@extends('layouts.app')
@section('content')

<style>
    .about-container {
        max-width: 900px;
        margin: 2rem auto 4rem;
    }
    .about-hero {
        text-align: center;
        padding: 4rem 2rem;
        background: linear-gradient(135deg, rgba(194,65,12,0.06) 0%, rgba(251,146,60,0.02) 100%);
        border-radius: 2rem;
        border: 1px solid rgba(194,65,12,0.1);
        margin-bottom: 3rem;
        position: relative;
        overflow: hidden;
    }
    .about-hero::before {
        content: '';
        position: absolute;
        top: -50%;
        left: -50%;
        width: 200%;
        height: 200%;
        background: radial-gradient(circle, rgba(194,65,12,0.03) 0%, transparent 60%);
        pointer-events: none;
    }
    .about-logo-wrapper {
        width: 120px;
        height: 120px;
        background: var(--bg-card);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 1.5rem;
        box-shadow: var(--shadow-lg);
        border: 1px solid rgba(194,65,12,0.15);
        transition: transform 0.4s ease;
    }
    .about-logo-wrapper:hover {
        transform: scale(1.08) rotate(5deg);
    }
    .about-logo-wrapper img {
        width: 80px;
        height: auto;
    }
    .about-title {
        font-family: 'Playfair Display', serif;
        font-size: 2.5rem;
        font-weight: 800;
        color: var(--text);
        margin-bottom: 0.75rem;
    }
    .about-subtitle {
        color: var(--primary);
        font-weight: 700;
        letter-spacing: 1px;
        text-transform: uppercase;
        font-size: 0.9rem;
        margin-bottom: 1.5rem;
    }
    .about-desc {
        font-size: 1.05rem;
        color: var(--text-dim);
        max-width: 650px;
        margin: 0 auto;
        line-height: 1.7;
    }
    .about-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 2rem;
        margin-bottom: 3rem;
    }
    .about-card {
        background: var(--bg-card);
        border: 1px solid var(--border);
        border-radius: 1.5rem;
        padding: 2.25rem;
        box-shadow: var(--shadow-sm);
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        display: flex;
        flex-direction: column;
        gap: 1.25rem;
    }
    .about-card:hover {
        transform: translateY(-5px);
        box-shadow: var(--shadow-lg);
        border-color: rgba(194,65,12,0.2);
    }
    .about-card-icon {
        width: 46px;
        height: 46px;
        background: rgba(194,65,12,0.08);
        color: var(--primary);
        border-radius: 1rem;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    .about-card-title {
        font-size: 1.25rem;
        font-weight: 700;
        color: var(--text);
    }
    .about-card-text {
        font-size: 0.95rem;
        color: var(--text-dim);
        line-height: 1.6;
    }
    .contact-item {
        display: flex;
        align-items: flex-start;
        gap: 1rem;
        font-size: 0.95rem;
        color: var(--text-dim);
    }
    .contact-icon {
        color: var(--primary);
        flex-shrink: 0;
        margin-top: 0.15rem;
    }
    @media (max-width: 768px) {
        .about-grid {
            grid-template-columns: 1fr;
        }
        .about-title {
            font-size: 2rem;
        }
    }
</style>

<div class="about-container">
    {{-- Breadcrumb --}}
    <div style="margin-bottom: 2rem; display: flex; align-items: center; gap: 0.5rem; font-size: 0.9rem;">
        <a href="{{ route('dashboard') }}" style="color: var(--text-muted); text-decoration: none; transition: color 0.2s;">Trang cá nhân</a>
        <span style="color: var(--text-muted);">/</span>
        <span style="color: var(--primary); font-weight: 600;">Về chúng tôi</span>
    </div>

    {{-- Hero block --}}
    <div class="about-hero">
        <div class="about-logo-wrapper">
            <img src="{{ asset('img/logo/logo-monocoffee.png') }}" alt="Mono Coffee">
        </div>
        <h1 class="about-title">Mono Coffee House</h1>
        <div class="about-subtitle">Hương vị nguyên bản, khơi nguồn cảm hứng</div>
        <p class="about-desc">
            Chào mừng bạn đến với Mono Coffee House. Chúng tôi tự hào mang đến cho quý khách hàng những hạt cà phê đậm đà bản sắc Việt, kết hợp hoàn hảo cùng không gian trải nghiệm sang trọng và dịch vụ chuyên nghiệp hàng đầu.
        </p>
    </div>

    {{-- Details Grid --}}
    <div class="about-grid">
        <div class="about-card">
            <div class="about-card-icon">
                <svg style="width: 22px; height: 22px; fill: none; stroke: currentColor; stroke-width: 2.2;" viewBox="0 0 24 24">
                    <circle cx="12" cy="12" r="10"></circle>
                    <line x1="12" y1="16" x2="12" y2="12"></line>
                    <line x1="12" y1="8" x2="12.01" y2="8"></line>
                </svg>
            </div>
            <h2 class="about-card-title">Câu chuyện thương hiệu</h2>
            <p class="about-card-text">
                Mono Coffee bắt đầu từ ước mơ nâng tầm giá trị hạt cà phê Robusta và Arabica Việt Nam. Mỗi tách cà phê phục vụ quý khách đều trải qua quá trình tuyển chọn hạt nghiêm ngặt, rang xay thủ công tỉ mỉ để lưu giữ trọn vẹn tinh túy đất trời.
            </p>
        </div>

        <div class="about-card">
            <div class="about-card-icon">
                <svg style="width: 22px; height: 22px; fill: none; stroke: currentColor; stroke-width: 2.2;" viewBox="0 0 24 24">
                    <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0118 0z"></path>
                    <circle cx="12" cy="10" r="3"></circle>
                </svg>
            </div>
            <h2 class="about-card-title">Thông tin liên hệ</h2>
            <div style="display: flex; flex-direction: column; gap: 1rem;">
                <div class="contact-item">
                    <svg class="contact-icon" style="width: 16px; height: 16px; fill: none; stroke: currentColor; stroke-width: 2.5;" viewBox="0 0 24 24">
                        <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0118 0z"></path>
                    </svg>
                    <span>123 Đường Lê Lợi, Phường Bến Thành, Quận 1, Thành phố Hồ Chí Minh, Việt Nam</span>
                </div>
                <div class="contact-item">
                    <svg class="contact-icon" style="width: 16px; height: 16px; fill: none; stroke: currentColor; stroke-width: 2.5;" viewBox="0 0 24 24">
                        <path d="M22 16.92v3a2 2 0 01-2.18 2 19.79 19.79 0 01-8.63-3.07 19.5 19.5 0 01-6-6 19.79 19.79 0 01-3.07-8.67A2 2 0 014.11 2h3a2 2 0 012 1.72 12.84 12.84 0 00.7 2.81 2 2 0 01-.45 2.11L8.09 9.91a16 16 0 006 6l1.27-1.27a2 2 0 012.11-.45 12.84 12.84 0 002.81.7A2 2 0 0122 16.92z"></path>
                    </svg>
                    <span>Hotline: 1900 8888 (08:00 - 22:00)</span>
                </div>
                <div class="contact-item">
                    <svg class="contact-icon" style="width: 16px; height: 16px; fill: none; stroke: currentColor; stroke-width: 2.5;" viewBox="0 0 24 24">
                        <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path>
                        <polyline points="22,6 12,13 2,6"></polyline>
                    </svg>
                    <span>Email: contact@monocoffee.vn</span>
                </div>
            </div>
        </div>
    </div>

    {{-- Google Maps Embed --}}
    <div style="background: var(--bg-card); border: 1px solid var(--border); border-radius: 1.5rem; padding: 1.5rem; box-shadow: var(--shadow-sm); margin-bottom: 3rem;">
        <h3 style="font-size: 1.1rem; font-weight: 700; color: var(--text); margin-bottom: 1rem; display: flex; align-items: center; gap: 0.5rem;">
            <svg style="width: 18px; height: 18px; fill: none; stroke: var(--primary); stroke-width: 2.2;" viewBox="0 0 24 24">
                <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0118 0z"></path>
                <circle cx="12" cy="10" r="3"></circle>
            </svg>
            Vị trí trên Google Maps
        </h3>
        <div style="width: 100%; height: 350px; border-radius: 1rem; overflow: hidden; border: 1px solid var(--border);">
            <iframe 
                src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3919.4853036437937!2d106.69752187609204!3d10.774092459235889!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3919485303643793%3A0x10669752187609204!2zMTIzIMSQxrDhu51uZyBMw6ogTOG7o2ksIFBoxrDhu51uZyBC4bq_biBUaMOgbmgsIFF14bqtbiAxLCBUaMOgbmggcGjhu5EgSOG7kyBDaMOtIE1pbmgsIFZp4buHdCBOYW0!5e0!3m2!1svi!2s!4v1700000000000!5m2!1svi!2s" 
                width="100%" 
                height="100%" 
                style="border:0;" 
                allowfullscreen="" 
                loading="lazy" 
                referrerpolicy="no-referrer-when-downgrade">
            </iframe>
        </div>
    </div>

    {{-- Back button --}}
    <div style="text-align: center;">
        <a href="{{ route('dashboard') }}" class="btn btn-outline" style="border-radius: 9999px;">
            <svg style="width: 16px; height: 16px; fill: none; stroke: currentColor; stroke-width: 2.5;" viewBox="0 0 24 24">
                <line x1="19" y1="12" x2="5" y2="12"></line>
                <polyline points="12 19 5 12 12 5"></polyline>
            </svg>
            Quay lại trang cá nhân
        </a>
    </div>
</div>

@endsection
