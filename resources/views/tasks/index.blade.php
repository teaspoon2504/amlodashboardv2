@extends('layouts.app')
@section('title', 'Task & Category')
@section('breadcrumb', 'Tasks')

@php
$progressColors = [
    'done' => ['dot' => 'bg-emerald-400', 'badge' => 'bg-emerald-50 text-emerald-600 border-emerald-100'],
    'in_progress' => ['dot' => 'bg-amber-400', 'badge' => 'bg-amber-50 text-amber-600 border-amber-100'],
    'not_started' => ['dot' => 'bg-slate-300', 'badge' => 'bg-slate-50 text-slate-400 border-slate-200'],
];
@endphp

@section('content')
<div class="p-4 sm:p-6 lg:p-8 space-y-5">

    {{-- Header --}}
    <div class="flex items-center justify-between">
        <div>
            <h2 class="text-[15px] font-bold text-slate-800">Task & Category</h2>
            <p class="text-[12px] text-slate-400 mt-0.5">{{ $tasks->total() }} task{{ $tasks->total() !== 1 ? 's' : '' }} total</p>
        </div>
        <a href="{{ route('tasks.create') }}" class="group inline-flex items-center gap-2 px-5 py-2.5 bg-[#0857C3] hover:bg-[#0647a0] text-white text-sm font-semibold rounded-xl transition-all shadow-sm hover:shadow-md hover:-translate-y-0.5">
            <svg class="w-4 h-4 group-hover:rotate-90 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
            Create Task
        </a>
    </div>

    {{-- Filters --}}
    <div class="bg-white rounded-2xl border border-slate-200/80 p-4 shadow-sm">
        <form method="GET" class="flex flex-wrap items-end gap-3">
            <div class="flex-1 min-w-[140px]">
                <label class="block text-[11px] font-semibold text-slate-500 mb-1.5 uppercase tracking-wider">Regional Office</label>
                <select name="regional_office_id" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3 py-2.5 text-sm text-slate-700 focus:outline-none focus:ring-2 focus:ring-[#0857C3]/20 focus:border-[#0857C3] transition-all">
                    <option value="">All Regional Office</option>
                    @foreach($regionalOffices as $ro)
                    <option value="{{ $ro->id }}" {{ request('regional_office_id') == $ro->id ? 'selected' : '' }}>{{ $ro->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="flex-1 min-w-[140px]">
                <label class="block text-[11px] font-semibold text-slate-500 mb-1.5 uppercase tracking-wider">Category</label>
                <select name="task_category_id" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3 py-2.5 text-sm text-slate-700 focus:outline-none focus:ring-2 focus:ring-[#0857C3]/20 focus:border-[#0857C3] transition-all">
                    <option value="">All Categories</option>
                    @foreach($taskCategories as $cat)
                    <option value="{{ $cat->id }}" {{ request('task_category_id') == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="flex-1 min-w-[140px]">
                <label class="block text-[11px] font-semibold text-slate-500 mb-1.5 uppercase tracking-wider">Status</label>
                <select name="progress" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3 py-2.5 text-sm text-slate-700 focus:outline-none focus:ring-2 focus:ring-[#0857C3]/20 focus:border-[#0857C3] transition-all">
                    <option value="">All Status</option>
                    <option value="done" {{ request('progress') === 'done' ? 'selected' : '' }}>Done</option>
                    <option value="in_progress" {{ request('progress') === 'in_progress' ? 'selected' : '' }}>In Progress</option>
                    <option value="not_started" {{ request('progress') === 'not_started' ? 'selected' : '' }}>Not Started</option>
                </select>
            </div>
            @if(request()->anyFilled(['regional_office_id', 'task_category_id', 'progress']))
            <a href="{{ route('tasks.index') }}" class="px-4 py-2.5 text-slate-500 hover:text-slate-700 hover:bg-slate-100 text-sm font-medium rounded-xl transition-all flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                Clear
            </a>
            @endif
            <button type="submit" class="px-5 py-2.5 bg-[#0857C3] hover:bg-[#0647a0] text-white text-sm font-semibold rounded-xl transition-all shadow-sm hover:shadow-md hover:-translate-y-0.5 flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"/></svg>
                Filter
            </button>
        </form>
    </div>

    {{-- Table --}}
    <div class="bg-white rounded-2xl border border-slate-200/80 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="border-b border-slate-100 bg-slate-50/80">
                        <th class="px-5 py-3.5 text-left text-[11px] font-bold text-slate-500 uppercase tracking-wider">Task Category</th>
                        <th class="px-4 py-3.5 text-left text-[11px] font-bold text-slate-500 uppercase tracking-wider hidden lg:table-cell">RO</th>
                        <th class="px-4 py-3.5 text-left text-[11px] font-bold text-slate-500 uppercase tracking-wider hidden md:table-cell">Team Lead</th>
                        <th class="px-4 py-3.5 text-left text-[11px] font-bold text-slate-500 uppercase tracking-wider hidden md:table-cell">Officer</th>
                        <th class="px-3 py-3.5 text-center text-[11px] font-bold text-slate-500 uppercase tracking-wider">Target</th>
                        <th class="px-3 py-3.5 text-center text-[11px] font-bold text-slate-500 uppercase tracking-wider">Done</th>
                        <th class="px-3 py-3.5 text-center text-[11px] font-bold text-slate-500 uppercase tracking-wider">%</th>
                        <th class="px-4 py-3.5 text-left text-[11px] font-bold text-slate-500 uppercase tracking-wider hidden sm:table-cell">Due</th>
                        <th class="px-4 py-3.5 text-left text-[11px] font-bold text-slate-500 uppercase tracking-wider">Status</th>
                        <th class="px-4 py-3.5 text-center text-[11px] font-bold text-slate-500 uppercase tracking-wider">Action</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    @forelse($tasks as $task)
                    @php
                        $pct = $task->target > 0 ? min(100, (int)round(($task->amount_done/$task->target)*100)) : 0;
                        $c = $progressColors[$task->progress] ?? $progressColors['not_started'];
                    @endphp
                    <tr class="hover:bg-slate-50/60 transition-colors group">
                        <td class="px-5 py-3.5">
                            <div class="flex items-center gap-2.5">
                                <div class="w-1.5 h-8 rounded-full {{ $c['dot'] }} flex-shrink-0 opacity-60 group-hover:opacity-100 transition-opacity"></div>
                                <div>
                                    <p class="font-semibold text-slate-800 text-[13px]">{{ $task->taskCategory->name }}</p>
                                    @if($task->branchOffice)
                                    <p class="text-[11px] text-slate-400">{{ $task->branchOffice->name }}</p>
                                    @endif
                                </div>
                            </div>
                        </td>
                        <td class="px-4 py-3.5 text-slate-600 text-[12px] hidden lg:table-cell">{{ $task->regionalOffice->name ?? '-' }}</td>
                        <td class="px-4 py-3.5 text-slate-600 text-[12px] hidden md:table-cell">{{ $task->teamLead->name ?? '-' }}</td>
                        <td class="px-4 py-3.5 text-slate-600 text-[12px] hidden md:table-cell">{{ $task->officer->name ?? '-' }}</td>
                        <td class="px-3 py-3.5 text-center text-slate-500 text-[13px] font-medium">{{ $task->target }}</td>
                        <td class="px-3 py-3.5 text-center"><span class="inline-flex items-center justify-center w-7 h-7 rounded-lg bg-slate-100 text-slate-600 text-xs font-bold">{{ $task->amount_done }}</span></td>
                        <td class="px-3 py-3.5 text-center">
                            <span class="text-[12px] font-bold {{ $pct >= 100 ? 'text-emerald-600' : ($pct > 0 ? 'text-amber-600' : 'text-slate-400') }}">{{ $pct }}%</span>
                        </td>
                        <td class="px-4 py-3.5 text-slate-400 text-[12px] hidden sm:table-cell">{{ $task->due_date?->format('d M Y') ?: '-' }}</td>
                        <td class="px-4 py-3.5">
                            <span class="inline-flex text-[11px] font-semibold px-2.5 py-1 rounded-full border {{ $c['badge'] }}">
                                @if($task->progress === 'done') Done
                                @elseif($task->progress === 'in_progress') In Progress
                                @else Not Started @endif
                            </span>
                        </td>
                        <td class="px-4 py-3.5 text-center">
                            <a href="{{ route('tasks.edit', $task) }}" class="inline-flex items-center gap-1 text-[12px] font-semibold text-[#0857C3] hover:text-[#0647a0] transition-colors">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                Edit
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="10" class="px-5 py-16 text-center">
                            <div class="flex flex-col items-center gap-2">
                                <div class="w-12 h-12 rounded-2xl bg-slate-100 flex items-center justify-center mb-2">
                                    <svg class="w-6 h-6 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                                </div>
                                <p class="text-slate-500 font-medium text-sm">No tasks found</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($tasks->hasPages())
        <div class="px-5 py-4 border-t border-slate-100 bg-slate-50/40">
            {{ $tasks->withQueryString()->links() }}
        </div>
        @endif
    </div>
</div>
@endsection