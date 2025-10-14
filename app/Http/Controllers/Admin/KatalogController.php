<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Kendaraan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class KatalogController extends Controller
{
    public function index()
    {
        $kendaraans = Kendaraan::all();
        return view('admin.katalog.index', compact('kendaraans'));
    }

    public function create()
    {
        $action = 'tambah';
        $kendaraan = null;
        return view('admin.katalog.form', compact('action', 'kendaraan'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'merek' => 'required|string|max:50',
            'model' => 'required|string|max:50',
            'tahun' => 'required|integer|min:1990|max:' . date('Y'),
            'warna' => 'required|string|max:30',
            'jml_kursi' => 'required|integer|min:2|max:50',
            'jumlah_unit' => 'required|integer|min:0',
            'harga_sewa_per_jam' => 'required|numeric|min:0',
            'status' => 'required|in:published,unpublished',
            'deskripsi' => 'required|string|max:500',
            'spesifikasi' => 'required|string|max:1000',
            'foto_kendaraan' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ], [
            'merek.required' => 'Merek kendaraan wajib diisi.',
            'model.required' => 'Model kendaraan wajib diisi.',
            'tahun.required' => 'Tahun kendaraan wajib diisi.',
            'tahun.integer' => 'Tahun harus berupa angka.',
            'tahun.min' => 'Tahun minimal 1990.',
            'tahun.max' => 'Tahun maksimal ' . date('Y') . '.',
            'warna.required' => 'Warna kendaraan wajib diisi.',
            'jml_kursi.required' => 'Jumlah kursi wajib diisi.',
            'jml_kursi.integer' => 'Jumlah kursi harus berupa angka.',
            'jml_kursi.min' => 'Jumlah kursi minimal 2.',
            'jml_kursi.max' => 'Jumlah kursi maksimal 50.',
            'jumlah_unit.required' => 'Jumlah unit wajib diisi.',
            'jumlah_unit.integer' => 'Jumlah unit harus berupa angka.',
            'jumlah_unit.min' => 'Jumlah unit minimal 0.',
            'harga_sewa_per_jam.required' => 'Harga sewa per jam wajib diisi.',
            'harga_sewa_per_jam.numeric' => 'Harga sewa per jam harus berupa angka.',
            'harga_sewa_per_jam.min' => 'Harga sewa per jam minimal 0.',
            'status.required' => 'Status kendaraan wajib dipilih.',
            'status.in' => 'Status harus published atau unpublished.',
            'deskripsi.required' => 'Deskripsi kendaraan wajib diisi.',
            'deskripsi.max' => 'Deskripsi maksimal 500 karakter.',
            'spesifikasi.required' => 'Spesifikasi kendaraan wajib diisi.',
            'spesifikasi.max' => 'Spesifikasi maksimal 1000 karakter.',
            'foto_kendaraan.image' => 'Foto kendaraan harus berupa gambar.',
            'foto_kendaraan.mimes' => 'Format foto kendaraan harus jpeg, png, jpg, atau gif.',
            'foto_kendaraan.max' => 'Ukuran foto kendaraan maksimal 2MB.'
        ]);

        $data = $request->all();

        // Handle file upload
        if ($request->hasFile('foto_kendaraan')) {
            $file = $request->file('foto_kendaraan');
            if ($file->isValid()) {
                $filename = time() . '_' . $file->getClientOriginalName();
                $filePath = $file->storeAs('kendaraan', $filename, 'public');
                $data['foto_kendaraan'] = $filename;
            } else {
                return redirect()->back()->withErrors(['foto_kendaraan' => 'File foto tidak valid'])->withInput();
            }
        }

        $kendaraan = Kendaraan::create($data);

        return redirect()->route('admin.katalog.index')->with('success', 'Data kendaraan berhasil ditambahkan!');
    }

    public function edit($id)
    {
        $action = 'edit';
        $kendaraan = Kendaraan::findOrFail($id);
        return view('admin.katalog.form', compact('action', 'kendaraan'));
    }

    public function update(Request $request, $id)
    {
        $kendaraan = Kendaraan::findOrFail($id);

        $request->validate([
            'merek' => 'required|string|max:50',
            'model' => 'required|string|max:50',
            'tahun' => 'required|integer|min:1990|max:' . date('Y'),
            'warna' => 'required|string|max:30',
            'jml_kursi' => 'required|integer|min:2|max:50',
            'jumlah_unit' => 'required|integer|min:0',
            'harga_sewa_per_jam' => 'required|numeric|min:0',
            'status' => 'required|in:published,unpublished',
            'deskripsi' => 'required|string|max:500',
            'spesifikasi' => 'required|string|max:1000',
            'foto_kendaraan' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ], [
            'merek.required' => 'Merek kendaraan wajib diisi.',
            'model.required' => 'Model kendaraan wajib diisi.',
            'tahun.required' => 'Tahun kendaraan wajib diisi.',
            'tahun.integer' => 'Tahun harus berupa angka.',
            'tahun.min' => 'Tahun minimal 1990.',
            'tahun.max' => 'Tahun maksimal ' . date('Y') . '.',
            'warna.required' => 'Warna kendaraan wajib diisi.',
            'jml_kursi.required' => 'Jumlah kursi wajib diisi.',
            'jml_kursi.integer' => 'Jumlah kursi harus berupa angka.',
            'jml_kursi.min' => 'Jumlah kursi minimal 2.',
            'jml_kursi.max' => 'Jumlah kursi maksimal 50.',
            'jumlah_unit.required' => 'Jumlah unit wajib diisi.',
            'jumlah_unit.integer' => 'Jumlah unit harus berupa angka.',
            'jumlah_unit.min' => 'Jumlah unit minimal 0.',
            'harga_sewa_per_jam.required' => 'Harga sewa per jam wajib diisi.',
            'harga_sewa_per_jam.numeric' => 'Harga sewa per jam harus berupa angka.',
            'harga_sewa_per_jam.min' => 'Harga sewa per jam minimal 0.',
            'status.required' => 'Status kendaraan wajib dipilih.',
            'status.in' => 'Status harus published atau unpublished.',
            'deskripsi.required' => 'Deskripsi kendaraan wajib diisi.',
            'deskripsi.max' => 'Deskripsi maksimal 500 karakter.',
            'spesifikasi.required' => 'Spesifikasi kendaraan wajib diisi.',
            'spesifikasi.max' => 'Spesifikasi maksimal 1000 karakter.',
            'foto_kendaraan.image' => 'Foto kendaraan harus berupa gambar.',
            'foto_kendaraan.mimes' => 'Format foto kendaraan harus jpeg, png, jpg, atau gif.',
            'foto_kendaraan.max' => 'Ukuran foto kendaraan maksimal 2MB.'
        ]);

        $data = $request->all();

        // Handle file upload
        if ($request->hasFile('foto_kendaraan')) {
            $file = $request->file('foto_kendaraan');
            if ($file->isValid()) {
                // Delete old image if exists
                if ($kendaraan->foto_kendaraan && Storage::disk('public')->exists('kendaraan/' . $kendaraan->foto_kendaraan)) {
                    Storage::disk('public')->delete('kendaraan/' . $kendaraan->foto_kendaraan);
                }

                $filename = time() . '_' . $file->getClientOriginalName();
                $filePath = $file->storeAs('kendaraan', $filename, 'public');
                $data['foto_kendaraan'] = $filename;
            } else {
                return redirect()->back()->withErrors(['foto_kendaraan' => 'File foto tidak valid'])->withInput();
            }
        }

        $kendaraan->update($data);

        return redirect()->route('admin.katalog.index')->with('success', 'Data kendaraan berhasil diupdate!');
    }

    public function destroy($id)
    {
        $kendaraan = Kendaraan::findOrFail($id);

        // Delete image if exists
        if ($kendaraan->foto_kendaraan && Storage::disk('public')->exists('kendaraan/' . $kendaraan->foto_kendaraan)) {
            Storage::disk('public')->delete('kendaraan/' . $kendaraan->foto_kendaraan);
        }

        $kendaraan->delete();

        return redirect()->route('admin.katalog.index')->with('success', 'Data kendaraan berhasil dihapus!');
    }
}