<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreUserRequest extends FormRequest
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
            'first_name' => 'required',
            'last_name' => 'nullable',
            'email' => 'required|unique:users,email,NULL,id,deleted_at,NULL',
            'mobile' => 'required|unique:users,mobile,NULL,id,deleted_at,NULL|digits:10',
            'business_name' => 'nullable',
            'city' => 'nullable',
            'address' => 'nullable',
            'image' => 'mimes:png,jpg',
            'password' => 'required|min:8',
            'confirm_password' => 'required|same:password',
        ];
    }
}
