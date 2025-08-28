<?php
class Jobtitle extends Controllers
{
    public function __construct()
    {
        isSession(); // Verifica que haya sesión iniciada
        parent::__construct(); // Llama al constructor padre
    }

    public function jobtitle()
    {
        $data['page_id'] = 10;
        permissionInterface($data['page_id']);
        $data['page_title'] = "Cargos del Personal";
        $data['page_description'] = "Permite gestionar los cargos asignados al personal de la empresa.";
        $data['page_container'] = "Jobtitle";
        $data['page_js_css'] = "jobtitle";


        registerLog(
            "Navegación en módulo",
            "El usuario ingresó al módulo: " . $data['page_title'],
            3,
            $_SESSION['login_info']['idUser']
        );

        $this->views->getView($this, "jobtitle", $data);
    }


    public function getJobTitles()
    {
        permissionInterface(10); // Validación de permisos

        $arrData = $this->model->select_jobtitles(); // Obtener datos del modelo
        $cont = 1; // Contador para enumerar

        foreach ($arrData as $key => $value) {
            // Estado como badge
            $arrData[$key]['status'] = $value['status'] == 'ACTIVO'
                ? '<span class="badge badge-success"><i class="fa fa-check"></i> ACTIVO</span>'
                : '<span class="badge badge-danger"><i class="fa fa-close"></i> INACTIVO</span>';

            // Contador
            $arrData[$key]['cont'] = $cont;

            // Botones de acción
            $arrData[$key]['actions'] = '
<div class="btn-group" role="group">
    <button class="btn btn-success update-item"
        data-id="' . $value["id"] . '"
        data-name="' . $value["name"] . '"
        data-description="' . $value["description"] . '"
        data-status="' . $value["status"] . '">
        <i class="fa fa-pencil"></i>
    </button>
    <button class="btn btn-danger delete-item"
        data-id="' . $value["id"] . '"
        data-name="' . $value["name"] . '">
        <i class="fa fa-remove"></i>
    </button>
    <button class="btn btn-info report-item"
        data-id="' . $value["id"] . '"
        data-name="' . $value["name"] . '"
        data-description="' . $value["description"] . '"
        data-status="' . $value["status"] . '"
        data-registrationDate="' . $value["dateRegistration"] . '"
        data-updateDate="' . $value["dateUpdate"] . '">
        <i class="fa fa-user"></i>
    </button>
        <a href="' . base_url() . '/pdf/jobtitle/' . encryption($value["id"]) . '" target="_Blank" class="btn btn-warning"><i class="fa fa-print text-white"></i></a>

</div>';

            $cont++;
        }

        echo json_encode($arrData, JSON_UNESCAPED_UNICODE);
    }


    public function setJobTitle()
    {
        permissionInterface(10);

        // Verificar método POST
        if ($_SERVER["REQUEST_METHOD"] !== "POST") {
            registerLog(
                "Acceso indebido a método",
                "Intento de acceso directo al método setJobTitle. IP: " . obtenerIP() . " | Sesión: " . json_encode($_SESSION),
                1,
                $_SESSION['login_info']['idUser']
            );
            toJson([
                "title" => "Acceso no permitido",
                "message" => "Acción denegada por el sistema.",
                "type" => "error",
                "status" => false
            ]);
        }

        isCsrf();

        // Validar existencia de campos
        if (!isset($_POST["txtName"])) {
            registerLog("Error de formulario", "El campo txtName no fue enviado al servidor", 1, $_SESSION['login_info']['idUser']);
            toJson([
                "title" => "Campo faltante",
                "message" => "Nombre del cargo es obligatorio",
                "type" => "error",
                "status" => false
            ]);
        }

        if (!isset($_POST["txtJobtitleDescription"])) {
            registerLog("Error de formulario", "El campo txtJobtitleDescription no fue enviado al servidor", 1, $_SESSION['login_info']['idUser']);
            toJson([
                "title" => "Campo faltante",
                "message" => "Descripción del cargo es obligatoria",
                "type" => "error",
                "status" => false
            ]);
        }

        // Limpiar datos
        $txtName = strClean($_POST["txtName"]);
        $txtDescription = strClean($_POST["txtJobtitleDescription"]);

        // Validaciones
        if ($txtName == "") {
            registerLog("Validación fallida", "Campo nombre vacío", 1, $_SESSION['login_info']['idUser']);
            toJson([
                "title" => "Campo obligatorio",
                "message" => "Debe completar el nombre del cargo.",
                "type" => "error",
                "status" => false
            ]);
        }

        if (verifyData("[A-Za-zÁÉÍÓÚáéíóúÑñ\s]{4,200}", $txtName)) {
            registerLog("Validación fallida", "El campo nombre no cumple el formato", 1, $_SESSION['login_info']['idUser']);
            toJson([
                "title" => "Formato inválido",
                "message" => "Nombre del cargo no válido.",
                "type" => "error",
                "status" => false
            ]);
        }

        if ($txtDescription != "" && verifyData("[a-zA-ZÁÉÍÓÚáéíóúÜüÑñ0-9\s.,;:!?()-]+", $txtDescription)) {
            registerLog("Validación fallida", "El campo descripción no cumple con el formato", 1, $_SESSION['login_info']['idUser']);
            toJson([
                "title" => "Formato inválido",
                "message" => "Descripción inválida.",
                "type" => "error",
                "status" => false
            ]);
        }

        // Guardar en BD
        $request = $this->model->insert_jobtitle($txtName, $txtDescription);

        if ($request > 0) {
            registerLog("Registro exitoso", "Se registró un nuevo cargo: " . json_encode($_POST), 2, $_SESSION['login_info']['idUser']);
            toJson([
                "title" => "Registro exitoso",
                "message" => "El cargo ha sido registrado correctamente",
                "type" => "success",
                "status" => true
            ]);
        } else {
            registerLog("Error en registro", "No se pudo registrar el cargo", 1, $_SESSION['login_info']['idUser']);
            toJson([
                "title" => "Error",
                "message" => "No se pudo registrar el cargo.",
                "type" => "error",
                "status" => false
            ]);
        }
    }


    public function deleteJobTitle()
    {
        permissionInterface(10);

        // Validación del método
        if ($_SERVER["REQUEST_METHOD"] !== "DELETE") {
            registerLog(
                "Acceso no autorizado",
                "Se intentó acceder a deleteJobTitle sin método DELETE. IP: " . obtenerIP(),
                1,
                $_SESSION['login_info']['idUser']
            );
            toJson([
                "title" => "Acción no permitida",
                "message" => "Acceso denegado",
                "type" => "error",
                "status" => false
            ]);
        }

        // Obtener y decodificar JSON del body
        $json = file_get_contents("php://input");
        $data = json_decode($json, true);

        // Validación de campos
        if (!isset($data["id"])) {
            registerLog(
                "Error de datos",
                "No se recibió el ID para eliminación. Data => " . $json,
                1,
                $_SESSION['login_info']['idUser']
            );
            toJson([
                "title" => "Error",
                "message" => "Faltan datos requeridos",
                "type" => "error",
                "status" => false
            ]);
        }

        $id = intval($data["id"]);
        $name = isset($data["name"]) ? strClean($data["name"]) : "Sin nombre";

        $request = $this->model->delete_jobtitle($id);

        if ($request) {
            registerLog(
                "Eliminación exitosa",
                "Se eliminó el cargo [$name] con ID $id correctamente",
                2,
                $_SESSION['login_info']['idUser']
            );
            toJson([
                "title" => "Eliminado",
                "message" => "El cargo ha sido eliminado correctamente",
                "type" => "success",
                "status" => true
            ]);
        } else {
            registerLog(
                "Fallo al eliminar",
                "No se pudo eliminar el cargo [$name] con ID $id",
                1,
                $_SESSION['login_info']['idUser']
            );
            toJson([
                "title" => "Error al eliminar",
                "message" => "No se pudo eliminar el registro",
                "type" => "error",
                "status" => false
            ]);
        }
    }



    public function updateJobTitle()
    {
        permissionInterface(10);

        if ($_SERVER["REQUEST_METHOD"] !== "POST") {
            registerLog(
                "Acceso indebido a método",
                "Intento de acceso directo al método updateJobTitle. IP: " . obtenerIP() . " | Sesión: " . json_encode($_SESSION),
                1,
                $_SESSION['login_info']['idUser']
            );
            toJson([
                "title" => "Acceso no permitido",
                "message" => "Acción denegada por el sistema.",
                "type" => "error",
                "status" => false
            ]);
        }

        isCsrf();

        // Validar existencia de campos
        if (!isset($_POST["update_txtId"]) || !isset($_POST["update_txtName"])) {
            registerLog("Error de formulario", "Faltan campos obligatorios para actualizar", 1, $_SESSION['login_info']['idUser']);
            toJson([
                "title" => "Error en la solicitud",
                "message" => "Faltan datos requeridos",
                "type" => "error",
                "status" => false
            ]);
        }

        $id = intval($_POST["update_txtId"]);
        $name = strClean($_POST["update_txtName"]);
        $description = isset($_POST["update_txtJobtitleDescription"]) ? strClean($_POST["update_txtJobtitleDescription"]) : "";
        $status = isset($_POST["update_slctStatus"]) ? strClean($_POST["update_slctStatus"]) : "";

        if ($name == "") {
            registerLog("Validación fallida", "Nombre vacío en actualización", 1, $_SESSION['login_info']['idUser']);
            toJson([
                "title" => "Campo obligatorio",
                "message" => "Debe ingresar un nombre",
                "type" => "error",
                "status" => false
            ]);
        }

        if (verifyData("[A-Za-zÁÉÍÓÚáéíóúÑñ\s]{4,200}", $name)) {
            registerLog("Validación fallida", "El campo nombre no cumple con el formato en update", 1, $_SESSION['login_info']['idUser']);
            toJson([
                "title" => "Formato inválido",
                "message" => "El nombre del cargo no es válido.",
                "type" => "error",
                "status" => false
            ]);
        }

        if ($description != "" && verifyData("[a-zA-ZÁÉÍÓÚáéíóúÜüÑñ0-9\s.,;:!?()-]+", $description)) {
            registerLog("Validación fallida", "Formato incorrecto en descripción (update)", 1, $_SESSION['login_info']['idUser']);
            toJson([
                "title" => "Formato inválido",
                "message" => "La descripción contiene caracteres no permitidos.",
                "type" => "error",
                "status" => false
            ]);
        }

        $request = $this->model->update_jobtitle($id, $name, $description, $status);

        if ($request > 0) {
            registerLog("Actualización exitosa", "Cargo actualizado correctamente => " . json_encode($_POST), 2, $_SESSION['login_info']['idUser']);
            toJson([
                "title" => "Actualización exitosa",
                "message" => "Los datos del cargo se actualizaron correctamente.",
                "type" => "success",
                "status" => true
            ]);
        } else {
            registerLog("Error inesperado", "No se logró actualizar el cargo => " . json_encode($_POST), 1, $_SESSION['login_info']['idUser']);
            toJson([
                "title" => "Error",
                "message" => "No se pudo actualizar el cargo.",
                "type" => "error",
                "status" => false
            ]);
        }
    }
}
