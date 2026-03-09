<?php

namespace Database\Seeders;

use App\Models\Kabupaten;
use App\Models\Kecamatan;
use Illuminate\Database\Seeder;

class WilayahSeeder extends Seeder
{
    public function run(): void
    {
        // Hapus data lama jika ada (PostgreSQL syntax)
        \DB::statement('TRUNCATE TABLE kecamatan, kabupaten RESTART IDENTITY CASCADE');

        $kabupaten = Kabupaten::create(['nama' => 'Kabupaten Semarang']);

        $kecamatans = [
            'Tugu',
            'Tembalang',
            'Semarang Utara',
            'Semarang Timur',
            'Semarang Tengah',
            'Semarang Selatan',
            'Semarang Barat',
            'Pedurungan',
            'Ngaliyan',
            'Mijen',
            'Gunung Pati',
            'Genuk',
            'Gayamsari',
            'Gajahmungkur',
            'Candisari',
            'Banyumanik',
        ];

        foreach ($kecamatans as $nama) {
            Kecamatan::create([
                'kabupaten_id' => $kabupaten->id,
                'nama'         => $nama,
            ]);
        }
    }
}