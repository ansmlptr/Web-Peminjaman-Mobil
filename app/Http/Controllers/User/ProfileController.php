<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\Booking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class ProfileController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:customer');
    }

    public function index()
    {
        $user = Auth::guard('customer')->user();

        // Get user booking statistics
        $bookingStats = [
            'total' => Booking::where('id_customer', $user->id)->count(),
            'pending' => Booking::where('id_customer', $user->id)->where('status', 'menunggu_pembayaran')->count(),
            'approved' => Booking::where('id_customer', $user->id)->where('status', 'disetujui')->count(),
            'completed' => Booking::where('id_customer', $user->id)->where('status', 'selesai')->count(),
        ];

        return view('user.profile.index', compact('user', 'bookingStats'));
    }

    public function updateProfile(Request $request)
    {
        $user = Auth::guard('customer')->user();

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                Rule::unique('customers')->ignore($user->id),
            ],
            'no_hp' => [
                'required',
                'string',
                'max:15',
                Rule::unique('customers')->ignore($user->id),
            ],
            'alamat' => 'required|string|max:500',
        ], [
            'name.required' => 'Nama lengkap wajib diisi.',
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'email.unique' => 'Email sudah digunakan.',
            'no_hp.required' => 'Nomor telepon wajib diisi.',
            'no_hp.unique' => 'Nomor telepon sudah digunakan.',
            'alamat.required' => 'Alamat wajib diisi.',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'no_hp' => $request->no_hp,
            'alamat' => $request->alamat,
        ]);

        return back()->with('success', 'Profil berhasil diperbarui.');
    }
}