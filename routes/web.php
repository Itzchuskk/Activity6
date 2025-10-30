<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\TestController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/users', [UserController::class, 'index'])->name('users.index');
});

Route::prefix('test')->group(function () {
    Route::get('/index',        [TestController::class, 'index'])->name('test.index');     // GET todos
    Route::get('/create',       [TestController::class, 'create'])->name('test.create');   // CREA uno
    Route::get('/read/{id}',    [TestController::class, 'read'])->name('test.read');       // GET uno
    Route::get('/update/{id}',  [TestController::class, 'update'])->name('test.update');   // UPDATE uno
    Route::get('/delete/{id}',  [TestController::class, 'delete'])->name('test.delete');   // DELETE uno
});


require __DIR__.'/auth.php';

use App\Http\Controllers\CourseController;

Route::resource('courses', CourseController::class);
Route::view('/kits', 'kits.index')->name('kits.index');

