@extends('layouts.app')
@section('content')
    <div class="mb-3">
        <a href="{{ route('admin.orders.index') }}" class="btn btn-outline btn-sm">← Quay lại danh sách</a>
    </div>

    <div style="display:grid; grid-template-columns: 1fr 1fr; gap:2rem; margin-bottom:2rem;">
        {{-- Thông tin đơn hàng --}}
        <div class="card">
            <h2 style="font-size:1.25rem; margin-bottom:1rem; border-bottom:1px solid var(--border); padding-bottom:0.5rem;">
                Chi tiết đơn hàng #{{ $order->id }}
            </h2>
            <div class="form-group">
                <label>Trạng thái hiện tại</label>
                <div>
                    @if($order->status === 'pending')
                        <span class="badge badge-pending">Chờ xử lý</span>
                    @elseif($order->status === 'processing')
                        <span class="badge badge-processing">Đang làm</span>
                    @elseif($order->status === 'completed')
                        <span class="badge badge-completed">Hoàn thành</span>
                    @else
                        <span class="badge badge-cancelled">Đã hủy</span>
                    @endif
                </div>
            </div>

            <div class="form-group">
                <label>Phương thức thanh toán</label>
                <div>
                    @if($order->payment_method === 'cod')
                        <strong>Thanh toán khi nhận hàng (COD)</strong>
                    @else
                        <strong>Chuyển khoản ngân hàng</strong>
                    @endif
                </div>
            </div>

            <div class="form-group">
                <label>Thời gian đặt hàng</label>
                <div class="text-main">{{ $order->created_at->format('H:i:s d/m/Y') }}</div>
            </div>

            {{-- Form cập nhật trạng thái đơn --}}
            <form action="{{ route('admin.orders.update', $order) }}" method="POST" style="margin-top:2rem; padding-top:1.5rem; border-top:1px solid var(--border);">
                @csrf
                @method('PUT')
                <div class="form-group">
                    <label for="status">Cập nhật trạng thái đơn hàng</label>
                    <select name="status" id="status" required style="margin-bottom:1rem;">
                        <option value="pending" {{ $order->status === 'pending' ? 'selected' : '' }}>Chờ xử lý</option>
                        <option value="processing" {{ $order->status === 'processing' ? 'selected' : '' }}>Đang làm nước</option>
                        <option value="completed" {{ $order->status === 'completed' ? 'selected' : '' }}>Hoàn thành đơn</option>
                        <option value="cancelled" {{ $order->status === 'cancelled' ? 'selected' : '' }}>Đã hủy đơn</option>
                    </select>
                </div>
                <button type="submit" class="btn btn-primary" style="width:100%;">Cập nhật trạng thái</button>
            </form>
        </div>

        {{-- Thông tin khách hàng nhận --}}
        <div class="card">
            <h2 style="font-size:1.25rem; margin-bottom:1rem; border-bottom:1px solid var(--border); padding-bottom:0.5rem;">
                Thông tin người nhận
            </h2>
            <div class="form-group">
                <label>Họ và tên</label>
                <div class="text-main" style="font-weight:600;">{{ $order->customer_name }}</div>
            </div>
            <div class="form-group">
                <label>Email liên hệ</label>
                <div class="text-main">{{ $order->customer_email }}</div>
            </div>
            <div class="form-group">
                <label>Số điện thoại</label>
                <div class="text-main">{{ $order->customer_phone }}</div>
            </div>
            <div class="form-group">
                <label>Địa chỉ nhận hàng</label>
                <div class="text-main" style="white-space: pre-wrap;">{{ $order->customer_address }}</div>
            </div>
        </div>
    </div>

    {{-- Sản phẩm trong đơn hàng --}}
    <div class="card">
        <h2 style="font-size:1.25rem; margin-bottom:1rem;">Danh sách món đã đặt</h2>
        <table>
            <thead>
                <tr>
                    <th>Món</th>
                    <th>Tùy chọn chi tiết</th>
                    <th>Đơn giá</th>
                    <th>Số lượng</th>
                    <th>Thành tiền</th>
                </tr>
            </thead>
            <tbody>
                @foreach($order->items as $item)
                    @php
                        $options = [];
                        $toppings = [];
                        if ($item->options) {
                            $options = is_string($item->options) ? json_decode($item->options, true) : $item->options;
                        }
                        if ($item->toppings) {
                            $toppings = is_string($item->toppings) ? json_decode($item->toppings, true) : $item->toppings;
                        }
                    @endphp
                    <tr>
                        <td>
                            <div style="display: flex; align-items: center; gap: 0.75rem;">
                                @if(!empty($item->product_image))
                                    <img src="{{ $item->product_image }}" alt="{{ $item->product_name }}" style="width: 40px; height: 40px; border-radius: 0.35rem; object-fit: cover; background: var(--bg-subtle);">
                                @endif
                                <div>
                                    <strong style="display: block;">{{ $item->product_name }}</strong>
                                </div>
                            </div>
                        </td>
                        <td>
                            @if(!empty($options))
                                @foreach($options as $opt)
                                    <span class="badge badge-processing" style="margin:2px 0; display:inline-block;">
                                        {{ $opt['name'] ?? '' }} (+{{ number_format($opt['price_adjustment'] ?? 0) }}đ)
                                    </span>
                                @endforeach
                            @endif

                            @if(!empty($toppings))
                                @foreach($toppings as $top)
                                    <span class="badge badge-completed" style="margin:2px 0; display:inline-block;">
                                        {{ $top['name'] ?? '' }} (+{{ number_format($top['price'] ?? 0) }}đ)
                                    </span>
                                @endforeach
                            @endif

                            @if(empty($options) && empty($toppings))
                                <span class="text-dim">Mặc định</span>
                            @endif
                        </td>
                        <td>{{ number_format($item->price) }}đ</td>
                        <td>{{ $item->quantity }}</td>
                        <td><strong>{{ number_format($item->price * $item->quantity) }}đ</strong></td>
                    </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="4" style="text-align:right; font-size:1.125rem;"><strong>Tổng giá trị đơn hàng:</strong></td>
                    <td style="font-size:1.25rem; color:var(--success);"><strong>{{ number_format($order->total_amount) }}đ</strong></td>
                </tr>
            </tfoot>
        </table>
    </div>
@endsection
