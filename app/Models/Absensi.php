<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Absensi extends Model
{
   use HasFactory;

    protected $fillable = [
        'user_id', 'tanggal', 'jam', 'latitude', 'longitude'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}