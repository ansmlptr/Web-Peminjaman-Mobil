<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Kendaraan;
use Illuminate\Http\Request;

class KatalogController extends Controller
{
    public function index(Request $request)
    {
        // Update status semua kendaraan berdasarkan ketersediaan
        $allVehicles = Kendaraan::all();

        $query = Kendaraan::query();

        // Search filter
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('merek', 'like', "%{$search}%")
                    ->orWhere('model', 'like', "%{$search}%")
                    ->orWhere('deskripsi', 'like', "%{$search}%");
            });
        }

        // Category filter
        if ($request->filled('kategori')) {
            $query->where('merek', $request->kategori);
        }

        // Price range filter
        if ($request->filled('harga')) {
            $priceRange = $request->harga;
            if (strpos($priceRange, '-') !== false) {
                list($minPrice, $maxPrice) = explode('-', $priceRange);
                $query->where('harga_sewa_per_jam', '>=', (int) $minPrice)
                    ->where('harga_sewa_per_jam', '<=', (int) $maxPrice);
            }
        } elseif ($request->filled('min_price') || $request->filled('max_price')) {
            if ($request->filled('min_price')) {
                $query->where('harga_sewa_per_jam', '>=', $request->min_price);
            }
            if ($request->filled('max_price')) {
                $query->where('harga_sewa_per_jam', '<=', $request->max_price);
            }
        }

        // Filter berdasarkan transmisi - removed (column doesn't exist)

        // Status filter (only show published by default)
        $query->where('status', 'published');

        // Sorting
        $sortBy = $request->get('sort_by', 'created_at');
        $sortOrder = $request->get('sort_order', 'desc');

        switch ($sortBy) {
            case 'price_low':
                $query->orderBy('harga_sewa_per_jam', 'asc');
                break;
            case 'price_high':
                $query->orderBy('harga_sewa_per_jam', 'desc');
                break;
            case 'name':
                $query->orderBy('merek', 'asc');
                break;
            case 'year':
                $query->orderBy('tahun', 'desc');
                break;
            default:
                $query->orderBy('created_at', 'desc');
        }

        // Pagination
        $kendaraans = $query->paginate(12)->withQueryString();

        // Get filter options
        $categories = Kendaraan::distinct('merek')->pluck('merek');
        $priceRange = [
            'min' => Kendaraan::min('harga_sewa_per_jam'),
            'max' => Kendaraan::max('harga_sewa_per_jam')
        ];

        return view('user.katalog.index', compact(
            'kendaraans',
            'categories',
            'priceRange'
        ));
    }

    public function detail($id)
    {
        $kendaraan = Kendaraan::findOrFail($id);

        // Get related vehicles (same category, different vehicle)
        $relatedVehicles = Kendaraan::where('merek', $kendaraan->merek)
            ->where('id_kendaraan', '!=', $id)
            ->where('status', 'published')
            ->limit(4)
            ->get();

        return view('user.katalog.detail', compact('kendaraan', 'relatedVehicles'));
    }
}