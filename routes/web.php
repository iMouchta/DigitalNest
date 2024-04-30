<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SolicitudEspecialController;
use App\Http\Controllers\SolicitudController;


Route::get('/', function () {return view('welcome');});
Route::get('/', [SolicitudEspecialController::class, 'create'])->name('solicitud.create');
Route::post('/', [SolicitudEspecialController::class, 'store'])->name('solicitud.store');



Route::get('/solicitudes', [SolicitudEspecialController::class, 'index'])->name('solicitud');

Route::resource('solicitud', SolicitudController::class);