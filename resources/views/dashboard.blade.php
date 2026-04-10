@extends('layouts.app')

@section('content')
<div class="card" style="text-align: center; padding: 4rem 2rem;">
    <div style="width: 80px; height: 80px; background: rgba(99, 102, 241, 0.1); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 1.5rem;">
        <svg width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="var(--primary)" stroke-width="2"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
    </div>
    <h1 style="font-size: 2.5rem; margin-bottom: 0.5rem;">{{ $message }}</h1>
    <p style="color: var(--text-dim);">You are logged in as <strong>{{ auth()->user()->name }}</strong> ({{ auth()->user()->role }})</p>
    
    @if(auth()->user()->role === 'admin')
        <div style="margin-top: 2rem;">
            <a href="{{ route('admin.users.index') }}" class="btn btn-primary">Go to Admin Panel</a>
        </div>
    @endif
</div>
@endsection
