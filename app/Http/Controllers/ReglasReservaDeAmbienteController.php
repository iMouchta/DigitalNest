<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Models\ReglaReservaDeAmbiente;



class ReglaReservaDeAmbienteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $datosFormularioReglaDeReserva = request()->except('_token');
        
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ReglaReservaDeAmbiente  $reglareservadeambiente
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ReglaReservaDeAmbiente  $reglareservadeambiente
     * @return \Illuminate\Http\Response
     */
    public function edit(ReglaReservaDeAmbiente $reglareservadeambiente)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ReglaReservaDeAmbiente  $reglareservadeambiente
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ReglaReservaDeAmbiente $reglareservadeambiente)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ReglaReservaDeAmbiente  $reglareservadeambiente
     * @return \Illuminate\Http\Response
     */
    public function destroy(ReglaReservaDeAmbiente $reglareservadeambiente)
    {
        //
    }
}
