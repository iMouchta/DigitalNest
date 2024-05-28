import Box from '@mui/material/Box';
import Checkbox from '@mui/material/Checkbox';
import FormControlLabel from '@mui/material/FormControlLabel';

import { useState, useEffect } from 'react';

export default function AmbientesSelector({ onSelect, isEmpty }) { 

  const [ambientes, setAmbientes] = useState([]);
  const [checked, setChecked] = useState([]);
  
  useEffect(() => {
    isEmpty(!checked.includes(true));
  }, [checked, isEmpty]);

  useEffect(() => {
    fetch("http://localhost:8000/api/ambiente")
      .then((response) => response.json())
      .then((data) => {
        setAmbientes(data);
        setChecked(new Array(data.length).fill(false));
      })
      .catch((error) => console.error("Error:", error));
  }, []);

  const handleChange = (index) => (event) => {
    const newChecked = [...checked];
    newChecked[index] = event.target.checked;
    setChecked(newChecked);

    if (onSelect) {
      onSelect(ambientes[index]);
    }
  };

  const ambientesPorEdificio = ambientes.reduce((acc, ambiente) => {
    if (!acc[ambiente.edificio]) {
      acc[ambiente.edificio] = [];
    }
    acc[ambiente.edificio].push(ambiente);
    return acc;
  }, {});
  
  return (
    <Box sx={{ flexDirection: "column" }}>
      {Object.entries(ambientesPorEdificio).map(([edificio, ambientes], index) => (
        <Box key={index} sx={{ flexDirection: "row" }}>
          <Box sx={{ marginRight: 2 }}>{edificio}</Box>
          <Box sx={{ flexDirection: "column" }}>
            {ambientes.map((ambiente, index) => (
              <FormControlLabel
                key={ambiente.idambiente}
                control={<Checkbox checked={checked[index]} onChange={handleChange(index)} />}
                label={ambiente.nombreambiente}
              />
            ))}
          </Box>
        </Box>
      ))}
    </Box>
  );

}