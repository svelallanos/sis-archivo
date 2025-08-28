let table;

// Configuración global de toastr
toastr.options = {
    closeButton: true,
    progressBar: true,
    timeOut: 5000,
    positionClass: "toast-top-right",
    newestOnTop: true,
    preventDuplicates: true
};

window.addEventListener("DOMContentLoaded", (e) => {
    loadTable();
    setTimeout(() => {
        openModal();

        // 🧼 Limpiar formularios al cerrar los modales (por botón, esc o clic fuera)
        $('#modalSave').on('hidden.bs.modal', function () {
            document.getElementById("formSave").reset();
        });

        $('#modalUpdate').on('hidden.bs.modal', function () {
            document.getElementById("formUpdate").reset();
        });

        saveData();
        updateData();
        loadDataUpdate();
        confirmationDelete();
        deleteData();
        loadReport();
    }, 1000);
});

window.addEventListener("click", (e) => {
    loadDataUpdate();
    confirmationDelete();
    loadReport();
});


function openModal() {
    const closeButton = document.getElementById("closeButtonSave");

    if (closeButton) {
        closeButton.addEventListener("click", () => {
            document.getElementById("formSave").reset();
        });
    }
}


// Función para cargar la tabla
function loadTable() {
    table = $("#table").DataTable({
        aProcessing: true,
        aServerSide: true,
        ajax: {
            url: base_url + "/Jobtitle/getJobTitles",
            dataSrc: ""
        },
        columns: [
            { data: "cont" },
            { data: "name" },
            { data: "description" },
            { data: "status" },
            { data: "actions" }
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
                title: "Reporte de Cargos en Excel",
                className: "btn btn-success",
            },
            {
                extend: "csvHtml5",
                text: "<i class='fa fa-file-text'></i> CSV",
                title: "Reporte de Cargos en CSV",
                className: "btn btn-info",
            },
            {
                extend: "pdfHtml5",
                text: "<i class='fa fa-file-pdf'></i> PDF",
                title: "Reporte de Cargos en PDF",
                className: "btn btn-danger",
                orientation: "landscape",
                pageSize: "LEGAL",
            }
        ],
        columnDefs: [
            { targets: [0], searchable: false },
            { targets: [1, 2, 3, 4], className: "text-center" }
        ],
        responsive: true,
        processing: true,
        destroy: true,
        iDisplayLength: 10,
        order: [[0, "asc"]],
        language: {
            url: base_url + "/Assets/js/libraries/Spanish-datatables.json",
        }
    });
}


function saveData() {
    const formSave = document.getElementById("formSave");

    formSave.addEventListener("submit", (e) => {
        e.preventDefault();

        const formData = new FormData(formSave);
        const headers = new Headers();

        const config = {
            method: "POST",
            headers: headers,
            cache: "no-cache",
            body: formData,
        };

        const url = base_url + "/Jobtitle/setJobTitle";

        const desc = formData.get("txtJobtitleDescription")?.trim() || "";
        if (desc && (desc.length < 10 || desc.length > 200)) {
            toastr.warning("La descripción debe tener entre 10 y 200 caracteres si es ingresada.");
            return;
        }


        fetch(url, config)
            .then((response) => {
                if (!response.ok) {
                    throw new Error(
                        `Error ${response.status} - ${response.statusText}`
                    );
                }
                return response.json();
            })
            .then((data) => {
                toastr[data.type](data.message, data.title || "Mensaje del sistema");

                if (!data.status) return;

                // Limpiar formulario y cerrar modal
                formSave.reset();
                $("#modalSave").modal("hide");

                // Recargar tabla
                table.ajax.reload(null, false);

                // Reasignar eventos
                setTimeout(() => {
                    loadDataUpdate();
                    confirmationDelete();
                    loadReport();
                }, 500);
            })
            .catch((error) => {
                toastr["error"](
                    "Error al contactar al servidor: " + error.message,
                    "Ocurrió un error inesperado"
                );
            });
    });
}


function loadDataUpdate() {
    const btnUpdateItem = document.querySelectorAll(".update-item");
    btnUpdateItem.forEach((item) => {
        item.addEventListener("click", (e) => {
            e.preventDefault();

            const id = item.getAttribute("data-id");
            const name = item.getAttribute("data-name");
            const description = item.getAttribute("data-description");
            const status = item.getAttribute("data-status");

            document.getElementById("update_txtId").value = id;
            document.getElementById("update_txtName").value = name;
            document.getElementById("update_txtDescription").value = description;
            document.getElementById("update_slctStatus").value = status;

            $("#modalUpdate").modal("show");
        });
    });
}

function updateData() {
    const formUpdate = document.getElementById("formUpdate");

    formUpdate.addEventListener("submit", (e) => {
        e.preventDefault();
        const formData = new FormData(formUpdate);
        const config = {
            method: "POST",
            body: formData,
        };
        const url = base_url + "/Jobtitle/updateJobTitle";

        const desc = formData.get("update_txtJobtitleDescription")?.trim() || "";
        if (desc && (desc.length < 10 || desc.length > 200)) {
            toastr.warning("La descripción debe tener entre 10 y 200 caracteres si es ingresada.");
            return;
        }


        fetch(url, config)
            .then((response) => {
                if (!response.ok) {
                    throw new Error(`Error ${response.status}: ${response.statusText}`);
                }
                return response.json();
            })
            .then((data) => {

                toastr[data.type](data.message, data.title);

                if (data.status) {
                    formUpdate.reset();
                    $("#modalUpdate").modal("hide");
                    table.ajax.reload(null, false);

                    setTimeout(() => {
                        confirmationDelete();
                        loadDataUpdate();
                        loadReport();
                    }, 500);
                }
            })
            .catch((error) => {
                toastr.error("Ocurrió un error inesperado: " + error.message, "Error");
            });
    });
}

// Confirmación
function confirmationDelete() {
    const arrBtnDeleteItem = document.querySelectorAll(".delete-item");
    arrBtnDeleteItem.forEach((item) => {
        item.addEventListener("click", () => {
            const name = item.getAttribute("data-name");
            const id = item.getAttribute("data-id");
            document.getElementById("txtDelete").innerHTML =
                "¿Está seguro de eliminar el cargo <strong>" + name + "</strong>?";
            const confirmDelete = document.getElementById("confirmDelete");
            confirmDelete.setAttribute("data-idjobtitle", id);
            confirmDelete.setAttribute("data-namejobtitle", name);
            $("#confirmModalDelete").modal("show");
        });
    });
}

// Eliminación
function deleteData() {
    const confirmDelete = document.getElementById("confirmDelete");
    confirmDelete.addEventListener("click", (e) => {
        e.preventDefault();
        const id = confirmDelete.getAttribute("data-idjobtitle");
        const name = confirmDelete.getAttribute("data-namejobtitle");
        const token = confirmDelete.getAttribute("data-token");

        const arrValues = { id: id, name: name, token: token };

        fetch(base_url + "/Jobtitle/deleteJobTitle", {
            method: "DELETE",
            headers: { "Content-Type": "application/json" },
            body: JSON.stringify(arrValues),
        })
            .then((response) => {
                if (!response.ok) {
                    throw new Error("Error en la solicitud " + response.statusText);
                }
                return response.json();
            })
            .then((data) => {
                toastr.options = {
                    closeButton: true,
                    timeOut: 5000,
                    progressBar: true,
                };
                if (!data.status) {
                    toastr[data.type](data.message, data.title);
                    return;
                }
                $("#confirmModalDelete").modal("hide");
                table.ajax.reload(null, false);
                toastr[data.type](data.message, data.title);

                setTimeout(() => {
                    confirmationDelete(); // Recargar
                    loadDataUpdate();
                }, 500);
            })
            .catch((error) => {
                toastr["error"](
                    "Error en la solicitud: " + error.message,
                    "Error inesperado"
                );
            });
    });
}



/*
function deleteData() {
    const confirmDelete = document.getElementById("confirmDelete");
    if (!confirmDelete) return;

    confirmDelete.addEventListener("click", (e) => {
        e.preventDefault();

        const id = confirmDelete.getAttribute("data-id");
        const name = confirmDelete.getAttribute("data-name");
        const token = document.querySelector('input[name="token"]').value; // ✅ CSRF seguro

        const arrValues = {
            id: id,
            name: name,
            token: token,
        };

        const config = {
            method: "DELETE",
            headers: { "Content-Type": "application/json" },
            body: JSON.stringify(arrValues),
        };

        const url = base_url + "/Jobtitle/deleteJobTitle";

        fetch(url, config)
            .then((response) => {
                if (!response.ok) {
                    throw new Error(`Error ${response.status}: ${response.statusText}`);
                }
                return response.json();
            })
            .then((data) => {
                
                if (!data.status) {
                    toastr[data.type](data.message, data.title);
                    return;
                }

                $("#confirmModalDelete").modal("hide"); // Oculta el modal
                table.ajax.reload(null, false); // Refresca la tabla
                toastr[data.type](data.message, data.title);

                // Reengancha eventos
                setTimeout(() => {
                    confirmationDelete();
                    loadDataUpdate();
                    loadReport();
                }, 500);
            })
            .catch((error) => {
                toastr["error"](
                    "Error al contactar al servidor: " + error.message,
                    "Ocurrió un error inesperado"
                );
            });
    });
}
    */


function loadReport() {
    const btnReportItem = document.querySelectorAll(".report-item");

    btnReportItem.forEach((item) => {
        item.addEventListener("click", (e) => {
            e.preventDefault();

            const id = item.getAttribute("data-id");
            const name = item.getAttribute("data-name");
            const description = item.getAttribute("data-description");
            const status = item.getAttribute("data-status");
            const registrationDate = item.getAttribute("data-registrationDate");
            const updateDate = item.getAttribute("data-updateDate");

            // Insertar valores en el modal
            document.getElementById("reportId").innerText = id;
            document.getElementById("reportName").innerText = name;
            document.getElementById("reportDescription").innerText = description;
            document.getElementById("reportStatus").innerText = status;
            document.getElementById("reportRegistrationDate").innerText = registrationDate;
            document.getElementById("reportUpdateDate").innerText = updateDate;

            // Mostrar modal
            $("#modalReport").modal("show");
        });
    });

}