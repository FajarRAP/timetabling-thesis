<?php

use App\Supports\GeneticAlgorithm;
use Illuminate\Support\Facades\Route;

Route::get('generate', function () {
    $ga = new GeneticAlgorithm(
        populationSize: 5,
        maxGeneration: 1000,
        mutationRate: .75,
    );
    $result = $ga->generate();

    return response()->json($result);
});
