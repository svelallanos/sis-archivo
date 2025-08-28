let table;
$(window).on("load", function () {
  setupImageUpload({
    dropAreaId: "drop-area",
    inputFileId: "flPhoto",
    previewImgId: "imgNewProfile",
    fileNameId: "fileName",
    fileSelectBtnId: "fileSelectBtn",
    removeBtnId: "btnRemoveImage",
  });

  setupImageUpload({
    dropAreaId: "drop-area_update",
    inputFileId: "flPhoto_update",
    previewImgId: "imgNewProfile_update",
    fileNameId: "fileName_update",
    fileSelectBtnId: "fileSelectBtn_update",
    removeBtnId: "btnRemoveImage_update",
  });
  loadTable();
  selectCompany();
  setTimeout(() => {
    OpenModal();
    saveData();
    updateData();
    deleteData();
    // confirmationDelete();
  }, 500);
});

function setupImageUpload({
  dropAreaId,
  inputFileId,
  previewImgId,
  fileNameId,
  fileSelectBtnId,
  removeBtnId,
}) {
  const dropArea = $(`#${dropAreaId}`);
  const inputFile = $(`#${inputFileId}`);
  const previewImg = $(`#${previewImgId}`);
  const fileName = $(`#${fileNameId}`);
  const fileSelectBtn = $(`#${fileSelectBtnId}`);
  const removeBtn = $(`#${removeBtnId}`);

  fileSelectBtn.on("click", function () {
    inputFile.click();
  });

  dropArea.on("dragover", function (e) {
    e.preventDefault();
    e.stopPropagation();
    dropArea.addClass("bg-light");
  });

  dropArea.on("dragleave", function (e) {
    e.preventDefault();
    e.stopPropagation();
    dropArea.removeClass("bg-light");
  });

  dropArea.on("drop", function (e) {
    e.preventDefault();
    e.stopPropagation();
    dropArea.removeClass("bg-light");

    const files = e.originalEvent.dataTransfer.files;
    if (files.length > 0) {
      previewImage(files[0], previewImg, fileName, removeBtn);
    }
  });

  inputFile.on("change", function () {
    if (this.files && this.files[0]) {
      previewImage(this.files[0], previewImg, fileName, removeBtn);
    }
  });

  removeBtn.on("click", function () {
    inputFile.val("");
    previewImg.attr("src", "").hide();
    fileName.text("").hide();
    removeBtn.hide();
  });
}

function previewImage(file, previewImg, fileName, removeBtn) {
  if (!file.type.startsWith("image/")) {
    alert("Por favor selecciona una imagen válida (JPG, PNG).");
    return;
  }

  if (file.size > 2 * 1024 * 1024) {
    alert("La imagen debe pesar menos de 2 MB.");
    return;
  }

  const reader = new FileReader();
  reader.onload = function (e) {
    previewImg.attr("src", e.target.result).show();
    fileName.text(file.name).show();
    removeBtn.show();
  };
  reader.readAsDataURL(file);
}

function loadImageFromPath(imagePath, previewImg, fileName, removeBtn) {
  previewImg.attr("src", imagePath).show();
  fileName.text(imagePath.split("=").pop()).show();
  removeBtn.show();
}

function selectCompany() {
  // Por defecto ocultamos el campo de razón social
  $("#divCompany").addClass("d-none");
  $(document).on("change", "input[name='checkCompanyName']", function () {
    if ($(this).val() === "JURIDICA") {
      $("#txtCompanyName").prop("required", true);
      $("#txtName").prop("required", false);
      $("#txtLastname").prop("required", false);
      $("#txtGender").prop("required", false);
      $("#divCompany").removeClass("d-none");
      $("#divName").addClass("d-none");
      $("#divLastname").addClass("d-none");
      $("#divBirthdate").addClass("d-none");
      $("#divGender").addClass("d-none");
    } else {
      $("#txtCompanyName").prop("required", false);
      $("#divCompany").addClass("d-none");
      $("#divName").removeClass("d-none");
      $("#divLastname").removeClass("d-none");
      $("#divBirthdate").removeClass("d-none");
      $("#divGender").removeClass("d-none");
      $("#txtName").prop("required", true);
      $("#txtLastname").prop("required", true);
      $("#txtGender").prop("required", true);
    }
  });
  $("#dataCompanyUpdate").addClass("d-none");
  $(document).on("change", "input[name='checkCompanyNameUpdate']", function () {
    if ($(this).val() === "JURIDICA") {
      $("#txtCompanyNameUpdate").prop("required", true);
      $("#txtNameUpdate").prop("required", false);
      $("#txtLastnameUpdate").prop("required", false);
      $("#txtGenderUpdate").prop("required", false);
      $("#divCompanyUpdate").removeClass("d-none");
      $("#divNameUpdate").addClass("d-none");
      $("#divLastnameUpdate").addClass("d-none");
      $("#divBirthdateUpdate").addClass("d-none");
      $("#divGenderUpdate").addClass("d-none");
    } else {
      $("#txtCompanyNameUpdate").prop("required", false);
      $("#divCompanyUpdate").addClass("d-none");
      $("#divNameUpdate").removeClass("d-none");
      $("#divLastnameUpdate").removeClass("d-none");
      $("#divBirthdateUpdate").removeClass("d-none");
      $("#divGenderUpdate").removeClass("d-none");
      $("#txtNameUpdate").prop("required", true);
      $("#txtLastnameUpdate").prop("required", true);
      $("#txtGenderUpdate").prop("required", true);
    }
  });
}

// Función que carga la tabla con los datos
function loadTable() {
  table = $("#table").DataTable({
    aProcessing: true,
    aServerSide: true,
    ajax: {
      url: "" + base_url + "/People/getAllPeople",
      dataSrc: "",
    },
    columns: [
      { data: null, className: "text-center" },
      { data: "_img", className: "col-1 text-center" },
      { data: "fullName", className: "col-2" },
      { data: "typeDoc", className: "col-1 text-center" },
      { data: "_numberDocument", className: "col-1 text-center" },
      { data: "_mail", className: "col-2" },
      { data: "_phone", className: "col-1 text-center" },
      { data: "dateRegister", className: "col-2 text-center" },
      { data: "status", className: "col-1 text-center" },
      { data: "actions", className: "col-1 text-center" },
    ],
    columnDefs: [
      {
        targets: 0,
        data: null,
        render: function (data, type, row, meta) {
          return meta.row + 1;
        },
      },
    ],
    dom: "lBfrtip",
    buttons: [
      {
        extend: "copyHtml5",
        text: "<i class='fa fa-copy'></i> Copiar",
        titleAttr: "Copiar",
        className: "btn btn-secondary",
      },
      {
        extend: "excelHtml5",
        text: "<i class='fa fa-table'></i> Excel",
        title: "Reporte de personas en Excel",
        className: "btn btn-success",
      },
      {
        extend: "csvHtml5",
        text: "<i class='fa fa-file-text'></i> CSV",
        title: "Reporte de personas en CSV",
        className: "btn btn-info",
      },
      {
        extend: "pdfHtml5",
        text: "<i class='fa fa-file-pdf'></i> PDF",
        title: "Reporte de personas en PDF",
        className: "btn btn-danger",
      },
    ],
    responsive: "true",
    destroy: true,
    iDisplayLength: 10,
    order: [[0, "asc"]],
    language: {
      url: base_url + "/Assets/js/libraries/Spanish-datatables.json",
    },
  });
}

function OpenModal() {
  $("#openModalSave").click(() => {
    $("#modalSave").modal("show");
  });

  $("button[data-dismiss='modal']").click(() => {
    $("#formSave")[0].reset();
  });

  $(document).on("click", ".__btn_edit", function () {
    // Obtenemos los datos del botón que se ha hecho clic
    let id = $(this).attr("data-id");
    let name = $(this).attr("data-name");
    let lastname = $(this).attr("data-lastname");
    let numberDocument = $(this).attr("data-numberdocument");
    let typePeople = $(this).attr("data-typepeople");
    let companyName = $(this).attr("data-fullname");
    let birthdate = $(this).attr("data-birthdate");
    let gender = $(this).attr("data-gender");
    let mail = $(this).attr("data-mail");
    let phone = $(this).attr("data-phone");
    let address = $(this).attr("data-address");
    let status = $(this).attr("data-status");
    let img = $(this).attr("data-img");
    console.log(img);

    if (typePeople === "NATURAL") {
      $("#divCompanyUpdate").addClass("d-none");
      $("#divNameUpdate").removeClass("d-none");
      $("#divLastnameUpdate").removeClass("d-none");
      $("#divBirthdateUpdate").removeClass("d-none");
      $("#divGenderUpdate").removeClass("d-none");
      $("#txtNameUpdate").prop("required", true);
      $("#txtLastnameUpdate").prop("required", true);
      $("#txtGenderUpdate").prop("required", true);
      $("#txtCompanyNameUpdate").prop("required", false);
      $("#naturalNameUpdate").prop("checked", true);
      $("#juridicaNameUpdate").prop("checked", false);
    } else {
      $("#divCompanyUpdate").removeClass("d-none");
      $("#divNameUpdate").addClass("d-none");
      $("#divLastnameUpdate").addClass("d-none");
      $("#divBirthdateUpdate").addClass("d-none");
      $("#divGenderUpdate").addClass("d-none");
      $("#txtNameUpdate").prop("required", false);
      $("#txtLastnameUpdate").prop("required", false);
      $("#txtGenderUpdate").prop("required", false);
      $("#txtCompanyNameUpdate").prop("required", true);
      $("#naturalNameUpdate").prop("checked", false);
      $("#juridicaNameUpdate").prop("checked", true);
    }
    // Mostramos los datos en el modal
    $("#formUpdate").attr("data-id", id);
    $("#txtNameUpdate").val(name);
    $("#txtLastnameUpdate").val(lastname);
    $("#txtCompanyNameUpdate").val(companyName);
    $("#txtNumberDocumentUpdate").val(numberDocument);
    $("#txtBirthdateUpdate").val(birthdate);
    $("#txtGenderUpdate").val(gender);
    $("#txtMailUpdate").val(mail);
    $("#txtPhoneUpdate").val(phone);
    $("#txtAddressUpdate").val(address);
    $("#txtStatusUpdate").val(status);
    $("#flPhoto_update").attr("data-imgupdate", img);

    loadImageFromPath(
      base_url + "/loadfile/people/?f=" + img,
      $("#imgNewProfile_update"),
      $("#fileName_update"),
      $("#btnRemoveImage_update")
    );
    // Mostramos el modal
    $("#modalUpdate").modal("show");
  });

  $(document).on("click", ".__btn_view", function () {
    let id = $(this).attr("data-id");
    let name = $(this).attr("data-name");
    let lastname = $(this).attr("data-lastname");
    let fullname = $(this).attr("data-fullname");
    let numberDocument = $(this).attr("data-numberdocument");
    let typePeople = $(this).attr("data-typepeople");
    let birthdate = $(this).attr("data-birthdate");
    let gender = $(this).attr("data-gender");
    let mail = $(this).attr("data-mail");
    let phone = $(this).attr("data-phone");
    let address = $(this).attr("data-address");
    let status = $(this).attr("data-status");
    let img = $(this).attr("data-img");
    let dateRegistration = $(this).attr("data-dateRegistration");
    let dateUpdate = $(this).attr("data-dateUpdate");

    if (status === "ACTIVO") {
      $("#txtStatusView").removeClass("badge-danger").addClass("badge-success");
    } else {
      $("#txtStatusView").removeClass("badge-success").addClass("badge-danger");
    }

    if(typePeople === "NATURAL") {
      $("#txtTypePeopleView").html("<span class='badge badge-info'>Persona Natural</span>");
      $("#txtCompanyNameView").text(name + " " + lastname);
    }
    else {
      $("#txtTypePeopleView").html("<span class='badge badge-info'>Persona Jurídica</span>");
      $("#txtCompanyNameView").text(fullname);
    }

    // Mostramos los datos en el modal
    $("#txtIdView").text("#" + id);
    $("#txtNumberDocumentView").text(numberDocument);
    $("#txtBirthdateView").text(birthdate);
    $("#txtGenderView").text(gender);
    $("#txtMailView").text(mail);
    $("#txtPhoneView").text(phone);
    $("#txtAddressView").text(address);
    $("#txtStatusView").text(status);
    $("#txtImgView").attr("src", base_url + "/loadfile/people/?f=" + img);
    $("#txtDateRegistrationView").text(dateRegistration);
    $("#txtDateUpdateView").text(dateUpdate);

    $("#modalView").modal("show");
  });
}

function saveData() {
  const formSave = $("#formSave").submit((e) => {
    e.preventDefault();
    // Obtenemos los datos de modal registrar
    let name = $("#txtName").val();
    let lastname = $("#txtLastname").val();
    let numberDocument = $("#txtnumberDocument").val();
    let birthdate = $("#txtBirthdate").val();
    let gender = $("#txtGender").val();
    let email = $("#txtEmail").val();
    let phone = $("#txtPhone").val();
    let address = $("#txtAddress").val();
    let companyName = $("#txtCompanyName").val();
    // configuramos el toastr
    toastr.options = {
      closeButton: true,
      onclick: null,
      showDuration: "300",
      hideDuration: "1000",
      timeOut: "5000",
      progressBar: true,
      onclick: null,
    };
    // Validamos los datos del formulario
    if (numberDocument == "" || phone == "" || address == "") {
      toastr.error("Llene los campos obligatorios", "Error");
      return false;
    }
    if ($("input[name='checkCompanyName']:checked").val() === "NATURAL") {
      if (name == "" || lastname == "") {
        toastr.error("Llene los campos obligatorios", "Error");
        return false;
      }
    } else {
      if (companyName == "") {
        toastr.error("Llene los campos obligatorios", "Error");
        return false;
      }
    }
    const formData = new FormData($("#formSave")[0]);
    // Creamos un objeto FormData para enviar los datos del formulario
    const request = axios.post(base_url + "/People/setPeople", formData, {
      headers: { "Content-Type": "multipart/form-data" },
    });
    // Obtenemos el estado de la respuesta
    request.then((response) => {
      if (response.status !== 200 && statusText !== "OK") {
        // Si la respuesta no es exitosa, mostramos un mensaje de error
        throw new Error(
          "Error en la solicitud " +
            response.status +
            " - " +
            response.statusText
        );
      } else {
        // En caso que haya un error
        if (!response.data.status) {
          toastr[response.data.type](
            response.data.message,
            response.data.title
          );
          return false;
        }
        // Recargamos la tabla sin reiniciar el paginador
        table.ajax.reload(null, false);
        toastr[response.data.type](response.data.message, response.data.title);
        //limpiar el formulario
        formSave[0].reset();
        //ocultar el modal abierto
        $("#modalSave").modal("hide");
        return true;
      }
    });

    request.catch((error) => {
      // Si hay un error en la solicitud, mostramos un mensaje de error
      console.error("Error en la solicitud:", error);
      // Mostrar un mensaje de error al usuario
      // Puedes usar SweetAlert o cualquier otra librería de notificaciones
      Toast.fire({
        icon: "error",
        title: "Error al guardar los datos.",
      });
    });
  });
}

function updateData() {
  const formUpdate = $("#formUpdate").submit((e) => {
    e.preventDefault();
    // Obtenemos los datos de modal registrar
    let id = $("#formUpdate").attr("data-id");
    let name = $("#txtNameUpdate").val();
    let lastname = $("#txtLastnameUpdate").val();
    let numberDocument = $("#txtnumberDocumentUpdate").val();
    let birthdate = $("#txtBirthdateUpdate").val();
    let gender = $("#txtGenderUpdate").val();
    let email = $("#txtEmailUpdate").val();
    let phone = $("#txtPhoneUpdate").val();
    let address = $("#txtAddressUpdate").val();
    let status = $("#txtStatusUpdate").val();
    let companyName = $("#txtCompanyNameUpdate").val();
    let imgActual = $("#flPhoto_update").attr("data-imgupdate");
    // configuramos el toastr
    toastr.options = {
      closeButton: true,
      onclick: null,
      showDuration: "300",
      hideDuration: "1000",
      timeOut: "5000",
      progressBar: true,
      onclick: null,
    };
    // Validamos los datos del formulario
    if (numberDocument == "" || phone == "" || address == "") {
      toastr.error("Llene los campos obligatorios", "Error");
      return false;
    }
    if ($("input[name='checkCompanyNameUpdate']:checked").val() === "NATURAL") {
      if (name == "" || lastname == "") {
        toastr.error("Llene los campos obligatorios", "Error");
        return false;
      }
    } else {
      if (companyName == "") {
        toastr.error("Llene los campos obligatorios", "Error");
        return false;
      }
    }
    // Agregamos los datos al objeto FormData para enviarlos al controlador
    let formData = new FormData($("#formUpdate")[0]);
    formData.append("id", id);
    formData.append("imgActual", imgActual);
    // Enviamos los datos al controlador utilizando axios
    // Creamos un objeto FormData para enviar los datos del formulario
    const request = axios.post(base_url + "/People/updatePeople", formData, {
      headers: { "Content-Type": "multipart/form-data" },
    });
    // Obtenemos el estado de la respuesta
    request.then((response) => {
      console.log(response);
      
      if (response.status !== 200 && statusText !== "OK") {
        // Si la respuesta no es exitosa, mostramos un mensaje de error
        throw new Error(
          "Error en la solicitud " +
            response.status +
            " - " +
            response.statusText
        );
      } else {
        // En caso que haya un error
        if (!response.data.status) {
          toastr[response.data.type](
            response.data.message,
            response.data.title
          );
          return false;
        }
        // Recargamos la tabla sin reiniciar el paginador
        table.ajax.reload(null, false);
        toastr[response.data.type](response.data.message, response.data.title);
        //limpiar el formulario
        formUpdate[0].reset();
        //ocultar el modal abierto
        $("#modalUpdate").modal("hide");
        return true;
      }
    });

    request.catch((error) => {
      // Si hay un error en la solicitud, mostramos un mensaje de error
      console.error("Error en la solicitud:", error);
      // Mostrar un mensaje de error al usuario
      // Puedes usar SweetAlert o cualquier otra librería de notificaciones
      Toast.fire({
        icon: "error",
        title: "Error al guardar los datos.",
      });
    });
  });
}

function deleteData() {
  $(document).on("click", ".__btn_delete", function () {
    let id = $(this).attr("data-id");
    let name = $(this).attr("data-name");
    let lastname = $(this).attr("data-lastname");
    let fullname = $(this).attr("data-fullname");
    let numberDocument = $(this).attr("data-numberdocument");
    let img = $(this).attr("data-img");
    let typePeople = $(this).attr("data-typepeople");
    let auxCompanyName = "Persona Jurídica";
    if(typePeople === "NATURAL"){
      auxCompanyName = "Persona Natural";
      fullname = name + " " + lastname;
    }

    let token = $("#token").val();
    Swal.fire({
      title: "¿Está seguro de eliminar la persona?",
      html:
        "Nombre(s): " +
        "<i>" +
        fullname +
        "</i></br>" +
        "N° Doc: " +
        "<b><i>" +
        numberDocument +
        "</i></b></br>"+
        "<span class='badge badge-info'>" +
        auxCompanyName + "</span>",
      icon: "warning",
      showCancelButton: true,
      confirmButtonColor: "#3085d6",
      cancelButtonColor: "#d33",
      confirmButtonText: "Sí, eliminarlo.",
    }).then((result) => {
      if (result.isConfirmed) {
        const request = axios.delete(base_url + "/People/deletePeople", {
          params: {
            idPeople: id,
            token: token,
            fullname: fullname,
            numberdocument: numberDocument,
            img: img,
          },
        });
        request.then((response) => {
          if (response.status !== 200 && statusText !== "OK") {
            // Si la respuesta no es exitosa, mostramos un mensaje de error
            throw new Error(
              "Error en la solicitud " +
                response.status +
                " - " +
                response.statusText
            );
          } else {
            // configuramos el toastr
            toastr.options = {
              closeButton: true,
              onclick: null,
              showDuration: "300",
              hideDuration: "1000",
              timeOut: "5000",
              progressBar: true,
              onclick: null,
            };
            // En caso que haya un error
            if (!response.data.status) {
              toastr[response.data.type](
                response.data.message,
                response.data.title
              );
              return false;
            }
            // Recargamos la tabla sin reiniciar el paginador
            table.ajax.reload(null, false);
            toastr[response.data.type](
              response.data.message,
              response.data.title
            );
          }
        });
      }
    });
  });
}
