import React, { useState } from "react";
import FormSelector from "./FormSelector";
import FormMultipleSelector from "./FormMultipleSelector";
import FormTextField from "./FormTextField";
import Box from "@mui/material/Box";
import SendFormButton from "./SendFormButton";
import FormDateSelector from "./FormDateSelector";
import FormTimeSlider from "./FormTimeSlider";

export default function FormSolicitudEspecial() {
  //* Form fields
  const [selectedOption1, setSelectedOption1] = useState("");
  const [selectedOption2, setSelectedOption2] = useState("");
  const [selectedMultipleOptions1, setSelectedMultipleOptions1] = useState([]);
  const [textFieldValue1, setTextFieldValue1] = useState("");

  //* Error Handling
  const [errorOption1, setErrorOption1] = useState(false);
  const [errorMessage, setErrorMessage] = useState("");

  const handleSubmit = (event) => {
    event.preventDefault();

    setErrorOption1(!selectedOption1);

    if (
      !selectedOption1 ||
      !selectedOption2 ||
      !selectedMultipleOptions1.length ||
      !textFieldValue1
    ) {
      setErrorMessage("Todos los campos son obligatorios");
      console.log("Error:", errorMessage);
      return;
    }

    console.log("Selected option 1:", selectedOption1);
    console.log("Selected option 2:", selectedOption2);
    console.log("Selected multiple options 1:", selectedMultipleOptions1);
    console.log("Text field value:", textFieldValue1);
  };

  return (
    <form>
      <Box sx={{ p: 2, border: "1px solid grey", borderRadius: "4px" }}>
        <FormTextField
          label="Nombre completo *"
          placeholder="Ingrese su nombre completo"
          onChange={setTextFieldValue1}
        />
        <FormTextField
          label="Capacidad *"
          placeholder="Estimado de personas que asistirán"
          onChange={setTextFieldValue1}
        />
        <FormSelector
          label="Edificio *"
          options={[
            { value: "Carla Salazar Serrudo", label: "Carla Salazar Serrudo" },
            {
              value: "Vladimir Abel Costas Jauregui",
              label: "Vladimir Abel Costas Jauregui",
            },
            { value: 3, label: "Test 3" },
            // ... más opciones
          ]}
          onChange={setSelectedOption2}
        />
        <FormSelector
          label="Ambientes *"
          options={[
            { value: "Carla Salazar Serrudo", label: "Carla Salazar Serrudo" },
            {
              value: "Vladimir Abel Costas Jauregui",
              label: "Vladimir Abel Costas Jauregui",
            },
            { value: 3, label: "Test 3" },
            // ... más opciones
          ]}
          onChange={setSelectedOption2}
        />
        <FormDateSelector label="Fecha *" onChange={setTextFieldValue1} />
        <FormTimeSlider
          label="Hora de inicio *"
          onChange={setTextFieldValue1}
        />
        <FormSelector
          label="Hora de inicio *"
          options={[
            {
              value: "6:45",
              label: "6:45",
            },
            {
              value: "8:15",
              label: "8:15",
            },
          ]}
          onChange={setTextFieldValue1}
        />
        <FormSelector
          label="Hora de fin *"
          options={[
            {
              value: "6:45",
              label: "6:45",
            },
            {
              value: "8:15",
              label: "8:15",
            },
          ]}
          onChange={setTextFieldValue1}
        />
        <FormTextField
          label="Motivo de reserva"
          placeholder="Ingrese el motivo de reserva"
          onChange={setTextFieldValue1}
        />

        <SendFormButton onClick={handleSubmit} />
      </Box>
    </form>
  );
}
