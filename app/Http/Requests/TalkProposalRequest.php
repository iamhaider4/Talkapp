<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TalkProposalRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true; // We'll handle authorization in the controller
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'presentation_file' => 'nullable|file|mimes:pdf|max:10240', // Max 10MB PDF
            'tags' => 'array',
            'tags.*' => 'exists:tags,id'
        ];
    }
}
