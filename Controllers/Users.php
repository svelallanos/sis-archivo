<?php

class Users extends Controllers
{
    /**
     * Constructor de la clase
     */
    public function __construct()
    {
        isSession();
        parent::__construct();
    }
    /**
     * Funcion que devuelve la vista de la gestion de usuarios
     * @return void
     */
    public function users()
    {
        $data['page_id'] = 3;
        permissionInterface($data['page_id']);
        $data['page_title'] = "Gestion de Usuarios";
        $data['page_description'] = "Te permite gestionar los usuarios que acceden al sistema";
        $data['page_container'] = "Users";
        $data['page_js_css'] = "users";
        registerLog("Información de navegación", "El usuario entro a :" . $data['page_title'], 3, $_SESSION['login_info']['idUser']);
        $this->views->getView($this, "users", $data);
    }
    /***
     * Esta función te permite abrir la vista del perfil de la cuenta del usuario
     */
    public function profile()
    {
        $data['page_id'] = 7;
        permissionInterface($data['page_id']);
        $data['page_title'] = "Perfil del Usuario";
        $data['page_description'] = "Te permite gestionar la configuración de tu cuenta";
        $data['page_container'] = "Users";
        $data['page_js_css'] = "profile";
        registerLog("Información de navegación", "El usuario entro a :" . $data['page_title'], 3, $_SESSION['login_info']['idUser']);
        $this->views->getView($this, "profile", $data);
    }

    /**
     * Funcion que desvuuelve la lista de los usuarios a la vista
     * @return void
     */
    public function getUsers()
    {
        permissionInterface(3);
        $arrData = $this->model->select_users();
        $cont = 1; //Contador para la tabla
        foreach ($arrData as $key => $value) {
            $arrData[$key]["u_user"] = decryption($value["u_user"]);
            $arrData[$key]["u_email"] = decryption($value["u_email"]);
            $arrData[$key]["cont"] = $cont;
            if ($value["idUser"] != 1) {
                $arrData[$key]["actions"] = ' 
                <div class="btn-group">               
                <button class="btn btn-success update-item" type="button"
                    data-id="' . $value["idUser"] . '"
                    data-fullname="' . $value["u_fullname"] . '"
                    data-dni="' . $value["u_dni"] . '"
                    data-gender="' . $value["u_gender"] . '"
                    data-email="' . decryption($value["u_email"]) . '"
                    data-user="' . decryption($value["u_user"]) . '"
                    data-password="' . decryption($value["u_password"]) . '"
                    data-rol="' . $value["r_name"] . '"
                    data-rolid="' . $value["role_id"] . '"
                    data-profile="' . $value["u_profile"] . '"
                    data-registrationDate="' . $value["u_registrationDate"] . '"
                    data-status="' . $value["u_status"] . '"
                    data-updateDate="' . $value["u_updateDate"] . '"
                ><i class="fa fa-pencil"></i></button>
                <button class="btn btn-info report-item" type="button"
                    data-id="' . $value["idUser"] . '"
                    data-fullname="' . $value["u_fullname"] . '"
                    data-dni="' . $value["u_dni"] . '"
                    data-gender="' . $value["u_gender"] . '"
                    data-email="' . decryption($value["u_email"]) . '"
                    data-user="' . decryption($value["u_user"]) . '"
                    data-password="' . decryption($value["u_password"]) . '"
                    data-rol="' . $value["r_name"] . '"
                    data-profile="' . $value["u_profile"] . '"
                    data-registrationDate="' . $value["u_registrationDate"] . '"
                    data-status="' . $value["u_status"] . '"
                    data-updateDate="' . $value["u_updateDate"] . '"
                ><i class="fa fa-user"></i></button>
                <a href="' . base_url() . '/pdf/user/' . encryption($value["idUser"]) . '" target="_Blank" class="btn btn-warning"><i class="fa fa-file-pdf"></i></a>
                <button class="btn btn-danger delete-item" data-id="' . $value["idUser"] . '" data-img="' . encryption($value["u_profile"]) . '"  data-fullname="' . $value["u_fullname"] . '" ><i class="fa fa-remove"></i></button>
                </div>
                '; //Botones de acciones
            } else {
                $arrData[$key]["actions"] = ' 
                 <div class="btn-group">
                <button class="btn btn-success update-item" 
                    data-id="' . $value["idUser"] . '"
                    data-fullname="' . $value["u_fullname"] . '"
                    data-dni="' . $value["u_dni"] . '"
                    data-gender="' . $value["u_gender"] . '"
                    data-email="' . decryption($value["u_email"]) . '"
                    data-user="' . decryption($value["u_user"]) . '"
                    data-password="' . decryption($value["u_password"]) . '"
                    data-rol="' . $value["r_name"] . '"
                    data-rolid="' . $value["role_id"] . '"
                    data-profile="' . $value["u_profile"] . '"
                    data-registrationDate="' . $value["u_registrationDate"] . '"
                    data-status="' . $value["u_status"] . '"
                    data-updateDate="' . $value["u_updateDate"] . '"                   
                type="button"><i class="fa fa-pencil"></i></button>
                <button class="btn btn-info report-item" 
                 data-id="' . $value["idUser"] . '"
                    data-fullname="' . $value["u_fullname"] . '"
                    data-dni="' . $value["u_dni"] . '"
                    data-gender="' . $value["u_gender"] . '"
                    data-email="' . decryption($value["u_email"]) . '"
                    data-user="' . decryption($value["u_user"]) . '"
                    data-password="' . decryption($value["u_password"]) . '"
                    data-rol="' . $value["r_name"] . '"
                    data-profile="' . $value["u_profile"] . '"
                    data-registrationDate="' . $value["u_registrationDate"] . '"
                    data-status="' . $value["u_status"] . '"
                    data-updateDate="' . $value["u_updateDate"] . '"
                type="button"><i class="fa fa-user"></i></button>
                 <a href="' . base_url() . '/pdf/user/' . encryption($value["idUser"]) . '" target="_Blank" class="btn btn-warning"><i class="fa fa-file-pdf"></i></a>
                 </div>
                ';
            }
            $cont++;
        }
        toJson($arrData);
    }
    /**
     * Funcion que permite el registro del usuario nuevo
     * @return void
     */
    public function setUser()
    {
        permissionInterface(3);

        //validacion del metodo POST
        if (!$_POST) {
            registerLog("Ocurrió un error inesperado", "Metodo POST no encontrado, al momento de registrar un usuario", 1, $_SESSION['login_info']['idUser']);
            $data = array(
                "title" => "Ocurrió un error inesperado",
                "message" => "Metodo POST no encontrado",
                "type" => "error",
                "status" => false
            );
            toJson($data);
        }
        isCsrf(); //validacion de ataque CSRF
        //validacion si se elecicono el tipo de genero
        if (!isset($_POST['txtGender'])) {
            registerLog("Ocurrió un error inesperado", "Debe seleccionar de manera obligatoria un genero, al momento de registrar un usuario", 1, $_SESSION['login_info']['idUser']);
            $data = array(
                "title" => "Ocurrió un error inesperado",
                "message" => "Debes seleccionar un genero",
                "type" => "error",
                "status" => false
            );
            toJson($data);
        }
        //limpiesa de los inputs
        $strFullName = strClean($_POST["txtFullName"]);
        $strDNI = strClean($_POST["txtDNI"]);
        $strGender = strClean($_POST["txtGender"]);
        $strUser = strClean($_POST["txtUser"]);
        $strEmail = strClean($_POST["txtEmail"]);
        $intRole = strClean($_POST["slctRole"]);
        $strPassword = strClean($_POST["txtPassword"]);
        $strProfile = ($_FILES) ? $_FILES["flPhoto"]["name"] : "";
        //validacion de campo si estan vacios
        if ($strFullName == "" || $strDNI == "" || $strGender == "" || $strUser == "" || $strEmail == "" || $intRole == "" || $strPassword == "") {
            registerLog("Ocurrió un error inesperado", "Es obligatorio llenar todos los campos, al momento de registrar un usuario", 1, $_SESSION['login_info']['idUser']);

            $data = array(
                "title" => "Error",
                "message" => "Todos los campos son obligatorios",
                "type" => "error",
                "status" => false
            );
            toJson($data);
        }
        //validacion de los formatos de texto que se ingresa en los campos
        if (verifyData("[A-ZÁÉÍÓÚÑa-záéíóúñ]+(\s[A-ZÁÉÍÓÚÑa-záéíóúñ]+)*", $strFullName)) {
            registerLog("Ocurrió un error inesperado", "El campo nombre no cumple con el formato de texto, al momento de registrar un usuario", 1, $_SESSION['login_info']['idUser']);
            $data = array(
                "title" => "Ocurrió un error inesperado",
                "message" => "El campo nombre no cumple con el formato de texto",
                "type" => "error",
                "status" => false
            );
            toJson($data);
        }
        if (verifyData("^\d{8}$", $strDNI)) {
            registerLog("Ocurrió un error inesperado", "El campo DNI no cumple con el formato de texto, al momento de registrar un usuario", 1, $_SESSION['login_info']['idUser']);
            $data = array(
                "title" => "Ocurrió un error inesperado",
                "message" => "El campo DNI no cumple con el formato de texto",
                "type" => "error",
                "status" => false
            );
            toJson($data);
        }
        if (verifyData("[a-zA-ZáéíóúÁÉÍÓÚñÑ]+", $strGender)) {
            registerLog("Ocurrió un error inesperado", "El campo género no cumple con el formato de texto, al momento de registrar un usuario", 1, $_SESSION['login_info']['idUser']);
            $data = array(
                "title" => "Ocurrió un error inesperado",
                "message" => "El campo género no cumple con el formato de texto",
                "type" => "error",
                "status" => false
            );
            toJson($data);
        }
        if (verifyData("[a-zA-Z0-9_-]{3,15}", $strUser)) {
            registerLog("Ocurrió un error inesperado", "El campo usuario no cumple con el formato de texto, al momento de registrar un usuario", 1, $_SESSION['login_info']['idUser']);
            $data = array(
                "title" => "Ocurrió un error inesperado",
                "message" => "El campo usuario no cumple con el formato de texto",
                "type" => "error",
                "status" => false
            );
            toJson($data);
        }
        if (verifyData("[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}", $strEmail)) {
            registerLog("Ocurrió un error inesperado", "El campo correo electrónico no cumple con el formato de texto, al momento de registrar un usuario", 1, $_SESSION['login_info']['idUser']);
            $data = array(
                "title" => "Ocurrió un error inesperado",
                "message" => "El campo correo electrónico no cumple con el formato de texto",
                "type" => "error",
                "status" => false
            );
            toJson($data);
        }
        //validacion que la contraseña pueda ingresar minimo 8 caracteres
        if (strlen($strPassword) < 8) {
            registerLog("Ocurrió un error inesperado", "La contraseña debe tener al menos 8 caracteres, al momento de registrar un usuario", 1, $_SESSION['login_info']['idUser']);
            $data = array(
                "title" => "Ocurrió un error inesperado",
                "message" => "La contraseña debe tener al menos 8 caracteres",
                "type" => "error",
                "status" => false
            );
            toJson($data);
        }
        //Encriptando informacion sensible
        $strUser = encryption($strUser); //encrypt user
        $strPassword = encryption($strPassword); //encrypt password
        $strEmail = encryption($strEmail); //encrypt email
        //proceso de subida de la imagen de perfil al servidor
        if (isset($_FILES["flPhoto"]["name"]) && !empty($_FILES["flPhoto"]["name"])) {
            //Valdiacion de  tipos de imagen para subir
            if (isFile("image", $_FILES["flPhoto"], ["jpg", "png", "jpeg"])) {
                registerLog("Ocurrió un error inesperado", "Para subir fotos de perfil para los usuarios solo se permite fotos de tipo JPEG, JPG, PNG", 1, $_SESSION['login_info']['idUser']);
                $data = array(
                    "title" => "Ocurrió un error inesperado",
                    "message" => "El formato de la imagen no cumple con los formatos solicitados",
                    "type" => "error",
                    "status" => false
                );
                toJson($data);
            }
            //Validacion de que la ruta de la imagen exista y si que se cree
            $ruta = getRoute() . "Profile/Users/";
            if (verifyFolder($ruta, 0777, true)) {
                registerLog("Informacion de subida de archivos", "El usuario subio una foto de perfil, donde se valido que exista la ruta solicitada para subir el archivo", 3, $_SESSION['login_info']['idUser']);
            }
            //preparamos la ruta final para subir al servidor
            $nameFinalPhoto = uniqid() . "." . pathinfo($strProfile, PATHINFO_EXTENSION);
            $rutaFinal = $ruta . $nameFinalPhoto;
            //Subimos la imagen al servidor
            $request_moveFile = resizeAndCompressImage($_FILES["flPhoto"]["tmp_name"], $rutaFinal, 0.5, 100, 100);
            if (!$request_moveFile) {
                registerLog("Registro exitoso", "No se logro subir la foto de perfil al momento de registrar el usuario", 2, $_SESSION['login_info']['idUser']);
                $data = array(
                    "title" => "Ocurrió un error inesperado",
                    "message" => "No se logro subir la foto de perfil",
                    "type" => "success",
                    "status" => true
                );
                toJson($data);
            }
            $strProfile = $nameFinalPhoto; //se asigna el nombre de la imagen a la variable
        }

        $request = $this->model->insert_user($strUser, $strPassword, $strEmail, $strProfile, $strFullName, $strGender, $strDNI, $intRole); //insert user in database
        if ($request > 0) {
            registerLog("Registro exitoso", "El usuario se ha registrado correctamente, al momento de registrar un usuario", 2, $_SESSION['login_info']['idUser']);
            $data = array(
                "title" => "Registro exitoso",
                "message" => "El usuario se ha registrado correctamente",
                "type" => "success",
                "status" => true
            );
            toJson($data);
        } else {
            registerLog("Ocurrió un error inesperado", "El usuario no se ha registrado correctamente", 1, $_SESSION['login_info']['idUser']);
            $data = array(
                "title" => "Ocurrió un error inesperado",
                "message" => "El usuario no se ha registrado correctamente",
                "type" => "error",
                "status" => false
            );
            toJson($data);
        }
    }
    /**
     * Funcion que se encarga de eliminar un usuario
     * @return void
     */
    public function deleteUser()
    {
        permissionInterface(3);

        //Validacion de que el metodo sea DELETE     
        if ($_SERVER["REQUEST_METHOD"] != "DELETE") {
            registerLog("Ocurrió un error inesperado", "Metodo DELETE no encontrado, al momento de eliminar un usuario", 1, $_SESSION['login_info']['idUser']);
            $data = array(
                "title" => "Ocurrió un error inesperado",
                "message" => "Metodo DELETE no encontrado",
                "type" => "error",
                "status" => false
            );
            toJson($data);
        }
        //capturamos la solicitud enviada
        $request = json_decode(file_get_contents("php://input"), true); //convertimos la solicitud a un array
        //validacion isCsrf
        isCsrf($request["token"]);
        //validamos que la soslicitud tenga los campos necesarios
        $id = strClean($request["id"]);
        $fullName = strClean($request["fullname"]);
        $img = strClean($request["img"]);
        //validamos que los campos no esten vacios
        if ($id == "" || $img == "") {
            registerLog("Ocurrió un error inesperado", "El id del usuario es requerido, al momento de eliminar un usuario", 1, $_SESSION['login_info']['idUser']);
            $data = array(
                "title" => "Ocurrió un error inesperado",
                "message" => "El id del usuario es requerido, refresca la pagina e intenta nuevamente",
                "type" => "error",
                "status" => false
            );
            toJson($data);
        }
        //validacion que solo ce acepte numeros en el campo id
        if (!is_numeric($id)) {
            registerLog("Ocurrió un error inesperado", "El id del usuario debe ser numerico, al momento de eliminar un usuario", 1, $_SESSION['login_info']['idUser']);
            $data = array(
                "title" => "Ocurrió un error inesperado",
                "message" => "El id del usuario debe, ser numerico, refresca la pagina e intenta nuevamente",
                "type" => "error",
                "status" => false
            );
            toJson($data);
        }
        ///validamos que el id del usuario exista en la base de datos
        $result = $this->model->select_user_by_Id($id);
        if (!$result) {
            registerLog("Ocurrió un error inesperado", "No se podra eliminar el usuario, ya que el id no existe en la base de datos", 1, $_SESSION['login_info']['idUser']);

            $data = array(
                "title" => "Ocurrió un error inesperado",
                "message" => "El id del usuario no existe, refresque la pagina y vuelva a intentarlo",
                "type" => "error",
                "status" => false
            );
            toJson($data);
        }
        //Realizamos la eliminacion del usuario, en la base de datos
        $request = $this->model->delete_user($id);
        if ($request > 0) {
            //Pprocedemos a eliminar la imagen del usuario
            $img = decryption($img);
            $ruta = getRoute() . "Profile/Users";
            if (delFolder($ruta, $img)) {
                registerLog("Atención", "No se pudo eliminar la imagen del usuario, al momento de eliminar un usuario, pero si se elimino el usuario, posiblemente porque no existe el archivo", 3, $_SESSION['login_info']['idUser']);
                $data = array(
                    "title" => "Atención",
                    "message" => "No se logro eliminar la imagen de perfil, pero si se elimino el usuario",
                    "type" => "info",
                    "status" => true
                );
                toJson($data);
            }
            registerLog("Eliminacion exitosa", "El usuario con id {$id} y nombre {$fullName} se ha eliminado correctamente", 2, $_SESSION['login_info']['idUser']);
            $data = array(
                "title" => "Eliminacion exitosa",
                "message" => "El usuario con id '{$id}' y nombre '{$fullName}' se ha eliminado correctamente",
                "type" => "success",
                "status" => true
            );
            toJson($data);
        } else {
            registerLog("Ocurrió un error inesperado", "No se pudo eliminar el usuario con id {$id} y nombre {$fullName}", 1, $_SESSION['login_info']['idUser']);
            $data = array(
                "title" => "Ocurrió un error inesperado",
                "message" => "No se pudo eliminar el usuario con id {$id} y nombre {$fullName}",
                "type" => "error",
                "status" => false
            );
            toJson($data);
        }
    }
    /**
     * Funcion que se encarga de actualizar un usuario
     * @return void
     */
    public function updateUser()
    {
        permissionInterface(3);
        //validacion del metodo POST
        if (!$_POST) {
            registerLog("Ocurrió un error inesperado", "Metodo POST no encontrado, al momento de actualizar un usuario", 1, $_SESSION['login_info']['idUser']);
            $data = array(
                "title" => "Ocurrió un error inesperado",
                "message" => "Metodo POST no encontrado",
                "type" => "error",
                "status" => false
            );
            toJson($data);
        }
        isCsrf(); //validacion de ataque CSRF        
        /**
         * Proceso de actualizacion deusuarios
         */
        //validacion si se elecicono el tipo de genero
        if (!isset($_POST['update_txtGender'])) {
            registerLog("Ocurrió un error inesperado", "Debe seleccionar de manera obligatoria un genero, al momento de actualizar un usuario", 1, $_SESSION['login_info']['idUser']);
            $data = array(
                "title" => "Ocurrió un error inesperado",
                "message" => "Debes seleccionar un genero",
                "type" => "error",
                "status" => false
            );
            toJson($data);
        }
        if (!isset($_POST["update_slctStatus"])) {
            registerLog("Ocurrió un error inesperado", "Debe seleccionar de manera obligatoria un estado, al momento de actualizar un usuario", 1, $_SESSION['login_info']['idUser']);
            $data = array(
                "title" => "Ocurrió un error inesperado",
                "message" => "Debes seleccionar un estado del usuario",
                "type" => "error",
                "status" => false
            );
            toJson($data);
        }
        //limpiesa de los inputs
        $intId = strClean($_POST["update_txtId"]);
        $strFullName = strClean($_POST["update_txtFullName"]);
        $strDNI = strClean($_POST["update_txtDNI"]);
        $strGender = strClean($_POST["update_txtGender"]);
        $strUser = strClean($_POST["update_txtUser"]);
        $strEmail = strClean($_POST["update_txtEmail"]);
        $intRole = ($intId == 1) ? 1 : strClean($_POST["update_slctRole"]);
        $strPassword = strClean($_POST["update_txtPassword"]);
        $strFotoActual = $_POST["update_txtFotoActual"];
        $strProfile = ($_FILES) ? $_FILES["update_flPhoto"]["name"] : "";
        $slctStatus = strClean($_POST["update_slctStatus"]);
        //validacion de campo si estan vacios
        if ($strFullName == "" || $slctStatus == "" || $strDNI == "" || $strGender == "" || $strUser == "" || $strEmail == "" || $intRole == "" || $strPassword == "") {
            registerLog("Ocurrió un error inesperado", "Es obligatorio llenar todos los campos, al momento de actualizar un usuario", 1, $_SESSION['login_info']['idUser']);

            $data = array(
                "title" => "Error",
                "message" => "Todos los campos son obligatorios",
                "type" => "error",
                "status" => false
            );
            toJson($data);
        }
        //validacion que el id sea numerico
        if (!is_numeric($intId)) {
            registerLog("Ocurrió un error inesperado", "El id debe ser numerico, al momento de actualizar un usuario", 1, $_SESSION['login_info']['idUser']);
            $data = array(
                "title" => "Ocurrió un error inesperado",
                "message" => "El id debe ser numerico, refresque la pagina y vuelva a intentarlo",
                "type" => "error",
                "status" => false
            );
            toJson($data);
        }
        //validacion de los formatos de texto que se ingresa en los campos
        if (verifyData("[A-ZÁÉÍÓÚÑa-záéíóúñ]+(\s[A-ZÁÉÍÓÚÑa-záéíóúñ]+)*", $strFullName)) {
            registerLog("Ocurrió un error inesperado", "El campo nombre no cumple con el formato de texto, al momento de actualizar un usuario", 1, $_SESSION['login_info']['idUser']);
            $data = array(
                "title" => "Ocurrió un error inesperado",
                "message" => "El campo nombre no cumple con el formato de texto",
                "type" => "error",
                "status" => false
            );
            toJson($data);
        }
        if (verifyData("^\d{8}$", $strDNI)) {
            registerLog("Ocurrió un error inesperado", "El campo DNI no cumple con el formato de texto, al momento de actualizar un usuario", 1, $_SESSION['login_info']['idUser']);
            $data = array(
                "title" => "Ocurrió un error inesperado",
                "message" => "El campo DNI no cumple con el formato de texto",
                "type" => "error",
                "status" => false
            );
            toJson($data);
        }
        if (verifyData("[a-zA-ZáéíóúÁÉÍÓÚñÑ]+", $strGender)) {
            registerLog("Ocurrió un error inesperado", "El campo género no cumple con el formato de texto, al momento de actualizar un usuario", 1, $_SESSION['login_info']['idUser']);
            $data = array(
                "title" => "Ocurrió un error inesperado",
                "message" => "El campo género no cumple con el formato de texto",
                "type" => "error",
                "status" => false
            );
            toJson($data);
        }
        if (verifyData("[a-zA-Z0-9_-]{3,15}", $strUser)) {
            registerLog("Ocurrió un error inesperado", "El campo usuario no cumple con el formato de texto, al momento de actualizar un usuario", 1, $_SESSION['login_info']['idUser']);
            $data = array(
                "title" => "Ocurrió un error inesperado",
                "message" => "El campo usuario no cumple con el formato de texto",
                "type" => "error",
                "status" => false
            );
            toJson($data);
        }
        if (verifyData("[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}", $strEmail)) {
            registerLog("Ocurrió un error inesperado", "El campo correo electrónico no cumple con el formato de texto, al momento de actualizar un usuario", 1, $_SESSION['login_info']['idUser']);
            $data = array(
                "title" => "Ocurrió un error inesperado",
                "message" => "El campo correo electrónico no cumple con el formato de texto",
                "type" => "error",
                "status" => false
            );
            toJson($data);
        }
        //validacion que la contraseña pueda ingresar minimo 8 caracteres
        if (strlen($strPassword) < 8) {
            registerLog("Ocurrió un error inesperado", "La contraseña debe tener al menos 8 caracteres, al momento de actualizar un usuario", 1, $_SESSION['login_info']['idUser']);
            $data = array(
                "title" => "Ocurrió un error inesperado",
                "message" => "La contraseña debe tener al menos 8 caracteres",
                "type" => "error",
                "status" => false
            );
            toJson($data);
        }
        //validacion que usuario exista en la base de datos
        $result = $this->model->select_user_by_Id($intId);
        if (!$result) {
            registerLog("Ocurrió un error inesperado", "No se podra actualizar el usuario, ya que el id no existe en la base de datos", 1, $_SESSION['login_info']['idUser']);

            $data = array(
                "title" => "Ocurrió un error inesperado",
                "message" => "El id del usuario no existe, refresque la pagina y vuelva a intentarlo",
                "type" => "error",
                "status" => false
            );
            toJson($data);
        }
        //Encriptando informacion sensible       
        if ($strPassword == "") {
            $strPassword = $result['u_password'];
        } else {
            $strPassword = encryption($strPassword); //encrypt user
        }
        //Encriptando informacion sensible
        $strUser = encryption($strUser); //encrypt user
        $strEmail = encryption($strEmail); //encrypt email
        //proceso de subida de la imagen de perfil al servidor
        if (isset($_FILES["update_flPhoto"]["name"]) && !empty($_FILES["update_flPhoto"]["name"])) {
            //Validacion de  tipos de imagen para subir
            if (isFile("image", $_FILES["update_flPhoto"], ["jpg", "png", "jpeg"])) {
                registerLog("Ocurrió un error inesperado", "Para subir fotos de perfil para los usuarios solo se permite fotos de tipo JPEG, JPG, PNG", 1, $_SESSION['login_info']['idUser']);
                $data = array(
                    "title" => "Ocurrió un error inesperado",
                    "message" => "El formato de la imagen no cumple con los formatos solicitados",
                    "type" => "error",
                    "status" => false
                );
                toJson($data);
            }
            //Validacion de que la ruta de la imagen exista y si que se cree
            $ruta = getRoute() . "Profile/Users/";
            if (verifyFolder($ruta, 0777, true)) {
                registerLog("Informacion de subida de archivos", "El usuario subio una foto de perfil, donde se valido que exista la ruta solicitada para subir el archivo", 3, $_SESSION['login_info']['idUser']);
            }
            //preparamos la ruta final para subir al servidor
            $nameFinalPhoto = uniqid() . "." . pathinfo($strProfile, PATHINFO_EXTENSION);
            $rutaFinal = $ruta . $nameFinalPhoto;
            //Subimos la imagen al servidor
            $request_moveFile = resizeAndCompressImage($_FILES["update_flPhoto"]["tmp_name"], $rutaFinal, 0.5, 100, 100);
            if (!$request_moveFile) {
                registerLog("Registro exitoso", "No se logro subir la foto de perfil al momento de actualizar el usuario", 2, $_SESSION['login_info']['idUser']);
                $data = array(
                    "title" => "Ocurrió un error inesperado",
                    "message" => "No se logro subir la foto de perfil",
                    "type" => "success",
                    "status" => true
                );
                toJson($data);
            }
            //eliminar la imagen anterior
            $ruta = getRoute() . "Profile/Users";
            if (delFolder($ruta, $strFotoActual)) {
                registerLog("Atención", "No se pudo eliminar la imagen anterior del usuario, al momento de eliminar un usuario", 1, $_SESSION['login_info']['idUser']);
                $data = array(
                    "title" => "Ocurrió un error inesperado",
                    "message" => "No se logro eliminar la imagen de perfil",
                    "type" => "error",
                    "status" => false
                );
                toJson($data);
            }
            $strProfile = $nameFinalPhoto; //se asigna el nombre de la imagen a la variable
        } else {
            $strProfile = $strFotoActual; //se asigna el nombre de la imagen a la variable
        }
        //Profeso de actualizacion de datos
        $request = $this->model->update_user($intId, $strUser, $strPassword, $strEmail, $strProfile, $strFullName, $strGender, $strDNI, $intRole, $slctStatus); //insert user in database
        if ($request > 0) {
            registerLog("Registro exitoso", "El usuario se ha registrado correctamente, al momento de actualizar un usuario", 2, $_SESSION['login_info']['idUser']);
            $data = array(
                "title" => "Registro exitoso",
                "message" => "El usuario se ha actualizado correctamente",
                "type" => "success",
                "status" => true
            );
            toJson($data);
        } else {
            registerLog("Ocurrió un error inesperado", "El usuario no se ha actualizado correctamente", 1, $_SESSION['login_info']['idUser']);
            $data = array(
                "title" => "Ocurrió un error inesperado",
                "message" => "El usuario no se ha registrado correctamente",
                "type" => "error",
                "status" => false
            );
            toJson($data);
        }

    }
    public function updateProfile()
    {
        permissionInterface(7);
        //validacion del metodo POST
        if (!$_POST) {
            registerLog("Ocurrió un error inesperado", "Metodo POST no encontrado, al momento de actualizar un usuario", 1, $_SESSION['login_info']['idUser']);
            $data = array(
                "title" => "Ocurrió un error inesperado",
                "message" => "Metodo POST no encontrado",
                "type" => "error",
                "status" => false
            );
            toJson($data);
        }
        isCsrf(); //validacion de ataque CSRF
        /**
         * Proceso de actualizado de perfil de un usuario
         */
        //validacion si se elecicono el tipo de genero
        if (!isset($_POST['update_txtGender'])) {
            registerLog("Ocurrió un error inesperado", "Debe seleccionar de manera obligatoria un genero, al momento de actualizar su informacion del perfil", 1, $_SESSION['login_info']['idUser']);
            $data = array(
                "title" => "Ocurrió un error inesperado",
                "message" => "Debes seleccionar un genero",
                "type" => "error",
                "status" => false
            );
            toJson($data);
        }
        //recibimos los datos del formulario
        $intId = $_SESSION['login_info']['idUser'];//id del usuario
        $strFullName = strClean($_POST["update_txtFullName"]);
        $strDNI = strClean($_POST["update_txtDNI"]);
        $strGender = strClean($_POST["update_txtGender"]);
        $strUser = strClean($_POST["update_txtUser"]);
        $strEmail = strClean($_POST["update_txtEmail"]);
        $strProfile = ($_FILES) ? $_FILES["update_flPhoto"]["name"] : "";
        $strPassword = strClean($_POST["update_txtPassword"]);
        $strFotoActual = $_POST["update_txtFotoActual"];
        //validamos que los campos esten llenos
        if (empty($strFullName) || empty($strDNI) || empty($strGender) || empty($strUser) || empty($strEmail)) {
            registerLog("Ocurrió un error inesperado", "Debe llenar todos los campos obligatoriamente, al momento de actualizar su perfil de usuario", 1, $_SESSION['login_info']['idUser']);
            $data = array(
                "title" => "Ocurrió un error inesperado",
                "message" => "Debes llenar todos los campos obligatoriamente",
                "type" => "error",
                "status" => false
            );
            toJson($data);
        }
        //validacion de los formatos de texto que se ingresa en los campos
        if (verifyData("[A-ZÁÉÍÓÚÑa-záéíóúñ]+(\s[A-ZÁÉÍÓÚÑa-záéíóúñ]+)*", $strFullName)) {
            registerLog("Ocurrió un error inesperado", "El campo nombre no cumple con el formato de texto, al momento de actualizar un usuario", 1, $_SESSION['login_info']['idUser']);
            $data = array(
                "title" => "Ocurrió un error inesperado",
                "message" => "El campo nombre no cumple con el formato de texto",
                "type" => "error",
                "status" => false
            );
            toJson($data);
        }
        if (verifyData("^\d{8}$", $strDNI)) {
            registerLog("Ocurrió un error inesperado", "El campo DNI no cumple con el formato de texto, al momento de actualizar un usuario", 1, $_SESSION['login_info']['idUser']);
            $data = array(
                "title" => "Ocurrió un error inesperado",
                "message" => "El campo DNI no cumple con el formato de texto",
                "type" => "error",
                "status" => false
            );
            toJson($data);
        }
        if (verifyData("[a-zA-ZáéíóúÁÉÍÓÚñÑ]+", $strGender)) {
            registerLog("Ocurrió un error inesperado", "El campo género no cumple con el formato de texto, al momento de actualizar un usuario", 1, $_SESSION['login_info']['idUser']);
            $data = array(
                "title" => "Ocurrió un error inesperado",
                "message" => "El campo género no cumple con el formato de texto",
                "type" => "error",
                "status" => false
            );
            toJson($data);
        }
        if (verifyData("[a-zA-Z0-9_-]{3,15}", $strUser)) {
            registerLog("Ocurrió un error inesperado", "El campo usuario no cumple con el formato de texto, al momento de actualizar un usuario", 1, $_SESSION['login_info']['idUser']);
            $data = array(
                "title" => "Ocurrió un error inesperado",
                "message" => "El campo usuario no cumple con el formato de texto",
                "type" => "error",
                "status" => false
            );
            toJson($data);
        }
        if (verifyData("[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}", $strEmail)) {
            registerLog("Ocurrió un error inesperado", "El campo correo electrónico no cumple con el formato de texto, al momento de actualizar un usuario", 1, $_SESSION['login_info']['idUser']);
            $data = array(
                "title" => "Ocurrió un error inesperado",
                "message" => "El campo correo electrónico no cumple con el formato de texto",
                "type" => "error",
                "status" => false
            );
            toJson($data);
        }
        //validacion que la contraseña pueda ingresar minimo 8 caracteres
        if ($strPassword != "" && strlen($strPassword) < 8) {
            registerLog("Ocurrió un error inesperado", "La contraseña debe tener al menos 8 caracteres, al momento de actualizar un usuario", 1, $_SESSION['login_info']['idUser']);
            $data = array(
                "title" => "Ocurrió un error inesperado",
                "message" => "La contraseña debe tener al menos 8 caracteres",
                "type" => "error",
                "status" => false
            );
            toJson($data);
        }

        //validacion que usuario exista en la base de datos
        $result = $this->model->select_user_by_Id($intId);
        if (!$result) {
            registerLog("Ocurrió un error inesperado", "No se podra actualizar el perfil del usuario, ya que el id no existe en la base de datos", 1, $_SESSION['login_info']['idUser']);

            $data = array(
                "title" => "Ocurrió un error inesperado",
                "message" => "El id del usuario no existe, refresque la pagina y vuelva a intentarlo",
                "type" => "error",
                "status" => false
            );
            toJson($data);
        }
        //Encriptando informacion sensible       
        if ($strPassword == "") {
            $strPassword = $result['u_password'];
        } else {
            $strPassword = encryption($strPassword); //encrypt user
        }
        $strUser = encryption($strUser); //encrypt user
        $strEmail = encryption($strEmail); //encrypt email
        //proceso de subida de la imagen de perfil al servidor
        if (isset($_FILES["update_flPhoto"]["name"]) && !empty($_FILES["update_flPhoto"]["name"])) {
            //Validacion de  tipos de imagen para subir
            if (isFile("image", $_FILES["update_flPhoto"], ["jpg", "png", "jpeg"])) {
                registerLog("Ocurrió un error inesperado", "Para subir fotos de perfil para los usuarios solo se permite fotos de tipo JPEG, JPG, PNG", 1, $_SESSION['login_info']['idUser']);
                $data = array(
                    "title" => "Ocurrió un error inesperado",
                    "message" => "El formato de la imagen no cumple con los formatos solicitados",
                    "type" => "error",
                    "status" => false
                );
                toJson($data);
            }
            //validacion de tamaño permitido para imagen
            $sizeFile = $_FILES["update_flPhoto"]["size"];
            if (valConvert($sizeFile)["Mb"] > 2) {
                registerLog("Ocurrió un error inesperado", "La imagen es muy grande, el tamaño permitido es de 2MB, para la foto de perfil", 1, $_SESSION['login_info']['idUser']);
                $data = array(
                    "title" => "Ocurrió un error inesperado",
                    "message" => "La imagen es muy grande, el tamaño permitido es de 2MB",
                    "type" => "error",
                    "status" => false
                );
                toJson($data);
            }
            //Validacion de que la ruta de la imagen exista y si que se cree
            $ruta = getRoute() . "Profile/Users/";
            if (verifyFolder($ruta, 0777, true)) {
                registerLog("Informacion de subida de archivos", "El usuario subio una foto de perfil, donde se valido que exista la ruta solicitada para subir el archivo", 3, $_SESSION['login_info']['idUser']);
            }
            //preparamos la ruta final para subir al servidor
            $nameFinalPhoto = $strUser . "-" . $strProfile;
            $rutaFinal = $ruta . $nameFinalPhoto;
            //Subimos la imagen al servidor
            $request_moveFile = move_uploaded_file($_FILES["update_flPhoto"]["tmp_name"], $rutaFinal);
            if (!$request_moveFile) {
                registerLog("Registro exitoso", "No se logro subir la foto de perfil al momento de actualizar el perfil del usuario", 2, $_SESSION['login_info']['idUser']);
                $data = array(
                    "title" => "Ocurrió un error inesperado",
                    "message" => "No se logro subir la foto de perfil",
                    "type" => "success",
                    "status" => true
                );
                toJson($data);
            }
            //eliminar la imagen anterior
            $ruta = getRoute() . "Profile/Users";
            if (delFolder($ruta, $strFotoActual)) {
                registerLog("Atención", "No se pudo eliminar la imagen anterior del usuario, al momento de actualizar su perfil de usuario", 1, $_SESSION['login_info']['idUser']);
                $data = array(
                    "title" => "Ocurrió un error inesperado",
                    "message" => "No se logro eliminar la imagen de perfil",
                    "type" => "error",
                    "status" => false
                );
                toJson($data);
            }
            $strProfile = $nameFinalPhoto; //se asigna el nombre de la imagen a la variable
        } else {
            $strProfile = $strFotoActual; //se asigna el nombre de la imagen a la variable
        }

        //proceso de actualizacion de datos
        $request = $this->model->update_user($intId, $strUser, $strPassword, $strEmail, $strProfile, $strFullName, $strGender, $strDNI); //insert user in database
        if ($request > 0) {
            registerLog("Registro exitoso", "El perfil de usuario se ah actualizado correctamente, al momento de actualizar un usuario", 2, $_SESSION['login_info']['idUser']);
            $data = array(
                "title" => "Registro exitoso",
                "message" => "El perfil del usuario se ha actualizado correctamente, cierre sesion para que se apliquen los cambios",
                "type" => "success",
                "status" => true
            );
            toJson($data);
        } else {
            registerLog("Ocurrió un error inesperado", "El perfil del usuario no se ha actualizado correctamente", 1, $_SESSION['login_info']['idUser']);
            $data = array(
                "title" => "Ocurrió un error inesperado",
                "message" => "El usuario no se ha registrado correctamente",
                "type" => "error",
                "status" => false
            );
            toJson($data);
        }
    }
}
