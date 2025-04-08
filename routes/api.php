<?php

use App\Http\Controllers\GeneticAlgorithmController;
use Illuminate\Support\Facades\Route;

Route::get('generate', [GeneticAlgorithmController::class, 'generate']);
