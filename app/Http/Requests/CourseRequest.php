<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CourseRequest extends FormRequest
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
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'teacher' => 'required'
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Judul course wajib diisi',
            'name.min' => 'Judul course minimal 2 karakter',
            'start_date.required' => 'Tanggal dimulai course wajib diisi',
            'start_date.date' => 'Format tanggal dimulai salah',
            'end_date.required' => 'Tanggal berakhir course wajib diisi',
            'end_date.date' => 'Format tanggal berakhir salah',
            'end_date.after' => 'Tanggal berakhir harus lebih besar dari tanggal dimulai'
        ];
    }
}
