import React from 'react';
import Dialog from '@mui/material/Dialog';
import DialogActions from '@mui/material/DialogActions';
import DialogContent from '@mui/material/DialogContent';
import DialogContentText from '@mui/material/DialogContentText';
import DialogTitle from '@mui/material/DialogTitle';
import Button from '@mui/material/Button';

export default function SelectAmbienteDialog({ open, handleClose }) {
  return (
    <Dialog
      open={open}
      onClose={handleClose}
      aria-labelledby="select-ambiente-dialog-title"
      aria-describedby="select-ambiente-dialog-description"
    >
      <DialogTitle id="select-ambiente-dialog-title">{"Seleccionar Ambiente"}</DialogTitle>
      <DialogContent>
        <DialogContentText id="select-ambiente-dialog-description">
          Aquí puedes seleccionar el ambiente.
        </DialogContentText>
      </DialogContent>
      <DialogActions>
        <Button onClick={handleClose} color="primary">
          Cancelar
        </Button>
        <Button onClick={handleClose} color="primary" autoFocus>
          Aceptar
        </Button>
      </DialogActions>
    </Dialog>
  );
}