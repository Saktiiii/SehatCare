<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class KategoriObat extends Model
{
    use HasFactory;
    protected $table = 'kategori_obat';

    protected $fillable = ['nama_kategori'];

    public function obat()
    {
        return $this->hasMany(Obat::class, 'kategori_id');
    }
}
