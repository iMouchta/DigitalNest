import React, { useState, useEffect } from "react";
import FormSelector from "./FormSelector";
import FormTextField from "./FormTextField";
import FormSelectorTrigger from "./FormSelectorTrigger";
import Box from "@mui/material/Box";
import SendFormButton from "./SendFormButton";
import Typography from "@mui/material/Typography";

import Dialog from "@mui/material/Dialog";
import DialogActions from "@mui/material/DialogActions";
import DialogContent from "@mui/material/DialogContent";
import DialogContentText from "@mui/material/DialogContentText";
import DialogTitle from "@mui/material/DialogTitle";
import Button from "@mui/material/Button";

export default function FormRegistrarAmbiente() {
  //* Form fields
  const [textFieldNombreAmbiente, setTextFieldNombreAmbiente] = useState("");
  const [selectedCapacidad, setSelectedCapacidad] = useState("");
  const [selectedEdificio, setSelectedEdificio] = useState("");
  const [selectedPlanta, setSelectedPlanta] = useState("");

  //* Error Handling
  const [errorNombreAmbiente, setErrorNombreAmbiente] = useState(false);
  const [errorCapacidad, setErrorCapacidad] = useState(false);
  const [errorEdificio, setErrorEdificio] = useState(false);
  const [errorPlanta, setErrorPlanta] = useState(false);

  const [errorMessage, setErrorMessage] = useState("");

  //* Additional states
  const [edificios, setEdificios] = useState([]);
  const [plantas, setPlantas] = useState([]);

  //* Dialog
  const [open, setOpen] = useState(false);
  const [openSuccess, setOpenSuccess] = useState(false);
  const [dialogMessage, setDialogMessage] = useState("");
  const [dialogTitle, setDialogTitle] = useState("");

  const handleClickOpen = (event) => {
    event.preventDefault();
    setErrorNombreAmbiente(!textFieldNombreAmbiente);
    setErrorCapacidad(!selectedCapacidad);
    setErrorEdificio(!selectedEdificio);
    setErrorPlanta(!selectedPlanta);

    if (
      !textFieldNombreAmbiente ||
      !selectedCapacidad ||
      !selectedEdificio ||
      !selectedPlanta
    ) {
      setErrorMessage("Todos los campos son obligatorios");
      console.log("Error:", errorMessage);
      return;
    }
    setOpen(true);
  };

  const handleClose = () => {
    setOpen(false);
  };

  const handleConfirm = () => {
    handleSubmit();
    setOpen(false);
  };

  useEffect(() => {
    fetch("http://localhost:8000/api/edificio")
      .then((response) => response.json())
      .then((data) => {
        setEdificios(data);
      })
      .catch((error) => console.error("Error:", error));
  }, []);

  const handleSubmit = () => {
    // event.preventDefault();
    // setErrorNombreAmbiente(!textFieldNombreAmbiente);
    // setErrorCapacidad(!selectedCapacidad);
    // setErrorEdificio(!selectedEdificio);
    // setErrorPlanta(!selectedPlanta);

    // if (
    //   !textFieldNombreAmbiente ||
    //   !selectedCapacidad ||
    //   !selectedEdificio ||
    //   !selectedPlanta
    // ) {
    //   setErrorMessage("Todos los campos son obligatorios");
    //   console.log("Error:", errorMessage);
    //   return;
    // }

    console.log("Nombre del Ambiente:", textFieldNombreAmbiente);
    console.log("Capacidad:", selectedCapacidad);
    console.log("Edificio:", selectedEdificio);
    console.log("Planta:", selectedPlanta);

    fetch("http://localhost:8000/api/ambiente", {
      method: "POST",
      headers: {
        "Content-Type": "application/json",
      },
      body: JSON.stringify({
        nombreambiente: textFieldNombreAmbiente,
        edificio: selectedEdificio,
        planta: selectedPlanta === "Planta Baja" ? 0 : selectedPlanta,
        capacidadambiente: selectedCapacidad,
      }),
    })
      .then((response) => response.json())
      .then((data) => {
        console.log("Success:", data);
        if(data.reserva) {
          setSelectedCapacidad("");
          setSelectedEdificio("");
          setSelectedPlanta("");
          setTextFieldNombreAmbiente("");
          handlePostSuccess("Ambiente registrado", "El ambiente ha sido registrado correctamente.");
        } else {
          handlePostSuccess("Ambiente no registrado", "No se ha registrado el ambiente porque ya existe un ambiente con ese nombre.");
        }
      })
      .catch((error) => {
        console.error("Error:", error);
      });
  };

  const handlePostSuccess = (title, message) => {
    setDialogTitle(title);
    setDialogMessage(message);
    setOpenSuccess(true);
  };

  const handleCloseSuccess = () => {
    setOpenSuccess(false);
  };

  const capacidades = [
    { value: "20" },
    { value: "30" },
    { value: "50" },
    { value: "100" },
    { value: "200" },
    { value: "250" },
  ];

  return (
    <form>
      <Box
        display="flex"
        flexDirection="column"
        justifyContent="center"
        alignItems="center"
        minHeight="calc(70vh - 200px)"
        sx={{
          p: 2,
          backgroundColor: "white",
          color: "black",
          width: "500px",
          borderRadius: "10px",
        }}
      >
        <FormTextField
          label="Nombre del ambiente *"
          placeholder="Ingrese el nombre del ambiente"
          onChange={setTextFieldNombreAmbiente}
          value={textFieldNombreAmbiente}
          error={errorNombreAmbiente}
        />
        <FormSelectorTrigger
          label="Edificio *"
          onChange={(e) => {
            setSelectedEdificio(e.target.value);
            setSelectedPlanta("");
            const edificioSeleccionado = edificios.find(
              (edificio) => edificio.nombreedificio === e.target.value
            );
            const numeropisos = edificioSeleccionado
              ? edificioSeleccionado.numeropisos
              : 0;
            setPlantas([
              "Planta Baja",
              ...Array.from({ length: numeropisos - 1 }, (_, i) => i + 1),
            ]);
          }}
          error={errorEdificio}
          options={edificios.map((edificio) => ({
            value: edificio.nombreedificio,
          }))}
          value={selectedEdificio}
        />
        <FormSelector
          label="Planta *"
          options={plantas.map((planta) => ({
            value: planta,
          }))}
          onChange={setSelectedPlanta}
          value={selectedPlanta}
          error={errorPlanta}
        />
        <FormSelector
          label="Capacidad *"
          options={capacidades}
          onChange={setSelectedCapacidad}
          value={selectedCapacidad}
          error={errorCapacidad}
        />

        <SendFormButton
          onClick={handleClickOpen}
          label={"Registrar ambiente"}
        />
        <Dialog
          open={open}
          onClose={handleClose}
          aria-labelledby="alert-dialog-title"
          aria-describedby="alert-dialog-description"
        >
          <DialogTitle id="alert-dialog-title">
            {"¿Está seguro que desea registrar este ambiente?"}
          </DialogTitle>
          <DialogContent>
            <Typography align="justify" id="alert-dialog-description">
              {
                "Al confirmar, el ambiente será habilitado con las reglas por defecto, estará habilitado para reserva hasta el 6 de junio del 2024, de hrs. 6:45 a.m. a 21:45 p.m. (se puede modificar estas reglas posteriormente)."
              }
            </Typography>
          </DialogContent>
          <DialogActions>
            <Button onClick={handleClose}>Cancelar</Button>
            <Button onClick={handleConfirm} autoFocus>
              Confirmar
            </Button>
          </DialogActions>
        </Dialog>
        <Dialog
          open={openSuccess}
          onClose={handleCloseSuccess}
          aria-labelledby="alert-dialog-title"
          aria-describedby="alert-dialog-description"
        >
          <DialogTitle id="alert-dialog-title">
            {dialogTitle}
          </DialogTitle>
          <DialogContent>
            <DialogContentText id="alert-dialog-description">
              {dialogMessage}
            </DialogContentText>
          </DialogContent>
          <DialogActions>
            <Button onClick={handleCloseSuccess} autoFocus>
              Aceptar
            </Button>
          </DialogActions>
        </Dialog>
      </Box>
    </form>
  );
}
