@extends('admin.layout.header-side-nav')

@section('content')
<div class="page-header">
    <h3 class="fw-bold mb-3">Detail Booking</h3>
</div>

@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

@if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        {{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

<div class="row">
    <div class="col-md-8">
        <div class="card card-round">
            <div class="card-header">
                <div class="card-head-row">
                    <div class="card-title">Informasi Booking</div>
                    <div class="card-tools">
                        <a href="{{ route('admin.booking.index') }}" class="btn btn-secondary btn-sm">
                            <i class="fa fa-arrow-left"></i> Kembali
                        </a>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <h5 class="mb-3">Data Penyewa</h5>
                        <table class="table table-borderless">
                            <tr>
                                <td width="40%"><strong>Nama Lengkap</strong></td>
                                <td>: {{ $booking->customer->nama }}</td>
                            </tr>
                            <tr>
                                <td><strong>Email</strong></td>
                                <td>: {{ $booking->customer->email }}</td>
                            </tr>
                            <tr>
                                <td><strong>No. Telepon</strong></td>
                                <td>: {{ $booking->customer->no_hp }}</td>
                            </tr>
                            <tr>
                                <td><strong>Alamat</strong></td>
                                <td>: {{ $booking->customer->alamat }}</td>
                            </tr>
                        </table>
                    </div>
                    <div class="col-md-6">
                        <h5 class="mb-3">Detail Rental</h5>
                        <table class="table table-borderless">
                            <tr>
                                <td width="40%"><strong>Tanggal Mulai</strong></td>
                                <td>: {{ $booking->tgl_mulai ? $booking->tgl_mulai->format('d F Y H:i') : 'N/A' }}
                                </td>
                            </tr>
                            <tr>
                                <td><strong>Tanggal Selesai</strong></td>
                                <td>: {{ $booking->tgl_selesai ? $booking->tgl_selesai->format('d F Y H:i') : 'N/A' }}
                                </td>
                            </tr>
                            <tr>
                                <td><strong>Durasi</strong></td>
                                <td>: 
                                    @if(isset($booking->durasi_jam))
                                        {{ $booking->durasi_jam }} jam
                                        @if($booking->total_jam)
                                            (Total: {{ $booking->total_jam }} jam)
                                        @endif
                                    @else
                                        {{ $booking->durasi_hari ?? 0 }} hari
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <td><strong>Tujuan</strong></td>
                                <td>: {{ $booking->tujuan }}</td>
                            </tr>
                            <tr>
                                <td><strong>Catatan</strong></td>
                                <td>: {{ $booking->catatan ?: 'Tidak ada catatan' }}</td>
                            </tr>
                        </table>
                    </div>
                </div>

                @if($booking->alasan_tolak && $booking->status == 'ditolak')
                <div class="row mt-4">
                    <div class="col-12">
                        <div class="alert alert-danger">
                            <h6><strong>Alasan Penolakan:</strong></h6>
                            <p class="mb-0">{{ $booking->alasan_tolak }}</p>
                        </div>
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <!-- Status Card -->
        <div class="card card-round mb-3">
            <div class="card-header">
                <div class="card-title">Status Booking</div>
            </div>
            <div class="card-body text-center">
                <div class="mb-3">
                    @if($booking->status == 'menunggu_pembayaran')
                        <span class="badge bg-warning fs-6">Menunggu Pembayaran</span>
                    @elseif($booking->status == 'dibayar')
                        <span class="badge bg-info fs-6">Dibayar</span>
                    @elseif($booking->status == 'disetujui')
                        <span class="badge bg-success fs-6">Disetujui</span>
                    @elseif($booking->status == 'ditolak')
                        <span class="badge bg-danger fs-6">Ditolak</span>
                    @elseif($booking->status == 'selesai')
                        <span class="badge bg-primary fs-6">Selesai</span>
                    @endif
                </div>
                
                @if($booking->status == 'disetujui')
                <div class="d-grid gap-2">
                    <form action="{{ route('admin.booking.complete', $booking->id_booking) }}" method="POST" class="mb-2">
                        @csrf
                        @method('PATCH')
                        <button type="submit" class="btn btn-primary btn-block" onclick="return confirm('Selesaikan booking ini?')">
                            <i class="fa fa-flag-checkered"></i> Selesaikan
                        </button>
                    </form>
                </div>
                @endif
            </div>
        </div>

        <!-- Vehicle Info Card -->
        <div class="card card-round mb-3">
            <div class="card-header">
                <div class="card-title">Kendaraan</div>
            </div>
            <div class="card-body">
                @if($booking->kendaraan)
                    <div class="text-center mb-3">
                        @if($booking->kendaraan->foto_kendaraan)
                             <img src="{{ asset('storage/kendaraan/' . $booking->kendaraan->foto_kendaraan) }}" 
                                 alt="{{ $booking->kendaraan->nama }}" 
                                 class="img-fluid rounded" 
                                 style="max-height: 150px; object-fit: cover;">
                        @else
                            <div class="bg-light rounded d-flex align-items-center justify-content-center" style="height: 150px;">
                                <i class="fa fa-car fa-3x text-muted"></i>
                            </div>
                        @endif
                    </div>
                    
                    <table class="table table-borderless table-sm">
                        <tr>
                            <td><strong>Model</strong></td>
                            <td>: {{ $booking->kendaraan->model }}</td>
                        </tr>
                        <tr>
                            <td><strong>Merek</strong></td>
                                <td>: {{ $booking->kendaraan->merek }}</td>
                        </tr>
                        <tr>
                            <td><strong>Tahun</strong></td>
                            <td>: {{ $booking->kendaraan->tahun }}</td>
                        </tr>
                        <tr>
                            <td><strong>Harga/jam</strong></td>
                            <td>: Rp {{ number_format($booking->kendaraan->harga_sewa_per_jam, 0, ',', '.') }}</td>
                        </tr>
                        <tr class="border-top">
                            <td><strong>Total Harga</strong></td>
                            <td><strong>: Rp {{ number_format($booking->total_harga, 0, ',', '.') }}</strong></td>
                        </tr>
                    </table>
                @else
                    <p class="text-muted">Data kendaraan tidak tersedia</p>
                @endif
            </div>
        </div>

        <!-- Payment Info Card -->
        <div class="card card-round">
            <div class="card-header">
                <div class="card-title">Informasi Pembayaran</div>
            </div>
            <div class="card-body">
                @if($booking->pembayaran)
                    <table class="table table-borderless table-sm">
                        <tr>
                            <td width="40%"><strong>Jumlah Bayar</strong></td>
                            <td>: Rp {{ number_format($booking->pembayaran->jumlah_bayar, 0, ',', '.') }}</td>
                        </tr>
                        <tr>
                            <td><strong>Metode</strong></td>
                            <td>: {{ $booking->pembayaran->metode_pembayaran }}</td>
                        </tr>
                        <tr>
                            <td><strong>Tanggal Bayar</strong></td>
                            <td>: {{ $booking->pembayaran->tanggal_bayar ? $booking->pembayaran->tanggal_bayar->format('d F Y H:i') : 'N/A' }}</td>
                        </tr>
                        <tr>
                            <td><strong>Status</strong></td>
                            <td>: 
                                @if($booking->pembayaran->status_pembayaran == 'pending')
                    <span class="badge bg-warning">Pending</span>
                @elseif($booking->pembayaran->status_pembayaran == 'menunggu_konfirmasi')
                    <span class="badge bg-info">Menunggu Konfirmasi</span>
                @elseif($booking->pembayaran->status_pembayaran == 'dikonfirmasi')
                    <span class="badge bg-success">Dikonfirmasi</span>
                @elseif($booking->pembayaran->status_pembayaran == 'ditolak')
                    <span class="badge bg-danger">Ditolak</span>
                @endif
                            </td>
                        </tr>
                    </table>
                    
                    @if($booking->pembayaran->bukti_pembayaran)
                        <div class="text-center mt-3">
                            <button class="btn btn-info btn-sm" data-bs-toggle="modal" data-bs-target="#buktiModal">
                                <i class="fa fa-image"></i> Lihat Bukti Pembayaran
                            </button>
                        </div>
                    @endif
                    
                    @if($booking->pembayaran->catatan_admin)
                        <div class="mt-3">
                            <small class="text-muted"><strong>Catatan Admin:</strong></small>
                            <p class="mb-0">{{ $booking->pembayaran->catatan_admin }}</p>
                        </div>
                    @endif
                @else
                    <p class="text-muted text-center">Belum ada data pembayaran</p>
                @endif
            </div>
        </div>
    </div>
</div>


<!-- Bukti Pembayaran Modal -->
@if($booking->pembayaran && $booking->pembayaran->bukti_pembayaran)
<div class="modal fade" id="buktiModal" tabindex="-1" aria-labelledby="buktiModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="buktiModalLabel">Bukti Pembayaran - Booking #{{ $booking->id_booking }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body text-center">
                <img src="{{ asset('storage/' . $booking->pembayaran->bukti_pembayaran) }}" 
                     alt="Bukti Pembayaran" 
                     class="img-fluid" 
                     style="max-height: 500px;">
                <div class="mt-3">
                    <p><strong>Jumlah Bayar:</strong> Rp {{ number_format($booking->pembayaran->jumlah_bayar, 0, ',', '.') }}</p>
                    <p><strong>Metode Pembayaran:</strong> {{ $booking->pembayaran->metode_pembayaran }}</p>
                    <p><strong>Tanggal Bayar:</strong> {{ $booking->pembayaran->tanggal_bayar ? $booking->pembayaran->tanggal_bayar->format('d/m/Y H:i') : 'N/A' }}</p>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                <a href="{{ asset('storage/' . $booking->pembayaran->bukti_pembayaran) }}" 
                   target="_blank" 
                   class="btn btn-primary">Buka di Tab Baru</a>
            </div>
        </div>
    </div>
</div>
@endif

@endsection