<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Testimonial;

class TestimonialSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $testimonials = [
            [
                'name' => 'John Doe',
                'position' => 'CEO, Tech Innovations',
                'testimonial' => 'Working with Naufal was an absolute pleasure. His expertise in Laravel and attention to security details made our project a success. Highly recommended!',
                'rate' => 5,
                'avatar' => null,
            ],
            [
                'name' => 'Alice Smith',
                'position' => 'Project Manager, StartupXYZ',
                'testimonial' => 'Exceptional problem-solving skills and deep understanding of cybersecurity. Naufal delivered beyond expectations and on time.',
                'rate' => 5,
                'avatar' => null,
            ],
            [
                'name' => 'Robert Brown',
                'position' => 'CTO, IoT Solutions Inc',
                'testimonial' => 'The IoT solution Naufal built for us was innovative and secure. His technical knowledge is impressive, and he\'s great to collaborate with.',
                'rate' => 4,
                'avatar' => null,
            ],
            [
                'name' => 'Emily Wilson',
                'position' => 'Security Director, FinTech Corp',
                'testimonial' => 'Naufal\'s penetration testing uncovered critical vulnerabilities we didn\'t know existed. Professional, thorough, and highly skilled.',
                'rate' => 5,
                'avatar' => null,
            ],
            [
                'name' => 'Michael Johnson',
                'position' => 'Lead Developer, Global Apps',
                'testimonial' => 'A true expert in backend development. Naufal streamlined our API processes, leading to significant performance gains. Fantastic work!',
                'rate' => 4,
                'avatar' => null,
            ],
            [
                'name' => 'Sophia Davis',
                'position' => 'HR Manager, Creative Minds',
                'testimonial' => 'Naufal is not only technically brilliant but also a great team player. His communication and dedication are outstanding.',
                'rate' => 5,
                'avatar' => null,
            ],
            [
                'name' => 'David Martinez',
                'position' => 'Product Owner, SecureNet',
                'testimonial' => 'He consistently delivers high-quality code and his focus on security is a huge asset. Our product is safer thanks to Naufal.',
                'rate' => 5,
                'avatar' => null,
            ],
            [
                'name' => 'Olivia Garcia',
                'position' => 'Marketing Lead, BrandBoost',
                'testimonial' => 'Naufal developed a custom backend for our marketing platform that perfectly met our complex needs. Highly satisfied!',
                'rate' => 4,
                'avatar' => null,
            ],
            [
                'name' => 'James Rodriguez',
                'position' => 'DevOps Engineer, CloudOps',
                'testimonial' => 'His understanding of system architecture and deployment is top-notch. Collaboration on infrastructure was seamless.',
                'rate' => 5,
                'avatar' => null,
            ],
            [
                'name' => 'Isabella Hernandez',
                'position' => 'UX Designer, PixelPerfect',
                'testimonial' => 'Naufal\'s backend work made my frontend designs come to life flawlessly. A pleasure to work with a developer who values UX.',
                'rate' => 4,
                'avatar' => null,
            ],
        ];

        foreach ($testimonials as $testimonial) {
            Testimonial::create($testimonial);
        }
    }
}
