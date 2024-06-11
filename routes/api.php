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
use App\Http\Controllers\NotificacionController;
use App\Http\Controllers\EmailController;
use App\Http\Controllers\ReglaReservaDeAmbienteController;
use App\Http\Controllers\UsuarioController;
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

//Solicitud Rapida
Route::resource('/ambientesDisponibles', SolicitudController::class);
Route::resource('/registrarSolicitudRapida', PeriodoReservaOcupadoController::class);
Route::resource('/motivo', MotivoController::class);
Route::resource('/getSolicitudesRapidas', SolicitudRapidaController::class);

//Registro, visualizacion, eliminacion y edicion de informacion de ambientes
Route::resource('/ambiente', AmbienteController::class);
Route::resource('/edificio', EdificioController::class);
Route::post('/editAmbiente', [AmbienteController::class, 'editAmbiente'])->name('editAmbiente');
Route::post('/getSolicitudesAsociadasConAmbiente', [AmbienteController::class, 'getSolicitudesAsociadasConAmbiente'])->name('getSolicitudesAsociadasConAmbiente');
Route::post('/deleteAmbiente', [AmbienteController::class, 'deleteAmbiente'])->name('deleteAmbiente');

//Obtener informacion de un ambiente con su id
Route::post('/getInfoAmbiente', [AmbienteController::class, 'getAmbienteById'])->name('getInfoAmbiente');

//CRUD Reglas de Reserva De Ambiente
Route::post('/registrarReglaReservaAmbiente', [ReglaReservaDeAmbienteController::class, 'registrarReglaReservaDeAmbiente'])->name('registrarReglaReservaDeAmbiente');
Route::post('/eliminarReglaReservaAmbiente', [ReglaReservaDeAmbienteController::class, 'eliminarReglaReservaDeAmbiente'])->name('eliminarReglaReservaDeAmbiente');
Route::post('/editarReglaReservaAmbiente', [ReglaReservaDeAmbienteController::class, 'editarReglaReservaDeAmbiente'])->name('editarReglaReservaDeAmbiente');

//solicitudEspecial
Route::post('/solicitudEspecial', [SolicitudEspecialController::class, 'store'])->name('solicitudEspecial.store');
Route::get('/solicitudEspecial', [SolicitudEspecialController::class, 'index'])->name('solicitudEspecial.index');
Route::get('/reservas', [SolicitudEspecialController::class, 'reservas'])->name('reservas');
Route::post('/eliminarSoli', [SolicitudEspecialController::class, 'eliminarConCorreo'])->name('solicitudEspecial.eliminar');
Route::post('/aceptarSoli', [SolicitudEspecialController::class, 'accept'])->name('accept');
Route::post('/confirmacion',[SolicitudEspecialController::class, 'confirmar'])->name('confirmar');
Route::post('/fecha', [SolicitudEspecialController::class, 'buscarPorFecha']);
Route::post('/editar', [SolicitudEspecialController::class, 'actualizarFechasSolicitudes'])->name('editarFecha');

//Notificaciones
Route::get('/notificaciones/usuario/{idUsuario}', [NotificacionController::class, 'obtenerNotificacionesPorUsuario'])->name('notificaciones');
Route::post('/verNotificaciones',[NotificacionController::class, 'cambiarEstado'])->name('verNotis');


//Mail
Route::post('/enviarCorreos', [SolicitudEspecialController::class, 'enviarCorreosDesdeApi']);

//Usuarios
Route::post('/users',[UsuarioController::class, 'enviarAviso']);
