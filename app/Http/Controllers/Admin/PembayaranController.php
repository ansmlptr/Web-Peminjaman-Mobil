<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Pembayaran;
use App\Models\Booking;

class PembayaranController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $pembayaran = Pembayaran::with(['booking.customer', 'booking.kendaraan'])
            ->orderBy('created_at', 'desc')
            ->get();

        return view('admin.pembayaran.index', compact('pembayaran'));
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $pembayaran = Pembayaran::with(['booking.customer', 'booking.kendaraan', 'admin'])
            ->findOrFail($id);

        return view('admin.pembayaran.show', compact('pembayaran'));
    }

    /**
     * Confirm payment
     */
    public function confirm(Pembayaran $pembayaran)
    {
        try {
            \DB::beginTransaction();

            $pembayaran->update([
                'status_pembayaran' => 'dikonfirmasi',
                'tanggal_konfirmasi' => now(),
                'admin_konfirmasi' => auth()->id()
            ]);

            // Update booking status to 'disetujui' when payment is confirmed
            $booking = $pembayaran->booking;
            $booking->update([
                'status' => 'disetujui'
            ]);

            // Kurangi jumlah unit kendaraan
            $kendaraan = $booking->kendaraan;
            $kendaraan->jumlah_unit = max(0, $kendaraan->jumlah_unit - 1);
            $kendaraan->save();


            \DB::commit();

            return redirect()->route('admin.pembayaran.index')
                ->with('success', 'Pembayaran berhasil dikonfirmasi dan booking disetujui');

        } catch (\Exception $e) {
            \DB::rollback();
            return redirect()->back()->with('error', 'Terjadi kesalahan saat mengkonfirmasi pembayaran.');
        }
    }

    /**
     * Reject payment
     */
    public function reject(Pembayaran $pembayaran)
    {
        try {
            \DB::beginTransaction();

            $pembayaran->update([
                'status_pembayaran' => 'ditolak',
                'tanggal_konfirmasi' => now(),
                'admin_konfirmasi' => auth()->id()
            ]);

            // Update booking status to 'ditolak' when payment is rejected
            $booking = $pembayaran->booking;
            $booking->update([
                'status' => 'ditolak'
            ]);

            // Update status kendaraan berdasarkan ketersediaan (unit tidak berubah)
            $kendaraan = $booking->kendaraan;

            \DB::commit();

            return redirect()->route('admin.pembayaran.index')
                ->with('success', 'Pembayaran berhasil ditolak dan booking ditolak');

        } catch (\Exception $e) {
            \DB::rollback();
            return redirect()->back()->with('error', 'Terjadi kesalahan saat menolak pembayaran.');
        }
    }
}