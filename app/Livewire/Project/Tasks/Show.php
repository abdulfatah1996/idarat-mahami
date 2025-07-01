<?php

namespace App\Livewire\Project\Tasks;

use Livewire\Component;
use App\Models\Task;
use App\Models\Project;

class Show extends Component
{
    public function render()
    {
        return view('livewire.project.tasks.show');
    }
}
