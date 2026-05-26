@extends('layouts.app')
@section('content')

<style>
.auth-wrap {
    max-width: 420px;
    margin: 3.5rem auto;
}
.auth-card {
    background: var(--bg-card);
    border: 1px solid var(--border);
    border-radius: 1.25rem;
    padding: 2.5rem;
}
.auth-logo {
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 0.6rem;
    margin-bottom: 2rem;
    text-align: center;
}
.auth-logo-icon {
    width: 56px;
    height: 56px;
    background: rgba(var(--primary-rgb, 212,149,90), 0.12);
    border: 1.5px solid rgba(var(--primary-rgb, 212,149,90), 0.25);
    border-radius: 1rem;
    display: flex;
    align-items: center;
    justify-content: center;
}
.auth-title {
    font-size: 1.4rem;
    font-weight: 800;
    color: var(--text-primary);
    margin: 0;
}
.auth-subtitle {
    font-size: 0.85rem;
    color: var(--text-muted);
    margin: 0;
}
.auth-field {
    margin-bottom: 1.1rem;
}
.auth-label {
    display: block;
    font-size: 0.78rem;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 0.4px;
    color: var(--text-muted);
    margin-bottom: 0.4rem;
}
.auth-input {
    width: 100%;
    padding: 0.65rem 0.9rem;
    border: 1.5px solid var(--border);
    border-radius: 0.6rem;
    background: var(--bg-subtle);
    color: var(--text-primary);
    font-size: 0.9rem;
    transition: border-color 0.15s, box-shadow 0.15s;
    box-sizing: border-box;
    font-family: inherit;
}
.auth-input:focus {
    outline: none;
    border-color: var(--primary);
    box-shadow: 0 0 0 3px rgba(var(--primary-rgb, 212,149,90), 0.15);
}
.auth-input.is-invalid {
    border-color: #ef4444;
    box-shadow: 0 0 0 3px rgba(239,68,68,0.12);
}
.auth-field-error {
    display: none;
    align-items: center;
    gap: 0.3rem;
    color: #ef4444;
    font-size: 0.78rem;
    font-weight: 500;
    margin-top: 0.35rem;
}
.auth-field-error.visible {
    display: flex;
}
.auth-remember {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    margin-bottom: 1.25rem;
}
.auth-remember input[type=checkbox] {
    width: 16px;
    height: 16px;
    accent-color: var(--primary);
    cursor: pointer;
}
.auth-remember label {
    font-size: 0.85rem;
    color: var(--text-secondary);
    cursor: pointer;
    margin: 0;
}
.auth-submit {
    width: 100%;
    padding: 0.85rem;
    border-radius: 0.7rem;
    background: var(--primary);
    color: white;
    border: none;
    font-size: 0.95rem;
    font-weight: 700;
    cursor: pointer;
    transition: all 0.2s ease;
    font-family: inherit;
    letter-spacing: 0.3px;
}
.auth-submit:hover {
    opacity: 0.9;
    transform: translateY(-1px);
    box-shadow: 0 6px 20px rgba(0,0,0,0.2);
}
.auth-divider {
    display: flex;
    align-items: center;
    gap: 0.75rem;
    margin: 1.5rem 0;
    color: var(--text-muted);
    font-size: 0.8rem;
}
.auth-divider::before, .auth-divider::after {
    content: '';
    flex: 1;
    height: 1px;
    background: var(--border);
}
.auth-footer {
    text-align: center;
    font-size: 0.85rem;
    color: var(--text-muted);
}
.auth-footer a {
    color: var(--primary);
    text-decoration: none;
    font-weight: 700;
}
.auth-footer a:hover { text-decoration: underline; }
.server-error {
    background: rgba(239,68,68,0.08);
    border: 1px solid rgba(239,68,68,0.25);
    border-radius: 0.6rem;
    padding: 0.75rem 1rem;
    color: #ef4444;
    font-size: 0.85rem;
    margin-bottom: 1.25rem;
    display: flex;
    align-items: center;
    gap: 0.5rem;
}
</style>

<div class="auth-wrap">
    <div class="auth-card">
        {{-- Logo / Header --}}
        <div class="auth-logo">
            <div class="auth-logo-icon">
                <svg style="width:28px;height:28px;fill:none;stroke:var(--primary);stroke-width:2;" viewBox="0 0 24 24">
                    <path d="M18 8h1a4 4 0 010 8h-1M2 8h16v9a4 4 0 01-4 4H6a4 4 0 01-4-4V8z"/>
                    <line x1="6" y1="2" x2="6" y2="8"/><line x1="10" y1="2" x2="10" y2="8"/><line x1="14" y1="2" x2="14" y2="8"/>
                </svg>
            </div>
            <div>
                <h1 class="auth-title">Đăng nhập</h1>
                <p class="auth-subtitle">Chào mừng trở lại Mono Coffee House</p>
            </div>
        </div>

        {{-- Server errors --}}
        @if($errors->any())
            <div class="server-error">
                <svg style="width:15px;height:15px;flex-shrink:0;fill:none;stroke:currentColor;stroke-width:2.5;" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
                {{ $errors->first() }}
            </div>
        @endif

        <form action="{{ route('login') }}" method="POST" id="loginForm" novalidate>
            @csrf

            {{-- Email --}}
            <div class="auth-field">
                <label class="auth-label" for="email">Địa chỉ Email</label>
                <input type="email" name="email" id="email"
                    class="auth-input @error('email') is-invalid @enderror"
                    value="{{ old('email') }}"
                    autofocus>
                <div class="auth-field-error @error('email') visible @enderror" id="err_email">
                    <svg style="width:12px;height:12px;flex-shrink:0;fill:none;stroke:currentColor;stroke-width:2.5;" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
                    <span>@error('email'){{ $message }}@else Vui lòng nhập email hợp lệ @enderror</span>
                </div>
            </div>

            {{-- Password --}}
            <div class="auth-field">
                <label class="auth-label" for="password">Mật khẩu</label>
                <input type="password" name="password" id="password"
                    class="auth-input @error('password') is-invalid @enderror">
                <div class="auth-field-error @error('password') visible @enderror" id="err_password">
                    <svg style="width:12px;height:12px;flex-shrink:0;fill:none;stroke:currentColor;stroke-width:2.5;" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
                    <span>Vui lòng nhập mật khẩu</span>
                </div>
            </div>

            {{-- Remember me --}}
            <div class="auth-remember">
                <input type="checkbox" id="remember" name="remember">
                <label for="remember">Ghi nhớ đăng nhập</label>
            </div>

            <button type="submit" class="auth-submit">
                Đăng nhập
            </button>
        </form>

        <div class="auth-divider">hoặc</div>

        <div class="auth-footer">
            Chưa có tài khoản?
            <a href="{{ route('register') }}">Đăng ký ngay</a>
        </div>
    </div>
</div>

<script>
(function() {
    const form = document.getElementById('loginForm');
    if (!form) return;
    const emailEl    = document.getElementById('email');
    const pwEl       = document.getElementById('password');
    const errEmail   = document.getElementById('err_email');
    const errPw      = document.getElementById('err_password');

    function setError(input, errDiv, show) {
        input.classList.toggle('is-invalid', show);
        errDiv.classList.toggle('visible', show);
    }

    form.addEventListener('submit', function(e) {
        let valid = true;
        if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(emailEl.value.trim())) {
            setError(emailEl, errEmail, true); valid = false;
        } else setError(emailEl, errEmail, false);
        if (pwEl.value.length < 1) {
            setError(pwEl, errPw, true); valid = false;
        } else setError(pwEl, errPw, false);
        if (!valid) e.preventDefault();
    });

    [emailEl, pwEl].forEach(el => {
        el.addEventListener('input', () => el.classList.remove('is-invalid'));
    });
})();
</script>

@endsection