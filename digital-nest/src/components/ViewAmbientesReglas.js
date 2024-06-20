import React, { useEffect, useState } from "react";
import { URL_API } from '../http/const';

import AmbientesTableReglas from "./AmbientesTableReglas";

export default function ViewAmbientesReglas() {
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
        <AmbientesTableReglas ambientes={ambientes} />
      </div>
    </div>
  );
}
