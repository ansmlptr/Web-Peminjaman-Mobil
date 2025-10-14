@extends('user.layout.app')

@section('title', 'Pembayaran - Upload Bukti Bayar')

@section('content')
<!-- Breadcrumb -->
<section class="bg-light py-3">
    <div class="container">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="{{ route('user.home') }}" class="text-decoration-none">Home</a></li>
                <li class="breadcrumb-item"><a href="{{ route('user.history') }}" class="text-decoration-none">History</a></li>
                <li class="breadcrumb-item active">Pembayaran</li>
            </ol>
        </nav>
    </div>
</section>

<!-- Payment Section -->
<section class="py-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <!-- Payment Status -->
                @if($booking->status == 'menunggu_pembayaran')
                    <div class="alert alert-warning border-0 shadow-sm mb-4">
                        <div class="d-flex align-items-center">
                            <i class="bi bi-clock-history text-warning me-3" style="font-size: 1.5rem;"></i>
                            <div>
                                <h6 class="mb-1 fw-bold">Menunggu Pembayaran</h6>
                                <p class="mb-0">Booking Anda menunggu pembayaran. Silakan upload bukti pembayaran untuk mempercepat proses.</p>
                            </div>
                        </div>
                    </div>
                @elseif($booking->status == 'dibayar')
                    <div class="alert alert-info border-0 shadow-sm mb-4">
                        <div class="d-flex align-items-center">
                            <i class="bi bi-info-circle text-info me-3" style="font-size: 1.5rem;"></i>
                            <div>
                                <h6 class="mb-1 fw-bold">Pembayaran Diterima</h6>
                                <p class="mb-0">Pembayaran telah diterima, menunggu konfirmasi admin.</p>
                            </div>
                        </div>
                    </div>
                @elseif($booking->status == 'disetujui')
                    <div class="alert alert-success border-0 shadow-sm mb-4">
                        <div class="d-flex align-items-center">
                            <i class="bi bi-check-circle text-success me-3" style="font-size: 1.5rem;"></i>
                            <div>
                                <h6 class="mb-1 fw-bold">Booking Disetujui</h6>
                                <p class="mb-0">Selamat! Booking Anda telah disetujui.</p>
                            </div>
                        </div>
                    </div>
                @elseif($booking->status == 'ditolak')
                    <div class="alert alert-danger border-0 shadow-sm mb-4">
                        <div class="d-flex align-items-center">
                            <i class="bi bi-x-circle text-danger me-3" style="font-size: 1.5rem;"></i>
                            <div>
                                <h6 class="mb-1 fw-bold">Booking Ditolak</h6>
                                <p class="mb-0">Maaf, booking Anda ditolak. {{ $booking->alasan_tolak ?? 'Silakan hubungi customer service untuk informasi lebih lanjut.' }}</p>
                            </div>
                        </div>
                    </div>
                @elseif($booking->status == 'selesai')
                    <div class="alert alert-primary border-0 shadow-sm mb-4">
                        <div class="d-flex align-items-center">
                            <i class="bi bi-flag text-primary me-3" style="font-size: 1.5rem;"></i>
                            <div>
                                <h6 class="mb-1 fw-bold">Booking Selesai</h6>
                                <p class="mb-0">Booking telah selesai.</p>
                            </div>
                        </div>
                    </div>
                @endif

                <div class="row g-4">
                    <!-- Booking Details -->
                    <div class="col-lg-6">
                        <div class="card border-0 shadow-sm h-100">
                            <div class="card-header bg-primary text-white">
                                <h5 class="mb-0 fw-bold">
                                    <i class="bi bi-file-text me-2"></i>Detail Booking
                                </h5>
                            </div>
                            <div class="card-body p-4">
                                <!-- Vehicle Info -->
                                <div class="d-flex align-items-center mb-4">
                                    @if($booking->kendaraan->foto_kendaraan)
                                        <img src="{{ asset('storage/kendaraan/' . $booking->kendaraan->foto_kendaraan) }}" 
                                             class="rounded" 
                                             style="width: 80px; height: 60px; object-fit: cover;"
                                             alt="{{ $booking->kendaraan->nama }}">
                                    @else
                                        <div class="bg-light rounded d-flex align-items-center justify-content-center" style="width: 80px; height: 60px;">
                                            <i class="bi bi-car-front text-muted"></i>
                                        </div>
                                    @endif
                                    <div class="ms-3">
                                        <h6 class="fw-bold mb-1">{{ $booking->kendaraan->nama }}</h6>
                                        <p class="text-muted small mb-0">{{ $booking->kendaraan->merek }} • {{ $booking->kendaraan->tahun }}</p>
                                    </div>
                                </div>

                                <!-- Booking Info -->
                                <div class="row g-3">
                                    <div class="col-12">
                                        <div class="border-start border-primary border-3 ps-3">
                                            <h6 class="fw-semibold mb-1">ID Booking</h6>
                                            <p class="text-muted mb-0">#{{ str_pad($booking->id_booking, 6, '0', STR_PAD_LEFT) }}</p>
                                        </div>
                                    </div>
                                    
                                    <div class="col-12">
                                        <div class="border-start border-primary border-3 ps-3">
                                            <h6 class="fw-semibold mb-1">Waktu Sewa</h6>
                                            <p class="text-muted mb-0">
                                                {{ \Carbon\Carbon::parse($booking->tgl_mulai)->format('d M Y, H:i') }} -
                                {{ \Carbon\Carbon::parse($booking->tgl_selesai)->format('d M Y, H:i') }}
                                            </p>
                                        </div>
                                    </div>
                                    
                                    <div class="col-6">
                                        <div class="border-start border-primary border-3 ps-3">
                                            <h6 class="fw-semibold mb-1">Durasi</h6>
                                            <p class="text-muted mb-0">
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
                                    
                                    <div class="col-6">
                                        <div class="border-start border-primary border-3 ps-3">
                                            <h6 class="fw-semibold mb-1">Tujuan</h6>
                                            <p class="text-muted mb-0">{{ ucfirst($booking->tujuan) }}</p>
                                        </div>
                                    </div>
                                    
                                    @if($booking->catatan)
                                    <div class="col-12">
                                        <div class="border-start border-primary border-3 ps-3">
                                            <h6 class="fw-semibold mb-1">Catatan</h6>
                                            <p class="text-muted mb-0">{{ $booking->catatan }}</p>
                                        </div>
                                    </div>
                                    @endif
                                </div>
                                
                                <!-- Total Price -->
                                <hr class="my-4">
                                <div class="bg-light border border-primary p-4 rounded">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <span class="fw-bold text-dark fs-5">Total Pembayaran:</span>
                                        <span class="h6 text-primary fw-bold mb-0">Rp {{ number_format($booking->total_harga, 0, ',', '.') }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Payment Form -->
                    <div class="col-lg-6">
                        <div class="card border-0 shadow-sm h-100">
                            <div class="card-header bg-success text-white">
                                <h5 class="mb-0 fw-bold">
                                    <i class="bi bi-credit-card me-2"></i>Informasi Pembayaran
                                </h5>
                            </div>
                            <div class="card-body p-4">
                                <!-- Bank Information -->
                                <div class="alert alert-info border-0 mb-4">
                                    <h6 class="fw-bold mb-3">
                                        <i class="bi bi-bank me-2"></i>Transfer ke Rekening:
                                    </h6>
                                    <div class="row g-3">
                                        <div class="col-12">
                                            <div class="d-flex justify-content-between align-items-center p-2 bg-white rounded">
                                                <div>
                                                    <strong>BCA</strong><br>
                                                    <small class="text-muted">1234567890</small><br>
                                                    <small class="text-muted">a.n. Rental Mobil</small>
                                                </div>
                                                <button class="btn btn-sm btn-outline-primary" onclick="copyToClipboard('1234567890')">
                                                    <i class="bi bi-clipboard"></i>
                                                </button>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="d-flex justify-content-between align-items-center p-2 bg-white rounded">
                                                <div>
                                                    <strong>Mandiri</strong><br>
                                                    <small class="text-muted">0987654321</small><br>
                                                    <small class="text-muted">a.n. Rental Mobil</small>
                                                </div>
                                                <button class="btn btn-sm btn-outline-primary" onclick="copyToClipboard('0987654321')">
                                                    <i class="bi bi-clipboard"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                <!-- Payment Form -->
                                @if($booking->pembayaran)
                                    <!-- Existing Payment -->
                                    <div class="mb-4">
                                        <h6 class="fw-bold mb-3">
                                            <i class="bi bi-check-circle text-success me-2"></i>Bukti Pembayaran Terupload
                                        </h6>
                                        
                                        <div class="border rounded p-3">
                                            <div class="row g-3">
                                                <div class="col-md-6">
                                                    <small class="text-muted">Jumlah Transfer:</small>
                                                    <p class="fw-bold mb-0">Rp {{ number_format($booking->pembayaran->jumlah_bayar, 0, ',', '.') }}</p>
                                                </div>
                                                <div class="col-md-6">
                                                    <small class="text-muted">Metode:</small>
                                                    <p class="fw-bold mb-0">{{ $booking->pembayaran->metode_pembayaran }}</p>
                                                </div>
                                                <div class="col-md-6">
                                                    <small class="text-muted">Tanggal Transfer:</small>
                                                    <p class="fw-bold mb-0">{{ \Carbon\Carbon::parse($booking->pembayaran->tanggal_bayar)->format('d M Y') }}</p>
                                                </div>
                                                <div class="col-md-6">
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
                                                @if($booking->pembayaran->bukti_pembayaran)
                                                <div class="col-12">
                                                    <small class="text-muted">Bukti Transfer:</small>
                                                    <div class="mt-2">
                                                        <img src="{{ asset('storage/' . $booking->pembayaran->bukti_pembayaran) }}" 
                                                             class="img-thumbnail" 
                                                             style="max-width: 200px; cursor: pointer;"
                                                             onclick="showPaymentProof('{{ asset('storage/' . $booking->pembayaran->bukti_pembayaran) }}')"
                                                             alt="Bukti Pembayaran">
                                                    </div>
                                                </div>
                                                @endif
                                            </div>
                                        </div>
                                        
                
                                    </div>
                                @else
                                    <!-- Upload Payment Form -->
                                    <form action="{{ route('user.payment.store', ['id_booking' => $booking->id_booking]) }}" method="POST" enctype="multipart/form-data" id="paymentForm">
                                        @csrf
                                        <input type="hidden" name="id_booking" value="{{ $booking->id_booking }}">
                                        
                                        <div class="mb-3">
                                            <label class="form-label fw-semibold">
                                                <i class="bi bi-currency-dollar me-1"></i>Jumlah Transfer *
                                            </label>
                                            <div class="input-group">
                                                <span class="input-group-text">Rp</span>
                                                <input type="number" 
                                                       class="form-control @error('jumlah_bayar') is-invalid @enderror" 
                                                       name="jumlah_bayar" 
                                                       value="{{ old('jumlah_bayar', $booking->total_harga) }}"
                                                       min="1"
                                                       required>
                                            </div>
                                            @error('jumlah_bayar')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        
                                        <div class="mb-3">
                                            <label class="form-label fw-semibold">
                                                <i class="bi bi-bank me-1"></i>Metode Pembayaran *
                                            </label>
                                            <select class="form-select @error('metode_pembayaran') is-invalid @enderror" name="metode_pembayaran" required>
                                                <option value="">Pilih metode pembayaran</option>
                                                <option value="transfer_bca" {{ old('metode_pembayaran') == 'transfer_bca' ? 'selected' : '' }}>Transfer Bank BCA</option>
                                                <option value="transfer_mandiri" {{ old('metode_pembayaran') == 'transfer_mandiri' ? 'selected' : '' }}>Transfer Bank Mandiri</option>
                                                <option value="transfer_bni" {{ old('metode_pembayaran') == 'transfer_bni' ? 'selected' : '' }}>Transfer Bank BNI</option>
                                                <option value="transfer_bri" {{ old('metode_pembayaran') == 'transfer_bri' ? 'selected' : '' }}>Transfer Bank BRI</option>
                                            </select>
                                            @error('metode_pembayaran')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        
                                        <div class="mb-3">
                                            <label class="form-label fw-semibold">
                                                <i class="bi bi-calendar-event me-1"></i>Tanggal Transfer *
                                            </label>
                                            <input type="date" 
                                                   class="form-control @error('tanggal_bayar') is-invalid @enderror" 
                                                   name="tanggal_bayar" 
                                                   value="{{ old('tanggal_bayar', date('Y-m-d')) }}"
                                                   max="{{ date('Y-m-d') }}"
                                                   required>
                                            @error('tanggal_bayar')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        
                                        <div class="mb-4">
                                            <label class="form-label fw-semibold">
                                                <i class="bi bi-image me-1"></i>Upload Bukti Transfer *
                                            </label>
                                            <input type="file" 
                                                   class="form-control @error('bukti_pembayaran') is-invalid @enderror" 
                                                   name="bukti_pembayaran" 
                                                   accept="image/*"
                                                   required>
                                            <div class="form-text">
                                                <i class="bi bi-info-circle me-1"></i>
                                                Format yang didukung: JPG, PNG, JPEG. Maksimal 2MB.
                                            </div>
                                            @error('bukti_pembayaran')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        
                                        <div class="d-grid">
                                            <button type="submit" class="btn btn-success btn-lg fw-semibold">
                                                <i class="bi bi-upload me-2"></i>Upload Bukti Pembayaran
                                            </button>
                                        </div>
                                    </form>
                                @endif
                                
                                <!-- Action Buttons -->
                                <hr class="my-4">
                                <div class="d-flex gap-2">
                                    <a href="{{ route('user.history') }}" class="btn btn-outline-secondary flex-fill">
                                        <i class="bi bi-arrow-left me-2"></i>Kembali ke History
                                    </a>
                                    <a href="{{ route('user.katalog') }}" class="btn btn-outline-primary flex-fill">
                                        <i class="bi bi-search me-2"></i>Lihat Katalog
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>



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
    function copyToClipboard(text) {
        navigator.clipboard.writeText(text).then(function() {
            // Show toast or alert
            const toast = document.createElement('div');
            toast.className = 'toast align-items-center text-white bg-success border-0 position-fixed top-0 end-0 m-3';
            toast.style.zIndex = '9999';
            toast.innerHTML = `
                <div class="d-flex">
                    <div class="toast-body">
                        <i class="bi bi-check-circle me-2"></i>Nomor rekening berhasil disalin!
                    </div>
                    <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
                </div>
            `;
            document.body.appendChild(toast);
            const bsToast = new bootstrap.Toast(toast);
            bsToast.show();
            
            // Remove toast after it's hidden
            toast.addEventListener('hidden.bs.toast', function() {
                document.body.removeChild(toast);
            });
        });
    }
    
    function showPaymentProof(imageSrc) {
        document.getElementById('paymentProofImage').src = imageSrc;
        document.getElementById('paymentProofLink').href = imageSrc;
        new bootstrap.Modal(document.getElementById('paymentProofModal')).show();
    }
    
    // File upload preview
    document.addEventListener('DOMContentLoaded', function() {
        const fileInput = document.querySelector('input[name="bukti_pembayaran"]');
        if (fileInput) {
            fileInput.addEventListener('change', function(e) {
                const file = e.target.files[0];
                if (file) {
                    // Validate file size (2MB)
                    if (file.size > 2 * 1024 * 1024) {
                        alert('Ukuran file terlalu besar. Maksimal 2MB.');
                        this.value = '';
                        return;
                    }
                    
                    // Validate file type
                    const allowedTypes = ['image/jpeg', 'image/jpg', 'image/png'];
                    if (!allowedTypes.includes(file.type)) {
                        alert('Format file tidak didukung. Gunakan JPG, JPEG, atau PNG.');
                        this.value = '';
                        return;
                    }
                }
            });
        }
    });
</script>
@endpush