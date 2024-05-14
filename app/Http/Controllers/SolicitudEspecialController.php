<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Solicitud;
use App\Models\Ambiente;
use Carbon\Carbon;

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
                'idsolicitud' => $solicitud->idsolicitud,
                'fechasolicitud' => $solicitud->fechasolicitud,
                'horainicialsolicitud' => $solicitud->horainicialsolicitud,
                'horafinalsolicitud' => $solicitud->horafinalsolicitud,
                'motivosolicitud' => $solicitud->motivosolicitud,
                'nombreadministrador' => $solicitud->administrador->nombreadministrador,
                'nombreAmbiente' => $solicitud->ambiente->nombreambiente,
            ];
        });
        return response()->json($solicitudesConDatos);
    }

    public function reservas()
    {
        $solicitudes = Solicitud::with('administrador', 'ambiente')
            ->where('aceptada', 1)
            ->get();

        $solicitudesConDatos = $solicitudes->map(function ($solicitud) {
            return [
                'nombreadministrador' => $solicitud->administrador->nombreadministrador,
                'nombreAmbiente' => $solicitud->ambiente->nombreambiente,
                'fechasolicitud' => $solicitud->fechasolicitud,
                'horainicialsolicitud' => $solicitud->horainicialsolicitud,
                'horafinalsolicitud' => $solicitud->horafinalsolicitud,
                'motivosolicitud' => $solicitud->motivosolicitud,
            ];
        });
        return response()->json($solicitudesConDatos);
    }

    public function aceptar(Request $request)
    {
        $request->validate([
            'idsolicitud' => 'required|integer|exists:solicitud,idsolicitud'
        ]);

        $solicitud = Solicitud::find($request->idsolicitud);

        $horasNoDisponibles = [];
        $horaInicial = Carbon::parse($solicitud->horainicialsolicitud);
        $horaFinal = Carbon::parse($solicitud->horafinalsolicitud)->subMinutes(45);

        while ($horaInicial->lt($horaFinal)) {
            $horasNoDisponibles[] = $horaInicial->format('H:i:s');
            $horaInicial->addMinutes(45);
        }

        $solicitudesConflictivas = Solicitud::where('idambiente', $solicitud->idambiente)
            ->where('fechasolicitud', $solicitud->fechasolicitud)
            ->where(function ($query) use ($horasNoDisponibles) {
                foreach ($horasNoDisponibles as $hora) {
                    $query->orWhere(function ($subQuery) use ($hora) {
                        $subQuery->where('horainicialsolicitud', '<=', $hora)
                            ->where('horafinalsolicitud', '>=', $hora);
                    });
                }
            })
            ->where('idsolicitud', '!=', $solicitud->idsolicitud)
            ->get();

        foreach ($solicitudesConflictivas as $solicitudConflictiva) {
            $solicitudConflictiva->aceptada = 0;
            $solicitudConflictiva->save();
        }

        $solicitud->aceptada = 1;
        $solicitud->save();


        if ($solicitud->aceptada == 1) {
            return response()->json(['confirmacion' => true]);
        } else {
            return response()->json(['confirmacion' => false]);
        }
    }



}
