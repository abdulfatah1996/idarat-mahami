<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\Attributes\Title;
use Livewire\Attributes\Layout;
use App\Models\Project;
use App\Models\Task;
use Illuminate\Support\Facades\Auth;

#[Layout('components.layouts.app')]
#[Title('لوحة التحكم')]
class Dashboard extends Component
{
    // المشاريع
    public int $projectsTotal = 0;
    public int $projectsCompleted = 0;
    public int $projectsInProgress = 0;

    // المهام
    public int $tasksTotal = 0;
    public int $tasksCompleted = 0;
    public int $tasksInProgress = 0;

    //last projects
    public $latestProjects = [];

    public $upcomingTasks = [];


    public function mount()
    {
        $userId = Auth::id();

        // المشاريع
        $this->projectsTotal = Project::where('owner_id', $userId)->count();
        $this->projectsCompleted = Project::where('owner_id', $userId)->where('status', 'completed')->count();
        $this->projectsInProgress = Project::where('owner_id', $userId)->where('status', 'in_progress')->count();

        // المهام عبر المشاريع المملوكة للمستخدم
        $projectIds = Project::where('owner_id', $userId)->pluck('id');

        $this->tasksTotal = Task::whereIn('project_id', $projectIds)->count();
        $this->tasksCompleted = Task::whereIn('project_id', $projectIds)->where('status', 'completed')->count();
        $this->tasksInProgress = Task::whereIn('project_id', $projectIds)->where('status', 'in_progress')->count();
        // 🆕 أحدث 5 مشاريع
        $this->latestProjects = Project::where('owner_id', $userId)
            ->latest()
            ->take(5)
            ->get();

        // ✅ أقرب 5 مهام على وشك الانتهاء
        $projectIds = \App\Models\Project::where('owner_id', $userId)->pluck('id');

        $this->upcomingTasks = \App\Models\Task::whereIn('project_id', $projectIds)
            ->whereNotNull('due_date')
            ->whereDate('due_date', '>=', today())
            ->orderBy('due_date')
            ->take(3)
            ->get();
    }


    public function render()
    {
        return view('livewire.dashboard');
    }
}
