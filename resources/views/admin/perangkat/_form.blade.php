<div class="mb-3">
    <label class="form-label fw-semibold">Ruangan <span class="text-danger">*</span></label>
    <select name="ruangan_id" class="form-select @error('ruangan_id') is-invalid @enderror">
        <option value="">-- Pilih Ruangan --</option>
        @foreach($ruangan as $item)
            <option value="{{ $item->id }}"
                {{ (string) old('ruangan_id', $perangkat->ruangan_id ?? '') === (string) $item->id ? 'selected' : '' }}>
                {{ $item->nama_ruangan }}
            </option>
        @endforeach
    </select>
    @error('ruangan_id')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

<div class="mb-3">
    <label class="form-label fw-semibold">Kode Perangkat <span class="text-danger">*</span></label>
    <input type="text" name="kode_perangkat"
           class="form-control @error('kode_perangkat') is-invalid @enderror"
           value="{{ old('kode_perangkat', $perangkat->kode_perangkat ?? '') }}"
           {{ isset($perangkat) ? 'readonly' : '' }}>
    @error('kode_perangkat')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

<div class="mb-3">
    <label class="form-label fw-semibold">Nama Perangkat <span class="text-danger">*</span></label>
    <input type="text" name="nama_perangkat"
           class="form-control @error('nama_perangkat') is-invalid @enderror"
           value="{{ old('nama_perangkat', $perangkat->nama_perangkat ?? '') }}">
    @error('nama_perangkat')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

<div class="mb-3">
    <label class="form-label fw-semibold">Merk / Model</label>
    <input type="text" name="merk_model"
           class="form-control @error('merk_model') is-invalid @enderror"
           value="{{ old('merk_model', $perangkat->merk_model ?? '') }}">
    @error('merk_model')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

<div class="mb-3">
    <label class="form-label fw-semibold">Kondisi <span class="text-danger">*</span></label>
    <select name="kondisi" class="form-select @error('kondisi') is-invalid @enderror">
        @foreach(['baik' => 'Baik', 'rusak' => 'Rusak', 'dalam_perbaikan' => 'Dalam Perbaikan'] as $value => $label)
            <option value="{{ $value }}"
                {{ old('kondisi', $perangkat->kondisi ?? '') === $value ? 'selected' : '' }}>
                {{ $label }}
            </option>
        @endforeach
    </select>
    @error('kondisi')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>
