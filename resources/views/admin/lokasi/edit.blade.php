@extends('layouts.admin')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <!-- Header Card -->
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-white border-0 py-4">
                    <div class="d-flex align-items-center">
                        <div class="header-icon bg-primary bg-opacity-10 rounded-circle p-3 me-3">
                            <i class="fas fa-map-marker-alt text-primary fs-4"></i>
                        </div>
                        <div>
                            <h4 class="fw-bold mb-1">Edit Lokasi</h4>
                            <p class="text-muted mb-0">Ubah informasi lokasi dan barang yang tersedia</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Form Card -->
            <div class="card border-0 shadow-sm">
                <div class="card-body p-4">
                    <form method="POST" action="{{ route('admin.lokasi.update', $lokasi->id_lokasi) }}" class="needs-validation" novalidate>
                        @csrf
                        @method('PUT')

                        <!-- Location Name Field -->
                        <div class="form-group-modern mb-4">
                            <label for="nama_lokasi" class="form-label fw-semibold mb-2">
                                <i class="fas fa-tag me-2 text-primary"></i>Nama Lokasi
                            </label>
                            <div class="input-group">
                                <span class="input-group-text bg-primary bg-opacity-10 border-primary">
                                    <i class="fas fa-map-marker-alt text-primary"></i>
                                </span>
                                <input type="text"
                                       class="form-control border-primary py-3"
                                       id="nama_lokasi"
                                       name="nama_lokasi"
                                       value="{{ old('nama_lokasi', $lokasi->nama_lokasi) }}"
                                       placeholder="Masukkan nama lokasi"
                                       required>
                            </div>
                            @error('nama_lokasi')
                                <div class="text-danger small mt-2">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Items Selection -->
                        <div class="form-group-modern mb-4">
                            <label class="form-label fw-semibold mb-3">
                                <i class="fas fa-boxes me-2 text-primary"></i>Pilih Barang di Lokasi Ini
                            </label>

                            <div class="items-container">
                                @if($items->count() > 0)
                                    <div class="row g-3">
                                        @foreach($items as $item)
                                            <div class="col-md-6 col-lg-4">
                                                <div class="item-card">
                                                    <input class="form-check-input visually-hidden"
                                                           type="checkbox"
                                                           name="items[]"
                                                           value="{{ $item->id_item }}"
                                                           id="item{{ $item->id_item }}"
                                                           {{ $lokasi->items->contains($item->id_item) ? 'checked' : '' }}>
                                                    <label class="item-card-label" for="item{{ $item->id_item }}">
                                                        <div class="item-card-content">
                                                            <div class="item-icon bg-primary bg-opacity-10 rounded-2 p-2 mb-2">
                                                                <i class="fas fa-box text-primary"></i>
                                                            </div>
                                                            <div class="item-name fw-semibold">{{ $item->nama_item }}</div>
                                                            <div class="item-status">
                                                                @if($lokasi->items->contains($item->id_item))
                                                                    <span class="badge bg-success bg-opacity-10 text-success">
                                                                        <i class="fas fa-check-circle me-1"></i>Tersedia
                                                                    </span>
                                                                @else
                                                                    <span class="badge bg-secondary bg-opacity-10 text-secondary">
                                                                        <i class="fas fa-times-circle me-1"></i>Tidak Tersedia
                                                                    </span>
                                                                @endif
                                                            </div>
                                                        </div>
                                                    </label>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                @else
                                    <div class="empty-state text-center py-5">
                                        <div class="empty-icon mb-3">
                                            <i class="fas fa-box-open fa-3x text-light bg-primary bg-opacity-10 rounded-3 p-4"></i>
                                        </div>
                                        <h6 class="fw-semibold text-muted">Belum Ada Barang</h6>
                                        <p class="text-muted small mb-3">Tidak ada barang yang tersedia untuk dikelola</p>
                                        <a href="{{ route('admin.items.create') }}" class="btn btn-primary btn-sm">
                                            <i class="fas fa-plus me-2"></i>Tambah Barang
                                        </a>
                                    </div>
                                @endif
                            </div>
                        </div>

                        <!-- Action Buttons -->
                        <div class="d-flex gap-3 pt-4 border-top">
                            <button type="submit" class="btn btn-primary-modern flex-fill">
                                <i class="fas fa-save me-2"></i>
                                Simpan Perubahan Lokasi
                            </button>
                            
                        </div>
                    </form>
                </div>
            </div>

            <!-- Summary Card -->
            <div class="card border-0 shadow-sm mt-4">
                <div class="card-body p-4">
                    <div class="row text-center">
                        <div class="col-md-3">
                            <div class="stat-item">
                                <div class="stat-value text-primary fw-bold">{{ $items->count() }}</div>
                                <div class="stat-label text-muted small">Total Barang</div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="stat-item">
                                <div class="stat-value text-success fw-bold">{{ $lokasi->items->count() }}</div>
                                <div class="stat-label text-muted small">Barang di Lokasi</div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="stat-item">
                                <div class="stat-value text-info fw-bold">{{ $items->count() - $lokasi->items->count() }}</div>
                                <div class="stat-label text-muted small">Barang Tersedia</div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="stat-item">
                                <div class="stat-value text-warning fw-bold">{{ $lokasi->id_lokasi }}</div>
                                <div class="stat-label text-muted small">ID Lokasi</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
/* Modern Card Styles */
.card {
    border-radius: 16px;
    transition: all 0.3s ease;
    border: 1px solid rgba(0, 0, 0, 0.08);
}

.card:hover {
    box-shadow: 0 8px 25px rgba(0, 0, 0, 0.12);
}

.card-header {
    border-bottom: 1px solid rgba(0, 0, 0, 0.06);
}

.header-icon {
    width: 56px;
    height: 56px;
    display: flex;
    align-items: center;
    justify-content: center;
}

/* Form Styles */
.form-group-modern {
    margin-bottom: 2rem;
}

.form-label {
    font-size: 1rem;
    color: #2d3748;
    margin-bottom: 0.75rem;
}

.form-control {
    border-radius: 12px;
    padding: 0.75rem 1rem;
    border: 2px solid #e2e8f0;
    transition: all 0.3s ease;
}

.form-control:focus {
    border-color: #4361ee;
    box-shadow: 0 0 0 0.2rem rgba(67, 97, 238, 0.25);
}

.input-group-text {
    border-radius: 12px 0 0 12px;
    border: 2px solid #e2e8f0;
    border-right: none;
    background-color: #f8fafc;
}

.input-group .form-control {
    border-left: none;
    border-radius: 0 12px 12px 0;
}

/* Items Container */
.items-container {
    max-height: 500px;
    overflow-y: auto;
    padding: 0.5rem;
}

/* Item Card Styles */
.item-card {
    position: relative;
    margin-bottom: 0;
}

.item-card-label {
    display: block;
    border: 2px solid #e2e8f0;
    border-radius: 12px;
    padding: 1.25rem;
    cursor: pointer;
    transition: all 0.3s ease;
    background: #ffffff;
    height: 100%;
}

.item-card-label:hover {
    border-color: #4361ee;
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
}

.form-check-input:checked + .item-card-label {
    border-color: #4361ee;
    background: rgba(67, 97, 238, 0.05);
    box-shadow: 0 4px 12px rgba(67, 97, 238, 0.15);
}

.item-card-content {
    text-align: center;
}

.item-icon {
    width: 48px;
    height: 48px;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 0.75rem;
}

.item-name {
    font-size: 0.9rem;
    color: #2d3748;
    margin-bottom: 0.5rem;
    line-height: 1.3;
}

.item-status .badge {
    font-size: 0.7rem;
    padding: 0.35rem 0.75rem;
    border-radius: 20px;
}

/* Modern Button Styles */
.btn-primary-modern {
    background: linear-gradient(135deg, #4361ee, #3a0ca3);
    border: none;
    border-radius: 12px;
    padding: 0.875rem 1.5rem;
    font-weight: 600;
    color: white;
    transition: all 0.3s ease;
    height: 52px;
}

.btn-primary-modern:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(67, 97, 238, 0.4);
    color: white;
}

.btn-secondary-modern {
    background: #ffffff;
    border: 2px solid #e2e8f0;
    border-radius: 12px;
    padding: 0.875rem 1.5rem;
    font-weight: 600;
    color: #4a5568;
    transition: all 0.3s ease;
    height: 52px;
}

.btn-secondary-modern:hover {
    background: #f7fafc;
    border-color: #cbd5e0;
    transform: translateY(-2px);
    color: #4a5568;
}

/* Empty State */
.empty-state {
    padding: 2rem 1rem;
}

.empty-icon {
    display: inline-block;
}

/* Summary Stats */
.stat-item {
    padding: 0.5rem;
}

.stat-value {
    font-size: 1.5rem;
    line-height: 1;
    margin-bottom: 0.25rem;
}

.stat-label {
    font-size: 0.8rem;
}

/* Scrollbar Styling */
.items-container::-webkit-scrollbar {
    width: 6px;
}

.items-container::-webkit-scrollbar-track {
    background: rgba(0, 0, 0, 0.05);
    border-radius: 3px;
}

.items-container::-webkit-scrollbar-thumb {
    background: rgba(0, 0, 0, 0.2);
    border-radius: 3px;
}

.items-container::-webkit-scrollbar-thumb:hover {
    background: rgba(0, 0, 0, 0.3);
}

/* Responsive Design */
@media (max-width: 768px) {
    .container {
        padding: 1rem;
    }

    .card-body {
        padding: 1.5rem !important;
    }

    .d-flex.gap-3 {
        flex-direction: column;
    }

    .btn-primary-modern,
    .btn-secondary-modern {
        width: 100%;
    }

    .header-icon {
        width: 48px;
        height: 48px;
    }

    .header-icon i {
        font-size: 1.25rem !important;
    }

    .items-container {
        max-height: 400px;
    }

    .row.text-center .col-md-3 {
        margin-bottom: 1rem;
    }
}

@media (max-width: 576px) {
    .row.g-3 {
        margin: 0 -0.5rem;
    }

    .col-md-6 {
        padding: 0 0.5rem;
    }

    .item-card-label {
        padding: 1rem;
    }

    .item-icon {
        width: 40px;
        height: 40px;
        margin-bottom: 0.5rem;
    }

    .item-name {
        font-size: 0.85rem;
    }
}

/* Animation */
@keyframes fadeInUp {
    from {
        opacity: 0;
        transform: translateY(20px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.card {
    animation: fadeInUp 0.6s ease-out;
}

.card:nth-child(2) {
    animation-delay: 0.1s;
}

.card:nth-child(3) {
    animation-delay: 0.2s;
}

.item-card {
    animation: fadeInUp 0.4s ease-out;
}

/* Checkbox Selection Animation */
.form-check-input:checked + .item-card-label .item-icon {
    animation: bounce 0.6s ease;
}

@keyframes bounce {
    0%, 20%, 60%, 100% {
        transform: scale(1);
    }
    40% {
        transform: scale(1.1);
    }
    80% {
        transform: scale(0.95);
    }
}
</style>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Add loading state to submit button
    const submitBtn = document.querySelector('.btn-primary-modern');
    if (submitBtn) {
        submitBtn.addEventListener('click', function(event) {
    const form = document.querySelector('.needs-validation');

    if (form.checkValidity()) {
        // Form valid → kirim
        this.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Menyimpan...';
        this.disabled = true;
        form.submit(); // ✅ pastikan form dikirim
    } else {
        // Form tidak valid → jangan disable tombol
        event.preventDefault();
        event.stopPropagation();
        form.classList.add('was-validated');
    }
});
    }



    // Enhanced checkbox interaction
  document.addEventListener("DOMContentLoaded", function () {

    const checkboxes = document.querySelectorAll('input[name="items[]"]');

    checkboxes.forEach(checkbox => {
        checkbox.addEventListener('change', function() {

            const card = this.closest('.item-card');
            const statusDiv = card.querySelector('.item-status');

            if (this.checked) {
                statusDiv.innerHTML = `
                    <span class="badge bg-success bg-opacity-10 text-success">
                        <i class="fas fa-check-circle me-1"></i> Tersedia
                    </span>`;
            } else {
                statusDiv.innerHTML = `
                    <span class="badge bg-secondary bg-opacity-10 text-secondary">
                        <i class="fas fa-times-circle me-1"></i> Tidak Tersedia
                    </span>`;
            }
        });
    });

});




    // Form validation
    const form = document.querySelector('.needs-validation');
    if (form) {
        form.addEventListener('submit', function(event) {
            if (!form.checkValidity()) {
                event.preventDefault();
                event.stopPropagation();
            }
            form.classList.add('was-validated');
        });
    }

    // Real-time character counter for location name
    const locationNameInput = document.getElementById('nama_lokasi');
    if (locationNameInput) {
        locationNameInput.addEventListener('input', function() {
            const maxLength = 100; // Adjust as needed
            const currentLength = this.value.length;

            // You can add a character counter here if needed
            console.log(`Character count: ${currentLength}/${maxLength}`);
        });
    }
});
</script>
@endpush
@endsection
