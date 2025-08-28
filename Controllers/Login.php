<?php

class Login extends Controllers
{
	public function __construct()
	{
		session_start(config_sesion());
		existLogin();
		parent::__construct();
	}

	public function login()
	{
		$data['page_id'] = 1;
		$data['page_title'] = "Inicio de sesión";
		$data['page_description'] = "Login";
		$data['page_container'] = "Login";
		$data['page_js_css'] = "login";
		$this->views->getView($this, "login", $data);
	}
	/**
	 * Funcion que permite el inicio de sesion del usuario
	 * @return void
	 */
	public function isLogIn()
	{
		//validacion del metodo POST
		if (!$_POST) {
			registerLog("Ocurrio un error inesperado", "Metodo POST no encontrado, al momento de iniciar session", 1);
			$data = array(
				"title" => "Ocurrio un error inesperado",
				"message" => "Metodo POST no encontrado",
				"type" => "error",
				"status" => false
			);
			toJson($data);
		}
		//limpieza de los inputs
		$txtUser = strClean($_POST["txtUser"]);
		$txtPassword = strClean($_POST["txtPassword"]);
		//validacion de campos vacios
		if ($txtUser == "" || $txtPassword == "") {
			registerLog("Ocurrio un error inesperado", "Todos los campos de login deben estar llenos", 1);
			$data = array(
				"title" => "Error",
				"message" => "Todos los campos son obligatorios",
				"type" => "error",
				"status" => false
			);
			toJson($data);
		}
		//Validacion de usuario, solo debe soporte minimo 3 caracteres
		if (strlen($txtUser) < 3) {
			registerLog("Ocurrio un error inesperado", "El usuario debe tener al menos 3 caracteres para poder ingresar al sistema", 1);
			$data = array(
				"title" => "Ocurrio un error inesperado",
				"message" => "El usuario debe tener al menos 3 caracteres",
				"type" => "error",
				"status" => false
			);
			toJson($data);
		}
		//validacion que la contraseña pueda ingresar minimo 8 caracteres
		if (strlen($txtPassword) < 8) {
			registerLog("Ocurrio un error inesperado", "La contraseña debe tener al menos 8 caracteres para iniciar sesion", 1);
			$data = array(
				"title" => "Ocurrio un error inesperado",
				"message" => "La contraseña debe tener al menos 8 caracteres",
				"type" => "error",
				"status" => false
			);
			toJson($data);
		}
		//Encriptacion de la informacion
		$txtUser = encryption($txtUser);
		$txtPassword = encryption($txtPassword);
		$request = $this->model->selectUserLogin($txtUser, $txtPassword);
		if ($request) {
			if ($request["u_status"] == "Inactivo") {
				registerLog("Ocurrio un error inesperado", "El usuario " . $request["u_fullname"] . ", no inicio sesion por motivo de cuenta desactivada", 1, $request["idUser"]);
				$data = array(
					"title" => "Ocurrio un error inesperado",
					"message" => "La cuenta del usuario actualmente se encuentra en estado Inactivo",
					"type" => "error",
					"status" => false
				);
				toJson($data);
			}
			$_SESSION['login'] = true;
			$_SESSION['login_info'] = array(
				"idUser" => $request["idUser"],
				"user" => $request["u_user"],
				"email" => $request["u_email"],
				"profile" => $request["u_profile"],
				"fullName" => $request["u_fullname"],
				"gender" => $request["u_gender"],
				"dni" => $request["u_dni"],
				"status" => $request["u_status"],
				"registrationDate" => $request["u_registrationDate"],
				"updateDate" => $request["u_updateDate"],
				"role_id" => $request["role_id"],
				"role" => $request["r_name"]
			);
			registerLog("Inicio de sesion exitoso", "El usuario " . $request["u_fullname"] . ", completo de manera satisfactoria el inicio de sesion", 2, $request["idUser"]);
			$data = array(
				"title" => "Inicio de sesion exitoso",
				"message" => "Hola " . $request["u_fullname"] . ", se completo de manera satisfactoria el inicio de sesion",
				"type" => "success",
				"status" => true,
				"redirection" => base_url() . "/dashboard"
			);
			toJson($data);
		} else {
			registerLog("Ocurrio un error inesperado", "El usuario {$txtUser} o contraseña {$txtPassword} que esta intentando ingresar no existe", 1);
			$data = array(
				"title" => "Ocurrio un error inesperado",
				"message" => "La cuenta de usuario no existe",
				"type" => "error",
				"status" => false
			);
			toJson($data);
		}
	}

	public function verifyEmail()
	{
		if ($_SERVER["REQUEST_METHOD"] !== "POST") {
			registerLog("Error al verificar email", "No se recibió método POST", 1);
			toJson([
				"title" => "Error inesperado",
				"message" => "No se pudo procesar la solicitud",
				"type" => "error",
				"status" => false
			]);
		}

		$email = isset($_POST["email"]) ? strClean($_POST["email"]) : "";

		if (empty($email)) {
			registerLog("Email vacío", "No se ingresó ningún email", 1);
			toJson([
				"title" => "Campo vacío",
				"message" => "El campo de correo electrónico no puede estar vacío",
				"type" => "error",
				"status" => false
			]);
		}

		// Validar formato
		if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
			registerLog("Email inválido", "Formato de email incorrecto: {$email}", 1);
			toJson([
				"title" => "Email inválido",
				"message" => "El correo no tiene un formato válido",
				"type" => "error",
				"status" => false
			]);
		}

		$emailEnc = encryption($email);

		// Buscar usuario
		$user = $this->model->emailExists($emailEnc);

		if (!$user || !isset($user["idUser"])) {
			registerLog("Correo no registrado", "Intento con correo no existente o resultado inválido: {$emailEnc}", 1);
			toJson([
				"title" => "Correo no encontrado",
				"message" => "El correo ingresado no se encuentra registrado",
				"type" => "error",
				"status" => false
			]);
		}

		// Generar código
		$code = rand(100000, 999999);
		$expiresAt = date("Y-m-d H:i:s", strtotime("+5 minutes"));

		// Guardar en BD
		$inserted = $this->model->insertResetToken($user["idUser"], $emailEnc, $code, $expiresAt);

		if (!$inserted) {
			registerLog("Error al insertar token", "No se pudo guardar el código en la base de datos", 1, $user["idUser"]);
			toJson([
				"title" => "Fallo interno",
				"message" => "No se pudo generar el código de verificación",
				"type" => "error",
				"status" => false
			]);
		}

		// Enviar correo
		$dataEmail = [
			"email" => $email,
			"asunto" => "Código de verificación para restablecer contraseña",
			"codigo" => $code
		];
		$send = sendEmail($dataEmail, "codigo_verificacion");

		if (!$send) {
			registerLog("Error al enviar código", "No se pudo enviar a {$emailEnc}", 1, $user["idUser"]);
			toJson([
				"title" => "Fallo al enviar",
				"message" => "No se pudo enviar el código al correo electrónico",
				"type" => "error",
				"status" => false
			]);
		}

		registerLog("Código enviado", "Se envió código de verificación al usuario", 2, $user["idUser"]);
		toJson([
			"title" => "Código enviado",
			"message" => "Se ha enviado un código de verificación a tu correo",
			"type" => "success",
			"status" => true,
			"redirection" => base_url() . "/sendcode"
		]);
	}
}
