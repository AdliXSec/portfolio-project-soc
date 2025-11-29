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
        Schema::create('abouts', function (Blueprint $table) {
            $table->id();
            $table->string('judul');          // Misal: "About Me"
            $table->string('subjudul')->nullable(); // Misal: "My Journey"
            $table->text('deskripsi');        // Cerita panjang
            $table->json('core');             // Simpan sebagai Array ["Backend", "IoT"]
            $table->integer('total_project')->default(0); // Angka total project
            $table->string('foto')->nullable(); // Path foto about
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('abouts');
    }
};