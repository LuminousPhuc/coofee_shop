@extends('layouts.app')

@section('content')
<div style="max-width: 600px; margin: 0 auto;">
    <div style="margin-bottom: 2rem;">
        <a href="{{ route('admin.users.index') }}" style="color: var(--text-dim); text-decoration: none; font-size: 0.875rem;">← Back to List</a>
        <h1 style="margin-top: 1rem;">Create New User</h1>
    </div>

    <div class="card">
        <form action="{{ route('admin.users.store') }}" method="POST">
            @csrf
            
            <div class="form-group">
                <label for="name">Full Name</label>
                <input type="text" name="name" id="name" value="{{ old('name') }}" required>
                @error('name') <p class="error-text">{{ $message }}</p> @enderror
            </div>

            <div class="form-group">
                <label for="email">Email Address</label>
                <input type="email" name="email" id="email" value="{{ old('email') }}" required>
                @error('email') <p class="error-text">{{ $message }}</p> @enderror
            </div>

            <div class="form-group">
                <label for="role">System Role</label>
                <select name="role" id="role" required>
                    @foreach(config('roles', []) as $key => $label)
                        <option value="{{ $key }}" {{ old('role') === $key ? 'selected' : '' }}>{{ ucfirst($label) }}</option>
                    @endforeach
                </select>
                @error('role') <p class="error-text">{{ $message }}</p> @enderror
            </div>

            <div class="form-group">
                <label for="password">Initial Password</label>
                <input type="password" name="password" id="password" required>
                @error('password') <p class="error-text">{{ $message }}</p> @enderror
            </div>

            <div style="margin-top: 2rem;">
                <button type="submit" class="btn btn-primary" style="width: 100%;">Create User Account</button>
            </div>
        </form>
    </div>
</div>
@endsection
