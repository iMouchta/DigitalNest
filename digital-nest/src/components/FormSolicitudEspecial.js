import React, { useState } from 'react';
import Desplegable from './Desplegable';

function FormSolicitudEspecial() {
  const [selectedOptionA, setSelectedOptionA] = useState('');
  const [selectedOptionB, setSelectedOptionB] = useState('');
  const [selectedOptionC, setSelectedOptionC] = useState('');

  const optionsA = ['Opcion A1', 'Opcion A2', 'Opcion A3', 'Opcion A4'];
  const optionsB = ['Opcion B1', 'Opcion B2', 'Opcion B3', 'Opcion B4'];
  const optionsC = ['Opcion C1', 'Opcion C2', 'Opcion C3', 'Opcion C4'];

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
      </label>
    </form>
  );
}

export default FormSolicitudRapida;