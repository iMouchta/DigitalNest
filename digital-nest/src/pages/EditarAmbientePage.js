import React, { useState, useEffect } from "react";
import { useLocation } from "react-router-dom";
import LockedTextFieldAmbiente from "../components/LockedTextFieldAmbiente";
import { Box } from "@mui/material";
import FormSelector from "../components/FormSelector";


export default function EditarAmbientePage() {

  const location = useLocation();
  const { ambiente } = location.state || {};
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
              defaultValue={ambiente.planta === 0 ? "Planta baja" : ambiente.planta}
            ></LockedTextFieldAmbiente>
            <LockedTextFieldAmbiente
              label="Capacidad"
              defaultValue={ambiente.capacidad}
            ></LockedTextFieldAmbiente>

          </Box>
        </form>
      </div>
    </div>
  );
}