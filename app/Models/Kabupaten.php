<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kabupaten extends Model
{
    protected $table = 'kabupaten';
    protected $fillable = ['nama'];

    public function kecamatans()
    {
        return $this->hasMany(Kecamatan::class);
    }
}