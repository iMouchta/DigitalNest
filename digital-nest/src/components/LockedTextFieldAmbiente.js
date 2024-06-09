import TextField from "@mui/material/TextField";
import Box from "@mui/material/Box";

export default function LockedTextFieldAmbiente({ label = "Nombre completo *", defaultValue = "Leticia Blanco" }) {
  return (
    <div>
      <Box
        sx={{
          display: "flex",
          flexDirection: "column",
          gap: 1,
          marginLeft: "8px",
          paddingY: "10px",
          minWidth: 488,
        }}
      >
        <TextField
          sx={{ backgroundColor: "#f5f5f5" }}
          label={label}
          defaultValue={defaultValue}
          InputProps={{
            readOnly: true,
          }}
        />
      </Box>
    </div>
  );
}