<?php

namespace App\Http\Controllers;

use App\Models\solicitud;
use App\Models\docente;
use App\Models\materia;
use App\Models\ambiente;
use App\Models\periodonodisponible;
use App\Models\reserva;

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
        $nombreDocente = $datosSolicitudFormulario['nombredocente'];
        $nombreMateria = $datosSolicitudFormulario['materia'];

        $docente = docente::where('nombredocente', $nombreDocente)->first();
        if ($docente) {
            //obtiene el id del docente
            $docenteId = $docente->iddocente;
            $materia = materia::where('nombremateria', $nombreMateria)->where('iddocente', $docenteId)->first();

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

                $solicitudIngresada = solicitud::insert($datosSolicitud);

                $ambientes = ambiente::all();
                $ambientesDisponibles = [];

                foreach ($ambientes as $ambiente) {
                    if ($ambiente->capacidadambiente >= $request->input('capacidad')) {

                        $ambienteCandidato = [
                            'idambiente' => $ambiente->idambiente,
                            'nombre' => $ambiente->nombreambiente,
                            'capacidad' => $ambiente->capacidadambiente
                        ];

                        $ambientesDisponibles[] = $ambienteCandidato;
                    }
                }
                
                if($solicitudIngresada) {
                    return response()->json(['subida' => true, 'ambientes' => $ambientesDisponibles]);
                    // return response()->json($request);
                } else {
                    return response()->json(['subida' => false]);
                }

            } else {
                //la materia no existe para este docente
                return response()->json(['error' => 'La materia no existe para este docente']);
            }
        } else {
            //el docente no existe
            $docenteId = null;
            return response()->json(['error' => 'El docente no existe']);
        }	
    }
    

    // private function periodoEstaDisponible($ambienteId, $fecha, $horaInicial, $horaFinal)
    // {
    //     $periodos = periodonodisponible::where('idambiente', $ambienteId)->where('fecha', $fecha)->get();
    //     if ($periodos) {
    //         foreach ($periodos as $periodo) {
    //             if ($horaInicial >= $periodo->hora && $horaInicial <= $periodo->hora) {
    //                 return false;
    //             }
    //         }
    //     }
    //     return true;
    // }
    

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
