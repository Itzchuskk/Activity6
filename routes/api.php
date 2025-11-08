<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\CourseApiController;
use App\Http\Controllers\Api\RoboticsKitApiController;

Route::get('/health', fn() => response()->json(['ok' => true, 'ts' => now()->toIso8601String()]));

Route::prefix('v1')->group(function () {
    Route::get('courses', [CourseApiController::class, 'index'])->name('api.v1.courses.index');
    Route::post('courses', [CourseApiController::class, 'store'])->name('api.v1.courses.store');
    Route::get('courses/{id}', [CourseApiController::class, 'show'])->name('api.v1.courses.show');
    Route::put('courses/{id}', [CourseApiController::class, 'update'])->name('api.v1.courses.update');
    Route::post('courses/{course}/enroll', [CourseApiController::class, 'enroll']);
    Route::delete('courses/{course}/enroll/{user}', [CourseApiController::class, 'unenroll']);

    Route::patch('courses/{id}', [CourseApiController::class, 'update']);
    Route::delete('courses/{id}', [CourseApiController::class, 'destroy'])->name('api.v1.courses.destroy');

    Route::get('kits', [RoboticsKitApiController::class, 'index'])->name('api.v1.kits.index');
    Route::post('kits', [RoboticsKitApiController::class, 'store'])->name('api.v1.kits.store');
    Route::get('kits/{id}', [RoboticsKitApiController::class, 'show'])->name('api.v1.kits.show');
    Route::put('kits/{id}', [RoboticsKitApiController::class, 'update'])->name('api.v1.kits.update');
    Route::patch('kits/{id}', [RoboticsKitApiController::class, 'update']);
    Route::delete('kits/{id}', [RoboticsKitApiController::class, 'destroy'])->name('api.v1.kits.destroy');
});
