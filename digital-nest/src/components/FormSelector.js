import * as React from "react";
import Input from "@mui/material/InputLabel";
import InputLabel from "@mui/material/InputLabel";
import MenuItem from "@mui/material/MenuItem";
import FormControl from "@mui/material/FormControl";
import Select from "@mui/material/Select";
import { FormHelperText } from "@mui/material";

export default function FormSelector({
  label,
  options,
  onChange,
  error,
  value,
}) {
  const handleChange = (event) => {
    onChange(event.target.value);
  };

  return (
    <div>
      <FormControl error={error} sx={{ m: 1, minWidth: 488 }}>
        <InputLabel sx={{ backgroundColor: "#f3f3f3" }}>{label}</InputLabel>
        <Select
          sx={{ backgroundColor: "#f3f3f3" }}
          label={label}
          value={value}
          onChange={handleChange}
          renderValue={(value) => `${value}`}
        >
          <MenuItem value="">
            <em>Ninguno </em>
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
