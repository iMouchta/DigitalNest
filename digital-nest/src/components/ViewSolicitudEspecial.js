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
import {
  Dialog,
  DialogActions,
  DialogContent,
  DialogContentText,
  DialogTitle,
} from "@mui/material";
import { toast, Toaster } from "react-hot-toast";

export default function ViewSolicitudEspecial() {
  const [open, setOpen] = useState(false);
  const [idsolicitudToAccept, setIdsolicitudToAccept] = useState(null);
  const [rows, setRows] = useState([]);

  const handleClickOpen = (idsolicitud) => {
    setOpen(true);
    setIdsolicitudToAccept(idsolicitud);
  };

  const handleClose = () => {
    setOpen(false);
  };

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
        toast.success("Se aceptó la reserva con éxito", {
          duration: 7000,
        });
        console.log("Success:", data);
        fetchSolicitudes(); // Actualiza las solicitudes después de la petición POST
      })
      .catch((error) => {
        toast.error("No se pudo aceptar la reserva");
        console.error("Error:", error);
      });
  };

  return (
    <TableContainer component={Paper}>
      <Table sx={{ minWidth: 650 }}>
        <TableHead>
          <TableRow>
            <TableCell>ID de Solicitud</TableCell>
            <TableCell>Ambiente</TableCell>
            <TableCell>Fecha de Reserva</TableCell>
            <TableCell>Hora Inicial</TableCell>
            <TableCell>Hora final</TableCell>
            <TableCell>Aceptar Solicitud</TableCell>
          </TableRow>
        </TableHead>
        <TableBody>
          {rows
            .filter((row) => !row.aceptada)
            .sort(
              (a, b) => new Date(a.fechasolicitud) - new Date(b.fechasolicitud)
            )
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
                    onClick={() => handleClickOpen(row.idsolicitud)}
                  >
                    Aceptar
                  </Button>
                  <Dialog
                    open={open}
                    onClose={handleClose}
                    aria-labelledby="alert-dialog-title"
                    aria-describedby="alert-dialog-description"
                  >
                    <DialogTitle id="alert-dialog-title">
                      {"Confirmación"}
                    </DialogTitle>
                    <DialogContent>
                      <DialogContentText id="alert-dialog-description">
                        ¿Está seguro de que quieres aceptar esta solicitud?
                      </DialogContentText>
                    </DialogContent>
                    <DialogActions>
                      <Button onClick={handleClose}>Cancelar</Button>
                      <Button
                        onClick={() => {
                          handleAccept(idsolicitudToAccept);
                          handleClose();
                        }}
                        autoFocus
                      >
                        Confirmar
                      </Button>
                    </DialogActions>
                  </Dialog>
                </TableCell>
              </TableRow>
            ))}
        </TableBody>
      </Table>
      <Toaster />
    </TableContainer>
  );
}
