<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Login - AMLO Dashboard')</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        :root {
            --primary: #0857C3;
            --secondary: #71C5E8;
            --text: #0F172A;
            --muted: #64748B;
            --bg: #FFFFFF;
            --card: #FFFFFF;
            --border: #DCE8F7;
        }

        body {
            font-family: 'Inter', sans-serif;
            background: var(--bg);
            color: var(--text);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 12px;
        }

        .wrapper { width: 100%; max-width: 326px; }

        .card {
            background: var(--card);
            border: 1px solid var(--border);
            border-radius: 19px;
            padding: 19px 14px;
            box-shadow: 0 5px 20px rgba(8, 87, 195, 0.08);
        }

        .title {
            text-align: center;
            font-size: clamp(1.36rem, 2.8vw, 2.18rem);
            line-height: 1.1;
            font-weight: 800;
            color: var(--primary);
            margin-bottom: 9.5px;
        }

        .subtitle {
            text-align: center;
            color: var(--muted);
            font-size: 0.646rem;
            line-height: 1.7;
            margin-bottom: 23px;
        }

        .section-label {
            text-align: center;
            color: var(--primary);
            font-size: 0.49rem;
            font-weight: 700;
            letter-spacing: 2px;
            margin-bottom: 12px;
        }

        .roles {
            display: flex;
            flex-direction: column;
            gap: 9.5px;
            margin-bottom: 18px;
        }

        .role-card {
            display: flex;
            align-items: flex-start;
            gap: 9.5px;
            padding: 11px;
            border-radius: 14px;
            border: 1px solid var(--border);
            background: #fff;
            cursor: pointer;
            transition: all .25s ease;
            user-select: none;
        }

        .role-card:hover {
            border-color: var(--secondary);
            transform: translateY(-1.4px);
            box-shadow: 0 5px 16px rgba(113, 197, 232, 0.15);
        }

        .role-card.active {
            border: 1px solid var(--primary);
            background: rgba(113, 197, 232, 0.08);
        }

        .icon-box {
            width: 36px;
            height: 36px;
            border-radius: 9.5px;
            flex-shrink: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            background: rgba(113, 197, 232, 0.18);
            font-size: 0.92rem;
        }

        .role-content { flex: 1; min-width: 0; }

        .role-title {
            font-size: 0.68rem;
            font-weight: 700;
            line-height: 1.35;
            margin-bottom: 2.7px;
        }

        .role-desc {
            font-size: 0.56rem;
            line-height: 1.55;
            color: var(--muted);
        }

        .field-group { margin-bottom: 11px; }

        .field-label {
            display: block;
            font-size: 0.49rem;
            font-weight: 700;
            color: var(--muted);
            letter-spacing: 1px;
            text-transform: uppercase;
            margin-bottom: 5.5px;
        }

        .field-input {
            width: 100%;
            padding: 9.5px 11px;
            border: 1px solid var(--border);
            border-radius: 9.5px;
            font-family: 'Inter', sans-serif;
            font-size: 0.61rem;
            color: var(--text);
            background: #fff;
            outline: none;
            transition: border-color .2s, box-shadow .2s;
        }

        .field-input:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 2px rgba(8, 87, 195, 0.1);
        }

        .field-input::placeholder { color: #b0bec5; }

        .password-wrap { position: relative; }

        .password-wrap .field-input { padding-right: 31px; }

        .password-toggle {
            position: absolute;
            right: 9.5px;
            top: 50%;
            transform: translateY(-50%);
            background: none;
            border: none;
            cursor: pointer;
            color: var(--muted);
            padding: 2.7px;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: color .2s;
        }

        .password-toggle:hover { color: var(--primary); }

        .login-btn {
            width: 100%;
            border: none;
            outline: none;
            background: var(--primary);
            color: #fff;
            border-radius: 12px;
            padding: 11px;
            font-family: 'Inter', sans-serif;
            font-size: 0.68rem;
            font-weight: 700;
            cursor: pointer;
            transition: all .25s ease;
            margin-top: 4px;
        }

        .login-btn:hover {
            background: #0649A5;
            transform: translateY(-1.4px);
            box-shadow: 0 5px 16px rgba(8, 87, 195, 0.3);
        }

        .login-btn:active { transform: translateY(0); }

        .error-msg {
            display: flex;
            align-items: center;
            gap: 4px;
            font-size: 0.53rem;
            color: #ef4444;
            margin-top: 4px;
            font-weight: 500;
        }

        .error-box {
            display: flex;
            align-items: flex-start;
            gap: 7px;
            padding: 8px 11px;
            background: #fef2f2;
            border: 0.7px solid #fecaca;
            border-radius: 9.5px;
            margin-bottom: 12px;
            font-size: 0.58rem;
            color: #ef4444;
        }

        .quick-note {
            text-align: center;
            font-size: 0.49rem;
            color: var(--muted);
            margin-top: 11px;
        }

        .quick-note span { font-weight: 700; color: var(--primary); }

        /* Tablet */
        @media (min-width: 768px) {
            body { padding: 22px; }
            .wrapper { max-width: 435px; }
            .card { padding: 33px 34px; border-radius: 23px; }
            .subtitle { font-size: 0.71rem; }
            .section-label { font-size: 0.53rem; }
            .roles { gap: 11px; }
            .role-card { padding: 14px; gap: 12px; }
            .icon-box { width: 45px; height: 45px; font-size: 1.05rem; }
            .role-title { font-size: 0.82rem; }
            .role-desc { font-size: 0.63rem; }
            .login-btn { padding: 12px; font-size: 0.75rem; }
        }
    </style>
</head>
<body>

<div class="wrapper">
    <div class="card">

        <h1 class="title">AMLO Activity Dashboard</h1>

        <p class="subtitle">
            Sistem Monitoring Aktivitas &amp; Kinerja Harian AMLO
        </p>

        <div class="section-label">— PILIH AKSES ROLE —</div>

        <div class="roles">
            <div class="role-card" id="role-officer" onclick="setRole('amlo@amlo.com')">
                <div class="icon-box">🎯</div>
                <div class="role-content">
                    <div class="role-title">AMLO Officer</div>
                    <div class="role-desc">Input aktivitas harian, laporan &amp; progress</div>
                </div>
            </div>
            <div class="role-card" id="role-lead" onclick="setRole('lead@amlo.com')">
                <div class="icon-box">📊</div>
                <div class="role-content">
                    <div class="role-title">AMLO Lead / Team Leader</div>
                    <div class="role-desc">Monitor tim, assign tugas, beri feedback</div>
                </div>
            </div>
            <div class="role-card" id="role-ho" onclick="setRole('superadmin@amlo.com')">
                <div class="icon-box">🏢</div>
                <div class="role-content">
                    <div class="role-title">Head Office Assurance</div>
                    <div class="role-desc">Overview seluruh wilayah, assessment &amp; audit</div>
                </div>
            </div>
        </div>

        {{-- Error alert --}}
        @if($errors->any())
        <div class="error-box">
            <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="flex-shrink:0;margin-top:1px">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            <span>{{ $errors->first() }}</span>
        </div>
        @endif

        <form method="POST" action="{{ route('login') }}" id="loginForm">
            @csrf

            <div class="field-group">
                <label class="field-label" for="email">Email Address</label>
                <input
                    id="email"
                    name="email"
                    type="email"
                    value="{{ old('email') }}"
                    required
                    autofocus
                    autocomplete="email"
                    placeholder="name@company.com"
                    class="field-input @error('email') border-red-400 @enderror"
                >
                @error('email')
                <p class="error-msg">
                    <svg width="13" height="13" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/></svg>
                    {{ $message }}
                </p>
                @enderror
            </div>

            <div class="field-group">
                <label class="field-label" for="password">Password</label>
                <div class="password-wrap">
                    <input
                        id="password"
                        name="password"
                        type="password"
                        required
                        autocomplete="current-password"
                        placeholder="••••••••"
                        class="field-input @error('password') border-red-400 @enderror"
                    >
                    <button type="button" class="password-toggle" onclick="togglePassword()">
                        <svg id="eye-icon" width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                        </svg>
                        <svg id="eye-off-icon" width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="display:none">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.542-7a10.025 10.025 0 014.132-5.411m0 0L21 21"/>
                        </svg>
                    </button>
                </div>
                @error('password')
                <p class="error-msg">
                    <svg width="13" height="13" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/></svg>
                    {{ $message }}
                </p>
                @enderror
            </div>

            <button type="submit" class="login-btn">Masuk Dashboard →</button>
        </form>

        <p class="quick-note">Password semua akun: <span>password</span></p>

    </div>
</div>

<script>
    let activeRole = 'officer';

    function setRole(role) {
        document.querySelectorAll('.role-card').forEach(c => c.classList.remove('active'));
        const map = {
            'amlo@amlo.com': 'officer',
            'lead@amlo.com': 'lead',
            'superadmin@amlo.com': 'ho'
        };
        const id = map[role];
        if (id) {
            document.getElementById('role-' + id).classList.add('active');
            activeRole = id;
        }
        document.getElementById('email').value = role;
        document.getElementById('password').focus();
    }

    document.getElementById('role-officer').classList.add('active');

    function togglePassword() {
        const input = document.getElementById('password');
        const eye = document.getElementById('eye-icon');
        const eyeOff = document.getElementById('eye-off-icon');
        if (input.type === 'password') {
            input.type = 'text';
            eye.style.display = 'none';
            eyeOff.style.display = 'block';
        } else {
            input.type = 'password';
            eye.style.display = 'block';
            eyeOff.style.display = 'none';
        }
    }
</script>

</body>
</html>