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
import { toast, Toaster } from "react-hot-toast";
import Grid from "@mui/material/Grid";
import Paper from "@mui/material/Paper";

export default function SelectAmbienteDialog({
  open,
  handleClose,
  ambientes,
  formData,
}) {
  const [selectedValue, setSelectedValue] = React.useState([]);
  const [isButtonDisabled, setIsButtonDisabled] = React.useState(false);

  const handleAccept = async () => {
    setIsButtonDisabled(true);

    const response = await fetch(
      "http://localhost:8000/api/periodonodisponible",
      {
        method: "POST",
        headers: {
          "Content-Type": "application/json",
        },
        body: JSON.stringify({
          // nombredocente: formData.nombredocente,
          nombresdocentes: ["Leticia Blanco"],
          materia: formData.materia,
          capacidad: formData.capacidad,
          fecha: formData.fecha,
          horainicial: formData.horainicial,
          horafinal: formData.horafinal,
          motivo: formData.motivo,
          nombresambientes: selectedValue,
        }),
        console: console.log("selectedValue", selectedValue),
      }
    )
      .then((response) => {
        if (!response.ok) {
          throw new Error("Error en la solicitud POST");
        }
        return response.json();
      })
      .then((data) => {
        if (data.reserva) {
          toast.success("Se ha realizado la reserva con éxito", {
            duration: 7000,
          });
          window.location.reload();
        } else {
          toast.error("No se ha podido realizar la reserva");
        }
        handleClose();
      })
      .catch((error) => {
        toast.error(
          "Ha ocurrido un error en el servidor al realizar la reserva"
        );
        console.error("Error:", error);
      })
      .finally(() => {
        setIsButtonDisabled(false);
      });
  };

  const handleToggle = (value) => () => {
    const currentIndex = selectedValue.indexOf(value);
    const newChecked = [...selectedValue];
  
    if (currentIndex === -1) {
      newChecked.push(value);
    } else {
      newChecked.splice(currentIndex, 1);
    }
  
    setSelectedValue(newChecked);
  };

  return (
    <div>
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
          <Grid container spacing={2}>
            {Object.keys(ambientes).length > 0 ? (
              Object.keys(ambientes).map((nombreAmbiente, index) => (
                <Grid item xs={4} key={index}>
                  <Paper
                    onClick={handleToggle(nombreAmbiente)}
                    style={{
                      padding: "1em",
                      cursor: "pointer",
                      backgroundColor: selectedValue.includes(nombreAmbiente)
                        ? "lightblue"
                        : "white",
                    }}
                  >
                    {`${nombreAmbiente} - ${ambientes[nombreAmbiente]}`}
                  </Paper>
                </Grid>
              ))
            ) : (
              <p>No existen ambientes disponibles</p>
            )}
          </Grid>
        </DialogContent>
        <DialogActions>
          <Button
            onClick={handleClose}
            color="primary"
            disabled={isButtonDisabled}
          >
            CANCELAR
          </Button>
          <Button
            onClick={handleAccept}
            color="primary"
            autoFocus
            disabled={isButtonDisabled}
          >
            SOLICITAR
          </Button>
        </DialogActions>
      </Dialog>
      <Toaster />
    </div>
  );
}
