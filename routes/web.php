<?php

use App\Http\Controllers\DocumentationController;
use App\Http\Controllers\FileController;
use App\Models\Documentation;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

//Documentation
Route::get('/readDocumentation', [DocumentationController::class, 'index'])->name('documentation.read');
Route::get('/addForm', function(){return view('documentation.addForm');})->name('documentation.addForm');
Route::post('/createDocumentation', [DocumentationController::class, 'addDocumentation'])->name('documentation.create');
Route::get('/update/{id}' , [DocumentationController::class , 'updateDocumentationForm'])->name('documentation.update');
Route::patch('/updating/{id}' , [DocumentationController::class , 'updateDocumentationLogic'])->name('documentation.updating');
Route::delete('/delete/{id}', [DocumentationController::class, 'deleteDocumentation'])->name('documentation.delete');

//Surat Penting
Route::get('/readFile', [FileController::class, 'index'])->name('file.read');
Route::get('/addForm', function(){return view('suratPenting.addForm');})->name('file.addForm');
Route::post('/createFile', [FileController::class, 'addFile'])->name('file.create');
Route::get('/update/{id}' , [FileController::class , 'updateFileForm'])->name('file.update');
Route::patch('/updating/{id}' , [FileController::class , 'updateFileLogic'])->name('file.updating');
Route::delete('/delete/{id}', [FileController::class, 'deleteFile'])->name('file.delete');