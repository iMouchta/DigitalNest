import React from "react";
import Dialog from "@mui/material/Dialog";
import DialogActions from "@mui/material/DialogActions";
import DialogContent from "@mui/material/DialogContent";
import DialogContentText from "@mui/material/DialogContentText";
import DialogTitle from "@mui/material/DialogTitle";
import Button from "@mui/material/Button";
import ToggleButton from "@mui/material/ToggleButton";
import ToggleButtonGroup from "@mui/material/ToggleButtonGroup";
import Box from "@mui/system/Box";

export default function SelectAmbienteDialog({
  open,
  handleClose,
  ambientes,
  formData,
}) {
  const [selectedValue, setSelectedValue] = React.useState("");

  const handleAccept = async () => {
    const response = await fetch(
      "http://localhost:8000/api/periodonodisponible",
      {
        method: "POST",
        headers: {
          "Content-Type": "application/json",
        },
        body: JSON.stringify({
          nombreambiente: selectedValue,
          fecha: formData.fecha,
          horainicial: formData.horainicial,
          horafinal: formData.horafinal,
          nombredocente: formData.nombredocente,
          materia: formData.materia,
          capacidad: formData.capacidad,
          motivo: formData.motivo,
        }),
      }
    )
      .then((response) => {
        if (!response.ok) {
          throw new Error("Error en la solicitud POST");
        }
        return response.json();
      })
      .then((data) => {
        console.log(data);
        handleClose();
      })
      .catch((error) => {
        console.error("Error:", error);
      });
  };

  return (
    <Dialog
      open={open}
      onClose={handleClose}
      aria-labelledby="select-ambiente-dialog-title"
      aria-describedby="select-ambiente-dialog-description"
    >
      <DialogTitle id="select-ambiente-dialog-title">
        {"Seleccionar Ambiente"}
      </DialogTitle>
      <DialogContent>
        <DialogContentText id="select-ambiente-dialog-description">
          Aquí puedes seleccionar el ambiente.
        </DialogContentText>
        <Box display="flex" flexWrap="wrap" justifyContent="space-between">
          <ToggleButtonGroup
            value={selectedValue}
            exclusive
            onChange={(event, newValue) => setSelectedValue(newValue)}
            aria-label="ambiente"
          >
            {Object.keys(ambientes).map((nombreAmbiente) => (
              <ToggleButton value={nombreAmbiente} key={nombreAmbiente}>
                {`${nombreAmbiente} - ${ambientes[nombreAmbiente]}`}
              </ToggleButton>
            ))}
          </ToggleButtonGroup>
        </Box>
      </DialogContent>
      <DialogActions>
        <Button onClick={handleClose} color="primary">
          Cancelar
        </Button>
        <Button onClick={handleAccept} color="primary" autoFocus>
          Aceptar
        </Button>
      </DialogActions>
    </Dialog>
  );
}
