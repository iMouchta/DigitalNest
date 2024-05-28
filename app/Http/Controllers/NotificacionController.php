<?php
namespace App\Http\Controllers;

use App\Models\Notificacion;
use App\Models\Usuario;
use Illuminate\Http\Request;

class NotificacionController extends Controller
{
    public function notificarUsuario($idUsuario, $mensaje, $general)
    {
        $notificacion = Notificacion::create([
            'mensaje' => $mensaje,
            'general' => $general,
            'vista' => false,
        ]);

        $usuario = Usuario::find($idUsuario);
        if ($usuario) {
            $usuario->notificaciones()->attach($notificacion->idnotificacion);
            return response()->json(['message' => 'Notificación enviada al usuario.'], 200);
        } else {
            return response()->json(['message' => 'Usuario no encontrado.'], 404);
        }
    }

    public function notificarUsuarios($idUsuarios, $mensaje, $general)
    {
        $notificacion = Notificacion::create([
            'mensaje' => $mensaje,
            'general' => $general,
            'vista' => false,
        ]);

        if (empty($idUsuarios)) {
            $usuarios = Usuario::all();
        } else {
            $usuarios = Usuario::whereIn('idusuario', $idUsuarios)->get();
        }

        foreach ($usuarios as $usuario) {
            $usuario->notificaciones()->attach($notificacion->idnotificacion);
        }

        return response()->json(['message' => 'Notificación enviada a los usuarios.'], 200);
    }

    public function obtenerNotificacionesPorUsuario($idUsuario)
    {
        $usuario = Usuario::findOrFail($idUsuario);
        $notificaciones = $usuario->notificaciones;
        return response()->json($notificaciones);
    }
}