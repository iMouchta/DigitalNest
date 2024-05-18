<?php

namespace App\Http\Controllers;

use App\Models\periodonodisponible;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\ambiente;
use App\Models\solicitud;
use App\Models\reserva;
use App\Models\docente;
use App\Models\materia;
use App\Models\docentesolicitud;
use App\Models\solicitudconambienteasignado;

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

        $nombresDocentes = $datosSolicitudFormulario['nombresdocentes'];
        $nombreMateria = $datosSolicitudFormulario['materia'];
        $capacidad = $datosSolicitudFormulario['capacidad'];
        $fecha = $datosSolicitudFormulario['fecha'];
        $horaInicial = $datosSolicitudFormulario['horainicial'];
        $horaFinal = $datosSolicitudFormulario['horafinal'];
        $motivo = $datosSolicitudFormulario['motivo'];
        $nombresAmbientes = $datosSolicitudFormulario['nombresambientes'];

        $listaIdsDocentes = [];
        $listaIdsAmbientes = [];

        $listaHorasDistribuidas = $this->generarListaHoras($horaInicial, $horaFinal);

        foreach ($nombresDocentes as $nombreDocente) {
            $docente = docente::where('nombredocente', $nombreDocente)->first();
            if ($docente) {
                $idDocente = $docente->iddocente;
                $listaIdsDocentes[] = $idDocente;

                $materia = materia::where('iddocente', $idDocente)->where('nombremateria', $nombreMateria)->first();
                if ($materia) {
                    $idMateria = $materia->idmateria;

                    foreach ($nombresAmbientes as $nombreAmbiente) {
                        $ambiente = ambiente::where('nombreambiente', $nombreAmbiente)->first();
                        $idAmbiente = $ambiente->idambiente;

                        if (!in_array($idAmbiente, $listaIdsAmbientes)) {
                            // Si no está, lo agregamos
                            $listaIdsAmbientes[] = $idAmbiente;
                        }

                        foreach ($listaHorasDistribuidas as $horaOcupada) {
                            $this->registrarPeriodoNoDisponible($horaOcupada, $fecha, $idAmbiente);
                        }
                    }
                }
            }
        }

        $datosSolicitud = [
            'capacidadsolicitud' => $capacidad,
            'fechasolicitud' => $fecha,
            'horainicialsolicitud' => $horaInicial,
            'horafinalsolicitud' => $horaFinal,
            'motivosolicitud' => $motivo,
            'aceptada' => true
        ];

        $solicitudCreada = $this->registrarSolicitud($datosSolicitud);
        $idSolicitud = $solicitudCreada->idsolicitud;

        $reservaCreada = $this->registrarReserva($idSolicitud);

        //se asocia la solicitud con los docentes que realizaron la solicitud 
        
        $asociacionDocenteSolicitud = $this->asociarSolicitudConDocente($listaIdsDocentes, $idSolicitud);
        $asociacionAmbienteSolicitud = $this->asociarSolicitudConAmbiente($listaIdsAmbientes, $idSolicitud);


        
        return response()->json(
            [
                'solicitud' => $solicitudCreada,
                'asociacioncondocente' => $asociacionDocenteSolicitud,
                'asociacionconambiente' => $asociacionAmbienteSolicitud,
                'reserva' => $reservaCreada
            ]
        );

    }

    private function registrarSolicitud($solicitudData)
    {
        $solicitud = solicitud::create($solicitudData);
        return $solicitud;
    }

    private function registrarReserva($idSolicitud)
    {
        $reservaData = [
            'idsolicitud' => $idSolicitud
        ];
        $reserva = reserva::insert($reservaData);
        return $reserva;
    }

    private function asociarSolicitudConDocente($idsdocentes, $idSolicitud)
    {
       foreach($idsdocentes as $idDocente) {
        $solicitudDocente = [
            'iddocente' => $idDocente,
            'idsolicitud' => $idSolicitud
        ];

        $solicitudDocenteAsociada = docentesolicitud::insert($solicitudDocente);
       }
        return $solicitudDocenteAsociada;
    }

    private function asociarSolicitudConAmbiente($listaIDAmbiente, $idSolicitud)
    {
        foreach($listaIDAmbiente as $idAmbiente) {
            $solicitudAmbiente = [
                'idambiente' => $idAmbiente,
                'idsolicitud' => $idSolicitud
            ];
    
            $solicitudAmbienteAsociada = solicitudconambienteasignado::insert($solicitudAmbiente);
        }
        return $solicitudAmbienteAsociada;
    }



    private function registrarPeriodoNoDisponible($horaPorOcupar, $fecha, $idAmbiente)
    {
        $periodoNoDisponibleSinRegistrar = $this->verificarPeriodoNoDisponible($horaPorOcupar, $fecha, $idAmbiente);
        if (!$periodoNoDisponibleSinRegistrar) {

            $periodoNoDisponible = [
                'idambiente' => $idAmbiente,
                'fecha' => $fecha,
                'hora' => $horaPorOcupar
            ];

            $registrarPeriodoNoDisponible = periodonodisponible::insert($periodoNoDisponible);

            if ($registrarPeriodoNoDisponible) {
                $periodosNoDisponiblesRegistrados[] = $periodoNoDisponible;
            }
        } else {
            $horasDesocupadas = false;
        }
    }

    private function generarListaHoras($horaInicial, $horaFinal)
    {
        $listaHoras = [];

        $horaInit = Carbon::parse($horaInicial);
        $horaFinal = Carbon::parse($horaFinal);

        if ($horaInit == $horaFinal) {
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

    private function obtenerUltimoIdSolicitud()
    {
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
