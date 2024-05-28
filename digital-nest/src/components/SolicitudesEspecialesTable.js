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
  { id: "nombreadministrador", label: "Nombre", minWidth: 170 },
  { id: "nombreAmbiente", label: "Ambiente", minWidth: 100 },
  { id: "fechaSolicitud", label: "Fecha de Reserva", minWidth: 100 },
  {
    id: "horainicialsolicitud",
    label: "Hora Inicial",
    minWidth: 100,
    align: "right",
  },
  {
    id: "horafinalsolicitud",
    label: "Hora Final",
    minWidth: 100,
    align: "right",
  },
  {
    id: "motivosolicitud",
    label: "Motivo Solicitud",
    minWidth: 170,
    align: "right",
  },
];

function createData(
  nombreadministrador,
  nombreAmbiente,
  fechaSolicitud,
  horainicialsolicitud,
  horafinalsolicitud,
  motivosolicitud
) {
  return {
    nombreadministrador,
    nombreAmbiente,
    fechaSolicitud,
    horainicialsolicitud,
    horafinalsolicitud,
    motivosolicitud,
  };
}

export default function SolicitudesEspecialesTable({ solicitudes }) {
  const [page, setPage] = React.useState(0);
  const [rowsPerPage, setRowsPerPage] = React.useState(10);

  const rows = solicitudes.map((solicitud) =>
    createData(
      solicitud.nombreadministrador,
      solicitud.nombreAmbiente,
      solicitud.fechasolicitud,
      solicitud.horainicialsolicitud.split(":").slice(0, 2).join(":"),
      solicitud.horafinalsolicitud.split(":").slice(0, 2).join(":"),
      solicitud.motivosolicitud
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
                  // style={{ minWidth: column.minWidth }}
                >
                  {column.label}
                </TableCell>
              ))}
            </TableRow>
          </TableHead>
          <TableBody>
            {rows
              .sort(
                (a, b) =>
                  new Date(a.fechasolicitud) - new Date(b.fechasolicitud)
              )
              .slice(page * rowsPerPage, page * rowsPerPage + rowsPerPage)
              .map((row, index) => {
                return (
                  <TableRow hover role="checkbox" tabIndex={-1} key={index}>
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
      <TablePagination
        labelRowsPerPage="Filas por página:"
        rowsPerPageOptions={[10, 25, 100]}
        component="div"
        count={rows.length}
        rowsPerPage={rowsPerPage}
        page={page}
        onPageChange={handleChangePage}
        onRowsPerPageChange={handleChangeRowsPerPage}
      />
    </Paper>
  );
}