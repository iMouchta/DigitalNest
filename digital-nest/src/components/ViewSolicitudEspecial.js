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

  const fetchSolicitudes = () => {
    fetch("http://localhost:8000/solicitudes")
      .then((response) => response.json())
      .then((data) => setRows(data))
      .catch((error) => console.error("Error:", error));
  };

  useEffect(() => {
    fetchSolicitudes();
  }, []);

  const handleAccept = (idsolicitud) => {
    fetch("http://localhost:8000/api/aceptar", {
      method: "POST",
      headers: {
        "Content-Type": "application/json",
      },
      body: JSON.stringify({
        idsolicitud: idsolicitud,
        // Agrega aquí el resto de los datos que necesitas enviar
      }),
    })
      .then((response) => response.json())
      .then((data) => {
        console.log("Success:", data);
        fetchSolicitudes(); // Actualiza las solicitudes después de la petición POST
      })
      .catch((error) => {
        console.error("Error:", error);
      });
  };

  return (
    <TableContainer component={Paper}>
      <Table sx={{ minWidth: 650 }}>
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
          {rows
            .filter((row) => !row.aceptada)
            .map((row) => (
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
                  <Button
                    variant="contained"
                    color="primary"
                    onClick={() => handleAccept(row.idsolicitud)}
                  >
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
