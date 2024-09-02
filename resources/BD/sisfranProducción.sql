-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost:8889
-- Tiempo de generación: 01-07-2024 a las 16:27:11
-- Versión del servidor: 5.7.39
-- Versión de PHP: 7.4.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


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
  `CUSTODIO_ID` int(11) DEFAULT NULL,
  `CODIGO` int(11) DEFAULT NULL,
  `NOMBRE_ACTIVO` char(100) DEFAULT NULL,
  `MODELO` char(100) DEFAULT NULL,
  `SERIE` char(100) DEFAULT NULL,
  `ORIGEN_INGRESO` char(100) DEFAULT NULL,
  `FECHA_INGRESO` date DEFAULT NULL,
  `VALOR_COMPRA` float DEFAULT NULL,
  `COMENTARIO` char(255) DEFAULT NULL,
  `COMPROBACION_INVENTARIO` varchar(10) NOT NULL,
  `HISTORICO` int(11) DEFAULT '1',
  `FECHA_HISTORICO` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `activo`
--

INSERT INTO `activo` (`ID_ACTIVO`, `CATEGORIA_ID`, `MARCA_ID`, `ESTADO_ID`, `COLOR_ID`, `CARACTERISTICA`, `BODEGA_ID`, `CUSTODIO_ID`, `CODIGO`, `NOMBRE_ACTIVO`, `MODELO`, `SERIE`, `ORIGEN_INGRESO`, `FECHA_INGRESO`, `VALOR_COMPRA`, `COMENTARIO`, `COMPROBACION_INVENTARIO`, `HISTORICO`, `FECHA_HISTORICO`) VALUES
(1, 2, 8, 3, 7, 'S/C', 1, 2, 13184469, 'ARCHIVADOR MIXTO', 'BIBLIOTECA', '63445030116003', 'MATRIZ - Oficina Central', '2020-02-12', 150, '', 'NO', 1, '2024-06-04');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `bodega`
--

CREATE TABLE `bodega` (
  `ID_BODEGA` int(11) NOT NULL,
  `NOMBRE_BODEGA` char(100) DEFAULT NULL,
  `UBICACION` char(100) DEFAULT NULL,
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
  `NOMBRE_CARGO` char(100) DEFAULT NULL
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
  `NOMBRE_CATEGORIA` char(100) NOT NULL,
  `DESCRIPCION_CATEGORIA` char(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `categoria`
--

INSERT INTO `categoria` (`ID_CATEGORIA`, `NOMBRE_CATEGORIA`, `DESCRIPCION_CATEGORIA`) VALUES
(1, 'EQUIPO INFORMÁTICO', 'EQUIPOS ELECTRÓNICOS Y INFORMÁTICOS'),
(2, 'BIEN INMUEBLE', 'BIENES INMUEBLES');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `color`
--

CREATE TABLE `color` (
  `ID_COLOR` int(11) NOT NULL,
  `NOMBRE_COLOR` char(100) DEFAULT NULL
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
-- Estructura de tabla para la tabla `custodio`
--

CREATE TABLE `custodio` (
  `ID_CUSTODIO` int(11) NOT NULL,
  `PERSONA_ID` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `custodio`
--

INSERT INTO `custodio` (`ID_CUSTODIO`, `PERSONA_ID`) VALUES
(1, 1),
(2, 2);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `entrega_recepcion`
--

CREATE TABLE `entrega_recepcion` (
  `ID_ENTREGA_RECEPCION` int(11) NOT NULL,
  `PERSONA_ID` int(11) NOT NULL,
  `ACTIVO_ID` int(11) NOT NULL,
  `CUSTODIO_ID` int(11) NOT NULL,
  `FECHA` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `entrega_recepcion`
--

INSERT INTO `entrega_recepcion` (`ID_ENTREGA_RECEPCION`, `PERSONA_ID`, `ACTIVO_ID`, `CUSTODIO_ID`, `FECHA`) VALUES
(1298, 3, 1, 2, '2024-06-04');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `estado`
--

CREATE TABLE `estado` (
  `ID_ESTADO` int(11) NOT NULL,
  `NOMBRE_ESTADO` char(100) DEFAULT NULL
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
-- Estructura de tabla para la tabla `marca`
--

CREATE TABLE `marca` (
  `ID_MARCA` int(11) NOT NULL,
  `NOMBRE_MARCA` char(100) DEFAULT NULL
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
  `CUSTODIO_ID` int(11) NOT NULL,
  `PERSONA_ID` int(11) NOT NULL,
  `FECHA_MOVIMIENTO` date NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

--
-- Volcado de datos para la tabla `movimiento_activo`
--

INSERT INTO `movimiento_activo` (`ID_MOVIMIENTO_ACTIVO`, `ACTIVO_ID`, `CUSTODIO_ID`, `PERSONA_ID`, `FECHA_MOVIMIENTO`) VALUES
(1, 1, 1, 1, '2024-06-04'),
(2, 1, 2, 3, '2024-06-27');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `persona`
--

CREATE TABLE `persona` (
  `ID_PERSONA` int(11) NOT NULL,
  `CEDULA` int(11) DEFAULT NULL,
  `NOMBRE_PERSONA` char(100) DEFAULT NULL,
  `DIRECCION` char(100) DEFAULT NULL,
  `TELEFONO` varchar(15) DEFAULT NULL,
  `CARGO_ID` int(11) NOT NULL,
  `UNIDAD_ID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `persona`
--

INSERT INTO `persona` (`ID_PERSONA`, `CEDULA`, `NOMBRE_PERSONA`, `DIRECCION`, `TELEFONO`, `CARGO_ID`, `UNIDAD_ID`) VALUES
(1, 1600000001, 'JORGE CHICAIZA', 'PUYO', '0987654321', 5, 5),
(2, 1600000002, 'MELBA SILVA', 'PUYO', '0987654321', 4, 4),
(3, 1600000003, 'CRISTIAN ARAUZ', 'PUYO', '0987654321', 1, 1);

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
(4, 'GENERADOR DE REPORTES Y ACTAS', 'Encargado de la Generación de Reportes y Actas');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `sistema`
--

CREATE TABLE `sistema` (
  `ID_SISTEMA` int(11) NOT NULL,
  `NOMBRE_SISTEMA` varchar(150) CHARACTER SET latin1 NOT NULL,
  `DIRECCION_SISTEMA` varchar(150) CHARACTER SET latin1 NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

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
  `NOMBRE_UNIDAD` char(100) DEFAULT NULL
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
(1, 1, 'ADMIN', 'sysadmin24.', 1);

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
  ADD KEY `FK_ACTIVO_REF_MARCA` (`MARCA_ID`),
  ADD KEY `FK_ACTIVO_REF_CUSTODIO` (`CUSTODIO_ID`);

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
  ADD PRIMARY KEY (`ID_CATEGORIA`);

--
-- Indices de la tabla `color`
--
ALTER TABLE `color`
  ADD PRIMARY KEY (`ID_COLOR`);

--
-- Indices de la tabla `custodio`
--
ALTER TABLE `custodio`
  ADD PRIMARY KEY (`ID_CUSTODIO`),
  ADD KEY `FK_PERSONA_REF_CUSTODIO` (`PERSONA_ID`);

--
-- Indices de la tabla `entrega_recepcion`
--
ALTER TABLE `entrega_recepcion`
  ADD PRIMARY KEY (`ID_ENTREGA_RECEPCION`),
  ADD KEY `FK_ENTREGA_RECEPCION_REF_ACTIVO` (`ACTIVO_ID`),
  ADD KEY `FK_ENTREGA_RECEPCION_REF_CUSTODIO` (`CUSTODIO_ID`),
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
-- Indices de la tabla `persona`
--
ALTER TABLE `persona`
  ADD PRIMARY KEY (`ID_PERSONA`),
  ADD KEY `FK_PERSONA_REF_CARGO` (`CARGO_ID`),
  ADD KEY `FK_PERSONA_REF_UNIDAD` (`UNIDAD_ID`);

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
  MODIFY `ID_ACTIVO` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

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
-- AUTO_INCREMENT de la tabla `custodio`
--
ALTER TABLE `custodio`
  MODIFY `ID_CUSTODIO` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `entrega_recepcion`
--
ALTER TABLE `entrega_recepcion`
  MODIFY `ID_ENTREGA_RECEPCION` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1299;

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
-- AUTO_INCREMENT de la tabla `persona`
--
ALTER TABLE `persona`
  MODIFY `ID_PERSONA` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `rol_usuario`
--
ALTER TABLE `rol_usuario`
  MODIFY `ID_ROL_USUARIO` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `sistema`
--
ALTER TABLE `sistema`
  MODIFY `ID_SISTEMA` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `unidad`
--
ALTER TABLE `unidad`
  MODIFY `ID_UNIDAD` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `usuario`
--
ALTER TABLE `usuario`
  MODIFY `ID_USUARIO` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

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
  ADD CONSTRAINT `activo_ibfk_5` FOREIGN KEY (`BODEGA_ID`) REFERENCES `bodega` (`ID_BODEGA`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `activo_ibfk_6` FOREIGN KEY (`CUSTODIO_ID`) REFERENCES `custodio` (`PERSONA_ID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `bodega`
--
ALTER TABLE `bodega`
  ADD CONSTRAINT `bodega_ibfk_1` FOREIGN KEY (`RESPONSABLE_BODEGA`) REFERENCES `persona` (`ID_PERSONA`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `entrega_recepcion`
--
ALTER TABLE `entrega_recepcion`
  ADD CONSTRAINT `entrega_recepcion_ibfk_1` FOREIGN KEY (`CUSTODIO_ID`) REFERENCES `custodio` (`ID_CUSTODIO`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `entrega_recepcion_ibfk_3` FOREIGN KEY (`ACTIVO_ID`) REFERENCES `activo` (`ID_ACTIVO`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `entrega_recepcion_ibfk_4` FOREIGN KEY (`PERSONA_ID`) REFERENCES `persona` (`ID_PERSONA`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `persona`
--
ALTER TABLE `persona`
  ADD CONSTRAINT `persona_ibfk_1` FOREIGN KEY (`UNIDAD_ID`) REFERENCES `unidad` (`ID_UNIDAD`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `persona_ibfk_2` FOREIGN KEY (`CARGO_ID`) REFERENCES `cargo` (`ID_CARGO`) ON DELETE CASCADE ON UPDATE CASCADE;

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
