@extends('layouts.landing')

@section('title', 'NGADU SARPAS - Sistem Pengaduan Sarana & Prasarana')

@section('content')
   <!-- Enhanced Navigation -->
<nav class="navbar" :class="{ 'scrolled': scrolled }" x-data="{
    mobileMenuOpen: false,
    isMobile: false,
    init() {
        this.checkScreenSize();
        window.addEventListener('resize', () => this.checkScreenSize());
    },
    checkScreenSize() {
        this.isMobile = window.innerWidth < 768;
    }
}" @scroll.window="scrolled = window.pageYOffset > 50">
    <div class="container">
        <div class="nav-content">
            <a href="{{ url('') }}" class="logo d-flex align-items-center">
                <img src="{{ asset('images/logo.webp') }}" alt="Logo Pengaduan Sarpras" style="height: 35px; width: auto; ">
                <span class="logo-text ms-2">Pengaduan Sarpras</span>
            </a>

            <div class="nav-links" :class="{ 'd-none': isMobile }">
                <a href="#features" class="nav-link">Fitur</a>
                <a href="#process" class="nav-link">Proses</a>
                <a href="#about" class="nav-link">Tentang</a>
            </div>

            <div class="nav-right">
                <a href="{{ url('/login') }}" class="btn btn-primary" :class="{ 'd-none': isMobile }">
                    <i class="fas fa-sign-in-alt"></i>
                    Masuk
                </a>

                <!-- Mobile Menu Button - Hanya tampil di layar kecil -->
                <button class="mobile-menu-btn"
                        x-show="isMobile"
                        x-transition
                        @click="mobileMenuOpen = !mobileMenuOpen">
                    <i class="fas fa-bars" x-show="!mobileMenuOpen" x-transition></i>
                    <i class="fas fa-times" x-show="mobileMenuOpen" x-transition></i>
                </button>
            </div>
        </div>

        <!-- Mobile Menu - Hanya tampil di layar kecil -->
        <div class="mobile-menu"
             x-show="isMobile && mobileMenuOpen"
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0 transform -translate-y-2"
             x-transition:enter-end="opacity-100 transform translate-y-0"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="opacity-100 transform translate-y-0"
             x-transition:leave-end="opacity-0 transform -translate-y-2">
            <a href="#features" class="mobile-nav-link" @click="mobileMenuOpen = false">Fitur</a>
            <a href="#process" class="mobile-nav-link" @click="mobileMenuOpen = false">Proses</a>
            <a href="#about" class="mobile-nav-link" @click="mobileMenuOpen = false">Tentang</a>
            <a href="{{ url('/login') }}" class="btn btn-primary mobile-login-btn">
                <i class="fas fa-sign-in-alt"></i>
                Masuk
            </a>
        </div>
    </div>
</nav>

    <!-- Enhanced Hero Section -->
    <section class="hero">
        <div class="container">
            <div class="hero-grid">
                <div class="hero-content">
                    <!-- HERO TITLE - Pendekatan RADIKAL -->
                    <div class="hero-title-section" data-mobile-title="true">
                        <div class="hero-title-line">Dari Laporan</div>
                        <div class="hero-title-line">Jadi Perubahan</div>
                    </div>

                    <p>Pengaduan Sarpras menghadirkan sistem pelaporan yang cepat, transparan, dan terintegrasi untuk memastikan setiap laporan menghasilkan tindakan nyata.</p>

                    <div class="hero-buttons">
                        <a href="{{ url('/login') }}" class="btn btn-white">
                            <i class="fas fa-rocket"></i>
                            Mulai Sekarang
                        </a>
                        <a href="#features" class="btn btn-outline" style="color: white; border-color: white;">
                            <i class="fas fa-globe"></i>
                            Lihat Fitur
                        </a>
                    </div>

                    <!-- Trust Indicators -->
                    <div style="margin-top: 3rem; display: flex; align-items: center; gap: 2rem; flex-wrap: wrap;">
                        <div style="display: flex; align-items: center; gap: 0.5rem;">
                            <i class="fas fa-shield-alt" style="color: #10b981;"></i>
                            <span style="color: white; font-weight: 500;">Aman & Terpercaya</span>
                        </div>
                        <div style="display: flex; align-items: center; gap: 0.5rem;">
                            <i class="fas fa-bolt" style="color: #f59e0b;"></i>
                            <span style="color: white; font-weight: 500;">Cepat & Transparan</span>
                        </div>
                        <div style="display: flex; align-items: center; gap: 0.5rem;">
                            <i class="fa fa-database" style="color: #3b82f6;"></i>
                            <span style="color: white; font-weight: 500;">Akuntabel</span>
                        </div>
                    </div>
                </div>

               <div class="hero-image">
                    <div class="hero-image-content">
                        <img src="{{ asset('images/smk.jpg') }}" alt="Dashboard Sistem Pengaduan">
                    </div>
                </div>
            </div>
        </div>
    </section>

   <!-- Enhanced Features Section -->
<section class="features" id="features">
    <div class="container">
        <div class="section-header">
            <h2 class="section-title">Fitur Unggulan Sistem</h2>
            <p class="section-subtitle">
                Dirancang untuk mempermudah proses pengaduan sarana dan prasarana sekolah dengan sistem yang transparan, efisien, dan mudah digunakan.
            </p>
        </div>

        <div class="features-grid">
            <div class="feature-card">
                <div class="feature-icon">
                    <i class="fas fa-file-upload"></i>
                </div>
                <h3 class="feature-title">Pengajuan Cepat & Mudah</h3>
                <p class="feature-description">
                    Ajukan pengaduan hanya dalam beberapa langkah. Isi formulir singkat, unggah foto pendukung, dan kirim dengan sekali klik.
                </p>
            </div>

            <div class="feature-card">
                <div class="feature-icon">
                    <i class="fas fa-map-marker-alt"></i>
                </div>
                <h3 class="feature-title">Tracking Real-time</h3>
                <p class="feature-description">
                    Pantau progres pengaduan dari tahap pengajuan hingga penyelesaian. Semua proses tercatat secara transparan dan akurat.
                </p>
            </div>

            <div class="feature-card">
                <div class="feature-icon">
                    <i class="fas fa-users-cog"></i>
                </div>
                <h3 class="feature-title">Kolaborasi Petugas & Admin</h3>
                <p class="feature-description">
                    Sistem mendukung kerja sama antara petugas dan admin agar tindak lanjut setiap laporan menjadi lebih cepat dan terkoordinasi.
                </p>
            </div>

             <div class="feature-card">
                <div class="feature-icon">
                    <i class="fas fa-star"></i>
                </div>
                <h3 class="feature-title">Rating & Ulasan Petugas</h3>
                <p class="feature-description">
                    Anda dapat memberikan penilaian kinerja petugas dari bintang 1 hingga 5 dan menulis ulasan untuk meningkatkan kualitas layanan.
                </p>
            </div>

            <div class="feature-card">
                <div class="feature-icon">
                    <i class="fas fa-folder-open"></i>
                </div>
                <h3 class="feature-title">Riwayat Pengaduan</h3>
                <p class="feature-description">
                    Setiap pengguna dapat melihat riwayat pengaduan yang telah diajukan dan statusnya secara detail kapan pun diperlukan.
                </p>
            </div>

            <div class="feature-card">
                <div class="feature-icon">
                    <i class="fas fa-mobile-alt"></i>
                </div>
                <h3 class="feature-title">Tampilan Responsif</h3>
                <p class="feature-description">
                    Nikmati pengalaman yang nyaman di berbagai perangkat — baik komputer, tablet, maupun smartphone.
                </p>
            </div>
        </div>
    </div>
</section>

    <!-- Process Section -->
    <section class="process" id="process">
        <div class="container">
            <div class="section-header">
                <h2 class="section-title">Cara Kerja Sistem</h2>
                <p class="section-subtitle">Proses sederhana untuk mengelola pengaduan sarana dan prasarana Anda</p>
            </div>

            <div class="process-timeline">
                <div class="process-item">
                    <div class="process-icon">
                        <i class="fas fa-edit"></i>
                    </div>
                    <div class="process-content">
                        <h3 class="process-title">1. Ajukan Pengaduan</h3>
                        <p class="process-description">Isi formulir pengaduan dengan detail lengkap dan upload bukti pendukung. Proses hanya membutuhkan waktu beberapa menit.</p>
                    </div>
                </div>

                <div class="process-item">
                    <div class="process-icon">
                        <i class="fas fa-paper-plane"></i>
                    </div>
                    <div class="process-content">
                        <h3 class="process-title">2. Verifikasi & Distribusi</h3>
                        <p class="process-description">Tim kami akan memverifikasi pengaduan Anda dan mendistribusikan ke unit terkait untuk penanganan lebih lanjut.</p>
                    </div>
                </div>

                <div class="process-item">
                    <div class="process-icon">
                        <i class="fas fa-cogs"></i>
                    </div>
                    <div class="process-content">
                        <h3 class="process-title">3. Proses Penanganan</h3>
                        <p class="process-description">Unit terkait akan melakukan penanganan sesuai dengan prioritas dan kompleksitas masalah yang dilaporkan.</p>
                    </div>
                </div>

                <div class="process-item">
                    <div class="process-icon">
                        <i class="fas fa-check-circle"></i>
                    </div>
                    <div class="process-content">
                        <h3 class="process-title">4. Selesai & Evaluasi</h3>
                        <p class="process-description">Anda akan menerima notifikasi ketika pengaduan telah selesai ditangani. Berikan feedback untuk peningkatan layanan.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="cta">
    <div class="container">
        <div class="cta-content">
            <h2>Perbaiki fasilitas dengan Pengaduan Sarpras</h2>
            <p>
                 Jadilah bagian dari perubahan positif di sekolah!
Melalui Pengaduan Sarpras, setiap siswa dapat ikut menjaga dan meningkatkan kualitas fasilitas sekolah.
            </p>
            <div class="hero-buttons" style="justify-content: center;">
                <a href="{{ url('/login') }}" class="btn btn-white">
                    <i class="fas fa-play"></i>
                    Coba Sekarang
                </a>
                <a href="{{ url('/register') }}" class="btn btn-outline" style="color: white; border-color: white;">
                    <i class="fas fa-user-plus"></i>
                    Buat Akun Baru
                </a>
            </div>
            <p style="margin-top: 1rem; font-size: 0.875rem; opacity: 0.8;">
                Lapor Mudah • Tindak Cepat • Fasilitas Terawat
            </p>
        </div>
    </div>
</section>

   <!-- Enhanced Footer -->
<footer class="footer" id="about">
    <div class="container">
        <!-- Bagian Tentang NGADU SARPAS -->
        <div class="footer-about">
            <h3>Tentang Pengaduan Sarpras</h3>
            <p>
                Pengaduan Sarpras adalah platform terintegrasi yang menghadirkan solusi digital untuk pengelolaan pengaduan sarana dan prasarana dengan sistem yang cepat, transparan, dan akuntabel.
            </p>
        </div>

        <!-- Footer Bottom -->
        <div class="footer-bottom">
            <p>
                &copy; {{ date('Y') }} Sistem Pengaduan Sarana & Prasarana. All rights reserved.
                <a href="#" style="color: #94a3b8; text-decoration: none;">Privacy Policy</a> |
                <a href="#" style="color: #94a3b8; text-decoration: none;">Terms of Service</a>
            </p>
        </div>
    </div>
</footer>

<!-- Mobile Menu Styles & Hero Title Fix -->
<style>
/* Mobile Menu Styles */
.mobile-menu-btn {
    background: none;
    border: none;
    font-size: 1.5rem;
    color: var(--primary-color);
    cursor: pointer;
    padding: 0.5rem;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 8px;
    transition: all 0.3s ease;
}

.mobile-menu-btn:hover {
    background-color: rgba(0, 56, 151, 0.1);
}

.mobile-menu {
    display: flex;
    flex-direction: column;
    padding: 1rem 0;
    border-top: 1px solid var(--border-color);
    margin-top: 1rem;
}

.mobile-nav-link {
    padding: 0.75rem 1rem;
    color: var(--text-color);
    text-decoration: none;
    font-weight: 500;
    transition: all 0.3s ease;
    border-radius: 8px;
    margin: 0.25rem 0;
}

.mobile-nav-link:hover {
    background-color: rgba(0, 56, 151, 0.05);
    color: var(--primary-color);
}

.mobile-login-btn {
    margin-top: 0.5rem;
    width: 100%;
    justify-content: center;
}

/* Helper classes untuk Alpine.js */
.d-none {
    display: none !important;
}

/* HERO TITLE - PENDAKATAN RADIKAL */
/* HERO TITLE - FIXED VERSION */
.hero-title-section {
    margin-bottom: 1.5rem !important;
    width: 100% !important;
    max-width: 100% !important;
    display: block !important;
    overflow: visible !important;
    position: relative !important;
}

.hero-title-line {
    font-size: 3.5rem !important;
    font-weight: 800 !important;
    line-height: 1.1 !important;
    color: white !important;
    text-shadow: 0 2px 4px rgba(0,0,0,0.1) !important;
    display: block !important;
    width: 100% !important;
    max-width: 100% !important;
    margin: 0 !important;
    padding: 0 !important;
    overflow: visible !important;
    word-wrap: break-word !important;
    word-break: break-word !important;
    overflow-wrap: break-word !important;
    white-space: normal !important;
    position: relative !important;
}

/* Desktop - Single Line */
@media (min-width: 769px) {
    .hero-title-section {
        display: block !important;
    }

    .hero-title-line {
        display: inline !important;
        white-space: nowrap !important;
    }

    .hero-title-line:first-child::after {
        content: " ";
        white-space: pre;
    }
}

/* Mobile - Two Lines (PERBAIKAN UTAMA) */
@media (max-width: 768px) {
    .hero-title-section {
        margin-bottom: 1.5rem !important;
        display: flex !important;
        flex-direction: column !important;
        gap: 0.5rem !important;
    }

    .hero-title-line {
        font-size: 2.5rem !important;
        line-height: 1.1 !important;
        text-align: center !important;
        display: block !important;
        white-space: normal !important;
        opacity: 1 !important;
        visibility: visible !important;
        height: auto !important;
        min-height: auto !important;
    }
}

@media (max-width: 480px) {
    .hero-title-line {
        font-size: 2rem !important;
        line-height: 1.1 !important;
    }
}

@media (max-width: 360px) {
    .hero-title-line {
        font-size: 1.75rem !important;
        line-height: 1.1 !important;
    }
}

/* Logo text responsive */
@media (max-width: 767px) {
    .logo-text {
        font-size: 1.2rem;
    }
}
</style>

<script>
// Force title display fix
document.addEventListener('DOMContentLoaded', function() {
    const titleSection = document.querySelector('.hero-title-section');
    if (titleSection) {
        // Force styles via JavaScript
        titleSection.style.width = '100%';
        titleSection.style.maxWidth = '100%';
        titleSection.style.overflow = 'visible';
        titleSection.style.display = 'block';

        const titleLines = titleSection.querySelectorAll('.hero-title-line');
        titleLines.forEach(line => {
            line.style.width = '100%';
            line.style.maxWidth = '100%';
            line.style.overflow = 'visible';
            line.style.display = 'block';
            line.style.wordWrap = 'break-word';
            line.style.wordBreak = 'break-word';
            line.style.overflowWrap = 'break-word';
            line.style.whiteSpace = 'normal';
        });
    }
});
</script>

@endsection
