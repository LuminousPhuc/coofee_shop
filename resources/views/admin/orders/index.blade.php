@extends('layouts.app')
@section('content')
    <div class="flex-between mb-3">
        <h1 style="font-size:1.5rem; display: flex; align-items: center; gap: 0.5rem;">
            <svg style="width: 22px; height: 22px; fill: none; stroke: var(--primary); stroke-width: 2;" viewBox="0 0 24 24"><path d="M20 7H4a2 2 0 00-2 2v6a2 2 0 002 2h16a2 2 0 002-2V9a2 2 0 00-2-2z"></path><path d="M16 21V5a2 2 0 00-2-2h-4a2 2 0 00-2 2v16"></path></svg>
            Quản lý Đơn hàng
        </h1>
    </div>

    <div class="card">
        <table>
            <thead>
                <tr>
                    <th>Mã ĐH</th>
                    <th>Khách hàng</th>
                    <th>Số điện thoại</th>
                    <th>Tổng tiền</th>
                    <th>Thanh toán</th>
                    <th>Trạng thái</th>
                    <th>Ngày đặt</th>
                    <th>Hành động</th>
                </tr>
            </thead>
            <tbody>
                @forelse($orders as $order)
                    <tr>
                        <td><strong>#{{ $order->id }}</strong></td>
                        <td>
                            <div>{{ $order->customer_name }}</div>
                            <span class="text-dim text-xs">{{ $order->customer_email }}</span>
                        </td>
                        <td>{{ $order->customer_phone }}</td>
                        <td><strong style="color:var(--success);">{{ number_format($order->total_amount) }}đ</strong></td>
                        <td>
                            @if($order->payment_method === 'cod')
                                <span class="badge badge-user">COD</span>
                            @else
                                <span class="badge badge-processing">Chuyển khoản</span>
                            @endif
                        </td>
                        <td>
                            @if($order->status === 'pending')
                                <span class="badge badge-pending">Chờ xử lý</span>
                            @elseif($order->status === 'processing')
                                <span class="badge badge-processing">Đang làm</span>
                            @elseif($order->status === 'completed')
                                <span class="badge badge-completed">Hoàn thành</span>
                            @else
                                <span class="badge badge-cancelled">Đã hủy</span>
                            @endif
                        </td>
                        <td class="text-dim text-xs">{{ $order->created_at->format('H:i d/m/Y') }}</td>
                        <td>
                            <div class="flex gap-1">
                                <a href="{{ route('admin.orders.show', $order) }}" class="btn btn-outline btn-sm">Xem chi tiết</a>
                                <form action="{{ route('admin.orders.destroy', $order) }}" method="POST" onsubmit="return confirm('Bạn có chắc chắn muốn xóa đơn hàng này?');">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm">Xóa</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="8" style="text-align:center;" class="text-dim">Chưa có đơn hàng nào.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="pagination-wrap">
        {{ $orders->links('pagination::bootstrap-4') }}
    </div>
@endsection
