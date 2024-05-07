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
        $request->validate([
            'capacidadsolicitud' => 'required|integer',
            'fechasolicitud' => 'required|date',
            'horainicialsolicitud' => 'required',
            'horafinalsolicitud' => 'required',
            'motivosolicitud' => 'required|string|max:1000',
            'ambientesolicitud' => 'required|string|max:250',
            'idmateria' => 'required|integer',
        ]);

        $solicitud = new Solicitud();
        $solicitud->fill($request->except('_token'));
        $solicitud->idmateria = $request->idmateria;
        $solicitud->save();

        if ($solicitud) {
            return back()->with('success', 'Solicitud creada exitosamente.');
        } else {
            return back()->with('error', 'Hubo un error al crear la solicitud.');
        }
    }

    public function index()
    {
        $solicitudes = Solicitud::all();
        return response()->json($solicitudes);
    }
}
