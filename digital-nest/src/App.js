import "./App.css";
import {
  BrowserRouter as Router,
  Route,
  Routes,
  Outlet,
} from "react-router-dom";
import List from "@mui/material/List";
import ListItem from "@mui/material/ListItem";
import ListItemText from "@mui/material/ListItemText";
import ListItemIcon from "@mui/material/ListItemIcon";
import HomeIcon from "@mui/icons-material/Home";
import FastForwardIcon from "@mui/icons-material/FastForward";
import SpecialIcon from "@mui/icons-material/Star";
import ReplyIcon from "@mui/icons-material/Reply";
import VisibilityIcon from "@mui/icons-material/Visibility";
import { Link as RouterLink } from "react-router-dom";
import NotificationsIcon from "@mui/icons-material/Notifications";

import PrimarySearchAppBar from "./components/AppBar";
import HomePage from "./pages/HomePage.js";
import SolicitudRapidaPage from "./pages/SolicitudRapidaPage.js";
import SolicitudEspecialPage from "./pages/SolicitudEspecialPage.js";
import ResponderSolicitudPage from "./pages/ResponderSolicitudPage.js";
import VisualizarSolicitudPage from "./pages/VisualizarSolicitudPage.js";
import EnviarNotificacionPage from "./pages/EnviarNotificacionPage.js";
import RegistrarAmbientePage from "./pages/RegistrarAmbientePage.js";
import VisualizarAmbientePage from "./pages/VisualizarAmbientePage.js";

function App() {
  return (
    <div className="App">
      <PrimarySearchAppBar />
      <Router>
        <Routes>
          {/* Remplazar la ruta inicial */}
          <Route path="/" element={<HomePage />} />
          <Route path="*" element={<h1>Not Found</h1>} />
          {/* Reservador para la pagina de login */}
          {/* <Route path="/login" element={<LoginPage />} /> */}
          <Route path="/docente" element={<AppLayout />}>
            <Route path="*" element={<h1>Not Found</h1>} />
            <Route path="home" element={<HomePage />} />
            <Route path="solicitudRapida" element={<SolicitudRapidaPage />} />
            <Route
              path="solicitudEspecial"
              element={<SolicitudEspecialPage />}
            />
            <Route
              path="responderSolicitud"
              element={<ResponderSolicitudPage />}
            />
            <Route
              path="visualizarSolicitud"
              element={<VisualizarSolicitudPage />}
            />
            <Route
              path="enviarNotificacion"
              element={<EnviarNotificacionPage />}
            />
            <Route
              path="registrarAmbiente"
              element={<RegistrarAmbientePage />}
            />
            <Route
              path="visualizarAmbiente"
              element={<VisualizarAmbientePage />}
            />
          </Route>

          <Route path="/administrador" element={<HomePage />}>
            <Route path="*" element={<h1>Not Found</h1>} />
            <Route path="home" element={<HomePage />} />
            <Route
              path="responderSolicitud"
              element={<ResponderSolicitudPage />}
            />
          </Route>
        </Routes>
      </Router>
    </div>
  );
}

function AppLayout() {
  return (
    <div className="app-layout">
      <div className="contenido-principal">
        <div className="barra-lateral">
          <h1>Sistema de Reserva de Ambientes</h1>
          <nav>
            <List component="nav">
              <ListItem button component={RouterLink} to="/">
                <ListItemIcon>
                  <HomeIcon />
                </ListItemIcon>
                <ListItemText primary="Inicio" />
              </ListItem>
              <ListItem
                button
                component={RouterLink}
                to="/docente/solicitudRapida"
              >
                <ListItemIcon>
                  <FastForwardIcon />
                </ListItemIcon>
                <ListItemText primary="Solicitud Rápida" />
              </ListItem>
              <ListItem
                button
                component={RouterLink}
                to="/docente/solicitudEspecial"
              >
                <ListItemIcon>
                  <SpecialIcon />
                </ListItemIcon>
                <ListItemText primary="Solicitud Especial" />
              </ListItem>
              <ListItem
                button
                component={RouterLink}
                to="/docente/responderSolicitud"
              >
                <ListItemIcon>
                  <ReplyIcon />
                </ListItemIcon>
                <ListItemText primary="Atender Solicitudes" />
              </ListItem>
              <ListItem
                button
                component={RouterLink}
                to="/docente/visualizarSolicitud"
              >
                <ListItemIcon>
                  <VisibilityIcon />
                </ListItemIcon>
                <ListItemText primary="Visualizar Reservas" />
              </ListItem>
              <ListItem
                button
                component={RouterLink}
                to="/docente/enviarNotificacion"
              >
                <ListItemIcon>
                  <NotificationsIcon />
                </ListItemIcon>
                <ListItemText primary="Escribir Notificación" />
              </ListItem>
              <ListItem
                button
                component={RouterLink}
                to="/docente/registrarAmbiente"
              >
                <ListItemIcon>
                  <NotificationsIcon />
                </ListItemIcon>
                <ListItemText primary="Registrar Ambiente" />
              </ListItem>
              <ListItem
                button
                component={RouterLink}
                to="/docente/visualizarAmbiente"
              >
                <ListItemIcon>
                  <NotificationsIcon />
                </ListItemIcon>
                <ListItemText primary="Visualizar Ambientes" />
              </ListItem>
            </List>
          </nav>
        </div>
        <div className="contenido">
          <Outlet />
        </div>
      </div>
      <div className="barra-inferior">
        <h1></h1>
      </div>
    </div>
  );
}

export default App;
