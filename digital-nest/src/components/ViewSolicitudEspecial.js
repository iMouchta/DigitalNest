import React, { useEffect, useState } from "react";
import {
  Table,
  TableBody,
  TableCell,
  TableContainer,
  TableHead,
  TableRow,
  Paper,
  Button,
} from "@mui/material";

export default function ViewSolicitudEspecial() {
  const [rows, setRows] = useState([]);

  useEffect(() => {
    fetch("http://localhost:8000/solicitudes")
      .then((response) => response.json())
      .then((data) => setRows(data))
      .catch((error) => console.error("Error:", error));
  }, []);

  return (
<TableContainer component={Paper}>
  <Table sx={{minWidth: 650}}>
    <TableHead>
      <TableRow>
        <TableCell>ID de Solicitud</TableCell>
        <TableCell>Solicitud</TableCell>
        <TableCell>Fecha</TableCell>
        <TableCell>Hora Inicial</TableCell>
        <TableCell>Hora final</TableCell>
        <TableCell>Aceptar Solicitud</TableCell>
      </TableRow>
    </TableHead>
    <TableBody>
      {rows.map((row) => (
        <TableRow key={row.idsolicitud}>
          <TableCell>{row.idsolicitud}</TableCell>
          <TableCell>{row.nombreAmbiente}</TableCell>
          <TableCell>{row.fechasolicitud}</TableCell>
          <TableCell>
            {row.horainicialsolicitud.split(":").slice(0, 2).join(":")}
          </TableCell>
          <TableCell>
            {row.horafinalsolicitud.split(":").slice(0, 2).join(":")}
          </TableCell>
          <TableCell>
            <Button variant="contained" color="primary">
              Aceptar
            </Button>
          </TableCell>
        </TableRow>
      ))}
    </TableBody>
  </Table>
</TableContainer>
  );
}
