<?php

namespace App\Livewire\Project\Chart;

use Livewire\Component;
use App\Models\Project;
use Illuminate\Support\Facades\Auth;

class BudgetChart extends Component
{
    public $labels = []; // الأشهر
    public $projectCounts = []; // عدد المشاريع
    public $budgets = []; // الميزانية

    public function mount()
    {
        $userId = Auth::id();

        $data = Project::selectRaw("strftime('%Y-%m', start_date) as month, COUNT(*) as count, SUM(budget) as total")
            ->where('owner_id', $userId)
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        $this->labels = $data->pluck('month')->map(fn($m) => \Carbon\Carbon::parse($m . '-01')->translatedFormat('F'))->toArray();
        $this->projectCounts = $data->pluck('count')->toArray();
        $this->budgets = $data->pluck('total')->map(fn($v) => (float) $v)->toArray();
    }

    public function render()
    {
        return view('livewire.project.chart.budget-chart');
    }
}
