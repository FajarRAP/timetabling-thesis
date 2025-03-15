<?php

use App\Http\Controllers\CourseController;
use App\Http\Controllers\DayController;
use App\Http\Controllers\GeneticAlgorithmController;
use App\Http\Controllers\LectureController;
use App\Http\Controllers\LecturerController;
use App\Http\Controllers\LectureSlotController;
use App\Http\Controllers\RoomClassController;
use App\Http\Controllers\TimeSlotController;
use Illuminate\Support\Facades\Route;

Route::apiResources([
    'courses' => CourseController::class,
    'days' => DayController::class,
    'lectures' => LectureController::class,
    'lecturers' => LecturerController::class,
    'lecture-slots' => LectureSlotController::class,
    'room-classes' => RoomClassController::class,
    'time-slots' => TimeSlotController::class,
],);

Route::get('generate', [GeneticAlgorithmController::class, 'generate']);
