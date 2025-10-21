<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Jalankan migrasi
     */
    public function up(): void
    {
        Schema::table('pemeliharaans', function (Blueprint $table) {
            // Pastikan nama tabel sesuai di database kamu
            $table->decimal('biaya_operasional', 15, 2)->nullable()->after('keterangan');
        });
    }

    /**
     * Rollback migrasi (hapus kolom jika dibatalkan)
     */
    public function down(): void
    {
        Schema::table('pemeliharaans', function (Blueprint $table) {
            $table->dropColumn('biaya_operasional');
        });
    }
};
