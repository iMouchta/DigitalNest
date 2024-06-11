import * as React from "react";
import Paper from "@mui/material/Paper";
import Table from "@mui/material/Table";
import TableBody from "@mui/material/TableBody";
import TableCell from "@mui/material/TableCell";
import TableContainer from "@mui/material/TableContainer";
import TableHead from "@mui/material/TableHead";
import TablePagination from "@mui/material/TablePagination";
import TableRow from "@mui/material/TableRow";

import IconButton from "@mui/material/IconButton";
import KeyboardArrowUpIcon from "@mui/icons-material/KeyboardArrowUp";
import KeyboardArrowDownIcon from "@mui/icons-material/KeyboardArrowDown";
import Collapse from "@mui/material/Collapse";
import Box from "@mui/material/Box";
import Typography from "@mui/material/Typography";
import Button from "@mui/material/Button";

import Dialog from "@mui/material/Dialog";
import DialogTitle from "@mui/material/DialogTitle";
import DialogContent from "@mui/material/DialogContent";
import DialogActions from "@mui/material/DialogActions";

const columns = [
  {
    id: "idsolicitud",
    label: "ID",
    minWidth: 170,
  },
  {
    id: "motivosolicitud",
    label: "Motivo Solicitud",
    minWidth: 170,
    align: "center",
  },
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
    id: "nombreadministrador",
    label: "Administrador",
    minWidth: 170,
    align: "right",
  },
];

function createData(
  idsolicitud,
  nombreadministrador,
  fechaSolicitud,
  horainicialsolicitud,
  horafinalsolicitud,
  motivosolicitud,
  ambientes
) {
  return {
    idsolicitud,
    nombreadministrador,
    fechaSolicitud,
    horainicialsolicitud,
    horafinalsolicitud,
    motivosolicitud,
    ambientes,
  };
}

export default function ViewSolicitudEspecial({ solicitudes }) {
  const [page, setPage] = React.useState(0);
  const [rowsPerPage, setRowsPerPage] = React.useState(10);
  const [expandedRow, setExpandedRow] = React.useState(null);
  const [open, setOpen] = React.useState(false);
  const [solicitudesAfectadas, setSolicitudesAfectadas] = React.useState([]);

  const rows = solicitudes.map((solicitud) =>
    createData(
      solicitud.idsolicitud,
      solicitud.nombreusuarios[0],
      solicitud.fechasolicitud,
      solicitud.horainicialsolicitud.split(":").slice(0, 2).join(":"),
      solicitud.horafinalsolicitud.split(":").slice(0, 2).join(":"),
      solicitud.motivosolicitud,
      solicitud.ambientes
    )
  );

  const handleClick = (solicitudId) => {
    const response = fetch("http://localhost:8000/api/confirmacion", {
      method: "POST",
      headers: {
        "Content-Type": "application/json",
      },
      body: JSON.stringify({
        idsolicitud: solicitudId,
      }),
    })
      .then((response) => {
        if (!response.ok) {
          throw new Error("Error en la solicitud POST");
        }
        return response.json();
      })
      .then((data) => {
        setSolicitudesAfectadas(data.SolicitudesEliminar);
        setOpen(true);
      })
      .catch((error) => {
        console.error("Error:", error);
      });
  };

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
              <TableCell />
              {/* Celda de tabla vacía para el icono de expansión */}
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
            {rows &&
              rows
                .sort(
                  (a, b) =>
                    new Date(a.fechasolicitud) - new Date(b.fechasolicitud)
                )
                .slice(page * rowsPerPage, page * rowsPerPage + rowsPerPage)
                .map((row, indexRow) => {
                  return (
                    <React.Fragment key={indexRow}>
                      <TableRow
                        hover
                        role="checkbox"
                        tabIndex={-1}
                        key={indexRow}
                      >
                        <TableCell>
                          <IconButton
                            aria-label="expand row"
                            size="small"
                            onClick={() =>
                              setExpandedRow(
                                expandedRow !== indexRow ? indexRow : null
                              )
                            }
                          >
                            {expandedRow === indexRow ? (
                              <KeyboardArrowUpIcon />
                            ) : (
                              <KeyboardArrowDownIcon />
                            )}
                          </IconButton>
                        </TableCell>
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
                      <TableRow>
                        <TableCell
                          style={{ paddingBottom: 0, paddingTop: 0 }}
                          colSpan={6}
                        >
                          <Collapse
                            in={expandedRow === indexRow}
                            timeout="auto"
                            unmountOnExit
                          >
                            <Box margin={1}>
                              <Typography
                                variant="h6"
                                gutterBottom
                                component="div"
                              >
                                Ambientes reservados
                              </Typography>
                              <Table size="small" aria-label="ambientes">
                                <TableHead>
                                  <TableRow>
                                    <TableCell>Nombre del ambiente</TableCell>
                                    <TableCell>Edificio</TableCell>
                                    <TableCell>Planta</TableCell>
                                  </TableRow>
                                </TableHead>
                                <TableBody>
                                  {expandedRow === indexRow &&
                                    row.ambientes &&
                                    row.ambientes.map(
                                      (ambiente, indexAmbiente) => (
                                        <TableRow key={indexAmbiente}>
                                          <TableCell component="th" scope="row">
                                            {ambiente.nombre_ambiente}
                                          </TableCell>
                                          <TableCell>
                                            {ambiente.edificio}
                                          </TableCell>
                                          <TableCell>
                                            {ambiente.planta}
                                          </TableCell>
                                        </TableRow>
                                      )
                                    )}
                                </TableBody>
                              </Table>
                              <Button
                                variant="contained"
                                color="primary"
                                style={{ marginTop: "20px" }}
                                onClick={() => handleClick(row.idsolicitud)}
                              >
                                Aceptar
                              </Button>
                              <Dialog
                                open={open}
                                onClose={() => setOpen(false)}
                              >
                                <DialogTitle>
                                  ¿Estás seguro que quieres aceptar esta
                                  solicitud?
                                </DialogTitle>
                                <DialogContent>
                                  {solicitudesAfectadas.length == 0 ? (
                                    <p>
                                      Está acción no afectará a ninguna otra
                                      solicitud
                                    </p>
                                  ) : (
                                    <div>
                                      <p>
                                        La acción afectará a las siguientes
                                        solicitudes ya realizadas con los IDs:
                                      </p>
                                      <ul>
                                        {solicitudesAfectadas.map(
                                          (item, index) => (
                                            <li key={index}>{item}</li>
                                          )
                                        )}
                                      </ul>
                                    </div>
                                  )}
                                </DialogContent>
                                <DialogActions>
                                  <Button
                                    onClick={() => setOpen(false)}
                                    color="primary"
                                  >
                                    Cancelar
                                  </Button>
                                  <Button
                                    onClick={async () => {

                                      await fetch('http://localhost:8000/api/aceptarSoli', {
                                        method: 'POST',
                                        headers: {
                                          'Content-Type': 'application/json'
                                        },
                                        body: JSON.stringify({ 
                                          idsolicitud: row.idsolicitud,
                                        })
                                      })
                                      .then(response => {
                                        if (!response.ok) {
                                          throw new Error('Error en la solicitud POST');
                                        }
                                        return response.json();
                                      })
                                      .then(data => {
                                        console.log(data);
                                        setOpen(false);
                                        window.location.reload();
                                      })
                                      .catch(error => {
                                        console.error('Error:', error);
                                      });
                                      setOpen(false);
                                    }}
                                    color="primary"
                                  >
                                    Confirmar
                                  </Button>
                                </DialogActions>
                              </Dialog>
                            </Box>
                          </Collapse>
                        </TableCell>
                      </TableRow>
                    </React.Fragment>
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
