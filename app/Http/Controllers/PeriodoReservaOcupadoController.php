<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\Usuario;
use App\Models\Materia;
use App\Models\Motivo;
use App\Models\Ambiente;
use App\Models\Solicitud;
use App\Models\SolicitudConAmbiente;
use App\Models\UsuarioConSolicitud;
use App\Models\PeriodoReservaOcupado;
use App\Models\reserva;
use App\Models\docente;

class PeriodoReservaOcupadoController extends Controller
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

        $listaIdAmbientesByName = $this->getIdAmbientesByName($nombresAmbientes);
        $listaIdAmbientes = $this->getIdAmbientes($nombresAmbientes);
        $periodosEstanDisponibles = $this->verificarHorasDisponibles($horaInicial, $horaFinal, $fecha, $listaIdAmbientesByName);
        $idMateriaDocentes = $this->getIdMateriaDocentes($nombresDocentes, $nombreMateria);

        if ($periodosEstanDisponibles) {

            $listaIdsDocentes = [];
            $listaIdsAmbientes = [];
            $listaHorasDistribuidas = $this->generarListaHoras($horaInicial, $horaFinal);

            foreach ($nombresDocentes as $nombreDocente) {
                $docente = Usuario::where('nombreusuario', $nombreDocente)
                        ->where('administrador', false)
                        ->first();

                if ($docente) {
                    $idDocente = $docente->idusuario;
                    $listaIdsDocentes[] = $idDocente;
                    $materia = Materia::where('idusuario', $idDocente)
                            ->where('nombremateria', $nombreMateria)
                            ->first();

                    if ($materia) {
                        $idMateria = $materia->idmateria;

                        foreach ($nombresAmbientes as $nombreAmbiente) {
                            $ambiente = Ambiente::where('nombreambiente', $nombreAmbiente)->first();
                            $idAmbiente = $ambiente->idambiente;

                            if (!in_array($idAmbiente, $listaIdsAmbientes)) {
                                // Si no está, lo agregamos
                                $listaIdsAmbientes[] = $idAmbiente;
                            }

                            foreach ($listaHorasDistribuidas as $horaOcupada) {
                                $this->registrarPeriodoReservaOcupado($horaOcupada, $fecha, $idAmbiente);
                                $idDocente = $this->getIdDocente($nombreDocente);
                                $idMateria = $this->getIdMateria($idDocente, $nombreMateria);
                                $this->cambiarEstadoMotivo($motivo, $idMateria);
                            }
                        }
                    }
                }
            }

            $datosSolicitud = [
                'idmateria' => $idMateriaDocentes,
                'capacidadsolicitud' => $capacidad,
                'fechasolicitud' => $fecha,
                'horainicialsolicitud' => $horaInicial,
                'horafinalsolicitud' => $horaFinal,
                'motivosolicitud' => $motivo,
                'aceptada' => true,
                'especial' => false
            ];

            $solicitudCreada = $this->registrarSolicitud($datosSolicitud);
            $idSolicitud = $solicitudCreada->idsolicitud;

            //se asocia la solicitud con los docentes que realizaron la solicitud, ambos devuelven true si la informacion
            //se guardo correctamente
            $asociacionDocenteSolicitud = $this->asociarSolicitudConDocente($listaIdsDocentes, $idSolicitud);
            $asociacionAmbienteSolicitud = $this->asociarSolicitudConAmbiente($listaIdsAmbientes, $idSolicitud);




            return response()->json(
                [
                    'solicitud' => $solicitudCreada,
                    'asociacioncondocente' => $asociacionDocenteSolicitud,
                    'asociacionconambiente' => $asociacionAmbienteSolicitud,
                    'reserva' => true,
                    'mensaje' => 'Solicitud creada correctamente'
                ]
            );
        } else {
            return response()->json(
                [
                    'solicitud' => null,
                    'asociacioncondocente' => false,
                    'asociacionconambiente' => false,
                    'reserva' => false,
                    'mensaje' => 'No se pudo crear la solicitud, ya que el ambiente se encuentra ocupado en el horario seleccionado'
                ]
            );
        }



    }

    private function getIdMateriaDocentes($nombresDocentes, $nombreMateria)
    {
        $listaIdMaterias = [];
        foreach ($nombresDocentes as $nombreDocente) {
            $docente = Usuario::where('nombreusuario', $nombreDocente)
                    ->where('administrador', false)
                    ->first();
            if ($docente) {
                $idDocente = $docente->idusuario;
                $materia = Materia::where('idusuario', $idDocente)
                        ->where('nombremateria', $nombreMateria)
                        ->first();
                if ($materia) {
                    $listaIdMaterias[] = $materia->idmateria;
                }
            }
        }
        return $listaIdMaterias[0];
    }

    private function verificarHorasDisponibles($horaInicial, $horaFinal, $fecha, $listaIdAmbientes)
    {
        $listaHoras = $this->generarListaHoras($horaInicial, $horaFinal);

        foreach ($listaIdAmbientes as $idAmbiente) {
            foreach ($listaHoras as $hora) {
                $periodoOcupado = $this->periodoOcupado($hora, $fecha, $idAmbiente);
                if ($periodoOcupado) {
                    return false;
                }
            }
        }

        return true;
    }

    private function getIdAmbientesByName($nombresAmbientes)
    {
        $listaIdAmbientes = [];
        foreach ($nombresAmbientes as $nombreAmbiente) {
            $ambiente = Ambiente::where('nombreambiente', $nombreAmbiente)->first();
            if ($ambiente) {
                $listaIdAmbientes[] = $ambiente->idambiente;
            }
        }
        return $listaIdAmbientes;
    }
    private function cambiarEstadoMotivo($motivo, $idMateria)
    {
        $idMotivo = $this->getIdMotivo($motivo, $idMateria);
        $motivo = Motivo::find($idMotivo);

        if ($motivo) {
            $motivo->registrado = true;
            $motivo->save();
        }
    }

    private function getIdMotivo($motivo, $idMateria)
    {
        $motivo = Motivo::where('nombremotivo', $motivo)
                ->where('idmateria', $idMateria)
                ->first();
        if ($motivo) {
            return $motivo->idmotivo;
        }
    }


    private function getIdMateria($idDocente, $nombreMateria)
    {
        $materia = Materia::where('idusuario', $idDocente)
                ->where('nombremateria', $nombreMateria)
                ->first();
        if ($materia) {
            return $materia->idmateria;
        }
    }

    private function getIdDocente($nombreDocente)
    {
        $docente = Usuario::where('nombreusuario', $nombreDocente)
                    ->where('administrador', false)
                    ->first();
        if ($docente) {
            return $docente->idusuario;
        }
    }

    private function getIdAmbientes($listaIdAmbientes)
    {
        $listaAmbientes = [];
        foreach ($listaIdAmbientes as $idAmbiente) {
            $ambiente = Ambiente::where('idambiente', $idAmbiente)->first();
            if ($ambiente) {
                $listaAmbientes[] = $ambiente;
            }
        }
        return $listaAmbientes;
    }



    private function registrarSolicitud($solicitudData)
    {
        $solicitud = Solicitud::create($solicitudData);
        return $solicitud;
    }

    private function asociarSolicitudConDocente($idsdocentes, $idSolicitud)
    {
        foreach ($idsdocentes as $idDocente) {
            $solicitudDocente = [
                'idusuario' => $idDocente,
                'idsolicitud' => $idSolicitud
            ];

            $solicitudDocenteAsociada = UsuarioConSolicitud::insert($solicitudDocente);
        }
        return $solicitudDocenteAsociada;
    }

    private function asociarSolicitudConAmbiente($listaIDAmbiente, $idSolicitud)
    {
        foreach ($listaIDAmbiente as $idAmbiente) {
            $solicitudAmbiente = [
                'idambiente' => $idAmbiente,
                'idsolicitud' => $idSolicitud
            ];

            $solicitudAmbienteAsociada = SolicitudConAmbiente::insert($solicitudAmbiente);
        }
        return $solicitudAmbienteAsociada;
    }



    private function registrarPeriodoReservaOcupado($horaPorOcupar, $fecha, $idAmbiente)
    {
        $periodoNoDisponibleSinRegistrar = $this->periodoOcupado($horaPorOcupar, $fecha, $idAmbiente);
        if (!$periodoNoDisponibleSinRegistrar) {

            $periodoNoDisponible = [
                'idambiente' => $idAmbiente,
                'fecha' => $fecha,
                'hora' => $horaPorOcupar
            ];

            $registrarPeriodoNoDisponible = PeriodoReservaOcupado::insert($periodoNoDisponible);

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

    //verifica si el periodo no disponible ya ha sido registrado osea si la hora fecha y ambiente ya estan ocupados
    private function periodoOcupado($hora, $fecha, $idAmbiente)
    {
        $periodoOcupado = PeriodoReservaOcupado::where('idambiente', $idAmbiente)->where('fecha', $fecha)->where('hora', $hora)->first();
        if ($periodoOcupado) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\PeriodoReservaOcupado  $periodoReservaOcupado
     * @return \Illuminate\Http\Response
     */
    public function show(PeriodoReservaOcupado $periodoReservaOcupado)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\PeriodoReservaOcupado  $periodoReservaOcupado
     * @return \Illuminate\Http\Response
     */
    public function edit(PeriodoReservaOcupado $periodoReservaOcupado)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\PeriodoReservaOcupado  $periodoReservaOcupado
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, PeriodoReservaOcupado $periodoReservaOcupado)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\PeriodoReservaOcupado  $periodoReservaOcupado
     * @return \Illuminate\Http\Response
     */
    public function destroy(PeriodoReservaOcupado $periodoReservaOcupado)
    {
        //
    }
}
