import React, { useState, useEffect } from "react";
import FormSelector from "./FormSelector";
import FormMultipleSelector from "./FormMultipleSelector";
import FormTextField from "./FormTextField";
import Box from "@mui/material/Box";
import SendFormButton from "./SendFormButton";
import FormDateSelector from "./FormDateSelector";
import Grid from "@mui/material/Box";
import SelectAmbienteDialog from "./SelectAmbienteDialog";
import { set } from "lodash";

export default function FormSolicitudRapida() {
  //* Form fields
  const [selectedNombreDocente, setSelectedNombreDocente] = useState("");
  const [selectedMateria, setSelectedMateria] = useState("");
  const [selectedCapacidad, setSelectedCapacidad] = useState("");
  const [selectedFecha, setSelectedFecha] = useState("");
  const [selectedHoraInicio, setSelectedHoraInicio] = useState("");
  const [selectedHoraFin, setSelectedHoraFin] = useState("");
  const [selectedMotivo, setSelectedMotivo] = useState("");

  //* Error Handling
  const [errorNombreDocente, setErrorNombreDocente] = useState(false);
  const [errorMateria, setErrorMateria] = useState(false);
  const [errorCapacidad, setErrorCapacidad] = useState(false);
  const [errorFecha, setErrorFecha] = useState(false);
  const [errorHoraInicio, setErrorHoraInicio] = useState(false);
  const [errorHoraFin, setErrorHoraFin] = useState(false);
  const [errorMotivo, setErrorMotivo] = useState(false);
  const [errorMessage, setErrorMessage] = useState("");

  //* Dialog
  const [openDialog, setOpenDialog] = useState(false);
  const [ambientes, setAmbientes] = useState({});

  const [formData, setFormData] = useState({
    nombredocente: "",
    materia: "",
    capacidad: "",
    fecha: "",
    horainicial: "",
    horafinal: "",
    motivo: "",
  });

  const handleOpenDialog = () => {
    setOpenDialog(true);
  };

  const handleSubmit = (event) => {
    event.preventDefault();

    setErrorNombreDocente(!selectedNombreDocente);
    setErrorMateria(!selectedMateria);
    setErrorCapacidad(!selectedCapacidad);
    setErrorFecha(!selectedFecha);
    setErrorHoraInicio(!selectedHoraInicio);
    setErrorHoraFin(!selectedHoraFin);
    setErrorMotivo(!selectedMotivo);

    if (
      !selectedNombreDocente ||
      !selectedMateria ||
      !selectedCapacidad ||
      !selectedFecha ||
      !selectedHoraInicio ||
      !selectedHoraFin ||
      !selectedMotivo
    ) {
      setErrorMessage("Todos los campos son obligatorios");
      console.log("Error:", errorMessage);
      return;
    }

    console.log("Nombre del docente:", [selectedNombreDocente]);
    console.log("Materia:", selectedMateria);
    console.log("Capacidad:", selectedCapacidad);
    console.log("Fecha:", selectedFecha.format("YYYY-MM-DD"));
    console.log("Hora de inicio:", selectedHoraInicio);
    console.log("Hora de fin:", selectedHoraFin);
    console.log("Motivo:", selectedMotivo);

    // Realizar la solicitud POST
    fetch("http://localhost:8000/api/solicitud", {
      method: "POST",
      headers: {
        "Content-Type": "application/json",
      },

      body: JSON.stringify({
        nombresdocentes: [selectedNombreDocente],
        materia: "Introduccion a la programacion",
        // materia: selectedMateria,
        capacidad: selectedCapacidad,
        fecha: selectedFecha.format("YYYY-MM-DD"),
        horainicial: selectedHoraInicio,
        horafinal: selectedHoraFin,
        motivo: selectedMotivo,
      }),
    })
      .then((response) => {
        if (!response.ok) {
          throw new Error("Error en la solicitud POST");
        }
        return response.json();
      })
      .then((data) => {
        console.log(data);
        setFormData({
          nombresdocentes: [selectedNombreDocente],
          materia: selectedMateria,
          capacidad: selectedCapacidad,
          fecha: selectedFecha.format("YYYY-MM-DD"),
          horainicial: selectedHoraInicio,
          horafinal: selectedHoraFin,
          motivo: selectedMotivo,
        });
        const ambientesMap = data.ambientes.reduce((map, ambiente) => {
          map[ambiente.nombreambiente] = ambiente.capacidadambiente;
          console.log("Ambiente:", ambiente.nombreambiente);
          return map;
        }, {});

        setAmbientes(ambientesMap);

        handleOpenDialog();
      })
      .catch((error) => {
        console.error("Error:", error);
      });
  };

  const docentes = [{ value: "Leticia Blanco" }];

  const materias = [
    { value: "Introduccion a la programacion" },
    { value: "Algoritmos Avanzados" },
    { value: "Taller de Ingenieria de Software" },
    { value: "Elementos de programacion y Estructura de Datos" },
    { value: "Arquitectura de Computadoras I" },
  ];

  const capacidades = [
    { value: "20" },
    { value: "30" },
    { value: "50" },
    { value: "100" },
    { value: "200" },
    { value: "250" },
  ];

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

  const horasIniciales = horasDisponibles.slice(0, -1);

  const [horasFinales, setHorasFinales] = useState([]);

  useEffect(() => {
    if (selectedHoraInicio) {
      const indiceHoraInicial = horasDisponibles.findIndex(hora => hora.value === selectedHoraInicio);
      const nuevasHorasFinales = horasDisponibles.slice(indiceHoraInicial + 1, indiceHoraInicial + 5);
      setHorasFinales(nuevasHorasFinales);
  
      // Verificar si la hora final seleccionada está en el nuevo rango de horas finales
      if (!nuevasHorasFinales.some(hora => hora.value === selectedHoraFin)) {
        setSelectedHoraFin(""); // Restablecer la hora final si no está en el rango
      }
    } else {
      setHorasFinales([]);
      setSelectedHoraFin(""); // Restablecer la hora final si la hora de inicio no está seleccionada
    }
  }, [selectedHoraInicio]);

  const motivos = [
    { value: "Primer Parcial" },
    { value: "Segundo Parcial" },
    { value: "Examen Final" },
    { value: "Segunda Instancia" },
    { value: "Examen de Mesa" },
  ];

  return (
    <form>
      <Grid>
        <Grid>
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
            <FormSelector
              label="Nombre del docente *"
              options={docentes}
              onChange={setSelectedNombreDocente}
              error={errorNombreDocente}
            />
            <FormMultipleSelector
              label="Nombres"
              options={[
                // { value: "Leticia Blanco Coca", label: "Leticia Blanco Coca" },
                { value: "Vladimir Costas", label: "Vladimir Costas" },
                { value: "Corina Flores", label: "Corina Flores" },
              ]}
              onChange={(value) => console.log(value)}
            />
            <FormSelector
              label="Materia *"
              options={materias}
              onChange={setSelectedMateria}
              error={errorMateria}
            />
            <FormSelector
              label="Capacidad *"
              options={capacidades}
              onChange={setSelectedCapacidad}
              error={errorCapacidad}
            />
            <FormDateSelector
              label="Fecha *"
              onChange={setSelectedFecha}
              error={errorFecha}
            />
            <FormSelector
              label="Hora inicial *"
              options={horasIniciales}
              onChange={setSelectedHoraInicio}
              error={errorHoraInicio}
            />
            <FormSelector
              label="Hora final *"
              options={horasFinales}
              onChange={setSelectedHoraFin}
              error={errorHoraFin}
            />
            <FormSelector
              label="Motivo de la reserva *"
              options={motivos}
              onChange={setSelectedMotivo}
              error={errorMotivo}
            />

            <SendFormButton
              onClick={handleSubmit}
              label={"SELECCIONAR AMBIENTE"}
            />
          </Box>
        </Grid>
      </Grid>
      <SelectAmbienteDialog
        open={openDialog}
        handleClose={() => setOpenDialog(false)}
        ambientes={ambientes}
        formData={formData}
      />
    </form>
  );
}
