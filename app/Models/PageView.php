<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PageView extends Model
{
    protected $fillable = [
        'session_id',
        'user_ip',
        'path',
        'user_agent',
        'referrer'
    ];
}