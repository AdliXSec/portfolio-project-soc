<?php

namespace App\Observers;

use App\Models\BlockedIp;
use App\Models\SecurityLog;
use App\Models\Setting;
use Illuminate\Support\Facades\Log;

class SecurityLogObserver
{
    /**
     * Handle the SecurityLog "created" event.
     */
    public function created(SecurityLog $securityLog): void
    {
        try {
            // Ambil pengaturan dari cache atau database
            $settings = Setting::pluck('value', 'key')->all();
            $autoBlockEnabled = $settings['soc_auto_block'] ?? false;
            $blockThreshold = (int) ($settings['soc_block_threshold'] ?? 5);

            // Jika auto-block tidak aktif, hentikan proses
            if (!$autoBlockEnabled) {
                return;
            }

            $ipAddress = $securityLog->ip_address;

            // Periksa apakah IP sudah diblokir untuk menghindari duplikasi
            if (BlockedIp::where('ip_address', $ipAddress)->exists()) {
                return;
            }

            // Hitung jumlah log keamanan untuk IP ini dalam 1 jam terakhir
            $recentOffenses = SecurityLog::where('ip_address', $ipAddress)
                ->where('created_at', '>=', now()->subHour())
                ->count();

            // Jika jumlah pelanggaran melebihi ambang batas, blokir IP
            if ($recentOffenses >= $blockThreshold) {
                BlockedIp::create([
                    'ip_address' => $ipAddress,
                    'reason' => 'Auto-blocked due to suspicious activity.',
                ]);
            }
        } catch (\Exception $e) {
            // Catat error jika terjadi masalah saat proses auto-blocking
            Log::error('Auto-blocking failed: ' . $e->getMessage());
        }
    }

    /**
     * Handle the SecurityLog "updated" event.
     */
    public function updated(SecurityLog $securityLog): void
    {
        //
    }

    /**
     * Handle the SecurityLog "deleted" event.
     */
    public function deleted(SecurityLog $securityLog): void
    {
        //
    }

    /**
     * Handle the SecurityLog "restored" event.
     */
    public function restored(SecurityLog $securityLog): void
    {
        //
    }

    /**
     * Handle the SecurityLog "force deleted" event.
     */
    public function forceDeleted(SecurityLog $securityLog): void
    {
        //
    }
}