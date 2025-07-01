<?php

namespace App\Livewire\Project\Tasks;

use Livewire\Component;
use App\Models\Project;
use Illuminate\Support\Facades\Auth;
use App\Models\Task;

class Index extends Component
{
    public $projects;

    public $showDeleteConfirmation = false;

    // toast
    public bool $showToast = false;
    public string $message = '';
    public string $type = 'success'; // success, danger, info, warning

    public function mount()
    {
        // Fetch projects owned by the authenticated user
        $this->projects = Project::where('owner_id', Auth::id())
            ->whereHas('tasks') // فقط المشاريع التي تحتوي على مهام
            ->with('tasks')     // تحميل المهام المرتبطة
            ->get();
    }
    public function confirmDelete($taskId)
    {
        $this->showDeleteConfirmation = true;
    }
    public function loadProjects()
    {
        $this->projects = Project::where('owner_id', Auth::id())
            ->whereHas('tasks')
            ->with('tasks')
            ->get();
    }

    public function deleteTask(Task $task)
    {
        if ($task) {
            $task->delete();
            $this->showDeleteConfirmation = false; // Close the confirmation modal after deletion
            $this->showToast('تم حذف المهمة بنجاح', 'success');
        } else {
            $this->showToast('المهمة غير موجودة', 'danger');
        }
        $this->loadProjects(); // Reload the project to reflect changes
    }

    public function showToast(string $message, string $type = 'success')
    {
        $this->message = $message;
        $this->type = $type;
        $this->showToast = true;
    }

    public function hideToast()
    {
        $this->showToast = false;
    }
    public function render()
    {
        return view('livewire.project.tasks.index');
    }
}
