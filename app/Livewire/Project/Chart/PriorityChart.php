<?php

namespace App\Livewire\Project\Chart;

use Livewire\Component;
use App\Models\Project;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;


class PriorityChart extends Component
{
    public $priorityLabels = ['منخفض', 'متوسط', 'عالٍ'];
    public $priorityCounts = [];
    public $prioritySummary = [];
    public $firstDate;
    public $lastDate;

    public function mount()
    {
        $user = Auth::user();

        $priorities = ['low', 'medium', 'high'];

        $counts = Project::where('owner_id', $user->id)
            ->selectRaw("priority, COUNT(*) as total")
            ->groupBy('priority')
            ->pluck('total', 'priority');

        $this->priorityCounts = collect($priorities)->map(fn($key) => $counts[$key] ?? 0)->toArray();

        $this->prioritySummary = collect($priorities)->map(function ($key, $index) {
            return [
                'label' => $this->priorityLabels[$index],
                'count' => $this->priorityCounts[$index],
            ];
        })->toArray();

        $this->firstDate = Project::where('owner_id', $user->id)->min('start_date');
        $this->lastDate = Project::where('owner_id', $user->id)->max('end_date');

        if ($this->firstDate) {
            $this->firstDate = Carbon::parse($this->firstDate);
        }
        if ($this->lastDate) {
            $this->lastDate = Carbon::parse($this->lastDate);
        }
    }

    public function render()
    {
        return view('livewire.project.chart.priority-chart', [
            'priorityLabels' => $this->priorityLabels,
            'priorityCounts' => $this->priorityCounts,
            'prioritySummary' => $this->prioritySummary,
            'firstDate' => $this->firstDate ? $this->firstDate->format('Y-m') : null,
            'lastDate' => $this->lastDate ? $this->lastDate->format('Y-m') : null,
        ]);
    }
}
