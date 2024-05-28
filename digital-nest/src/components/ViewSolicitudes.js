import React, { useEffect, useState } from "react";
import SolicitudesEspecialesTable from "./SolicitudesEspecialesTable";
import SolicitudRapidaTable from "./SolicitudRapidaTable";

export default function ViewSolicitudes() {
  const [solicitudesEspeciales, setSolicitudesEspeciales] = useState([]);
  const [solicitudesRapidas, setSolicitudesRapidas] = useState([]);

  // useEffect(() => {
  //   fetch("http://localhost:8000/reservas")
  //     .then((response) => response.json())
  //     .then((data) => setSolicitudes(data))
  //     .catch((error) => console.error("Error:", error));
  // }, []);

  useEffect(() => {
    fetch("http://localhost:8000/api/getSolicitudesRapidas")
      .then((response) => response.json())
      .then((data) => setSolicitudesRapidas(data))
      .catch((error) => console.error("Error:", error));
  }, []);

  return (
    <div>
      <div style={{marginBottom: '30px'}}>
        <SolicitudesEspecialesTable solicitudes={solicitudesEspeciales} />
      </div>
      
      <div>
        <SolicitudRapidaTable solicitudes={solicitudesRapidas} />
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
