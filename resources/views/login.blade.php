<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Login - AMLO Dashboard')</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <style>
        *, *::before, *::after { box-sizing: border-box; }
        body { font-family: 'Inter', ui-sans-serif, system-ui, sans-serif; margin: 0; }
        [x-cloak] { display: none !important; }
        @keyframes float { 0%, 100% { transform: translateY(0px) rotate(0deg); } 50% { transform: translateY(-12px) rotate(2deg); } }
        @keyframes pulse-ring { 0% { transform: scale(1); opacity: 0.4; } 100% { transform: scale(1.6); opacity: 0; } }
        @keyframes shimmer { 0% { background-position: -200% center; } 100% { background-position: 200% center; } }
        @keyframes slideUp { from { opacity: 0; transform: translateY(20px); } to { opacity: 1; transform: translateY(0); } }
        @keyframes dotFlow { 0% { transform: translateY(0px) translateX(0px); } 50% { transform: translateY(-20px) translateX(10px); } 100% { transform: translateY(0px) translateX(0px); } }
        .animate-float { animation: float 6s ease-in-out infinite; }
        .animate-float-delay { animation: float 6s ease-in-out infinite 3s; }
        .animate-slide-up { animation: slideUp 0.6s ease-out forwards; }
        .animate-dot-1 { animation: dotFlow 4s ease-in-out infinite; }
        .animate-dot-2 { animation: dotFlow 4s ease-in-out infinite 1.3s; }
        .animate-dot-3 { animation: dotFlow 4s ease-in-out infinite 2.6s; }
        .btn-shimmer { background-size: 200% auto; animation: shimmer 2s linear infinite; }
        .glass { backdrop-filter: blur(12px); -webkit-backdrop-filter: blur(12px); }
        .input-glow:focus { box-shadow: 0 0 0 3px rgba(96, 165, 250, 0.15), 0 0 12px rgba(96, 165, 250, 0.1); }
        .btn-hover { transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1); }
        .btn-hover:hover { transform: translateY(-2px); box-shadow: 0 8px 24px rgba(37, 99, 235, 0.4); }
        .btn-hover:active { transform: translateY(0); }
        .demo-btn { transition: all 0.2s ease; }
        .demo-btn:hover { transform: translateY(-2px) scale(1.03); }
    </style>
</head>
<body class="min-h-screen bg-slate-100 overflow-hidden">

{{-- Animated background --}}
<div class="fixed inset-0 overflow-hidden pointer-events-none">
    <div class="absolute inset-0 bg-gradient-to-br from-slate-900 via-blue-950 to-slate-900"></div>
    {{-- Top right glow --}}
    <div class="absolute -top-40 -right-40 w-96 h-96 rounded-full bg-blue-600/10 blur-3xl"></div>
    <div class="absolute -top-20 -right-20 w-64 h-64 rounded-full bg-cyan-500/10 blur-3xl"></div>
    {{-- Bottom left glow --}}
    <div class="absolute -bottom-40 -left-40 w-96 h-96 rounded-full bg-indigo-600/10 blur-3xl"></div>
    {{-- Animated floating orbs --}}
    <div class="absolute top-20 right-20 w-2 h-2 rounded-full bg-cyan-400/40 animate-dot-1"></div>
    <div class="absolute top-40 right-40 w-1.5 h-1.5 rounded-full bg-blue-400/40 animate-dot-2"></div>
    <div class="absolute top-16 right-32 w-1 h-1 rounded-full bg-indigo-400/40 animate-dot-3"></div>
    <div class="absolute bottom-32 left-20 w-2 h-2 rounded-full bg-blue-400/30 animate-dot-1"></div>
    <div class="absolute bottom-16 left-40 w-1.5 h-1.5 rounded-full bg-cyan-400/30 animate-dot-2"></div>
    {{-- Grid pattern --}}
    <div class="absolute inset-0 opacity-[0.03]" style="background-image: linear-gradient(rgba(255,255,255,0.5) 1px, transparent 1px), linear-gradient(90deg, rgba(255,255,255,0.5) 1px, transparent 1px); background-size: 48px 48px;"></div>
</div>

<div class="relative min-h-screen flex">

    {{-- ========== LEFT PANEL — Dark brand side ========== --}}
    <div class="hidden lg:flex lg:w-[420px] flex-col justify-between p-10 xl:p-14 flex-shrink-0 relative overflow-hidden">

        {{-- Subtle radial glow behind logo --}}
        <div class="absolute top-8 left-1/2 -translate-x-1/2 w-32 h-32 rounded-full bg-blue-500/10 blur-2xl"></div>

        {{-- Logo & Brand --}}
        <div class="relative">
            <div class="flex items-center gap-4 mb-16">
                <div class="w-12 h-12 rounded-2xl bg-gradient-to-br from-blue-500 to-cyan-400 flex items-center justify-center shadow-lg shadow-blue-500/25 animate-float">
                    <span class="text-white font-extrabold text-xl leading-none">A</span>
                </div>
                <div>
                    <h1 class="font-extrabold text-white text-lg leading-none tracking-tight">AML Dashboard</h1>
                    <p class="text-blue-300/60 text-xs font-medium mt-1 tracking-widest uppercase">AML/CFT System</p>
                </div>
            </div>

            {{-- Tagline --}}
            <div class="space-y-3 mb-16">
                <h2 class="text-3xl xl:text-4xl font-extrabold text-white leading-tight">
                    Monitor &amp;<br>Enforce <span class="text-transparent bg-clip-text bg-gradient-to-r from-blue-400 to-cyan-400">Compliance</span>
                </h2>
                <p class="text-slate-400 text-sm leading-relaxed max-w-xs">
                    Real-time AML/CFT monitoring across all regional offices and branch operations.
                </p>
            </div>

            {{-- Feature bullets --}}
            <div class="space-y-4">
                @foreach([
                    ['icon' => 'M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z', 'label' => 'Real-time Task Monitoring'],
                    ['icon' => 'M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z', 'label' => 'Officer Performance Tracking'],
                    ['icon' => 'M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z', 'label' => 'Regional Scorecards'],
                ] as $feature)
                <div class="flex items-center gap-3">
                    <div class="w-8 h-8 rounded-xl bg-blue-500/20 border border-blue-500/20 flex items-center justify-center flex-shrink-0">
                        <svg class="w-4 h-4 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $feature['icon'] }}"/></svg>
                    </div>
                    <span class="text-slate-300 text-sm font-medium">{{ $feature['label'] }}</span>
                </div>
                @endforeach
            </div>
        </div>

        {{-- Footer --}}
        <div class="relative">
            <div class="h-px bg-gradient-to-r from-transparent via-blue-500/30 to-transparent mb-5"></div>
            <p class="text-slate-500 text-xs font-medium">© {{ date('Y') }} AMLO Dashboard · All rights reserved</p>
            <p class="text-slate-600 text-[10px] mt-1">Anti-Money Laundering & Counter Financing of Terrorism</p>
        </div>

        {{-- Decorative circles --}}
        <div class="absolute -bottom-20 -right-20 w-64 h-64 rounded-full border border-blue-500/10 animate-float-delay"></div>
        <div class="absolute -bottom-32 -right-8 w-40 h-40 rounded-full border border-cyan-500/10 animate-float"></div>
    </div>

    {{-- ========== RIGHT PANEL — Form ========== --}}
    <div class="flex-1 flex items-center justify-center p-6 sm:p-10 relative">

        {{-- Mobile logo --}}
        <div class="absolute top-6 left-1/2 -translate-x-1/2 lg:hidden flex items-center gap-3">
            <div class="w-9 h-9 rounded-xl bg-gradient-to-br from-blue-500 to-cyan-400 flex items-center justify-center shadow-lg shadow-blue-500/25">
                <span class="text-white font-extrabold text-base leading-none">A</span>
            </div>
            <div>
                <h1 class="font-extrabold text-white text-sm leading-none tracking-tight">AML Dashboard</h1>
                <p class="text-blue-300/60 text-[10px] font-medium">AML/CFT System</p>
            </div>
        </div>

        {{-- Form card --}}
        <div class="w-full max-w-[440px] animate-slide-up">

            {{-- Card header --}}
            <div class="mb-6">
                <div class="inline-flex items-center gap-2 px-3 py-1.5 rounded-full bg-blue-500/10 border border-blue-500/20 mb-4">
                    <div class="w-1.5 h-1.5 rounded-full bg-blue-400 animate-pulse"></div>
                    <span class="text-blue-300 text-[11px] font-semibold tracking-wider uppercase">Secure Access</span>
                </div>
                <h2 class="text-2xl xl:text-3xl font-extrabold text-slate-800 leading-tight">Sign in to your<br>account</h2>
                <p class="text-slate-400 text-sm mt-2">Enter your credentials to access the dashboard</p>
            </div>

            {{-- Error alert --}}
            @if($errors->any())
            <div class="mb-4 flex items-start gap-3 px-4 py-3 bg-red-50 border border-red-200/80 rounded-2xl">
                <div class="w-8 h-8 rounded-xl bg-red-100 flex items-center justify-center flex-shrink-0">
                    <svg class="w-4 h-4 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </div>
                <div>
                    <p class="text-red-600 text-sm font-semibold">Authentication failed</p>
                    <p class="text-red-400 text-xs mt-0.5">{{ $errors->first() }}</p>
                </div>
            </div>
            @endif

            {{-- Form --}}
            <form method="POST" action="{{ route('login') }}" x-data="{ loading: false, showPass: false }" @submit="loading = true" class="glass bg-white/80 border border-white/60 rounded-3xl shadow-xl shadow-slate-900/5 p-8 space-y-5">

                @csrf

                {{-- Email field --}}
                <div class="space-y-1.5">
                    <label class="text-[11px] font-bold text-slate-500 uppercase tracking-wider" for="email">Email Address</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                            <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207"/>
                            </svg>
                        </div>
                        <input
                            id="email"
                            name="email"
                            type="email"
                            value="{{ old('email') }}"
                            required
                            autofocus
                            autocomplete="email"
                            placeholder="name@company.com"
                            class="w-full pl-12 pr-4 py-3.5 bg-white border border-slate-200 rounded-2xl text-sm text-slate-700 placeholder-slate-300 focus:outline-none focus:border-blue-400 input-glow transition-all @error('email') border-red-400 bg-red-50/30 @enderror"
                        >
                    </div>
                    @error('email')
                    <p class="text-[11px] text-red-500 flex items-center gap-1.5">
                        <svg class="w-3.5 h-3.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/></svg>
                        {{ $message }}
                    </p>
                    @enderror
                </div>

                {{-- Password field --}}
                <div class="space-y-1.5">
                    <div class="flex items-center justify-between">
                        <label class="text-[11px] font-bold text-slate-500 uppercase tracking-wider" for="password">Password</label>
                    </div>
                    <div class="relative" x-data="{ show: false }">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                            <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                            </svg>
                        </div>
                        <input
                            id="password"
                            name="password"
                            :type="show ? 'text' : 'password'"
                            required
                            autocomplete="current-password"
                            placeholder="••••••••"
                            class="w-full pl-12 pr-12 py-3.5 bg-white border border-slate-200 rounded-2xl text-sm text-slate-700 placeholder-slate-300 focus:outline-none focus:border-blue-400 input-glow transition-all @error('password') border-red-400 @enderror"
                        >
                        <button type="button" @click="show = !show" class="absolute inset-y-0 right-0 pr-4 flex items-center text-slate-400 hover:text-slate-600 transition-colors">
                            <svg x-show="!show" x-cloak class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                            </svg>
                            <svg x-show="show" x-cloak class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.542-7a10.025 10.025 0 014.132-5.411m0 0L21 21"/>
                            </svg>
                        </button>
                    </div>
                    @error('password')
                    <p class="text-[11px] text-red-500 flex items-center gap-1.5">
                        <svg class="w-3.5 h-3.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/></svg>
                        {{ $message }}
                    </p>
                    @enderror
                </div>

                {{-- Submit button --}}
                <button
                    type="submit"
                    :disabled="loading"
                    class="relative w-full py-3.5 text-white text-sm font-bold rounded-2xl overflow-hidden btn-shimmer btn-hover
                       shadow-lg shadow-blue-600/30"
                    style="background: linear-gradient(135deg, #1d4ed8 0%, #3b82f6 50%, #0ea5e9 100%);"
                >
                    <span :class="loading ? 'opacity-0' : 'opacity-100'" class="flex items-center justify-center gap-2 transition-all duration-200">
                        Sign In
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
                        </svg>
                    </span>
                    <span x-show="loading" x-cloak class="absolute inset-0 flex items-center justify-center">
                        <svg class="w-5 h-5 animate-spin" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"/>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"/>
                        </svg>
                    </span>
                </button>
            </form>

            {{-- Demo accounts --}}
            <div class="mt-4 glass bg-white/60 border border-white/60 rounded-2xl p-5">
                <p class="text-[11px] font-bold text-slate-400 uppercase tracking-widest mb-3 text-center">Quick Demo Access</p>
                <div class="grid grid-cols-3 gap-2.5">
                    @foreach([
                        ['email' => 'superadmin@amlo.com', 'role' => 'Head Office', 'accent' => 'purple'],
                        ['email' => 'lead@amlo.com', 'role' => 'Team Lead', 'accent' => 'blue'],
                        ['email' => 'amlo@amlo.com', 'role' => 'Officer', 'accent' => 'emerald'],
                    ] as $acc)
                    <button
                        type="button"
                        onclick="document.getElementById('email').value='{{ $acc['email'] }}';document.getElementById('password').focus();"
                        class="demo-btn p-3 rounded-2xl border text-center border-slate-200/80 hover:border-{{ $acc['accent'] }}-300 hover:bg-{{ $acc['accent'] }}-50/50 backdrop-blur-sm
                        @if($acc['accent'] === 'purple')
                           bg-purple-50/30 text-purple-600 hover:bg-purple-50 hover:shadow-sm
                        @elseif($acc['accent'] === 'blue')
                           bg-blue-50/30 text-blue-600 hover:bg-blue-50 hover:shadow-sm
                        @else
                           bg-emerald-50/30 text-emerald-600 hover:bg-emerald-50 hover:shadow-sm
                        @endif"
                    >
                        <p class="text-[11px] font-bold leading-tight">{{ $acc['role'] }}</p>
                        <p class="text-[9px] text-slate-400 mt-0.5 leading-tight font-mono">{{ explode('@', $acc['email'])[0] }}</p>
                    </button>
                    @endforeach
                </div>
                <p class="text-center text-[10px] text-slate-400 mt-3 font-medium">Password for all: <span class="font-mono text-blue-600 font-semibold">password</span></p>
            </div>

        </div>
    </div>
</div>

</body>
</html>