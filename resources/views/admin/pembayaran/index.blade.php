@extends('admin.layout.header-side-nav')

@section('content')
<div class="page-header">
    <h3 class="fw-bold mb-3">Kelola Pembayaran</h3>
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
                    <div class="card-title">Daftar Pembayaran</div>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead class="thead-light">
                            <tr>
                                <th>ID Pembayaran</th>
                                <th>ID Booking</th>
                                <th>Nama Penyewa</th>
                                <th>Jumlah Bayar</th>
                                <th>Metode Pembayaran</th>
                                <th>Tanggal Bayar</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($pembayaran ?? [] as $item)
                                <tr>
                                    <td>{{ $item->id_pembayaran ?? 'N/A' }}</td>
                                    <td>{{ $item->id_booking ?? 'N/A' }}</td>
                                    <td>{{ $item->booking->customer->nama ?? 'N/A' }}</td>
                                    <td>Rp {{ number_format($item->jumlah_bayar ?? 0, 0, ',', '.') }}</td>
                                    <td>{{ ucfirst($item->metode_pembayaran ?? 'N/A') }}</td>
                                    <td>{{ $item->tanggal_bayar ? $item->tanggal_bayar->format('d/m/Y H:i') : 'N/A' }}</td>
                                    <td>
                                        @if($item->status_pembayaran == 'pending')
                            <span class="badge bg-warning">Pending</span>
                        @elseif($item->status_pembayaran == 'menunggu_konfirmasi')
                            <span class="badge bg-info">Menunggu Konfirmasi</span>
                        @elseif($item->status_pembayaran == 'dikonfirmasi')
                            <span class="badge bg-success">Dikonfirmasi</span>
                        @elseif($item->status_pembayaran == 'ditolak')
                            <span class="badge bg-danger">Ditolak</span>
                        @endif
                                    </td>
                                    <td>
                                        <div class="form-button-action">
                                            @if($item->status_pembayaran == 'pending' || $item->status_pembayaran == 'menunggu_konfirmasi')
                                                <form action="{{ route('admin.pembayaran.confirm', $item->id_pembayaran) }}" method="POST" style="display: inline;">
                                                    @csrf
                                                    @method('PATCH')
                                                    <button type="submit" class="btn btn-link btn-success btn-lg" data-original-title="Confirm" onclick="return confirm('Konfirmasi pembayaran ini?')">
                                                        <i class="fa fa-check"></i>
                                                    </button>
                                                </form>
                                                <form action="{{ route('admin.pembayaran.reject', $item->id_pembayaran) }}" method="POST" style="display: inline;">
                                                    @csrf
                                                    @method('PATCH')
                                                    <button type="submit" class="btn btn-link btn-danger btn-lg" data-original-title="Reject" onclick="return confirm('Tolak pembayaran ini?')">
                                                        <i class="fa fa-times"></i>
                                                    </button>
                                                </form>
                                            @endif
                                            <a href="{{ route('admin.pembayaran.show', $item->id_pembayaran) }}" class="btn btn-link btn-info btn-lg" data-original-title="View Details">
                                                <i class="fa fa-eye"></i>
                                            </a>
                                            @if($item->bukti_pembayaran)
                                                <a href="{{ asset('storage/' . $item->bukti_pembayaran) }}" target="_blank" class="btn btn-link btn-primary btn-lg" data-original-title="View Payment Proof">
                                                    <i class="fa fa-file-image"></i>
                                                </a>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="text-center">Belum ada data pembayaran</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection