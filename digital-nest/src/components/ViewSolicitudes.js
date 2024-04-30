import React, { useEffect, useState } from "react";
import {
  Button,
  Card,
  CardContent,
  CardActions,
  Typography,
  List,
  ListItem,
} from "@mui/material";

const data = [
  {
    nombre: "Leticia Blanco Coca",
    materia: "Taller de Software",
    capacidad: "50",
    fecha: "20-05-2024",
    horaInicial: "6:45",
    horaFinal: "8:15",
    motivo: "Primer parcial",
  },
  {
    nombre: "Luisa Fernanda",
    materia: "Programacion",
    capacidad: "50",
    fecha: "20-05-2024",
    horaInicial: "6:45",
    horaFinal: "8:15",
    motivo: "Primer parcial",
  },
  {
    nombre: "Pablito Perez",
    materia: "Programacion",
    capacidad: "50",
    fecha: "20-05-2024",
    horaInicial: "6:45",
    horaFinal: "8:15",
    motivo: "Primer parcial",
  },
  {
    nombre: "Jose Orosco",
    materia: "Programacion",
    capacidad: "50",
    fecha: "20-05-2024",
    horaInicial: "6:45",
    horaFinal: "8:15",
    motivo: "Primer parcial",
  },
];

export default function VisualizarSolicitudPage() {
  const [solicitdData, setSolicitudData] = useState([]);

  // useEffect(() => {
  //   fetch('http://localhost:8000/api/ruta-a-tu-endpoint')
  //     .then(response => response.json())
  //     .then(data => setData(data));
  // }, []);
  return (
    <div className="visualizar-solicitud-page">
      <List>
        {data.map((item) => (
          <ListItem key={item.id}>
            <Card>
              <CardContent>
                <Typography variant="body1">
                  Nombre del docente: {item.nombre}
                </Typography>
                <Typography variant="body1">Materia: {item.materia}</Typography>
                <Typography variant="body1">
                  Capacidad: {item.capacidad}
                </Typography>
                <Typography variant="body1">Fecha: {item.fecha}</Typography>
                <Typography variant="body1">
                  Hora Inicial: {item.horaInicial}
                </Typography>
                <Typography variant="body1">
                  Hora Final: {item.horaFinal}
                </Typography>
                <Typography variant="body1">Motivo: {item.motivo}</Typography>
              </CardContent>
            </Card>
          </ListItem>
        ))}
      </List>
    </div>
  );
}
