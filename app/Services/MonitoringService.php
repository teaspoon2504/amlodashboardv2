<?php

namespace App\Services;

use App\Models\Task;
use App\Models\TaskCategory;
use App\Models\TeamLead;
use App\Models\RegionalOffice;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Collection;

class MonitoringService
{
    public function buildRegionalOfficeScorecard(User $user): Collection
    {
        $categories = TaskCategory::all();

        $query = RegionalOffice::with(['teamLead', 'branchOffices.officers'])
            ->withSum(['tasks as total_target' => fn() => null], 'target')
            ->withSum(['tasks as total_done' => fn($q) => $q->where('progress', Task::PROGRESS_DONE)], 'amount_done');

        if ($user->role !== 'ho') {
            $query->where('id', $user->regional_office_id);
        }

        return $query->get()->map(function (RegionalOffice $ro) use ($categories) {
            $roTasks = $ro->tasks;
            $totalTarget = $roTasks->sum('target');
            $totalDone = $roTasks->where('progress', Task::PROGRESS_DONE)->sum('amount_done');

            $catBreakdown = $this->buildCategoryBreakdown($roTasks, $categories);

            $branchOffices = $ro->branchOffices->map(function ($bo) use ($categories) {
                $boTasks = $bo->tasks;
                $boTarget = $boTasks->sum('target');
                $boDone = $boTasks->where('progress', Task::PROGRESS_DONE)->sum('amount_done');

                $catBreakdown = $this->buildCategoryBreakdown($boTasks, $categories, summary: true);

                return [
                    'branch_office' => $bo,
                    'total_target' => $boTarget,
                    'total_done' => $boDone,
                    'categories' => $catBreakdown,
                    'overall_percent' => $this->calcPercent($boDone, $boTarget),
                ];
            });

            return [
                'regional_office' => $ro,
                'team_lead' => $ro->teamLead,
                'total_target' => $totalTarget,
                'total_done' => $totalDone,
                'categories' => $catBreakdown,
                'branch_offices' => $branchOffices,
                'overall_percent' => $this->calcPercent($totalDone, $totalTarget),
            ];
        });
    }

    public function buildOfficerScorecard(User $user): Collection
    {
        $categories = TaskCategory::all();

        $query = TeamLead::with(['regionalOffice', 'officers.branchOffice'])
            ->withSum(['tasks as total_target' => fn() => null], 'target')
            ->withSum(['tasks as total_done' => fn($q) => $q->where('progress', Task::PROGRESS_DONE)], 'amount_done');

        if ($user->role !== 'ho') {
            $query->where('id', $user->team_lead_id);
        }

        return $query->get()->map(function (TeamLead $tl) use ($categories) {
            $tlTasks = $tl->tasks;
            $totalTarget = $tlTasks->sum('target');
            $totalDone = $tlTasks->where('progress', Task::PROGRESS_DONE)->sum('amount_done');

            $catBreakdown = $this->buildCategoryBreakdown($tlTasks, $categories);

            $officers = $tl->officers->map(function ($officer) use ($categories) {
                $oTasks = $officer->tasks;
                $oTarget = $oTasks->sum('target');
                $oDone = $oTasks->where('progress', Task::PROGRESS_DONE)->sum('amount_done');

                $catBreakdown = $this->buildCategoryBreakdown($oTasks, $categories);

                return [
                    'officer' => $officer,
                    'branch_office' => $officer->branchOffice,
                    'total_target' => $oTarget,
                    'total_done' => $oDone,
                    'categories' => $catBreakdown,
                    'overall_percent' => $this->calcPercent($oDone, $oTarget),
                ];
            });

            return [
                'team_lead' => $tl,
                'regional_office' => $tl->regionalOffice,
                'total_target' => $totalTarget,
                'total_done' => $totalDone,
                'categories' => $catBreakdown,
                'officers' => $officers,
                'overall_percent' => $this->calcPercent($totalDone, $totalTarget),
            ];
        });
    }

    private function buildCategoryBreakdown($tasks, $categories, bool $summary = false): array
    {
        $breakdown = [];
        foreach ($categories as $cat) {
            $catTasks = $tasks->where('task_category_id', $cat->id);
            $target = $catTasks->sum('target');
            $done = $catTasks->where('progress', Task::PROGRESS_DONE)->sum('amount_done');

            $data = [
                'target' => $target,
                'done' => $done,
                'percent' => $this->calcPercent($done, $target),
            ];

            if (!$summary) {
                $data['in_progress'] = $catTasks->where('progress', Task::PROGRESS_IN_PROGRESS)->count();
                $data['not_started'] = $catTasks->where('progress', Task::PROGRESS_NOT_STARTED)->count();
            }

            $breakdown[$cat->id] = $data;
        }
        return $breakdown;
    }

    private function calcPercent(int $done, int $target): int
    {
        return $target > 0 ? (int) min(100, round(($done / $target) * 100)) : 0;
    }
}