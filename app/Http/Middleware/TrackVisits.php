<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;
use App\Models\PageView;
use App\Models\MonthlyStat;
use Symfony\Component\HttpFoundation\Response;

class TrackVisits
{
    public function handle(Request $request, Closure $next): Response
    {
        $userIp = $request->ip();

        // Cek blocked IP SEBELUM proses request (lebih efisien)
        if ($request->isMethod('GET') && !$request->wantsJson()) {
            // Cache blocked IPs untuk performa (5 menit)
            $blockedIps = Cache::remember('blocked_ips', 300, function () {
                return DB::table('blocked_ips')->pluck('ip_address')->toArray();
            });

            if (in_array($userIp, $blockedIps)) {
                abort(403, 'Your IP is blocked by Security System.');
            }
        }

        $startTime = microtime(true);
        $response = $next($request);
        $endTime = microtime(true);

        // Track hanya GET requests yang bukan API/JSON
        if ($request->isMethod('GET') && !$request->wantsJson()) {
            $duration = ($endTime - $startTime) * 1000;
            $statusCode = $response->getStatusCode();

            // Sanitasi user agent untuk mencegah log injection
            $userAgent = substr($request->userAgent() ?? 'Unknown', 0, 500);
            $referrer = substr($request->server('HTTP_REFERER') ?? '', 0, 500);

            // Insert page view (hanya sekali!)
            PageView::create([
                'session_id' => $request->session()->getId(),
                'user_ip' => $userIp,
                'path' => substr($request->path(), 0, 255),
                'user_agent' => $userAgent,
                'referrer' => $referrer ?: null,
                'status_code' => $statusCode,
                'response_time_ms' => $duration,
            ]);

            // Update monthly stats
            $now = now();
            MonthlyStat::firstOrCreate(
                ['year' => $now->year, 'month' => $now->month],
                ['visits_count' => 0]
            )->increment('visits_count');
        }

        return $response;
    }
}
