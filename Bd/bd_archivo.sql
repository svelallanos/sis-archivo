-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Versión del servidor:         10.4.32-MariaDB - mariadb.org binary distribution
-- SO del servidor:              Win64
-- HeidiSQL Versión:             12.10.0.7000
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


-- Volcando estructura de base de datos para bd_archivo
DROP DATABASE IF EXISTS `bd_archivo`;
CREATE DATABASE IF NOT EXISTS `bd_archivo` /*!40100 DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci */;
USE `bd_archivo`;

-- Volcando estructura para tabla bd_archivo.tb_company
DROP TABLE IF EXISTS `tb_company`;
CREATE TABLE IF NOT EXISTS `tb_company` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(200) DEFAULT NULL,
  `subtitle` varchar(300) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `mail` text DEFAULT NULL,
  `ruc` char(11) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `phone` char(9) DEFAULT NULL,
  `dateRegistration` timestamp NOT NULL DEFAULT current_timestamp(),
  `dateUpdate` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `status` enum('ACTIVO','INACTIVO') DEFAULT 'ACTIVO',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Volcando datos para la tabla bd_archivo.tb_company: ~1 rows (aproximadamente)
INSERT INTO `tb_company` (`id`, `title`, `subtitle`, `description`, `mail`, `ruc`, `address`, `phone`, `dateRegistration`, `dateUpdate`, `status`) VALUES
	(1, 'MUNICIPALIDAD DISTRITAL DE ELIAS SOPLIN VARGAS', 'Sistema archivistico', NULL, 'informatica@munieliassoplinvargas.gob.pe', '20187362840', 'Av. Galilea 452', '963953212', '2025-07-28 14:58:49', '2025-08-28 16:48:12', 'ACTIVO');

-- Volcando estructura para tabla bd_archivo.tb_configuration
DROP TABLE IF EXISTS `tb_configuration`;
CREATE TABLE IF NOT EXISTS `tb_configuration` (
  `idConfiguration` int(11) NOT NULL AUTO_INCREMENT,
  `c_name` varchar(255) NOT NULL,
  `c_logo` varchar(255) NOT NULL,
  `c_description` text NOT NULL,
  `c_registrationDate` timestamp NOT NULL DEFAULT current_timestamp(),
  `c_updateDate` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`idConfiguration`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Volcando datos para la tabla bd_archivo.tb_configuration: ~1 rows (aproximadamente)
INSERT INTO `tb_configuration` (`idConfiguration`, `c_name`, `c_logo`, `c_description`, `c_registrationDate`, `c_updateDate`) VALUES
	(1, 'Sis Archivo', '6887eede6d033.jpg', 'Sistema archivistico', '2025-02-02 00:49:12', '2025-08-28 16:48:45');

-- Volcando estructura para tabla bd_archivo.tb_file
DROP TABLE IF EXISTS `tb_file`;
CREATE TABLE IF NOT EXISTS `tb_file` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_code` int(11) DEFAULT NULL,
  `table` varchar(100) NOT NULL,
  `name` text NOT NULL,
  `type` char(25) DEFAULT NULL,
  `size` double DEFAULT NULL,
  `status` enum('ACTIVO','INACTIVO') DEFAULT 'ACTIVO',
  `dateRegistration` timestamp NOT NULL DEFAULT current_timestamp(),
  `dateUpdate` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=112 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Volcando datos para la tabla bd_archivo.tb_file: ~0 rows (aproximadamente)

-- Volcando estructura para tabla bd_archivo.tb_interface
DROP TABLE IF EXISTS `tb_interface`;
CREATE TABLE IF NOT EXISTS `tb_interface` (
  `idInterface` int(11) NOT NULL AUTO_INCREMENT,
  `i_name` varchar(250) NOT NULL,
  `i_description` text DEFAULT NULL,
  `i_url` varchar(250) DEFAULT NULL,
  `i_isOption` char(1) DEFAULT '0',
  `i_isPublic` char(1) DEFAULT '0',
  `i_isListNav` char(1) DEFAULT '1',
  `i_status` enum('Activo','Inactivo') DEFAULT 'Activo',
  `i_registrationDate` timestamp NOT NULL DEFAULT current_timestamp(),
  `i_updateDate` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `module_id` int(11) NOT NULL,
  PRIMARY KEY (`idInterface`),
  KEY `module_id` (`module_id`),
  CONSTRAINT `tb_interface_ibfk_1` FOREIGN KEY (`module_id`) REFERENCES `tb_module` (`idModule`)
) ENGINE=InnoDB AUTO_INCREMENT=32 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Volcando datos para la tabla bd_archivo.tb_interface: ~11 rows (aproximadamente)
INSERT INTO `tb_interface` (`idInterface`, `i_name`, `i_description`, `i_url`, `i_isOption`, `i_isPublic`, `i_isListNav`, `i_status`, `i_registrationDate`, `i_updateDate`, `module_id`) VALUES
	(1, 'Inicio de Sesion', NULL, 'login', '0', '1', '0', 'Activo', '2025-01-26 15:17:34', '2025-08-28 16:43:05', 1),
	(2, 'Dashboard', NULL, 'dashboard', '0', '0', '0', 'Activo', '2025-01-26 19:37:54', '2025-08-28 16:43:03', 1),
	(3, 'Usuarios', NULL, 'users', '0', '0', '1', 'Activo', '2025-01-26 20:10:27', '2025-08-28 16:43:00', 1),
	(4, 'Roles', NULL, 'roles', '0', '0', '1', 'Activo', '2025-01-28 22:21:22', '2025-08-28 16:42:58', 1),
	(5, 'Listado de Logs', NULL, 'logs', '0', '0', '1', 'Activo', '2025-01-31 21:49:03', '2025-08-28 16:42:55', 1),
	(6, 'Configuracion del sistema', NULL, 'system', '0', '0', '1', 'Activo', '2025-02-01 22:29:47', '2025-08-28 16:42:53', 1),
	(7, 'Perfil del usuario', NULL, 'profile', '0', '0', '0', 'Activo', '2025-02-02 16:23:26', '2025-08-28 16:42:50', 1),
	(10, 'Cargos', NULL, 'jobtitle', '0', '0', '1', 'Activo', '2025-05-23 02:55:45', '2025-08-21 17:15:00', 1),
	(11, 'Personas', NULL, 'people', '0', '0', '1', 'Activo', '2025-08-28 16:42:37', '2025-08-28 16:42:37', 1),
	(16, 'Trabajadores', NULL, 'worker', '0', '0', '1', 'Activo', '2025-06-02 03:39:07', '2025-08-21 17:15:45', 1),
	(20, 'Bloqueo de Sesion', NULL, 'lock', '0', '0', '0', 'Activo', '2025-05-22 05:54:34', '2025-08-28 16:42:45', 1);

-- Volcando estructura para tabla bd_archivo.tb_job_title
DROP TABLE IF EXISTS `tb_job_title`;
CREATE TABLE IF NOT EXISTS `tb_job_title` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(200) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `status` enum('ACTIVO','INACTIVO') DEFAULT 'ACTIVO',
  `dateRegistration` timestamp NOT NULL DEFAULT current_timestamp(),
  `dateUpdate` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Volcando datos para la tabla bd_archivo.tb_job_title: ~0 rows (aproximadamente)

-- Volcando estructura para tabla bd_archivo.tb_log
DROP TABLE IF EXISTS `tb_log`;
CREATE TABLE IF NOT EXISTS `tb_log` (
  `idLog` int(11) NOT NULL AUTO_INCREMENT,
  `l_title` varchar(200) NOT NULL,
  `l_description` text DEFAULT NULL,
  `l_registrationDate` timestamp NOT NULL DEFAULT current_timestamp(),
  `l_updateDate` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `typelog_id` int(11) DEFAULT NULL,
  `user_id` int(11) NOT NULL,
  PRIMARY KEY (`idLog`),
  KEY `user_id` (`user_id`),
  KEY `tb_log_ibfk_1` (`typelog_id`),
  CONSTRAINT `tb_log_ibfk_1` FOREIGN KEY (`typelog_id`) REFERENCES `tb_typelog` (`idTypeLog`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Volcando datos para la tabla bd_archivo.tb_log: ~11 rows (aproximadamente)
INSERT INTO `tb_log` (`idLog`, `l_title`, `l_description`, `l_registrationDate`, `l_updateDate`, `typelog_id`, `user_id`) VALUES
	(1, 'Información de navegación', 'El usuario entro a :Panel de control', '2025-08-28 16:49:10', '2025-08-28 16:49:10', 3, 1),
	(2, 'Ocurrio un error inesperado', 'Error: SQLSTATE[42S02]: Base table or view not found: 1146 Table \'bd_archivo.tb_customer\' doesn\'t exist - 42S02', '2025-08-28 16:49:10', '2025-08-28 16:49:10', 1, 1),
	(3, 'Información de navegación', 'El usuario entro a :Panel de control', '2025-08-28 16:49:27', '2025-08-28 16:49:27', 3, 1),
	(4, 'Ocurrio un error inesperado', 'Error: SQLSTATE[42S02]: Base table or view not found: 1146 Table \'bd_archivo.tb_customer\' doesn\'t exist - 42S02', '2025-08-28 16:49:27', '2025-08-28 16:49:27', 1, 1),
	(5, 'Información de navegación', 'El usuario entro a :Panel de control', '2025-08-28 16:50:35', '2025-08-28 16:50:35', 3, 1),
	(6, 'Ocurrio un error inesperado', 'Error: SQLSTATE[42S02]: Base table or view not found: 1146 Table \'bd_archivo.tb_customer\' doesn\'t exist - 42S02', '2025-08-28 16:50:36', '2025-08-28 16:50:36', 1, 1),
	(7, 'Tiempo de inactividad', 'El usuario ha estado inactivo durante -Tiempo inactivo: 12 minutos y 45 segundos.', '2025-08-28 16:50:37', '2025-08-28 16:50:37', 3, 1),
	(8, 'Información de navegación', 'El usuario entro a :Panel de control', '2025-08-28 16:50:37', '2025-08-28 16:50:37', 3, 1),
	(9, 'Navegación en módulo', 'El usuario ingresó al módulo: Cargos del Personal', '2025-08-28 16:50:52', '2025-08-28 16:50:52', 3, 1),
	(10, 'Información de navegación', 'El usuario entro a :Gestion de Usuarios', '2025-08-28 16:50:56', '2025-08-28 16:50:56', 3, 1),
	(11, 'Cierre de sesion', 'El usuario Super Admin ah cerrado sesion en el sistema', '2025-08-28 16:51:12', '2025-08-28 16:51:12', 2, 1);

-- Volcando estructura para tabla bd_archivo.tb_module
DROP TABLE IF EXISTS `tb_module`;
CREATE TABLE IF NOT EXISTS `tb_module` (
  `idModule` int(11) NOT NULL AUTO_INCREMENT,
  `m_name` varchar(250) NOT NULL,
  `m_icon` varchar(250) NOT NULL DEFAULT '<i class="fa fa-microchip" aria-hidden="true"></i>',
  `m_description` text DEFAULT NULL,
  `m_status` enum('Activo','Inactivo') DEFAULT 'Activo',
  `m_registrationDate` timestamp NOT NULL DEFAULT current_timestamp(),
  `m_updateDate` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`idModule`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Volcando datos para la tabla bd_archivo.tb_module: ~2 rows (aproximadamente)
INSERT INTO `tb_module` (`idModule`, `m_name`, `m_icon`, `m_description`, `m_status`, `m_registrationDate`, `m_updateDate`) VALUES
	(1, 'Módulo configuración', '<i class="fa-solid fa-gears"></i>', 'Aqui se encuentra toda la configuracion inicial del sistema', 'Activo', '2025-01-26 15:17:10', '2025-08-28 16:40:05'),
	(2, 'Logs', '<i class="fa fa-microchip" aria-hidden="true"></i>', 'Aqui se visualizara los logs del sistema', 'Activo', '2025-01-31 21:32:16', '2025-08-28 16:40:15');

-- Volcando estructura para tabla bd_archivo.tb_password_reset_tokens
DROP TABLE IF EXISTS `tb_password_reset_tokens`;
CREATE TABLE IF NOT EXISTS `tb_password_reset_tokens` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `email` varchar(100) NOT NULL,
  `code` varchar(10) NOT NULL,
  `expires_at` datetime NOT NULL,
  `status` enum('Activo','Usado','Expirado') DEFAULT 'Activo',
  `created_at` datetime DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  CONSTRAINT `tb_password_reset_tokens_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `tb_user` (`idUser`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Volcando datos para la tabla bd_archivo.tb_password_reset_tokens: ~0 rows (aproximadamente)

-- Volcando estructura para tabla bd_archivo.tb_people
DROP TABLE IF EXISTS `tb_people`;
CREATE TABLE IF NOT EXISTS `tb_people` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(200) DEFAULT NULL,
  `fullname` text DEFAULT NULL,
  `lastname` varchar(200) DEFAULT NULL,
  `numberDocument` char(11) DEFAULT NULL,
  `typePeople` enum('JURIDICA','NATURAL') DEFAULT NULL,
  `birthdate` date DEFAULT NULL,
  `gender` enum('FEMENINO','MASCULINO','OTRO') DEFAULT NULL,
  `mail` text DEFAULT NULL,
  `phone` char(9) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `comment` text DEFAULT NULL,
  `dateRegistration` timestamp NOT NULL DEFAULT current_timestamp(),
  `dateUpdate` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `status` enum('ACTIVO','INACTIVO') DEFAULT 'ACTIVO',
  PRIMARY KEY (`id`),
  UNIQUE KEY `dni` (`numberDocument`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=51 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Volcando datos para la tabla bd_archivo.tb_people: ~0 rows (aproximadamente)

-- Volcando estructura para tabla bd_archivo.tb_role
DROP TABLE IF EXISTS `tb_role`;
CREATE TABLE IF NOT EXISTS `tb_role` (
  `idRole` int(11) NOT NULL AUTO_INCREMENT,
  `r_name` varchar(250) NOT NULL,
  `r_description` text DEFAULT NULL,
  `r_status` enum('Activo','Inactivo') DEFAULT 'Activo',
  `r_registrationDate` timestamp NOT NULL DEFAULT current_timestamp(),
  `r_updateDate` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`idRole`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Volcando datos para la tabla bd_archivo.tb_role: ~2 rows (aproximadamente)
INSERT INTO `tb_role` (`idRole`, `r_name`, `r_description`, `r_status`, `r_registrationDate`, `r_updateDate`) VALUES
	(1, 'Root', 'El rol Root es el usuario con los privilegios más elevados dentro del sistema. Tiene control total sobre la configuración, la administración de usuarios, la seguridad y la gestión de recursos. Este rol está destinado exclusivamente a tareas de administración crítica y debe ser utilizado con precaución para evitar daños en el sistema.', 'Activo', '2025-01-26 21:34:50', '2025-02-02 22:52:24'),
	(15, 'Administrador', 'Encargado para las pruebas del sistema', 'Activo', '2025-07-13 22:34:48', '2025-07-13 22:34:48');

-- Volcando estructura para tabla bd_archivo.tb_typelog
DROP TABLE IF EXISTS `tb_typelog`;
CREATE TABLE IF NOT EXISTS `tb_typelog` (
  `idTypeLog` int(11) NOT NULL AUTO_INCREMENT,
  `tl_name` varchar(100) NOT NULL,
  `tl_description` text DEFAULT NULL,
  `tl_status` enum('Activo','Inactivo') DEFAULT 'Activo',
  `tl_registrationDate` timestamp NOT NULL DEFAULT current_timestamp(),
  `tl_updateDate` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`idTypeLog`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Volcando datos para la tabla bd_archivo.tb_typelog: ~3 rows (aproximadamente)
INSERT INTO `tb_typelog` (`idTypeLog`, `tl_name`, `tl_description`, `tl_status`, `tl_registrationDate`, `tl_updateDate`) VALUES
	(1, 'Error', NULL, 'Activo', '2025-01-26 15:14:03', '2025-01-26 15:14:03'),
	(2, 'Correcto', NULL, 'Activo', '2025-01-27 05:26:47', '2025-01-27 05:26:47'),
	(3, 'Información', NULL, 'Activo', '2025-01-27 05:26:57', '2025-01-27 05:26:57');

-- Volcando estructura para tabla bd_archivo.tb_user
DROP TABLE IF EXISTS `tb_user`;
CREATE TABLE IF NOT EXISTS `tb_user` (
  `idUser` int(11) NOT NULL AUTO_INCREMENT,
  `u_user` text NOT NULL,
  `u_password` text NOT NULL,
  `u_email` text NOT NULL,
  `u_profile` text DEFAULT NULL,
  `u_fullname` varchar(200) NOT NULL,
  `u_gender` enum('Masculino','Femenino','Otro') NOT NULL,
  `u_dni` char(8) NOT NULL,
  `u_status` enum('Activo','Inactivo') DEFAULT 'Activo',
  `u_registrationDate` timestamp NOT NULL DEFAULT current_timestamp(),
  `u_updateDate` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `role_id` int(11) NOT NULL,
  PRIMARY KEY (`idUser`),
  UNIQUE KEY `u_dni` (`u_dni`),
  UNIQUE KEY `u_user` (`u_user`) USING HASH,
  UNIQUE KEY `u_email` (`u_email`) USING HASH,
  KEY `role_id` (`role_id`),
  CONSTRAINT `tb_user_ibfk_1` FOREIGN KEY (`role_id`) REFERENCES `tb_role` (`idRole`)
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Volcando datos para la tabla bd_archivo.tb_user: ~1 rows (aproximadamente)
INSERT INTO `tb_user` (`idUser`, `u_user`, `u_password`, `u_email`, `u_profile`, `u_fullname`, `u_gender`, `u_dni`, `u_status`, `u_registrationDate`, `u_updateDate`, `role_id`) VALUES
	(1, 'OHl4NXRSbFRqbSs1UW9mbEpxNnNPQT09', 'OHl4NXRSbFRqbSs1UW9mbEpxNnNPQT09', 'VTJxUmZLN2x5N0FrKzJMamRtLzR3Zz09', '687433294d211.jpg', 'Super Admin', 'Otro', '12345678', 'Activo', '2025-01-28 18:49:20', '2025-08-21 16:31:56', 1);

-- Volcando estructura para tabla bd_archivo.tb_userroledetail
DROP TABLE IF EXISTS `tb_userroledetail`;
CREATE TABLE IF NOT EXISTS `tb_userroledetail` (
  `idUserRoleDetail` int(11) NOT NULL AUTO_INCREMENT,
  `interface_id` int(11) NOT NULL,
  `role_id` int(11) NOT NULL,
  `urd_status` enum('Activo','Inactivo') DEFAULT 'Activo',
  `urd_registrationDate` timestamp NOT NULL DEFAULT current_timestamp(),
  `urd_updateDate` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`idUserRoleDetail`),
  KEY `tb_userroledetail_ibfk_1` (`interface_id`),
  KEY `tb_userroledetail_ibfk_2` (`role_id`),
  CONSTRAINT `tb_userroledetail_ibfk_1` FOREIGN KEY (`interface_id`) REFERENCES `tb_interface` (`idInterface`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `tb_userroledetail_ibfk_2` FOREIGN KEY (`role_id`) REFERENCES `tb_role` (`idRole`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=51 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Volcando datos para la tabla bd_archivo.tb_userroledetail: ~11 rows (aproximadamente)
INSERT INTO `tb_userroledetail` (`idUserRoleDetail`, `interface_id`, `role_id`, `urd_status`, `urd_registrationDate`, `urd_updateDate`) VALUES
	(1, 1, 1, 'Activo', '2025-06-02 03:40:12', '2025-06-02 03:40:12'),
	(2, 2, 1, 'Activo', '2025-06-02 03:40:19', '2025-06-02 03:40:19'),
	(3, 3, 1, 'Activo', '2025-06-02 03:40:30', '2025-06-02 03:40:30'),
	(4, 4, 1, 'Activo', '2025-06-02 03:40:57', '2025-06-02 03:40:57'),
	(5, 5, 1, 'Activo', '2025-06-02 03:41:08', '2025-06-02 03:41:08'),
	(6, 6, 1, 'Activo', '2025-06-02 03:41:20', '2025-06-02 03:42:46'),
	(7, 7, 1, 'Activo', '2025-06-02 03:41:29', '2025-06-02 03:42:48'),
	(47, 10, 1, 'Activo', '2025-08-28 16:43:45', '2025-08-28 16:43:48'),
	(48, 11, 1, 'Activo', '2025-08-28 16:44:01', '2025-08-28 16:44:01'),
	(49, 16, 1, 'Activo', '2025-08-28 16:44:09', '2025-08-28 16:44:09'),
	(50, 20, 1, 'Activo', '2025-08-28 16:44:17', '2025-08-28 16:44:17');

-- Volcando estructura para tabla bd_archivo.tb_worker
DROP TABLE IF EXISTS `tb_worker`;
CREATE TABLE IF NOT EXISTS `tb_worker` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `people_id` int(11) DEFAULT NULL,
  `job_title_id` int(11) DEFAULT NULL,
  `account_number` text DEFAULT NULL,
  `account_number2` text DEFAULT NULL,
  `account_number3` text DEFAULT NULL,
  `account_number4` text DEFAULT NULL,
  `status` enum('ACTIVO','INACTIVO') DEFAULT 'ACTIVO',
  `dateRegistration` timestamp NOT NULL DEFAULT current_timestamp(),
  `dateUpdate` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `account_number` (`account_number`) USING HASH,
  KEY `people_id` (`people_id`),
  KEY `job_title_id` (`job_title_id`),
  CONSTRAINT `tb_worker_ibfk_1` FOREIGN KEY (`people_id`) REFERENCES `tb_people` (`id`),
  CONSTRAINT `tb_worker_ibfk_2` FOREIGN KEY (`job_title_id`) REFERENCES `tb_job_title` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Volcando datos para la tabla bd_archivo.tb_worker: ~0 rows (aproximadamente)

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
