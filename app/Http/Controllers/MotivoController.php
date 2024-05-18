<?php

namespace App\Http\Controllers;

use App\Models\motivo;
use App\Models\docente;
use App\Models\materia;
use Illuminate\Http\Request;

class MotivoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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
        $motivosDisponibles = [];

        foreach ($nombresDocentes as $nombreDocente) {
            $docente = docente::where('nombredocente', $nombreDocente)->first();
            if ($docente) {
                $idDocente = $docente->iddocente;
                $materia = materia::where('iddocente', $idDocente)->where('nombremateria', $nombreMateria)->first();

                if ($materia) {
                    $motivos = motivo::where('registrado', false)->where('idmateria', $materia->idmateria)->get();

                    $motivoDisponible = [
                        'docente' => $nombreDocente,
                        'materia' => $nombreMateria,
                        'motivos' => $motivos
                    ];

                    $motivosDisponibles[] = $motivoDisponible;
                }
            }
        }
        
        return response()->json($motivosDisponibles);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\motivo  $motivo
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\motivo  $motivo
     * @return \Illuminate\Http\Response
     */
    public function edit(motivo $motivo)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\motivo  $motivo
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, motivo $motivo)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\motivo  $motivo
     * @return \Illuminate\Http\Response
     */
    public function destroy(motivo $motivo)
    {
        //
    }
}
