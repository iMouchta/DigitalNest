<?php

namespace App\Http\Controllers;

use App\Models\Ambiente;
use App\Models\Edificio;
use Illuminate\Http\Request;

class AmbienteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $ambientes = Ambiente::all();
        $listaAmbientesConUbicacion = [];
        
        foreach ($ambientes as $ambiente) {
            $nombreEdificio = $this->getNombreEdificio($ambiente->idedificio);
            $ambienteConUbicacion = [
                'idambiente' => $ambiente->idambiente,
                'nombreambiente' => $ambiente->nombreambiente,
                'edificio' => $nombreEdificio,
                'planta' => $ambiente->planta,
                'capacidadambiente' => $ambiente->capacidadambiente,
            ];
            $listaAmbientesConUbicacion[] = $ambienteConUbicacion;
        }


        return response()->json($listaAmbientesConUbicacion);
    }

    private function getNombreEdificio($idEdificio) {
        $edificio = Edificio::find($idEdificio);
        return $edificio->nombreedificio;
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
        $datosFormularioCreacionAmbiente = request()->except('_token');

        $nombreAmbiente = $datosFormularioCreacionAmbiente['nombreambiente'];
        $capacidad = $datosFormularioCreacionAmbiente['capacidadambiente'];
        $ubicacion = $datosFormularioCreacionAmbiente['ubicacion'];
        $idubicacion = $datosFormularioCreacionAmbiente['idubicacion'];
        $planta = $datosFormularioCreacionAmbiente['planta'];

        if ($this->ambienteRepetido($nombreAmbiente)) {
            return response()->json(['ambienteRegistrado' => false]);
        } else {
            $datosAmbiente = [
                'nombreambiente' => $nombreAmbiente,
                'capacidadambiente' => $capacidad,
                'planta' => $planta,
                'idubicacion' => $idubicacion,
            ];
            $registrado = ambiente::insert($datosAmbiente);
            return response()->json(['ambienteRegistrado' => $registrado]);
        }


    }

    private function ambienteRepetido($nombreAmbiente) {
        $ambiente = ambiente::where('nombreambiente', $nombreAmbiente)->first();
        return $ambiente != null;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ambiente  $ambiente
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ambiente  $ambiente
     * @return \Illuminate\Http\Response
     */
    public function edit(ambiente $ambiente)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ambiente  $ambiente
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ambiente $ambiente)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ambiente  $ambiente
     * @return \Illuminate\Http\Response
     */
    public function destroy(ambiente $ambiente)
    {
        //
    }
}
