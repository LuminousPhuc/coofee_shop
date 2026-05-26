@extends('layouts.app')

@push('styles')
<style>
.checkout-grid {
    display: grid;
    grid-template-columns: 1fr 1.1fr;
    gap: 2rem;
    align-items: start;
}
.checkout-card {
    background: var(--bg-card);
    border: 1px solid var(--border);
    border-radius: 1.25rem;
    overflow: hidden;
}
.checkout-card-header {
    padding: 1.25rem 1.5rem;
    border-bottom: 1px solid var(--border);
    display: flex;
    align-items: center;
    gap: 0.6rem;
}
.checkout-card-header h2 {
    font-size: 1rem;
    font-weight: 700;
    color: var(--text-primary);
    margin: 0;
}
.checkout-card-body {
    padding: 1.5rem;
}

/* Order summary table */
.order-summary-table {
    width: 100%;
    border-collapse: collapse;
    font-size: 0.875rem;
}
.order-summary-table thead th {
    padding: 0.6rem 0.75rem;
    font-size: 0.72rem;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    color: var(--text-muted);
    text-align: left;
    border-bottom: 1px solid var(--border);
}
.order-summary-table tbody tr {
    border-bottom: 1px solid var(--border);
}
.order-summary-table tbody tr:last-child {
    border-bottom: none;
}
.order-summary-table td {
    padding: 0.75rem;
    vertical-align: top;
    color: var(--text-secondary);
}
.order-product-name {
    font-weight: 600;
    color: var(--text-primary);
}
.order-option-tag {
    display: inline-block;
    font-size: 0.68rem;
    background: rgba(var(--primary-rgb, 212,149,90), 0.1);
    color: var(--primary);
    border-radius: 9999px;
    padding: 0.15rem 0.5rem;
    margin: 1px;
}
.order-subtotal {
    font-weight: 600;
    color: var(--text-primary);
    white-space: nowrap;
}
.order-total-row {
    background: var(--bg-subtle);
    border-top: 2px solid var(--border) !important;
}
.order-total-row td {
    padding: 1rem 0.75rem;
    font-weight: 700;
    font-size: 1rem;
    color: var(--text-primary);
}
.order-total-price {
    color: var(--primary) !important;
    font-size: 1.1rem !important;
}

/* Form styles */
.form-field {
    margin-bottom: 1.1rem;
}
.form-label {
    display: flex;
    align-items: center;
    gap: 0.4rem;
    font-size: 0.8rem;
    font-weight: 700;
    color: var(--text-muted);
    text-transform: uppercase;
    letter-spacing: 0.4px;
    margin-bottom: 0.4rem;
}
.form-label .required-dot {
    width: 5px;
    height: 5px;
    background: #ef4444;
    border-radius: 50%;
    display: inline-block;
}
.form-input {
    width: 100%;
    padding: 0.65rem 0.9rem;
    border: 1.5px solid var(--border);
    border-radius: 0.6rem;
    background: var(--bg-subtle);
    color: var(--text-primary);
    font-size: 0.9rem;
    transition: border-color 0.15s, box-shadow 0.15s;
    box-sizing: border-box;
    font-family: inherit;
}
.form-input:focus {
    outline: none;
    border-color: var(--primary);
    box-shadow: 0 0 0 3px rgba(var(--primary-rgb, 212,149,90), 0.15);
}
.form-input.is-invalid {
    border-color: #ef4444;
    box-shadow: 0 0 0 3px rgba(239, 68, 68, 0.12);
}
.field-error {
    display: none;
    align-items: center;
    gap: 0.3rem;
    color: #ef4444;
    font-size: 0.78rem;
    font-weight: 500;
    margin-top: 0.35rem;
}
.field-error.visible {
    display: flex;
}

/* Payment method selector */
.payment-options {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 0.6rem;
}
.payment-option-input {
    display: none;
}
.payment-option-label {
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 0.5rem;
    padding: 0.9rem 0.75rem;
    border: 1.5px solid var(--border);
    border-radius: 0.75rem;
    background: var(--bg-subtle);
    cursor: pointer;
    transition: all 0.15s;
    text-align: center;
}
.payment-option-input:checked + .payment-option-label {
    border-color: var(--primary);
    background: rgba(var(--primary-rgb, 212,149,90), 0.08);
}
.payment-option-label:hover {
    border-color: var(--primary);
}
.payment-option-label .pay-icon {
    width: 32px;
    height: 32px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: var(--primary);
}
.payment-option-label .pay-name {
    font-size: 0.82rem;
    font-weight: 700;
    color: var(--text-primary);
}
.payment-option-label .pay-desc {
    font-size: 0.7rem;
    color: var(--text-muted);
}

/* Submit button */
.submit-btn {
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
    letter-spacing: 0.3px;
    font-family: inherit;
}
.submit-btn:hover {
    opacity: 0.9;
    transform: translateY(-1px);
    box-shadow: 0 6px 20px rgba(0,0,0,0.2);
}

@media (max-width: 900px) {
    .checkout-grid { grid-template-columns: 1fr; }
}
@media (max-width: 640px) {
    .payment-options { grid-template-columns: 1fr; }
}

/* Saved addresses styles */
.address-radio-input:checked + .address-radio-label {
    border-color: var(--primary) !important;
    background: rgba(var(--primary-rgb, 212,149,90), 0.08) !important;
}
.address-radio-input:checked + .address-radio-label .custom-radio-circle {
    border-color: var(--primary) !important;
}
.address-radio-input:checked + .address-radio-label .custom-radio-circle::after {
    content: '';
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    width: 6px;
    height: 6px;
    background: var(--primary);
    border-radius: 50%;
}
</style>
@endpush

@section('content')

<div style="display:flex; align-items:center; gap:0.7rem; margin-bottom:1.75rem;">
    <svg style="width:28px;height:28px;fill:none;stroke:var(--primary);stroke-width:2.2;" viewBox="0 0 24 24"><rect x="1" y="4" width="22" height="16" rx="2" ry="2"/><line x1="1" y1="10" x2="23" y2="10"/></svg>
    <h1 style="font-size:1.6rem;font-weight:800;color:var(--text-primary);margin:0;">Thanh toán</h1>
</div>

<div class="checkout-grid">

    {{-- LEFT: Order Summary --}}
    <div class="checkout-card">
        <div class="checkout-card-header">
            <svg style="width:18px;height:18px;fill:none;stroke:var(--primary);stroke-width:2.2;" viewBox="0 0 24 24"><path d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
            <h2>Đơn hàng của bạn</h2>
        </div>
        <table class="order-summary-table">
            <thead>
                <tr>
                    <th>Sản phẩm</th>
                    <th style="text-align:center;">SL</th>
                    <th style="text-align:right;">Thành tiền</th>
                </tr>
            </thead>
            <tbody>
                @foreach($items as $item)
                    <tr>
                        <td>
                            <div class="order-product-name">{{ $item['product']->name }}</div>
                            @if(!empty($item['option_names'] ?? []))
                                <div style="margin-top:0.3rem;">
                                    @foreach($item['option_names'] ?? [] as $on)
                                        <span class="order-option-tag">{{ $on }}</span>
                                    @endforeach
                                    @foreach($item['topping_names'] ?? [] as $tn)
                                        <span class="order-option-tag" style="background:rgba(74,222,128,0.1);color:#4ade80;">{{ $tn }}</span>
                                    @endforeach
                                </div>
                            @endif
                        </td>
                        <td style="text-align:center;">
                            <span style="background:var(--bg-subtle);border:1px solid var(--border);border-radius:9999px;padding:0.15rem 0.6rem;font-size:0.8rem;font-weight:700;">{{ $item['quantity'] }}</span>
                        </td>
                        <td style="text-align:right;" class="order-subtotal">{{ number_format($item['subtotal']) }}đ</td>
                    </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr class="order-total-row">
                    <td colspan="2">Tổng cộng</td>
                    <td style="text-align:right;" class="order-total-price">{{ number_format($total) }}đ</td>
                </tr>
            </tfoot>
        </table>
        <div style="padding:1rem 1.25rem; border-top:1px solid var(--border); display:flex; align-items:center; gap:0.4rem; font-size:0.8rem; color:var(--text-muted);">
            <svg style="width:14px;height:14px;flex-shrink:0;fill:none;stroke:currentColor;stroke-width:2;" viewBox="0 0 24 24"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
            Phí vận chuyển: <span style="color:#4ade80;font-weight:700;">Miễn phí</span>
        </div>
    </div>

    {{-- RIGHT: Customer Info Form --}}
    <div class="checkout-card">
        <div class="checkout-card-header">
            <svg style="width:18px;height:18px;fill:none;stroke:var(--primary);stroke-width:2.2;" viewBox="0 0 24 24"><path d="M20 21v-2a4 4 0 00-4-4H8a4 4 0 00-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
            <h2>Thông tin giao hàng</h2>
        </div>
        <div class="checkout-card-body">
            <form action="{{ route('checkout.store') }}" method="POST" id="checkoutForm" novalidate>
                @csrf

                @if(auth()->check() && count($addresses) > 0)
                    <div class="form-field" style="margin-bottom: 1.5rem;">
                        <label class="form-label" style="margin-bottom: 0.6rem;">Chọn địa chỉ nhận hàng đã lưu</label>
                        <div style="display: flex; flex-direction: column; gap: 0.75rem;">
                            @foreach($addresses as $addr)
                                <div style="position: relative;">
                                    <input type="radio" name="selected_saved_address" id="saved_addr_{{ $addr->id }}" value="{{ $addr->id }}" class="address-radio-input" style="position: absolute; opacity: 0; pointer-events: none;" {{ $addr->is_default ? 'checked' : '' }} data-name="{{ $addr->recipient_name }}" data-phone="{{ $addr->recipient_phone }}" data-address="{{ $addr->address_line }}">
                                    <label for="saved_addr_{{ $addr->id }}" class="address-radio-label" style="display: block; border: 1.5px solid var(--border); border-radius: 0.75rem; padding: 0.9rem; cursor: pointer; transition: all 0.15s; background: var(--bg-subtle);">
                                        <div style="display: flex; align-items: center; gap: 0.5rem; margin-bottom: 0.25rem;">
                                            <span class="custom-radio-circle" style="width: 14px; height: 14px; border: 2px solid var(--text-muted); border-radius: 50%; display: inline-block; position: relative; transition: all 0.15s; flex-shrink: 0;"></span>
                                            <strong style="color: var(--text-primary); font-size: 0.85rem;">{{ $addr->recipient_name }}</strong>
                                            <span style="color: var(--text-muted); font-size: 0.8rem;">| {{ $addr->recipient_phone }}</span>
                                            @if($addr->is_default)
                                                <span style="background: rgba(74,222,128,0.12); color: #4ade80; font-size: 0.65rem; font-weight: 700; padding: 0.1rem 0.4rem; border-radius: 9999px; text-transform: uppercase;">Mặc định</span>
                                            @endif
                                        </div>
                                        <div style="color: var(--text-secondary); font-size: 0.8rem; padding-left: 1.25rem;">{{ $addr->address_line }}</div>
                                    </label>
                                </div>
                            @endforeach
                            
                            {{-- Option for new address --}}
                            <div style="position: relative;">
                                <input type="radio" name="selected_saved_address" id="saved_addr_new" value="new" class="address-radio-input" style="position: absolute; opacity: 0; pointer-events: none;" {{ count($addresses->where('is_default', 1)) === 0 ? 'checked' : '' }} data-name="" data-phone="" data-address="">
                                <label for="saved_addr_new" class="address-radio-label" style="display: block; border: 1.5px solid var(--border); border-radius: 0.75rem; padding: 0.9rem; cursor: pointer; transition: all 0.15s; background: var(--bg-subtle);">
                                    <div style="display: flex; align-items: center; gap: 0.5rem;">
                                        <span class="custom-radio-circle" style="width: 14px; height: 14px; border: 2px solid var(--text-muted); border-radius: 50%; display: inline-block; position: relative; transition: all 0.15s; flex-shrink: 0;"></span>
                                        <strong style="color: var(--text-primary); font-size: 0.85rem;">Nhập địa chỉ khác</strong>
                                    </div>
                                </label>
                            </div>
                        </div>
                    </div>
                @endif

                {{-- Họ và tên --}}
                <div class="form-field">
                    <label class="form-label" for="customer_name">
                        Họ và tên <span class="required-dot"></span>
                    </label>
                    <input type="text" name="customer_name" id="customer_name"
                        class="form-input @error('customer_name') is-invalid @enderror"
                        value="{{ old('customer_name', auth()->user()->name ?? '') }}">
                    <div class="field-error @error('customer_name') visible @enderror" id="err_name">
                        <svg style="width:12px;height:12px;flex-shrink:0;fill:none;stroke:currentColor;stroke-width:2.5;" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
                        <span>@error('customer_name'){{ $message }}@else Vui lòng nhập họ và tên @enderror</span>
                    </div>
                </div>

                {{-- Email --}}
                <div class="form-field">
                    <label class="form-label" for="customer_email">
                        Email <span class="required-dot"></span>
                    </label>
                    <input type="email" name="customer_email" id="customer_email"
                        class="form-input @error('customer_email') is-invalid @enderror"
                        value="{{ old('customer_email', auth()->user()->email ?? '') }}">
                    <div class="field-error @error('customer_email') visible @enderror" id="err_email">
                        <svg style="width:12px;height:12px;flex-shrink:0;fill:none;stroke:currentColor;stroke-width:2.5;" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
                        <span>@error('customer_email'){{ $message }}@else Vui lòng nhập địa chỉ email hợp lệ @enderror</span>
                    </div>
                </div>

                {{-- Số điện thoại --}}
                <div class="form-field">
                    <label class="form-label" for="customer_phone">
                        Số điện thoại <span class="required-dot"></span>
                    </label>
                    <input type="tel" name="customer_phone" id="customer_phone"
                        class="form-input @error('customer_phone') is-invalid @enderror"
                        value="{{ old('customer_phone') }}">
                    <div class="field-error @error('customer_phone') visible @enderror" id="err_phone">
                        <svg style="width:12px;height:12px;flex-shrink:0;fill:none;stroke:currentColor;stroke-width:2.5;" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
                        <span>@error('customer_phone'){{ $message }}@else Vui lòng nhập số điện thoại @enderror</span>
                    </div>
                </div>

                {{-- Địa chỉ --}}
                <div class="form-field">
                    <label class="form-label" for="customer_address">
                        Địa chỉ giao hàng <span class="required-dot"></span>
                    </label>
                    <textarea name="customer_address" id="customer_address" rows="3"
                        class="form-input @error('customer_address') is-invalid @enderror">{{ old('customer_address') }}</textarea>
                    <div class="field-error @error('customer_address') visible @enderror" id="err_address">
                        <svg style="width:12px;height:12px;flex-shrink:0;fill:none;stroke:currentColor;stroke-width:2.5;" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
                        <span>@error('customer_address'){{ $message }}@else Vui lòng nhập địa chỉ giao hàng @enderror</span>
                    </div>
                </div>

                {{-- Phương thức thanh toán --}}
                <div class="form-field">
                    <label class="form-label">
                        Phương thức thanh toán <span class="required-dot"></span>
                    </label>
                    <div class="payment-options">
                        <div>
                            <input type="radio" name="payment_method" id="pay_cod" value="cod"
                                class="payment-option-input"
                                {{ (old('payment_method', 'cod') === 'cod') ? 'checked' : '' }}>
                            <label class="payment-option-label" for="pay_cod">
                                <span class="pay-icon">
                                    <svg style="width:26px;height:26px;fill:none;stroke:currentColor;stroke-width:1.8;" viewBox="0 0 24 24"><rect x="2" y="7" width="20" height="14" rx="2" ry="2"/><path d="M16 21V5a2 2 0 00-2-2h-4a2 2 0 00-2 2v16"/></svg>
                                </span>
                                <span class="pay-name">Thanh toán COD</span>
                                <span class="pay-desc">Trả tiền khi nhận hàng</span>
                            </label>
                        </div>
                        <div>
                            <input type="radio" name="payment_method" id="pay_banking" value="banking"
                                class="payment-option-input"
                                {{ old('payment_method') === 'banking' ? 'checked' : '' }}>
                            <label class="payment-option-label" for="pay_banking">
                                <span class="pay-icon">
                                    <svg style="width:26px;height:26px;fill:none;stroke:currentColor;stroke-width:1.8;" viewBox="0 0 24 24"><rect x="1" y="4" width="22" height="16" rx="2" ry="2"/><line x1="1" y1="10" x2="23" y2="10"/></svg>
                                </span>
                                <span class="pay-name">Chuyển khoản</span>
                                <span class="pay-desc">Banking / QR Code</span>
                            </label>
                        </div>
                    </div>
                    <div class="field-error @error('payment_method') visible @enderror" id="err_payment">
                        <svg style="width:12px;height:12px;flex-shrink:0;fill:none;stroke:currentColor;stroke-width:2.5;" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
                        <span>@error('payment_method'){{ $message }}@else Vui lòng chọn phương thức thanh toán @enderror</span>
                    </div>
                </div>

                <button type="submit" class="submit-btn">
                    <svg style="width:18px;height:18px;fill:none;stroke:currentColor;stroke-width:2.5;" viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg>
                    Đặt hàng — {{ number_format($total) }}đ
                </button>
            </form>
        </div>
    </div>

</div>

<script>
(function() {
    const form = document.getElementById('checkoutForm');
    if (!form) return;

    const fields = [
        {
            input: document.getElementById('customer_name'),
            error: document.getElementById('err_name'),
            validate: (v) => v.trim().length >= 2 ? null : 'Vui lòng nhập họ và tên (ít nhất 2 ký tự)'
        },
        {
            input: document.getElementById('customer_email'),
            error: document.getElementById('err_email'),
            validate: (v) => /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(v.trim()) ? null : 'Vui lòng nhập địa chỉ email hợp lệ'
        },
        {
            input: document.getElementById('customer_phone'),
            error: document.getElementById('err_phone'),
            validate: (v) => /^[0-9\s\+\-]{9,15}$/.test(v.trim()) ? null : 'Số điện thoại không hợp lệ (9-15 chữ số)'
        },
        {
            input: document.getElementById('customer_address'),
            error: document.getElementById('err_address'),
            validate: (v) => v.trim().length >= 10 ? null : 'Vui lòng nhập địa chỉ giao hàng chi tiết hơn'
        }
    ];

    function showError(field, msg) {
        field.input.classList.add('is-invalid');
        field.error.querySelector('span').textContent = msg;
        field.error.classList.add('visible');
    }

    function clearError(field) {
        field.input.classList.remove('is-invalid');
        field.error.classList.remove('visible');
    }

    // Saved address handling
    const addressRadios = document.querySelectorAll('.address-radio-input');
    const nameInput = document.getElementById('customer_name');
    const phoneInput = document.getElementById('customer_phone');
    const addressInput = document.getElementById('customer_address');

    function updateFieldsFromSelectedRadio(force = false) {
        const checkedRadio = document.querySelector('.address-radio-input:checked');
        if (checkedRadio) {
            const name = checkedRadio.getAttribute('data-name');
            const phone = checkedRadio.getAttribute('data-phone');
            const address = checkedRadio.getAttribute('data-address');
            
            if (checkedRadio.value !== 'new') {
                if (force || ((nameInput.value.trim() === '' || nameInput.value.trim() === "{{ auth()->user()->name ?? '' }}") && phoneInput.value.trim() === '' && addressInput.value.trim() === '')) {
                    nameInput.value = name;
                    phoneInput.value = phone;
                    addressInput.value = address;
                    fields.forEach(clearError);
                }
            } else if (force) {
                nameInput.value = "{{ auth()->user()->name ?? '' }}";
                phoneInput.value = "";
                addressInput.value = "";
                fields.forEach(clearError);
            }
        }
    }

    if (addressRadios.length > 0) {
        addressRadios.forEach(radio => {
            radio.addEventListener('change', () => updateFieldsFromSelectedRadio(true));
        });
        // Initial load check
        updateFieldsFromSelectedRadio();
    }

    // Real-time validation on blur
    fields.forEach(f => {
        f.input.addEventListener('blur', () => {
            const err = f.validate(f.input.value);
            if (err) showError(f, err);
            else clearError(f);
        });
        f.input.addEventListener('input', () => {
            if (f.input.classList.contains('is-invalid')) {
                const err = f.validate(f.input.value);
                if (!err) clearError(f);
            }
        });
    });

    // On submit: validate all
    form.addEventListener('submit', function(e) {
        let valid = true;
        fields.forEach(f => {
            const err = f.validate(f.input.value);
            if (err) { showError(f, err); valid = false; }
            else clearError(f);
        });
        if (!valid) {
            e.preventDefault();
            // Scroll to first error
            const firstErr = form.querySelector('.is-invalid');
            if (firstErr) firstErr.scrollIntoView({ behavior: 'smooth', block: 'center' });
        }
    });
})();
</script>

@endsection
