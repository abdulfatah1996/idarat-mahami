<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;

class ProjectsExport implements FromCollection
{
    protected $projects;

    public function __construct($projects)
    {
        $this->projects = $projects;
    }

    public function collection()
    {
        return $this->projects;
    }
}
