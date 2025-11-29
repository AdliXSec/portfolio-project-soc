<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Home extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama',
        'role',
        'deskripsi',
        'foto',
        'mail',
        'github',
        'linkedin',
        'instagram',
        'cv',
    ];

    protected $casts = [
        'role' => 'array',
    ];
}