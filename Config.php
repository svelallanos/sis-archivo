<?php

//Variable constante de la URL del proyecto
const BASE_URL = "https://rice.nguevara.com";
//Ruta de almacenamiento de archivos
const RUTA_ARCHIVOS = "./Storage/";
//Nombre del sistema
const NOMBRE_SISTEMA = "Sistema de Gestion de Arroz";
//Zona horaria
date_default_timezone_set('America/Lima');

//Datos de conexión a Base de Datos
const DB_HOST = "localhost";
const DB_NAME = "nguevara_rice";
const DB_USER = "nguevara_riceguevara";
const DB_PASSWORD = "AxcEVB7f5Tbr3ce";
const DB_PORT = 3306;
const DB_CHARSET = "utf8";

//Deliminadores decimal y millar Ej. 24,1989.00
const SPD = ".";
const SPM = ",";

//Simbolo de moneda
const SMONEY = "S/.";

//Datos envio de correo
const NOMBRE_REMITENTE = "Sistema de Gestion de Roles";
const EMAIL_REMITENTE = "no-reply@abelosh.com";
const NOMBRE_EMPESA = "Sistema de Roles";
const WEB_EMPRESA = "www.roles.com";
//Variables de encriptacion
const METHOD = "AES-256-CBC";
const SECRET_KEY = "SystemOfPredios2025";
const SECRET_IV = "@2025BajoNaranjillo";
//nombre de la sesion
const SESSION_NAME = "SRices";