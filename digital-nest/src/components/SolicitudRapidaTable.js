import * as React from "react";

import Paper from "@mui/material/Paper";
import Table from "@mui/material/Table";
import TableBody from "@mui/material/TableBody";
import TableCell from "@mui/material/TableCell";
import TableContainer from "@mui/material/TableContainer";
import TableHead from "@mui/material/TableHead";
import TablePagination from "@mui/material/TablePagination";
import TableRow from "@mui/material/TableRow";

const columns = [
  { id: "idSolicitud", label: "Id", minWidth: 80 },
  { id: "fechaSolicitud", label: "Fecha de Reserva", minWidth: 100 },
  { id: "nombreMateria", label: "Materia", minWidth: 100 },
  {
    id: "motivoSolicitud",
    label: "Motivo Solicitud",
    minWidth: 170,
    align: "right",
  },
  {
    id: "horaInicialSolicitud",
    label: "Hora Inicial",
    minWidth: 100,
    align: "right",
  },
  {
    id: "horaFinalSolicitud",
    label: "Hora Final",
    minWidth: 100,
    align: "right",
  },

];

function createData(
  idSolicitud,
  nombreMateria,
  motivoSolicitud,
  fechaSolicitud,
  horaInicialSolicitud,
  horaFinalSolicitud,
) {
  return {
    idSolicitud,
    nombreMateria,
    motivoSolicitud,
    fechaSolicitud,
    horaInicialSolicitud,
    horaFinalSolicitud,
  };
}

export default function SolicitudRapidaTable({ solicitudes }) {
  const [page, setPage] = React.useState(0);
  const [rowsPerPage, setRowsPerPage] = React.useState(10);

  const rows = solicitudes.map((solicitud) =>
    createData(
      solicitud.idSolicitud,
      solicitud.nombreMateria,
      solicitud.motivoSolicitud,
      solicitud.fechaSolicitud,
      solicitud.horaInicialSolicitud.split(":").slice(0, 2).join(":"),
      solicitud.horaFinalSolicitud.split(":").slice(0, 2).join(":"),
    )
  );

  const handleChangePage = (event, newPage) => {
    setPage(newPage);
  };

  const handleChangeRowsPerPage = (event) => {
    setRowsPerPage(+event.target.value);
    setPage(0);
  };

  return (
    <Paper sx={{ width: "100%", overflow: "hidden" }}>
      <TableContainer sx={{ maxHeight: 440 }}>
        <Table stickyHeader aria-label="sticky table">
          <TableHead>
            <TableRow>
              {columns.map((column) => (
                <TableCell
                  key={column.id}
                  align={column.align}
                  style={{ minWidth: column.minWidth }}
                >
                  {column.label}
                </TableCell>
              ))}
            </TableRow>
          </TableHead>
          <TableBody>
            {rows
              .slice(page * rowsPerPage, page * rowsPerPage + rowsPerPage)
              .map((row) => {
                return (
                  <TableRow hover role="checkbox" tabIndex={-1} key={row.code}>
                    {columns.map((column) => {
                      const value = row[column.id];
                      return (
                        <TableCell key={column.id} align={column.align}>
                          {column.format && typeof value === "number"
                            ? column.format(value)
                            : value}
                        </TableCell>
                      );
                    })}
                  </TableRow>
                );
              })}
          </TableBody>
        </Table>
      </TableContainer>
    </Paper>
  );
  

}
