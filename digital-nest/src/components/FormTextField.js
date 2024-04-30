import * as React from "react";
import Box from "@mui/material/Box";
import TextField from "@mui/material/TextField";

export default function FormTextField({ label, placeholder, onChange, error }) {

  const handleChange = (event) => {
    onChange(event.target.value);
  }

  return (
    <div>
      <Box
        sx={{
          display: "flex",
          flexDirection: "column",
          gap: 1,
        }}
      >
        <TextField
          label={label}
          placeholder={placeholder}
          multiline
          onChange={handleChange}
          error={error}
        />
      </Box>
    </div>
  );
}
