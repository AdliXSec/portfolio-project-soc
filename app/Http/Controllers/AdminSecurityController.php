<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PageView;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class AdminSecurityController extends Controller
{
    public function index()
    {
        return view('admin.security.index');
    }

    // API Endpoint untuk Data Live (AJAX)
    public function getLiveStats()
    {
        // 1. Server Resources (Windows/Linux Compatible)
        // Note: Di Windows XAMPP, memory_get_usage() hanya mengambil memori script PHP, bukan OS.
        // Untuk Real project di Linux, gunakan 'sys_getloadavg()'.
        $memoryUsage = round(memory_get_usage() / 1024 / 1024, 2); // MB (Script usage)
        $diskFree = round(disk_free_space("/") / 1024 / 1024 / 1024, 2); // GB
        $diskTotal = round(disk_total_space("/") / 1024 / 1024 / 1024, 2); // GB

        // 2. Error Rates (Hari ini)
        $errors = PageView::select('status_code', DB::raw('count(*) as total'))
            ->whereDate('created_at', Carbon::today())
            ->whereIn('status_code', [403, 404, 500])
            ->groupBy('status_code')
            ->get()
            ->pluck('total', 'status_code');

        // 3. Traffic Spikes (RPS - Request Per Minute sebenarnya, dibagi 60)
        // Mengambil data 10 menit terakhir
        $trafficData = PageView::select(DB::raw('MINUTE(created_at) as minute'), DB::raw('count(*) as count'))
            ->where('created_at', '>=', Carbon::now()->subMinutes(10))
            ->groupBy('minute')
            ->get();

        // 4. Failed Login (Brute Force Check)
        $failedLogins = DB::table('failed_logins')
            ->where('attempted_at', '>=', Carbon::today())
            ->count();

        // 5. SSL Status (Cek Domain Sendiri)
        // Ganti domain dengan domain lokal atau live Anda
        $targetDomain = config('services.ssl_checker.domain');
        $sslStatus = $this->checkSSL($targetDomain); // Contoh pakai google dulu karena localhost tidak ada SSL

        return response()->json([
            'server' => [
                'memory' => $memoryUsage,
                'disk_free' => $diskFree,
                'disk_total' => $diskTotal,
                'cpu_load' => rand(5, 30) // Simulasi CPU (karena susah ambil real CPU di Windows XAMPP tanpa COM)
            ],
            'errors' => [
                '403' => $errors[403] ?? 0,
                '404' => $errors[404] ?? 0,
                '500' => $errors[500] ?? 0,
            ],
            'traffic' => $trafficData,
            'security' => [
                'failed_logins' => $failedLogins,
                'ssl_days' => $sslStatus
            ]
        ]);
    }

    public function getLiveLogs()
    {
        $logs = \App\Models\PageView::latest()->take(10)->get();

        // Kita format datanya di sini agar JS tidak pusing memikirkan logika tampilan
        $formattedLogs = $logs->map(function ($log) {

            // 1. Logika Badge Warna
            $status = $log->status_code ?? 200;
            $badgeColor = 'success';
            if ($status >= 400)
                $badgeColor = 'warning';
            if ($status >= 500)
                $badgeColor = 'danger';

            // 2. Logika Ikon Device
            $agent = strtolower($log->user_agent);
            $deviceIcon = 'mdi-desktop-mac';
            if (str_contains($agent, 'mobile'))
                $deviceIcon = 'mdi-cellphone';
            if (str_contains($agent, 'bot'))
                $deviceIcon = 'mdi-robot';

            // 3. Cek Blocklist (Query ringan)
            // Note: Untuk performa tinggi, sebaiknya cache list IP yang diblokir
            $isBlocked = \App\Models\BlockedIp::where('ip_address', $log->user_ip)->exists();

            return [
                'status_code' => $status,
                'badge_color' => $badgeColor,
                'user_ip' => $log->user_ip,
                'country' => $log->country_code ?? 'Local',
                'device_icon' => $deviceIcon,
                'user_agent_short' => \Illuminate\Support\Str::limit($log->user_agent, 20),
                'path' => \Illuminate\Support\Str::limit($log->path, 30),
                'referrer' => \Illuminate\Support\Str::limit($log->referrer ?? 'Direct', 20),
                'time_exact' => $log->created_at->format('H:i:s'),
                'time_ago' => $log->created_at->diffForHumans(),
                'is_blocked' => $isBlocked,
                // URL untuk form action block
                'block_url' => route('admin.security.block')
            ];
        });

        return response()->json($formattedLogs);
    }

    private function checkSSL($domain)
    {
        try {
            $g = stream_context_create(["ssl" => ["capture_peer_cert" => true]]);
            $r = stream_socket_client("ssl://{$domain}:443", $errno, $errstr, 30, STREAM_CLIENT_CONNECT, $g);
            $cont = stream_context_get_params($r);
            $cert = openssl_x509_parse($cont["options"]["ssl"]["peer_certificate"]);

            $validTo = $cert['validTo_time_t'];
            $current = time();

            // Hitung sisa hari
            return floor(($validTo - $current) / (60 * 60 * 24));
        } catch (\Exception $e) {
            return 0; // Error atau tidak ada SSL
        }
    }
}
