<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Solicitud;
use App\Models\Ambiente;
use Carbon\Carbon;
use App\Models\periodonodisponible;

class SolicitudEspecialController extends Controller
{
    public function create()
    {
        $ambientes = Ambiente::all();
        return view('welcome', compact('ambientes'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'idadministrador' => 'required|integer|exists:administrador,idadministrador',
            'fechasolicitud' => 'required|date',
            'horainicialsolicitud' => 'required|date_format:H:i',
            'horafinalsolicitud' => 'required|date_format:H:i',
            'motivosolicitud' => 'required|string|max:1000',
            'idambientes' => 'required|array',
            'idambientes.*' => 'integer|exists:ambiente,idambiente',
            'especial' => 'boolean|nullable',
            'aceptada' => 'boolean|nullable',
        ]);

        $solicitud = new Solicitud();
        $solicitud->fill($request->except(['_token', 'idambientes']));
        $solicitud->especial = true;
        $solicitud->save();

        $solicitud->ambientes()->sync($request->idambientes);
        return response()->json(['subida' => true]);
    }


    public function index()
    {
        $solicitudes = Solicitud::with([
            'administrador',
            'ambientes' => function ($query) {
                $query->with('ubicacion');
            }
        ])
            ->where('especial', true)
            ->get();

        $solicitudesConDatos = $solicitudes->map(function ($solicitud) {
            $ambientes = $solicitud->ambientes->map(function ($ambiente) {
                return [
                    'nombre_ambiente' => $ambiente->nombreambiente,
                    'ubicacion' => $ambiente->ubicacion->nombreubicacion,
                    'planta' => $ambiente->planta,
                ];
            });

            return [
                'idsolicitud' => $solicitud->idsolicitud,
                'fechasolicitud' => $solicitud->fechasolicitud,
                'horainicialsolicitud' => $solicitud->horainicialsolicitud,
                'horafinalsolicitud' => $solicitud->horafinalsolicitud,
                'motivosolicitud' => $solicitud->motivosolicitud,
                'nombreadministrador' => $solicitud->administrador->nombreadministrador,
                'ambientes' => $ambientes->toArray(),
                'aceptada' => $solicitud->aceptada ? true : false,
            ];
        });

        return response()->json($solicitudesConDatos);
    }
    public function reservas()
    {
        $solicitudes = Solicitud::with('administrador', 'ambientes', 'ambientes.ubicacion')
            ->where('aceptada', 1)
            ->get();

        $solicitudesConDatos = $solicitudes->map(function ($solicitud) {
            $ambientes = $solicitud->ambientes->map(function ($ambiente) {
                return [
                    'nombre_ambiente' => $ambiente->nombreambiente,
                    'ubicacionAmbiente' => $ambiente->ubicacion->nombreubicacion,
                    'plantaAmbiente' => $ambiente->planta,
                ];
            });

            return [
                'nombreadministrador' => $solicitud->administrador->nombreadministrador,
                'ambientes' => $ambientes,
                'fechasolicitud' => $solicitud->fechasolicitud,
                'horainicialsolicitud' => $solicitud->horainicialsolicitud,
                'horafinalsolicitud' => $solicitud->horafinalsolicitud,
                'motivosolicitud' => $solicitud->motivosolicitud,
            ];
        });

        return response()->json($solicitudesConDatos);
    }

    public function eliminar(Request $request)
    {
        $request->validate([
            'idsolicitud' => 'required|integer|exists:solicitud,idsolicitud'
        ]);

        $solicitud = Solicitud::find($request->idsolicitud);

        if (!$solicitud) {
            return response()->json(['error' => 'Solicitud no encontrada'], 404);
        }

        $solicitud->ambientes()->detach();
        $solicitud->delete();
        return response()->json(['mensaje' => 'La solicitud ha sido eliminada correctamente.']);

    }

    private function generarListaHoras($horaInicial, $horaFinal)
    {
        $listaHoras = [];

        $horaInit = Carbon::parse($horaInicial);
        $horaFin = Carbon::parse($horaFinal)->subMinutes(45);

        while ($horaInit <= $horaFin) {
            $listaHoras[] = $horaInit->format('H:i');
            $horaInit->addMinutes(45);
        }

        return $listaHoras;
    }

    public function generarInfo(Request $request)
    {
        $request->validate([
            'idsolicitud' => 'required|integer|exists:solicitud,idsolicitud'
        ]);

        $solicitud = Solicitud::find($request->idsolicitud);

        $horarios = $this->generarListaHoras($solicitud->horainicialsolicitud, $solicitud->horafinalsolicitud);
        $ambientesIds = $solicitud->ambientes->pluck('idambiente');

        return response()->json([
            'horarios' => $horarios,
            'fecha' => $solicitud->fechasolicitud,
            'ambientes' => $ambientesIds
        ]);
    }

    public function generarConflictos($request)
    {
        $info = $this->generarInfo($request);

        if ($info->getStatusCode() !== 200) {
            return $info;
        }

        $data = $info->getData();
        $fecha = $data->fecha;
        $horario = $data->horarios;

        $solicitudes = Solicitud::where('fechasolicitud', $fecha)
            ->where('idsolicitud', '!=', $request->idsolicitud)
            ->pluck('idsolicitud');

        return [
            'ids_solicitudes' => $solicitudes,
            'horario' => $horario
        ];
    }

    public function accept(Request $request)
{
    $request->validate([
        'idsolicitud' => 'required|integer|exists:solicitud,idsolicitud'
    ]);

    $solicitudInicial = Solicitud::find($request->idsolicitud);

    $conflictosData = $this->generarConflictos($request);
    $idsSolicitudes = $conflictosData['ids_solicitudes'];
    $horariosInicial = $conflictosData['horario'];

    $conflictos = [];
    foreach ($idsSolicitudes as $id) {
        $solicitud = Solicitud::find($id);
        $horariosSolicitud = $this->generarListaHoras($solicitud->horainicialsolicitud, $solicitud->horafinalsolicitud);

        foreach ($horariosInicial as $horaInicial) {
            if (in_array($horaInicial, $horariosSolicitud)) {
                $conflictos[] = $id;
                break;
            }
        }
    }

    return response()->json($conflictos);
}

}
