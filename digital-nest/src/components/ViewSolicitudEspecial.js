import React, {useEffect, useState} from 'react';
import { Table, TableBody, TableCell, TableContainer, TableHead, TableRow, Paper, Button } from '@mui/material';

export default function ViewSolicitudEspecial() {


  const [rows, setRows] = useState([]);

  useEffect(() => {
    fetch('http://localhost:8000/solicitudes')
      .then(response => response.json())
      .then(data => setRows(data))
      .catch(error => console.error('Error:', error));
  }, []);

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
              </TableCell>
            </TableRow>
          ))}
        </TableBody>
      </Table>
    </TableContainer>
  );
}