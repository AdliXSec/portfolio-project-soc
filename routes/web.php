<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\CertificateController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AdminHomeController;
use App\Http\Controllers\AdminAboutController;
use App\Http\Controllers\AdminTechController;
use App\Http\Controllers\AdminJourneyController;
use App\Http\Controllers\AdminProjectController;
use App\Http\Controllers\AdminCertificateController;
use App\Http\Controllers\AdminTestimonialController;
use App\Http\Controllers\AdminSearchController;
use App\Http\Controllers\AdminSecurityController;
use App\Http\Controllers\AdminSecurityLogController;
use App\Http\Controllers\AdminBlockIpController;
use App\Http\Controllers\AdminSettingController;
use App\Http\Controllers\AdminUserController;
use App\Http\Controllers\SitemapController;
use Illuminate\Auth\Access\AuthorizationException;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/sitemap.xml', [SitemapController::class, 'index'])->name('sitemap');
Route::post('/contact', [HomeController::class, 'sendContact'])->name('contact.send')->middleware('throttle:3,1');
Route::get('/projects', [ProjectController::class, 'index'])->name('projects.index');
Route::get('/projects/{project}', [ProjectController::class, 'show'])->name('projects.show');
Route::get('/certificates/{certificate}', [CertificateController::class, 'show'])->name('certificate.show');

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.perform')->middleware('throttle:5,1');
});

// OTP Routes moved outside of 'auth' middleware group
Route::get('/otp/verification', [AuthController::class, 'showOtpForm'])->name('otp.verification');
Route::post('/otp/verify', [AuthController::class, 'verifyOtp'])->name('otp.verify');
Route::post('/otp/resend', [AuthController::class, 'resendOtp'])->name('otp.resend');
Route::get('/back-login', [AuthController::class, 'backLogin'])->name('back.login');

Route::middleware('auth')->group(function () {
    Route::middleware('otp.verified')->group(function () {
        Route::get('/admin/dashboard', [AdminController::class, 'index'])->name('admin.dashboard');
        Route::get('/admin/home', [AdminHomeController::class, 'index'])->name('admin.home.index');
        Route::put('/admin/home/update', [AdminHomeController::class, 'update'])->name('admin.home.update');
        Route::get('/admin/about', [AdminAboutController::class, 'index'])->name('admin.about.index');
        Route::put('/admin/about/update', [AdminAboutController::class, 'update'])->name('admin.about.update');
        Route::resource('admin/tech', AdminTechController::class, ['names' => 'admin.tech'])->except(['show']);
        Route::resource('admin/journey', AdminJourneyController::class, ['names' => 'admin.journey'])->except(['show']);
        Route::resource('admin/project', AdminProjectController::class, ['names' => 'admin.project'])->except(['show']);
        Route::resource('admin/certificate', AdminCertificateController::class, ['names' => 'admin.certificate'])->except(['show']);
        Route::resource('admin/testimonial', AdminTestimonialController::class, ['names' => 'admin.testimonial'])->except(['show']);
        Route::get('/admin/search', [AdminSearchController::class, 'search'])->name('admin.search');
        Route::get('/admin/security', [AdminSecurityController::class, 'index'])->name('admin.security.index');
        Route::post('/admin/security/toggle', [AdminSecurityController::class, 'toggleSetting'])->name('admin.security.toggle');
        Route::put('/admin/security/threshold', [AdminSecurityController::class, 'updateThreshold'])->name('admin.security.threshold');
        Route::get('/admin/security/api', [AdminSecurityController::class, 'getLiveStats'])->name('admin.security.api');
        Route::get('/admin/security/firewall', [AdminBlockIpController::class, 'index'])->name('admin.security.firewall');
        Route::post('/admin/security/firewall', [AdminBlockIpController::class, 'store'])->name('admin.security.block');
        Route::delete('/admin/security/firewall/{id}', [AdminBlockIpController::class, 'destroy'])->name('admin.security.unblock');
        Route::get('/admin/security/logs', [AdminSecurityLogController::class, 'index'])->name('admin.security.logs');
        Route::get('/admin/security/api/logs', [AdminSecurityController::class, 'getLiveLogs'])->name('admin.security.logs.api');

        // Settings Routes
        Route::get('/admin/settings', [AdminSettingController::class, 'index'])->name('admin.settings.index');
        Route::get('/admin/settings/profile', [AdminSettingController::class, 'profile'])->name('admin.settings.profile');
        Route::put('/admin/settings/profile', [AdminSettingController::class, 'updateProfile'])->name('admin.settings.profile.update');
        Route::put('/admin/settings/password', [AdminSettingController::class, 'updatePassword'])->name('admin.settings.password.update');
        Route::delete('/admin/settings/avatar', [AdminSettingController::class, 'deleteAvatar'])->name('admin.settings.avatar.delete');

        // User Management Routes
        Route::resource('admin/users', AdminUserController::class, ['names' => 'admin.users'])->except(['show']);
    });

    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});
// Route::get('/fix-stats', function () {
//     // 1. Kosongkan tabel statistik
//     \App\Models\MonthlyStat::truncate();

//     // 2. Ambil semua log view
//     $logs = \App\Models\PageView::all();

//     // 3. Hitung ulang
//     foreach ($logs as $log) {
//         \App\Models\MonthlyStat::firstOrCreate(
//             [
//                 'year' => $log->created_at->year,
//                 'month' => $log->created_at->month
//             ],
//             ['visits_count' => 0]
//         )->increment('visits_count');
//     }

//     return "Sinkronisasi Selesai! Monthly Stats sekarang sesuai dengan Page Views.";
// });

// Route::fallback(function () {
//     return response()->view('errors.404', [], 404);
// })->name('404');

// Route::get('/test-403', function () {
//     throw new AuthorizationException('Anda tidak memiliki hak akses untuk halaman ini.');
// })->name('test.403');

// Route::get('/test-500', function () {
//     $obj = null;
//     return $obj->callMethod();
// })->name('test.500');
