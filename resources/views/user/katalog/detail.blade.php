@extends('user.layout.app')

@section('title', ($kendaraan->model ?? '') . ' - Detail Kendaraan')

@section('content')
<!-- Breadcrumb -->
<section class="bg-light py-3">
    <div class="container">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="{{ route('user.home') }}" class="text-decoration-none">Home</a></li>
                <li class="breadcrumb-item"><a href="{{ route('user.katalog') }}" class="text-decoration-none">Katalog</a></li>
                <li class="breadcrumb-item active"> {{ $kendaraan->model ?? '' }}</li>
            </ol>
        </nav>
    </div>
</section>

<!-- Vehicle Detail -->
<section class="py-5">
    <div class="container">
        <div class="row g-5">
            <!-- Vehicle Image & Gallery -->
            <div class="col-lg-7">
                <div class="card border-0 shadow-sm">
                    <div class="position-relative">
                        @if($kendaraan->foto_kendaraan)
                            <img src="{{ asset('storage/kendaraan/' . $kendaraan->foto_kendaraan) }}" 
                                 class="card-img-top" 
                                 style="height: 400px; object-fit: cover;"
                                 alt=" {{ $kendaraan->model ?? '' }}">
                        @else
                            <div class="bg-light d-flex align-items-center justify-content-center" style="height: 400px;">
                                <i class="bi bi-car-front text-muted" style="font-size: 5rem;"></i>
                            </div>
                        @endif
                        
                        <!-- Status Badge -->
                        <span class="badge {{ $kendaraan->isAvailable() ? 'bg-success' : 'bg-danger' }} position-absolute top-0 end-0 m-3 fs-6">
                            <i class="bi bi-{{ $kendaraan->isAvailable() ? 'check' : 'x' }}-circle me-1"></i>{{ $kendaraan->ketersediaan }}
                        </span>
                        
                        <!-- Category Badge -->
                        <span class="badge bg-primary position-absolute top-0 start-0 m-3 fs-6">
                            {{ ucfirst($kendaraan->merek ?? 'Kendaraan') }}
                        </span>
                    </div>
                </div>
                
                <!-- Vehicle Information -->
                <div class="card border-0 shadow-sm mt-4">
                    <div class="card-body p-4">
                        <h4 class="fw-bold mb-4">
                            <i class="bi bi-info-circle text-primary me-2"></i>Informasi Kendaraan
                        </h4>
                        
                        <div class="row g-4">
                            <div class="col-md-6">
                                <div class="d-flex align-items-center mb-3">
                                    <div class="feature-icon me-3" style="width: 2.5rem; height: 2.5rem; font-size: 1rem;">
                                        <i class="bi bi-building"></i>
                                    </div>
                                    <div>
                                        <h6 class="mb-0">Merek</h6>
                                    <p class="text-muted mb-0">{{ $kendaraan->merek ?? '-' }}</p>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="d-flex align-items-center mb-3">
                                    <div class="feature-icon me-3" style="width: 2.5rem; height: 2.5rem; font-size: 1rem;">
                                        <i class="bi bi-calendar"></i>
                                    </div>
                                    <div>
                                        <h6 class="mb-0">Tahun</h6>
                                        <p class="text-muted mb-0">{{ $kendaraan->tahun ?? '-' }}</p>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="d-flex align-items-center mb-3">
                                    <div class="feature-icon me-3" style="width: 2.5rem; height: 2.5rem; font-size: 1rem;">
                                        <i class="bi bi-people"></i>
                                    </div>
                                    <div>
                                        <h6 class="mb-0">Kapasitas</h6>
                                        <p class="text-muted mb-0">{{ $kendaraan->jml_kursi ?? '-' }} kursi</p>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="d-flex align-items-center mb-3">
                                    <div class="feature-icon me-3" style="width: 2.5rem; height: 2.5rem; font-size: 1rem;">
                                        <i class="bi bi-gear"></i>
                                    </div>
                                    <div>
                                        <h6 class="mb-0">Unit Tersedia</h6>
                                        <p class="text-muted mb-0">{{ $kendaraan->jumlah_unit ?? '-' }} unit</p>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="d-flex align-items-center mb-3">
                                    <div class="feature-icon me-3" style="width: 2.5rem; height: 2.5rem; font-size: 1rem;">
                                        <i class="bi bi-palette"></i>
                                    </div>
                                    <div>
                                        <h6 class="mb-0">Warna</h6>
                                        <p class="text-muted mb-0">{{ ucfirst($kendaraan->warna ?? '-') }}</p>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="d-flex align-items-center mb-3">
                                    <div class="feature-icon me-3" style="width: 2.5rem; height: 2.5rem; font-size: 1rem;">
                                        <i class="bi bi-car-front"></i>
                                    </div>
                                    <div>
                                        <h6 class="mb-0">Model</h6>
                                        <p class="text-muted mb-0">{{ $kendaraan->model ?? '-' }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        @if(isset($kendaraan->deskripsi) && $kendaraan->deskripsi)
                        <hr class="my-4">
                        <div class="row">
                            <div class="col-md-6">
                                <h6 class="fw-bold mb-3">Deskripsi</h6>
                                <p class="text-muted">{{ $kendaraan->deskripsi ?? '-' }}</p>
                            </div>
                            <div class="col-md-6">
                                <h6 class="fw-bold mb-3">Spesifikasi</h6>
                                <p class="text-muted">{{ $kendaraan->spesifikasi ?? '-' }}</p>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
            
            <!-- Booking Form -->
            <div class="col-lg-5">
                <div class="card border-0 shadow-lg sticky-top" style="top: 100px;">
                    <div class="card-body p-4">
                        <div class="text-center mb-4">
                            <h3 class="fw-bold mb-2">{{ $kendaraan->model ?? '' }}</h3>
                            <div class="mb-3">
                                <span class="h2 text-primary fw-bold">Rp {{ number_format($kendaraan->harga_sewa_per_jam ?? 0, 0, ',', '.') }}</span>
                                <span class="text-muted">/jam</span>
                            </div>
                        </div>
                        
                        @auth('customer')
                            @if($kendaraan->jumlah_unit > 0)
                                <form action="{{ route('user.booking.store') }}" method="POST" id="bookingForm">
                                        @csrf
                                        <input type="hidden" name="id_kendaraan" value="{{ $kendaraan->id_kendaraan }}">
                                        
                                        <!-- Date & Time Selection -->
                                        <div class="mb-3">
                                            <label class="form-label fw-semibold">
                                                <i class="bi bi-calendar-event me-1"></i>Waktu Mulai
                                            </label>
                                            <input type="datetime-local" 
                                                class="form-control @error('waktu_mulai') is-invalid @enderror" 
                                                name="waktu_mulai" 
                                                id="waktu_mulai"
                                                value="{{ old('waktu_mulai') }}"
                                                min="{{ date('Y-m-d\TH:i') }}"
                                                required>
                                            @if($errors->has('waktu_mulai'))
                                                <div class="invalid-feedback">{{ $errors->first('waktu_mulai') }}</div>
                                            @endif
                                        </div>
                                        
                                        <div class="mb-3">
                                            <label class="form-label fw-semibold">
                                                <i class="bi bi-calendar-x me-1"></i>Waktu Selesai
                                            </label>
                                            <input type="datetime-local" 
                                                class="form-control @error('waktu_selesai') is-invalid @enderror" 
                                                name="waktu_selesai" 
                                                id="waktu_selesai"
                                                value="{{ old('waktu_selesai') }}"
                                                required>
                                            @if($errors->has('waktu_selesai'))
                                                <div class="invalid-feedback">{{ $errors->first('waktu_selesai') }}</div>
                                            @endif
                                        </div>
                                        
                                        <!-- Duration Display -->
                                        <div class="mb-3">
                                            <div class="bg-light p-3 rounded">
                                                <div class="d-flex justify-content-between align-items-center">
                                                    <span class="fw-semibold">Durasi:</span>
                                                    <span id="duration" class="text-primary fw-bold">-</span>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <!-- Purpose -->
                                        <div class="mb-3">
                                            <label class="form-label fw-semibold">
                                                <i class="bi bi-chat-text me-1"></i>Tujuan Penggunaan
                                            </label>
                                            <select class="form-select @error('tujuan') is-invalid @enderror" name="tujuan" required>
                                                <option value="">Pilih tujuan penggunaan</option>
                                                <option value="wisata" {{ old('tujuan') == 'wisata' ? 'selected' : '' }}>Wisata</option>
                                                <option value="bisnis" {{ old('tujuan') == 'bisnis' ? 'selected' : '' }}>Bisnis</option>
                                                <option value="keluarga" {{ old('tujuan') == 'keluarga' ? 'selected' : '' }}>Keluarga</option>
                                                <option value="pernikahan" {{ old('tujuan') == 'pernikahan' ? 'selected' : '' }}>Pernikahan</option>
                                                <option value="lainnya" {{ old('tujuan') == 'lainnya' ? 'selected' : '' }}>Lainnya</option>
                                            </select>
                                            @if($errors->has('tujuan'))
                                                <div class="invalid-feedback">{{ $errors->first('tujuan') }}</div>
                                            @endif
                                        </div>
                                        
                                        <!-- Notes -->
                                        <div class="mb-4">
                                            <label class="form-label fw-semibold">
                                                <i class="bi bi-sticky me-1"></i>Catatan (Opsional)
                                            </label>
                                            <textarea class="form-control @error('catatan') is-invalid @enderror" 
                                                    name="catatan" 
                                                    rows="3" 
                                                    placeholder="Tambahkan catatan khusus untuk rental ini...">{{ old('catatan') }}</textarea>
                                            @if($errors->has('catatan'))
                                                <div class="invalid-feedback">{{ $errors->first('catatan') }}</div>
                                            @endif
                                        </div>
                                        
                                        <!-- Price Calculation -->
                                        <div class="bg-primary bg-opacity-10 p-3 rounded mb-4">
                                            <h6 class="fw-bold mb-2">Rincian Harga</h6>
                                            <div class="d-flex justify-content-between mb-1">
                                                <span>Harga per jam:</span>
                                                <span>Rp {{ number_format($kendaraan->harga_sewa_per_jam ?? 0, 0, ',', '.') }}</span>
                                            </div>
                                            <div class="d-flex justify-content-between mb-1">
                                                <span>Durasi:</span>
                                                <span id="durationText">-</span>
                                            </div>
                                            <div class="d-flex justify-content-between mb-1">
                                                  <span>Total Harga:</span>
                                                <span id="totalPrice">Rp 0</span>
                                            </div>
                                            <hr class="my-2">
                                        </div>
                                        
                                        <!-- Submit Button -->
                                        <div class="d-grid">
                                            <button type="submit" class="btn btn-primary btn-lg fw-semibold">
                                                <i class="bi bi-calendar-check me-2"></i>Pesan Sekarang
                                            </button>
                                        </div>
                                    </form>
                            @else
                                <div class="text-center py-4">
                                    <i class="bi bi-exclamation-triangle text-warning" style="font-size: 3rem;"></i>
                                    <h5 class="fw-bold mt-3 mb-2 text-warning">Kendaraan Tidak Tersedia</h5>
                                    <p class="text-muted mb-3">Maaf, saat ini tidak ada unit yang tersedia untuk kendaraan ini.</p>
                                    <div class="bg-light p-3 rounded mb-4">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <span class="fw-semibold">Unit Tersedia:</span>
                                            <span class="text-danger fw-bold">{{ $kendaraan->jumlah_unit }} unit</span>
                                        </div>
                                    </div>
                                    <div class="d-grid">
                                        <a href="{{ route('user.katalog') }}" class="btn btn-outline-primary btn-lg">
                                            <i class="bi bi-arrow-left me-2"></i>Lihat Kendaraan Lain
                                        </a>
                                    </div>
                                </div>
                            @endif
                        @else
                            <div class="text-center py-4">
                                <i class="bi bi-person-plus text-primary" style="font-size: 3rem;"></i>
                                <h5 class="fw-bold mt-3 mb-2">Login Diperlukan</h5>
                                <p class="text-muted mb-4">Silakan login terlebih dahulu untuk melakukan pemesanan.</p>
                                <div class="d-grid">
                                    <a href="{{ route('user.login') }}" class="btn btn-primary btn-lg">
                                        <i class="bi bi-box-arrow-in-right me-2"></i>Login
                                    </a>
                                </div>
                            </div>
                        @endauth
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const waktuMulai = document.getElementById('waktu_mulai');
        const waktuSelesai = document.getElementById('waktu_selesai');
        const duration = document.getElementById('duration');
        const durationText = document.getElementById('durationText');
        const totalPrice = document.getElementById('totalPrice');
        
        const hargaPerJam = {{ $kendaraan->harga_sewa_per_jam ?? 0 }};
        const isHourly = true;
        
        function calculateDuration() {
            if (waktuMulai.value && waktuSelesai.value) {
                const start = new Date(waktuMulai.value);
                const end = new Date(waktuSelesai.value);
                
                if (end > start) {
                    const diffMs = end - start;
                    const diffHours = Math.ceil(diffMs / (1000 * 60 * 60));
                    const diffDays = Math.ceil(diffMs / (1000 * 60 * 60 * 24));
                    
                    if (isHourly) {
                        duration.textContent = diffHours + ' jam';
                        durationText.textContent = diffHours + ' jam';
                        const total = diffHours * hargaPerJam;
                        totalPrice.textContent = 'Rp ' + total.toLocaleString('id-ID');
                    } else {
                        duration.textContent = diffDays + ' hari';
                        durationText.textContent = diffDays + ' hari';
                        const total = diffDays * hargaPerJam;
                        totalPrice.textContent = 'Rp ' + total.toLocaleString('id-ID');
                    }
                } else {
                    duration.textContent = '-';
                    durationText.textContent = '-';
                    totalPrice.textContent = 'Rp 0';
                }
            }
        }
        
        waktuMulai.addEventListener('change', function() {
            // Set minimum end time to start time
            waktuSelesai.min = this.value;
            calculateDuration();
        });
        
        waktuSelesai.addEventListener('change', calculateDuration);
        
        // Set default times
        const now = new Date();
        const tomorrow = new Date(now.getTime() + 24 * 60 * 60 * 1000);
        
        if (!waktuMulai.value) {
            waktuMulai.value = now.toISOString().slice(0, 16);
        }
        if (!waktuSelesai.value) {
            waktuSelesai.value = tomorrow.toISOString().slice(0, 16);
        }
        
        calculateDuration();
    });
</script>
@endpush