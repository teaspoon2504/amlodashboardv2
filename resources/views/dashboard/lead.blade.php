@extends('layouts.app')
@section('title', 'Dashboard - Team Lead')
@section('breadcrumb', 'Team Lead')

@php
$stats = [
    ['label' => 'Total Target', 'value' => $totalTarget, 'icon' => 'M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z', 'color' => 'slate', 'sub' => "{$tasks->count()} tasks", 'progressWidth' => min(100, $totalTarget > 0 ? (int) round($totalDone / $totalTarget * 100) : 0)],
    ['label' => 'Done', 'value' => $totalDone, 'icon' => 'M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z', 'color' => 'emerald', 'sub' => "{$doneTasks->count()} tasks"],
    ['label' => 'In Progress', 'value' => $totalInProgress, 'icon' => 'M12 8v4l3 3m6-2a9 9 0 11-18 0 9 9 0 0118 0z', 'color' => 'amber', 'sub' => "{$inProgressTasks->count()} tasks"],
    ['label' => 'Not Started', 'value' => $totalNotStarted, 'icon' => 'M20 12H4M4 6h16M4 18h16', 'color' => 'stone', 'sub' => "{$notStartedTasks->count()} tasks"],
];
@endphp

@section('content')
<div class="p-4 sm:p-6 lg:p-8 space-y-6">

    <div class="flex items-center justify-between">
        <div>
            <h2 class="text-[15px] font-bold text-slate-800">Welcome back, {{ auth()->user()->name }}</h2>
            <p class="text-[12px] text-slate-400 mt-0.5">{{ now()->translatedFormat('l, d F Y') }}</p>
        </div>
    </div>

    <div class="grid grid-cols-2 lg:grid-cols-4 gap-3 lg:gap-4">
        @foreach($stats as $stat)
        <x-stat-card
                :label="$stat['label']"
                :value="$stat['value']"
                :icon="$stat['icon']"
                :color="$stat['color']"
                :sub="$stat['sub']"
                :progress-width="!empty($stat['progressWidth']) ? $stat['progressWidth'] : null"
            />
        @endforeach
    </div>

    @if($doneTasks->count())
    <div>
        <div class="flex items-center gap-2 mb-4">
            <div class="w-2 h-2 rounded-full bg-emerald-400"></div>
            <h3 class="text-sm font-bold text-slate-700">Completed Tasks</h3>
            <span class="ml-auto text-[11px] font-semibold px-2.5 py-0.5 rounded-full bg-emerald-50 text-emerald-600 border border-emerald-100">{{ $doneTasks->count() }}</span>
        </div>
        <div class="bg-white rounded-2xl border border-slate-200/80 shadow-sm overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead>
                        <tr class="border-b border-slate-100 bg-slate-50/60">
                            <th class="px-5 py-3 text-left text-[11px] font-bold text-slate-500 uppercase tracking-wider">Task</th>
                            <th class="px-4 py-3 text-left text-[11px] font-bold text-slate-500 uppercase tracking-wider hidden md:table-cell">PIC Officer</th>
                            <th class="px-4 py-3 text-center text-[11px] font-bold text-slate-500 uppercase tracking-wider">Target</th>
                            <th class="px-4 py-3 text-center text-[11px] font-bold text-slate-500 uppercase tracking-wider">Done</th>
                            <th class="px-4 py-3 text-left text-[11px] font-bold text-slate-500 uppercase tracking-wider hidden sm:table-cell">Due Date</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-50">
                        @foreach($doneTasks->take(8) as $task)
                        <tr class="hover:bg-slate-50/70 transition-colors">
                            <td class="px-5 py-3.5">
                                <div class="flex items-center gap-2.5">
                                    <div class="w-1.5 h-1.5 rounded-full bg-emerald-400 flex-shrink-0 mt-0.5"></div>
                                    <div>
                                        <p class="font-semibold text-slate-800 text-[13px]">{{ $task->taskCategory->name }}</p>
                                        <p class="text-[11px] text-slate-400">{{ $task->branchOffice->name ?? '-' }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-4 py-3.5 text-slate-600 text-[13px] hidden md:table-cell">{{ $task->officer->name ?? '-' }}</td>
                            <td class="px-4 py-3.5 text-center text-slate-500 text-[13px]">{{ $task->target }}</td>
                            <td class="px-4 py-3.5 text-center"><span class="inline-flex items-center justify-center w-7 h-7 rounded-lg bg-emerald-50 text-emerald-600 text-xs font-bold">{{ $task->amount_done }}</span></td>
                            <td class="px-4 py-3.5 text-slate-400 text-[12px] hidden sm:table-cell">{{ $task->due_date?->format('d M') ?? '-' }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    @endif

    @if($inProgressTasks->count())
    <div>
        <div class="flex items-center gap-2 mb-4">
            <div class="w-2 h-2 rounded-full bg-amber-400"></div>
            <h3 class="text-sm font-bold text-slate-700">In Progress</h3>
            <span class="ml-auto text-[11px] font-semibold px-2.5 py-0.5 rounded-full bg-amber-50 text-amber-600 border border-amber-100">{{ $inProgressTasks->count() }}</span>
        </div>
        <div class="bg-white rounded-2xl border border-slate-200/80 shadow-sm overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead>
                        <tr class="border-b border-slate-100 bg-slate-50/60">
                            <th class="px-5 py-3 text-left text-[11px] font-bold text-slate-500 uppercase tracking-wider">Task</th>
                            <th class="px-4 py-3 text-left text-[11px] font-bold text-slate-500 uppercase tracking-wider hidden md:table-cell">PIC Officer</th>
                            <th class="px-4 py-3 text-center text-[11px] font-bold text-slate-500 uppercase tracking-wider">Target</th>
                            <th class="px-4 py-3 text-center text-[11px] font-bold text-slate-500 uppercase tracking-wider">Done</th>
                            <th class="px-4 py-3 text-left text-[11px] font-bold text-slate-500 uppercase tracking-wider hidden sm:table-cell">Due Date</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-50">
                        @foreach($inProgressTasks->take(8) as $task)
                        <tr class="hover:bg-slate-50/70 transition-colors">
                            <td class="px-5 py-3.5">
                                <div class="flex items-center gap-2.5">
                                    <div class="w-1.5 h-1.5 rounded-full bg-amber-400 flex-shrink-0 mt-0.5"></div>
                                    <div>
                                        <p class="font-semibold text-slate-800 text-[13px]">{{ $task->taskCategory->name }}</p>
                                        <p class="text-[11px] text-slate-400">{{ $task->branchOffice->name ?? '-' }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-4 py-3.5 text-slate-600 text-[13px] hidden md:table-cell">{{ $task->officer->name ?? '-' }}</td>
                            <td class="px-4 py-3.5 text-center text-slate-500 text-[13px]">{{ $task->target }}</td>
                            <td class="px-4 py-3.5 text-center"><span class="inline-flex items-center justify-center w-7 h-7 rounded-lg bg-amber-50 text-amber-600 text-xs font-bold">{{ $task->amount_done }}</span></td>
                            <td class="px-4 py-3.5 text-slate-400 text-[12px] hidden sm:table-cell">{{ $task->due_date?->format('d M') ?? '-' }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    @endif

    <div>
        <h3 class="text-sm font-bold text-slate-700 mb-4">Task Categories Overview</h3>
        <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-4">
            @foreach($categories as $category)
            @php
                $catTasks = $tasks->where('task_category_id', $category->id);
                $done = $catTasks->where('progress', 'done')->count();
                $inProgress = $catTasks->where('progress', 'in_progress')->count();
                $notStarted = $catTasks->where('progress', 'not_started')->count();
                $total = $catTasks->count();
                $percent = $total > 0 ? min(100, (int) round(($done / $total) * 100)) : 0;
            @endphp
            <x-category-card
                :name="$category->name"
                :percent="$percent"
                :done="$done"
                :in-progress="$inProgress"
                :not-started="$notStarted"
                progress-label="Completion"
            />
            @endforeach
        </div>
    </div>
</div>
@endsection