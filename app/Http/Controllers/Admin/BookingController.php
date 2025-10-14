<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BookingController extends Controller
{
    /**
     * Display a listing of bookings for admin
     */
    public function index()
    {
        $bookings = Booking::with(['kendaraan', 'customer', 'pembayaran'])
            ->orderBy('created_at', 'desc')
            ->get();

        return view('admin.booking.index', compact('bookings'));
    }

    /**
     * Display the specified booking details
     */
    public function show($id)
    {
        $booking = Booking::with(['kendaraan', 'customer', 'pembayaran'])
            ->where('id_booking', $id)
            ->firstOrFail();

        return view('admin.booking.show', compact('booking'));
    }

    /**
     * Complete a booking 
     */
    public function complete($id)
    {
        try {
            DB::beginTransaction();

            $booking = Booking::where('id_booking', $id)->firstOrFail();

            // Hanya bisa complete jika status disetujui
            if ($booking->status !== 'disetujui') {
                return redirect()->back()->with('error', 'Booking tidak dapat diselesaikan karena status bukan disetujui.');
            }

            // Update status booking menjadi selesai
            $booking->update([
                'status' => 'selesai'
            ]);

            // Kembalikan unit kendaraan
            $kendaraan = $booking->kendaraan;
            $kendaraan->jumlah_unit = $kendaraan->jumlah_unit + 1;
            $kendaraan->save();


            DB::commit();

            return redirect()->route('admin.booking.index')
                ->with('success', 'Booking berhasil diselesaikan!');

        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error', 'Terjadi kesalahan saat menyelesaikan booking.');
        }
    }

    /**
     * Get booking statistics for dashboard
     */
    public function getStats()
    {
        $stats = [
            'total' => Booking::count(),
            'pending' => Booking::where('status', 'pending')->count(),
            'approved' => Booking::where('status', 'approved')->count(),
            'rejected' => Booking::where('status', 'rejected')->count(),
        ];

        return $stats;
    }

    /**
     * Filter bookings by status
     */
    public function filterByStatus(Request $request)
    {
        $status = $request->get('status');

        $query = Booking::with(['kendaraan', 'user'])
            ->orderBy('created_at', 'desc');

        if ($status && $status !== 'all') {
            $query->where('status', $status);
        }

        $bookings = $query->get();

        return view('admin.booking.index', compact('bookings'));
    }
}