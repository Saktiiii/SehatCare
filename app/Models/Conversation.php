<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Conversation extends Model
{
    
    protected $fillable = ['pasien_id', 'nakes_id', 'status'];

    public function pasien()
    {
        return $this->belongsTo(User::class, 'pasien_id');
    }

    public function nakes()
    {
        return $this->belongsTo(User::class, 'nakes_id');
    }

    public function messages()
    {
        return $this->hasMany(Message::class);
    }
}
