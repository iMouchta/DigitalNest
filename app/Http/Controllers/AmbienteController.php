<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ambiente;
use App\Models\Edificio;
use App\Models\SolicitudConAmbiente;
use App\Models\Solicitud;
use App\Models\PeriodoReservaOcupado;
use App\Models\ReglaReservaDeAmbiente;
use Carbon\Carbon;



use App\Http\Controllers\ReglaReservaDeAmbienteController;

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
        $reglaReservaDeAmbienteController = new ReglaReservaDeAmbienteController();
        $listaAmbientesConUbicacion = [];

        foreach ($ambientes as $ambiente) {
            $listaReglasDeAmbiente = $reglaReservaDeAmbienteController->getReglaReservaDeAmbiente($ambiente->idambiente);
            $nombreEdificio = $this->getNombreEdificio($ambiente->idedificio);

            $ambienteConUbicacion = [
                'idambiente' => $ambiente->idambiente,
                'nombreambiente' => $ambiente->nombreambiente,
                'edificio' => $nombreEdificio,
                'planta' => $ambiente->planta,
                'capacidadambiente' => $ambiente->capacidadambiente,
                'reglasDeReserva' => $listaReglasDeAmbiente,
            ];
            $listaAmbientesConUbicacion[] = $ambienteConUbicacion;
        }


        return response()->json($listaAmbientesConUbicacion);
    }

    private function getNombreEdificio($idEdificio)
    {
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
        $edificio = $datosFormularioCreacionAmbiente['edificio'];
        // $idubicacion = $datosFormularioCreacionAmbiente['idedificio'];
        $planta = $datosFormularioCreacionAmbiente['planta'];

        $idEdificio = $this->getIdEdificioByName($edificio);
        $edificioExiste = Edificio::where('nombreedificio', $edificio)->first();

        if ($edificioExiste) {
            if ($this->ambienteRepetido($nombreAmbiente)) {
                return response()->json([
                    'ambienteRegistrado' => false,
                    'mensaje' => 'El ambiente ya existe'
                ]);
            } else {
                $datosAmbiente = [
                    'nombreambiente' => $nombreAmbiente,
                    'capacidadambiente' => $capacidad,
                    'planta' => $planta,
                    'idedificio' => $idEdificio,
                ];
                $registrado = ambiente::insert($datosAmbiente);
                return response()->json([
                    'ambienteRegistrado' => $registrado,
                    'mensaje' => $registrado ? 'Ambiente registrado' : 'Error al registrar ambiente'
                ]);
            }
        } else {
            return response()->json([
                'ambienteRegistrado' => false,
                'mensaje' => 'El edificio no existe'
            ]);
        }


    }

    private function getIdEdificioByName($nombreEdificio)
    {
        $edificio = Edificio::where('nombreedificio', $nombreEdificio)->first();
        return $edificio->idedificio;
    }

    private function ambienteRepetido($nombreAmbiente)
    {
        $ambiente = ambiente::where('nombreambiente', $nombreAmbiente)->first();
        return $ambiente != null;
    }

    //Devuelve informacion de un ambiente segun su id
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function getAmbienteById()
    {
        $datosAmbiente = request()->except('_token');
        $idAmbiente = $datosAmbiente['idambiente'];
        $ambiente = Ambiente::find($idAmbiente);
        $idEdificio = $ambiente->idedificio;

        $edificio = Edificio::find($idEdificio);
        $nombreEdificio = $edificio->nombreedificio;

        $infoAmbiente = [
            'nombreambiente' => $ambiente->nombreambiente,
            'capacidadambiente' => $ambiente->capacidadambiente,
            'planta' => $ambiente->planta,
            'nombreedificio' => $nombreEdificio,
        ];

        return response()->json($infoAmbiente);
    }

    public function editAmbiente(Request $request)
    {
        $datosFormulario = request()->except('_token');
        $idAmbiente = $datosFormulario['idambiente'];
        $nombreAmbiente = $datosFormulario['nombreambiente'] ?? null;
        $capacidad = $datosFormulario['capacidadambiente'] ?? null;
        $planta = $datosFormulario['planta'] ?? null;
        $nombreEdificio = $datosFormulario['nombreedificio'] ?? null;

        $ambienteTieneReservas = $this->ambienteTieneReservas($idAmbiente);

        if (!$ambienteTieneReservas) {

            $ambiente = Ambiente::find($idAmbiente);

            if ($nombreEdificio != null) {
                $idEdificio = $this->getIdEdificioByName($nombreEdificio);
            }
            if ($nombreAmbiente != null) {
                $ambiente->nombreambiente = $nombreAmbiente;
            }
            if (!empty($capacidad)) {
                $ambiente->capacidadambiente = $capacidad;
            }
            if (!empty($planta)) {
                $ambiente->planta = $planta;
            }
            if (!empty($idEdificio)) {
                $ambiente->idedificio = $idEdificio;
            }

            $actualizado = $ambiente->save();

            if ($actualizado) {
                return response()->json([
                    'actualizado' => true,
                    'mensaje' => 'Ambiente actualizado correctamente'
                ]);
            } else {
                return response()->json([
                    'actualizado' => false,
                    'mensaje' => 'Error al actualizar el ambiente'
                ]);
            }
        } else {
            return response()->json([
                'actualizado' => false,
                'mensaje' => 'No se pudo editar el ambiente, porque ya tiene reservas asociadas'
            ]);
        }
    }

    public function deleteAmbiente(Request $request)
    {
        $datosFormulario = request()->except('_token');
        $idAmbientePorEliminar = $datosFormulario['idambiente'];

        $ambienteTieneReservas = $this->ambienteTieneReservas($idAmbientePorEliminar);

        if (!$ambienteTieneReservas) {
            $ambiente = Ambiente::find($idAmbientePorEliminar);
            $eliminado = $ambiente->delete();

            if ($eliminado) {
                return response()->json([
                    'eliminado' => true,
                    'mensaje' => 'Ambiente eliminado correctamente'
                ]);
            } else {
                return response()->json([
                    'eliminado' => false,
                    'mensaje' => 'Error al eliminar el ambiente'
                ]);
            }
        } else {
            $listaConsecuenciasEliminacionAmbiente = [];
            $idSolicitudesAfectadas = $this->getIdSolicitudesAfectadasPorEliminacion($idAmbientePorEliminar);
            foreach ($idSolicitudesAfectadas as $idSolicitudAfectada) {
                $ambientesDisponibles = $this->asignarNuevoAmbiente($idSolicitudAfectada, $idAmbientePorEliminar);
                if (count($ambientesDisponibles) > 0) {
                    $nuevoAmbienteAsignado = $ambientesDisponibles[0];

                    //to do
                    $this->asociarNuevoAmbienteConSolicitud($idSolicitudAfectada, $nuevoAmbienteAsignado->idambiente);

                    $listaConsecuenciasEliminacionAmbiente[] = [
                        'idSolicitud' => $idSolicitudAfectada,
                        'ambientesDisponibles' => $nuevoAmbienteAsignado,
                        'mensaje' => 'Se asignó un nuevo ambiente a la solicitud'
                    ];
                } else {
                    $listaConsecuenciasEliminacionAmbiente[] = [
                        'idSolicitud' => $idSolicitudAfectada,
                        'ambientesDisponibles' => [],
                        'mensaje' => 'No se pudo asignar un nuevo ambiente a la solicitud'
                    ];
                }
            }

            //to do
            $this->actualizarPeriodosDeReserva($idSolicitudAfectada, $nuevoAmbienteAsignado->idambiente);
            $this->actualizarReglasDeReserva($idSolicitudAfectada, $nuevoAmbienteAsignado->idambiente);
            $this->eliminarAmbienteSinConsecuencias($idAmbientePorEliminar);

            return response()->json([
                // 'eliminado' => false,
                // 'mensaje' => 'No se pudo eliminar el ambiente, porque tiene reservas asociadas',
                'consecuencias' => $listaConsecuenciasEliminacionAmbiente
                // 'ambientesDisponibles' => $ambientesDisponibles
            ]);

        }
    }

    private function asignarNuevoAmbiente($idSolicitud, $IdAmbientePorEliminar)
    {
        $datosSolicitud = Solicitud::find($idSolicitud);

        $infoAmbientePorEliminar = Ambiente::find($IdAmbientePorEliminar);
        $capacidadAmbientePorEliminar = $infoAmbientePorEliminar->capacidadambiente;

        $fecha = $datosSolicitud->fechasolicitud;
        $horaInicial = $datosSolicitud->horainicialsolicitud;
        $horaFinal = $datosSolicitud->horafinalsolicitud;

        $ambientesDisponibles = [];

        $ambientes = Ambiente::all();
        $listaHoras = $this->generarListaHoras($horaInicial, $horaFinal);
        foreach ($ambientes as $ambiente) {
            $idAmbiente = $ambiente->idambiente;
            $capacidadAmbiente = $ambiente->capacidadambiente;
            if ($capacidadAmbiente >= $capacidadAmbientePorEliminar && $idAmbiente != $IdAmbientePorEliminar) {
                foreach ($listaHoras as $hora) {
                    $periodoReservaOcupado = PeriodoReservaOcupado::
                        where('idambiente', $ambiente->idambiente)
                        ->where('fecha', $fecha)
                        ->where('hora', $hora)
                        ->first();
                    if (!$periodoReservaOcupado) {
                        if (!$this->ambienteDuplicado($ambiente, $ambientesDisponibles)) {
                            if ($this->cumpleReglaReserva($ambiente->idambiente, $fecha, $horaInicial, $horaFinal)) {
                                $ambientesDisponibles[] = $ambiente;
                                break;
                            }
                        }
                    }
                }
            }
        }

        return $ambientesDisponibles;
    }

    private function getIdSolicitudesAfectadasPorEliminacion($idAmbiente)
    {
        $solicitudesAsociadasConAmbiente = SolicitudConAmbiente::where('idambiente', $idAmbiente)->get();
        $listaIdsSolicitudesAfectadas = [];

        foreach ($solicitudesAsociadasConAmbiente as $solicitudAsociadaConAmbiente) {
            $idSolicitudAfectada = $solicitudAsociadaConAmbiente->idsolicitud;
            $listaIdsSolicitudesAfectadas[] = $idSolicitudAfectada;
        }

        return $listaIdsSolicitudesAfectadas;
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

    private function cumpleReglaReserva($idAmbiente, $fecha, $horaInicial, $horaFinal)
    {
        $reglaReservaDeAmbiente = ReglaReservaDeAmbiente::where('idambiente', $idAmbiente)->get();
        $fechaSolicitudCarbon = Carbon::parse($fecha);
        $horaInicialSolicitudCarbon = Carbon::parse($horaInicial);
        $horaFinalSolicitudCarbon = Carbon::parse($horaFinal);

        if ($reglaReservaDeAmbiente) {
            foreach ($reglaReservaDeAmbiente as $regla) {
                $horaInicialDisponible = Carbon::parse($regla->horainicialdisponible);
                $horaFinalDisponible = Carbon::parse($regla->horafinaldisponible);
                $fechaInicialDisponible = Carbon::parse($regla->fechainicialdisponible);
                $fechaFinalDisponible = Carbon::parse($regla->fechafinaldisponible);

                if ($fechaSolicitudCarbon->between($fechaInicialDisponible, $fechaFinalDisponible)) {
                    if (($horaInicialSolicitudCarbon >= $horaInicialDisponible) && ($horaFinalSolicitudCarbon <= $horaFinalDisponible)) {
                        return true;
                    }
                }
            }
        }
        return false;
    }

    private function ambienteDuplicado($ambiente, $ambientesDisponibles)
    {
        $repetido = false;
        foreach ($ambientesDisponibles as $ambienteDisponible) {
            if ($ambienteDisponible->idambiente == $ambiente->idambiente) {
                $repetido = true;
                break;
            }
        }
        return $repetido;
    }

    private function ambienteTieneReservas($idAmbiente)
    {
        $solicitudConAmbiente = SolicitudConAmbiente::where('idambiente', $idAmbiente)->first();
        if ($solicitudConAmbiente) {
            return true;
        } else {
            return false;
        }
    }
}
