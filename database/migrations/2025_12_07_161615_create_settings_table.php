<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('settings', function (Blueprint $table) {
            $table->id();
            $table->string('key')->unique();
            $table->text('value')->nullable();
            $table->string('type')->default('string'); // string, boolean, integer, json
            $table->string('group')->default('general'); // general, security, etc
            $table->timestamps();
        });

        // Insert default settings
        DB::table('settings')->insert([
            [
                'key' => 'soc_enabled',
                'value' => '1',
                'type' => 'boolean',
                'group' => 'security',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'key' => 'soc_auto_block',
                'value' => '0',
                'type' => 'boolean',
                'group' => 'security',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'key' => 'soc_block_threshold',
                'value' => '5',
                'type' => 'integer',
                'group' => 'security',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('settings');
    }
};
