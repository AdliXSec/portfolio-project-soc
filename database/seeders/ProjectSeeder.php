<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Project;
use Str;

class ProjectSeeder extends Seeder
{
    public function run(): void
    {
        Project::truncate(); // Hapus semua data project yang ada

        // Buat 20 data dummy menggunakan ProjectFactory
        Project::factory()->count(20)->create();
    }
}