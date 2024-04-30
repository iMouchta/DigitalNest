import React from "react";
import { AdapterDayjs } from "@mui/x-date-pickers/AdapterDayjs";
import { LocalizationProvider } from "@mui/x-date-pickers/LocalizationProvider";
import { DatePicker } from "@mui/x-date-pickers/DatePicker";
import dayjs from "dayjs";

export default function FormDateSelector({ label, onChange }) {
  const minDate = dayjs().add(1, 'day');
  const maxDate = dayjs().add(30, 'day');
  return (
    <div>
      <LocalizationProvider dateAdapter={AdapterDayjs}>
        <DatePicker label={label} minDate={minDate} maxDate={maxDate} onChange={onChange}/>
      </LocalizationProvider>
    </div>
  );
}
