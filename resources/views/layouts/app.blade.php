<!DOCTYPE html>
<html lang="id" class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'AMLO Dashboard')</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        * { box-sizing: border-box; }
        body { font-family: 'Inter', ui-sans-serif, system-ui, sans-serif; margin: 0; }
        [x-cloak] { display: none !important; }
        .scrollbar-hide::-webkit-scrollbar { display: none; }
        .scrollbar-hide { -ms-overflow-style: none; scrollbar-width: none; }
        .scrollbar-thin::-webkit-scrollbar { width: 4px; height: 4px; }
        .scrollbar-thin::-webkit-scrollbar-track { background: transparent; }
        .scrollbar-thin::-webkit-scrollbar-thumb { background: rgba(255,255,255,0.1); border-radius: 4px; }
        @keyframes slideDown { from { opacity: 0; transform: translateY(-6px); } to { opacity: 1; transform: translateY(0); } }
        @keyframes fadeIn { from { opacity: 0; } to { opacity: 1; } }
        @keyframes countUp { from { opacity: 0; transform: translateY(8px); } to { opacity: 1; transform: translateY(0); } }
        @keyframes progressBar { from { width: 0; } }
        .animate-slide-down { animation: slideDown 0.25s ease-out forwards; }
        .animate-fade-in { animation: fadeIn 0.3s ease-out forwards; }
        .animate-count-up { animation: countUp 0.4s ease-out forwards; }
        .progress-animate { animation: progressBar 1s ease-out forwards; }
    </style>
</head>
<body class="h-full bg-slate-100 antialiased">

<div x-data="{ sidebarOpen: false, activeMenu: 'dashboard' }" class="h-full flex">

    {{-- Mobile Overlay --}}
    <div x-show="sidebarOpen" x-cloak
        class="fixed inset-0 z-40 bg-black/60 backdrop-blur-sm lg:hidden transition-opacity"
        @click="sidebarOpen = false" x-transition.opacity></div>

    {{-- Sidebar --}}
    <aside
        class="fixed top-0 left-0 z-50 h-full w-60 bg-[#081529] flex flex-col transition-all duration-300 ease-in-out
               lg:static lg:inset-0 overflow-hidden
               shadow-2xl lg:shadow-none ring-1 ring-white/5"
        :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full lg:translate-x-0'">

        {{-- Logo --}}
        <div class="flex items-center gap-3 px-5 py-5 border-b border-white/10">
            <div class="w-8 h-8 rounded-lg bg-gradient-to-br from-[#0857C3] to-[#71C5E8] flex items-center justify-center shadow-lg flex-shrink-0">
                <span class="text-white font-extrabold text-base leading-none">A</span>
            </div>
            <div>
                <h1 class="font-extrabold text-sm text-white leading-none tracking-tight">AML Dashboard</h1>
                <p class="text-[10px] text-white/40 font-medium mt-0.5">AML/CFT System</p>
            </div>
            <button @click="sidebarOpen = false" class="ml-auto lg:hidden p-1 rounded hover:bg-white/10 text-white/50 hover:text-white transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>
        </div>

        {{-- User Profile --}}
        <div class="px-4 py-4 border-b border-white/10">
            <div class="flex items-center gap-3">
                <div class="relative flex-shrink-0">
                    <div class="w-8 h-8 rounded-lg bg-gradient-to-br from-[#0857C3] to-[#71C5E8] flex items-center justify-center">
                        <span class="text-white font-bold text-xs">{{ strtoupper(substr(auth()->user()->name ?? 'U', 0, 1)) }}</span>
                    </div>
                    <div class="absolute -bottom-0.5 -right-0.5 w-2.5 h-2.5 bg-emerald-400 rounded-full border-2 border-[#081529]"></div>
                </div>
                <div class="min-w-0 flex-1">
                    <p class="font-semibold text-white text-[12px] truncate">{{ auth()->user()->name ?? 'User' }}</p>
                    <span class="inline-flex items-center gap-1 text-[10px] font-medium px-1.5 py-0.5 rounded-md
                        @if(auth()->user()->role === 'ho') bg-purple-500/20 text-purple-300
                        @elseif(auth()->user()->role === 'lead') bg-blue-500/20 text-blue-300
                        @else bg-emerald-500/20 text-emerald-300 @endif">
                        <span class="w-1 h-1 rounded-full
                            @if(auth()->user()->role === 'ho') bg-purple-400
                            @elseif(auth()->user()->role === 'lead') bg-blue-400
                            @else bg-emerald-400 @endif"></span>
                        @if(auth()->user()->role === 'ho') Head Office
                        @elseif(auth()->user()->role === 'lead') Team Lead
                        @else AMLO Officer @endif
                    </span>
                </div>
            </div>
        </div>

        {{-- Navigation --}}
        <nav class="flex-1 px-3 py-4 overflow-y-auto scrollbar-thin space-y-0.5">

            <p class="px-3 mb-2 text-[10px] font-bold text-white/25 uppercase tracking-widest">Menu</p>

            @php
                $dashboardRoute = match(auth()->user()->role) { 'officer' => route('dashboard.officer'), 'lead' => route('dashboard.lead'), default => route('dashboard.ho') };
            @endphp

            <a href="{{ $dashboardRoute }}" x-on:click="activeMenu = 'dashboard'"
                class="group flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition-all duration-150 relative overflow-hidden
                {{ request()->routeIs('dashboard.*') ? 'bg-[#0857C3]/20 text-white' : 'text-white/60 hover:text-white hover:bg-white/5' }}">
                @if(request()->routeIs('dashboard.*'))
                <div class="absolute left-0 top-1/2 -translate-y-1/2 w-0.5 h-6 bg-[#71C5E8] rounded-r-full"></div>
                @endif
                <svg class="w-[18px] h-[18px] flex-shrink-0 {{ request()->routeIs('dashboard.*') ? 'text-[#71C5E8]' : 'text-white/40 group-hover:text-white/70' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                </svg>
                <span class="{{ request()->routeIs('dashboard.*') ? 'font-semibold' : '' }}">Dashboard</span>
            </a>

            <a href="{{ route('tasks.index') }}" x-on:click="activeMenu = 'tasks'"
                class="group flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition-all duration-150 relative overflow-hidden
                {{ request()->routeIs('tasks.*') ? 'bg-[#0857C3]/20 text-white' : 'text-white/60 hover:text-white hover:bg-white/5' }}">
                @if(request()->routeIs('tasks.*'))
                <div class="absolute left-0 top-1/2 -translate-y-1/2 w-0.5 h-6 bg-[#71C5E8] rounded-r-full"></div>
                @endif
                <svg class="w-[18px] h-[18px] flex-shrink-0 {{ request()->routeIs('tasks.*') ? 'text-[#71C5E8]' : 'text-white/40 group-hover:text-white/70' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"/>
                </svg>
                <span class="{{ request()->routeIs('tasks.*') ? 'font-semibold' : '' }}">Task & Category</span>
            </a>

            @if(in_array(auth()->user()->role, ['ho', 'lead']))
            <a href="{{ route('monitoring.regional-office') }}" x-on:click="activeMenu = 'mon-ro'"
                class="group flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition-all duration-150 relative overflow-hidden
                {{ request()->routeIs('monitoring.regional-office') ? 'bg-[#0857C3]/20 text-white' : 'text-white/60 hover:text-white hover:bg-white/5' }}">
                @if(request()->routeIs('monitoring.regional-office'))
                <div class="absolute left-0 top-1/2 -translate-y-1/2 w-0.5 h-6 bg-[#71C5E8] rounded-r-full"></div>
                @endif
                <svg class="w-[18px] h-[18px] flex-shrink-0 {{ request()->routeIs('monitoring.regional-office') ? 'text-[#71C5E8]' : 'text-white/40 group-hover:text-white/70' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                </svg>
                <span class="{{ request()->routeIs('monitoring.regional-office') ? 'font-semibold' : '' }}">Monitoring RO</span>
            </a>

            <a href="{{ route('monitoring.officer') }}" x-on:click="activeMenu = 'mon-officer'"
                class="group flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition-all duration-150 relative overflow-hidden
                {{ request()->routeIs('monitoring.officer') ? 'bg-[#0857C3]/20 text-white' : 'text-white/60 hover:text-white hover:bg-white/5' }}">
                @if(request()->routeIs('monitoring.officer'))
                <div class="absolute left-0 top-1/2 -translate-y-1/2 w-0.5 h-6 bg-[#71C5E8] rounded-r-full"></div>
                @endif
                <svg class="w-[18px] h-[18px] flex-shrink-0 {{ request()->routeIs('monitoring.officer') ? 'text-[#71C5E8]' : 'text-white/40 group-hover:text-white/70' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
                </svg>
                <span class="{{ request()->routeIs('monitoring.officer') ? 'font-semibold' : '' }}">Monitoring Officer</span>
            </a>
            @endif
        </nav>

        {{-- Sign Out --}}
        <div class="px-3 pb-5 border-t border-white/10 pt-3">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="group flex items-center gap-3 px-3 py-2.5 w-full rounded-lg text-sm font-medium text-white/40 hover:text-red-400 hover:bg-red-500/10 transition-all duration-150">
                    <svg class="w-[18px] h-[18px] flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                    </svg>
                    Sign Out
                </button>
            </form>
        </div>
    </aside>

    {{-- Main Area --}}
    <div class="flex-1 flex flex-col min-w-0 h-full overflow-hidden">

        {{-- Top Bar --}}
        <header class="bg-white border-b border-slate-200 px-5 lg:px-7 flex-shrink-0">
            <div class="flex items-center justify-between h-14">
                <div class="flex items-center gap-4">
                    <button @click="sidebarOpen = true" class="lg:hidden p-2 rounded-lg hover:bg-slate-100 text-slate-500 transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/></svg>
                    </button>
                    <div>
                        <h1 class="text-[13px] font-bold text-slate-900">Dashboard</h1>
                        <div class="flex items-center gap-1.5 text-[11px] text-slate-400 font-medium">
                            <span>Dashboard</span>
                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                            <span class="text-slate-600">@yield('breadcrumb', 'Overview')</span>
                        </div>
                    </div>
                </div>
                <div class="flex items-center gap-2">
                    {{-- Notification --}}
                    <button class="relative p-2 rounded-lg hover:bg-slate-100 text-slate-400 hover:text-slate-600 transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/></svg>
                        <span class="absolute top-1 right-1 w-1.5 h-1.5 rounded-full bg-[#71C5E8]"></span>
                    </button>
                    {{-- User Avatar --}}
                    <div class="relative">
                        <div class="w-8 h-8 rounded-lg bg-gradient-to-br from-[#0857C3] to-[#71C5E8] flex items-center justify-center cursor-pointer">
                            <span class="text-white font-bold text-xs">{{ strtoupper(substr(auth()->user()->name ?? 'U', 0, 1)) }}</span>
                        </div>
                        <div class="absolute -bottom-0.5 -right-0.5 w-2.5 h-2.5 bg-emerald-400 rounded-full border-2 border-white"></div>
                    </div>
                </div>
            </div>
        </header>

        {{-- Success Alert --}}
        @if(session('success'))
        <div x-data="{ show: true }" x-show="show" x-transition
            class="mx-5 lg:mx-7 mt-4 flex items-center gap-3 px-4 py-3 bg-emerald-50 border border-emerald-200/80 rounded-xl shadow-sm animate-slide-down">
            <div class="w-7 h-7 rounded-lg bg-emerald-100 flex items-center justify-center flex-shrink-0">
                <svg class="w-3.5 h-3.5 text-emerald-600" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
            </div>
            <span class="text-sm font-medium text-emerald-700">{{ session('success') }}</span>
            <button @click="show = false" class="ml-auto text-emerald-400 hover:text-emerald-700 transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>
        </div>
        @endif

        {{-- Page Content --}}
        <main class="flex-1 overflow-y-auto overflow-x-hidden">
            @yield('content')
        </main>
    </div>
</div>

@stack('scripts')
</body>
</html>