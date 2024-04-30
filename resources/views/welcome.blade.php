<!DOCTYPE html>
<html lang="es">

    <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulario de Solicitud</title>
    </head>

<body>
    <h2>Formulario de Solicitud</h2>
    @if ($errors->any())
        <div>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
                </div>
            @endif
    <form action="/" method="POST">
        @csrf
        <label for="capacidad">Capacidad:</label>
        <input type="number" id="capacidad" name="capacidad" required><br><br>

        <label for="fecha">Fecha:</label>
        <input type="date" id="fecha" name="fecha" required><br><br>

        <label for="hora">Hora Inicial:</label>
        <input type="time" id="hora" name="hora" required><br><br>

        <label for="hora_final">Hora Final:</label>
        <input type="time" id="hora_final" name="hora_final" required><br><br>

        <label for="motivo">Motivo:</label>
        <input type="text" id="motivo" name="motivo" required><br><br>

        <label for="ambiente">Ambiente:</label>
        <input type="number" id="ambiente" name="ambiente" required><br><br>


        <label for="docente">Docente:</label>
        <input type="text" id="docente" name="docente" required><br><br>

        <label for="materia">Materia:</label>
        <input type="text" id="materia" name="materia" required><br><br>

        <label for="grupo">Grupo:</label>
        <input type="text" id="grupo" name="grupo" required><br><br>

        <button type="submit">Enviar Solicitud</button>
    </form>
    </body>

</html>
