window.addEventListener("load", () => {
  flippedFormLogin();
  rememberUser();
  verifyEmail(); // Funcion que se encarga de verificar el email del usuario
  login(); // Funcion que se encarga de enviar los datos del formulario de login
  setRemember();
});

function flippedFormLogin() {
  // Login Page Flipbox control
  $('.login-content [data-toggle="flip"]').click(function () {
    $(".login-box").toggleClass("flipped");
    return false;
  });
}
function login() {
  const formLogin = document.getElementById("formLogin");
  formLogin.addEventListener("submit", (e) => {
    e.preventDefault();
    const formData = new FormData(formLogin);
    const headers = new Headers();
    const config = {
      method: "POST",
      headers: headers,
      node: "no-cache",
      cors: "cors",
      body: formData,
    };
    const url = base_url + "/login/isLogIn"; // URL to send the form data
    fetch(url, config)
      .then((response) => {
        if (!response.ok) {
          throw new Error(
            "Error en la solicitud " +
            response.status +
            " - " +
            response.statusText
          );
        }
        return response.json();
      })
      .then((data) => {
        toastr.options = {
          closeButton: true,
          onclick: null,
          showDuration: "300",
          hideDuration: "1000",
          timeOut: "5000",
          progressBar: true,
          onclick: null,
        };
        if (!data.status) {
          //limpiar el formulario
          formLogin.reset();
          toastr[data.type](data.message, data.title);
          return false;
        }
        toastr[data.type](data.message, data.title);
        formLogin.reset();
        setTimeout(() => {
          window.location.href = data.redirection;
        }, 1000);
        return true;
      })
      .catch((error) => {
        toastr.options = {
          closeButton: true,
          timeOut: 0,
          onclick: null,
        };
        toastr["error"](
          "Error en la solicitud al servidor: " +
          error.message +
          " - " +
          error.name,
          "Ocurrio un error inesperado"
        );
      });
  });
}
//Funcion que se encarga de verificar si el usuario quiere recordar el usuario
function setRemember() {
  const chbxRemember = document.getElementById("chbxRemember");
  const txtUser = document.getElementById("txtUser");
  chbxRemember.addEventListener("change", () => {
    if (document.getElementById("chbxRemember").checked) {
      //Validamos que campo no este vacio
      if (txtUser.value === "") {
        toastr.options = {
          closeButton: true,
          timeOut: 0,
          onclick: null,
        };
        toastr["error"](
          "No se puede recordar el usuario cuando el campo usuario esta vacío",
          "Ocurrió un error inesperado"
        );
        document.getElementById("chbxRemember").checked = false;
        return false;
      }
      toastr.options = {
        closeButton: true,
        timeOut: 3000,
        onclick: null,
      };
      toastr["info"](
        "El usuario sera recordado a partir de ahora en adelante",
        "Mensaje de información"
      );
      localStorage.setItem("usuario", txtUser.value); // Guarda si se marca
    } else {
      toastr.options = {
        closeButton: true,
        timeOut: 3000,
        onclick: null,
      };
      toastr["info"]("El usuario no será recordado", "Atencion");
      localStorage.removeItem("usuario"); // Borra si no se marca
    }
  });
}
//Funcion que se encarga de recordar el usuario
function rememberUser() {
  const txtUser = document.getElementById("txtUser");
  const user = localStorage.getItem("usuario");
  if (user !== null) {
    txtUser.value = user;
    document.getElementById("chbxRemember").checked = true;
  }
}
// Funcion que se encarga de verificar el email del usuario
function verifyEmail() {
  const formForget = document.getElementById("formForget");
  formForget.addEventListener("submit", (e) => {
    e.preventDefault();

    const formData = new FormData(formForget);
    const config = {
      method: "POST",
      body: formData,
    };

    const url = base_url + "/login/verifyEmail"; // URL de tu controlador

    fetch(url, config)
      .then((response) => {
        if (!response.ok) {
          throw new Error(`Error HTTP ${response.status}`);
        }
        return response.json();
      })
      .then((data) => {
        toastr.options = {
          closeButton: true,
          timeOut: 5000,
          progressBar: true,
        };
        toastr[data.type](data.message, data.title);

        if (data.status && data.redirection) {
          setTimeout(() => {
            window.location.href = data.redirection;
          }, 1000);
        }
      })
      .catch((error) => {
        toastr.options = {
          closeButton: true,
          timeOut: 0,
        };
        toastr["error"](
          "No se pudo completar la solicitud: " + error.message,
          "Error inesperado"
        );
      });
  });
}

