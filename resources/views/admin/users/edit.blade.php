@extends('layouts.app')

@section('content')
<div style="max-width: 600px; margin: 0 auto;">
    <div style="margin-bottom: 2rem;">
        <a href="{{ route('admin.users.index') }}" style="color: var(--text-dim); text-decoration: none; font-size: 0.875rem;">← Back to List</a>
        <h1 style="margin-top: 1rem;">Edit User: {{ $user->name }}</h1>
    </div>

    <div class="card">
        <form action="{{ route('admin.users.update', $user) }}" method="POST">
            @csrf
            @method('PUT')
            
            <div class="form-group">
                <label for="name">Full Name</label>
                <input type="text" name="name" id="name" value="{{ old('name', $user->name) }}" required>
                @error('name') <p class="error-text">{{ $message }}</p> @enderror
            </div>

            <div class="form-group">
                <label for="email">Email Address</label>
                <input type="email" name="email" id="email" value="{{ old('email', $user->email) }}" required>
                @error('email') <p class="error-text">{{ $message }}</p> @enderror
            </div>

            <div class="form-group">
                <label for="role">System Role</label>
                <select name="role" id="role" required>
                    @foreach(config('roles', []) as $key => $label)
                        <option value="{{ $key }}" {{ old('role', $user->role) === $key ? 'selected' : '' }}>{{ ucfirst($label) }}</option>
                    @endforeach
                </select>
                @error('role') <p class="error-text">{{ $message }}</p> @enderror
            </div>

            <div class="form-group">
                <label for="password">Change Password (leave blank to keep current)</label>
                <input type="password" name="password" id="password">
                @error('password') <p class="error-text">{{ $message }}</p> @enderror
            </div>

            <div style="margin-top: 2rem;">
                <button type="submit" class="btn btn-primary" style="width: 100%;">Update User Account</button>
            </div>
        </form>
    </div>
</div>
@endsection
