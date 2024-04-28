import React, { useState } from "react";
import Desplegable from "./Desplegable";
import { FormControl, InputLabel, MenuItem, Select } from "@mui/material";
import FormSelector from "./FormSelector";
import FormMultipleSelector from "./FormMultipleSelector";

function FormSolicitudRapida() {
  const [selectedOptionA, setSelectedOptionA] = useState("");
  const [selectedOptionB, setSelectedOptionB] = useState("");
  const [selectedOptionC, setSelectedOptionC] = useState("");

  const optionsA = ["Opcion A1", "Opcion A2", "Opcion A3", "Opcion A4"];
  const optionsB = ["Opcion B1", "Opcion B2", "Opcion B3", "Opcion B4"];
  const optionsC = ["Opcion C1", "Opcion C2", "Opcion C3", "Opcion C4"];

  const handleSelectChangeA = (event) => {
    setSelectedOptionA(event.target.value);
  };

  const handleSelectChangeB = (event) => {
    setSelectedOptionB(event.target.value);
  };

  const handleSelectChangeC = (event) => {
    setSelectedOptionC(event.target.value);
  };

  return (
    <form>
      <label>
        Selecciona una opción:
        <Desplegable
          options={optionsA}
          selectedOption={selectedOptionA}
          handleSelectChange={handleSelectChangeA}
        />
        <Desplegable
          options={optionsB}
          selectedOption={selectedOptionB}
          handleSelectChange={handleSelectChangeB}
        />
        <Desplegable
          options={optionsC}
          selectedOption={selectedOptionC}
          handleSelectChange={handleSelectChangeC}
        />
        <div className="form-text-field">
          <label>Nombre: </label>
          <input type="text" placeholder="Nombre" />
        </div>
        <div className="form-solicitud-button">
          <button type="submit">Enviar</button>
        </div>
      </label>
      <FormSelector
        label="Selecciona una opción"
        options={[
          { value: "Test 1", label: "Test 1" },
          { value: 2, label: "Test 2" },
          { value: 3, label: "Test 3" },
          // ... más opciones
        ]}
      />
      <FormSelector
        label="Selecciona una opción"
        options={[
          { value: 1, label: "Test 1" },
          { value: 2, label: "Test 2" },
          { value: 3, label: "Test 3" },
          // ... más opciones
        ]}
      />
      <FormMultipleSelector 
        label="Selecciona opciones"
        options={[
          { value: "Test 1", label: "Test 1" },
          { value: 2, label: "Test 2" },
          { value: 3, label: "Test 3" },
          // ... más opciones
        ]}
      />
    </form>
  );
}

export default FormSolicitudRapida;
