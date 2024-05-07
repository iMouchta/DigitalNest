<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SolicitudEspecialController;
use App\Http\Controllers\SolicitudController;
use App\Http\Controllers\ReservaController;


Route::get('/', function () {return view('welcome');});
Route::get('/', [SolicitudEspecialController::class, 'create'])->name('solicitud.create');
Route::post('/', [SolicitudEspecialController::class, 'store'])->name('solicitud.store');


Route::get('/', function () {
    return view('welcome');
});



Route::get('/solicitudes', [SolicitudEspecialController::class, 'index'])->name('solicitud');


// Route::get('/formularioSolicitud', function () {
//     return view('solicitudes.solicitudrapida');
// });

Route::resource('reserva', ReservaController::class);
// Route::get('/', [SolicitudController::class, 'create'])->name('solicitud.create');
// Route::post('/', [SolicitudController::class, 'store'])->name('solicitud.store');

Route::resource('solicitud', SolicitudController::class);

// Route::get('/formularioSolicitudRapida',
//      [SolicitudController::class, 'create'])->name('solicitud.create');

// Route::post('/formularioSolicitudRapida',
//      [SolicitudController::class, 'store'])->name('solicitud.store');