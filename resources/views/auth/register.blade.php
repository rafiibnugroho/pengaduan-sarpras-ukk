@extends('layouts.logres')

@section('title', 'Register - ' . config('app.name'))

@section('content')
<div class="auth-form">
    <h2 class="form-title">Daftar Akun Baru ✨</h2>
    <p class="form-subtitle">Isi data berikut untuk mulai menggunakan Pengaduan Sarpras</p>

    <form method="POST" action="{{ route('register') }}" novalidate id="registerForm">
        @csrf

        <!-- Name -->
        <div class="form-group">
            <label for="name" class="form-label">Nama Lengkap</label>
            <div class="input-group">
                <span class="input-group-text"><i class="fas fa-user"></i></span>
                <input id="name" type="text"
                       class="form-control @error('name') is-invalid @enderror"
                       name="name" value="{{ old('name') }}" required
                       placeholder="Contoh: Lorem Ipsum">
            </div>
            @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>

        <!-- Email -->
        <div class="form-group">
            <label for="email" class="form-label">E-mail</label>
            <div class="input-group">
                <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                <input id="email" type="email"
                       class="form-control @error('email') is-invalid @enderror"
                       name="email" value="{{ old('email') }}" required
                       placeholder="email@example.com">
            </div>
            @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>

        <!-- Password -->
        <div class="form-group">
            <label for="password" class="form-label">Kata Sandi</label>
            <div class="input-group">
                <span class="input-group-text"><i class="fas fa-lock"></i></span>
                <input id="password" type="password"
                       class="form-control @error('password') is-invalid @enderror"
                       name="password" required placeholder="Minimal 8 karakter">
                <button type="button" class="btn btn-outline-secondary togglePassword">
                    <i class="fas fa-eye"></i>
                </button>
            </div>
            @error('password') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>

        <!-- Confirm Password -->
        <div class="form-group">
            <label for="password_confirmation" class="form-label">Ulangi Kata Sandi</label>
            <div class="input-group">
                <span class="input-group-text"><i class="fas fa-lock"></i></span>
                <input id="password_confirmation" type="password"
                       class="form-control"
                       name="password_confirmation" required placeholder="Ulangi Kata Sandi Anda">
                <button type="button" class="btn btn-outline-secondary togglePassword">
                    <i class="fas fa-eye"></i>
                </button>
            </div>
        </div>

        <!-- Submit -->
        <button type="submit" class="btn btn-primary-custom w-100 mb-3">Daftar Sekarang</button>

        <!-- Login Link -->
        <p class="text-center text-muted mb-4">
            Sudah punya akun? <a href="{{ route('login') }}" class="auth-link">Masuk di sini</a>
        </p>

        <!-- Divider -->
        <div class="divider">
            <span>atau</span>
        </div>

        <!-- Google -->
        <a href="{{ route('auth.google') }}" class="btn btn-google d-flex align-items-center justify-content-center">
            <img src="https://www.gstatic.com/firebasejs/ui/2.0.0/images/auth/google.svg" width="20" class="me-2"/>
            Daftar dengan Google
        </a>
    </form>
</div>

<div class="auth-image">
    <div class="auth-content text-center">
        <img src="{{ asset('images/logo.webp') }}" alt="Pengaduan Sarpras" loading="eager" fetchpriority="high">
        <p>Perbaiki fasilitas dengan<br>Pengaduan Sarpras</p>
    </div>
</div>
@endsection
