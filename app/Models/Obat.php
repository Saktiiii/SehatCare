<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class Obat extends Model
{
    use HasFactory;
    protected $table = 'obat';

    protected $fillable = [
        'nama_obat',
        'kategori_id',
        'stok',
        'harga',
        'deskripsi',
        'foto',
    ];

    public function kategori()
    {
        return $this->belongsTo(KategoriObat::class, 'kategori_id');
    }
}
