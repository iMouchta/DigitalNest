import React, { useState, useEffect } from "react";
import FormSelector from "./FormSelector";
import FormTextField from "./FormTextField";
import Box from "@mui/material/Box";
import SendFormButton from "./SendFormButton";
import FormDateSelector from "./FormDateSelector";
import {
  Dialog,
  DialogActions,
  DialogContent,
  DialogContentText,
  DialogTitle,
} from "@mui/material";
import Button from "@mui/material/Button";
import { toast, Toaster } from "react-hot-toast";
import FormMultipleSelector from "./FormMultipleSelector";
import AmbientesSelector from "./AmbientesSelector";
import { set } from "lodash";
import LockedTextField from "./LockedTextField";

export default function FormSolicitudEspecial() {
  //* Form fields
  const [textFieldNombre, setTextFieldNombre] = useState("");
  // const [textFieldCapacidad, setTextFieldCapacidad] = useState("");
  const [selectedFecha, setSelectedFecha] = useState("");
  const [selectedHoraInicio, setSelectedHoraInicio] = useState("");
  const [selectedHoraFin, setSelectedHoraFin] = useState("");
  const [textFieldMotivo, setTextFieldMotivo] = useState("");
  const [selectedAmbientes, setSelectedAmbientes] = useState([]);

  //* Error Handling
  const [errorNombre, setErrorNombre] = useState(false);
  // const [errorCapacidad, setErrorCapacidad] = useState(false);
  const [isAmbientesEmpty, setIsAmbientesEmpty] = useState(true);
  const [errorFecha, setErrorFecha] = useState(false);
  const [errorHoraInicio, setErrorHoraInicio] = useState(false);
  const [errorHoraFin, setErrorHoraFin] = useState(false);
  const [errorMotivo, setErrorMotivo] = useState(false);

  const [errorMessage, setErrorMessage] = useState("");

  //* Dialog
  const [open, setOpen] = useState(false);

  const handleClickOpen = () => {
    setOpen(true);
  };

  const handleClose = () => {
    setOpen(false);
  };

  const handleSubmit = () => {
    // event.preventDefault();
    // setErrorNombre(!textFieldNombre);
    // setErrorEdificio(!selectedEdificio);
    // setErrorAmbientes(!selectedAmbientes);
    setErrorFecha(!selectedFecha);
    setErrorHoraInicio(!selectedHoraInicio);
    setErrorHoraFin(!selectedHoraFin);
    setErrorMotivo(!textFieldMotivo);

    if (
      // !textFieldNombre ||
      !selectedFecha ||
      !selectedHoraInicio ||
      !selectedHoraFin ||
      !textFieldMotivo
    ) {
      setErrorMessage("Todos los campos son obligatorios");
      console.log("Error:", errorMessage);
      return;
    }

    // console.log("Nombre:", textFieldNombre);
    // console.log("Capacidad:", textFieldCapacidad);
    console.log("Ambientes:", selectedAmbientes);
    console.log("Fecha:", selectedFecha.format("YYYY-MM-DD"));
    console.log("Hora de inicio:", selectedHoraInicio);
    console.log("Hora de fin:", selectedHoraFin);
    console.log("Motivo:", textFieldMotivo);

    fetch("http://localhost:8000/api/solicitudEspecial", {
      method: "POST",
      headers: {
        "Content-Type": "application/json",
      },
      body: JSON.stringify({
        idusuarios: [1],
        fechasolicitud: selectedFecha.format("YYYY-MM-DD"),
        horainicialsolicitud: selectedHoraInicio,
        horafinalsolicitud: selectedHoraFin,
        idambientes: selectedAmbientes.map((ambiente) => ambiente.idambiente),
        motivosolicitud: textFieldMotivo,
      }),
    })
      .then((response) => response.json())
      .then((data) => {
        if (data.subida) {
          toast.success("Solicitud enviada correctamente");
          window.confirm("Solicitud realizada exitosamente");
          window.location.reload();
        } else {
          toast.error("Error al enviar la solicitud");
        }
      })
      .catch((error) => {
        console.error("Error:", error);
      });
  };
  const handleSelectAmbiente = (ambiente) => {
    setSelectedAmbientes((prev) => {
      // Verifica si el ambiente ya está en el arreglo
      const isAlreadySelected = prev.find(
        (item) => item.idambiente === ambiente.idambiente
      );
      // Si no está, lo agrega
      if (!isAlreadySelected) {
        console.log("Ambiente seleccionado:", ambiente);
        return [...prev, ambiente];
      }
      // Si ya está, devuelve el arreglo sin cambios
      return prev;
    });
  };

  const handleSelectAmbientes = (ambientes) => {
    setSelectedAmbientes((prev) => {
      // Crear una copia del estado anterior para modificar
      let newSelectedAmbientes = [...prev];
  
      // Iterar sobre el arreglo de ambientes proporcionado
      ambientes.forEach((ambiente) => {
        // Verifica si el ambiente ya está en el arreglo
        const isAlreadySelected = newSelectedAmbientes.find(
          (item) => item.idambiente === ambiente.idambiente
        );
  
        // Si no está, lo agrega
        if (!isAlreadySelected) {
          console.log("Ambiente seleccionado:", ambiente);
          newSelectedAmbientes.push(ambiente);
        }
        // Si ya está, no se hacen cambios, por lo que no se agrega de nuevo
      });
  
      // Devuelve el nuevo estado
      return newSelectedAmbientes;
    });
  };
  const horasDisponibles = [
    { value: "6:45" },
    { value: "7:30" },
    { value: "8:15" },
    { value: "9:00" },
    { value: "9:45" },
    { value: "10:30" },
    { value: "11:15" },
    { value: "12:00" },
    { value: "12:45" },
    { value: "13:30" },
    { value: "14:15" },
    { value: "15:00" },
    { value: "15:45" },
    { value: "16:30" },
    { value: "17:15" },
    { value: "18:00" },
    { value: "18:45" },
    { value: "19:30" },
    { value: "20:15" },
    { value: "21:00" },
    { value: "21:45" },
  ];

  const horasInicio = horasDisponibles.slice(0, -1);

  const [horasFin, setHorasFin] = useState([]);

  useEffect(() => {
    if (selectedHoraInicio) {
      const indiceHoraInicial = horasDisponibles.findIndex(
        (hora) => hora.value === selectedHoraInicio
      );
      const nuevasHorasFinales = horasDisponibles.slice(
        indiceHoraInicial + 1,
        indiceHoraInicial + 5
      );
      setHorasFin(nuevasHorasFinales);

      // Verificar si la hora final seleccionada está en el nuevo rango de horas finales
      if (!nuevasHorasFinales.some((hora) => hora.value === selectedHoraFin)) {
        setSelectedHoraFin(""); // Restablecer la hora final si no está en el rango
      }
    } else {
      setHorasFin([]);
      setSelectedHoraFin(""); // Restablecer la hora final si la hora de inicio no está seleccionada
    }
  }, [selectedHoraInicio, selectedHoraFin, setSelectedHoraFin]);
  return (
    <form>
      <Box
        display="flex"
        flexDirection="column"
        justifyContent="center"
        alignItems="center"
        minHeight="calc(100vh - 160px)"
        sx={{
          p: 2,
          backgroundColor: "white",
          color: "black",
          width: "500px",
          borderRadius: "10px",
        }}
      >
        {/* <FormTextField
          label="Nombre completo *"
          placeholder="Ingrese su nombre completo"
          onChange={setTextFieldNombre}
          error={errorNombre}
        /> */}
        <LockedTextField />
        <AmbientesSelector
          onMultipleSelection={handleSelectAmbientes}
          isEmpty={setIsAmbientesEmpty}
        />
        {isAmbientesEmpty && (
          <div style={{ color: "red", fontSize: "small" }}>
            Debes seleccionar almenos un ambiente
          </div>
        )}
        <div style={{ marginTop: "20px" }}></div>

        <FormDateSelector
          label="Fecha *"
          onChange={setSelectedFecha}
          error={errorFecha}
        />

        <FormSelector
          label="Hora inicial *"
          options={horasInicio}
          onChange={setSelectedHoraInicio}
          error={errorHoraInicio}
          value={selectedHoraInicio}
        />
        <FormSelector
          label="Hora final *"
          options={horasFin}
          onChange={setSelectedHoraFin}
          error={errorHoraFin}
          value={selectedHoraFin}
        />
        <FormTextField
          label="Motivo de la reserva"
          placeholder="Ingrese el motivo de reserva"
          onChange={setTextFieldMotivo}
          error={errorMotivo}
        />

        <SendFormButton onClick={handleClickOpen} label={"Confirmar"} />
        <Dialog
          open={open}
          onClose={handleClose}
          aria-labelledby="alert-dialog-title"
          aria-describedby="alert-dialog-description"
        >
          <DialogTitle id="alert-dialog-title">{"Confirmación"}</DialogTitle>
          <DialogContent>
            <DialogContentText id="alert-dialog-description">
              ¿Estás seguro de que quieres enviar esta solicitud?
            </DialogContentText>
          </DialogContent>
          <DialogActions>
            <Button onClick={handleClose}>Cancelar</Button>
            <Button
              onClick={() => {
                handleSubmit();
                handleClose();
              }}
              autoFocus
            >
              Aceptar
            </Button>
          </DialogActions>
        </Dialog>
      </Box>
      <Toaster />
    </form>
  );
}
