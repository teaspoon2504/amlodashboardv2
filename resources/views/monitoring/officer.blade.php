@extends('layouts.app')
@section('title', 'Monitoring Officer')
@section('breadcrumb', 'Officer Performance')

@php
$scoreColors = [
    'high' => ['bar' => 'bg-gradient-to-r from-emerald-400 to-emerald-500', 'text' => 'text-emerald-600', 'bg' => 'bg-emerald-50'],
    'med' => ['bar' => 'bg-gradient-to-r from-amber-400 to-amber-500', 'text' => 'text-amber-600', 'bg' => 'bg-amber-50'],
    'low' => ['bar' => 'bg-slate-300', 'text' => 'text-slate-400', 'bg' => 'bg-slate-50'],
];
@endphp

@section('content')
<div class="p-4 sm:p-6 lg:p-8 space-y-5">

    <div class="flex items-center justify-between">
        <div>
            <h2 class="text-[15px] font-bold text-slate-800">Officer Performance Scorecard</h2>
            <p class="text-[12px] text-slate-400 mt-0.5">{{ $scorecard->count() }} team lead{{ $scorecard->count() > 1 ? 's' : '' }} tracked</p>
        </div>
    </div>

    @forelse($scorecard as $row)
    @php
        $scoreLevel = $row['overall_percent'] > 60 ? 'high' : ($row['overall_percent'] > 30 ? 'med' : 'low');
        $sc = $scoreColors[$scoreLevel];
    @endphp
    <div x-data="{ open: false }" class="bg-white rounded-2xl border border-slate-200/80 shadow-sm overflow-hidden hover:border-slate-300 transition-all duration-200">

        {{-- Team Lead Header --}}
        <button @click="open = !open" class="w-full flex items-center gap-4 px-5 py-4 hover:bg-slate-50/60 transition-colors text-left">
            <div class="w-10 h-10 rounded-full {{ $sc['bg'] }} border border-slate-100 flex items-center justify-center flex-shrink-0">
                <span class="text-[13px] font-extrabold {{ $sc['text'] }}">{{ strtoupper(substr($row['team_lead']->name ?? 'U', 0, 1)) }}</span>
            </div>
            <div class="flex-1 min-w-0">
                <p class="font-bold text-slate-800 text-[14px]">{{ $row['team_lead']->name }}</p>
                <p class="text-[12px] text-slate-400">{{ $row['regional_office']->name ?? '-' }}</p>
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

        {{-- Category chips --}}
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

        {{-- Officers (Collapsible) --}}
        <div x-show="open" x-collapse class="border-t border-slate-100">
            <div class="bg-slate-50/50 px-5 py-2.5">
                <p class="text-[11px] font-bold text-slate-400 uppercase tracking-widest">Officers</p>
            </div>
            @foreach($row['officers'] as $oRow)
            <div class="flex items-center gap-4 px-5 py-3.5 hover:bg-white transition-colors border-t border-slate-50">
                <div class="w-7 h-7 rounded-lg bg-blue-50 border border-blue-100 flex items-center justify-center flex-shrink-0">
                    <span class="text-[10px] font-extrabold text-blue-600">{{ strtoupper(substr($oRow['officer']->name ?? 'U', 0, 1)) }}</span>
                </div>
                <div class="flex-1 min-w-0">
                    <p class="font-semibold text-slate-700 text-[13px]">{{ $oRow['officer']->name }}</p>
                    <p class="text-[11px] text-slate-400">{{ $oRow['branch_office']->name ?? '-' }}</p>
                </div>
                <div class="flex items-center gap-1.5 flex-shrink-0">
                    <span class="text-[10px] font-bold text-emerald-600 bg-emerald-50 px-1.5 py-0.5 rounded-md border border-emerald-100">{{ $oRow['categories'][$categories->first()->id]['done'] ?? 0 }} D</span>
                    <span class="text-[10px] font-bold text-amber-600 bg-amber-50 px-1.5 py-0.5 rounded-md border border-amber-100">{{ $oRow['categories'][$categories->first()->id]['in_progress'] ?? 0 }} IP</span>
                    <span class="text-[10px] font-bold text-slate-400 bg-slate-50 px-1.5 py-0.5 rounded-md border border-slate-100">{{ $oRow['categories'][$categories->first()->id]['not_started'] ?? 0 }} N</span>
                </div>
                <div class="flex items-center gap-2 flex-shrink-0">
                    <div class="w-14 sm:w-16 bg-slate-100 rounded-full h-1.5 overflow-hidden">
                        <div class="h-1.5 rounded-full bg-[#71C5E8] transition-all" style="width: {{ $oRow['overall_percent'] }}%"></div>
                    </div>
                    <span class="text-[13px] font-extrabold text-[#71C5E8] w-9 text-right">{{ $oRow['overall_percent'] }}%</span>
                </div>
            </div>
            @endforeach
        </div>
    </div>
    @empty
    <div class="bg-white rounded-2xl border border-slate-200/80 shadow-sm p-12 text-center">
        <div class="w-12 h-12 rounded-2xl bg-slate-100 flex items-center justify-center mx-auto mb-3">
            <svg class="w-6 h-6 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
        </div>
        <p class="text-slate-500 font-medium text-sm">No officers found</p>
    </div>
    @endforelse
</div>
@endsection