<?php

namespace App\Providers;

use App\Models\SecurityLog;
use App\Observers\SecurityLogObserver;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\ServiceProvider;
// 1. Tambahkan Import Class yang dibutuhkan
use Illuminate\Support\Facades\Event;
use Illuminate\Auth\Events\Failed;
use Illuminate\Support\Facades\DB;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Gunakan view pagination Bootstrap di seluruh aplikasi
        Paginator::useBootstrap();

        // 2. Event Listener: Menangkap setiap kegagalan login
        Event::listen(Failed::class, function ($event) {

            // Simpan data penyerang/user gagal ke database
            DB::table('failed_logins')->insert([
                'ip_address' => request()->ip(),
                // Ambil email yang dicoba (jika ada)
                'email' => $event->credentials['email'] ?? 'unknown',
                'user_agent' => request()->userAgent(),
                'attempted_at' => now(),
            ]);

        });

        // Daftarkan SecurityLogObserver
        SecurityLog::observe(SecurityLogObserver::class);
    }
}
