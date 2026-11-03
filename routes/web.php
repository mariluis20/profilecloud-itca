<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DirectoryController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Student\ProfileController;
use App\Http\Controllers\Student\ProjectController;
use App\Http\Controllers\Student\SkillController;
use App\Http\Middleware\EnsureUserHasRole;
use App\Http\Middleware\EnsureUserIsActive;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/perfiles', [DirectoryController::class, 'index'])->name('directory.index');
Route::get('/perfiles/{profile:slug}', [DirectoryController::class, 'show'])->name('directory.show');

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.attempt');
    Route::get('/registro', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/registro', [AuthController::class, 'register'])
        ->middleware('throttle:5,1')
        ->name('register.store');
});

Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth')->name('logout');

Route::middleware(['auth', EnsureUserIsActive::class])->group(function () {
    Route::get('/panel', DashboardController::class)->name('dashboard');

    Route::middleware(EnsureUserHasRole::class.':estudiante')
        ->prefix('panel')
        ->name('student.')
        ->group(function () {
            Route::get('/perfil', [ProfileController::class, 'edit'])->name('profile.edit');
            Route::put('/perfil', [ProfileController::class, 'update'])->name('profile.update');

            Route::post('/habilidades', [SkillController::class, 'store'])->name('skills.store');
            Route::delete('/habilidades/{skill}', [SkillController::class, 'destroy'])->name('skills.destroy');

            Route::get('/proyectos/nuevo', [ProjectController::class, 'create'])->name('projects.create');
            Route::post('/proyectos', [ProjectController::class, 'store'])->name('projects.store');
            Route::get('/proyectos/{project}/editar', [ProjectController::class, 'edit'])->name('projects.edit');
            Route::put('/proyectos/{project}', [ProjectController::class, 'update'])->name('projects.update');
            Route::delete('/proyectos/{project}', [ProjectController::class, 'destroy'])->name('projects.destroy');
        });

    Route::middleware(EnsureUserHasRole::class.':admin')
        ->prefix('admin')
        ->name('admin.')
        ->group(function () {
            Route::get('/', [AdminController::class, 'dashboard'])->name('dashboard');
            Route::get('/usuarios', [AdminController::class, 'users'])->name('users');
            Route::patch('/usuarios/{user}/estado', [AdminController::class, 'toggle'])->name('users.toggle');
            Route::patch('/usuarios/{user}/rol', [AdminController::class, 'role'])->name('users.role');
            Route::get('/bitacora', [AdminController::class, 'logs'])->name('logs');
        });
});
