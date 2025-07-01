<?php

namespace Database\Factories;

use App\Models\Project;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProjectFactory extends Factory
{
    protected $model = Project::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->sentence(3),
            'slug' => $this->faker->unique()->slug,
            'description' => $this->faker->paragraph,
            'status' => $this->faker->randomElement(['new', 'in_progress', 'completed']),
            'priority' => $this->faker->randomElement(['low', 'medium', 'high']),
            'progress' => $this->faker->numberBetween(0, 100),
            'budget' => $this->faker->numberBetween(1000, 100000),
            'client_name' => $this->faker->company,
            'is_archived' => false,
            'start_date' => now()->subDays(rand(1, 30)),
            'end_date' => now()->addDays(rand(10, 90)),
            // ❌ لا تكتب owner_id هنا
        ];
    }
}
