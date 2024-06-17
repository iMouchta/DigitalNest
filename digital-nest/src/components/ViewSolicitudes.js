import React, { useEffect, useState } from "react";
import SolicitudesEspecialesTable from "./SolicitudesEspecialesTable";
import SolicitudRapidaTable from "./SolicitudRapidaTable";
import { URL_API } from '../http/const';

export default function ViewSolicitudes() {
  const [solicitudesEspeciales, setSolicitudesEspeciales] = useState([]);
  const [solicitudesRapidas, setSolicitudesRapidas] = useState([]);

  useEffect(() => {
    fetch(`${URL_API}/solicitudEspecial`)
      .then((response) => response.json())
      .then((data) => setSolicitudesEspeciales(data))
      .catch((error) => console.error("Error:", error));
  }, []);

  useEffect(() => {
    fetch(`${URL_API}/getSolicitudesRapidas`)
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
