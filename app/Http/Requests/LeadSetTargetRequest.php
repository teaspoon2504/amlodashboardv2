<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LeadSetTargetRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->role === 'lead';
    }

    public function rules(): array
    {
        return [
            'target'     => ['required', 'integer', 'min:0'],
            'officer_id' => ['required', 'exists:officers,id'],
        ];
    }

    public function messages(): array
    {
        return [
            'target.required'     => 'Target is required.',
            'target.min'          => 'Target must be 0 or greater.',
            'officer_id.required' => 'Please select an officer.',
            'officer_id.exists'   => 'Selected officer does not exist.',
        ];
    }
}