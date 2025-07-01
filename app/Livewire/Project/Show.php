<?php

namespace App\Livewire\Project;

use Livewire\Component;
use Livewire\Attributes\Title;
use App\Models\Project;
use App\Models\Task;
use Illuminate\Support\Facades\Auth;

#[Title('عرض المشروع')]
class Show extends Component
{
    public $projectId;
    public $project;
    public $showDeleteConfirmation = false;
    public $createTaskModal = false; // Modal for creating a new task


    // Properties for the task creation form
    public string $title = '';
    public string $description = '';
    public string $status = 'pending'; // Default status
    public string $priority = 'medium'; // Default priority
    public int $progress = 0; // Default progress
    public ?string $start_date = null; // Default start date
    public ?string $end_date = null; // Default end date


    // toast
    public bool $showToast = false;
    public string $message = '';
    public string $type = 'success'; // success, danger, info, warning


    protected $rules = [
        'title' => 'required|string|max:255',
        'description' => 'nullable|string',
        'status' => 'required|in:pending,in_progress,completed',
        'priority' => 'required|in:low,medium,high',
        'progress' => 'required|integer|min:0|max:100',
        'start_date' => 'nullable|date',
        'end_date' => 'nullable|date|after_or_equal:start_date',
    ];

    protected $messages = [
        'title.required' => 'يرجى إدخال عنوان المهمة',
        'description.string' => 'يجب أن يكون وصف المهمة نصًا',
        'status.required' => 'يرجى تحديد حالة المهمة',
        'priority.required' => 'يرجى تحديد أولوية المهمة',
        'progress.required' => 'يرجى إدخال نسبة تقدم المهمة',
        'start_date.date' => 'يرجى إدخال تاريخ بدء صالح',
        'end_date.date' => 'يرجى إدخال تاريخ انتهاء صالح',
        'end_date.after_or_equal' => 'يجب أن يكون تاريخ الانتهاء بعد أو يساوي تاريخ البدء',
    ];

    public function mount($id)
    {
        $this->projectId = $id;
        $this->showDeleteConfirmation = false; // Initialize the confirmation modal state
        $this->createTaskModal = false; // Initialize the create task modal state
        // Load the project data
        $this->loadProject();
    }


    public function confirmDelete($taskId)
    {
        $this->showDeleteConfirmation = true;
    }


    public function ShowCreateTaskModal()
    {
        $this->createTaskModal = true;
    }

    public function createTask()
    {
        $project = Auth::user()->projects()->find($this->projectId);
        if (!$project) {
            $this->showToast('المشروع غير موجود', 'danger');
            return;
        }

        // Validate the task data
        $this->validate();
        // Create a new task
        $task = new Task();
        $task->project_id = $this->projectId; // Set the project ID
        $task->title = $this->title;
        $task->description = $this->description;
        $task->status = $this->status;
        $task->priority = $this->priority;
        $task->progress = $this->progress;
        $task->start_date = $this->start_date;
        $task->due_date = $this->end_date; // Use due_date as per the database schema
        $task->save(); // Save the task to the database
        $this->createTaskModal = false; // Close the modal after creating a task
        $this->showToast('تم إنشاء المهمة بنجاح', 'success');
        $this->loadProject(); // Reload the project to reflect changes
    }

    public function deleteTask($taskId)
    {
        $task = Auth::user()->projects()->find($this->projectId)->tasks()->find($taskId);
        if ($task) {
            $task->delete();
            $this->showDeleteConfirmation = false; // Close the confirmation modal after deletion
            $this->showToast('تم حذف المهمة بنجاح', 'success');
        } else {
            $this->showToast('المهمة غير موجودة', 'danger');
        }
        $this->loadProject(); // Reload the project to reflect changes
    }

    public function loadProject()
    {
        $this->project = Project::find($this->projectId);
    }

    public function showToast(string $message, string $type = 'success')
    {
        $this->message = $message;
        $this->type = $type;
        $this->showToast = true;

        // سيختفي بعد 3 ثواني باستخدام wire:poll في الواجهة
    }

    public function hideToast()
    {
        $this->showToast = false;
    }



    public function render()
    {
        return view('livewire.project.show');
    }
}
