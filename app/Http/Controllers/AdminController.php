<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\MonthlyStat;
use App\Models\PageView;
use App\Models\User; // Asumsi untuk Total Visitors
use Carbon\Carbon;

class AdminController extends Controller
{
    /**
     * Menampilkan dashboard utama dengan data analytics.
     */
    public function index()
    {
        // 1. Statistik Pengunjung (Existing)
        $totalViews = PageView::count();
        $totalUniqueIPs = PageView::distinct('user_ip')->count('user_ip');

        // 2. Statistik Konten (BARU - Tambahkan ini)
        $totalProjects = \App\Models\Project::count();
        $totalCertificates = \App\Models\Certificate::count();

        // 3. Data Lainnya (Existing)
        $recentLogs = PageView::latest()->take(10)->get(); // Ambil 7 saja biar pas
        $topPages = PageView::select('path', DB::raw('COUNT(*) as views_count'))
            ->groupBy('path')
            ->orderByDesc('views_count')
            ->limit(10)
            ->get();

        $monthlyStats = MonthlyStat::orderBy('year')->orderBy('month')->get();
        $chartData = $monthlyStats->map(function ($stat) {
            return [
                'label' => \Carbon\Carbon::create($stat->year, $stat->month)->format('M Y'),
                'visits' => $stat->visits_count,
            ];
        });

        return view('admin.index', compact(
            'totalViews',
            'totalUniqueIPs',
            'totalProjects',      // Kirim ke view
            'totalCertificates',  // Kirim ke view
            'recentLogs',
            'topPages',
            'chartData'
        ));
    }
}
