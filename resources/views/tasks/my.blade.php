@extends('layouts.app')
@section('title', 'My Tasks')
@section('breadcrumb', 'My Tasks')

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
            <h2 class="text-[15px] font-bold text-slate-800">My Tasks</h2>
            <p class="text-[12px] text-slate-400 mt-0.5">{{ $tasks->count() }} task{{ $tasks->count() !== 1 ? 's' : '' }} assigned</p>
        </div>
        <div class="flex items-center gap-2 text-[11px] text-slate-400">
            <span class="w-2 h-2 rounded-full bg-emerald-400 animate-pulse"></span>
            Updating task progress
        </div>
    </div>

    @if($tasks->isEmpty())
    <div class="bg-white rounded-2xl border border-slate-200/80 p-16 text-center shadow-sm">
        <div class="w-12 h-12 rounded-2xl bg-slate-100 flex items-center justify-center mx-auto mb-3">
            <svg class="w-6 h-6 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
        </div>
        <p class="text-slate-500 font-medium text-sm">No tasks assigned to you yet</p>
    </div>
    @else
    <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-3 gap-4">
        @foreach($tasks as $task)
        @php
            $pct = $task->target > 0 ? min(100, (int)round(($task->amount_done / $task->target) * 100)) : 0;
            $c = $progressColors[$task->progress] ?? $progressColors['not_started'];
        @endphp

        <div class="bg-white rounded-2xl border border-slate-200/80 shadow-sm overflow-hidden hover:shadow-md transition-shadow">

            {{-- Card header --}}
            <div class="px-4 py-3 border-b border-slate-100 bg-gradient-to-r from-[#0857C3]/5 to-transparent">
                <div class="flex items-start justify-between gap-2">
                    <div class="flex items-center gap-2 min-w-0">
                        <div class="w-1.5 h-1.5 rounded-full {{ $c['dot'] }} flex-shrink-0 mt-1.5"></div>
                        <h3 class="text-[13px] font-bold text-slate-800 leading-snug line-clamp-2">{{ $task->taskCategory->name }}</h3>
                    </div>
                    <span class="flex-shrink-0 text-[10px] font-semibold px-2 py-0.5 rounded-full border {{ $c['badge'] }}">
                        @if($task->progress === 'done') Done
                        @elseif($task->progress === 'in_progress') In Progress
                        @else Not Started @endif
                    </span>
                </div>
                @if($task->branchOffice)
                <p class="text-[11px] text-slate-400 mt-1 ml-3.5">{{ $task->branchOffice->name }}</p>
                @endif
            </div>

            {{-- Card body --}}
            <div class="p-4 space-y-4">

                {{-- Progress bar --}}
                <div>
                    <div class="flex items-center justify-between mb-1.5">
                        <span class="text-[11px] text-slate-500 font-medium">Progress</span>
                        <span class="text-[13px] font-extrabold {{ $pct >= 100 ? 'text-emerald-600' : ($pct > 0 ? 'text-amber-600' : 'text-slate-400') }}">{{ $pct }}%</span>
                    </div>
                    <div class="w-full bg-slate-100 rounded-full h-1.5 overflow-hidden">
                        <div class="h-1.5 rounded-full bg-gradient-to-r from-[#0857C3] to-[#71C5E8] transition-all duration-700 ease-out @if($pct >= 100) bg-emerald-500 @endif"
                            style="width: {{ $pct }}%"></div>
                    </div>
                </div>

                {{-- Stats --}}
                <div class="grid grid-cols-3 gap-2">
                    <div class="text-center p-2 rounded-xl bg-slate-50 border border-slate-100/50">
                        <p class="text-[14px] font-extrabold text-slate-700">{{ $task->target }}</p>
                        <p class="text-[9px] text-slate-400 font-semibold uppercase tracking-wide">Target</p>
                    </div>
                    <div class="text-center p-2 rounded-xl bg-emerald-50 border border-emerald-100/50">
                        <p class="text-[14px] font-extrabold text-emerald-600">{{ $task->amount_done }}</p>
                        <p class="text-[9px] text-emerald-500 font-semibold uppercase tracking-wide">Done</p>
                    </div>
                    <div class="text-center p-2 rounded-xl bg-slate-50 border border-slate-100/50">
                        <p class="text-[14px] font-extrabold text-slate-500">{{ max(0, $task->target - $task->amount_done) }}</p>
                        <p class="text-[9px] text-slate-400 font-semibold uppercase tracking-wide">Remaining</p>
                    </div>
                </div>

                {{-- Due date --}}
                @if($task->due_date)
                <div class="flex items-center justify-between text-[11px]">
                    <span class="text-slate-400 font-medium">Due Date</span>
                    <span class="font-bold text-slate-600">{{ $task->due_date->format('d M Y') }}</span>
                </div>
                @endif

                {{-- Description --}}
                @if($task->description)
                <div class="text-[11px] text-slate-500 bg-slate-50 rounded-xl p-3 leading-relaxed">
                    <span class="font-semibold text-slate-600">Notes:</span> {{ $task->description }}
                </div>
                @endif

                {{-- Update form --}}
                <form method="POST" action="{{ route('tasks.officer-update', $task) }}" class="space-y-2.5 pt-1 border-t border-slate-100">
                    @csrf
                    @method('PATCH')

                    <div class="grid grid-cols-2 gap-2">
                        <div>
                            <label class="text-[10px] font-bold text-slate-500 uppercase tracking-wider mb-1 block">Done</label>
                            <input
                                type="number"
                                name="amount_done"
                                value="{{ $task->amount_done }}"
                                min="0"
                                max="{{ $task->target }}"
                                class="w-full bg-white border border-slate-200 rounded-xl px-3 py-2 text-[13px] text-slate-700 font-semibold focus:outline-none focus:ring-2 focus:ring-[#0857C3]/20 focus:border-[#0857C3] transition-all @error('amount_done') border-red-400 bg-red-50 @enderror"
                            >
                        </div>
                        <div>
                            <label class="text-[10px] font-bold text-slate-500 uppercase tracking-wider mb-1 block">Status</label>
                            <select name="progress_override" class="w-full bg-white border border-slate-200 rounded-xl px-3 py-2 text-[12px] text-slate-700 focus:outline-none focus:ring-2 focus:ring-[#0857C3]/20 focus:border-[#0857C3] transition-all">
                                <option value="">Auto</option>
                                <option value="not_started" {{ $task->progress === 'not_started' ? 'selected' : '' }}>Not Started</option>
                                <option value="in_progress" {{ $task->progress === 'in_progress' ? 'selected' : '' }}>In Progress</option>
                                <option value="done" {{ $task->progress === 'done' ? 'selected' : '' }}>Done</option>
                            </select>
                        </div>
                    </div>

                    <div>
                        <label class="text-[10px] font-bold text-slate-500 uppercase tracking-wider mb-1 block">Description / Notes</label>
                        <textarea
                            name="description"
                            rows="2"
                            placeholder="Add notes about your progress..."
                            class="w-full bg-white border border-slate-200 rounded-xl px-3 py-2 text-[12px] text-slate-700 placeholder-slate-300 focus:outline-none focus:ring-2 focus:ring-[#0857C3]/20 focus:border-[#0857C3] transition-all resize-none"
                        >{{ $task->description }}</textarea>
                    </div>

                    <button type="submit" class="w-full py-2 bg-[#0857C3] hover:bg-[#0647a0] text-white text-[12px] font-bold rounded-xl transition-all shadow-sm hover:shadow-md hover:-translate-y-0.5 flex items-center justify-center gap-2">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                        Update Progress
                    </button>

                    @if($errors->any() && $errors->hasbag('update_' . $task->id))
                    <p class="text-[11px] text-red-500 font-medium">{{ $errors->bag('update_' . $task->id)->first() }}</p>
                    @endif
                </form>
            </div>
        </div>
        @endforeach
    </div>
    @endif
</div>
@endsection