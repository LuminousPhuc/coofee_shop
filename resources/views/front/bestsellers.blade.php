@extends('layouts.app')
@section('content')

    <div style="margin-bottom: 2rem; display: flex; align-items: flex-end; justify-content: space-between; flex-wrap: wrap; gap: 1rem;">
        <div>
            <h1 style="font-size: 2rem; font-weight: 800; color: var(--text-main); display: inline-flex; align-items: center; gap: 0.6rem; margin-bottom: 0.25rem;">
                <svg style="width: 26px; height: 26px; fill: none; stroke: var(--primary); stroke-width: 2.5;" viewBox="0 0 24 24">
                    <polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon>
                </svg>
                Sản phẩm bán chạy nhất
            </h1>
            <p style="color: var(--text-dim); font-size: 0.95rem;">Được yêu thích nhất và khuyên dùng tại cửa hàng</p>
        </div>
        <a href="{{ route('front.home') }}" style="display: inline-flex; align-items: center; gap: 0.35rem; color: var(--text-dim); font-size: 0.88rem; text-decoration: none;">
            <svg style="width: 14px; height: 14px; fill: none; stroke: currentColor; stroke-width: 2;" viewBox="0 0 24 24"><path d="M19 12H5M12 19l-7-7 7-7"></path></svg>
            Về trang chủ
        </a>
    </div>

    {{-- Categories filter --}}
    <div style="margin-bottom: 2rem; display: flex; gap: 0.5rem; flex-wrap: wrap; align-items: center;">
        <span style="font-size: 0.88rem; color: var(--text-dim); font-weight: 600; margin-right: 0.5rem;">Lọc danh mục:</span>
        <a href="{{ route('front.bestsellers') }}" class="btn {{ !request('category_id') ? 'btn-primary' : 'btn-outline' }} btn-sm" style="border-radius: 9999px;">Tất cả</a>
        @foreach($categories as $cat)
            <a href="{{ route('front.bestsellers', ['category_id' => $cat->id]) }}" class="btn {{ request('category_id') == $cat->id ? 'btn-primary' : 'btn-outline' }} btn-sm" style="border-radius: 9999px;">{{ $cat->name }}</a>
        @endforeach
    </div>

    {{-- Product Grid --}}
    @if($products->count())
        <div class="product-grid">
            @foreach($products as $product)
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

        <div class="pagination-wrap">
            {{ $products->links('pagination::bootstrap-4') }}
        </div>
    @else
        <div class="card" style="text-align:center; padding:4rem 2rem; border: 2px dashed var(--border);">
            <svg style="width: 56px; height: 56px; fill: none; stroke: var(--text-muted); stroke-width: 1.5; margin: 0 auto 1rem auto; display: block;" viewBox="0 0 24 24">
                <polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon>
            </svg>
            <p style="font-weight: 700; font-size: 1.1rem; margin-bottom: 0.5rem; color: var(--text);">Không tìm thấy sản phẩm bán chạy nào</p>
        </div>
    @endif

@endsection
