import TextField from "@mui/material/TextField";
import Box from "@mui/material/Box";

export default function LockedTextFieldAmbiente({ label = "Error *", defaultValue = "Error" }) {
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
          sx={{ backgroundColor: "#BDBDBD" }}
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