<?php

use App\Http\Controllers\PqrController;
use App\Http\Controllers\SeguimientoController;
use App\Http\Middleware\GestorMiddleware;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');
//Pública
    //Registrar una nueva PQR
    Route::post('/pqrs', [PqrController::class, 'store'])
    ->name('api.pqrs.store');


//Agentes|Administrador|Supervisor
    Route::middleware(['web', GestorMiddleware::class])->group(function () {
  
            //Listar PQR y aplicar filtros
            Route::get('/pqr', [PqrController::class, 'index'])->name('api.pqrs.index');

            //actualizar Gestion PQR
            Route::patch('/pqr/{pqr}/gestion',[SeguimientoController::class, 'update'])
            ->name('pqrs.gestion');
        
    });
