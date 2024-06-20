import React, { useEffect, useState } from "react";
import { URL_API } from '../http/const';

import AmbientesTableEliminar from "./AmbientesTableEliminar";

export default function ViewAmbientesEliminar() {
  const [ambientes, setAmbientes] = useState([]);

  useEffect(() => {
    fetch(`${URL_API}/ambiente`)
      .then((response) => response.json())
      .then((data) => setAmbientes(data))
      .catch((error) => console.error("Error:", error));
  }, []);

  return (
    <div>
      <div>
        <AmbientesTableEliminar ambientes={ambientes} />
      </div>
    </div>
  );
}
