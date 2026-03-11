<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('rumah_mudik', function (Blueprint $table) {
            // Tambahkan setelah kolom kecamatan
            // nullable() agar tidak error pada baris data yang sudah ada
            $table->string('kelurahan')->nullable()->after('kecamatan');
        });
    }

    public function down(): void
    {
        Schema::table('rumah_mudik', function (Blueprint $table) {
            $table->dropColumn('kelurahan');
        });
    }
};