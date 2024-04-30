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
        <label for="capacidadsolicitud">Capacidad:</label>
        <input type="number" id="capacidadsolicitud" name="capacidadsolicitud" required><br><br>

        <label for="fechasolicitud">Fecha:</label>
        <input type="date" id="fechasolicitud" name="fechasolicitud" required><br><br>

        <label for="horainicialsolicitud">Hora Inicial:</label>
        <input type="time" id="horainicialsolicitud" name="horainicialsolicitud" required><br><br>

        <label for="horafinalsolicitud">Hora Final:</label>
        <input type="time" id="horafinalsolicitud" name="horafinalsolicitud" required><br><br>

        <label for="motivo">Motivo:</label>
        <input type="text" id="motivo" name="motivo" required><br><br>

        <label for="idambiente">Ambiente:</label>
        <input type="number" id="idambiente" name="idambiente" required><br><br>

        <label for="idmateria">Materia:</label>
        <input type="number" id="idmateria" name="idmateria" required><br><br>

        <button type="submit">Enviar Solicitud</button>
    </form>
</body>

</html>

