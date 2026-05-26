@extends('layouts.app')

@push('styles')
<style>
    input[type=number]::-webkit-inner-spin-button,
    input[type=number]::-webkit-outer-spin-button {
        -webkit-appearance: none;
        margin: 0;
    }
    .qty-input-cart { -moz-appearance: textfield; }

    .cart-table-wrap {
        background: var(--bg-card);
        border: 1px solid var(--border);
        border-radius: 1.25rem;
        overflow: hidden;
    }
    .cart-table-wrap table {
        width: 100%;
        border-collapse: collapse;
    }
    .cart-table-wrap thead th {
        background: var(--bg-subtle);
        padding: 0.9rem 1.25rem;
        font-size: 0.75rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        color: var(--text-muted);
        text-align: left;
        border-bottom: 1px solid var(--border);
    }
    .cart-table-wrap tbody tr {
        border-bottom: 1px solid var(--border);
        transition: background 0.15s;
    }
    .cart-table-wrap tbody tr:last-child {
        border-bottom: none;
    }
    .cart-table-wrap tbody tr:hover {
        background: var(--bg-subtle);
    }
    .cart-table-wrap td {
        padding: 1rem 1.25rem;
        vertical-align: middle;
    }
    .cart-product-name {
        font-weight: 600;
        color: var(--text-primary);
        font-size: 0.95rem;
    }
    .cart-product-cat {
        font-size: 0.75rem;
        color: var(--text-muted);
        margin-top: 0.2rem;
    }
    .option-tag {
        display: inline-block;
        background: rgba(var(--primary-rgb, 212,149,90), 0.12);
        color: var(--primary);
        border: 1px solid rgba(var(--primary-rgb, 212,149,90), 0.25);
        font-size: 0.7rem;
        font-weight: 600;
        padding: 0.2rem 0.6rem;
        border-radius: 9999px;
        margin: 2px 2px 0 0;
    }
    .topping-tag {
        display: inline-block;
        background: rgba(74, 222, 128, 0.1);
        color: #4ade80;
        border: 1px solid rgba(74, 222, 128, 0.25);
        font-size: 0.7rem;
        font-weight: 600;
        padding: 0.2rem 0.6rem;
        border-radius: 9999px;
        margin: 2px 2px 0 0;
    }
    .cart-qty-wrap {
        display: inline-flex;
        align-items: center;
        border: 1.5px solid var(--border);
        border-radius: 9999px;
        overflow: hidden;
        background: var(--bg-subtle);
        height: 32px;
    }
    .cart-qty-btn {
        border: none;
        background: transparent;
        padding: 0;
        width: 32px;
        height: 100%;
        cursor: pointer;
        color: var(--text-muted);
        display: flex;
        align-items: center;
        justify-content: center;
        transition: all 0.15s;
    }
    .cart-qty-btn:hover {
        color: var(--primary);
        background: rgba(0,0,0,0.03);
    }
    .qty-input-cart {
        width: 32px;
        height: 100%;
        text-align: center;
        border: none;
        background: transparent;
        padding: 0;
        font-weight: 700;
        font-size: 0.88rem;
        color: var(--text-primary);
    }
    .cart-price {
        font-weight: 600;
        color: var(--text-secondary);
        font-size: 0.9rem;
    }
    .cart-subtotal {
        font-weight: 700;
        color: var(--primary);
        font-size: 0.95rem;
    }
    .delete-btn {
        width: 32px;
        height: 32px;
        display: flex;
        align-items: center;
        justify-content: center;
        background: rgba(220, 38, 38, 0.08);
        border: 1.5px solid rgba(220, 38, 38, 0.2);
        border-radius: 50%;
        color: #dc2626;
        cursor: pointer;
        transition: all 0.15s;
    }
    .delete-btn:hover {
        background: rgba(220, 38, 38, 0.18);
        border-color: #dc2626;
    }
    .cart-summary-card {
        background: var(--bg-card);
        border: 1px solid var(--border);
        border-radius: 1.25rem;
        padding: 1.5rem;
        margin-top: 1.5rem;
    }
    .summary-row {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 0.5rem 0;
        color: var(--text-secondary);
        font-size: 0.9rem;
    }
    .summary-total {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 1rem 0 0;
        margin-top: 0.5rem;
        border-top: 1px solid var(--border);
        font-size: 1.15rem;
        font-weight: 700;
        color: var(--text-primary);
    }
    .summary-total-price {
        color: var(--primary);
        font-size: 1.35rem;
    }
    .checkout-btn {
        width: 100%;
        padding: 0.95rem;
        border-radius: 0.75rem;
        background: var(--primary);
        color: white;
        border: none;
        font-size: 1rem;
        font-weight: 700;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 0.5rem;
        transition: all 0.2s ease;
        margin-top: 1.25rem;
        text-decoration: none;
        letter-spacing: 0.3px;
    }
    .checkout-btn:hover {
        opacity: 0.9;
        transform: translateY(-1px);
        box-shadow: 0 6px 20px rgba(0,0,0,0.2);
    }

    /* Confirm Modal */
    #confirmModal {
        display: none;
        position: fixed;
        inset: 0;
        z-index: 9999;
        background: rgba(0,0,0,0.55);
        align-items: center;
        justify-content: center;
        backdrop-filter: blur(4px);
    }
    .modal-box {
        background: var(--bg-card);
        border: 1px solid var(--border);
        padding: 2rem;
        border-radius: 1.25rem;
        width: 90%;
        max-width: 400px;
        box-shadow: 0 20px 60px rgba(0,0,0,0.35);
        text-align: center;
        animation: dropdownFadeIn 0.2s ease-out;
    }
    .modal-icon {
        width: 52px;
        height: 52px;
        background: rgba(220, 38, 38, 0.12);
        border: 1.5px solid rgba(220, 38, 38, 0.25);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 1.25rem;
        color: #dc2626;
    }
    .modal-title {
        font-size: 1.2rem;
        font-weight: 700;
        color: var(--text-primary);
        margin-bottom: 0.5rem;
    }
    .modal-desc {
        color: var(--text-muted);
        font-size: 0.9rem;
        margin-bottom: 1.5rem;
        line-height: 1.5;
    }
    .modal-actions {
        display: flex;
        gap: 0.75rem;
    }
    .modal-actions button {
        flex: 1;
        padding: 0.65rem 1rem;
        border-radius: 0.6rem;
        font-weight: 600;
        font-size: 0.9rem;
        cursor: pointer;
        transition: all 0.15s;
    }
    .btn-modal-cancel {
        background: var(--bg-subtle);
        border: 1.5px solid var(--border);
        color: var(--text-secondary);
    }
    .btn-modal-cancel:hover {
        border-color: var(--text-muted);
    }
    .btn-modal-confirm {
        background: #dc2626;
        border: none;
        color: white;
    }
    .btn-modal-confirm:hover {
        background: #b91c1c;
    }

    @media (max-width: 640px) {
        .cart-table-wrap table, .cart-table-wrap thead, .cart-table-wrap tbody, .cart-table-wrap th, .cart-table-wrap td, .cart-table-wrap tr {
            display: block;
        }
        .cart-table-wrap thead tr { display: none; }
        .cart-table-wrap td {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0.6rem 1rem;
        }
        .cart-table-wrap td::before {
            content: attr(data-label);
            font-size: 0.75rem;
            font-weight: 700;
            color: var(--text-muted);
            text-transform: uppercase;
            letter-spacing: 0.3px;
        }
    }
</style>
@endpush

@section('content')

<div style="display:flex; align-items:center; justify-content:space-between; margin-bottom:1.5rem;">
    <h1 style="font-size:1.6rem; display:flex; align-items:center; gap:0.6rem; margin:0;">
        <svg style="width:28px;height:28px;fill:none;stroke:var(--primary);stroke-width:2.5;" viewBox="0 0 24 24"><path d="M6 2L3 6v14a2 2 0 002 2h14a2 2 0 002-2V6l-3-4H6zM3 6h18M16 10a4 4 0 01-8 0"></path></svg>
        Giỏ hàng của bạn
    </h1>
    <a href="{{ route('front.shop') }}" class="btn btn-outline btn-sm">
        <svg style="width:13px;height:13px;fill:none;stroke:currentColor;stroke-width:2.5;" viewBox="0 0 24 24"><path d="M19 12H5M12 5l-7 7 7 7"/></svg>
        Tiếp tục mua hàng
    </a>
</div>

@if(count($items) > 0)

    @if(session('success'))
        <div style="background:rgba(74,222,128,0.1);border:1px solid rgba(74,222,128,0.3);border-radius:0.6rem;padding:0.75rem 1rem;color:#4ade80;font-size:0.875rem;margin-bottom:1rem;display:flex;align-items:center;gap:0.5rem;">
            <svg style="width:16px;height:16px;flex-shrink:0;fill:none;stroke:currentColor;stroke-width:2.5;" viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg>
            {{ session('success') }}
        </div>
    @endif

    <div class="cart-table-wrap">
        <table>
            <thead>
                <tr>
                    <th>Sản phẩm</th>
                    <th>Tuỳ chọn</th>
                    <th>Đơn giá</th>
                    <th>Số lượng</th>
                    <th>Thành tiền</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @foreach($items as $item)
                    <tr>
                        <td data-label="Sản phẩm">
                            <div style="display: flex; align-items: center; gap: 1rem;">
                                @if(!empty($item['product']->image_url))
                                    <img src="{{ $item['product']->image_url }}" alt="{{ $item['product']->name }}" style="width: 50px; height: 50px; border-radius: 0.5rem; object-fit: cover; background: var(--bg-subtle);">
                                @else
                                    <div style="width: 50px; height: 50px; border-radius: 0.5rem; background: var(--bg-subtle); display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                                        <svg style="width: 20px; height: 20px; fill: none; stroke: var(--text-muted); stroke-width: 1.5;" viewBox="0 0 24 24"><path d="M18 8h1a4 4 0 010 8h-1M2 8h16v9a4 4 0 01-4 4H6a4 4 0 01-4-4V8z"></path></svg>
                                    </div>
                                @endif
                                <div>
                                    <div class="cart-product-name">{{ $item['product']->name }}</div>
                                    <div class="cart-product-cat">{{ $item['product']->category->name ?? '' }}</div>
                                </div>
                            </div>
                        </td>
                        <td data-label="Tuỳ chọn">
                            <div>
                                @if(!empty($item['option_names']))
                                    @foreach($item['option_names'] as $on)
                                        <span class="option-tag">{{ $on }}</span>
                                    @endforeach
                                @endif
                                @if(!empty($item['topping_names']))
                                    @foreach($item['topping_names'] as $tn)
                                        <span class="topping-tag">{{ $tn }}</span>
                                    @endforeach
                                @endif
                                @if(empty($item['option_names']) && empty($item['topping_names']))
                                    <span style="color:var(--text-muted);font-size:0.8rem;">Mặc định</span>
                                @endif
                            </div>
                        </td>
                        <td data-label="Đơn giá">
                            <span class="cart-price">{{ number_format($item['price']) }}đ</span>
                        </td>
                        <td data-label="Số lượng">
                            <form action="{{ route('cart.update', $item['key']) }}" method="POST" class="qty-form">
                                @csrf
                                @method('PATCH')
                                <div class="cart-qty-wrap">
                                    <button type="button" class="cart-qty-btn qty-minus">
                                        <svg style="width:13px;height:13px;" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="5" y1="12" x2="19" y2="12"/></svg>
                                    </button>
                                    <input type="number" name="quantity" value="{{ $item['quantity'] }}" min="1" max="20" class="qty-input-cart">
                                    <button type="button" class="cart-qty-btn qty-plus">
                                        <svg style="width:13px;height:13px;" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
                                    </button>
                                </div>
                            </form>
                        </td>
                        <td data-label="Thành tiền">
                            <span class="cart-subtotal">{{ number_format($item['subtotal']) }}đ</span>
                        </td>
                        <td>
                            <form action="{{ route('cart.destroy', $item['key']) }}" method="POST" class="delete-form">
                                @csrf
                                @method('DELETE')
                                <button type="button" class="delete-btn btn-delete" title="Xóa sản phẩm">
                                    <svg style="width:14px;height:14px;fill:none;stroke:currentColor;stroke-width:2;" viewBox="0 0 24 24"><path d="M3 6h18M19 6v14a2 2 0 01-2 2H7a2 2 0 01-2-2V6m3 0V4a2 2 0 012-2h4a2 2 0 012 2v2"/></svg>
                                </button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    {{-- Order Summary --}}
    <div style="display:flex; justify-content:flex-end;">
        <div class="cart-summary-card" style="min-width:320px; max-width:420px;">
            <div style="font-size:0.9rem; font-weight:700; text-transform:uppercase; letter-spacing:0.5px; color:var(--text-muted); margin-bottom:0.75rem;">Tóm tắt đơn hàng</div>

            <div class="summary-row">
                <span>Tạm tính ({{ count($items) }} sản phẩm)</span>
                <span>{{ number_format($total) }}đ</span>
            </div>
            <div class="summary-row">
                <span>Phí vận chuyển</span>
                <span style="color:#4ade80;font-weight:600;">Miễn phí</span>
            </div>

            <div class="summary-total">
                <span>Tổng cộng</span>
                <span class="summary-total-price">{{ number_format($total) }}đ</span>
            </div>

            <a href="{{ route('checkout') }}" class="checkout-btn">
                <svg style="width:18px;height:18px;fill:none;stroke:currentColor;stroke-width:2.5;" viewBox="0 0 24 24"><path d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                Tiến hành thanh toán
            </a>

            <a href="{{ route('front.shop') }}" style="display:block; text-align:center; margin-top:0.75rem; font-size:0.85rem; color:var(--text-muted);">← Tiếp tục mua hàng</a>
        </div>
    </div>

@else
    <div class="cart-table-wrap" style="text-align:center; padding:4rem 2rem;">
        <svg style="width:80px;height:80px;fill:none;stroke:var(--text-muted);stroke-width:1.2;margin:0 auto 1.5rem;display:block;opacity:0.5;" viewBox="0 0 24 24"><path d="M6 2L3 6v14a2 2 0 002 2h14a2 2 0 002-2V6l-3-4H6zM3 6h18M16 10a4 4 0 01-8 0"></path></svg>
        <h3 style="font-size:1.25rem;font-weight:700;color:var(--text-primary);margin-bottom:0.5rem;">Giỏ hàng đang trống</h3>
        <p style="color:var(--text-muted);margin-bottom:1.5rem;">Hãy khám phá thực đơn và thêm những món bạn yêu thích!</p>
        <a href="{{ route('front.shop') }}" class="btn btn-primary">
            <svg style="width:15px;height:15px;fill:none;stroke:currentColor;stroke-width:2.5;" viewBox="0 0 24 24"><path d="M18 8h1a4 4 0 010 8h-1M2 8h16v9a4 4 0 01-4 4H6a4 4 0 01-4-4V8z"/></svg>
            Xem thực đơn ngay
        </a>
    </div>
@endif

{{-- Delete Confirmation Modal --}}
<div id="confirmModal">
    <div class="modal-box">
        <div class="modal-icon">
            <svg style="width:24px;height:24px;fill:none;stroke:currentColor;stroke-width:2;" viewBox="0 0 24 24"><path d="M3 6h18M19 6v14a2 2 0 01-2 2H7a2 2 0 01-2-2V6m3 0V4a2 2 0 012-2h4a2 2 0 012 2v2"/><line x1="10" y1="11" x2="10" y2="17"/><line x1="14" y1="11" x2="14" y2="17"/></svg>
        </div>
        <div class="modal-title">Xóa sản phẩm?</div>
        <div class="modal-desc">Bạn có chắc muốn xóa sản phẩm này khỏi giỏ hàng không? Hành động này không thể hoàn tác.</div>
        <div class="modal-actions">
            <button type="button" id="btnCancelDelete" class="btn-modal-cancel">Hủy bỏ</button>
            <button type="button" id="btnConfirmDelete" class="btn-modal-confirm">Xóa ngay</button>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', () => {
    // === Quantity +/- with auto-submit ===
    document.querySelectorAll('.qty-form').forEach(form => {
        const input = form.querySelector('.qty-input-cart');
        const minus = form.querySelector('.qty-minus');
        const plus  = form.querySelector('.qty-plus');

        minus.addEventListener('click', () => {
            const v = parseInt(input.value) || 1;
            if (v > 1) { input.value = v - 1; form.submit(); }
        });
        plus.addEventListener('click', () => {
            const v = parseInt(input.value) || 1;
            if (v < 20) { input.value = v + 1; form.submit(); }
        });
        input.addEventListener('change', () => {
            let v = parseInt(input.value) || 1;
            if (v < 1) v = 1;
            if (v > 20) v = 20;
            input.value = v;
            form.submit();
        });
    });

    // === Delete Confirmation Modal ===
    let targetForm = null;
    const modal = document.getElementById('confirmModal');

    document.querySelectorAll('.btn-delete').forEach(btn => {
        btn.addEventListener('click', e => {
            targetForm = e.currentTarget.closest('form');
            modal.style.display = 'flex';
        });
    });

    document.getElementById('btnCancelDelete').addEventListener('click', () => {
        modal.style.display = 'none';
        targetForm = null;
    });

    document.getElementById('btnConfirmDelete').addEventListener('click', () => {
        if (targetForm) targetForm.submit();
    });

    // Close on backdrop click
    modal.addEventListener('click', e => {
        if (e.target === modal) {
            modal.style.display = 'none';
            targetForm = null;
        }
    });
});
</script>
@endpush
