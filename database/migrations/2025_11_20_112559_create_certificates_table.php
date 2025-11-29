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
        Schema::create('certificates', function (Blueprint $table) {
            $table->id();
            $table->string('judul');
            $table->string('slug')->unique()->nullable();
            $table->string('icon')->nullable();
            $table->string('type');           // Certificate / Award
            $table->string('issued');         // Penerbit (Dicoding, Udemy)
            $table->date('tanggal');          // Tanggal terbit
            $table->string('kredensial')->nullable(); // ID Sertifikat
            $table->string('status')->default('Valid'); // Valid / Expired
            $table->text('deskripsi')->nullable();
            $table->json('skill')->nullable(); // Array skill yang didapat
            $table->string('link')->nullable(); // Link verifikasi
            $table->string('foto')->nullable(); // Scan sertifikat
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('certificates');
    }
};
