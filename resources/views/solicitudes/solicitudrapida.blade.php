<form action="{{ url('/solicitud') }}" method="post">
<!-- @csrf -->
    <label for="nombredocente"> Nombre del docente </label>
    <input type="text" name="nombredocente" id="nombredocente">
    <br>
    <label for="materia"> Materia </label>
    <input type="text" name="materia" id="materia">
    <br>
    <label for="capacidad"> Capacidad </label>
    <input type="text" name="capacidad"  id="capacidad">
    <br>
    <label for="fecha"> Fecha </label>
    <input type="date" name="fecha"  id="fecha">
    <br>
    <label for="horainicial">Hora Inicial:</label>
    <input type="time" id="horainicial" name="horainicial" required>
    <br>
    <label for="horafinal">Hora Final:</label>
    <input type="time" id="horafinal" name="horafinal" required>
    <br>
    <label for="motivo">Motivo:</label>
    <input type="text" id="motivo" name="motivo" required>
    <br>
    <button type="submit">Enviar Solicitud</button>
    <br>
</form>