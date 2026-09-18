<?php

use App\Http\Controllers\PqrController;
use App\Http\Controllers\PqrTrackingController;
use App\Http\Controllers\SeguimientoController;
use App\Http\Controllers\StatsController;
use App\Http\Middleware\GestorMiddleware;
use App\Http\Middleware\SupervisorMiddleware;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

//Públicas

//Registrar una nueva PQR
Route::post('/pqrs', [PqrController::class, 'store'])
    ->name('api.pqrs.store');

//Rastreo PQR
Route::get('/pqr/rastreo', [PqrTrackingController::class, 'track']);


//Agentes|Administrador|Supervisor
Route::middleware(['web', GestorMiddleware::class])->group(function () {

    //Listar PQR y aplicar filtros
    Route::get('/pqr', [PqrController::class, 'index'])->name('api.pqrs.index');

    //actualizar Gestion PQR
    Route::patch('/pqr/{pqr}/gestion', [SeguimientoController::class, 'update'])
        ->name('pqrs.gestion');
});

//Administrador|Supervisor
Route::middleware(['web', SupervisorMiddleware::class])->group(function () {

    //Estadisticas

    //PQRs Por Estado
    Route::get('/pqr/stat-by-status', [StatsController::class, 'pqrStatByStatus']);

    //PQRs Por Tipo
    Route::get('/pqr/stat-by-type', [StatsController::class, 'pqrStatByType']);
});