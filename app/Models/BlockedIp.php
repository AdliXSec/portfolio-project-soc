<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BlockedIp extends Model
{
    use HasFactory;

    protected $table = 'blocked_ips'; // Sesuai nama tabel migrasi sebelumnya

    protected $fillable = [
        'ip_address',
        'reason',
    ];
}
