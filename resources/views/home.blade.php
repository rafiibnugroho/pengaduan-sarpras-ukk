@extends('layouts.user')

@section('title', 'Dashboard - ' . config('app.name'))

@section('content')
    <!-- Hero Welcome Section -->
    <div class="glass-card mb-5 animate-fadeInUp">
        <div class="row align-items-center">
            <div class="col-lg-8">
                <div class="p-5">
                    <div class="d-flex align-items-center mb-4">
                        <div class="bg-primary bg-opacity-10 p-3 rounded-circle me-4">
                            <i data-lucide="sparkles" class="text-primary" style="width: 32px; height: 32px;"></i>
                        </div>
                        <div>
                            <h1 class="display-5 fw-bold text-gradient mb-2">
                                Selamat Datang, <span class="text-primary">{{ Auth::user()->name }}</span>! 👋
                            </h1>

                        </div>
                    </div>

                    <p class="lead text-muted mb-4">
                        Selamat datang di <strong class="text-primary">Sistem Pengaduan Sarana & Prasarana Digital SMKN 1 BANTUL</strong>.
                        Laporkan masalah infrastruktur dengan mudah dan pantau progressnya secara real-time.
                    </p>

                    <div class="d-flex flex-wrap gap-3">
                        <a href="{{ route('pengaduan.create') }}"
                           class="btn-modern btn-primary animate-float">
                            <i data-lucide="plus-circle" class="me-2"></i>
                            Buat Laporan Baru
                        </a>
                        <a href="{{ route('pengaduan.index') }}"
                           class="btn-modern btn-secondary">
                            <i data-lucide="clock" class="me-2"></i>
                            Lihat Riwayat
                        </a>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 d-none d-lg-block">
                <div class="text-center p-4">
                    <div class="position-relative">
                        <div class="floating-element" style="width: 200px; height: 200px; background: var(--primary-gradient); opacity: 0.1; border-radius: 50%; position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%);"></div>
                        <i data-lucide="shield-check" class="text-primary" style="width: 120px; height: 120px; position: relative; z-index: 2;"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Enhanced Statistics Cards -->
    <div class="stats-grid animate-fadeInUp" style="animation-delay: 0.1s;">
        <div class="glass-card stat-card" style="border-left: 4px solid var(--success);">
            <div class="stat-value text-success">{{ $stats['selesai'] ?? 0 }}</div>
            <div class="stat-label">Laporan Selesai</div>
            <i data-lucide="check-circle" class="text-success mt-3" style="width: 40px; height: 40px;"></i>
            <div class="progress mt-3">
                <div class="progress-bar bg-success" style="width: {{ ($stats['selesai'] ?? 0) / max(($stats['total'] ?? 1), 1) * 100 }}%"></div>
            </div>
        </div>

        <div class="glass-card stat-card" style="border-left: 4px solid var(--warning);">
            <div class="stat-value text-warning">{{ $stats['proses'] ?? 0 }}</div>
            <div class="stat-label">Sedang Diproses</div>
            <i data-lucide="clock" class="text-warning mt-3" style="width: 40px; height: 40px;"></i>
            <div class="progress mt-3">
                <div class="progress-bar bg-warning" style="width: {{ ($stats['proses'] ?? 0) / max(($stats['total'] ?? 1), 1) * 100 }}%"></div>
            </div>
        </div>

        <div class="glass-card stat-card" style="border-left: 4px solid var(--primary-color);">
            <div class="stat-value text-primary">{{ $stats['diajukan'] ?? 0 }}</div>
            <div class="stat-label">Menunggu Review</div>
            <i data-lucide="send" class="text-primary mt-3" style="width: 40px; height: 40px;"></i>
            <div class="progress mt-3">
                <div class="progress-bar bg-primary" style="width: {{ ($stats['diajukan'] ?? 0) / max(($stats['total'] ?? 1), 1) * 100 }}%"></div>
            </div>
        </div>

        <div class="glass-card stat-card" style="border-left: 4px solid var(--dark);">
            <div class="stat-value text-dark">{{ $stats['total'] ?? 0 }}</div>
            <div class="stat-label">Total Laporan</div>
            <i data-lucide="file-text" class="text-dark mt-3" style="width: 40px; height: 40px;"></i>
            <div class="progress mt-3">
                <div class="progress-bar bg-dark" style="width: 100%"></div>
            </div>
        </div>
    </div>

    <div class="row mt-4">
        <!-- Recent Reports -->
        <div class="col-lg-8 mb-4">
            <div class="glass-card animate-slideInLeft">
                <div class="card-header border-0 bg-transparent p-4">
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="d-flex align-items-center">
                            <div class="bg-primary bg-opacity-10 p-2 rounded-circle me-3">
                                <i data-lucide="file-text" class="text-primary" style="width: 24px; height: 24px;"></i>
                            </div>
                            <div>
                                <h5 class="mb-1 fw-bold">Laporan Terbaru</h5>
                                <p class="text-muted mb-0">Pantau status laporan Anda terkini</p>
                            </div>
                        </div>
                        <a href="{{ route('pengaduan.index') }}" class="btn-modern btn-secondary btn-sm">
                            Lihat Semua
                            <i data-lucide="arrow-right" class="ms-1"></i>
                        </a>
                    </div>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table modern-table table-hover mb-0">
                            <thead>
                                <tr>
                                    <th>ID Laporan</th>
                                    <th>Judul Pengaduan</th>
                                    <th>Status</th>
                                    <th>Tanggal</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($recentReports as $report)
                                    <tr>
                                        <td>
                                            <code class="bg-light px-2 py-1 rounded">#{{ str_pad($report->id_pengaduan, 4, '0', STR_PAD_LEFT) }}</code>
                                        </td>
                                        <td>
                                            <div>
                                                <div class="fw-semibold">{{ Str::limit($report->nama_pengaduan, 35) }}</div>
                                               @if($report->lokasi)
                                                    <small class="text-muted">
                                                        <i data-lucide="map-pin" class="me-1" style="width: 12px; height: 12px;"></i>
                                                        {{ Str::limit($report->lokasi->nama_lokasi ?? '-', 25) }}
                                                    </small>
                                                @endif
                                            </div>
                                        </td>
                                        <td>
                                            @php
                                                $statusConfig = [
                                                    'Selesai' => ['class' => 'bg-success', 'icon' => 'check-circle', 'color' => 'success'],
                                                    'Diproses' => ['class' => 'bg-warning', 'icon' => 'clock', 'color' => 'warning'],
                                                    'Ditolak' => ['class' => 'bg-danger', 'icon' => 'x-circle', 'color' => 'danger'],
                                                    'Diajukan' => ['class' => 'bg-primary', 'icon' => 'send', 'color' => 'primary'],
                                                ];
                                                $config = $statusConfig[$report->status] ?? ['class' => 'bg-primary', 'icon' => 'help-circle', 'color' => 'primary'];
                                            @endphp
                                            <span class="badge badge-modern bg-{{ $config['color'] }}-light text-{{ $config['color'] }}">
                                                <i data-lucide="{{ $config['icon'] }}" class="me-1" style="width: 12px; height: 12px;"></i>
                                                {{ $report->status }}
                                            </span>
                                        </td>
                                        <td>
                                            <div class="fw-semibold">{{ $report->created_at->format('d M Y') }}</div>
                                            <small class="text-muted">{{ $report->created_at->format('H:i') }}</small>
                                        </td>
                                        <td>
                                            <a href="{{ route('pengaduan.show', $report->id_pengaduan) }}"
                                               class="btn btn-outline-primary btn-sm">
                                                <i data-lucide="eye" class="me-1" style="width: 12px; height: 12px;"></i>
                                                Detail
                                            </a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center py-5">
                                            <div class="text-muted">
                                                <i data-lucide="inbox" class="mb-3" style="width: 48px; height: 48px; opacity: 0.5;"></i>
                                                <p class="fw-semibold mb-1">Belum ada laporan</p>
                                                <p class="mb-0">Buat laporan pertama Anda untuk memulai</p>
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>


        <!-- Quick Actions & Progress -->
        <div class="col-lg-4">
            <!-- Quick Actions -->
            <div class="glass-card mb-4 animate-slideInLeft" style="animation-delay: 0.2s;">
                <div class="card-body p-4">
                    <div class="d-flex align-items-center mb-4">
                        <div class="bg-primary bg-opacity-10 p-2 rounded-circle me-3">
                            <i data-lucide="zap" class="text-primary" style="width: 24px; height: 24px;"></i>
                        </div>
                        <div>
                            <h6 class="fw-bold mb-1">Akses Cepat</h6>
                            <p class="text-muted mb-0 small">Akses fitur utama dengan mudah</p>
                        </div>
                    </div>

                    <div class="d-grid gap-3">
                        <a href="{{ route('pengaduan.create') }}" class="d-flex align-items-center p-3 text-decoration-none rounded-3 bg-light-hover">
                            <div class="bg-success bg-opacity-10 p-2 rounded me-3">
                                <i data-lucide="plus-circle" class="text-success" style="width: 20px; height: 20px;"></i>
                            </div>
                            <div class="flex-grow-1">
                                <div class="fw-semibold">Buat Laporan Baru</div>
                                <div class="text-muted small">Laporkan masalah infrastruktur</div>
                            </div>
                            <i data-lucide="chevron-right" class="text-muted" style="width: 16px; height: 16px;"></i>
                        </a>

                        <a href="{{ route('pengaduan.index') }}" class="d-flex align-items-center p-3 text-decoration-none rounded-3 bg-light-hover">
                                                        <div class="bg-primary bg-opacity-10 p-2 rounded me-3">
                                <i data-lucide="file-text" class="text-primary" style="width: 20px; height: 20px;"></i>
                            </div>
                            <div class="flex-grow-1">
                                <div class="fw-semibold">Riwayat Laporan</div>
                                <div class="text-muted small">Lihat semua laporan Anda</div>
                            </div>
                            <i data-lucide="chevron-right" class="text-muted" style="width: 16px; height: 16px;"></i>
                        </a>

                        <a href="#" class="d-flex align-items-center p-3 text-decoration-none rounded-3 bg-light-hover">
                            <div class="bg-info bg-opacity-10 p-2 rounded me-3">
                                <i data-lucide="help-circle" class="text-info" style="width: 20px; height: 20px;"></i>
                            </div>
                            <div class="flex-grow-1">
                                <div class="fw-semibold">Panduan</div>
                                <div class="text-muted small">Cara membuat laporan</div>
                            </div>
                            <i data-lucide="chevron-right" class="text-muted" style="width: 16px; height: 16px;"></i>
                        </a>
                    </div>
                </div>
            </div>


            <!-- Progress Summary -->
            <div class="glass-card animate-slideInLeft" style="animation-delay: 0.4s;">
                <div class="card-body p-4">
                    <div class="d-flex align-items-center mb-4">
                        <div class="bg-success bg-opacity-10 p-2 rounded-circle me-3">
                            <i data-lucide="trending-up" class="text-success" style="width: 24px; height: 24px;"></i>
                        </div>
                        <div>
                            <h6 class="fw-bold mb-1">Ringkasan Progress</h6>
                            <p class="text-muted mb-0 small">Status pengaduan Anda</p>
                        </div>
                    </div>

                    @php
                        $total = max(($stats['total'] ?? 0), 1);
                        $selesaiPct = round((($stats['selesai'] ?? 0) / $total) * 100);
                        $prosesPct = round((($stats['proses'] ?? 0) / $total) * 100);
                        $diajukanPct = round((($stats['diajukan'] ?? 0) / $total) * 100);
                    @endphp

                    <div class="space-y-4">
                        @foreach([
                            ['color' => 'success', 'icon' => 'check-circle', 'label' => 'Selesai', 'value' => $selesaiPct, 'count' => $stats['selesai'] ?? 0],
                            ['color' => 'warning', 'icon' => 'clock', 'label' => 'Diproses', 'value' => $prosesPct, 'count' => $stats['proses'] ?? 0],
                            ['color' => 'primary', 'icon' => 'send', 'label' => 'Diajukan', 'value' => $diajukanPct, 'count' => $stats['diajukan'] ?? 0]
                        ] as $item)
                            <div class="progress-item">
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <span class="fw-semibold">
                                        <i data-lucide="{{ $item['icon'] }}" class="me-2 text-{{ $item['color'] }}" style="width: 16px; height: 16px;"></i>
                                        {{ $item['label'] }}
                                    </span>
                                    <span class="fw-bold text-{{ $item['color'] }}">{{ $item['value'] }}%</span>
                                </div>
                                <div class="progress" style="height: 8px;">
                                    <div class="progress-bar bg-{{ $item['color'] }}"
                                         style="width: {{ $item['value'] }}%"
                                         role="progressbar"
                                         data-value="{{ $item['value'] }}">
                                    </div>
                                </div>
                                <div class="d-flex justify-content-between align-items-center mt-1">
                                    <small class="text-muted">{{ $item['count'] }} laporan</small>
                                    <small class="fw-semibold text-{{ $item['color'] }}">{{ $item['value'] }}%</small>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <!-- Overall Progress Circle -->
                    <div class="text-center mt-4 pt-3 border-top">
                        <div class="position-relative d-inline-block">
                            <svg width="80" height="80" class="progress-circle">
                                <circle cx="40" cy="40" r="35" stroke="#e9ecef" stroke-width="6" fill="none"/>
                                <circle cx="40" cy="40" r="35" stroke="#10b981" stroke-width="6" fill="none"
                                        stroke-dasharray="220"
                                        stroke-dashoffset="{{ 220 - (220 * $selesaiPct / 100) }}"
                                        stroke-linecap="round" transform="rotate(-90 40 40)"/>
                            </svg>
                            <div class="position-absolute top-50 start-50 translate-middle">
                                <span class="fw-bold text-success">{{ $selesaiPct }}%</span>
                            </div>
                        </div>
                        <p class="small text-muted mt-2 mb-0">Tingkat Penyelesaian</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- aktivitas terbaru yang di tutup sementara
    <!-- Activity Timeline -->
    <div class="row mt-4">
        <div class="col-12">
            <div class="glass-card animate-fadeInUp" style="animation-delay: 0.6s;">
                <div class="card-header border-0 bg-transparent p-4">
                    <div class="d-flex align-items-center">
                        <div class="bg-info bg-opacity-10 p-2 rounded-circle me-3">
                            <i data-lucide="activity" class="text-info" style="width: 24px; height: 24px;"></i>
                        </div>
                        <div>
                            <h5 class="mb-1 fw-bold">Aktivitas Terkini</h5>
                            <p class="text-muted mb-0">Riwayat aktivitas laporan Anda</p>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="timeline">
                        @forelse($recentReports->take(3) as $activity)
                            <div class="timeline-item">
                                <div class="timeline-marker">
                                    <i data-lucide="circle" class="text-primary" style="width: 12px; height: 12px;"></i>
                                </div>
                                <div class="timeline-content">
                                    <div class="d-flex justify-content-between align-items-center mb-1">
                                        <span class="fw-semibold">Laporan #{{ str_pad($activity->id_pengaduan, 4, '0', STR_PAD_LEFT) }}</span>
                                        <small class="text-muted">{{ $activity->updated_at->diffForHumans() }}</small>
                                    </div>
                                    <p class="mb-1">{{ $activity->nama_pengaduan }}</p>
                                    <span class="badge bg-{{ $statusConfig[$activity->status]['color'] ?? 'primary' }}-light text-{{ $statusConfig[$activity->status]['color'] ?? 'primary' }}">
                                        Status: {{ $activity->status }}
                                    </span>
                                </div>
                            </div>
                        @empty
                            <div class="text-center py-4">
                                <i data-lucide="activity" class="text-muted mb-3" style="width: 48px; height: 48px; opacity: 0.5;"></i>
                                <p class="text-muted mb-0">Belum ada aktivitas terbaru</p>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
    --}}

    <!-- Enhanced Tips Section -->
    <div class="glass-card mt-4 animate-fadeInUp" style="animation-delay: 0.8s;">
        <div class="card-body p-5">
            <div class="row align-items-center">
                <div class="col-lg-8">
                    <h5 class="fw-bold mb-4">💡 Tips & Best Practices</h5>
                    <div class="row g-4">
                        <div class="col-md-6">
                            <div class="d-flex align-items-start">
                                <div class="bg-success bg-opacity-10 p-3 rounded-circle me-4">
                                    <i data-lucide="camera" class="text-success" style="width: 20px; height: 20px;"></i>
                                </div>
                                <div>
                                    <h6 class="fw-semibold mb-2">Foto yang Jelas</h6>
                                    <p class="text-muted small mb-0">Pastikan foto menunjukkan kerusakan dengan jelas dari berbagai angle</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="d-flex align-items-start">
                                <div class="bg-warning bg-opacity-10 p-3 rounded-circle me-4">
                                    <i data-lucide="map-pin" class="text-warning" style="width: 20px; height: 20px;"></i>
                                </div>
                                <div>
                                    <h6 class="fw-semibold mb-2">Lokasi Spesifik</h6>
                                    <p class="text-muted small mb-0">Sebutkan ruangan, lantai, dan landmark sekitar</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="d-flex align-items-start">
                                <div class="bg-primary bg-opacity-10 p-3 rounded-circle me-4">
                                    <i data-lucide="file-text" class="text-primary" style="width: 20px; height: 20px;"></i>
                                </div>
                                <div>
                                    <h6 class="fw-semibold mb-2">Deskripsi Detail</h6>
                                    <p class="text-muted small mb-0">Jelaskan kronologi dan dampak kerusakan secara rinci</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="d-flex align-items-start">
                                <div class="bg-info bg-opacity-10 p-3 rounded-circle me-4">
                                    <i data-lucide="refresh-cw" class="text-info" style="width: 20px; height: 20px;"></i>
                                </div>
                                <div>
                                    <h6 class="fw-semibold mb-2">Pantau Berkala</h6>
                                    <p class="text-muted small mb-0">Cek status laporan secara rutin untuk update terbaru</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 text-center">
                        <div class="bg-primary bg-opacity-10 p-3 rounded-circle d-inline-block mb-3">
                            <i data-lucide="clock" class="text-primary" style="width: 32px; height: 32px;"></i>
                        </div>
                        <h6 class="fw-semibold mb-2">Waktu Operasional</h6>
                        <p class="small text-muted mb-3">Tim kami siap membantu Anda</p>
                        <div class="bg-light p-3 rounded-3">
                            <div class="fw-semibold text-primary">Senin - Jumat</div>
                            <div class="text-muted small">08:00 - 16:00 WIB</div>
                        </div>
                        <div class="mt-3">
                            <small class="text-muted">Response time: 1-2 jam kerja</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{--
    <!-- Emergency Contact -->
    <div class="glass-card mt-4 animate-fadeInUp" style="animation-delay: 1s;">
        <div class="card-body text-center p-5">
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <div class="bg-danger bg-opacity-10 p-4 rounded-4 border border-danger border-2">
                        <i data-lucide="alert-triangle" class="text-danger mb-3" style="width: 48px; height: 48px;"></i>
                        <h5 class="fw-bold text-danger mb-3">Darurat?</h5>
                        <p class="text-muted mb-4">Untuk kerusakan yang membahayakan atau memerlukan penanganan segera</p>
                        <div class="d-flex justify-content-center gap-3 flex-wrap">
                            <a href="tel:+62123456789" class="btn btn-danger btn-modern">
                                <i data-lucide="phone" class="me-2"></i>
                                Hubungi Darurat
                            </a>
                            <a href="mailto:emergency@smkn1bantul.sch.id" class="btn btn-outline-danger btn-modern">
                                <i data-lucide="mail" class="me-2"></i>
                                Email Darurat
                            </a>
                        </div>
                    </div>
                    --}}
                </div>
            </div>
        </div>
    </div>
@endsection

@push('styles')
<style>
    /* Enhanced Timeline */
    .timeline {
        position: relative;
        padding-left: 2rem;
    }

    .timeline::before {
        content: '';
        position: absolute;
        left: 15px;
        top: 0;
        bottom: 0;
        width: 2px;
        background: var(--primary-gradient);
        opacity: 0.3;
    }

    .timeline-item {
        position: relative;
        margin-bottom: 2rem;
        display: flex;
        align-items: flex-start;
    }

    .timeline-marker {
        position: absolute;
        left: -2rem;
        top: 0.25rem;
        background: white;
        border-radius: 50%;
        padding: 0.25rem;
    }

    .timeline-content {
        flex: 1;
        background: rgba(255, 255, 255, 0.5);
        padding: 1rem 1.5rem;
        border-radius: var(--border-radius-sm);
        border-left: 3px solid var(--primary-color);
    }

    /* Progress Circle */
    .progress-circle {
        transform: rotate(-90deg);
    }

    .progress-circle circle {
        transition: stroke-dashoffset 1.5s ease-in-out;
    }

    /* Hover Effects */
    .bg-light-hover {
        transition: all 0.3s ease;
        border: 1px solid transparent;
    }

    .bg-light-hover:hover {
        background: rgba(255, 255, 255, 0.8) !important;
        border-color: var(--glass-border);
        transform: translateX(5px);
        box-shadow: var(--shadow-sm);
    }

    /* Progress Items */
    .progress-item {
        padding: 1rem;
        background: rgba(255, 255, 255, 0.3);
        border-radius: var(--border-radius-sm);
        margin-bottom: 1rem;
        transition: all 0.3s ease;
    }

    .progress-item:hover {
        background: rgba(255, 255, 255, 0.5);
        transform: translateY(-2px);
    }

    /* Responsive Design */
    @media (max-width: 768px) {
        .timeline {
            padding-left: 1.5rem;
        }

        .timeline-marker {
            left: -1.5rem;
        }

        .timeline-content {
            padding: 1rem;
        }
    }
</style>
@endpush

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Enhanced progress bar animation
        const progressBars = document.querySelectorAll('.progress-bar');
        progressBars.forEach(bar => {
            const width = bar.style.width;
            bar.style.width = '0';
            setTimeout(() => {
                bar.style.width = width;
                bar.style.transition = 'width 1.5s cubic-bezier(0.4, 0, 0.2, 1)';
            }, 300);
        });

        // Progress circle animation
        const progressCircles = document.querySelectorAll('.progress-circle circle');
        progressCircles.forEach(circle => {
            const dashoffset = circle.style.strokeDashoffset;
            circle.style.strokeDashoffset = '220';
            setTimeout(() => {
                circle.style.strokeDashoffset = dashoffset;
                circle.style.transition = 'stroke-dashoffset 2s ease-in-out';
            }, 500);
        });

        // Enhanced hover effects for cards
        const cards = document.querySelectorAll('.glass-card');
        cards.forEach(card => {
            card.addEventListener('mouseenter', function() {
                this.style.transform = 'translateY(-10px) scale(1.02)';
                this.style.boxShadow = '0 25px 50px -12px rgba(0,0,0,0.3)';
            });

            card.addEventListener('mouseleave', function() {
                this.style.transform = 'translateY(0) scale(1)';
                this.style.boxShadow = 'var(--shadow-sm)';
            });
        });

        // Ripple effect for buttons
        document.querySelectorAll('.btn-modern').forEach(button => {
            button.addEventListener('click', function(e) {
                const ripple = document.createElement('span');
                const rect = button.getBoundingClientRect();
                const size = Math.max(rect.width, rect.height);
                const x = e.clientX - rect.left - size / 2;
                const y = e.clientY - rect.top - size / 2;

                ripple.style.cssText = `
                    position: absolute;
                    border-radius: 50%;
                    background: rgba(255, 255, 255, 0.6);
                    transform: scale(0);
                    animation: ripple 0.6s linear;
                    width: ${size}px;
                    height: ${size}px;
                    left: ${x}px;
                    top: ${y}px;
                `;

                button.style.position = 'relative';
                button.style.overflow = 'hidden';
                button.appendChild(ripple);

                setTimeout(() => ripple.remove(), 600);
            });
        });

        // Add CSS for ripple animation
        if (!document.querySelector('#ripple-style')) {
            const style = document.createElement('style');
            style.id = 'ripple-style';
            style.textContent = `
                @keyframes ripple {
                    to {
                        transform: scale(4);
                        opacity: 0;
                    }
                }
            `;
            document.head.appendChild(style);
        }

        // Auto-refresh stats every 30 seconds
        setInterval(() => {
            fetch('{{ route('home.stats') }}')
                .then(response => response.json())
                .then(data => {
                    // Update stats cards
                    document.querySelectorAll('.stat-value').forEach((element, index) => {
                        const values = [data.selesai, data.proses, data.diajukan, data.total];
                        if (values[index] !== undefined) {
                            element.textContent = values[index];
                        }
                    });
                })
                .catch(error => console.log('Auto-refresh error:', error));
        }, 30000);

        // Scroll animations
        const observerOptions = {
            threshold: 0.1,
            rootMargin: '0px 0px -50px 0px'
        };

        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.style.opacity = '1';
                    entry.target.style.transform = 'translateY(0)';
                    entry.target.style.transition = 'all 0.8s cubic-bezier(0.175, 0.885, 0.32, 1.275)';
                }
            });
        }, observerOptions);

        document.querySelectorAll('.animate-fadeInUp, .animate-slideInLeft').forEach(el => {
            el.style.opacity = '0';
            el.style.transform = 'translateY(30px)';
            observer.observe(el);
        });
    });
</script>
@endpush
