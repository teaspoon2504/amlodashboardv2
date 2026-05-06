<div class="bg-white rounded-2xl border border-slate-200/80 p-4 lg:p-5 shadow-sm hover:shadow-lg hover:border-slate-300 transition-all duration-200 overflow-hidden group">
    <div class="flex items-start justify-between mb-3">
        <span class="text-[11px] font-semibold text-slate-500 uppercase tracking-wider">{{ $label }}</span>
        <div class="w-9 h-9 rounded-xl flex items-center justify-center flex-shrink-0
            @if($color === 'emerald') bg-emerald-50 text-emerald-600
            @elseif($color === 'amber') bg-amber-50 text-amber-600
            @elseif($color === 'slate') bg-[#0857C3]/10 text-[#0857C3]
            @else bg-stone-100 text-stone-500 @endif">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $icon }}"/></svg>
        </div>
    </div>
    <p class="text-2xl lg:text-3xl font-extrabold text-slate-900 mb-0.5">{{ number_format($value) }}</p>
    <p class="text-[11px] text-slate-400 font-medium">{{ $sub }}</p>
    @if(!empty($progressWidth))
    <div class="mt-3 h-0.5 rounded-full bg-slate-100 overflow-hidden">
        <div class="h-full rounded-full @if($color === 'emerald') bg-emerald-400 @elseif($color === 'amber') bg-amber-400 @elseif($color === 'slate') bg-[#0857C3] @else bg-stone-300 @endif"
             style="width: {{ $progressWidth }}%"></div>
    </div>
    @endif
</div>