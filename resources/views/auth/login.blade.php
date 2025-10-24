@extends('layouts.logres')

@section('title', 'Login - ' . config('app.name'))

@section('content')
<div class="auth-form">
    <h2 class="form-title">Selamat Datang Kembali 👋</h2>
    <p class="form-subtitle">Silakan masuk ke akun Anda</p>

    @if (session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <form method="POST" action="{{ route('login') }}" novalidate id="loginForm">
        @csrf

        <!-- Email -->
        <div class="form-group">
            <label for="email" class="form-label">E-mail</label>
            <div class="input-group">
                <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                <input id="email" type="email"
                       class="form-control @error('email') is-invalid @enderror"
                       name="email" value="{{ old('email') }}" required autofocus
                       placeholder="E-mail Anda">
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
                       name="password" required placeholder="Kata Sandi Anda">
                <button type="button" class="btn btn-outline-secondary togglePassword">
                    <i class="fas fa-eye"></i>
                </button>
            </div>
            @error('password') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>

        <!-- Remember & Forgot -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div class="form-check">
                <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                <label class="form-check-label" for="remember">Ingat saya</label>
            </div>
            @if (Route::has('password.request'))
                <a href="{{ route('password.request') }}" class="auth-link">Lupa Kata Sandi?</a>
            @endif
        </div>

        <!-- Submit -->
        <button type="submit" class="btn btn-primary-custom w-100 mb-3">Masuk Sekarang</button>

        <!-- Register Link -->
        <p class="text-center text-muted mb-4">
            Belum punya akun? <a href="{{ route('register') }}" class="auth-link">Daftar disini</a>
        </p>

        <!-- Divider -->
        <div class="divider">
            <span>atau</span>
        </div>

        <!-- Google -->
        <a href="{{ route('auth.google') }}" class="btn btn-google d-flex align-items-center justify-content-center">
            <img src="https://www.gstatic.com/firebasejs/ui/2.0.0/images/auth/google.svg" width="20" class="me-2"/>
            Masuk dengan Google
        </a>
    </form>
</div>

<div class="auth-image">
    <div class="auth-content text-center">
        <img src="{{ asset('images/logo.webp') }}" alt="Ilustrasi Login" loading="eager" fetchpriority="high">
        <p>Perbaiki fasilitas dengan<br>Pengaduan Sarpras</p>
    </div>
</div>
@endsection
