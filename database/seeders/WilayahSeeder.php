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
            'Ambarawa',
            'Bancak',
            'Bandungan',
            'Bawen',
            'Bergas',
            'Bringin',
            'Getasan',
            'Jambu',
            'Kaliwungu',
            'Pabelan',
            'Pringapus',
            'Sumowono',
            'Suruh',
            'Susukan',
            'Tengaran',
            'Tuntang',
            'Ungaran Barat',
            'Ungaran Timur',
        ];

        foreach ($kecamatans as $nama) {
            Kecamatan::create([
                'kabupaten_id' => $kabupaten->id,
                'nama'         => $nama,
            ]);
        }
    }
}