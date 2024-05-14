import React from "react";
import ViewSolicitudes from "../components/ViewSolicitudes";

export default function VisualizarSolicitudPage(params) {
  return (
    <div className="visualizar-solicitud-page">
      <h1>Visualizar reservas</h1>
      <ViewSolicitudes />
    </div>
  );
}
