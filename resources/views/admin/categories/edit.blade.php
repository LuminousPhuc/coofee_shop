@extends('layouts.app')
@section('content')
    <div class="mb-3">
        <a href="{{ route('admin.categories.index') }}" class="btn btn-outline btn-sm">← Quay lại</a>
    </div>

    <div class="card" style="max-width:600px;">
        <h1 style="font-size:1.5rem; margin-bottom:1.5rem;">Sửa danh mục: {{ $category->name }}</h1>

        <form action="{{ route('admin.categories.update', $category) }}" method="POST">
            @csrf @method('PUT')

            <div class="form-group">
                <label for="name">Tên danh mục *</label>
                <input type="text" name="name" id="name" value="{{ old('name', $category->name) }}" required>
                @error('name') <p class="error-text">{{ $message }}</p> @enderror
            </div>

            <div class="form-group">
                <label for="slug">Slug *</label>
                <input type="text" name="slug" id="slug" value="{{ old('slug', $category->slug) }}" required>
                @error('slug') <p class="error-text">{{ $message }}</p> @enderror
            </div>

            <div class="form-group">
                <label class="check-item">
                    <input type="checkbox" name="is_active" value="1" {{ old('is_active', $category->is_active) ? 'checked' : '' }}>
                    Hiển thị danh mục
                </label>
            </div>

            <button type="submit" class="btn btn-primary">Cập nhật</button>
        </form>
    </div>
@endsection
