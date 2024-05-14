import React from 'react';
import { Table, TableBody, TableCell, TableContainer, TableHead, TableRow, Paper, Button } from '@mui/material';

export default function ViewSolicitudEspecial() {
  // Aquí puedes poner tus datos. Este es solo un ejemplo.
  const rows = [
    { id: 1, ambiente: 'Ambiente 1', fecha: '2022-01-01', horaInicial: '10:00', fechaFinal: '2022-01-02' },
    { id: 2, ambiente: 'Ambiente 2', fecha: '2022-01-03', horaInicial: '11:00', fechaFinal: '2022-01-04' },
    // Agrega más filas según sea necesario
  ];

  return (
    <TableContainer component={Paper}>
      <Table sx={{ minWidth: 650 }} aria-label="simple table">
        <TableHead>
          <TableRow>
            <TableCell>ID de Solicitud</TableCell>
            <TableCell>Ambiente</TableCell>
            <TableCell>Fecha</TableCell>
            <TableCell>Hora Inicial</TableCell>
            <TableCell>Fecha Final</TableCell>
            <TableCell>Acciones</TableCell>
          </TableRow>
        </TableHead>
        <TableBody>
          {rows.map((row) => (
            <TableRow key={row.id}>
              <TableCell>{row.id}</TableCell>
              <TableCell>{row.ambiente}</TableCell>
              <TableCell>{row.fecha}</TableCell>
              <TableCell>{row.horaInicial}</TableCell>
              <TableCell>{row.fechaFinal}</TableCell>
              <TableCell>
                <Button variant="contained" color="primary">Aprobar</Button>
                <Button variant="contained" color="secondary">Rechazar</Button>
              </TableCell>
            </TableRow>
          ))}
        </TableBody>
      </Table>
    </TableContainer>
  );
}