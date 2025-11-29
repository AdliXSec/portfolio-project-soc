<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;

    protected $fillable = [
        'judul',
        'type',
        'deskripsi',
        'fitur',      // JSON
        'galery',     // JSON
        'client',
        'role',       // String (Peran di project)
        'tanggal',
        'teknologi',  // JSON
        'website',
        'source',
    ];

    protected $casts = [
        'fitur' => 'array', // JSON ke Array
        'galery' => 'array', // JSON ke Array
        'teknologi' => 'array', // JSON ke Array
        'tanggal' => 'date',  // Agar bisa diformat ($project->tanggal->format('Y'))
    ];

    public function getRouteKeyName()
    {
        return 'slug';
    }
}