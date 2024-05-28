import React, { useState } from "react";
import FormSelector from "./FormSelector";
import FormTextField from "./FormTextField";
import Box from "@mui/material/Box";
import SendFormButton from "./SendFormButton";


export default function FormRegistrarAmbiente() {
  //* Form fields
  const [textFieldNombreAmbiente, setTextFieldNombreAmbiente] = useState("");
  const [textFieldNombreEdificio, setTextFieldNombreEdificio] = useState("");
  const [selectedCapacidad, setSelectedCapacidad] = useState("");
  const [textFieldUbicacionAmbiente, setTextFieldUbicacionAmbiente] = useState("");

  //* Error Handling
  const [errorNombreAmbiente, setErrorNombreAmbiente] = useState(false);
  const [errorNombreEdificio, setErrorNombreEdificio] = useState(false);
  const [errorCapacidad, setErrorCapacidad] = useState(false);
  const [errorUbicacionAmbiente, setErrorUbicaionAmbiente] = useState(false);
  
  const [errorMessage, setErrorMessage] = useState("");

  const handleSubmit = (event) => {
    event.preventDefault();
    setErrorNombreAmbiente(!textFieldNombreAmbiente);
    setErrorNombreEdificio(!textFieldNombreEdificio);
    setErrorCapacidad(!selectedCapacidad);
    setErrorUbicaionAmbiente(!textFieldUbicacionAmbiente);

    if (
      !textFieldNombreAmbiente ||
      !textFieldNombreEdificio ||
      !selectedCapacidad ||
      !textFieldUbicacionAmbiente 
    ) {
      setErrorMessage("Todos los campos son obligatorios");
      console.log("Error:", errorMessage);
      return;
    }

    console.log("Nombre del Ambiente:", textFieldNombreAmbiente);
    console.log("Nombre del Edificio:", textFieldNombreEdificio);
    console.log("Capacidad:", selectedCapacidad);
    console.log("Ubicacion del Ambiente:", textFieldUbicacionAmbiente);
    
    fetch("http://localhost:8000/", {
      method: "POST",
      headers: {
        "Content-Type": "application/json",
      },
      body: JSON.stringify({
        nombreAmbiente: textFieldNombreAmbiente,
        nombreEdificio: textFieldNombreEdificio,
        capacidad: selectedCapacidad,
        ubicacionAmbiente: textFieldUbicacionAmbiente,
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
      minHeight="calc(100vh - 160px)" 
      sx={{ p: 2,
      backgroundColor: 'white',
      color: 'black',
      width: '500px',
      borderRadius: "10px" }}>
        <FormTextField

          label="Nombre del ambiente*" 
         
          placeholder="Ingrese el nombre del ambiente"
          onChange={setTextFieldNombreAmbiente}
          error={errorNombreAmbiente}
        />
        <FormTextField

          label="Nombre del Edificio*" 

          placeholder="Ingrese el nombre del Edificio"
          onChange={setTextFieldNombreEdificio}
          error={errorNombreEdificio}
          />
        <FormSelector
          label="Capacidad *"
          options={capacidades}
          onChange={setSelectedCapacidad}
          error={errorCapacidad}
        />
        <FormTextField

          label="Ubicacion Del Ambiente*" 

          placeholder="Ingrese la ubicacion del Ambiente"
          onChange={setTextFieldUbicacionAmbiente}
          error={errorUbicacionAmbiente}
          />
           
        <SendFormButton onClick={handleSubmit} label={"Confirmar"} />
      </Box>
    </form>
  );
}
