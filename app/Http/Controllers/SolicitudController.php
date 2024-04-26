<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Solicitud;
use App\Models\Ambiente;

class SolicitudController extends Controller
{
    public function create()
    {
        $ambientes = Ambiente::all();
        return view('welcome', compact('ambientes'));
    }

    public function store(Request $request)
    {
       // dd($request->all());
        $request->validate([
            'capacidad' => 'required|integer',
            'fecha' => 'required|date',
            'hora' => 'required',
            'hora_final' => 'required',
            'motivo' => 'required|string|max:255',
            'ambiente' => 'required|exists:ambiente,id',
            'docente' => 'required|string|max:255',
            'materia' => 'required|string|max:255',
            'grupo' => 'required|string|max:255',
        ]);

        Solicitud::create($request->all());

        return back()->with('success', 'Solicitud creada exitosamente.');
    }
}

