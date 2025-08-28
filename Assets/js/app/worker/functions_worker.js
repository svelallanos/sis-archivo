let table;
let table_people;
window.addEventListener("DOMContentLoaded", (e) => {
  loadTable();
  setTimeout(() => {
    saveData();
    loadReport();
    loadWorkerUpdate();
    confirmationDelete();
    deleteData();
    updateData();
    searchData();
    openModalPeople();
    cancelForm();
    loadTablePeople();
  }, 1000);
});

function cancelForm() {
  $("#btnCancel").on("click", function () {
    $("#formSave")[0].reset();
    $("#profileCard").html("");
  });
}

function openModalPeople() {
  $("#openModalPeople").click(() => {
    $("#modalListPeople").modal("show");
  });
}

// Función que carga la tabla con los datos
function loadTable() {
  table = $("#table").DataTable({
    aProcessing: true,
    aServerSide: true,
    ajax: {
      url: "" + base_url + "/Worker/getWorker",
      dataSrc: "",
    },
    columns: [
      { data: "cont", className: "text-center" },
      { data: "fullname" },
      { data: "dni", className: "text-center" },
      { data: "phone" },
      { data: "jobtitle", className: "text-center" },
      { data: "account" },
      { data: "status_badge", className: "text-center" }, //agregado
      { data: "actions", className: "text-center" },
    ],
    dom: "lBfrtip",
    buttons: [
      {
        extend: "copyHtml5",
        text: "<i class='fa fa-copy'></i> Copiar",
        titleAttr: "Copiar",
        className: "btn btn-secondary",
        exportOptions: {},
      },
      {
        extend: "excelHtml5",
        text: "<i class='fa fa-table'></i> Excel",
        title: "Reporte de Trabajadores en Excel",
        className: "btn btn-success",
        exportOptions: {},
      },
      {
        extend: "csvHtml5",
        text: "<i class='fa fa-file-text'></i> CSV",
        title: "Reporte de Trabajadores en CSV",
        className: "btn btn-info",
        exportOptions: {},
      },
      {
        extend: "pdfHtml5",
        text: "<i class='fa fa-file-pdf'></i> PDF",
        title: "Reporte de Trabajadores en PDF",
        className: "btn btn-danger",
        orientation: "landscape",
        pageSize: "LEGAL",
        exportOptions: {},
      },
    ],

    responsive: "true",
    processing: true,
    bProcessing: true, //bProscessing: true,
    destroy: true,
    iDisplayLength: 10,
    order: [[0, "asc"]],
    language: {
      url: base_url + "/Assets/js/libraries/Spanish-datatables.json",
    },
    fnDrawCallback: function () {
      confirmationDelete();
      loadReport();
      loadWorkerUpdate();
    },
  });
}
// Función que guarda los datos en la base de datos
function saveData() {
  const formSave = document.getElementById("formSave");
  formSave.addEventListener("submit", (e) => {
    e.preventDefault();
    const formData = new FormData(formSave);
    const header = new Headers();
    const config = {
      method: "POST",
      headers: header,
      node: "no-cache",
      cors: "cors",
      body: formData,
    };
    const url = base_url + "/Worker/setWorker";
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
          //onclick: null,
        };
        if (!data.status) {
          toastr[data.type](data.message, data.title);
          return false;
        }
        //limpiar el formulario
        formSave.reset();
        //ocultar el modal abierto
        $("#modalSave").modal("hide");
        //actualizar la tabla
        table.ajax.reload(null, false);
        toastr[data.type](data.message, data.title);
        document.getElementById("profileCard").innerHTML = ``; // Limpiar el card de perfil
        //recargar las funciones
        setTimeout(() => {
          confirmationDelete();
          loadReport();
        }, 500);
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

function loadTablePeople() {
  table_people = $("#table_people").DataTable({
    aProcessing: true,
    aServerSide: true,
    ajax: {
      url: "" + base_url + "/Worker/getPeople",
      dataSrc: "",
    },
    columns: [
      { data: "numberDocument", className: "col-1 text-center" },
      { data: "fullname" },
      { data: "actions", className: "col-1 text-center" },
    ],
    responsive: "true",
    destroy: true,
    iDisplayLength: 10,
    order: [[0, "asc"]],
    language: {
      url: base_url + "/Assets/js/libraries/Spanish-datatables.json",
    },
    info: false,
  });

  $(document).on("click", ".btn-success", function () {
  const dni = $(this).data("dni");

  if ($("#modalSave").hasClass("show")) {
    $("#txtDni").val(dni);
    $("#btnSearch").trigger("click");
  } else if ($("#modalUpdate").hasClass("show")) {
    $("#update_txtDni").val(dni);
    $("#btnSearch").trigger("click");
  }

  $("#modalListPeople").modal("hide");
});

}
//Funcion que carga los datos en el reporte del modal del registro seleccionado
function loadReport() {
  const btnReportItem = document.querySelectorAll(".report-item");
  btnReportItem.forEach((item) => {
    item.addEventListener("click", (e) => {
      e.preventDefault();
      ///obtenemos los atributos del btn update y los almacenamos en una constante data-id="' . $value["id"] . '" data-fullname="' . $value["fullname"] . '" data-dni="' . $value["dni"] . '" data-gender="' . $value["gender"] . '" data-birthdate="' . $value["birthdate"] . '" data-phone="' . $value["phone"] . '" data-address="' . $value["address"] . '" data-profile="' . $value["profile"] . '" data-mail="' . $value["mail"] . '" data-status="' . $value['status'] . '"   data-registrationDate="' . dateFormat($value['dateRegistration']) . '" data-updateDate="' . dateFormat($value['dateUpdate']) . '"
      const id = item.getAttribute("data-id");
      const photo = item.getAttribute("data-imgProfile");
      const typePeople = item.getAttribute("data-typepeople");
      const name = item.getAttribute("data-name");
      const lastname = item.getAttribute("data-lastname");
      const fullnamecal = item.getAttribute("data-fullname");
      const dni = item.getAttribute("data-dni");
      const birthdate = item.getAttribute("data-birthdate");
      const gender = item.getAttribute("data-gender");
      const mail = item.getAttribute("data-mail");
      const phone = item.getAttribute("data-phone");
      const address = item.getAttribute("data-address");
      const account = item.getAttribute("data-account");
      const account2 = item.getAttribute("data-account2");
      const account3 = item.getAttribute("data-account3");
      const account4 = item.getAttribute("data-account4");
      const jobtitle = item.getAttribute("data-jobtitle");
      const status = item.getAttribute("data-status");
      const registrationDate = item.getAttribute("data-registrationDate");
      const updateDate = item.getAttribute("data-updateDate");

      let fullname = "";
      if (typePeople === "NATURAL") {
        fullname = `${name} ${lastname}`;
      } else {
        fullname = fullnamecal;
      }

      //asignamos los valores obtenidos a los campos del modal
      document.getElementById("reportTitle").innerHTML = fullname;
      document.getElementById("reportPhotoProfile").src = photo;
      document.getElementById("reportCodeCustomer").innerHTML = id;
      document.getElementById("reportStatusCustomer").innerHTML = status;
      document.getElementById("reportDni").innerHTML = dni;
      document.getElementById("reportBirthdate").innerHTML = birthdate;
      document.getElementById("reportGender").innerHTML = gender;
      document.getElementById("reportEmail").innerHTML = mail;
      document.getElementById("reportPhone").innerHTML = phone;
      document.getElementById("reportAddress").innerHTML = address;
      document.getElementById("reportNumberAccount").innerHTML = account;
      document.getElementById("reportNumberAccount2").innerHTML = account2;
      document.getElementById("reportNumberAccount3").innerHTML = account3;
      document.getElementById("reportNumberAccount4").innerHTML = account4;
      document.getElementById("reportJobTitle").innerHTML = jobtitle;
      document.getElementById("reportRegistrationDate").innerHTML =
        registrationDate;
      document.getElementById("reportUpdateDate").innerHTML = updateDate;

      //abrir el modal
      $("#modalReport").modal("show");
    });
  });
}
// Función que confirma la eliminación
function confirmationDelete() {
  const arrBtnDeleteItem = document.querySelectorAll(".delete-item");
  arrBtnDeleteItem.forEach((item) => {
    item.addEventListener("click", (e) => {
      //obtenemos los atributos del btn delete y los almacenamos en una constante
      const name = item.getAttribute("data-fullname");
      const id = item.getAttribute("data-id");
      //Preguntamos en el modal si esta seguro de eliminar elar el registro
      document.getElementById("txtDelete").innerHTML =
        "¿Está seguro de eliminar el trabajador <strong>" + name + " </strong>?";
      //Asiganamos los valores obtenidos y los enviamos a traves de un atributo dentro del btn de confirmacion de eliminar
      const confirmDelete = document.getElementById("confirmDelete");
      confirmDelete.setAttribute("data-id", id);
      confirmDelete.setAttribute("data-fullname", name);
      //abrimos el modal de confirmacion
      $("#confirmModalDelete").modal("show");
    });
  });
}
// Función que se encarga de eliminar un registro
function deleteData() {
  const confirmDelete = document.getElementById("confirmDelete");
  confirmDelete.addEventListener("click", (e) => {
    e.preventDefault();
    //recibimos las variables del atributo del btn de confirmacion de eliminar en sus constantes
    const id = confirmDelete.getAttribute("data-id");
    const name = confirmDelete.getAttribute("data-fullname");
    const token = confirmDelete.getAttribute("data-token");
    //creamos un array con los valores recuperados
    const arrValues = {
      id: id,
      name: name,
      token: token,
    };
    const header = { "Content-Type": "application/json" };
    const config = {
      method: "DELETE",
      headers: header,
      body: JSON.stringify(arrValues),
    };
    //La ruta donde se apunta del controlador
    const url = base_url + "/Worker/deleteWorker";
    fetch(url, config)
      .then((response) => {
        if (!response.ok) {
          throw new Error(
            "Error en la solicitud" +
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
          toastr[data.type](data.message, data.title);
          return false;
        }
        //ocultar el modal abierto
        $("#confirmModalDelete").modal("hide");
        //actualizar la tabla
        table.ajax.reload(null, false);
        toastr[data.type](data.message, data.title);
        ///recargar las funciones
        setTimeout(() => {
          confirmationDelete();
          loadReport();
        }, 500);
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
//funcion que busca los datos de una persona por su dni
function searchData() {
  const btnSearch = document.getElementById("btnSearch");
  btnSearch.addEventListener("click", (e) => {
    e.preventDefault();
    const dni = document.getElementById("txtDni").value;
    if (dni === "") {
      toastr["warning"]("Ingrese un DNI para buscar", "Advertencia");
      return false;
    }
    const url = base_url + "/Worker/searchPeople?dni=" + dni;
    fetch(url)
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
        if (!data.status) {
          toastr[data.type](data.message, data.title);
          return false;
        }

        const person = data.info.people;
        const cardPeople = document.getElementById("profileCard");

        cardPeople.innerHTML = ` 
                        <img src="${data.info.profile}" alt="Foto de perfil" class="profile-img" style="width: 150px; height: 150px; border-radius: 50%;">
                            <div class="card-body">
                                <h3 class="card-title text-center mb-4"><i class="fa fa-user-circle"></i> ${person.fullname}</h3>
                                </h3>

                                <div class="info-row">
                                    <i class="fa fa-id-badge text-primary info-icon"></i> <strong>CODP:</strong> ${person.id}
                                </div>
                                <div class="info-row">
                                    <i class="fa fa-id-card text-primary info-icon"></i> <strong>NUMERO DE DOCUMENTO:</strong> ${person.numberDocument}
                                </div>
                                <div class="info-row">
                                    <i class="fa fa-birthday-cake text-primary info-icon"></i> <strong>Fecha de
                                        Nacimiento:</strong> ${person.birthdate}
                                </div>
                                <div class="info-row">
                                    <i class="fa fa-venus-mars text-primary info-icon"></i> <strong>Género:</strong>
                                    ${person.birthdate}
                                </div>
                                <div class="info-row">
                                    <i class="fa fa-envelope text-primary info-icon"></i> <strong>Email:</strong> <a
                                        href="mailto:${person.mail}">${person.mail}</a>
                                </div>
                                <div class="info-row">
                                    <i class="fa fa-phone text-primary info-icon"></i> <strong>Teléfono:</strong>
                                    ${person.phone}
                                </div>
                                <div class="info-row">
                                    <i class="fa fa-map-marker text-primary info-icon"></i> <strong>Dirección:</strong>
                                    ${person.address}
                                </div>
                                <hr>
                                <div class="info-row">
                                    <i class="fa fa-calendar-plus-o text-primary info-icon"></i>
                                    <strong>Registro:</strong> ${person.dateRegistration}
                                </div>
                                <div class="info-row">
                                    <i class="fa fa-calendar-check-o text-primary info-icon"></i> <strong>Última
                                        Actualización:</strong> ${person.dateUpdate}
                                </div>
                                <div class="info-row text-center mt-4">
                                    <span class="badge badge-success"><i class="fa fa-check-circle"></i> ${person.status}</span>
                                </div>
                            </div>
                            <input type="hidden" id="txtId" name="txtId" value="${person.id}">
                            `;

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

function searchDataUpdate(dni) {

  const url = base_url + "/Worker/searchPeopleUpdate?dni=" + dni;
  fetch(url)
    .then((response) => {
      if (!response.ok) {
        throw new Error("Error en la solicitud " + response.status + " - " + response.statusText);
      }
      return response.json();
    })
    .then((data) => {
      if (!data.status) {
        toastr[data.type](data.message, data.title);
        return false;
      }
      const person = data.info.people;
      const cardPeople = document.getElementById("update_profileCard");
      cardPeople.innerHTML = ` <!-- Imagen de perfil grande -->
                            <img src="${data.info.profile}" alt="Foto de perfil" class="profile-img" style="width: 150px; height: 150px; border-radius: 50%;">
                            <div class="card-body">
                                <h3 class="card-title text-center mb-4"><i class="fa fa-user-circle"></i> ${person.fullname}</h3>
                                </h3>

                                <div class="info-row">
                                    <i class="fa fa-id-badge text-primary info-icon"></i> <strong>CODP:</strong> ${person.id}
                                </div>
                                <div class="info-row">
                                    <i class="fa fa-id-card text-primary info-icon"></i> <strong>NÚMERO DE DOCUMENTO:</strong> ${person.numberDocument}
                                </div>
                                <div class="info-row">
                                    <i class="fa fa-birthday-cake text-primary info-icon"></i> <strong>Fecha de
                                        Nacimiento:</strong> ${person.birthdate}
                                </div>
                                <div class="info-row">
                                    <i class="fa fa-venus-mars text-primary info-icon"></i> <strong>Género:</strong>
                                    ${person.gender}
                                </div>
                                <div class="info-row">
                                    <i class="fa fa-envelope text-primary info-icon"></i> <strong>Email:</strong> <a
                                        href="mailto:${person.mail}">${person.mail}</a>
                                </div>
                                <div class="info-row">
                                    <i class="fa fa-phone text-primary info-icon"></i> <strong>Teléfono:</strong>
                                    ${person.phone}
                                </div>
                                <div class="info-row">
                                    <i class="fa fa-map-marker text-primary info-icon"></i> <strong>Dirección:</strong>
                                    ${person.address}
                                </div>
                                <hr>
                                <div class="info-row">
                                    <i class="fa fa-calendar-plus-o text-primary info-icon"></i>
                                    <strong>Registro:</strong> ${person.dateRegistration}
                                </div>
                                <div class="info-row">
                                    <i class="fa fa-calendar-check-o text-primary info-icon"></i> <strong>Última
                                        Actualización:</strong> ${person.dateUpdate}
                                </div>
                                <div class="info-row text-center mt-4">
                                    <span class="badge badge-success"><i class="fa fa-check-circle"></i> ${person.status}</span>
                                </div>
                            </div>
                            <input type="hidden" id="txtId" name="txtId" value="${person.id}">
                            `;

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
}

function loadWorkerUpdate() {
  const btnUpdateItem = document.querySelectorAll(".update-item");
  btnUpdateItem.forEach((item) => {
    item.addEventListener("click", (e) => {
      e.preventDefault();

      //obtenemos los valores de los atributos del
      const id = item.getAttribute("data-id");
      const idPeople = item.getAttribute("data-idPeople");
      const dni = item.getAttribute("data-dni");
      const account = item.getAttribute("data-account");
      const jobtitle = item.getAttribute("data-jobtitle");
      const status = item.getAttribute("data-status");
      const account2 = item.getAttribute("data-account2");
      const account3 = item.getAttribute("data-account3");
      const account4 = item.getAttribute("data-account4");


      // Preparamos los elementos del formularios para actualizar y asiganamos valores

      document.getElementById("update_txtId").value = id;

      document.getElementById("update_txtIdPeople").value = idPeople;
      document.getElementById("update_txtDni").value = dni;
      document.getElementById("update_txtAccountnumber").value = account;
      document.getElementById("update_selectJobtitle").value = jobtitle;
      document.getElementById("update_slctStatus").value = status;
      document.getElementById("update_txtAccountnumber2").value = account2;
      document.getElementById("update_txtAccountnumber3").value = account3;
      document.getElementById("update_txtAccountnumber4").value = account4;
      searchDataUpdate(dni);
      //abrir el modal
      document.getElementById("update_profileCard").innerHTML = ""; // Limpia antes de mostrar
      $("#modalUpdate").modal("show");

    });
  });
}


// Función que actualiza los datos en la base de datos
function updateData() {
  const formUpdate = document.getElementById("formUpdate");
  formUpdate.addEventListener("submit", (e) => {
    e.preventDefault();
    const formData = new FormData(formUpdate);
    const header = new Headers();
    const config = {
      method: "POST",
      headers: header,
      node: "no-cache",
      cors: "cors",
      body: formData,
    };
    const url = base_url + "/Worker/updateWorker";
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
          //onclick: null,
        };
        if (!data.status) {
          toastr[data.type](data.message, data.title);
          return false;
        }
        //limpiar el formulario
        formUpdate.reset();
        //ocultar el modal abierto
        $("#modalUpdate").modal("hide");
        //actualizar la tabla
        table.ajax.reload(null, false);
        toastr[data.type](data.message, data.title);
        document.getElementById("profileCard").innerHTML = ``; // Limpiar el card de perfil
        //recargar las funciones
        setTimeout(() => {
          confirmationDelete();
          loadWorkerUpdate();
          loadReport();
        }, 500);
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
