<?php

namespace App\Livewire\Project\Chart;

use Livewire\Component;
use App\Models\Project;
use Illuminate\Support\Facades\Auth;

class StatusChart extends Component
{
    public $statusLabels = [];
    public $statusCounts = [];
    public $statusSummary = [];

    public function mount()
    {
        $statuses = [
            'new' => 'جديد',
            'in_progress' => 'قيد التنفيذ',
            'completed' => 'مكتمل'
        ];

        $data = Project::where('owner_id', Auth::id())
            ->selectRaw('status, COUNT(*) as count')
            ->groupBy('status')
            ->pluck('count', 'status');

        foreach ($statuses as $key => $label) {
            $this->statusLabels[] = $label;
            $this->statusCounts[] = $data[$key] ?? 0;
            $this->statusSummary[] = [
                'label' => $label,
                'count' => $data[$key] ?? 0
            ];
        }
    }
    public function render()
    {
        $firstProjectDate = \App\Models\Project::orderBy('start_date')->value('start_date');
        $lastProjectDate = \App\Models\Project::orderByDesc('end_date')->value('end_date');

        $dateRange = null;

        if ($firstProjectDate && $lastProjectDate) {
            $dateRange = $firstProjectDate->format('m-Y') . ' إلى ' . $lastProjectDate->format('m-Y');
        }
        return view('livewire.project.chart.status-chart', [
            'dateRange' => $dateRange,
        ]);
    }
}
