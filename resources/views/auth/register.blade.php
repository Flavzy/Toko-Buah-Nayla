@extends('layouts.app')

@section('title', 'Sign Up')

@section('content')
<div style="min-height: 80vh; display: flex; align-items: center; justify-content: center; background-color: var(--canvas-parchment); padding: 48px 24px;">
    <div class="product-card" style="width: 100%; max-width: 480px; padding: 48px;">
        <div class="text-center mb-8">
            <h1 class="display-md mb-2">Buat Akun.</h1>
            <p class="text-muted">Bergabung dengan Toko Buah Nayla.</p>
        </div>

        <form action="{{ route('register.post') }}" method="POST" class="flex-col gap-4">
            @csrf
            <div>
                <label for="name" class="form-label">Nama Lengkap</label>
                <input type="text" id="name" name="name" class="form-input" value="{{ old('name') }}" required autofocus>
                @error('name')
                    <p class="caption text-danger mt-2">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="email" class="form-label">Email</label>
                <input type="email" id="email" name="email" class="form-input" value="{{ old('email') }}" required>
                @error('email')
                    <p class="caption text-danger mt-2">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="phone" class="form-label">Nomor Telepon</label>
                <input type="text" id="phone" name="phone" class="form-input" value="{{ old('phone') }}">
            </div>

            <div>
                <label for="password" class="form-label">Password</label>
                <input type="password" id="password" name="password" class="form-input" required>
                @error('password')
                    <p class="caption text-danger mt-2">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="password_confirmation" class="form-label">Konfirmasi Password</label>
                <input type="password" id="password_confirmation" name="password_confirmation" class="form-input" required>
            </div>

            <button type="submit" class="btn btn-primary w-full mt-4" style="padding: 14px; border-radius: 8px;">Sign Up</button>

            <div class="text-center mt-6">
                <p class="caption text-muted">Sudah punya akun? <a href="{{ route('login') }}" style="font-weight: 600;">Sign In.</a></p>
            </div>
        </form>
    </div>
</div>
@endsection
