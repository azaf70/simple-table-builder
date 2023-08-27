<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TableTemplateController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

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
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::name('table-template.')->group(function () {
        Route::get('/table-template', [TableTemplateController::class, 'index'])->name('index');
//        Route::get('/table-template/create', [TableTemplateController::class, 'create'])->name('create');
        Route::post('/table-template', [TableTemplateController::class, 'store'])->name('store');
//        Route::get('/table-template/{table}', [TableTemplateController::class, 'show'])->name('show');
//        Route::get('/table-template/{table}/edit', [TableTemplateController::class, 'edit'])->name('edit');
//        Route::put('/table-template/{table}', [TableTemplateController::class, 'update'])->name('update');
//        Route::delete('/table-template/{table}', [TableTemplateController::class, 'destroy'])->name('destroy');
    });
});

require __DIR__.'/auth.php';
