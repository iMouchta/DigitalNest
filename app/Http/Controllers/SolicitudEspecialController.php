<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Solicitud;
use App\Models\Ambiente;

class SolicitudEspecialController extends Controller
{
    public function create()
    {
        $ambientes = Ambiente::all();
        return view('welcome', compact('ambientes'));
    }

    public function store(Request $request)
    {
    //dd($request->all());
    $request->validate([
        'capacidadsolicitud' => 'required|integer',
        'fechasolicitud' => 'required|date',
        'horainicialsolicitud' => 'required',
        'horafinalsolicitud' => 'required',
        'motivo' => 'required|string|max:255',
        'idambiente' => 'required|integer',
        'idmateria' => 'required|integer',
    ]);

    $solicitud = new Solicitud();
    $solicitud->fill($request->except('_token')); 
    $solicitud->idmateria = $request->idmateria; 
    $solicitud->idambiente = $request->idambiente;
    $solicitud->save();

    return back()->with('success', 'Solicitud creada exitosamente.');
}


public function index()
{
    $solicitudes = Solicitud::all();
    return view('solicitud', compact('solicitudes'));
}


}

