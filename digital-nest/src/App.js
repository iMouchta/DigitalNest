import "./App.css";
import {
  BrowserRouter as Router,
  Route,
  Routes,
  Outlet,
} from "react-router-dom";
import List from '@mui/material/List';
import ListItem from '@mui/material/ListItem';
import ListItemText from '@mui/material/ListItemText';
import { Link as RouterLink } from 'react-router-dom';

import PrimarySearchAppBar from "./components/AppBar";
import HomePage from "./pages/HomePage.js";
import SolicitudRapidaPage from "./pages/SolicitudRapidaPage.js";
import SolicitudEspecialPage from "./pages/SolicitudEspecialPage.js";
import ResponderSolicitudPage from "./pages/ResponderSolicitudPage.js";
import VisualizarSolicitudPage from "./pages/VisualizarSolicitudPage.js";

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
          <h1>Menú</h1>
          <nav>
            <List component="nav">
              <ListItem button component={RouterLink} to="/">
                <ListItemText primary="Inicio" />
              </ListItem>
              <ListItem button component={RouterLink} to="/docente/solicitudRapida">
                <ListItemText primary="Solicitud Rápida" />
              </ListItem>
              <ListItem button component={RouterLink} to="/docente/solicitudEspecial">
                <ListItemText primary="Solicitud Especial" />
              </ListItem>
              <ListItem button component={RouterLink} to="/docente/responderSolicitud">
                <ListItemText primary="Responder Solicitud" />
              </ListItem>
              <ListItem button component={RouterLink} to="/docente/visualizarSolicitud">
                <ListItemText primary="Visualizar Solicitud" />
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
