<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CategoryRequest extends FormRequest
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
     * @return array
     */
    public function rules()
    {
        //parmetar from route
        $id = $this->route('id');
        return [
            'name' => [
                'required',
                'alpha',
                'max:255',
                'min:3',
                Rule::unique('Categories', 'name')->ignore($id),
            ],
            'description' => [
                'required',
                'min:5',
                'filter:laravel,php',

            ],
            'parent_id' => [
                'nullable',
                'exists:categories,id',
            ],
            'image' => [
                'image',
                'max:1048576',
                'dimensions:min_width=200,min_heigth=200'
            ],
            'sataus' => [
                'required',
                'in:active,inactive'
            ],

        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Required!',
        ];
    }
}
