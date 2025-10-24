@extends('layouts.petugas')

@section('title', 'Dashboard Petugas - ' . config('app.name'))
@section('page-title', 'Dashboard Petugas')

@section('content')
<!-- Welcome Section -->
<div class="welcome-card" data-aos="fade-up">

    <div class="welcome-content">
        <div class="welcome-icon">
            <i class="fas fa-headset"></i>
        </div>
        <h1 class="welcome-title">Selamat datang, {{ Auth::user()->name }}! 👋</h1>
        <p class="welcome-subtitle">
            Kelola pengaduan sarana dan prasarana dengan cepat dan efisien.
            Dashboard ini membantu Anda memantau dan menangani setiap laporan secara real-time.
        </p>
        {{--
        <a href="{{ route('petugas.pengaduan.index') }}" class="btn-modern">
            <i class="fas fa-clipboard-list me-2"></i>
            Kelola Pengaduan
        </a>
         --}}
    </div>
</div>

<!-- Statistics Cards -->
<div class="stats-grid">
    @php
        $statsData = [
            ['label' => 'Diajukan', 'value' => $stats['diajukan'] ?? 0, 'icon' => 'fas fa-file-alt', 'color' => 'primary'],
            ['label' => 'Disetujui', 'value' => $stats['disetujui'] ?? 0, 'icon' => 'fas fa-thumbs-up', 'color' => 'success'],
            ['label' => 'Ditolak', 'value' => $stats['ditolak'] ?? 0, 'icon' => 'fas fa-times', 'color' => 'danger'],
            ['label' => 'Diproses', 'value' => $stats['proses'] ?? 0, 'icon' => 'fas fa-spinner', 'color' => 'warning'],
            ['label' => 'Selesai', 'value' => $stats['selesai'] ?? 0, 'icon' => 'fas fa-check-circle', 'color' => 'info'],
            ['label' => 'Total Laporan', 'value' => $stats['total'] ?? 0, 'icon' => 'fas fa-clipboard-list', 'color' => 'dark'],
        ];
    @endphp

    @foreach($statsData as $stat)
        <div class="stat-card glass-card" data-aos="fade-up" data-aos-delay="{{ $loop->index * 100 }}">
            <div class="stat-icon {{ $stat['color'] }}">
                <i class="{{ $stat['icon'] }}"></i>
            </div>
            <div class="stat-value">{{ $stat['value'] }}</div>
            <div class="stat-label">{{ $stat['label'] }}</div>
        </div>
    @endforeach
</div>



                <!-- Recent Activity Section -->
<div class="activity-section">
    <div class="section-header" data-aos="fade-up">
        <h2 class="section-title">Aktivitas Terbaru</h2>
        <a href="{{ route('petugas.pengaduan.index') }}" class="btn-modern">
            <i class="fas fa-eye me-2"></i> Lihat Semua
        </a>
    </div>

    <div class="activity-list">
        @forelse($recentActivities as $report)
            <div class="activity-card-modern-v2 status-{{ strtolower($report->status) }}" data-aos="fade-up" data-aos-delay="{{ $loop->index * 80 }}">

                <div class="activity-icon-circle-v2">
                    @php
                        $icons = [
                            'diajukan' => 'fas fa-file-alt',
                            'disetujui' => 'fas fa-thumbs-up',
                            'ditolak' => 'fas fa-times-circle',
                            'diproses' => 'fas fa-cogs',
                            'selesai' => 'fas fa-check-double'
                        ];
                        $iconClass = $icons[strtolower($report->status)] ?? 'fas fa-clipboard-list';
                    @endphp
                    <i class="{{ $iconClass }}"></i>
                </div>

                <div class="activity-content-v2">
                    <h3 class="activity-title-v2">{{ $report->nama_pengaduan }}</h3>
                    <p class="activity-meta-v2">
                        <span>Dibuat: {{ \Carbon\Carbon::parse($report->created_at)->diffForHumans() }}</span> •
                        <span>Prioritas:
                            @if($report->prioritas == 'tinggi')
                                <span class="priority-tag-v2 priority-tinggi">Tinggi</span>
                            @elseif($report->prioritas == 'sedang')
                                <span class="priority-tag-v2 priority-sedang">Sedang</span>
                            @else
                                <span class="priority-tag-v2 priority-rendah">Rendah</span>
                            @endif
                        </span>
                    </p>
                </div>

                <span class="activity-badge-v2 badge-{{ strtolower($report->status) }}">
                    {{ ucfirst($report->status) }}
                </span>
            </div>
        @empty
            <div class="empty-state-v2" data-aos="fade-up">
                <i class="fas fa-inbox"></i>
                <h3>Belum ada aktivitas</h3>
                <p>Tidak ada pengaduan yang perlu ditangani saat ini.</p>
            </div>
        @endforelse
    </div>
</div>


{{--
<!-- aksi cepat tutup dulu -->
<div class="activity-section mt-5">
    <div class="section-header" data-aos="fade-up">
        <h2 class="section-title">Aksi Cepat</h2>
    </div>

        <div class="col-md-4" data-aos="fade-up" data-aos-delay="200">
            <div class="glass-card p-4 text-center hover-lift">
                <div class="stat-icon warning mb-3">
                    <i class="fas fa-tasks"></i>
                </div>
                <h4>Pengaduan Diproses</h4>
                <p class="text-muted">Lihat pengaduan yang sedang dalam proses</p>
                <a href="{{ route('petugas.pengaduan.index') }}?status=diproses" class="btn btn-warning w-100">Lihat</a>
            </div>
        </div>
        --}}

<style>

    .activity-card-modern-v2 {
    background-color: #ffffff;
    border: 1px solid #e5e7eb; /* Garis tepi yang lebih halus */
    border-radius: 1rem;
    padding: 1.25rem;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.04);
    transition: transform 0.3s ease, box-shadow 0.3s ease;
    display: flex;
    align-items: center;
    margin-bottom: 1rem; /* Jarak antar kartu */
}

.activity-card-modern-v2:hover {
    transform: translateY(-3px);
    box-shadow: 0 8px 24px rgba(0, 0, 0, 0.08);
}

.activity-icon-circle-v2 {
    width: 50px;
    height: 50px;
    min-width: 50px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.25rem;
    margin-right: 1.5rem;
    color: #ffffff; /* Warna ikon default putih */
}

.activity-content-v2 {
    flex-grow: 1;
}

.activity-title-v2 {
    font-size: 1rem;
    font-weight: 600;
    color: #1f2937;
    margin: 0 0 0.25rem 0;
    line-height: 1.4;
}

.activity-meta-v2 {
    font-size: 0.8rem;
    color: #6b7280;
    margin: 0;
}

.priority-tag-v2 {
    font-size: 0.75rem;
    padding: 0.1rem 0.5rem;
    border-radius: 0.5rem;
    font-weight: 600;
}

/* Warna Prioritas */
.priority-tinggi { background-color: #fecaca; color: #dc2626; } /* Merah */
.priority-sedang { background-color: #fcd34d; color: #b45309; } /* Kuning Tua */
.priority-rendah { background-color: #d1fae5; color: #059669; } /* Hijau Muda */

/* Badge Status (Pill Badge) */
.activity-badge-v2 {
    min-width: 80px;
    text-align: center;
    padding: 0.4rem 0.8rem;
    font-size: 0.75rem;
    font-weight: 700;
    border-radius: 9999px;
    text-transform: capitalize;
}

/* Warna Icon dan Badge untuk Setiap Status */

/* Disetujui - Menggunakan warna Ceklis Hijau */
.status-disetujui .activity-icon-circle-v2 { background-color: #059669; }
.status-disetujui .activity-icon-circle-v2 i { color: #ffffff; }
.badge-disetujui { background-color: #059669; color: #ffffff; }

/* Diajukan - Menggunakan warna Biru Muda */
.status-diajukan .activity-icon-circle-v2 { background-color: #0ea5e9; }
.status-diajukan .activity-icon-circle-v2 i { color: #ffffff; }
.badge-diajukan { background-color: #0ea5e9; color: #ffffff; }

/* Diproses - Menggunakan warna Orange/Kuning */
.status-diproses .activity-icon-circle-v2 { background-color: #f59e0b; }
.status-diproses .activity-icon-circle-v2 i { color: #ffffff; }
.badge-diproses { background-color: #f59e0b; color: #ffffff; }

/* Selesai - Menggunakan warna Hijau Terang */
.status-selesai .activity-icon-circle-v2 { background-color: #10b981; }
.status-selesai .activity-icon-circle-v2 i { color: #ffffff; }
.badge-selesai { background-color: #10b981; color: #ffffff; }

/* Ditolak - Menggunakan warna Merah */
.status-ditolak .activity-icon-circle-v2 { background-color: #ef4444; }
.status-ditolak .activity-icon-circle-v2 i { color: #ffffff; }
.badge-ditolak { background-color: #ef4444; color: #ffffff; }

/* Empty State */
.empty-state-v2 {
    text-align: center;
    padding: 3rem;
    border-radius: 1rem;
    background-color: #f9fafb;
    border: 1px dashed #e5e7eb;
    color: #9ca3af;
}
.empty-state-v2 i { font-size: 3rem; margin-bottom: 0.5rem; }
.empty-state-v2 h3 { font-size: 1.25rem; font-weight: 600; color: #4b5563; }
    .hover-lift {
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }

    .hover-lift:hover {
        transform: translateY(-8px);
        box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
    }

    .btn {
        border: none;
        padding: 0.75rem 1.5rem;
        border-radius: var(--border-radius-sm);
        font-weight: 600;
        transition: var(--transition);
    }

    .btn:hover {
        transform: translateY(-2px);
    }
</style>

<script>
    // Add interactive elements
    document.addEventListener('DOMContentLoaded', function() {
        // Add click effects to activity items
        const activityItems = document.querySelectorAll('.activity-item');
        activityItems.forEach(item => {
            item.addEventListener('click', function() {
                // Add visual feedback
                this.style.transform = 'scale(0.98)';
                setTimeout(() => {
                    this.style.transform = '';
                }, 150);
            });
        });

        // Animate numbers in stats
        const statValues = document.querySelectorAll('.stat-value');
        statValues.forEach(stat => {
            const finalValue = parseInt(stat.textContent);
            let currentValue = 0;
            const increment = finalValue / 30;
            const timer = setInterval(() => {
                currentValue += increment;
                if (currentValue >= finalValue) {
                    stat.textContent = finalValue;
                    clearInterval(timer);
                } else {
                    stat.textContent = Math.floor(currentValue);
                }
            }, 50);
        });
    });
</script>
  <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        // Inisialisasi AOS (Animate On Scroll)
        AOS.init({
            duration: 800,
            once: true,
            easing: 'ease-out-cubic'
        });
    </script>
@endsection
