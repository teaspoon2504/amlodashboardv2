<?php

namespace App\Services;

use App\Models\Task;
use App\Models\TaskCategory;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;

class DashboardService
{
    public function getOfficerStats(User $user): array
    {
        $officerId = $user->officer_id;

        $tasks = Task::with(['taskCategory', 'branchOffice'])
            ->where('officer_id', $officerId)
            ->get();

        $categories = TaskCategory::with(['tasks' => fn($q) => $q->where('officer_id', $officerId)])->get();

        return array_merge($this->buildStats($tasks), ['categories' => $categories, 'tasks' => $tasks]);
    }

    public function getLeadStats(User $user): array
    {
        $teamLeadId = $user->team_lead_id;

        $tasks = Task::with(['taskCategory', 'officer', 'branchOffice'])
            ->where('team_lead_id', $teamLeadId)
            ->get();

        $categories = TaskCategory::with(['tasks' => fn($q) => $q->where('team_lead_id', $teamLeadId)])->get();

        return array_merge($this->buildStats($tasks), ['categories' => $categories, 'tasks' => $tasks]);
    }

    public function getHOStats(): array
    {
        $tasks = Task::with(['taskCategory', 'teamLead', 'officer', 'branchOffice', 'regionalOffice'])->get();
        $categories = TaskCategory::with('tasks')->get();

        return array_merge($this->buildStats($tasks), ['categories' => $categories, 'tasks' => $tasks]);
    }

    /**
     * Shared stats builder — used by all role dashboards.
     */
    private function buildStats(Collection $tasks): array
    {
        return [
            'totalTarget' => $tasks->sum('target'),
            'totalDone' => $tasks->where('progress', Task::PROGRESS_DONE)->sum('amount_done'),
            'totalInProgress' => $tasks->where('progress', Task::PROGRESS_IN_PROGRESS)->sum('amount_done'),
            'totalNotStarted' => $tasks->where('progress', Task::PROGRESS_NOT_STARTED)->sum('target'),
            'doneTasks' => $tasks->where('progress', Task::PROGRESS_DONE),
            'inProgressTasks' => $tasks->where('progress', Task::PROGRESS_IN_PROGRESS),
            'notStartedTasks' => $tasks->where('progress', Task::PROGRESS_NOT_STARTED),
        ];
    }
}