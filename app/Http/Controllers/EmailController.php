<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\Correo;

class EmailController extends Controller
{
    public function enviarCorreo(Request $request)
    {
        $request->validate([
            'destinatario' => 'required|email',
            'titulo' => 'required|string',
            'mensaje' => 'required|string',
        ]);

        $destinatario = $request->destinatario;
        $titulo = $request->titulo;
        $mensaje = $request->mensaje;

        $details = [
            'title' => $titulo,
            'body' => $mensaje
        ];

        try {
            // Enviar el correo utilizando el servicio de correo de Laravel
            Mail::to($destinatario)->send(new Correo($details));
        } catch (\Exception $e) {
            // Manejar cualquier excepción que ocurra al enviar el correo
            return response()->json(['error' => 'No se pudo enviar el correo electrónico'], 500);
        }

        return response()->json(['mensaje' => 'Correo enviado correctamente'], 200);
    }

    
}