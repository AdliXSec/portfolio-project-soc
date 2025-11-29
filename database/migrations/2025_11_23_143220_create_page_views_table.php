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
        Schema::create('page_views', function (Blueprint $table) {
            $table->id();

            $table->string('session_id', 40)->nullable();
            $table->string('user_ip', 45);
            $table->text('path');
            $table->text('user_agent')->nullable();
            $table->string('referrer')->nullable();
            $table->index('path', 'path_idx'); // Index pada kolom TEXT
            $table->index('session_id', 'session_idx');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('page_views');
    }
};