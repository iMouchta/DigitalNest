import React from "react";
import { Typography, TextField, Button } from "@mui/material";
import { Dialog, DialogTitle, DialogContentText } from "@mui/material";
import { DialogActions } from "@mui/material";

export default function EnviarNotificacionPage(params) {
  const [open, setOpen] = React.useState(false);

  const handleClickOpen = () => {
    setOpen(true);
  };

  const handleClose = () => {
    setOpen(false);
  };

  return (
    <div className="enviar-notificacion-page">
      <Typography variant="h4">Enviar notificacion general</Typography>
      <TextField
        variant="outlined"
        margin="normal"
        required
        fullWidth
        id="mensaje"
        label="Mensaje"
        name="mensaje"
        autoFocus
        multiline
        rows={4}
      />
      <Button
        type="submit"
        fullWidth
        variant="contained"
        color="primary"
        onClick={handleClickOpen}
      >
        Enviar
      </Button>

      <Dialog open={open} onClose={handleClose}>
        <DialogTitle>Confirmación</DialogTitle>
        <DialogContentText>
          ¿Estás seguro de que quieres enviar la notificación?
        </DialogContentText>
        <DialogActions>
          <Button onClick={handleClose} color="primary">
            Cancelar
          </Button>
          <Button onClick={handleClose} color="primary" autoFocus>
            Confirmar
          </Button>
        </DialogActions>
      </Dialog>
    </div>
  );
}
