import React, { useState } from "react";
import FormSelector from "./FormSelector";
import FormMultipleSelector from "./FormMultipleSelector";
import FormTextField from "./FormTextField";
import Box from "@mui/material/Box";
import SendFormButton from "./SendFormButton";
import FormDateSelector from "./FormDateSelector";

export default function FormSolicitudRapida() {
  //* Form fields
  const [selectedNombreDocente, setSelectedNombreDocente] = useState("");
  const [selectedMateria, setSelectedMateria] = useState("");
  const [selectedCapacidad, setSelectedCapacidad] = useState("");
  const [selectedFecha, setSelectedFecha] = useState("");
  const [selectedHoraInicio, setSelectedHoraInicio] = useState("");
  const [selectedHoraFin, setSelectedHoraFin] = useState("");
  const [selectedMotivo, setSelectedMotivo] = useState("");

  //* Error Handling
  const [errorNombreDocente, setErrorNombreDocente] = useState(false);
  const [errorMateria, setErrorMateria] = useState(false);
  const [errorCapacidad, setErrorCapacidad] = useState(false);
  const [errorFecha, setErrorFecha] = useState(false);
  const [errorHoraInicio, setErrorHoraInicio] = useState(false);
  const [errorHoraFin, setErrorHoraFin] = useState(false);
  const [errorMotivo, setErrorMotivo] = useState(false);
  const [errorMessage, setErrorMessage] = useState("");

  const handleSubmit = (event) => {
    event.preventDefault();

    setErrorNombreDocente(!selectedNombreDocente);
    setErrorMateria(!selectedMateria);
    setErrorCapacidad(!selectedCapacidad);
    setErrorFecha(!selectedFecha);
    setErrorHoraInicio(!selectedHoraInicio);
    setErrorHoraFin(!selectedHoraFin);
    setErrorMotivo(!selectedMotivo);

    if (
      !selectedNombreDocente ||
      !selectedMateria ||
      !selectedCapacidad ||
      !selectedFecha ||
      !selectedHoraInicio ||
      !selectedHoraFin ||
      !selectedMotivo
    ) {
      setErrorMessage("Todos los campos son obligatorios");
      console.log("Error:", errorMessage);
      return;
    }

    console.log("Nombre del docente:", selectedNombreDocente);
    console.log("Materia:", selectedMateria);
    console.log("Capacidad:", selectedCapacidad);
    console.log("Fecha:", selectedFecha.format('YYYY-MM-DD'));
    console.log("Hora de inicio:", selectedHoraInicio);
    console.log("Hora de fin:", selectedHoraFin);
    console.log("Motivo:", selectedMotivo);

    // Realizar la solicitud POST
    fetch("http://localhost/public/solicitud", {
      method: "POST",
      headers: {
        "Content-Type": "application/json",
      },
      body: JSON.stringify({
        nombredocente: selectedNombreDocente,
        materia: selectedMateria,
        capacidad: selectedCapacidad,
        fecha: selectedFecha.format('YYYY-MM-DD'),
        horainicial: selectedHoraInicio,
        horafinal: selectedHoraFin,
        motivo: selectedMotivo,
      }),
    })
      .then((response) => response.json())
      .then((data) => console.log(data))
      .catch((error) => {
        console.error("Error:", error);
      });
  };

  const docentes = [{ value: "Leticia Blanco Coca" }];

  const materias = [
    { value: "Matemáticas" },
    { value: "Física" },
    { value: "Química" },
    { value: "Biología" },
    { value: "Historia" },
  ];

  const capacidades = [
    { value: "20" },
    { value: "30" },
    { value: "50" },
    { value: "100" },
    { value: "200" },
    { value: "250" },
  ];

  const horasIniciales = [
    { value: "6:45" },
    { value: "8:15" },
    { value: "9:45" },
    { value: "11:15" },
    { value: "12:45" },
    { value: "14:15" },
    { value: "15:45" },
    { value: "17:15" },
    { value: "18:45" },
    { value: "20:15" },
  ];

  const horasFinales = [
    { value: "6:45" },
    { value: "8:15" },
    { value: "9:45" },
    { value: "11:15" },
    { value: "12:45" },
    { value: "14:15" },
    { value: "15:45" },
    { value: "17:15" },
    { value: "18:45" },
    { value: "20:15" },
  ];

  const motivos = [
    { value: "Primer Parcial" },
    { value: "Segundo Parcial" },
    { value: "Examen Final" },
    { value: "Segunda Instancia" },
    { value: "Examen de Mesa"}
  ];

  return (
    <form>
      <Box sx={{ p: 2, border: "1px solid grey", borderRadius: "4px" }}>
        <FormSelector
          label="Nombre del docente *"
          options={docentes}
          onChange={setSelectedNombreDocente}
          error={errorNombreDocente}
        />
        <FormSelector
          label="Materia *"
          options={materias}
          onChange={setSelectedMateria}
          error={errorMateria}
        />
        <FormSelector
          label="Capacidad *"
          options={capacidades}
          onChange={setSelectedCapacidad}
          error={errorCapacidad}
        />
        <FormDateSelector
          label="Fecha *"
          onChange={setSelectedFecha}
          error={errorFecha}
        />
        <FormSelector
          label="Hora inicial *"
          options={horasIniciales}
          onChange={setSelectedHoraInicio}
          error={errorHoraInicio}
        />
        <FormSelector
          label="Hora final *"
          options={horasFinales}
          onChange={setSelectedHoraFin}
          error={errorHoraFin}
        />
        <FormSelector
          label="Motivo de la reserva *"
          options={motivos}
          onChange={setSelectedMotivo}
          error={errorMotivo}
        />

        <SendFormButton onClick={handleSubmit} label={"SELECCIONAR AMBIENTE"} />
      </Box>
    </form>
  );
}
