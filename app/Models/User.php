<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * الخصائص القابلة للملء الجماعي (Mass Assignment).
     */
    protected $fillable = [
        'name',
        'username',
        'email',
        'phone',
        'country',
        'city',
        'address',
        'postal_code',
        'birth_date',
        'bio',
        'avatar',
        'role',
        'is_active',
        'is_verified',
        'password',
    ];

    /**
     * الخصائص التي يتم إخفاؤها عند التحويل لـ JSON أو Array.
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * تحويل بعض الخصائص لأنواع مناسبة.
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'birth_date' => 'date',
        'is_active' => 'boolean',
        'is_verified' => 'boolean',
    ];

    /**
     * سمات إضافية ممكنة (مثلاً avatar_url).
     */
    protected $appends = [
        'avatar_url',
    ];

    /**
     * رابط الصورة الرمزية كاملاً.
     */
    public function getAvatarUrlAttribute()
    {
        return $this->avatar
            ? asset('storage/' . $this->avatar)
            : asset('assets/images/users/user-default.jpg');
    }


    /**
     * التحقق مما إذا كان المستخدم مشرف.
     */
    public function isAdmin()
    {
        return $this->role === 'admin';
    }

    public function getRoleLabelAttribute(): string
    {
        return match ($this->role) {
            'admin' => 'مدير النظام',
            'user' => 'مستخدم عادي',
            default => 'مستخدم'
        };
    }

    /**
     * العلاقة مع المشاريع التي أنشأها المستخدم.
     */
    public function projects()
    {
        return $this->hasMany(Project::class, 'owner_id');
    }
}
