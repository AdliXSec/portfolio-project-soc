<?php

namespace Database\Factories;

use App\Models\Project;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class ProjectFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Project::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $projectTypes = ['Web Development', 'Mobile App', 'Cyber Security', 'IoT', 'UI/UX Design'];
        $technologies = ['Laravel', 'Vue.js', 'React', 'Node.js', 'Python', 'PHP', 'MySQL', 'MongoDB', 'AWS', 'Docker', 'Kubernetes', 'Tailwind CSS', 'Bootstrap'];
        $clients = ['Dinas XYZ', 'PT Maju Mundur', 'Startup ABC', 'Personal Project', 'Freelance Client'];
        $roles = ['Fullstack Developer', 'Frontend Developer', 'Backend Developer', 'UI/UX Designer', 'DevOps Engineer', 'Security Consultant'];

        $title = $this->faker->sentence(rand(3, 7));
        $slug = Str::slug($title);
        $description = $this->faker->paragraph(rand(3, 7));
        $features = $this->faker->sentences(rand(2, 4));
        $gallery = [$this->faker->imageUrl(), $this->faker->imageUrl()];
        $techStack = $this->faker->randomElements($technologies, rand(2, 5));
        $website = $this->faker->boolean(70) ? $this->faker->url() : null;
        $source = $this->faker->boolean(50) ? $this->faker->url() : null;

        return [
            'judul' => $title,
            'slug' => $slug,
            'type' => $this->faker->randomElement($projectTypes),
            'deskripsi' => $description,
            'fitur' => $features,
            'galery' => $gallery,
            'client' => $this->faker->randomElement($clients),
            'role' => $this->faker->randomElement($roles),
            'tanggal' => $this->faker->dateTimeBetween('-2 years', 'now')->format('Y-m-d'),
            'teknologi' => $techStack,
            'website' => $website,
            'source' => $source,
        ];
    }
}