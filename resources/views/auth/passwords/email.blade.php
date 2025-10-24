@extends('layouts.logres')

@section('title', 'Reset Password - ' . config('app.name'))

@section('content')
<div class="auth-form">
    <h2 class="form-title">Reset Kata Sandi</h2>
    <p class="form-subtitle">Masukkan email Anda untuk menerima link reset kata sandi</p>

    @if (session('status'))
        <div class="alert alert-success">
            {{ session('status') }}
        </div>
    @endif

    <form method="POST" action="{{ route('password.email') }}">
        @csrf

        <!-- Email -->
        <div class="form-group">
            <label for="email" class="form-label">E-mail</label>
            <div class="input-group">
                <span class="input-group-text">
                    <i class="fas fa-envelope"></i>
                </span>
                <input id="email"
                       type="email"
                       class="form-control @error('email') is-invalid @enderror"
                       name="email"
                       value="{{ old('email') }}"
                       required
                       autofocus
                       placeholder="E-mail Anda">
            </div>
            @error('email')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <!-- Submit Button -->
        <button type="submit" class="btn btn-primary-custom mb-3">Kirim Link Reset</button>

        <!-- Back to Login -->
        <div class="text-muted text-center">
            Sudah ingat kata sandi? <a href="{{ route('login') }}" class="auth-link">Masuk di sini</a>
        </div>
    </form>
</div>

<!-- Bagian kanan gambar -->
<div class="auth-image">
    <img src="{{ asset('images/logo.webp') }}" alt="Pengaduan Sarpras" style="max-width: 200px; height: auto;">
    <div style="text-align: center; color: white; margin-top: 20px; font-size: 1rem; line-height: 1.5;">
        <p>Perbaiki fasilitas dengan<br>Pengaduan Sarpras</p>
    </div>
</div>
@endsection
