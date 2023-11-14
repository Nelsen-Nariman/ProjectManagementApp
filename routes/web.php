<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\UserController;
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

    // Ini untuk user dengan role Admin aja
    Route::middleware('admin')->group(function() {
        Route::get('/workers', [UserController::class, 'index'])->name('workers');
        Route::get('/workers/search', [UserController::class, 'search'])->name('workers.search');
        Route::get('/workers/{user_id}', [UserController::class, 'show'])->name('worker.detail');

        Route::delete('/workers/{user_id}', [UserController::class, 'destroy'])->name('worker.destroy');
    });
});

require __DIR__.'/auth.php';
