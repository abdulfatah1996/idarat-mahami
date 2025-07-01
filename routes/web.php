<?php

use Illuminate\Support\Facades\Route;
use App\Livewire\Auth\Login;
use App\Livewire\Auth\Register;
use App\Livewire\Dashboard;
use Illuminate\Support\Facades\Auth;
use App\Livewire\User\Profile;
use App\Models\Project;
use App\Livewire\Project as ProjectLivewire;
use App\Livewire\Project\Tasks as TasksLivewire;
use App\Livewire\Ui\Notifications;



Route::get('/', function () {
    return view('welcome');
});


Route::group(['middleware' => 'guest'], function () {
    Route::get('/login', Login::class)->name('login');
    Route::get('/register', Register::class)->name('register');
    Route::get('/forgot-password', function () {
        return 'صفحة إعادة كلمة المرور (قيد الإنشاء)';
    })->name('password.request');
});


Route::group(['middleware' => 'auth'], function () {
    Route::get('/dashboard', Dashboard::class)->name('dashboard');
    Route::get('/profile', Profile::class)->name('profile');
    Route::post('/logout', function () {
        Auth::logout();
        request()->session()->invalidate();
        request()->session()->regenerateToken();
        return redirect()->route('login');
    })->name('logout');


    // Project Routes
    // Create a new project
    Route::get('/projects/create', ProjectLivewire\Create::class)->name('projects.create');
    // List and Show Projects
    Route::get('/projects', ProjectLivewire\Index::class)->name('projects.index');
    // Show a specific project
    Route::get('/projects/{id}', ProjectLivewire\Show::class)->name('projects.show');

    // Edit project
    Route::get('/projects/{id}/edit', ProjectLivewire\Edit::class)->name('projects.edit');

    // Task Routes
    // Create a new task
    Route::get('/tasks/create', TasksLivewire\Create::class)->name('tasks.create');
    // List tasks for a project
    Route::get('/tasks', TasksLivewire\Index::class)->name('tasks.index');
    // Show a specific task
    Route::get('/tasks/{taskId}/show', TasksLivewire\Show::class)->name('tasks.show');
    // // Edit a specific task
    Route::get('/tasks/{taskId}/edit', TasksLivewire\Edit::class)->name('tasks.edit');


    // Notifications
    Route::get('/notifications', App\Livewire\Notifications\Index::class)->name('notifications.index');
});
