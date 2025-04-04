<?php

use App\Http\Controllers\ProfileController;
use App\Http\Resources\LectureResource;
use App\Models\Course;
use App\Models\Lecture;
use App\Models\Lecturer;
use App\Models\RoomClass;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/lecturer', fn() => view('lecturer', ['lecturers' => Lecturer::all()]))->name('lecturer');
    Route::get('/room-class', fn() => view('room-class', ['roomClasses' => RoomClass::all()]))->name('room-class');
    Route::get('/course', fn() => view('course', ['courses' => Course::all()]))->name('course');
    Route::get('/lecture', fn() => view('lecture', ['lectures' => LectureResource::collection(Lecture::all())]))->name('lecture');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
