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
        Schema::create('booking', function (Blueprint $table) {
            $table->id('id_booking');
            $table->unsignedBigInteger('id_customer');
            $table->unsignedBigInteger('id_kendaraan');
            $table->datetime('tgl_mulai');
            $table->datetime('tgl_selesai');
            $table->integer('durasi_jam');
            $table->string('tujuan');
            $table->text('catatan')->nullable();
            $table->decimal('total_harga', 15, 2);
            $table->enum('status', ['menunggu_pembayaran', 'dibayar', 'disetujui', 'ditolak', 'selesai'])->default('menunggu_pembayaran');
            $table->timestamps();

            // Foreign key constraints
            $table->foreign('id_customer')->references('id')->on('customers')->onDelete('cascade');
            $table->foreign('id_kendaraan')->references('id_kendaraan')->on('kendaraan')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('booking');
    }
};