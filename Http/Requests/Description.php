<?php

namespace App\Base\Http\Requests;


use Illuminate\Foundation\Http\FormRequest;

class Description extends FormRequest
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
        return [
            'name' => 'required|string|max:255',
            'image' => 'nullable|image',
            'default' => 'nullable|boolean',
            'category_id' => 'sometimes|string|not_in:Select an option',
            'short_description' => 'required|string|max:100',
            'full_description' => 'nullable|string',

            // permissions verification
            // Must be in title case - first letters capitalized
            'Create' => 'nullable|boolean',
            'permission' => 'sometimes|boolean',
        ];
    }
}
