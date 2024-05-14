import React from "react";
import FormSolicitudEspecial from "../components/FormSolicitudEspecial.js";

export default function SolicitudEspecialPage() {
  return (
    <div>
      <h1>Realizar una solicitud especial</h1>
      <div style={{ display: 'flex', justifyContent: 'center', alignItems: 'center', paddingTop: '20px', paddingBottom: '20px' }}>
        <FormSolicitudEspecial />
      </div>
    </div>
  );
}