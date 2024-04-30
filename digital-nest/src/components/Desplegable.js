import React from 'react';


function Desplegable({ options, selectedOption, handleSelectChange }) {
  return (
    <div className="Desplegable">
      <select value={selectedOption} onChange={handleSelectChange}>
        <option value="">--Por favor selecciona una opción--</option>
        {options.map((option) => (
          <option key={option} value={option}>
            {option}
          </option>
        ))}
      </select>
    </div>
  );
}

export default Desplegable;