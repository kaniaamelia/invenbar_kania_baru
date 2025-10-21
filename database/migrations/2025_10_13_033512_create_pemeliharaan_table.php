<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pemeliharaan', function (Blueprint $table) {
            $table->id();
            $table->foreignId('barang_id')
                  ->constrained('barangs')
                  ->onDelete('cascade');
            $table->date('tanggal');
            $table->text('keterangan')->nullable();
            $table->enum('jenis', ['Rutin', 'Darurat', 'Perbaikan'])->default('Rutin');
            $table->enum('status', ['Pemeriksaan', 'Pembersihan'])->default('Pemeriksaan');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pemeliharaan');
    }
};
