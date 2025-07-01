<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('tasks', function (Blueprint $table) {
            $table->id();

            // ربط بالمشروع
            $table->foreignId('project_id')->constrained()->onDelete('cascade');

            // عنوان ووصف المهمة
            $table->string('title');
            $table->text('description')->nullable();

            // حالة المهمة
            $table->enum('status', ['pending', 'in_progress', 'completed'])->default('pending');

            // التواريخ
            $table->date('start_date')->nullable();
            $table->date('due_date')->nullable();

            // أولوية المهمة
            $table->enum('priority', ['low', 'medium', 'high'])->default('medium');

            // نسبة التقدم
            $table->unsignedTinyInteger('progress')->default(0);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tasks');
    }
};
