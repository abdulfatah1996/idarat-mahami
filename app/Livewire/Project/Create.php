<?php

namespace App\Livewire\Project;

use App\Models\Project;
use App\Models\Notification;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Illuminate\Support\Str;
use Livewire\Attributes\Title;

#[Title('إنشاء مشروع جديد')]
class Create extends Component
{
    public string $name = '';
    public string $description = '';
    public string $status = 'new';
    public string $priority = 'medium';
    public int $progress = 0;
    public ?string $start_date = null;
    public ?string $end_date = null;
    public ?float $budget = null;
    public ?string $client_name = null;

    // toast
    public bool $showToast = false;
    public string $message = '';
    public string $type = 'success'; // success, danger, info, warning

    protected $rules = [
        'name' => 'required|string|max:255',
        'description' => 'nullable|string',
        'status' => 'required|in:new,in_progress,completed',
        'priority' => 'required|in:low,medium,high',
        'progress' => 'required|integer|min:0|max:100',
        'budget' => 'nullable|numeric|min:0',
        'client_name' => 'nullable|string|max:255',
        'start_date' => 'nullable|date',
        'end_date' => 'nullable|date|after_or_equal:start_date',
    ];

    protected $messages = [
        'name.required' => 'اسم المشروع مطلوب.',
        'status.required' => 'حالة المشروع مطلوبة.',
        'priority.required' => 'أولوية المشروع مطلوبة.',
        'progress.required' => 'نسبة تقدم المشروع مطلوبة.',
        'start_date.date' => 'تاريخ البدء يجب أن يكون تاريخًا صالحًا.',
        'end_date.date' => 'تاريخ الانتهاء يجب أن يكون تاريخًا صالحًا.',
        'end_date.after_or_equal' => 'تاريخ الانتهاء يجب أن يكون بعد أو يساوي تاريخ البدء.',
    ];

    public function mount()
    {
        $this->name = '';
        $this->description = '';
        $this->status = 'new';
        $this->priority = 'medium';
        $this->progress = 0;
        $this->start_date = now()->format('Y-m-d');
        $this->end_date = null;
        $this->budget = null;
        $this->client_name = null;
    }

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }

    public function createProject()
    {
        $this->validate();

        $project = new Project();
        $project->name = $this->name;
        $project->description = $this->description;
        $project->status = $this->status;
        $project->priority = $this->priority;
        $project->progress = $this->progress;
        $project->start_date = $this->start_date ? \Carbon\Carbon::parse($this->start_date) : null;
        $project->end_date = $this->end_date ? \Carbon\Carbon::parse($this->end_date) : null;
        $project->budget = $this->budget;
        $project->client_name = $this->client_name;
        $project->owner_id = Auth::id();
        $project->slug = Str::slug($this->name) . '-' . uniqid();

        $project->save();

        // 🔔 إنشاء الإشعار
        Notification::create([
            'user_id' => Auth::id(),
            'title' => 'تم إنشاء مشروع جديد',
            'body' => $this->name,
            'icon' => 'ti ti-folder-plus',
            'url' => route('projects.show', $project->id),
        ]);

        // إعادة تعيين الحقول
        $this->reset([
            'name',
            'description',
            'status',
            'priority',
            'progress',
            'start_date',
            'end_date',
            'budget',
            'client_name',
        ]);

        $this->showToast('تم إنشاء المشروع بنجاح', 'success');
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
        return view('livewire.project.create');
    }
}
