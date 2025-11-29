<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Journey;

class JourneySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Journey::truncate(); // Opsional: Hapus data lama

        $journeys = [
            [
                'tahun' => '2021 - 2022',
                'judul' => 'Freelance Web Developer',
                'deskripsi' => 'Developed diverse web solutions including internal dashboards for Police Department (Polda), tournament systems, and IoT integrations.'
            ],
            [
                'tahun' => '2022 - 2023',
                'judul' => 'Robotic Mentor at SMA Hangtuah 5',
                'deskripsi' => 'Guided student teams to achieve 2nd Place in National Robotics Competition (ITS) and Appropriate Technology Innovation.'
            ],
            [
                'tahun' => '2024 - Present',
                'judul' => 'Cyber Security Projects',
                'deskripsi' => 'Focusing on vulnerability assessment and reporting. Successfully reported bugs (XSS, Open Redirect) to verified government systems.'
            ],
        ];

        foreach ($journeys as $journey) {
            Journey::create($journey);
        }
    }
}