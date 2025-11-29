<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Project;
use Str;

class ProjectSeeder extends Seeder
{
    public function run(): void
    {
        // Project::truncate();

        $projects = [
            [
                'judul' => 'Marine Conservation Platform',
                'slug' => Str::slug('Marine Conservation Platform'),
                'type' => 'Web Development',
                'deskripsi' => 'A comprehensive dashboard for monitoring marine life data. Built with Laravel and Vue.js, focusing on real-time data visualization to help researchers track ocean health metrics efficiently.',
                'fitur' => [
                    "Real-time data streaming from underwater sensors.",
                    "Interactive maps using Leaflet.js.",
                    "Role-based access control (RBAC) for Admin & Researcher."
                ],
                'galery' => ["p1.png", "p1.png"], // Array gambar
                'client' => 'Dinas Kelautan Jatim',
                'role' => 'Backend & Database Architect',
                'tanggal' => '2024-08-01',
                'teknologi' => ["Laravel", "Vue.js", "MySQL", "Tailwind"],
                'website' => 'https://marine-demo.test',
                'source' => 'https://github.com/naufaladli/marine-project'
            ],
            [
                'judul' => 'Eco System Monitor',
                'slug' => Str::slug('Eco System Monitor'),
                'type' => 'IoT',
                'deskripsi' => 'IoT-based system for tracking environmental parameters in real-time. Uses Arduino sensors connected to a Node.js backend via MQTT protocol.',
                'fitur' => [
                    "MQTT Broker implementation.",
                    "Sensor calibration module.",
                    "Alert system via Telegram Bot."
                ],
                'galery' => ["p1.png"],
                'client' => 'Personal Project',
                'role' => 'IoT Engineer',
                'tanggal' => '2023-11-15',
                'teknologi' => ["Node.js", "Arduino", "MQTT", "C++"],
                'website' => null,
                'source' => 'https://github.com/naufaladli/eco-iot'
            ],
            [
                'judul' => 'Vulnerability Scanner Tool',
                'slug' => Str::slug('Vulnerability Scanner Tool'),
                'type' => 'Cyber Security',
                'deskripsi' => 'Automated penetration testing tool designed to identify common web vulnerabilities like XSS, SQL Injection, and Open Redirects automatically.',
                'fitur' => [
                    "Automated crawling.",
                    "Payload injection generator.",
                    "PDF Report generation."
                ],
                'galery' => ["p1.png"],
                'client' => 'Thesis Project',
                'role' => 'Security Researcher',
                'tanggal' => '2024-01-20',
                'teknologi' => ["Python", "Bash", "Linux", "Selenium"],
                'website' => null,
                'source' => 'https://github.com/naufaladli/vuln-scanner'
            ],
            [
                'judul' => 'Golden Hour App',
                'slug' => Str::slug('Golden Hour App'),
                'type' => 'Mobile App',
                'deskripsi' => 'An application calculating the perfect time for photography based on location. Features include weather integration and community sharing.',
                'fitur' => [
                    "GPS Location tracking.",
                    "Sun position calculation.",
                    "Community photo feed."
                ],
                'galery' => ["p1.png"],
                'client' => 'Freelance',
                'role' => 'Mobile Developer',
                'tanggal' => '2023-05-10',
                'teknologi' => ["React Native", "Firebase", "Google Maps API"],
                'website' => 'https://play.google.com/store/apps',
                'source' => null
            ]
        ];

        foreach ($projects as $project) {
            Project::create($project);
        }
    }
}
