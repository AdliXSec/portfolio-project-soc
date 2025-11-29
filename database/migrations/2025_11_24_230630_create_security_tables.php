<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // 1. Tabel Percobaan Login Gagal (Untuk deteksi Brute Force)
        Schema::create('failed_logins', function (Blueprint $table) {
            $table->id();
            $table->string('ip_address', 45);
            $table->string('email')->nullable(); // Email yang dicoba
            $table->text('user_agent')->nullable();
            $table->timestamp('attempted_at');
        });

        // 2. Tabel Blacklist IP (Otomatis atau Manual)
        Schema::create('blocked_ips', function (Blueprint $table) {
            $table->id();
            $table->string('ip_address', 45)->unique();
            $table->string('reason')->nullable(); // Misal: "Brute Force Detected"
            $table->timestamps();
        });

        // 3. Menambah kolom response_time & status_code ke page_views (Untuk analisis Latency & Error)
        Schema::table('page_views', function (Blueprint $table) {
            $table->integer('status_code')->nullable()->after('path'); // 200, 404, 500
            $table->float('response_time_ms')->nullable()->after('status_code'); // ms
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('security_tables');
    }
};
