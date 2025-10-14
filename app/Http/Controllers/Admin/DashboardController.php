<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Kendaraan;
use App\Models\Booking;
use App\Models\Pembayaran;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        // Total kendaraan
        $totalKendaraan = Kendaraan::count();

        // Booking aktif (approved dan sedang berjalan)
        $bookingAktif = Booking::where('status', 'disetujui')
            ->where('tgl_mulai', '<=', Carbon::now())
            ->where('tgl_selesai', '>=', Carbon::now())
            ->count();

        // Menunggu konfirmasi (paid status)
        $menungguKonfirmasi = Booking::where('status', 'dibayar')->count();

        // Pendapatan bulan ini (dari booking yang sudah completed)
        $pendapatanBulanIni = Booking::where('status', 'selesai')
            ->whereMonth('created_at', Carbon::now()->month)
            ->whereYear('created_at', Carbon::now()->year)
            ->sum('total_harga');

        // Recent bookings (5 terbaru)
        $recentBookings = Booking::with('kendaraan')
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        return view('admin.dashboard', compact(
            'totalKendaraan',
            'bookingAktif',
            'menungguKonfirmasi',
            'pendapatanBulanIni',
            'recentBookings'
        ));
    }
}