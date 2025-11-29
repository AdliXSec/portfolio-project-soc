<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Home; // Jangan lupa import Model ini

class HomeSeeder extends Seeder
{
    public function run(): void
    {
        // Pastikan tabel kosong dulu agar tidak duplikat (opsional)
        // Home::truncate();

        Home::create([
            'nama' => 'Naufal Syahruradli',
            'role' => ["Backend Developer", "IoT Enthusiast", "Cyber Security Enthusiast"],
            'deskripsi' => 'Transforming complex problems into elegant, secure, and scalable digital solutions.',
            'foto' => 'adli2.png',

            // Isi data dummy sosmed
            'mail' => 'naufalsyahruradli@gmail.com',
            'github' => 'https://github.com/naufaladli',
            'linkedin' => 'https://linkedin.com/in/naufaladli',
            'instagram' => 'https://instagram.com/naufaladli',
            'cv' => 'belum_ada.pdf',
        ]);
    }
}
