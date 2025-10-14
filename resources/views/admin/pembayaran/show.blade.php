@extends('admin.layout.header-side-nav')

@section('content')
<div class="page-header">
    <h3 class="fw-bold mb-3">Detail Pembayaran</h3>
</div>

<div class="row">
    <div class="col-md-8">
        <div class="card card-round">
            <div class="card-header">
                <div class="card-head-row">
                    <div class="card-title">Informasi Pembayaran</div>
                    <div class="card-tools">
                        <a href="{{ route('admin.pembayaran.index') }}" class="btn btn-secondary btn-sm">
                            <i class="fa fa-arrow-left"></i> Kembali
                        </a>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="form-label fw-bold">ID Pembayaran</label>
                            <p class="form-control-static">{{ $pembayaran->id_pembayaran }}</p>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="form-label fw-bold">ID Booking</label>
                            <p class="form-control-static">{{ $pembayaran->id_booking }}</p>
                        </div>
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="form-label fw-bold">Nama Penyewa</label>
                            <p class="form-control-static">{{ $pembayaran->booking->customer->nama ?? 'N/A' }}</p>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="form-label fw-bold">Kendaraan</label>
                            <p class="form-control-static">{{ $pembayaran->booking->kendaraan->id_kendaraan ?? 'N/A' }}</p>
                        </div>
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="form-label fw-bold">Jumlah Bayar</label>
                            <p class="form-control-static">Rp {{ number_format($pembayaran->jumlah_bayar, 0, ',', '.') }}</p>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="form-label fw-bold">Metode Pembayaran</label>
                            <p class="form-control-static">{{ ucfirst($pembayaran->metode_pembayaran) }}</p>
                        </div>
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="form-label fw-bold">Tanggal Bayar</label>
                            <p class="form-control-static">{{ $pembayaran->tanggal_bayar ? $pembayaran->tanggal_bayar->format('d/m/Y') : 'N/A' }}</p>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="form-label fw-bold">Status Pembayaran</label>
                            <p class="form-control-static">
                                @if($pembayaran->status_pembayaran == 'pending')
                                    <span class="badge bg-warning">Pending</span>
                                @elseif($pembayaran->status_pembayaran == 'menunggu_konfirmasi')
                                    <span class="badge bg-info">Menunggu Konfirmasi</span>
                                @elseif($pembayaran->status_pembayaran == 'dikonfirmasi')
                                    <span class="badge bg-success">Dikonfirmasi</span>
                                @elseif($pembayaran->status_pembayaran == 'ditolak')
                                    <span class="badge bg-danger">Ditolak</span>
                                @endif
                            </p>
                        </div>
                    </div>
                </div>
                
                @if($pembayaran->tanggal_konfirmasi)
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="form-label fw-bold">Tanggal Konfirmasi</label>
                            <p class="form-control-static">{{ $pembayaran->tanggal_konfirmasi->format('d/m/Y H:i') }}</p>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="form-label fw-bold">Admin Konfirmasi</label>
                            <p class="form-control-static">{{ $pembayaran->admin->name ?? 'N/A' }}</p>
                        </div>
                    </div>
                </div>
                @endif
                
                @if($pembayaran->catatan_admin)
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label class="form-label fw-bold">Catatan Admin</label>
                            <p class="form-control-static">{{ $pembayaran->catatan_admin }}</p>
                        </div>
                    </div>
                </div>
                @endif
                
                @if($pembayaran->status_pembayaran == 'pending' || $pembayaran->status_pembayaran == 'menunggu_konfirmasi')
                <div class="row mt-4">
                    <div class="col-md-12">
                        <div class="d-flex gap-2">
                            <form action="{{ route('admin.pembayaran.confirm', $pembayaran->id_pembayaran) }}" method="POST" style="display: inline;">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="btn btn-success" onclick="return confirm('Konfirmasi pembayaran ini?')">
                                    <i class="fa fa-check"></i> Konfirmasi Pembayaran
                                </button>
                            </form>
                            <form action="{{ route('admin.pembayaran.reject', $pembayaran->id_pembayaran) }}" method="POST" style="display: inline;">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="btn btn-danger" onclick="return confirm('Tolak pembayaran ini?')">
                                    <i class="fa fa-times"></i> Tolak Pembayaran
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>
    
    <div class="col-md-4">
        @if($pembayaran->bukti_pembayaran)
        <div class="card card-round">
            <div class="card-header">
                <div class="card-title">Bukti Pembayaran</div>
            </div>
            <div class="card-body text-center">
                <img src="{{ asset('storage/' . $pembayaran->bukti_pembayaran) }}" 
                     class="img-fluid rounded" 
                     style="max-height: 400px;"
                     alt="Bukti Pembayaran">
                <div class="mt-3">
                    <a href="{{ asset('storage/' . $pembayaran->bukti_pembayaran) }}" 
                       target="_blank" 
                       class="btn btn-primary btn-sm">
                        <i class="fa fa-external-link"></i> Lihat Full Size
                    </a>
                </div>
            </div>
        </div>
        @else
        <div class="card card-round">
            <div class="card-header">
                <div class="card-title">Bukti Pembayaran</div>
            </div>
            <div class="card-body text-center">
                <p class="text-muted">Belum ada bukti pembayaran yang diupload</p>
            </div>
        </div>
        @endif
    </div>
</div>
@endsection