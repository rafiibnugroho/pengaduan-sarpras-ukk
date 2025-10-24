@extends('layouts.user')

@section('content')
<head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
</head>
<style>
    /* CSS sebelumnya (disederhanakan untuk contoh ini, asumsikan Anda menggunakan CSS dari jawaban sebelumnya) */
    .page-container {
        background-color: #f7f9fc;
        min-height: 100vh;
    }

    .profile-card {
        border-radius: 20px;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.05);
        border: 1px solid #e5e7eb;
        transition: all 0.4s cubic-bezier(0.25, 0.8, 0.25, 1);
    }

    .section-title {
        font-size: 1.75rem;
        font-weight: 700;
        color: #1f2937;
        margin-bottom: 2rem;
        border-left: 5px solid #4f46e5;
        padding-left: 15px;
        line-height: 1.2;
    }

    .form-label {
        font-weight: 600;
        color: #374151;
        font-size: 0.95rem;
        margin-bottom: 0.5rem;
    }

    .form-control-lg {
        padding: 0.75rem 1.25rem;
        border-radius: 12px;
        border: 1px solid #d1d5db;
    }
    .form-control-lg:focus {
        border-color: #4f46e5;
        box-shadow: 0 0 0 4px rgba(79, 70, 229, 0.1);
    }

    /* Primary Button */
    .btn-primary-modern {
        background: #4f46e5;
        border: none;
        padding: 0.8rem 2rem;
        border-radius: 14px;
        font-weight: 700;
        transition: background 0.3s ease;
        box-shadow: 0 4px 15px rgba(79, 70, 229, 0.3);
    }

    /* Secondary Button */
    .btn-secondary-modern {
        background: #f59e0b;
        border: none;
        padding: 0.8rem 2rem;
        border-radius: 14px;
        font-weight: 700;
        color: white;
        transition: background 0.3s ease;
        box-shadow: 0 4px 15px rgba(245, 158, 11, 0.3);
    }

    /* Tombol Back BARU (Minimalis di Samping Judul) */
    .back-btn-minimal {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 40px; /* Ukuran kotak */
        height: 40px;
        border-radius: 50%; /* Bulat */
        color: #4f46e5;
        background: #eef2ff; /* Latar belakang sangat lembut */
        text-decoration: none;
        font-size: 1.25rem;
        transition: all 0.2s ease;
        border: none;
        margin-right: 15px; /* Jarak dari teks */
        flex-shrink: 0;
    }
    .back-btn-minimal:hover {
        background: #dbeafe;
        color: #3730a3;
    }

    /* Styling Judul dan Tombol */
    .header-container {
        display: flex;
        align-items: center;
        /* Tambahkan jarak dari atas kartu */
        padding-bottom: 25px;
    }

    .divider {
        height: 1px;
        background: #e5e7eb;
        margin: 3rem 0;
    }

    /* Styling Notifikasi */
    .alert-success { background-color: #ecfdf5; color: #065f46; border-left: 5px solid #10b981; border-radius: 12px; padding: 1rem 1.5rem; }
    .alert-danger { background-color: #fef2f2; color: #991b1b; border-left: 5px solid #ef4444; border-radius: 12px; padding: 1rem 1.5rem; }

</style>

<div class="page-container">
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-lg-8">

                <div class="profile-card p-4 p-md-5 bg-white">

                    <div class="header-container">
                        <a href="{{ route('home') }}" class="back-btn-minimal" title="Kembali">
                            <i class="bi bi-arrow-left"></i>
                        </a>

                        <h2 class="fw-bold m-0" style="color: #1f2937;">Pengaturan Akun Saya ⚙️</h2>
                    </div>
                    <hr class="mt-4 mb-5" style="border-color: #f3f4f6;"> @if(session('success'))
                        <div class="alert alert-success mb-4" role="alert">
                            <i class="bi bi-check-circle-fill"></i> {{ session('success') }}
                        </div>
                    @endif
                    @if(session('error'))
                        <div class="alert alert-danger mb-4" role="alert">
                            <i class="bi bi-exclamation-triangle-fill"></i> {{ session('error') }}
                        </div>
                    @endif

                    <h3 class="section-title">Informasi Dasar</h3>
                    <form action="{{ route('profile.update') }}" method="POST">
                        @csrf
                        <div class="mb-4">
                            <label for="name" class="form-label">Nama Lengkap</label>
                            <input type="text" id="name" name="name" class="form-control form-control-lg" placeholder="Masukkan Nama Lengkap Anda" value="{{ old('name', $user->name) }}" required>
                        </div>
                        <div class="mb-5">
                            <label for="email" class="form-label">Alamat Email</label>
                            <input type="email" id="email" name="email" class="form-control form-control-lg" placeholder="contoh@domain.com" value="{{ old('email', $user->email) }}" required>
                        </div>
                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary-modern">
                                <i class="bi bi-save me-2"></i> Simpan Perubahan
                            </button>
                        </div>
                    </form>

                    <div class="divider"></div>

                    <h3 class="section-title">Keamanan Akun</h3>
                    <form action="{{ route('profile.password') }}" method="POST">
                        @csrf
                        <div class="mb-4">
                            <label for="old_password" class="form-label">Kata Sandi Lama</label>
                            <input type="password" id="old_password" name="old_password" class="form-control form-control-lg" required>
                        </div>
                        <div class="mb-4">
                            <label for="new_password" class="form-label">Kata Sandi Baru</label>
                            <input type="password" id="new_password" name="new_password" class="form-control form-control-lg" required>
                        </div>
                        <div class="mb-5">
                            <label for="new_password_confirmation" class="form-label">Konfirmasi Kata Sandi Baru</label>
                            <input type="password" id="new_password_confirmation" name="new_password_confirmation" class="form-control form-control-lg" required>
                        </div>
                        <div class="d-grid">
                            <button type="submit" class="btn btn-secondary-modern">
                                <i class="bi bi-key-fill me-2"></i> Perbarui Kata Sandi
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
