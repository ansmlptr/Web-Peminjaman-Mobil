<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Kendaraan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;

class BookingController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:customer');
    }


    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id_kendaraan' => 'required|exists:kendaraan,id_kendaraan',
            'waktu_mulai' => 'required|date|after_or_equal:now',
            'waktu_selesai' => 'required|date|after:waktu_mulai',
            'tujuan' => 'required|string|max:255',
            'catatan' => 'nullable|string|max:500',
        ], [
            'id_kendaraan.required' => 'Kendaraan wajib dipilih.',
            'id_kendaraan.exists' => 'Kendaraan tidak ditemukan.',
            'waktu_mulai.required' => 'Waktu mulai wajib diisi.',
            'waktu_mulai.date' => 'Format waktu mulai tidak valid.',
            'waktu_mulai.after_or_equal' => 'Waktu mulai tidak boleh kurang dari sekarang.',
            'waktu_selesai.required' => 'Waktu selesai wajib diisi.',
            'waktu_selesai.date' => 'Format waktu selesai tidak valid.',
            'waktu_selesai.after' => 'Waktu selesai harus setelah waktu mulai.',
            'tujuan.required' => 'Tujuan penggunaan wajib diisi.',
            'tujuan.max' => 'Tujuan penggunaan maksimal 255 karakter.',
            'catatan.max' => 'Catatan maksimal 500 karakter.',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $kendaraan = Kendaraan::findOrFail($request->id_kendaraan);


        // Cek ketersediaan unit
        if (!$kendaraan->isAvailable()) {
            return back()->withErrors(['id_kendaraan' => 'Kendaraan tidak tersedia atau unit sudah habis.'])->withInput();
        }

        $startDateTime = Carbon::parse($request->waktu_mulai);
        $endDateTime = Carbon::parse($request->waktu_selesai);

        // Cek booking bentrok
        $conflictingBooking = Booking::where('id_kendaraan', $request->id_kendaraan)
            ->where('status', '!=', 'ditolak')
            ->where(function ($query) use ($startDateTime, $endDateTime) {
                $query->where(function ($q) use ($startDateTime, $endDateTime) {
                    $q->where('tgl_mulai', '<=', $endDateTime)
                        ->where('tgl_selesai', '>=', $startDateTime);
                });
            })
            ->exists();

        if ($conflictingBooking) {
            return back()->withErrors(['waktu_mulai' => 'Kendaraan sudah dibooking pada waktu tersebut.'])->withInput();
        }

        $durationInHours = $startDateTime->diffInHours($endDateTime, true);
        $billingHours = ceil($durationInHours);
        $hargaPerJam = $kendaraan->harga_sewa_per_jam;
        $totalHarga = $billingHours * $hargaPerJam;

        $dataBooking = [
            'id_customer' => Auth::guard('customer')->id(),
            'id_kendaraan' => $request->id_kendaraan,
            'tgl_mulai' => $startDateTime,
            'tgl_selesai' => $endDateTime,
            'durasi_jam' => $billingHours,
            'tujuan' => $request->tujuan,
            'catatan' => $request->catatan,
            'total_harga' => $totalHarga,
            'status' => 'menunggu_pembayaran',
        ];

        Booking::create($dataBooking);

        return redirect()->route('user.history')
            ->with('success', 'Booking berhasil dibuat. Silakan upload bukti pembayaran di halaman riwayat pemesanan.');
    }



    public function history(Request $request)
    {
        $query = Booking::with(['kendaraan', 'customer', 'pembayaran'])
            ->where('id_customer', Auth::guard('customer')->id());

        $bookings = $query->orderBy('created_at', 'desc')->paginate(10)->withQueryString();

        // Get booking statistics
        $stats = [
            'total' => Booking::where('id_customer', Auth::guard('customer')->id())->count(),
            'pending' => Booking::where('id_customer', Auth::guard('customer')->id())->where('status', 'menunggu_pembayaran')->count(),
            'paid' => Booking::where('id_customer', Auth::guard('customer')->id())->where('status', 'dibayar')->count(),
            'approved' => Booking::where('id_customer', Auth::guard('customer')->id())->where('status', 'disetujui')->count(),
            'completed' => Booking::where('id_customer', Auth::guard('customer')->id())->where('status', 'selesai')->count(),
            'rejected' => Booking::where('id_customer', Auth::guard('customer')->id())->where('status', 'ditolak')->count(),
        ];

        return view('user.history.index', compact('bookings', 'stats'));
    }

    public function show($id)
    {
        $booking = Booking::with(['kendaraan', 'customer', 'pembayaran'])
            ->where('id_customer', Auth::guard('customer')->id())
            ->findOrFail($id);

        return response()->json($booking);
    }
}