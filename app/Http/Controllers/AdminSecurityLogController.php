<?php

namespace App\Http\Controllers;

use App\Models\SecurityLog;
use Illuminate\Http\Request;

class AdminSecurityLogController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $logs = SecurityLog::latest()->paginate(20);
        return view('admin.security.logs', compact('logs'));
    }
}
