@extends('layouts.app')
@section('title', 'Dashboard - AMLO Officer')
@section('breadcrumb', 'My Tasks')

@php
$stats = [
    ['label' => 'Total Target', 'value' => $totalTarget, 'icon' => 'M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z', 'color' => 'slate', 'sub' => "{$tasks->count()} tasks", 'progressWidth' => min(100, $totalTarget > 0 ? (int) round($totalDone / $totalTarget * 100) : 0)],
    ['label' => 'Done', 'value' => $totalDone, 'icon' => 'M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z', 'color' => 'emerald', 'sub' => "{$doneTasks->count()} tasks"],
    ['label' => 'In Progress', 'value' => $totalInProgress, 'icon' => 'M12 8v4l3 3m6-2a9 9 0 11-18 0 9 9 0 0118 0z', 'color' => 'amber', 'sub' => "{$inProgressTasks->count()} tasks"],
    ['label' => 'Remaining', 'value' => $totalNotStarted, 'icon' => 'M20 12H4M4 6h16M4 18h16', 'color' => 'stone', 'sub' => "{$notStartedTasks->count()} tasks"],
];
@endphp

@section('content')
<div class="p-4 sm:p-6 lg:p-8 space-y-6">

    <div class="flex items-center justify-between">
        <div>
            <h2 class="text-[15px] font-bold text-slate-800">Good {{ now()->hour < 12 ? 'morning' : (now()->hour < 18 ? 'afternoon' : 'evening') }}, {{ auth()->user()->name }}</h2>
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

    <div>
        <h3 class="text-sm font-bold text-slate-700 mb-4">My Task Categories</h3>
        <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-4">
            @foreach($categories as $category)
            @php
                $catTasks = $tasks->where('task_category_id', $category->id);
                $done = $catTasks->where('progress', 'done')->count();
                $inProgress = $catTasks->where('progress', 'in_progress')->count();
                $notStarted = $catTasks->where('progress', 'not_started')->count();
                $total = $catTasks->count();
                $percent = $total > 0 ? min(100, (int) round(($done / $total) * 100)) : 0;
                $catTask = $catTasks->first();
            @endphp
            <x-category-card
                :name="$category->name"
                :percent="$percent"
                :done="$done"
                :in-progress="$inProgress"
                :not-started="$notStarted"
                :target="$catTask?->target"
                :amount-done="$catTask?->amount_done"
                :due-date="$catTask?->due_date?->format('d M Y')"
                :has-target="true"
            />
            @endforeach
        </div>
    </div>
</div>
@endsection