
<table class="table table-light">
    <thead class="thead-light">
        <tr>
            <th>#</th>
            <th>Nombre Docente</th>
            <th>Materia</th>
            <th>Capacidad</th>
            <th>Fecha</th>
            <th>Hora Inicial</th>
            <th>Hora Final</th>
            <th>Motivo</th>
        </tr>
    </thead>
    
    <tbody>
        @foreach( $solicitudes as $solicitud )
        <tr>
            <td>{{ $solicitud->id }}</td>
            <td>{{ $solicitud->nombredocente }}</td>
            <td>{{ $solicitud->materia }}</td>
            <td>{{ $solicitud->capacidad }}</td>
            <td>{{ $solicitud->fecha }}</td>
            <td>{{ $solicitud->horainicial }}</td>
            <td>{{ $solicitud->horafinal }}</td>
            <td>{{ $solicitud->motivo }}</td>
        </tr>
        @endforeach

    </tbody>
</table>