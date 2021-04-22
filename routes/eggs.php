<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EggController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\EggProjectionController;
use App\Http\Controllers\PDFController;

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
Route::post('/pdf/{egg}', [PDFController::class, 'create'])->name('pdf');

Route::get('/companies', [CompanyController::class, 'show'])->name('companies.show');
Route::post('/companies', [CompanyController::class, 'store'])->name('companies.store');
Route::get('/companies/edit', [CompanyController::class, 'edit'])->name('companies.edit');
Route::post('/companies/update', [CompanyController::class, 'update'])->name('companies.update');

Route::get('/', [EggController::class, 'index'])->name('eggs.index');
Route::get('/create', [EggController::class, 'create'])->name('eggs.create');
Route::post('/', [EggController::class, 'store'])->name('eggs.store');
Route::get('/show/{egg}', [EggController::class, 'show'])->name('eggs.show');
Route::get('/edit/{egg}', [EggController::class, 'edit'])->name('eggs.edit');
Route::post('/edit/{egg}', [EggController::class, 'update'])->name('eggs.update');
Route::get('/{egg}', [EggController::class, 'delete'])->name('eggs.delete');


Route::get('/projection/{egg}/{projection}', [EggProjectionController::class, 'addWeight'])->name('projection.addweight');
Route::post('/projection/{egg}/{projection}', [EggProjectionController::class, 'update'])->name('projection.update');



