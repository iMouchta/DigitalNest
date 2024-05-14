<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SolicitudEspecialController;
// use App\Http\Controllers\SolicitudController;
use App\Http\Controllers\ReservaController;


Route::get('/', function () {return view('welcome');});
Route::get('/', [SolicitudEspecialController::class, 'create'])->name('solicitud.create');
Route::post('/', [SolicitudEspecialController::class, 'store'])->name('solicitud.store');


Route::get('/', function () {
    return view('welcome');
});



// Route::get('/solicitudes', [SolicitudEspecialController::class, 'index'])->name('solicitud');

// Route::resource('solicitud', SolicitudController::class);

Route::group(['middleware' => ['cors']], function () {
    Route::get('/solicitudes', [SolicitudEspecialController::class, 'index'])->name('solicitud');
    // Route::resource('/solicitud', SolicitudController::class);
    

    Route::get('/', function () {return view('welcome');});
    Route::get('/', [SolicitudEspecialController::class, 'create'])->name('solicitud.create');
    Route::post('/', [SolicitudEspecialController::class, 'store'])->name('solicitud.store');
});


Route::resource('reserva', ReservaController::class);
// Route::resource('solicitud', SolicitudController::class);