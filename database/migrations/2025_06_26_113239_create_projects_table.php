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
        Schema::create('projects', function (Blueprint $table) {
            $table->id();
            $table->string('number')->unique()->nullable();
            $table->string('name');
            $table->string('slug')->unique();
            $table->text('description')->nullable();
            $table->enum('status', ['new', 'in_progress', 'completed'])->default('new');
            $table->enum('priority', ['low', 'medium', 'high'])->default('medium');
            $table->unsignedTinyInteger('progress')->default(0); // 0 to 100
            $table->decimal('budget', 10, 2)->nullable();
            $table->string('client_name')->nullable();
            $table->boolean('is_archived')->default(false);
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            $table->foreignId('owner_id')->constrained('users')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('projects');
    }
};
