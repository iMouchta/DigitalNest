<?php

namespace App\Http\Controllers;

use App\Models\solicitud;
use App\Models\docente;
use App\Models\materia;
use Illuminate\Http\Request;

class SolicitudController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $datos['solicitudes'] = solicitud::all();
        return view('solicitudes.index', $datos);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view("solicitudes.solicitudrapida");
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $datosSolicitudFormulario = request()->except('_token');
        $nombreDocente = $request->input('nombredocente');
        $nombreMateria = $request->input('materia');

        $docente = docente::where('nombredocente', $nombreDocente)->first();
        if ($docente) {
            //obtiene el id del docente
            $docenteId = $docente->iddocente;
            $materia = Materia::where('nombremateria', $nombreMateria)->where('iddocente', $docenteId)->first();

            if($materia) {
                //obten el id de la materia
                $materiaId = $materia->idmateria;

                //se crea mapa con los valores requeridos para la solicitud
                $datosSolicitud = [
                    'idmateria' => $materiaId,
                    'capacidadsolicitud' => $request->input('capacidad'),
                    'fechasolicitud' => $request->input('fecha'),
                    'horainicialsolicitud' => $request->input('horainicial'),
                    'horafinalsolicitud' => $request->input('horafinal'),
                    'motivosolicitud' => $request->input('motivo')
                ];
                return response()->json($datosSolicitud[]);
            } else {
                //la materia no existe para este docente
                return response()->json(['error' => 'La materia no existe para este docente']);
            }
        } else {
            //el docente no existe
            $docenteId = null;
            return response()->json(['error' => 'El docente no existe']);
        }	

        // $datos = [
        //     'docente_id' => $docenteId,
        //     'materia_id' => $materiaId,
        // ];

        // return response()->json($datos);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\solicitud  $reserva
     * @return \Illuminate\Http\Response
     */
    public function show(solicitud $solicitud)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\solicitud  $solicitud
     * @return \Illuminate\Http\Response
     */
    public function edit(solicitud $solicitud)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\solicitud  $solcitud
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, solicitud $solicitud)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\solicitud  $solicitud
     * @return \Illuminate\Http\Response
     */
    public function destroy(solicitud $solicitud)
    {
        //
    }
}
