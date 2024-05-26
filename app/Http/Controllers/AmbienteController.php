<?php

namespace App\Http\Controllers;

use App\Models\ambiente;
use App\Models\ubicacion;
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
        $ambientes = ambiente::all();
        $listaAmbientesConUbicacion = [];
        
        foreach ($ambientes as $ambiente) {
            $nombreUbicacion = $this->getNombreUbicacion($ambiente->idubicacion);
            $ambienteConUbicacion = [
                'idambiente' => $ambiente->idambiente,
                'nombreambiente' => $ambiente->nombreambiente,
                'ubicacion' => $nombreUbicacion,
                'planta' => $ambiente->planta,
                'capacidadambiente' => $ambiente->capacidadambiente,
            ];
            $listaAmbientesConUbicacion[] = $ambienteConUbicacion;
        }


        return response()->json($listaAmbientesConUbicacion);
    }

    private function getNombreUbicacion($idUbicacion) {
        $ubicacion = ubicacion::find($idUbicacion);
        return $ubicacion->nombreubicacion;
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

        if ($this->ambienteRepedido($nombreAmbiente)) {
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

    private function ambienteRepedido($nombreAmbiente) {
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
