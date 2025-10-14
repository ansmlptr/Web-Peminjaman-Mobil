<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('pembayaran', function (Blueprint $table) {
            $table->id('id_pembayaran');
            $table->unsignedBigInteger('id_booking');
            $table->foreign('id_booking')->references('id_booking')->on('booking')->onDelete('cascade');

            // Detail Pembayaran
            $table->decimal('jumlah_bayar', 12, 2);
            $table->enum('metode_pembayaran', ['transfer_bca', 'transfer_mandiri', 'transfer_bni', 'transfer_bri']);
            $table->string('bukti_pembayaran')->nullable(); // path file bukti transfer
            $table->datetime('tanggal_bayar')->nullable();

            // Status & Konfirmasi
            $table->enum('status_pembayaran', ['pending', 'menunggu_konfirmasi', 'dikonfirmasi', 'ditolak'])->default('pending');
            $table->datetime('tanggal_konfirmasi')->nullable();
            $table->foreignId('admin_konfirmasi')->nullable()->constrained('users')->onDelete('set null');
            $table->text('catatan_admin')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pembayaran');
    }
};
