<?php

namespace Database\Seeders;

use App\Models\Kabupaten;
use App\Models\Kecamatan;
use Illuminate\Database\Seeder;

class WilayahSeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            'Kota Semarang' => [
                'Banyumanik', 'Candisari', 'Gajahmungkur', 'Gayamsari',
                'Genuk', 'Gunungpati', 'Mijen', 'Ngaliyan', 'Pedurungan',
                'Semarang Barat', 'Semarang Selatan', 'Semarang Tengah',
                'Semarang Timur', 'Semarang Utara', 'Tembalang', 'Tugu',
            ],
            'Kabupaten Semarang' => [
                'Ambarawa', 'Bancak', 'Bandungan', 'Bawen', 'Bergas',
                'Bringin', 'Getasan', 'Jambu', 'Kaliwungu', 'Pabelan',
                'Pringapus', 'Suruh', 'Susukan', 'Tengaran', 'Tuntang', 'Ungaran Barat', 'Ungaran Timur',
            ],
            'Kabupaten Demak' => [
                'Bonang', 'Demak', 'Dempet', 'Gajah', 'Guntur',
                'Karangawen', 'Karanganyar', 'Kebonagung', 'Mijen', 'Mranggen',
                'Sayung', 'Wedung', 'Wonosalam',
            ],
            'Kabupaten Kendal' => [
                'Boja', 'Brangsong', 'Cepiring', 'Gemuh', 'Kaliwungu',
                'Kendal', 'Limbangan', 'Ngampel', 'Pagerruyung', 'Patean',
                'Patebon', 'Pegandon', 'Plantungan', 'Ringinarum', 'Rowosari',
                'Singorojo', 'Sukorejo', 'Weleri',
            ],
            'Kota Salatiga' => [
                'Argomulyo', 'Sidomukti', 'Sidorejo', 'Tingkir',
            ],
            'Kabupaten Grobogan' => [
                'Brati', 'Gabus', 'Geyer', 'Godong', 'Grobogan',
                'Gubug', 'Karangrayung', 'Kedungjati', 'Klambu', 'Ngaringan',
                'Penawangan', 'Pulokulon', 'Purwodadi', 'Tawangharjo',
                'Toroh', 'Wirosari',
            ],
            'Kabupaten Boyolali' => [
                'Ampel', 'Andong', 'Banyudono', 'Boyolali', 'Cepogo',
                'Juwangi', 'Karanggede', 'Kemusu', 'Klego', 'Mojosongo',
                'Musuk', 'Ngemplak', 'Nogosari', 'Sambi', 'Sawit',
                'Selo', 'Simo', 'Teras', 'Wonosegoro',
            ],
        ];

        foreach ($data as $kabNama => $kecamatans) {
            $kabupaten = Kabupaten::create(['nama' => $kabNama]);
            foreach ($kecamatans as $kec) {
                Kecamatan::create([
                    'kabupaten_id' => $kabupaten->id,
                    'nama'         => $kec,
                ]);
            }
        }
    }
}
