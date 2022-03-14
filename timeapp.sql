-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1:3306
-- Tiempo de generación: 14-03-2022 a las 04:14:38
-- Versión del servidor: 8.0.27
-- Versión de PHP: 8.0.13

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `timeapp`
--

DELIMITER $$
--
-- Procedimientos
--
DROP PROCEDURE IF EXISTS `sp_ActivityTime`$$
CREATE PROCEDURE `sp_ActivityTime` (IN `_id_actividad` INT)  SELECT SUM(horas) as horas FROM actividadtiempos WHERE estado = 1 AND id_actividad = _id_actividad$$

DROP PROCEDURE IF EXISTS `sp_ActivityTime_Delete`$$
CREATE PROCEDURE `sp_ActivityTime_Delete` (IN `_id` INT)  UPDATE actividadtiempos SET estado = 0 WHERE id= _id$$

DROP PROCEDURE IF EXISTS `sp_ActivityTime_Insert`$$
CREATE PROCEDURE `sp_ActivityTime_Insert` (IN `_id_actividad` INT, IN `_fecha` DATE, IN `_horas` INT, IN `_estado` INT)  INSERT INTO actividadtiempos (id_actividad, fecha, horas, estado) VALUES (_id_actividad, _fecha, _horas, _estado)$$

DROP PROCEDURE IF EXISTS `sp_ActivityTime_Select`$$
CREATE PROCEDURE `sp_ActivityTime_Select` (IN `_id` INT)  SELECT a.id, b.id as id_actividad, b.descripcion, a.fecha, a.horas FROM actividadtiempos a
INNER JOIN actividades b ON a.id_actividad = b.id
WHERE a.id = _id$$

DROP PROCEDURE IF EXISTS `sp_ActivityTime_SelectAll`$$
CREATE PROCEDURE `sp_ActivityTime_SelectAll` (IN `_id_user` INT)  SELECT a.id, b.descripcion, a.fecha, a.horas FROM actividadtiempos a
INNER JOIN actividades b ON a.id_actividad = b.id
WHERE b.estado = 1 AND a.estado = 1 AND b.id_user = _id_user$$

DROP PROCEDURE IF EXISTS `sp_ActivityTime_Update`$$
CREATE PROCEDURE `sp_ActivityTime_Update` (IN `_id_actividad` INT, IN `_fecha` DATE, IN `_horas` INT, IN `_id` INT)  UPDATE actividadtiempos SET id_actividad = _id_actividad, fecha = _fecha, horas = _horas WHERE id = _id$$

DROP PROCEDURE IF EXISTS `sp_Activity_Delete`$$
CREATE PROCEDURE `sp_Activity_Delete` (IN `_id` INT)  UPDATE actividades SET estado = 0 WHERE id = _id$$

DROP PROCEDURE IF EXISTS `sp_Activity_Insert`$$
CREATE PROCEDURE `sp_Activity_Insert` (IN `_descripcion` VARCHAR(200), IN `_idUser` INT)  INSERT INTO actividades (descripcion, id_user) VALUES (_descripcion,_idUser)$$

DROP PROCEDURE IF EXISTS `sp_Activity_Select`$$
CREATE PROCEDURE `sp_Activity_Select` (IN `_id_actividad` INT)  SELECT id, descripcion FROM actividades
WHERE id = _id_actividad$$

DROP PROCEDURE IF EXISTS `sp_Activity_SelectAll`$$
CREATE PROCEDURE `sp_Activity_SelectAll` (IN `_id_user` INT)  SELECT a.id, a.descripcion
FROM actividades a 
WHERE a.id_user = _id_user AND a.estado = 1$$

DROP PROCEDURE IF EXISTS `sp_Activity_Update`$$
CREATE PROCEDURE `sp_Activity_Update` (IN `_descripcion` VARCHAR(200), IN `_id` INT)  UPDATE actividades SET descripcion = _descripcion WHERE id = _id$$

DROP PROCEDURE IF EXISTS `sp_GetUser`$$
CREATE PROCEDURE `sp_GetUser` (IN `_usuario` VARCHAR(20), IN `_password` VARCHAR(200))  SELECT u.id, u.identificacion, u.nombre, p.nombre as perfil, u.estado 
FROM usuarios u 
INNER JOIN perfiles p ON p.id = u.id_perfil 
WHERE u.identificacion = _usuario AND u.password = _password$$

DROP PROCEDURE IF EXISTS `sp_Perfil_SelectAll`$$
CREATE PROCEDURE `sp_Perfil_SelectAll` ()  SELECT id, nombre FROM perfiles$$

DROP PROCEDURE IF EXISTS `sp_User_Insert`$$
CREATE PROCEDURE `sp_User_Insert` (IN `_nombre` VARCHAR(200), IN `_identificacion` VARCHAR(20), IN `_password` VARCHAR(200), IN `_id_perfil` INT, IN `_fecha_crea` DATE, IN `_estado` INT)  INSERT INTO usuarios (nombre, identificacion, password, id_perfil, fecha_creacion, fecha_modificacion, estado) VALUES (_nombre, _identificacion, _password, _id_perfil, _fecha_crea, NULL, _estado)$$

DROP PROCEDURE IF EXISTS `sp_User_Select`$$
CREATE PROCEDURE `sp_User_Select` (IN `_id` INT)  SELECT u.id, u.identificacion, u.nombre, p.id as id_perfil, p.nombre as perfil, u.password, u.estado 
FROM usuarios u 
INNER JOIN perfiles p ON p.id = u.id_perfil 
WHERE u.id = _id$$

DROP PROCEDURE IF EXISTS `sp_User_SelectAll`$$
CREATE PROCEDURE `sp_User_SelectAll` ()  SELECT u.id, u.identificacion, u.nombre, p.nombre as perfil, u.estado 
FROM usuarios u 
INNER JOIN perfiles p ON p.id = u.id_perfil$$

DROP PROCEDURE IF EXISTS `sp_User_Update`$$
CREATE PROCEDURE `sp_User_Update` (IN `_nombre` VARCHAR(200), IN `_identificacion` VARCHAR(20), IN `_password` VARCHAR(200), IN `_id_perfil` INT, IN `_fecha_mod` DATE, IN `_estado` INT, IN `_id` INT)  UPDATE usuarios SET nombre = _nombre, identificacion = _identificacion, password = _password, id_perfil = _id_perfil, fecha_modificacion = _fecha_mod, estado = _estado WHERE id = _id$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `actividades`
--

DROP TABLE IF EXISTS `actividades`;
CREATE TABLE IF NOT EXISTS `actividades` (
  `id` int NOT NULL AUTO_INCREMENT,
  `descripcion` varchar(200) COLLATE utf8_spanish_ci NOT NULL,
  `id_user` int NOT NULL,
  `estado` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb3 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `actividades`
--

INSERT INTO `actividades` (`id`, `descripcion`, `id_user`, `estado`) VALUES
(1, 'Desarrollo de calendario', 1, 1),
(2, 'Desarrollo de Interface', 1, 1),
(3, 'Implementacion Interface', 1, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `actividadtiempos`
--

DROP TABLE IF EXISTS `actividadtiempos`;
CREATE TABLE IF NOT EXISTS `actividadtiempos` (
  `id` int NOT NULL AUTO_INCREMENT,
  `id_actividad` int NOT NULL,
  `fecha` date DEFAULT NULL,
  `horas` int DEFAULT NULL,
  `estado` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_Tiempo_Actividad` (`id_actividad`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb3 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `actividadtiempos`
--

INSERT INTO `actividadtiempos` (`id`, `id_actividad`, `fecha`, `horas`, `estado`) VALUES
(5, 1, '2022-02-24', 1, 0),
(6, 1, '2022-02-01', 3, 1),
(7, 1, '2022-03-01', 2, 1),
(8, 2, '2022-03-02', 1, 1),
(11, 1, '2022-03-15', 3, 0),
(12, 1, '2022-03-15', 3, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `perfiles`
--

DROP TABLE IF EXISTS `perfiles`;
CREATE TABLE IF NOT EXISTS `perfiles` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nombre` varchar(100) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb3 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `perfiles`
--

INSERT INTO `perfiles` (`id`, `nombre`) VALUES
(1, 'Administrador'),
(2, 'Empleado');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

DROP TABLE IF EXISTS `usuarios`;
CREATE TABLE IF NOT EXISTS `usuarios` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nombre` varchar(200) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `identificacion` varchar(20) COLLATE utf8_spanish_ci NOT NULL,
  `password` varchar(200) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `id_perfil` int NOT NULL,
  `fecha_creacion` date NOT NULL,
  `fecha_modificacion` date DEFAULT NULL,
  `estado` tinyint NOT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_idUsuario_idPerfil` (`id_perfil`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb3 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id`, `nombre`, `identificacion`, `password`, `id_perfil`, `fecha_creacion`, `fecha_modificacion`, `estado`) VALUES
(1, 'Admin', '1128432446', 'Admin1234', 1, '2022-03-01', NULL, 1),
(6, 'Empleado2', '1128432448', 'Empleado1234', 2, '2022-03-14', NULL, 1),
(7, 'Empleado1', '1128432447', 'Empleado1234', 2, '2022-03-14', NULL, 1);

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `actividadtiempos`
--
ALTER TABLE `actividadtiempos`
  ADD CONSTRAINT `FK_Tiempo_Actividad` FOREIGN KEY (`id_actividad`) REFERENCES `actividades` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Filtros para la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD CONSTRAINT `FK_idUsuario_idPerfil` FOREIGN KEY (`id_perfil`) REFERENCES `perfiles` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
