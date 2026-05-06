@extends('layouts.app')
@section('title', 'Create Task')
@section('breadcrumb', 'Create Task')

@section('content')
<div class="p-4 sm:p-6 lg:p-8 max-w-3xl">
    <div class="bg-white rounded-2xl border border-slate-200/80 shadow-sm overflow-hidden">

        {{-- Card Header --}}
        <div class="px-6 py-5 border-b border-slate-100 bg-gradient-to-r from-[#0857C3]/5 to-[#71C5E8]/5">
            <div class="flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-xl bg-[#0857C3]/10 flex items-center justify-center">
                        <svg class="w-5 h-5 text-[#0857C3]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"/></svg>
                    </div>
                    <div>
                        <h2 class="text-[16px] font-bold text-slate-900">Create New Task</h2>
                        <p class="text-[12px] text-slate-400 mt-0.5">Fill in the details below to create a new task</p>
                    </div>
                </div>
            </div>
        </div>

        {{-- Form --}}
        <form method="POST" action="{{ route('tasks.store') }}" class="p-6 space-y-5">
            @csrf

            {{-- Row 1 --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                <div class="space-y-2">
                    <label class="text-[11px] font-bold text-slate-600 uppercase tracking-wider">Regional Office <span class="text-red-400">*</span></label>
                    <select name="regional_office_id" required class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm text-slate-700 focus:outline-none focus:ring-2 focus:ring-[#0857C3]/20 focus:border-[#0857C3] transition-all @error('regional_office_id') border-red-400 bg-red-50/30 @enderror">
                        <option value="">Select Regional Office</option>
                        @foreach($regionalOffices as $ro)
                        <option value="{{ $ro->id }}" {{ old('regional_office_id') == $ro->id ? 'selected' : '' }}>{{ $ro->name }}</option>
                        @endforeach
                    </select>
                    @error('regional_office_id') <p class="text-[11px] text-red-500 mt-1">{{ $message }}</p> @enderror
                </div>
                <div class="space-y-2">
                    <label class="text-[11px] font-bold text-slate-600 uppercase tracking-wider">Task Category <span class="text-red-400">*</span></label>
                    <select name="task_category_id" required class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm text-slate-700 focus:outline-none focus:ring-2 focus:ring-[#0857C3]/20 focus:border-[#0857C3] transition-all @error('task_category_id') border-red-400 bg-red-50/30 @enderror">
                        <option value="">Select Category</option>
                        @foreach($taskCategories as $cat)
                        <option value="{{ $cat->id }}" {{ old('task_category_id') == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                        @endforeach
                    </select>
                    @error('task_category_id') <p class="text-[11px] text-red-500 mt-1">{{ $message }}</p> @enderror
                </div>
            </div>

            {{-- Row 2 --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                <div class="space-y-2">
                    <label class="text-[11px] font-bold text-slate-600 uppercase tracking-wider">Team Lead</label>
                    <select name="team_lead_id" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm text-slate-700 focus:outline-none focus:ring-2 focus:ring-[#0857C3]/20 focus:border-[#0857C3] transition-all">
                        <option value="">Select Team Lead</option>
                        @foreach($teamLeads as $tl)
                        <option value="{{ $tl->id }}" {{ old('team_lead_id') == $tl->id ? 'selected' : '' }}>{{ $tl->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="space-y-2">
                    <label class="text-[11px] font-bold text-slate-600 uppercase tracking-wider">Officer</label>
                    <select name="officer_id" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm text-slate-700 focus:outline-none focus:ring-2 focus:ring-[#0857C3]/20 focus:border-[#0857C3] transition-all">
                        <option value="">Select Officer</option>
                        @foreach($officers as $o)
                        <option value="{{ $o->id }}" {{ old('officer_id') == $o->id ? 'selected' : '' }}>{{ $o->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            {{-- Row 3 --}}
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-5">
                <div class="space-y-2">
                    <label class="text-[11px] font-bold text-slate-600 uppercase tracking-wider">Branch Office</label>
                    <select name="branch_office_id" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm text-slate-700 focus:outline-none focus:ring-2 focus:ring-[#0857C3]/20 focus:border-[#0857C3] transition-all">
                        <option value="">Select Branch</option>
                        @foreach($branchOffices as $bo)
                        <option value="{{ $bo->id }}" {{ old('branch_office_id') == $bo->id ? 'selected' : '' }}>{{ $bo->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="space-y-2">
                    <label class="text-[11px] font-bold text-slate-600 uppercase tracking-wider">Target <span class="text-red-400">*</span></label>
                    <input type="number" name="target" value="{{ old('target', 0) }}" min="0" required
                        class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm text-slate-700 focus:outline-none focus:ring-2 focus:ring-[#0857C3]/20 focus:border-[#0857C3] transition-all @error('target') border-red-400 bg-red-50/30 @enderror">
                    @error('target') <p class="text-[11px] text-red-500 mt-1">{{ $message }}</p> @enderror
                </div>
                <div class="space-y-2">
                    <label class="text-[11px] font-bold text-slate-600 uppercase tracking-wider">Amount Done</label>
                    <input type="number" name="amount_done" value="{{ old('amount_done', 0) }}" min="0"
                        class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm text-slate-700 focus:outline-none focus:ring-2 focus:ring-[#0857C3]/20 focus:border-[#0857C3] transition-all">
                </div>
            </div>

            {{-- Row 4 --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                <div class="space-y-2">
                    <label class="text-[11px] font-bold text-slate-600 uppercase tracking-wider">Due Date</label>
                    <input type="date" name="due_date" value="{{ old('due_date') }}"
                        class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm text-slate-700 focus:outline-none focus:ring-2 focus:ring-[#0857C3]/20 focus:border-[#0857C3] transition-all">
                </div>
                <div class="space-y-2">
                    <label class="text-[11px] font-bold text-slate-600 uppercase tracking-wider">Progress</label>
                    <select name="progress" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm text-slate-700 focus:outline-none focus:ring-2 focus:ring-[#0857C3]/20 focus:border-[#0857C3] transition-all">
                        <option value="not_started" {{ old('progress', 'not_started') === 'not_started' ? 'selected' : '' }}>Not Started</option>
                        <option value="in_progress" {{ old('progress') === 'in_progress' ? 'selected' : '' }}>In Progress</option>
                        <option value="done" {{ old('progress') === 'done' ? 'selected' : '' }}>Done</option>
                    </select>
                </div>
            </div>

            {{-- Description --}}
            <div class="space-y-2">
                <label class="text-[11px] font-bold text-slate-600 uppercase tracking-wider">Description</label>
                <textarea name="description" rows="3" placeholder="Describe the task details..."
                    class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm text-slate-700 focus:outline-none focus:ring-2 focus:ring-[#0857C3]/20 focus:border-[#0857C3] transition-all resize-none placeholder-slate-300">{{ old('description') }}</textarea>
            </div>

            {{-- Actions --}}
            <div class="flex items-center gap-3 pt-2 border-t border-slate-100">
                <button type="submit" class="px-6 py-2.5 bg-[#0857C3] hover:bg-[#0647a0] text-white text-sm font-semibold rounded-xl transition-all shadow-sm hover:shadow-md hover:-translate-y-0.5 flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                    Create Task
                </button>
                <a href="{{ route('tasks.index') }}" class="px-5 py-2.5 text-slate-500 hover:text-slate-700 hover:bg-slate-100 text-sm font-medium rounded-xl transition-all">Cancel</a>
            </div>
        </form>
    </div>
</div>
@endsection