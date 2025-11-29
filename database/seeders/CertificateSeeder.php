<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Certificate;
use Str;

class CertificateSeeder extends Seeder
{
    public function run(): void
    {
        // Certificate::truncate();

        $certs = [
            [
                "judul" => "2nd Place National Robotics",
                'slug' => Str::slug('2nd Place National Robotics'),
                "icon" => "fa-solid fa-trophy",
                "type" => "Award",
                "issued" => "Institut Teknologi Sepuluh Nopember (ITS)",
                "tanggal" => "2023-09-24",
                "kredensial" => "ITS-ROBO-23-X99",
                "status" => "Valid",
                "deskripsi" => "Juara 2 kompetisi robotika tingkat nasional kategori Line Follower Analog. Kompetisi ini diikuti oleh lebih dari 50 tim dari seluruh Indonesia.",
                "skill" => ["C++ Programming", "PID Control", "Electronics"],
                "link" => "https://its.ac.id/verify",
                "foto" => "sample.jpg"
            ],
            [
                "judul" => "2nd Place Innovation Tech",
                'slug' => Str::slug('2nd Place Innovation Tech'),
                "icon" => "fa-solid fa-trophy",
                "type" => "Award",
                "issued" => "Kabupaten Sidoarjo",
                "tanggal" => "2023-07-15",
                "kredensial" => "SDA-TECH-23",
                "status" => "Valid",
                "deskripsi" => "Penghargaan Teknologi Tepat Guna untuk inovasi sistem monitoring lingkungan berbasis IoT.",
                "skill" => ["Innovation", "IoT", "Public Speaking"],
                "link" => "#",
                "foto" => "sample.jpg"
            ],
            [
                "judul" => "Cyber Security Acknowledgement",
                'slug' => Str::slug('Cyber Security Acknowledgement'),
                "icon" => "fa-solid fa-shield-halved",
                "type" => "Certificate",
                "issued" => "Kutai Kartanegara Govt",
                "tanggal" => "2024-02-10",
                "kredensial" => "KUKAR-CSIRT-001",
                "status" => "Valid",
                "deskripsi" => "Sertifikat penghargaan atas pelaporan kerentanan (XSS & Open Redirect) pada sistem website pemerintah daerah.",
                "skill" => ["Penetration Testing", "Ethical Hacking", "Reporting"],
                "link" => "#",
                "foto" => "sample.jpg"
            ],
            [
                "judul" => "Backend Developer Expert",
                'slug' => Str::slug('Backend Developer Expert'),
                "type" => "Certificate",
                "issued" => "Dicoding Indonesia",
                "tanggal" => "2024-01-05",
                "kredensial" => "DICODING-BE-EXP",
                "status" => "Valid",
                "deskripsi" => "Menyelesaikan kurikulum backend expert menggunakan Node.js, Hapi Framework, dan database PostgreSQL.",
                "skill" => ["Node.js", "Hapi", "PostgreSQL", "API Design"],
                "link" => "https://dicoding.com/certificates/xyz",
                "foto" => "sample.jpg"
            ],
            [
                "judul" => "IoT Specialist Fundament",
                'slug' => Str::slug('IoT Specialist Fundament'),
                "type" => "Certificate",
                "issued" => "Udemy",
                "tanggal" => "2022-11-20",
                "kredensial" => "UC-123456",
                "status" => "Valid",
                "deskripsi" => "Penguasaan dasar mikrokontroler ESP32, protokol MQTT, dan integrasi cloud platform.",
                "skill" => ["ESP32", "Microcontroller", "Sensors"],
                "link" => "#",
                "foto" => "sample.jpg"
            ],
            [
                "judul" => "Networking Essentials",
                'slug' => Str::slug('Networking Essentials'),
                "icon" => "fa-solid fa-shield-halved",
                "type" => "Certificate",
                "issued" => "Cisco Networking Academy",
                "tanggal" => "2022-05-15",
                "kredensial" => "CISCO-NET-001",
                "status" => "Valid",
                "deskripsi" => "Pemahaman fundamental tentang infrastruktur jaringan, subnetting, routing, dan keamanan jaringan dasar.",
                "skill" => ["Networking", "Cisco Packet Tracer", "Subnetting"],
                "link" => "#",
                "foto" => "sample.jpg"
            ]
        ];

        foreach ($certs as $cert) {
            Certificate::create($cert);
        }
    }
}
