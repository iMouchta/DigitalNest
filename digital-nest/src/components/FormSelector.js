import * as React from "react";
import InputLabel from "@mui/material/InputLabel";
import MenuItem from "@mui/material/MenuItem";
import FormControl from "@mui/material/FormControl";
import Select from "@mui/material/Select";
import { FormHelperText } from "@mui/material";

export default function FormSelector({ label, options, onChange, error }) {
  const [value, setValue] = React.useState("");

  const handleChange = (event) => {
    setValue(event.target.value);
    onChange(event.target.value);
  };

  return (
    <div>
      <FormControl error={error} sx={{ m: 1, minWidth: 250 }}>
        <InputLabel>{label}</InputLabel>
        <Select label={label} value={value} onChange={handleChange}>
          <MenuItem value="">
            <em>Ninguno</em>
          </MenuItem>
          {options.map((option, index) => (
            <MenuItem key={index} value={option.value}>
              {option.value}
            </MenuItem>
          ))}
        </Select>
        <FormHelperText>Campo obligatorio (*)</FormHelperText>
      </FormControl>
    </div>
  );
}
