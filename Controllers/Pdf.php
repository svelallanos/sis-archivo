<?php

class Pdf extends Controllers
{
  private $model;

  public function __construct()
  {
    parent::__construct();
  }

  /**
   * Metodo que genera la boleta en formato PDF
   * @param mixed $data
   * @return void
   */
  public function pdf($data)
  {
    //capturamos los datos de $data y desecriptamos
    $id = decryption($data);
    //validamos que no este vacio
    if (empty($id)) {
      registerLog("Ocurrió un error inesperado", "No se puede generar la boleta por motivo que se manipulo el id o se esta enviando vacio", 1);
      $data = array(
        "title" => "Ocurrió un error inesperado",
        "message" => "No se logro completar la generacion de la boleta, intentelo mas tarde",
        "type" => "error",
        "status" => false
      );
      dep($data);
      die();
    }
    //validamos que el id sea un numero
    if (!is_numeric($id)) {
      registerLog("Ocurrió un error inesperado", "No se puede generar la boleta por motivo que se manipulo el id y no es un numero", 1);
      $data = array(
        "title" => "Ocurrió un error inesperado",
        "message" => "No se logro completar la generacion de la boleta, intentelo mas tarde",
        "type" => "error",
        "status" => false
      );
      dep($data);
    }
    //obtenemos los servicios pagados completos en el modelo payment
    require_once "./Models/PaymentModel.php";
    $objPayment = new PaymentModel();
    $requestPay = $objPayment->select_detail_document_and_services_for_document($id);
    $requestInfo = $objPayment->select_infor_partnert_by_document($id);
    ///validamos que no este vacio el $requestInfo
    if (empty($requestInfo)) {
      registerLog("Ocurrió un error inesperado", "No se puede generar la boleta por motivo que no se encontraron los datos del cliente", 1);
      $data = array(
        "title" => "Ocurrió un error inesperado",
        "message" => "No se logro completar la generacion de la boleta, intentelo mas tarde",
        "type" => "error",
        "status" => false
      );
      dep($data);
      die();
    }
    //validamos que no este vacio el $requestPay
    if (empty($requestPay)) {
      registerLog("Ocurrió un error inesperado", "No se puede generar la boleta por motivo que no existen servicios pagados", 1);
      $data = array(
        "title" => "Ocurrió un error inesperado",
        "message" => "No se logro completar la generacion de la boleta, intentelo mas tarde",
        "type" => "error",
        "status" => false
      );
      dep($data);
      die();
    }
    /* dep($requestPay);
     die();*/
    //si no lo recorremos y llenamos en el array productos
    $productos = [];
    foreach ($requestPay as $key => $value) {
      $productos[$key] = [
        'descripcion' => $value['name_service'],
        'cantidad' => $value['quantity'],
        'precio' => $value['unitPrice'],
      ];
    }


    require_once "./Libraries/fpdf186/boleta.php";
    // Datos de ejemplo (pueden venir de una base de datos o formulario)
    $url_logo = (getSystemInfo()) ? getSystemInfo()["c_logo"] : null;
    $datos_boleta = [
      'empresa' => getConfigurationSytem()['di_title'],
      'ruc' => getConfigurationSytem()['di_ruc'],
      'direccion' => getConfigurationSytem()['di_address'],
      'telefono' => getConfigurationSytem()['di_phone'],
      'email' => getConfigurationSytem()['di_email'],
      'serie' => $requestInfo['dt_year'],
      'anio' => $requestInfo['dt_year'],
      'numero' => $requestInfo['dt_number'],
      'fecha' => $requestInfo['dt_issueDate'],
      'verificacion' => base_url() . '/pdf/pdf/' . encryption($id),
      'logo' => getRoute() . '/Profile/Logo/' . $url_logo, // Ruta de la imagen del logo
      'currency' => getCurrency(),
      'typeDocument' => 'NOTA DE VENTA',
      'total' => $requestInfo['total']
    ];

    $cliente = [
      'nombre' => $requestInfo['fullname'],
      'dni' => $requestInfo['document'],
      'direccion' => $requestInfo['p_address'],
    ];


    $pdf = new boleta();
    $pdf->datos_boleta = $datos_boleta;
    $pdf->cliente = $cliente;
    $pdf->productos = $productos;
    $pdf->SetTitle($datos_boleta['typeDocument'] . " - " . $datos_boleta['serie'] . "-" . $datos_boleta['numero'] . " " . $cliente['nombre']);
    $pdf->AddPage();
    $pdf->DatosCliente();
    $pdf->DetalleProductos();
    $pdf->Output("I", ($datos_boleta['typeDocument'] . " - " . $datos_boleta['serie'] . "-" . $datos_boleta['numero'] . " " . $cliente['nombre']) . ".pdf");
  }

  public function sale($data)
  {
    isSession();
    permissionInterface(21);
    //capturamos los datos de $data y desecriptamos
    $id = decryption($data);
    //validamos que no este vacio
    if (empty($id)) {
      registerLog("Ocurrió un error inesperado", "No se puede generar la boleta por motivo que se manipulo el id o se esta enviando vacio", 1);
      $data = array(
        "title" => "Ocurrió un error inesperado",
        "message" => "No se logro completar la generacion de la boleta, intentelo mas tarde",
        "type" => "error",
        "status" => false
      );
      dep($data);
      die();
    }
    //validamos que el ID sea un número
    if (!is_numeric($id)) {
      registerLog("Ocurrió un error inesperado", "No se puede generar la boleta por motivo que se manipulo el id y no es un numero", 1);
      $data = array(
        "title" => "Ocurrió un error inesperado",
        "message" => "No se logro completar la generacion de la boleta, intentelo mas tarde",
        "type" => "error",
        "status" => false
      );
      dep($data);
    }
    //obtenemos los servicios pagados completos en el modelo payment
    require_once "./Models/SalesModel.php";
    $objSale = new SalesModel();
    $requestSale = $objSale->getSale($id);
    $requestInfo = $objSale->getCustomer_By_Inner_PeopleId($requestSale['customer_id']);
    $requestPay = $objSale->getAllDetailSaleById($requestSale['id']);
    $requestAdvance = $objSale->getAllSaleAdvancesById($requestSale['id']);
    ///validamos que no este vacio el $requestInfo
    if (empty($requestInfo)) {
      registerLog("Ocurrió un error inesperado", "No se puede generar el comprobante por motivo que no se encontraron los datos del cliente", 1);
      $data = array(
        "title" => "Ocurrió un error inesperado",
        "message" => "No se logro completar la generación del comprobante, inténtelo mas tarde",
        "type" => "error",
        "status" => false
      );
      dep($data);
      die();
    }
    //validamos que no este vacío el $requestSale
    if (empty($requestSale)) {
      registerLog("Ocurrió un error inesperado", "No se puede generar el comprobante por motivo que no existen ventas pagadas", 1);
      $data = array(
        "title" => "Ocurrió un error inesperado",
        "message" => "No se logro completar la generación del comprobante, inténtelo mas tarde",
        "type" => "error",
        "status" => false
      );
      dep($data);
      die();
    }
    //validamos que no este vacío el $requestPay
    if (empty($requestPay)) {
      registerLog("Ocurrió un error inesperado", "No se puede generar el comprobante por motivo que no existen pagos registrados", 1);
      $data = array(
        "title" => "Ocurrió un error inesperado",
        "message" => "No se logro completar la generación del comprobante, inténtelo mas tarde",
        "type" => "error",
        "status" => false
      );
      dep($data);
      die();
    }
    //si no lo recorremos y llenamos en el array productos
    $productos = [];
    $totalSale = 0;
    foreach ($requestPay as $key => $value) {
      if ($value['unit_of_measure'] === 'KG') {
        $presentation = $value['unit_of_measure'];
      } else {
        $presentation = $value['unit_of_measure'] . ' ' . $value['sack_weight_kg'] . ' KG';
      }
      $productos[$key] = [
        'descripcion' => $value['product_name'],
        'presentacion' => $presentation,
        'cantidad' => $value['quantity'],
        'precio' => $value['unit_price'],
      ];
      $totalSale += $value['subtotal'];
    }

    $advances = [];
    $totalAdvance = 0;
    if (!empty($requestAdvance)) {
      foreach ($requestAdvance as $key => $value) {
        if ($value['unit_of_measure'] === 'KG') {
          $presentation = $value['unit_of_measure'];
        } else {
          $presentation = $value['unit_of_measure'] . ' ' . $value['sack_weight_kg'] . ' KG';
        }
        $advances[$key] = [
          'fecha' => $value['dateStart'],
          'descripcion' => $value['product_name'] . ' ('.$presentation.')',
          'cantidad' => $value['quantity'],
          'monto' => $value['amount'],
        ];
        $totalAdvance += $value['amount'];
      }
    }

    require_once "./Libraries/fpdf186/sale.php";
    // Datos de ejemplo (pueden venir de una base de datos o formulario)
    $url_logo = (getSystemInfo()) ? getSystemInfo()["c_logo"] : null;
    $datos_comprobante = [
      'empresa' => getConfigurationSytem()['title'],
      'ruc' => getConfigurationSytem()['ruc'],
      'direccion' => getConfigurationSytem()['address'],
      'telefono' => getConfigurationSytem()['phone'],
      'email' => getConfigurationSytem()['mail'],
      'serie' => $requestSale['serie'],
      'anio' => $requestSale['year'],
      'numero' => $requestSale['number'],
      'fecha' => $requestSale['issue_date'],
      'verificacion' => base_url() . '/pdf/sale/' . encryption($id),
      'logo' => getRoute() . '/Profile/Logo/' . $url_logo, // Ruta de la imagen del logo
      'currency' => getCurrency(),
      'typeDocument' => $requestSale['document_type'] . ' DE VENTA',
      'total' => $requestSale['total']
    ];

    if ($requestInfo['typePeople'] === "NATURAL") {
      $requestInfo['fullname'] = $requestInfo['name'] . ' ' . $requestInfo['lastname'];
    } else {
      $requestInfo['fullname'] = $requestInfo['fullname'];
    }

    $cliente = [
      'nombre' => $requestInfo['fullname'],
      'dni' => $requestInfo['numberDocument'],
      'direccion' => $requestInfo['address'],
    ];

    $pdf = new reporteSale();
    $pdf->datos_comprobante = $datos_comprobante;
    $pdf->cliente = $cliente;
    $pdf->productos = $productos;
    $pdf->adelantos = $advances;
    $pdf->total_sale = $totalSale;
    $pdf->total_advance = $totalAdvance;
    $pdf->SetTitle($datos_comprobante['typeDocument'] . " - " . $datos_comprobante['serie'] . "-" . $datos_comprobante['numero'] . " " . $cliente['nombre']);
    $pdf->AddPage();
    $pdf->DatosCliente();
    $pdf->DetalleProductos();
    if (!empty($requestAdvance)) {
      $pdf->Adelantos();
    }
    $pdf->Pay();
    $pdf->Output("I", ($datos_comprobante['typeDocument'] . " - " . $datos_comprobante['serie'] . "-" . $datos_comprobante['numero'] . " " . $cliente['nombre']) . ".pdf");
  }

  /**
   * Metodo que genera el pdf de la area y y el usuario
   * @param mixed $id
   * @return void
   */

  public function user($data)
  {
    isSession();
    permissionInterface(3);
    //capturamos los datos de $data y desecriptamos
    $id = decryption($data);
    //validamos que no este vacio
    if (empty($id)) {
      registerLog("Ocurrió un error inesperado", "No se puede generar la boleta por motivo que se manipulo el id o se esta enviando vacio", 1);
      $data = array(
        "title" => "Ocurrió un error inesperado",
        "message" => "No se logro completar la generacion de la boleta, intentelo mas tarde",
        "type" => "error",
        "status" => false
      );
      dep($data);
      die();
    }
    //validamos que el id sea un numero
    if (!is_numeric($id)) {
      registerLog("Ocurrió un error inesperado", "No se puede generar la boleta por motivo que se manipulo el id y no es un numero", 1);
      $data = array(
        "title" => "Ocurrió un error inesperado",
        "message" => "No se logro completar la generacion de la boleta, intentelo mas tarde",
        "type" => "error",
        "status" => false
      );
      dep($data);
    }
    //requerimos el modelo de usuario
    require_once "./Models/UsersModel.php";
    $objUser = new UsersModel();
    $request = $objUser->select_user_by_Id($id);
    //requerimos el reporte de usuario
    require_once "./Libraries/fpdf186/user.php";
    $usuario = [
      'foto' => 'foto_usuario.jpg', // Ruta de imagen de perfil
      'dni' => $request['u_dni'],
      'genero' => $request['u_gender'],
      'usuario' => decryption($request['u_user']),
      'contrasena' => decryption($request['u_password']),
      'email' => decryption($request['u_email']),
      'rol' => $request['r_name'],
      'fecha_registro' => dateFormat($request['u_registrationDate']),
      'fecha_actualizacion' => dateFormat($request['u_updateDate']),
      'nombres_completos' => strtoupper($request['u_fullname']),
    ];
    $url_logo = (getSystemInfo()) ? getSystemInfo()["c_logo"] : null;
    $headerData = [
      'nombre_comite' => getConfigurationSytem()['title'],
      'ruc' => getConfigurationSytem()['ruc'],
      'direccion' => getConfigurationSytem()['address'],
      'telefono' => getConfigurationSytem()['phone'],
      'correo' => getConfigurationSytem()['mail'],
      'logo' => getRoute() . '/Profile/Logo/' . $url_logo, // Logo institucional
    ];
    $reporte = new ReporteUsuario($usuario, $headerData);
    $reporte->SetTitle($request['u_dni'] . " - " . $request['u_fullname']);
    //cambiar nombre del pdf cuando se genere el pdf
    $reporte->SetAuthor($request['u_dni'] . " - " . $request['u_fullname']);
    $reporte->SetSubject($request['u_dni'] . " - " . $request['u_fullname']);
    $reporte->generarReporte();
    $reporte->outputPDF($request['u_dni'] . " - " . $request['u_fullname'] . ".pdf");
    unset($request);
  }

  /**
   * Metodo que genera el pdf de un rol
   * @param mixed $data
   * @return void
   */
  public function rol($data)
  {
    isSession();
    permissionInterface(4);
    //capturamos los datos de $data y desecriptamos
    $id = decryption($data);
    //validamos que no este vacio
    if (empty($id)) {
      registerLog("Ocurrió un error inesperado", "No se puede generar la boleta por motivo que se manipulo el id o se esta enviando vacio", 1);
      $data = array(
        "title" => "Ocurrió un error inesperado",
        "message" => "No se logro completar la generacion de la boleta, intentelo mas tarde",
        "type" => "error",
        "status" => false
      );
      dep($data);
      die();
    }
    //validamos que el id sea un numero
    if (!is_numeric($id)) {
      registerLog("Ocurrió un error inesperado", "No se puede generar la boleta por motivo que se manipulo el id y no es un numero", 1);
      $data = array(
        "title" => "Ocurrió un error inesperado",
        "message" => "No se logro completar la generacion de la boleta, intentelo mas tarde",
        "type" => "error",
        "status" => false
      );
      dep($data);
    }
    //requerimos el modelo de roles
    require_once "./Models/RolesModel.php";
    $objRol = new RolesModel();
    $infRol = $objRol->select_rol_by_id($id);
    $detailRol = $objRol->select_permissions_by_role($id);

    // =================== DATOS =================== //
    $url_logo = (getSystemInfo()) ? getSystemInfo()["c_logo"] : null;
    $headerData = [
      'nombre_comite' => getConfigurationSytem()['title'],
      'ruc' => getConfigurationSytem()['ruc'],
      'direccion' => getConfigurationSytem()['address'],
      'telefono' => getConfigurationSytem()['phone'],
      'correo' => getConfigurationSytem()['mail'],
      'logo' => getRoute() . '/Profile/Logo/' . $url_logo, // Logo institucional
    ];

    $rolData = [
      'nombre' => $infRol['r_name'],
      'codigo' => '#' . $infRol['idRole'],
      'descripcion' => $infRol['r_description'],
      'estado' => $infRol['r_status'],
      'fecha_registro' => dateFormat($infRol['r_registrationDate']),
      'fecha_actualizacion' => dateFormat($infRol['r_updateDate']),
    ];

    $mapBool = ['0' => 'No', '1' => 'Sí'];

    foreach ($detailRol as $modulo) {
      if (!isset($modulo['interface']) || !is_array($modulo['interface'])) {
        continue;
      }

      foreach ($modulo['interface'] as $interfaz) {
        $permisos[] = [
          'nombre' => $interfaz['i_name'],
          'ruta' => $interfaz['i_url'],
          'menu' => $mapBool[(string)$interfaz['i_isOption']],
          'publico' => $mapBool[(string)$interfaz['i_isPublic']],
          'menu_nav' => $mapBool[(string)$interfaz['i_isListNav']],
          'descripcion' => $interfaz['i_description'] ?? ''
        ];
      }
    }

    // =============== GENERACIÓN PDF =============== //
    require_once "./Libraries/fpdf186/rol.php";
    $pdf = new rol($headerData);
    $pdf->SetTitle($infRol['idRole'] . "-" . $infRol['r_name']);
    $pdf->generarReporteRol($rolData, $permisos);
    $pdf->Output('I', $infRol['idRole'] . "-" . $infRol['r_name'] . ".pdf");
    //Destruimos las variables
    unset($infRol);
    unset($detailRol);
  }

  /**
   * Metodo que genera el pdf de una categoria
   * @param mixed $data
   * @return void
   */
  public function category($data)
  {
    isSession();
    permissionInterface(8);
    //capturamos los datos de $data y desecriptamos
    $id = decryption($data);
    //validamos que no este vacio
    if (empty($id)) {
      registerLog("Ocurrió un error inesperado", "No se puede generar la boleta por motivo que se manipulo el id o se esta enviando vacio", 1);
      $data = array(
        "title" => "Ocurrió un error inesperado",
        "message" => "No se logro completar la generacion de la boleta, intentelo mas tarde",
        "type" => "error",
        "status" => false
      );
      dep($data);
      die();
    }
    //validamos que el id sea un numero
    if (!is_numeric($id)) {
      registerLog("Ocurrió un error inesperado", "No se puede generar la boleta por motivo que se manipulo el id y no es un numero", 1);
      $data = array(
        "title" => "Ocurrió un error inesperado",
        "message" => "No se logro completar la generacion de la boleta, intentelo mas tarde",
        "type" => "error",
        "status" => false
      );
      dep($data);
    }
    //requerimos el modelo de la categoria
    require_once "./Models/CategoryModel.php";
    $objCategory = new CategoryModel();
    $infCategory = $objCategory->select_category_by_id($id);
    $detailCategory = $objCategory->select_detail_category($id); // <- esta línea nueva

    // =================== DATOS =================== //
    $url_logo = (getSystemInfo()) ? getSystemInfo()["c_logo"] : null;
    $headerData = [
      'nombre_comite' => getConfigurationSytem()['title'],
      'ruc' => getConfigurationSytem()['ruc'],
      'direccion' => getConfigurationSytem()['address'],
      'telefono' => getConfigurationSytem()['phone'],
      'correo' => getConfigurationSytem()['mail'],
      'logo' => getRoute() . '/Profile/Logo/' . $url_logo, // Logo institucional
    ];

    // =============== GENERACIÓN PDF =============== //
    require_once "./Libraries/fpdf186/category.php";
    $pdf = new ReporteCategoria($detailCategory, $headerData);
    $pdf->SetTitle($infCategory['idCategory'] . "-" . $infCategory['name']);
    $pdf->generarReporte($detailCategory);
    $pdf->Output('I', $infCategory['idCategory'] . "-" . $infCategory['name'] . ".pdf");
  }

  public function producttype($data)
  {
    isSession();
    permissionInterface(9);
    //capturamos los datos de $data y desecriptamos
    $id = decryption($data);
    //validamos que no este vacio
    if (empty($id)) {
      registerLog("Ocurrió un error inesperado", "No se puede generar la boleta por motivo que se manipulo el id o se esta enviando vacio", 1);
      $data = array(
        "title" => "Ocurrió un error inesperado",
        "message" => "No se logro completar la generacion de la boleta, intentelo mas tarde",
        "type" => "error",
        "status" => false
      );
      dep($data);
      die();
    }
    //validamos que el id sea un numero
    if (!is_numeric($id)) {
      registerLog("Ocurrió un error inesperado", "No se puede generar la boleta por motivo que se manipulo el id y no es un numero", 1);
      $data = array(
        "title" => "Ocurrió un error inesperado",
        "message" => "No se logro completar la generacion de la boleta, intentelo mas tarde",
        "type" => "error",
        "status" => false
      );
      dep($data);
    }
    //requerimos el modelo del tipo de producto
    require_once "./Models/ProducttypeModel.php";
    $objProduct = new ProducttypeModel();
    $infProducttype = $objProduct->select_producttype_by_Id($id);
    $detailProducttype = $objProduct->select_detail_producttype($id); // <- esta línea nueva

    // =================== DATOS =================== //
    $url_logo = (getSystemInfo()) ? getSystemInfo()["c_logo"] : null;
    $headerData = [
      'nombre_comite' => getConfigurationSytem()['title'],
      'ruc' => getConfigurationSytem()['ruc'],
      'direccion' => getConfigurationSytem()['address'],
      'telefono' => getConfigurationSytem()['phone'],
      'correo' => getConfigurationSytem()['mail'],
      'logo' => getRoute() . '/Profile/Logo/' . $url_logo, // Logo institucional
    ];

    // =============== GENERACIÓN PDF =============== //
    require_once "./Libraries/fpdf186/Producttype.php";
    $pdf = new ReporteProducttype($detailProducttype, $headerData);
    $pdf->SetTitle($infProducttype['id'] . "-" . $infProducttype['name']);
    $pdf->generarReporte($detailProducttype);
    $pdf->Output('I', $infProducttype['id'] . "-" . $infProducttype['name'] . ".pdf");
  }

  /**
   * Metodo que genera el pdf de una trabajador
   * @param mixed $data
   * @return void
   */
  public function jobtitle($data)
  {
    isSession();
    permissionInterface(10);
    //capturamos los datos de $data y desecriptamos
    $id = decryption($data);
    //validamos que no este vacio
    if (empty($id)) {
      registerLog("Ocurrió un error inesperado", "No se puede generar la boleta por motivo que se manipulo el id o se esta enviando vacio", 1);
      $data = array(
        "title" => "Ocurrió un error inesperado",
        "message" => "No se logro completar la generacion de la boleta, intentelo mas tarde",
        "type" => "error",
        "status" => false
      );
      dep($data);
      die();
    }
    //validamos que el id sea un numero
    if (!is_numeric($id)) {
      registerLog("Ocurrió un error inesperado", "No se puede generar la boleta por motivo que se manipulo el id y no es un numero", 1);
      $data = array(
        "title" => "Ocurrió un error inesperado",
        "message" => "No se logro completar la generacion de la boleta, intentelo mas tarde",
        "type" => "error",
        "status" => false
      );
      dep($data);
    }
    //requerimos el modelo de la categoria
    require_once "./Models/JobtitleModel.php";
    $objJobtitle = new JobtitleModel();
    $infJobtitle = $objJobtitle->select_jobtitle_by_id($id);
    $detailJobtitle = $objJobtitle->select_detail_jobtitle($id); // <- esta línea nueva

    // =================== DATOS =================== //
    $url_logo = (getSystemInfo()) ? getSystemInfo()["c_logo"] : null;
    $headerData = [
      'nombre_comite' => getConfigurationSytem()['title'],
      'ruc' => getConfigurationSytem()['ruc'],
      'direccion' => getConfigurationSytem()['address'],
      'telefono' => getConfigurationSytem()['phone'],
      'correo' => getConfigurationSytem()['mail'],
      'logo' => getRoute() . '/Profile/Logo/' . $url_logo, // Logo institucional
    ];

    // =============== GENERACIÓN PDF =============== //
    require_once "./Libraries/fpdf186/jobtitle.php";
    $pdf = new ReporteJobtitle($detailJobtitle, $headerData);
    $pdf->SetTitle($infJobtitle['id'] . "-" . $infJobtitle['name']);
    $pdf->generarReporte($detailJobtitle);
    $pdf->Output('I', $infJobtitle['id'] . "-" . $infJobtitle['name'] . ".pdf");
  }


  /**
   * Metodo que genera el pdf de una ubicacion
   * @param mixed $data
   * @return void
   */
  public function ubication($data)
  {
    isSession();
    permissionInterface(12);
    //capturamos los datos de $data y desecriptamos
    $id = decryption($data);
    //validamos que no este vacio
    if (empty($id)) {
      registerLog("Ocurrió un error inesperado", "No se puede generar la boleta por motivo que se manipulo el id o se esta enviando vacio", 1);
      $data = array(
        "title" => "Ocurrió un error inesperado",
        "message" => "No se logro completar la generacion de la boleta, intentelo mas tarde",
        "type" => "error",
        "status" => false
      );
      dep($data);
      die();
    }
    //validamos que el id sea un numero
    if (!is_numeric($id)) {
      registerLog("Ocurrió un error inesperado", "No se puede generar la boleta por motivo que se manipulo el id y no es un numero", 1);
      $data = array(
        "title" => "Ocurrió un error inesperado",
        "message" => "No se logro completar la generacion de la boleta, intentelo mas tarde",
        "type" => "error",
        "status" => false
      );
      dep($data);
    }
    //requerimos el modelo de la categoria
    require_once "./Models/UbicationModel.php";
    $objUbication = new UbicationModel();
    $infJUbication = $objUbication->select_ubication_by_id($id);
    $detailUbication = $objUbication->select_detail_ubication($id); // <- esta línea nueva

    // =================== DATOS =================== //
    $url_logo = (getSystemInfo()) ? getSystemInfo()["c_logo"] : null;
    $headerData = [
      'nombre_comite' => getConfigurationSytem()['title'],
      'ruc' => getConfigurationSytem()['ruc'],
      'direccion' => getConfigurationSytem()['address'],
      'telefono' => getConfigurationSytem()['phone'],
      'correo' => getConfigurationSytem()['mail'],
      'logo' => getRoute() . '/Profile/Logo/' . $url_logo, // Logo institucional
    ];

    // =============== GENERACIÓN PDF =============== //
    require_once "./Libraries/fpdf186/ubication.php";
    $pdf = new ReporteUbication($detailUbication, $headerData);
    $pdf->SetTitle($infJUbication['id'] . "-" . $infJUbication['name']);
    $pdf->generarReporte($detailUbication);
    $pdf->Output('I', $infJUbication['id'] . "-" . $infJUbication['name'] . ".pdf");
  }

  /**
   * Metodo que genera el pdf de una ubicacion
   * @param mixed $data
   * @return void
   */
  public function product($data)
  {
    isSession();
    permissionInterface(12);
    //capturamos los datos de $data y desecriptamos
    $id = decryption($data);
    //validamos que no este vacio
    if (empty($id)) {
      registerLog("Ocurrió un error inesperado", "No se puede generar la boleta por motivo que se manipulo el id o se esta enviando vacio", 1);
      $data = array(
        "title" => "Ocurrió un error inesperado",
        "message" => "No se logro completar la generacion de la boleta, intentelo mas tarde",
        "type" => "error",
        "status" => false
      );
      dep($data);
      die();
    }
    //validamos que el id sea un numero
    if (!is_numeric($id)) {
      registerLog("Ocurrió un error inesperado", "No se puede generar la boleta por motivo que se manipulo el id y no es un numero", 1);
      $data = array(
        "title" => "Ocurrió un error inesperado",
        "message" => "No se logro completar la generacion de la boleta, intentelo mas tarde",
        "type" => "error",
        "status" => false
      );
      dep($data);
    }
    //requerimos el modelo de la categoria
    require_once "./Models/ProductModel.php";
    $objProduct = new ProductModel();
    $infJProduct = $objProduct->select_product_by_id($id);
    $detailProduct = $objProduct->select_detail_product($id); // <- esta línea nueva

    // =================== DATOS =================== //
    $url_logo = (getSystemInfo()) ? getSystemInfo()["c_logo"] : null;
    $headerData = [
      'nombre_comite' => getConfigurationSytem()['title'],
      'ruc' => getConfigurationSytem()['ruc'],
      'direccion' => getConfigurationSytem()['address'],
      'telefono' => getConfigurationSytem()['phone'],
      'correo' => getConfigurationSytem()['mail'],
      'logo' => getRoute() . '/Profile/Logo/' . $url_logo, // Logo institucional
    ];

    // =============== GENERACIÓN PDF =============== //
    require_once "./Libraries/fpdf186/product.php";
    $pdf = new ReporteProduct($detailProduct, $headerData);
    $pdf->SetTitle($infJProduct['id'] . "-" . $infJProduct['name']);
    $pdf->generarReporte($detailProduct);
    $pdf->Output('I', $infJProduct['id'] . "-" . $infJProduct['name'] . ".pdf");
  }

  /**
   * Metodo que genera el pdf de los prestamos
   * @param mixed $data
   * @return void
   */
  public function loan($data)
  {
    isSession();
    permissionInterface(14);
    //capturamos los datos de $data y desencriptamos
    $id = decryption($data);
    //validamos que no este vacio
    if (empty($id)) {
      registerLog("Ocurrió un error inesperado", "No se puede generar la boleta por motivo que se manipulo el id o se esta enviando vacio", 1);
      $data = array(
        "title" => "Ocurrió un error inesperado",
        "message" => "No se logro completar la generacion de la boleta, intentelo mas tarde",
        "type" => "error",
        "status" => false
      );
      dep($data);
      die();
    }
    //validamos que el id sea un numero
    if (!is_numeric($id)) {
      registerLog("Ocurrió un error inesperado", "No se puede generar la boleta por motivo que se manipulo el id y no es un numero", 1);
      $data = array(
        "title" => "Ocurrió un error inesperado",
        "message" => "No se logro completar la generacion de la boleta, intentelo mas tarde",
        "type" => "error",
        "status" => false
      );
      dep($data);
    }
    //requerimos el modelo de la categoria
    require_once "./Models/LoanModel.php";
    $objLoan = new LoanModel();
    $detailLoan = $objLoan->select_detail_loan($id); // <- esta línea nueva

    $detailLoan["amount"] = getCurrency() . " " . $detailLoan["amount"]; // <- esta línea nueva
    //adicionamos el % al monto de interes
    $detailLoan["interest"] = $detailLoan["interest"] . " %";
    //mejoramos la fecha de inicio y fin
    $detailLoan["dateRegistration"] = dateFormat($detailLoan["dateRegistration"]);
    $detailLoan["dateUpdate"] = dateFormat($detailLoan["dateUpdate"]);

    //validamos que no este vacio el $detailLoan
    if (empty($detailLoan)) {
      registerLog("Ocurrió un error inesperado", "No se puede generar el documento por motivo que no se encontraron los datos del préstamo", 1);
      $data = array(
        "title" => "Ocurrió un error inesperado",
        "message" => "No se logro completar la generacion del documento, intentelo mas tarde",
        "type" => "error",
        "status" => false
      );
      dep($data);
    }
    // =================== DATOS =================== //
    $url_logo = getSystemInfo() ? getSystemInfo()["c_logo"] : '';
    $headerData = [
      'nombre_comite' => getConfigurationSytem()['title'],
      'ruc' => getConfigurationSytem()['ruc'],
      'direccion' => getConfigurationSytem()['address'],
      'telefono' => getConfigurationSytem()['phone'],
      'correo' => getConfigurationSytem()['mail'],
      'logo' => getRoute() . '/Profile/Logo/' . $url_logo, // Logo institucional
    ];

    // =============== GENERACIÓN PDF =============== //
    require_once "./Libraries/fpdf186/loan.php";

    $pdf = new ReporteLoan($detailLoan, $headerData);
    $pdf->generarReporte($detailLoan);
    $pdf->SetTitle($detailLoan['customer_id'] . " - " . $detailLoan['fullname']);
    //cambiar nombre del pdf cuando se genere el pdf
    $pdf->SetAuthor($detailLoan['customer_id'] . " - " . $detailLoan['fullname']);
    $pdf->SetSubject($detailLoan['customer_id'] . " - " . $detailLoan['fullname']);
    $pdf->Output('I', $id . '.pdf'); // Usa la variable original si $id es el ID de préstamo
    unset($detailLoan);
    unset($objLoan);
  }

  /**
   * Metodo que genera el pdf de una ubicacion
   * @param mixed $data
   * @return void
   */
  public function worker($data)
  {
    isSession();
    permissionInterface(16);
    //capturamos los datos de $data y desecriptamos
    $id = decryption($data);
    //validamos que no este vacio
    if (empty($id)) {
      registerLog("Ocurrió un error inesperado", "No se puede generar la boleta por motivo que se manipulo el id o se esta enviando vacio", 1);
      $data = array(
        "title" => "Ocurrió un error inesperado",
        "message" => "No se logro completar la generacion de la boleta, intentelo mas tarde",
        "type" => "error",
        "status" => false
      );
      dep($data);
      die();
    }
    //validamos que el id sea un numero
    if (!is_numeric($id)) {
      registerLog("Ocurrió un error inesperado", "No se puede generar la boleta por motivo que se manipulo el id y no es un numero", 1);
      $data = array(
        "title" => "Ocurrió un error inesperado",
        "message" => "No se logro completar la generacion de la boleta, intentelo mas tarde",
        "type" => "error",
        "status" => false
      );
      dep($data);
    }
    //requerimos el modelo de Workerdame
    require_once "./Models/WorkerModel.php";
    $objWorker = new WorkerModel();
    $infJWorker = $objWorker->select_worker_by_id($id);
    $detailWorker = $objWorker->select_detail_worker($id);


    // =================== DATOS =================== //
    $url_logo = (getSystemInfo()) ? getSystemInfo()["c_logo"] : null;
    $headerData = [
      'nombre_comite' => getConfigurationSytem()['title'],
      'ruc' => getConfigurationSytem()['ruc'],
      'direccion' => getConfigurationSytem()['address'],
      'telefono' => getConfigurationSytem()['phone'],
      'correo' => getConfigurationSytem()['mail'],
      'logo' => getRoute() . '/Profile/Logo/' . $url_logo, // Logo institucional
    ];

    // =============== GENERACIÓN PDF =============== //
    require_once "./Libraries/fpdf186/worker.php";
    $pdf = new ReporteWorker($detailWorker, $headerData);
    $pdf->SetTitle($infJWorker['id'] . "-" . $infJWorker['people_id']);
    $pdf->generarReporte($detailWorker);
    $pdf->Output('I', $infJWorker['id'] . "-" . $infJWorker['people_id'] . ".pdf");
  }

  /**
   * Metodo que genera el pdf de las personas
   * @param mixed $data
   * @return void
   */
  public function people($data)
  {
    isSession();
    permissionInterface(11);
    //capturamos los datos de $data y desecriptamos
    $id = decryption($data);
    //validamos que no este vacio
    if (empty($id)) {
      registerLog("Ocurrió un error inesperado", "No se puede generar la boleta por motivo que se manipulo el id o se esta enviando vacio", 1);
      $data = array(
        "title" => "Ocurrió un error inesperado",
        "message" => "No se logro completar la generacion de la boleta, intentelo mas tarde",
        "type" => "error",
        "status" => false
      );
      dep($data);
      die();
    }
    //validamos que el id sea un numero
    if (!is_numeric($id)) {
      registerLog("Ocurrió un error inesperado", "No se puede generar la boleta por motivo que se manipulo el id y no es un numero", 1);
      $data = array(
        "title" => "Ocurrió un error inesperado",
        "message" => "No se logro completar la generacion de la boleta, intentelo mas tarde",
        "type" => "error",
        "status" => false
      );
      dep($data);
    }
    //requerimos el modelo de la categoria
    require_once "./Models/PeopleModel.php";
    $objPeople = new PeopleModel();
    $infJPeople = $objPeople->select_people_by_id($id);
    $detailPeople = $objPeople->select_detail_people($id); // <- esta línea nueva

    // =================== DATOS =================== //
    $url_logo = (getSystemInfo()) ? getSystemInfo()["c_logo"] : null;
    $headerData = [
      'nombre_comite' => getConfigurationSytem()['title'],
      'ruc' => getConfigurationSytem()['ruc'],
      'direccion' => getConfigurationSytem()['address'],
      'telefono' => getConfigurationSytem()['phone'],
      'correo' => getConfigurationSytem()['mail'],
      'logo' => getRoute() . '/Profile/Logo/' . $url_logo, // Logo institucional
    ];

    // =============== GENERACIÓN PDF =============== //
    require_once "./Libraries/fpdf186/people.php";
    $pdf = new ReportePeople($detailPeople, $headerData);
    $pdf->SetTitle($infJPeople['id'] . "-" . $infJPeople['name']);
    $pdf->generarReporte($detailPeople);
    $pdf->Output('I', $infJPeople['id'] . "-" . $infJPeople['name'] . ".pdf");
  }

  /**
   * Metodo que genera el pdf de las personas
   * @param mixed $data
   * @return void
   */
  public function supplier($data)
  {
    isSession();
    permissionInterface(17);
    //capturamos los datos de $data y desecriptamos
    $id = decryption($data);
    //validamos que no este vacio
    if (empty($id)) {
      registerLog("Ocurrió un error inesperado", "No se puede generar la boleta por motivo que se manipulo el id o se esta enviando vacio", 1);
      $data = array(
        "title" => "Ocurrió un error inesperado",
        "message" => "No se logro completar la generacion de la boleta, intentelo mas tarde",
        "type" => "error",
        "status" => false
      );
      dep($data);
      die();
    }
    //validamos que el id sea un numero
    if (!is_numeric($id)) {
      registerLog("Ocurrió un error inesperado", "No se puede generar la boleta por motivo que se manipulo el id y no es un numero", 1);
      $data = array(
        "title" => "Ocurrió un error inesperado",
        "message" => "No se logro completar la generacion de la boleta, intentelo mas tarde",
        "type" => "error",
        "status" => false
      );
      dep($data);
    }
    //requerimos el modelo de los proveedores
    require_once "./Models/SupplierModel.php";
    $objSupplier = new SupplierModel();
    $infJSupplier = $objSupplier->select_supplier_by_id($id);
    $detailSupplier = $objSupplier->select_detail_supplier($id); // <- esta línea nueva

    // =================== DATOS =================== //
    $url_logo = (getSystemInfo()) ? getSystemInfo()["c_logo"] : null;
    $headerData = [
      'nombre_comite' => getConfigurationSytem()['title'],
      'ruc' => getConfigurationSytem()['ruc'],
      'direccion' => getConfigurationSytem()['address'],
      'telefono' => getConfigurationSytem()['phone'],
      'correo' => getConfigurationSytem()['mail'],
      'logo' => getRoute() . '/Profile/Logo/' . $url_logo, // Logo institucional
    ];

    // =============== GENERACIÓN PDF =============== //
    require_once "./Libraries/fpdf186/supplier.php";
    $pdf = new ReporteSupplier($detailSupplier, $headerData);
    $pdf->SetTitle($infJSupplier['id'] . "-" . ($infJSupplier['name'] ?? ''));
    $pdf->generarReporte($detailSupplier);
    $fullname = $infJSupplier['name'] ?? '';
    $pdf->Output('I', $infJSupplier['id'] . "-" . $fullname . ".pdf");
  }

  /**
   * Metodo que genera el pdf de las personas
   * @param mixed $data
   * @return void
   */
  public function customer($data)
  {
    isSession();
    permissionInterface(19);
    //capturamos los datos de $data y desecriptamos
    $id = decryption($data);
    //validamos que no este vacio
    if (empty($id)) {
      registerLog("Ocurrió un error inesperado", "No se puede generar la boleta por motivo que se manipulo el id o se esta enviando vacio", 1);
      $data = array(
        "title" => "Ocurrió un error inesperado",
        "message" => "No se logro completar la generacion de la boleta, intentelo mas tarde",
        "type" => "error",
        "status" => false
      );
      dep($data);
      die();
    }
    //validamos que el id sea un numero
    if (!is_numeric($id)) {
      registerLog("Ocurrió un error inesperado", "No se puede generar la boleta por motivo que se manipulo el id y no es un numero", 1);
      $data = array(
        "title" => "Ocurrió un error inesperado",
        "message" => "No se logro completar la generacion de la boleta, intentelo mas tarde",
        "type" => "error",
        "status" => false
      );
      dep($data);
    }
    //requerimos el modelo de los clientes
    require_once "./Models/CustomerModel.php";
    $objCustomer = new CustomerModel();
    $infJCustomer = $objCustomer->select_customer_by_id($id);
    $detailCustomer = $objCustomer->select_detail_customer($id); // <- esta línea nueva


    // =================== DATOS =================== //
    $url_logo = (getSystemInfo()) ? getSystemInfo()["c_logo"] : null;
    $headerData = [
      'nombre_comite' => getConfigurationSytem()['title'],
      'ruc' => getConfigurationSytem()['ruc'],
      'direccion' => getConfigurationSytem()['address'],
      'telefono' => getConfigurationSytem()['phone'],
      'correo' => getConfigurationSytem()['mail'],
      'logo' => getRoute() . '/Profile/Logo/' . $url_logo, // Logo institucional
    ];

    // =============== GENERACIÓN PDF =============== //
    require_once "./Libraries/fpdf186/customer.php";
    $pdf = new ReporteCustomer($detailCustomer, $headerData);
    $pdf->SetTitle($infJCustomer['id'] . "-" . ($infJCustomer['name'] ?? ''));
    $pdf->generarReporte($detailCustomer);
    $fullname = $infJCustomer['name'] ?? '';
    $pdf->Output('I', $infJCustomer['id'] . "-" . $fullname . ".pdf");
  }

  public function advances($data)
  {
    isSession();
    permissionInterface(24);
    //capturamos los datos de $data y desencriptamos
    $id = decryption($data);
    //validamos que no este vacio
    if (empty($id)) {
      registerLog("Ocurrió un error inesperado", "No se puede generar el documento por motivo que se manipulo el id o se esta enviando vacio", 1);
      $data = array(
        "title" => "Ocurrió un error inesperado",
        "message" => "No se logro completar la generacion de el documento, intentelo mas tarde",
        "type" => "error",
        "status" => false
      );
      dep($data);
      die();
    }
    //validamos que el id sea un numero
    if (!is_numeric($id)) {
      registerLog("Ocurrió un error inesperado", "No se puede generar el documento por motivo que se manipulo el id y no es un numero", 1);
      $data = array(
        "title" => "Ocurrió un error inesperado",
        "message" => "No se logro completar la generacion de el documento, intentelo mas tarde",
        "type" => "error",
        "status" => false
      );
      dep($data);
    }
    //requerimos el modelo de la categoria
    require_once "./Models/AdvancesModel.php";
    $objAdvances = new AdvancesModel();
    $detailAdvances = $objAdvances->select_detail_advances($id); // <- esta línea nueva

    $detailAdvances["amount"] = getCurrency() . " " . $detailAdvances["amount"]; // <- esta línea nueva
    //mejoramos la fecha de inicio y fin
    $detailAdvances["dateRegistration"] = dateFormat($detailAdvances["dateRegistration"]);
    $detailAdvances["dateUpdate"] = dateFormat($detailAdvances["dateUpdate"]);

    //validamos que no este vacio el $detailAdvances
    if (empty($detailAdvances)) {
      registerLog("Ocurrió un error inesperado", "No se puede generar el documento por motivo que no se encontraron los datos del préstamo", 1);
      $data = array(
        "title" => "Ocurrió un error inesperado",
        "message" => "No se logro completar la generacion del documento, intentelo mas tarde",
        "type" => "error",
        "status" => false
      );
      dep($data);
    }
    // =================== DATOS =================== //
    $url_logo = getSystemInfo() ? getSystemInfo()["c_logo"] : '';
    $headerData = [
      'nombre_comite' => getConfigurationSytem()['title'],
      'ruc' => getConfigurationSytem()['ruc'],
      'direccion' => getConfigurationSytem()['address'],
      'telefono' => getConfigurationSytem()['phone'],
      'correo' => getConfigurationSytem()['mail'],
      'logo' => getRoute() . '/Profile/Logo/' . $url_logo, // Logo institucional
    ];

    // =============== GENERACIÓN PDF =============== //
    require_once "./Libraries/fpdf186/advances.php";

    $pdf = new ReporteAdvances($detailAdvances, $headerData);
    $pdf->generarReporte($detailAdvances);
    $pdf->SetTitle($detailAdvances['customer_id'] . " - " . $detailAdvances['fullname']);
    //cambiar nombre del pdf cuando se genere el pdf
    $pdf->SetAuthor($detailAdvances['customer_id'] . " - " . $detailAdvances['fullname']);
    $pdf->SetSubject($detailAdvances['customer_id'] . " - " . $detailAdvances['fullname']);
    $pdf->Output('I', $id . '.pdf'); // Usa la variable original si $id es el ID de préstamo
    unset($detailAdvances);
    unset($objAdvances);
  }
}
