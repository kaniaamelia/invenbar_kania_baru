<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    public function up(): void
    {
        DB::statement("ALTER TABLE pemeliharaan MODIFY COLUMN status ENUM('Pemeriksaan', 'Pembersihan', 'Selesai') DEFAULT 'Pemeriksaan'");
    }

    public function down(): void
    {
        DB::statement("ALTER TABLE pemeliharaan MODIFY COLUMN status ENUM('Pemeriksaan', 'Pembersihan') DEFAULT 'Pemeriksaan'");
    }
};

