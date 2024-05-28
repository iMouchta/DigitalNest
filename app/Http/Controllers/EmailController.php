<?php

namespace App\Http\Controllers;

use App\Mail\Correo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class EmailController extends Controller
{
    public function enviarCorreo(Request $request)
    {
        $details = [
            'title' => 'Título del correo',
            'body' => 'Contenido del correo.'
        ];  

        Mail::to('digital.nest.dev@gmail.com')->send(new Correo($details));

        return response()->json(['message' => 'Correo enviado'], 200);
    }
}