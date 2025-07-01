<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Project;
use App\Models\User;
use Illuminate\Support\Str;
use Carbon\Carbon;

class ProjectSeeder extends Seeder
{
    public function run(): void
    {
        Project::truncate();

        $user = User::first() ?? User::factory()->create();
        $projects = [
            [
                'name' => 'منصة التعليم الذكي',
                'description' => 'نظام لإدارة التعليم عن بعد للمدارس والجامعات.',
                'status' => 'in_progress',
                'priority' => 'high',
                'progress' => 60,
                'budget' => 15000,
                'client_name' => 'أكاديمية النجاح',
            ],
            [
                'name' => 'نظام حجوزات العيادات',
                'description' => 'تطبيق لحجز المواعيد في العيادات الطبية.',
                'status' => 'new',
                'priority' => 'medium',
                'progress' => 0,
                'budget' => 8000,
                'client_name' => 'مستشفى الشفاء',
            ],
            [
                'name' => 'موقع تجارة إلكترونية',
                'description' => 'متجر إلكتروني لبيع المنتجات التقنية.',
                'status' => 'completed',
                'priority' => 'high',
                'progress' => 100,
                'budget' => 20000,
                'client_name' => 'تقني ماركت',
            ],
            [
                'name' => 'نظام إدارة المهام',
                'description' => 'لوحة تحكم لتوزيع ومتابعة المهام بين الفريق.',
                'status' => 'in_progress',
                'priority' => 'low',
                'progress' => 35,
                'budget' => 6000,
                'client_name' => 'شركة الإنجاز',
            ],
            [
                'name' => 'تطبيق متابعة الحملات الإعلانية',
                'description' => 'أداة لتتبع أداء الحملات الرقمية على فيسبوك وجوجل.',
                'status' => 'new',
                'priority' => 'medium',
                'progress' => 0,
                'budget' => 10000,
                'client_name' => 'وكالة سمارت ميديا',
            ],
            [
                'name' => 'موقع حجز سيارات',
                'description' => 'نظام حجز وإدارة سيارات الأجرة في المدن.',
                'status' => 'in_progress',
                'priority' => 'medium',
                'progress' => 50,
                'budget' => 12000,
                'client_name' => 'تاكسي بلس',
            ],
            [
                'name' => 'نظام محاسبة صغير',
                'description' => 'تطبيق محاسبي بسيط مخصص لأصحاب المشاريع الصغيرة.',
                'status' => 'new',
                'priority' => 'low',
                'progress' => 10,
                'budget' => 5000,
                'client_name' => 'مركز المحاسبين العرب',
            ],
            [
                'name' => 'منصة وظائف مصغّرة',
                'description' => 'موقع لعرض فرص العمل عن بعد والمهام المصغرة.',
                'status' => 'completed',
                'priority' => 'high',
                'progress' => 100,
                'budget' => 14000,
                'client_name' => 'وظفني الآن',
            ],
            [
                'name' => 'تطبيق متابعة الطلاب',
                'description' => 'تطبيق مخصص للمعلمين لمتابعة تقدم الطلاب بشكل يومي.',
                'status' => 'in_progress',
                'priority' => 'medium',
                'progress' => 75,
                'budget' => 9000,
                'client_name' => 'مدرسة النجاح',
            ],
            [
                'name' => 'موقع تعريفي لمكتب محاماة',
                'description' => 'موقع رسمي لعرض خدمات مكتب المحامي محمد.',
                'status' => 'completed',
                'priority' => 'low',
                'progress' => 100,
                'budget' => 3000,
                'client_name' => 'مكتب العدالة',
            ],
        ];

        foreach ($projects as $data) {
            Project::create([
                'name' => $data['name'],
                'slug' => Str::slug($data['name']) . '-' . uniqid(),
                'description' => $data['description'],
                'status' => $data['status'],
                'priority' => $data['priority'],
                'progress' => $data['progress'],
                'budget' => $data['budget'],
                'client_name' => $data['client_name'],
                'owner_id' => 1, // غيّره حسب المستخدم المطلوب
                'start_date' => Carbon::now()->subDays(rand(10, 30)),
                'end_date' => Carbon::now()->addDays(rand(5, 30)),
            ]);
        }
        echo "Done seeding projects.\n";
    }
}
