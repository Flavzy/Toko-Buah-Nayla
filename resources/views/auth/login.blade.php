@extends('layouts.app')

@section('title', 'Sign In')

@section('content')
<div style="min-height: 80vh; display: flex; align-items: center; justify-content: center; background-color: var(--canvas-parchment); padding: 48px 24px;">
    <div class="product-card" style="width: 100%; max-width: 480px; padding: 48px;">
        <div class="text-center mb-8">
            <h1 class="display-md mb-2">Sign In.</h1>
            <p class="text-muted">Masuk ke akun Toko Buah Nayla Anda.</p>
        </div>

        <form action="{{ route('login.post') }}" method="POST" class="flex-col gap-4">
            @csrf
            <div>
                <label for="email" class="form-label">Email</label>
                <input type="email" id="email" name="email" class="form-input" value="{{ old('email') }}" required autofocus placeholder="nama@email.com">
                @error('email')
                    <p class="caption text-danger mt-2">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="password" class="form-label">Password</label>
                <input type="password" id="password" name="password" class="form-input" required>
                @error('password')
                    <p class="caption text-danger mt-2">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex items-center gap-2 mt-2 mb-4">
                <input type="checkbox" id="remember" name="remember" style="accent-color: var(--primary);">
                <label for="remember" class="caption">Ingat saya</label>
            </div>

            <button type="submit" class="btn btn-primary w-full" style="padding: 14px; border-radius: 8px;">Sign In</button>

            <div class="text-center mt-6">
                <p class="caption text-muted">Belum punya akun? <a href="{{ route('register') }}" style="font-weight: 600;">Daftar sekarang.</a></p>
            </div>
        </form>
    </div>
</div>
@endsection
