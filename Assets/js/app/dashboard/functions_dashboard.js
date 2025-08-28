document.addEventListener("DOMContentLoaded", function () {
  // cargarTarjetas();
});

function cargarTarjetas() {
  fetch(base_url + "/Dashboard/resumenTarjetas")
    .then((response) => response.json())
    .then((data) => {
      const contenedor = document.getElementById("contenedorTarjetas");
      contenedor.innerHTML = "";
      data.forEach((tarjeta) => {
        contenedor.innerHTML += crearTarjeta(
          tarjeta.titulo,
          tarjeta.valor,
          tarjeta.color
        );
      });
    })
    .catch((error) => {
      console.error("Error al cargar las tarjetas:", error);
    });
}

function crearTarjeta(titulo, valor, color) {
  return `
    <div class="col-md-6 col-lg-3">
          <div class="widget-small ${color} coloured-icon">
            <i class="icon fa fa-users fa-3x"></i>
            <div class="info">
              <h5>${titulo}</h5>
              <p><b>${valor}</b></p>
            </div>
          </div>
    </div>
  `;
}
