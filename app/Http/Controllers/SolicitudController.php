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
        $nombresDocentes = $datosSolicitudFormulario['nombresdocentes'];
        $nombreMateria = $datosSolicitudFormulario['materia'];
        $capacidad = $datosSolicitudFormulario['capacidad'];
        $fecha = $datosSolicitudFormulario['fecha'];
        $horaInicial = $datosSolicitudFormulario['horainicial'];
        $horaFinal = $datosSolicitudFormulario['horafinal'];
        $motivo = $datosSolicitudFormulario['motivo'];

        $solicitudesRealizadas = [];
        $ambientesDisponibles = [];
        $solicitudesSubidas = false;

        foreach ($nombresDocentes as $nombreDocente) {
            $docente = docente::where('nombredocente', $nombreDocente)->first();
            if ($docente) {
                $idDocente = $docente->iddocente;
                $materia = materia::where('nombremateria', $nombreMateria)->where('iddocente', $idDocente)->first();

                if($materia) {
                    $idMateria = $materia->idmateria;

                    $datosSolicitud = [
                        'idmateria' => $idMateria,
                        'capacidadsolicitud' => $capacidad,
                        'fechasolicitud' => $fecha,
                        'horainicialsolicitud' => $horaInicial,
                        'horafinalsolicitud' => $horaFinal,
                        'motivosolicitud' => $motivo
                    ];

                    $solicitudIngresada = solicitud::insert($datosSolicitud);
                    $solicitudesRealizadas[] = $datosSolicitud;
                    $solicitudesSubidas = true;                  

                }
            }
        }

        $ambientes = ambiente::all();
                    

        foreach ($ambientes as $ambiente) {
            if ($ambiente->capacidadambiente >= $capacidad) {

                $ambienteCandidato = [
                    'idambiente' => $ambiente->idambiente,
                    'nombre' => $ambiente->nombreambiente,
                    'capacidad' => $ambiente->capacidadambiente
                ];

                $ambientesDisponibles[] = $ambienteCandidato;
            }
        }



        return response()->json(['nombresDocentes' => $nombresDocentes, 'solicitudesAceptadas' => $solicitudesRealizadas, 'ambientes' => $ambientesDisponibles]);
	
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
