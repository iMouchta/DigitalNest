import React from "react";
import { AdapterDayjs } from "@mui/x-date-pickers/AdapterDayjs";
import { LocalizationProvider } from "@mui/x-date-pickers/LocalizationProvider";
import { DatePicker } from "@mui/x-date-pickers/DatePicker";
import FormHelperText from "@mui/material/FormHelperText";
import dayjs from "dayjs";

export default function FormDateSelector({ label, onChange, error }) {
  const minDate = dayjs().add(1, "day");
  const maxDate = dayjs().set('month', 6).set('date', 6);

  const [value, setValue] = React.useState(null);

  const handleChange = (newValue) => {
    setValue(newValue);
    onChange(newValue);
  };

  return (
    <div style={{marginLeft: '8px', marginRight:'8px'}}>
      <LocalizationProvider sx={{backgroundColor: '#f3f3f3'}}  dateAdapter={AdapterDayjs}>
        <DatePicker
          sx={{backgroundColor: '#f3f3f3',minWidth: 488}}
          style={{ color: error ? "red" : "inherit",  }}
          label={label}
          minDate={minDate}
          maxDate={maxDate}
          value={value}
          onChange={handleChange}
          error={error}
          helperText={error ? "Este campo es obligatorio" : ""}
        />
        <FormHelperText style={{ color: error ? "rgb(311, 47, 47)" : "inherit", marginLeft: '8px' }}>
        Campo obligatorio (*)
        </FormHelperText>
      </LocalizationProvider>
    </div>
  );
}
