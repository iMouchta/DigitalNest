import { React } from "react";
import { Link } from "react-router-dom";

function HomePage() {
  return (
    <div>
      <h1>Bienvenido a la pagina de inicio</h1>
      <p>Esta es la pagina de inicio de muestra</p>
      <div className="navigation-button">
        <Link to="/app/solicitudRapida">Solicitud rapida</Link>
      </div>
      <div className="navigation-button">
        <Link to="/app/SolicitudEspecial">Solicitud especial</Link>
      </div>
    </div>
  );
}

export default HomePage;
