<?php

namespace Database\Seeders;

use App\Models\Project;
use App\Models\Task;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class TaskSeeder extends Seeder
{
    public function run(): void
    {
        $projects = Project::all();

        foreach ($projects as $project) {
            for ($i = 1; $i <= 3; $i++) {
                Task::create([
                    'project_id' => $project->id,
                    'title' => "مهمة رقم {$i} للمشروع {$project->name}",
                    'description' => "تفاصيل المهمة رقم {$i} المرتبطة بالمشروع {$project->name}",
                    'priority' => ['low', 'medium', 'high'][array_rand(['low', 'medium', 'high'])],
                    'status' => ['pending', 'in_progress', 'completed'][array_rand(['pending', 'in_progress', 'completed'])],
                    'start_date' => now()->subDays(rand(1, 10)),
                    'due_date' => now()->addDays(rand(5, 15)),
                    'progress' => rand(0, 100),
                ]);
            }
        }
    }
}
