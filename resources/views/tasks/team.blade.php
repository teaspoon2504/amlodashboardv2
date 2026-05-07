@extends('layouts.app')
@section('title', 'Team Tasks')
@section('breadcrumb', 'Team Tasks')

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
            <h2 class="text-[15px] font-bold text-slate-800">Team Tasks</h2>
            <p class="text-[12px] text-slate-400 mt-0.5">{{ $tasks->count() }} task{{ $tasks->count() !== 1 ? 's' : '' }} in your team</p>
        </div>
    </div>

    @if($tasks->isEmpty())
    <div class="bg-white rounded-2xl border border-slate-200/80 p-16 text-center shadow-sm">
        <div class="w-12 h-12 rounded-2xl bg-slate-100 flex items-center justify-center mx-auto mb-3">
            <svg class="w-6 h-6 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
        </div>
        <p class="text-slate-500 font-medium text-sm">No tasks assigned to your team yet</p>
    </div>
    @else
    <div class="bg-white rounded-2xl border border-slate-200/80 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="border-b border-slate-100 bg-slate-50/80">
                        <th class="px-5 py-3.5 text-left text-[11px] font-bold text-slate-500 uppercase tracking-wider">Task</th>
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
                    @foreach($tasks as $task)
                    @php
                        $pct = $task->target > 0 ? min(100, (int)round(($task->amount_done / $task->target) * 100)) : 0;
                        $c = $progressColors[$task->progress] ?? $progressColors['not_started'];
                    @endphp
                    <tr class="hover:bg-slate-50/60 transition-colors group">
                        <td class="px-5 py-3.5">
                            <div class="flex items-center gap-2.5">
                                <div class="w-1.5 h-1.5 rounded-full {{ $c['dot'] }} flex-shrink-0 mt-0.5"></div>
                                <div>
                                    <p class="font-semibold text-slate-800 text-[13px]">{{ $task->taskCategory->name }}</p>
                                    <p class="text-[11px] text-slate-400">{{ $task->branchOffice->name ?? '-' }}</p>
                                </div>
                            </div>
                        </td>
                        <td class="px-4 py-3.5 text-slate-600 text-[12px] hidden md:table-cell">{{ $task->officer->name ?? '-' }}</td>
                        <td class="px-3 py-3.5 text-center text-slate-500 text-[13px] font-medium">{{ $task->target }}</td>
                        <td class="px-3 py-3.5 text-center">
                            <span class="inline-flex items-center justify-center w-7 h-7 rounded-lg bg-slate-100 text-slate-600 text-xs font-bold">{{ $task->amount_done }}</span>
                        </td>
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
                            <button
                                onclick="openFeedback('{{ $task->id }}', '{{ $task->taskCategory->name }}', `{{ $task->feedback ?? '' }}`)"
                                class="inline-flex items-center gap-1 text-[12px] font-semibold text-[#0857C3] hover:text-[#0647a0] transition-colors"
                            >
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"/></svg>
                                Feedback
                            </button>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    @endif
</div>

{{-- Feedback Modal --}}
<div
    x-data="{ open: false, taskId: null, taskName: '' }"
    x-show="open"
    x-cloak
    @open-feedback.window="open = true; taskId = $event.detail.taskId; taskName = $event.detail.taskName"
    class="fixed inset-0 z-50 flex items-center justify-center p-4"
    style="display: none"
>
    <div class="absolute inset-0 bg-black/40 backdrop-blur-sm" @click="open = false"></div>
    <div class="relative bg-white rounded-2xl shadow-2xl w-full max-w-md p-6 animate-slide-down">
        <div class="flex items-center justify-between mb-5">
            <div>
                <h3 class="text-[15px] font-bold text-slate-800">Give Feedback</h3>
                <p class="text-[11px] text-slate-400 mt-0.5" x-text="taskName"></p>
            </div>
            <button @click="open = false" class="p-2 rounded-lg hover:bg-slate-100 text-slate-400 hover:text-slate-600 transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>
        </div>

        <div id="feedback-forms">
            @foreach($tasks as $task)
            <form
                method="POST"
                action="{{ route('tasks.lead-feedback', $task) }}"
                id="feedback-form-{{ $task->id }}"
                x-show="taskId === '{{ $task->id }}'"
            >
                @csrf
                @method('PATCH')
                <div class="space-y-3">
                    <div>
                        <label class="text-[11px] font-bold text-slate-500 uppercase tracking-wider mb-1.5 block">Feedback</label>
                        <textarea
                            name="feedback"
                            rows="3"
                            placeholder="Write your feedback for this task..."
                            class="w-full bg-white border border-slate-200 rounded-xl px-3 py-2.5 text-[13px] text-slate-700 placeholder-slate-300 focus:outline-none focus:ring-2 focus:ring-[#0857C3]/20 focus:border-[#0857C3] transition-all resize-none"
                        >{{ $task->feedback }}</textarea>
                    </div>
                    <button type="submit" class="w-full py-2.5 bg-[#0857C3] hover:bg-[#0647a0] text-white text-[13px] font-bold rounded-xl transition-all shadow-sm hover:shadow-md hover:-translate-y-0.5 flex items-center justify-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                        Submit Feedback
                    </button>
                </div>
            </form>
            @endforeach
        </div>
    </div>
</div>

<script>
function openFeedback(taskId, taskName) {
    document.querySelectorAll('#feedback-forms > form').forEach(f => f.style.display = 'none');
    const form = document.getElementById('feedback-form-' + taskId);
    if (form) form.style.display = 'block';
    window.dispatchEvent(new CustomEvent('open-feedback', {
        detail: { taskId, taskName }
    }));
}
</script>
@endsection