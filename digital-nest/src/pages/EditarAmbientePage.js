import React, { useState, useEffect } from "react";
import { useLocation } from "react-router-dom";
import LockedTextFieldAmbiente from "../components/LockedTextFieldAmbiente";
import { Box, Button } from "@mui/material";
import FormSelector from "../components/FormSelector";
import FormTextField from "../components/FormTextField";

export default function EditarAmbientePage() {
  const location = useLocation();
  const { ambiente } = location.state || {};

  //* Variables
  const [textFieldNombreAmbiente, setTextFieldNombreAmbiente] = useState("");
  const [selectedCapacidad, setSelectedCapacidad] = useState("");
  const [selectedEdificio, setSelectedEdificio] = useState("");
  const [selectedPlanta, setSelectedPlanta] = useState("");

  //* Errors
  const [errorNombreAmbiente, setErrorNombreAmbiente] = useState(false);
  const [errorCapacidad, setErrorCapacidad] = useState(false);
  const [errorEdificio, setErrorEdificio] = useState(false);
  const [errorPlanta, setErrorPlanta] = useState(false);

  const [errorMessage, setErrorMessage] = useState("");

  //* Additional states
  const [edificios, setEdificios] = useState([]);
  const [plantas, setPlantas] = useState([]);

  const handleSubmit = () => {
    setErrorNombreAmbiente(!textFieldNombreAmbiente);
    setErrorCapacidad(!selectedCapacidad);
    setErrorEdificio(!selectedEdificio);
    setErrorPlanta(!selectedPlanta);

    if (!textFieldNombreAmbiente) {
      setErrorMessage("Todos los campos son obligatorios");
      console.log("Error en la validación:");
      return;
    }

    console.log("Nombre del ambiente:", textFieldNombreAmbiente);
    console.log("Capacidad:", selectedCapacidad);
    console.log("Edificio:", selectedEdificio);
    console.log("Planta:", selectedPlanta);

    // guardarCambios();
  };

  const guardarCambios = async () => {
    await fetch("http://localhost:8000/api/editAmbiente", {
      method: "POST",
      headers: {
        "Content-Type": "application/json",
      },
      body: JSON.stringify({
        idambiente: ambiente.id,
        nombreambiente: textFieldNombreAmbiente,
        capacidadambiente: selectedCapacidad,
        planta: selectedPlanta === "Planta baja" ? 0 : selectedPlanta,
        nombreedificio: selectedEdificio,
      }),
    })
      .then((response) => {
        if (!response.ok) {
          throw new Error("Error en la solicitud POST");
        }
        return response.json();
      })
      .then((data) => {
        console.log(data);
      })
      .catch((error) => {
        console.error("Error:", error);
      });
  };

  const eliminarAmbiente = async () => {
    await fetch("http://localhost:8000/api/deleteAmbiente", {
      method: "POST",
      headers: {
        "Content-Type": "application/json",
      },
      body: JSON.stringify({
        idambiente: ambiente.id,
      }),
    })
      .then((response) => {
        if (!response.ok) {
          throw new Error("Error en la solicitud POST");
        }
        return response.json();
      })
      .then((data) => {
        console.log(data);
      })
      .catch((error) => {
        console.error("Error:", error);
      });
  };

  const edificiosDisponibles = [
    { value: "Edificio academico II" },
    { value: "Multiacademico" },
  ];

  return (
    <div>
      <h2>Reglas de reserva</h2>

      <div
        style={{
          display: "flex",
          justifyContent: "center",
          alignItems: "center",
          paddingTop: "20px",
          paddingBottom: "10px",
        }}
      >
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
            {/* <LockedTextFieldAmbiente
              label="ID del Ambiente"
              defaultValue={ambiente.id}
            ></LockedTextFieldAmbiente> */}
            <LockedTextFieldAmbiente
              label="Nombre del ambiente"
              defaultValue={ambiente.aula}
            ></LockedTextFieldAmbiente>
            <LockedTextFieldAmbiente
              label="Edificio"
              defaultValue={ambiente.edificio}
            ></LockedTextFieldAmbiente>
            <LockedTextFieldAmbiente
              label="Planta"
              defaultValue={
                ambiente.planta === 0 ? "Planta baja" : ambiente.planta
              }
            ></LockedTextFieldAmbiente>
            <LockedTextFieldAmbiente
              label="Capacidad"
              defaultValue={ambiente.capacidad}
            ></LockedTextFieldAmbiente>
            <FormTextField
              label="Nombre del ambiente"
              placeholder="Ingrese el nombre del ambiente"
              onChange={setTextFieldNombreAmbiente}
              error={errorNombreAmbiente}
            ></FormTextField>
            <FormSelector
              label="Edificio"
              options={edificiosDisponibles}
              onChange={setSelectedEdificio}
              error={errorEdificio}
              value={selectedEdificio}
            ></FormSelector>
            <FormSelector
              label="Planta"
              options={plantas}
              onChange={setSelectedPlanta}
              error={errorPlanta}
              value={selectedPlanta}
            ></FormSelector>
            <FormSelector
              label="Capacidad"
              onChange={setSelectedCapacidad}
              options={[{ value: "200" }, { value: "250" }]}
              error={errorCapacidad}
              value={selectedCapacidad}
            ></FormSelector>
            <Box
              sx={{
                display: "flex",
                justifyContent: "center",
                alignItems: "center",
                gap: 2,
                marginTop: 2,
              }}
            >
              <Button style={{ backgroundColor: "#ff6666", color: "white" }}>
                Eliminar ambiente
              </Button>
              <Button
                variant="contained"
                color="primary"
                onClick={handleSubmit}
              >
                Guardar cambios
              </Button>
            </Box>
          </Box>
        </form>
      </div>
    </div>
  );
}
