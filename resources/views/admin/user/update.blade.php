    @extends('layouts.admin')

    @section('content')
    <h1 class="text-3xl font-bold text-gray-800 mb-6 border-b pb-2">Edit Pengaduan: {{ $pengaduan->judul }}</h1>

    <!-- Form untuk Update Pengaduan -->
    <form action="{{ route('admin.pengaduan.update', $pengaduan->id) }}" method="POST">
        @csrf
        @method('PUT') {{-- Metode spoofing untuk UPDATE --}}

        <!-- Field Judul -->
        <div class="mb-4">
            <label for="judul" class="block text-sm font-medium text-gray-700 mb-1">Judul Pengaduan</label>
            <input type="text"
                   name="judul"
                   id="judul"
                   value="{{ old('judul', $pengaduan->judul) }}"
                   class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 @error('judul') border-red-500 @enderror"
                   required>
            @error('judul')
                <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
            @enderror
        </div>

        <!-- Field Deskripsi -->
        <div class="mb-4">
            <label for="deskripsi" class="block text-sm font-medium text-gray-700 mb-1">Deskripsi Lengkap</label>
            <textarea name="deskripsi"
                      id="deskripsi"
                      rows="5"
                      class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 @error('deskripsi') border-red-500 @enderror"
                      required>{{ old('deskripsi', $pengaduan->deskripsi) }}</textarea>
            @error('deskripsi')
                <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
            @enderror
        </div>

        <!-- Field Lokasi (Asumsi ada model Lokasi) -->
        <div class="mb-4">
            <label for="lokasi_id" class="block text-sm font-medium text-gray-700 mb-1">Lokasi Terkait</label>
            <select name="lokasi_id"
                    id="lokasi_id"
                    class="mt-1 block w-full px-3 py-2 border border-gray-300 bg-white rounded-lg shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 @error('lokasi_id') border-red-500 @enderror"
                    required>
                <option value="">-- Pilih Lokasi --</option>
                {{-- Loop data lokasi dari controller (Pastikan Anda mengirim variabel $lokasis dari controller) --}}
                @foreach ($lokasis as $lokasi)
                    <option value="{{ $lokasi->id }}"
                        {{ (old('lokasi_id', $pengaduan->lokasi_id) == $lokasi->id) ? 'selected' : '' }}>
                        {{ $lokasi->nama_lokasi }}
                    </option>
                @endforeach
            </select>
            @error('lokasi_id')
                <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
            @enderror
        </div>

        <!-- Field Status (Contoh: Menunggu, Diproses, Selesai) -->
        <div class="mb-6">
            <label for="status" class="block text-sm font-medium text-gray-700 mb-1">Status Pengaduan</label>
            <select name="status"
                    id="status"
                    class="mt-1 block w-full px-3 py-2 border border-gray-300 bg-white rounded-lg shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 @error('status') border-red-500 @enderror"
                    required>
                @php $statuses = ['Menunggu', 'Diproses', 'Selesai', 'Ditolak']; @endphp
                @foreach ($statuses as $status)
                    <option value="{{ $status }}"
                        {{ (old('status', $pengaduan->status) == $status) ? 'selected' : '' }}>
                        {{ $status }}
                    </option>
                @endforeach
            </select>
            @error('status')
                <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
            @enderror
        </div>

        <!-- Tombol Aksi -->
        <div class="flex justify-end space-x-3">
            <a href="{{ route('admin.pengaduan.index') }}"
               class="inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-lg text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition duration-150 ease-in-out">
                Batal
            </a>
            <button type="submit"
                    class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-lg shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition duration-150 ease-in-out">
                Simpan Perubahan
            </button>
        </div>
    </form>

</div>


</div>
@endsection
