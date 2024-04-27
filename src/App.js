import "./App.css";
import {
  BrowserRouter as Router,
  Route,
  Routes,
  Outlet,
} from "react-router-dom";

import HomePage from "./pages/HomePage.js";
import SolicitudRapidaPage from "./pages/SolicitudRapidaPage.js";
import SolicitudEspecialPage from "./pages/SolicitudEspecialPage.js";

function App() {
  return (
    <div className="App">
      <Router>
        <Routes>
          {/* Remplazar la ruta inicial */}
          <Route path="/" element={<HomePage />} />
          {/* Reservador para la pagina de login */}
          {/* <Route path="/login" element={<LoginPage />} /> */}
          <Route path="/app" element={<AppLayout />}>
            <Route path="home" element={<HomePage />} />
            <Route path="solicitudRapida" element={<SolicitudRapidaPage />} />
            <Route
              path="solicitudEspecial"
              element={<SolicitudEspecialPage />}
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
      <div className="barra-superior">
        <h1>Barra superior</h1>
      </div>
      <div className="contenido-principal">
        <div className="barra-lateral">
          <h1>Barra lateral</h1>
        </div>
        <div className="contenido">
          <Outlet />
        </div>
      </div>
      <div className="barra-inferior">
        <h1>Barra inferior</h1>
      </div>
    </div>
  );
}

export default App;
