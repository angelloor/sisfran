-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost:8889
-- Tiempo de generación: 05-11-2024 a las 19:15:27
-- Versión del servidor: 5.7.44
-- Versión de PHP: 8.2.20

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = '-05:00';


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `sisfran`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `activo`
--

CREATE TABLE `activo` (
  `ID_ACTIVO` int(11) NOT NULL,
  `CATEGORIA_ID` int(11) DEFAULT NULL,
  `MARCA_ID` int(11) DEFAULT NULL,
  `ESTADO_ID` int(11) DEFAULT NULL,
  `COLOR_ID` int(11) DEFAULT NULL,
  `CARACTERISTICA` varchar(255) DEFAULT NULL,
  `BODEGA_ID` int(11) DEFAULT NULL,
  `CODIGO` int(11) DEFAULT NULL,
  `NOMBRE_ACTIVO` varchar(100) DEFAULT NULL,
  `MODELO` varchar(100) DEFAULT NULL,
  `SERIE` varchar(100) DEFAULT NULL,
  `UBICACION_INGRESO` varchar(100) DEFAULT NULL,
  `FECHA_INGRESO` date DEFAULT NULL,
  `VALOR_COMPRA` float DEFAULT NULL,
  `COMENTARIO` varchar(255) DEFAULT NULL,
  `COMPROBACION_INVENTARIO` varchar(10) NOT NULL,
  `HISTORICO` int(11) DEFAULT '1',
  `FECHA_HISTORICO` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `activo`
--

INSERT INTO `activo` (`ID_ACTIVO`, `CATEGORIA_ID`, `MARCA_ID`, `ESTADO_ID`, `COLOR_ID`, `CARACTERISTICA`, `BODEGA_ID`, `CODIGO`, `NOMBRE_ACTIVO`, `MODELO`, `SERIE`, `UBICACION_INGRESO`, `FECHA_INGRESO`, `VALOR_COMPRA`, `COMENTARIO`, `COMPROBACION_INVENTARIO`, `HISTORICO`, `FECHA_HISTORICO`) VALUES
(1, 1, 76, 1, 21, 'S/C', 1, 1210801010, 'IMPRESORA TERMICA', 'S/N', 'S/N', 'STO DOMINGO ENC', '2019-04-11', 0, '', 'NO', 1, '0000-00-00'),
(2, 1, 76, 1, 21, 'S/C', 1, 1210801010, 'IMPRESORA TERMICA', 'S/N', 'S/N', 'T. MACAS', '2019-06-10', 0, '', 'NO', 1, '0000-00-00'),
(3, 1, 76, 1, 21, 'S/C', 1, 1210801031, 'COMPUTADOR DE ESCRITORIO 9NA GENERACION', 'S/N', 'S/N', 'DURAN', '2020-10-20', 0, '', 'NO', 1, '0000-00-00'),
(4, 1, 76, 1, 21, 'S/C', 1, 1210801032, 'IMPRESORA TERMICA SD EPSON TM-T88V-834', 'S/N', 'S/N', 'DURAN', '2020-10-20', 0, '', 'NO', 1, '0000-00-00'),
(5, 1, 76, 1, 21, 'S/C', 1, 1210801033, 'UPS APC BE85M2-LM', 'S/N', 'S/N', 'DURAN', '2020-10-20', 0, '', 'NO', 1, '0000-00-00'),
(6, 1, 76, 1, 21, 'S/C', 1, 1210801033, 'UPS APC BE850M2-LM STAND BYE 120V 9 TOMA', 'S/N', 'S/N', 'DURAN', '2020-10-20', 0, '', 'NO', 1, '0000-00-00'),
(7, 1, 76, 1, 21, 'S/C', 1, 1210801001, 'MONITOR 19 PULGADAS', 'S/N', 'S/N', 'ADMINISTRACION', '2006-09-08', 125, '', 'NO', 1, '0000-00-00'),
(8, 1, 76, 1, 21, 'S/C', 1, 1210801002, 'CPU CORE I3', 'S/N', 'S/N', 'AMBATO SUR', '2008-01-28', 323.12, '', 'NO', 1, '0000-00-00'),
(9, 1, 76, 1, 21, 'S/C', 1, 1210801003, 'IMPRESORA MATRICIAL', 'S/N', 'S/N', 'T. COCA', '2008-03-03', 0, '', 'NO', 1, '0000-00-00'),
(10, 1, 76, 1, 21, 'S/C', 1, 1210801003, 'IMPRESORA MATRICIAL', 'S/N', 'S/N', 'ADMINISTRACION', '2008-03-03', 370, '', 'NO', 1, '0000-00-00'),
(11, 1, 76, 1, 21, 'S/C', 1, 1210801014, 'UPS REGULADOR', 'S/N', 'S/N', 'T. GUAYAQUIL', '2008-06-21', 61, '', 'NO', 1, '0000-00-00'),
(12, 1, 76, 1, 21, 'S/C', 1, 1210801005, 'CPU INTEL CORE I3', 'S/N', 'S/N', 'T. ZAMORA', '2008-08-25', 615, '', 'NO', 1, '0000-00-00'),
(13, 1, 76, 1, 21, 'S/C', 1, 1210801006, 'REGULADOR DE VOLTAJE', 'S/N', 'S/N', 'T. RIOBAMBA', '2008-08-25', 40, '', 'NO', 1, '0000-00-00'),
(14, 1, 76, 1, 21, 'S/C', 1, 1210801006, 'REGULADOR DE VOLTAJE', 'S/N', 'S/N', 'YANTZAZA', '2008-08-25', 40, '', 'NO', 1, '0000-00-00'),
(15, 1, 76, 1, 21, 'S/C', 1, 1210801014, 'UPS REGULADOR', 'S/N', 'S/N', 'O. BAÑOS', '2008-08-25', 40, '', 'NO', 1, '0000-00-00'),
(16, 1, 76, 1, 21, 'S/C', 1, 1210801014, 'UPS REGULADOR', 'S/N', 'S/N', 'O. ATACAMES', '2008-08-25', 40, '', 'NO', 1, '0000-00-00'),
(17, 1, 76, 1, 21, 'S/C', 1, 1210801003, 'IMPRESORA MATRICIAL', 'S/N', 'S/N', 'O. ATACAMES', '2010-07-27', 386, '', 'NO', 1, '0000-00-00'),
(18, 1, 76, 1, 21, 'S/C', 1, 1210801003, 'IMPRESORA MATRICIAL', 'S/N', 'S/N', 'T. RIOBAMBA', '2010-07-27', 386, '', 'NO', 1, '0000-00-00'),
(19, 1, 76, 1, 21, 'S/C', 1, 1210801014, 'UPS REGULADOR', 'S/N', 'S/N', 'AMBATO SUR', '2011-02-09', 0, '', 'NO', 1, '0000-00-00'),
(20, 1, 76, 1, 21, 'S/C', 1, 1210801002, 'CPU CORE I3', 'S/N', 'S/N', 'O. BAÑOS', '2011-06-10', 414.84, '', 'NO', 1, '0000-00-00'),
(21, 1, 76, 1, 21, 'S/C', 1, 1210801001, 'MONITOR 19 PULGADAS', 'S/N', 'S/N', 'T.AMBATOENC', '2011-09-09', 128, '', 'NO', 1, '0000-00-00'),
(22, 1, 76, 1, 21, 'S/C', 1, 1210801005, 'CPU INTEL CORE I3', 'S/N', 'S/N', 'O. ATACAMES', '2011-12-06', 602.51, '', 'NO', 1, '0000-00-00'),
(23, 1, 76, 1, 21, 'S/C', 1, 1210801007, 'CPU INTEL CORE I3 7100', 'S/N', 'S/N', 'T. TENA', '2012-02-08', 379.22, '', 'NO', 1, '0000-00-00'),
(24, 1, 76, 1, 21, 'S/C', 1, 1210801001, 'MONITOR 19 PULGADAS', 'S/N', 'S/N', 'T. COCA', '2012-05-16', 150.71, '', 'NO', 1, '0000-00-00'),
(25, 1, 76, 1, 21, 'S/C', 1, 1210801014, 'UPS REGULADOR', 'S/N', 'S/N', 'T.SUCUA', '2012-05-16', 42, '', 'NO', 1, '0000-00-00'),
(26, 1, 76, 1, 21, 'S/C', 1, 1210801008, 'LAPTOP CORE I3 TOSHIBA', 'S/N', 'S/N', 'ADMINISTRACION', '2012-07-05', 897.79, '', 'NO', 1, '0000-00-00'),
(27, 1, 76, 1, 21, 'S/C', 1, 1210801014, 'UPS REGULADOR', 'S/N', 'S/N', 'T. TENA', '2012-10-13', 86.56, '', 'NO', 1, '0000-00-00'),
(28, 1, 76, 1, 21, 'S/C', 1, 1210801009, 'CISCO SMALL BUSINESS', 'S/N', 'S/N', 'ADMINISTRACION', '2012-12-12', 0, '', 'NO', 1, '0000-00-00'),
(29, 1, 76, 1, 21, 'S/C', 1, 1210801002, 'CPU CORE I3', 'S/N', 'S/N', 'T. RIOBAMBA', '2012-12-12', 0, '', 'NO', 1, '0000-00-00'),
(30, 1, 76, 1, 21, 'S/C', 1, 1210801010, 'IMPRESORA TERMICA', 'S/N', 'S/N', 'T. SUCUA', '2012-12-12', 0, '', 'NO', 1, '0000-00-00'),
(31, 1, 76, 1, 21, 'S/C', 1, 1210801011, 'IMPRESORA TE TICKETS', 'S/N', 'S/N', 'ADMINISTRACION', '2012-12-12', 0, '', 'NO', 1, '0000-00-00'),
(32, 1, 76, 1, 21, 'S/C', 1, 1210801001, 'MONITOR 19 PULGADAS', 'S/N', 'S/N', 'QUI.CENTRO', '2012-12-12', 0, '', 'NO', 1, '0000-00-00'),
(33, 1, 76, 1, 21, 'S/C', 1, 1210801006, 'REGULADOR DE VOLTAJE EQUIPOS DE ASAMBLEA', 'S/N', 'S/N', 'ADMINISTRACION', '2012-12-12', 0, '', 'NO', 1, '0000-00-00'),
(34, 1, 76, 1, 21, 'S/C', 1, 1210801012, 'MODEM-ROUTER', 'S/N', 'S/N', 'O. SHELL', '2012-12-12', 0, '', 'NO', 1, '0000-00-00'),
(35, 1, 76, 1, 21, 'S/C', 1, 1210801013, 'ROUTER', 'S/N', 'S/N', 'ADMINISTRACION', '2012-12-12', 1.25, '', 'NO', 1, '0000-00-00'),
(36, 1, 76, 1, 21, 'S/C', 1, 1210801013, 'ROUTER', 'S/N', 'S/N', 'ADMINISTRACION', '2012-12-12', 0, '', 'NO', 1, '0000-00-00'),
(37, 1, 76, 1, 21, 'S/C', 1, 1210801013, 'ROUTER', 'S/N', 'S/N', 'ADMINISTRACION', '2012-12-12', 0, '', 'NO', 1, '0000-00-00'),
(38, 1, 76, 1, 21, 'S/C', 1, 1210801013, 'ROUTER', 'S/N', 'S/N', 'ADMINISTRACION', '2012-12-12', 0, '', 'NO', 1, '0000-00-00'),
(39, 1, 76, 1, 21, 'S/C', 1, 1210801014, 'UPS REGULADOR', 'S/N', 'S/N', 'QUI.CENTRO', '2012-12-12', 0, '', 'NO', 1, '0000-00-00'),
(40, 1, 76, 1, 21, 'S/C', 1, 1210801014, 'UPS REGULADOR', 'S/N', 'S/N', 'ADMINISTRACION', '2012-12-12', 60, '', 'NO', 1, '0000-00-00'),
(41, 1, 76, 1, 21, 'S/C', 1, 1210801005, 'CPU INTEL CORE I3', 'S/N', 'S/N', 'T. COCA', '2012-12-13', 398.72, '', 'NO', 1, '0000-00-00'),
(42, 1, 76, 1, 21, 'S/C', 1, 1210801014, 'UPS REGULADOR', 'S/N', 'S/N', 'T.AMBATOENC', '2013-03-03', 78.67, '', 'NO', 1, '0000-00-00'),
(43, 1, 76, 1, 21, 'S/C', 1, 1210801003, 'IMPRESORA MATRICIAL', 'S/N', 'S/N', 'T. COCA', '2013-03-07', 409.2, '', 'NO', 1, '0000-00-00'),
(44, 1, 76, 1, 21, 'S/C', 1, 1210801003, 'IMPRESORA MATRICIAL', 'S/N', 'S/N', 'O. MARISCAL', '2013-04-23', 0, '', 'NO', 1, '0000-00-00'),
(45, 1, 76, 1, 21, 'S/C', 1, 1210801001, 'MONITOR 19 PULGADAS', 'S/N', 'S/N', 'O. ATACAMES', '2013-08-22', 138.96, '', 'NO', 1, '0000-00-00'),
(46, 1, 76, 1, 21, 'S/C', 1, 1210801014, 'APC', 'S/N', 'S/N', 'ADMINISTRACION', '2013-09-20', 77.08, '', 'NO', 1, '0000-00-00'),
(47, 1, 76, 1, 21, 'S/C', 1, 1210801015, 'COPIADORA', 'S/N', 'S/N', 'T.LAGO AGRIO', '2013-09-24', 242.24, '', 'NO', 1, '0000-00-00'),
(48, 1, 76, 1, 21, 'S/C', 1, 1210801014, 'UPS REGULADOR', 'S/N', 'S/N', 'O. SHELL', '2013-10-24', 77.08, '', 'NO', 1, '0000-00-00'),
(49, 1, 76, 1, 21, 'S/C', 1, 1210801014, 'UPS REGULADOR', 'S/N', 'S/N', 'C.MACAS', '2013-12-16', 73.41, '', 'NO', 1, '0000-00-00'),
(50, 1, 76, 1, 21, 'S/C', 1, 1210801014, 'UPS REGULADOR', 'S/N', 'S/N', 'ADMINISTRACION', '2014-02-05', 4.5, '', 'NO', 1, '0000-00-00'),
(51, 1, 76, 1, 21, 'S/C', 1, 1210801002, 'CPU CORE I3', 'S/N', 'S/N', 'T.GUAYAQUIL', '2014-02-25', 364.29, '', 'NO', 1, '0000-00-00'),
(52, 1, 76, 1, 21, 'S/C', 1, 1210801001, 'MONITOR 19 PULGADAS', 'S/N', 'S/N', 'T. GUAYAQUIL', '2014-02-25', 364.29, '', 'NO', 1, '0000-00-00'),
(53, 1, 76, 1, 21, 'S/C', 1, 1210801001, 'MONITOR 19 PULGADAS', 'S/N', 'S/N', 'T. TENA', '2014-05-05', 155.05, '', 'NO', 1, '0000-00-00'),
(54, 1, 76, 1, 21, 'S/C', 1, 1210801002, 'CPU CORE I3', 'S/N', 'S/N', 'O. SHELL', '2014-05-13', 380.23, '', 'NO', 1, '0000-00-00'),
(55, 1, 76, 1, 21, 'S/C', 1, 1210801001, 'MONITOR 19 PULGADAS', 'S/N', 'S/N', 'ADMINISTRACION', '2014-05-21', 116.07, '', 'NO', 1, '0000-00-00'),
(56, 1, 76, 1, 21, 'S/C', 1, 1210801016, 'SERVIDOR', 'S/N', 'S/N', 'ADMINISTRACION', '2014-05-30', 3192, '', 'NO', 1, '0000-00-00'),
(57, 1, 76, 1, 21, 'S/C', 1, 1210801014, 'UPS REGULADOR', 'S/N', 'S/N', 'QUI.CARCELEN', '2014-05-31', 1075.2, '', 'NO', 1, '0000-00-00'),
(58, 1, 76, 1, 21, 'S/C', 1, 1210801014, 'UPS', 'S/N', 'S/N', 'ADMINISTRACION', '2014-06-06', 71, '', 'NO', 1, '0000-00-00'),
(59, 1, 76, 1, 21, 'S/C', 1, 1210801005, 'CPU INTEL CORE I3', 'S/N', 'S/N', 'T. QUITO', '2014-07-06', 535, '', 'NO', 1, '0000-00-00'),
(60, 1, 76, 1, 21, 'S/C', 1, 1210801005, 'CPU INTEL CORE I3', 'S/N', 'S/N', 'T. SUCUA', '2014-07-06', 535, '', 'NO', 1, '0000-00-00'),
(61, 1, 76, 1, 21, 'S/C', 1, 1210801017, 'CPU INTEL CORE I3 4130', 'S/N', 'S/N', 'ENC.QUITO', '2014-07-22', 470.4, '', 'NO', 1, '0000-00-00'),
(62, 1, 76, 1, 21, 'S/C', 1, 1210801005, 'CPU INTEL CORE I3', 'S/N', 'S/N', 'QUI.CENTRO', '2014-07-22', 470.4, '', 'NO', 1, '0000-00-00'),
(63, 1, 76, 1, 21, 'S/C', 1, 1210801017, 'CPU CORE I3 4130', 'S/N', 'S/N', 'ADMINISTRACION', '2014-07-22', 470.4, '', 'NO', 1, '0000-00-00'),
(64, 1, 76, 1, 21, 'S/C', 1, 1210801001, 'MONITOR 19 PULGADAS', 'S/N', 'S/N', 'T. ZAMORA', '2014-07-22', 118.73, '', 'NO', 1, '0000-00-00'),
(65, 1, 76, 1, 21, 'S/C', 1, 1210801018, 'MONITOR LG 19 PULGADAS', 'S/N', 'S/N', 'O STO DOMINGO', '2014-07-22', 106, '', 'NO', 1, '0000-00-00'),
(66, 1, 76, 1, 21, 'S/C', 1, 1210801018, 'MONITOR LG 19 PULGADAS', 'S/N', 'S/N', 'ADMINISTRACION', '2014-07-22', 118.73, '', 'NO', 1, '0000-00-00'),
(67, 1, 76, 1, 21, 'S/C', 1, 1210801001, 'MONITOR 19 PULGADAS', 'S/N', 'S/N', 'T. RIOBAMBA', '2014-07-22', 108, '', 'NO', 1, '0000-00-00'),
(68, 1, 76, 1, 21, 'S/C', 1, 1210801014, 'UPS REGULADOR', 'S/N', 'S/N', 'ADMINISTRACION', '2014-07-22', 76.16, '', 'NO', 1, '0000-00-00'),
(69, 1, 76, 1, 21, 'S/C', 1, 1210801014, 'UPS REGULADOR', 'S/N', 'S/N', 'T. MACAS', '2014-07-22', 76.16, '', 'NO', 1, '0000-00-00'),
(70, 1, 76, 1, 21, 'S/C', 1, 1210801018, 'MONITOR LG', 'S/N', 'S/N', 'STO DOMINGO ENC', '2014-07-22', 106, '', 'NO', 1, '0000-00-00'),
(71, 1, 76, 1, 21, 'S/C', 1, 1210801001, 'MONITOR 19 PULGADAS', 'S/N', 'S/N', 'STO DOMINGO ENC', '2014-07-22', 0, '', 'NO', 1, '0000-00-00'),
(72, 1, 76, 1, 21, 'S/C', 1, 1210801001, 'MONITOR 19 PULGADAS', 'S/N', 'S/N', 'O. MARISCAL', '2014-09-03', 120.96, '', 'NO', 1, '0000-00-00'),
(73, 1, 76, 1, 21, 'S/C', 1, 1210801001, 'MONITOR 19 PULGADAS', 'S/N', 'S/N', 'ENC.QUITO', '2014-09-03', 120.96, '', 'NO', 1, '0000-00-00'),
(74, 1, 76, 1, 21, 'S/C', 1, 1210801005, 'CPU INTEL CORE I3', 'S/N', 'S/N', 'QUI.CARCELEN', '2014-11-18', 498.4, '', 'NO', 1, '0000-00-00'),
(75, 1, 76, 1, 21, 'S/C', 1, 1210801014, 'UPS REGULADOR', 'S/N', 'S/N', 'ADMINISTRACION', '2014-12-27', 81, '', 'NO', 1, '0000-00-00'),
(76, 1, 76, 1, 21, 'S/C', 1, 1210801020, 'SISTEMA DE FACTURACION ELECTRONICA', 'S/N', 'S/N', 'ADMINISTRACION', '2015-01-19', 2239.28, '', 'NO', 1, '0000-00-00'),
(77, 1, 76, 1, 21, 'S/C', 1, 1210801006, 'REGULADOR DE VOLTAJE', 'S/N', 'S/N', 'T. RIOBAMBA', '2015-01-22', 1.25, '', 'NO', 1, '0000-00-00'),
(78, 1, 76, 1, 21, 'S/C', 1, 1210801012, 'MODEN ROUTER', 'S/N', 'S/N', 'T. TENA', '2015-04-15', 83.28, '', 'NO', 1, '0000-00-00'),
(79, 1, 76, 1, 21, 'S/C', 1, 1210801018, 'MONITOR LG 19 PULGADAS', 'S/N', 'S/N', 'ADMINISTRACION', '2015-05-21', 21.66, '', 'NO', 1, '0000-00-00'),
(80, 1, 76, 1, 21, 'S/C', 1, 1210801021, 'IMPRESORA MULTIFUNCION', 'S/N', 'S/N', 'ADMINISTRACION', '2015-07-21', 75.06, '', 'NO', 1, '0000-00-00'),
(81, 1, 76, 1, 21, 'S/C', 1, 1210801022, 'PROCESADOR', 'S/N', 'S/N', 'ADMINISTRACION', '2015-08-10', 116.66, '', 'NO', 1, '0000-00-00'),
(82, 1, 76, 1, 21, 'S/C', 1, 1210801023, 'ROUTER CISCO', 'S/N', 'S/N', 'T. PUYO', '2015-08-12', 47.63, '', 'NO', 1, '0000-00-00'),
(83, 1, 76, 1, 21, 'S/C', 1, 1210801024, 'ENFRIADOR DE MODEM', 'S/N', 'S/N', 'T. PUYO', '2015-08-12', 45.5, '', 'NO', 1, '0000-00-00'),
(84, 1, 76, 1, 21, 'S/C', 1, 1210801010, 'IMPRESORA TERMICA', 'S/N', 'S/N', 'T. GUAYAQUIL', '2015-10-12', 463.5, '', 'NO', 1, '0000-00-00'),
(85, 1, 76, 1, 21, 'S/C', 1, 1210801010, 'IMPRESORA TERMICA', 'S/N', 'S/N', 'T. PUYO', '2015-11-18', 140.56, '', 'NO', 1, '0000-00-00'),
(86, 1, 76, 1, 21, 'S/C', 1, 1210801001, 'MONITOR 19 PULGADAS', 'S/N', 'S/N', 'O. SHELL', '2015-11-18', 43.65, '', 'NO', 1, '0000-00-00'),
(87, 1, 76, 1, 21, 'S/C', 1, 1210801025, 'SOFWARE SISTEMA DE BOLETOS Y ENCOMIENDAS', 'S/N', 'S/N', 'ADMINISTRACION', '2015-12-31', 6175.59, '', 'NO', 1, '0000-00-00'),
(88, 1, 76, 1, 21, 'S/C', 1, 1210801010, 'IMPRESORA TERMICA', 'S/N', 'S/N', 'O. BAÑOS', '2016-01-18', 166.11, '', 'NO', 1, '0000-00-00'),
(89, 1, 76, 1, 21, 'S/C', 1, 1210801010, 'IMPRESORA TERMICA', 'S/N', 'S/N', 'O. SHELL', '2016-01-18', 166.11, '', 'NO', 1, '0000-00-00'),
(90, 1, 76, 1, 21, 'S/C', 1, 1210801014, 'UPS REGULADOR', 'S/N', 'S/N', 'T. ZAMORA', '2016-01-18', 26.43, '', 'NO', 1, '0000-00-00'),
(91, 1, 76, 1, 21, 'S/C', 1, 1210801014, 'UPS REGULADOR', 'S/N', 'S/N', 'ADMINISTRACION', '2016-02-04', 198.6, '', 'NO', 1, '0000-00-00'),
(92, 1, 76, 1, 21, 'S/C', 1, 1210801018, 'MONITOR DE 19 PULGADAS LG', 'S/N', 'S/N', 'GUALAQUIZA', '2016-02-24', 47.59, '', 'NO', 1, '0000-00-00'),
(93, 1, 76, 1, 21, 'S/C', 1, 1210801010, 'IMPRESORA TERMICA', 'S/N', 'S/N', 'GUALAQUIZA', '2016-04-11', 191.55, '', 'NO', 1, '0000-00-00'),
(94, 1, 76, 1, 21, 'S/C', 1, 1210801014, 'UPS - APC', 'S/N', 'S/N', 'ADMINISTRACION', '2016-05-11', 33.72, '', 'NO', 1, '0000-00-00'),
(95, 1, 76, 1, 21, 'S/C', 1, 1210801001, 'MONITOR 19 PULGADAS', 'S/N', 'S/N', 'T. GUAYAQUIL', '2016-05-17', 67.05, '', 'NO', 1, '0000-00-00'),
(96, 1, 76, 1, 21, 'S/C', 1, 1210801001, 'MONITOR 19 PULGADAS', 'S/N', 'S/N', 'C.MACAS', '2016-08-09', 71.75, '', 'NO', 1, '0000-00-00'),
(97, 1, 76, 1, 21, 'S/C', 1, 1210801001, 'MONITOR 19 PULGADAS', 'S/N', 'S/N', 'AMBATO SUR', '2016-10-19', 79.44, '', 'NO', 1, '0000-00-00'),
(98, 1, 76, 1, 21, 'S/C', 1, 1210801010, 'IMPRESORA TERMICA', 'S/N', 'S/N', 'T. QUITO', '2017-02-10', 121.61, '', 'NO', 1, '0000-00-00'),
(99, 1, 76, 1, 21, 'S/C', 1, 1210801026, 'CPU I3 8100 ENSAMBLADO', 'S/N', 'S/N', 'T. MACAS', '2017-02-22', 614.42, '', 'NO', 1, '0000-00-00'),
(100, 1, 76, 1, 21, 'S/C', 1, 1210801026, 'CPU INTEL CORE I3 8100', 'S/N', 'S/N', 'T. MACAS', '2017-02-22', 443.45, '', 'NO', 1, '0000-00-00'),
(101, 1, 76, 1, 21, 'S/C', 1, 1210801018, 'MONITOR 19 PULGADAS LG', 'S/N', 'S/N', 'T. MACAS', '2017-02-22', 99.13, '', 'NO', 1, '0000-00-00'),
(102, 1, 76, 1, 21, 'S/C', 1, 1210801017, 'CPU INTEL CORE I3 4130', 'S/N', 'S/N', 'ADMINISTRACION', '2017-03-13', 0, '', 'NO', 1, '0000-00-00'),
(103, 1, 76, 1, 21, 'S/C', 1, 1210801002, 'CPU CORE I3', 'S/N', 'S/N', 'AMBATO', '2017-03-13', 460.82, '', 'NO', 1, '0000-00-00'),
(104, 1, 76, 1, 21, 'S/C', 1, 1210801014, 'UPS REGULADOR', 'S/N', 'S/N', 'T. QUITO', '2017-03-13', 58.49, '', 'NO', 1, '0000-00-00'),
(105, 1, 76, 1, 21, 'S/C', 1, 1210801027, 'CPU CORE I3 6100', 'S/N', 'S/N', 'ADMINISTRACION', '2017-04-17', 477.88, '', 'NO', 1, '0000-00-00'),
(106, 1, 76, 1, 21, 'S/C', 1, 1210801010, 'IMPRESORA TERMICA', 'S/N', 'S/N', 'QUI.CENTRO', '2017-04-17', 60.67, '', 'NO', 1, '0000-00-00'),
(107, 1, 76, 1, 21, 'S/C', 1, 1210801001, 'MONITOR 19 PULGADAS', 'S/N', 'S/N', 'T.SUCUA', '2017-04-17', 102.33, '', 'NO', 1, '0000-00-00'),
(108, 1, 76, 1, 21, 'S/C', 1, 1210801006, 'REGULADOR DE VOLTAJE', 'S/N', 'S/N', 'QUI.CENTRO', '2017-04-17', 60.67, '', 'NO', 1, '0000-00-00'),
(109, 1, 76, 1, 21, 'S/C', 1, 1210801028, 'PROYECTOR', 'S/N', 'S/N', 'ADMINISTRACION', '2017-05-08', 665.61, '', 'NO', 1, '0000-00-00'),
(110, 1, 76, 1, 21, 'S/C', 1, 1210801014, 'UPS REGULADOR', 'S/N', 'S/N', 'MARISCAL', '2017-06-06', 64, '', 'NO', 1, '0000-00-00'),
(111, 1, 76, 1, 21, 'S/C', 1, 1210801001, 'MONITOR 19 PULGADAS', 'S/N', 'S/N', 'T. MACAS ', '2017-06-07', 140, '', 'NO', 1, '0000-00-00'),
(112, 1, 76, 1, 21, 'S/C', 1, 1210801006, 'REGULADOR DE VOLTAJE', 'S/N', 'S/N', 'T.LAGO AGRIO', '2017-06-07', 64, '', 'NO', 1, '0000-00-00'),
(113, 1, 76, 1, 21, 'S/C', 1, 1210801014, 'UPS APC', 'S/N', 'S/N', 'T. MACAS', '2017-06-07', 79.46, '', 'NO', 1, '0000-00-00'),
(114, 1, 76, 1, 21, 'S/C', 1, 1210801010, 'IMPRESORA TERMICA', 'S/N', 'S/N', 'T. TENA', '2017-06-09', 290, '', 'NO', 1, '0000-00-00'),
(115, 1, 76, 1, 21, 'S/C', 1, 1210801005, 'CPU INTEL CORE I3', 'S/N', 'S/N', 'O. SHELL', '2017-07-07', 519.68, '', 'NO', 1, '0000-00-00'),
(116, 1, 76, 1, 21, 'S/C', 1, 1210801001, 'MONITOR 19 PULGADAS', 'S/N', 'S/N', 'T. QUITO', '2017-07-07', 116.66, '', 'NO', 1, '0000-00-00'),
(117, 1, 76, 1, 21, 'S/C', 1, 1210801010, 'IMPRESORA TERMICA', 'S/N', 'S/N', 'QUI.CENTRO', '2017-07-14', 305.69, '', 'NO', 1, '0000-00-00'),
(118, 1, 76, 1, 21, 'S/C', 1, 1210801002, 'CPU CORE I3', 'S/N', 'S/N', 'ADMINISTRACION', '2017-07-22', 512.02, '', 'NO', 1, '0000-00-00'),
(119, 1, 76, 1, 21, 'S/C', 1, 1210801001, 'MONITOR 19 PULGADAS', 'S/N', 'S/N', 'T. PUYO', '2017-07-22', 117.07, '', 'NO', 1, '0000-00-00'),
(120, 1, 76, 1, 21, 'S/C', 1, 1210801014, 'UPS REGULADOR', 'S/N', 'S/N', 'T. MACAS', '2017-07-22', 67.17, '', 'NO', 1, '0000-00-00'),
(121, 1, 76, 1, 21, 'S/C', 1, 1210801029, 'NASK ALMACENAMIENTO INTERNO', 'S/N', 'S/N', 'ADMINISTRACION', '2017-08-03', 149.83, '', 'NO', 1, '0000-00-00'),
(122, 1, 76, 1, 21, 'S/C', 1, 1210801010, 'IMPRESORA TERMICA', 'S/N', 'S/N', 'C.MACAS', '2017-08-23', 302.22, '', 'NO', 1, '0000-00-00'),
(123, 1, 76, 1, 21, 'S/C', 1, 1210801014, 'UPS REGULADOR', 'S/N', 'S/N', 'ADMINISTRACION', '2017-09-05', 61.41, '', 'NO', 1, '0000-00-00'),
(124, 1, 76, 1, 21, 'S/C', 1, 1210801002, 'CPU CORE I3', 'S/N', 'S/N', 'C.MACAS', '2017-10-18', 231.65, '', 'NO', 1, '0000-00-00'),
(125, 1, 76, 1, 21, 'S/C', 1, 1210801018, 'MONITOR LG 19 PULGADAS', 'S/N', 'S/N', 'QUI.CARCELEN', '2017-10-18', 124.19, '', 'NO', 1, '0000-00-00'),
(126, 1, 76, 1, 21, 'S/C', 1, 1210801030, 'PUNNTERO LASER', 'S/N', 'S/N', 'ADMINISTRACION', '2017-10-18', 52.28, '', 'NO', 1, '0000-00-00'),
(127, 1, 76, 1, 21, 'S/C', 1, 1210801014, 'UPS REGULADOR', 'S/N', 'S/N', 'GUALAQUIZA', '2017-10-18', 37.95, '', 'NO', 1, '0000-00-00'),
(128, 1, 76, 1, 21, 'S/C', 1, 1210801010, 'IMPRESORA TERMICA', 'S/N', 'S/N', 'QUI.CARCELEN', '2017-11-12', 321.11, '', 'NO', 1, '0000-00-00'),
(129, 1, 76, 1, 21, 'S/C', 1, 1210801014, 'UPS REGULADOR', 'S/N', 'S/N', 'T. PUYO', '2018-01-12', 69.64, '', 'NO', 1, '0000-00-00'),
(130, 1, 76, 1, 21, 'S/C', 1, 1210801014, 'UPS REGULADOR', 'S/N', 'S/N', 'T. COCA', '2018-02-21', 69.64, '', 'NO', 1, '0000-00-00'),
(131, 1, 76, 1, 21, 'S/C', 1, 1210801027, 'CPU CORE I3 6100', 'S/N', 'S/N', 'GUALAQUIZA', '2018-03-21', 223, '', 'NO', 1, '0000-00-00'),
(132, 1, 76, 1, 21, 'S/C', 1, 1210801001, 'MONITOR 19 PULGADAS', 'S/N', 'S/N', 'ADMINISTRACION', '2018-03-21', 98.21, '', 'NO', 1, '0000-00-00'),
(133, 1, 76, 1, 21, 'S/C', 1, 1210801001, 'MONITOR 19 PULGADAS', 'S/N', 'S/N', 'ADMINISTRACION', '2018-04-18', 220, '', 'NO', 1, '0000-00-00'),
(134, 1, 76, 1, 21, 'S/C', 1, 1210801001, 'MONITOR 19 PULGADAS', 'S/N', 'S/N', 'O STO DOMINGO', '2018-04-25', 138, '', 'NO', 1, '0000-00-00'),
(135, 1, 76, 1, 21, 'S/C', 1, 1210801030, 'LICENCIAS DE WIMDOW 10-64 BITS', 'S/N', 'S/N', 'OFICINA CENTRAL', '2018-04-27', 6041.25, '', 'NO', 1, '0000-00-00'),
(136, 1, 76, 1, 21, 'S/C', 1, 1210801021, 'IMPRESORA MULTIFUNCION', 'S/N', 'S/N', 'ADMINISTRACION', '2018-06-18', 393, '', 'NO', 1, '0000-00-00'),
(137, 1, 76, 1, 21, 'S/C', 1, 1210801021, 'IMPRESORA MULTIFUNCIONAL', 'S/N', 'S/N', 'ADMINISTRACION', '2018-06-18', 393, '', 'NO', 1, '0000-00-00'),
(138, 1, 76, 1, 21, 'S/C', 1, 1210801001, 'MONITOR 19 PULGADAS', 'S/N', 'S/N', 'O. BAÑOS', '2018-06-21', 117, '', 'NO', 1, '0000-00-00'),
(139, 1, 76, 1, 21, 'S/C', 1, 1210801005, 'CPU INTEL CORE I3', 'S/N', 'S/N', 'ADMINISTRACION', '2018-08-25', 615, '', 'NO', 1, '0000-00-00'),
(140, 1, 76, 1, 21, 'S/C', 1, 1210801003, 'IMPRESORA MATRICIAL', 'S/N', 'S/N', 'QUI.CENTRO', '2018-08-25', 360, '', 'NO', 1, '0000-00-00'),
(141, 1, 76, 1, 21, 'S/C', 1, 1210801010, 'IMPRESORA TERMICA', 'S/N', 'S/N', 'T. ZAMORA', '2018-08-25', 398, '', 'NO', 1, '0000-00-00'),
(142, 1, 76, 1, 21, 'S/C', 1, 1210801018, 'MONITOR 19 PULGADAS LG', 'S/N', 'S/N', 'ADMINISTRACION', '2018-08-27', 98.21, '', 'NO', 1, '0000-00-00'),
(143, 1, 76, 1, 21, 'S/C', 1, 1210801026, 'CPU INTEL CORE I3 8100', 'S/N', 'S/N', 'ADMINISTRACION', '2018-08-29', 985, '', 'NO', 1, '0000-00-00'),
(144, 1, 76, 1, 21, 'S/C', 1, 1210801002, 'CPU CORE I3', 'S/N', 'S/N', 'T. PUYO', '2018-08-29', 985, '', 'NO', 1, '0000-00-00'),
(145, 1, 76, 1, 21, 'S/C', 1, 1210801010, 'IMPRESORA TERMICA', 'S/N', 'S/N', 'T. MACAS', '2018-08-31', 312, '', 'NO', 1, '0000-00-00'),
(146, 1, 76, 1, 21, 'S/C', 1, 1210801010, 'IMPRESORA TERMICA', 'S/N', 'S/N', 'T. PUYO', '2018-08-31', 312, '', 'NO', 1, '0000-00-00'),
(147, 1, 76, 1, 21, 'S/C', 1, 1210801002, 'CPU CORE I3', 'S/N', 'S/N', 'ADMINISTRACION', '2018-09-29', 985, '', 'NO', 1, '0000-00-00'),
(148, 1, 76, 1, 21, 'S/C', 1, 1210801021, 'IMPRESORA MULTIFUNCIONAL', 'S/N', 'S/N', 'ADMINISTRACION', '2018-11-28', 393, '', 'NO', 1, '0000-00-00'),
(149, 1, 76, 1, 21, 'S/C', 1, 1210801014, 'UPS REGULADOR', 'S/N', 'S/N', 'ADMINISTRACION', '2018-11-28', 60, '', 'NO', 1, '0000-00-00'),
(150, 1, 76, 1, 21, 'S/C', 1, 1210801014, 'UPS REGULADOR', 'S/N', 'S/N', 'Administración', '2018-12-03', 69, '', 'NO', 1, '0000-00-00'),
(151, 2, 76, 1, 21, 'S/C', 1, 1210401001, 'VITRINA NEGRA', 'S/N', 'S/N', 'ADMINISTRACION', '2005-06-06', 66.64, '', 'NO', 1, '0000-00-00'),
(152, 2, 76, 1, 21, 'S/C', 1, 1210401002, 'ARMARIO DE MADERA COLOR CAFÉ', 'S/N', 'S/N', 'ADMINISTRACION', '2005-06-15', 60, '', 'NO', 1, '0000-00-00'),
(153, 2, 76, 1, 21, 'S/C', 1, 1210401003, 'ARCHIVADOR METALICO COLOR NEGRO TRES CAJONES', 'S/N', 'S/N', 'ADMINISTRACION', '2005-12-09', 67.2, '', 'NO', 1, '0000-00-00'),
(154, 2, 76, 1, 21, 'S/C', 1, 1210401004, 'MESA MEDIANA NEGRA', 'S/N', 'S/N', 'T. QUITO', '2006-08-12', 110, '', 'NO', 1, '0000-00-00'),
(155, 2, 76, 1, 21, 'S/C', 1, 1210401005, 'MESA COLOR CAFE', 'S/N', 'S/N', 'ADMINISTRACION', '2007-06-14', 187.5, '', 'NO', 1, '0000-00-00'),
(156, 2, 76, 1, 21, 'S/C', 1, 1210401006, 'SILLA GIRATORIA', 'S/N', 'S/N', 'T. RIOBAMBA', '2007-06-22', 118, '', 'NO', 1, '0000-00-00'),
(157, 2, 76, 1, 21, 'S/C', 1, 1210401007, 'SILLA METALICA DE 4 ASIENTOS', 'S/N', 'S/N', 'C.MACAS', '2007-11-21', 94, '', 'NO', 1, '0000-00-00'),
(158, 2, 76, 1, 21, 'S/C', 1, 1210401008, 'ESCRITORIO METALICO 3 CAJONES', 'S/N', 'S/N', 'C.MACAS', '2009-02-05', 9.7, '', 'NO', 1, '0000-00-00'),
(159, 2, 76, 1, 21, 'S/C', 1, 1210401009, 'SILLA DE ESCRITORIO', 'S/N', 'S/N', 'C.MACAS', '2009-02-05', 0.75, '', 'NO', 1, '0000-00-00'),
(160, 2, 76, 1, 21, 'S/C', 1, 1210401010, 'ESCRITORIO  DE CARTON PRENSADO 3 CAJONES', 'S/N', 'S/N', 'C.MACAS', '2009-02-05', 79.89, '', 'NO', 1, '0000-00-00'),
(161, 2, 76, 1, 21, 'S/C', 1, 1210401011, 'ESCRITORIO PARA DOCUMENTOS COLOR NEGRO', 'S/N', 'S/N', 'ADMINISTRACION', '2009-06-02', 20.54, '', 'NO', 1, '0000-00-00'),
(162, 2, 76, 1, 21, 'S/C', 1, 1210401012, 'ESCRITORIO MADERA TRES CAJONES CAFE', 'S/N', 'S/N', 'ADMINISTRACION', '2009-06-02', 23, '', 'NO', 1, '0000-00-00'),
(163, 2, 76, 1, 21, 'S/C', 1, 1210401013, 'ESTANTE DE MADERA COLOR CAFE', 'S/N', 'S/N', 'ADMINISTRACION', '2009-07-01', 4, '', 'NO', 1, '0000-00-00'),
(164, 2, 76, 1, 21, 'S/C', 1, 1210401014, 'CAJONERA PEQUEÑA 3 CAJONES', 'S/N', 'S/N', 'T. QUITO', '2009-07-06', 11.25, '', 'NO', 1, '0000-00-00'),
(165, 2, 76, 1, 21, 'S/C', 1, 1210401015, 'SILLA GIRATORIA COLOR NEGRO', 'S/N', 'S/N', 'ADMINISTRACION', '2009-07-06', 118.99, '', 'NO', 1, '0000-00-00'),
(166, 2, 76, 1, 21, 'S/C', 1, 1210401016, 'PERCHA METALICA GRANDE', 'S/N', 'S/N', 'C.MACAS', '2009-11-06', 27.5, '', 'NO', 1, '0000-00-00'),
(167, 2, 76, 1, 21, 'S/C', 1, 1210401017, 'MUEBLE DE MADERA 4 PUERTAS', 'S/N', 'S/N', 'T.AMBATOENC', '2010-03-03', 31.42, '', 'NO', 1, '0000-00-00'),
(168, 2, 76, 1, 21, 'S/C', 1, 1210401018, 'ESCRITORIO', 'S/N', 'S/N', 'T. PUYO', '2010-08-12', 55.35, '', 'NO', 1, '0000-00-00'),
(169, 2, 76, 1, 21, 'S/C', 1, 1210401019, 'PERCHAS DE MADERA', 'S/N', 'S/N', 'PERCHA', '2010-08-12', 24.97, '', 'NO', 1, '0000-00-00'),
(170, 2, 76, 1, 21, 'S/C', 1, 1210401020, 'PERCHAS METALICAS', 'S/N', 'S/N', 'ADMINISTRACION', '2010-08-12', 24.97, '', 'NO', 1, '0000-00-00'),
(171, 2, 76, 1, 21, 'S/C', 1, 1210401021, 'PERCHAS METALICAS', 'S/N', 'S/N', 'ADMINISTRACION', '2010-08-12', 24.97, '', 'NO', 1, '0000-00-00'),
(172, 2, 76, 1, 21, 'S/C', 1, 1210401022, 'PERCHAS METALICAS', 'S/N', 'S/N', 'ADMINISTRACION', '2010-08-12', 24.97, '', 'NO', 1, '0000-00-00'),
(173, 2, 76, 1, 21, 'S/C', 1, 1210401023, 'PERCHAS METALICAS', 'S/N', 'S/N', 'ADMINISTRACION', '2010-08-12', 24.97, '', 'NO', 1, '0000-00-00'),
(174, 2, 76, 1, 21, 'S/C', 1, 1210401024, 'MUEBLE DE MADERA TIPO L', 'S/N', 'S/N', 'QUI.CENTRO', '2011-05-24', 296.25, '', 'NO', 1, '0000-00-00'),
(175, 2, 76, 1, 21, 'S/C', 1, 1210401025, 'SILLAS PARA RECEPCION DE CLIENTES COLOR', 'S/N', 'S/N', 'ADMINISTRACION', '2011-06-23', 50, '', 'NO', 1, '0000-00-00'),
(176, 2, 76, 1, 21, 'S/C', 1, 1210401137, 'SILLAS', 'S/N', 'S/N', 'O. ATACAMES', '2012-12-12', 0, '', 'NO', 1, '0000-00-00'),
(177, 2, 76, 1, 21, 'S/C', 1, 1210401222, 'ESPEJO CON ESTANTES PARA BAÑO', 'S/N', 'S/N', 'ADMINISTRACION', '2018-11-12', 0, '', 'NO', 1, '0000-00-00'),
(178, 2, 76, 1, 21, 'S/C', 1, 1210401229, 'CAJONERA DE 3 CAJONES', 'S/N', 'S/N', 'T. MACAS', '2018-12-12', 0, '', 'NO', 1, '0000-00-00'),
(179, 2, 76, 1, 21, 'S/C', 1, 1210401230, 'ESCRITORIO PARA COMPUTADORAS TRES CAJONES', 'S/N', 'S/N', 'ADMINISTRACION', '2018-12-12', 0, '', 'NO', 1, '0000-00-00'),
(180, 2, 76, 1, 21, 'S/C', 1, 1210601007, 'DVR/ CAMARAS DE SEGURIDAD MATRIZ', 'S/N', 'S/N', 'ADMINISTRACION', '2012-12-12', 0, '', 'NO', 1, '0000-00-00'),
(181, 2, 76, 1, 21, 'S/C', 1, 1210601001, 'TELEFONO CONVENCIONAL', 'S/N', 'S/N', 'T.COCA', '2004-12-16', 36.51, '', 'NO', 1, '0000-00-00'),
(182, 2, 76, 1, 21, 'S/C', 1, 1210601002, 'MUEBLE METALICO', 'S/N', 'S/N', 'T.AMBATOENC', '2005-06-06', 21.65, '', 'NO', 1, '0000-00-00'),
(183, 2, 76, 1, 21, 'S/C', 1, 1210601003, 'TELEFONO UNA BASE', 'S/N', 'S/N', 'T.RIOBAMBA', '2008-08-27', 2.32, '', 'NO', 1, '0000-00-00'),
(184, 2, 76, 1, 21, 'S/C', 1, 1210601004, 'REFRIGERADOR PEQUEÑO HACEB', 'S/N', 'S/N', 'T.COCA', '2009-04-09', 15, '', 'NO', 1, '0000-00-00'),
(185, 2, 76, 1, 21, 'S/C', 1, 1210601005, 'REFRIGERADORA INDURAMA', 'S/N', 'S/N', 'ADMINISTRACION', '2011-06-23', 205, '', 'NO', 1, '0000-00-00'),
(186, 2, 76, 1, 21, 'S/C', 1, 1210601006, 'REFRIGERADORA', 'S/N', 'S/N', 'T. GUAYAQUIL', '2011-06-23', 263.11, '', 'NO', 1, '0000-00-00');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `asistencia`
--

CREATE TABLE `asistencia` (
  `ID_ASISTENCIA` int(11) NOT NULL,
  `PERSONA_ID` int(11) NOT NULL,
  `OFICINA_ID` int(11) NOT NULL,
  `FECHA_E_ASISTENCIA` date NOT NULL,
  `FECHA_S_ASISTENCIA` date DEFAULT NULL,
  `HORA_E_ASISTENCIA` time NOT NULL,
  `HORA_S_ASISTENCIA` time DEFAULT NULL,
  `LATITUD_E_ASISTENCIA` varchar(100) NOT NULL,
  `LATITUD_S_ASISTENCIA` varchar(100) DEFAULT NULL,
  `LONGITUD_E_ASISTENCIA` varchar(100) NOT NULL,
  `LONGITUD_S_ASISTENCIA` varchar(100) DEFAULT NULL,
  `OBSERVACIONES_E_ASISTENCIA` varchar(250) DEFAULT NULL,
  `OBSERVACIONES_S_ASISTENCIA` varchar(250) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `bodega`
--

CREATE TABLE `bodega` (
  `ID_BODEGA` int(11) NOT NULL,
  `NOMBRE_BODEGA` varchar(100) DEFAULT NULL,
  `UBICACION` varchar(100) DEFAULT NULL,
  `RESPONSABLE_BODEGA` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `bodega`
--

INSERT INTO `bodega` (`ID_BODEGA`, `NOMBRE_BODEGA`, `UBICACION`, `RESPONSABLE_BODEGA`) VALUES
(1, 'BODEGA PRINCIPAL DE BIENES', 'OFICINA MATRIZ - PUYO', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cargo`
--

CREATE TABLE `cargo` (
  `ID_CARGO` int(11) NOT NULL,
  `NOMBRE_CARGO` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `cargo`
--

INSERT INTO `cargo` (`ID_CARGO`, `NOMBRE_CARGO`) VALUES
(1, 'OFICINISTA'),
(2, 'GERENTE'),
(3, 'PRESIDENTE'),
(4, 'ASISTENTE'),
(5, 'TÉCNICO');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categoria`
--

CREATE TABLE `categoria` (
  `ID_CATEGORIA` int(11) NOT NULL,
  `NOMBRE_CATEGORIA` varchar(100) NOT NULL,
  `DESCRIPCION_CATEGORIA` varchar(100) DEFAULT NULL,
  `PERSONA_ID` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `categoria`
--

INSERT INTO `categoria` (`ID_CATEGORIA`, `NOMBRE_CATEGORIA`, `DESCRIPCION_CATEGORIA`, `PERSONA_ID`) VALUES
(1, 'EQUIPO INFORMÁTICO', 'EQUIPOS ELECTRÓNICOS Y INFORMÁTICOS', 1),
(2, 'BIEN INMUEBLE', 'BIENES INMUEBLES', 2);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `color`
--

CREATE TABLE `color` (
  `ID_COLOR` int(11) NOT NULL,
  `NOMBRE_COLOR` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `color`
--

INSERT INTO `color` (`ID_COLOR`, `NOMBRE_COLOR`) VALUES
(1, 'AMARILLO'),
(2, 'AZUL'),
(3, 'BEIGE'),
(4, 'BICOLOR'),
(5, 'BLANCO'),
(6, 'BLANCO Y NEGRO'),
(7, 'CAFÉ'),
(8, 'CAOBA'),
(9, 'CELESTE'),
(10, 'CEREZO'),
(11, 'CREMA'),
(12, 'FLOREADO'),
(13, 'GRIS'),
(14, 'GRIS HIERRO'),
(15, 'HABANO'),
(16, 'HUESO CLARO'),
(17, 'MARFIL'),
(18, 'MARRÓN'),
(19, 'MIEL'),
(20, 'NEGRO'),
(21, 'NO APLICA'),
(22, 'PLATA'),
(23, 'PLOMO'),
(24, 'ROJO'),
(25, 'ROSADO'),
(26, 'TOMATE'),
(27, 'TRICOLOR'),
(28, 'TURQUESA'),
(29, 'VERDE'),
(30, 'VINO');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `entrega_recepcion`
--

CREATE TABLE `entrega_recepcion` (
  `ID_ENTREGA_RECEPCION` int(11) NOT NULL,
  `PERSONA_ID` int(11) NOT NULL,
  `ACTIVO_ID` int(11) NOT NULL,
  `FECHA` date NOT NULL,
  `COMENTARIO` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `entrega_recepcion`
--

INSERT INTO `entrega_recepcion` (`ID_ENTREGA_RECEPCION`, `PERSONA_ID`, `ACTIVO_ID`, `FECHA`, `COMENTARIO`) VALUES
(1, 3, 1, '2024-06-04', 'S/C');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `estado`
--

CREATE TABLE `estado` (
  `ID_ESTADO` int(11) NOT NULL,
  `NOMBRE_ESTADO` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `estado`
--

INSERT INTO `estado` (`ID_ESTADO`, `NOMBRE_ESTADO`) VALUES
(1, 'BUENO'),
(2, 'MALO'),
(3, 'REGULAR');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `firma`
--

CREATE TABLE `firma` (
  `ID_FIRMA` int(11) NOT NULL,
  `PERSONA_ID` int(11) NOT NULL,
  `DENOMINACION` varchar(50) CHARACTER SET latin1 NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_swedish_ci;

--
-- Volcado de datos para la tabla `firma`
--

INSERT INTO `firma` (`ID_FIRMA`, `PERSONA_ID`, `DENOMINACION`) VALUES
(1, 1, 'ING'),
(2, 2, 'MGS');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `horario_oficina`
--

CREATE TABLE `horario_oficina` (
  `ID_HORARIO_OFICINA` int(11) NOT NULL,
  `OFICINA_ID` int(11) NOT NULL,
  `HORA_ENTRADA` time NOT NULL,
  `HORA_SALIDA` time NOT NULL,
  `SALTO_DIA` varchar(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `horario_oficina`
--

INSERT INTO `horario_oficina` (`ID_HORARIO_OFICINA`, `OFICINA_ID`, `HORA_ENTRADA`, `HORA_SALIDA`, `SALTO_DIA`) VALUES
(1, 1, '00:00:00', '08:00:00', 'NO'),
(2, 1, '08:00:00', '16:00:00', 'NO'),
(3, 1, '16:00:00', '00:00:00', 'NO'),
(4, 2, '06:00:00', '14:00:00', 'NO'),
(5, 3, '06:00:00', '14:00:00', 'NO'),
(6, 3, '14:00:00', '22:00:00', 'NO'),
(7, 3, '22:00:00', '06:00:00', 'SI');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `marca`
--

CREATE TABLE `marca` (
  `ID_MARCA` int(11) NOT NULL,
  `NOMBRE_MARCA` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `marca`
--

INSERT INTO `marca` (`ID_MARCA`, `NOMBRE_MARCA`) VALUES
(1, '3COM'),
(2, 'ACE'),
(3, 'ADATA'),
(4, 'AKG'),
(5, 'ALTEK'),
(6, 'APPLE'),
(7, 'ARMEND SAFE'),
(8, 'ATU'),
(9, 'AUDIO TECH'),
(10, 'CANON'),
(11, 'CASSIO'),
(12, 'CDP'),
(13, 'CHAUVET'),
(14, 'CISCO'),
(15, 'CLON'),
(16, 'COLEMAN'),
(17, 'COMPAC'),
(18, 'COMPUTER POWER'),
(19, 'COOPER'),
(20, 'DAWWOO'),
(21, 'DELUX'),
(22, 'DELUXE'),
(23, 'DEWALT'),
(24, 'DINON'),
(25, 'DLINK'),
(26, 'E 7 N'),
(27, 'EAGLE'),
(28, 'ECLIPSE'),
(29, 'ELECTROLUX'),
(30, 'ENERGIZER'),
(31, 'EPSON'),
(32, 'FIRMESA'),
(33, 'FORZA'),
(34, 'FUJITSU'),
(35, 'GARMIN'),
(36, 'GENERAL ELECTRIC'),
(37, 'GENERICO'),
(38, 'GENIUS'),
(39, 'GEXX'),
(40, 'GRANDSTREAM'),
(41, 'HAND PUNCH'),
(42, 'HP'),
(43, 'IBM'),
(44, 'INFOCUS'),
(45, 'INNOVAIR'),
(46, 'KEHUA'),
(47, 'KW TRIO'),
(48, 'LENOVO'),
(49, 'LEXMARK'),
(50, 'LG'),
(51, 'LOGITECH'),
(52, 'MACKIE'),
(53, 'MAGELLAN'),
(54, 'MASTER PUNCH'),
(55, 'MICROSOFT'),
(56, 'MIKROTIK'),
(57, 'OURSKY'),
(58, 'PANASONIC'),
(59, 'PERKINS'),
(60, 'PHILIPS'),
(61, 'PICA'),
(62, 'PIONEER'),
(63, 'POLYCOM'),
(64, 'PORTEN'),
(65, 'POWER'),
(66, 'POWER GUARD'),
(67, 'POWERCOM'),
(68, 'PRO'),
(69, 'QBEX'),
(70, 'QUASAD'),
(71, 'QUILOTOA'),
(72, 'RAINBOX'),
(73, 'RICOH'),
(74, 'SAMSUNG'),
(75, 'SANYO'),
(76, 'SIN MARCA'),
(77, 'SONY'),
(78, 'SPEEDMIND'),
(79, 'STAINLESS'),
(80, 'SYLVANIA'),
(81, 'SYMBOL'),
(82, 'TOSHIBA'),
(83, 'TRENDNET'),
(84, 'VARTA'),
(85, 'VIRDI'),
(86, 'WENGER'),
(87, 'WHARFEDALE PRO'),
(88, 'YOLLY'),
(89, 'ZEBRA'),
(90, 'KOICA');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `movimiento_activo`
--

CREATE TABLE `movimiento_activo` (
  `ID_MOVIMIENTO_ACTIVO` int(11) NOT NULL,
  `ACTIVO_ID` int(11) NOT NULL,
  `PERSONA_ID` int(11) NOT NULL,
  `FECHA_MOVIMIENTO` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `movimiento_activo`
--

INSERT INTO `movimiento_activo` (`ID_MOVIMIENTO_ACTIVO`, `ACTIVO_ID`, `PERSONA_ID`, `FECHA_MOVIMIENTO`) VALUES
(1, 1, 1, '2024-06-04'),
(2, 1, 3, '2024-06-27');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `oficina`
--

CREATE TABLE `oficina` (
  `ID_OFICINA` int(11) NOT NULL,
  `NOMBRE_OFICINA` varchar(50) NOT NULL,
  `DESCRIPCION_OFICINA` varchar(100) NOT NULL,
  `LATITUD_OFICINA` varchar(100) NOT NULL,
  `LONGITUD_OFICINA` varchar(100) NOT NULL,
  `RADIO_VALIDO_METROS` int(3) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `oficina`
--

INSERT INTO `oficina` (`ID_OFICINA`, `NOMBRE_OFICINA`, `DESCRIPCION_OFICINA`, `LATITUD_OFICINA`, `LONGITUD_OFICINA`, `RADIO_VALIDO_METROS`) VALUES
(1, 'TERMINAL PUYO', 'OFICINA TERMINAL PUYO', '-1.4901483163584224', '-78.00615852883709', 10),
(2, 'MARISCAL', 'OFICINA MARISCAL', '-1.4874415404061425', '-77.99470549634349', 10),
(3, 'ENCOMIENDAS PUYO', 'OFICINA DE ENCOMIENDAS EN EL PUYO', '-1.48682081816182', '-78.00128093174351', 10);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `permiso`
--

CREATE TABLE `permiso` (
  `ID_PERMISO` int(11) NOT NULL,
  `PERSONA_ID` int(11) NOT NULL,
  `FECHA_INICIO_PERMISO` date NOT NULL,
  `FECHA_FIN_PERMISO` date NOT NULL,
  `ESTADO_PERMISO` varchar(50) DEFAULT 'CREADO',
  `DOCUMENTACION_PERMISO` varchar(250) DEFAULT NULL,
  `OBSERVACIONES_PERMISO` varchar(250) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `persona`
--

CREATE TABLE `persona` (
  `ID_PERSONA` int(11) NOT NULL,
  `CEDULA` int(11) DEFAULT NULL,
  `NOMBRE_PERSONA` varchar(100) DEFAULT NULL,
  `DIRECCION` varchar(100) DEFAULT NULL,
  `TELEFONO` varchar(15) DEFAULT NULL,
  `CARGO_ID` int(11) NOT NULL,
  `UNIDAD_ID` int(11) NOT NULL,
  `TIPO_CONTRATO` varchar(100) NOT NULL,
  `SALARIO_BASE` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `persona`
--

INSERT INTO `persona` (`ID_PERSONA`, `CEDULA`, `NOMBRE_PERSONA`, `DIRECCION`, `TELEFONO`, `CARGO_ID`, `UNIDAD_ID`, `TIPO_CONTRATO`, `SALARIO_BASE`) VALUES
(1, 1600000001, 'JORGE CHICAIZA', 'PUYO', '0987654321', 5, 5, 'CODIGO DE TRABAJO', 700),
(2, 1600000002, 'MELBA SILVA', 'PUYO', '0987654321', 4, 4, 'CODIGO DE TRABAJO', 700),
(3, 1600000003, 'CRISTIAN ARAUZ', 'PUYO', '0987654321', 1, 1, 'CODIGO DE TRABAJO', 700);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `persona_horario_oficina`
--

CREATE TABLE `persona_horario_oficina` (
  `ID_PERSONA_HORARIO_OFICINA` int(11) NOT NULL,
  `PERSONA_ID` int(11) NOT NULL,
  `OFICINA_ID` int(11) NOT NULL,
  `HORARIO_OFICINA_ID` int(11) NOT NULL,
  `FECHA_PERSONA_HORARIO_OFICINA` date NOT NULL,
  `NOTA_PERSONA_HORARIO_OFICINA` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `rol_usuario`
--

CREATE TABLE `rol_usuario` (
  `ID_ROL_USUARIO` int(11) NOT NULL,
  `NOMBRE_ROL_USUARIO` varchar(50) NOT NULL,
  `DESCRIPCION_ROL_USUARIO` varchar(150) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `rol_usuario`
--

INSERT INTO `rol_usuario` (`ID_ROL_USUARIO`, `NOMBRE_ROL_USUARIO`, `DESCRIPCION_ROL_USUARIO`) VALUES
(1, 'ADMINISTRADOR', 'Encargado de la Administración del Sistema'),
(2, 'INVITADO', 'Permite hacer todo lo del administrador menos el control de usuarios'),
(3, 'COMPROBADOR DE INVENTARIO', 'Permite hacer la comprobación del Inventario'),
(4, 'GENERADOR DE REPORTES Y ACTAS', 'Encargado de la Generación de Reportes y Actas'),
(5, 'ASISTENTE', 'Encargado de la asistencia al público');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `sistema`
--

CREATE TABLE `sistema` (
  `ID_SISTEMA` int(11) NOT NULL,
  `NOMBRE_SISTEMA` varchar(150) NOT NULL,
  `DIRECCION_SISTEMA` varchar(150) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `sistema`
--

INSERT INTO `sistema` (`ID_SISTEMA`, `NOMBRE_SISTEMA`, `DIRECCION_SISTEMA`) VALUES
(1, 'Webmail', 'tourisanfrancisco.com/webmail');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `unidad`
--

CREATE TABLE `unidad` (
  `ID_UNIDAD` int(11) NOT NULL,
  `NOMBRE_UNIDAD` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `unidad`
--

INSERT INTO `unidad` (`ID_UNIDAD`, `NOMBRE_UNIDAD`) VALUES
(1, 'UNIDAD OPERATIVA'),
(2, 'UNIDAD DE TALENTO HUMANO'),
(3, 'UNIDAD FINANCIERA'),
(4, 'UNIDAD ADMINISTRATIVA'),
(5, 'UNIDAD DE TECNOLOGÍAS DE INFORMACIÓN');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario`
--

CREATE TABLE `usuario` (
  `ID_USUARIO` int(11) NOT NULL,
  `PERSONA_ID` int(11) NOT NULL,
  `NOMBRE_USUARIO` varchar(50) NOT NULL,
  `CLAVE` varchar(255) NOT NULL,
  `ROL_USUARIO_ID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `usuario`
--

INSERT INTO `usuario` (`ID_USUARIO`, `PERSONA_ID`, `NOMBRE_USUARIO`, `CLAVE`, `ROL_USUARIO_ID`) VALUES
(1, 1, 'ADMIN', '$2y$10$/s.Qe.gT8mZVDeFTbQLTg.VFNkdUm8FE3MwoaHZxh.mGR1HEgbq7q', 1),
(2, 3, 'CARAUZ', '$2y$10$8lFL1UlcUsnyoDgIUJ9o3eaofrwHhkqdN7BX/d.fe8guic71frZh6', 5);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `activo`
--
ALTER TABLE `activo`
  ADD PRIMARY KEY (`ID_ACTIVO`),
  ADD KEY `FK_ACTIVO_REF_BODEGA` (`BODEGA_ID`),
  ADD KEY `FK_ACTIVO_REF_CARACTER` (`CARACTERISTICA`),
  ADD KEY `FK_ACTIVO_REF_CATEGORI` (`CATEGORIA_ID`),
  ADD KEY `FK_ACTIVO_REF_COLOR` (`COLOR_ID`),
  ADD KEY `FK_ACTIVO_REF_ESTADO` (`ESTADO_ID`),
  ADD KEY `FK_ACTIVO_REF_MARCA` (`MARCA_ID`);

--
-- Indices de la tabla `asistencia`
--
ALTER TABLE `asistencia`
  ADD PRIMARY KEY (`ID_ASISTENCIA`),
  ADD KEY `FK_ASISTENCIA_REF_PERSONA` (`PERSONA_ID`),
  ADD KEY `FK_ASISTENCIA_REF_OFICINA` (`OFICINA_ID`);

--
-- Indices de la tabla `bodega`
--
ALTER TABLE `bodega`
  ADD PRIMARY KEY (`ID_BODEGA`),
  ADD KEY `FK_BODEGA_REF_PERSONA` (`RESPONSABLE_BODEGA`);

--
-- Indices de la tabla `cargo`
--
ALTER TABLE `cargo`
  ADD PRIMARY KEY (`ID_CARGO`);

--
-- Indices de la tabla `categoria`
--
ALTER TABLE `categoria`
  ADD PRIMARY KEY (`ID_CATEGORIA`),
  ADD KEY `FK_CATEGORIA_REF_PERSONA` (`PERSONA_ID`);
  
--
-- Indices de la tabla `color`
--
ALTER TABLE `color`
  ADD PRIMARY KEY (`ID_COLOR`);

--
-- Indices de la tabla `entrega_recepcion`
--
ALTER TABLE `entrega_recepcion`
  ADD PRIMARY KEY (`ID_ENTREGA_RECEPCION`),
  ADD KEY `FK_ENTREGA_RECEPCION_REF_ACTIVO` (`ACTIVO_ID`),
  ADD KEY `FK_ENTREGA_RECEPCION_REF_PERSONA` (`PERSONA_ID`);

--
-- Indices de la tabla `estado`
--
ALTER TABLE `estado`
  ADD PRIMARY KEY (`ID_ESTADO`);

--
-- Indices de la tabla `firma`
--
ALTER TABLE `firma`
  ADD PRIMARY KEY (`ID_FIRMA`);

--
-- Indices de la tabla `horario_oficina`
--
ALTER TABLE `horario_oficina`
  ADD PRIMARY KEY (`ID_HORARIO_OFICINA`),
  ADD KEY `FK_HORARIO_OFICINA_REF_OFICINA` (`OFICINA_ID`);

--
-- Indices de la tabla `marca`
--
ALTER TABLE `marca`
  ADD PRIMARY KEY (`ID_MARCA`);

--
-- Indices de la tabla `movimiento_activo`
--
ALTER TABLE `movimiento_activo`
  ADD PRIMARY KEY (`ID_MOVIMIENTO_ACTIVO`);

--
-- Indices de la tabla `oficina`
--
ALTER TABLE `oficina`
  ADD PRIMARY KEY (`ID_OFICINA`);

--
-- Indices de la tabla `permiso`
--
ALTER TABLE `permiso`
  ADD PRIMARY KEY (`ID_PERMISO`),
  ADD KEY `FK_PERMISO_REF_PERSONA` (`PERSONA_ID`);

--
-- Indices de la tabla `persona`
--
ALTER TABLE `persona`
  ADD PRIMARY KEY (`ID_PERSONA`),
  ADD KEY `FK_PERSONA_REF_CARGO` (`CARGO_ID`),
  ADD KEY `FK_PERSONA_REF_UNIDAD` (`UNIDAD_ID`);

--
-- Indices de la tabla `persona_horario_oficina`
--
ALTER TABLE `persona_horario_oficina`
  ADD PRIMARY KEY (`ID_PERSONA_HORARIO_OFICINA`),
  ADD KEY `FK_PERSONA_HORARIO_OFICINA_REF_PERSONA` (`PERSONA_ID`),
  ADD KEY `FK_PERSONA_HORARIO_OFICINA_REF_HORARIO_OFICINA` (`HORARIO_OFICINA_ID`);

--
-- Indices de la tabla `rol_usuario`
--
ALTER TABLE `rol_usuario`
  ADD PRIMARY KEY (`ID_ROL_USUARIO`);

--
-- Indices de la tabla `sistema`
--
ALTER TABLE `sistema`
  ADD PRIMARY KEY (`ID_SISTEMA`);

--
-- Indices de la tabla `unidad`
--
ALTER TABLE `unidad`
  ADD PRIMARY KEY (`ID_UNIDAD`);

--
-- Indices de la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`ID_USUARIO`),
  ADD KEY `FK_USUARIO_REF_PERSONA` (`PERSONA_ID`),
  ADD KEY `FK_USUARIO_REF_ROL_USUARIO` (`ROL_USUARIO_ID`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `activo`
--
ALTER TABLE `activo`
  MODIFY `ID_ACTIVO` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=187;

--
-- AUTO_INCREMENT de la tabla `asistencia`
--
ALTER TABLE `asistencia`
  MODIFY `ID_ASISTENCIA` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `bodega`
--
ALTER TABLE `bodega`
  MODIFY `ID_BODEGA` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `cargo`
--
ALTER TABLE `cargo`
  MODIFY `ID_CARGO` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `categoria`
--
ALTER TABLE `categoria`
  MODIFY `ID_CATEGORIA` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `color`
--
ALTER TABLE `color`
  MODIFY `ID_COLOR` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT de la tabla `entrega_recepcion`
--
ALTER TABLE `entrega_recepcion`
  MODIFY `ID_ENTREGA_RECEPCION` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `estado`
--
ALTER TABLE `estado`
  MODIFY `ID_ESTADO` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `firma`
--
ALTER TABLE `firma`
  MODIFY `ID_FIRMA` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `horario_oficina`
--
ALTER TABLE `horario_oficina`
  MODIFY `ID_HORARIO_OFICINA` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de la tabla `marca`
--
ALTER TABLE `marca`
  MODIFY `ID_MARCA` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=91;

--
-- AUTO_INCREMENT de la tabla `movimiento_activo`
--
ALTER TABLE `movimiento_activo`
  MODIFY `ID_MOVIMIENTO_ACTIVO` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `oficina`
--
ALTER TABLE `oficina`
  MODIFY `ID_OFICINA` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `permiso`
--
ALTER TABLE `permiso`
  MODIFY `ID_PERMISO` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `persona`
--
ALTER TABLE `persona`
  MODIFY `ID_PERSONA` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `persona_horario_oficina`
--
ALTER TABLE `persona_horario_oficina`
  MODIFY `ID_PERSONA_HORARIO_OFICINA` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `rol_usuario`
--
ALTER TABLE `rol_usuario`
  MODIFY `ID_ROL_USUARIO` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `sistema`
--
ALTER TABLE `sistema`
  MODIFY `ID_SISTEMA` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `unidad`
--
ALTER TABLE `unidad`
  MODIFY `ID_UNIDAD` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `usuario`
--
ALTER TABLE `usuario`
  MODIFY `ID_USUARIO` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `activo`
--
ALTER TABLE `activo`
  ADD CONSTRAINT `activo_ibfk_1` FOREIGN KEY (`CATEGORIA_ID`) REFERENCES `categoria` (`ID_CATEGORIA`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `activo_ibfk_2` FOREIGN KEY (`MARCA_ID`) REFERENCES `marca` (`ID_MARCA`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `activo_ibfk_3` FOREIGN KEY (`ESTADO_ID`) REFERENCES `estado` (`ID_ESTADO`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `activo_ibfk_4` FOREIGN KEY (`COLOR_ID`) REFERENCES `color` (`ID_COLOR`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `activo_ibfk_5` FOREIGN KEY (`BODEGA_ID`) REFERENCES `bodega` (`ID_BODEGA`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `asistencia`
--
ALTER TABLE `asistencia`
  ADD CONSTRAINT `asistencia_ibfk_1` FOREIGN KEY (`PERSONA_ID`) REFERENCES `persona` (`ID_PERSONA`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `asistencia_ibfk_2` FOREIGN KEY (`OFICINA_ID`) REFERENCES `oficina` (`ID_OFICINA`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `bodega`
--
ALTER TABLE `bodega`
  ADD CONSTRAINT `bodega_ibfk_1` FOREIGN KEY (`RESPONSABLE_BODEGA`) REFERENCES `persona` (`ID_PERSONA`) ON DELETE CASCADE ON UPDATE CASCADE;


--
-- Filtros para la tabla `entrega_recepcion`
--
ALTER TABLE `entrega_recepcion`
  ADD CONSTRAINT `entrega_recepcion_ibfk_3` FOREIGN KEY (`ACTIVO_ID`) REFERENCES `activo` (`ID_ACTIVO`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `entrega_recepcion_ibfk_4` FOREIGN KEY (`PERSONA_ID`) REFERENCES `persona` (`ID_PERSONA`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `horario_oficina`
--
ALTER TABLE `horario_oficina`
  ADD CONSTRAINT `horario_oficina_ibfk_1` FOREIGN KEY (`OFICINA_ID`) REFERENCES `oficina` (`ID_OFICINA`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `permiso`
--
ALTER TABLE `permiso`
  ADD CONSTRAINT `permiso_ibfk_1` FOREIGN KEY (`PERSONA_ID`) REFERENCES `persona` (`ID_PERSONA`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `persona`
--
ALTER TABLE `persona`
  ADD CONSTRAINT `persona_ibfk_1` FOREIGN KEY (`UNIDAD_ID`) REFERENCES `unidad` (`ID_UNIDAD`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `persona_ibfk_2` FOREIGN KEY (`CARGO_ID`) REFERENCES `cargo` (`ID_CARGO`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `persona_horario_oficina`
--
ALTER TABLE `persona_horario_oficina`
  ADD CONSTRAINT `persona_horario_oficina_ibfk_1` FOREIGN KEY (`PERSONA_ID`) REFERENCES `persona` (`ID_PERSONA`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `persona_horario_oficina_ibfk_2` FOREIGN KEY (`HORARIO_OFICINA_ID`) REFERENCES `horario_oficina` (`ID_HORARIO_OFICINA`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD CONSTRAINT `usuario_ibfk_2` FOREIGN KEY (`ROL_USUARIO_ID`) REFERENCES `rol_usuario` (`ID_ROL_USUARIO`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `usuario_ibfk_3` FOREIGN KEY (`ID_USUARIO`) REFERENCES `persona` (`ID_PERSONA`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;