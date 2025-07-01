<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class Project extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'number',
        'slug',
        'description',
        'status',
        'priority',
        'progress',
        'budget',
        'client_name',
        'is_archived',
        'start_date',
        'end_date',
        'owner_id',
    ];
    protected $casts = [
        'start_date' => 'datetime',
        'end_date' => 'datetime',
        'is_archived' => 'boolean',
    ];
    // العلاقة مع المستخدم
    public function owner()
    {
        return $this->belongsTo(User::class, 'owner_id');
    }

    // توليد slug تلقائي عند إنشاء المشروع
    protected static function booted()
    {
        static::creating(function ($project) {
            // توليد الـ slug مع نهاية عشوائية لضمان التفرّد
            $project->slug = Str::slug($project->name) . '-' . Str::random(5);

            // توليد الرقم التسلسلي للمشروع (P + آخر رقمين من السنة + رقم متسلسل)
            $year = now()->format('y'); // مثلاً: 25 للسنة 2025
            $count = DB::table('projects')
                ->whereYear('created_at', now()->year)
                ->count() + 1;

            $serial = str_pad($count, 3, '0', STR_PAD_LEFT);
            $project->number = 'P' . $year . $serial;
        });
    }

    public function tasks()
    {
        return $this->hasMany(Task::class);
    }
}
