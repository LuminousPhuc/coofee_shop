@extends('layouts.app')
@section('content')

<style>
.thankyou-wrap {
    max-width: 560px;
    margin: 3rem auto;
    text-align: center;
}
.thankyou-icon {
    width: 88px;
    height: 88px;
    background: linear-gradient(135deg, rgba(74,222,128,0.15), rgba(74,222,128,0.05));
    border: 2px solid rgba(74,222,128,0.3);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 1.5rem;
    animation: scaleIn 0.4s ease;
}
@keyframes scaleIn {
    from { transform: scale(0.5); opacity: 0; }
    to { transform: scale(1); opacity: 1; }
}
.thankyou-title {
    font-size: 1.8rem;
    font-weight: 800;
    color: #4ade80;
    margin-bottom: 0.75rem;
}
.thankyou-desc {
    color: var(--text-muted);
    font-size: 0.95rem;
    line-height: 1.6;
    margin-bottom: 2rem;
}
.thankyou-actions {
    display: flex;
    gap: 0.75rem;
    justify-content: center;
}
</style>

<div class="thankyou-wrap">
    <div class="card" style="padding: 3rem 2rem;">
        <div class="thankyou-icon">
            <svg style="width:44px;height:44px;fill:none;stroke:#4ade80;stroke-width:2.2;" viewBox="0 0 24 24">
                <path d="M22 11.08V12a10 10 0 11-5.93-9.14"/>
                <polyline points="22 4 12 14.01 9 11.01"/>
            </svg>
        </div>
        <h1 class="thankyou-title">Đặt hàng thành công!</h1>
        <p class="thankyou-desc">
            Cảm ơn bạn đã tin tưởng và đặt hàng tại <strong>Mono Coffee House</strong>.<br>
            Chúng tôi sẽ xử lý và giao hàng đến bạn trong thời gian sớm nhất.
        </p>

        <div style="background:var(--bg-subtle);border:1px solid var(--border);border-radius:0.75rem;padding:1rem 1.25rem;margin-bottom:2rem;font-size:0.85rem;color:var(--text-muted);display:flex;align-items:center;gap:0.6rem;">
            <svg style="width:16px;height:16px;flex-shrink:0;fill:none;stroke:var(--primary);stroke-width:2;" viewBox="0 0 24 24"><path d="M22 16.92v3a2 2 0 01-2.18 2 19.79 19.79 0 01-8.63-3.07A19.5 19.5 0 013.07 9.81a19.79 19.79 0 01-3.07-8.72A2 2 0 012 .99h3a2 2 0 012 1.72c.127.96.361 1.903.7 2.81a2 2 0 01-.45 2.11L6.91 8.92a16 16 0 006.16 6.16l1.27-1.27a2 2 0 012.11-.45c.907.339 1.85.573 2.81.7A2 2 0 0122 16.92z"/></svg>
            Chúng tôi sẽ liên hệ xác nhận đơn hàng qua số điện thoại của bạn
        </div>

        <div class="thankyou-actions">
            <a href="{{ route('front.home') }}" class="btn btn-outline">
                <svg style="width:14px;height:14px;fill:none;stroke:currentColor;stroke-width:2.5;" viewBox="0 0 24 24"><path d="M3 9l9-7 9 7v11a2 2 0 01-2 2H5a2 2 0 01-2-2z"/><polyline points="9 22 9 12 15 12 15 22"/></svg>
                Về trang chủ
            </a>
            <a href="{{ route('front.shop') }}" class="btn btn-primary">
                <svg style="width:14px;height:14px;fill:none;stroke:currentColor;stroke-width:2.5;" viewBox="0 0 24 24"><path d="M18 8h1a4 4 0 010 8h-1M2 8h16v9a4 4 0 01-4 4H6a4 4 0 01-4-4V8z"/></svg>
                Tiếp tục mua sắm
            </a>
        </div>
    </div>
</div>

@endsection
