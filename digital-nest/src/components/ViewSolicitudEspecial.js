import React from "react";
import { Button, Card, CardContent, CardActions, Typography, List, ListItem } from "@mui/material";

const data = [
  // Aquí puedes agregar tus datos
  { text: "Texto 1", id: 1 },
  { text: "Texto 2", id: 2 },
  { text: "Texto 3", id: 3 },
  { text: "Texto 4", id: 4},
  { text: "Texto 5", id: 5 },
  
  // ...
];

export default function ViewSolicitudEspecial() {
  return (
    <List>
      {data.map((item) => (
        <ListItem key={item.id}>
          <Card>
            <CardContent>
              <Typography variant="body1">Titular: {item.text}</Typography>
              <Typography variant="body1">Fecha: {item.text}</Typography>
              <Typography variant="body1">Motivo: {item.text}</Typography>
            </CardContent>
            <CardActions>
              <Button size="small">Rechazar</Button>
              <Button size="small">Aprobar</Button>
            </CardActions>
          </Card>
        </ListItem>
      ))}
    </List>
  );
}