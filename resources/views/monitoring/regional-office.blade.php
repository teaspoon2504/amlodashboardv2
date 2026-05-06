@extends('layouts.app')
@section('title', 'Monitoring Regional Office')
@section('breadcrumb', 'Regional Office')

@php
$scoreColors = [
    'high' => ['bar' => 'bg-gradient-to-r from-emerald-400 to-emerald-500', 'text' => 'text-emerald-600', 'bg' => 'bg-emerald-50', 'badge' => 'bg-emerald-100 text-emerald-700', 'dot' => 'bg-emerald-400'],
    'med' => ['bar' => 'bg-gradient-to-r from-amber-400 to-amber-500', 'text' => 'text-amber-600', 'bg' => 'bg-amber-50', 'badge' => 'bg-amber-100 text-amber-700', 'dot' => 'bg-amber-400'],
    'low' => ['bar' => 'bg-slate-300', 'text' => 'text-slate-400', 'bg' => 'bg-slate-50', 'badge' => 'bg-slate-100 text-slate-500', 'dot' => 'bg-slate-300'],
];
@endphp

@section('content')
<div class="p-4 sm:p-6 lg:p-8 space-y-5">

    {{-- Header --}}
    <div class="flex items-center justify-between">
        <div>
            <h2 class="text-[15px] font-bold text-slate-800">Scorecard Per Regional Office</h2>
            <p class="text-[12px] text-slate-400 mt-0.5">{{ $scorecard->count() }} regional office{{ $scorecard->count() > 1 ? 's' : '' }} tracked</p>
        </div>
        <div class="hidden sm:flex items-center gap-4 text-[11px] font-semibold text-slate-400">
            <span class="flex items-center gap-1.5"><span class="w-2 h-2 rounded-full bg-emerald-400"></span> High &gt;60%</span>
            <span class="flex items-center gap-1.5"><span class="w-2 h-2 rounded-full bg-amber-400"></span> Med 30–60%</span>
            <span class="flex items-center gap-1.5"><span class="w-2 h-2 rounded-full bg-slate-300"></span> Low &lt;30%</span>
        </div>
    </div>

    @forelse($scorecard as $row)
    @php
        $scoreLevel = $row['overall_percent'] > 60 ? 'high' : ($row['overall_percent'] > 30 ? 'med' : 'low');
        $sc = $scoreColors[$scoreLevel];
    @endphp
    <div x-data="{ open: false }" class="bg-white rounded-2xl border border-slate-200/80 shadow-sm overflow-hidden hover:border-slate-300 transition-all duration-200">

        {{-- RO Header --}}
        <button @click="open = !open" class="w-full flex items-center gap-4 px-5 py-4 hover:bg-slate-50/60 transition-colors text-left">
            <div class="w-10 h-10 rounded-xl {{ $sc['bg'] }} border border-slate-100 flex items-center justify-center flex-shrink-0">
                <svg class="w-5 h-5 {{ $sc['text'] }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
            </div>
            <div class="flex-1 min-w-0">
                <p class="font-bold text-slate-800 text-[14px]">{{ $row['regional_office']->name }}</p>
                <p class="text-[12px] text-slate-400">{{ $row['team_lead']->name ?? '—' }} · {{ $row['regional_office']->code }}</p>
            </div>
            <div class="flex items-center gap-3 flex-shrink-0">
                <div class="hidden sm:flex items-center gap-2 mr-2">
                    <div class="w-20 bg-slate-100 rounded-full h-1.5 overflow-hidden">
                        <div class="h-1.5 rounded-full {{ $sc['bar'] }} transition-all duration-500" style="width: {{ $row['overall_percent'] }}%"></div>
                    </div>
                    <span class="text-[14px] font-extrabold {{ $sc['text'] }} w-10 text-right">{{ $row['overall_percent'] }}%</span>
                </div>
                <div class="sm:hidden mr-2">
                    <span class="text-[14px] font-extrabold {{ $sc['text'] }}">{{ $row['overall_percent'] }}%</span>
                </div>
                <svg class="w-4 h-4 text-slate-400 transform transition-transform duration-200" :class="open ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
            </div>
        </button>

        {{-- Category Chips --}}
        <div class="px-5 pb-4 -mt-1">
            <div class="flex flex-wrap gap-2">
                @foreach($row['categories'] as $catId => $catData)
                <div class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl text-[11px] font-semibold border
                    @if($catData['percent'] >= 100) bg-emerald-50 border-emerald-100 text-emerald-600
                    @elseif($catData['percent'] > 0) bg-amber-50 border-amber-100 text-amber-600
                    @else bg-slate-50 border-slate-100 text-slate-400 @endif">
                    <span class="w-1.5 h-1.5 rounded-full @if($catData['percent'] >= 100) bg-emerald-400 @elseif($catData['percent'] > 0) bg-amber-400 @else bg-slate-300 @endif"></span>
                    {{ $catData['percent'] }}%
                </div>
                @endforeach
            </div>
        </div>

        {{-- Branch Offices (Collapsible) --}}
        <div x-show="open" x-collapse class="border-t border-slate-100">
            <div class="bg-slate-50/50 px-5 py-2.5">
                <p class="text-[11px] font-bold text-slate-400 uppercase tracking-widest">Branch Offices</p>
            </div>
            @foreach($row['branch_offices'] as $boRow)
            <div class="flex items-center gap-4 px-5 py-3.5 hover:bg-white transition-colors border-t border-slate-50">
                <div class="w-1.5 h-1.5 rounded-full bg-slate-300 flex-shrink-0"></div>
                <div class="flex-1 min-w-0">
                    <p class="font-semibold text-slate-700 text-[13px]">{{ $boRow['branch_office']->name }}</p>
                    <p class="text-[11px] text-slate-400">{{ $boRow['branch_office']->code }}</p>
                </div>
                <div class="flex items-center gap-2 flex-shrink-0">
                    <div class="w-16 sm:w-20 bg-slate-100 rounded-full h-1.5 overflow-hidden">
                        <div class="h-1.5 rounded-full bg-[#71C5E8] transition-all" style="width: {{ $boRow['overall_percent'] }}%"></div>
                    </div>
                    <span class="text-[13px] font-extrabold text-[#71C5E8] w-10 text-right">{{ $boRow['overall_percent'] }}%</span>
                </div>
            </div>
            @endforeach
        </div>
    </div>
    @empty
    <div class="bg-white rounded-2xl border border-slate-200/80 shadow-sm p-12 text-center">
        <div class="w-12 h-12 rounded-2xl bg-slate-100 flex items-center justify-center mx-auto mb-3">
            <svg class="w-6 h-6 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
        </div>
        <p class="text-slate-500 font-medium text-sm">No regional offices found</p>
    </div>
    @endforelse
</div>
@endsection