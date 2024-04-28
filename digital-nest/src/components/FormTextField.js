import * as React from "react";
import Box from "@mui/material/Box";
import TextField from "@mui/material/TextField";

export default function FormTextField({ label, placeholder }) {
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
        />
      </Box>
    </div>
  );
}
