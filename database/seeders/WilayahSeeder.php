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
                'Karanganyar', 'Randugarut','Mangkang Wetan', 'Tugurejo', 'Mangkang Kulon','Jerakah','Mangunharjo'
            ],

            'Tembalang'=> [
                'Tembalang','Tandang','Kramas','Meteseh','Sambiroto','Sendangmulyo','Mangunharjo','Sendangguwo','Bulusan','Kedungmudu','Rowosari','Jangli',
            ],

            'Semarang Utara' => [
                'Bandarharjo','Dadapsari','Panggung Kidul','Plombokan','Bulu Lor','Kuningan','Panggung Lor','Tanjung Mas','Purwosari',
            ],

            'Semarang Timur' => [
                'Kebonagung','Karang Tempel','Kemijen','Mlatibaru','Rejomulyo','Sarirejo','Bugangan','Mlatiharjo','Rejosari','Karangturi',
            ],
            
            'Semarang Tengah' => [
                'Kembangsari','Bangunharjo','Brumbungan','Kauman','Pekunden','Purwodinatan','Karangkidul','Sekayu','Miroto','Pandansari','Jagalan','Gabahan','Kranggan','Pindrikan Kidul','Pindrikan Lor', 
            ],

            'Semarang Selatan' => [
                'Lamper Lor','Barusari','Bulustalan','Mugassari','Wonodri','Pleburan','Randusari','Lamper Tengah','Peterongan','Lamper Kidul', 
            ],
            
            'Semarang Barat' => [
                'Krobokan','Kembangarum','Kalibanteng Kidul','Manyaran','Tambakharjo','Kalibanteng Kulon','Tawangmas','Karangayu','Krapyak','Tawangsari','Bongsari','Ngemplak Simongan','Salamanmloyo','Cabean','Gisikdrono','Bojongsalaman'
            ],
            
            'Pedurungan' => [
                'Plamomgsari','Pedurungan Lor','Pedurungan Kidul','Tlogosari Kidul','Kalicari','Penggaron Kidul','Pedurungan Tengah','Muktiharjo Kidul','Palebon','Tlogosari Wetan','Gemah','Tlogomulyo',
            ],            
            
            'Ngaliyan' => [
                'Kalipancur','Purwoyoso','Bringin','Bambankerep','Gondoriyo','Tambakaji','Ngaliyan','Wates','Podorejo','Wonosari',
            ],

            'Mijen' => [
                'Kedungpane','Karangmalang','Wonolopo','Jatisari','Pesantren','Tambangan','Bubakan','Mijen','Polaman','Jatibarang','Cangkiran','Ngadirgo','Wonoplumbon','Purwosari',
            ],
                
            'Gunungpati' => [
                'Pakintelan','Pongangan','Mangunsari','Sekaran','Sumurejo','Nongkosawit','Ngijo','Sukorejo','Patemon','Gunungpati','Cepoko','Plalangan','Kandri','Sadeng','Kalisegoro','Jatirejo',
            ],            
            
            'Genuk' => [
                'Karangroto','Gebangsari','Sembungharjo','Terboyo Kulon','Trimulyo','Genuksari','Muktiharjo Lor','Terboyo Wetan','Kudu','Banjardowo','Penggaron Lor','Bangetayu Wetan','Bangetayu Kulon',
            ],

            'Gayamsari' => [
                'Tambakrejo','Kaligawe','Sawah Besar','Siwalan','Sambirejo','Pandean Lamper','Gayamsari',
            ],
                
            'Gajahmungkur' => [
                'Bendungan','Karangrejo','Lempongsari','Sampangan','Gajahmungkur','Petompon','Bendan Ngisor','Bendan Duwur',
            ],

            'Candisari' => [
                'Karanganyar Gunung','Tegalsari','Candi','Kaliwiru','Wonotingal','Jomblang','Jatingaleh'
            ],

            'Banyumanik' => [
                'Banyumanik','Pudak Payung','Pedalangan','Srondol Kulon','Gedawangan','Srondol Wetan','Sumurbroto','Padangsari','Ngesrep','Tinjomoyo','Jabungan',
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