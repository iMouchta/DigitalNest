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
            'idadministrador' => 'required',
            'fechasolicitud' => 'required|date',
            'horainicialsolicitud' => 'required',
            'horafinalsolicitud' => 'required',
            'motivosolicitud' => 'required|string|max:1000',
            'idambiente' => 'required|integer',
            'especial' => 'boolean|required',
            'aceptada' => 'boolean|nullable',
        ]);

        $solicitud = new Solicitud();
        $solicitud->fill($request->except('_token'));
        $solicitud->idambiente = $request->idambiente;
        $solicitud->especial = true;

        $solicitud->save();

        if ($solicitud) {
            return response()->json(['subida' => true]);
        } else {
            return response()->json(['subida' => false]);
        }
    }


    public function index()
    {
        $solicitudes = Solicitud::with('administrador', 'ambiente')
        ->where('especial', 1)
        ->get();

        $solicitudesConDatos = $solicitudes->map(function ($solicitud) {
            return [
                'fechasolicitud' => $solicitud->fechasolicitud,
                'horainicialsolicitud' => $solicitud->horainicialsolicitud,
                'horafinalsolicitud' => $solicitud->horafinalsolicitud,
                'motivosolicitud' => $solicitud->motivosolicitud,
                'idambiente' => $solicitud->idambiente,
                'nombreadministrador' => $solicitud->administrador->nombreadministrador,
                'nombreAmbiente' => $solicitud->ambiente->nombreambiente,
            ];
        });
        return response()->json($solicitudesConDatos);
    }


}
