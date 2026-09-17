<?php

use App\Http\Controllers\PqrController;
use App\Http\Controllers\PqrTrackingController;
use App\Http\Controllers\SeguimientoController;
use App\Http\Controllers\UserController;
use App\Http\Middleware\AdminMiddleware;
use App\Http\Middleware\GestorMiddleware;
use App\Http\Middleware\LoggedUserMiddleware;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});
//Rutas Públicas
//vista confirmacion pqrs
Route::get('/pqrs/confirmacion/{tracking_code}', [PqrController::class, 'confirmation'])
    ->name('pqrs.confirmation');

//vista rastreo por radicado
Route::get('/pqr/rastreo', [PqrTrackingController::class, 'PqrTrackingView'])
    ->name('pqr.tracking');

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    //logueados
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    //Administrador
    Route::middleware(['web', AdminMiddleware::class])->group(function () {
        //Usuarios
        Route::get('/users', [UserController::class, 'show'])->name('users')->middleware('auth');
    });
   
    //Agentes|Administrador|Supervisor
    Route::middleware(['web', GestorMiddleware::class])->group(function () {
    // Listado de PQR
        Route::get('/pqrs', [SeguimientoController::class, 'index'])->name('pqrs.index')->middleware('auth');        
    });
});
