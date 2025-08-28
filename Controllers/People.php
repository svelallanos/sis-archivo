<?php

use LDAP\Result;

class People extends Controllers
{
    public function __construct()
    {
        isSession();
        parent::__construct();
    }

    public function people()
    {
        $data['page_id'] = 11;
        permissionInterface($data['page_id']);
        $data['page_title'] = "Gestión de Personas";
        $data['page_description'] = "Te permite gestionar todas las personas.";
        $data['page_container'] = "People";
        $data['page_js_css'] = "people";
        registerLog("Información de navegación", "El usuario entro a :" . $data['page_title'], 3, $_SESSION['login_info']['idUser']);
        $this->views->getView($this, "people", $data);
    }

    public function getAllPeople()
    {
        permissionInterface(11);
        $arrFilePeople = $this->model->getAllFilePeople('tb_people');

        foreach ($arrFilePeople as $value) {
            $auxFilePeople[$value['id_code']] = $value;
        }
        $arrData = $this->model->getAllPeople();
        if (!empty($arrData)) {
            foreach ($arrData as $key => $value) {
                if ($value['status'] === 'ACTIVO') {
                    $arrData[$key]['status'] = '<span class="badge badge-success"><i class="fa fa-check"></i> ACTIVO</span>';
                } else {
                    $arrData[$key]['status'] = '<span class="badge badge-danger"><i class="fa fa-close"></i> INACTIVO</span>';
                }
                // Convertir la cadena de fecha a un objeto DateTime
                $date = new DateTime($value['dateRegistration']);
                // Formatear la fecha y hora
                $formattedDate = $date->format('Y-m-d');  // "2025-04-10"
                $formattedTime = $date->format('h:i A');  // "01:21 PM"

                // Asignar la fecha y hora formateadas a la variable
                $arrData[$key]['dateRegister'] = $formattedDate . ' <b>' . $formattedTime . '</b>';
                $img = "clientes.png";
                if (isset($auxFilePeople[$value['id']])) {
                    $img = $auxFilePeople[$value['id']]["name"];
                }
                if ($value["typePeople"] === "NATURAL") {
                    $arrData[$key]["typeDoc"] = '<span class="badge badge-info">DNI</span>';
                    $arrData[$key]["fullName"] = $value["name"] . " " . $value["lastname"];
                } else {
                    $arrData[$key]["typeDoc"] = '<span class="badge badge-info">RUC</span>';
                    $arrData[$key]["fullName"] = $value["fullname"];
                }
                $arrData[$key]['birthdate'] = $value['birthdate'] ? $value['birthdate'] : 'No especificado';
                $arrData[$key]['gender'] = $value['gender'] ? $value['gender'] : 'No especificado';
                $arrData[$key]['_numberDocument'] = "<badge class='badge badge-secondary'>" . $value["numberDocument"] . "</badge>";
                $arrData[$key]['_mail'] = "<a href='mailto:" . $value["mail"] . "'>" . $value["mail"] . "</a>";
                $arrData[$key]['_phone'] = "<a href='tel:" . $value["phone"] . "'>" . $value["phone"] . "</a>";
                $arrData[$key]['_img'] = "<div class='img-profile'><img src='" . base_url() . "/loadfile/people/?f=" . $img . "' alt='Imagen de perfil'></div>";
                $arrData[$key]['actions'] = '
                <div class="btn-group">
                <button type="button" title="Editar Persona" class="btn btn-success __btn_edit" 
                data-id="' . $value["id"] . '" 
                data-name="' . $value["name"] . '" 
                data-lastname="' . $value["lastname"] . '"
                data-fullname="' . $value["fullname"] . '"
                data-numberdocument="' . $value["numberDocument"] . '"
                data-typepeople="' . $value["typePeople"] . '"
                data-birthdate="' . $arrData[$key]['birthdate'] . '"
                data-gender="' . $arrData[$key]['gender'] . '"
                data-mail="' . $value["mail"] . '"
                data-phone="' . $value["phone"] . '"
                data-address="' . $value["address"] . '"
                data-status="' . $value["status"] . '"
                data-img="' . $img . '" 
                ><i class="m-auto fa fa-pencil"></i></button>
                <button type="button" title="Datos de la persona" class="btn btn-info __btn_view" 
                data-id="' . $value["id"] . '" 
                data-name="' . $value["name"] . '" 
                data-lastname="' . $value["lastname"] . '"
                data-fullname="' . $value["fullname"] . '"
                data-numberdocument="' . $value["numberDocument"] . '"
                data-typepeople="' . $value["typePeople"] . '"
                data-birthdate="' . $arrData[$key]['birthdate'] . '"
                data-gender="' . $arrData[$key]['gender'] . '"
                data-mail="' . $value["mail"] . '"
                data-phone="' . $value["phone"] . '"
                data-address="' . $value["address"] . '"
                data-img="' . $img . '" 
                data-dateRegistration="' . $value["dateRegistration"] . '" 
                data-dateUpdate="' . $value["dateUpdate"] . '" 
                data-status="' . $value["status"] . '" 
                ><i class="fa fa-exclamation-circle" aria-hidden="true"></i></button>
                <button type="button" title="Eliminar persona" class="btn btn-danger __btn_delete" 
                data-id="' . $value["id"] . '" 
                data-typepeople="' . $value["typePeople"] . '" 
                data-fullname="' . $value["fullname"] . '" 
                data-name="' . $value["name"] . '" 
                data-lastname="' . $value["lastname"] . '" 
                data-numberdocument="' . $value["numberDocument"] . '" 
                data-img="' . $img . '"
                ><i class="fa fa-remove"></i></button>
                <a href="' . base_url() . '/pdf/people/' . encryption($value["id"]) . '" target="_Blank" class="btn btn-warning"><i class="fa fa-print text-white"></i></a>

                 </div>';
            }
        }
        toJson($arrData);
    }

    public function setPeople()
    {
        permissionInterface(11);
        // Validamos si el método es POST
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            registerLog("Ocurrió un error inesperado", "Método POST no encontrado al registrar la presentación", 1, $_SESSION['login_info']['idRole']);
            $data = array(
                "title" => "Ocurrió un error inesperado",
                "message" => "Método POST no encontrado",
                "type" => "error",
                "status" => false
            );
            toJson($data);
        }
        //Validamos los campos obligatorios
        if (!isset($_REQUEST['txtnumberDocument']) || !isset($_REQUEST['txtPhone']) || !isset($_REQUEST['txtAddress'])) {
            $data = array(
                "title" => "Ocurrió un error inesperado",
                "message" => "Todos los campos son obligatorios",
                "type" => "error",
                "status" => false
            );
            toJson($data);
        }
        if (!isset($_REQUEST['checkCompanyName']) && ($_REQUEST['checkCompanyName'] === "NATURAL" || $_REQUEST['checkCompanyName'] === "JURIDICA")) {
            $data = array(
                "title" => "Ocurrió un error inesperado",
                "message" => "Debe seleccionar si es persona natural o jurídica",
                "type" => "error",
                "status" => false
            );
            toJson($data);
        }
        // validamos cuando es persona natural
        if ($_REQUEST['checkCompanyName'] === "NATURAL") {
            if (!isset($_REQUEST['txtName']) || !isset($_REQUEST['txtLastname'])) {
                $data = array(
                    "title" => "Ocurrió un error inesperado",
                    "message" => "Todos los campos son obligatorios",
                    "type" => "error",
                    "status" => false
                );
                toJson($data);
            }
            $strName = strClean($_POST["txtName"]);
            $strLastname = strClean($_POST["txtLastname"]);
            $strBirthdate = !empty($_POST["txtBirthdate"]) ? strClean($_POST["txtBirthdate"]) : null;
            $strGender = strClean($_POST["txtGender"]);
            $strCompanyName = null;
        } else {
            if (!isset($_REQUEST['txtCompanyName'])) {
                $data = array(
                    "title" => "Ocurrió un error inesperado",
                    "message" => "Todos los campos son obligatorios",
                    "type" => "error",
                    "status" => false
                );
                toJson($data);
            }
            $strName = null;
            $strLastname = null;
            $strBirthdate = null;
            $strGender = null;
            $strCompanyName = strClean($_POST["txtCompanyName"]);
        }
        isCsrf(); //validacion de ataque CSRF
        // Limpieza de los inputs
        $strNumberDocument = strClean($_POST["txtnumberDocument"]);
        $strEmail = strClean($_POST["txtMail"]);
        $strPhone = strClean($_POST["txtPhone"]);
        $strAddress = strClean($_POST["txtAddress"]);
        $strComment = strClean($_POST["txtComment"]);
        $strFile = ($_FILES) ? $_FILES["flPhoto"]["name"] : "";

        if ($_REQUEST['checkCompanyName'] === "NATURAL") {
            // Validación del formato de texto en el nombre (solo letras y espacios, mínimo 4 caracteres, máximo 255)
            if (verifyData("[A-Za-zÁÉÍÓÚáéíóúÑñ\s]{4,255}", $strName)) {
                registerLog("Ocurrió un error inesperado", "El campo Nombre no cumple con el formato de texto", 1, $_SESSION['login_info']['idUser']);
                $data = array(
                    "title" => "Ocurrio un error inesperado",
                    "message" => "El campo nombre no cumple con el formato de texto",
                    "type" => "error",
                    "status" => false
                );
                toJson($data);
            }
            // Validación del formato de texto en el apellido (solo letras y espacios, mínimo 4 caracteres, máximo 255)
            if (verifyData("[A-Za-zÁÉÍÓÚáéíóúÑñ\s]{4,255}", $strLastname)) {
                registerLog("Ocurrió un error inesperado", "El campo Apellido no cumple con el formato de texto", 1, $_SESSION['login_info']['idUser']);
                $data = array(
                    "title" => "Ocurrio un error inesperado",
                    "message" => "El campo apellido no cumple con el formato de texto",
                    "type" => "error",
                    "status" => false
                );
                toJson($data);
            }
            // Validación del formato de texto en el DNI (solo números, mínimo 8 caracteres, máximo 8)
            if (verifyData("[0-9]{8}", $strNumberDocument)) {
                registerLog("Ocurrió un error inesperado", "El número de documento no cumple con el formato de texto", 1, $_SESSION['login_info']['idUser']);
                $data = array(
                    "title" => "Ocurrio un error inesperado",
                    "message" => "El número de documento no cumple con el formato de texto",
                    "type" => "error",
                    "status" => false
                );
                toJson($data);
            }
            if (!empty($strBirthdate)) {
                // Validación del formato de fecha de nacimiento (debe ser una fecha válida)
                if (verifyData("^(19|20)\d{2}-(0[1-9]|1[0-2])-(0[1-9]|[12][0-9]|3[01])$", $strBirthdate)) {
                    registerLog("Ocurrió un error inesperado", "El campo Fecha de Nacimiento no cumple con el formato de fecha", 1, $_SESSION['login_info']['idUser']);
                    $data = array(
                        "title" => "Ocurrio un error inesperado",
                        "message" => "El campo fecha de nacimiento no cumple con el formato de fecha",
                        "type" => "error",
                        "status" => false
                    );
                    toJson($data);
                }
            }
            // Validación del género (debe ser 'Masculino' o 'Femenino' o 'Otro')
            $strGender = ucfirst(strtolower($strGender)); // Convertir a mayúscula la primera letra
            if (!in_array($strGender, ['Masculino', 'Femenino', 'Otro'])) {
                registerLog("Ocurrió un error inesperado", "El campo Género no es válido", 1, $_SESSION['login_info']['idUser']);
                $data = array(
                    "title" => "Ocurrio un error inesperado",
                    "message" => "El campo género no es válido",
                    "type" => "error",
                    "status" => false
                );
                toJson($data);
            }
        } else {
            // Validación del formato de texto en el RUC (solo números, mínimo 11 caracteres, máximo 11)
            if (verifyData("[0-9]{11}", $strNumberDocument)) {
                registerLog("Ocurrió un error inesperado", "El número de documento no cumple con el formato de texto", 1, $_SESSION['login_info']['idUser']);
                $data = array(
                    "title" => "Ocurrio un error inesperado",
                    "message" => "El número de documento no cumple con el formato de texto",
                    "type" => "error",
                    "status" => false
                );
                toJson($data);
            }
            // Validación del formato de texto en la razón social (solo letras y espacios, mínimo 4 caracteres, máximo 255)
            if (verifyData("[A-Za-zÁÉÍÓÚáéíóúÑñ\s]{4,255}", $strCompanyName)) {
                registerLog("Ocurrió un error inesperado", "El campo Razón Social no cumple con el formato de texto", 1, $_SESSION['login_info']['idUser']);
                $data = array(
                    "title" => "Ocurrio un error inesperado",
                    "message" => "El campo razón social no cumple con el formato de texto",
                    "type" => "error",
                    "status" => false
                );
                toJson($data);
            }
        }
        // Validar el formato solo si se ha ingresado un email
        if (!empty($strEmail)) {
            // Validación del formato de texto en el email (correo electrónico)
            if (!filter_var($strEmail, FILTER_VALIDATE_EMAIL)) {
                registerLog("Ocurrió un error inesperado", "El campo Email no cumple con el formato de texto", 1, $_SESSION['login_info']['idUser']);
                $data = array(
                    "title" => "Ocurrió un error inesperado",
                    "message" => "El campo email no cumple con el formato de texto",
                    "type" => "error",
                    "status" => false
                );
                toJson($data);
            }
        }
        // Validación del formato de texto en el teléfono (solo números, mínimo 9 caracteres, máximo 9)
        if (verifyData("[0-9]{9}", $strPhone)) {
            registerLog("Ocurrió un error inesperado", "El campo Teléfono no cumple con el formato de texto", 1, $_SESSION['login_info']['idUser']);
            $data = array(
                "title" => "Ocurrio un error inesperado",
                "message" => "El campo teléfono no cumple con el formato de texto",
                "type" => "error",
                "status" => false
            );
            toJson($data);
        }
        // Validación del formato de texto en la dirección (solo letras, números, espacios y caracteres especiales, mínimo 4 caracteres, máximo 255) y ejemplo "Jr. Iquitos #251, Lima, Perú"
        if (verifyData("[A-Za-z0-9ÁÉÍÓÚáéíóúÑñ\s\.\-,#]{4,255}", $strAddress)) {
            registerLog("Ocurrió un error inesperado", "El campo Dirección no cumple con el formato de texto", 1, $_SESSION['login_info']['idUser']);
            $data = array(
                "title" => "Ocurrio un error inesperado",
                "message" => "El campo dirección no cumple con el formato de texto",
                "type" => "error",
                "status" => false
            );
            toJson($data);
        }
        // Validamos que no hay un registro con el mismo DNI o RUC
        $arrData = $this->model->getPeopleByNumberDocument($strNumberDocument);
        if (!empty($arrData)) {
            $data = array(
                "title" => "Ocurrió un error inesperado",
                "message" => "Ya existe un registro con el mismo número de documento",
                "type" => "warning",
                "status" => false
            );
            toJson($data);
        }
        // Auxiliar para la imagen
        $validFile = false;
        if (isset($_FILES["flPhoto"]["name"]) && !empty($_FILES["flPhoto"]["name"])) {
            //Validacion de  tipos de imagen para subir
            if (isFile("image", $_FILES["flPhoto"], ["jpg", "png", "jpeg"])) {
                registerLog("Ocurrio un error inesperado", "Para subir fotos de perfil para los usuarios solo se permite fotos de tipo JPEG, JPG, PNG", 1, $_SESSION['login_info']['idUser']);
                $data = array(
                    "title" => "Ocurrio un error inesperado",
                    "message" => "El formato de la imagen no cumple con los formatos solicitados",
                    "type" => "error",
                    "status" => false
                );
                toJson($data);
            }

            //validacion de tamaño permitido para imagen
            $sizeFile = $_FILES["flPhoto"]["size"];
            if (valConvert($sizeFile)["Mb"] > 2) {
                registerLog("Ocurrio un error inesperado", "La imagen es muy grande, el tamaño permitido es de 2MB, para la foto de perfil", 1, $_SESSION['login_info']['idUser']);
                $data = array(
                    "title" => "Ocurrio un error inesperado",
                    "message" => "La imagen es muy grande, el tamaño permitido es de 2MB",
                    "type" => "error",
                    "status" => false
                );
                toJson($data);
            }
            //Obtener los datos de la imagen
            $fileName = $_FILES['flPhoto']['name'];
            $fileSize = $_FILES['flPhoto']['size'];
            $fileType = $_FILES['flPhoto']['type'];
            $fileNameCmps = explode(".", $fileName);
            $fileExtension = strtolower(end($fileNameCmps));

            //Validacion de que la ruta de la imagen exista y si que se cree
            $ruta = getRoute() . "People/";
            if (verifyFolder($ruta, 0777, true)) {
                registerLog("Informacion de subida de archivos", "El usuario subio una foto de perfil, donde se valido que exista la ruta solicitada para subir el archivo", 3, $_SESSION['login_info']['idUser']);
            }
            //preparamos la ruta final para subir al servidor
            $nameFinalPhoto = 'img_' . date('Ymd_His') . '.' . $fileExtension;;
            $rutaFinal = $ruta . $nameFinalPhoto;
            //Subimos la imagen al servidor
            $request_moveFile = move_uploaded_file($_FILES["flPhoto"]["tmp_name"], $rutaFinal);
            if (!$request_moveFile) {
                registerLog("Registro exitoso", "No se logro subir la imagen al momento de registrar el perfil", 2, $_SESSION['login_info']['idUser']);
                $data = array(
                    "title" => "Ocurrio un error inesperado",
                    "message" => "No se logró subir la imagen",
                    "type" => "success",
                    "status" => true
                );
                toJson($data);
            }
            $validFile = true;
            $strFile = $nameFinalPhoto; //se asigna el nombre de la imagen a la variable
        }
        // Insertamos los datos en la base de datos
        $request = $this->model->setPeople(
            $strName,
            $strCompanyName,
            $strLastname,
            $strNumberDocument,
            $_POST['checkCompanyName'],
            $strBirthdate,
            $strGender,
            $strEmail,
            $strPhone,
            $strAddress,
            $strComment,
        );
        // Validamos si se insertó correctamente
        if ($request > 0) {
            // Cargamos la imagen al perfil
            if ($validFile) {
                $request = $this->model->setImagePeople($request, 'tb_people', $strFile, $fileType, $fileSize);
                // Validamos si se insertó correctamente
                if ($request) {
                    registerLog("Registro exitoso", "Perfil registrado correctamente", 2, $_SESSION['login_info']['idUser']);
                    $data = array(
                        "title" => "Registro exitoso",
                        "message" => "Perfil registrado correctamente.",
                        "type" => "success",
                        "status" => true
                    );
                } else {
                    registerLog("Registro exitoso", "Perfil registrado correctamente", 2, $_SESSION['login_info']['idUser']);
                    $data = array(
                        "title" => "Registro exitoso",
                        "message" => "Perfil registrado correctamente pero no se pudo cargar la imagen.",
                        "type" => "success",
                        "status" => true
                    );
                }
                toJson($data);
            }
            registerLog("Registro exitoso", "Perfil registrado correctamente", 2, $_SESSION['login_info']['idUser']);
            $data = array(
                "title" => "Registro exitoso",
                "message" => "El perfil se ha registrado correctamente",
                "type" => "success",
                "status" => true
            );
            toJson($data);
        }

        registerLog("Ocurrio un error inesperado", "La persona no se ha registrado correctamente", 1, $_SESSION['login_info']['idRole']);
        $data = array(
            "title" => "Ocurrio un error inesperado",
            "message" => "La persona no se ha registrado correctamente",
            "type" => "error",
            "status" => false
        );
        toJson($data);
    }

    public function updatePeople()
    {
        permissionInterface(11);
        // Validamos si el método es POST
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            registerLog("Ocurrio un error inesperado", "Metodo POST no encontrado, al momento de actualizar la presentación", 1, $_SESSION['login_info']['idUser']);
            $data = array(
                "title" => "Ocurrió un error inesperado",
                "message" => "Método POST no encontrado",
                "type" => "error",
                "status" => false
            );
            toJson($data);
        }
        //Validamos los campos obligatorios
        if (!isset($_REQUEST['txtNumberDocumentUpdate']) || !isset($_REQUEST['txtPhoneUpdate']) || !isset($_REQUEST['txtAddressUpdate'])) {
            $data = array(
                "title" => "Ocurrió un error inesperado",
                "message" => "Todos los campos son obligatorios",
                "type" => "error",
                "status" => false
            );
            toJson($data);
        }
        if (!isset($_REQUEST['checkCompanyNameUpdate']) && ($_REQUEST['checkCompanyNameUpdate'] === "NATURAL" || $_REQUEST['checkCompanyNameUpdate'] === "JURIDICA")) {
            $data = array(
                "title" => "Ocurrió un error inesperado",
                "message" => "Debe seleccionar si es persona natural o jurídica",
                "type" => "error",
                "status" => false
            );
            toJson($data);
        }
        // validamos cuando es persona natural
        if ($_REQUEST['checkCompanyNameUpdate'] === "NATURAL") {
            if (!isset($_REQUEST['txtNameUpdate']) || !isset($_REQUEST['txtLastnameUpdate'])) {
                $data = array(
                    "title" => "Ocurrió un error inesperado",
                    "message" => "Todos los campos son obligatorios",
                    "type" => "error",
                    "status" => false
                );
                toJson($data);
            }
            $strName = strClean($_POST["txtNameUpdate"]);
            $strLastname = strClean($_POST["txtLastnameUpdate"]);
            $strBirthdate = !empty($_POST["txtBirthdateUpdate"]) ? strClean($_POST["txtBirthdateUpdate"]) : null;
            $strGender = strClean($_POST["txtGenderUpdate"]);
            $strCompanyName = null;
        } else {
            if (!isset($_REQUEST['txtCompanyNameUpdate'])) {
                $data = array(
                    "title" => "Ocurrió un error inesperado",
                    "message" => "Todos los campos son obligatorios",
                    "type" => "error",
                    "status" => false
                );
                toJson($data);
            }
            $strName = null;
            $strLastname = null;
            $strBirthdate = null;
            $strGender = null;
            $strCompanyName = strClean($_POST["txtCompanyNameUpdate"]);
        }
        isCsrf(); //validacion de ataque CSRF
        // Validación del id
        $strId = strClean($_POST["id"]);
        // Convertimos a entero el id
        $strId = (int) $strId;
        // validación si existe el id en la base de datos
        $arrData = $this->model->getPeople($strId);
        if (empty($arrData)) {
            $data = array(
                "title" => "Ocurrió un error inesperado",
                "message" => "La persona no existe",
                "type" => "error",
                "status" => false
            );
            toJson($data);
        }
        // Limpieza de los inputs
        $strNumberDocument = strClean($_POST["txtNumberDocumentUpdate"]);
        $strEmail = strClean($_POST["txtMailUpdate"]);
        $strPhone = strClean($_POST["txtPhoneUpdate"]);
        $strAddress = strClean($_POST["txtAddressUpdate"]);
        $strComment = strClean($_POST["txtCommentUpdate"]);
        $strStatus = strClean($_POST["txtStatusUpdate"]);
        $strFile = ($_FILES) ? $_FILES["flPhoto_update"]["name"] : "";
        $strImgActual = strClean($_POST["imgActual"]);


        if ($_REQUEST['checkCompanyNameUpdate'] === "NATURAL") {
            // Validación del formato de texto en el nombre (solo letras y espacios, mínimo 4 caracteres, máximo 255)
            if (verifyData("[A-Za-zÁÉÍÓÚáéíóúÑñ\s]{4,255}", $strName)) {
                registerLog("Ocurrió un error inesperado", "El campo Nombre no cumple con el formato de texto", 1, $_SESSION['login_info']['idUser']);
                $data = array(
                    "title" => "Ocurrio un error inesperado",
                    "message" => "El campo nombre no cumple con el formato de texto",
                    "type" => "error",
                    "status" => false
                );
                toJson($data);
            }
            // Validación del formato de texto en el apellido (solo letras y espacios, mínimo 4 caracteres, máximo 255)
            if (verifyData("[A-Za-zÁÉÍÓÚáéíóúÑñ\s]{4,255}", $strLastname)) {
                registerLog("Ocurrió un error inesperado", "El campo Apellido no cumple con el formato de texto", 1, $_SESSION['login_info']['idUser']);
                $data = array(
                    "title" => "Ocurrio un error inesperado",
                    "message" => "El campo apellido no cumple con el formato de texto",
                    "type" => "error",
                    "status" => false
                );
                toJson($data);
            }
            // Validación del formato de texto en el DNI (solo números, mínimo 8 caracteres, máximo 8)
            if (verifyData("[0-9]{8}", $strNumberDocument)) {
                registerLog("Ocurrió un error inesperado", "El número de documento no cumple con el formato de texto", 1, $_SESSION['login_info']['idUser']);
                $data = array(
                    "title" => "Ocurrio un error inesperado",
                    "message" => "El número de documento no cumple con el formato de texto",
                    "type" => "error",
                    "status" => false
                );
                toJson($data);
            }
            if (!empty($strBirthdate)) {
                // Validación del formato de fecha de nacimiento (debe ser una fecha válida)
                if (verifyData("^(19|20)\d{2}-(0[1-9]|1[0-2])-(0[1-9]|[12][0-9]|3[01])$", $strBirthdate)) {
                    registerLog("Ocurrió un error inesperado", "El campo Fecha de Nacimiento no cumple con el formato de fecha", 1, $_SESSION['login_info']['idUser']);
                    $data = array(
                        "title" => "Ocurrio un error inesperado",
                        "message" => "El campo fecha de nacimiento no cumple con el formato de fecha",
                        "type" => "error",
                        "status" => false
                    );
                    toJson($data);
                }
            }
            // Validación del género (debe ser 'Masculino' o 'Femenino' o 'Otro')
            $strGender = ucfirst(strtolower($strGender)); // Convertir a mayúscula la primera letra
            if (!in_array($strGender, ['Masculino', 'Femenino', 'Otro'])) {
                registerLog("Ocurrió un error inesperado", "El campo Género no es válido", 1, $_SESSION['login_info']['idUser']);
                $data = array(
                    "title" => "Ocurrio un error inesperado",
                    "message" => "El campo género no es válido",
                    "type" => "error",
                    "status" => false
                );
                toJson($data);
            }
        } else {
            // Validación del formato de texto en el RUC (solo números, mínimo 11 caracteres, máximo 11)
            if (verifyData("[0-9]{11}", $strNumberDocument)) {
                registerLog("Ocurrió un error inesperado", "El número de documento no cumple con el formato de texto", 1, $_SESSION['login_info']['idUser']);
                $data = array(
                    "title" => "Ocurrio un error inesperado",
                    "message" => "El número de documento no cumple con el formato de texto",
                    "type" => "error",
                    "status" => false
                );
                toJson($data);
            }
            // Validación del formato de texto en la razón social (solo letras y espacios, mínimo 4 caracteres, máximo 255)
            if (verifyData("[A-Za-zÁÉÍÓÚáéíóúÑñ\s]{4,255}", $strCompanyName)) {
                registerLog("Ocurrió un error inesperado", "El campo Razón Social no cumple con el formato de texto", 1, $_SESSION['login_info']['idUser']);
                $data = array(
                    "title" => "Ocurrio un error inesperado",
                    "message" => "El campo razón social no cumple con el formato de texto",
                    "type" => "error",
                    "status" => false
                );
                toJson($data);
            }
        }
        // Validar el formato solo si se ha ingresado un email
        if (!empty($strEmail)) {
            if (!filter_var($strEmail, FILTER_VALIDATE_EMAIL)) {
                registerLog("Ocurrió un error inesperado", "El campo Email no cumple con el formato estándar", 1, $_SESSION['login_info']['idUser']);
                $data = array(
                    "title" => "Ocurrió un error inesperado",
                    "message" => "El campo email no cumple con el formato válido",
                    "type" => "error",
                    "status" => false
                );
                toJson($data);
            }
        }
        // Validación del formato de texto en el teléfono (solo números, mínimo 9 caracteres, máximo 9)
        if (verifyData("[0-9]{9}", $strPhone)) {
            registerLog("Ocurrió un error inesperado", "El campo Teléfono no cumple con el formato de texto", 1, $_SESSION['login_info']['idUser']);
            $data = array(
                "title" => "Ocurrio un error inesperado",
                "message" => "El campo teléfono no cumple con el formato de texto",
                "type" => "error",
                "status" => false
            );
            toJson($data);
        }
        // Validación del formato de texto en la dirección (solo letras, números, espacios y caracteres especiales, mínimo 4 caracteres, máximo 255) y ejemplo "Jr. Iquitos #251, Lima, Perú"
        if (verifyData("[A-Za-z0-9ÁÉÍÓÚáéíóúÑñ\s\.\-,#]{4,255}", $strAddress)) {
            registerLog("Ocurrió un error inesperado", "El campo Dirección no cumple con el formato de texto", 1, $_SESSION['login_info']['idUser']);
            $data = array(
                "title" => "Ocurrio un error inesperado",
                "message" => "El campo dirección no cumple con el formato de texto",
                "type" => "error",
                "status" => false
            );
            toJson($data);
        }
        // Validamos que no hay un registro con el mismo número de documento
        $arrData = $this->model->getPeopleByNumberDocument($strNumberDocument);
        if (!empty($arrData) && $arrData['id'] != $strId) {
            $data = array(
                "title" => "Ocurrió un error inesperado",
                "message" => "Ya existe un registro con el mismo número de documento",
                "type" => "warning",
                "status" => false
            );
            toJson($data);
        }
        // Auxiliar para la imagen
        $validFile = false;
        if (isset($_FILES["flPhoto_update"]["name"]) && !empty($_FILES["flPhoto_update"]["name"])) {
            //Validacion de  tipos de imagen para subir
            if (isFile("image", $_FILES["flPhoto_update"], ["jpg", "png", "jpeg"])) {
                registerLog("Ocurrio un error inesperado", "Para subir fotos de perfil para los usuarios solo se permite fotos de tipo JPEG, JPG, PNG", 1, $_SESSION['login_info']['idUser']);
                $data = array(
                    "title" => "Ocurrio un error inesperado",
                    "message" => "El formato de la imagen no cumple con los formatos solicitados",
                    "type" => "error",
                    "status" => false
                );
                toJson($data);
            }

            //validacion de tamaño permitido para imagen
            $sizeFile = $_FILES["flPhoto_update"]["size"];
            if (valConvert($sizeFile)["Mb"] > 2) {
                registerLog("Ocurrio un error inesperado", "La imagen es muy grande, el tamaño permitido es de 2MB, para la foto de perfil", 1, $_SESSION['login_info']['idUser']);
                $data = array(
                    "title" => "Ocurrio un error inesperado",
                    "message" => "La imagen es muy grande, el tamaño permitido es de 2MB",
                    "type" => "error",
                    "status" => false
                );
                toJson($data);
            }

            //eliminar la imagen anterior
            $ruta = getRoute() . "People";
            if (delFolder($ruta, $strImgActual)) {
                registerLog("Atención", "No se pudo eliminar la imagen anterior de perfil, al momento de eliminar la persona", 1, $_SESSION['login_info']['idUser']);
                $data = array(
                    "title" => "Ocurrio un error inesperado",
                    "message" => "No se logro eliminar la imagen de perfil",
                    "type" => "error",
                    "status" => false
                );
                toJson($data);
            }
            //Eliminamos la imagen de la base datos
            $request = $this->model->deleteFilePeople($strId, 'tb_people');
            // Validamos si se eliminó correctamente
            if (!$request) {
                registerLog("Ocurrio un error inesperado", "No se logro eliminar la imagen de perfil, al momento de eliminar la persona", 1, $_SESSION['login_info']['idUser']);
                $data = array(
                    "title" => "Ocurrio un error inesperado",
                    "message" => "No se logro eliminar la imagen de perfil",
                    "type" => "error",
                    "status" => false
                );
                toJson($data);
            }
            //Obtener los datos de la imagen
            $fileName = $_FILES['flPhoto_update']['name'];
            $fileSize = $_FILES['flPhoto_update']['size'];
            $fileType = $_FILES['flPhoto_update']['type'];
            $fileNameCmps = explode(".", $fileName);
            $fileExtension = strtolower(end($fileNameCmps));

            //Validacion de que la ruta de la imagen exista y si que se cree
            $ruta = getRoute() . "People/";
            if (verifyFolder($ruta, 0777, true)) {
                registerLog("Informacion de subida de archivos", "El usuario subio una foto de perfil, donde se valido que exista la ruta solicitada para subir el archivo", 3, $_SESSION['login_info']['idUser']);
            }
            //preparamos la ruta final para subir al servidor
            $nameFinalPhoto = 'img_' . date('Ymd_His') . '.' . $fileExtension;
            $rutaFinal = $ruta . $nameFinalPhoto;
            //Subimos la imagen al servidor
            $request_moveFile = move_uploaded_file($_FILES["flPhoto_update"]["tmp_name"], $rutaFinal);
            if (!$request_moveFile) {
                registerLog("Registro exitoso", "No se logro subir la imagen al momento de registrar la persona", 2, $_SESSION['login_info']['idUser']);
                $data = array(
                    "title" => "Ocurrio un error inesperado",
                    "message" => "No se logro subir la imagen",
                    "type" => "success",
                    "status" => true
                );
                toJson($data);
            }
            $validFile = true;
            $strFile = $nameFinalPhoto; //se asigna el nombre de la imagen a la variable
        }
        // Cargamos la imagen al perfil
        if ($validFile) {
            $request = $this->model->setImagePeople($strId, 'tb_people', $strFile, $fileType, $fileSize);
            // Validamos si se insertó correctamente
            if (!$request) {
                registerLog("Ocurrio un error inesperado", "La imagen de perfil no se ha registrado correctamente", 1, $_SESSION['login_info']['idRole']);
                $data = array(
                    "title" => "Ocurrio un error inesperado",
                    "message" => "La imagen de perfil no se ha registrado correctamente",
                    "type" => "error",
                    "status" => false
                );

                toJson($data);
            }
        }
        // Actualizamos los datos en la base de datos
        $request = $this->model->updatePeople($strId, $strName, $strLastname, $strCompanyName, $strNumberDocument, $_POST['checkCompanyNameUpdate'], $strBirthdate, $strGender, $strEmail, $strPhone, $strAddress, $strComment, $strStatus);
        // Validamos si se actualizó correctamente
        if ($request) {
            registerLog("Registro exitoso", "La persona se actualizó correctamente", 2, $_SESSION['login_info']['idUser']);
            $data = array(
                "title" => "Actualización correcta",
                "message" => "Registro actualizado correctamente",
                "type" => "success",
                "status" => true
            );
        } else {
            registerLog("Ocurrio un error inesperado", "La persona no se ha actualizado correctamente", 1, $_SESSION['login_info']['idRole']);
            $data = array(
                "title" => "Ocurrio un error inesperado",
                "message" => "Datos de la persona no se ha actualizado correctamente",
                "type" => "error",
                "status" => false
            );
        }
        toJson($data);
    }

    public function deletePeople()
    {
        permissionInterface(11);
        // Validamos si el método es DELETE
        if ($_SERVER['REQUEST_METHOD'] !== 'DELETE') {
            registerLog("Ocurrió un error inesperado", "Método POST no encontrado al registrar la Presentación", 1, $_SESSION['login_info']['idRole']);
            $data = array(
                "title" => "Ocurrió un error inesperado",
                "message" => "Método POST no encontrado",
                "type" => "error",
                "status" => false
            );
            toJson($data);
        }

        if (!isset($_REQUEST['idPeople']) || !isset($_REQUEST["numberdocument"]) ||  !isset($_REQUEST["fullname"]) || !isset($_REQUEST["img"])) {
            $data = array(
                "title" => "Ocurrió un error inesperado",
                "message" => "Todos los campos son obligatorios",
                "type" => "error",
                "status" => false
            );
            toJson($data);
        }
        isCsrf($_REQUEST['token']); //validacion de ataque CSRF
        $strId = strClean($_REQUEST['idPeople']);
        $strFullname = strClean($_REQUEST['fullname']);
        $strNumberDocument = strClean($_REQUEST['numberdocument']);
        $strImg = strClean($_REQUEST["img"]);
        // Convertimos a entero el id
        $strId = (int) $strId;
        // validación si existe el id en la base de datos
        $arrData = $this->model->getPeople($strId);
        if (empty($arrData)) {
            $data = array(
                "title" => "Ocurrió un error inesperado",
                "message" => "La persona no existe",
                "type" => "error",
                "status" => false
            );
            toJson($data);
        }
        // Validamos que no esté asociado a un trabajador
        $arrData = $this->model->getPeopleWorker($strId);
        if (!empty($arrData)) {
            $data = array(
                "title" => "Ocurrió un error inesperado",
                "message" => "La persona no se puede eliminar porque ya está asociado a un trabajador",
                "type" => "error",
                "status" => false
            );
            toJson($data);
        }
        // Validamos que no esté asociado a un cliente
        $arrData = $this->model->getPeopleCustomer($strId);
        if (!empty($arrData)) {
            $data = array(
                "title" => "Ocurrió un error inesperado",
                "message" => "La persona no se puede eliminar porque ya está asociado a un cliente",
                "type" => "error",
                "status" => false
            );
            toJson($data);
        }
        // Validamos que no esté asociado a un proveedor
        $arrData = $this->model->getPeopleSupplier($strId);
        if (!empty($arrData)) {
            $data = array(
                "title" => "Ocurrió un error inesperado",
                "message" => "La persona no se puede eliminar porque ya está asociado a un proveedor",
                "type" => "error",
                "status" => false
            );
            toJson($data);
        }

        // valido que la imagen no sea de perfil por defecto
        if ($strImg !== "clientes.png") {
            //eliminar la imagen anterior
            $ruta = getRoute() . "People";
            if (delFolder($ruta, $strImg)) {
                registerLog("Atención", "No se pudo eliminar la imagen anterior del perfil, al momento de eliminar un perfil", 1, $_SESSION['login_info']['idUser']);
                $data = array(
                    "title" => "Ocurrio un error inesperado",
                    "message" => "No se logró eliminar la imagen de perfil",
                    "type" => "error",
                    "status" => false
                );
                toJson($data);
            }
            //Eliminamos la imagen de la base datos
            $request = $this->model->deleteFilePeople($strId, 'tb_people');
            // Validamos si se eliminó correctamente
            if (!$request) {
                registerLog("Ocurrio un error inesperado", "No se logro eliminar la imagen del perfil, al momento de eliminar un perfil", 1, $_SESSION['login_info']['idUser']);
                $data = array(
                    "title" => "Ocurrio un error inesperado",
                    "message" => "No se logró eliminar la imagen de perfil",
                    "type" => "error",
                    "status" => false
                );
                toJson($data);
            }
        }
        // Eliminamos el registro en la base de datos
        $request = $this->model->deletePeople($strId);
        // Validamos si se eliminó correctamente
        if ($request) {
            registerLog("Eliminacion correcta", "La persona se eliminó correctamente", 2, $_SESSION['login_info']['idUser']);
            $data = array(
                "title" => "Eliminación correcta",
                "message" => "Persona: {$strFullname}, con N° Doc: {$strNumberDocument} eliminado correctamente",
                "type" => "success",
                "status" => true
            );
            toJson($data);
        } else {
            registerLog("Ocurrio un error inesperado", "La persona no se ha eliminado correctamente", 1, $_SESSION['login_info']['idRole']);
            $data = array(
                "title" => "Ocurrió un error inesperado",
                "message" => "La persona no se ha eliminado correctamente",
                "type" => "error",
                "status" => false
            );
            toJson($data);
        }
    }
}
