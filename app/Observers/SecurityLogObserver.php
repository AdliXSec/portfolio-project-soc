<?php

namespace App\Observers;

use App\Models\BlockedIp;
use App\Models\SecurityLog;
use App\Models\Setting;
use App\Models\User;
use App\Mail\SecurityAlertMail;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class SecurityLogObserver
{
    /**
     * Handle the SecurityLog "created" event.
     */
    public function created(SecurityLog $securityLog): void
    {
        try {
            // 1. Ambil pengaturan (dengan caching untuk 10 menit)
            $settings = Cache::remember('soc_settings', now()->addMinutes(10), function () {
                return Setting::pluck('value', 'key')->all();
            });
            
            $autoBlockEnabled = $settings['soc_auto_block'] ?? false;
            $blockThreshold = (int) ($settings['soc_block_threshold'] ?? 5);
            $emailAlertEnabled = $settings['soc_email_alert'] ?? false;
            
            $ipWasBlocked = false;

            // 2. Logika Auto-Block (jika aktif)
            if ($autoBlockEnabled) {
                $ipAddress = $securityLog->ip_address;

                if (!BlockedIp::where('ip_address', $ipAddress)->exists()) {
                    $recentOffenses = SecurityLog::where('ip_address', $ipAddress)
                        ->where('created_at', '>=', now()->subHour())
                        ->count();

                    if ($recentOffenses >= $blockThreshold) {
                        BlockedIp::create([
                            'ip_address' => $ipAddress,
                            'reason' => 'Auto-blocked after ' . $recentOffenses . ' offenses.',
                        ]);
                        // Lupakan cache blocklist agar blokir segera efektif
                        Cache::forget('blocked_ips');
                        $ipWasBlocked = true;
                    }
                }
            }

            // 3. Logika Notifikasi Email (jika aktif)
            if ($emailAlertEnabled) {
                // Cari email admin pertama untuk dijadikan penerima notifikasi
                $recipient = User::where('role', 'admin')->value('email');
                if (!$recipient) {
                    Log::warning('Security Alert: No admin user found to send email notification.');
                    return;
                }

                $subject = $ipWasBlocked
                    ? "[CRITICAL] IP {$securityLog->ip_address} Automatically Blocked"
                    : "[Security Alert] Suspicious Activity Detected from {$securityLog->ip_address}";

                Mail::to($recipient)->send(new SecurityAlertMail($securityLog, $subject));
            }

        } catch (\Exception $e) {
            // Catat error jika terjadi masalah saat proses observer
            Log::error('SecurityLogObserver failed: ' . $e->getMessage(), [
                'file' => $e->getFile(),
                'line' => $e->getLine()
            ]);
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