import React, { useState, useEffect } from "react";
import FormSelector from "./FormSelector";
import FormTextField from "./FormTextField";
import Box from "@mui/material/Box";
import SendFormButton from "./SendFormButton";

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

  useEffect(() => {
    fetch("http://localhost:8000/api/edificio")
      .then((response) => response.json())
      .then((data) => {
        setEdificios(data);
      })
      .catch((error) => console.error("Error:", error));
  }, []);

  const handleSubmit = (event) => {
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
        planta: selectedPlanta,
        capacidadambiente: selectedCapacidad,
      }),
    })
      .then((response) => response.json())
      .then((data) => {
        console.log("Success:", data);
        window.location.reload();

      })
      .catch((error) => {
        console.error("Error:", error);
      });
  };

  const capacidades = [
    { value: "20" },
    { value: "30" },
    { value: "50" },
    { value: "100" },
    { value: "200" },
    { value: "250" },
  ];

  const plantas = [
    { value: "0" },
    { value: "1" },
    { value: "2" },
    { value: "3" },
  ];

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
          label="Nombre del ambiente *"
          placeholder="Ingrese el nombre del ambiente"
          onChange={setTextFieldNombreAmbiente}
          error={errorNombreAmbiente}
        />
        <FormSelector
          label="Edificio *"
          onChange={setSelectedEdificio}
          error={errorEdificio}
          options={edificios.map((edificio) => ({
            value: edificio.nombreedificio,
          }))}
        />
        <FormSelector
          label="Capacidad *"
          options={capacidades}
          onChange={setSelectedCapacidad}
          error={errorCapacidad}
        />
        <FormSelector
          label="Planta *"
          options={plantas}
          onChange={setSelectedPlanta}
          error={errorPlanta}
        />

        <SendFormButton onClick={handleSubmit} label={"Confirmar"} />
      </Box>
    </form>
  );
}
