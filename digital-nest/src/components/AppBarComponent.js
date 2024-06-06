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

export default function AppBarComponent() {
  const [numNotification, setNumNotification] = useState(0);
  const [notificationOpen, setNotificationOpen] = useState(null);
  const [notifications, setNotifications] = useState([]);

  useEffect(() => {
    fetch("http://localhost:8000/api/notificaciones/usuario/2")
      .then((response) => response.json())
      .then((data) => {
        const sortedData = data.sort((a, b) => a.vista - b.vista);
        setNotifications(sortedData);
        const unreadNotifications = sortedData.filter(notification => notification.vista === 0).length;
        setNumNotification(unreadNotifications);
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
      <AppBar position="static" sx={{ backgroundColor: "rgb(0, 123, 255)" }}>
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
          horizontal: "center",
        }}
        transformOrigin={{
          vertical: "top",
          horizontal: "center",
        }}
      >
        <Typography variant="h5" component="div" sx={{ padding: 2 }}>
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
