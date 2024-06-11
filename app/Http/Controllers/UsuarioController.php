<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Usuario;

class UsuarioController extends Controller
{
    protected $emailController;

    public function __construct( EmailController $emailController)
    {
        $this->emailController = $emailController;
    }

    public function enviarAviso(Request $request){
        $mensaje = $request->input('mensaje'); 
        $userIds = Usuario::pluck('idUsuario');
    
        foreach ($userIds as $idUsuario) {
            $this->enviarCorreosDesdeApi(new Request([
                'ids_usuarios' => [$idUsuario],
                'mensaje' => $mensaje
            ]));
        }
    
        return response()->json("Aviso enviado correctamente");
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
}
