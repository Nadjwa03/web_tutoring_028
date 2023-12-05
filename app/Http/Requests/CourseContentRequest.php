<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CourseContentRequest extends FormRequest
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
            'course_id' => 'required',
            'name' => 'required|min:2',
            'file' => 'nullable|mimes:pdf|max:4096',
        ];
    }

    public function messages(): array
    {
        return [
            'course_id' => 'required',
            'name.required' => 'Judul konten wajib diisi',
            'name.min' => 'Judul konten minimal 2 karakter',
            'file.mimes' => 'Format file wajib pdf',
            'file.max' => 'File yang diupload tidak boleh lebih dari 4MB'
        ];
    }
}
