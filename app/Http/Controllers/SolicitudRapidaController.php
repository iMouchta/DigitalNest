<?php

namespace App\Http\Controllers;

use App\Models\Solicitud;
use Illuminate\Http\Request;
use App\Models\UsuarioConSolicitud;
use App\Models\SolicitudConAmbiente;
use App\Models\Usuario;
use App\Models\Materia;
use App\Models\Ambiente;

class SolicitudRapidaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $listaSolicitudesRapidas = [];
        $solicitudesRapidas = Solicitud::where('especial', false)->get();
        foreach ($solicitudesRapidas as $solicitud) {
            $idSolicitud = $solicitud->idsolicitud;
            $idMateria = $solicitud->idmateria;
            //info a subir a la lista de solicitudes
            $capacidadSolicitud = $solicitud->capacidadsolicitud;
            $fechaSolicitud = $solicitud->fechasolicitud;
            $horaInicialSolicitud = $solicitud->horainicialsolicitud;
            $horaFinalSolicitud = $solicitud->horafinalsolicitud;
            $motivoSolicitud = $solicitud->motivosolicitud;
            $nombresDocentes = $this->getNombresDocentes($idSolicitud);
            $nombreMateria = $this->getNombreMateria($idMateria);
            $nombresAmbientes = $this->getNombresAmbientes($idSolicitud);

            $solicitudRapida = [
                'capacidadSolicitud' => $capacidadSolicitud,
                'fechaSolicitud' => $fechaSolicitud,
                'horaInicialSolicitud' => $horaInicialSolicitud,
                'horaFinalSolicitud' => $horaFinalSolicitud,
                'motivoSolicitud' => $motivoSolicitud,
                'nombresDocentes' => $nombresDocentes,
                'nombreMateria' => $nombreMateria,
                'nombresAmbientes' => $nombresAmbientes,
            ];

            $listaSolicitudesRapidas[] = $solicitudRapida;
        }

        return response()->json($listaSolicitudesRapidas);
    }

    private function getNombresDocentes($idSolicitud) {
        $usuariosConSolicitud = UsuarioConSolicitud::where('idsolicitud', $idSolicitud)->get();
        $nombresDocentes = [];

        foreach ($usuariosConSolicitud as $usuarioConSolicitud) {
            $idUsuario = $usuarioConSolicitud->idusuario;
            $usuario = Usuario::find($idUsuario);
            $nombreDocente = $usuario->nombreusuario;
            $nombresDocentes[] = $nombreDocente;
        }
        return $nombresDocentes;
    }

    private function getNombreMateria($idMateria) {
        $materia = Materia::find($idMateria);
        return $materia->nombremateria;
    }

    private function getNombresAmbientes($idSolicitud) {
        $solicitudConAmbiente = SolicitudConAmbiente::where('idsolicitud', $idSolicitud)->get();
        $nombresAmbientes = [];

        foreach ($solicitudConAmbiente as $solicitudAmbiente) {
            $idAmbiente = $solicitudAmbiente->idambiente;
            $ambiente = Ambiente::find($idAmbiente);
            $nombreAmbiente = $ambiente->nombreambiente;
            $nombresAmbientes[] = $nombreAmbiente;
        }
        return $nombresAmbientes;
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
