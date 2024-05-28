<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\SolicitudController;
use App\Http\Controllers\PeriodoReservaOcupadoController;
use App\Http\Controllers\SolicitudEspecialController;
use App\Http\Controllers\AmbienteController;
use App\Http\Controllers\SolicitudRapidaController;
use App\Http\Controllers\MotivoController;
use App\Http\Controllers\EdificioController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


Route::resource('/ambientesDisponibles', SolicitudController::class);
// Route::resource('solicitud', SolicitudController::class);
Route::resource('/registrarSolicitudRapida', PeriodoReservaOcupadoController::class);
// Route::post('/aceptar', [SolicitudEspecialController::class, 'aceptar'])->name('solicitud.aceptar');
// Route::get('/', function () {return view('welcome');});
// Route::get('/', [SolicitudEspecialController::class, 'create'])->name('solicitud.create');
//Route::post('/', [SolicitudEspecialController::class, 'store'])->name('solicitud.store');
Route::resource('/motivo', MotivoController::class);
Route::resource('/ambiente', AmbienteController::class);
Route::resource('/getSolicitudesRapidas', SolicitudRapidaController::class);
Route::resource('/edificio', EdificioController::class);


//solicitudEspecial
Route::post('/solicitudEspecial', [SolicitudEspecialController::class, 'store'])->name('solicitudEspecial.store');
Route::get('/solicitudEspecial', [SolicitudEspecialController::class, 'index'])->name('solicitudEspecial.index');
Route::get('/reservas', [SolicitudEspecialController::class, 'reservas'])->name('reservas');
Route::post('/eliminarSoli', [SolicitudEspecialController::class, 'eliminar'])->name('solicitudEspecial.eliminar');
Route::post('/accept', [SolicitudEspecialController::class, 'accept'])->name('accept');

