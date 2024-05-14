<?php

namespace App\Http\Controllers;

use App\Models\periodonodisponible;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\ambiente;
use App\Models\solicitud;
use App\Models\reserva;

class PeriodonodisponibleController extends Controller
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

        $nombreAmbiente = $datosSolicitudFormulario['nombreambiente'];
        $fecha = $datosSolicitudFormulario['fecha'];
        $horaInicial = $datosSolicitudFormulario['horainicial'];
        $horaFinal = $datosSolicitudFormulario['horafinal'];

        $listaHorasDistribuidas = $this->generarListaHoras($horaInicial, $horaFinal);

        $ambiente = ambiente::where('nombreambiente', $nombreAmbiente)->first();
        $idAmbiente = $ambiente->idambiente;

        $periodosNoDisponiblesRegistrados = [];

        $horasDesocupadas = true;

        foreach ($listaHorasDistribuidas as $horaOcupada) {
            $periodoNoDisponibleSinRegistrar = $this->verificarPeriodoNoDisponible($horaOcupada, $fecha, $idAmbiente); 
            if (!$periodoNoDisponibleSinRegistrar) {

                $periodoNoDisponible = [
                    'idambiente' => $idAmbiente,
                    'fecha' => $fecha,
                    'hora' => $horaOcupada
                ];

                $registrarPeriodoNoDisponible = periodonodisponible::insert($periodoNoDisponible);
                $horasDesocupadas = true;

                if($registrarPeriodoNoDisponible){
                    $periodosNoDisponiblesRegistrados[] = $periodoNoDisponible;
                }
            } else {
                $horasDesocupadas = false;
            }
        }

        $idUltimaSolicitud = $this->obtenerUltimoIdSolicitud();

        $registroReserva = [
            'idambiente' => $idAmbiente,
            'idsolicitud' => $idUltimaSolicitud,
        ];

        $registrarReserva = reserva::insert($registroReserva);

        if($registrarReserva){
            // return response()->json([
            //     'listaHorasDistribuidas' => $listaHorasDistribuidas, 
            //     'idUltimaSolicitud' => $idUltimaSolicitud,
            //     'idAmbiente' => $idAmbiente, 
            //     'fecha' => $fecha, 
            //     'periodosNoDisponiblesRegistrados' => $periodosNoDisponiblesRegistrados,
            //     'horasDesocupadas' => $horasDesocupadas
            //     ]);
            return response()->json([
                'reservarealizada' => true
            ]);
        } else {
            return response()->json([
                'reservarealizada' => false
            ]);
        }

        
    }

    private function generarListaHoras($horaInicial, $horaFinal)
    {
        $listaHoras = [];

        $horaInit = Carbon::parse($horaInicial);
        $horaFinal = Carbon::parse($horaFinal);

        if($horaInit == $horaFinal){
            $listaHoras[] = $horaInit->format('H:i:s');
            return $listaHoras;
        } else {
            while ($horaInit < $horaFinal) {
                $listaHoras[] = $horaInit->format('H:i:s');
                $horaInit->addMinutes(45);
            }
    
            // array_pop($listaHoras);
            return $listaHoras;
        }        
    }

    private function verificarPeriodoNoDisponible($hora, $fecha, $idAmbiente)
    {
        $periodoNoDisponible = periodonodisponible::where('idambiente', $idAmbiente)->where('fecha', $fecha)->where('hora', $hora)->first();
        if ($periodoNoDisponible) {
            return true;
        } else {
            return false;
        }
    }

    private function obtenerUltimoIdSolicitud(){
        $solicitud = solicitud::latest('idsolicitud')->first();
        return $solicitud->idsolicitud;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\periodonodisponible  $periodonodisponible
     * @return \Illuminate\Http\Response
     */
    public function show(periodonodisponible $periodonodisponible)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\periodonodisponible  $periodonodisponible
     * @return \Illuminate\Http\Response
     */
    public function edit(periodonodisponible $periodonodisponible)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\periodonodisponible  $periodonodisponible
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, periodonodisponible $periodonodisponible)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\periodonodisponible  $periodonodisponible
     * @return \Illuminate\Http\Response
     */
    public function destroy(periodonodisponible $periodonodisponible)
    {
        //
    }
}
