@extends('layouts.app')
@section('content')
    <div class="flex-between mb-3">
        <h1 style="font-size:1.5rem; display: flex; align-items: center; gap: 0.5rem;">
            <svg style="width: 22px; height: 22px; fill: none; stroke: var(--primary); stroke-width: 2;" viewBox="0 0 24 24"><path d="M22 19a2 2 0 01-2 2H4a2 2 0 01-2-2V5a2 2 0 012-2h5l2 3h9a2 2 0 012 2z"></path></svg>
            Quản lý danh mục
        </h1>
        <a href="{{ route('admin.categories.create') }}" class="btn btn-primary btn-sm" style="display: inline-flex; align-items: center; gap: 0.35rem;">
            <svg style="width: 13px; height: 13px; fill: none; stroke: currentColor; stroke-width: 2.5;" viewBox="0 0 24 24"><path d="M12 5v14M5 12h14"></path></svg>
            Thêm danh mục
        </a>
    </div>

    <div class="card">
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Tên</th>
                    <th>Slug</th>
                    <th>Trạng thái</th>
                    <th>Hành động</th>
                </tr>
            </thead>
            <tbody>
                @forelse($categories as $cat)
                    <tr>
                        <td>{{ $cat->id }}</td>
                        <td><strong>{{ $cat->name }}</strong></td>
                        <td class="text-dim">{{ $cat->slug }}</td>
                        <td>
                            @if($cat->is_active)
                                <span class="badge badge-completed">Hiển thị</span>
                            @else
                                <span class="badge badge-cancelled">Ẩn</span>
                            @endif
                        </td>
                        <td>
                            <div class="flex gap-1">
                                <a href="{{ route('admin.categories.edit', $cat) }}" class="btn btn-outline btn-sm">Sửa</a>
                                <form action="{{ route('admin.categories.destroy', $cat) }}" method="POST" onsubmit="return confirm('Xóa danh mục này?');">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm">Xóa</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="5" style="text-align:center;" class="text-dim">Chưa có danh mục nào.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="pagination-wrap">
        {{ $categories->links('pagination::bootstrap-4') }}
    </div>
@endsection
