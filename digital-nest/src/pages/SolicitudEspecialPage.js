import React from "react";
import FormSolicitudEspecial from "../components/FormSolicitudEspecial.js";

export default function SolicitudEspecialPage() {
  return (
    <div>
      <h1>Solicitud Especial</h1>
      <div className="recuadro-formulario">
        <FormSolicitudEspecial />
      </div>
    </div>
  );
}