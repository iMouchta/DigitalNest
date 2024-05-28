import TextField from "@mui/material/TextField";
import Box from "@mui/material/Box";

export default function LockedTextField() {
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
          sx={{ backgroundColor: "#f3f3f3" }}
          label="Nombre completo *"
          defaultValue="Jose Admin"
          InputProps={{
            readOnly: true,
          }}
        />
      </Box>
    </div>
  );
}
