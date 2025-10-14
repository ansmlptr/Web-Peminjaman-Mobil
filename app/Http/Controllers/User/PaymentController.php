<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Pembayaran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class PaymentController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:customer');
    }

    public function index($id_booking)
    {
        $booking = Booking::with(['kendaraan', 'pembayaran'])
            ->where('id_customer', Auth::guard('customer')->id())
            ->findOrFail($id_booking);

        return view('user.pembayaran.index', compact('booking'));
    }

    public function store(Request $request, $id_booking)
    {
        $booking = Booking::where('id_customer', Auth::guard('customer')->id())
            ->findOrFail($id_booking);

        // Cegah double payment
        if ($booking->pembayaran) {
            return back()->withErrors(['general' => 'Pembayaran sudah pernah diupload.']);
        }

        $validator = Validator::make($request->all(), [
            'jumlah_bayar' => 'required|numeric|min:' . $booking->total_harga,
            'metode_pembayaran' => 'required|string|max:100',
            'tanggal_bayar' => 'required|date|before_or_equal:today',
            'bukti_pembayaran' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ], [
            'jumlah_bayar.required' => 'Jumlah bayar wajib diisi.',
            'jumlah_bayar.numeric' => 'Jumlah bayar harus berupa angka.',
            'jumlah_bayar.min' => 'Jumlah bayar minimal Rp ' . number_format($booking->total_harga, 0, ',', '.'),
            'metode_pembayaran.required' => 'Metode pembayaran wajib diisi.',
            'tanggal_bayar.required' => 'Tanggal bayar wajib diisi.',
            'tanggal_bayar.date' => 'Format tanggal bayar tidak valid.',
            'tanggal_bayar.before_or_equal' => 'Tanggal bayar tidak boleh lebih dari hari ini.',
            'bukti_pembayaran.required' => 'Bukti pembayaran wajib diupload.',
            'bukti_pembayaran.image' => 'Bukti pembayaran harus berupa gambar.',
            'bukti_pembayaran.mimes' => 'Format bukti pembayaran harus jpeg, png, atau jpg.',
            'bukti_pembayaran.max' => 'Ukuran bukti pembayaran maksimal 2MB.',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        // Simpan file bukti
        $buktiPath = $request->file('bukti_pembayaran')->store('bukti_pembayaran', 'public');

        // Buat record pembayaran
        Pembayaran::create([
            'id_booking' => $id_booking,
            'jumlah_bayar' => $request->jumlah_bayar,
            'metode_pembayaran' => $request->metode_pembayaran,
            'tanggal_bayar' => $request->tanggal_bayar,
            'bukti_pembayaran' => $buktiPath,
            'status_pembayaran' => 'menunggu_konfirmasi',
        ]);

        // Update booking status to 'dibayar'
        $booking->update([
            'status' => 'dibayar'
        ]);

        return back()->with('success', 'Bukti pembayaran berhasil diupload. Menunggu verifikasi admin.');
    }





    public function showProof($id_booking)
    {
        $booking = Booking::where('id_customer', Auth::guard('customer')->id())
            ->findOrFail($id_booking);

        $pembayaran = $booking->pembayaran;
        if (!$pembayaran || !$pembayaran->bukti_pembayaran) {
            abort(404, 'Bukti pembayaran tidak ditemukan.');
        }

        $path = storage_path('app/public/' . $pembayaran->bukti_pembayaran);
        if (!file_exists($path)) {
            abort(404, 'File bukti pembayaran tidak ditemukan.');
        }

        return response()->file($path);
    }
}