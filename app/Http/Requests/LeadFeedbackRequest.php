<?php

namespace App\Http\Requests;

use App\Models\Task;
use Illuminate\Foundation\Http\FormRequest;

class LeadFeedbackRequest extends FormRequest
{
    public function authorize(): bool
    {
        $task = $this->route('task');
        return $this->user()?->role === 'lead'
            && $task->team_lead_id === $this->user()->team_lead_id;
    }

    public function rules(): array
    {
        return [
            'feedback' => ['nullable', 'string', 'max:1000'],
        ];
    }
}