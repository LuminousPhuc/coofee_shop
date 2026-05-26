@extends('layouts.app')
@section('content')

    <div style="margin-bottom: 2rem; display: flex; align-items: flex-end; justify-content: space-between; flex-wrap: wrap; gap: 1rem;">
        <div>
            <h1 style="font-size: 2rem; font-weight: 800; color: var(--text-main); display: inline-flex; align-items: center; gap: 0.6rem; margin-bottom: 0.25rem;">
                <svg style="width: 26px; height: 26px; fill: none; stroke: var(--primary); stroke-width: 2.5;" viewBox="0 0 24 24">
                    <path d="M18 8h1a4 4 0 010 8h-1M2 8h16v9a4 4 0 01-4 4H6a4 4 0 01-4-4V8z"></path>
                </svg>
                Thực đơn đồ uống
            </h1>
            <p style="color: var(--text-dim); font-size: 0.95rem;">Trải nghiệm những hương vị quyến rũ được pha chế tỉ mỉ</p>
        </div>
        <a href="{{ route('front.home') }}" style="display: inline-flex; align-items: center; gap: 0.35rem; color: var(--text-dim); font-size: 0.88rem; text-decoration: none;">
            <svg style="width: 14px; height: 14px; fill: none; stroke: currentColor; stroke-width: 2;" viewBox="0 0 24 24"><path d="M19 12H5M12 19l-7-7 7-7"></path></svg>
            Về trang chủ
        </a>
    </div>

@push('styles')
    <style>
        /* Custom Dropdown Styling */
        .custom-dropdown {
            position: relative;
            display: inline-block;
            min-width: 220px;
        }
        .dropdown-btn {
            width: 100%;
            height: 100%;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 0.75rem;
            background: #fdfdfd;
            border: 1.5px solid var(--border);
            color: var(--text);
            padding: 0.75rem 1.1rem;
            border-radius: 0.75rem;
            font-size: 0.92rem;
            font-family: inherit;
            cursor: pointer;
            text-align: left;
            transition: all 0.25s;
        }
        .dropdown-btn:hover {
            border-color: var(--primary);
            background: white;
        }
        .dropdown-menu-list {
            display: none;
            position: absolute;
            top: 100%;
            left: 0;
            right: 0;
            background: white;
            border: 1.5px solid var(--border);
            border-radius: 0.75rem;
            box-shadow: var(--shadow-lg);
            z-index: 1000;
            overflow: hidden;
            animation: dropdownFadeIn 0.2s cubic-bezier(0.16, 1, 0.3, 1);
        }
        .dropdown-menu-list a {
            display: block;
            padding: 0.7rem 1.1rem;
            color: var(--text-dim);
            text-decoration: none;
            font-size: 0.9rem;
            font-weight: 500;
            transition: all 0.15s;
        }
        .dropdown-menu-list a:hover {
            background: var(--bg-subtle);
            color: var(--primary);
            padding-left: 1.3rem;
        }
        .dropdown-menu-list a.active {
            background: rgba(194,65,12,0.06);
            color: var(--primary);
            font-weight: 700;
        }
        .custom-dropdown:hover .dropdown-menu-list {
            display: block;
        }
        .custom-dropdown:hover .dropdown-btn svg {
            transform: rotate(180deg);
        }
        @keyframes dropdownFadeIn {
            from { opacity: 0; transform: translateY(8px); }
            to { opacity: 1; transform: translateY(0); }
        }
    </style>
@endpush

    {{-- Search & Filter --}}
    <form action="{{ route('front.shop') }}" method="GET" class="search-bar" style="align-items: stretch;">
        <input type="search" name="search" value="{{ request('search') }}" placeholder="Tìm kiếm sản phẩm...">
        
        {{-- Custom Categories Hover Dropdown --}}
        <div class="custom-dropdown">
            <button type="button" class="dropdown-btn">
                <span>{{ $categories->firstWhere('id', request('category_id'))->name ?? 'Tất cả danh mục' }}</span>
                <svg style="width: 12px; height: 12px; fill: none; stroke: currentColor; stroke-width: 2.5; transition: transform 0.2s;" viewBox="0 0 24 24"><path d="M6 9l6 6 6-6"></path></svg>
            </button>
            <div class="dropdown-menu-list">
                <a href="{{ route('front.shop', ['search' => request('search')]) }}" class="{{ !request('category_id') ? 'active' : '' }}">Tất cả danh mục</a>
                @foreach($categories as $cat)
                    <a href="{{ route('front.shop', ['category_id' => $cat->id, 'search' => request('search')]) }}" class="{{ request('category_id') == $cat->id ? 'active' : '' }}">{{ $cat->name }}</a>
                @endforeach
            </div>
        </div>

        <button type="submit" class="btn btn-primary">Tìm kiếm</button>
        @if(request('search') || request('category_id'))
            <a href="{{ route('front.shop') }}" class="btn btn-outline" style="display: inline-flex; align-items: center;">Xóa bộ lọc</a>
        @endif
    </form>

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
                        @if($product->is_bestseller)
                        <span style="position: absolute; top: 0.6rem; left: 0.6rem; background: var(--primary); color: white; font-size: 0.65rem; font-weight: 700; padding: 0.25rem 0.6rem; border-radius: 9999px; text-transform: uppercase; letter-spacing: 0.5px; display: inline-flex; align-items: center; gap: 0.25rem;">
                            <svg style="width: 10px; height: 10px; fill: white; stroke: none;" viewBox="0 0 24 24"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon></svg>
                            Best Seller
                        </span>
                        @endif
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
        <div class="card" style="text-align:center; padding:3rem;">
            <svg style="width: 48px; height: 48px; fill: none; stroke: var(--text-muted); stroke-width: 1.5; margin: 0 auto 1rem auto; display: block;" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"></circle><path d="M8 15h8"></path><circle cx="9" cy="9" r="1"></circle><circle cx="15" cy="9" r="1"></circle></svg>
            <p>Không tìm thấy sản phẩm nào.</p>
        </div>
    @endif

@endsection
