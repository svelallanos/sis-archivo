window.addEventListener("load", () => {
  changePassword();
});

function changePassword() {
  const form = document.getElementById("formResetPass");

  form.addEventListener("submit", function (e) {
    e.preventDefault();

    // Recuperar el código desde el campo oculto
    const code = document.getElementById("code").value;

    if (!code) {
      toastr["error"]("Código inválido o expirado. Solicita uno nuevo.", "Error");
      return;
    }

    const formData = new FormData(form);
    formData.append("code", code);

    fetch(base_url + "/resetpassword/changePassword", {
      method: "POST",
      body: formData,
    })
      .then((res) => res.json())
      .then((data) => {
        toastr.options = {
          closeButton: true,
          progressBar: true,
          timeOut: "5000",
        };

        toastr[data.type](data.message, data.title);

        if (data.status) {
          localStorage.removeItem("reset_code"); // Eliminar el código guardado
          setTimeout(() => {
            window.location.href = base_url + "/login";
          }, 1500);
        }
      })
      .catch((err) => {
        toastr["error"]("Error inesperado: " + err.message, "Servidor");
      });
  });
}
