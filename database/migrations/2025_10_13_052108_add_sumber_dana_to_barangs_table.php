<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('barangs', function (Blueprint $table) {
            $table->string('sumber_dana')->nullable()->after('kondisi'); 
            // sesuaikan "after('harga')" dengan kolom terakhir di tabel kamu
        });
    }

    public function down(): void
    {
        Schema::table('barangs', function (Blueprint $table) {
            $table->dropColumn('sumber_dana');
        });
    }
};
