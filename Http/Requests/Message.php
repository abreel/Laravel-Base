<?php

namespace App\Base\Http\Requests;


use Illuminate\Foundation\Http\FormRequest;

class Message extends FormRequest
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
            'email' => 'nullable|email|string',
            'mobile' => 'nullable|numeric|min:5',
            'subject' => 'required|string|min:2',
            'message' => 'required|string|min:2',
            'sender_id' => 'nullable|integer',
            'receiver_id' => 'nullable|integer',
        ];
    }
}
