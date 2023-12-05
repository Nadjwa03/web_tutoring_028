<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|min:2',
            'email' => 'required|email|unique:users,email,' . $this->id,
            'username' => 'required|min:6|unique:users,username,' . $this->id,
            'role' => 'required',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Nama tidak boleh kosong',
            'name.min' => 'Nama minimal 2 huruf',
            'email.required' => 'Email tidak boleh kosong',
            'email.email' => 'Penulisan email tidak sesuai',
            'email.unique' => 'Email sudah terdaftar',
            'username.required' => 'Username tidak boleh kosong',
            'username.min' => 'Username minimal 6 huruf',
            'username.unique' => 'Username sudah terdaftar',
            'role.required' => 'Role tidak boleh kosong'
        ];
    }
}
