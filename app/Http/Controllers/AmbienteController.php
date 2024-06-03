<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ambiente;
use App\Models\Edificio;

use App\Http\Controllers\ReglaReservaDeAmbienteController;

class AmbienteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $ambientes = Ambiente::all();
        $reglaReservaDeAmbienteController = new ReglaReservaDeAmbienteController();
        $listaAmbientesConUbicacion = [];
        
        foreach ($ambientes as $ambiente) {
            $listaReglasDeAmbiente = $reglaReservaDeAmbienteController->getReglaReservaDeAmbiente($ambiente->idambiente);
            $nombreEdificio = $this->getNombreEdificio($ambiente->idedificio);            

            $ambienteConUbicacion = [
                'idambiente' => $ambiente->idambiente,
                'nombreambiente' => $ambiente->nombreambiente,
                'edificio' => $nombreEdificio,
                'planta' => $ambiente->planta,
                'capacidadambiente' => $ambiente->capacidadambiente,
                'reglasDeReserva' => $listaReglasDeAmbiente,
            ];
            $listaAmbientesConUbicacion[] = $ambienteConUbicacion;
        }


        return response()->json($listaAmbientesConUbicacion);
    }

    private function getNombreEdificio($idEdificio) {
        $edificio = Edificio::find($idEdificio);
        return $edificio->nombreedificio;
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
        $datosFormularioCreacionAmbiente = request()->except('_token');

        $nombreAmbiente = $datosFormularioCreacionAmbiente['nombreambiente'];
        $capacidad = $datosFormularioCreacionAmbiente['capacidadambiente'];
        $edificio = $datosFormularioCreacionAmbiente['edificio'];
        // $idubicacion = $datosFormularioCreacionAmbiente['idedificio'];
        $planta = $datosFormularioCreacionAmbiente['planta'];

        $idEdificio = $this->getIdEdificioByName($edificio);
        $edificioExiste = Edificio::where('nombreedificio', $edificio)->first();

        if($edificioExiste) {
            if ($this->ambienteRepetido($nombreAmbiente)) {
                return response()->json([
                    'ambienteRegistrado' => false,
                    'mensaje' => 'El ambiente ya existe'
                ]);
            } else {
                $datosAmbiente = [
                    'nombreambiente' => $nombreAmbiente,
                    'capacidadambiente' => $capacidad,
                    'planta' => $planta,
                    'idedificio' => $idEdificio,
                ];
                $registrado = ambiente::insert($datosAmbiente);
                return response()->json([
                    'ambienteRegistrado' => $registrado,
                    'mensaje' => $registrado ? 'Ambiente registrado' : 'Error al registrar ambiente'
                ]);
            }
        } else {
            return response()->json([
                'ambienteRegistrado' => false,
                'mensaje' => 'El edificio no existe'
            ]);
        }


    }

    private function getIdEdificioByName($nombreEdificio) {
        $edificio = Edificio::where('nombreedificio', $nombreEdificio)->first();
        return $edificio->idedificio;
    }

    private function ambienteRepetido($nombreAmbiente) {
        $ambiente = ambiente::where('nombreambiente', $nombreAmbiente)->first();
        return $ambiente != null;
    }

   //Devuelve informacion de un ambiente segun su id
   /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
   public function getAmbienteById() {
        $datosAmbiente = request()->except('_token');
        $idAmbiente = $datosAmbiente['idambiente'];
        $ambiente = Ambiente::find($idAmbiente);
        $idEdificio = $ambiente->idedificio;

        $edificio = Edificio::find($idEdificio);
        $nombreEdificio = $edificio->nombreedificio;

        $infoAmbiente = [
            'nombreambiente' => $ambiente->nombreambiente,
            'capacidadambiente' => $ambiente->capacidadambiente,
            'planta' => $ambiente->planta,
            'nombreedificio' => $nombreEdificio,
        ];

        return response()->json($infoAmbiente);
   }
}
