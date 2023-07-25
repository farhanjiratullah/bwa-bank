<?php

namespace App\Http\Requests\API;

use Illuminate\Foundation\Http\FormRequest;

class UpdateUserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users,username,' . $this->user->id,
            'email' => 'required|string|max:255|unique:users,email,' . $this->user->id,
            'current_password' => 'nullable|string|max:255',
            'password' => 'nullable|string|max:255|confirmed',
            'ktp' => 'nullable|image',
            'profile_picture' => 'nullable|image'
        ];
    }
}
