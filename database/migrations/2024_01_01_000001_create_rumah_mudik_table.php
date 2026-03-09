<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('rumah_mudik', function (Blueprint $table) {
            $table->id();
            $table->string('nik', 16)->index(); // NIK sebagai key pencarian (bisa duplikat untuk 2+ rumah)
            $table->string('nama_pemilik');
            $table->decimal('latitude', 10, 8);
            $table->decimal('longitude', 11, 8);
            $table->text('alamat_lengkap');
            $table->string('rt', 5);
            $table->string('rw', 5);
            $table->string('kabupaten');
            $table->string('kecamatan');
            $table->date('tanggal_mulai_mudik');
            $table->date('tanggal_selesai_mudik');
            $table->string('foto_rumah')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('rumah_mudik');
    }
};