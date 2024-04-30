import { Button } from "@mui/material";
import React from "react";
import ViewSolicitudEspecial from "../components/ViewSolicitudEspecial.js";

export default function ResponderSolicitudPage() {
  return (
    <div>
      <h1>Responder Solicitud</h1>
      <p>Esta es la página de Responder Solicitud</p>
      <Button variant="contained" color="primary">Atender Solicitud</Button>
      <ViewSolicitudEspecial />
    </div>
  );
}
