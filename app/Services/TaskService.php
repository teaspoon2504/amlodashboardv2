<?php

namespace App\Services;

use App\Models\BranchOffice;
use App\Models\Officer;
use App\Models\RegionalOffice;
use App\Models\Task;
use App\Models\TaskCategory;
use App\Models\TeamLead;
use App\Models\User;
use Illuminate\Http\Request;

class TaskService
{
    /**
     * Shared dropdown data for create / edit forms.
     */
    public function getFormData(): array
    {
        return [
            'regionalOffices' => RegionalOffice::all(),
            'taskCategories' => TaskCategory::all(),
            'teamLeads' => TeamLead::with('regionalOffice')->get(),
            'officers' => Officer::with(['branchOffice.regionalOffice'])->get(),
            'branchOffices' => BranchOffice::with('regionalOffice')->get(),
        ];
    }

    /**
     * Paginated + filtered task list for HO.
     */
    public function getFilteredTasks(Request $request)
    {
        $query = Task::with([
            'taskCategory',
            'regionalOffice',
            'teamLead',
            'officer',
            'branchOffice',
        ])->when($request->filled('regional_office_id'), fn($q) =>
            $q->where('regional_office_id', $request->regional_office_id)
        )->when($request->filled('task_category_id'), fn($q) =>
            $q->where('task_category_id', $request->task_category_id)
        )->when($request->filled('progress'), fn($q) =>
            $q->where('progress', $request->progress)
        );

        return $query->orderByDesc('id')->paginate(20)->withQueryString();
    }

    // ---- Role-specific updates ----

    public function officerUpdate(Task $task, array $data): void
    {
        abort_unless(
            auth()->user()->officer_id === $task->officer_id,
            403,
            'You are not authorized to update this task.'
        );

        $task->fill([
            'amount_done' => $data['amount_done'],
            'description' => $data['description'] ?? null,
        ]);

        // Manual status override takes priority; otherwise sync from amount
        if (!empty($data['progress_override'])) {
            $task->progress = $data['progress_override'];
        } else {
            $task->syncProgressFromAmount();
        }

        $task->save();
    }

    public function leadFeedback(Task $task, array $data): void
    {
        abort_unless(
            auth()->user()->team_lead_id === $task->team_lead_id,
            403,
            'You are not authorized to give feedback on this task.'
        );

        $task->feedback = $data['feedback'] ?? null;
        $task->save();
    }

    public function leadSetTarget(Task $task, array $data): void
    {
        $user = auth()->user();

        abort_unless($user->role === 'lead', 403);

        $officer = Officer::findOrFail($data['officer_id']);

        $task->fill([
            'target' => $data['target'],
            'officer_id' => $officer->id,
            'team_lead_id' => $user->team_lead_id,
            'regional_office_id' => $user->regional_office_id,
        ]);
        $task->save();
    }
}