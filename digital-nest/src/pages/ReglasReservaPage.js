import React, { useState, useEffect } from "react";
import { useLocation } from "react-router-dom";
import LockedTextFieldAmbiente from "../components/LockedTextFieldAmbiente";
import { Box, Button } from "@mui/material";
import FormDateSelector from "../components/FormDateSelector";
import FormSelector from "../components/FormSelector";

export default function ReglasReservaPage() {
  const location = useLocation();
  const { ambiente } = location.state || {};

  //* Variables
  const [selectedFechaInicial, setSelectedFechaInicial] = useState("");
  const [selectedFechaFinal, setSelectedFechaFinal] = useState("");

  const [selectedHoraInicio, setSelectedHoraInicio] = useState("");
  const [selectedHoraFin, setSelectedHoraFin] = useState("");

  //* Errores
  const [errorFechaInicial, setErrorFechaInicial] = useState(false);
  const [errorFechaFinal, setErrorFechaFinal] = useState(false);
  const [errorHoraInicio, setErrorHoraInicio] = useState(false);
  const [errorHoraFin, setErrorHoraFin] = useState(false);
  const [errorMessage, setErrorMessage] = useState("");

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

  const horasIniciales = horasDisponibles.slice(0, -1);

  const horasFinales = horasDisponibles.slice(1);
  
  const handleSubmit = (event) => {
    event.preventDefault();

    setErrorFechaInicial(!selectedFechaInicial);
    setErrorFechaFinal(!selectedFechaFinal);
    setErrorHoraInicio(!selectedHoraInicio);
    setErrorHoraFin(!selectedHoraFin);
    if (
      !selectedFechaInicial ||
      !selectedFechaFinal ||
      !selectedHoraInicio ||
      !selectedHoraFin
    ) {
      setErrorMessage("Todos los campos son obligatorios");
      console.log("Error en la validación");
      return;
    }

    console.log("Fecha inicial: ", selectedFechaInicial);
    console.log("Fecha final: ", selectedFechaFinal);

    crearReglasDeReserva();
  };

  const crearReglasDeReserva = async () => {
    await fetch("http://localhost:8000/api/registrarReglaReservaAmbiente", {
      method: "POST",
      headers: {
        "Content-Type": "application/json",
      },
      body: JSON.stringify({
        idambiente: ambiente.id,
        fechainicialdisponible: selectedFechaInicial,
        fechafinaldisponible: selectedFechaFinal,
        horainicialdisponible: selectedHoraInicio,
        horafinaldisponible: selectedHoraFin,
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
            <h2>Información de ambiente</h2>
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
            <h2>Reglas de reserva</h2>
            <FormDateSelector
              label={"Fecha inicial"}
              onChange={setSelectedFechaInicial}
              error={errorFechaInicial}
            ></FormDateSelector>
            <FormDateSelector
              label={"Fecha final"}
              onChange={setSelectedFechaFinal}
              error={errorFechaFinal}
              value={selectedFechaFinal}
            ></FormDateSelector>
            <FormSelector
              label="Hora inicial *"
              options={horasIniciales}
              error={errorHoraInicio}
              onChange={setSelectedHoraInicio}
              value={selectedHoraInicio}
            />
            <FormSelector
              label="Hora final *"
              options={horasFinales}
              error={errorHoraFin}
              onChange={setSelectedHoraFin}
              value={selectedHoraFin}
            />
            <Button variant="contained" color="primary" onClick={handleSubmit}>
              Guardar cambios
            </Button>
          </Box>
        </form>
      </div>
    </div>
  );
}