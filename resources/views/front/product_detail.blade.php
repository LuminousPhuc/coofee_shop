@extends('layouts.app')
@section('content')

<style>
.product-detail-wrap {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 2.5rem;
    align-items: start;
}
.product-img-card {
    background: var(--bg-card);
    border: 1px solid var(--border);
    border-radius: 1.25rem;
    overflow: hidden;
    aspect-ratio: 1;
    display: flex;
    align-items: center;
    justify-content: center;
    position: relative;
}
.product-img-card img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}
.product-img-card .no-img {
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 1rem;
    color: var(--text-muted);
}
.product-info-card {
    background: var(--bg-card);
    border: 1px solid var(--border);
    border-radius: 1.25rem;
    padding: 2rem;
}
.product-category-tag {
    display: inline-block;
    background: rgba(var(--primary-rgb, 212,149,90), 0.15);
    color: var(--primary);
    font-size: 0.75rem;
    font-weight: 600;
    letter-spacing: 0.5px;
    text-transform: uppercase;
    padding: 0.3rem 0.9rem;
    border-radius: 9999px;
    margin-bottom: 1rem;
}
.product-title {
    font-size: 2rem;
    font-weight: 700;
    color: var(--text-primary);
    margin-bottom: 0.5rem;
    line-height: 1.2;
}
.live-price {
    font-size: 1.8rem;
    font-weight: 700;
    color: var(--primary);
    margin-bottom: 1.5rem;
    transition: all 0.2s ease;
}
.option-section {
    margin-bottom: 1.25rem;
}
.option-section-label {
    font-size: 0.8rem;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    color: var(--text-muted);
    margin-bottom: 0.6rem;
    display: flex;
    align-items: center;
    gap: 0.4rem;
}
.option-pills {
    display: flex;
    flex-wrap: wrap;
    gap: 0.5rem;
}
.option-pill-input {
    display: none;
}
.option-pill-label {
    display: inline-flex;
    align-items: center;
    gap: 0.35rem;
    padding: 0.45rem 1rem;
    border-radius: 9999px;
    border: 1.5px solid var(--border);
    background: var(--bg-subtle);
    color: var(--text-secondary);
    font-size: 0.85rem;
    cursor: pointer;
    transition: all 0.15s ease;
    user-select: none;
}
.option-pill-input:checked + .option-pill-label,
.option-pill-label:hover {
    border-color: var(--primary);
    background: rgba(var(--primary-rgb, 212,149,90), 0.12);
    color: var(--primary);
}
.option-pill-input:checked + .option-pill-label {
    font-weight: 600;
}
.topping-chips {
    display: flex;
    flex-wrap: wrap;
    gap: 0.5rem;
}
.topping-chip-input {
    display: none;
}
.topping-chip-label {
    display: inline-flex;
    align-items: center;
    gap: 0.35rem;
    padding: 0.45rem 1rem;
    border-radius: 0.5rem;
    border: 1.5px solid var(--border);
    background: var(--bg-subtle);
    color: var(--text-secondary);
    font-size: 0.85rem;
    cursor: pointer;
    transition: all 0.15s ease;
    user-select: none;
}
.topping-chip-input:checked + .topping-chip-label,
.topping-chip-label:hover {
    border-color: var(--primary);
    background: rgba(var(--primary-rgb, 212,149,90), 0.12);
    color: var(--primary);
}
.topping-chip-input:checked + .topping-chip-label {
    font-weight: 600;
}
.topping-chip-input:checked + .topping-chip-label .chip-check {
    display: inline-flex;
}
.chip-check {
    display: none;
    align-items: center;
    justify-content: center;
    width: 14px;
    height: 14px;
    background: var(--primary);
    color: white;
    border-radius: 50%;
}
.qty-row {
    display: flex;
    align-items: center;
    gap: 0.75rem;
    margin-bottom: 1.25rem;
}
.qty-btn {
    width: 36px;
    height: 36px;
    border-radius: 50%;
    border: 1.5px solid var(--border);
    background: var(--bg-subtle);
    color: var(--text-primary);
    font-size: 1.1rem;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: all 0.15s;
}
.qty-btn:hover {
    border-color: var(--primary);
    color: var(--primary);
}
.qty-input {
    width: 60px;
    text-align: center;
    border: 1.5px solid var(--border);
    background: var(--bg-subtle);
    color: var(--text-primary);
    border-radius: 0.5rem;
    padding: 0.4rem;
    font-size: 1rem;
    font-weight: 600;
}
.add-cart-btn {
    width: 100%;
    padding: 0.9rem;
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
    letter-spacing: 0.3px;
}
.add-cart-btn:hover {
    opacity: 0.9;
    transform: translateY(-1px);
    box-shadow: 0 6px 20px rgba(0,0,0,0.2);
}
.section-divider {
    border: none;
    border-top: 1px solid var(--border);
    margin: 1.25rem 0;
}
.price-breakdown {
    background: var(--bg-subtle);
    border-radius: 0.75rem;
    padding: 0.9rem 1.1rem;
    margin-bottom: 1.25rem;
    font-size: 0.85rem;
    color: var(--text-muted);
}
.price-breakdown .pb-row {
    display: flex;
    justify-content: space-between;
    margin-bottom: 0.3rem;
}
.price-breakdown .pb-total {
    display: flex;
    justify-content: space-between;
    font-weight: 700;
    color: var(--text-primary);
    font-size: 0.95rem;
    border-top: 1px solid var(--border);
    padding-top: 0.5rem;
    margin-top: 0.5rem;
}
@media (max-width: 768px) {
    .product-detail-wrap { grid-template-columns: 1fr; }
    .product-title { font-size: 1.5rem; }
}
</style>

<div style="margin-bottom:1.25rem;">
    <a href="{{ url()->previous() == url()->current() ? route('front.shop') : url()->previous() }}" class="btn btn-outline btn-sm">
        <svg style="width:14px;height:14px;fill:none;stroke:currentColor;stroke-width:2.5;" viewBox="0 0 24 24"><path d="M19 12H5M12 5l-7 7 7 7"/></svg>
        Quay lại
    </a>
</div>

<div class="product-detail-wrap">
    {{-- LEFT: Product Image --}}
    <div class="product-img-card">
        @if($product->image_url)
            <img src="{{ $product->image_url }}" alt="{{ $product->name }}">
        @else
            <div class="no-img">
                <svg style="width:80px;height:80px;fill:none;stroke:var(--text-muted);stroke-width:1.2;" viewBox="0 0 24 24"><path d="M18 8h1a4 4 0 010 8h-1M2 8h16v9a4 4 0 01-4 4H6a4 4 0 01-4-4V8z"></path><line x1="6" y1="2" x2="6" y2="8"/><line x1="10" y1="2" x2="10" y2="8"/><line x1="14" y1="2" x2="14" y2="8"/></svg>
                <span>Chưa có ảnh</span>
            </div>
        @endif
        @if($product->is_bestseller)
            <span style="position:absolute;top:1rem;left:1rem;background:var(--primary);color:white;font-size:0.7rem;font-weight:700;padding:0.3rem 0.8rem;border-radius:9999px;text-transform:uppercase;letter-spacing:0.5px;display:inline-flex;align-items:center;gap:0.3rem;">
                <svg style="width:10px;height:10px;fill:white;stroke:none;" viewBox="0 0 24 24"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/></svg>
                Best Seller
            </span>
        @endif
    </div>

    {{-- RIGHT: Info & Order Form --}}
    <div class="product-info-card">
        <span class="product-category-tag">{{ $product->category->name ?? 'Đồ uống' }}</span>
        <h1 class="product-title">{{ $product->name }}</h1>
        <div class="live-price" id="livePrice">{{ number_format($product->base_price) }}đ</div>

        <form action="{{ route('cart.add', $product->id) }}" method="POST" id="add-to-cart-form">
            @csrf

            {{-- Hidden base price for JS calculation --}}
            <input type="hidden" id="basePrice" value="{{ $product->base_price }}">

            {{-- Option Groups --}}
            @foreach($product->optionGroups as $group)
                <div class="option-section" 
                     data-group-id="{{ $group->id }}" 
                     data-group-name="{{ Str::lower($group->name) }}">
                    <div class="option-section-label">
                        <svg style="width:13px;height:13px;fill:none;stroke:currentColor;stroke-width:2.5;" viewBox="0 0 24 24"><circle cx="12" cy="12" r="3"/><path d="M12 2v2M12 20v2M4.22 4.22l1.42 1.42M18.36 18.36l1.42 1.42M2 12h2M20 12h2M4.22 19.78l1.42-1.42M18.36 5.64l1.42-1.42"/></svg>
                        {{ $group->name }}
                    </div>
                    <div class="option-pills">
                        @foreach($group->optionValues as $val)
                            <div>
                                <input type="radio" 
                                    class="option-pill-input price-option" 
                                    name="options[{{ $group->id }}]" 
                                    id="opt_{{ $val->id }}" 
                                    value="{{ $val->id }}"
                                    data-price="{{ $val->price_adjustment }}"
                                    data-group="{{ $group->id }}"
                                    data-value-name="{{ Str::lower($val->name) }}"
                                    {{ $val->is_default ? 'checked' : '' }}>
                                <label class="option-pill-label" for="opt_{{ $val->id }}">
                                    {{ $val->name }}
                                    @if($val->price_adjustment > 0)
                                        <span style="opacity:0.7;font-size:0.75rem;">+{{ number_format($val->price_adjustment) }}đ</span>
                                    @endif
                                </label>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endforeach

            {{-- Toppings --}}
            @if($product->allow_topping && $toppings->count())
                <hr class="section-divider">
                <div class="option-section">
                    <div class="option-section-label">
                        <svg style="width:13px;height:13px;fill:none;stroke:currentColor;stroke-width:2;" viewBox="0 0 24 24"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>
                        Topping (tuỳ chọn)
                    </div>
                    <div class="topping-chips">
                        @foreach($toppings as $tp)
                            <div>
                                <input type="checkbox" 
                                    class="topping-chip-input price-topping" 
                                    name="toppings[]" 
                                    id="tp_{{ $tp->id }}" 
                                    value="{{ $tp->id }}"
                                    data-price="{{ $tp->price }}">
                                <label class="topping-chip-label" for="tp_{{ $tp->id }}">
                                    <span class="chip-check">
                                        <svg style="width:8px;height:8px;fill:none;stroke:white;stroke-width:3;" viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg>
                                    </span>
                                    {{ $tp->name }}
                                    <span style="opacity:0.7;font-size:0.75rem;">+{{ number_format($tp->price) }}đ</span>
                                </label>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

            <hr class="section-divider">

            {{-- Quantity --}}
            <div class="option-section">
                <div class="option-section-label">Số lượng</div>
                <div class="qty-row">
                    <button type="button" class="qty-btn" id="qtyMinus">−</button>
                    <input type="number" name="quantity" id="qtyInput" class="qty-input" value="1" min="1" max="20" readonly>
                    <button type="button" class="qty-btn" id="qtyPlus">+</button>
                    <span style="color:var(--text-muted);font-size:0.85rem;">sản phẩm</span>
                </div>
            </div>

            {{-- Price Breakdown --}}
            <div class="price-breakdown" id="priceBreakdown" style="display:none;">
                <div id="pbBase" class="pb-row"><span>Giá gốc</span><span></span></div>
                <div id="pbOptions"></div>
                <div id="pbToppings"></div>
                <div id="pbQty" class="pb-row"><span>Số lượng</span><span></span></div>
                <div class="pb-total"><span>Tổng cộng</span><span id="pbTotal"></span></div>
            </div>

            @if(session('success'))
                <div style="background:rgba(74,222,128,0.1);border:1px solid rgba(74,222,128,0.3);border-radius:0.5rem;padding:0.75rem 1rem;color:#4ade80;font-size:0.875rem;margin-bottom:1rem;display:flex;align-items:center;gap:0.5rem;">
                    <svg style="width:16px;height:16px;flex-shrink:0;fill:none;stroke:currentColor;stroke-width:2.5;" viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg>
                    {{ session('success') }}
                </div>
            @endif

            <button type="submit" class="add-cart-btn">
                <svg style="width:18px;height:18px;fill:none;stroke:currentColor;stroke-width:2.5;" viewBox="0 0 24 24"><path d="M6 2L3 6v14a2 2 0 002 2h14a2 2 0 002-2V6l-3-4H6zM3 6h18M16 10a4 4 0 01-8 0"></path></svg>
                Thêm vào giỏ hàng
            </button>
        </form>
    </div>
</div>

<script>
(function() {
    const basePrice = parseInt(document.getElementById('basePrice').value) || 0;
    const livePriceEl = document.getElementById('livePrice');
    const qtyInput = document.getElementById('qtyInput');
    const priceBreakdown = document.getElementById('priceBreakdown');

    function formatMoney(v) {
        return v.toLocaleString('vi-VN') + 'đ';
    }

    function calcPrice() {
        let optionExtra = 0;
        const optionLines = [];

        // Options (radio - one per group)
        document.querySelectorAll('.price-option:checked').forEach(el => {
            const adj = parseInt(el.dataset.price) || 0;
            if (adj > 0) {
                optionExtra += adj;
                const label = document.querySelector('label[for="' + el.id + '"]');
                optionLines.push({ name: label ? label.innerText.trim() : '', price: adj });
            }
        });

        // Toppings (checkbox - multiple)
        let toppingExtra = 0;
        const toppingLines = [];
        document.querySelectorAll('.price-topping:checked').forEach(el => {
            const p = parseInt(el.dataset.price) || 0;
            toppingExtra += p;
            const label = document.querySelector('label[for="' + el.id + '"]');
            toppingLines.push({ name: label ? label.querySelector('.topping-chip-label') ? el.id : label.innerText.trim() : '', price: p });
        });

        const qty = parseInt(qtyInput.value) || 1;
        const unitPrice = basePrice + optionExtra + toppingExtra;
        const total = unitPrice * qty;

        livePriceEl.textContent = formatMoney(unitPrice);

        // Build breakdown if extras exist or qty > 1
        const hasExtras = optionLines.length > 0 || toppingLines.length > 0 || qty > 1;
        priceBreakdown.style.display = hasExtras ? 'block' : 'none';

        if (hasExtras) {
            document.querySelector('#pbBase span:last-child').textContent = formatMoney(basePrice);
            
            // Options
            const pbOpts = document.getElementById('pbOptions');
            pbOpts.innerHTML = '';
            optionLines.forEach(o => {
                const row = document.createElement('div');
                row.className = 'pb-row';
                row.innerHTML = '<span>' + o.name + '</span><span>+' + formatMoney(o.price) + '</span>';
                pbOpts.appendChild(row);
            });

            // Toppings
            const pbTops = document.getElementById('pbToppings');
            pbTops.innerHTML = '';
            document.querySelectorAll('.price-topping:checked').forEach(el => {
                const p = parseInt(el.dataset.price) || 0;
                const labelEl = document.querySelector('label[for="' + el.id + '"]');
                const name = labelEl ? labelEl.textContent.trim().replace(/\+[\d.,]+đ/,'').trim() : '';
                const row = document.createElement('div');
                row.className = 'pb-row';
                row.innerHTML = '<span>↳ ' + name + '</span><span>+' + formatMoney(p) + '</span>';
                pbTops.appendChild(row);
            });

            document.querySelector('#pbQty span:last-child').textContent = '× ' + qty;
            document.getElementById('pbTotal').textContent = formatMoney(total);
        }
    }

    // === Ice group visibility (Blade-injected IDs for 100% reliability) ===
    @php
        $hotVal = null;
        $tempGrp = null;
        $iceGrp  = null;
        foreach($product->optionGroups as $g) {
            $gLower = mb_strtolower($g->name);
            if (str_contains($gLower, 'nhiệt')) {
                $tempGrp = $g;
                foreach($g->optionValues as $v) {
                    if (mb_strtolower($v->name) === 'nóng') { $hotVal = $v; break; }
                }
            }
            if (str_contains($gLower, 'mức đá') || $gLower === 'đá' || str_contains($gLower, 'mức ')) {
                $iceGrp = $g;
            }
        }
    @endphp

    @if($tempGrp && $iceGrp && $hotVal)
    const _tempGroupEl = document.querySelector('.option-section[data-group-id="{{ $tempGrp->id }}"]');
    const _iceGroupEl  = document.querySelector('.option-section[data-group-id="{{ $iceGrp->id }}"]');
    const _hotInputId  = 'opt_{{ $hotVal->id }}';

    function syncIceGroup() {
        if (!_tempGroupEl || !_iceGroupEl) return;
        const isHot = document.getElementById(_hotInputId)?.checked;
        if (isHot) {
            _iceGroupEl.style.transition = 'opacity 0.2s';
            _iceGroupEl.style.opacity = '0.3';
            _iceGroupEl.style.pointerEvents = 'none';
            _iceGroupEl.querySelectorAll('input[type=radio]').forEach(r => { r.disabled = true; r.checked = false; });
            _iceGroupEl.querySelectorAll('.option-pill-label').forEach(l => l.style.cursor = 'not-allowed');
            if (!_iceGroupEl.querySelector('.ice-na-badge')) {
                const b = document.createElement('span');
                b.className = 'ice-na-badge';
                b.textContent = '— không áp dụng';
                b.style.cssText = 'font-size:0.72rem;color:var(--text-muted);margin-left:0.4rem;font-weight:400;text-transform:none;letter-spacing:0;font-style:italic;';
                _iceGroupEl.querySelector('div').appendChild(b);
            }
        } else {
            _iceGroupEl.style.opacity = '1';
            _iceGroupEl.style.pointerEvents = '';
            _iceGroupEl.querySelectorAll('input[type=radio]').forEach(r => r.disabled = false);
            _iceGroupEl.querySelectorAll('.option-pill-label').forEach(l => l.style.cursor = 'pointer');
            const def = _iceGroupEl.querySelector('input[type=radio]:not(:checked)');
            const first = _iceGroupEl.querySelector('input[type=radio]');
            if (first && !_iceGroupEl.querySelector('input[type=radio]:checked')) first.checked = true;
            _iceGroupEl.querySelector('.ice-na-badge')?.remove();
        }
        calcPrice();
    }
    @else
    function syncIceGroup() {}
    @endif

    // Bind all option & topping changes
    document.querySelectorAll('.price-option, .price-topping').forEach(el => {
        el.addEventListener('change', function() { syncIceGroup(); calcPrice(); });
    });

    document.getElementById('qtyMinus').addEventListener('click', function() {
        const v = parseInt(qtyInput.value) || 1;
        if (v > 1) { qtyInput.value = v - 1; calcPrice(); }
    });
    document.getElementById('qtyPlus').addEventListener('click', function() {
        const v = parseInt(qtyInput.value) || 1;
        if (v < 20) { qtyInput.value = v + 1; calcPrice(); }
    });

    // Initialize on load
    syncIceGroup();
    calcPrice();
})();
</script>

@endsection
