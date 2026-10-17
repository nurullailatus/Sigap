@extends('layouts.app')

@section('page-title', 'Buat Laporan Baru')

@section('content')

<div class="mb-3">
    <a href="{{ route('pelapor.dashboard') }}" class="btn btn-outline-secondary btn-sm">
        <i class="bi bi-arrow-left"></i> Kembali
    </a>
</div>

<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card border-0 shadow-sm rounded-3">
            <div class="card-header bg-white border-0 pt-3">
                <h6 class="fw-bold mb-0">
                    <i class="bi bi-plus-circle me-2 text-primary"></i>Form Laporan Kerusakan
                </h6>
            </div>
            <div class="card-body">
                <form action="{{ route('pelapor.laporan.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    {{-- Pilih Ruangan --}}
                    <div class="mb-3">
                        <label class="form-label fw-semibold">
                            Ruangan <span class="text-danger">*</span>
                        </label>
                        <select name="ruangan_id" id="ruangan_id"
                                class="form-select @error('ruangan_id') is-invalid @enderror">
                            <option value="">-- Pilih Ruangan --</option>
                            @foreach($ruangan as $r)
                            <option value="{{ $r->id }}" {{ old('ruangan_id') == $r->id ? 'selected' : '' }}>
                                {{ $r->nama_ruangan }}
                            </option>
                            @endforeach
                        </select>
                        @error('ruangan_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Pilih Perangkat (dinamis sesuai ruangan) --}}
                    <div class="mb-3">
                        <label class="form-label fw-semibold">
                            Perangkat yang Rusak <span class="text-danger">*</span>
                        </label>
                        <select name="perangkat_id" id="perangkat_id"
                                class="form-select @error('perangkat_id') is-invalid @enderror"
                                disabled>
                            <option value="">-- Pilih Ruangan Dulu --</option>
                        </select>
                        @error('perangkat_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <div class="form-text text-muted">
                            <i class="bi bi-info-circle"></i> Pilih ruangan dulu, daftar perangkat akan muncul otomatis
                        </div>
                    </div>

                    {{-- Pilih Kategori --}}
                    <div class="mb-3">
                        <label class="form-label fw-semibold">
                            Kategori Kerusakan <span class="text-danger">*</span>
                        </label>
                        <select name="kategori_kerusakan_id"
                                class="form-select @error('kategori_kerusakan_id') is-invalid @enderror">
                            <option value="">-- Pilih Kategori --</option>
                            @foreach($kategori as $k)
                            <option value="{{ $k->id }}" {{ old('kategori_kerusakan_id') == $k->id ? 'selected' : '' }}>
                                {{ $k->nama_kategori }}
                            </option>
                            @endforeach
                        </select>
                        @error('kategori_kerusakan_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Tingkat Urgensi --}}
                    <div class="mb-3">
                        <label class="form-label fw-semibold">
                            Tingkat Urgensi <span class="text-danger">*</span>
                        </label>
                        <div class="d-flex gap-3">
                            <div class="form-check">
                                <input class="form-check-input" type="radio"
                                       name="tingkat_urgensi" value="rendah"
                                       {{ old('tingkat_urgensi') == 'rendah' ? 'checked' : '' }}>
                                <label class="form-check-label">
                                    <span class="badge bg-secondary">Rendah</span>
                                    <small class="text-muted d-block">Tidak mengganggu kegiatan</small>
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio"
                                       name="tingkat_urgensi" value="sedang"
                                       {{ old('tingkat_urgensi', 'sedang') == 'sedang' ? 'checked' : '' }}>
                                <label class="form-check-label">
                                    <span class="badge bg-warning text-dark">Sedang</span>
                                    <small class="text-muted d-block">Sedikit mengganggu</small>
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio"
                                       name="tingkat_urgensi" value="tinggi"
                                       {{ old('tingkat_urgensi') == 'tinggi' ? 'checked' : '' }}>
                                <label class="form-check-label">
                                    <span class="badge bg-danger">Tinggi</span>
                                    <small class="text-muted d-block">Mengganggu kegiatan belajar</small>
                                </label>
                            </div>
                        </div>
                        @error('tingkat_urgensi')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Deskripsi Kerusakan --}}
                    <div class="mb-3">
                        <label class="form-label fw-semibold">
                            Deskripsi Kerusakan <span class="text-danger">*</span>
                        </label>
                        <textarea name="deskripsi_kerusakan" rows="4"
                                  class="form-control @error('deskripsi_kerusakan') is-invalid @enderror"
                                  placeholder="Jelaskan kerusakan secara detail. Contoh: Proyektor tidak menyala saat tombol power ditekan, lampu indikator berkedip merah...">{{ old('deskripsi_kerusakan') }}</textarea>
                        @error('deskripsi_kerusakan')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <div class="form-text text-muted">Minimal 20 karakter</div>
                    </div>

                    {{-- Upload Foto --}}
                    <div class="mb-4">
                        <label class="form-label fw-semibold">
                            Foto Kerusakan <span class="text-muted fw-normal">(opsional, maks 3 foto)</span>
                        </label>
                        <input type="file" name="foto[]" id="foto"
                               class="form-control @error('foto.*') is-invalid @enderror"
                               accept="image/*" multiple>
                        @error('foto.*')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <div class="form-text text-muted">Format: JPG, PNG. Maks 2MB per foto</div>

                        {{-- Preview foto sebelum upload --}}
                        <div id="preview-foto" class="d-flex gap-2 flex-wrap mt-2"></div>
                    </div>

                    {{-- Tombol Submit --}}
                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-send me-1"></i> Kirim Laporan
                        </button>
                        <a href="{{ route('pelapor.dashboard') }}" class="btn btn-outline-secondary">
                            Batal
                        </a>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
// =====================================================
// DROPDOWN DINAMIS: Perangkat berubah sesuai Ruangan
// =====================================================
document.getElementById('ruangan_id').addEventListener('change', function() {
    const ruanganId = this.value;
    const perangkatSelect = document.getElementById('perangkat_id');

    if (!ruanganId) {
        // Kalau ruangan belum dipilih, disable dropdown perangkat
        perangkatSelect.innerHTML = '<option value="">-- Pilih Ruangan Dulu --</option>';
        perangkatSelect.disabled = true;
        return;
    }

    // Fetch ke route API kita untuk ambil perangkat by ruangan
    fetch(`/api/perangkat/${ruanganId}`)
        .then(response => response.json())
        .then(data => {
            perangkatSelect.disabled = false;
            perangkatSelect.innerHTML = '<option value="">-- Pilih Perangkat --</option>';

            if (data.length === 0) {
                perangkatSelect.innerHTML = '<option value="">Tidak ada perangkat di ruangan ini</option>';
                return;
            }

            data.forEach(perangkat => {
                perangkatSelect.innerHTML += `
                    <option value="${perangkat.id}">
                        ${perangkat.nama_perangkat} - ${perangkat.merk_model ?? ''}
                    </option>`;
            });
        });
});

// =====================================================
// PREVIEW FOTO sebelum diupload
// =====================================================
document.getElementById('foto').addEventListener('change', function() {
    const preview = document.getElementById('preview-foto');
    preview.innerHTML = '';

    // Batasi maksimal 3 foto
    const files = Array.from(this.files).slice(0, 3);

    files.forEach(file => {
        const reader = new FileReader();
        reader.onload = function(e) {
            preview.innerHTML += `
                <img src="${e.target.result}"
                     style="width:80px;height:80px;object-fit:cover;border-radius:8px;border:2px solid #dee2e6">`;
        };
        reader.readAsDataURL(file);
    });
});
</script>
@endpush