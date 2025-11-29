<?php

namespace App\Http\Controllers;

use App\Models\BlockedIp;
use App\Models\PageView;
use Illuminate\Http\Request;

class AdminBlockIpController extends Controller
{
    // Tampilkan Daftar Blokir
    public function index()
    {
        $blockedIps = BlockedIp::orderBy('created_at', 'desc')->get();
        $recentLogs = PageView::latest()->take(10)->get();
        return view('admin.security.blocklist', compact('blockedIps', 'recentLogs'));
    }

    // Blokir IP Manual
    public function store(Request $request)
    {
        $request->validate([
            'ip_address' => 'required|ip|unique:blocked_ips,ip_address',
            'reason' => 'nullable|string|max:255',
        ]);

        BlockedIp::create([
            'ip_address' => $request->ip_address,
            'reason' => $request->reason ?? 'Manual Block by Admin',
        ]);

        return redirect()->back()->with('success', 'IP Address has been added to blacklist.');
    }

    // Buka Blokir (Unblock)
    public function destroy($id)
    {
        $ip = BlockedIp::findOrFail($id);
        $ip->delete();

        return redirect()->back()->with('success', 'IP Address unblocked successfully.');
    }
}