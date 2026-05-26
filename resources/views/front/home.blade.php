@extends('layouts.app')
@section('content')

    {{-- Banner Section --}}
    <div style="border-radius: 1.5rem; overflow: hidden; box-shadow: var(--shadow); margin-bottom: 3rem; width: 100%;">
        <img src="{{ asset('img/banner/banner2.png') }}" alt="Mono Coffee Banner" style="width: 100%; display: block; max-height: 420px; object-fit: cover;">
    </div>

    {{-- Bestsellers Section --}}
    <div style="margin-bottom: 2rem; display: flex; align-items: flex-end; justify-content: space-between; flex-wrap: wrap; gap: 1rem;">
        <div>
            <h2 style="font-size: 2rem; font-weight: 800; color: var(--text-main); display: inline-flex; align-items: center; gap: 0.6rem; margin-bottom: 0.25rem;">
                <svg style="width: 28px; height: 28px; fill: none; stroke: var(--primary); stroke-width: 2.5;" viewBox="0 0 24 24">
                    <polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon>
                </svg>
                Sản phẩm bán chạy
            </h2>
            <p style="color: var(--text-dim); font-size: 0.95rem;">Những tách cà phê được yêu thích nhất tại Mono Coffee</p>
        </div>
        @if($hasMore)
        <a href="{{ route('front.bestsellers') }}" style="display: inline-flex; align-items: center; gap: 0.4rem; color: var(--primary); font-weight: 700; font-size: 0.95rem; text-decoration: none; border: 1.5px solid var(--primary); padding: 0.55rem 1.2rem; border-radius: 9999px; transition: all 0.2s;" onmouseover="this.style.background='var(--primary)';this.style.color='white'" onmouseout="this.style.background='transparent';this.style.color='var(--primary)'">
            Xem thêm
            <svg style="width: 16px; height: 16px; fill: none; stroke: currentColor; stroke-width: 2.5;" viewBox="0 0 24 24"><path d="M5 12h14M12 5l7 7-7 7"></path></svg>
        </a>
        @endif
    </div>

    @if($displayBestsellers->count())
        <div class="product-grid" style="margin-bottom: 3rem;">
            @foreach($displayBestsellers as $product)
                <div class="product-card">
                    <div class="product-card-img" style="position: relative;">
                        @if($product->image_url)
                            <img src="{{ $product->image_url }}" alt="{{ $product->name }}">
                        @else
                            <div style="width:100%;height:100%;display:flex;align-items:center;justify-content:center;background:var(--bg-subtle);">
                                <svg style="width: 48px; height: 48px; fill: none; stroke: var(--text-muted); stroke-width: 1.5;" viewBox="0 0 24 24"><path d="M18 8h1a4 4 0 010 8h-1M2 8h16v9a4 4 0 01-4 4H6a4 4 0 01-4-4V8z"></path></svg>
                            </div>
                        @endif
                        <span style="position: absolute; top: 0.6rem; left: 0.6rem; background: var(--primary); color: white; font-size: 0.65rem; font-weight: 700; padding: 0.25rem 0.6rem; border-radius: 9999px; text-transform: uppercase; letter-spacing: 0.5px; display: inline-flex; align-items: center; gap: 0.25rem;">
                            <svg style="width: 10px; height: 10px; fill: white; stroke: none;" viewBox="0 0 24 24"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon></svg>
                            Best Seller
                        </span>
                    </div>
                    <div class="product-card-body">
                        <p class="product-category">{{ $product->category->name ?? 'N/A' }}</p>
                        <h3><a href="{{ route('front.product.show', $product->slug) }}">{{ $product->name }}</a></h3>
                        <div style="margin-top: auto; padding-top: 0.5rem;">
                            <p class="product-price" style="margin-bottom: 0.75rem;">{{ number_format($product->base_price) }}đ</p>
                            <a href="{{ route('front.product.show', $product->slug) }}" class="btn btn-primary btn-sm" style="width: 100%; display: inline-flex; align-items: center; justify-content: center; gap: 0.35rem; text-decoration: none;">
                                <svg style="width: 14px; height: 14px; fill: none; stroke: currentColor; stroke-width: 2.5;" viewBox="0 0 24 24"><path d="M6 2L3 6v14a2 2 0 002 2h14a2 2 0 002-2V6l-3-4H6zM3 6h18M16 10a4 4 0 01-8 0"></path></svg>
                                Chọn tuỳ chọn
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>


    @else
        <div class="card" style="text-align:center; padding:4rem 2rem; border: 2px dashed var(--border);">
            <svg style="width: 56px; height: 56px; fill: none; stroke: var(--text-muted); stroke-width: 1.5; margin: 0 auto 1rem auto; display: block;" viewBox="0 0 24 24">
                <polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon>
            </svg>
            <p style="font-weight: 700; font-size: 1.1rem; margin-bottom: 0.5rem; color: var(--text);">Chưa có sản phẩm bán chạy</p>
            <p class="text-dim text-sm">Quản trị viên có thể đánh dấu sản phẩm Best Seller trong trang quản lý.</p>
            <a href="{{ route('front.shop') }}" class="btn btn-primary" style="margin-top: 1.5rem; border-radius: 9999px;">Xem tất cả sản phẩm</a>
        </div>
    @endif

@endsection
