import React, { useState } from "react";
import FormSelector from "./FormSelector";
import FormTextField from "./FormTextField";
import Box from "@mui/material/Box";
import SendFormButton from "./SendFormButton";
import FormDateSelector from "./FormDateSelector";

export default function FormSolicitudEspecial() {
  //* Form fields
  const [textFieldNombre, setTextFieldNombre] = useState("");
  const [textFieldCapacidad, setTextFieldCapacidad] = useState("");
  const [selectedEdificio, setSelectedEdificio] = useState("");
  const [selectedAmbientes, setSelectedAmbientes] = useState("");
  const [selectedFecha, setSelectedFecha] = useState("");
  const [selectedHoraInicio, setSelectedHoraInicio] = useState("");
  const [selectedHoraFin, setSelectedHoraFin] = useState("");
  const [textFieldMotivo, setTextFieldMotivo] = useState("");

  //* Error Handling
  const [errorNombre, setErrorNombre] = useState(false);
  const [errorCapacidad, setErrorCapacidad] = useState(false);
  const [errorEdificio, setErrorEdificio] = useState(false);
  const [errorAmbientes, setErrorAmbientes] = useState(false);
  const [errorFecha, setErrorFecha] = useState(false);
  const [errorHoraInicio, setErrorHoraInicio] = useState(false);
  const [errorHoraFin, setErrorHoraFin] = useState(false);
  const [errorMotivo, setErrorMotivo] = useState(false);

  const [errorMessage, setErrorMessage] = useState("");

  const handleSubmit = (event) => {
    event.preventDefault();
    setErrorNombre(!textFieldNombre);
    setErrorCapacidad(!textFieldCapacidad);
    setErrorEdificio(!selectedEdificio);
    setErrorAmbientes(!selectedAmbientes);
    setErrorFecha(!selectedFecha);
    setErrorHoraInicio(!selectedHoraInicio);
    setErrorHoraFin(!selectedHoraFin);
    setErrorMotivo(!textFieldMotivo);

    if (
      !textFieldNombre ||
      !textFieldCapacidad ||
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
    console.log("Capacidad:", textFieldCapacidad);
    console.log("Edificio:", selectedEdificio);
    console.log("Ambientes:", selectedAmbientes);
    console.log("Fecha:", selectedFecha.format("YYYY-MM-DD"));
    console.log("Hora de inicio:", selectedHoraInicio);
    console.log("Hora de fin:", selectedHoraFin);
    console.log("Motivo:", textFieldMotivo);

    fetch("http://localhost:3001/solicitud-especial", {
      method: "POST",
      headers: {
        "Content-Type": "application/json",
      },
      body: JSON.stringify({
        nombre: textFieldNombre,
        capacidad: textFieldCapacidad,
        edificio: selectedEdificio,
        ambientes: selectedAmbientes,
        fecha: selectedFecha.format("YYYY-MM-DD"),
        horaInicio: selectedHoraInicio,
        horaFin: selectedHoraFin,
        motivo: textFieldMotivo,
      }),
    })
      .then((response) => response.json())
      .then((data) => {
        console.log("Success:", data);
      })
      .catch((error) => {
        console.error("Error:", error);
      }    
  );
  };

  const edificios = [
    {value: "Edificio nuevo"}
  ];

  const ambientes = [
    {value: "Auditorio"},
    {value: "690A"},
    {value: "690B"},
    {value: "690C"},
    {value: "690D"},
  ];

  const horasInicio = [
    {value: "6:45"},
    {value: "8:15"},
  ];

  const horasFin = [
    {value: "6:45"},
    {value: "8:15"},
  ];

  return (
    <form>
      <Box sx={{ p: 2, border: "1px solid grey", borderRadius: "4px" }}>
        <FormTextField
          label="Nombre completo *"
          placeholder="Ingrese su nombre completo"
          onChange={setTextFieldNombre}
          error={errorNombre}
        />
        <FormTextField
          label="Capacidad *"
          placeholder="Estimado de personas que asistirán"
          onChange={setTextFieldCapacidad}
          error={errorCapacidad}
        />
        <FormSelector
          label="Edificio *"
          options={edificios}
          onChange={setSelectedEdificio}
          error={errorEdificio}
        />
        <FormSelector
          label="Ambientes *"
          options={ambientes}
          onChange={setSelectedAmbientes}
          error={errorAmbientes}
        />
        <FormDateSelector
          label="Fecha *"
          onChange={setSelectedFecha}
          error={errorFecha}
        />

        <FormSelector
          label="Hora de inicio *"
          options={horasInicio}
          onChange={setSelectedHoraInicio}
          error={errorHoraInicio}
        />
        <FormSelector
          label="Hora de fin *"
          options={horasFin}
          onChange={setSelectedHoraFin}
          error={errorHoraFin}
        />
        <FormTextField
          label="Motivo de reserva"
          placeholder="Ingrese el motivo de reserva"
          onChange={setTextFieldMotivo}
          error={errorMotivo}
        />

        <SendFormButton onClick={handleSubmit} />
      </Box>
    </form>
  );
}
