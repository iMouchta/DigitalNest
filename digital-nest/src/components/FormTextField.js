import * as React from "react";
import Box from "@mui/material/Box";
import TextField from "@mui/material/TextField";
import { FormHelperText } from "@mui/material";
import { blue } from "@mui/material/colors";

export default function FormTextField({ label, placeholder, onChange, error }) {
  const handleChange = (event) => {
    onChange(event.target.value);
  };

  return (
    <div>
      <Box 
        sx={{
          display: "flex",
          flexDirection: "column",
          gap: 1,
          marginLeft: "8px",
          paddingY: "10px",
          minWidth: 488
          
        }}
        
      >
        <TextField
          
          sx={{backgroundColor: '#f3f3f3'}} 
          label={label}
          placeholder={placeholder}
          multiline
          onChange={handleChange}
          error={error}
          
        />
          
        <FormHelperText error={error} >
          
          {error ? "Campo   obligatorio (*)" : ""}
        </FormHelperText>
      </Box>
    </div>
  );
}
