import React, { useState, useEffect } from "react";
import FormSelector from "./FormSelector";
import FormTextField from "./FormTextField";
import Box from "@mui/material/Box";
import SendFormButton from "./SendFormButton";
import FormDateSelector from "./FormDateSelector";
import {
  Dialog,
  DialogActions,
  DialogContent,
  DialogContentText,
  DialogTitle,
} from "@mui/material";
import Button from "@mui/material/Button";
import { toast, Toaster } from "react-hot-toast";
import FormMultipleSelector from "./FormMultipleSelector";

export default function FormSolicitudEspecial() {
  //* Form fields
  const [textFieldNombre, setTextFieldNombre] = useState("");
  // const [textFieldCapacidad, setTextFieldCapacidad] = useState("");
  const [selectedEdificio, setSelectedEdificio] = useState("");
  const [selectedAmbientes, setSelectedAmbientes] = useState("");
  const [selectedFecha, setSelectedFecha] = useState("");
  const [selectedHoraInicio, setSelectedHoraInicio] = useState("");
  const [selectedHoraFin, setSelectedHoraFin] = useState("");
  const [textFieldMotivo, setTextFieldMotivo] = useState("");

  //* Error Handling
  const [errorNombre, setErrorNombre] = useState(false);
  // const [errorCapacidad, setErrorCapacidad] = useState(false);
  const [errorEdificio, setErrorEdificio] = useState(false);
  const [errorAmbientes, setErrorAmbientes] = useState(false);
  const [errorFecha, setErrorFecha] = useState(false);
  const [errorHoraInicio, setErrorHoraInicio] = useState(false);
  const [errorHoraFin, setErrorHoraFin] = useState(false);
  const [errorMotivo, setErrorMotivo] = useState(false);

  const [errorMessage, setErrorMessage] = useState("");

  //* Dialog
  const [open, setOpen] = useState(false);

  const handleClickOpen = () => {
    setOpen(true);
  };

  const handleClose = () => {
    setOpen(false);
  };

  const handleSubmit = () => {
    // event.preventDefault();
    setErrorNombre(!textFieldNombre);
    // setErrorCapacidad(!textFieldCapacidad);
    setErrorEdificio(!selectedEdificio);
    setErrorAmbientes(!selectedAmbientes);
    setErrorFecha(!selectedFecha);
    setErrorHoraInicio(!selectedHoraInicio);
    setErrorHoraFin(!selectedHoraFin);
    setErrorMotivo(!textFieldMotivo);

    if (
      !textFieldNombre ||
      // !textFieldCapacidad ||
      !selectedEdificio ||
      !selectedAmbientes ||
      !selectedFecha ||
      !selectedHoraInicio ||
      !selectedHoraFin ||
      !textFieldMotivo
    ) {
      setErrorMessage("Todos los campos son obligatorios");
      console.log("Error:", errorMessage);
      return;
    }

    console.log("Nombre:", textFieldNombre);
    // console.log("Capacidad:", textFieldCapacidad);
    console.log("Edificio:", selectedEdificio);
    console.log("Ambientes:", selectedAmbientes);
    console.log("Fecha:", selectedFecha.format("YYYY-MM-DD"));
    console.log("Hora de inicio:", selectedHoraInicio);
    console.log("Hora de fin:", selectedHoraFin);
    console.log("Motivo:", textFieldMotivo);

    fetch("http://localhost:8000/api/", {
      method: "POST",
      headers: {
        "Content-Type": "application/json",
      },
      body: JSON.stringify({
        idadministrador: textFieldNombre,
        // capacidad: textFieldCapacidad,
        //* Lidiar con los ambientes
        // edificio: selectedEdificio,
        // ambientes: selectedAmbientes,
        idambiente: 1,
        fechasolicitud: selectedFecha.format("YYYY-MM-DD"),
        horainicialsolicitud: selectedHoraInicio,
        horafinalsolicitud: selectedHoraFin,
        motivosolicitud: textFieldMotivo,
        especial: 1,
      }),
    })
      .then((response) => response.json())
      .then((data) => {
        console.log("Success:", data);
      })
      .catch((error) => {
        console.error("Error:", error);
      });
  };

  const edificios = [{ value: "Edificio nuevo" }];

  const ambientes = [
    { value: "Auditorio" },
    { value: "690A" },
    { value: "690B" },
    { value: "690C" },
    { value: "690D" },
  ];

  const horasDisponibles = [
    { value: "6:45" },
    { value: "7:30" },
    { value: "8:15" },
    { value: "9:00" },
    { value: "9:45" },
    { value: "10:30" },
    { value: "11:15" },
    { value: "12:00" },
    { value: "12:45" },
    { value: "13:30" },
    { value: "14:15" },
    { value: "15:00" },
    { value: "15:45" },
    { value: "16:30" },
    { value: "17:15" },
    { value: "18:00" },
    { value: "18:45" },
    { value: "19:30" },
    { value: "20:15" },
    { value: "21:00" },
    { value: "21:45" },
  ];

  const horasInicio = horasDisponibles.slice(0, -1);

  const [horasFin, setHorasFin] = useState([]);

  useEffect(() => {
    if (selectedHoraInicio) {
      const indiceHoraInicial = horasDisponibles.findIndex(
        (hora) => hora.value === selectedHoraInicio
      );
      const nuevasHorasFinales = horasDisponibles.slice(
        indiceHoraInicial + 1,
        indiceHoraInicial + 5
      );
      setHorasFin(nuevasHorasFinales);

      // Verificar si la hora final seleccionada está en el nuevo rango de horas finales
      if (!nuevasHorasFinales.some((hora) => hora.value === selectedHoraFin)) {
        setSelectedHoraFin(""); // Restablecer la hora final si no está en el rango
      }
    } else {
      setHorasFin([]);
      setSelectedHoraFin(""); // Restablecer la hora final si la hora de inicio no está seleccionada
    }
  }, [selectedHoraInicio, selectedHoraFin, setSelectedHoraFin]);
  return (
    <form>
      <Box
        display="flex"
        flexDirection="column"
        justifyContent="center"
        alignItems="center"
        minHeight="calc(100vh - 160px)"
        sx={{
          p: 2,
          backgroundColor: "white",
          color: "black",
          width: "500px",
          borderRadius: "10px",
        }}
      >
        <FormTextField
          label="Nombre completo *"
          placeholder="Ingrese su nombre completo"
          onChange={setTextFieldNombre}
          error={errorNombre}
        />
        {/* <FormTextField
          label="Capacidad *"
          placeholder="Estimado de personas que asistirán"
          onChange={setTextFieldCapacidad}
          error={errorCapacidad}
        /> */}
        <FormSelector
          label="Edificio *"
          options={edificios}
          onChange={setSelectedEdificio}
          error={errorEdificio}
          value={selectedEdificio}
        />
        <FormSelector
          label="Ambientes *"
          options={ambientes}
          onChange={setSelectedAmbientes}
          error={errorAmbientes}
          value={selectedAmbientes}
        />
        <FormMultipleSelector
          label="Amientes *"
          options={[
            { value: "Auditorio", label: "Auditorio" },
            { value: "690A", label: "690A" },
            { value: "690B", label: "690B" },
            { value: "690C", label: "690C" },
            { value: "690D", label: "690D" },
          ]}
          onChange={(value) => console.log(value)}
        />
        <FormDateSelector
          label="Fecha *"
          onChange={setSelectedFecha}
          error={errorFecha}
        />

        <FormSelector
          label="Hora inicial *"
          options={horasInicio}
          onChange={setSelectedHoraInicio}
          error={errorHoraInicio}
          value={selectedHoraInicio}
        />
        <FormSelector
          label="Hora final *"
          options={horasFin}
          onChange={setSelectedHoraFin}
          error={errorHoraFin}
          value={selectedHoraFin}
        />
        <FormTextField
          label="Motivo de la reserva"
          placeholder="Ingrese el motivo de reserva"
          onChange={setTextFieldMotivo}
          error={errorMotivo}
        />

        <SendFormButton onClick={handleClickOpen} label={"Confirmar"} />
        <Dialog
          open={open}
          onClose={handleClose}
          aria-labelledby="alert-dialog-title"
          aria-describedby="alert-dialog-description"
        >
          <DialogTitle id="alert-dialog-title">{"Confirmación"}</DialogTitle>
          <DialogContent>
            <DialogContentText id="alert-dialog-description">
              ¿Estás seguro de que quieres enviar esta solicitud?
            </DialogContentText>
          </DialogContent>
          <DialogActions>
            <Button onClick={handleClose}>Cancelar</Button>
            <Button
              onClick={() => {
                handleSubmit();
                handleClose();
              }}
              autoFocus
            >
              Aceptar
            </Button>
          </DialogActions>
        </Dialog>
      </Box>
      <Toaster />
    </form>
  );
}
