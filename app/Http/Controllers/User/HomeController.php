<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Kendaraan;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        // Update status semua kendaraan berdasarkan ketersediaan
        $allVehicles = Kendaraan::all();

        // Get popular vehicles (limit 6) - hanya yang published
        $popularVehicles = Kendaraan::where('status', 'published')
            ->orderBy('created_at', 'desc')
            ->limit(6)
            ->get();

        // Get vehicle statistics
        $vehicleStats = [
            'total' => Kendaraan::count(),
            'available' => Kendaraan::where('status', 'published')->count(),
            'brands' => Kendaraan::distinct('merek')->count()
        ];

        return view('user.home', compact('popularVehicles', 'vehicleStats'));
    }
}