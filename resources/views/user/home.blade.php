@extends('user.layout.app')

@section('title', 'Home - CantikCarRental')

@section('content')
<!-- Hero Section - Kaira Style -->
<section class="hero-section text-white">
    <div class="container-fluid">
        <div class="row align-items-center min-vh-100">
            <div class="col-lg-6 offset-lg-1">
                <div class="py-5">
                    <h1 class="display-2 fw-bold mb-4 text-uppercase" style="line-height: 1.1;">
                        Rental Mobil Listrik <br><span style="color: #fff; opacity: 0.8;">Terpercaya</span>
                    </h1>
                    <p class="fs-5 mb-5" style="line-height: 1.7; opacity: 0.9;">
                        Temukan kendaraan impian Anda dengan harga terjangkau dan pelayanan terbaik di CantikCarRental
                    </p>
                    <div class="d-flex flex-wrap gap-4 mb-5">
                        <a href="{{ route('user.katalog') }}" class="btn btn-light btn-lg px-5 py-3 text-uppercase fw-bold" style="letter-spacing: 1px;">
                            Jelajahi Katalog
                        </a>
                        @guest('customer')
                        <a href="{{ route('user.register') }}" class="btn btn-outline-light btn-lg px-5 py-3 text-uppercase fw-bold" style="letter-spacing: 1px;">
                            Daftar Gratis
                        </a>
                        @endguest
                    </div>
                    
                    <!-- Stats -->
                </div>
            </div>
            <div class="col-lg-5">
                <div class="text-center p-5">
                    <svg width="100%" height="500" viewBox="0 0 500 500" class="img-fluid">
                        <!-- Modern Car illustration -->
                        <defs>
                            <linearGradient id="carGradient" x1="0%" y1="0%" x2="100%" y2="100%">
                                <stop offset="0%" style="stop-color:#ffffff;stop-opacity:0.9" />
                                <stop offset="100%" style="stop-color:#f8f9fa;stop-opacity:0.7" />
                            </linearGradient>
                        </defs>
                        <!-- Car body -->
                        <rect x="50" y="220" width="400" height="140" rx="0" fill="url(#carGradient)"/>
                        <!-- Wheels -->
                        <circle cx="150" cy="360" r="35" fill="#111"/>
                        <circle cx="350" cy="360" r="35" fill="#111"/>
                        <circle cx="150" cy="360" r="20" fill="#8C907E"/>
                        <circle cx="350" cy="360" r="20" fill="#8C907E"/>
                        <!-- Windows -->
                        <rect x="80" y="240" width="90" height="70" rx="0" fill="#8C907E" opacity="0.8"/>
                        <rect x="190" y="240" width="120" height="70" rx="0" fill="#8C907E" opacity="0.8"/>
                        <rect x="330" y="240" width="90" height="70" rx="0" fill="#8C907E" opacity="0.8"/>
                        <!-- Brand -->
                        <text x="250" y="290" text-anchor="middle" fill="#111" font-size="24" font-weight="bold" font-family="Jost">CantikCarRental</text>
                    </svg>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Features Section - Kaira Style -->
<section class="py-6" style="padding: 6rem 0;">
    <div class="container-fluid">
        <div class="text-center mb-6" style="margin-bottom: 4rem;">
            <h2 class="display-4 fw-bold mb-4 text-uppercase" style="letter-spacing: 2px;">Mengapa Memilih CantikCarRental?</h2>
            <p class="fs-5 text-muted" style="line-height: 1.7;">Kami memberikan pengalaman rental terbaik dengan berbagai keunggulan</p>
        </div>
        
        <div class="row g-5">
            <div class="col-lg-4 col-md-6">
                <div class="card h-100 text-center border-0" style="background: transparent;">
                    <div class="card-body p-5">
                        <div class="feature-icon mx-auto mb-4">
                            <i class="bi bi-shield-check"></i>
                        </div>
                        <h4 class="fw-bold mb-4 text-uppercase" style="letter-spacing: 1px;">Aman & Terpercaya</h4>
                        <p class="text-muted fs-6" style="line-height: 1.7;">Semua kendaraan telah melalui inspeksi ketat dan diasuransikan untuk keamanan Anda.</p>
                    </div>
                </div>
            </div>
            
            <div class="col-lg-4 col-md-6">
                <div class="card h-100 text-center border-0" style="background: transparent;">
                    <div class="card-body p-5">
                        <div class="feature-icon mx-auto mb-4">
                            <i class="bi bi-clock"></i>
                        </div>
                        <h4 class="fw-bold mb-4 text-uppercase" style="letter-spacing: 1px;">Rental Per Jam</h4>
                        <p class="text-muted fs-6" style="line-height: 1.7;">Fleksibilitas rental mulai dari per jam hingga bulanan sesuai kebutuhan Anda.</p>
                    </div>
                </div>
            </div>
            
            <div class="col-lg-4 col-md-6">
                <div class="card h-100 text-center border-0" style="background: transparent;">
                    <div class="card-body p-5">
                        <div class="feature-icon mx-auto mb-4">
                            <i class="bi bi-headset"></i>
                        </div>
                        <h4 class="fw-bold mb-4 text-uppercase" style="letter-spacing: 1px;">Support 24/7</h4>
                        <p class="text-muted fs-6" style="line-height: 1.7;">Tim customer service kami siap membantu Anda kapan saja, 24 jam sehari.</p>
                    </div>
                </div>
            </div>
            
            <div class="col-lg-4 col-md-6">
                <div class="card h-100 text-center border-0" style="background: transparent;">
                    <div class="card-body p-5">
                        <div class="feature-icon mx-auto mb-4">
                            <i class="bi bi-geo-alt"></i>
                        </div>
                        <h4 class="fw-bold mb-4 text-uppercase" style="letter-spacing: 1px;">Antar Jemput</h4>
                        <p class="text-muted fs-6" style="line-height: 1.7;">Layanan antar jemput gratis untuk area tertentu, memudahkan mobilitas Anda.</p>
                    </div>
                </div>
            </div>
            
            <div class="col-lg-4 col-md-6">
                <div class="card h-100 text-center border-0" style="background: transparent;">
                    <div class="card-body p-5">
                        <div class="feature-icon mx-auto mb-4">
                            <i class="bi bi-credit-card"></i>
                        </div>
                        <h4 class="fw-bold mb-4 text-uppercase" style="letter-spacing: 1px;">Pembayaran Mudah</h4>
                        <p class="text-muted fs-6" style="line-height: 1.7;">Berbagai metode pembayaran tersedia: transfer bank</p>
                    </div>
                </div>
            </div>
            
            <div class="col-lg-4 col-md-6">
                <div class="card h-100 text-center border-0" style="background: transparent;">
                    <div class="card-body p-5">
                        <div class="feature-icon mx-auto mb-4">
                            <i class="bi bi-star-fill"></i>
                        </div>
                        <h4 class="fw-bold mb-4 text-uppercase" style="letter-spacing: 1px;">Kualitas Terjamin</h4>
                        <p class="text-muted fs-6" style="line-height: 1.7;">Kendaraan terawat dengan baik dan selalu dalam kondisi prima untuk perjalanan Anda.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Popular Vehicles Section - Kaira Style -->
<section class="py-6" style="padding: 6rem 0; background-color: #f8f9fa;">
    <div class="container-fluid">
        <div class="text-center mb-6" style="margin-bottom: 4rem;">
            <h2 class="display-4 fw-bold mb-4 text-uppercase" style="letter-spacing: 2px;">Mobil Listrik Populer</h2>
            <p class="fs-5 text-muted" style="line-height: 1.7;">Pilihan favorit pelanggan kami</p>
        </div>
        
        <div class="row g-5">
            @forelse($popularVehicles as $kendaraan)
            <div class="col-lg-4 col-md-6">
                <div class="card vehicle-card border-0" style="background: white; transition: all 0.3s ease; border-radius: 0;">
                    <div class="position-relative overflow-hidden">
                        @if($kendaraan->foto_kendaraan)
                            <img src="{{ asset('storage/kendaraan/' . $kendaraan->foto_kendaraan) }}" 
                                 class="card-img-top" 
                                 style="height: 280px; object-fit: cover;"
                                 alt="{{ $kendaraan->merek }} {{ $kendaraan->model }}">
                        @else
                            <svg width="100%" height="280" class="card-img-top">
                                <rect width="100%" height="100%" fill="#f1f5f9"/>
                                <text x="50%" y="50%" text-anchor="middle" dy=".3em" fill="#64748b" font-size="16" font-weight="bold">{{ strtoupper($kendaraan->merek) }}</text>
                            </svg>
                        @endif
                        <span class="badge position-absolute top-0 end-0 m-3" style="background: {{ $kendaraan->isAvailable() ? '#28a745' : '#dc3545' }}; color: white; padding: 8px 12px; font-size: 11px; letter-spacing: 1px;">{{ $kendaraan->ketersediaan }}</span>
                    </div>
                    <div class="card-body p-4">
                        <h4 class="fw-bold mb-3 text-uppercase" style="letter-spacing: 1px; font-size: 1.1rem;">{{ $kendaraan->merek }} {{ $kendaraan->model }}</h4>
                        <p class="text-muted mb-4" style="line-height: 1.6; font-size: 0.9rem;">
                            <i class="bi bi-people me-2"></i>{{ $kendaraan->jml_kursi }} Kursi
                            <i class="bi bi-calendar ms-4 me-2"></i>{{ $kendaraan->tahun }}
                        </p>
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <span class="h4 fw-bold" style="color: var(--primary-color);">Rp {{ number_format($kendaraan->harga_sewa_per_jam, 0, ',', '.') }}</span>
                                <small class="text-muted">/jam</small>
                            </div>
                            <a href="{{ route('user.katalog.detail', $kendaraan->id_kendaraan) }}" class="btn btn-primary">
                                <i class="bi bi-eye me-1"></i>Detail
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            @empty
            <div class="col-12">
                <div class="text-center py-5">
                    <i class="bi bi-car-front" style="font-size: 4rem; color: #dee2e6;"></i>
                    <h4 class="mt-3 text-muted">Belum ada mobil listrik populer</h4>
                    <p class="text-muted">Kendaraan akan muncul di sini setelah ada data rental</p>
                </div>
            </div>
            @endforelse
        </div>
        
        <div class="text-center mt-6" style="margin-top: 4rem;">
            <a href="{{ route('user.katalog') }}" class="btn btn-primary">
                <i class="bi bi-grid me-2"></i>Lihat Semua Kendaraan
            </a>
        </div>
    </div>
</section>
@endsection

@push('styles')
<style>
    .min-vh-75 {
        min-height: 75vh;
    }
</style>
@endpush