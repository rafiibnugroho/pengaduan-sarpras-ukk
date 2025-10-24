@extends('layouts.logres')

@section('title', 'Ubah Kata Sandi - ' . config('app.name'))

@section('content')
<div class="auth-form">
    <h2 class="form-title">Buat Kata Sandi Baru</h2>
    <p class="form-subtitle">Masukkan kata sandi baru untuk akun Anda</p>

    <form method="POST" action="{{ route('password.update') }}">
        @csrf

        <input type="hidden" name="token" value="{{ $token }}">

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
                       value="{{ $email ?? old('email') }}"
                       required
                       autofocus
                       placeholder="E-mail Anda">
            </div>
            @error('email')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <!-- New Password -->
        <div class="form-group">
            <label for="password" class="form-label">Kata Sandi Baru</label>
            <div class="input-group">
                <span class="input-group-text">
                    <i class="fas fa-lock"></i>
                </span>
                <input id="password"
                       type="password"
                       class="form-control @error('password') is-invalid @enderror"
                       name="password"
                       required
                       placeholder="Kata Sandi Baru">
                <button type="button" class="btn btn-outline-secondary togglePassword">
                    <i class="fas fa-eye"></i>
                </button>
            </div>
            @error('password')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <!-- Confirm Password -->
        <div class="form-group">
            <label for="password_confirmation" class="form-label">Ulangi Kata Sandi</label>
            <div class="input-group">
                <span class="input-group-text">
                    <i class="fas fa-lock"></i>
                </span>
                <input id="password_confirmation"
                       type="password"
                       class="form-control"
                       name="password_confirmation"
                       required
                       placeholder="Ulangi Kata Sandi">
                <button type="button" class="btn btn-outline-secondary togglePassword">
                    <i class="fas fa-eye"></i>
                </button>
            </div>
        </div>

        <!-- Submit Button -->
        <button type="submit" class="btn btn-primary-custom mb-3">Reset Kata Sandi</button>

        <!-- Back to Login -->
        <div class="text-muted text-center">
            Sudah ingat kata sandi? <a href="{{ route('login') }}" class="auth-link">Masuk di sini</a>
        </div>
    </form>
</div>

<!-- Bagian kanan gambar -->
<div class="auth-image">
    <img src="{{ asset('images/logo.png') }}" alt="Pengaduan Sarpras" style="max-width: 200px; height: auto;">
    <div style="text-align: center; color: white; margin-top: 20px; font-size: 1rem; line-height: 1.5;">
        <p>Perbaiki fasilitas dengan<br>Pengaduan Sarpras</p>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll(".togglePassword").forEach(button => {
        button.addEventListener("click", function () {
            const input = this.closest(".input-group").querySelector("input");
            const type = input.type === "password" ? "text" : "password";
            input.type = type;

            const icon = this.querySelector("i");
            icon.classList.toggle("fa-eye");
            icon.classList.toggle("fa-eye-slash");
        });
    });
});
</script>
@endpush
