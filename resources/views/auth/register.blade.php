@extends('layouts.app')
@section('content')

@push('styles')
<style>
/* Reuse auth styles from login */
.auth-wrap { max-width: 420px; margin: 3rem auto; }
.auth-card { background: var(--bg-card); border: 1px solid var(--border); border-radius: 1.25rem; padding: 2.5rem; }
.auth-logo { display: flex; flex-direction: column; align-items: center; gap: 0.6rem; margin-bottom: 2rem; text-align: center; }
.auth-logo-icon { width: 56px; height: 56px; background: rgba(var(--primary-rgb,212,149,90),0.12); border: 1.5px solid rgba(var(--primary-rgb,212,149,90),0.25); border-radius: 1rem; display: flex; align-items: center; justify-content: center; }
.auth-title { font-size: 1.4rem; font-weight: 800; color: var(--text-primary); margin: 0; }
.auth-subtitle { font-size: 0.85rem; color: var(--text-muted); margin: 0; }
.auth-field { margin-bottom: 1.1rem; }
.auth-label { display: block; font-size: 0.78rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.4px; color: var(--text-muted); margin-bottom: 0.4rem; }
.auth-input { width: 100%; padding: 0.65rem 0.9rem; border: 1.5px solid var(--border); border-radius: 0.6rem; background: var(--bg-subtle); color: var(--text-primary); font-size: 0.9rem; transition: border-color 0.15s, box-shadow 0.15s; box-sizing: border-box; font-family: inherit; }
.auth-input:focus { outline: none; border-color: var(--primary); box-shadow: 0 0 0 3px rgba(var(--primary-rgb,212,149,90),0.15); }
.auth-input.is-invalid { border-color: #ef4444; box-shadow: 0 0 0 3px rgba(239,68,68,0.12); }
.auth-field-error { display: none; align-items: center; gap: 0.3rem; color: #ef4444; font-size: 0.78rem; font-weight: 500; margin-top: 0.35rem; }
.auth-field-error.visible { display: flex; }
.auth-submit { width: 100%; padding: 0.85rem; border-radius: 0.7rem; background: var(--primary); color: white; border: none; font-size: 0.95rem; font-weight: 700; cursor: pointer; transition: all 0.2s ease; font-family: inherit; letter-spacing: 0.3px; }
.auth-submit:hover { opacity: 0.9; transform: translateY(-1px); box-shadow: 0 6px 20px rgba(0,0,0,0.2); }
.auth-divider { display: flex; align-items: center; gap: 0.75rem; margin: 1.5rem 0; color: var(--text-muted); font-size: 0.8rem; }
.auth-divider::before, .auth-divider::after { content: ''; flex: 1; height: 1px; background: var(--border); }
.auth-footer { text-align: center; font-size: 0.85rem; color: var(--text-muted); }
.auth-footer a { color: var(--primary); text-decoration: none; font-weight: 700; }
.auth-footer a:hover { text-decoration: underline; }
.server-error { background: rgba(239,68,68,0.08); border: 1px solid rgba(239,68,68,0.25); border-radius: 0.6rem; padding: 0.75rem 1rem; color: #ef4444; font-size: 0.85rem; margin-bottom: 1.25rem; display: flex; align-items: center; gap: 0.5rem; }
.pw-strength { height: 4px; border-radius: 9999px; margin-top: 0.4rem; background: var(--border); overflow: hidden; display: none; }
.pw-strength-bar { height: 100%; border-radius: 9999px; transition: width 0.3s, background 0.3s; width: 0; }
.pw-hint { font-size: 0.72rem; color: var(--text-muted); margin-top: 0.25rem; display: none; }
</style>
@endpush

<div class="auth-wrap">
    <div class="auth-card">
        {{-- Header --}}
        <div class="auth-logo">
            <div class="auth-logo-icon">
                <svg style="width:28px;height:28px;fill:none;stroke:var(--primary);stroke-width:2;" viewBox="0 0 24 24">
                    <path d="M16 21v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2"/>
                    <circle cx="8.5" cy="7" r="4"/>
                    <line x1="20" y1="8" x2="20" y2="14"/>
                    <line x1="23" y1="11" x2="17" y2="11"/>
                </svg>
            </div>
            <div>
                <h1 class="auth-title">Tạo tài khoản</h1>
                <p class="auth-subtitle">Đăng ký để trải nghiệm đặt hàng dễ dàng hơn</p>
            </div>
        </div>

        {{-- Server errors --}}
        @if($errors->any())
            <div class="server-error">
                <svg style="width:15px;height:15px;flex-shrink:0;fill:none;stroke:currentColor;stroke-width:2.5;" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
                {{ $errors->first() }}
            </div>
        @endif

        <form action="{{ route('register') }}" method="POST" id="registerForm" novalidate>
            @csrf

            {{-- Họ tên --}}
            <div class="auth-field">
                <label class="auth-label" for="name">Họ và tên</label>
                <input type="text" name="name" id="name"
                    class="auth-input @error('name') is-invalid @enderror"
                    value="{{ old('name') }}"
                    autofocus>
                <div class="auth-field-error @error('name') visible @enderror" id="err_name">
                    <svg style="width:12px;height:12px;flex-shrink:0;fill:none;stroke:currentColor;stroke-width:2.5;" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
                    <span>@error('name'){{ $message }}@else Vui lòng nhập họ và tên @enderror</span>
                </div>
            </div>

            {{-- Email --}}
            <div class="auth-field">
                <label class="auth-label" for="email">Địa chỉ Email</label>
                <input type="email" name="email" id="email"
                    class="auth-input @error('email') is-invalid @enderror"
                    value="{{ old('email') }}">
                <div class="auth-field-error @error('email') visible @enderror" id="err_email">
                    <svg style="width:12px;height:12px;flex-shrink:0;fill:none;stroke:currentColor;stroke-width:2.5;" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
                    <span>@error('email'){{ $message }}@else Vui lòng nhập email hợp lệ @enderror</span>
                </div>
            </div>

            {{-- Mật khẩu --}}
            <div class="auth-field">
                <label class="auth-label" for="password">Mật khẩu</label>
                <input type="password" name="password" id="password"
                    class="auth-input @error('password') is-invalid @enderror">
                <div class="pw-strength"><div class="pw-strength-bar" id="pwBar"></div></div>
                <div class="pw-hint" id="pwHint">Nhập mật khẩu để kiểm tra độ mạnh</div>
                <div class="auth-field-error @error('password') visible @enderror" id="err_password">
                    <svg style="width:12px;height:12px;flex-shrink:0;fill:none;stroke:currentColor;stroke-width:2.5;" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
                    <span>@error('password'){{ $message }}@else Mật khẩu tối thiểu 6 ký tự @enderror</span>
                </div>
            </div>

            {{-- Xác nhận mật khẩu --}}
            <div class="auth-field">
                <label class="auth-label" for="password_confirmation">Xác nhận mật khẩu</label>
                <input type="password" name="password_confirmation" id="password_confirmation"
                    class="auth-input">
                <div class="auth-field-error" id="err_confirm">
                    <svg style="width:12px;height:12px;flex-shrink:0;fill:none;stroke:currentColor;stroke-width:2.5;" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
                    <span>Mật khẩu xác nhận không khớp</span>
                </div>
            </div>

            <button type="submit" class="auth-submit">
                Tạo tài khoản
            </button>
        </form>

        <div class="auth-divider">hoặc</div>

        <div class="auth-footer">
            Đã có tài khoản?
            <a href="{{ route('login') }}">Đăng nhập ngay</a>
        </div>
    </div>
</div>

<script>
(function() {
    const form   = document.getElementById('registerForm');
    const nameEl = document.getElementById('name');
    const emailEl= document.getElementById('email');
    const pwEl   = document.getElementById('password');
    const cfEl   = document.getElementById('password_confirmation');
    const pwBar  = document.getElementById('pwBar');
    const pwHint = document.getElementById('pwHint');

    // Password strength meter
    pwEl.addEventListener('input', function() {
        const v = this.value;
        const pwStrengthEl = document.querySelector('.pw-strength');
        
        if (v.length > 0) {
            pwStrengthEl.style.display = 'block';
            pwHint.style.display = 'block';
        } else {
            pwStrengthEl.style.display = 'none';
            pwHint.style.display = 'none';
        }

        let score = 0;
        if (v.length >= 6) score++;
        if (v.length >= 10) score++;
        if (/[A-Z]/.test(v)) score++;
        if (/[0-9]/.test(v)) score++;
        if (/[^A-Za-z0-9]/.test(v)) score++;

        const pct   = Math.min(100, score * 20) + '%';
        const color = score <= 1 ? '#ef4444' : score <= 3 ? '#f59e0b' : '#4ade80';
        const label = score <= 1 ? 'Rất yếu' : score === 2 ? 'Yếu' : score === 3 ? 'Trung bình' : score === 4 ? 'Mạnh' : 'Rất mạnh';

        pwBar.style.width = pct;
        pwBar.style.background = color;
        pwHint.textContent = v.length > 0 ? 'Độ mạnh: ' + label : '';
        pwHint.style.color = v.length > 0 ? color : 'var(--text-muted)';
    });

    function setError(el, errDiv, show) {
        el.classList.toggle('is-invalid', show);
        errDiv.classList.toggle('visible', show);
    }

    form.addEventListener('submit', function(e) {
        let valid = true;

        if (nameEl.value.trim().length < 2) {
            setError(nameEl, document.getElementById('err_name'), true); valid = false;
        } else setError(nameEl, document.getElementById('err_name'), false);

        if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(emailEl.value.trim())) {
            setError(emailEl, document.getElementById('err_email'), true); valid = false;
        } else setError(emailEl, document.getElementById('err_email'), false);

        if (pwEl.value.length < 6) {
            setError(pwEl, document.getElementById('err_password'), true); valid = false;
        } else setError(pwEl, document.getElementById('err_password'), false);

        if (cfEl.value !== pwEl.value) {
            setError(cfEl, document.getElementById('err_confirm'), true); valid = false;
        } else setError(cfEl, document.getElementById('err_confirm'), false);

        if (!valid) e.preventDefault();
    });

    [nameEl, emailEl, pwEl, cfEl].forEach(el => {
        el.addEventListener('input', () => el.classList.remove('is-invalid'));
    });
})();
</script>

@endsection