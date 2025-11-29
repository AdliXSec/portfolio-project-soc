<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tech extends Model
{
    use HasFactory;

    // Jika nama tabel di database Anda 'teches', baris ini opsional.
    // Tapi jika nama tabelnya 'techs', Anda harus uncomment baris di bawah:
    // protected $table = 'teches';

    protected $fillable = [
        'judul',
        'foto',
    ];
}
