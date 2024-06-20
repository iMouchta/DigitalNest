import React, { useEffect, useState } from "react";
import { URL_API } from '../http/const';

import AmbientesTableEditar from "./AmbientesTableEditar";

export default function ViewAmbientesEditar() {
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
        <AmbientesTableEditar ambientes={ambientes} />
      </div>
    </div>
  );
}
