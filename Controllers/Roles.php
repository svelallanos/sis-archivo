<?php

class Roles extends Controllers
{
    public function __construct()
    {
        isSession();
        parent::__construct();
    }

    public function roles()
    {
        $data['page_id'] = 4;
        permissionInterface($data['page_id']);
        $data['page_title'] = "Gestión de Roles";
        $data['page_description'] = "Te permite gestionar los roles que acceden al sistema";
        $data['page_container'] = "Roles";
        $data['page_js_css'] = "roles";
        registerLog("Información de navegación", "El usuario entro a :" . $data['page_title'], 3, $_SESSION['login_info']['idUser']);
        $this->views->getView($this, "roles", $data);
    }

    /**
     * Funcion que desvuelve la lista de los roles a la vista
     * @return void
     */
    public function getRoles()
    {
        permissionInterface(4);
        $arrData = $this->model->select_roles();
        $cont = 1; //Contador para la tabla
        foreach ($arrData as $key => $value) {
            $arrData[$key]["cont"] = $cont;
            if ($value["idRole"] != 1) {
                $arrData[$key]["actions"] = '
                <button class="btn btn-success update-item" data-id="' . $value["idRole"] . '" data-name="' . $value["r_name"] . '" data-status="' . $value['r_status'] . '"  data-description="' . $value["r_description"] . '" type="button"><i class="fa fa-pencil"></i></button>
                <button class="btn btn-info report-item" data-id="' . $value["idRole"] . '" data-name="' . $value["r_name"] . '" data-status="' . $value['r_status'] . '"  data-description="' . $value["r_description"] . '" data-registrationDate="' . $value['r_registrationDate'] . '" data-updateDate="' . $value['r_updateDate'] . '" type="button"><i class="fa fa-exclamation-circle" aria-hidden="true"></i></button>
                <button class="btn btn-warning permission-item" data-id="' . $value["idRole"] . '" data-name="' . $value["r_name"] . '"   data-description="' . $value["r_description"] . '" type="button"><i class="fa fa-th-list" aria-hidden="true"></i></button>
                <button class="btn btn-danger delete-item" data-id="' . $value["idRole"] . '" data-name="' . $value["r_name"] . '" ><i class="fa fa-remove"></i></button>
                <a href="'.base_url().'/pdf/rol/'.encryption($value["idRole"]).'" target="_Blank" class="btn btn-warning"><i class="fa fa-file-pdf"></i></a>
                '; //Botones de acciones
            } else {
                $arrData[$key]["actions"] = ' 
                <button class="btn btn-success update-item" 
                data-id="' . $value["idRole"] . '" 
                data-name="' . $value["r_name"] . '" 
                data-status="' . $value['r_status'] . '" 
                data-description="' . $value["r_description"] . '" 
                type="button"><i class="fa fa-pencil"></i></button>
                <button class="btn btn-info report-item" 
                data-id="' . $value["idRole"] . '" 
                data-name="' . $value["r_name"] . '" 
                data-status="' . $value['r_status'] . '" 
                data-description="' . $value["r_description"] . '" 
                data-registrationDate="' . $value['r_registrationDate'] . '" 
                data-updateDate="' . $value['r_updateDate'] . '"  
                type="button"><i class="fa fa-exclamation-circle" aria-hidden="true"></i></button>
                <a href="'.base_url().'/pdf/rol/'.encryption($value["idRole"]).'" target="_Blank" class="btn btn-warning"><i class="fa fa-file-pdf"></i></a>
                ';
            }
            $cont++;
        }
        echo json_encode($arrData);
    }
    /**
     * Funcion que permite el registro del usuario nuevo
     * @return void
     */
    public function setRoles()
    {
        permissionInterface(4);
        // Validación del método POST
        if (!$_POST) {
            registerLog("Ocurrió un error inesperado", "Método POST no encontrado al registrar un rol", 1, $_SESSION['login_info']['idRole']);
            $data = array(
                "title" => "Ocurrió un error inesperado",
                "message" => "Método POST no encontrado",
                "type" => "error",
                "status" => false
            );
            toJson($data);
        }
        isCsrf(); //validacion de ataque CSRF
        // Limpieza de los inputs
        $strRoleName = strClean($_POST["txtRoleName"]);
        $strRoleDescription = strClean($_POST["txtRoleDescription"]);

        // Validación de campos vacíos
        if ($strRoleName == "") {
            registerLog("Ocurrió un error inesperado", "Es obligatorio llenar todos los campos al registrar un rol", 1, $_SESSION['login_info']['idUser']);

            $data = array(
                "title" => "Error",
                "message" => "Todos los campos son obligatorios",
                "type" => "error",
                "status" => false
            );
            toJson($data);
        }

        // Validación del formato de texto en el nombre del rol (solo letras y espacios, mínimo 4 caracteres, máximo 250)
        if (verifyData("[A-Za-zÁÉÍÓÚáéíóúÑñ\s]{4,250}", $strRoleName)) {
            registerLog("Ocurrió un error inesperado", "El campo Nombre no cumple con el formato de texto al registrar un rol", 1, $_SESSION['login_info']['idUser']);
            $data = array(
                "title" => "Ocurrió un error inesperado",
                "message" => "El campo nombre no cumple con el formato de texto",
                "type" => "error",
                "status" => false
            );
            toJson($data);
        }

        // Validación del formato de la descripción del rol (permite letras, números, guiones, espacios, mínimo 20 caracteres)
        if ($strRoleDescription != "") {
            if (verifyData("[a-zA-ZÁÉÍÓÚáéíóúÜüÑñ0-9\s.,;:!?()-]+", $strRoleDescription)) {
                registerLog("Ocurrió un error inesperado", "El campo Descripción no cumple con el formato de texto al registrar un rol", 1, $_SESSION['login_info']['idUser']);
                $data = array(
                    "title" => "Ocurrió un error inesperado",
                    "message" => "El campo nombre no cumple con el formato de texto",
                    "type" => "error",
                    "status" => false
                );
                toJson($data);
            }
        }
        $request = $this->model->insert_role($strRoleName, $strRoleDescription); //insert  roles in database
        if ($request > 0) {
            registerLog("Registro exitoso", "El rol se ha registrado correctamente, al momento de registrar un usuario", 2, $_SESSION['login_info']['idUser']);
            $data = array(
                "title" => "Registro exitoso",
                "message" => "El rol se ha registrado correctamente",
                "type" => "success",
                "status" => true
            );
            toJson($data);
        } else {
            registerLog("Ocurrió un error inesperado", "El rol no se ha registrado correctamente", 1, $_SESSION['login_info']['idRole']);
            $data = array(
                "title" => "Ocurrió un error inesperado",
                "message" => "El rol no se ha registrado correctamente",
                "type" => "error",
                "status" => false
            );
            toJson($data);
        }
    }
    /**
     * Función que devuelve los roles al select de la vista registro de roles.
     * @return void
     */
    public function getRolesSelect()
    {
        $arrData = $this->model->select_roles();
        // Eliminando el rol root para que no se pueda asignar desde la interfaz
        foreach ($arrData as $key => $value) {
            if ($value["idRole"] == 1) {
                unset($arrData[$key]); // Elimina el rol 1
                break;
            }
        }

        $arrData = array_values($arrData); // Reasigna los índices numéricos
        echo json_encode($arrData);
    }

    /**
     * Función que se encarga de eliminar un rol
     * @return void
     */
    public function deleteRoles()
    {
        permissionInterface(4);

        //Validacion de que el metodo sea DELETE
        if ($_SERVER["REQUEST_METHOD"] !== "DELETE") {
            registerLog("Ocurrió un error inesperado", "Metodo DELETE no encontrado, al momento de eliminar un rol", 1, $_SESSION['login_info']['idUser']);
            $data = array(
                "title" => "Ocurrió un error inesperado",
                "message" => "Metodo DELETE no encontrado",
                "type" => "error",
                "status" => false
            );
            toJson($data);
        }

        // Capturamos la solicitud enviada
        $request = json_decode(file_get_contents("php://input"), true);
        // Validación isCsrf
        isCsrf($request["token"]);
        // Validamos que la solicitud tenga los campos necesarios
        $id = strClean($request["id"]);
        $name = strClean($request["name"]);
        //validamos que los campos no esten vacios
        if ($id == "") {
            registerLog("Ocurrió un error inesperado", "El id del rol es requerido, al momento de eliminar un rol", 1, $_SESSION['login_info']['idUser']);
            $data = array(
                "title" => "Ocurrió un error inesperado",
                "message" => "El id del rol es requerido, refresca la página e intenta nuevamente",
                "type" => "error",
                "status" => false
            );
            toJson($data);
        }
        //validacion que solo ce acepte numeros en el campo id
        if (!is_numeric($id)) {
            registerLog("Ocurrió un error inesperado", "El id del rol debe ser numerico, al momento de eliminar un rol", 1, $_SESSION['login_info']['idUser']);
            $data = array(
                "title" => "Ocurrió un error inesperado",
                "message" => "El id del rol debe, ser numerico, refresca la página e intenta nuevamente",
                "type" => "error",
                "status" => false
            );
            toJson($data);
        }
        ///validamos que el id del rol exista en la base de datos
        $result = $this->model->select_rol_by_id($id);
        if (!$result) {
            registerLog("Ocurrió un error inesperado", "No se podra eliminar el usuario, ya que el id no existe en la base de datos", 1, $_SESSION['login_info']['idUser']);

            $data = array(
                "title" => "Ocurrió un error inesperado",
                "message" => "El id del rol no existe, refresque la página y vuelva a intentarlo",
                "type" => "error",
                "status" => false
            );
            toJson($data);
        }
        $request = $this->model->delete_role($id);
        if ($request) {
            registerLog("Eliminacion correcta", "Se elimino de manera correcta el rol {$name}", 2, $_SESSION['login_info']['idUser']);

            $data = array(
                "title" => "Eliminacion correcta",
                "message" => "Se elimino de manera correcta el rol {$name}",
                "type" => "success",
                "status" => true
            );
            toJson($data);
        } else {
            registerLog("Ocurrió un error inesperado", "No se pudo eliminar el rol {$name}, por favor intentalo nuevamente", 1, $_SESSION['login_info']['idUser']);

            $data = array(
                "title" => "Ocurrió un error inesperado",
                "message" => "No se logro eliminar de manera correcta el rol {$name}",
                "type" => "error",
                "status" => false
            );
            toJson($data);
        }
    }
    /**
     * Metodo que se encarga de actualizar un rol
     * @return void
     */
    public function updateRole()
    {
        permissionInterface(4);
        //validacion del metodo POST
        if (!$_POST) {
            registerLog("Ocurrió un error inesperado", "Metodo POST no encontrado, al momento de actualizar un rol", 1, $_SESSION['login_info']['idUser']);
            $data = array(
                "title" => "Ocurrió un error inesperado",
                "message" => "Método POST no encontrado",
                "type" => "error",
                "status" => false
            );
            toJson($data);
        }
        isCsrf(); //validacion de ataque CSRF
        //Captura de datos enviamos
        $update_txtId = strClean($_POST["update_txtId"]);
        $update_txtRoleName = strClean($_POST["update_txtRoleName"]);
        $update_txtRoleDescription = strClean($_POST["update_txtRoleDescription"]);
        $update_txtRoleStatus = strClean($_POST["update_txtRoleStatus"]);
        //validacion de los campos que no llegen vacios
        if ($update_txtId == "" || $update_txtRoleName == "" || $update_txtRoleStatus == "") {
            registerLog("Ocurrió un error inesperado", "Los campos no pueden estar vacios, al momento de actualizar un rol", 1, $_SESSION['login_info']['idUser']);
            $data = array(
                "title" => "Ocurrió un error inesperado",
                "message" => "Los campos no pueden estar vacios",
                "type" => "error",
                "status" => false
            );
            toJson($data);
        }
        //validacion de que el id sea numerico
        if (!is_numeric($update_txtId)) {
            registerLog("Ocurrió un error inesperado", "El id del rol debe ser numerico, al momento de actualizar un rol", 1, $_SESSION['login_info']['idUser']);
            $data = array(
                "title" => "Ocurrió un error inesperado",
                "message" => "El id del rol debe ser numerico",
                "type" => "error",
                "status" => false
            );
            toJson($data);
        }
        //validamos que los roles no sean mayores a 250 caracteres
        if (strlen($update_txtRoleName) > 50) {
            registerLog("Ocurrió un error inesperado", "El nombre del rol no puede ser mayor a 50 caracteres, al momento de actualizar un rol", 1, $_SESSION['login_info']['idUser']);
            $data = array(
                "title" => "Ocurrió un error inesperado",
                "message" => "El nombre del rol no puede ser mayor a 50 caracteres",
                "type" => "error",
                "status" => false
            );
            toJson($data);
        }
        //Validamos los caracteres permitidos en el nombre
        if (verifyData("[A-Za-zÁÉÍÓÚáéíóúÑñ\s]{4,250}", $update_txtRoleName)) {
            registerLog("Ocurrió un error inesperado", "El campo Nombre no cumple con el formato de texto al registrar un rol", 1, $_SESSION['login_info']['idUser']);
            $data = array(
                "title" => "Ocurrió un error inesperado",
                "message" => "El campo nombre no cumple con el formato de texto",
                "type" => "error",
                "status" => false
            );
            toJson($data);
        }
        if ($update_txtRoleDescription != "") {
            if (verifyData("[a-zA-ZÁÉÍÓÚáéíóúÜüÑñ0-9\s.,;:!?()-]+", $update_txtRoleDescription)) {
                registerLog("Ocurrió un error inesperado", "El campo Descripción no cumple con el formato de texto al registrar un rol", 1, $_SESSION['login_info']['idUser']);
                $data = array(
                    "title" => "Ocurrió un error inesperado",
                    "message" => "El campo nombre no cumple con el formato de texto",
                    "type" => "error",
                    "status" => false
                );
                toJson($data);
            }
        }
        //validamos que el id del rol exista en la base de datos
        $result = $this->model->select_rol_by_id($update_txtId);
        if (!$result) {
            registerLog("Ocurrió un error inesperado", "No se pudo actualizar el rol, ya que el id no existe en la base de datos", 1, $_SESSION['login_info']['idUser']);
            $data = array(
                "title" => "Ocurrió un error inesperado",
                "message" => "El id del rol no existe, refresque la página y vuelva a intentarlo",
                "type" => "error",
                "status" => false
            );
            toJson($data);
        }
        //registramos el rol en la base de datos
        $result = $this->model->update_role($update_txtId, $update_txtRoleName, $update_txtRoleDescription, $update_txtRoleStatus);
        if ($result) {
            registerLog("Rol actualizado", "Se actualizo la información del rol con el id: " . $update_txtId, 1, $_SESSION['login_info']['idUser']);
            $data = array(
                "title" => "Rol actualizado",
                "message" => "Se actualizo el rol con el id: " . $update_txtId,
                "type" => "success",
                "status" => true
            );
            toJson($data);
        } else {
            registerLog("Ocurrió un error inesperado", "No se pudo actualizar el rol, al momento de actualizar un rol", 1, $_SESSION['login_info']['idUser']);
            $data = array(
                "title" => "Ocurrió un error inesperado",
                "message" => "No se pudo actualizar el rol, al momento de actualizar un rol",
                "type" => "error",
                "status" => false
            );
            toJson($data);
        }
    }
    /**
     * Summary of getOptionsByRole
     * @return void
     */
    public function getOptionsByRoleAdd()
    {
        permissionInterface(4);
        if (!$_GET) {
            registerLog("Ocurrió un error inesperado", "Metodo GET no encontrado, al momento de obtener sus permisos solicitados", 1, $_SESSION['login_info']['idUser']);
            $data = array(
                "title" => "Ocurrió un error inesperado",
                "message" => "Metodo GET no encontrado",
                "type" => "error",
                "status" => false
            );
            toJson($data);
        }
        //almacenamos el id del rol
        $idRole = strClean($_GET["id"]);
        //validamos si el campo esta vacio
        if (empty($idRole)) {
            registerLog("Ocurrió un error inesperado", "El id del rol no puede estar vacio, al momento de obtener sus permisos solicitados", 1, $_SESSION['login_info']['idUser']);
            $data = array(
                "title" => "Ocurrió un error inesperado",
                "message" => "El id del rol no puede estar vacio, refresque la página y vuelva a intentarlo",
                "type" => "error",
                "status" => false
            );
            toJson($data);
        }
        //validamos si el id es numerico
        if (!is_numeric($idRole)) {
            registerLog("Ocurrió un error inesperado", "El id del rol no puede ser un caracter, al momento de obtener sus permisos solicitados", 1, $_SESSION['login_info']['idUser']);
            $data = array(
                "title" => "Ocurrió un error inesperado",
                "message" => "El id del rol no puede ser un caracter, refresque la página y vuelva a intentarlo",
                "type" => "error",
                "status" => false
            );
            toJson($data);
        }
        //consultamos en la base de datos por los permisos del rol
        $result = $this->model->select_permissions_by_role($idRole);
        toJson(["modules" => $result, "status" => true]);
    }
    /**
     * Funcion quye devuelve todas las opciones de los permisos si estan activos o no de aceurdo al rol
     * @return void
     */
    public function getOptionByRoleAll()
    {
        permissionInterface(4);
        //Validamos el metodo
        if (!$_GET) {
            registerLog("Ocurrió un error inesperado", "Metodo GET no encontrado, al momento de obtener sus permisos solicitados", 1, $_SESSION['login_info']['idUser']);
            $data = array(
                "title" => "Ocurrió un error inesperado",
                "message" => "Método GET no encontrado",
                "type" => "error",
                "status" => false
            );
            toJson($data);
        }
        //Capturamos el parametro enviado
        $id = strClean($_GET['id']);
        //validamos si el campo esta vacio
        if (empty($id)) {
            registerLog("Ocurrió un error inesperado", "El id del rol no puede estar vacio, al momento de obtener sus permisos solicitados", 1, $_SESSION['login_info']['idUser']);
            $data = array(
                "title" => "Ocurrió un error inesperado",
                "message" => "El id del rol no puede estar vacio, refresque la página y vuelva a intentarlo",
                "type" => "error",
                "status" => false
            );
            toJson($data);
        }
        //Validamos si el id es numerico
        if (!is_numeric($id)) {
            registerLog("Ocurrió un error inesperado", "El id del rol no puede ser un caracter, al momento de obtener sus permisos solicitados", 1, $_SESSION['login_info']['idUser']);
            $data = array(
                "title" => "Ocurrió un error inesperado",
                "message" => "El id del rol no puede ser un caracter, refresque la página y vuelva a intentarlo",
                "type" => "error",
                "status" => false
            );
            toJson($data);
        }
        //obtenemos los modulos e interfaces habilitadas
        $result = $this->model->selects_all_modules_and_interface($id);
        registerLog("Atencion a peticion de información", "Peticion de modulos activos y disponibles devuelyta correctamente: ss" . json_encode($result), 3, $_SESSION['login_info']['idUser']);
        toJson(['status' => true, 'modules' => $result]);
    }
    /**
     * Funcion que prepara el los permisos para el registro
     * @return void
     */
    public function preparePermission()
    {
        permissionInterface(4);
        if (!$_POST) {
            registerLog("Ocurrió un error inesperado, cierre de sesion forzado", "Metodo POST no encontrado, al momento de seleccionar un permiso", 1, $_SESSION['login_info']['idUser']);
            $data = array(
                "title" => "Ocurrió un error inesperado",
                "message" => "Metodo POST no encontrado",
                "type" => "error",
                "status" => false
            );
            toJson($data);
        }

        //recuperamos los inputs que se enviaron
        $idDetail = (isset($_POST['idDetail'])) ? strClean($_POST['idDetail']) : "Fail";
        $idRole = strClean($_POST['idRole']);
        $idInterface = strClean($_POST['idInterface']);
        $status = (isset($_POST['status'])) ? strClean($_POST['status']) : "Activo";

        //validamos si los campos enviados estan vacios
        if (empty($idDetail) || empty($idRole) || empty($idInterface) || empty($status)) {
            registerLog("Cierre de sesion forzado", "Alguno de los campos ah sido enviados vacios al servidor, se intento manipular los datos, por los que se procedera a cerrar sesion forzada", 1, $_SESSION['login_info']['idUser']);
            $data = array(
                "title" => "Ocurrió un error inesperado",
                "message" => "Se detecto problemas con la información enviada, enviando campos vacios, se procedera a cerrar sesion",
                "type" => "error",
                "status" => false
            );
            toJson($data);
        }

        if (!is_numeric($idRole) || !is_numeric($idInterface) || (!is_numeric($idDetail) && $idDetail != "Fail")) {
            registerLog("Cierre de sesion forzado", "Alguno de los campos ah sido enviados vulnerado su estructura al servidor, se intento manipular los datos, por los que se procedera a cerrar sesion forzada", 1, $_SESSION['login_info']['idUser']);
            $data = array(
                "title" => "Ocurrió un error inesperado",
                "message" => "Se detecto problemas con la información enviada, no cumple con el formato solicitado, se procederá a cerrar sesión",
                "type" => "error",
                "status" => false
            );
            toJson($data);
        }
        //procedemos almacenar los la informacon en una variable de sesion para poderla utilizar
        if (!isset($_SESSION["permission_data"])) {
            $_SESSION["permission_data"][0] = array(
                "idDetail" => $idDetail,
                "idRole" => $idRole,
                "idInterface" => $idInterface,
                "status" => $status
            );
        } else {
            //Buscamos en el array que no existan datos duplicados, si hubiese se motificaria el estado
            $count = 0;
            foreach ($_SESSION["permission_data"] as $key => $value) {
                if ($value["idRole"] == $idRole && $value["idInterface"] == $idInterface) {
                    $_SESSION["permission_data"][$key]["status"] = $status;
                    registerLog("Atencion alerta de información", "Se modifico o creo nuevo registro de los permisos, información detallada: " . json_encode($_SESSION["permission_data"]), 3, $_SESSION['login_info']['idUser']);
                    $data = array(
                        "title" => "Atencion alerta de información",
                        "message" => "Se modificó la información de permisos con éxito",
                        "type" => "info",
                        "status" => true
                    );
                    toJson($data);
                    exit;
                }
            }
            array_push($_SESSION["permission_data"], array("idDetail" => $idDetail, "idRole" => $idRole, "idInterface" => $idInterface, "status" => $status));
        }
        registerLog("Atencion alerta de información", "Se modifico o creo nuevo registro de los permisos, información detallada: " . json_encode($_SESSION["permission_data"]), 3, $_SESSION['login_info']['idUser']);
        $data = array(
            "title" => "Atencion alerta de información",
            "message" => "Se modificó la información de permisos con éxito",
            "type" => "info",
            "status" => true
        );
        toJson($data);
    }
    /**
     * Registro de la información de datos de cada permiso de cada rol
     * @return never
     */
    public function setDataPermission()
    {
        if (!isset($_SESSION["permission_data"])) {
            registerLog("Ocurrió un error inesperado", "No se ah hecho ninguna modificación en los permisos", 1, $_SESSION['login_info']['idUser']);
            $data = array(
                "title" => "Ocurrió un error inesperado",
                "message" => "No se selecciono ningún permiso o modifación",
                "type" => "error",
                "status" => false
            );
            toJson($data);
        }
        $arrData = $_SESSION["permission_data"];
        foreach ($arrData as $key => $value) {
            //Primero consultamos en la base de datos si existe el registro, para poder actualizarlo caso contrario se registrar
            $resultData = $this->model->select_userroldetail($value["idInterface"], $value["idRole"]);
            if ($resultData) {
                //Si en caso existiese el registro , actualizamos el estado
                $resultSetData = $this->model->update_status_interface_role_detail($value["idInterface"], $value["idRole"], $value["status"]);
            } else {
                //si en caso no hubiese un registro insertamos un nuevo registro
                $resultSetData = $this->model->insert_new_permission_role_detail($value["idInterface"], $value["idRole"], $value["status"]);
            }
        }
        registerLog("Registro de permisos correcto", "Se registro de manera correcta los permisos para el rol", 2, $_SESSION['login_info']['idUser']);

        $data = array(
            "title" => "Registro de permisos correcto",
            "message" => "Se registro de manera correcta los permisos para el rol",
            "type" => "success",
            "status" => true
        );
        unset($_SESSION["permission_data"]);
        toJson($data);
    }
}
