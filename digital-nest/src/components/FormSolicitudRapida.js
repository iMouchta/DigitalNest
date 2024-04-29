import React, { useState } from "react";
import FormSelector from "./FormSelector";
import FormMultipleSelector from "./FormMultipleSelector";
import FormTextField from "./FormTextField";
import Box from "@mui/material/Box";
import SendFormButton from "./SendFormButton";

export default function FormSolicitudRapida() {
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
        <FormSelector
          label="Selecciona una opción"
          options={[
            { value: "Test 1", label: "Test 1" },
            { value: 2, label: "Test 2" },
            { value: 3, label: "Test 3" },
            // ... más opciones
          ]}
          onChange={setSelectedOption1}
          error={errorOption1}
        />
        <FormSelector
          label="Selecciona una opción"
          options={[
            { value: 1, label: "Test 1" },
            { value: 2, label: "Test 2" },
            { value: 3, label: "Test 3" },
            // ... más opciones
          ]}
          onChange={setSelectedOption2}
        />
        <FormMultipleSelector
          label="Selecciona opciones"
          options={[
            { value: "Test 1", label: "Test 1" },
            { value: 2, label: "Test 2" },
            { value: 3, label: "Test 3" },
            // ... más opciones
          ]}
          onChange={setSelectedMultipleOptions1}
        />
        <FormTextField
          label="Campo de texto"
          placeholder="Placeholder"
          onChange={setTextFieldValue1}
        />
        <SendFormButton onClick={handleSubmit} />
      </Box>
    </form>
  );
}