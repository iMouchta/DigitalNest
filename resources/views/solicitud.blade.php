<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Listado de Solicitudes</title>
</head>
<body>
    <h2>Listado de Solicitudes</h2>
    <table>
        <thead>
            <tr>
                <th>Fecha de Solicitud</th>
                <th>Materia</th>    
                <th>Ambiente</th>
                <th>Fecha</th>
                <th>Hora Inicial</th>
                <th>Hora Final</th>

            </tr>
        </thead>
        <tbody>
            @foreach($solicitudes as $solicitud)
            <tr>
                <td>{{ $solicitud->idadministrador }}</td> <!--(aca pondre una fecha)-->
                <td>{{ $solicitud->idmateria }}</td>  <!--(aca pondre un nombre)-->
                <td>{{ $solicitud->idambiente }}</td> <!--(aca pondre un nombre)-->
                <td>{{ $solicitud->fechasolicitud }}</td>
                <td>{{ $solicitud->horainicialsolicitud }}</td>
                <td>{{ $solicitud->horafinalsolicitud }}</td>

            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
