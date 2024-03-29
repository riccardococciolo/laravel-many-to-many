<?php

namespace App\Http\Controllers\admin;

use App\Models\Project;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreProjectRequest;
use App\Http\Requests\UpdateProjectRequest;
use App\Models\Technology;
use App\Models\Type;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $perPage = 10;
        if($request->per_page) {
            $perPage = $request->per_page;
        }
        $projects = Project::paginate($perPage);

        return view('admin.projects.index', compact('projects'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $types = Type::all();
        $technologies = Technology::all();
        return view('admin.projects.create', compact('types', 'technologies'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreProjectRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreProjectRequest $request)
    {
        {
            $form_data = $request->all();
            $project = new project();
            $project->fill($form_data);
            $project->slug = Str::slug($project->title, '-');

            if($request->hasFile('cover_image')) {
                $path = Storage::put('project_images', $request->cover_image);
                $project->cover_image = $path;
            }

            $project->save();

            if ($request->has('technologies')) {
                $project->technologies()->attach($request->technologies);
            }
    
            return redirect()->route('admin.projects.show', ['project' => $project->slug])->with('message', 'il messaggio é stato creato con successo');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function show(Project $project)
    {
        return view('admin.projects.show', compact('project'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function edit(Project $project)
    {
        $types = Type::all();
        $technologies = Technology::all();
        return view('admin.projects.edit', compact('project', 'types', 'technologies'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateProjectRequest  $request
     * @param  \App\Models\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateProjectRequest $request, Project $project)
    {
        {
            $form_data = $request->all();

            if($request->hasFile('cover_image')) {
                if($project->cover_image) {
                    Storage::delete($project->cover_image);
                }
    
                $path = Storage::put('project_images', $request->cover_image);
                $form_data['cover_image'] = $path;
            }    

            $project->update($form_data);

            if ($request->has('technologies')) {
                $project->technologies()->sync($request->technologies);
            } else { 
                $project->technologies()->sync([]);
            }
    
            return redirect()->route('admin.projects.show', ['project' => $project->slug])->with('message', 'il messaggio é stato modificato con successo');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function destroy(Project $project)
    {
        $project->delete();

        return redirect()->route('admin.projects.index')->with('message', 'il messaggio é stato eliminato con successo');
    }
}
