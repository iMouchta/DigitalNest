<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as Middleware;

class VerifyCsrfToken extends Middleware
{
    /**
     * The URIs that should be excluded from CSRF verification.
     *
     * @var array<int, string>
     */
    protected $except = [
        '/', // Ruta para crear y almacenar una solicitud
        '/solicitudes', // Ruta para obtener todas las solicitudes
        '/solicitud/*', // Rutas generadas por el resource controller SolicitudController
    ];
}
