<?php

namespace App\Http\Requests\API;

use Illuminate\Foundation\Http\FormRequest;

class StoreRegisterRequest extends FormRequest
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
            'name' => 'required|string',
            'username' => 'required|string|unique:users,username',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6|confirmed',
            'pin' => 'required|digits:6',
            'profile_picture' => 'nullable|image|mimes:png,jpg,jpeg',
            'ktp' => 'nullable|image|mimes:png,jpg,jpeg',
            'card_number' => 'required|integer|digits:16'
        ];
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'username' => $this->email,
            'card_number' => str()->password(16, false, true, false)
        ]);
    }
}
