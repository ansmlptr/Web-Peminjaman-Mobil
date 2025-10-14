<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('kendaraan', function (Blueprint $table) {
            $table->id('id_kendaraan');
            $table->string('merek', 50);
            $table->string('model', 50);
            $table->year('tahun');
            $table->string('warna', 30);
            $table->integer('jml_kursi');
            $table->text('deskripsi')->nullable();
            $table->text('spesifikasi')->nullable();
            $table->string('foto_kendaraan')->nullable();
            $table->decimal('harga_sewa_per_jam', 12, 2);
            $table->integer('jumlah_unit')->default(1);
            $table->enum('status', ['published', 'unpublished'])->default('published');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kendaraan');
    }
};