@extends('layouts.app')
@section('content')

    <div class="mb-3">
        <a href="{{ route('admin.products.index') }}" class="btn btn-outline btn-sm">← Quay lại danh sách</a>
    </div>

    <div style="display:grid; grid-template-columns:1fr 380px; gap:2rem; align-items:start;">

        {{-- LEFT: FORM --}}
        <div class="card">
            <div class="card-header">
                <h1 class="card-title" style="display: flex; align-items: center; gap: 0.5rem;">
                    <svg style="width: 20px; height: 20px; fill: none; stroke: var(--primary); stroke-width: 2.5;" viewBox="0 0 24 24"><path d="M11 4H4a2 2 0 00-2 2v14a2 2 0 002 2h14a2 2 0 002-2v-7"></path><path d="M18.5 2.5a2.121 2.121 0 113 3L12 15l-4 1 1-4 9.5-9.5z"></path></svg>
                    Sửa sản phẩm: {{ $product->name }}
                </h1>
            </div>

            <form action="{{ route('admin.products.update', $product) }}" method="POST">
                @csrf @method('PUT')

                <div class="form-group">
                    <label for="name">Tên sản phẩm *</label>
                    <input type="text" name="name" id="name" value="{{ old('name', $product->name) }}" required>
                    @error('name') <span class="error-text">{{ $message }}</span> @enderror
                </div>

                <div style="display:grid; grid-template-columns:1fr 1fr; gap:1rem;">
                    <div class="form-group">
                        <label for="category_id">Danh mục *</label>
                        <select name="category_id" id="category_id" required>
                            <option value="">-- Chọn danh mục --</option>
                            @foreach($categories as $cat)
                                <option value="{{ $cat->id }}" {{ old('category_id', $product->category_id) == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                            @endforeach
                        </select>
                        @error('category_id') <span class="error-text">{{ $message }}</span> @enderror
                    </div>
                    <div class="form-group">
                        <label for="base_price">Giá cơ bản (VNĐ) *</label>
                        <input type="number" name="base_price" id="base_price" value="{{ old('base_price', $product->base_price) }}" required min="0" step="1000">
                        @error('base_price') <span class="error-text">{{ $message }}</span> @enderror
                    </div>
                </div>

                <div class="form-group">
                    <label for="slug">Slug URL *</label>
                    <input type="text" name="slug" id="slug" value="{{ old('slug', $product->slug) }}" required>
                    @error('slug') <span class="error-text">{{ $message }}</span> @enderror
                </div>

                <div class="form-group">
                    <label for="image_url">URL / Đường dẫn hình ảnh</label>
                    <input type="text" name="image_url" id="image_url" value="{{ old('image_url', $product->image_url) }}"
                           placeholder="Nhấp chọn ảnh từ thư viện bên phải..."
                           oninput="updatePreview(this.value)">
                    @error('image_url') <span class="error-text">{{ $message }}</span> @enderror
                </div>

                @if($optionGroups->count())
                    <div class="form-group">
                        <label>Nhóm tùy chọn (Size, Đường, Đá...)</label>
                        <div class="check-group">
                            @foreach($optionGroups as $group)
                                <label class="check-item">
                                    <input type="checkbox" name="option_groups[]" value="{{ $group->id }}"
                                        {{ in_array($group->id, old('option_groups', $selectedGroups)) ? 'checked' : '' }}>
                                    {{ $group->name }}
                                    <span class="text-muted text-xs">({{ $group->optionValues->count() }} lựa chọn)</span>
                                </label>
                            @endforeach
                        </div>
                    </div>
                @endif

                <div style="display:grid; grid-template-columns:1fr 1fr; gap:1rem;" class="mb-3">
                    <div class="form-group" style="margin-bottom:0;">
                        <label class="check-item">
                            <input type="checkbox" name="allow_topping" value="1" {{ old('allow_topping', $product->allow_topping) ? 'checked' : '' }}>
                            Cho phép thêm topping
                        </label>
                    </div>
                    <div class="form-group" style="margin-bottom:0;">
                        <label class="check-item">
                            <input type="checkbox" name="is_active" value="1" {{ old('is_active', $product->is_active) ? 'checked' : '' }}>
                            Hiển thị sản phẩm
                        </label>
                    </div>
                </div>

                <div class="form-group mb-3">
                    <label class="check-item">
                        <input type="checkbox" name="is_bestseller" value="1" {{ old('is_bestseller', $product->is_bestseller) ? 'checked' : '' }}>
                        Sản phẩm nổi bật / Best Seller
                    </label>
                </div>

                <button type="submit" class="btn btn-primary" style="width:100%; padding:0.85rem; display: inline-flex; align-items: center; justify-content: center; gap: 0.5rem;">
                    <svg style="width: 18px; height: 18px; fill: none; stroke: currentColor; stroke-width: 2.5;" viewBox="0 0 24 24"><path d="M19 21H5a2 2 0 01-2-2V5a2 2 0 012-2h11l5 5v11a2 2 0 01-2 2z"></path><path d="M17 21v-8H7v8M7 3v5h8"></path></svg>
                    Cập nhật sản phẩm
                </button>
            </form>
        </div>

        {{-- RIGHT: IMAGE PICKER --}}
        <div>
            <div class="card mb-2" style="margin-bottom:1rem;">
                <p class="text-xs text-dim font-bold" style="text-transform:uppercase; letter-spacing:0.5px; margin-bottom:0.75rem;">Xem trước ảnh</p>
                <div id="img-preview" style="width:100%; aspect-ratio:1; border-radius:0.75rem; overflow:hidden; background:linear-gradient(135deg,#fef3c7,#fed7aa); display:flex; align-items:center; justify-content:center; font-size:3rem; border:2px dashed var(--border);">
                    @if($product->image_url)
                        <img src="{{ old('image_url', $product->image_url) }}" style="width:100%; height:100%; object-fit:cover;">
                    @else
                        <svg style="width:56px;height:56px;fill:none;stroke:var(--text-muted);stroke-width:1.2;opacity:0.5;" viewBox="0 0 24 24"><path d="M18 8h1a4 4 0 010 8h-1M2 8h16v9a4 4 0 01-4 4H6a4 4 0 01-4-4V8z"/><line x1="6" y1="2" x2="6" y2="8"/><line x1="10" y1="2" x2="10" y2="8"/><line x1="14" y1="2" x2="14" y2="8"/></svg>
                    @endif
                </div>
            </div>

            @if(!empty($localImages))
                <div class="card" style="padding:1rem;">
                    <p class="text-xs font-bold text-dim" style="text-transform:uppercase; letter-spacing:0.5px; margin-bottom:0.75rem;">Thư viện ảnh ({{ count($localImages) }} ảnh)</p>
                    <div style="display:grid; grid-template-columns:repeat(4,1fr); gap:0.5rem; max-height:400px; overflow-y:auto; padding-right:0.25rem;">
                        @foreach($localImages as $img)
                            @php $fullUrl = asset($img); @endphp
                            <div class="gallery-thumb {{ old('image_url', $product->image_url) == $fullUrl ? 'selected' : '' }}"
                                 onclick="selectImg('{{ $fullUrl }}', this)"
                                 style="aspect-ratio:1; border-radius:0.5rem; overflow:hidden; cursor:pointer; border:2px solid transparent; transition:all 0.2s; background:var(--bg-subtle);">
                                <img src="{{ $fullUrl }}" alt="img" style="width:100%;height:100%;object-fit:cover; display:block;">
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>

    </div>

    @push('styles')
    <style>
        .gallery-thumb:hover { border-color: var(--primary-light) !important; transform: scale(0.97); }
        .gallery-thumb.selected { border-color: var(--primary) !important; box-shadow: 0 0 0 3px rgba(194,65,12,0.15); }
        @media (max-width: 900px) {
            div[style*="grid-template-columns:1fr 380px"] { grid-template-columns: 1fr !important; }
        }
    </style>
    @endpush

    @push('scripts')
    <script>
        function selectImg(url, el) {
            document.getElementById('image_url').value = url;
            updatePreview(url);
            document.querySelectorAll('.gallery-thumb').forEach(t => t.classList.remove('selected'));
            el.classList.add('selected');
        }

        function updatePreview(url) {
            const box = document.getElementById('img-preview');
            if (url && url.trim()) {
                box.innerHTML = `<img src="${url}" style="width:100%;height:100%;object-fit:cover;" onerror="this.parentElement.innerHTML='<svg style=\'width:40px;height:40px;fill:none;stroke:#ef4444;stroke-width:2;\' viewBox=\'0 0 24 24\'><circle cx=\'12\' cy=\'12\' r=\'10\'/><line x1=\'15\' y1=\'9\' x2=\'9\' y2=\'15\'/><line x1=\'9\' y1=\'9\' x2=\'15\' y2=\'15\'/></svg>'`+`>`;
            } else {
                box.innerHTML = '<svg style="width:56px;height:56px;fill:none;stroke:var(--text-muted);stroke-width:1.2;opacity:0.5;" viewBox="0 0 24 24"><path d="M18 8h1a4 4 0 010 8h-1M2 8h16v9a4 4 0 01-4 4H6a4 4 0 01-4-4V8z"/><line x1="6" y1="2" x2="6" y2="8"/><line x1="10" y1="2" x2="10" y2="8"/><line x1="14" y1="2" x2="14" y2="8"/></svg>';
            }
        }
    </script>
    @endpush
@endsection
