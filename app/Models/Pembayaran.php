<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pembayaran extends Model
{
    use HasFactory;

    protected $table = 'pembayaran';
    protected $primaryKey = 'id_pembayaran';

    protected $fillable = [
        'id_booking',
        'jumlah_bayar',
        'metode_pembayaran',
        'bukti_pembayaran',
        'tanggal_bayar',
        'status_pembayaran',
        'tanggal_konfirmasi',
        'admin_konfirmasi',
        'catatan_admin'
    ];

    protected $casts = [
        'jumlah_bayar' => 'decimal:2',
        'tanggal_bayar' => 'datetime',
        'tanggal_konfirmasi' => 'datetime'
    ];

    // Relasi ke booking
    public function booking()
    {
        return $this->belongsTo(Booking::class, 'id_booking', 'id_booking');
    }

    // Relasi ke admin yang mengkonfirmasi
    public function admin()
    {
        return $this->belongsTo(User::class, 'admin_konfirmasi');
    }
}
