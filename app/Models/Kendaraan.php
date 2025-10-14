<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kendaraan extends Model
{
    use HasFactory;

    protected $table = 'kendaraan';
    protected $primaryKey = 'id_kendaraan';

    protected $fillable = [
        'merek',
        'model',
        'tahun',
        'warna',
        'jml_kursi',
        'foto_kendaraan',
        'harga_sewa_per_jam',
        'deskripsi',
        'spesifikasi',
        'jumlah_unit',
        'status'
    ];

    protected $casts = [
        'harga_sewa_per_jam' => 'decimal:2',
        'tahun' => 'integer',
        'jumlah_kursi' => 'integer',
        'jumlah_unit' => 'integer'
    ];

    // Relasi ke booking
    public function booking()
    {
        return $this->hasMany(Booking::class, 'id_kendaraan', 'id_kendaraan');
    }

    // Relasi ke bookings (alias untuk konsistensi)
    public function bookings()
    {
        return $this->hasMany(Booking::class, 'id_kendaraan', 'id_kendaraan');
    }

    // Method untuk mengecek ketersediaan kendaraan
    public function isAvailable()
    {
        // Kendaraan tersedia jika jumlah unit > 0
        return $this->jumlah_unit > 0;
    }

    // Method untuk mendapatkan jumlah unit yang tersedia
    public function getAvailableUnits()
    {
        $activeBookings = $this->bookings()
            ->where('status', 'disetujui')
            ->where('tgl_selesai', '>=', now())
            ->count();

        return max(0, $this->jumlah_unit - $activeBookings);
    }

    // Accessor untuk status ketersediaan
    public function getKetersediaanAttribute()
    {
        return $this->jumlah_unit > 0 ? 'TERSEDIA' : 'TIDAK TERSEDIA';
    }
}