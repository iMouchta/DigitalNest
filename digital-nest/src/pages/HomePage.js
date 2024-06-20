import { React } from "react";
import { Link } from "react-router-dom";
import "./HomePage.css"; // Asegúrate de crear este archivo CSS en la misma carpeta que HomePage.js

function HomePage() {
  return (
    <div class="home-container">
      <div className="home-page">
        <h1>Bienvenido al Sistema de Reserva de Ambientes</h1>
        <p>
          Este sistema te permite realizar solicitudes rápidas de manera
          eficiente y sencilla. Haz clic en el botón de abajo para comenzar.
        </p>
        <div className="navigation-button">
          <Link to="/docente/solicitudRapida">Ingresar al Sistema</Link>
        </div>
      </div>
    </div>
  );
}

export default HomePage;
