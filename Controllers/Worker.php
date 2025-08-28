<?php

class Worker extends Controllers
{
    /**
     * Costructor que verifica que el usuario este logueado
     */
    public function __construct()
    {
        isSession();
        parent::__construct();
    }
    /**
     * Metodo que se encarga de cargar la vista de los trabajadores
     * @return void
     */
    public function worker()
    {
        $data['page_id'] = 16;
        permissionInterface($data['page_id']);
        $data['page_title'] = "Gestión de Trabajadores";
        $data['page_description'] = "Te permite gestionar los trabajadores de la empresa, puedes agregar, editar, eliminar y ver los trabajadores registrados.";
        $data['page_container'] = "Worker";
        $data['page_js_css'] = "worker";
        $data['jobtitle'] = $this->model->getAllJobtitle();
        registerLog("Información de navegación", "El usuario entro a :" . $data['page_title'], 3, $_SESSION['login_info']['idUser']);
        $this->views->getView($this, "worker", $data);
    }
    /**
     * Metodo que se encarga de cargar la vista de la categoria
     * @return void
     */
    public function getWorker()
    {
        permissionInterface(16);
        $arrData = $this->model->select_worker();
        $auxArrData = $this->model->getAllJobtitle();

        foreach ($auxArrData as $value) {
            $arrJobtitle[$value['id']] = $value['name'];
        }

        // toJson($arrData);
        //requerimos el modelo file
        require_once "./Models/FileModel.php";
        $fileModel = new FileModel();

        $cont = 1; //Contador para la tabla
        foreach ($arrData as $key => $value) {
            $arrData[$key]["cont"] = $cont;

            //agregamos un badge para el estado
            if ($value["status"] == 'ACTIVO') {
                $arrData[$key]["status_badge"] = '<span class="badge badge-success"> <i class="fa fa-check"></i> ACTIVO</span>';
            } else {
                $arrData[$key]["status_badge"] = '<span class="badge badge-danger"> <i class="fa fa-close"></i> INACTIVO</span>';
            }

            $arrFiles = $fileModel->select_file_search_for_id_and_table($value["idPeople"], "tb_people");
            if (empty($arrFiles)) {
                $imgProfile = base_url() . "/loadfile/people/?f=clientes.png";
            } else {
                $imgProfile = base_url() . "/loadfile/people/?f=" . $arrFiles['name'];
            }
            unset($arrFiles);

            if ($value['typePeople'] === "NATURAL") {
                $arrData[$key]["fullname"] = $value["name"] . " " . $value["lastname"];
            } else {
                $arrData[$key]["fullname"] = $value["fullname"];
            }

            $arrData[$key]["actions"] = '
            <div class="btn-group">
                <button class="btn btn-success update-item" title="Editar registro" 
                data-id="' . $value["id"] . '" 
                data-idPeople="' . $value["idPeople"] . '"
                data-dni="' . $value["dni"] . '"
                data-jobtitle="' . $value["idJobtitle"] . '"
                data-fullname = "' . $value["fullname"] . '" 
                data-account = "' . $value["account"] . '" 
                data-account2 = "' . $value["account2"] . '" 
                data-account3 = "' . $value["account3"] . '" 
                data-account4 = "' . $value["account4"] . '" 
                data-status="' . $value["status"] . '"  
                type="button"><i class="fa fa-pencil"></i></button>

                <button class="btn btn-info report-item" title="Ver reporte" 
                data-id="' . $value["id"] . '" 
                data-fullname="' . $value["fullname"] . '" 
                data-name="' . $value["name"] . '"
                data-typepeople="' . $value["typePeople"] . '"
                data-lastname="' . $value["lastname"] . '"
                data-dni="' . $value["dni"] . '"
                data-gender="' . $value["gender"] . '"
                data-birthdate="' . $value["birthdate"] . '"
                data-mail="' . $value["mail"] . '"
                data-address="' . $value["address"] . '"
                data-phone="' . $value["phone"] . '"
                data-jobtitle="' . $arrJobtitle[$value["idJobtitle"]] . '"
                data-account="' . $value["account"] . '" 
                data-account2 = "' . $value["account2"] . '" 
                data-account3 = "' . $value["account3"] . '" 
                data-account4 = "' . $value["account4"] . '" 
                data-imgProfile="' . $imgProfile . '"
                data-status="' . $value["status"] . '"  
                data-registrationDate="' . dateFormat($value['dateRegistration']) . '" 
                data-updateDate="' . dateFormat($value['dateUpdate']) . '" 
                type="button"><i class="fa fa-exclamation-circle" aria-hidden="true"></i></button>
                 
                <button class="btn btn-danger delete-item" title ="Eliminar registro" 
                data-id="' . $value["id"]  . '" 
                data-fullname="' . $value["fullname"] .  '" type="button"><i class="fa fa-remove"></i></button>
                <a href="' . base_url() . '/pdf/worker/' . encryption($value["id"]) . '" target="_Blank" class="btn btn-warning"><i class="fa fa-print text-white"></i></a>

                </div>
                 ';

            $cont++;
        }
        toJson($arrData);
    }

    public function getPeople()
    {
        permissionInterface(16);
        $arrData = $this->model->getAllPeople();

        $cont = 1; //Contador para la tabla
        foreach ($arrData as $key => $value) {
            $arrData[$key]["cont"] = $cont;

            if ($value['typePeople'] === "NATURAL") {
                $arrData[$key]["fullname"] = $value["name"] . " " . $value["lastname"];
            } else {
                $arrData[$key]["fullname"] = $value["fullname"];
            }

            $arrData[$key]["actions"] = '
            <div class="btn-group">   
            <button class="btn btn-success btn-select-person" type="button" 
                data-typepeople="' . $value["typePeople"] . '"
                data-fullname="' . $arrData[$key]["fullname"] . '"
                data-dni="' . $value["numberDocument"] . '"
            ><i class="fa-solid fa-check-double"></i></button>
            </div>';

            $cont++;
        }
        echo json_encode($arrData);
    }

    public function searchPeople()
    {
        permissionInterface(16);
        //validacion del metodo POST
        if (!$_GET) {
            registerLog("Ocurrió un error inesperado", "Método POST no encontrado, al momento de registrar un usuario", 1, $_SESSION['login_info']['idUser']);
            $data = array(
                "title" => "Ocurrió un error inesperado",
                "message" => "Método POST no encontrado",
                "type" => "error",
                "status" => false
            );
            toJson($data);
        }
        if (!isset($_GET['dni'])) {
            registerLog("Ocurrió un error inesperado", "No se encontró el campo txtDni", 1, $_SESSION['login_info']['idUser']);
            $data = array(
                "title" => "Ocurrió un error inesperado",
                "message" => "No se encontró el campo txtDni",
                "type" => "error",
                "status" => false
            );
            toJson($data);
        }
        //Almacenamos el dni en una variable
        $dni = strClean($_GET['dni']);
        //validamos que el dni no este vacio
        if (empty($dni)) {
            registerLog("Ocurrió un error inesperado", "El campo txtDni no puede estar vacio", 1, $_SESSION['login_info']['idUser']);
            $data = array(
                "title" => "Ocurrió un error inesperado",
                "message" => "El campo txtDni no puede estar vacío",
                "type" => "error",
                "status" => false
            );
            toJson($data);
        }
        //validamos que el dni sea un numero
        if (!is_numeric($dni)) {
            registerLog("Ocurrió un error inesperado", "El campo txtDni debe ser un numero", 1, $_SESSION['login_info']['idUser']);
            $data = array(
                "title" => "Ocurrió un error inesperado",
                "message" => "El campo txtDni debe ser numérico",
                "type" => "error",
                "status" => false
            );
            toJson($data);
        }
        //validamos que el dni tenga 8 caracteres
        if (strlen($dni) != 8 && strlen($dni) != 11) {
            registerLog("Ocurrió un error inesperado", "El campo txtDni debe tener 8 u 11 caracteres", 1, $_SESSION['login_info']['idUser']);
            $data = array(
                "title" => "Ocurrió un error inesperado",
                "message" => "El campo txtNumberDocument debe tener 8 u 11 caracteres",
                "type" => "error",
                "status" => false
            );
            toJson($data);
        }
        //realizamos la consulta a la base de datos
        $arrData = $this->model->search_people($dni);
        //validamos que la consulta haya devuelto resultados
        if (empty($arrData)) {
            registerLog("Ocurrió un error inesperado", "No se encontraron resultados", 1, $_SESSION['login_info']['idUser']);
            $data = array(
                "title" => "Ocurrió un error inesperado",
                "message" => "No se encontraron resultados",
                "type" => "error",
                "status" => false
            );
            toJson($data);
        }
        if ($arrData['typePeople'] === "NATURAL") {
            $arrData["fullname"] = $arrData["name"] . " " . $arrData["lastname"];
        } else {
            $arrData["fullname"] = $arrData["fullname"];
        }

        require_once "./Models/FileModel.php";
        $fileModel = new FileModel();
        $arrFiles = $fileModel->select_file_search_for_id_and_table($arrData['id'], "tb_people");
        if (empty($arrFiles)) {
            $imgProfile = base_url() . "/loadfile/people/?f=clientes.png";
        } else {
            $imgProfile = base_url() . "/loadfile/people/?f=" . $arrFiles['name'];
        }

        //retornamos los resultados
        toJson([
            "status" => true,
            "info" => ["people" => $arrData, "profile" => $imgProfile]
        ]);
    }

    public function searchPeopleUpdate()
    {
        permissionInterface(16);
        //validacion del metodo POST
        if (!$_GET) {
            registerLog("Ocurrió un error inesperado", "Método POST no encontrado, al momento de registrar un usuario", 1, $_SESSION['login_info']['idUser']);
            $data = array(
                "title" => "Ocurrió un error inesperado",
                "message" => "Método POST no encontrado",
                "type" => "error",
                "status" => false
            );
            toJson($data);
        }
        if (!isset($_GET['dni'])) {
            registerLog("Ocurrió un error inesperado", "No se encontró el campo update_txtDni", 1, $_SESSION['login_info']['idUser']);
            $data = array(
                "title" => "Ocurrió un error inesperado",
                "message" => "No se encontró el campo update_txtDni",
                "type" => "error",
                "status" => false
            );
            toJson($data);
        }
        //Almacenamos el dni en una variable
        $dni = strClean($_GET['dni']);
        //validamos que el dni no este vacio
        if (empty($dni)) {
            registerLog("Ocurrió un error inesperado", "El campo txtDni no puede estar vacio", 1, $_SESSION['login_info']['idUser']);
            $data = array(
                "title" => "Ocurrió un error inesperado",
                "message" => "El campo txtDni no puede estar vacio",
                "type" => "error",
                "status" => false
            );
            toJson($data);
        }

        //realizamos la consulta a la base de datos
        $arrData = $this->model->search_people($dni);
        if ($arrData['typePeople'] === "NATURAL") {
            $arrData["fullname"] = $arrData["name"] . " " . $arrData["lastname"];
        } else {
            $arrData["fullname"] = $arrData["fullname"];
        }

        require_once "./Models/FileModel.php";
        $fileModel = new FileModel();
        $arrFiles = $fileModel->select_file_search_for_id_and_table($arrData['id'], "tb_people");
        if (empty($arrFiles)) {
            $imgProfile = base_url() . "/loadfile/people/?f=clientes.png";
        } else {
            $imgProfile = base_url() . "/loadfile/people/?f=" . $arrFiles['name'];
        }

        //retornamos los resultados
        toJson([
            "status" => true,
            "info" => ["people" => $arrData, "profile" => $imgProfile]
        ]);
    }

    /**
     * Metodo que permite el registro de trabajadores
     * @return void
     */
    public function setWorker()
    {
        permissionInterface(16);
        // Validación del método POST
        if (!$_POST) {
            registerLog("Ocurrió un error inesperado", "El sistema ha detectado un intento de acceso al método setCategory a través de la URL, lo cual no está permitido. Por motivos de seguridad, este intento ha sido bloqueado automáticamente.
                                Cabe señalar que esta acción debe realizarse únicamente mediante un formulario diseñado específicamente para dicho registro.
                                Detalles del intento bloqueado: \nIp=>" . obtenerIP() . "\n InfoUser=>[" . json_encode($_SESSION) . "]", 1, $_SESSION['login_info']['idUser']);
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
        $intPeopleId = strClean($_POST["txtId"]);
        $intJobtitleId = strClean($_POST["selectJobtitle"]);
        $strAccountNumber = strClean($_POST["txt_Accountnumber"]);
        $strAccountNumber2 = strClean($_POST["txt_Accountnumber2"]);
        $strAccountNumber3 = strClean($_POST["txt_Accountnumber3"]);
        $strAccountNumber4 = strClean($_POST["txt_Accountnumber4"]);


        //validamos que la persona no este registrada como cliente
        $arrData = $this->model->select_people_by_id($intPeopleId);
        if (!empty($arrData)) {
            registerLog("Ocurrió un error inesperado", "El cliente ya se encuentra registrado", 1, $_SESSION['login_info']['idUser']);
            $data = array(
                "title" => "Ocurrió un error inesperado",
                "message" => "El cliente ya se encuentra registrado",
                "type" => "error",
                "status" => false
            );
            toJson($data);
        }
        //destruimos la variable $request
        unset($request);
        $request = $this->model->insert_worker(
            $intPeopleId,
            $intJobtitleId,
            $strAccountNumber,
            $strAccountNumber2,
            $strAccountNumber3,
            $strAccountNumber4
        ); //insert  trabajadores in database
        if ($request > 0) {
            registerLog("Registro exitoso", "El trabajador se registro de manera correcta. Detalle => " . json_encode($_POST), 2, $_SESSION['login_info']['idUser']);
            $data = array(
                "title" => "Registro exitoso",
                "message" => "El trabajador se ha registrado correctamente",
                "type" => "success",
                "status" => true
            );
            toJson($data);
        } else {
            registerLog("Ocurrió un error inesperado", "No se logro completar el registro de los trabajadores", 1, $_SESSION['login_info']['idUser']);
            $data = array(
                "title" => "Ocurrió un error inesperado",
                "message" => "No se logro completar el registro del trabajador",
                "type" => "error",
                "status" => false
            );
            toJson($data);
        }
    }
    /**
     * Metodo que se encarga de eliminar una categoria
     * @return void
     */
    public function updateWorker()
    {
        permissionInterface(16);
        //validacion del metodo POST
        if (!$_POST) {
            registerLog("Ocurrió un error inesperado", "El sistema ha detectado un intento de acceso al método setCategory a través de la URL, lo cual no está permitido. Por motivos de seguridad, este intento ha sido bloqueado automáticamente.
                                Cabe señalar que esta acción debe realizarse únicamente mediante un formulario diseñado específicamente para dicha actualización.
                                Detalles del intento bloqueado: \nIp=>" . obtenerIP() . "\n InfoUser=>[" . json_encode($_SESSION) . "]", 1, $_SESSION['login_info']['idUser']);
            $data = array(
                "title" => "Ocurrió un error inesperado",
                "message" => "Metodo POST no encontrado",
                "type" => "error",
                "status" => false
            );
            toJson($data);
        }
        isCsrf(); //validacion de ataque CSRF
        //validamos que los campos existan, uno por uno
        if (!isset($_POST["update_txtId"])) {
            registerLog("Ocurrió un error inesperado", "El input update_txtId no existe, se manipulo el formulario por favor refresca la página para poder solucionar este inconveniente", 1, $_SESSION['login_info']['idUser']);
            $data = array(
                "title" => "Ocurrió un error inesperado",
                "message" => "No se encontro el campo update_txtId por favor refresca la página",
                "type" => "error",
                "status" => false
            );
            toJson($data);
        }

        if (!isset($_POST["update_slctStatus"])) {
            registerLog("Ocurrió un error inesperado", "El input update_slctStatus no existe, se manipulo el formulario por favor refresca la página para poder solucionar este inconveniente", 1, $_SESSION['login_info']['idUser']);
            $data = array(
                "title" => "Ocurrió un error inesperado",
                "message" => "No se encontro el campo update_slctStatus por favor refresca la página",
                "type" => "error",
                "status" => false
            );
            toJson($data);
        }

        //Captura de datos enviamos
        $update_txtId = strClean($_POST["update_txtId"]);
        $update_idPeople = strClean($_POST["update_txtIdPeople"]);
        $update_selectJobtitle = strClean($_POST["update_selectJobtitle"]);
        $update_txtAccountnumber = strClean($_POST["update_txtAccountnumber"]);
        $update_txtAccountnumber2 = strClean($_POST["update_txtAccountnumber2"]);
        $update_txtAccountnumber3 = strClean($_POST["update_txtAccountnumber3"]);
        $update_txtAccountnumber4 = strClean($_POST["update_txtAccountnumber4"]);
        $update_txtStatus = strClean($_POST["update_slctStatus"]);
        //validacion de los campos que no llegen vacios
        // if ($update_txtId == "" || $update_idPeople == "" || $update_selectJobtitle == "" || $update_txtAccountnumber || $update_txtStatus == "") {
        //     registerLog("Ocurrió un error inesperado", "Los campos no pueden estar vacios, al momento de actualizar un trabajador", 1, $_SESSION['login_info']['idUser']);
        //     $data = array(
        //         "title" => "Ocurrió un error inesperado",
        //         "message" => "Los campos no pueden estar vacios",
        //         "type" => "error",
        //         "status" => false
        //     );
        //     toJson($data);
        // }
        //validacion de que el id sea numerico
        if (!is_numeric($update_txtId)) {
            registerLog("Ocurrió un error inesperado", "El id del trabajador debe ser numerico, al momento de actualizar un trabajador", 1, $_SESSION['login_info']['idUser']);
            $data = array(
                "title" => "Ocurrió un error inesperado",
                "message" => "El id del trabajador debe ser numérico, por favor refresca la página",
                "type" => "error",
                "status" => false
            );
            toJson($data);
        }

        //validamos que el id de la categoria exista en la base de datos
        $result = $this->model->select_worker_by_id($update_txtId);
        if (!$result) {
            registerLog("Ocurrió un error inesperado", "No se pudo actualizar el trabajador, ya que id proporcionado no pertenece a nigun registro", 1, $_SESSION['login_info']['idUser']);
            $data = array(
                "title" => "Ocurrió un error inesperado",
                "message" => "El id del trabajador no existe, refresque la página y vuelva a intentarlo",
                "type" => "error",
                "status" => false
            );
            toJson($data);
        }

        //registramos el trabajador en la base de datos
        $result = $this->model->update_worker(
            $update_txtId,
            $update_idPeople,
            $update_selectJobtitle,
            $update_txtAccountnumber,
            $update_txtAccountnumber2,
            $update_txtAccountnumber3,
            $update_txtAccountnumber4,
            $update_txtStatus
        ); //insert  trabajadores in database
        if ($result) {
            registerLog("Categoria actualizada", "Se actualizo la informacion del trabajador con el id: " . $update_txtId, 1, $_SESSION['login_info']['idUser']);
            $data = array(
                "title" => "Categoria actualizado",
                "message" => "Se actualizó el trabajador de forma correcta",
                "type" => "success",
                "status" => true
            );
            toJson($data);
        } else {
            registerLog("Ocurrió un error inesperado", "No se pudo actualizar el trabajador, por favor intente de nuevo", 1, $_SESSION['login_info']['idUser']);
            $data = array(
                "title" => "Ocurrió un error inesperado",
                "message" => "No se pudo actualizar al trabajador, por favor intente de nuevo",
                "type" => "error",
                "status" => false
            );
            toJson($data);
        }
    }
    /**
     * Función que se encarga de eliminar un rol
     * @return void
     */
    public function deleteWorker()
    {
        permissionInterface(16);

        //Validacion de que el metodo sea DELETE
        if ($_SERVER["REQUEST_METHOD"] !== "DELETE") {
            registerLog("Ocurrió un error inesperado", "Metodo DELETE no encontrado, para poder eliminar una categoria se necesita este metodo", 1, $_SESSION['login_info']['idUser']);
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
            registerLog("Ocurrió un error inesperado", "El id de la categoria no puede estar vacio, para poder eliminarla", 1, $_SESSION['login_info']['idUser']);
            $data = array(
                "title" => "Ocurrió un error inesperado",
                "message" => "El id del trabajador es requerido, refresca la página e intenta nuevamente",
                "type" => "error",
                "status" => false
            );
            toJson($data);
        }
        //validacion que solo ce acepte numeros en el campo id
        if (!is_numeric($id)) {
            registerLog("Ocurrió un error inesperado", "El id de la categoria no esta en formato numerico, por lo que no se lograra eliminar este registro", 1, $_SESSION['login_info']['idUser']);
            $data = array(
                "title" => "Ocurrió un error inesperado",
                "message" => "El id del trabajador debe, ser numerico, refresca la página e intenta nuevamente",
                "type" => "error",
                "status" => false
            );
            toJson($data);
        }
        ///validamos que el id del rol exista en la base de datos
        $result = $this->model->select_worker_by_id($id);
        if (!$result) {
            registerLog("Ocurrió un error inesperado", "No se podra eliminar la categoria ya que el id propocinado no existe", 1, $_SESSION['login_info']['idUser']);

            $data = array(
                "title" => "Ocurrió un error inesperado",
                "message" => "El id del trabajador no existe, refresque la página y vuelva a intentarlo",
                "type" => "error",
                "status" => false
            );
            toJson($data);
        }
        $request = $this->model->delete_worker($id);
        if ($request) {
            registerLog("Eliminacion correcta", "Se elimino de manera correcta la categoria {$name}", 2, $_SESSION['login_info']['idUser']);

            $data = array(
                "title" => "Eliminacion correcta",
                "message" => "Se elimino de manera correcta el trabajador {$name}",
                "type" => "success",
                "status" => true
            );
            toJson($data);
        } else {
            registerLog("Ocurrió un error inesperado", "No se pudo eliminar la categoria {$name}, por favor intentalo nuevamente", 1, $_SESSION['login_info']['idUser']);

            $data = array(
                "title" => "Ocurrió un error inesperado",
                "message" => "No se logro eliminar de manera correcta el trabajador {$name}",
                "type" => "error",
                "status" => false
            );
            toJson($data);
        }
    }
}
