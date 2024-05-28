import React, { useEffect, useState } from "react";
import ViewSolicitudEspecial from "../components/ViewSolicitudEspecial";

export default function ResponderSolicitudPage() {
  const [solicitudesEspeciales, setSolicitudesEspeciales] = useState([]);

  useEffect(() => {
    fetch("http://localhost:8000/api/solicitudEspecial")
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