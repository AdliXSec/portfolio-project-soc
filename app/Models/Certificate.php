<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Certificate extends Model
{
    use HasFactory;

    protected $fillable = [
        'judul',
        'icon',
        'type',
        'issued',
        'tanggal',
        'kredensial',
        'status',
        'deskripsi',
        'skill',      // JSON
        'link',
        'foto',
    ];

    protected $casts = [
        'skill' => 'array', // JSON ke Array
        'tanggal' => 'date',  // Agar bisa diformat tanggalnya
    ];

    public function getRouteKeyName()
    {
        return 'slug';
    }
}