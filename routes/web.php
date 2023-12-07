<?php


use App\Http\Controllers\DocumentationController;
use App\Http\Controllers\FileController;
use App\Http\Controllers\PDFController;
use App\Models\Documentation;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\ProjectUserController;
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
    Route::get('/projects/{project_id}/areas', [AreaController::class, 'index'])->name('areas.index');
   
  
    //Documentation
    Route::prefix('/documentation')->group(function(){
        Route::get('/read/{area_id}', [DocumentationController::class, 'index'])->name('documentation.read');
        Route::get('/addForm/{area_id}', [DocumentationController::class, 'showAddDocumentationForm'])->name('documentation.addForm');
        Route::post('/create/{area_id}', [DocumentationController::class, 'addDocumentation'])->name('documentation.create');
        Route::get('/update/{id}' , [DocumentationController::class , 'updateDocumentationForm'])->name('documentation.update');
        Route::patch('/updating/{id}' , [DocumentationController::class , 'updateDocumentationLogic'])->name('documentation.updating');
        Route::delete('/delete/{id}', [DocumentationController::class, 'deleteDocumentation'])->name('documentation.delete');
    });

    // PDF Convert
    Route::get('/pdf/convert', [PDFController::class, 'pdfGeneration'])->name('pdf.convert');

    //Surat Penting
    Route::prefix('/file')->group(function(){
        Route::get('/read/{project_id}', [FileController::class, 'index'])->name('file.read');
        Route::get('/addForm/{project_id}', [FileController::class, 'showAddFileForm'])->name('file.addForm');
        Route::post('/create/{project_id}', [FileController::class, 'addFile'])->name('file.create');
        Route::get('/update/{id}' , [FileController::class , 'updateFileForm'])->name('file.update');
        Route::patch('/updating/{id}' , [FileController::class , 'updateFileLogic'])->name('file.updating');
        Route::delete('/delete/{id}', [FileController::class, 'deleteFile'])->name('file.delete');
    });

    // Ini untuk user dengan role Admin aja
    Route::middleware('admin')->group(function() {
        Route::get('/workers', [UserController::class, 'index'])->name('workers');
        Route::get('/workers/search', [UserController::class, 'search'])->name('workers.search');
        Route::get('/workers/{user_id}', [UserController::class, 'show'])->name('worker.detail');
        Route::delete('/workers/{user_id}', [UserController::class, 'destroy'])->name('worker.destroy');

        Route::get('/workers/{user_id}/assign', [ProjectUserController::class, 'index'])->name('worker.assignForm');
        Route::post('/worker/assign', [ProjectUserController::class, 'create'])->name('worker.assign');
        Route::delete('/workers/{user_id}/{project_id}/delete', [ProjectUserController::class, 'delete'])->name('projectUser.delete');


        Route::get('/projects/addProject', function(){return view('contents.project-management.add-project');})->name('add.project');
        Route::post('/projects/create', [ProjectController::class, 'addProject'])->name('project.create');
        Route::get('/projects/search/toAssign/{user_id}', [ProjectController::class, 'searchToAssign'])->name('project.search.toAssign');
        Route::get('/projects/update/{id}' , [ProjectController::class , 'updateProjectForm'])->name('project.updateForm');
        Route::patch('/projects/updating/{id}' , [ProjectController::class , 'updateProject'])->name('project.update');
        Route::delete('/projects/delete/{id}', [ProjectController::class, 'deleteProject'])->name('project.delete');


        Route::get('/projects/{project_id}/areas/addArea', [AreaController::class, 'showAddAreaForm'])->name('add.area');
        Route::post('/projects/{project_id}/areas/create', [AreaController::class, 'addArea'])->name('area.create');
        Route::get('/projects/areas/update/{id}' , [AreaController::class , 'updateFormArea'])->name('area.updateForm');
        Route::patch('/projects/areas/updating/{id}' , [AreaController::class , 'updateArea'])->name('area.update');
        Route::delete('/projects/areas/delete/{id}', [AreaController::class, 'deleteArea'])->name('area.delete');

    });
    Route::get('/projects/{typeSorting}', [ProjectController::class, 'sorting'])->name('sorting');
});

require __DIR__.'/auth.php';
