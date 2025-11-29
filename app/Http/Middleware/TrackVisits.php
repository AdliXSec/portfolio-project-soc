<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\PageView;
use App\Models\MonthlyStat;
use Symfony\Component\HttpFoundation\Response;

class TrackVisits
{
    public function handle(Request $request, Closure $next): Response
    {
        $startTime = microtime(true);

        $response = $next($request);

        $endTime = microtime(true);
        $duration = ($endTime - $startTime) * 1000;
        $statusCode = $response->getStatusCode();
        if ($request->isMethod('GET') && !$request->wantsJson()) {

            $isBlocked = \Illuminate\Support\Facades\DB::table('blocked_ips')
                ->where('ip_address', $request->ip())
                ->exists();

            if ($isBlocked) {
                abort(403, 'Your IP is blocked by Security System.');
            }

            \App\Models\PageView::create([
                'session_id' => $request->session()->getId(),
                'user_ip' => $request->ip(),
                'path' => $request->path(),
                'user_agent' => $request->userAgent(),
                'referrer' => $request->server('HTTP_REFERER'),
                'status_code' => $statusCode,       // BARU
                'response_time_ms' => $duration,    // BARU
            ]);

            $now = now();
            $userIp = $request->ip();

            $stat = MonthlyStat::firstOrCreate(
                [
                    'year' => $now->year,
                    'month' => $now->month,
                ],
                [
                    'visits_count' => 0
                ]
            );

            $stat->increment('visits_count');

            PageView::create([
                'session_id' => $request->session()->getId(),
                'user_ip' => $userIp,
                'path' => $request->path(),
                'user_agent' => $request->userAgent(),
                'referrer' => $request->server('HTTP_REFERER') ?? null,
            ]);
        }

        return $next($request);
    }
}
