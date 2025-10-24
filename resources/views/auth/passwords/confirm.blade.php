@extends('layouts.logres')

@section('title', 'Konfirmasi Password - ' . config('app.name'))

@section('content')
<div class="auth-form">
    <h2 class="form-title">Konfirmasi Password</h2>
    <p class="form-subtitle">Silakan masukkan kembali password Anda untuk melanjutkan</p>

    @if (session('status'))
        <div class="alert alert-success" role="alert">
            {{ session('status') }}
        </div>
    @endif

    <form method="POST" action="{{ route('password.confirm') }}" id="confirmPasswordForm" novalidate>
        @csrf

        <!-- Password -->
        <div class="form-group">
            <label for="password" class="form-label">Kata Sandi</label>
            <div class="input-group">
                <span class="input-group-text">
                    <i class="fas fa-lock"></i>
                </span>
                <input id="password"
                       type="password"
                       class="form-control @error('password') is-invalid @enderror"
                       name="password"
                       required
                       autocomplete="current-password"
                       placeholder="Masukkan password Anda">
                <button type="button" class="btn btn-outline-secondary togglePassword">
                    <i class="fas fa-eye"></i>
                </button>
            </div>
            @error('password')
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <!-- Submit Button -->
        <button type="submit" class="btn btn-primary-custom mb-3">Konfirmasi Password</button>

        <!-- Forgot Password Link -->
        @if (Route::has('password.request'))
        <div class="text-center">
            <a class="auth-link" href="{{ route('password.request') }}">
                Lupa Password?
            </a>
        </div>
        @endif
    </form>
</div>

<div class="auth-image">
    <img src="{{ asset('images/logo.png') }}" alt="Pengaduan Sarpras">
    <div style="text-align: center; color: white; margin-top: 20px;">
        <p>Perbaiki fasilitas dengan<br>Pengaduan Sarpras</p>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener("DOMContentLoaded", function () {
    document.querySelectorAll(".togglePassword").forEach(button => {
        button.addEventListener("click", function () {
            const input = this.closest(".input-group").querySelector("input");
            const icon = this.querySelector("i");

            if (input.type === "password") {
                input.type = "text";
                icon.classList.replace("fa-eye", "fa-eye-slash");
            } else {
                input.type = "password";
                icon.classList.replace("fa-eye-slash", "fa-eye");
            }
        });
    });
});
</script>
@endpush
