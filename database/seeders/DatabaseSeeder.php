<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Database\Seeders\HomeSeeder;
use Database\Seeders\AboutSeeder;
use Database\Seeders\TechSeeder;
use Database\Seeders\JourneySeeder;
use Database\Seeders\ProjectSeeder;
use Database\Seeders\CertificateSeeder;
use Database\Seeders\UserSeeder;
use Database\Seeders\TestimonialSeeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            HomeSeeder::class,
            AboutSeeder::class,
            TechSeeder::class,
            JourneySeeder::class,
            ProjectSeeder::class,
            CertificateSeeder::class,
            UserSeeder::class,
            TestimonialSeeder::class,
        ]);
    }
}