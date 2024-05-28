import React from "react";
import FormRegistrarAmbiente from "../components/FormRegistrarAmbiente.js";

function RegistrarAmbientePage() {
  return (
    <div>
      <h1>Registrar Ambiente</h1>
      <div style={{ display: 'flex', justifyContent: 'center', alignItems: 'center', paddingTop: '20px', paddingBottom: '10px' }}>
        <FormRegistrarAmbiente/>
      </div>
    </div>
  );
}

export default RegistrarAmbientePage;
