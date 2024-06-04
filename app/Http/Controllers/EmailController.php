<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\Correo;
use App\Jobs\SendEmailJob;

class EmailController extends Controller
{
    public function enviarCorreo(Request $request)
    {
        $request->validate([
            'Correos' => 'required|array|min:1',
            'Correos.*' => 'required|email',
            'Mensaje' => 'required|string',
        ]);

        $correos = $request->input('Correos');
        $mensaje = $request->input('Mensaje');

        foreach ($correos as $correo) {
            dispatch(new SendEmailJob($correo, $mensaje));
        }

        return response()->json(['message' => 'Correos enviados con éxito'], 200);
    }

    
}