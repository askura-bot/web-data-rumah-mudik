<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RumahMudik extends Model
{
    protected $table = 'rumah_mudik';

    protected $fillable = [
        'nik',
        'nama_pemilik',
        'latitude',
        'longitude',
        'alamat_lengkap',
        'rt',
        'rw',
        'kabupaten',
        'kecamatan',
        'tanggal_mulai_mudik',
        'tanggal_selesai_mudik',
        'foto_rumah',
    ];

    protected $casts = [
        'tanggal_mulai_mudik'   => 'date',
        'tanggal_selesai_mudik' => 'date',
        'latitude'              => 'float',
        'longitude'             => 'float',
    ];
}
