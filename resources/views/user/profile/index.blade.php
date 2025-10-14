@extends('user.layout.app')

@section('title', 'Profil Saya')

@section('content')
<!-- Page Header -->
<section class="bg-primary text-white py-5">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-8">
                <h1 class="display-5 fw-bold mb-3">Profil Saya</h1>
                <p class="lead mb-0">Kelola informasi akun dan preferensi Anda</p>
            </div>
            <div class="col-lg-4 text-lg-end">
                <i class="bi bi-person-circle" style="font-size: 5rem; opacity: 0.3;"></i>
            </div>
        </div>
    </div>
</section>

<!-- Profile Content -->
<section class="py-5">
    <div class="container">
        <div class="row g-5">
            <!-- Profile Info Card -->
            <div class="col-lg-4">
                <div class="card border-0 shadow-sm sticky-top" style="top: 100px;">
                    <div class="card-body p-4 text-center">
                        <!-- User Info -->
                        <h4 class="fw-bold mb-2">{{ auth()->user()->nama }}</h4>
                        <p class="text-muted mb-3">{{ auth()->user()->email }}</p>
                        
                        <!-- Stats -->
                        <div class="row g-3 text-center">
                            <div class="col-6">
                                <div class="border-end">
                                    <h5 class="fw-bold text-primary mb-0">{{ $bookingStats['total'] }}</h5>
                                    <small class="text-muted">Total Booking</small>
                                </div>
                            </div>
                            <div class="col-6">
                                <h5 class="fw-bold text-success mb-0">{{ $bookingStats['approved'] }}</h5>
                                <small class="text-muted">Disetujui</small>
                            </div>
                        </div>
                        
                        <hr class="my-4">
                        
                        <!-- Quick Actions -->
                        <div class="d-grid gap-2">
                            <a href="{{ route('user.history') }}" class="btn btn-outline-primary">
                                <i class="bi bi-clock-history me-2"></i>Riwayat Booking
                            </a>
                            <a href="{{ route('user.katalog') }}" class="btn btn-outline-success">
                                <i class="bi bi-search me-2"></i>Lihat Katalog
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Profile Forms -->
            <div class="col-lg-8">
                <!-- Personal Information -->
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-header bg-white border-bottom">
                        <h5 class="mb-0 fw-bold">
                            <i class="bi bi-person me-2 text-primary"></i>Informasi Pribadi
                        </h5>
                    </div>
                    <div class="card-body p-4">
                        <form action="{{ route('user.profile.update') }}" method="POST" id="profileForm">
                            @csrf
                            @method('PUT')
                            
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="form-label fw-semibold">
                                        <i class="bi bi-person me-1"></i>Nama Lengkap *
                                    </label>
                                    <input type="text" 
                                           class="form-control @error('name') is-invalid @enderror" 
                                           name="name" 
                                           value="{{ old('name', auth()->user()->nama) }}"
                                           required>
                                    @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                
                                <div class="col-md-6">
                                    <label class="form-label fw-semibold">
                                        <i class="bi bi-envelope me-1"></i>Email *
                                    </label>
                                    <input type="email" 
                                           class="form-control @error('email') is-invalid @enderror" 
                                           name="email" 
                                           value="{{ old('email', auth()->user()->email) }}"
                                           required>
                                    @error('email')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                
                                <div class="col-12">
                                    <label class="form-label fw-semibold">
                                        <i class="bi bi-telephone me-1"></i>Nomor Telepon *
                                    </label>
                                    <input type="tel" 
                                           class="form-control @error('no_hp') is-invalid @enderror" 
                                           name="no_hp" 
                                           value="{{ old('no_hp', auth()->user()->no_hp) }}"
                                           placeholder="08xxxxxxxxxx"
                                           required>
                                    @error('no_hp')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                
                                <div class="col-12">
                                    <label class="form-label fw-semibold">
                                        <i class="bi bi-geo-alt me-1"></i>Alamat *
                                    </label>
                                    <textarea class="form-control @error('alamat') is-invalid @enderror" 
                                              name="alamat" 
                                              rows="3" 
                                              placeholder="Masukkan alamat lengkap"
                                              required>{{ old('alamat', auth()->user()->alamat) }}</textarea>
                                    @error('alamat')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            
                            <div class="d-flex justify-content-end mt-4">
                                <button type="submit" class="btn btn-primary px-4">
                                    <i class="bi bi-check me-2"></i>Simpan Perubahan
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@push('scripts')
<script>

    // Phone number formatting
    document.querySelector('input[name="no_hp"]').addEventListener('input', function(e) {
        let value = e.target.value.replace(/\D/g, '');
        if (value.startsWith('0')) {
            e.target.value = value;
        } else if (value.startsWith('62')) {
            e.target.value = '0' + value.substring(2);
        }
    });
    
    // Form validation
    document.getElementById('profileForm').addEventListener('submit', function(e) {
        const phone = document.querySelector('input[name="no_hp"]').value;
        const ktp = document.querySelector('input[name="no_ktp"]').value;
        
        if (phone.length < 10 || phone.length > 15) {
            e.preventDefault();
            alert('Nomor telepon harus 10-15 digit.');
            return;
        }
    });
</script>
@endpush