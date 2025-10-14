@extends('admin.layout.header-side-nav')

@section('content')
<div class="page-header">
    <h3 class="fw-bold mb-3">Kelola Pesanan</h3>
</div>

@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

<div class="row">
    <div class="col-md-12">
        <div class="card card-round">
            <div class="card-header">
                <div class="card-head-row">
                    <div class="card-title">Daftar Booking</div>
                    <div class="card-tools">
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead class="thead-light">
                            <tr>
                                <th>ID Booking</th>
                                <th>Nama Penyewa</th>
                                <th>Kendaraan</th>
                                <th>Waktu Sewa</th>
                                <th>Durasi</th>
                                <th>Total Harga</th>
                                <th>Bukti Bayar</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($bookings ?? [] as $booking)
                                <tr>
                                    <td>{{ $booking->id_booking }}</td>
                                    <td>{{ $booking->customer->nama ?? 'N/A' }}</td>
                                    <td>
                                        @if($booking->kendaraan)
                                            {{ $booking->kendaraan->merek ?? '' }}{{ $booking->kendaraan->merek && $booking->kendaraan->model ? ' - ' : '' }}{{ $booking->kendaraan->model ?? '' }}
                                        @else
                                            N/A
                                        @endif
                                    </td>
                                    <td>
                                        {{ $booking->tgl_mulai ? $booking->tgl_mulai->format('d/m/Y') : 'N/A' }}
                                        <br>
                                        <small class="text-muted">
                                            s/d {{ $booking->tgl_selesai ? $booking->tgl_selesai->format('d/m/Y') : 'N/A' }}
                                        </small>
                                    </td>
                                    <td>
                                        {{ $booking->durasi_jam ?? 0 }} jam
                                    </td>
                                    <td>Rp {{ number_format($booking->total_harga, 0, ',', '.') }}</td>
                                    <td>
                                        @if($booking->pembayaran && $booking->pembayaran->bukti_pembayaran)
                                            <button class="btn btn-sm btn-info" data-bs-toggle="modal" data-bs-target="#buktiModal{{ $booking->id_booking }}">
                                                <i class="fa fa-image"></i> Lihat
                                            </button>
                                        @else
                                            <span class="badge badge-secondary">Belum ada</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($booking->status == 'menunggu_pembayaran')
                                            <span class="badge badge-warning">Menunggu Pembayaran</span>
                                        @elseif($booking->status == 'dibayar')
                                            <span class="badge badge-info">Dibayar</span>
                                        @elseif($booking->status == 'disetujui')
                                            <span class="badge badge-success">Disetujui</span>
                                        @elseif($booking->status == 'ditolak')
                                            <span class="badge badge-danger">Ditolak</span>
                                        @elseif($booking->status == 'selesai')
                                            <span class="badge badge-info">Selesai</span>
                                        @else
                                            <span class="badge badge-secondary">{{ ucfirst($booking->status) }}</span>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="form-button-action">
                                            @if($booking->status == 'disetujui')
                                                <form action="{{ route('admin.booking.complete', $booking->id_booking) }}" method="POST" style="display: inline;">
                                                    @csrf
                                                    @method('PATCH')
                                                    <button type="submit" class="btn btn-link btn-primary btn-lg" data-original-title="Selesaikan" onclick="return confirm('Selesaikan booking ini?')">
                                                        <i class="fa fa-flag-checkered"></i>
                                                    </button>
                                                </form>
                                            @endif
                                            <a href="{{ route('admin.booking.show', $booking->id_booking) }}" class="btn btn-link btn-info btn-lg" data-original-title="View Details">
                                                <i class="fa fa-eye"></i>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="9" class="text-center">Belum ada data booking</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal untuk Bukti Pembayaran -->
@foreach($bookings ?? [] as $booking)
    @if($booking->pembayaran && $booking->pembayaran->bukti_pembayaran)
        <div class="modal fade" id="buktiModal{{ $booking->id_booking }}" tabindex="-1" aria-labelledby="buktiModalLabel{{ $booking->id_booking }}" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="buktiModalLabel{{ $booking->id_booking }}">Bukti Pembayaran - Booking #{{ $booking->id_booking }}</h5>
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
                            <p><strong>Status:</strong> 
                                @if($booking->pembayaran->status_pembayaran == 'pending')
                                    <span class="badge badge-warning">Pending</span>
                                @elseif($booking->pembayaran->status_pembayaran == 'menunggu_konfirmasi')
                                    <span class="badge badge-warning">Menunggu Konfirmasi</span>
                                @elseif($booking->pembayaran->status_pembayaran == 'dikonfirmasi')
                                    <span class="badge badge-success">Dikonfirmasi</span>
                                @elseif($booking->pembayaran->status_pembayaran == 'ditolak')
                                    <span class="badge badge-danger">Ditolak</span>
                                @endif
                            </p>
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
@endforeach

@endsection