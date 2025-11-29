<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class About extends Model
{
    use HasFactory;

    protected $fillable = [
        'judul',
        'subjudul',
        'deskripsi',
        'core',          // JSON
        'total_project',
        'foto',
    ];

    protected $casts = [
        'core' => 'array', // Penting: ubah JSON ke Array
    ];
}
