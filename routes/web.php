<?php

use App\Http\Controllers\CourseController;
use App\Http\Controllers\LectureController;
use App\Http\Controllers\LecturerConstraintController;
use App\Http\Controllers\LecturerController;
use App\Http\Controllers\LectureSlotController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RoomClassController;
use App\Http\Controllers\TimetableController;
use App\Http\Controllers\TimetableEntryController;
use Illuminate\Support\Facades\Route;

Route::get('/', fn() => view('welcome'));

Route::middleware(['auth', 'verified'])->group(function () {
    Route::prefix('dashboard')->group(function () {
        Route::get('/', fn() => view('dashboard'))->name('dashboard');
        Route::controller(RoomClassController::class)->group(function () {
            Route::get('/room-class', 'index')->name('room-class');
            Route::post('/room-class', 'store')->name('room-class.store');
            Route::delete('/room-class/{roomClass}', 'destroy')->name('room-class.destroy');
        });
        Route::controller(CourseController::class)->group(function () {
            Route::get('/course', 'index')->name('course');
            Route::post('/course', 'store')->name('course.store');
            Route::delete('/course/{course}', 'destroy')->name('course.destroy');
        });
        Route::controller(LecturerController::class)->group(function () {
            Route::get('/lecturer', 'index')->name('lecturer');
            Route::post('/lecturer', 'store')->name('lecturer.store');
            Route::delete('/lecturer/{lecturer}', 'destroy')->name('lecturer.destroy');
        });
        Route::controller(LecturerConstraintController::class)->group(function () {
            Route::get('lecturer/{lecturer}/constraint', 'index')->name('lecturer-constraint');
            Route::post('lecturer/{lecturer}/constraint', 'store')->name('lecturer-constraint.store');
        });
        Route::controller(LectureController::class)->group(function () {
            Route::get('/lecture', 'index')->name('lecture');
            Route::post('/lecture', 'store')->name('lecture.store');
            Route::delete('/lecture/{lecture}', 'destroy')->name('lecture.destroy');
        });
        Route::controller(TimetableController::class)->group(function () {
            Route::get('/timetable', 'index')->name('timetable');
            Route::post('/timetable', 'store')->name('timetable.store');
            Route::delete('/timetable/{timetable}', 'destroy')->name('timetable.destroy');
        });
        Route::controller(TimetableEntryController::class)->group(function () {
            Route::get('/timetable/{timetable}/entry', 'index')->name('timetable-entry');
            Route::post('/timetable/{timetable}/entry', 'store')->name('timetable-entry.store');
        });
        Route::get('/lecture-slot', LectureSlotController::class)->name('lecture-slot');
    });
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
