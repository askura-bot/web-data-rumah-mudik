<?php
// database/seeders/WilayahSeeder.php
namespace Database\Seeders;

use App\Models\Kabupaten;
use App\Models\Kecamatan;
use App\Models\Kelurahan;
use Illuminate\Database\Seeder;

class WilayahSeeder extends Seeder
{
    public function run(): void
    {
        \DB::statement('TRUNCATE TABLE kelurahan, kecamatan, kabupaten RESTART IDENTITY CASCADE');

        $kabupaten = Kabupaten::create(['nama' => 'Kabupaten Semarang']);

        // Data kelurahan/desa per kecamatan — Kabupaten Semarang
        $wilayah = [
            'Tugu' => [
                'Karangayar', 'Randugarut'
            ],
            'Ungaran Barat' => [
                'Ungaran', 'Lerep', 'Candirejo', 'Nyatnyono', 'Genuk',
                'Gogik', 'Kalisidi', 'Branjang',
            ],
            'Ungaran Timur' => [
                'Gedanganak', 'Beji', 'Leyangan', 'Sidomulyo', 'Kalirejo',
                'Kalongan', 'Susukan',
            ],
            'Bergas' => [
                'Bergas Lor', 'Bergas Kidul', 'Randugunting', 'Diwak',
                'Gebugan', 'Pagersari', 'Wringinputih', 'Ngempon',
                'Munding', 'Gondoriyo',
            ],
            'Pringapus' => [
                'Pringapus', 'Klepu', 'Wonoyoso', 'Candirejo', 'Pringsari',
                'Jatirunggo', 'Penawangan', 'Bumirejo',
            ],
            'Bawen' => [
                'Bawen', 'Harjosari', 'Lemahireng', 'Asinan', 'Polosiri',
                'Poncoruso', 'Kandangan', 'Doplang',
            ],
            'Ambarawa' => [
                'Ambarawa', 'Lodoyong', 'Kupang', 'Panjang', 'Pojoksari',
                'Tambakboyo', 'Ngampin', 'Kranggan', 'Bejalen', 'Bandungan',
            ],
            'Bandungan' => [
                'Bandungan', 'Sidomukti', 'Pakopen', 'Kenteng', 'Jetis',
                'Duren', 'Banyukuning', 'Mlilir',
            ],
            'Sumowono' => [
                'Sumowono', 'Lanjan', 'Candigaron', 'Kemitir', 'Ngadikerso',
                'Trayu', 'Duren', 'Jubelan', 'Bumen', 'Mendongan',
                'Pledokan', 'Piyanggang',
            ],
            'Jambu' => [
                'Jambu', 'Genting', 'Kebondalem', 'Kelurahan', 'Bedono',
                'Rejosari', 'Kuwarasan', 'Gondoriyo', 'Brongkol',
            ],
            'Banyubiru' => [
                'Banyubiru', 'Kebondowo', 'Kemambang', 'Tegaron',
                'Rowoboni', 'Wirogomo', 'Sepakung', 'Gedong',
            ],
            'Tuntang' => [
                'Tuntang', 'Kesongo', 'Candirejo', 'Sraten', 'Watuagung',
                'Karangtengah', 'Jombor', 'Gading', 'Semowo', 'Ngempon',
                'Rowosari', 'Polobogo',
            ],
            'Getasan' => [
                'Getasan', 'Manggihan', 'Polobogo', 'Wates', 'Kopeng',
                'Batur', 'Tolokan', 'Jetak', 'Sumogawe', 'Tajuk',
                'Nogosaren', 'Samirono', 'Ngrawan',
            ],
            'Tengaran' => [
                'Tengaran', 'Sruwen', 'Karangduren', 'Cukil', 'Duren',
                'Barukan', 'Butuh', 'Klero', 'Regunung', 'Patemon',
                'Tegalwaton', 'Nyamat',
            ],
            'Susukan' => [
                'Susukan', 'Timpik', 'Muncar', 'Bakalrejo', 'Koripan',
                'Ketapang', 'Gentan', 'Badran', 'Kemetul',
            ],
            'Suruh' => [
                'Suruh', 'Plumbon', 'Cukilan', 'Dadapayam', 'Kebowan',
                'Jatirejo', 'Krandon Lor', 'Medayu', 'Congol', 'Tegalwaton',
                'Gunung Tumpeng', 'Bonomerto', 'Purworejo', 'Reksosari',
                'Dersansari', 'Ngrawan',
            ],
            'Pabelan' => [
                'Pabelan', 'Semowo', 'Segiri', 'Kauman Lor', 'Kadirejo',
                'Padaan', 'Tukang', 'Giling', 'Bendungan', 'Terban',
                'Glawan',
            ],
        ];

        foreach ($wilayah as $namaKec => $kelurahans) {
            $kecamatan = Kecamatan::create([
                'kabupaten_id' => $kabupaten->id,
                'nama'         => $namaKec,
            ]);

            foreach ($kelurahans as $namaKel) {
                Kelurahan::create([
                    'kecamatan_id' => $kecamatan->id,
                    'nama'         => $namaKel,
                ]);
            }
        }
    }
}