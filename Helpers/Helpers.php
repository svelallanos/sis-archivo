<?php
//Funcion que retorna el nombre del sistema
function getSystemName()
{
  return NOMBRE_SISTEMA;
}

//Retorla la url del proyecto
function base_url()
{
  return BASE_URL;
}

//Funcion que te permite devolver el tipo de moneda de la app
function getCurrency()
{
  return SMONEY;
}

//Funcion que devuelve la ruta de los archivos subidos al sistema
function getRoute()
{
  return RUTA_ARCHIVOS;
}

//Retorla la url de Assets
function media()
{
  return BASE_URL . "/Assets";
}

function headerAdmin($data = "")
{
  $view_header = "./Views/Template/panel/head.php";
  require_once($view_header);
}

function footerAdmin($data = "")
{
  $view_footer = "./Views/Template/panel/foot.php";
  require_once($view_footer);
}

// Funcion que carga los modales
function loadModalAdmin($modal = "", $array = [])
{
  $modal = "./Views/Template/panel/Modals/" . $modal . ".php";
  require_once($modal);
}

//Muestra información formateada
function dep($data)
{
  $format = print_r('<pre>');
  $format .= print_r($data);
  $format .= print_r('</pre>');
  return $format;
}

//Envio de correos
// function sendEmail($data, $template)
// {
//     $asunto = $data['asunto'];
//     $emailDestino = $data['email'];
//     $empresa = NOMBRE_REMITENTE;
//     $remitente = EMAIL_REMITENTE;
//     //ENVIO DE CORREO
//     $de = "MIME-Version: 1.0\r\n";
//     $de .= "Content-type: text/html; charset=UTF-8\r\n";
//     $de .= "From: {$empresa} <{$remitente}>\r\n";
//     ob_start();
//     require_once("./Views/Template/Email/" . $template . ".php");
//     $mensaje = ob_get_clean();
//     $send = mail($emailDestino, $asunto, $mensaje, $de);
//     return $send;
// }

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

function sendEmail($data, $template)
{
  require_once "./Libraries/PHPMailer/src/PHPMailer.php";
  require_once "./Libraries/PHPMailer/src/SMTP.php";
  require_once "./Libraries/PHPMailer/src/Exception.php";

  $mail = new PHPMailer(true);

  try {
    // Configuración del servidor SMTP
    $mail->isSMTP();
    $mail->Host = 'smtp.gmail.com';        // Servidor SMTP de Gmail
    $mail->SMTPAuth = true;
    $mail->Username = 'ebnersmith17@gmail.com'; // TU CORREO GMAIL
    $mail->Password = 'vhqk marl lzhx skac';    // APP PASSWORD generado en Google
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS; //STARTTLS
    $mail->Port = 587;                      //Puerto STARTTLS

    // Configuración del remitente y destinatario
    $mail->setFrom('ebnersmith17@gmail.com', NOMBRE_REMITENTE);
    $mail->addAddress($data['email']);           // Destinatario

    // Asunto y cuerpo del mensaje
    $mail->isHTML(true);
    $mail->Subject = "=?UTF-8?B?" . base64_encode($data['asunto']) . "?=";

    // Cargar contenido HTML desde plantilla
    ob_start();
    require_once "./Views/Template/Email/{$template}.php";
    $body = ob_get_clean();
    $mail->Body = $body;

    $mail->send();
    return true;
  } catch (Exception $e) {
    registerLog("Error de PHPMailer", $mail->ErrorInfo, 1);
    return false;
  }
}


//Elimina exceso de espacios entre palabras
function strClean($strCadena)
{
  $string = preg_replace(['/\s+/', '/^\s|\s$/'], [' ', ''], $strCadena);
  $string = trim($string); //Elimina espacios en blanco al inicio y al final
  $string = stripslashes($string); // Elimina las \ invertidas
  $string = str_ireplace("<script>", "", $string);
  $string = str_ireplace("</script>", "", $string);
  $string = str_ireplace("<script src>", "", $string);
  $string = str_ireplace("<script type=>", "", $string);
  $string = str_ireplace("SELECT * FROM", "", $string);
  $string = str_ireplace("DELETE FROM", "", $string);
  $string = str_ireplace("INSERT INTO", "", $string);
  $string = str_ireplace("SELECT COUNT(*) FROM", "", $string);
  $string = str_ireplace("DROP TABLE", "", $string);
  $string = str_ireplace("OR '1'='1", "", $string);
  $string = str_ireplace('OR "1"="1"', "", $string);
  $string = str_ireplace('OR ´1´=´1´', "", $string);
  $string = str_ireplace("is NULL; --", "", $string);
  $string = str_ireplace("is NULL; --", "", $string);
  $string = str_ireplace("LIKE '", "", $string);
  $string = str_ireplace('LIKE "', "", $string);
  $string = str_ireplace("LIKE ´", "", $string);
  $string = str_ireplace("OR 'a'='a", "", $string);
  $string = str_ireplace('OR "a"="a', "", $string);
  $string = str_ireplace("OR ´a´=´a", "", $string);
  $string = str_ireplace("OR ´a´=´a", "", $string);
  $string = str_ireplace("--", "", $string);
  $string = str_ireplace("^", "", $string);
  $string = str_ireplace("[", "", $string);
  $string = str_ireplace("]", "", $string);
  $string = str_ireplace("==", "", $string);
  return $string;
}

//Genera una contraseña de 10 caracteres
function passGenerator($length = 10)
{
  $pass = "";
  $longitudPass = $length;
  $cadena = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz1234567890";
  $longitudCadena = strlen($cadena);

  for ($i = 1; $i <= $longitudPass; $i++) {
    $pos = rand(0, $longitudCadena - 1);
    $pass .= substr($cadena, $pos, 1);
  }
  return $pass;
}

//Genera un token
function token()
{
  $r1 = bin2hex(random_bytes(10));
  $r2 = bin2hex(random_bytes(10));
  $r3 = bin2hex(random_bytes(10));
  $r4 = bin2hex(random_bytes(10));
  $token = $r1 . '-' . $r2 . '-' . $r3 . '-' . $r4;
  return $token;
}

//Formato para valores monetarios
function formatMoney($cantidad)
{
  $cantidad = number_format($cantidad, 2, SPD, SPM);
  return $cantidad;
}

function activeItem($idPage, $idPageValue)
{
  if ($idPage == $idPageValue) {
    return "active";
  }
}

//funcion que se encarga de convertir la informacion a tipo JSON
function toJson($data)
{
  echo json_encode($data, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
  die();
}

/**Funcion verificar datos*/
function verifyData($filtro, $cadena): bool
{
  if (preg_match("/^" . $filtro . "$/", $cadena)) {
    return false;
  } else {
    return true;
  }
}

/**Encriptar texto plano ah hash*/
function encryption($string)
{
  $output = FALSE;
  $key = hash('sha256', SECRET_KEY);
  $iv = substr(hash('sha256', SECRET_IV), 0, 16);
  $output = openssl_encrypt($string, METHOD, $key, 0, $iv);
  $output = base64_encode($output);
  return $output;
}

/**Desencripta de hash a texto plano */
function decryption($string): string
{
  $key = hash('sha256', SECRET_KEY);
  $iv = substr(hash('sha256', SECRET_IV), 0, 16);
  $output = openssl_decrypt(base64_decode($string), METHOD, $key, 0, $iv);
  return $output;
}

//function que registra logs en la base de datos del sistema
function registerLog($title, $description, $typeLog, $idUser = 0)
{
  require_once "./Models/LogsModel.php";
  $obj = new LogsModel();
  $obj->insert_log($title, $description, $typeLog, $idUser);
}

//Funcion que validad ataque CSRF
function isCsrf($token = "")
{
  if ($token != "") {
    $_POST['token'] = $token;
  }
  if (isset($_POST['token'])) {
    if (isset($_SESSION['token'])) {
      if (!empty($_SESSION['token'])) {
        if (!hash_equals($_SESSION['token'], $_POST['token'])) {
          registerLog("Ocurrio un error inesperado", "El token proporcionado en el formulario no coincide con el token generado por la página, lo que indica un posible intento de vulneración del sistema de registro.", 1, 1);
          $data = array(
            "title" => "Ocurrio un error inesperado",
            "message" => "Error: La sesión ha expirado o el token de seguridad es inválido. Por favor, actualiza la página e intenta nuevamente",
            "type" => "error",
            "status" => false
          );
          toJson($data);
        }
      } else {
        registerLog("Ocurrio un error inesperado", "Token de seguridad no encontrado en la sesión.", 1, 1);
        $data = array(
          "title" => "Ocurrio un error inesperado",
          "message" => "Error: La sesión ha expirado o el token de seguridad es inválido. Por favor, actualiza la página e intenta nuevamente",
          "type" => "error",
          "status" => false
        );
        toJson($data);
      }
      //unset($_SESSION['token']);
    } else {
      registerLog("Ocurrio un error inesperado", "No se encontró el token de seguridad en la sesión.", 1, 1);
      $data = array(
        "title" => "Ocurrio un error inesperado",
        "message" => "Error: La sesión ha expirado o el token de seguridad es inválido. Por favor, actualiza la página e intenta nuevamente",
        "type" => "error",
        "status" => false
      );
      toJson($data);
    }
  } else {
    registerLog("Ocurrio un error inesperado", "Campo token no encontrado en el formulario.", 1, 1);
    $data = array(
      "title" => "Ocurrio un error inesperado",
      "message" => "Error: La sesión ha expirado, el token de seguridad es inválido o el campo no encontrado en el formulario. Por favor, actualiza la página e intenta nuevamente",
      "type" => "error",
      "status" => false
    );
    toJson($data);
  }
}

/**Funcion que previene ataque CSRF */
function csrf(bool $input = true)
{
  //unset($_SESSION['token']);
  if (empty($_SESSION['token'])) {
    $_SESSION['token'] = token();
  }
  $token = $_SESSION['token'];
  if (!$input) {
    return $token;
  } else {
    return '<input type="hidden" name="token" id="token" value="' . $token . '" >';
  }
}

//configuracion de la sesion
function config_sesion()
{
  return ["name" => SESSION_NAME];
}

//Funcion que valida si un usuario  tiene validado el inicio de sesion correcto
function isSession()
{
  if (session_status() === PHP_SESSION_NONE) {
    session_start(config_sesion());
  }
  if (isset($_SESSION['login'])) {
  } else if (!isset($_SESSION['login']) && isset($_COOKIE['login'])) {
    $_SESSION['login'] = $_COOKIE['login'];
    $_SESSION['login_info'] = json_decode($_COOKIE['login_info'], true);
    registerLog("Informacion sobre sesión de usuario", "El usuario tenia una sesion abierta, de alguna manera se cerro, se procedio a volver a abrirla", 1, $_SESSION['login_info']['idUser']);
  } else {
    //obtener ip
    $ip = obtenerIP();
    registerLog("Intento de inicio de interfaz", "No se logro intentar iniciar la interfaz desde la parte externa del sistema, IP de intento de logeo - {$ip}", 1, 0);
    header("Location: " . base_url() . "/login");
  }
}

//validacion de login de inicio si existe
function existLogin()
{
  //sirve para regresar al dashboard desde el login
  if (isset($_SESSION['login'])) {
    header("Location: " . base_url() . "/dashboard");
  }
}

//Funcion para aceptar un tipo de archivo
function isFile(string $type = "", $file, array $extension = [])
{
  $arrType = explode("/", $file["type"]);
  switch ($type) {
    case 'image':
      if ($type == $arrType[0]) {
        if (!empty($extension)) {
          if (!in_array($arrType[1], $extension)) {
            return true;
          }
          return false;
        }
        return false;
      }
      return true;
      break;
    default:
      return false;
      break;
  }
}

//Funcion que valida la creacion de rutas
function verifyFolder(string $ruta, int $permissions = 0777, bool $recursive = false)
{
  if (!is_dir($ruta)) {
    mkdir($ruta, $permissions, $recursive);
    return false;
  } else {
    return true;
  }
}

//Funcion que convierte a mb kb by gb un valor
function valConvert(float $sizeFile): array
{
  $arrValue = array(
    "Byte" => $sizeFile,
    "KB" => ($sizeFile / 1024),
    "Mb" => (($sizeFile / 1024) / 1024)
  );
  return $arrValue;
}

//Funcion que elimina una carpeta
function delFolder(string $carpeta, string $val = "*", bool $deletFolder = false): bool
{
  if (!is_dir($carpeta)) {
    return true;
  }
  $arrFile = glob($carpeta . "/" . $val);
  if (!empty($arrFile)) {
    foreach ($arrFile as $file) {
      //validamos que sea un archivo y exista en la carpeta
      if (is_file($file)) {
        //si existe el archivo lo eliminamos
        if (!unlink($file)) {
          return true;
        }
      } else {
        return true;
      }
    }
  }
  //validamos si quieren eliminar la carpeta
  if ($deletFolder) {
    if (!rmdir($carpeta)) {
      return true;
    }
  }
  return false;
}

//Funcion que carga las opciones del sidebar
function loadOptions(int $id_user, $data = null)
{
  //requerimos el modelo userModel
  require_once "./Models/RolesModel.php";
  $obj = new RolesModel();
  $arrData = $obj->select_module_iterface_by_user($id_user);
  $arrDataListNav = $obj->select_module_iterface_by_user_is_not_list_nav($id_user);
  $arrDataAll = $obj->select_module_iterface_by_user_all($id_user);
  if ($arrData || $arrDataListNav) {
    $_SESSION['login_interface'] = $arrDataAll;
    $sideBar = "";
    foreach ($arrData as $key => $value) {
      $sideBar .= '
                        <li class="treeview ' . isExpanded($data["page_id"], $value['interface']) . '"><a class="app-menu__item" href="#" data-toggle="treeview">' . $value['m_icon'] . '&nbsp;
                            <span class="app-menu__label">' . $value['m_name'] . '</span><i
                                    class="treeview-indicator fa fa-angle-right"></i></a>
                            <ul class="treeview-menu">';
      foreach ($value['interface'] as $key2 => $value2) {
        if ($value2['i_isOption'] == '0') {
          if ($value2['i_isListNav'] == '1') {
            $sideBar .= ' <li><a class="treeview-item ' . activeItem($value2['idInterface'], $data["page_id"]) . '" href="' . base_url() . '/' . $value2['i_url'] . '"><i class="fa-regular fa-circle mr-1"></i>' . $value2['i_name'] . '</a></li>   ';
          }
        }
      }
      $sideBar .= '</ul>
                        </li>
                        ';
    }
    echo $sideBar;
  } else {
    registerLog("Cierre de sesion forzado", "La cuenta del usuario no tiene permisos a niguna funcion, por eso se esta forzando a cerrar session", 3, $_SESSION['login_info']['idUser']);
    //Revisar si se puede mejorar esta ruta, a una interfaz donde diga que la cuenta no tiene permisos, por eso nos fuerza a cerrar sesion
    echo '<script>window.location.href="' . base_url() . '/LogOut";</script>';
  }
  //limpiamos el objeto por seguridad
  unset($obj);
}

//Funcion que busca si el id de la inerfaz esta dentro para poder expandir el item
function isExpanded(int $idInterface, array $array)
{
  foreach ($array as $interfaz) {
    if ($interfaz['i_isListNav'] === '1') {
      if ($interfaz['idInterface'] == $idInterface) {
        return 'is-expanded'; // retorna la clase para expandir el item
      }
    }
  }
  return null; // Retorna null si no se encuentra
}

//Funcion que permite saber si el usuario tiene permisos para acceder a una interfaz
function permissionInterface(int $idInterface)
{
  foreach ($_SESSION['login_interface'] as $modulo) {
    foreach ($modulo['interface'] as $interfaz) {
      if ($interfaz['idInterface'] == $idInterface) {
        return true; // retorna la clase para expandir el item
      }
    }
  }
  registerLog("Cierre de sesion forzado", "La cuenta no tiene permiso a ingresar en esta vist, por lo que se esta forzando a cerrar sesion", 3, $_SESSION['login_info']['idUser']);
  //Revisar si se puede mejorar esta ruta, a una interfaz donde diga que la cuenta no tiene permisos, por eso nos fuerza a cerrar sesion
  echo '<script>window.location.href="' . base_url() . '/LogOut";</script>'; // Retorna null si no se encuentra
}

// Funcion que da formato a la fecha
function dateFormat($date): string
{
  $date = strtotime($date);
  $date = date("M d - Y", $date) . "  " . date("h:i:s a", $date);
  return $date;
}

//Funcion que devuelve la IP del usuario
function obtenerIP()
{
  if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
    // IP desde share internet.
    $ip = $_SERVER['HTTP_CLIENT_IP'];
  } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
    // IP pasada desde un proxy.
    $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
  } else {
    // IP remota.
    $ip = $_SERVER['REMOTE_ADDR'];
  }
  return $ip;
}

//Funcion que obtiene la informacion de sistema
function getSystemInfo()
{
  require_once "./Models/SystemModel.php";
  $obj = new SystemModel();
  $arrData = $obj->select_info_system();
  unset($obj);
  return $arrData;
}

function getConfigurationSytem()
{
  require_once "./Models/SystemModel.php";
  $obj = new SystemModel();
  $arrData = $obj->select_info_configuration();
  unset($obj);
  return $arrData;
}

//Funcion que redimensiona la imagen y tamaño de la imagen
function resizeAndCompressImage($sourcePath, $destinationPath, $maxSizeMB = 2, $newWidth = null, $newHeight = null)
{
  $maxSizeBytes = $maxSizeMB * 1024 * 1024; // Convertir MB a Bytes

  // Obtener información de la imagen
  list($width, $height, $type) = getimagesize($sourcePath);

  // Crear una imagen desde el archivo original
  switch ($type) {
    case IMAGETYPE_JPEG:
      $sourceImage = imagecreatefromjpeg($sourcePath);
      break;
    case IMAGETYPE_PNG:
      $sourceImage = imagecreatefrompng($sourcePath);
      break;
    case IMAGETYPE_GIF:
      $sourceImage = imagecreatefromgif($sourcePath);
      break;
    default:
      return false; // Tipo de imagen no compatible
  }

  // Si no se especifican nuevas dimensiones, mantener las originales
  if ($newWidth === null) {
    $newWidth = $width;
  }
  if ($newHeight === null) {
    $newHeight = ($height * $newWidth) / $width;
  }

  // Crear una imagen en blanco con las nuevas dimensiones
  $resizedImage = imagecreatetruecolor($newWidth, $newHeight);

  // Redimensionar la imagen
  imagecopyresampled($resizedImage, $sourceImage, 0, 0, 0, 0, $newWidth, $newHeight, $width, $height);

  // Ajustar la calidad dinámicamente para alcanzar el peso deseado
  $quality = 90; // Comenzar con calidad alta
  do {
    // Guardar la imagen temporalmente en buffer
    ob_start();
    if ($type == IMAGETYPE_JPEG) {
      imagejpeg($resizedImage, null, $quality);
    } elseif ($type == IMAGETYPE_PNG) {
      imagepng($resizedImage, null, 9); // PNG usa nivel de compresión (0-9)
    } elseif ($type == IMAGETYPE_GIF) {
      imagegif($resizedImage);
    }
    $imageData = ob_get_clean();
    $fileSize = strlen($imageData); // Obtener el tamaño en bytes

    // Reducir calidad progresivamente hasta alcanzar el peso límite
    $quality -= 5;
  } while ($fileSize > $maxSizeBytes && $quality > 10);

  // Guardar la imagen final
  file_put_contents($destinationPath, $imageData);

  // Liberar memoria
  imagedestroy($sourceImage);
  imagedestroy($resizedImage);

  return true;
}

/**
 * Función para generar un código QR y guardarlo en una ruta específica
 *
 * @param string $data - Contenido del QR (texto o URL)
 * @param string $filename - Nombre del archivo (sin la ruta)
 * @param string $path - Ruta donde se guardará el archivo
 * @param int $size - Tamaño del QR (1-10 recomendado)
 * @param int $margin - Margen del QR
 *
 * @return string           - Ruta completa del archivo guardado o mensaje de error
 */
function generarQR(string $data, string $filename = "codigo_qr.png", string $path = "qr_codes/", float $size = 10, float $margin = 2, int $maxIntentos = 3)
{
  // Incluir la biblioteca
  require_once './Libraries/phpqrcode/qrlib.php';

  // Asegurar que la ruta exista, si no, crearla
  if (!file_exists($path)) {
    mkdir($path, 0777, true);
  }

  // Ruta completa donde se guardará el QR
  $filePath = $path . $filename;

  // Intentar generar el código QR hasta `maxIntentos`
  $intento = 0;
  while ($intento < $maxIntentos) {
    // Generar y guardar el código QR
    QRcode::png($data, $filePath, QR_ECLEVEL_L, $size, $margin);

    // Verificar si el archivo se creó correctamente
    if (file_exists($filePath)) {
      return $filePath;
    }

    // Incrementar el contador de intentos
    $intento++;
  }

  // Si llegó aquí, significa que falló en todos los intentos
  return false;
}

/**
 * Calcula la diferencia entre dos fechas y devuelve el resultado en
 * años, meses, días, horas, minutos y segundos.
 *
 * @param string $fechaInicio Fecha inicial en formato 'Y-m-d H:i:s'.
 * @param string $fechaFin Fecha final en formato 'Y-m-d H:i:s'.
 *
 * @return string Retorna una cadena con la diferencia formateada, por ejemplo:
 *                "25 años, 4 meses, 17 días, 2 horas, 35 minutos, 20 segundos"
 *
 * @example
 * echo calcularDiferenciaFechas("2000-01-01 12:00:00", "2025-05-18 14:35:20");
 */
function calculateDifferenceDates($fechaInicio, $fechaFin, $incluirHoras = false)
{
  // Crear objetos DateTime a partir de las fechas ingresadas
  $inicio = new DateTime($fechaInicio);
  $fin = new DateTime($fechaFin);

  // Calcular la diferencia
  $diferencia = $inicio->diff($fin);


  // Construir la cadena base
  $resultado = "{$diferencia->y} años, {$diferencia->m} meses, {$diferencia->d} días";

  // Si se desea incluir horas, minutos y segundos
  if ($incluirHoras) {
    $resultado .= ", {$diferencia->h} horas, {$diferencia->i} minutos, {$diferencia->s} segundos";
  }

  return $resultado;
}
