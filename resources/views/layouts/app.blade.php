<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title ?? 'Mono Coffee' }} - Coffee Shop</title>
    <link href="https://fonts.googleapis.com/css2?family=Be+Vietnam+Pro:ital,wght@0,300;0,400;0,500;0,600;0,700;0,800;1,300;1,400;1,500;1,600;1,700;1,800&family=Playfair+Display:ital,wght@0,600;0,700;0,800;1,600&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary: #c2410c;
            --primary-light: #ea580c;
            --primary-hover: #9a3412;
            --bg: #fbfbfb;
            --bg-card: #ffffff;
            --bg-subtle: #f5f5f4;
            --text: #1c1917;
            --text-dim: #57534e;
            --text-muted: #a8a29e;
            --border: #e7e5e4;
            --border-strong: #d6d3d1;
            --danger: #dc2626;
            --success: #16a34a;
            --warning: #d97706;
            --info: #2563eb;
            --shadow-sm: 0 1px 2px rgba(0,0,0,0.02), 0 1px 3px rgba(0,0,0,0.03);
            --shadow: 0 4px 20px rgba(0,0,0,0.03), 0 2px 8px rgba(0,0,0,0.02);
            --shadow-lg: 0 20px 48px rgba(194,65,12,0.06), 0 4px 16px rgba(0,0,0,0.02);
            --radius: 0.75rem;
            --radius-lg: 1rem;
        }
        * { margin:0; padding:0; box-sizing:border-box; }
        body { font-family:'Be Vietnam Pro',sans-serif; background:var(--bg); color:var(--text); line-height:1.6; min-height:100vh; -webkit-font-smoothing:antialiased; }

        /* ====== NAVBAR ====== */
        nav {
            background:rgba(255,255,255,0.85);
            backdrop-filter:blur(20px);
            -webkit-backdrop-filter:blur(20px);
            border-bottom:1px solid rgba(231,229,228,0.7);
            padding:0;
            position:sticky;
            top:0;
            z-index:200;
            box-shadow:var(--shadow-sm);
        }
        .nav-inner {
            max-width:1200px;
            margin:0 auto;
            padding:0 2rem;
            display:flex;
            justify-content:space-between;
            align-items:center;
            height:72px;
        }
        .logo {
            display:flex;
            align-items:center;
            gap:0.75rem;
            text-decoration:none;
        }
        .logo img {
            height:44px;
            width:auto;
            display:block;
        }
        .logo-text {
            font-family:'Playfair Display',serif;
            font-size:1.35rem;
            font-weight:800;
            color:var(--primary);
            letter-spacing:0.2px;
        }
        .nav-links {
            display:flex;
            align-items:center;
            gap:0.5rem;
        }
        .nav-link {
            color:var(--text-dim);
            text-decoration:none;
            font-size:0.92rem;
            font-weight:500;
            padding:0.6rem 1rem;
            border-radius:0.75rem;
            transition:all 0.25s cubic-bezier(0.4, 0, 0.2, 1);
            position:relative;
        }
        .nav-link:hover { background:var(--bg-subtle); color:var(--text); }
        .nav-link.active { background:rgba(194,65,12,0.06); color:var(--primary); font-weight:600; }
        .nav-link.admin-link {
            background:var(--bg-subtle);
            border:1px solid var(--border);
            font-size:0.85rem;
        }
        .nav-link.admin-link:hover { border-color:var(--primary); color:var(--primary); background:white; }
        .cart-bubble {
            display:inline-flex;
            align-items:center;
            gap:0.5rem;
            background:var(--primary);
            color:white;
            padding:0.6rem 1.2rem;
            border-radius:9999px;
            font-size:0.9rem;
            font-weight:600;
            text-decoration:none;
            transition:all 0.25s cubic-bezier(0.4, 0, 0.2, 1);
            box-shadow:0 4px 12px rgba(194,65,12,0.2);
        }
        .cart-bubble:hover { background:var(--primary-hover); transform:translateY(-1px); box-shadow:0 6px 20px rgba(194,65,12,0.3); }
        .cart-count {
            background:white;
            color:var(--primary);
            border-radius:50%;
            width:20px;
            height:20px;
            display:inline-flex;
            align-items:center;
            justify-content:center;
            font-size:0.75rem;
            font-weight:800;
        }
        .btn-logout {
            background:none;
            border:1px solid var(--border);
            color:var(--text-dim);
            padding:0.6rem 1.1rem;
            border-radius:0.75rem;
            cursor:pointer;
            font-size:0.9rem;
            font-weight:500;
            transition:all 0.25s;
            font-family:inherit;
        }
        .btn-logout:hover { border-color:var(--danger); color:var(--danger); background:rgba(220,38,38,0.03); }

        /* ====== ADMIN BADGE ====== */
        .admin-badge {
            display:inline-flex;
            align-items:center;
            background:rgba(194,65,12,0.06);
            color:var(--primary);
            border:1px solid rgba(194,65,12,0.15);
            border-radius:9999px;
            padding:0.3rem 0.85rem;
            font-size:0.78rem;
            font-weight:700;
            letter-spacing:0.5px;
            text-transform:uppercase;
        }

        /* ====== LAYOUT ====== */
        .container { max-width:1200px; margin:0 auto; padding:2.5rem 2rem; }
        .main-content { padding-top:1.5rem; }

        /* ====== ADMIN PANEL BAR ====== */
        .admin-top-bar {
            background:linear-gradient(135deg, var(--primary) 0%, var(--primary-light) 100%);
            color:white;
            padding:0.75rem 0;
            font-size:0.88rem;
            font-weight:500;
            box-shadow:var(--shadow-sm);
        }
        .admin-bar-inner {
            max-width:1200px;
            margin:0 auto;
            padding:0 2rem;
            display:flex;
            align-items:center;
            justify-content:space-between;
            flex-wrap:wrap;
            gap:1rem;
        }
        .admin-nav-pills { display:flex; gap:0.5rem; flex-wrap:wrap; }
        .admin-pill {
            color:white;
            text-decoration:none;
            padding:0.4rem 1rem;
            border-radius:9999px;
            font-size:0.85rem;
            font-weight:600;
            transition:all 0.2s;
            border:1px solid rgba(255,255,255,0.3);
        }
        .admin-pill:hover { background:rgba(255,255,255,0.2); color:white; border-color:rgba(255,255,255,0.6); }
        .admin-pill.active { background:white; color:var(--primary); font-weight:700; box-shadow:var(--shadow-sm); border-color:white; }

        /* ====== CARDS ====== */
        .card {
            background:var(--bg-card);
            border:1px solid rgba(231,229,228,0.8);
            border-radius:var(--radius-lg);
            padding:2rem;
            box-shadow:var(--shadow);
        }
        .card-header {
            display:flex;
            justify-content:space-between;
            align-items:center;
            margin-bottom:1.75rem;
            padding-bottom:1.25rem;
            border-bottom:1px solid var(--border);
        }
        .card-title { font-size:1.2rem; font-weight:700; color:var(--text); }

        /* ====== FORMS ====== */
        .form-group { margin-bottom:1.5rem; }
        label {
            display:block;
            font-size:0.8rem;
            font-weight:700;
            color:var(--text-dim);
            margin-bottom:0.5rem;
            text-transform:uppercase;
            letter-spacing:0.5px;
        }
        label.check-item {
            display:flex;
            align-items:center;
            gap:0.6rem;
            text-transform:none;
            letter-spacing:0;
            font-weight:500;
            font-size:0.92rem;
            cursor:pointer;
            color:var(--text);
        }
        input[type="text"],input[type="email"],input[type="password"],
        input[type="number"],input[type="tel"],input[type="url"],input[type="search"],
        select, textarea {
            width:100%;
            background:#fdfdfd;
            border:1.5px solid var(--border);
            color:var(--text);
            padding:0.75rem 1.1rem;
            border-radius:0.75rem;
            font-size:0.92rem;
            font-family:inherit;
            outline:none;
            transition:all 0.25s cubic-bezier(0.4, 0, 0.2, 1);
        }
        input:focus, select:focus, textarea:focus {
            border-color:var(--primary);
            background:white;
            box-shadow:0 0 0 4px rgba(194,65,12,0.08);
        }
        textarea { resize:vertical; min-height:100px; }
        select option { background:white; }
        .error-text { color:var(--danger); font-size:0.8rem; margin-top:0.35rem; display:block; }

        /* ====== BUTTONS ====== */
        .btn {
            display:inline-flex;
            align-items:center;
            justify-content:center;
            gap:0.5rem;
            padding:0.75rem 1.6rem;
            border-radius:0.75rem;
            font-weight:600;
            font-size:0.92rem;
            cursor:pointer;
            transition:all 0.25s cubic-bezier(0.4, 0, 0.2, 1);
            text-decoration:none;
            border:none;
            font-family:inherit;
            white-space:nowrap;
        }
        .btn-primary { background:var(--primary); color:white; box-shadow:0 4px 12px rgba(194,65,12,0.18); }
        .btn-primary:hover { background:var(--primary-hover); transform:translateY(-1px); box-shadow:0 6px 18px rgba(194,65,12,0.28); }
        .btn-success { background:var(--success); color:white; box-shadow:0 4px 12px rgba(22,163,74,0.15); }
        .btn-success:hover { opacity:0.95; transform:translateY(-1px); }
        .btn-danger { background:var(--danger); color:white; box-shadow:0 4px 12px rgba(220,38,38,0.15); }
        .btn-danger:hover { opacity:0.95; transform:translateY(-1px); }
        .btn-outline { background:transparent; border:1.5px solid var(--border); color:var(--text-dim); }
        .btn-outline:hover { border-color:var(--primary); color:var(--primary); background:rgba(194,65,12,0.02); }
        .btn-sm { padding:0.5rem 1.1rem; font-size:0.85rem; border-radius:0.6rem; }
        .btn-xs { padding:0.35rem 0.8rem; font-size:0.78rem; border-radius:0.5rem; }

        /* ====== TABLES ====== */
        .table-wrapper { overflow-x:auto; border-radius:var(--radius); border:1px solid var(--border); background:white; }
        table { width:100%; border-collapse:collapse; font-size:0.92rem; }
        thead { background:var(--bg-subtle); }
        th {
            text-align:left;
            padding:1rem 1.25rem;
            color:var(--text-dim);
            font-weight:700;
            font-size:0.75rem;
            text-transform:uppercase;
            letter-spacing:0.8px;
            border-bottom:1px solid var(--border);
        }
        td { padding:1.2rem 1.25rem; border-bottom:1px solid var(--border); color:var(--text); vertical-align:middle; }
        tbody tr:last-child td { border-bottom:none; }
        tbody tr:hover { background:rgba(245,245,244,0.4); }

        /* ====== BADGES ====== */
        .badge {
            display:inline-flex;
            align-items:center;
            padding:0.25rem 0.75rem;
            border-radius:9999px;
            font-size:0.78rem;
            font-weight:700;
        }
        .badge-admin { background:rgba(194,65,12,0.08); color:var(--primary); border:1px solid rgba(194,65,12,0.15); }
        .badge-user { background:rgba(120,113,108,0.08); color:var(--text-dim); border:1px solid var(--border); }
        .badge-pending { background:rgba(217,119,6,0.08); color:var(--warning); border:1px solid rgba(217,119,6,0.15); }
        .badge-processing { background:rgba(37,99,235,0.08); color:var(--info); border:1px solid rgba(37,99,235,0.15); }
        .badge-completed { background:rgba(22,163,74,0.08); color:var(--success); border:1px solid rgba(22,163,74,0.15); }
        .badge-cancelled { background:rgba(220,38,38,0.08); color:var(--danger); border:1px solid rgba(220,38,38,0.15); }

        /* ====== ALERTS ====== */
        .alert { padding:1rem 1.25rem; border-radius:0.75rem; margin-bottom:1.75rem; font-size:0.92rem; display:flex; align-items:center; gap:0.6rem; }
        .alert-success { background:rgba(22,163,74,0.06); color:#15803d; border:1px solid rgba(22,163,74,0.2); }
        .alert-danger { background:rgba(220,38,38,0.06); color:var(--danger); border:1px solid rgba(220,38,38,0.2); }

        /* ====== PRODUCT GRID ====== */
        .product-grid { display:grid; grid-template-columns:repeat(5, 1fr); gap:1.5rem; }
        .product-card {
            background:var(--bg-card);
            border:1px solid rgba(231,229,228,0.7);
            border-radius:var(--radius-lg);
            overflow:hidden;
            display:flex;
            flex-direction:column;
            height:100%;
            transition:all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            box-shadow:var(--shadow-sm);
        }
        .product-card:hover { transform:translateY(-6px); box-shadow:var(--shadow-lg); border-color:rgba(194,65,12,0.15); }
        .product-card-img {
            width:100%;
            height:200px;
            background:var(--bg-subtle);
            display:flex;
            align-items:center;
            justify-content:center;
            font-size:3.5rem;
            overflow:hidden;
            position:relative;
            padding:0.75rem;
        }
        .product-card-img img { width:100%; height:100%; object-fit:contain; transition:transform 0.4s cubic-bezier(0.4, 0, 0.2, 1); }
        .product-card:hover .product-card-img img { transform:scale(1.06); }
        .product-card-body { padding:1.5rem; display:flex; flex-direction:column; flex-grow:1; }
        .product-category { font-size:0.75rem; color:var(--primary); font-weight:700; text-transform:uppercase; letter-spacing:0.8px; margin-bottom:0.5rem; }
        .product-card-body h3 { font-size:1.1rem; margin-bottom:0.5rem; font-weight:700; line-height:1.3; }
        .product-card-body h3 a { color:var(--text); text-decoration:none; transition:color 0.2s; }
        .product-card-body h3 a:hover { color:var(--primary); }
        .product-price { font-size:1.25rem; font-weight:800; color:var(--primary); margin-bottom:1rem; }

        /* ====== SEARCH BAR ====== */
        .search-bar { display:flex; gap:1rem; margin-bottom:2.5rem; flex-wrap:wrap; align-items:center; }
        .search-bar input[type="search"] { flex:1; min-width:260px; }
        .search-bar select { width:auto; min-width:200px; }

        /* ====== PAGINATION ====== */
        .pagination-wrap { margin-top:2.5rem; display:flex; justify-content:center; }
        .pagination-wrap ul {
            list-style: none !important;
            padding: 0 !important;
            margin: 0 !important;
            display: flex !important;
            gap: 0.25rem !important;
            align-items: center;
        }
        .pagination-wrap li {
            list-style: none !important;
            padding: 0 !important;
            margin: 0 !important;
        }
        .pagination-wrap nav span, .pagination-wrap nav a,
        .pagination-wrap ul li span, .pagination-wrap ul li a {
            display:inline-block; padding:0.6rem 1rem; margin:0 0.15rem; border-radius:0.5rem;
            font-size:0.88rem; text-decoration:none; border:1px solid var(--border);
            color:var(--text-dim); background:white; transition:all 0.2s;
        }
        .pagination-wrap nav span.current, .pagination-wrap nav a:hover,
        .pagination-wrap ul li span.current, .pagination-wrap ul li a:hover,
        .pagination-wrap ul li.active span {
            background:var(--primary); color:white; border-color:var(--primary); box-shadow:var(--shadow-sm);
        }

        /* ====== CHECKBOX ====== */
        .check-group { display:flex; flex-wrap:wrap; gap:1rem; }
        .check-item input[type="checkbox"], .check-item input[type="radio"] { width:auto; accent-color:var(--primary); cursor:pointer; }

        /* ====== HELPERS ====== */
        .flex { display:flex; }
        .flex-between { display:flex; justify-content:space-between; align-items:center; }
        .flex-center { display:flex; align-items:center; justify-content:center; }
        .gap-1 { gap:0.5rem; } .gap-2 { gap:1rem; } .gap-3 { gap:1.5rem; }
        .mt-1 { margin-top:0.5rem; } .mt-2 { margin-top:1rem; } .mt-3 { margin-top:1.5rem; } .mt-4 { margin-top:2rem; }
        .mb-1 { margin-bottom:0.5rem; } .mb-2 { margin-bottom:1rem; } .mb-3 { margin-bottom:1.5rem; } .mb-4 { margin-bottom:2rem; }
        .text-dim { color:var(--text-dim); } .text-muted { color:var(--text-muted); }
        .text-sm { font-size:0.88rem; } .text-xs { font-size:0.75rem; }
        .font-bold { font-weight:700; } .font-black { font-weight:800; }
        .page-title { font-size:1.85rem; font-weight:800; color:var(--text); letter-spacing:-0.3px; }
        .page-sub { color:var(--text-dim); font-size:0.95rem; margin-top:0.35rem; }

        /* ====== THUMBNAIL IN TABLE ====== */
        .product-thumb {
            width:54px; height:54px; border-radius:0.5rem; object-fit:cover;
            border:1px solid var(--border); background:var(--bg-subtle);
        }
        .product-thumb-placeholder {
            width:54px; height:54px; border-radius:0.5rem; background:linear-gradient(135deg,#fef3c7,#fed7aa);
            display:flex; align-items:center; justify-content:center; font-size:1.5rem;
            border:1px solid var(--border);
        }

        /* ====== FOOTER ====== */
        footer {
            background:var(--bg-card);
            border-top:1px solid var(--border);
            margin-top:5rem;
            padding:3rem 0;
        }
        .footer-inner {
            max-width:1200px;
            margin:0 auto;
            padding:0 2rem;
            display:flex;
            justify-content:space-between;
            align-items:center;
            flex-wrap:wrap;
            gap:1.5rem;
        }
        .footer-brand { display:flex; align-items:center; gap:0.75rem; }
        .footer-brand img { height:36px; width:auto; display:block; }
        .footer-copy { font-size:0.88rem; color:var(--text-muted); }

        @media (max-width: 1200px) {
            .product-grid { grid-template-columns:repeat(4, 1fr); gap:1.25rem; }
        }
        @media (max-width: 992px) {
            .product-grid { grid-template-columns:repeat(3, 1fr); gap:1.25rem; }
        }
        @media (max-width: 768px) {
            .nav-inner { padding:0 1.25rem; height:64px; }
            .container { padding:2rem 1.25rem; }
            .product-grid { grid-template-columns:repeat(2, 1fr); gap:1rem; }
            .search-bar { flex-direction:column; gap:0.75rem; }
            .search-bar input[type="search"], .search-bar select, .search-bar button { width:100% !important; }
            .admin-nav-pills { gap:0.35rem; }
            .footer-inner { flex-direction:column; text-align:center; }
        }
        @media (max-width: 480px) {
            .product-grid { grid-template-columns:repeat(1, 1fr); }
        }
    </style>
    @stack('styles')
</head>
<body>
    {{-- Admin top bar --}}
    @auth
        @if(auth()->user()->role === 'admin' && request()->is('admin*'))
        <div class="admin-top-bar">
            <div class="admin-bar-inner">
                <span style="font-weight: 700; display: inline-flex; align-items: center; gap: 0.4rem;">
                    <svg style="width: 16px; height: 16px; fill: none; stroke: currentColor; stroke-width: 2;" viewBox="0 0 24 24"><path d="M12 15a3 3 0 100-6 3 3 0 000 6z"></path><path d="M19.4 15a1.65 1.65 0 00.33 1.82l.06.06a2 2 0 11-2.83 2.83l-.06-.06a1.65 1.65 0 00-1.82-.33 1.65 1.65 0 00-1 1.51V21a2 2 0 01-4 0v-.09A1.65 1.65 0 009 19.4a1.65 1.65 0 00-1.82.33l-.06.06a2 2 0 11-2.83-2.83l.06-.06a1.65 1.65 0 00.33-1.82 1.65 1.65 0 00-1.51-1H3a2 2 0 010-4h.09A1.65 1.65 0 004.6 9a1.65 1.65 0 00-.33-1.82l-.06-.06a2 2 0 112.83-2.83l.06.06a1.65 1.65 0 001.82.33H9a1.65 1.65 0 001-1.51V3a2 2 0 014 0v.09a1.65 1.65 0 001 1.51 1.65 1.65 0 001.82-.33l.06-.06a2 2 0 112.83 2.83l-.06.06a1.65 1.65 0 00-.33 1.82V9a1.65 1.65 0 001.51 1H21a2 2 0 010 4h-.09a1.65 1.65 0 00-1.51 1z"></path></svg>
                    Quản trị hệ thống
                </span>
                <div class="admin-nav-pills">
                    <a href="{{ route('admin.users.index') }}" class="admin-pill {{ request()->is('admin/users*') ? 'active' : '' }}">Tài khoản</a>
                    <a href="{{ route('admin.categories.index') }}" class="admin-pill {{ request()->is('admin/categories*') ? 'active' : '' }}">Danh mục</a>
                    <a href="{{ route('admin.products.index') }}" class="admin-pill {{ request()->is('admin/products*') ? 'active' : '' }}">Sản phẩm</a>
                    <a href="{{ route('admin.orders.index') }}" class="admin-pill {{ request()->is('admin/orders*') ? 'active' : '' }}">Đơn hàng</a>
                </div>
            </div>
        </div>
        @endif
    @endauth

    <nav>
        <div class="nav-inner">
            <a href="{{ route('front.home') }}" class="logo">
                <img src="{{ asset('img/logo/logo-monocoffee.png') }}" alt="Mono Coffee">
            </a>
            <div class="nav-links">
                <a href="{{ route('front.home') }}" class="nav-link {{ request()->routeIs('front.home') ? 'active' : '' }}">Trang chủ</a>
                <a href="{{ route('front.shop') }}" class="nav-link {{ request()->routeIs('front.shop') ? 'active' : '' }}">Thực đơn</a>
                <a href="{{ route('front.bestsellers') }}" class="nav-link {{ request()->routeIs('front.bestsellers') ? 'active' : '' }}">Bán chạy</a>

                @php 
                    $cartCount = 0;
                    if(auth()->check()) {
                        $cartModel = \App\Models\Cart::where('user_id', auth()->id())->first();
                        if ($cartModel) {
                            $cartCount = $cartModel->items()->sum('quantity');
                        }
                    } else {
                        $cartCount = collect(session('cart', []))->sum('quantity'); 
                    }
                @endphp
                <a href="{{ route('cart.index') }}" class="cart-bubble">
                    <svg style="width: 16px; height: 16px; fill: none; stroke: currentColor; stroke-width: 2.5;" viewBox="0 0 24 24"><path d="M6 2L3 6v14a2 2 0 002 2h14a2 2 0 002-2V6l-3-4H6zM3 6h18M16 10a4 4 0 01-8 0"></path></svg>
                    Giỏ hàng
                    @if($cartCount > 0)
                        <span class="cart-count">{{ $cartCount }}</span>
                    @endif
                </a>

                @auth
                    @if(auth()->user()->role === 'admin')
                        <span class="admin-badge">Admin</span>
                        @if(!request()->is('admin*'))
                            <a href="{{ route('admin.products.index') }}" class="nav-link admin-link" style="display: inline-flex; align-items: center; gap: 0.35rem;">
                                <svg style="width: 14px; height: 14px; fill: none; stroke: currentColor; stroke-width: 2;" viewBox="0 0 24 24"><path d="M12 15a3 3 0 100-6 3 3 0 000 6z"></path><path d="M19.4 15a1.65 1.65 0 00.33 1.82l.06.06a2 2 0 11-2.83 2.83l-.06-.06a1.65 1.65 0 00-1.82-.33 1.65 1.65 0 00-1 1.51V21a2 2 0 01-4 0v-.09A1.65 1.65 0 009 19.4a1.65 1.65 0 00-1.82.33l-.06.06a2 2 0 11-2.83-2.83l.06-.06a1.65 1.65 0 00.33-1.82 1.65 1.65 0 00-1.51-1H3a2 2 0 010-4h.09A1.65 1.65 0 004.6 9a1.65 1.65 0 00-.33-1.82l-.06-.06a2 2 0 112.83-2.83l.06.06a1.65 1.65 0 001.82.33H9a1.65 1.65 0 001-1.51V3a2 2 0 014 0v.09a1.65 1.65 0 001 1.51 1.65 1.65 0 001.82-.33l.06-.06a2 2 0 112.83 2.83l-.06.06a1.65 1.65 0 00-.33 1.82V9a1.65 1.65 0 001.51 1H21a2 2 0 010 4h-.09a1.65 1.65 0 00-1.51 1z"></path></svg>
                                Quản trị
                            </a>
                        @else
                            <a href="{{ route('front.home') }}" class="nav-link admin-link" style="display: inline-flex; align-items: center; gap: 0.35rem;">
                                <svg style="width: 14px; height: 14px; fill: none; stroke: currentColor; stroke-width: 2;" viewBox="0 0 24 24"><path d="M3 9l9-7 9 7v11a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"></path><path d="M9 22V12h6v10"></path></svg>
                                Cửa hàng
                            </a>
                        @endif
                    @endif
                    <a href="{{ route('dashboard') }}" class="nav-link {{ request()->is('info') ? 'active' : '' }}" style="display: inline-flex; align-items: center; gap: 0.4rem;">
                        <div style="width: 26px; height: 26px; background: var(--bg-subtle); border-radius: 50%; display: flex; align-items: center; justify-content: center; color: var(--primary);">
                            <svg style="width: 14px; height: 14px; fill: none; stroke: currentColor; stroke-width: 2.5;" viewBox="0 0 24 24"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7" r="4"></circle></svg>
                        </div>
                        Thông tin
                    </a>
                    <form action="{{ route('logout') }}" method="POST" style="display:inline;">
                        @csrf
                        <button type="submit" class="btn-logout">Đăng xuất</button>
                    </form>
                @else
                    <a href="{{ route('login') }}" class="nav-link">Đăng nhập</a>
                    <a href="{{ route('register') }}" class="btn btn-primary btn-sm">Đăng ký</a>
                @endauth
            </div>
        </div>
    </nav>

    <main class="container main-content">
        @if(session('success'))
            <div class="alert alert-success" style="display: flex; align-items: center; gap: 0.5rem;">
                <svg style="width: 18px; height: 18px; fill: none; stroke: currentColor; stroke-width: 2.5;" viewBox="0 0 24 24"><path d="M22 11.08V12a10 10 0 11-5.93-9.14"></path><path d="M22 4L12 14.01l-3-3"></path></svg>
                <span>{{ session('success') }}</span>
            </div>
        @endif
        @if(session('error'))
            <div class="alert alert-danger" style="display: flex; align-items: center; gap: 0.5rem;">
                <svg style="width: 18px; height: 18px; fill: none; stroke: currentColor; stroke-width: 2.5;" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"></circle><line x1="15" y1="9" x2="9" y2="15"></line><line x1="9" y1="9" x2="15" y2="15"></line></svg>
                <span>{{ session('error') }}</span>
            </div>
        @endif

        @yield('content')
    </main>

    <footer>
        <div class="footer-inner">
            <div class="footer-brand">
                <img src="{{ asset('img/logo/logo-monocoffee.png') }}" alt="Mono Coffee">
            </div>
            <p class="footer-copy">© {{ date('Y') }} Mono Coffee House · Hương vị nguyên bản, khơi nguồn cảm hứng</p>
        </div>
    </footer>

    @stack('scripts')
</body>
</html>