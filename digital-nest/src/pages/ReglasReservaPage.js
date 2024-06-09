import React, { useState, useEffect } from "react";
import { useLocation } from "react-router-dom";
import LockedTextFieldAmbiente from "../components/LockedTextFieldAmbiente";
import { Box } from "@mui/material";
import FormDateSelector from "../components/FormDateSelector";
import FormSelector from "../components/FormSelector";

export default function ReglasReservaPage() {
  const location = useLocation();
  const { idAmbiente } = location.state || {};

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

  const [selectedHoraInicio, setSelectedHoraInicio] = useState("");
  const [selectedHoraFin, setSelectedHoraFin] = useState("");
  const [horasFinales, setHorasFinales] = useState([]);

  return (
    <div>
      <h2>Reglas de reserva</h2>
      <p>ID del ambiente: {idAmbiente}</p>
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
            <LockedTextFieldAmbiente
              label="ID del Ambiente"
              defaultValue={idAmbiente}
            ></LockedTextFieldAmbiente>
            <LockedTextFieldAmbiente
              label="Nombre del ambiente"
              defaultValue="690B"
            ></LockedTextFieldAmbiente>
            <LockedTextFieldAmbiente
              label="Edificio"
              defaultValue="Edificio 1"
            ></LockedTextFieldAmbiente>
            <LockedTextFieldAmbiente
              label="Planta"
              defaultValue="Planta baja"
            ></LockedTextFieldAmbiente>
            <LockedTextFieldAmbiente
              label="Capacidad"
              defaultValue="20"
            ></LockedTextFieldAmbiente>
            <h2>Reglas de reserva</h2>
            <LockedTextFieldAmbiente
              label="Días de anticipación"
              defaultValue="2"
            ></LockedTextFieldAmbiente>
            <FormDateSelector label={"Fecha inicial"}></FormDateSelector>
            <FormDateSelector label={"Fecha final"}></FormDateSelector>
            <FormSelector
              label="Hora inicial *"
              options={horasIniciales}
              onChange={setSelectedHoraInicio}
              value={selectedHoraInicio}
            />
            <FormSelector
              label="Hora final *"
              options={horasFinales}
              onChange={setSelectedHoraFin}
              value={selectedHoraFin}
            />
          </Box>
        </form>
      </div>
    </div>
  );
}
