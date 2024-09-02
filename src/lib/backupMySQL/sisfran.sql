﻿SET SQL_MODE  = 'NO_AUTO_VALUE_ON_ZERO';
  SET time_zone = '+00:00'; 
DROP TABLE activo;

CREATE TABLE `activo` (
  `ID_ACTIVO` int(11) NOT NULL AUTO_INCREMENT,
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
  `FECHA_HISTORICO` date DEFAULT NULL,
  PRIMARY KEY (`ID_ACTIVO`),
  KEY `FK_ACTIVO_REF_BODEGA` (`BODEGA_ID`),
  KEY `FK_ACTIVO_REF_CARACTER` (`CARACTERISTICA`),
  KEY `FK_ACTIVO_REF_CATEGORI` (`CATEGORIA_ID`),
  KEY `FK_ACTIVO_REF_COLOR` (`COLOR_ID`),
  KEY `FK_ACTIVO_REF_ESTADO` (`ESTADO_ID`),
  KEY `FK_ACTIVO_REF_MARCA` (`MARCA_ID`),
  KEY `FK_ACTIVO_REF_CUSTODIO` (`CUSTODIO_ID`),
  CONSTRAINT `activo_ibfk_1` FOREIGN KEY (`CATEGORIA_ID`) REFERENCES `categoria` (`ID_CATEGORIA`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `activo_ibfk_2` FOREIGN KEY (`MARCA_ID`) REFERENCES `marca` (`ID_MARCA`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `activo_ibfk_3` FOREIGN KEY (`ESTADO_ID`) REFERENCES `estado` (`ID_ESTADO`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `activo_ibfk_4` FOREIGN KEY (`COLOR_ID`) REFERENCES `color` (`ID_COLOR`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `activo_ibfk_5` FOREIGN KEY (`BODEGA_ID`) REFERENCES `bodega` (`ID_BODEGA`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `activo_ibfk_6` FOREIGN KEY (`CUSTODIO_ID`) REFERENCES `custodio` (`PERSONA_ID`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

INSERT INTO `activo`(`ID_ACTIVO`,`CATEGORIA_ID`,`MARCA_ID`,`ESTADO_ID`,`COLOR_ID`,`CARACTERISTICA`,`BODEGA_ID`,`CUSTODIO_ID`,`CODIGO`,`NOMBRE_ACTIVO`,`MODELO`,`SERIE`,`ORIGEN_INGRESO`,`FECHA_INGRESO`,`VALOR_COMPRA`,`COMENTARIO`,`COMPROBACION_INVENTARIO`,`HISTORICO`,`FECHA_HISTORICO`) VALUES 
('1','2','8','3','7','S/C','1','2','13184469','ARCHIVADOR MIXTO','BIBLIOTECA','63445030116003','MATRIZ - Oficina Central','2020-02-12','150','','NO','1','2024-06-04');
DROP TABLE bodega;

CREATE TABLE `bodega` (
  `ID_BODEGA` int(11) NOT NULL AUTO_INCREMENT,
  `NOMBRE_BODEGA` char(100) DEFAULT NULL,
  `UBICACION` char(100) DEFAULT NULL,
  `RESPONSABLE_BODEGA` int(11) DEFAULT NULL,
  PRIMARY KEY (`ID_BODEGA`),
  KEY `FK_BODEGA_REF_PERSONA` (`RESPONSABLE_BODEGA`),
  CONSTRAINT `bodega_ibfk_1` FOREIGN KEY (`RESPONSABLE_BODEGA`) REFERENCES `persona` (`ID_PERSONA`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

INSERT INTO `bodega`(`ID_BODEGA`,`NOMBRE_BODEGA`,`UBICACION`,`RESPONSABLE_BODEGA`) VALUES 
('1','BODEGA PRINCIPAL DE BIENES','OFICINA MATRIZ - PUYO','1');
DROP TABLE cargo;

CREATE TABLE `cargo` (
  `ID_CARGO` int(11) NOT NULL AUTO_INCREMENT,
  `NOMBRE_CARGO` char(100) DEFAULT NULL,
  PRIMARY KEY (`ID_CARGO`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

INSERT INTO `cargo`(`ID_CARGO`,`NOMBRE_CARGO`) VALUES 
('1','OFICINISTA'),

('2','GERENTE'),

('3','PRESIDENTE'),

('4','ASISTENTE'),

('5','TÉCNICO');
DROP TABLE categoria;

CREATE TABLE `categoria` (
  `ID_CATEGORIA` int(11) NOT NULL AUTO_INCREMENT,
  `NOMBRE_CATEGORIA` char(100) NOT NULL,
  `DESCRIPCION_CATEGORIA` char(100) DEFAULT NULL,
  PRIMARY KEY (`ID_CATEGORIA`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

INSERT INTO `categoria`(`ID_CATEGORIA`,`NOMBRE_CATEGORIA`,`DESCRIPCION_CATEGORIA`) VALUES 
('1','EQUIPO INFORMÁTICO','EQUIPOS ELECTRÓNICOS Y INFORMÁTICOS'),

('2','BIEN INMUEBLE','BIENES INMUEBLES');
DROP TABLE color;

CREATE TABLE `color` (
  `ID_COLOR` int(11) NOT NULL AUTO_INCREMENT,
  `NOMBRE_COLOR` char(100) DEFAULT NULL,
  PRIMARY KEY (`ID_COLOR`)
) ENGINE=InnoDB AUTO_INCREMENT=31 DEFAULT CHARSET=latin1;

INSERT INTO `color`(`ID_COLOR`,`NOMBRE_COLOR`) VALUES 
('1','AMARILLO'),

('2','AZUL'),

('3','BEIGE'),

('4','BICOLOR'),

('5','BLANCO'),

('6','BLANCO Y NEGRO'),

('7','CAFÉ'),

('8','CAOBA'),

('9','CELESTE'),

('10','CEREZO'),

('11','CREMA'),

('12','FLOREADO'),

('13','GRIS'),

('14','GRIS HIERRO'),

('15','HABANO'),

('16','HUESO CLARO'),

('17','MARFIL'),

('18','MARRÓN'),

('19','MIEL'),

('20','NEGRO'),

('21','NO APLICA'),

('22','PLATA'),

('23','PLOMO'),

('24','ROJO'),

('25','ROSADO'),

('26','TOMATE'),

('27','TRICOLOR'),

('28','TURQUESA'),

('29','VERDE'),

('30','VINO');
DROP TABLE custodio;

CREATE TABLE `custodio` (
  `ID_CUSTODIO` int(11) NOT NULL AUTO_INCREMENT,
  `PERSONA_ID` int(11) DEFAULT NULL,
  PRIMARY KEY (`ID_CUSTODIO`),
  KEY `FK_PERSONA_REF_CUSTODIO` (`PERSONA_ID`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

INSERT INTO `custodio`(`ID_CUSTODIO`,`PERSONA_ID`) VALUES 
('1','1'),

('2','2');
DROP TABLE entrega_recepcion;

CREATE TABLE `entrega_recepcion` (
  `ID_ENTREGA_RECEPCION` int(11) NOT NULL AUTO_INCREMENT,
  `PERSONA_ID` int(11) NOT NULL,
  `ACTIVO_ID` int(11) NOT NULL,
  `CUSTODIO_ID` int(11) NOT NULL,
  `FECHA` date NOT NULL,
  PRIMARY KEY (`ID_ENTREGA_RECEPCION`),
  KEY `FK_ENTREGA_RECEPCION_REF_ACTIVO` (`ACTIVO_ID`),
  KEY `FK_ENTREGA_RECEPCION_REF_CUSTODIO` (`CUSTODIO_ID`),
  KEY `FK_ENTREGA_RECEPCION_REF_PERSONA` (`PERSONA_ID`),
  CONSTRAINT `entrega_recepcion_ibfk_1` FOREIGN KEY (`CUSTODIO_ID`) REFERENCES `custodio` (`ID_CUSTODIO`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `entrega_recepcion_ibfk_3` FOREIGN KEY (`ACTIVO_ID`) REFERENCES `activo` (`ID_ACTIVO`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `entrega_recepcion_ibfk_4` FOREIGN KEY (`PERSONA_ID`) REFERENCES `persona` (`ID_PERSONA`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=1299 DEFAULT CHARSET=latin1;

INSERT INTO `entrega_recepcion`(`ID_ENTREGA_RECEPCION`,`PERSONA_ID`,`ACTIVO_ID`,`CUSTODIO_ID`,`FECHA`) VALUES 
('1298','3','1','2','2024-06-04');
DROP TABLE estado;

CREATE TABLE `estado` (
  `ID_ESTADO` int(11) NOT NULL AUTO_INCREMENT,
  `NOMBRE_ESTADO` char(100) DEFAULT NULL,
  PRIMARY KEY (`ID_ESTADO`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

INSERT INTO `estado`(`ID_ESTADO`,`NOMBRE_ESTADO`) VALUES 
('1','BUENO'),

('2','MALO'),

('3','REGULAR');
DROP TABLE firma;

CREATE TABLE `firma` (
  `ID_FIRMA` int(11) NOT NULL AUTO_INCREMENT,
  `PERSONA_ID` int(11) NOT NULL,
  `DENOMINACION` varchar(50) CHARACTER SET latin1 NOT NULL,
  PRIMARY KEY (`ID_FIRMA`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_swedish_ci;

INSERT INTO `firma`(`ID_FIRMA`,`PERSONA_ID`,`DENOMINACION`) VALUES 
('1','1','ING'),

('2','2','MGS');
DROP TABLE marca;

CREATE TABLE `marca` (
  `ID_MARCA` int(11) NOT NULL AUTO_INCREMENT,
  `NOMBRE_MARCA` char(100) DEFAULT NULL,
  PRIMARY KEY (`ID_MARCA`)
) ENGINE=InnoDB AUTO_INCREMENT=91 DEFAULT CHARSET=latin1;

INSERT INTO `marca`(`ID_MARCA`,`NOMBRE_MARCA`) VALUES 
('1','3COM'),

('2','ACE'),

('3','ADATA'),

('4','AKG'),

('5','ALTEK'),

('6','APPLE'),

('7','ARMEND SAFE'),

('8','ATU'),

('9','AUDIO TECH'),

('10','CANON'),

('11','CASSIO'),

('12','CDP'),

('13','CHAUVET'),

('14','CISCO'),

('15','CLON'),

('16','COLEMAN'),

('17','COMPAC'),

('18','COMPUTER POWER'),

('19','COOPER'),

('20','DAWWOO'),

('21','DELUX'),

('22','DELUXE'),

('23','DEWALT'),

('24','DINON'),

('25','DLINK'),

('26','E 7 N'),

('27','EAGLE'),

('28','ECLIPSE'),

('29','ELECTROLUX'),

('30','ENERGIZER'),

('31','EPSON'),

('32','FIRMESA'),

('33','FORZA'),

('34','FUJITSU'),

('35','GARMIN'),

('36','GENERAL ELECTRIC'),

('37','GENERICO'),

('38','GENIUS'),

('39','GEXX'),

('40','GRANDSTREAM'),

('41','HAND PUNCH'),

('42','HP'),

('43','IBM'),

('44','INFOCUS'),

('45','INNOVAIR'),

('46','KEHUA'),

('47','KW TRIO'),

('48','LENOVO'),

('49','LEXMARK'),

('50','LG'),

('51','LOGITECH'),

('52','MACKIE'),

('53','MAGELLAN'),

('54','MASTER PUNCH'),

('55','MICROSOFT'),

('56','MIKROTIK'),

('57','OURSKY'),

('58','PANASONIC'),

('59','PERKINS'),

('60','PHILIPS'),

('61','PICA'),

('62','PIONEER'),

('63','POLYCOM'),

('64','PORTEN'),

('65','POWER'),

('66','POWER GUARD'),

('67','POWERCOM'),

('68','PRO'),

('69','QBEX'),

('70','QUASAD'),

('71','QUILOTOA'),

('72','RAINBOX'),

('73','RICOH'),

('74','SAMSUNG'),

('75','SANYO'),

('76','SIN MARCA'),

('77','SONY'),

('78','SPEEDMIND'),

('79','STAINLESS'),

('80','SYLVANIA'),

('81','SYMBOL'),

('82','TOSHIBA'),

('83','TRENDNET'),

('84','VARTA'),

('85','VIRDI'),

('86','WENGER'),

('87','WHARFEDALE PRO'),

('88','YOLLY'),

('89','ZEBRA'),

('90','KOICA');
DROP TABLE movimiento_activo;

CREATE TABLE `movimiento_activo` (
  `ID_MOVIMIENTO_ACTIVO` int(11) NOT NULL AUTO_INCREMENT,
  `ACTIVO_ID` int(11) NOT NULL,
  `CUSTODIO_ID` int(11) NOT NULL,
  `PERSONA_ID` int(11) NOT NULL,
  `FECHA_MOVIMIENTO` date NOT NULL,
  PRIMARY KEY (`ID_MOVIMIENTO_ACTIVO`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

INSERT INTO `movimiento_activo`(`ID_MOVIMIENTO_ACTIVO`,`ACTIVO_ID`,`CUSTODIO_ID`,`PERSONA_ID`,`FECHA_MOVIMIENTO`) VALUES 
('1','1','1','1','2024-06-04'),

('2','1','2','3','2024-06-27');
DROP TABLE persona;

CREATE TABLE `persona` (
  `ID_PERSONA` int(11) NOT NULL AUTO_INCREMENT,
  `CEDULA` int(11) DEFAULT NULL,
  `NOMBRE_PERSONA` char(100) DEFAULT NULL,
  `DIRECCION` char(100) DEFAULT NULL,
  `TELEFONO` varchar(15) DEFAULT NULL,
  `CARGO_ID` int(11) NOT NULL,
  `UNIDAD_ID` int(11) NOT NULL,
  PRIMARY KEY (`ID_PERSONA`),
  KEY `FK_PERSONA_REF_CARGO` (`CARGO_ID`),
  KEY `FK_PERSONA_REF_UNIDAD` (`UNIDAD_ID`),
  CONSTRAINT `persona_ibfk_1` FOREIGN KEY (`UNIDAD_ID`) REFERENCES `unidad` (`ID_UNIDAD`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `persona_ibfk_2` FOREIGN KEY (`CARGO_ID`) REFERENCES `cargo` (`ID_CARGO`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

INSERT INTO `persona`(`ID_PERSONA`,`CEDULA`,`NOMBRE_PERSONA`,`DIRECCION`,`TELEFONO`,`CARGO_ID`,`UNIDAD_ID`) VALUES 
('1','1600000001','JORGE CHICAIZA','PUYO','0987654321','5','5'),

('2','1600000002','MELBA SILVA','PUYO','0987654321','4','4'),

('3','1600000003','CRISTIAN ARAUZ','PUYO','0987654321','1','1');
DROP TABLE rol_usuario;

CREATE TABLE `rol_usuario` (
  `ID_ROL_USUARIO` int(11) NOT NULL AUTO_INCREMENT,
  `NOMBRE_ROL_USUARIO` varchar(50) NOT NULL,
  `DESCRIPCION_ROL_USUARIO` varchar(150) NOT NULL,
  PRIMARY KEY (`ID_ROL_USUARIO`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

INSERT INTO `rol_usuario`(`ID_ROL_USUARIO`,`NOMBRE_ROL_USUARIO`,`DESCRIPCION_ROL_USUARIO`) VALUES 
('1','ADMINISTRADOR','Encargado de la Administración del Sistema'),

('2','INVITADO','Permite hacer todo lo del administrador menos el control de usuarios'),

('3','COMPROBADOR DE INVENTARIO','Permite hacer la comprobación del Inventario'),

('4','GENERADOR DE REPORTES Y ACTAS','Encargado de la Generación de Reportes y Actas');
DROP TABLE sistema;

CREATE TABLE `sistema` (
  `ID_SISTEMA` int(11) NOT NULL AUTO_INCREMENT,
  `NOMBRE_SISTEMA` varchar(150) CHARACTER SET latin1 NOT NULL,
  `DIRECCION_SISTEMA` varchar(150) CHARACTER SET latin1 NOT NULL,
  PRIMARY KEY (`ID_SISTEMA`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

INSERT INTO `sistema`(`ID_SISTEMA`,`NOMBRE_SISTEMA`,`DIRECCION_SISTEMA`) VALUES 
('1','Webmail','tourisanfrancisco.com/webmail');
DROP TABLE unidad;

CREATE TABLE `unidad` (
  `ID_UNIDAD` int(11) NOT NULL AUTO_INCREMENT,
  `NOMBRE_UNIDAD` char(100) DEFAULT NULL,
  PRIMARY KEY (`ID_UNIDAD`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

INSERT INTO `unidad`(`ID_UNIDAD`,`NOMBRE_UNIDAD`) VALUES 
('1','UNIDAD OPERATIVA'),

('2','UNIDAD DE TALENTO HUMANO'),

('3','UNIDAD FINANCIERA'),

('4','UNIDAD ADMINISTRATIVA'),

('5','UNIDAD DE TECNOLOGÍAS DE INFORMACIÓN');
DROP TABLE usuario;

CREATE TABLE `usuario` (
  `ID_USUARIO` int(11) NOT NULL AUTO_INCREMENT,
  `PERSONA_ID` int(11) NOT NULL,
  `NOMBRE_USUARIO` varchar(50) NOT NULL,
  `CLAVE` varchar(255) NOT NULL,
  `ROL_USUARIO_ID` int(11) NOT NULL,
  PRIMARY KEY (`ID_USUARIO`),
  KEY `FK_USUARIO_REF_PERSONA` (`PERSONA_ID`),
  KEY `FK_USUARIO_REF_ROL_USUARIO` (`ROL_USUARIO_ID`),
  CONSTRAINT `usuario_ibfk_2` FOREIGN KEY (`ROL_USUARIO_ID`) REFERENCES `rol_usuario` (`ID_ROL_USUARIO`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `usuario_ibfk_3` FOREIGN KEY (`ID_USUARIO`) REFERENCES `persona` (`ID_PERSONA`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

INSERT INTO `usuario`(`ID_USUARIO`,`PERSONA_ID`,`NOMBRE_USUARIO`,`CLAVE`,`ROL_USUARIO_ID`) VALUES 
('1','1','ADMIN','sysadmin','1');



