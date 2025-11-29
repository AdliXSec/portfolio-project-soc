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
use App\Http\Controllers\AdminSearchController;
use App\Http\Controllers\AdminSecurityController;
use App\Http\Controllers\AdminBlockIpController;
use Illuminate\Auth\Access\AuthorizationException;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::post('/contact', [HomeController::class, 'sendContact'])->name('contact.send');
Route::get('/projects', [ProjectController::class, 'index'])->name('projects.index');
Route::get('/projects/{project}', [ProjectController::class, 'show'])->name('projects.show');
Route::get('/certificates/{certificate}', [CertificateController::class, 'show'])->name('certificate.show');

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.perform');
});
Route::middleware('auth')->group(function () {
    Route::get('/admin/dashboard', [AdminController::class, 'index'])->name('admin.dashboard');
    Route::get('/admin/home', [AdminHomeController::class, 'index'])->name('admin.home.index');
    Route::put('/admin/home/update', [AdminHomeController::class, 'update'])->name('admin.home.update');
    Route::get('/admin/about', [AdminAboutController::class, 'index'])->name('admin.about.index');
    Route::put('/admin/about/update', [AdminAboutController::class, 'update'])->name('admin.about.update');
    Route::resource('admin/tech', AdminTechController::class, ['names' => 'admin.tech'])->except(['show']);
    Route::resource('admin/journey', AdminJourneyController::class, ['names' => 'admin.journey'])->except(['show']);
    Route::resource('admin/project', AdminProjectController::class, ['names' => 'admin.project'])->except(['show']);
    Route::resource('admin/certificate', AdminCertificateController::class, ['names' => 'admin.certificate'])->except(['show']);
    Route::get('/admin/search', [AdminSearchController::class, 'search'])->name('admin.search');
    Route::get('/admin/security', [AdminSecurityController::class, 'index'])->name('admin.security.index');
    Route::get('/admin/security/api', [AdminSecurityController::class, 'getLiveStats'])->name('admin.security.api');
    Route::get('/admin/security/firewall', [AdminBlockIpController::class, 'index'])->name('admin.security.firewall');
    Route::post('/admin/security/firewall', [AdminBlockIpController::class, 'store'])->name('admin.security.block');
    Route::delete('/admin/security/firewall/{id}', [AdminBlockIpController::class, 'destroy'])->name('admin.security.unblock');
    Route::get('/admin/security/api/logs', [AdminSecurityController::class, 'getLiveLogs'])->name('admin.security.logs.api');
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
