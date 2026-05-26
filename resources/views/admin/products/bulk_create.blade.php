@extends('layouts.app')
@section('content')

    <div class="mb-3">
        <a href="{{ route('admin.products.index') }}" class="btn btn-outline btn-sm" style="display: inline-flex; align-items: center; gap: 0.35rem;">
            <svg style="width: 14px; height: 14px; fill: none; stroke: currentColor; stroke-width: 2;" viewBox="0 0 24 24"><path d="M19 12H5M12 19l-7-7 7-7"></path></svg>
            Quay lại danh sách
        </a>
    </div>

    <div class="flex-between mb-4">
        <div>
            <h1 class="page-title" style="display: flex; align-items: center; gap: 0.5rem;">
                <svg style="width: 28px; height: 28px; fill: none; stroke: var(--primary); stroke-width: 2.5;" viewBox="0 0 24 24"><path d="M13 2L3 14h9l-1 8 10-12h-9l1-8z"></path></svg>
                Thêm nhiều sản phẩm nhanh
            </h1>
            <p class="page-sub">Nhấp chọn các hình ảnh có sẵn bên phải để tạo nhanh hàng loạt sản phẩm tương ứng!</p>
        </div>
    </div>

    <div style="display:grid; grid-template-columns: 1fr 340px; gap: 2rem; align-items: start;">

        {{-- LEFT: DYNAMIC PRODUCTS FORM --}}
        <div>
            <form action="{{ route('admin.products.bulk-store') }}" method="POST" id="bulkForm">
                @csrf

                <div id="bulkTableBody" style="display: flex; flex-direction: column; gap: 1.5rem; margin-bottom: 2rem;">
                    {{-- Empty State --}}
                    <div id="emptyRow" class="card" style="text-align: center; padding: 4rem 2rem; color: var(--text-muted); border: 2px dashed var(--border);">
                        <svg style="width: 48px; height: 48px; fill: none; stroke: var(--text-muted); stroke-width: 1.5; margin: 0 auto 1rem auto; display: block;" viewBox="0 0 24 24"><path d="M23 19a2 2 0 01-2 2H3a2 2 0 01-2-2V8a2 2 0 012-2h4l2-3h6l2 3h4a2 2 0 012 2z"></path><circle cx="12" cy="13" r="4"></circle></svg>
                        <p class="font-bold" style="color: var(--text); font-size: 1.1rem;">Thư viện trống hoặc chưa chọn ảnh</p>
                        <p class="text-sm text-dim mt-1">Hãy nhấp chọn các hình ảnh ở cột bên phải để tự động thêm các dòng sản phẩm.</p>
                    </div>
                </div>

                <div class="flex-between">
                    <button type="button" class="btn btn-outline" onclick="addBlankRow()" style="display: inline-flex; align-items: center; gap: 0.35rem;">
                        <svg style="width: 16px; height: 16px; fill: none; stroke: currentColor; stroke-width: 2.5;" viewBox="0 0 24 24"><path d="M12 5v14M5 12h14"></path></svg>
                        Thêm dòng trống
                    </button>
                    <button type="submit" class="btn btn-primary" id="btnSubmit" style="display: none; padding: 0.8rem 2.5rem; font-size: 1rem; align-items: center; gap: 0.5rem;">
                        <svg style="width: 18px; height: 18px; fill: none; stroke: currentColor; stroke-width: 2.5;" viewBox="0 0 24 24"><path d="M19 21H5a2 2 0 01-2-2V5a2 2 0 012-2h11l5 5v11a2 2 0 01-2 2z"></path><path d="M17 21v-8H7v8M7 3v5h8"></path></svg>
                        Lưu tất cả sản phẩm (<span id="submitCount">0</span>)
                    </button>
                </div>
            </form>
        </div>

        {{-- RIGHT: IMAGE LIBRARY PICKER --}}
        <div>
            @if(!empty($localImages))
                <div class="card" style="padding: 1.5rem;">
                    <div class="flex-between mb-3">
                        <p class="text-xs font-bold text-dim" style="text-transform: uppercase; letter-spacing: 0.8px; display: inline-flex; align-items: center; gap: 0.35rem;">
                            <svg style="width: 14px; height: 14px; fill: none; stroke: currentColor; stroke-width: 2;" viewBox="0 0 24 24"><path d="M23 19a2 2 0 01-2 2H3a2 2 0 01-2-2V8a2 2 0 012-2h4l2-3h6l2 3h4a2 2 0 012 2z"></path><circle cx="12" cy="13" r="4"></circle></svg>
                            Thư viện ảnh ({{ count($localImages) }})
                        </p>
                        <button type="button" class="btn btn-xs btn-outline" onclick="selectAllImages()">Chọn tất cả</button>
                    </div>
                    <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 0.5rem; max-height: 520px; overflow-y: auto; padding-right: 0.25rem;">
                        @foreach($localImages as $img)
                            @php $fullUrl = asset($img); @endphp
                            <div class="gallery-thumb-item" data-path="{{ $fullUrl }}" data-filename="{{ basename($img, '.png') }}" onclick="toggleLibraryImage(this)"
                                 style="aspect-ratio: 1; border-radius: 0.5rem; overflow: hidden; cursor: pointer; border: 2.5px solid transparent; transition: all 0.2s; background: var(--bg-subtle); position: relative;">
                                <img src="{{ $fullUrl }}" alt="img" style="width: 100%; height: 100%; object-fit: cover; display: block;">
                                <div class="check-overlay" style="position: absolute; top: 0; left: 0; right: 0; bottom: 0; background: rgba(194,65,12,0.15); display: none; align-items: center; justify-content: center; color: white;">
                                    <svg style="width: 24px; height: 24px; fill: none; stroke: currentColor; stroke-width: 3.5;" viewBox="0 0 24 24"><path d="M20 6L9 17l-5-5"></path></svg>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @else
                <div class="card" style="text-align: center; padding: 2.5rem 1.5rem;">
                    <svg style="width: 48px; height: 48px; fill: none; stroke: var(--text-muted); stroke-width: 1.5; margin: 0 auto 1rem auto; display: block;" viewBox="0 0 24 24"><path d="M22 19a2 2 0 01-2 2H4a2 2 0 01-2-2V5a2 2 0 012-2h5l2 3h9a2 2 0 012 2z"></path></svg>
                    <p class="text-sm text-dim">Không có ảnh nào trong public/img/products/</p>
                </div>
            @endif
        </div>

    </div>

    @push('styles')
    <style>
        .gallery-thumb-item:hover { border-color: var(--primary-light); transform: scale(0.96); }
        .gallery-thumb-item.active { border-color: var(--primary); }
        .gallery-thumb-item.active .check-overlay { display: flex !important; }
    </style>
    @endpush

    @push('scripts')
    <script>
        let rowIdx = 0;
        const categories = @json($categories);
        const optionGroups = @json($optionGroups);

        function updateEmptyState() {
            const body = document.getElementById('bulkTableBody');
            const rows = body.querySelectorAll('.bulk-row');
            const empty = document.getElementById('emptyRow');
            const btnSubmit = document.getElementById('btnSubmit');
            const submitCount = document.getElementById('submitCount');

            if (rows.length === 0) {
                empty.style.display = 'block';
                btnSubmit.style.display = 'none';
            } else {
                empty.style.display = 'none';
                btnSubmit.style.display = 'inline-flex';
                submitCount.innerText = rows.length;
            }
        }

        function toggleLibraryImage(element) {
            const path = element.dataset.path;
            const filename = element.dataset.filename;

            if (element.classList.contains('active')) {
                // Find and remove matching card
                const row = document.querySelector(`.bulk-row[data-image="${path}"]`);
                if (row) row.remove();
                element.classList.remove('active');
            } else {
                // Add new card with this image
                element.classList.add('active');
                addRow(path, filename);
            }
            updateEmptyState();
        }

        function selectAllImages() {
            document.querySelectorAll('.gallery-thumb-item').forEach(item => {
                if (!item.classList.contains('active')) {
                    toggleLibraryImage(item);
                }
            });
        }

        function addRow(imagePath = '', defaultName = '') {
            const body = document.getElementById('bulkTableBody');
            
            // Format name from filename (capitalize words)
            let formattedName = defaultName
                .replace(/[-_]/g, ' ')
                .split(' ')
                .map(word => word.charAt(0).toUpperCase() + word.slice(1))
                .join(' ');

            const div = document.createElement('div');
            div.className = 'card bulk-row';
            div.dataset.image = imagePath;
            div.style.cssText = 'padding: 1.5rem; position: relative; display: grid; grid-template-columns: 100px 1fr; gap: 1.5rem; align-items: start;';
            div.innerHTML = `
                <!-- Image Box -->
                <div style="position: relative;">
                    ${imagePath ? `<img src="${imagePath}" style="width: 100px; height: 100px; object-fit: cover; border-radius: 0.5rem; border: 1px solid var(--border);">` : `<div style="width: 100px; height: 100px; display: flex; align-items: center; justify-content: center; background: var(--bg-subtle); border-radius: 0.5rem; color: var(--text-dim);"><svg style="width: 32px; height: 32px; fill: none; stroke: currentColor; stroke-width: 1.5;" viewBox="0 0 24 24"><path d="M18 8h1a4 4 0 018 0v1a4 4 0 01-4 4h-5m-9-5h14a1 1 0 011 1v7a8 8 0 01-8 8H7a8 8 0 01-8-8V9a1 1 0 011-1z"></path></svg></div>`}
                    <input type="hidden" name="products[${rowIdx}][image_url]" value="${imagePath}">
                </div>

                <!-- Inputs Grid -->
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem;">
                    <div class="form-group" style="grid-column: span 2; margin-bottom: 0;">
                        <label style="font-size: 0.75rem;">Tên sản phẩm *</label>
                        <input type="text" name="products[${rowIdx}][name]" value="${formattedName}" placeholder="Tên món..." required>
                    </div>
                    
                    <div class="form-group" style="margin-bottom: 0;">
                        <label style="font-size: 0.75rem;">Danh mục *</label>
                        <select name="products[${rowIdx}][category_id]" required>
                            <option value="">-- Chọn danh mục --</option>
                            ${categories.map(c => `<option value="${c.id}">${c.name}</option>`).join('')}
                        </select>
                    </div>

                    <div class="form-group" style="margin-bottom: 0;">
                        <label style="font-size: 0.75rem;">Giá bán (đ) *</label>
                        <input type="number" name="products[${rowIdx}][base_price]" placeholder="45000" required min="0" step="1000">
                    </div>

                    <div class="form-group" style="grid-column: span 2; margin-bottom: 0; padding-top: 0.75rem; border-top: 1px dashed var(--border); margin-top: 0.25rem;">
                        <label style="font-size: 0.75rem; margin-bottom: 0.75rem;">Tùy chọn & Trạng thái</label>
                        <div style="display: flex; flex-wrap: wrap; gap: 1.5rem; align-items: center;">
                            ${optionGroups.map(og => `
                                <label class="check-item" style="font-size: 0.85rem; font-weight: 500; margin-bottom: 0;">
                                    <input type="checkbox" name="products[${rowIdx}][option_groups][]" value="${og.id}" checked>
                                    ${og.name}
                                </label>
                            `).join('')}
                            <label class="check-item" style="font-size: 0.85rem; font-weight: 500; margin-bottom: 0; margin-left: auto;">
                                <input type="checkbox" name="products[${rowIdx}][allow_topping]" value="1" checked>
                                Thêm Topping
                            </label>
                            <label class="check-item" style="font-size: 0.85rem; font-weight: 500; margin-bottom: 0;">
                                <input type="checkbox" name="products[${rowIdx}][is_bestseller]" value="1">
                                Bestseller
                            </label>
                            <label class="check-item" style="font-size: 0.85rem; font-weight: 500; margin-bottom: 0;">
                                <input type="checkbox" name="products[${rowIdx}][is_active]" value="1" checked>
                                Hiển thị
                            </label>
                        </div>
                    </div>
                </div>

                <!-- Close button -->
                <button type="button" class="btn-remove" onclick="removeRow(this, '${imagePath}')" style="position: absolute; top: 1rem; right: 1rem; width: 28px; height: 28px; border-radius: 50%; border: 1.5px solid var(--border); background: white; color: var(--text-dim); display: flex; align-items: center; justify-content: center; cursor: pointer; transition: all 0.2s;">
                    <svg style="width: 14px; height: 14px; fill: none; stroke: currentColor; stroke-width: 2.5;" viewBox="0 0 24 24"><path d="M18 6L6 18M6 6l12 12"></path></svg>
                </button>
            `;
            body.appendChild(div);
            rowIdx++;
            updateEmptyState();
        }

        function addBlankRow() {
            addRow('', 'Sản phẩm mới');
        }

        function removeRow(button, imagePath) {
            const card = button.closest('.bulk-row');
            card.remove();

            // Deselect in library if matches
            if (imagePath) {
                const item = document.querySelector(`.gallery-thumb-item[data-path="${imagePath}"]`);
                if (item) item.classList.remove('active');
            }
            updateEmptyState();
        }
    </script>
    @endpush
@endsection
