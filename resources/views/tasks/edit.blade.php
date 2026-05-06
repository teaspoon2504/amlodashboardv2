@extends('layouts.app')
@section('title', 'Edit Task')
@section('breadcrumb', 'Edit Task')

@section('content')
<div class="p-4 sm:p-6 lg:p-8 max-w-3xl">
    <div class="bg-white rounded-2xl border border-slate-200/80 shadow-sm overflow-hidden">

        <div class="px-6 py-5 border-b border-slate-100 bg-gradient-to-r from-[#0857C3]/5 to-[#71C5E8]/5">
            <div class="flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-xl bg-[#0857C3]/10 flex items-center justify-center">
                        <svg class="w-5 h-5 text-[#0857C3]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                    </div>
                    <div>
                        <h2 class="text-[16px] font-bold text-slate-900">Edit Task</h2>
                        <p class="text-[12px] text-slate-400 mt-0.5">Update task details below</p>
                    </div>
                </div>
            </div>
        </div>

        <form method="POST" action="{{ route('tasks.update', $task) }}" class="p-6 space-y-5">
            @csrf @method('PUT')

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                <div class="space-y-2">
                    <label class="text-[11px] font-bold text-slate-600 uppercase tracking-wider">Regional Office <span class="text-red-400">*</span></label>
                    <select name="regional_office_id" required class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm text-slate-700 focus:outline-none focus:ring-2 focus:ring-[#0857C3]/20 focus:border-[#0857C3] transition-all">
                        @foreach($regionalOffices as $ro)
                        <option value="{{ $ro->id }}" {{ $task->regional_office_id == $ro->id ? 'selected' : '' }}>{{ $ro->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="space-y-2">
                    <label class="text-[11px] font-bold text-slate-600 uppercase tracking-wider">Task Category <span class="text-red-400">*</span></label>
                    <select name="task_category_id" required class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm text-slate-700 focus:outline-none focus:ring-2 focus:ring-[#0857C3]/20 focus:border-[#0857C3] transition-all">
                        @foreach($taskCategories as $cat)
                        <option value="{{ $cat->id }}" {{ $task->task_category_id == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                <div class="space-y-2">
                    <label class="text-[11px] font-bold text-slate-600 uppercase tracking-wider">Team Lead</label>
                    <select name="team_lead_id" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm text-slate-700 focus:outline-none focus:ring-2 focus:ring-[#0857C3]/20 focus:border-[#0857C3] transition-all">
                        <option value="">Select Team Lead</option>
                        @foreach($teamLeads as $tl)
                        <option value="{{ $tl->id }}" {{ $task->team_lead_id == $tl->id ? 'selected' : '' }}>{{ $tl->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="space-y-2">
                    <label class="text-[11px] font-bold text-slate-600 uppercase tracking-wider">Officer</label>
                    <select name="officer_id" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm text-slate-700 focus:outline-none focus:ring-2 focus:ring-[#0857C3]/20 focus:border-[#0857C3] transition-all">
                        <option value="">Select Officer</option>
                        @foreach($officers as $o)
                        <option value="{{ $o->id }}" {{ $task->officer_id == $o->id ? 'selected' : '' }}>{{ $o->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-3 gap-5">
                <div class="space-y-2">
                    <label class="text-[11px] font-bold text-slate-600 uppercase tracking-wider">Branch Office</label>
                    <select name="branch_office_id" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm text-slate-700 focus:outline-none focus:ring-2 focus:ring-[#0857C3]/20 focus:border-[#0857C3] transition-all">
                        <option value="">Select Branch</option>
                        @foreach($branchOffices as $bo)
                        <option value="{{ $bo->id }}" {{ $task->branch_office_id == $bo->id ? 'selected' : '' }}>{{ $bo->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="space-y-2">
                    <label class="text-[11px] font-bold text-slate-600 uppercase tracking-wider">Target <span class="text-red-400">*</span></label>
                    <input type="number" name="target" value="{{ $task->target }}" min="0" required
                        class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm text-slate-700 focus:outline-none focus:ring-2 focus:ring-[#0857C3]/20 focus:border-[#0857C3] transition-all">
                </div>
                <div class="space-y-2">
                    <label class="text-[11px] font-bold text-slate-600 uppercase tracking-wider">Amount Done</label>
                    <input type="number" name="amount_done" value="{{ $task->amount_done }}" min="0"
                        class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm text-slate-700 focus:outline-none focus:ring-2 focus:ring-[#0857C3]/20 focus:border-[#0857C3] transition-all">
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                <div class="space-y-2">
                    <label class="text-[11px] font-bold text-slate-600 uppercase tracking-wider">Due Date</label>
                    <input type="date" name="due_date" value="{{ $task->due_date?->format('Y-m-d') }}"
                        class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm text-slate-700 focus:outline-none focus:ring-2 focus:ring-[#0857C3]/20 focus:border-[#0857C3] transition-all">
                </div>
                <div class="space-y-2">
                    <label class="text-[11px] font-bold text-slate-600 uppercase tracking-wider">Progress</label>
                    <select name="progress" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm text-slate-700 focus:outline-none focus:ring-2 focus:ring-[#0857C3]/20 focus:border-[#0857C3] transition-all">
                        <option value="not_started" {{ $task->progress === 'not_started' ? 'selected' : '' }}>Not Started</option>
                        <option value="in_progress" {{ $task->progress === 'in_progress' ? 'selected' : '' }}>In Progress</option>
                        <option value="done" {{ $task->progress === 'done' ? 'selected' : '' }}>Done</option>
                    </select>
                </div>
            </div>

            <div class="space-y-2">
                <label class="text-[11px] font-bold text-slate-600 uppercase tracking-wider">Description</label>
                <textarea name="description" rows="3"
                    class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm text-slate-700 focus:outline-none focus:ring-2 focus:ring-[#0857C3]/20 focus:border-[#0857C3] transition-all resize-none placeholder-slate-300">{{ $task->description }}</textarea>
            </div>

            <div class="space-y-2">
                <label class="text-[11px] font-bold text-slate-600 uppercase tracking-wider">Feedback</label>
                <textarea name="feedback" rows="2"
                    class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm text-slate-700 focus:outline-none focus:ring-2 focus:ring-[#0857C3]/20 focus:border-[#0857C3] transition-all resize-none placeholder-slate-300">{{ $task->feedback }}</textarea>
            </div>

            <div class="flex items-center gap-3 pt-4 border-t border-slate-100">
                <button type="submit" class="px-6 py-2.5 bg-[#0857C3] hover:bg-[#0647a0] text-white text-sm font-semibold rounded-xl transition-all shadow-sm hover:shadow-md hover:-translate-y-0.5 flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                    Update Task
                </button>
                <a href="{{ route('tasks.index') }}" class="px-5 py-2.5 text-slate-500 hover:text-slate-700 hover:bg-slate-100 text-sm font-medium rounded-xl transition-all">Cancel</a>
                <button type="submit" form="delete-form" class="ml-auto px-4 py-2.5 text-red-500 hover:text-red-700 hover:bg-red-50 text-sm font-semibold rounded-xl transition-all flex items-center gap-1.5">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-4v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                    Delete
                </button>
            </div>
        </form>

        <form id="delete-form" method="POST" action="{{ route('tasks.destroy', $task) }}" class="hidden">
            @csrf @method('DELETE')
        </form>
    </div>
</div>
@endsection