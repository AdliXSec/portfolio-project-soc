<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\About;

class AboutSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // About::truncate(); // Opsional: Hapus data lama agar tidak duplikat

        About::create([
            'judul' => 'About Me',
            'subjudul' => 'Backend Developer & Cyber Security Enthusiast',

            // Deskripsi panjang (menggunakan HTML untuk paragraf agar rapi di blade dengan {!! !!})
            'deskripsi' => 'Hi! I\'m Naufal Syahruradli but u can call me Adli, a Backend Web Developer & IoT Developer passionate about building efficient and scalable solutions. I specialize in developing secure, high-performance backend systems, working with databases, APIs, and cloud technologies to ensure smooth and reliable applications. In IoT, I integrate hardware and software to create smart, data-driven solutions that improve automation and connectivity. I’m always eager to explore new technologies, solve real-world problems, and develop impactful projects.<br><br>My journey involves a blend of clean code architecture and a deep curiosity for Cyber Security. Whether it\'s optimizing database queries or testing system vulnerabilities, I enjoy the challenge of making technology both functional and secure. Let’s connect and collaborate!',

            // Array Core Competencies (Otomatis jadi JSON karena casting di Model)
            'core' => [
                "Backend Development",
                "Internet of Things",
                "Cyber Security",
                "Database Management",
                "RESTful API"
            ],

            'total_project' => 100, // Angka statistik
            'foto' => 'adli.jpg' // Pastikan gambar ini ada di public/img/
        ]);
    }
}