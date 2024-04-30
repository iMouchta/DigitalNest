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
    public function store()
    {
        $solicitudes = solicitud::all();
        $periodoNoDisponibleSubido = false;

        foreach ($solicitudes as $solicitud) {
            $idSolicitud = $solicitud->idsolicitud;
            $capacidad = $solicitud->capacidadsolicitud;
            $fecha = $solicitud->fechasolicitud;
            $horaInicialSolicitud = $solicitud->horainicialsolicitud;
            $horaFinalSolicitud = $solicitud->horafinalsolicitud;

            $periodosNoDisponibles = periodonodisponible::all();
            if ($periodosNoDisponibles->isEmpty()) {
                $datosAmbiente = $this->obtenerAmbienteTentativo($capacidad);
                $idAmbienteTentativo = $datosAmbiente['idambiente'];

                $datosReserva = [
                    'idsolicitud' => $idSolicitud,
                    'idambiente' => $idAmbienteTentativo,
                ];

                $reservaSubida = reserva::insert($datosReserva);


                $listaHoras = $this->generarListaHoras($horaInicialSolicitud, $horaFinalSolicitud);


                foreach ($listaHoras as $hora) {
                    $horaOcupada = $hora;
                    $datosPeriodoNoDisponible = [
                        'idambiente' => $idAmbienteTentativo,
                        'fecha' => $fecha,
                        'hora' => $horaOcupada,
                    ];
                    $periodoNoDisponibleSubido = periodonodisponible::insert($datosPeriodoNoDisponible);
                }


                return response()->json($reservaSubida);
            } else {
                $datosAmbiente = $this->obtenerAmbienteTentativo($capacidad);
                $idAmbienteTentativo = $datosAmbiente['idambiente'];

                $datosReserva = [
                    'idsolicitud' => $idSolicitud,
                    'idambiente' => $idAmbienteTentativo,
                ];

                $estaDisponible = $this->periodoEstaDisponible($idAmbienteTentativo, $fecha, $horaInicialSolicitud, $horaFinalSolicitud);

                if ($estaDisponible) {
                    $reservaSubida = reserva::insert($datosReserva);

                    $listaHoras = $this->generarListaHoras($horaInicialSolicitud, $horaFinalSolicitud);
                    foreach ($listaHoras as $hora) {
                        $horaOcupada = $hora;
                        $datosPeriodoNoDisponible = [
                            'idambiente' => $idAmbienteTentativo,
                            'fecha' => $fecha,
                            'hora' => $horaOcupada,
                        ];
                        $periodoNoDisponibleSubido = periodonodisponible::insert($datosPeriodoNoDisponible);
                    }

                    return response()->json($reservaSubida);
                } else {
                    return response()->json(false);
                }
            }


        }
        // return response()->json($periodosNoDisponibles);

    }

    private function obtenerAmbienteTentativo($capacidad)
    {
        //obtener ambiente
        $ambiente = ambiente::where('capacidadambiente', '>=', $capacidad)->first();
        if ($ambiente) {
            $datosambiente = [
                'idambiente' => $ambiente->idambiente,
                'nombre' => $ambiente->nombreambiente,
                'capacidad' => $ambiente->capacidadambiente
            ];
            // return response()->json($datosambiente);
            return $datosambiente;
        } else {
            $datosambiente = null;
            return $datosambiente;
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

    private function periodoEstaDisponible($ambienteId, $fecha, $horaInicial, $horaFinal)
    {
        $periodos = periodonodisponible::where('idambiente', $ambienteId)->where('fecha', $fecha)->where('hora', '>', $horaInicial)->where('hora', '<', $horaFinal)->get();
        if ($periodos) {
            return true;
        } else {
            return false;
        }
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
