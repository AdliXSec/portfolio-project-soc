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
        Schema::create('projects', function (Blueprint $table) {
            $table->id();
            $table->string('judul');
            $table->string('slug')->unique()->nullable();
            $table->string('type');           // Web, Mobile, IoT
            $table->text('deskripsi');
            $table->json('fitur')->nullable();     // Array list fitur
            $table->json('galery')->nullable();    // Array path gambar
            $table->string('client')->nullable();
            $table->string('role')->nullable();    // Peran Anda di project
            $table->date('tanggal')->nullable();   // Tanggal pengerjaan
            $table->json('teknologi')->nullable(); // Array ["Laravel", "Vue"]
            $table->string('website')->nullable(); // Link Demo
            $table->string('source')->nullable();  // Link GitHub
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('projects');
    }
};
