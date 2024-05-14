import React from "react";
import FormSolicitudRapida from "../components/FormSolicitudRapida.js";

function SolicitudRapidaPage() {
  return (
    <div>
      <h1>Realizar una solicitud rápida</h1>
      <div className="recuadro-formulario">
        <FormSolicitudRapida />
      </div>
    </div>
  );
}

export default SolicitudRapidaPage;
