<?php

namespace App\Http\Controllers;

use App\Models\Usuario;
use App\Models\Materia;
use App\Models\Ambiente;
use App\Models\PeriodoReservaOcupado;
use App\Models\solicitud;
use App\Models\ReglaReservaDeAmbiente;
use Carbon\Carbon;

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
        // return view("solicitudes.solicitudrapida");
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

        $ambientesDisponibles = [];

        foreach ($nombresDocentes as $nombreDocente) {
            $docente = Usuario::where('nombreusuario', $nombreDocente)->first();

            if ($docente) {
                $idDocente = $docente->idusuario;
                $materia = Materia::where('nombremateria', $nombreMateria)
                    ->where('idusuario', $idDocente)
                    ->first();

                if ($materia) {
                    $ambientes = Ambiente::all();
                    $listaHoras = $this->generarListaHoras($horaInicial, $horaFinal);

                    foreach ($ambientes as $ambiente) {
                        $capacidadAmbiente = $ambiente->capacidadambiente;
                        if ($capacidadAmbiente >= $capacidad) {
                            foreach ($listaHoras as $hora) {
                                $periodoReservaOcupado = PeriodoReservaOcupado::
                                    where('idambiente', $ambiente->idambiente)
                                    ->where('fecha', $fecha)
                                    ->where('hora', $hora)
                                    ->first();

                                if (!$periodoReservaOcupado) {
                                    if (!$this->ambienteRepetido($ambiente, $ambientesDisponibles)) {
                                        if ($this->cumpleReglaReserva($ambiente->idambiente, $fecha, $horaInicial, $horaFinal)) {
                                            $ambientesDisponibles[] = $ambiente;
                                            break;
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }

        return response()->json([
            'ambientes' => $ambientesDisponibles,
        ]);

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
    
                if ($fechaSolicitudCarbon -> between($fechaInicialDisponible, $fechaFinalDisponible)) {
                    if (($horaInicialSolicitudCarbon >= $horaInicialDisponible) && ($horaFinalSolicitudCarbon <= $horaFinalDisponible)) {
                        return true;
                    }
                }
            }
        }
        return false;
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

    private function ambienteRepetido($ambiente, $ambientesDisponibles)
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
