<?php
class Company extends Controllers
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
     * Metodo que se encarga de cargar la vista de las empresas
     * @return void
     */
    public function company()
    {
       // Este pertenece a la empresa
        $data['page_id'] = 23;
        permissionInterface($data['page_id']);
        $data['page_title'] = "Gestión de Empresas";
        $data['page_description'] = "Te permite gestionar los datos de la empresa";
        $data['page_container'] = "Company";
        $data['page_js_css'] = "company";
        registerLog("Información de navegación", "El usuario entro a :" . $data['page_title'], 3, $_SESSION['login_info']['idUser']);
        $this->views->getView($this, "company", $data);
    }
    /**
     * Metodo que se encarga de cargar la vista de la categoria
     * @return void
     */
    public function getCompany()
    {
        permissionInterface(23);
        $arrData = $this->model->select_company();
        $cont = 1; //Contador para la tabla
        foreach ($arrData as $key => $value) {
            $arrData[$key]["cont"] = $cont;
            //agregamos un badge para el estado
            if ($value["status"] == 'ACTIVO') {
                $arrData[$key]["status_badge"] = '<span class="badge badge-success"> <i class="fa fa-check"></i> Activo</span>';
            } else {
                $arrData[$key]["status_badge"] = '<span class="badge badge-danger"> <i class="fa fa-close"></i> Inactivo</span>';
            }
            $arrData[$key]["actions"] = '
            <div class="btn-group">
                <button class="btn btn-success update-item" title="Editar registro" 
                data-id="' . $value["id"] . '" 
                data-title="' . $value["title"] . '" 
                data-subtitle="' . $value["subtitle"] . '" 
                data-description="' . $value["description"] . '" 
                data-mail="' . $value["mail"] . '" 
                data-ruc="' . $value["ruc"] . '" 
                data-address="' . $value["address"] . '" 
                data-phone="' . $value["phone"] . '" 
                data-status="' . $value['status'] . '"  
                type="button"><i class="fa fa-pencil"></i></button>
                

                <button class="btn btn-info report-item" title="Ver reporte" 
                data-id="' . $value["id"] . '" 
                data-title="' . $value["title"] . '" 
                data-subtitle="' . $value["subtitle"] . '" 
                data-description="' . $value["description"] . '" 
                data-mail="' . $value["mail"] . '" 
                data-ruc="' . $value["ruc"] . '" 
                data-address="' . $value["address"] . '" 
                data-phone="' . $value["phone"] . '" 
                data-status="' . $value['status'] . '" 
                data-registrationDate="' . dateFormat($value['dateRegistration']) . '" 
                data-updateDate="' . dateFormat($value['dateUpdate']) . '" 
                type="button"><i class="fa fa-exclamation-circle" aria-hidden="true"></i></button>


                 <button class="btn btn-danger delete-item" title ="Eliminar registro" 
                 data-id="' . $value["id"] . '" 
                 data-title="' . $value["title"] . '"
                 ><i class="fa fa-remove"></i></button>
                </div>
                 ';

            $cont++;
        }
        toJson($arrData);
    }
    /**
     * Metodo que permite el registro de nueva categorias
     * @return void
     */
    public function setCompany()
    {
        permissionInterface(23);
        // Validación del método POST
        if ($_SERVER['REQUEST_METHOD'] !== "POST") {
            registerLog("Ocurrió un error inesperado", "El sistema ha detectado un intento de acceso al método setCategory a través de la URL, lo cual no está permitido. Por motivos de seguridad, este intento ha sido bloqueado automáticamente.
                                Cabe señalar que esta acción debe realizarse únicamente mediante un formulario diseñado específicamente para dicho registro.
                                Detalles del intento bloqueado: \nIp=>" . obtenerIP() . "\n InfoUser=>[" . json_encode($_SESSION) . "]", 1, $_SESSION['login_info']['idUser']);
            $data = array(
                "title" => "Ocurrió un error inesperado",
                "message" => "Método POST no encontrado",
                "type" => "error",
                "status" => false
            );
            toJson($_REQUEST);
        }

        isCsrf(); //validacion de ataque CSRF
        //validamos que los campos existan
        if (!isset($_REQUEST["txtTitle"])) {
            registerLog("Ocurrió un error inesperado", "El input txtTitle no existe, se manipulo el formulario por favor refresca la página para poder solucionar este inconveniente", 1, $_SESSION['login_info']['idUser']);
            $data = array(
                "title" => "Ocurrió un error inesperado",
                "message" => "No se encontró el campo txtTitle por favor refresca la página",
                "type" => "error",
                "status" => false
            );
            toJson($data);
        }
        if (!isset($_REQUEST["txtSubtitle"])) {
            registerLog("Ocurrió un error inesperado", "El input txtSubtitle no existe, se manipulo el formulario por favor refresca la página para poder solucionar este inconveniente", 1, $_SESSION['login_info']['idUser']);
            $data = array(
                "title" => "Ocurrió un error inesperado",
                "message" => "No se encontró el campo txtSubtitle por favor refresca la página",
                "type" => "error",
                "status" => false
            );
            toJson($data);
        }
        if (!isset($_REQUEST["txtDescription"])) {
            registerLog("Ocurrió un error inesperado", "El input txtDescription no existe, se manipulo el formulario por favor refresca la página para poder solucionar este inconveniente", 1, $_SESSION['login_info']['idUser']);
            $data = array(
                "title" => "Ocurrió un error inesperado",
                "message" => "No se encontró el campo txtDescription por favor refresca la página",
                "type" => "error",
                "status" => false
            );
            toJson($data);
        }
        if (!isset($_REQUEST["txtMail"])) {
            registerLog("Ocurrió un error inesperado", "El input txtMail no existe, se manipulo el formulario por favor refresca la página para poder solucionar este inconveniente", 1, $_SESSION['login_info']['idUser']);
            $data = array(
                "title" => "Ocurrió un error inesperado",
                "message" => "No se encontró el campo txtMail por favor refresca la página",
                "type" => "error",
                "status" => false
            );
            toJson($data);
        }
        if (!isset($_REQUEST["txtRuc"])) {
            registerLog("Ocurrió un error inesperado", "El input txtRuc no existe, se manipulo el formulario por favor refresca la página para poder solucionar este inconveniente", 1, $_SESSION['login_info']['idUser']);
            $data = array(
                "title" => "Ocurrió un error inesperado",
                "message" => "No se encontró el campo txtRuc por favor refresca la página",
                "type" => "error",
                "status" => false
            );
            toJson($data);
        }
        if (!isset($_REQUEST["txtAddress"])) {
            registerLog("Ocurrió un error inesperado", "El input txtAddress no existe, se manipulo el formulario por favor refresca la página para poder solucionar este inconveniente", 1, $_SESSION['login_info']['idUser']);
            $data = array(
                "title" => "Ocurrió un error inesperado",
                "message" => "No se encontró el campo txtAddress por favor refresca la página",
                "type" => "error",
                "status" => false
            );
            toJson($data);
        }
        if (!isset($_REQUEST["txtPhone"])) {
            registerLog("Ocurrió un error inesperado", "El input txtPhone no existe, se manipulo el formulario por favor refresca la página para poder solucionar este inconveniente", 1, $_SESSION['login_info']['idUser']);
            $data = array(
                "title" => "Ocurrió un error inesperado",
                "message" => "No se encontró el campo txtPhone por favor refresca la página",
                "type" => "error",
                "status" => false
            );
            toJson($data);
        }
        // Limpieza de los inputs
        $txtTitle = strClean($_POST["txtTitle"]);
        $txtSubtitle = strClean($_POST["txtSubtitle"]);
        $txtDescription = strClean($_POST["txtDescription"]);
        $txtMail = strClean($_POST["txtMail"]);
        $txtRuc = strClean($_POST["txtRuc"]);
        $txtAddress = strClean($_POST["txtAddress"]);
        $txtPhone = strClean($_POST["txtPhone"]);

        // Validación del telefono
        if (!preg_match('/^[0-9]{9}$/', $txtPhone)) {
            registerLog(
                "Ocurrió un error inesperado",
                "El teléfono ingresado no tiene el formato correcto. Debe contener exactamente 9 dígitos numéricos.",
                1,
                $_SESSION['login_info']['idUser']
            );
            $data = array(
                "title" => "Ocurrió un error inesperado",
                "message" => "El teléfono ingresado no es válido. Debe tener exactamente 9 dígitos numéricos.",
                "type" => "error",
                "status" => false
            );
            toJson($data);
        }

        // Validación de campos vacíos
        if ($txtTitle == "") {
            registerLog("Ocurrió un error inesperado", "Es obligatorio que el campo titulo este lleno, ya que lo contrario no se realizara el registro de la empresa", 1, $_SESSION['login_info']['idUser']);

            $data = array(
                "title" => "Error",
                "message" => "Campo nombre obligatorio",
                "type" => "error",
                "status" => false
            );
            toJson($data);
        }
        // Validación del formato de la descripción de la empresa (permite letras, números, guiones, espacios, mínimo 20 caracteres)
        if ($txtDescription != "") {
            if (verifyData("[a-zA-ZÁÉÍÓÚáéíóúÜüÑñ0-9\s.,;:!?()-]+", $txtDescription)) {
                registerLog("Ocurrió un error inesperado", "El campo Descripción no cumple con el formato de texto como para poder registrarlo como parte de la empresa", 1, $_SESSION['login_info']['idUser']);
                $data = array(
                    "title" => "Ocurrio un error inesperado",
                    "message" => "El campo Descripción no cumple con el formato de texto",
                    "type" => "error",
                    "status" => false
                );
                toJson($data);
            }
            // Validación de campos vacíos
            if ($txtMail == "") {
                registerLog("Ocurrió un error inesperado", "Es obligatorio que el campo email este lleno, ya que lo contrario no se realizara el registro de la empresa", 1, $_SESSION['login_info']['idUser']);

                $data = array(
                    "title" => "Error",
                    "message" => "Campo Email obligatorio",
                    "type" => "error",
                    "status" => false
                );
                toJson($data);
            }


            // Validación de campos vacíos
            if ($txtRuc == "") {
                registerLog("Ocurrió un error inesperado", "Es obligatorio que el campo ruc este lleno, ya que lo contrario no se realizara el registro de la empresa", 1, $_SESSION['login_info']['idUser']);

                $data = array(
                    "title" => "Error",
                    "message" => "Campo RUC obligatorio",
                    "type" => "error",
                    "status" => false
                );
                toJson($data);
            }



            // Validación de campos vacíos
            if ($txtAddress == "") {
                registerLog("Ocurrió un error inesperado", "Es obligatorio que el campo direccion este lleno, ya que lo contrario no se realizara el registro de la empresa", 1, $_SESSION['login_info']['idUser']);

                $data = array(
                    "title" => "Error",
                    "message" => "Campo Dirección obligatorio",
                    "type" => "error",
                    "status" => false
                );
                toJson($data);
            }

            // Validación de campos vacíos
            if ($txtPhone == "") {
                registerLog("Ocurrió un error inesperado", "Es obligatorio que el campo telefono este lleno, ya que lo contrario no se realizara el registro de la empresa", 1, $_SESSION['login_info']['idUser']);

                $data = array(
                    "title" => "Error",
                    "message" => "Campo Teléfono obligatorio",
                    "type" => "error",
                    "status" => false
                );
                toJson($data);
            }
        }
        //validamos que no nos permita el registro de empresas con el mismo titulo
        $request = $this->model->select_for_title_company($txtTitle);
        if ($request) {
            registerLog("Ocurrió un error inesperado", "El titulo de empresa proporcionado ya existe en la base de datos, por favor cambie por otro nombre para poder registrar la nueva empresa", 1, $_SESSION['login_info']['idUser']);
            $data = array(
                "title" => "Ocurrio un error inesperado",
                "message" => "El título de empresa proporcionado ya existe en la base de datos",
                "type" => "error",
                "status" => false
            );
            toJson($data);
        }
        //destruimos la variable $request
        unset($request);
        $request = $this->model->insert_company($txtTitle, $txtSubtitle, $txtDescription, $txtMail, $txtRuc,  $txtAddress, $txtPhone); //insert  empresas in database
        if ($request > 0) {
            registerLog("Registro exitoso", "La empresa se registro de manera correcta. Detalle => " . json_encode($_POST), 2, $_SESSION['login_info']['idUser']);
            $data = array(
                "title" => "Registro exitoso",
                "message" => "La empresa se ha registrado correctamente",
                "type" => "success",
                "status" => true
            );
            toJson($data);
        } else {
            registerLog("Ocurrio un error inesperado", "No se logro completar el registro de la empresa", 1, $_SESSION['login_info']['idUser']);
            $data = array(
                "title" => "Ocurrio un error inesperado",
                "message" => "No se logró completar el registro de la categoría",
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
    public function updateCompany()
    {
        permissionInterface(23);
        //validacion del metodo POST
        if (!$_POST) {
            registerLog("Ocurrio un error inesperado", "El sistema ha detectado un intento de acceso al método setCategory a través de la URL, lo cual no está permitido. Por motivos de seguridad, este intento ha sido bloqueado automáticamente.
                                Cabe señalar que esta acción debe realizarse únicamente mediante un formulario diseñado específicamente para dicha actualización.
                                Detalles del intento bloqueado: \nIp=>" . obtenerIP() . "\n InfoUser=>[" . json_encode($_SESSION) . "]", 1, $_SESSION['login_info']['idUser']);
            $data = array(
                "title" => "Ocurrio un error inesperado",
                "message" => "Metodo POST no encontrado",
                "type" => "error",
                "status" => false
            );
            toJson($data);
        }
        isCsrf(); //validacion de ataque CSRF
        //validamos que los campos existan, uno por uno
        if (!isset($_POST["update_txtId"])) {
            registerLog("Ocurrio un error inesperado", "El input update_txtId no existe, se manipulo el formulario por favor refresca la página para poder solucionar este inconveniente", 1, $_SESSION['login_info']['idUser']);
            $data = array(
                "title" => "Ocurrio un error inesperado",
                "message" => "No se encontró el campo update_txtId por favor refresca la página",
                "type" => "error",
                "status" => false
            );
            toJson($data);
        }
        if (!isset($_POST["update_txtTitle"])) {
            registerLog("Ocurrio un error inesperado", "El input update_txtTitle no existe, se manipulo el formulario por favor refresca la página para poder solucionar este inconveniente", 1, $_SESSION['login_info']['idUser']);
            $data = array(
                "title" => "Ocurrio un error inesperado",
                "message" => "No se encontró el campo update_txtTitle por favor refresca la página",
                "type" => "error",
                "status" => false
            );
            toJson($data);
        }
        if (!isset($_POST["update_txtSubtitle"])) {
            registerLog("Ocurrio un error inesperado", "El input update_txtSubtitle no existe, se manipulo el formulario por favor refresca la página para poder solucionar este inconveniente", 1, $_SESSION['login_info']['idUser']);
            $data = array(
                "title" => "Ocurrio un error inesperado",
                "message" => "No se encontró el campo update_txtSubtitle por favor refresca la página",
                "type" => "error",
                "status" => false
            );
            toJson($data);
        }
        if (!isset($_POST["update_txtDescription"])) {
            registerLog("Ocurrio un error inesperado", "El input update_txtDescription no existe, se manipulo el formulario por favor refresca la página para poder solucionar este inconveniente", 1, $_SESSION['login_info']['idUser']);
            $data = array(
                "title" => "Ocurrio un error inesperado",
                "message" => "No se encontró el campo update_txtDescription por favor refresca la página",
                "type" => "error",
                "status" => false
            );
            toJson($data);
        }
        if (!isset($_POST["update_txtMail"])) {
            registerLog("Ocurrio un error inesperado", "El input update_txtMail no existe, se manipulo el formulario por favor refresca la página para poder solucionar este inconveniente", 1, $_SESSION['login_info']['idUser']);
            $data = array(
                "title" => "Ocurrio un error inesperado",
                "message" => "No se encontró el campo update_txtMail por favor refresca la página",
                "type" => "error",
                "status" => false
            );
            toJson($data);
        }
        if (!isset($_POST["update_txtRuc"])) {
            registerLog("Ocurrio un error inesperado", "El input update_txtRuc no existe, se manipulo el formulario por favor refresca la página para poder solucionar este inconveniente", 1, $_SESSION['login_info']['idUser']);
            $data = array(
                "title" => "Ocurrio un error inesperado",
                "message" => "No se encontró el campo update_txtRuc por favor refresca la página",
                "type" => "error",
                "status" => false
            );
            toJson($data);
        }
        if (!isset($_POST["update_txtAddress"])) {
            registerLog("Ocurrio un error inesperado", "El input update_txtAddress no existe, se manipulo el formulario por favor refresca la página para poder solucionar este inconveniente", 1, $_SESSION['login_info']['idUser']);
            $data = array(
                "title" => "Ocurrio un error inesperado",
                "message" => "No se encontró el campo update_txtAddress por favor refresca la página",
                "type" => "error",
                "status" => false
            );
            toJson($data);
        }
        if (!isset($_POST["update_txtPhone"])) {
            registerLog("Ocurrio un error inesperado", "El input update_txtPhone no existe, se manipulo el formulario por favor refresca la página para poder solucionar este inconveniente", 1, $_SESSION['login_info']['idUser']);
            $data = array(
                "title" => "Ocurrio un error inesperado",
                "message" => "No se encontró el campo update_txtPhone por favor refresca la página",
                "type" => "error",
                "status" => false
            );
            toJson($data);
        }
        if (!isset($_POST["update_txtStatus"])) {
            registerLog("Ocurrio un error inesperado", "El input update_txtStatus no existe, se manipulo el formulario por favor refresca la página para poder solucionar este inconveniente", 1, $_SESSION['login_info']['idUser']);
            $data = array(
                "title" => "Ocurrio un error inesperado",
                "message" => "No se encontró el campo update_txtStatus por favor refresca la página",
                "type" => "error",
                "status" => false
            );
            toJson($data);
        }

        //Captura de datos enviamos
        $update_txtId = strClean($_POST["update_txtId"]);
        $update_txtTitle = strClean($_POST["update_txtTitle"]);
        $update_txtSubtitle = strClean($_POST["update_txtSubtitle"]);
        $update_txtDescription = strClean($_POST["update_txtDescription"]);
        $update_txtMail = strClean($_POST["update_txtMail"]);
        $update_txtRuc = strClean($_POST["update_txtRuc"]);
        $update_txtAddress = strClean($_POST["update_txtAddress"]);
        $update_txtPhone = strClean($_POST["update_txtPhone"]);
        $update_txtStatus = strClean($_POST["update_txtStatus"]);
        //validacion de los campos que no llegen vacios
        if ($update_txtId == "" || $update_txtTitle == "" || $update_txtSubtitle == "" || $update_txtMail == "" || $update_txtRuc == "" || $update_txtAddress == "" || $update_txtPhone == ""  || $update_txtStatus == "") {
            registerLog("Ocurrio un error inesperado", "Los campos no pueden estar vacios, al momento de actualizar una empresa", 1, $_SESSION['login_info']['idUser']);
            $data = array(
                "title" => "Ocurrio un error inesperado",
                "message" => "Los campos no pueden estar vacíos",
                "type" => "error",
                "status" => false
            );
            toJson($data);
        }
        //validacion de que el id sea numerico
        if (!is_numeric($update_txtId)) {
            registerLog("Ocurrio un error inesperado", "El id de la empresa debe ser numerico, al momento de actualizar una empresa", 1, $_SESSION['login_info']['idUser']);
            $data = array(
                "title" => "Ocurrio un error inesperado",
                "message" => "El id de la empresa debe ser numérico, por favor refresca la página",
                "type" => "error",
                "status" => false
            );
            toJson($data);
        }
        // //validamos que los nombres de las categorias  no sean mayores a 200 caracteres
        // if (strlen($update_txtName) > 200) {
        //     registerLog("Ocurrio un error inesperado", "El nombre de la categoria no puede ser mayor a 200 caracteres, por favor el usuario debera mantener la cantidad establecida", 1, $_SESSION['login_info']['idUser']);
        //     $data = array(
        //         "title" => "Ocurrio un error inesperado",
        //         "message" => "El nombre de la categoria no puede ser mayor a 200 caracteres, por favor el usuario debera mantener la cantidad establecida",
        //         "type" => "error",
        //         "status" => false
        //     );
        //     toJson($data);
        // }
        //Validamos los caracteres permitidos en el nombre
        // if (verifyData("[A-Za-zÁÉÍÓÚáéíóúÑñ\s]{4,200}", $update_txtName)) {
        //     registerLog("Ocurrió un error inesperado", "El campo Nombre no cumple con el formato de texto, para poder actualizar la categoria", 1, $_SESSION['login_info']['idUser']);
        //     $data = array(
        //         "title" => "Ocurrio un error inesperado",
        //         "message" => "El campo nombre no cumple con el formato de texto",
        //         "type" => "error",
        //         "status" => false
        //     );
        //     toJson($data);
        // }
        // if ($update_txtDescription != "") {
        //     if (verifyData("[a-zA-ZÁÉÍÓÚáéíóúÜüÑñ0-9\s.,;:!?()-]+", $update_txtDescription)) {
        //         registerLog("Ocurrió un error inesperado", "El campo Descripción no cumple con el formato de texto, para poder actualizar la categoria", 1, $_SESSION['login_info']['idUser']);
        //         $data = array(
        //             "title" => "Ocurrio un error inesperado",
        //             "message" => "El campo descripcion no cumple con el formato de texto",
        //             "type" => "error",
        //             "status" => false
        //         );
        //         toJson($data);
        //     }
        // }
        // //validamos que el id de la categoria exista en la base de datos
        // $result = $this->model->select_company_by_id($update_txtId);
        // if (!$result) {
        //     registerLog("Ocurrio un error inesperado", "No se pudo actualizar la categoria, ya que id proporcionado no pertenece a nigun registro", 1, $_SESSION['login_info']['idUser']);
        //     $data = array(
        //         "title" => "Ocurrio un error inesperado",
        //         "message" => "El id de la categoria no existe, refresque la página y vuelva a intentarlo",
        //         "type" => "error",
        //         "status" => false
        //     );
        //     toJson($data);
        // }
        // if ($result['name'] != $update_txtName) {
        //     //consultamos si el nombre de la categoria ya existe
        //     $request = $this->model->select_for_name_company($update_txtName);
        //     //validamos que el id de la categoria sea diferente al id que se esta actualizando
        //     if ($request) {
        //         if ($request['idCategory'] != $update_txtId) {
        //             registerLog("Ocurrio un error inesperado", "El nombre de la categoria ya existe, por favor cambie el nombre de la categoria", 1, $_SESSION['login_info']['idUser']);
        //             $data = array(
        //                 "title" => "Ocurrio un error inesperado",
        //                 "message" => "El nombre de la categoria ya existe, por favor cambie el nombre de la categoria",
        //                 "type" => "error",
        //                 "status" => false
        //             );
        //             toJson($data);
        //         }
        //     }
        // }
        //registramos el rol en la base de datos
        $result = $this->model->update_company($update_txtId, $update_txtTitle, $update_txtSubtitle, $update_txtDescription, $update_txtMail, $update_txtRuc, $update_txtAddress, $update_txtPhone, $update_txtStatus);
        if ($result) {
            registerLog("Empresa actualizada", "Se actualizo la informacion de de la empresa con el id: " . $update_txtId, 1, $_SESSION['login_info']['idUser']);
            $data = array(
                "title" => "Empresa actualizado",
                "message" => "Se actualizó la empresa con el id: " . $update_txtId,
                "type" => "success",
                "status" => true
            );
            toJson($data);
        } else {
            registerLog("Ocurrio un error inesperado", "No se pudo actualizar la empresa, por favor intente de nuevo", 1, $_SESSION['login_info']['idUser']);
            $data = array(
                "title" => "Ocurrio un error inesperado",
                "message" => "No se pudo actualizar la empresa, por favor intente de nuevo",
                "type" => "error",
                "status" => false
            );
            toJson($data);
        }
    }
    /**
     * Función que se encarga de eliminar una empresa
     * @return void
     */
    public function deleteCompany()
    {
        permissionInterface(23);

        //Validacion de que el metodo sea DELETE
        if ($_SERVER["REQUEST_METHOD"] !== "DELETE") {
            registerLog("Ocurrio un error inesperado", "Metodo DELETE no encontrado, para poder eliminar una empresa se necesita este metodo", 1, $_SESSION['login_info']['idUser']);
            $data = array(
                "title" => "Ocurrio un error inesperado",
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
        $title = strClean($request["title"]);
        //validamos que los campos no esten vacios
        if ($id == "") {
            registerLog("Ocurrio un error inesperado", "El id de la empresa no puede estar vacio, para poder eliminarla", 1, $_SESSION['login_info']['idUser']);
            $data = array(
                "title" => "Ocurrio un error inesperado",
                "message" => "El id de la empresa es requerido, refresca la página e intenta nuevamente",
                "type" => "error",
                "status" => false
            );
            toJson($data);
        }
        //validacion que solo ce acepte numeros en el campo id
        if (!is_numeric($id)) {
            registerLog("Ocurrio un error inesperado", "El id de la empresa no esta en formato numerico, por lo que no se lograra eliminar este registro", 1, $_SESSION['login_info']['idUser']);
            $data = array(
                "title" => "Ocurrio un error inesperado",
                "message" => "El id de la empresa debe, ser numerico, refresca la página e intenta nuevamente",
                "type" => "error",
                "status" => false
            );
            toJson($data);
        }
        ///validamos que el id del rol exista en la base de datos
        $result = $this->model->select_company_by_id($id);
        if (!$result) {
            registerLog("Ocurrio un error inesperado", "No se podra eliminar la empresa ya que el id propocinado no existe", 1, $_SESSION['login_info']['idUser']);

            $data = array(
                "title" => "Ocurrio un error inesperado",
                "message" => "El id de la empresa no existe, refresque la página y vuelva a intentarlo",
                "type" => "error",
                "status" => false
            );
            toJson($data);
        }
        $request = $this->model->delete_company($id);
        if ($request) {
            registerLog("Eliminacion correcta", "Se elimino de manera correcta la empresa {$title}", 2, $_SESSION['login_info']['idUser']);

            $data = array(
                "title" => "Eliminacion correcta",
                "message" => "Se elimino de manera correcta la empresa {$title}",
                "type" => "success",
                "status" => true
            );
            toJson($data);
        } else {
            registerLog("Ocurrio un error inesperado", "No se pudo eliminar la empresa {$title}, por favor intentalo nuevamente", 1, $_SESSION['login_info']['idUser']);

            $data = array(
                "title" => "Ocurrio un error inesperado",
                "message" => "No se logro eliminar de manera correcta la empresa {$title}",
                "type" => "error",
                "status" => false
            );
            toJson($data);
        }
    }
}
