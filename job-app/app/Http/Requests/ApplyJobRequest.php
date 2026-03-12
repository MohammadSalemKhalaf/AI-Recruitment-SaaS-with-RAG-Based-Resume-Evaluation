<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ApplyJobRequest extends FormRequest
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
            'resume_id'    => 'nullable|exists:resumes,id',
            'resume_file'  => 'required_without:resume_id|file|mimes:pdf,doc,docx|max:5120',
            'cover_letter' => 'nullable|string|max:2000',
        ];
    }


    public function messages()
    {
        return [
            'resume_id.exists' => 'The selected resume does not exist.',
            'resume_file.required_without' => 'Please select an existing resume or upload a new one.',
            'resume_file.mimes' => 'The resume must be a file of type: pdf, doc, docx.',
            'resume_file.max' => 'The resume may not be greater than 5MB.',
            'cover_letter.max' => 'The cover letter may not be greater than 2000 characters.',
        ];
    }
}