@extends('layouts.user')

@section('content')
<div class="container py-5">
    <!-- Header -->
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-4">
        <div>
            <h2 class="fw-bold text-primary mb-1">
                <i class="fas fa-list-alt me-2"></i> Pengaduan Saya
            </h2>
            <p class="text-muted mb-0">Pantau status dan progress laporan Anda</p>
        </div>
        <div class="mt-3 mt-md-0">
            <a href="{{ route('pengaduan.create') }}" class="btn btn-primary rounded-pill px-4">
                <i class="fas fa-plus me-2"></i>Buat Pengaduan Baru
            </a>
        </div>
    </div>

    @if($pengaduan->count() > 0)
        <div class="row g-4">
            @foreach($pengaduan as $p)
                <div class="col-lg-6">
                    <div class="card border-0 shadow-sm rounded-4 hover-card h-100">
                        <div class="card-body">
                            <!-- Title + Status -->
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <h5 class="fw-bold text-dark mb-0">{{ $p->nama_pengaduan }}</h5>
                                <span class="badge rounded-pill px-3 py-2 fs-6
                                    @if($p->status === 'Selesai') bg-success
                                    @elseif($p->status === 'Diproses') bg-warning text-dark
                                    @elseif($p->status === 'Ditolak') bg-danger
                                    @else bg-primary @endif">
                                    <i class="fas fa-circle small me-1"></i>{{ ucfirst($p->status) }}
                                </span>
                            </div>

                            <!-- Date -->
                            <p class="text-muted small mb-2">
                                <i class="fas fa-calendar me-1"></i>
                                {{ \Carbon\Carbon::parse($p->tgl_pengajuan)->format('d M Y') }}
                            </p>

                            <!-- Description -->
                            <p class="mb-3 text-truncate">{{ $p->deskripsi }}</p>

                            <!-- Foto -->
                            @if($p->foto)
                                <img src="{{ asset('storage/'.$p->foto) }}"
                                    alt="Bukti Foto"
                                    class="img-fluid rounded shadow-sm foto-preview"
                                    style="max-height: 150px; object-fit: cover; cursor:pointer;"
                                    data-bs-toggle="modal"
                                    data-bs-target="#fotoModal"
                                    data-foto-src="{{ asset('storage/'.$p->foto) }}"
                                    data-foto-title="{{ $p->nama_pengaduan }}">
                            @else
                                <div class="bg-light text-center rounded py-4 text-muted">
                                    <i class="fas fa-image fa-2x mb-2"></i>
                                    <p class="small mb-0">Tidak ada foto</p>
                                </div>
                            @endif

                            <!-- Footer -->
                            <div class="d-flex justify-content-between align-items-center mt-3">
                                <small class="text-muted">
                                    <i class="fas fa-tools me-1"></i>{{ $p->item->nama_item ?? '-' }}
                                </small>
                                <div>
                                    <button class="btn btn-outline-primary btn-sm detail-btn"
                                            data-pengaduan="{{ json_encode($p) }}">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                    @if(in_array(strtolower($p->status), ['diajukan','ditolak']))
                                        <a href="{{ route('pengaduan.edit', $p->id_pengaduan) }}"
                                           class="btn btn-outline-warning btn-sm">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <!-- Empty State -->
        <div class="text-center py-5">
            <i class="fas fa-inbox fa-5x text-muted opacity-50 mb-3"></i>
            <h4 class="text-muted">Belum Ada Pengaduan</h4>
            <p class="text-muted">Mulai laporkan masalah sarana prasarana Anda di sini.</p>
            <a href="{{ route('pengaduan.create') }}" class="btn btn-primary rounded-pill px-4">
                <i class="fas fa-plus me-2"></i>Buat Pengaduan Pertama
            </a>
        </div>
    @endif
</div>

<!-- Foto Modal -->
<div class="modal fade" id="fotoModal" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content border-0 rounded-4">
            <div class="modal-header border-0">
                <h5 class="modal-title" id="fotoModalTitle">Foto Pengaduan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body text-center p-0">
                <img src="" alt="Foto Pengaduan" class="img-fluid rounded-bottom-4" id="fotoModalImage">
            </div>
        </div>
    </div>
</div>

<!-- Detail Modal -->
<div class="modal fade" id="detailModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content border-0 rounded-4">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title"><i class="fas fa-info-circle me-2"></i>Detail Pengaduan</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body" id="detailModalBody">
                <!-- Content by JS -->
            </div>
        </div>
    </div>
</div>

<style>
.hover-card { transition: all 0.3s ease; }
.hover-card:hover { transform: translateY(-5px); box-shadow: 0 8px 25px rgba(0,0,0,0.15) !important; }
.foto-preview:hover { transform: scale(1.05); transition: all 0.3s ease; }
</style>

<script>
document.addEventListener('DOMContentLoaded', () => {
    // Foto Modal
    document.querySelectorAll('.foto-preview').forEach(img => {
        img.addEventListener('click', function() {
            document.getElementById('fotoModalImage').src = this.dataset.fotoSrc;
            document.getElementById('fotoModalTitle').textContent = this.dataset.fotoTitle;
        });
    });

    // Detail Modal
    document.querySelectorAll('.detail-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            const p = JSON.parse(this.dataset.pengaduan);
            const modalBody = document.getElementById('detailModalBody');
            modalBody.innerHTML = `
                <h4 class="fw-bold mb-3">${p.nama_pengaduan}</h4>
                <p class="text-muted"><i class="fas fa-calendar me-1"></i> ${p.tgl_pengajuan}</p>
                <p>${p.deskripsi}</p>
                ${p.foto ? `<img src="/storage/${p.foto}" class="img-fluid rounded shadow mt-3">` : ''}
            `;
            new bootstrap.Modal(document.getElementById('detailModal')).show();
        });
    });
});
</script>
@endsection
