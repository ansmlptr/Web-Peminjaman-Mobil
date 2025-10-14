@extends('user.layout.app')

@section('title', 'Riwayat Pemesanan')

@section('content')
<!-- Page Header -->
<section class="bg-primary text-white py-5">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-8">
                <h1 class="display-5 fw-bold mb-3">Riwayat Pemesanan</h1>
                <p class="lead mb-0">Kelola dan pantau semua pemesanan rental mobil Anda</p>
            </div>
            <div class="col-lg-4 text-lg-end">
                <i class="bi bi-clock-history" style="font-size: 5rem; opacity: 0.3;"></i>
            </div>
        </div>
    </div>
</section>

<!-- Filter & Stats -->
<section class="py-4 bg-light">
    <div class="container">
        <div class="row g-4">
            <!-- Stats Cards -->
            <div class="col-lg-3 col-md-6">
                <div class="card border-0 shadow-sm text-center">
                    <div class="card-body">
                        <div class="feature-icon bg-primary text-white mx-auto mb-3" style="width: 3rem; height: 3rem; font-size: 1.2rem;">
                            <i class="bi bi-file-text"></i>
                        </div>
                        <h4 class="fw-bold text-primary">{{ $stats['total'] }}</h4>
                        <p class="text-muted mb-0">Total Booking</p>
                    </div>
                </div>
            </div>
            
            <div class="col-lg-2 col-md-4 col-sm-6">
                <div class="card border-0 shadow-sm text-center">
                    <div class="card-body">
                        <div class="feature-icon bg-warning text-white mx-auto mb-3" style="width: 3rem; height: 3rem; font-size: 1.2rem;">
                            <i class="bi bi-clock"></i>
                        </div>
                        <h4 class="fw-bold text-warning">{{ $stats['pending'] }}</h4>
                        <p class="text-muted mb-0">Menunggu</p>
                    </div>
                </div>
            </div>
            
            <div class="col-lg-2 col-md-4 col-sm-6">
                <div class="card border-0 shadow-sm text-center">
                    <div class="card-body">
                        <div class="feature-icon bg-info text-white mx-auto mb-3" style="width: 3rem; height: 3rem; font-size: 1.2rem;">
                            <i class="bi bi-credit-card"></i>
                        </div>
                        <h4 class="fw-bold text-info">{{ $stats['paid'] }}</h4>
                        <p class="text-muted mb-0">Dibayar</p>
                    </div>
                </div>
            </div>
            
            <div class="col-lg-2 col-md-4 col-sm-6">
                <div class="card border-0 shadow-sm text-center">
                    <div class="card-body">
                        <div class="feature-icon bg-success text-white mx-auto mb-3" style="width: 3rem; height: 3rem; font-size: 1.2rem;">
                            <i class="bi bi-check-circle"></i>
                        </div>
                        <h4 class="fw-bold text-success">{{ $stats['completed'] }}</h4>
                        <p class="text-muted mb-0">Selesai</p>
                    </div>
                </div>
            </div>
            
            <div class="col-lg-2 col-md-4 col-sm-6">
                <div class="card border-0 shadow-sm text-center">
                    <div class="card-body">
                        <div class="feature-icon bg-danger text-white mx-auto mb-3" style="width: 3rem; height: 3rem; font-size: 1.2rem;">
                            <i class="bi bi-x-circle"></i>
                        </div>
                        <h4 class="fw-bold text-danger">{{ $stats['rejected'] }}</h4>
                        <p class="text-muted mb-0">Ditolak</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Booking History -->
<section class="py-5">
    <div class="container">
        @if($bookings->count() > 0)
            <div class="row g-4">
                @foreach($bookings as $booking)
                <div class="col-12">
                    <div class="card border-0 shadow-sm">
                        <div class="card-body p-4">
                            <div class="row g-4">
                                <!-- Vehicle Image -->
                                <div class="col-lg-2 col-md-3">
                                    @if($booking->kendaraan->foto_kendaraan)
                                        <img src="{{ asset('storage/kendaraan/' . $booking->kendaraan->foto_kendaraan) }}" 
                                             class="img-fluid rounded" 
                                             style="height: 120px; width: 100%; object-fit: cover;"
                                             alt="{{ $booking->kendaraan->model }}">
                                    @else
                                        <div class="bg-light rounded d-flex align-items-center justify-content-center" style="height: 120px;">
                                            <i class="bi bi-car-front text-muted" style="font-size: 2rem;"></i>
                                        </div>
                                    @endif
                                </div>
                                
                                <!-- Booking Details -->
                                <div class="col-lg-6 col-md-9">
                                    <div class="d-flex justify-content-between align-items-start mb-2">
                                        <div class="d-flex align-items-center gap-2">
                                            <h5 class="fw-bold mb-0">{{ $booking->kendaraan->merek }}</h5>
                                            <h5 class="fw-bold mb-0">{{ $booking->kendaraan->model }}</h5>
                                        </div>
                                        <span class="badge bg-{{ $booking->status == 'selesai' ? 'success' : ($booking->status == 'dibayar' ? 'info' : ($booking->status == 'menunggu_pembayaran' ? 'warning' : 'danger')) }} fs-6">
                                @if($booking->status == 'menunggu_pembayaran')
                                    Menunggu Pembayaran
                                @elseif($booking->status == 'dibayar')
                                    Dibayar
                                @elseif($booking->status == 'selesai')
                                    Selesai
                                @elseif($booking->status == 'ditolak')
                                    Ditolak
                                @endif
                            </span>
                                    </div>
                                    
                                    <p class="text-muted mb-2">
                                         <i class="bi bi-people me-1"></i>{{ $booking->kendaraan->jml_kursi }} Kursi
                                         <i class="bi bi-calendar ms-2 me-1"></i>{{ $booking->kendaraan->tahun }}
                                     </p>
                                    
                                    <div class="row g-2 mb-3">
                                        <div class="col-sm-6">
                                            <small class="text-muted">ID Booking:</small>
                                            <p class="fw-semibold mb-0">#{{ str_pad($booking->id_booking, 6, '0', STR_PAD_LEFT) }}</p>
                                        </div>
                                        <div class="col-sm-6">
                                            <small class="text-muted">Tanggal Booking:</small>
                                            <p class="fw-semibold mb-0">{{ \Carbon\Carbon::parse($booking->created_at)->format('d M Y') }}</p>
                                        </div>
                                        <div class="col-sm-6">
                                            <small class="text-muted">Waktu Sewa:</small>
                                            <p class="fw-semibold mb-0">
                                                {{ \Carbon\Carbon::parse($booking->tgl_mulai)->format('d M Y, H:i') }}
                                            </p>
                                        </div>
                                        <div class="col-sm-6">
                                            <small class="text-muted">Durasi:</small>
                                            <p class="fw-semibold mb-0">
                                                @php
                                                    $start = \Carbon\Carbon::parse($booking->tgl_mulai);
                                                    $end = \Carbon\Carbon::parse($booking->tgl_selesai);
                                                    if($booking->kendaraan->harga_per_jam) {
                                                        $duration = $start->diffInHours($end);
                                                        echo $duration . ' jam';
                                                    } else {
                                                        $duration = $start->diffInDays($end);
                                                        echo $duration . ' hari';
                                                    }
                                                @endphp
                                            </p>
                                        </div>
                                    </div>
                                    
                                    @if($booking->status == 'ditolak' && $booking->alasan_penolakan)
                                    <div class="alert alert-danger border-0 py-2 px-3 mb-0">
                                        <small><strong>Alasan Penolakan:</strong> {{ $booking->alasan_penolakan }}</small>
                                    </div>
                                    @endif
                                </div>
                                
                                <!-- Payment & Actions -->
                                <div class="col-lg-4">
                                    <!-- Price -->
                                    <div class="text-end mb-3">
                                        <h4 class="text-primary fw-bold mb-0">Rp {{ number_format($booking->total_harga, 0, ',', '.') }}</h4>
                                    </div>
                                    
                                    <!-- Payment Status -->
                                    <div class="mb-3">
                                        <small class="text-muted">Status Pembayaran:</small>
                                        @if($booking->pembayaran)
                                            <div class="d-flex align-items-center mt-1">
                                                <span class="badge bg-{{ $booking->pembayaran->status_pembayaran == 'dikonfirmasi' ? 'success' : ($booking->pembayaran->status_pembayaran == 'pending' || $booking->pembayaran->status_pembayaran == 'menunggu_konfirmasi' ? 'warning' : 'danger') }} me-2">
                                        @if($booking->pembayaran->status_pembayaran == 'pending')
                                            Pending
                                        @elseif($booking->pembayaran->status_pembayaran == 'menunggu_konfirmasi')
                                            Menunggu Konfirmasi
                                        @elseif($booking->pembayaran->status_pembayaran == 'dikonfirmasi')
                                            Dikonfirmasi
                                        @elseif($booking->pembayaran->status_pembayaran == 'ditolak')
                                            Ditolak
                                        @endif
                                    </span>
                                                @if($booking->pembayaran->bukti_pembayaran)
                                                    <button class="btn btn-sm btn-outline-primary" 
                                                            onclick="showPaymentProof('{{ asset('storage/' . $booking->pembayaran->bukti_pembayaran) }}')"
                                                            title="Lihat Bukti Pembayaran">
                                                        <i class="bi bi-image"></i>
                                                    </button>
                                                @endif
                                            </div>
                                        @else
                                            <span class="badge bg-secondary">Belum Upload Bukti</span>
                                        @endif
                                    </div>
                                    
                                    <!-- Action Buttons -->
                                    <div class="d-grid gap-2">
                                        @if(!$booking->pembayaran && $booking->status != 'ditolak')
                    <a href="{{ route('user.payment.index', $booking->id_booking) }}" class="btn btn-primary">
                        <i class="fas fa-credit-card me-1"></i> Bayar Sekarang
                    </a>
                @elseif($booking->pembayaran && $booking->status != 'ditolak')
                                            <a href="{{ route('user.payment.index', $booking->id_booking) }}" class="btn btn-outline-primary btn-sm">
                                                <i class="bi bi-eye me-2"></i>Lihat Pembayaran
                                            </a>
                                        @endif
                                        
                                        <button class="btn btn-outline-secondary btn-sm" 
                                                data-bs-toggle="modal" 
                                                data-bs-target="#detailModal{{ $booking->id_booking }}">
                                            <i class="bi bi-info-circle me-2"></i>Detail Booking
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            
            <!-- Pagination -->
            <div class="d-flex justify-content-center mt-5">
                {{ $bookings->appends(request()->query())->links() }}
            </div>
        @else
            <!-- Empty State -->
            <div class="text-center py-5">
                <i class="bi bi-inbox text-muted" style="font-size: 5rem;"></i>
                <h3 class="fw-bold mt-4 mb-3">Belum Ada Riwayat Pemesanan</h3>
                <p class="text-muted mb-4">Anda belum memiliki riwayat pemesanan. Mulai jelajahi katalog mobil kami!</p>
                <a href="{{ route('user.katalog') }}" class="btn btn-primary btn-lg">
                    <i class="bi bi-search me-2"></i>Lihat Katalog
                </a>
            </div>
        @endif
    </div>
</section>

<!-- Detail Modals -->
@foreach($bookings as $booking)
<div class="modal fade" id="detailModal{{ $booking->id_booking }}" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title fw-bold">
                    <i class="bi bi-file-text me-2"></i>Detail Booking #{{ str_pad($booking->id_booking, 6, '0', STR_PAD_LEFT) }}
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="row g-4">
                    <!-- Vehicle Info -->
                    <div class="col-md-6">
                        <h6 class="fw-bold mb-3">Informasi Kendaraan</h6>
                        <div class="d-flex align-items-center mb-3">
                            @if($booking->kendaraan->foto_kendaraan)
                                 <img src="{{ asset('storage/kendaraan/' . $booking->kendaraan->foto_kendaraan) }}" 
                                     class="rounded me-3" 
                                     style="width: 80px; height: 60px; object-fit: cover;"
                                     alt="{{ $booking->kendaraan->model }}">
                            @else
                                <div class="bg-light rounded me-3 d-flex align-items-center justify-content-center" style="width: 80px; height: 60px;">
                                    <i class="bi bi-car-front text-muted"></i>
                                </div>
                            @endif
                            <div>
                                <h6 class="fw-bold mb-1">{{ $booking->kendaraan->model }}</h6>
                                <p class="text-muted small mb-0">{{ $booking->kendaraan->merek }} • {{ $booking->kendaraan->tahun }}</p>
                            </div>
                        </div>
                        
                        <div class="row g-2">
                            <div class="col-6">
                                <small class="text-muted">Kapasitas:</small>
                                <p class="fw-semibold mb-0">{{ $booking->kendaraan->jml_kursi }} orang</p>
                            </div>    
                            <div class="col-12">
                                <small class="text-muted">Spesifikasi:</small>
                                <p class="fw-semibold mb-0">{{ ucfirst($booking->kendaraan->spesifikasi) }}</p>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Booking Info -->
                    <div class="col-md-6">
                        <h6 class="fw-bold mb-3">Detail Pemesanan</h6>
                        <div class="row g-2">
                            <div class="col-12">
                                <small class="text-muted">Waktu Mulai:</small>
                                <p class="fw-semibold mb-0">{{ \Carbon\Carbon::parse($booking->tgl_mulai)->format('d M Y, H:i') }}</p>
                            </div>
                            <div class="col-12">
                                <small class="text-muted">Waktu Selesai:</small>
                                <p class="fw-semibold mb-0">{{ \Carbon\Carbon::parse($booking->tgl_selesai)->format('d M Y, H:i') }}</p>
                            </div>
                            <div class="col-6">
                                <small class="text-muted">Durasi:</small>
                                <p class="fw-semibold mb-0">
                                    @php
                                                $start = \Carbon\Carbon::parse($booking->tgl_mulai);
                                                $end = \Carbon\Carbon::parse($booking->tgl_selesai);
                                        if($booking->kendaraan->harga_per_jam) {
                                            $duration = $start->diffInHours($end);
                                            echo $duration . ' jam';
                                        } else {
                                            $duration = $start->diffInDays($end);
                                            echo $duration . ' hari';
                                        }
                                    @endphp
                                </p>
                            </div>
                            <div class="col-6">
                                <small class="text-muted">Tujuan:</small>
                                <p class="fw-semibold mb-0">{{ ucfirst($booking->tujuan) }}</p>
                            </div>
                            <div class="col-12">
                                <small class="text-muted">Status:</small>
                                <span class="badge bg-{{ $booking->status == 'selesai' ? 'success' : ($booking->status == 'dibayar' ? 'info' : ($booking->status == 'menunggu_pembayaran' ? 'warning' : 'danger')) }}">
                                    @if($booking->status == 'menunggu_pembayaran')
                                        Menunggu Pembayaran
                                    @elseif($booking->status == 'dibayar')
                                        Dibayar
                                    @elseif($booking->status == 'selesai')
                                        Selesai
                                    @elseif($booking->status == 'ditolak')
                                        Ditolak
                                    @endif
                                </span>
                            </div>
                            @if($booking->catatan)
                            <div class="col-12">
                                <small class="text-muted">Catatan:</small>
                                <p class="fw-semibold mb-0">{{ $booking->catatan }}</p>
                            </div>
                            @endif
                        </div>
                    </div>
                    
                    <!-- Payment Info -->
                    @if($booking->pembayaran)
                    <div class="col-12">
                        <hr>
                        <h6 class="fw-bold mb-3">Informasi Pembayaran</h6>
                        <div class="row g-2">
                            <div class="col-md-3">
                                <small class="text-muted">Jumlah:</small>
                                <p class="fw-semibold mb-0">Rp {{ number_format($booking->pembayaran->jumlah_bayar, 0, ',', '.') }}</p>
                            </div>
                            <div class="col-md-3">
                                <small class="text-muted">Metode:</small>
                                <p class="fw-semibold mb-0">{{ $booking->pembayaran->metode_pembayaran }}</p>
                            </div>
                            <div class="col-md-3">
                                <small class="text-muted">Tanggal:</small>
                                <p class="fw-semibold mb-0">{{ \Carbon\Carbon::parse($booking->pembayaran->tanggal_bayar)->format('d M Y') }}</p>
                            </div>
                            <div class="col-md-3">
                                <small class="text-muted">Status:</small>
                                <span class="badge bg-{{ $booking->pembayaran->status_pembayaran == 'dikonfirmasi' ? 'success' : ($booking->pembayaran->status_pembayaran == 'pending' || $booking->pembayaran->status_pembayaran == 'menunggu_konfirmasi' ? 'warning' : 'danger') }}">
                                    @if($booking->pembayaran->status_pembayaran == 'pending')
                                        Pending
                                    @elseif($booking->pembayaran->status_pembayaran == 'menunggu_konfirmasi')
                                        Menunggu Konfirmasi
                                    @elseif($booking->pembayaran->status_pembayaran == 'dikonfirmasi')
                                        Dikonfirmasi
                                    @elseif($booking->pembayaran->status_pembayaran == 'ditolak')
                                        Ditolak
                                    @endif
                                </span>
                            </div>
                        </div>
                    </div>
                    @endif
                    
                    <!-- Price Breakdown -->
                    <div class="col-12">
                        <hr>
                        <div class="bg-light p-3 rounded">
                            <div class="d-flex justify-content-between mb-2">
                                <span>Harga per jam:</span>
                                <span>Rp {{ number_format($booking->kendaraan->harga_sewa_per_jam, 0, ',', '.') }}</span>
                            </div>
                            <div class="d-flex justify-content-between mb-2">
                                <span>Durasi:</span>
                                <span>
                                    @php
                                            $start = \Carbon\Carbon::parse($booking->tgl_mulai);
                                            $end = \Carbon\Carbon::parse($booking->tgl_selesai);
                                        if($booking->kendaraan->harga_per_jam) {
                                            $duration = $start->diffInHours($end);
                                            echo $duration . ' jam';
                                        } else {
                                            $duration = $start->diffInDays($end);
                                            echo $duration . ' hari';
                                        }
                                    @endphp
                                </span>
                            </div>
                            <hr class="my-2">
                            <div class="d-flex justify-content-between fw-bold text-primary">
                                <span>Total:</span>
                                <span>Rp {{ number_format($booking->total_harga, 0, ',', '.') }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                @if(!$booking->pembayaran && $booking->status != 'rejected')
                    <a href="{{ route('user.payment.index', $booking->id_booking) }}" class="btn btn-success">
                        <i class="bi bi-upload me-2"></i>Upload Bukti Bayar
                    </a>
                @elseif($booking->pembayaran && $booking->status != 'rejected')
                    <a href="{{ route('user.payment.index', $booking->id_booking) }}" class="btn btn-primary">
                        <i class="bi bi-eye me-2"></i>Lihat Pembayaran
                    </a>
                @endif
            </div>
        </div>
    </div>
</div>
@endforeach

<!-- Payment Proof Modal -->
<div class="modal fade" id="paymentProofModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title fw-bold">
                    <i class="bi bi-image me-2"></i>Bukti Pembayaran
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body text-center">
                <img id="paymentProofImage" src="" class="img-fluid rounded" alt="Bukti Pembayaran">
                <div class="mt-3">
                    <a id="paymentProofLink" href="" target="_blank" class="btn btn-primary">
                        <i class="bi bi-box-arrow-up-right me-2"></i>Buka di Tab Baru
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    function showPaymentProof(imageSrc) {
        document.getElementById('paymentProofImage').src = imageSrc;
        document.getElementById('paymentProofLink').href = imageSrc;
        new bootstrap.Modal(document.getElementById('paymentProofModal')).show();
    }
</script>
@endpush