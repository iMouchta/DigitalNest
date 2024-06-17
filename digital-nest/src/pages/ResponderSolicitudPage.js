import React, { useEffect, useState } from "react";
import ViewSolicitudEspecial from "../components/ViewSolicitudEspecial";
import { URL_API } from '../http/const';

export default function ResponderSolicitudPage() {
  const [solicitudesEspeciales, setSolicitudesEspeciales] = useState([]);

  useEffect(() => {
    fetch(`${URL_API}/solicitudEspecial`)
      .then((response) => response.json())
      .then((data) => {
        const solicitudesNoAceptadas = data.filter(solicitud => !solicitud.aceptada);
        setSolicitudesEspeciales(solicitudesNoAceptadas);
      })
      .catch((error) => console.error("Error:", error));
  }, []);

  return (
    <div>
      <h2>Responder solicitudes especiales</h2>
      <ViewSolicitudEspecial solicitudes={solicitudesEspeciales} />
    </div>
  );
}