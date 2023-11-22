<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AreaController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return redirect('/login');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
});

Route::middleware(['auth', 'verified'])->group(function() {
    Route::get('/projects', [ProjectController::class, 'index'])->name('projects');
    Route::get('/projects/search', [ProjectController::class, 'search'])->name('projects.search');
    Route::get('/projects/addProject', function(){return view('contents.project-management.add-project');})->name('add.project');
    Route::post('/projects/create', [ProjectController::class, 'addProject'])->name('project.create');
    Route::get('/projects/update/{id}' , [ProjectController::class , 'updateProjectForm'])->name('project.updateForm');
    Route::patch('/projects/updating/{id}' , [ProjectController::class , 'updateProject'])->name('project.update');
    Route::get('/projects/{typeSorting}', [ProjectController::class, 'sorting'])->name('sorting');

    Route::get('/projects/{project_id}/areas', [AreaController::class, 'index'])->name('areas.index');
    Route::get('/projects/{project_id}/areas/addArea', [AreaController::class, 'showAddAreaForm'])->name('add.area');
    Route::post('/projects/{project_id}/areas/create', [AreaController::class, 'addArea'])->name('area.create');
    Route::get('/projects/areas/update/{id}' , [AreaController::class , 'updateFormArea'])->name('area.updateForm');
    Route::patch('/projects/areas/updating/{id}' , [AreaController::class , 'updateArea'])->name('area.update');

    // Ini untuk user dengan role Admin aja
    Route::middleware('admin')->group(function() {
        Route::get('/workers', [UserController::class, 'index'])->name('workers');
        Route::get('/workers/search', [UserController::class, 'search'])->name('workers.search');
        Route::get('/workers/{user_id}', [UserController::class, 'show'])->name('worker.detail');

        Route::delete('/workers/{user_id}', [UserController::class, 'destroy'])->name('worker.destroy');
    });
});

require __DIR__.'/auth.php';
