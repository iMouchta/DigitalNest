<?php

namespace App\Http\Controllers;

use App\Models\solicitud;
use Illuminate\Http\Request;
use App\Models\UsuarioConSolicitud;
use App\Models\SolicitudConAmbiente;
use App\Models\Usuario;
use App\Models\Materia;

class SolicitudRapidaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $solicitudesRapidas = solicitud::where('especial', false)->get();
        $solicitudRapidaInfo = $this->solicitudRapidaInfoCompleta($solicitudesRapidas);

        return response()->json($solicitudRapidaInfo);
    }

    public function solicitudRapidaInfoCompleta($solicitudesRapidas) {
        $listaSolicitudesRapidas = [];

        foreach ($solicitudesRapidas as $solicitudRapida) {
            $idSolicitudRapida = $solicitudRapida->idsolicitud;
            $usuarioSolicitudRapida = $this->getUsuarioInfoByIdSolicitud($idSolicitudRapida); 

            $solicitudRapidaInfo = [
                'idsolicitud' => $idSolicitudRapida,                
                'usuarios' => $usuarioSolicitudRapida,
                'materia' => $solicitudRapida->materia,
                'ambientes' => $this->getAmbientesInfoByIdSolicitud($idSolicitudRapida)
            ];
            
            $listaSolicitudesRapidas[] = $solicitudRapidaInfo;
        }
        return $listaSolicitudesRapidas;
    }

    private function getMateriaSolicitudInfoByIdUsuario($idUsuario) {
    
    }

    private function getUsuarioInfoByIdSolicitud($idSolicitud) {
        $usuariosSolicitud = UsuarioConSolicitud::where('idsolicitud', $idSolicitud)->get();
        $listaIdUsuarios = [];

        foreach ($usuariosSolicitud as $usuarioSolicitud) {
            $listaIdUsuarios[] = $usuarioSolicitud->idusuario;
        }

        return $listaIdUsuarios;
    }

    private function getAmbientesInfoByIdSolicitud($idSolicitud) {
        $ambientesSolicitud = SolicitudConAmbiente::where('idsolicitud', $idSolicitud)->get();
        return $ambientesSolicitud;
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
        
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\solicitud  $solicitud
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\solicitud  $solicitud
     * @return \Illuminate\Http\Response
     */
    public function edit(solicitud $solicitud)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\solicitud  $solicitud
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, solicitud $solicitud)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\solicitud  $solicitud
     * @return \Illuminate\Http\Response
     */
    public function destroy(solicitud $solicitud)
    {
        //
    }
}
