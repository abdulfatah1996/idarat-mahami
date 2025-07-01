<?php

namespace App\Livewire\Project\Tasks;

use Livewire\Component;
use App\Models\Task;
use App\Models\Project;
use App\Models\Notification;
use Illuminate\Support\Facades\Auth;

class Edit extends Component
{
    public $projects = [];
    public Task $task;
    public $project_id;
    public $title;
    public $priority = 'medium';
    public $description;
    public $start_date;
    public $due_date;
    public $status = 'pending';
    public $progress = 0;

    public bool $showToast = false;
    public string $message = '';
    public string $type = 'success';

    public function mount($taskId)
    {
        $this->task = Task::findOrFail($taskId);

        $this->projects = Project::where('owner_id', Auth::id())->get();

        $this->project_id = $this->task->project_id;
        $this->title = $this->task->title;
        $this->priority = $this->task->priority;
        $this->description = $this->task->description;
        $this->start_date = $this->task->start_date?->format('Y-m-d');
        $this->due_date = $this->task->due_date?->format('Y-m-d');
        $this->status = $this->task->status;
        $this->progress = $this->task->progress;
    }

    public function updateTask()
    {
        $this->validate([
            'project_id' => 'required|exists:projects,id',
            'title' => 'required|string|max:255',
            'priority' => 'required|in:low,medium,high',
            'description' => 'nullable|string',
            'start_date' => 'nullable|date',
            'due_date' => 'nullable|date|after_or_equal:start_date',
            'status' => 'required|in:pending,in_progress,completed',
            'progress' => 'required|integer|min:0|max:100',
        ]);

        $this->task->update([
            'project_id' => $this->project_id,
            'title' => $this->title,
            'priority' => $this->priority,
            'description' => $this->description,
            'start_date' => $this->start_date,
            'due_date' => $this->due_date,
            'status' => $this->status,
            'progress' => $this->progress,
        ]);

        // 🛎️ إشعار بتعديل المهمة
        Notification::create([
            'user_id' => Auth::id(),
            'title' => 'تم تعديل المهمة',
            'body' => $this->title,
            'icon' => 'ti ti-edit-circle',
            'url' => route('tasks.show', $this->task->id),
        ]);

        $this->showToast('تم تحديث المهمة بنجاح', 'success');
        redirect()->route('tasks.index');
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
        return view('livewire.project.tasks.edit');
    }
}
