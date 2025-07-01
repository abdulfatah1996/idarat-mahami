<?php

namespace App\Livewire\Project\Tasks;

use Livewire\Component;
use Livewire\Attributes\Title;
use App\Models\Project;
use Illuminate\Support\Facades\Auth;
use App\Models\Task;
use App\Models\Notification;


#[Title('إنشاء مهمة جديدة')]
class Create extends Component
{
    public $projects;

    public $project_id;
    public string $title = '';
    public string $description = '';
    public string $status = 'pending'; // ✅ متوافق مع enum في قاعدة البيانات
    public string $priority = 'medium';
    public int $progress = 0;
    public ?string $start_date = null;
    public ?string $end_date = null;

    // Toast
    public bool $showToast = false;
    public string $message = '';
    public string $type = 'success';

    protected $rules = [
        'project_id' => 'required|exists:projects,id',
        'title' => 'required|string|max:255',
        'description' => 'nullable|string',
        'status' => 'required|in:pending,in_progress,completed',
        'priority' => 'required|in:low,medium,high',
        'progress' => 'required|integer|min:0|max:100',
        'start_date' => 'nullable|date',
        'end_date' => 'nullable|date|after_or_equal:start_date',
    ];

    protected $messages = [
        'project_id.required' => 'يرجى اختيار المشروع.',
        'project_id.exists' => 'المشروع المحدد غير موجود.',
        'title.required' => 'يرجى إدخال عنوان المهمة.',
        'status.required' => 'يرجى تحديد حالة المهمة.',
        'priority.required' => 'يرجى تحديد أولوية المهمة.',
        'progress.required' => 'يرجى تحديد نسبة الإنجاز.',
        'start_date.date' => 'تاريخ البدء غير صالح.',
        'end_date.date' => 'تاريخ الانتهاء غير صالح.',
        'end_date.after_or_equal' => 'تاريخ الانتهاء يجب أن يكون بعد أو يساوي تاريخ البدء.',
    ];

    public function mount()
    {
        $this->projects = Project::where('owner_id', Auth::id())->get();
    }

    public function createTask()
    {
        $this->validate();
        // Create a new task and associate it with the selected project
        // Create a new task
        $task = new Task();
        $task->project_id = $this->project_id; // Set the project ID
        $task->title = $this->title;
        $task->description = $this->description;
        $task->status = $this->status;
        $task->priority = $this->priority;
        $task->progress = $this->progress;
        $task->start_date = $this->start_date;
        $task->due_date = $this->end_date; // Use due_date as per the database schema
        $task->save(); // Save the task to the database
        $this->showToast('تم إنشاء المهمة بنجاح', 'success');
        Notification::create([
            'user_id' => Auth::id(),
            'title' => 'تم إنشاء مهمة جديدة',
            'body' => $this->title,
            'icon' => 'ti ti-list-check',
            'url' => route('tasks.show', $task->id),
        ]);

        $this->resetForm();
    }

    public function resetForm()
    {
        $this->project_id = '';
        $this->title = '';
        $this->description = '';
        $this->status = 'pending';
        $this->priority = 'medium';
        $this->progress = 0;
        $this->start_date = null;
        $this->end_date = null;
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
        return view('livewire.project.tasks.create');
    }
}
