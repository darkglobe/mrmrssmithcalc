<?php

use App\Http\Controllers\CalculatorController;
use Illuminate\Support\Facades\Route;

Route::get('/', [CalculatorController::class, 'calculator']);
Route::get('/calculator', [CalculatorController::class, 'calculator']);
Route::get('/calculate', [CalculatorController::class, 'calculator']);
Route::post('/calculate', [CalculatorController::class, 'calculate']);
