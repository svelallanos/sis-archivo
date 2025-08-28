window.addEventListener("load", () => {
  verifyCode(); // Ejecutar cuando se cargue la página
});

function verifyCode() {
  const formCode = document.getElementById("formSendCode");

  formCode.addEventListener("submit", function (e) {
    e.preventDefault();

    const formData = new FormData(formCode);
    const config = {
      method: "POST",
      body: formData,
    };

    const url = base_url + "/sendcode/verifyCode";

    fetch(url, config)
      .then((res) => {
        if (!res.ok) {
          throw new Error("Error al verificar código: " + res.statusText);
        }
        return res.json();
      })
      .then((data) => {
        toastr.options = {
          closeButton: true,
          progressBar: true,
          timeOut: "5000",
        };

        if (!data.status) {
          toastr[data.type](data.message, data.title);
          return;
        }

        //Guardar email en localStorage
        localStorage.setItem("reset_email", data.email);

        toastr[data.type](data.message, data.title);
        setTimeout(() => {
          window.location.href = data.redirection;
        }, 1000);
      })
      .catch((err) => {
        toastr["error"](
          "Error de red o de servidor: " + err.message,
          "Ocurrió un error inesperado"
        );
      });
  });
}



