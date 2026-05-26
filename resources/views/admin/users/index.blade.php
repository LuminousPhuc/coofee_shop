@extends('layouts.app')

@section('content')
<div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem;">
    <h1>User Management</h1>
    <a href="{{ route('admin.users.create') }}" class="btn btn-primary">Create New User</a>
</div>

<div class="card" style="padding: 0; overflow: hidden;">
    <table>
        <thead>
            <tr>
                <th>Name</th>
                <th>Email</th>
                <th>Role</th>
                <th>Created</th>
                <th style="text-align: right;">Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($users as $user)
            <tr>
                <td>
                    <div style="font-weight: 600;">{{ $user->name }}</div>
                </td>
                <td>{{ $user->email }}</td>
                <td>
                    <form action="{{ route('admin.users.update-role', $user) }}" method="POST" id="role-form-{{ $user->id }}">
                        @csrf
                        @method('PATCH')
                        <select name="role" 
                                onchange="this.form.submit()" 
                                style="background: transparent; border: 1px solid var(--border); padding: 0.2rem 0.5rem; border-radius: 4px; color: var(--text-main); font-size: 0.75rem; cursor: pointer; {{ $user->role === 'admin' ? 'border-color: #818cf8; color: #818cf8;' : '' }}"
                                {{ auth()->id() === $user->id ? 'disabled' : '' }}>
                            @foreach(config('roles', []) as $key => $label)
                                <option value="{{ $key }}" {{ $user->role === $key ? 'selected' : '' }}>{{ strtoupper($label) }}</option>
                            @endforeach
                        </select>
                    </form>
                </td>
                <td style="color: var(--text-dim);">{{ $user->created_at->format('M d, Y') }}</td>
                <td style="text-align: right;">
                    <div style="display: flex; gap: 0.5rem; justify-content: flex-end;">
                        <a href="{{ route('admin.users.edit', $user) }}" class="btn btn-logout btn-sm">Edit</a>
                        
                        @if($user->id !== auth()->id())
                        <form action="{{ route('admin.users.destroy', $user) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this user?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                        </form>
                        @endif
                    </div>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
