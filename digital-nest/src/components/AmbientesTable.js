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
import { useNavigate } from "react-router-dom";
import { Button } from "@mui/material";

const columns = [
  { id: "id", label: "ID", minWidth: 170 },
  { id: "edificio", label: "Edificio", minWidth: 100 },
  { id: "aula", label: "Aula", minWidth: 100 },
  { id: "planta", label: "Planta", minWidth: 100, align: "center" },
  { id: "capacidad", label: "Capacidad", minWidth: 100, align: "center" },
  { id: "estado", label: "Estado", minWidth: 100, align: "right" },
];

function createData(
  id,
  edificio,
  aula,
  planta,
  capacidad,
  estado,
  reglasDeReserva
) {
  return {
    id,
    edificio,
    aula,
    planta: planta === 0 ? "Planta baja" : planta,
    capacidad,
    estado,
    reglasDeReserva,
  };
}

export default function AmbientesTable({ ambientes }) {
  const [page, setPage] = React.useState(0);
  const [rowsPerPage, setRowsPerPage] = React.useState(10);
  const [expandedRow, setExpandedRow] = React.useState(null);
  const navigate = useNavigate();

  const rows = ambientes.map((ambiente) =>
    createData(
      ambiente.idambiente,
      ambiente.edificio,
      ambiente.nombreambiente,
      ambiente.planta,
      ambiente.capacidadambiente,
      "Activo",
      ambiente.reglasDeReserva
    )
  );

  const handleChangePage = (event, newPage) => {
    setPage(newPage);
  };

  const handleChangeRowsPerPage = (event) => {
    setRowsPerPage(+event.target.value);
    setPage(0);
  };

  const navigateToReglasDeReserva = (ambiente) => {
    const navArguments = { ambiente: ambiente };
    navigate("/docente/reglasDeReserva", { state: navArguments });
  };

  const navigateToEditarAmbiente = (ambiente) => {
    const navArguments = { ambiente: ambiente };
    navigate("/docente/editarAmbiente", { state: navArguments });
  };

  return (
    <Paper sx={{ width: "100%", overflow: "hidden" }}>
      <TableContainer sx={{ maxHeight: 440 }}>
        <Table stickyHeader aria-label="sticky table">
          <TableHead>
            <TableRow>
              <TableCell />
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
              .slice(page * rowsPerPage, page * rowsPerPage + rowsPerPage)
              .map((row, index) => {
                const isExpanded = expandedRow === row.id;
                return (
                  <React.Fragment key={row.id}>
                    <TableRow hover role="checkbox" tabIndex={-1} key={index}>
                      <TableCell>
                        <IconButton
                          aria-label="expand row"
                          size="small"
                          onClick={() =>
                            setExpandedRow(isExpanded ? null : row.id)
                          }
                        >
                          {isExpanded ? (
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
                            {column.id === "estado" && value === "Activo" ? (
                              <Typography style={{ color: "green" }}>
                                {value}
                              </Typography>
                            ) : column.format && typeof value === "number" ? (
                              column.format(value)
                            ) : (
                              value
                            )}
                          </TableCell>
                        );
                      })}
                    </TableRow>
                    <TableRow>
                      <TableCell
                        style={{ paddingBottom: 0, paddingTop: 0 }}
                        colSpan={6}
                      >
                        <Collapse in={isExpanded} timeout="auto" unmountOnExit>
                          <Box margin={1}>
                            <Typography
                              variant="h6"
                              gutterBottom
                              component="div"
                            >
                              Periodos disponibles
                            </Typography>
                            <Table size="small" aria-label="purchases">
                              <TableHead>
                                <TableRow>
                                  <TableCell>Fecha Inicial</TableCell>
                                  <TableCell>Fecha Final</TableCell>
                                  <TableCell>Hora Inicial</TableCell>
                                  <TableCell>Hora Final</TableCell>
                                </TableRow>
                              </TableHead>
                              <TableBody>
                                {(row.reglasDeReserva || []).map((regla) => (
                                  <TableRow
                                    key={regla.idreglareservadeambiente}
                                  >
                                    <TableCell component="th" scope="row">
                                      {regla.fechainicialdisponible}
                                    </TableCell>
                                    <TableCell>
                                      {regla.fechafinaldisponible}
                                    </TableCell>
                                    <TableCell>
                                      {regla.horainicialdisponible}
                                    </TableCell>
                                    <TableCell>
                                      {regla.horafinaldisponible}
                                    </TableCell>
                                  </TableRow>
                                ))}
                              </TableBody>
                            </Table>
                            <Box
                              sx={{
                                display: "flex",
                                justifyContent: "space-between",
                                alignItems: "center",
                                gap: 2,
                              }}
                            >
                              <Button
                                onClick={() => navigateToReglasDeReserva(row)}
                              >
                                Crear regla de reserva
                              </Button>
                              <Button
                                onClick={() => navigateToEditarAmbiente(row)}
                              >
                                Editar información de ambiente
                              </Button>
                              //TODO cambiar a color rojo
                              <Button
                                onClick={() => navigateToEditarAmbiente(row)}
                              >
                                Eliminar ambiente
                              </Button>
                            </Box>
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
