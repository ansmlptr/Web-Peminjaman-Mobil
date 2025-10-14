@php
    // $action: 'tambah' atau 'edit'
    // $kendaraan: data kendaraan (jika edit), kalau tambah kosong/null
@endphp

@extends('admin.layout.header-side-nav')

@section('content')
        <div class="page-header">
            <h3 class="fw-bold mb-3">{{ $action == 'edit' ? 'Edit Data' : 'Tambah Data' }}</h3>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="card-title">Data Kendaraan</div>
                    </div>
                    <form action="{{ $action == 'edit' ? route('admin.katalog.update', $kendaraan->id_kendaraan) : route('admin.katalog.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @if($action == 'edit')
                            @method('PUT')
                        @endif
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <!-- Merek -->
                                    <div class="form-group mb-3">
                                        <label for="merek">Merek</label>
                                        <input type="text" class="form-control @error('merek') is-invalid @enderror" name="merek" id="merek"
                                            value="{{ old('merek', $kendaraan->merek ?? '') }}" maxlength="50" required>
                                        @error('merek')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <!-- Model -->
                                    <div class="form-group mb-3">
                                        <label for="model">Model</label>
                                        <input type="text" class="form-control @error('model') is-invalid @enderror" name="model" id="model"
                                            value="{{ old('model', $kendaraan->model ?? '') }}" maxlength="50" required>
                                        @error('model')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <!-- Tahun -->
                                    <div class="form-group mb-3">
                                        <label for="tahun">Tahun</label>
                                        <input type="number" class="form-control @error('tahun') is-invalid @enderror" name="tahun" id="tahun"
                                            value="{{ old('tahun', $kendaraan->tahun ?? '') }}" min="1990" max="{{ date('Y') }}" required>
                                        @error('tahun')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <!-- Warna -->
                                    <div class="form-group mb-3">
                                        <label for="warna">Warna</label>
                                        <input type="text" class="form-control @error('warna') is-invalid @enderror" name="warna" id="warna"
                                            value="{{ old('warna', $kendaraan->warna ?? '') }}" maxlength="30" required>
                                        @error('warna')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <!-- Jumlah Kursi -->
                                    <div class="form-group mb-3">
                                        <label for="jml_kursi">Jumlah Kursi</label>
                                        <input type="number" class="form-control @error('jml_kursi') is-invalid @enderror" name="jml_kursi" id="jml_kursi"
                                            value="{{ old('jml_kursi', $kendaraan->jml_kursi ?? '') }}" min="2" max="50" required>
                                        @error('jml_kursi')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <!-- Jumlah Unit -->
                                    <div class="form-group mb-3">
                                        <label for="jumlah_unit">Jumlah Unit</label>
                                        <input type="number" class="form-control @error('jumlah_unit') is-invalid @enderror" name="jumlah_unit" id="jumlah_unit"
                                            value="{{ old('jumlah_unit', $kendaraan->jumlah_unit ?? '1') }}" min="0" required>
                                        @error('jumlah_unit')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <!-- Harga Sewa Per Jam -->
                                    <div class="form-group mb-3">
                                        <label for="harga_sewa_per_jam">Harga Sewa per Jam</label>
                                        <input type="number" class="form-control @error('harga_sewa_per_jam') is-invalid @enderror" name="harga_sewa_per_jam" id="harga_sewa_per_jam"
                                            value="{{ old('harga_sewa_per_jam', $kendaraan->harga_sewa_per_jam ?? '') }}" step="0.01" min="0" required>
                                        @error('harga_sewa_per_jam')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <!-- Status -->
                                    <div class="form-group mb-3">
                                        <label for="status">Status</label>
                                        <select class="form-control @error('status') is-invalid @enderror" name="status" id="status" required>
                                            <option value="">Pilih Status</option>
                                            <option value="published" {{ old('status', $kendaraan->status ?? '') == 'published' ? 'selected' : '' }}>Published</option>
                                            <option value="unpublished" {{ old('status', $kendaraan->status ?? '') == 'unpublished' ? 'selected' : '' }}>Unpublished</option>
                                        </select>
                                        @error('status')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <!-- Foto Kendaraan -->
                                    <div class="form-group mb-3">
                                        <label for="foto_kendaraan">Foto Kendaraan</label>
                                        <input type="file" class="form-control @error('foto_kendaraan') is-invalid @enderror" name="foto_kendaraan" id="foto_kendaraan" accept="image/*" onchange="previewImage(event)">
                                        @error('foto_kendaraan')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                        <small class="form-text text-muted">Format: JPEG, PNG, JPG, GIF. Maksimal 2MB.</small>
                                        <div id="imagePreview" style="margin-top: 10px;">
                            @if($action == 'edit' && !empty($kendaraan->foto_kendaraan))
                                <img src="{{ asset('storage/kendaraan/' . $kendaraan->foto_kendaraan) }}" alt="Current Image" style="max-width: 200px; height: auto; border: 1px solid #ddd; border-radius: 4px; padding: 5px;">
                            @endif
                        </div>
                                    </div>
                                    <!-- Deskripsi -->
                                    <div class="form-group mb-3">
                                        <label for="deskripsi">Deskripsi</label>
                                        <textarea class="form-control @error('deskripsi') is-invalid @enderror" name="deskripsi" id="deskripsi" rows="4" maxlength="500" required>{{ old('deskripsi', $kendaraan->deskripsi ?? '') }}</textarea>
                                        @error('deskripsi')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <!-- Spesifikasi -->
                                    <div class="form-group mb-3">
                                        <label for="spesifikasi">Spesifikasi</label>
                                        <textarea class="form-control @error('spesifikasi') is-invalid @enderror" name="spesifikasi" id="spesifikasi" rows="4" maxlength="1000" required>{{ old('spesifikasi', $kendaraan->spesifikasi ?? '') }}</textarea>
                                        @error('spesifikasi')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-action">
                            <button type="submit" class="btn btn-success">{{ $action == 'edit' ? 'Update' : 'Tambah' }}</button>
                            <a href="{{ route('admin.katalog.index') }}" class="btn btn-danger">Batal</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
@endsection

@section('scripts')
<script>
function previewImage(event) {
    const file = event.target.files[0];
    const output = document.getElementById('imagePreview');
    
    // Reset preview jika tidak ada file yang dipilih
    if (!file) {
        @if($action == 'edit' && !empty($kendaraan->foto_kendaraan))
            output.innerHTML = '<img src="{{ asset('storage/kendaraan/' . $kendaraan->foto_kendaraan) }}" alt="Current Image" style="max-width: 200px; height: auto; border: 1px solid #ddd; border-radius: 4px; padding: 5px;">';
        @else
            output.innerHTML = '';
        @endif
        return;
    }
    
    // Validasi ukuran file (maksimal 2MB)
    if (file.size > 2 * 1024 * 1024) {
        alert('Ukuran file terlalu besar! Maksimal 2MB.');
        event.target.value = '';
        @if($action == 'edit' && !empty($kendaraan->foto_kendaraan))
            output.innerHTML = '<img src="{{ asset('storage/kendaraan/' . $kendaraan->foto_kendaraan) }}" alt="Current Image" style="max-width: 200px; height: auto; border: 1px solid #ddd; border-radius: 4px; padding: 5px;">';
        @else
            output.innerHTML = '';
        @endif
        return;
    }
    
    // Validasi tipe file
    const allowedTypes = ['image/jpeg', 'image/png', 'image/jpg', 'image/gif'];
    if (!allowedTypes.includes(file.type)) {
        alert('Format file tidak didukung! Gunakan JPEG, PNG, JPG, atau GIF.');
        event.target.value = '';
        @if($action == 'edit' && !empty($kendaraan->foto_kendaraan))
            output.innerHTML = '<img src="{{ asset('storage/kendaraan/' . $kendaraan->foto_kendaraan) }}" alt="Current Image" style="max-width: 200px; height: auto; border: 1px solid #ddd; border-radius: 4px; padding: 5px;">';
        @else
            output.innerHTML = '';
        @endif
        return;
    }
    
    // Tampilkan preview gambar
    const reader = new FileReader();
    reader.onload = function(){
        output.innerHTML = '<img src="' + reader.result + '" alt="Preview" style="max-width: 200px; height: auto; border: 1px solid #ddd; border-radius: 4px; padding: 5px;">';
    };
    reader.readAsDataURL(file);
}
</script>
@endsection
