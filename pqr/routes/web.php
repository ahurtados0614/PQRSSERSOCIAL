<?php

use App\Http\Controllers\PqrController;
use App\Http\Controllers\SeguimientoController;
use App\Http\Controllers\UserController;
use App\Http\Middleware\AdminMiddleware;
use App\Http\Middleware\GestorMiddleware;
use App\Http\Middleware\LoggedUserMiddleware;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/pqrs/confirmacion/{tracking_code}', [PqrController::class, 'confirmation'])
    ->name('pqrs.confirmation');

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
       // Route::get('/pqrs', function () {
            
       //     return view('pqrs.index');
       // })->name('pqrs.index');

        
    });

    //api sugeridas
    /**
     * POST   /api/pqrs
     *GET    /api/pqrs/{tracking_code}
     *GET    /api/pqrs
     *PATCH  /api/pqrs/{id}/status
     */
});
