<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateProjectRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
            return [
                'title' => ['required', 'max:200', 'min:5', Rule::unique('projects')->ignore($this->project)],
                'content' => ['nullable']
            ];
    }

    public function messages()
    {
        return [
            'title.required' => 'Il titolo è obbligatorio.',
            'title.min' => 'Il titolo deve avere una lunghezza minima di :min caratteri.',
            'title.max' => 'Il titolo deve avere una lunghezza massima di :max caratteri.',
            'title.unique' => 'Non ci devono essere titoli con lo stesso nome.',
        ];
    }
}
