import "./App.css";
import {
  BrowserRouter as Router,
  Route,
  Routes,
  Outlet,
} from "react-router-dom";
import { Link } from "react-router-dom";
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
            <ul>
              <li>
                <Link to="/">Inicio</Link>
              </li>
              <li>
                <Link to="/docente/solicitudRapida">Solicitud Rápida</Link>
              </li>
              <li>
                <Link to="/docente/solicitudEspecial">Solicitud Especial</Link>
              </li>
              <li>
                <Link to="/docente/responderSolicitud">Responder Solicitud</Link>
              </li>
              <li>
                <Link to="/docente/visualizarSolicitud">Visualizar Solicitud</Link>
              </li>
            </ul>
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
