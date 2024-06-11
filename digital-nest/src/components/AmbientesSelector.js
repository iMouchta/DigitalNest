import Box from "@mui/material/Box";
import Checkbox from "@mui/material/Checkbox";
import FormControlLabel from "@mui/material/FormControlLabel";
import { useState, useEffect } from "react";

export default function AmbientesSelector({ onMultipleSelection, isEmpty }) {
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

    const selectedAmbientes = ambientes.filter((_, i) => newChecked[i]);
    if (onMultipleSelection) {
      onMultipleSelection(selectedAmbientes);
    }
  };

  const handleSelectAll = () => {
    const newAllChecked = !checked.every(Boolean);
    const newChecked = new Array(ambientes.length).fill(newAllChecked);
    setChecked(newChecked);

    if (onMultipleSelection) {
      if (newAllChecked) {
        onMultipleSelection(ambientes);
      } else {
        onMultipleSelection([]);
      }
    }
  };

  const allChecked = checked.every(Boolean);
  const indeterminate = checked.some(Boolean) && !allChecked;

  const handleChangeParent = (event) => {
    const newCheckedState = checked.map(() => event.target.checked);
    setChecked(newCheckedState);
    if (onMultipleSelection) {
      if (event.target.checked) {
        onMultipleSelection(ambientes);
      } else {
        onMultipleSelection([]);
      }
    }
  };

  return (
    <div>
      <FormControlLabel
        label="Todos los Ambientes"
        control={
          <Checkbox
            checked={allChecked}
            indeterminate={indeterminate}
            onChange={handleChangeParent}
          />
        }
      />
      <Box sx={{ display: "flex", flexDirection: "column", ml: 3 }}>
        {ambientes.map((ambiente, index) => (
          <FormControlLabel
            key={ambiente.idambiente}
            label={ambiente.nombreambiente}
            control={
              <Checkbox
                checked={checked[index]}
                onChange={handleChange(index)}
              />
            }
          />
        ))}
      </Box>
    </div>
  );
}