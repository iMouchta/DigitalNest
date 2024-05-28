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
      <div style={{ marginBottom: "30px" }}>
        <h2>Solicitudes Rápidas</h2>
        <SolicitudRapidaTable solicitudes={solicitudesRapidas} />
      </div>

      <div style={{ marginBottom: "30px" }}>
        <h2>Solicitudes Especiales</h2>
        <SolicitudesEspecialesTable solicitudes={solicitudesEspeciales} />
      </div>
    </div>
  );
}
