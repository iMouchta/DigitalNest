import React from "react";
import FormSolicitudRapida from "../components/FormSolicitudRapida.js";

function SolicitudRapidaPage() {
  return (
    <div>
      <h1>Realizar una solicitud rápida</h1>
      <div
        style={{
          display: "flex",
          justifyContent: "center",
          alignItems: "center",
          paddingTop: "20px",
          paddingBottom: "20px",
        }}
      >
        <FormSolicitudRapida />
      </div>
    </div>
  );
}

export default SolicitudRapidaPage;
