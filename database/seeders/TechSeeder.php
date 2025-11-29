<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Tech;

class TechSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Tech::truncate(); // Opsional: Hapus data lama

        $techs = [
            [
                'judul' => 'PHP',
                'foto' => 'php.png'
            ],
            [
                'judul' => 'C#',
                'foto' => 'cs.png'
            ],
            [
                'judul' => 'JavaScript',
                'foto' => 'javascript.png'
            ],
            [
                'judul' => 'Node.js',
                'foto' => 'nodejs.png'
            ],
            [
                'judul' => 'Python',
                'foto' => 'python.png'
            ],
            [
                'judul' => 'Go (Golang)',
                'foto' => 'go.png'
            ],
            [
                'judul' => 'MySQL',
                'foto' => 'mysql.png'
            ],
            [
                'judul' => 'React JS',
                'foto' => 'reactjs.png'
            ],
            [
                'judul' => 'Arduino',
                'foto' => 'arduino.png'
            ],
            [
                'judul' => 'C++',
                'foto' => 'cpp.png'
            ],
            [
                'judul' => 'CSS3',
                'foto' => 'css.png'
            ],
            [
                'judul' => 'Java',
                'foto' => 'java.png'
            ],
        ];

        // Loop untuk insert data sekaligus
        foreach ($techs as $tech) {
            Tech::create($tech);
        }
    }
}
