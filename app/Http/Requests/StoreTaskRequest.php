<?php

namespace App\Http\Requests;

use App\Models\Task;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreTaskRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->role === 'ho';
    }

    public function rules(): array
    {
        return [
            'regional_office_id' => ['required', 'exists:regional_offices,id'],
            'task_category_id'   => ['required', 'exists:task_categories,id'],
            'team_lead_id'       => ['nullable', 'exists:team_leads,id'],
            'officer_id'         => ['nullable', 'exists:officers,id'],
            'branch_office_id'   => ['nullable', 'exists:branch_offices,id'],
            'target'             => ['required', 'integer', 'min:0'],
            'amount_done'        => ['nullable', 'integer', 'min:0'],
            'due_date'           => ['nullable', 'date', 'after_or_equal:today'],
            'description'        => ['nullable', 'string', 'max:1000'],
            'progress'           => ['nullable', Rule::in(Task::PROGRESSES)],
        ];
    }

    public function messages(): array
    {
        return [
            'regional_office_id.required' => 'Regional Office is required.',
            'task_category_id.required'   => 'Task Category is required.',
            'target.required'             => 'Target is required.',
            'target.min'                   => 'Target must be 0 or greater.',
            'amount_done.min'              => 'Amount done must be 0 or greater.',
        ];
    }
}