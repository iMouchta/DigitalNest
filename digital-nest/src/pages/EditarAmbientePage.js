import React, { useState, useEffect } from "react";
import { useLocation } from "react-router-dom";
import LockedTextFieldAmbiente from "../components/LockedTextFieldAmbiente";
import { Box, Button, Dialog, DialogActions, DialogContent, DialogTitle, Typography } from "@mui/material";
import FormSelector from "../components/FormSelector";
import FormTextField from "../components/FormTextField";
import FormSelectorTrigger from "../components/FormSelectorTrigger";
import { URL_API } from '../http/const';

export default function EditarAmbientePage() {
  const location = useLocation();
  const { ambiente } = location.state || {};

  //* Variables
  const [textFieldNombreAmbiente, setTextFieldNombreAmbiente] = useState(
    ambiente.aula
  );
  const [selectedEdificio, setSelectedEdificio] = useState(ambiente.edificio);
  const [selectedCapacidad, setSelectedCapacidad] = useState(
    ambiente.capacidad
  );
  const [selectedPlanta, setSelectedPlanta] = useState(ambiente.planta);

  //* Errors
  const [errorNombreAmbiente, setErrorNombreAmbiente] = useState(false);
  const [errorCapacidad, setErrorCapacidad] = useState(false);
  const [errorEdificio, setErrorEdificio] = useState(false);
  const [errorPlanta, setErrorPlanta] = useState(false);

  const [errorMessage, setErrorMessage] = useState("");

  //* Additional states
  const [edificios, setEdificios] = useState([]);
  const [plantas, setPlantas] = useState([]);

  //* Dialog
  const [open, setOpen] = useState(false);
  const [openSuccess, setOpenSuccess] = useState(false);
  const [dialogMessage, setDialogMessage] = useState("");
  const [dialogTitle, setDialogTitle] = useState("");

  useEffect(() => {
    fetch(`${URL_API}/edificio`)
      .then((response) => response.json())
      .then((data) => {
        setEdificios(data);
        const edificioSeleccionado = data.find(
          (edificio) => edificio.nombreedificio === selectedEdificio
        );
        const numeropisos = edificioSeleccionado
          ? edificioSeleccionado.numeropisos
          : 0;
        setPlantas([
          "Planta baja",
          ...Array.from({ length: numeropisos - 1 }, (_, i) => i + 1),
        ]);
      })
      .catch((error) => console.error("Error:", error));
  }, []);

  const handleSubmit = () => {
    setErrorNombreAmbiente(!textFieldNombreAmbiente);
    setErrorCapacidad(!selectedCapacidad);
    setErrorEdificio(!selectedEdificio);
    setErrorPlanta(!selectedPlanta);

    if (!textFieldNombreAmbiente) {
      setErrorMessage("Todos los campos son obligatorios");
      console.log("Error en la validación:");
      return;
    }

    console.log("Nombre del ambiente:", textFieldNombreAmbiente);
    console.log("Capacidad:", selectedCapacidad);
    console.log("Edificio:", selectedEdificio);
    console.log("Planta:", selectedPlanta);

    setOpen(true);
    // guardarCambios();
  };

  const handleClose = () => {
    setOpen(false);
  };

  const handleConfirm = () => {
    guardarCambios();
    setOpen(false);
  };

  const guardarCambios = async () => {
    await fetch(`${URL_API}/editAmbiente`, {
      method: "POST",
      headers: {
        "Content-Type": "application/json",
      },
      body: JSON.stringify({
        idambiente: ambiente.id,
        nombreambiente: textFieldNombreAmbiente,
        capacidadambiente: selectedCapacidad,
        planta: selectedPlanta === "Planta baja" ? 0 : selectedPlanta,
        nombreedificio: selectedEdificio,
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
        if (data.actualizado) {
          handlePostSuccess(
            "Cambios guardados",
            "Los cambios se guardaron correctamente"
          );
        } else {
          handlePostSuccess(
            "Error",
            "No se pudo guardar los cambios porque el ambiente ya tiene reservas asociadas"
          );
        }
      })
      .catch((error) => {
        console.error("Error:", error);
      });
  };

  const handlePostSuccess = (title, message) => {
    setDialogTitle(title);
    setDialogMessage(message);
    setOpenSuccess(true);
  };

  const handleCloseSuccess = () => {
    setOpenSuccess(false);
  };

  // const eliminarAmbiente = async () => {
  //   await fetch(`${URL_API}/deleteAmbiente", {
  //     method: "POST",
  //     headers: {
  //       "Content-Type": "application/json",
  //     },
  //     body: JSON.stringify({
  //       idambiente: ambiente.id,
  //     }),
  //   })
  //     .then((response) => {
  //       if (!response.ok) {
  //         throw new Error("Error en la solicitud POST");
  //       }
  //       return response.json();
  //     })
  //     .then((data) => {
  //       console.log(data);
  //     })
  //     .catch((error) => {
  //       console.error("Error:", error);
  //     });
  // };

  return (
    <div>
      <h2>Reglas de reserva</h2>

      <div
        style={{
          display: "flex",
          justifyContent: "center",
          alignItems: "center",
          paddingTop: "20px",
          paddingBottom: "10px",
        }}
      >
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
            <LockedTextFieldAmbiente
              label="ID del Ambiente"
              defaultValue={ambiente.id}
            ></LockedTextFieldAmbiente>

            {/* <LockedTextFieldAmbiente
              label="Nombre del ambiente"
              defaultValue={ambiente.aula}
            ></LockedTextFieldAmbiente>
            <LockedTextFieldAmbiente
              label="Edificio"
              defaultValue={ambiente.edificio}
            ></LockedTextFieldAmbiente>
            <LockedTextFieldAmbiente
              label="Planta"
              defaultValue={
                ambiente.planta === 0 ? "Planta baja" : ambiente.planta
              }
            ></LockedTextFieldAmbiente>
            <LockedTextFieldAmbiente
              label="Capacidad"
              defaultValue={ambiente.capacidad}
            ></LockedTextFieldAmbiente> */}
            <FormTextField
              label="Nombre del ambiente *"
              placeholder="Ingrese el nombre del ambiente"
              onChange={setTextFieldNombreAmbiente}
              error={errorNombreAmbiente}
              defaultValue={ambiente.aula}
            ></FormTextField>
            <FormSelectorTrigger
              label="Edificio *"
              options={edificios.map((edificio) => ({
                value: edificio.nombreedificio,
              }))}
              onChange={(e) => {
                setSelectedEdificio(e.target.value);
                setSelectedPlanta("");
                const edificioSeleccionado = edificios.find(
                  (edificio) => edificio.nombreedificio === e.target.value
                );
                const numeropisos = edificioSeleccionado
                  ? edificioSeleccionado.numeropisos
                  : 0;
                setPlantas([
                  "Planta baja",
                  ...Array.from({ length: numeropisos - 1 }, (_, i) => i + 1),
                ]);
              }}
              error={errorEdificio}
              value={selectedEdificio}
            ></FormSelectorTrigger>
            <FormSelector
              label="Planta *"
              options={plantas.map((planta) => ({
                value: planta,
              }))}
              onChange={setSelectedPlanta}
              error={errorPlanta}
              value={selectedPlanta}
            ></FormSelector>
            <FormSelector
              label="Capacidad *"
              onChange={setSelectedCapacidad}
              options={[
                { value: "20" },
                { value: "30" },
                { value: "50" },
                { value: "100" },
                { value: "200" },
                { value: "250" },
              ]}
              error={errorCapacidad}
              value={selectedCapacidad}
            ></FormSelector>
            <Box
              sx={{
                display: "flex",
                justifyContent: "center",
                alignItems: "center",
                gap: 2,
                marginTop: 2,
              }}
            >
              {/* <Button style={{ backgroundColor: "#ff6666", color: "white" }}>
                Eliminar ambiente
              </Button> */}
              <Button
                variant="contained"
                color="primary"
                onClick={handleSubmit}
              >
                Guardar cambios
              </Button>
              <Dialog
                open={open}
                onClose={handleClose}
                aria-labelledby="alert-dialog-title"
                aria-describedby="alert-dialog-description"
              >
                <DialogTitle id="alert-dialog-title">
                  {"¿Está seguro de guardar los cambios?"}
                </DialogTitle>
                <DialogContent>
                  <Typography align="justify" id="alert-dialog-description">
                    {"Una vez guardados los cambios se actualizarán en el sistema"}
                  </Typography>
                </DialogContent>
                <DialogActions>
                  <Button onClick={handleClose}>Cancelar</Button>
                  <Button onClick={handleConfirm} autoFocus>
                    Confirmar
                  </Button>
                </DialogActions>
              </Dialog>
              <Dialog
                open={openSuccess}
                onClose={handleCloseSuccess}
                aria-labelledby="alert-dialog-title"
                aria-describedby="alert-dialog-description"
              >
                <DialogTitle id="alert-dialog-title">{dialogTitle}</DialogTitle>
                <DialogContent>
                  <Typography align="justify" id="alert-dialog-description">
                    {dialogMessage}
                  </Typography>
                </DialogContent>
                <DialogActions>
                  <Button onClick={handleCloseSuccess} autoFocus>
                    Aceptar
                  </Button>
                </DialogActions>
              </Dialog>
            </Box>
          </Box>
        </form>
      </div>
    </div>
  );
}
