<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SolicitudEspecialController;

Route::group(['middleware' => ['cors']], function () {
    //Route::get('/solicitudes', [SolicitudEspecialController::class, 'index'])->name('solicitud');
    
    //Route::resource('/solicitud', SolicitudController::class);
});
Route::get('/{any}',function(){
    return view('index');
})->where('any','.*');
