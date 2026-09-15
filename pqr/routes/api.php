<?php

use App\Http\Controllers\PqrController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('/pqrs', [PqrController::class, 'store'])
    ->name('api.pqrs.store');