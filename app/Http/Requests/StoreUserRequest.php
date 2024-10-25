<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreUserRequest extends FormRequest
{

    public function authorize(): bool
    {
        return true;
    }


    public function rules(): array
    {
        return [
            'role_id' => ['required', 'uuid', Rule::exists('roles', 'id')->whereNull('deleted_at')],
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', Rule::unique('users')->whereNull('deleted_at'), 'max:255'],
            'phone_number' => ['required', 'string', 'digits:10', 'regex:/^[6-9]{1}[0-9]{9}$/'],
            'description' => ['required', 'max:1000'],
            'profile_picture' => ['required', 'file', 'image', 'max:2048'],
        ];
    }
    public function messages()
    {
        return [
            'role_id.exists' => 'Role does not exist.',
            'phone_number.regex' => 'Please enter a valid indian phone number.'
        ];
    }
}
