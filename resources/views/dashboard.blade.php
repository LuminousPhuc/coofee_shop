@extends('layouts.app')
@section('content')

<style>
.profile-grid {
    display: grid;
    grid-template-columns: 280px 1fr;
    gap: 1.75rem;
    align-items: start;
}
.profile-sidebar {
    background: var(--bg-card);
    border: 1px solid var(--border);
    border-radius: 1.25rem;
    overflow: hidden;
}
.profile-avatar-section {
    padding: 2rem;
    text-align: center;
    background: linear-gradient(135deg, rgba(var(--primary-rgb,212,149,90),0.08), transparent);
    border-bottom: 1px solid var(--border);
}
.profile-avatar {
    width: 80px;
    height: 80px;
    border-radius: 50%;
    background: rgba(var(--primary-rgb,212,149,90),0.12);
    border: 2px solid rgba(var(--primary-rgb,212,149,90),0.3);
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 1rem;
}
.profile-name {
    font-size: 1.1rem;
    font-weight: 700;
    color: var(--text-primary);
    margin-bottom: 0.25rem;
}
.profile-email {
    font-size: 0.8rem;
    color: var(--text-muted);
    word-break: break-all;
}
.profile-nav {
    padding: 0.75rem 0;
}
.profile-nav-item {
    display: flex;
    align-items: center;
    gap: 0.6rem;
    padding: 0.65rem 1.25rem;
    font-size: 0.875rem;
    color: var(--text-secondary);
    text-decoration: none;
    transition: all 0.15s;
}
.profile-nav-item:hover, .profile-nav-item.active {
    background: rgba(var(--primary-rgb,212,149,90),0.08);
    color: var(--primary);
}
.profile-nav-item svg { flex-shrink: 0; }

/* Main content */
.profile-main {}
.profile-section {
    background: var(--bg-card);
    border: 1px solid var(--border);
    border-radius: 1.25rem;
    overflow: hidden;
    margin-bottom: 1.5rem;
}
.profile-section-header {
    padding: 1.1rem 1.5rem;
    border-bottom: 1px solid var(--border);
    display: flex;
    align-items: center;
    gap: 0.6rem;
}
.profile-section-title {
    font-size: 0.9rem;
    font-weight: 700;
    color: var(--text-primary);
    margin: 0;
}
.profile-section-body {
    padding: 1.5rem;
}
.info-row {
    display: flex;
    align-items: center;
    padding: 0.75rem 0;
    border-bottom: 1px solid var(--border);
    font-size: 0.875rem;
    gap: 1rem;
}
.info-row:last-child { border-bottom: none; }
.info-label {
    width: 130px;
    flex-shrink: 0;
    font-size: 0.75rem;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 0.4px;
    color: var(--text-muted);
}
.info-value {
    color: var(--text-primary);
    font-weight: 500;
}

/* Orders table */
.orders-table {
    width: 100%;
    border-collapse: collapse;
    font-size: 0.875rem;
}
.orders-table th {
    padding: 0.7rem 1rem;
    font-size: 0.72rem;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 0.4px;
    color: var(--text-muted);
    text-align: left;
    background: var(--bg-subtle);
    border-bottom: 1px solid var(--border);
}
.orders-table td {
    padding: 0.85rem 1rem;
    border-bottom: 1px solid var(--border);
    color: var(--text-secondary);
    vertical-align: middle;
}
.orders-table tr:last-child td { border-bottom: none; }
.orders-table tr:hover td { background: var(--bg-subtle); }
.order-status {
    display: inline-flex;
    align-items: center;
    gap: 0.3rem;
    padding: 0.25rem 0.65rem;
    border-radius: 9999px;
    font-size: 0.72rem;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 0.3px;
}
.status-pending   { background: rgba(251,191,36,0.12); color: #fbbf24; }
.status-processing{ background: rgba(96,165,250,0.12); color: #60a5fa; }
.status-completed { background: rgba(74,222,128,0.12); color: #4ade80; }
.status-cancelled { background: rgba(248,113,113,0.12); color: #f87171; }

.stats-row {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 1rem;
    margin-bottom: 1.5rem;
}
.stat-card {
    background: var(--bg-card);
    border: 1px solid var(--border);
    border-radius: 1rem;
    padding: 1.25rem 1rem;
    text-align: center;
}
.stat-number {
    font-size: 1.75rem;
    font-weight: 800;
    color: var(--primary);
    line-height: 1;
    margin-bottom: 0.35rem;
}
.stat-label {
    font-size: 0.75rem;
    color: var(--text-muted);
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.4px;
}

@media (max-width: 900px) {
    .profile-grid { grid-template-columns: 1fr; }
    .stats-row { grid-template-columns: repeat(2, 1fr); }
}
</style>

<div class="profile-grid">

    {{-- SIDEBAR --}}
    <div class="profile-sidebar">
        <div class="profile-avatar-section">
            <div class="profile-avatar">
                <svg style="width:38px;height:38px;fill:none;stroke:var(--primary);stroke-width:1.8;" viewBox="0 0 24 24">
                    <path d="M20 21v-2a4 4 0 00-4-4H8a4 4 0 00-4 4v2"/>
                    <circle cx="12" cy="7" r="4"/>
                </svg>
            </div>
            <div class="profile-name">{{ $user->name }}</div>
            <div class="profile-email">{{ $user->email }}</div>
            <div style="margin-top:0.75rem;">
                <span class="badge badge-{{ $user->role === 'admin' ? 'admin' : 'user' }}">
                    {{ strtoupper($user->role) }}
                </span>
            </div>
        </div>
        <nav class="profile-nav">
            @php
                $activeTab = request()->query('tab', 'overview');
            @endphp
            <a href="{{ route('dashboard', ['tab' => 'overview']) }}" class="profile-nav-item {{ $activeTab === 'overview' ? 'active' : '' }}">
                <svg style="width:15px;height:15px;fill:none;stroke:currentColor;stroke-width:2.2;" viewBox="0 0 24 24"><path d="M3 9l9-7 9 7v11a2 2 0 01-2 2H5a2 2 0 01-2-2z"/><polyline points="9 22 9 12 15 12 15 22"/></svg>
                Tổng quan
            </a>
            <a href="{{ route('dashboard', ['tab' => 'addresses']) }}" class="profile-nav-item {{ $activeTab === 'addresses' ? 'active' : '' }}">
                <svg style="width:15px;height:15px;fill:none;stroke:currentColor;stroke-width:2.2;" viewBox="0 0 24 24"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0118 0z"/><circle cx="12" cy="10" r="3"/></svg>
                Sổ địa chỉ
            </a>
            <a href="{{ route('front.shop') }}" class="profile-nav-item">
                <svg style="width:15px;height:15px;fill:none;stroke:currentColor;stroke-width:2.2;" viewBox="0 0 24 24"><path d="M18 8h1a4 4 0 010 8h-1M2 8h16v9a4 4 0 01-4 4H6a4 4 0 01-4-4V8z"/></svg>
                Tiếp tục mua hàng
            </a>
            @if($user->role === 'admin')
            <a href="{{ route('admin.users.index') }}" class="profile-nav-item">
                <svg style="width:15px;height:15px;fill:none;stroke:currentColor;stroke-width:2.2;" viewBox="0 0 24 24"><path d="M12 20h9"/><path d="M16.5 3.5a2.121 2.121 0 013 3L7 19l-4 1 1-4L16.5 3.5z"/></svg>
                Quản trị hệ thống
            </a>
            @endif
            <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="profile-nav-item" style="color:#ef4444;">
                <svg style="width:15px;height:15px;fill:none;stroke:currentColor;stroke-width:2.2;" viewBox="0 0 24 24"><path d="M9 21H5a2 2 0 01-2-2V5a2 2 0 012-2h4"/><polyline points="16 17 21 12 16 7"/><line x1="21" y1="12" x2="9" y2="12"/></svg>
                Đăng xuất
            </a>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display:none;">@csrf</form>
        </nav>
    </div>

    {{-- MAIN --}}
    <div class="profile-main">

        @if($activeTab === 'overview')
            {{-- Stats --}}
            <div class="stats-row">
                <div class="stat-card">
                    <div class="stat-number">{{ $orders->count() }}</div>
                    <div class="stat-label">Tổng đơn hàng</div>
                </div>
                <div class="stat-card">
                    <div class="stat-number">{{ $orders->where('status','completed')->count() }}</div>
                    <div class="stat-label">Đã hoàn thành</div>
                </div>
                <div class="stat-card">
                    <div class="stat-number">{{ number_format($orders->sum('total_amount') / 1000) }}K</div>
                    <div class="stat-label">Tổng chi tiêu</div>
                </div>
            </div>

            {{-- Account Info --}}
            <div class="profile-section">
                <div class="profile-section-header">
                    <svg style="width:17px;height:17px;fill:none;stroke:var(--primary);stroke-width:2.2;" viewBox="0 0 24 24"><path d="M20 21v-2a4 4 0 00-4-4H8a4 4 0 00-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                    <h2 class="profile-section-title">Thông tin tài khoản</h2>
                </div>
                <div class="profile-section-body" style="padding: 0 1.5rem;">
                    <div class="info-row">
                        <span class="info-label">Họ và tên</span>
                        <span class="info-value">{{ $user->name }}</span>
                    </div>
                    <div class="info-row">
                        <span class="info-label">Email</span>
                        <span class="info-value">{{ $user->email }}</span>
                    </div>
                    <div class="info-row">
                        <span class="info-label">Vai trò</span>
                        <span class="info-value">
                            <span class="badge badge-{{ $user->role === 'admin' ? 'admin' : 'user' }}">{{ strtoupper($user->role) }}</span>
                        </span>
                    </div>
                    <div class="info-row">
                        <span class="info-label">Ngày tham gia</span>
                        <span class="info-value">{{ $user->created_at->format('d/m/Y') }}</span>
                    </div>
                </div>
            </div>

            {{-- Order History --}}
            <div class="profile-section">
                <div class="profile-section-header">
                    <svg style="width:17px;height:17px;fill:none;stroke:var(--primary);stroke-width:2.2;" viewBox="0 0 24 24"><path d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                    <h2 class="profile-section-title">Lịch sử đơn hàng</h2>
                </div>
                @if($orders->count() > 0)
                    <table class="orders-table">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Ngày đặt</th>
                                <th>Sản phẩm</th>
                                <th>Tổng tiền</th>
                                <th>Trạng thái</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($orders as $order)
                                <tr>
                                    <td style="font-weight:700;color:var(--text-primary);">#{{ $order->id }}</td>
                                    <td>{{ $order->created_at->format('d/m/Y H:i') }}</td>
                                    <td>
                                        @foreach($order->items->take(2) as $item)
                                            <div style="font-size:0.8rem;">{{ $item->product_name }} × {{ $item->quantity }}</div>
                                        @endforeach
                                        @if($order->items->count() > 2)
                                            <div style="font-size:0.75rem;color:var(--text-muted);">+{{ $order->items->count() - 2 }} sản phẩm khác</div>
                                        @endif
                                    </td>
                                    <td style="font-weight:700;color:var(--primary);">{{ number_format($order->total_amount) }}đ</td>
                                    <td>
                                        @php
                                            $statusMap = [
                                                'pending'    => ['label' => 'Chờ xử lý',   'class' => 'status-pending'],
                                                'processing' => ['label' => 'Đang xử lý',  'class' => 'status-processing'],
                                                'completed'  => ['label' => 'Hoàn thành',  'class' => 'status-completed'],
                                                'cancelled'  => ['label' => 'Đã hủy',      'class' => 'status-cancelled'],
                                            ];
                                            $s = $statusMap[$order->status] ?? ['label' => $order->status, 'class' => 'status-pending'];
                                        @endphp
                                        <span class="order-status {{ $s['class'] }}">{{ $s['label'] }}</span>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @else
                    <div style="padding:3rem;text-align:center;">
                        <svg style="width:56px;height:56px;fill:none;stroke:var(--text-muted);stroke-width:1.2;margin:0 auto 1rem;display:block;opacity:0.4;" viewBox="0 0 24 24"><path d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                        <p style="color:var(--text-muted);margin-bottom:1rem;">Bạn chưa có đơn hàng nào</p>
                        <a href="{{ route('front.shop') }}" class="btn btn-primary btn-sm">Mua hàng ngay</a>
                    </div>
                @endif
            </div>

        @elseif($activeTab === 'addresses')
            {{-- Sổ địa chỉ --}}
            <div class="profile-section">
                <div class="profile-section-header" style="display: flex; justify-content: space-between; align-items: center; width: 100%;">
                    <div style="display: flex; align-items: center; gap: 0.6rem;">
                        <svg style="width:17px;height:17px;fill:none;stroke:var(--primary);stroke-width:2.2;" viewBox="0 0 24 24"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0118 0z"/><circle cx="12" cy="10" r="3"/></svg>
                        <h2 class="profile-section-title">Sổ địa chỉ nhận hàng</h2>
                    </div>
                    <button type="button" class="btn btn-primary btn-sm" onclick="document.getElementById('add-address-form').style.display='block'">+ Thêm địa chỉ mới</button>
                </div>
                <div class="profile-section-body">

                    {{-- Form thêm mới (Ẩn mặc định) --}}
                    <div id="add-address-form" style="display: none; background: rgba(194,65,12,0.03); padding: 1.5rem; border-radius: 1rem; margin-bottom: 1.5rem; border: 1px dashed var(--border);">
                        <h3 style="font-size: 0.95rem; font-weight: 700; margin-bottom: 1rem; color: var(--primary);">Thêm địa chỉ giao hàng mới</h3>
                        <form action="{{ route('addresses.store') }}" method="POST">
                            @csrf
                            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; margin-bottom: 1rem;">
                                <div class="form-group" style="margin-bottom: 0;">
                                    <label style="font-size: 0.7rem;">Tên người nhận</label>
                                    <input type="text" name="recipient_name" required placeholder="Họ và tên">
                                </div>
                                <div class="form-group" style="margin-bottom: 0;">
                                    <label style="font-size: 0.7rem;">Số điện thoại</label>
                                    <input type="text" name="recipient_phone" required placeholder="Số điện thoại">
                                </div>
                            </div>
                            <div class="form-group">
                                <label style="font-size: 0.7rem;">Địa chỉ chi tiết</label>
                                <textarea name="address_line" required placeholder="Số nhà, tên đường, phường/xã, quận/huyện, tỉnh/thành phố..." style="min-height: 80px;"></textarea>
                            </div>
                            <div class="form-group" style="display: flex; align-items: center; gap: 0.5rem; margin-bottom: 1.25rem;">
                                <input type="checkbox" name="is_default" id="is_default" value="1" style="width: auto; cursor: pointer;">
                                <label for="is_default" style="display: inline; text-transform: none; font-weight: 500; font-size: 0.85rem; cursor: pointer; color: var(--text-secondary); margin-bottom: 0;">Đặt làm địa chỉ mặc định</label>
                            </div>
                            <div style="display: flex; gap: 0.5rem;">
                                <button type="submit" class="btn btn-primary btn-sm">Lưu địa chỉ</button>
                                <button type="button" class="btn btn-outline btn-sm" onclick="document.getElementById('add-address-form').style.display='none'">Hủy</button>
                            </div>
                        </form>
                    </div>

                    @if($addresses->count() > 0)
                        <div style="display: flex; flex-direction: column; gap: 1rem;">
                            @foreach($addresses as $address)
                                <div style="border: 1px solid var(--border); border-radius: 1rem; padding: 1.25rem; background: var(--bg-card); transition: all 0.2s; position: relative;">
                                    <div style="display: flex; justify-content: space-between; align-items: flex-start; flex-wrap: wrap; gap: 1rem;">
                                        <div>
                                            <div style="display: flex; align-items: center; gap: 0.5rem; margin-bottom: 0.5rem; flex-wrap: wrap;">
                                                <strong style="color: var(--text-primary); font-size: 0.95rem;">{{ $address->recipient_name }}</strong>
                                                <span style="color: var(--text-muted); font-size: 0.85rem;">| {{ $address->recipient_phone }}</span>
                                                @if($address->is_default)
                                                    <span class="badge badge-completed" style="font-size: 0.7rem; padding: 0.15rem 0.5rem; background: rgba(74,222,128,0.12); color: #4ade80;">Mặc định</span>
                                                @endif
                                            </div>
                                            <p style="color: var(--text-secondary); font-size: 0.9rem; line-height: 1.4; white-space: pre-wrap; margin: 0;">{{ $address->address_line }}</p>
                                        </div>
                                        <div style="display: flex; gap: 0.5rem; align-items: center;">
                                            @if(!$address->is_default)
                                                <form action="{{ route('addresses.set-default', $address) }}" method="POST" style="display:inline;">
                                                    @csrf
                                                    <button type="submit" class="btn btn-outline btn-sm" style="padding: 0.35rem 0.75rem; font-size: 0.78rem;">Đặt mặc định</button>
                                                </form>
                                            @endif
                                            <button type="button" class="btn btn-outline btn-sm" style="padding: 0.35rem 0.75rem; font-size: 0.78rem;" onclick="document.getElementById('edit-address-form-{{ $address->id }}').style.display='block'">Sửa</button>
                                            <form action="{{ route('addresses.destroy', $address) }}" method="POST" onsubmit="return confirm('Bạn có chắc chắn muốn xóa địa chỉ này?');" style="display:inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm" style="padding: 0.35rem 0.75rem; font-size: 0.78rem; background: var(--danger); color: white;">Xóa</button>
                                            </form>
                                        </div>
                                    </div>

                                    {{-- Form chỉnh sửa địa chỉ (Ẩn mặc định) --}}
                                    <div id="edit-address-form-{{ $address->id }}" style="display: none; background: rgba(194,65,12,0.02); padding: 1.25rem; border-radius: 0.75rem; margin-top: 1rem; border: 1px solid var(--border);">
                                        <h4 style="font-size: 0.9rem; font-weight: 700; margin-bottom: 0.75rem; color: var(--primary);">Chỉnh sửa địa chỉ</h4>
                                        <form action="{{ route('addresses.update', $address) }}" method="POST">
                                            @csrf
                                            @method('PUT')
                                            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; margin-bottom: 0.75rem;">
                                                <div class="form-group" style="margin-bottom: 0;">
                                                    <label style="font-size: 0.7rem;">Tên người nhận</label>
                                                    <input type="text" name="recipient_name" value="{{ $address->recipient_name }}" required>
                                                </div>
                                                <div class="form-group" style="margin-bottom: 0;">
                                                    <label style="font-size: 0.7rem;">Số điện thoại</label>
                                                    <input type="text" name="recipient_phone" value="{{ $address->recipient_phone }}" required>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label style="font-size: 0.7rem;">Địa chỉ chi tiết</label>
                                                <textarea name="address_line" required style="min-height: 80px;">{{ $address->address_line }}</textarea>
                                            </div>
                                            <div class="form-group" style="display: flex; align-items: center; gap: 0.5rem; margin-bottom: 1rem;">
                                                <input type="checkbox" name="is_default" id="is_default_{{ $address->id }}" value="1" {{ $address->is_default ? 'checked' : '' }} style="width: auto; cursor: pointer;">
                                                <label for="is_default_{{ $address->id }}" style="display: inline; text-transform: none; font-weight: 500; font-size: 0.85rem; cursor: pointer; color: var(--text-secondary); margin-bottom: 0;">Đặt làm địa chỉ mặc định</label>
                                            </div>
                                            <div style="display: flex; gap: 0.5rem;">
                                                <button type="submit" class="btn btn-primary btn-sm">Cập nhật</button>
                                                <button type="button" class="btn btn-outline btn-sm" onclick="document.getElementById('edit-address-form-{{ $address->id }}').style.display='none'">Hủy</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div style="padding: 3rem; text-align: center; border: 1px dashed var(--border); border-radius: 1rem;">
                            <svg style="width:48px;height:48px;fill:none;stroke:var(--text-muted);stroke-width:1.2;margin:0 auto 1rem;display:block;opacity:0.4;" viewBox="0 0 24 24"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0118 0z"/><circle cx="12" cy="10" r="3"/></svg>
                            <p style="color:var(--text-muted); margin-bottom:1rem;">Bạn chưa có địa chỉ giao hàng nào được lưu.</p>
                            <button class="btn btn-primary btn-sm" onclick="document.getElementById('add-address-form').style.display='block'">Thêm địa chỉ đầu tiên</button>
                        </div>
                    @endif

                </div>
            </div>
        @endif
    </div>
</div>
@endsection