<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Solicitud;
use App\Models\Ambiente;
use App\Models\Usuario;
use App\Http\Controllers\NotificacionController;
use App\Http\Controllers\EmailController;
use Carbon\Carbon;


class SolicitudEspecialController extends Controller
{
    protected $notificacionController;
    protected $emailcontroller;

    public function __construct(EmailController $emailController, NotificacionController $notificacionController)
    {
        $this->emailcontroller = $emailController;
        $this->notificacionController = $notificacionController;
    }

    public function create()
    {
        $ambientes = Ambiente::all();
        return view('welcome', compact('ambientes'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'idusuarios' => 'required|array',
            'idusuarios.*' => 'required|integer|exists:usuario,idusuario',
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
        $solicitud->aceptada = false;
        $solicitud->save();


        $solicitud->usuarios()->sync($request->idusuarios);
        $solicitud->ambientes()->sync($request->idambientes);

        return response()->json(['subida' => true]);
    }


    public function index()
    {
        $solicitudes = Solicitud::with([
            'usuarios',
            'ambientes' => function ($query) {
                $query->with('edificio');
            }
        ])
            ->where('especial', true)
            ->get();

        $solicitudesConDatos = $solicitudes->map(function ($solicitud) {
            $ambientes = $solicitud->ambientes->map(function ($ambiente) {
                return [
                    'nombre_ambiente' => $ambiente->nombreambiente,
                    'edificio' => $ambiente->edificio->nombreedificio,
                    'planta' => $ambiente->planta,
                ];
            });

            $nombresUsuarios = $solicitud->usuarios->pluck('nombreusuario')->toArray();

            return [
                'idsolicitud' => $solicitud->idsolicitud,
                'fechasolicitud' => $solicitud->fechasolicitud,
                'horainicialsolicitud' => $solicitud->horainicialsolicitud,
                'horafinalsolicitud' => $solicitud->horafinalsolicitud,
                'motivosolicitud' => $solicitud->motivosolicitud,
                'nombreusuarios' => $nombresUsuarios,
                'ambientes' => $ambientes->toArray(),
                'aceptada' => $solicitud->aceptada ? true : false,
            ];
        });

        return response()->json($solicitudesConDatos);
    }
    public function reservas()
    {
        $indexResponse = $this->index();
        $solicitudes = json_decode($indexResponse->getContent(), true);
        $solicitudesAceptadas = array_filter($solicitudes, function ($solicitud) {
            return $solicitud['aceptada'] === true;
        });

        $solicitudesAceptadas = array_values($solicitudesAceptadas);
        return response()->json($solicitudesAceptadas);
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

        foreach ($solicitud->usuarios as $usuario) {
            $this->notificacionController->notificarUsuario(
                $usuario->idusuario,
                'Tu solicitud especial ha sido eliminada.',
                false
            );
        }

        $solicitud->ambientes()->detach();
        $solicitud->usuarios()->detach();
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


        $conflictosData = $this->generarConflictos($request);
        $idsSolicitudes = $conflictosData['ids_solicitudes'];
        $horariosInicial = $conflictosData['horario'];

        $solicitud = Solicitud::findOrFail($request->idsolicitud);

        $solicitud->aceptada = true;
        $solicitud->save();

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
