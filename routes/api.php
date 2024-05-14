<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\SolicitudController;
use App\Http\Controllers\PeriodonodisponibleController;
use App\Http\Controllers\SolicitudEspecialController;

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


Route::resource('/solicitud', SolicitudController::class);
Route::resource('solicitud', SolicitudController::class);
Route::resource('periodonodisponible', PeriodonodisponibleController::class);
Route::post('/aceptar', [SolicitudEspecialController::class, 'aceptar'])->name('solicitud.aceptar');
// Route::get('/', function () {return view('welcome');});
Route::get('/', [SolicitudEspecialController::class, 'create'])->name('solicitud.create');
Route::post('/', [SolicitudEspecialController::class, 'store'])->name('solicitud.store');

