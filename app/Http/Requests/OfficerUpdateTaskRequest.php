<?php

namespace App\Http\Requests;

use App\Models\Task;
use Illuminate\Foundation\Http\FormRequest;

class OfficerUpdateTaskRequest extends FormRequest
{
    public function authorize(): bool
    {
        $task = $this->route('task');
        return $this->user()?->role === 'officer'
            && $task->officer_id === $this->user()->officer_id;
    }

    public function rules(): array
    {
        return [
            'amount_done' => ['required', 'integer', 'min:0'],
            'description' => ['nullable', 'string', 'max:1000'],
        ];
    }

    public function messages(): array
    {
        return [
            'amount_done.required' => 'Amount done is required.',
            'amount_done.min'      => 'Amount done must be 0 or greater.',
        ];
    }
}