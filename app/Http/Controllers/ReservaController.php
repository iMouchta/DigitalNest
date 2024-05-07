<?php

namespace App\Http\Controllers;

use App\Models\reserva;
use App\Models\solicitud;
use App\Models\periodonodisponible;
use App\Models\ambiente;

use Illuminate\Http\Request;
use Carbon\Carbon;

class ReservaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view("solicitudes.reservasolicitudrapida");
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //mandar numero de solicitudes ateendidas
        $reservasExitosas = [];
        $reservasRechazadas = [];
        
        $solicitudes = solicitud::all();

        foreach ($solicitudes as $solicitud) {

            $idsolicitud = $solicitud->idsolicitud;
            $capacidad = $solicitud->capacidadsolicitud;

            $ambienteTentativo = $this->obtenerAmbienteTentativo($capacidad);

            if ($ambienteTentativo) {
                $idambiente = $ambienteTentativo['idambiente'];

                $reserva = [
                    'idsolicitud' => $idsolicitud,
                    'idambiente' => $idambiente
                ];

                reserva::insert($reserva);

                $reservasExitosas[] = $reserva;
            } else {
                $reservasRechazadas[] = $solicitud;
            }
            
        }        

        return response()->json([
            'reservas' => $reservasExitosas, 
            'evaluadas' => true, 
            'noAceptadas' => $reservasRechazadas]);

    }

    //esto  fue lo ultimo que hiciste
    // private function obtenerAmbienteTentativo($capacidad, $fecha, $horaInicial, $horaFinal)
    // {
    //     //obtener ambiente
    //     $ambiente = ambiente::where('capacidadambiente', '>=', $capacidad)->first();
    //     $estaDisponible = $this->ambienteEstaDisponible($ambiente->idambiente, $fecha, $horaInicial, $horaFinal);

    //     if ($ambiente && $estaDisponible) {
    //         $datosambiente = [
    //             'idambiente' => $ambiente->idambiente,
    //             'nombre' => $ambiente->nombreambiente,
    //             'capacidad' => $ambiente->capacidadambiente
    //         ];
    //         // return response()->json($datosambiente);
    //         return $datosambiente;
    //     } else {
    //         $datosambiente = null;
    //         return $datosambiente;
    //     }
    // }

    private function obtenerAmbienteTentativo($capacidad)
    {
        $ambiente = ambiente::where('capacidadambiente', '>=', $capacidad)->first();
        
        if ($ambiente) {
            $datosAmbiente = [
                'idambiente' => $ambiente->idambiente,
                'nombre' => $ambiente->nombreambiente,
                'capacidad' => $ambiente->capacidadambiente
            ];
            return $datosAmbiente;
        } 
    }

    private function generarListaHoras($horaInicial, $horaFinal)
    {
        $listaHoras = [];

        $horaActual = Carbon::parse($horaInicial);
        $horaFinal = Carbon::parse($horaFinal);


        while ($horaActual < $horaFinal) {
            $listaHoras[] = $horaActual->format('H:i:s');
            $horaActual->addMinutes(45);
        }
        return $listaHoras;
    }

    private function ambienteEstaDisponible($idAmbiente, $fecha, $horaInicial, $horaFinal)
    {
        $coincidencia = PeriodoNoDisponible::where('idambiente', $idAmbiente)
            ->where('fecha', $fecha)
            ->where(function ($query) use ($horaInicial, $horaFinal) {
                $query->where('hora', '>=', $horaInicial)
                      ->where('hora', '<', $horaFinal)
                      ->orWhere('hora', '>', $horaInicial)
                      ->where('hora', '<=', $horaFinal);
            })
            ->doesntExist();

        // Si no hay coincidencia, devuelve true; de lo contrario, devuelve false
        return $coincidencia;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\reserva  $reserva
     * @return \Illuminate\Http\Response
     */
    public function show(reserva $reserva)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\reserva  $reserva
     * @return \Illuminate\Http\Response
     */
    public function edit(reserva $reserva)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\reserva  $reserva
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, reserva $reserva)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\reserva  $reserva
     * @return \Illuminate\Http\Response
     */
    public function destroy(reserva $reserva)
    {
        //
    }
}
