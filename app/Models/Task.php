<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Task extends Model
{
    use HasFactory;

    protected $fillable = [
        'project_id',
        'title',
        'description',
        'status',
        'start_date',
        'due_date',
        'priority',
        'progress',
    ];

    protected $casts = [
        'start_date' => 'date',
        'due_date' => 'date',
        'progress' => 'integer',
    ];

    // 🔁 علاقة مع المشروع
    public function project()
    {
        return $this->belongsTo(Project::class);
    }
}
