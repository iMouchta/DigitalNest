import React, { useEffect, useState } from "react";
import List from "@mui/material/List";
import ListItem from "@mui/material/ListItem";
import ListItemButton from "@mui/material/ListItemButton";
import ListItemText from "@mui/material/ListItemText";
import Card from "@mui/material/Card";
import CardContent from "@mui/material/CardContent";
import Typography from "@mui/material/Typography";
import Collapse from "@mui/material/Collapse";
import ExpandLess from "@mui/icons-material/ExpandLess";
import ExpandMore from "@mui/icons-material/ExpandMore";
import SolicitudesTable from "./SolicitudesTable";

export default function ViewSolicitudes() {
  const [open, setOpen] = useState({});

  const handleClick = (id) => {
    setOpen((prev) => ({ ...prev, [id]: !prev[id] }));
  };
  const [data, setData] = useState([]);

  const [solicitudes, setSolicitudes] = useState([]);

  useEffect(() => {
    fetch('http://localhost:8000/solicitudes')
      .then(response => response.json())
      .then(data => setSolicitudes(data))
      .catch(error => console.error('Error:', error));
  }, []);

  const tmpData = [
    {
      id: 1,
      nombre: "Juan Perez",
      materia: "Matematicas",
      capacidad: 20,
      fecha: "2021-10-10",
      infoAdicional: "Información adicional 1",
    },
    {
      id: 2,
      nombre: "Maria Lopez",
      materia: "Fisica",
      capacidad: 15,
      fecha: "2021-10-11",
      infoAdicional: "Información adicional 2",
    },
    // ... más datos ...
  ];

  return (

    <div>
    <div>
      <SolicitudesTable />
    </div>
    {solicitudes.map((solicitud, index) => (
      <div key={index}>
        <p>Id Solicitud: {solicitud.idsolicitud}</p>
        <p>Id Materia: {solicitud.idmateria}</p>
        <p>Id Ambiente: {solicitud.idambiente}</p>
        <p>Capacidad Solicitud: {solicitud.capacidadsolicitud}</p>
        <p>Fecha Solicitud: {solicitud.fechasolicitud}</p>
        <p>Hora Inicial Solicitud: {solicitud.horainicialsolicitud}</p>
        <p>Hora Final Solicitud: {solicitud.horafinalsolicitud}</p>
        {/* Añade más campos según sea necesario */}
      </div>
    ))}
  </div>

    // <List
    //   sx={{
    //     width: "100%",
    //     maxWidth: 450,
    //     bgcolor: "background.paper",
    //     position: "relative",
    //     overflow: "auto",
    //     maxHeight: 600,
    //     "& ul": { padding: 0 },
    //   }}
    // >
    //   {tmpData.map((item) => (
    //     <div key={item.id}>
    //       <ListItemButton onClick={() => handleClick(item.id)}>
    //         <Card sx={{ width: "100%" }}>
    //           <CardContent>
    //             <Typography variant="body1">
    //               Nombre del docente: {item.nombre}
    //             </Typography>
    //             <Typography variant="body1">Aula: {item.aula}</Typography>
    //             <Typography variant="body1">Fecha: {item.fecha}</Typography>
    //             {open[item.id] ? <ExpandLess /> : <ExpandMore />}
    //           </CardContent>
    //           <Collapse in={open[item.id]} timeout="auto" unmountOnExit>
    //             <CardContent>
    //               <Typography variant="body1">
    //                 Capacidad: {item.capacidad}
    //               </Typography>
    //               <Typography variant="body1">Motivo: {item.motivo}</Typography>
    //               <Typography variant="body1">
    //                 Hora inicial: {item.horaInicial}
    //               </Typography>
    //               <Typography variant="body1">
    //                 Hora final: {item.horaFinal}
    //               </Typography>
    //               <Typography variant="body1">
    //                 Fecha de solicitud: {item.fechaSolicitud}
    //               </Typography>
    //               <Typography variant="body1">
    //                 Hora de solicitud: {item.horaSolicitud}
    //               </Typography>
    //             </CardContent>
    //           </Collapse>
    //         </Card>
    //       </ListItemButton>
    //     </div>
    //   ))}
    // </List>
  );
}
