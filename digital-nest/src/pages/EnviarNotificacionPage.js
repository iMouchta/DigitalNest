import React, { useState } from "react";
import {
  Typography,
  TextField,
  Button,
  Paper,
  Box,
  Switch,
  FormControlLabel,
} from "@mui/material";
import { Dialog, DialogTitle, DialogContentText } from "@mui/material";
import { DialogActions } from "@mui/material";
import FormDateSelector from "../components/FormDateSelector";

export default function EnviarNotificacionPage(params) {
  const [mostrarFechas, setMostrarFechas] = useState(false);

  //* Variables
  const [mensaje, setMensaje] = useState("");
  const [selectedFechaAfectada, setSelectedFechaAfectada] = useState("");
  const [selectedFechaTransferencia, setSelectedFechaTransferencia] =
    useState("");

  //* Error Handling
  const [errorMensaje, setErrorMensaje] = useState(false);
  const [errorFechaAfectada, setErrorFechaAfectada] = useState(false);
  const [errorFechaTransferencia, setErrorFechaTransferencia] = useState(false);
  const [errorMessage, setErrorMessage] = useState("");

  //* Loading data
  const [isLoading, setIsLoading] = useState(false);

  const handleChange = (event) => {
    setMostrarFechas(event.target.checked);
  };

  //* Dialog
  const [open, setOpen] = React.useState(false);

  const handleClickOpen = (event) => {
    event.preventDefault();
    setErrorMensaje(!mensaje);
    setErrorFechaAfectada(!selectedFechaAfectada);
    setErrorFechaTransferencia(!selectedFechaTransferencia);

    if (
      !mensaje ||
      (mostrarFechas && (!selectedFechaAfectada || !selectedFechaTransferencia))
    ) {
      setErrorMessage("Todos los campos son obligatorios");
      console.log("Error:", errorMessage);
      return;
    }

    console.log("Mensaje:", mensaje);
    if (mostrarFechas) {
      console.log(
        "Fecha afectada:",
        selectedFechaAfectada.format("YYYY-MM-DD")
      );
      console.log(
        "Fecha transferencia:",
        selectedFechaTransferencia.format("YYYY-MM-DD")
      );
    }

    setOpen(true);
  };

  const handleClose = () => {
    setOpen(false);
  };

  const handleEnviarNotificacion = () => {
    isLoading(true);
    fetch("http://localhost:8000/api/users", {
      method: "POST",
      headers: {
        "Content-Type": "application/json",
      },
      body: JSON.stringify({
        mensaje: mensaje,
      }),
    })
      .then((response) => response.json())
      .then((data) => {
        console.log("Success:", data);
        if (mostrarFechas) {
          fetch("http://localhost:8000/api/editar", {
            method: "POST",
            headers: {
              "Content-Type": "application/json",
            },
            body: JSON.stringify({
              fecha1: selectedFechaAfectada.format("YYYY-MM-DD"),
              fecha2: selectedFechaTransferencia.format("YYYY-MM-DD"),
            }),
          })
            .then((response) => response.json())
            .then((data) => {
              console.log("Success:", data);
              window.confirm("Se ha enviado la notificación correctamente.");
              window.location.reload();
            })
            .catch((error) => {
              console.error("Error:", error);
            })
            .finally(() => {
              setIsLoading(false);
            });
        }
        setOpen(false);
      })
      .catch((error) => {
        console.error("Error:", error);
      });
  };

  return (
    <div className="enviar-notificacion-page">
      <h1>Enviar Notificación general</h1>
      <Typography>
        Enviar una notificación general a todos los usuarios de la plataforma.
      </Typography>
      <div
        style={{
          display: "flex",
          justifyContent: "center",
          alignItems: "center",
          paddingTop: "20px",
          paddingBottom: "10px",
        }}
      >
        <form>
          <Box
            display="flex"
            flexDirection="column"
            justifyContent="center"
            alignItems="center"
            sx={{
              p: 2,
              backgroundColor: "white",
              color: "black",
              width: "500px",
              borderRadius: "10px",
            }}
          >
            <TextField
              variant="outlined"
              margin="normal"
              fullWidth
              id="mensaje"
              label="Mensaje *"
              name="mensaje"
              autoFocus
              multiline
              rows={4}
              error={errorMensaje}
              onChange={(e) => setMensaje(e.target.value)}
            />
            <FormControlLabel
              control={
                <Switch
                  checked={mostrarFechas}
                  onChange={handleChange}
                  name="mostrarFechas"
                />
              }
              label="Notificación con modificaciones de reservas"
            />
            {mostrarFechas && (
              <Box sx={{ marginBottom: "15px", padding: "10px" }}>
                <Typography
                  variant="h6"
                  align="justify"
                  style={{ marginBottom: "15px" }}
                >
                  Selecciona una fecha, la cual, todas las reservas de ambientes
                  serán canceladas y transferidas a una nueva fecha. Se enviará
                  una notificación a todos los usuarios afectados.
                </Typography>

                <FormDateSelector
                  label="Fecha de reserva afectada"
                  onChange={setSelectedFechaAfectada}
                  error={errorFechaAfectada}
                />
                <Box sx={{ marginBottom: "15px" }}></Box>
                <FormDateSelector
                  label="Fecha de transferencia de reserva"
                  onChange={setSelectedFechaTransferencia}
                  error={errorFechaTransferencia}
                />
              </Box>
            )}

            <Button
              type="submit"
              fullWidth
              variant="contained"
              color="primary"
              onClick={handleClickOpen}
            >
              Enviar
            </Button>
          </Box>
        </form>
      </div>

      <Dialog open={open} onClose={handleClose}>
        <DialogTitle>
          ¿Estás seguro de que quieres enviar la notificación?
        </DialogTitle>
        <DialogContentText
          style={{
            display: "flex",
            justifyContent: "center",
            alignItems: "center",
            padding: "20px",
          }}
        >
          Al confirmar, se enviará la notificación a todos los usuarios de la
          plataforma.
        </DialogContentText>
        <DialogActions>
          <Button onClick={handleClose} color="primary" disabled={isLoading}>
            Cancelar
          </Button>
          <Button
            onClick={handleEnviarNotificacion}
            color="primary"
            autoFocus
            disabled={isLoading}
          >
            Confirmar
          </Button>
        </DialogActions>
      </Dialog>
    </div>
  );
}
