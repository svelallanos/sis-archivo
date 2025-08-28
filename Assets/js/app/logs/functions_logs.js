let table;
window.addEventListener("load", () => {
  loadTable();
  setTimeout(() => {
    loadReport();
    filterTable();
    clearFilters();
  }, 500);
});
//Funcion que se encarga de listar la tabla
function loadTable() {
  table = $("#table").DataTable({
    aProcessing: true,
    aServerSide: true,
    ajax: {
      url: "" + base_url + "/Logs/getLogs",
      data: function (d) {
        // Se agrega el parámetro del filtro al objeto que se envía al servidor
        d.filterType = $("#filter-type").val();
        d.minData = $("#min-datetime").val();
        d.maxData = $("#max-datetime").val();
      },
      dataSrc: "",
    },
    columns: [
      { data: "cont" },
      { data: "l_title" },
      { data: "tl_name" },
      { data: "u_fullname" },
      { data: "l_registrationDate" }, // Fecha con hora
      { data: "actions" },
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
        text: "<i class='fa fa-file-excel-o'></i> Excel",
        title: "Reporte de logs en Excel",
        className: "btn btn-success",
      },
      {
        extend: "csvHtml5",
        text: "<i class='fa fa-file-text'></i> CSV",
        title: "Reporte de logs en CSV",
        className: "btn btn-info",
      },
      {
        extend: "pdfHtml5",
        text: "<i class='fa fa-file-pdf-o'></i> PDF",
        title: "Reporte de logs en PDF",

        className: "btn btn-danger",
      },
    ],
    responsive: true,
    bDestroy: true,
    iDisplayLength: 10,
    order: [[0, "asc"]],
    language: {
      url: base_url + "/Assets/js/libraries/Spanish-datatables.json",
    },
  });
}
//Funcion que carga los datos en el reporte del modal del usuario
function loadReport() {
   $(document).on("click", ".report-item", function () {
      //creamos las constantes que capturar los datos de los atributos del boton
      const idLog = $(this).attr("data-id");
      const title = $(this).attr("data-title");
      const description = $(this).attr("data-description");
      const registrationDate = $(this).attr("data-registrationdate");
      const updateDate = $(this).attr("data-updatedate");
      const type = $(this).attr("data-type");
      const fullname = $(this).attr("data-fullname");
      const email = $(this).attr("data-email");
      const user = $(this).attr("data-user");
      //obtene los elementos del modal donde se cargaran los datos
      const reportTitle = document.getElementById("reportTitle");
      const reportCode = document.getElementById("reportCode");
      const reportType = document.getElementById("reportType");
      const reportDescription = document.getElementById("reportDescription");
      const reportFullname = document.getElementById("reportFullname");
      const reportUser = document.getElementById("reportUser");
      const reportEmail = document.getElementById("reportEmail");
      const reportRegistrationDate = document.getElementById(
         "reportRegistrationDate"
      );
      const reportUpdateDate = document.getElementById("reportUpdateDate");
      //asignamos los valores a los elementos del modal
      reportTitle.innerHTML = title;
      reportCode.innerHTML = "#" + idLog;
      reportType.innerHTML = type;
      reportDescription.innerHTML = description
         .replaceAll("|", '"')
         .replaceAll("¬", "'");
      reportFullname.innerHTML = fullname;
      reportUser.innerHTML = user;
      reportEmail.innerHTML = email;
      reportRegistrationDate.innerHTML = registrationDate;
      reportUpdateDate.innerHTML = updateDate;

      //abrimos el modal
      $("#modalReport").modal("show");
   });
}
//Function que filtra los datos de la tabla
function filterTable() {
  const filterBtn = document.getElementById("filter-btn");
  filterBtn.addEventListener("click", () => {
    //obtenemos los valores de los inputs de la fechas
    const minDate = document.getElementById("min-datetime").value;
    const maxDate = document.getElementById("max-datetime").value;
    //validamos los campos vacios
    if (minDate == "" || maxDate == "") {
      toastr.options = {
        closeButton: true,
        timeOut: 0,
        onclick: null,
      };
      toastr["error"](
        "Debe llenar los campos de fecha",
        "Ocurrio un error inesperado"
      );
      return false;
    }
    //validamos que la fecha maxima sea mayor a la fecha minima
    if (minDate > maxDate) {
      toastr.options = {
        closeButton: true,
        timeOut: 0,
        onclick: null,
      };
      toastr["error"](
        "La fecha minima no debe ser mayor que la fecha maxima",
        "Ocurrio un error inesperado"
      );
      return false;
    }
    table.ajax.reload();
  });
}
//Funcion que limpiar los campos de los filtros
function clearFilters() {
  const clearBtn = document.getElementById("reset-btn");
  clearBtn.addEventListener("click", () => {
    document.getElementById("min-datetime").value = "";
    document.getElementById("max-datetime").value = "";
    table.ajax.reload();
    toastr.options = {
      closeButton: true,
      timeOut: 0,
      onclick: null,
    };
    toastr["success"]("Filtros limpiados correctamente", "Filtros limpiados");
  });
}
