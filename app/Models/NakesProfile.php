<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class NakesProfile extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'alamat_praktek',
        'lulusan',
        'spesialisasi',
        'nomor_registrasi',
        'pengalaman_kerja',
        'foto'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
