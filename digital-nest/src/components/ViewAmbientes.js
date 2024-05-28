import React, { useEffect, useState } from "react";

import AmbientesTable from "./AmbientesTable";

export default function ViewAmbientes() {
  const [solicitudes, setSolicitudes] = useState([]);

  useEffect(() => {
    fetch("http://localhost:8000/solicitudes")
      .then((response) => response.json())
      .then((data) => setSolicitudes(data))
      .catch((error) => console.error("Error:", error));
  }, []);

  return (
    <div>
      <div>
        <AmbientesTable solicitudes={solicitudes} />
      </div>
      {/* {solicitudes.map((solicitud, index) => (
      <div key={index}>
        <p>Id Solicitud: {solicitud.idsolicitud}</p>
        <p>Id Materia: {solicitud.idmateria}</p>
        <p>Id Ambiente: {solicitud.idambiente}</p>
        <p>Capacidad Solicitud: {solicitud.capacidadsolicitud}</p>
        <p>Fecha Solicitud: {solicitud.fechasolicitud}</p>
        <p>Hora Inicial Solicitud: {solicitud.horainicialsolicitud}</p>
        <p>Hora Final Solicitud: {solicitud.horafinalsolicitud}</p>

      </div>
    ))} */}
    </div>
  );
}
