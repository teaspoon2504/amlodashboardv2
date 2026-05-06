<div class="bg-white rounded-2xl border border-slate-200/80 shadow-sm hover:shadow-lg hover:border-[#0857C3]/30 transition-all duration-200 overflow-hidden group">
    <div class="px-4 py-3.5 bg-gradient-to-r from-[#0857C3]/5 via-[#71C5E8]/5 to-transparent border-b border-slate-100/80">
        <h4 class="text-[12px] font-bold text-slate-800 leading-snug line-clamp-2 group-hover:text-[#0647a0] transition-colors">{{ $name }}</h4>
    </div>
    <div class="p-4 space-y-3">
        <div class="flex items-center justify-between">
            <span class="text-[11px] text-slate-500 font-medium">{{ $progressLabel ?? 'Progress' }}</span>
            <span class="text-[14px] font-extrabold text-[#0857C3]">{{ $percent }}%</span>
        </div>
        <div class="w-full bg-slate-100 rounded-full h-1.5 overflow-hidden">
            <div class="h-1.5 rounded-full bg-gradient-to-r from-[#0857C3] to-[#71C5E8] transition-all duration-1000 ease-out" style="width: {{ $percent }}%"></div>
        </div>
        <div class="grid grid-cols-3 gap-1.5">
            <div class="text-center p-1.5 rounded-xl bg-emerald-50 border border-emerald-100/50">
                <p class="text-[13px] font-extrabold text-emerald-600">{{ $done }}</p>
                <p class="text-[9px] text-emerald-500 font-semibold uppercase tracking-wide">Done</p>
            </div>
            <div class="text-center p-1.5 rounded-xl bg-amber-50 border border-amber-100/50">
                <p class="text-[13px] font-extrabold text-amber-600">{{ $inProgress }}</p>
                <p class="text-[9px] text-amber-500 font-semibold uppercase tracking-wide">In Prg</p>
            </div>
            <div class="text-center p-1.5 rounded-xl bg-slate-100 border border-slate-200/50">
                <p class="text-[13px] font-extrabold text-slate-500">{{ $notStarted }}</p>
                <p class="text-[9px] text-slate-400 font-semibold uppercase tracking-wide">New</p>
            </div>
        </div>
        @if($hasTarget ?? false)
        <div class="pt-2 border-t border-slate-100/60 space-y-1.5">
            <div class="flex items-center justify-between text-[11px]">
                <span class="text-slate-400 font-medium">Target</span>
                <span class="font-bold text-slate-600">{{ $target }}</span>
            </div>
            <div class="flex items-center justify-between text-[11px]">
                <span class="text-slate-400 font-medium">Done</span>
                <span class="font-bold text-emerald-600">{{ $amountDone }}</span>
            </div>
            @if(isset($dueDate))
            <div class="flex items-center justify-between text-[11px]">
                <span class="text-slate-400 font-medium">Due Date</span>
                <span class="font-bold text-slate-600">{{ $dueDate }}</span>
            </div>
            @endif
        </div>
        @endif
    </div>
</div>