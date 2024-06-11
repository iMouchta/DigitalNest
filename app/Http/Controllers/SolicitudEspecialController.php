<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Solicitud;
use App\Models\Ambiente;
use App\Models\Usuario;
use App\Http\Controllers\NotificacionController;
use Carbon\Carbon;


class SolicitudEspecialController extends Controller
{
    //kevin
    protected $notificacionController;
    protected $emailController;

    //kevin
    public function __construct(NotificacionController $notificacionController, EmailController $emailController)
    {
        $this->notificacionController = $notificacionController;
        $this->emailController = $emailController;
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
        $usuariosSolicitud = $request->idusuarios;
        $motivo = $request->motivosolicitud;
        $fecha = $request->fechasolicitud;

        $mensaje = "Se ha creado una nueva solicitud con la siguiente información: 
            - Fecha: $fecha
            - Motivo: $motivo";

        foreach ($usuariosSolicitud as $idUsuario) {
            $this->notificacionController->notificarUsuario($idUsuario, $mensaje, false);
            $this->enviarCorreosDesdeApi(new Request([
                'ids_usuarios' => [$idUsuario],
                'mensaje' => $mensaje
            ]));
        }

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

    public function eliminarConCorreo(Request $request)
    {
        $request->validate([
            'idsolicitud' => 'required|integer|exists:solicitud,idsolicitud'
        ]);

        $solicitud = Solicitud::findOrFail($request->idsolicitud);
        $motivo = $solicitud->motivosolicitud;
        $usuariosSolicitud = $solicitud->usuarios->pluck('idusuario');
        $fecha = $solicitud->fechasolicitud;

        
        $mensaje = "Se ha cancelado su solicitud para el dia: $fecha, con el motivo: $motivo";

                foreach ($usuariosSolicitud as $idUsuario) {
            $this->notificacionController->notificarUsuario($idUsuario, $mensaje, false);
            $this->enviarCorreosDesdeApi(new Request([
                'ids_usuarios' => [$idUsuario],
                'mensaje' => $mensaje
            ]));
        }

        $solicitud->ambientes()->detach();
        $solicitud->usuarios()->detach();
        $solicitud->delete();

        return response()->json("true");       
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
        $motivo = $solicitud->motivosolicitud;
        $usuariosSolicitud = $solicitud->usuarios->pluck('idusuario');

        foreach ($usuariosSolicitud as $idUsuario) {
            $mensaje = "Su solicitud con el motivo: $motivo, ha sido aceptada.";
            $this->notificacionController->notificarUsuario($idUsuario, $mensaje, false);
            $this->enviarCorreosDesdeApi(new Request([
                'ids_usuarios' => [$idUsuario],
                'mensaje' => $mensaje
            ]));
        }

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

        foreach ($conflictos as $idSolicitudConflictiva) {
            $solicitudConflictiva = Solicitud::findOrFail($idSolicitudConflictiva);
            $usuariosConflictiva = $solicitudConflictiva->usuarios->pluck('idusuario');

            foreach ($usuariosConflictiva as $idUsuario) {
                $mensaje = "Su solicitud ha sido rechazada por el motivo de: $motivo.";
                $this->notificacionController->notificarUsuario($idUsuario, $mensaje, false);
                $this->enviarCorreosDesdeApi(new Request([
                    'ids_usuarios' => [$idUsuario],
                    'mensaje' => $mensaje
                ]));
            }
        }

        foreach ($conflictos as $idSolicitudConflictiva) {
            $requestEliminar = new Request(['idsolicitud' => $idSolicitudConflictiva]);
            $this->eliminar($requestEliminar);

        }

        $solicitud->aceptada = true;
        $solicitud->save();

        return response()->json(
            [
                'aceptada' => true
            ]
        );
    }

    public function confirmar(Request $request)
    {
        $request->validate([
            'idsolicitud' => 'required|integer|exists:solicitud,idsolicitud'
        ]);

        $conflictosData = $this->generarConflictos($request);
        $idsSolicitudes = $conflictosData['ids_solicitudes'];
        $horariosInicial = $conflictosData['horario'];

        $solicitud = Solicitud::findOrFail($request->idsolicitud);

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

        return response()->json(
            [
                'SolicitudesEliminar' => $conflictos
            ]
        );

    }

    public function enviarCorreos(array $idsUsuarios, string $mensaje)
    {
        $correos = Usuario::whereIn('idusuario', $idsUsuarios)->pluck('correousuario')->toArray();

        foreach ($correos as $correo) {
            $this->emailController->enviarCorreo(new Request([
                'Correos' => [$correo],
                'Mensaje' => $mensaje
            ]));
        }
    }

    public function enviarCorreosDesdeApi(Request $request)
    {
        $request->validate([
            'ids_usuarios' => 'required|array',
            'ids_usuarios.*' => 'required|integer',
            'mensaje' => 'required|string'
        ]);

        $idsUsuarios = $request->ids_usuarios;
        $mensaje = $request->mensaje;
        $usuariosExistentes = Usuario::whereIn('idusuario', $idsUsuarios)->pluck('idusuario')->toArray();
        $idsNoEncontradas = array_diff($idsUsuarios, $usuariosExistentes);

        if (!empty($idsNoEncontradas)) {
            return response()->json([
                'error' => 'Un(os) usuario(s) no fue(ron) encontradp(s)',
                'usuariosEncontrados' => $idsNoEncontradas
            ], 400);
        }

        $this->enviarCorreos($usuariosExistentes, $mensaje);

        return response()->json(['mensaje' => 'Correos enviados correctamente']);
    }

    public function buscarPorFecha(Request $request)
    {
        $request->validate([
            'fecha' => 'required|date',
        ]);

        $fecha = $request->fecha;

        $solicitudes = Solicitud::with([
            'usuarios',
            'ambientes' => function ($query) {
                $query->with('edificio');
            }
        ])
            ->where('especial', true)
            ->whereDate('fechasolicitud', $fecha)
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
                'nombreusuarios' => $nombresUsuarios,
                'motivosolicitud' => $solicitud->motivosolicitud,
                'fechasolicitud' => $solicitud->fechasolicitud,
                'horainicialsolicitud' => $solicitud->horainicialsolicitud,
                'horafinalsolicitud' => $solicitud->horafinalsolicitud,
                'ambientes' => $ambientes->toArray(),
                'aceptada' => $solicitud->aceptada !== null ? ($solicitud->aceptada ? true : false) : null
            ];
        });

        return response()->json($solicitudesConDatos);
    }

    public function buscarIDPorFecha(Request $request)
    {
        $request->validate([
            'fecha' => 'required|date',
        ]);

        $fecha = $request->fecha;

        $solicitudes = Solicitud::whereDate('fechasolicitud', $fecha)
            ->pluck('idsolicitud');

        return response()->json($solicitudes);
    }

    public function actualizarFechasSolicitudes(Request $request)
    {
        $request->validate([
            'fecha1' => 'required|date',
            'fecha2' => 'required|date',
        ]);

        $fechaOriginal = $request->fecha1;
        $nuevaFecha = $request->fecha2;

        $solicitudes = Solicitud::whereDate('fechasolicitud', $fechaOriginal)->get();

        if ($solicitudes->isEmpty()) {
            return response()->json(['mensaje' => 'No se encontraron solicitudes con la fecha original proporcionada.'], 404);
        }
        $usuariosSolicitud = [];
        foreach ($solicitudes as $solicitud) {
            $usuariosSolicitud = array_merge($usuariosSolicitud, $solicitud->usuarios->pluck('idusuario')->toArray());
        }
        $usuariosSolicitud = array_unique($usuariosSolicitud);
        $mensaje = "Su reserva de la fecha: $fechaOriginal, ha sido actualizada. La nueva fecha es: $nuevaFecha";
        foreach ($usuariosSolicitud as $idUsuario) {
            $this->notificacionController->notificarUsuario($idUsuario, $mensaje, false);
            $this->enviarCorreosDesdeApi(new Request([
                'ids_usuarios' => [$idUsuario],
                'mensaje' => $mensaje
            ]));
        }
        foreach ($solicitudes as $solicitud) {
            $solicitud->fechasolicitud = $nuevaFecha;
            $solicitud->save();
        }

        return response()->json(['mensaje' => 'Las fechas han sido actualizadas correctamente.']);
    }





}
