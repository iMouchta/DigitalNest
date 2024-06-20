import {
  AppBar,
  Badge,
  Box,
  IconButton,
  Toolbar,
  Typography,
  Popover,
  List,
  ListItem,
  ListItemText,
} from "@mui/material";
import NotificationsIcon from "@mui/icons-material/Notifications";
import { useState, useEffect } from "react";
import NotificationDisplay from "./NotificationDisplay";
import { URL_API } from '../http/const';

export default function AppBarComponent() {
  const [numNotification, setNumNotification] = useState(0);
  const [notificationOpen, setNotificationOpen] = useState(null);
  const [notifications, setNotifications] = useState([]);

  useEffect(() => {
    fetch(`${URL_API}/notificaciones/usuario/1`)
      .then((response) => response.json())
      .then((data) => {
        const sortedData = data.sort((a, b) => {
          if (a.vista === b.vista) {
           
            return b.idnotificacion - a.idnotificacion;
          } else {
            return a.vista - b.vista;
          }
        });
        
        setNotifications(sortedData);
        
        const unreadNotifications = sortedData.filter(
          (notification) => notification.vista === 0
        ).length;
        
        setNumNotification(unreadNotifications);
        fetch(`${URL_API}/verNotificaciones`, {
          method: "POST",
          headers: {
            "Content-Type": "application/json",
          },
          body: JSON.stringify({
            idUsuario: 1,
          }),
        })
          .then((response) => response.json())
          .then((data) => {
            console.log(data);
          })
          .catch((error) => {
            console.error("Error:", error);
          });
      })
      .catch((error) => {
        console.error("Error:", error);
      });
  }, []);

  const handleClickNotification = (event) => {
    setNotificationOpen(event.currentTarget);
  };

  const handleCloseNotification = () => {
    setNotificationOpen(null);
  };

  const open = Boolean(notificationOpen);
  const id = open ? "simple-popover" : undefined;

  return (
    <Box sx={{ flexGrow: 1 }}>
      <AppBar position="fixed" sx={{ backgroundColor: "rgb(0, 91, 150)" }}>
        <Toolbar>
          <Typography variant="h6" component="div" sx={{ flexGrow: 1 }}>
            Digital Nest
          </Typography>
          <IconButton color="inherit" onClick={handleClickNotification}>
            <Badge badgeContent={numNotification} color="error">
              <NotificationsIcon />
            </Badge>
          </IconButton>
        </Toolbar>
      </AppBar>
      <Popover
        id={id}
        open={open}
        anchorEl={notificationOpen}
        onClose={handleCloseNotification}
        anchorOrigin={{
          vertical: "bottom",
          horizontal: "right",
        }}
        transformOrigin={{
          vertical: "top",
          horizontal: "right",
        }}
        PaperProps={{
          style: { maxHeight: "50vh", overflow: "auto" },
        }}
      >
        <Typography
          variant="h5"
          component="div"
          sx={{ marginTop: 2, marginLeft: 2, fontWeight: "bold" }}
        >
          Notificaciones
        </Typography>
        <List>
          {notifications.map((notification) => (
            <NotificationDisplay
              key={notification.idnotificacion}
              notificationText={notification.mensaje}
              isUnread={notification.vista == 0}
            />
          ))}
        </List>
      </Popover>
    </Box>
  );
}
