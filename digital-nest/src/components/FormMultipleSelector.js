import * as React from "react";
import { useTheme } from "@mui/material/styles";
import Box from "@mui/material/Box";
import OutlinedInput from "@mui/material/OutlinedInput";
import InputLabel from "@mui/material/InputLabel";
import MenuItem from "@mui/material/MenuItem";
import FormControl from "@mui/material/FormControl";
import Select from "@mui/material/Select";
import Chip from "@mui/material/Chip";
import { FormHelperText } from "@mui/material";

export default function FormMultipleSelector({ label, options, onChange }) {
  const [value, setValue] = React.useState([]);

  const handleChange = (event) => {
    const {
      target: { value },
    } = event;
    const valueArray = typeof value === "string" ? value.split(",") : value;
    setValue(valueArray);
    onChange(valueArray);

  };

  return (
    <div>
      <FormControl sx={{ m: 1, minWidth: 488 }}>
        <InputLabel sx={{backgroundColor: '#f3f3f3'}}>{label}</InputLabel>
        <Select
          sx={{backgroundColor: '#f3f3f3'}}
          multiple
          label={label}
          value={value}
          onChange={handleChange}
          renderValue={(selected) => (
            <Box sx={{  display: "flex", flexWrap: "wrap", gap: 0.5 }}>
              {selected.map((value) => (
                <Chip key={value} label={value} />
              ))}
            </Box>
          )}
        >
          {options.map((option, index) => (
            <MenuItem key={index} value={option.value}>
              {option.label}
            </MenuItem>
          ))}
        </Select>
        <FormHelperText>Campo obligatorio (*)</FormHelperText>
      </FormControl>
    </div>
  );
}
