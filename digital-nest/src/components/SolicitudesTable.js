import * as React from "react";
import Paper from "@mui/material/Paper";
import Table from "@mui/material/Table";
import TableBody from "@mui/material/TableBody";
import TableCell from "@mui/material/TableCell";
import TableContainer from "@mui/material/TableContainer";
import TableHead from "@mui/material/TableHead";
import TablePagination from "@mui/material/TablePagination";
import TableRow from "@mui/material/TableRow";

export default function SolicitudesTable() {
  return (<Paper>
    <TableContainer>
      <Table stickyHeader >
        <TableHead>
          <TableRow>
            <TableCell>Nombre</TableCell>
            <TableCell>Correo</TableCell>
            <TableCell>Fecha de solicitud</TableCell>
            <TableCell>Estado</TableCell>
          </TableRow>
        </TableHead>
        
        
      </Table>
    </TableContainer>
  </Paper>);
}
