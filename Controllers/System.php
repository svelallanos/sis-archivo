<?php

class System extends Controllers
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
    public function system()
    {
        $data['page_id'] = 6;
        permissionInterface($data['page_id']);
        $data['page_title'] = "Configruacion del Sistema";
        $data['page_description'] = "Cambia el logo, nombre y otros datos del sistema";
        $data['page_container'] = "System";
        $data['page_js_css'] = "system";
        registerLog("Información de navegación", "El usuario entro a :" . $data['page_title'], 3, $_SESSION['login_info']['idUser']);

        $this->views->getView($this, "system", $data);
    }
    /**
     * Funcion que permite guardar la informacion general del sistema
     * @return void
     */
    public function setInfoGeneral()
    {
        //Se verifica si se tiene permiso para acceder a la vista
        permissionInterface(6);
        //validacion del metodo POST
        if (!$_POST) {
            registerLog("Ocurrio un error inesperado", "Metodo POST no encontrado, al momento de registrar o actualizar la informacion del sistema", 1, $_SESSION['login_info']['idUser']);
            $data = array(
                "title" => "Ocurrio un error inesperado",
                "message" => "Metodo POST no encontrado",
                "type" => "error",
                "status" => false
            );
            toJson($data);
        }
        //Validacion que la tabla solo tenga un solo registro
        $request_data_all = $this->model->selects_info_system();
        //Si el resultado llega vacios entonces se asigna un valor de 0
        if (empty($request_data_all)) {
            $request_data_all = 0;
        }
        //si el resultado es un array y tiene mas de un registro entonces se procede a truncar la tabla
        if (is_array($request_data_all) && count($request_data_all) > 1) {
            $this->model->truncate_info_system();
            registerLog("Ocurrio un error inesperado", "La tabla de configuracion solo puede tener un registro, no se puede registrar mas de un registro, por lo que se procedio a truncar la tabla con la informacion", 1, $_SESSION['login_info']['idUser']);
            $data = array(
                "title" => "Ocurrio un error inesperado",
                "message" => "No se puede realizar el registro actualmente, refresca la pagina e intenta de nuevo",
                "type" => "error",
                "status" => false
            );
            toJson($data);
        }
        isCsrf(); //validacion de ataque CSRF
        //recuperacion de los datos del formulario
        $nombreSistema = strClean($_POST['nombreSistema']);
        $descripcion = strClean($_POST['descripcion']);
        $logo = ($_FILES) ? $_FILES["logo"]["name"] : "";
        //Validacion de campos vacios para el nombre del sistema
        if ($nombreSistema == "") {
            registerLog("Ocurrio un error inesperado", "El nombre del sistema no puede estar vacio", 1, $_SESSION['login_info']['idUser']);
            $data = array(
                "title" => "Ocurrio un error inesperado",
                "message" => "El nombre del sistema no puede estar vacio",
                "type" => "error",
                "status" => false
            );
            toJson($data);
        }
        //Validacion de que el campo tenga la misma estructura que el nombre del sistema
        if (verifyData("[A-ZÁÉÍÓÚÑa-záéíóúñ]+(\s[A-ZÁÉÍÓÚÑa-záéíóúñ]+)*", $nombreSistema)) {
            registerLog("Ocurrio un error inesperado", "El nombre del sistema no puede tener caracteres especiales", 1, $_SESSION['login_info']['idUser']);
            $data = array(
                "title" => "Ocurrio un error inesperado",
                "message" => "El nombre del sistema no puede tener caracteres especiales",
                "type" => "error",
                "status" => false
            );
            toJson($data);
        }
        if (verifyData("[a-zA-ZÁÉÍÓÚáéíóúÜüÑñ0-9\s.,;:!?()-]+", $descripcion)) {
            registerLog("Ocurrio un error inesperado", "La descripcion del sistema no puede tener caracteres especiales", 1, $_SESSION['login_info']['idUser']);
            $data = array(
                "title" => "Ocurrio un error inesperado",
                "message" => "La descripcion del sistema no puede tener caracteres especiales",
                "type" => "error",
                "status" => false
            );
            toJson($data);
        }
        //proceso de subida de la imagen de perfil al servidor
        if (isset($_FILES["logo"]["name"]) && !empty($_FILES["logo"]["name"])) {
            //Valdiacion de  tipos de imagen para subir
            if (isFile("image", $_FILES["logo"], ["jpg", "png", "jpeg"])) {
                registerLog("Ocurrio un error inesperado", "Para subir el logo/icono para el sistema solo se permite fotos de tipo JPEG, JPG, PNG", 1, $_SESSION['login_info']['idUser']);
                $data = array(
                    "title" => "Ocurrio un error inesperado",
                    "message" => "El formato de la imagen no cumple con los formatos solicitados",
                    "type" => "error",
                    "status" => false
                );
                toJson($data);
            }
            //Validacion de que la ruta de la imagen exista y si que se cree
            $ruta = getRoute() . "Profile/Logo/";
            if (verifyFolder($ruta, 0777, true)) {
                registerLog("Informacion de subida de archivos", "El usuario subio una foto de perfil, donde se valido que exista la ruta solicitada para subir el archivo", 3, $_SESSION['login_info']['idUser']);
            }
            //preparamos la ruta final para subir al servidor
            $nameFinalPhoto = uniqid() . "." . pathinfo($logo, PATHINFO_EXTENSION);
            $rutaFinal = $ruta . $nameFinalPhoto;
            //Subimos la imagen al servidor
            $request_moveFile = resizeAndCompressImage($_FILES["logo"]["tmp_name"], $rutaFinal, 0.5, 100, 100);
            if (!$request_moveFile) {
                registerLog("Registro exitoso", "No se logro subir el logo del sistema al momento de registrar sus datos principales", 2, $_SESSION['login_info']['idUser']);
                $data = array(
                    "title" => "Ocurrio un error inesperado",
                    "message" => "No se logro subir el logo del sistema",
                    "type" => "success",
                    "status" => true
                );
                toJson($data);
            }
            $logo = $nameFinalPhoto; //se asigna el nombre de la imagen a la variable
        }
        //validamos que si existe los datos de configuracion se actulice entonces la informacion
        if (is_array($request_data_all) && count($request_data_all) == 1) {
            //Se obtiene la informacion de sistema con una funcion que solo trae un solo registro
            $request_data = $this->model->select_info_system();
            $idConfiguration = $request_data['idConfiguration'];
            $c_logo = $request_data['c_logo'];
            if (isset($_POST["profile_exist"]) && empty($_FILES["logo"]["name"])) {
                $logo = $c_logo; //se asigna el logo existente
            }
            $request = $this->model->update_info_system($idConfiguration, $nombreSistema, $descripcion, $logo);
            if ($request) {
                if (isset($_POST["profile_exist"]) && !empty($_FILES["logo"]["name"])) {
                    //Procedemos a eliminar el icono del sistema
                    $img = $c_logo;
                    $ruta = getRoute() . "Profile/Logo";
                    if (delFolder($ruta, $img)) {
                        registerLog("Atención", "No se pudo eliminar el logo del sistema, al momento de eliminar un logo, pero si se elimino el usuario, posiblemente porque no existe el archivo", 3, $_SESSION['login_info']['idUser']);
                        $data = array(
                            "title" => "Atención",
                            "message" => "No se logro eliminar el logo del sistema, pero si se actualizao la informacion del sistema",
                            "type" => "info",
                            "status" => true
                        );
                        toJson($data);
                    }
                }
                registerLog("Actualizacion exitosa", "Se actualizo la informacion del sistema correctamente", 2, $_SESSION['login_info']['idUser']);
                $data = array(
                    "title" => "Actualizacion exitosa",
                    "message" => "Se actualizo la informacion del sistema correctamente",
                    "type" => "success",
                    "status" => true
                );
                toJson($data);
            } else {
                registerLog("Ocurrio un error inesperado", "No se logro actualizar la informacion del sistema", 1, $_SESSION['login_info']['idUser']);
                $data = array(
                    "title" => "Ocurrio un error inesperado",
                    "message" => "No se logro actualizar la informacion del sistema",
                    "type" => "error",
                    "status" => false
                );
                toJson($data);
            }
        }
        // caso contrario se realice el registro de informacion en la tabla
        $request = $this->model->insert_info_system($nombreSistema, $descripcion, $logo);
        if ($request) {
            registerLog("Registro exitoso", "Se registro la informacion del sistema correctamente", 2, $_SESSION['login_info']['idUser']);
            $data = array(
                "title" => "Registro exitoso",
                "message" => "Se registro la informacion del sistema correctamente",
                "type" => "success",
                "status" => true
            );
            toJson($data);
        } else {
            registerLog("Ocurrio un error inesperado", "No se logro registrar la informacion del sistema", 1, $_SESSION['login_info']['idUser']);
            $data = array(
                "title" => "Ocurrio un error inesperado",
                "message" => "No se logro registrar la informacion del sistema",
                "type" => "error",
                "status" => false
            );
            toJson($data);
        }
    }






    /**
     * Funcion que permite guardar la informacion general del sistema
     * @return void
     */
    public function setConfiguration()
    {
        //Se verifica si se tiene permiso para acceder a la vista
        permissionInterface(6);
        //validacion del Método POST
        if (!$_POST) {
            registerLog("Ocurrió un error inesperado", "Método POST no encontrado, al momento de registrar o actualizar la información del sistema", 1, $_SESSION['login_info']['idUser']);
            $data = array(
                "title" => "Ocurrió un error inesperado",
                "message" => "Método POST no encontrado",
                "type" => "error",
                "status" => false
            );
            toJson($data);
        }
        //Validacion que la tabla solo tenga un solo registro
        $request_data_all = $this->model->selects_info_configuration();
        //Si el resultado llega vacios entonces se asigna un valor de 0
        if (empty($request_data_all)) {
            $request_data_all = 0;
        }
        //si el resultado es un array y tiene mas de un registro entonces se procede a truncar la tabla
        if (is_array($request_data_all) && count($request_data_all) > 1) {
            $this->model->truncate_info_configuration();
            registerLog("Ocurrió un error inesperado", "La tabla de configuración solo puede tener un registro, no se puede registrar mas de un registro, por lo que se procedio a truncar la tabla con la informacion", 1, $_SESSION['login_info']['idUser']);
            $data = array(
                "title" => "Ocurrió un error inesperado",
                "message" => "No se puede realizar el registro actualmente, refresca la página e intenta de nuevo",
                "type" => "error",
                "status" => false
            );
            toJson($data);
        }
        isCsrf(); //validacion de ataque CSRF
        //validamos los que exisan en el formulario
        if (!isset($_POST['tituloEmpresa'])) {
            registerLog("Ocurrió un error inesperado", "El título de la empresa no puede estar vacio", 1, $_SESSION['login_info']['idUser']);
            $data = array(
                "title" => "Ocurrió un error inesperado",
                "message" => "El título de la empresa no puede estar vacio",
                "type" => "error",
                "status" => false
            );
            toJson($data);
        }
        if (!isset($_POST["subtituloEmpresa"])) {
            registerLog("Ocurrió un error inesperado", "El subtítulo de la empresa no puede estar vacio", 1, $_SESSION['login_info']['idUser']);
            $data = array(
                "title" => "Ocurrió un error inesperado",
                "message" => "El subtítulo de la empresa no puede estar vacio",
                "type" => "error",
                "status" => false
            );
            toJson($data);
        }
        if (!isset($_POST["emailEmpresa"])) {
            registerLog("Ocurrió un error inesperado", "El correo de la empresa no puede estar vacio", 1, $_SESSION['login_info']['idUser']);
            $data = array(
                "title" => "Ocurrió un error inesperado",
                "message" => "El correo de la empresa no puede estar vacio",
                "type" => "error",
                "status" => false
            );
            toJson($data);
        }
        if (!isset($_POST["rucEmpresa"])) {
            registerLog("Ocurrió un error inesperado", "El RUC de la empresa no puede estar vacio", 1, $_SESSION['login_info']['idUser']);
            $data = array(
                "title" => "Ocurrió un error inesperado",
                "message" => "El RUC de la empresa no puede estar vacio",
                "type" => "error",
                "status" => false
            );
            toJson($data);
        }
        if (!isset($_POST["direccionEmpresa"])) {
            registerLog("Ocurrió un error inesperado", "La dirección de la empresa no puede estar vacio", 1, $_SESSION['login_info']['idUser']);
            $data = array(
                "title" => "Ocurrió un error inesperado",
                "message" => "La dirección de la empresa no puede estar vacio",
                "type" => "error",
                "status" => false
            );
            toJson($data);
        }
        if (!isset($_POST["telefonoEmpresa"])) {
            registerLog("Ocurrió un error inesperado", "El teléfono de la empresa no puede estar vacio", 1, $_SESSION['login_info']['idUser']);
            $data = array(
                "title" => "Ocurrió un error inesperado",
                "message" => "El teléfono de la empresa no puede estar vacio",
                "type" => "error",
                "status" => false
            );
            toJson($data);
        }
        //recuperacion de los datos del formulario
        $tituloEmpresa = strClean($_POST['tituloEmpresa']);
        $subtituloEmpresa = strClean($_POST['subtituloEmpresa']);
        $emailEmpresa = strClean($_POST['emailEmpresa']);
        $rucEmpresa = strClean($_POST['rucEmpresa']);
        $direccionEmpresa = strClean($_POST['direccionEmpresa']);
        $telefonoEmpresa = strClean($_POST['telefonoEmpresa']);
        $patternTexto = "/^[a-zA-ZÁÉÍÓÚáéíóúÑñ0-9\s.,()#°\/-]+$/";
        if (
            !preg_match($patternTexto, $tituloEmpresa) ||
            !preg_match($patternTexto, $subtituloEmpresa) ||
            !preg_match($patternTexto, $direccionEmpresa)
        ) {

            registerLog("Caracteres inválidos", "Uno de los campos contiene caracteres no permitidos", 1, $_SESSION['login_info']['idUser']);
            $data = array(
                "title" => "Caracteres inválidos",
                "message" => "Evite símbolos especiales no permitidos en título, subtítulo o dirección",
                "type" => "error",
                "status" => false
            );
            toJson($data);
        }
        //validamos el formato del ruc de la empresa que solo permita los ruc de 10 y 20 de iniciales ya que una validacion es para persona natural y otra para persona juridica
        if (!preg_match('/^(10|20)\d{9}$/', $rucEmpresa)) {
            registerLog("RUC inválido", "El RUC debe tener 11 dígitos y comenzar con 10 o 20", 1, $_SESSION['login_info']['idUser']);
            $data = array(
                "title" => "RUC inválido",
                "message" => "El RUC debe tener 11 dígitos y comenzar con 10 o 20",
                "type" => "error",
                "status" => false
            );
            toJson($data);
        }
        //validamos el formato del telefono de la empresa que solo permita los numeros de 9 digitos
        if (!preg_match('/^\d{9}$/', $telefonoEmpresa)) {
            registerLog("Teléfono inválido", "El número de teléfono debe tener exactamente 9 dígitos", 1, $_SESSION['login_info']['idUser']);
            $data = array(
                "title" => "Teléfono inválido",
                "message" => "El número de teléfono debe tener exactamente 9 dígitos",
                "type" => "error",
                "status" => false
            );
            toJson($data);
        }

        //Validacion de campos vacios para el nombre del sistema
        if (empty($tituloEmpresa)) {
            registerLog("Ocurrió un error inesperado", "El título de la empresa no puede estar vacio", 1, $_SESSION['login_info']['idUser']);
            $data = array(
                "title" => "Ocurrió un error inesperado",
                "message" => "El título de la empresa no puede estar vacio",
                "type" => "error",
                "status" => false
            );
            toJson($data);
        }
        if (empty($subtituloEmpresa)) {
            registerLog("Ocurrió un error inesperado", "El subtítulo de la empresa no puede estar vacio", 1, $_SESSION['login_info']['idUser']);
            $data = array(
                "title" => "Ocurrió un error inesperado",
                "message" => "El subtítulo de la empresa no puede estar vacio",
                "type" => "error",
                "status" => false
            );
            toJson($data);
        }
        if (empty($emailEmpresa) || !filter_var($emailEmpresa, FILTER_VALIDATE_EMAIL)) {
            registerLog("Correo inválido", "El correo electrónico está vacío o tiene un formato inválido", 1, $_SESSION['login_info']['idUser']);
            $data = array(
                "title" => "Correo inválido",
                "message" => "El correo electrónico está vacío o tiene un formato inválido",
                "type" => "error",
                "status" => false
            );
            toJson($data);
        }
        if (empty($telefonoEmpresa)) {
            registerLog("Ocurrió un error inesperado", "El teléfono de la empresa no puede estar vacio", 1, $_SESSION['login_info']['idUser']);
            $data = array(
                "title" => "Ocurrió un error inesperado",
                "message" => "El teléfono de la empresa no puede estar vacio",
                "type" => "error",
                "status" => false
            );
            toJson($data);
        }
        if (empty($rucEmpresa)) {
            registerLog("Ocurrió un error inesperado", "El RUC de la empresa no puede estar vacio", 1, $_SESSION['login_info']['idUser']);
            $data = array(
                "title" => "Ocurrió un error inesperado",
                "message" => "El RUC de la empresa no puede estar vacio",
                "type" => "error",
                "status" => false
            );
            toJson($data);
        }
        if (empty($direccionEmpresa)) {
            registerLog("Ocurrió un error inesperado", "La dirección de la empresa no puede estar vacio", 1, $_SESSION['login_info']['idUser']);
            $data = array(
                "title" => "Ocurrió un error inesperado",
                "message" => "La dirección de la empresa no puede estar vacio",
                "type" => "error",
                "status" => false
            );
            toJson($data);
        }
        if (empty($telefonoEmpresa)) {
            registerLog("Ocurrió un error inesperado", "El teléfono de la empresa no puede estar vacio", 1, $_SESSION['login_info']['idUser']);
            $data = array(
                "title" => "Ocurrió un error inesperado",
                "message" => "El teléfono de la empresa no puede estar vacio",
                "type" => "error",
                "status" => false
            );
            toJson($data);
        }
        //validamos que si existe los datos de configuracion se actulice entonces la informacion
        if (is_array($request_data_all) && count($request_data_all) == 1) {
            //Se obtiene la informacion de sistema con una funcion que solo trae un solo registro
            $request_data = $this->model->select_info_configuration();
            $id = $request_data['id'];

            $request = $this->model->update_info_configuration($id, $tituloEmpresa, $subtituloEmpresa, $emailEmpresa, $rucEmpresa, $direccionEmpresa, $telefonoEmpresa);
            if ($request) {

                registerLog("Actualización exitosa", "Se actualizó la información del sistema correctamente", 2, $_SESSION['login_info']['idUser']);
                $data = array(
                    "title" => "Actualización exitosa",
                    "message" => "Se actualizó la información del sistema correctamente",
                    "type" => "success",
                    "status" => true
                );
                toJson($data);
            } else {
                registerLog("Ocurrió un error inesperado", "No se logró actualizar la información del sistema", 1, $_SESSION['login_info']['idUser']);
                $data = array(
                    "title" => "Ocurrió un error inesperado",
                    "message" => "No se logró actualizar la información del sistema",
                    "type" => "error",
                    "status" => false
                );
                toJson($data);
            }
        }
        // caso contrario se realice el registro de informacion en la tabla
        $request = $this->model->insert_info_configuration($tituloEmpresa, $subtituloEmpresa, $emailEmpresa, $rucEmpresa, $direccionEmpresa, $telefonoEmpresa);
        if ($request) {
            registerLog("Registro exitoso", "Se registró la información del sistema correctamente", 2, $_SESSION['login_info']['idUser']);
            $data = array(
                "title" => "Registro exitoso",
                "message" => "Se registró la información del sistema correctamente",
                "type" => "success",
                "status" => true
            );
            toJson($data);
        } else {
            registerLog("Ocurrió un error inesperado", "No se logro registrar la información del sistema", 1, $_SESSION['login_info']['idUser']);
            $data = array(
                "title" => "Ocurrió un error inesperado",
                "message" => "No se logró registrar la información del sistema",
                "type" => "error",
                "status" => false
            );
            toJson($data);
        }
    }
}
