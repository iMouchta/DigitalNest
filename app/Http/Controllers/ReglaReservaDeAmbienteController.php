<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Models\ReglaReservaDeAmbiente;



class ReglaReservaDeAmbienteController extends Controller
{
     // Función para registrar una regla de reserva de ambiente Y asignarla a un ambiente
    public function registrarReglaReservaDeAmbiente(Request $request)
    {
        $datosFormularioReglaDeReserva = request()->except('_token');
        $idAmbiente = $datosFormularioReglaDeReserva['idambiente'];
        $fechaInicialDisponible = $datosFormularioReglaDeReserva['fechainicialdisponible'];
        $fechaFinalDisponible = $datosFormularioReglaDeReserva['fechafinaldisponible'];
        $horaInicialDisponible = $datosFormularioReglaDeReserva['horainicialdisponible'];
        $horaFinalDisponible = $datosFormularioReglaDeReserva['horafinaldisponible'];

        $reglaReservaDeAmbienteRepetida = $this->reglaReservaDeAmbienteRepetida($idAmbiente, $fechaInicialDisponible, $fechaFinalDisponible, $horaInicialDisponible, $horaFinalDisponible);

        if ($reglaReservaDeAmbienteRepetida) {
            return response()->json([
                'registrada' => false,
                'mensaje' => 'La regla de reserva de ambiente ya existe'
            ]);
        } else {

            $reglaReservaDeAmbienteData = [
                'idambiente' => $idAmbiente,
                'fechainicialdisponible' => $fechaInicialDisponible,
                'fechafinaldisponible' => $fechaFinalDisponible,
                'horainicialdisponible' => $horaInicialDisponible,
                'horafinaldisponible' => $horaFinalDisponible,
            ];

            $reglaReservaDeAmbienteSubida = ReglaReservaDeAmbiente::insert($reglaReservaDeAmbienteData);

            if ($reglaReservaDeAmbienteSubida) {
                return response()->json([
                    'registrada' => true,
                    'message' => 'Regla de reserva de ambiente subida correctamente',
                ]);
            } else {
                return response()->json([
                    'registrada' => false,
                    'message' => 'Error al subir la regla de reserva de ambiente',
                ]);
            }
        }
    }

    private function reglaReservaDeAmbienteRepetida($idAmbiente, $fechaInicialDisponible, $fechaFinalDisponible, $horaInicialDisponible, $horaFinalDisponible)
    {
        $reglaReservaDeAmbiente = ReglaReservaDeAmbiente::where('idambiente', $idAmbiente)
            ->where('fechainicialdisponible', $fechaInicialDisponible)
            ->where('fechafinaldisponible', $fechaFinalDisponible)
            ->where('horainicialdisponible', $horaInicialDisponible)
            ->where('horafinaldisponible', $horaFinalDisponible)
            ->first();
        return $reglaReservaDeAmbiente;
    }

    // Función para eliminar una regla de reserva de ambiente
    public function eliminarReglaReservaDeAmbiente(Request $request) {
        $informacionReglaReservaDeAmbiente = request()->except('_token');
        $idReglaReservaDeAmbiente = $informacionReglaReservaDeAmbiente['idreglareservadeambiente'];
        $reglaReservaDeAmbiente = ReglaReservaDeAmbiente::find($idReglaReservaDeAmbiente);
        $ambienteEliminado = $reglaReservaDeAmbiente->delete();

        if ($ambienteEliminado) {
            return response()->json([
                'eliminada' => true,
                'mensaje' => 'Regla de reserva de ambiente eliminada correctamente'
            ]);
        } else {
            return response()->json([
                'eliminada' => false,
                'mensaje' => 'Error al eliminar la regla de reserva de ambiente'
            ]);
        }
    }

    // Función para obtener las reglas de reserva de un ambiente en específico con su id
    public function getReglaReservaDeAmbiente(Request $request)
    {
        $informacionAmbiente = request()->except('_token');
        $idAmbiente = $informacionAmbiente['idambiente'];
        $reglasReservaDeAmbiente = ReglaReservaDeAmbiente::where('idambiente', $idAmbiente)->get();
        return response()->json($reglasReservaDeAmbiente);
    }

    // Función para editar una regla de reserva de ambiente
    public function editarReglaReservaDeAmbiente(Request $request)
    {
        $datosFormularioEdicionReglaDeReserva = request()->except('_token');
        $idReglaReservaDeAmbiente = $datosFormularioEdicionReglaDeReserva['idreglareservadeambiente'];

        $nuevaFechaInicialDisponible = $datosFormularioEdicionReglaDeReserva['fechainicialdisponible'];
        $nuevaFechaFinalDisponible = $datosFormularioEdicionReglaDeReserva['fechafinaldisponible'];
        $nuevaHoraInicialDisponible = $datosFormularioEdicionReglaDeReserva['horainicialdisponible'];
        $nuevaHoraFinalDisponible = $datosFormularioEdicionReglaDeReserva['horafinaldisponible'];

        $reglaReservaDeAmbiente = ReglaReservaDeAmbiente::find($idReglaReservaDeAmbiente);

        $reglaReservaDeAmbiente->fechainicialdisponible = $nuevaFechaInicialDisponible;
        $reglaReservaDeAmbiente->fechafinaldisponible = $nuevaFechaFinalDisponible;
        $reglaReservaDeAmbiente->horainicialdisponible = $nuevaHoraInicialDisponible;
        $reglaReservaDeAmbiente->horafinaldisponible = $nuevaHoraFinalDisponible;

        $reglaReservaDeAmbienteActualizada = $reglaReservaDeAmbiente->save();

        if ($reglaReservaDeAmbienteActualizada) {
            return response()->json([
                'actualizada' => true,
                'mensaje' => 'Regla de reserva de ambiente actualizada correctamente'
            ]);
        } else {
            return response()->json([
                'actualizada' => false,
                'mensaje' => 'Error al actualizar la regla de reserva de ambiente'
            ]);
        }
    }
}
