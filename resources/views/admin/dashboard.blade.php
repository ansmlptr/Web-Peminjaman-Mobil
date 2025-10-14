@extends('admin.layout.header-side-nav')

@section('content')
<style>
.card-stats {
    min-height: 120px;
}
.card-stats .card-body {
    padding: 20px;
    display: flex;
    align-items: center;
    min-height: 80px;
}
.card-stats .numbers {
    flex: 1;
}
.card-stats .card-title {
    font-size: 1.5rem;
    margin-bottom: 0;
}
.card-stats .card-category {
    font-size: 0.875rem;
    margin-bottom: 5px;
}
</style>
<div class="container">
    <div class="page-inner">
        <div class="d-flex align-items-left align-items-md-center flex-column flex-md-row pt-2 pb-4">
            <div>
                <h3 class="fw-bold mb-3">Dashboard Admin</h3>
                <h6 class="op-7 mb-2">Sistem Manajemen Rental Mobil Listrik</h6>
            </div>
        </div>
        
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="row">
            <div class="col-sm-6 col-md-3">
                <div class="card card-stats card-round">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col-icon">
                                <div class="icon-big text-center icon-primary bubble-shadow-small">
                                    <i class="fas fa-car"></i>
                                </div>
                            </div>
                            <div class="col col-stats ms-3 ms-sm-0">
                                <div class="numbers">
                                    <p class="card-category">Total Kendaraan</p>
                                    <h4 class="card-title">{{ $totalKendaraan ?? 0 }}</h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-md-3">
                <div class="card card-stats card-round">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col-icon">
                                <div class="icon-big text-center icon-success bubble-shadow-small">
                                    <i class="fas fa-calendar-check"></i>
                                </div>
                            </div>
                            <div class="col col-stats ms-3 ms-sm-0">
                                <div class="numbers">
                                    <p class="card-category">Booking Aktif</p>
                                    <h4 class="card-title">{{ $bookingAktif ?? 0 }}</h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-sm-6 col-md-3">
                <div class="card card-stats card-round">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col-icon">
                                <div class="icon-big text-center icon-warning bubble-shadow-small">
                                    <i class="fas fa-clock"></i>
                                </div>
                            </div>
                            <div class="col col-stats ms-3 ms-sm-0">
                                <div class="numbers">
                                    <p class="card-category">Menunggu Konfirmasi</p>
                                    <h4 class="card-title">{{ $menungguKonfirmasi ?? 0 }}</h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-md-3">
                <div class="card card-stats card-round">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col-icon">
                                <div class="icon-big text-center icon-secondary bubble-shadow-small">
                                    <i class="fas fa-money-bill-wave"></i>
                                </div>
                            </div>
                            <div class="col col-stats ms-3 ms-sm-0">
                                <div class="numbers">
                                    <p class="card-category">Pendapatan Bulan Ini</p>
                                    <h4 class="card-title">Rp {{ number_format($pendapatanBulanIni ?? 0, 0, ',', '.') }}</h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Recent Bookings -->
        <div class="row">
            <div class="col-md-12">
                <div class="card card-round">
                    <div class="card-header">
                        <div class="card-head-row">
                            <div class="card-title">Booking Terbaru</div>
                            <div class="card-tools">
                                <a href="{{ route('admin.booking.index') }}" class="btn btn-label-info btn-round btn-sm me-2">
                                    <span class="btn-label">
                                        <i class="fa fa-eye"></i>
                                    </span>
                                    Lihat Semua
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead class="thead-light">
                                    <tr>
                                        <th>ID</th>
                                        <th>Nama Penyewa</th>
                                        <th>Kendaraan</th>
                                        <th>Tanggal Mulai</th>
                                        <th>Status</th>
                                        <th>Total Harga</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($recentBookings ?? [] as $booking)
                                        <tr>
                                            <td>{{ $booking->id_booking }}</td>
                                            <td>{{ $booking->customer->nama}}</td>
                                            <td>{{ $booking->kendaraan->model ?? 'N/A' }}</td>
                                            <td>{{ $booking->tgl_mulai ? $booking->tgl_mulai->format('d/m/Y') : 'N/A' }}</td>
                                            <td>
                                                @if($booking->status == 'menunggu_pembayaran')
                                    <span class="badge bg-warning">Menunggu Pembayaran</span>
                                @elseif($booking->status == 'dibayar')
                                    <span class="badge bg-info">Dibayar</span>
                                @elseif($booking->status == 'disetujui')
                                    <span class="badge bg-success">Disetujui</span>
                                @elseif($booking->status == 'ditolak')
                                    <span class="badge bg-danger">Ditolak</span>
                                @elseif($booking->status == 'selesai')
                                    <span class="badge bg-primary">Selesai</span>
                                @endif
                                            </td>
                                            <td>Rp {{ number_format($booking->total_harga, 0, ',', '.') }}</td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="6" class="text-center">Belum ada booking</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection