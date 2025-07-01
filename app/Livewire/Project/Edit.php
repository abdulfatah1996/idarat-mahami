<?php

namespace App\Livewire\Project;

use Livewire\Attributes\Title;
use Livewire\Component;
use App\Models\Project;
use App\Models\Notification;
use Illuminate\Support\Facades\Auth;

#[Title('تعديل المشروع')]
class Edit extends Component
{
    public $projectId;
    public $project;

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
    public string $type = 'success';

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

    public function mount($id)
    {
        $this->projectId = $id;
        $this->project = Project::findOrFail($this->projectId);

        $this->name = $this->project->name;
        $this->description = $this->project->description;
        $this->status = $this->project->status;
        $this->priority = $this->project->priority;
        $this->progress = $this->project->progress;
        $this->start_date = $this->project->start_date ? $this->project->start_date->format('Y-m-d') : null;
        $this->end_date = $this->project->end_date ? $this->project->end_date->format('Y-m-d') : null;
        $this->budget = $this->project->budget;
        $this->client_name = $this->project->client_name;
    }

    public function updateProject()
    {
        $this->validate();

        $this->project->update([
            'name' => $this->name,
            'description' => $this->description,
            'status' => $this->status,
            'priority' => $this->priority,
            'progress' => $this->progress,
            'start_date' => $this->start_date,
            'end_date' => $this->end_date,
            'budget' => $this->budget,
            'client_name' => $this->client_name,
        ]);

        // 🔔 إشعار عند تعديل المشروع
        Notification::create([
            'user_id' => Auth::id(),
            'title' => 'تم تعديل المشروع',
            'body' => $this->name,
            'icon' => 'ti ti-edit-circle',
            'url' => route('projects.show', $this->project->id),
        ]);

        $this->showToast('تم تحديث المشروع بنجاح.');
        return redirect()->route('projects.index');
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
        return view('livewire.project.edit');
    }
}
