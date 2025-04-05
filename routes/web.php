<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RoomClassController;
use App\Http\Resources\LectureResource;
use App\Models\Course;
use App\Models\Lecture;
use App\Models\Lecturer;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware(['auth', 'verified'])->group(function () {
    Route::prefix('dashboard')->group(function () {
        Route::get('/', fn() => view('dashboard'))->name('dashboard');
        Route::controller(RoomClassController::class)->group(function () {
            Route::get('/room-class', 'index')->name('room-class');
            Route::post('/room-class', 'store')->name('room-class.store');
            Route::delete('/room-class/{roomClass}', 'destroy')->name('room-class.destroy');
        });
    });
});

Route::middleware('auth')->group(function () {
    Route::get('/lecturer', fn() => view('lecturer', ['lecturers' => Lecturer::all()]))->name('lecturer');
    Route::get('/course', fn() => view('course', ['courses' => Course::all()]))->name('course');
    Route::get('/lecture', fn() => view('lecture', ['lectures' => LectureResource::collection(Lecture::all())]))->name('lecture');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
