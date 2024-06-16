-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 28-02-2023 a las 18:54:38
-- Versión del servidor: 10.4.27-MariaDB
-- Versión de PHP: 8.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `supermarket`
--
CREATE DATABASE IF NOT EXISTS `supermarket` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci;
USE `supermarket`;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `canton`
--

CREATE TABLE `canton` (
  `Id` int(11) NOT NULL,
  `NombreCanton` varchar(30) NOT NULL,
  `IdProvincia` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

--
-- RELACIONES PARA LA TABLA `canton`:
--   `IdProvincia`
--       `provincia` -> `Id`
--

--
-- Volcado de datos para la tabla `canton`
--

INSERT INTO `canton` (`Id`, `NombreCanton`, `IdProvincia`) VALUES
(101, 'SAN JOSÉ', 1),
(102, 'ESCAZÚ', 1),
(103, 'DESAMPARADOS', 1),
(104, 'PURISCAL', 1),
(105, 'TARRAZÚ', 1),
(106, 'ASERRÍ', 1),
(107, 'MORA', 1),
(108, 'GOICOECHEA', 1),
(109, 'SANTA ANA', 1),
(110, 'ALAJUELITA', 1),
(111, 'VÁZQUEZ DE CORONADO', 1),
(112, 'ACOSTA', 1),
(113, 'TIBÁS', 1),
(114, 'MORAVIA', 1),
(115, 'MONTES DE OCA', 1),
(116, 'TURRUBARES', 1),
(117, 'DOTA', 1),
(118, 'CURRIDABAT', 1),
(119, 'PÉREZ ZELEDÓN', 1),
(120, 'LEÓN CORTÉS', 1),
(201, 'ALAJUELA', 2),
(202, 'SAN RAMÓN', 2),
(203, 'GRECIA', 2),
(204, 'SAN MATEO', 2),
(205, 'ATENAS', 2),
(206, 'NARANJO', 2),
(207, 'PALMARES', 2),
(208, 'POÁS', 2),
(209, 'OROTINA', 2),
(210, 'SAN CARLOS', 2),
(211, 'ZARCERO', 2),
(212, 'VALVERDE VEGA', 2),
(213, 'UPALA', 2),
(214, 'LOS CHILES', 2),
(215, 'GUATUSO', 2),
(301, 'CARTAGO', 3),
(302, 'PARAÍSO', 3),
(303, 'LA UNIÓN', 3),
(304, 'JIMÉNEZ', 3),
(305, 'TURRIALBA', 3),
(306, 'ALVARADO', 3),
(307, 'OREAMUNO', 3),
(308, 'EL GUARCO', 3),
(401, 'HEREDIA', 4),
(402, 'BARVA', 4),
(403, 'SANTO DOMINGO', 4),
(404, 'SANTA BÁRBARA', 4),
(405, 'SAN RAFAEL', 4),
(406, 'SAN ISIDRO', 4),
(407, 'BELÉN', 4),
(408, 'FLORES', 4),
(409, 'SAN PABLO', 4),
(410, 'SARAPIQUÍ', 4),
(501, 'LIBERIA', 5),
(502, 'NICOYA', 5),
(503, 'SANTA CRUZ', 5),
(504, 'BAGACES', 5),
(505, 'CARRILLO', 5),
(506, 'CAÑAS', 5),
(507, 'ABANGARES', 5),
(508, 'TILARÁN', 5),
(509, 'NANDAYURE', 5),
(510, 'LA CRUZ', 5),
(511, 'HOJANCHA', 5),
(601, 'PUNTARENAS', 6),
(602, 'ESPARZA', 6),
(603, 'BUENOS AIRES', 6),
(604, 'MONTES DE ORO', 6),
(605, 'OSA', 6),
(606, 'QUEPOS', 6),
(607, 'GOLFITO', 6),
(608, 'COTO BRUS', 6),
(609, 'PARRITA', 6),
(610, 'CORREDORES', 6),
(611, 'GARABITO', 6),
(701, 'LIMÓN', 7),
(702, 'POCOCÍ', 7),
(703, 'SIQUIRRES', 7),
(704, 'TALAMANCA', 7),
(705, 'MATINA', 7),
(706, 'GUÁCIMO', 7);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cliente`
--

CREATE TABLE `cliente` (
  `Id` int(11) NOT NULL,
  `Identificacion` varchar(20) NOT NULL,
  `Nombre` varchar(100) NOT NULL,
  `Telefono` varchar(15) NOT NULL,
  `Email` varchar(30) NOT NULL,
  `idDistrito` int(11) NOT NULL,
  `Direccion` varchar(500) NOT NULL,
  `Actividad` varchar(50) NOT NULL,
  `Regimen` tinyint(11) NOT NULL,
  `estadoHacienda` varchar(25) NOT NULL,
  `Status` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

--
-- RELACIONES PARA LA TABLA `cliente`:
--   `idDistrito`
--       `distrito` -> `Id`
--   `Regimen`
--       `regimen` -> `id`
--

--
-- Volcado de datos para la tabla `cliente`
--

INSERT INTO `cliente` (`Id`, `Identificacion`, `Nombre`, `Telefono`, `Email`, `idDistrito`, `Direccion`, `Actividad`, `Regimen`, `estadoHacienda`, `Status`) VALUES
(1, '603820149', 'JAIRO RAUL PEREZ RODRIGUEZ', '83182537', 'jrwc1989@gmail.com', 60102, '25 m Sur del CENCINAI', '', 1, 'Inscrito', 1),
(2, '1', 'CLIENTE', '12345678', 'email@correo.com', 60102, 'Pitahaya', '', 3, 'No Inscrito', 1),
(3, '604200872', 'VALERIA SOFIA MORA MORA', '86291347', 'vmora@correo.com', 60102, 'Pitahaya', '', 3, 'No inscrito', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `distrito`
--

CREATE TABLE `distrito` (
  `Id` int(11) NOT NULL,
  `nombreDistrito` varchar(50) NOT NULL,
  `idCanton` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

--
-- RELACIONES PARA LA TABLA `distrito`:
--   `idCanton`
--       `canton` -> `Id`
--

--
-- Volcado de datos para la tabla `distrito`
--

INSERT INTO `distrito` (`Id`, `nombreDistrito`, `idCanton`) VALUES
(10101, 'CARMEN', 101),
(10102, 'MERCED', 101),
(10103, 'HOSPITAL', 101),
(10104, 'CATEDRAL', 101),
(10105, 'ZAPOTE', 101),
(10106, 'SAN FRANCISCO DE DOS RÍOS', 101),
(10107, 'URUCA', 101),
(10108, 'MATA REDONDA', 101),
(10109, 'PAVAS', 101),
(10110, 'HATILLO', 101),
(10111, 'SAN SEBASTÍAN', 101),
(10201, 'ESCAZÚ', 102),
(10202, 'SAN ANTONIO', 102),
(10203, 'SAN RAFAEL', 102),
(10301, 'DESAMPARADOS', 103),
(10302, 'SAN MIGUEL', 103),
(10303, 'SAN JUAN DE DIOS', 103),
(10304, 'SAN RAFAEL ARRIBA', 103),
(10305, 'SAN ANTONIO', 103),
(10306, 'FRAILES', 103),
(10307, 'PATARRÁ', 103),
(10308, 'SAN CRISTOBAL ', 103),
(10309, 'ROSARIO', 103),
(10310, 'DAMAS', 103),
(10311, 'SAN RAFAEL ABAJO', 103),
(10312, 'GRAVILIAS', 103),
(10313, 'LOS GUIDO', 103),
(10401, 'SANTIAGO', 104),
(10402, 'MERCEDES SUR', 104),
(10403, 'BARBACOAS', 104),
(10404, 'GRIFO ALTO', 104),
(10405, 'SAN RAFAEL', 104),
(10406, 'CANDELARITA', 104),
(10407, 'DESAMPARADITOS', 104),
(10408, 'SAN ANTONIO', 104),
(10409, 'CHIRES', 104),
(10501, 'SAN MARCOS', 105),
(10502, 'SAN LORENZO', 105),
(10503, 'SAN CARLOS', 105),
(10601, 'ASERRÍ', 106),
(10602, 'TARBACA', 106),
(10603, 'VUELTA DE JORCO', 106),
(10604, 'SAN GABRIEL', 106),
(10605, 'LEGUA', 106),
(10606, 'MONTERREY', 106),
(10607, 'SALITRILLOS', 106),
(10701, 'COLÓN', 107),
(10702, 'GUAYABO', 107),
(10703, 'TABARCIA', 107),
(10704, 'PIEDRAS NEGRAS', 107),
(10705, 'PICAGRES', 107),
(10706, 'JARIS', 107),
(10801, 'GUADALUPE', 108),
(10802, 'SAN FRANCISCO', 108),
(10803, 'CALLE BLANCOS', 108),
(10804, 'MATA DE PLÁTANO', 108),
(10805, 'IPÍS', 108),
(10806, 'RANCHO REDONDO', 108),
(10807, 'PURRAL', 108),
(10901, 'SANTA ANA', 109),
(10902, 'SALITRAL', 109),
(10903, 'POZOS', 109),
(10904, 'URUCA ', 109),
(10905, 'PIEDADES', 109),
(10906, 'BRASIL', 109),
(11001, 'ALAJUELITA', 110),
(11002, 'SAN JOSECITO', 110),
(11003, 'SAN ANTONIO', 110),
(11004, 'CONCEPCIÓN', 110),
(11005, 'SAN FELIPE', 110),
(11101, 'SAN ISIDRO', 111),
(11102, 'SAN RAFAEL', 111),
(11103, 'DULCE NOMBRE DE JESÚS', 111),
(11104, 'PATALILLO', 111),
(11105, 'CASCAJAL', 111),
(11201, 'SAN IGNACIO', 112),
(11202, 'GUAITIL', 112),
(11203, 'PALMICHAL', 112),
(11204, 'CANGREJAL', 112),
(11205, 'SABANILLAS', 112),
(11301, 'SAN JUAN', 113),
(11302, 'CINCO ESQUINAS', 113),
(11303, 'ANSELMO LLORENTE', 113),
(11304, 'LEÓN XIII', 113),
(11305, 'COLIMA', 113),
(11401, 'SAN VICENTE', 114),
(11402, 'SAN JERÓNIMO', 114),
(11403, 'LA TRINIDAD', 114),
(11501, 'SAN PEDRO', 115),
(11502, 'SABANILLA', 115),
(11503, 'MERCEDES', 115),
(11504, 'SAN RAFAEL', 115),
(11601, 'SAN PABLO', 116),
(11602, 'SAN PEDRO', 116),
(11603, 'SAN JUAN DE MATA', 116),
(11604, 'SAN LUIS', 116),
(11605, 'CARARA', 116),
(11701, 'SANTA MARÍA', 117),
(11702, 'EL JARDÍN', 117),
(11703, 'COPEY', 117),
(11801, 'CURRIDABAT', 118),
(11802, 'GRANADILLA', 118),
(11803, 'SÁNCHEZ', 118),
(11804, 'TIRRASES', 118),
(11901, 'SAN ISIDRO DE EL GENERAL', 119),
(11902, 'EL GENERAL', 119),
(11903, 'DANIEL FLORES', 119),
(11904, 'RIVAS', 119),
(11905, 'SAN PEDRO', 119),
(11906, 'PLATANARES', 119),
(11907, 'PEJIBAYE', 119),
(11908, 'CAJÓN', 119),
(11909, 'BARÚ', 119),
(11910, 'RÍO NUEVO', 119),
(11911, 'PÁRAMO', 119),
(11912, 'LA AMISTAD', 119),
(12001, 'SAN PABLO', 120),
(12002, 'SAN ANDRÉS', 120),
(12003, 'LLANO BONITO', 120),
(12004, 'SAN ISIDRO', 120),
(12005, 'SANTA CRUZ', 120),
(12006, 'SAN ANTONIO', 120),
(20101, 'ALAJUELA', 201),
(20102, 'SAN JOSÉ', 201),
(20103, 'CARRIZAL', 201),
(20104, 'SAN ANTONIO', 201),
(20105, 'GUÁCIMA', 201),
(20106, 'SAN ISIDRO', 201),
(20107, 'SABANILLA', 201),
(20108, 'SAN RAFAEL', 201),
(20109, 'RÍO SEGUNDO', 201),
(20110, 'DESAMPARADOS', 201),
(20111, 'TURRÚCARES', 201),
(20112, 'TAMBOR', 201),
(20113, 'GARITA', 201),
(20114, 'SARAPIQUÍ ', 201),
(20201, 'SAN RAMÓN', 202),
(20202, 'SANTIAGO', 202),
(20203, 'SAN JUAN', 202),
(20204, 'PIEDADES NORTE', 202),
(20205, 'PIEDADES SUR', 202),
(20206, 'SAN RAFAEL', 202),
(20207, 'SAN ISIDRO', 202),
(20208, 'ÁNGELES', 202),
(20209, 'ALFARO', 202),
(20210, 'VOLIO', 202),
(20211, 'CONCEPCIÓN', 202),
(20212, 'ZAPOTAL', 202),
(20213, 'PEÑAS BLANCAS', 202),
(20301, 'GRECIA', 203),
(20302, 'SAN ISIDRO', 203),
(20303, 'SAN JOSÉ', 203),
(20304, 'SAN ROQUE', 203),
(20305, 'TACARES', 203),
(20306, 'RÍO CUARTO', 203),
(20307, 'PUENTE DE PIEDRA', 203),
(20308, 'BOLÍVAR', 203),
(20401, 'SAN MATEO', 204),
(20402, 'DESMONTE', 204),
(20403, 'JESÚS MARÍA', 204),
(20404, 'LABRADOR', 204),
(20501, 'ATENAS', 205),
(20502, 'JESÚS', 205),
(20503, 'MERCEDES', 205),
(20504, 'SAN ISIDRO', 205),
(20505, 'CONCEPCIÓN', 205),
(20506, 'SAN JOSÉ', 205),
(20507, 'SANTA EULALIA', 205),
(20508, 'ESCOBAL', 205),
(20601, 'NARANJO', 206),
(20602, 'SAN MIGUEL', 206),
(20603, 'SAN JOSÉ', 206),
(20604, 'CIRRÍ SUR', 206),
(20605, 'SAN JERÓNIMO', 206),
(20606, 'SAN JUAN', 206),
(20607, 'EL ROSARIO', 206),
(20608, 'PALMITOS', 206),
(20701, 'PALMARES', 207),
(20702, 'ZARAGOZA', 207),
(20703, 'BUENOS AIRES', 207),
(20704, 'SANTIAGO', 207),
(20705, 'CANDELARIA', 207),
(20706, 'ESQUIPULAS', 207),
(20707, 'LA GRANJA', 207),
(20801, 'SAN PEDRO', 208),
(20802, 'SAN JUAN ', 208),
(20803, 'SAN RAFAEL', 208),
(20804, 'CARRILLOS', 208),
(20805, 'SABANA REDONDA', 208),
(20901, 'OROTINA', 209),
(20902, 'EL MASTATE', 209),
(20903, 'HACIENDA VIEJA', 209),
(20904, 'COYOLAR', 209),
(20905, 'LA CEIBA', 209),
(21001, 'QUESADA', 210),
(21002, 'FLORENCIA', 210),
(21003, 'BUENAVISTA', 210),
(21004, 'AGUAS ZARCAS', 210),
(21005, 'VENECIA', 210),
(21006, 'PITAL', 210),
(21007, 'LA FORTUNA', 210),
(21008, 'LA TIGRA', 210),
(21009, 'LA PALMERA', 210),
(21010, 'VENADO', 210),
(21011, 'CUTRIS', 210),
(21012, 'MONTERREY', 210),
(21013, 'POCOSOL', 210),
(21101, 'ZARCERO', 211),
(21102, 'LAGUNA', 211),
(21103, 'TAPESCO', 211),
(21104, 'GUADALUPE', 211),
(21105, 'PALMIRA', 211),
(21106, 'ZAPOTE', 211),
(21107, 'BRISAS', 211),
(21201, 'SARCHÍ NORTE', 212),
(21202, 'SARCHÍ SUR', 212),
(21203, 'TORO AMARILLO', 212),
(21204, 'SAN PEDRO', 212),
(21205, 'RODRÍGUEZ', 212),
(21301, 'UPALA', 213),
(21302, 'AGUAS CLARAS', 213),
(21303, 'SAN JOSÉ O PIZOTE', 213),
(21304, 'BIJAGUA', 213),
(21305, 'DELICIAS', 213),
(21306, 'DOS RÍOS', 213),
(21307, 'YOLILLAL', 213),
(21308, 'CANALETE', 213),
(21401, 'LOS CHILES', 214),
(21402, 'CAÑO NEGRO', 214),
(21403, 'EL AMPARO', 214),
(21404, 'SAN JORGE', 214),
(21501, 'SAN RAFAEL', 215),
(21502, 'BUENAVISTA', 215),
(21503, 'COTE', 215),
(21504, 'KATIRA', 215),
(30101, 'ORIENTAL', 301),
(30102, 'OCCIDENTAL ', 301),
(30103, 'CARMEN', 301),
(30104, 'SAN NICOLÁS', 301),
(30105, 'AGUACALIENTE O SAN FRANCISCO', 301),
(30106, 'GUADALUPE O ARENILLA', 301),
(30107, 'CORRALILLO', 301),
(30108, 'TIERRA BLANCA', 301),
(30109, 'DULCE NOMBRE', 301),
(30110, 'LLANO GRANDE', 301),
(30111, 'QUEBRADILLA', 301),
(30201, 'PARAÍSO', 302),
(30202, 'SANTIAGO', 302),
(30203, 'OROSI', 302),
(30204, 'CACHÍ', 302),
(30205, 'LLANOS DE SANTA LUCÍA', 302),
(30301, 'TRES RÍOS', 303),
(30302, 'SAN DIEGO', 303),
(30303, 'SAN JUAN', 303),
(30304, 'SAN RAFAEL', 303),
(30305, 'CONCEPCIÓN', 303),
(30306, 'DULCE NOMBRE', 303),
(30307, 'SAN RAMÓN', 303),
(30308, 'RÍO AZUL', 303),
(30401, 'JUAN VIÑAS', 304),
(30402, 'TUCURRIQUE', 304),
(30403, 'PEJIBAYE', 304),
(30501, 'TURRIALBA', 305),
(30502, 'LA SUIZA', 305),
(30503, 'PERALTA', 305),
(30504, 'SANTA CRUZ', 305),
(30505, 'SANTA TERESITA', 305),
(30506, 'PAVONES', 305),
(30507, 'TUIS', 305),
(30508, 'TAYUTIC', 305),
(30509, 'SANTA ROSA', 305),
(30510, 'TRES EQUIS', 305),
(30511, 'LA ISABEL', 305),
(30512, 'CHIRRIPÓ', 305),
(30601, 'PACAYAS', 306),
(30602, 'CERVANTES', 306),
(30603, 'CAPELLADES', 306),
(30701, 'SAN RAFAEL', 307),
(30702, 'COT', 307),
(30703, 'POTRERO CERRADO', 307),
(30704, 'CIPRESES', 307),
(30705, 'SANTA ROSA', 307),
(30801, 'EL TEJAR', 308),
(30802, 'SAN ISIDRO', 308),
(30803, 'TOBOSI', 308),
(30804, 'PATIO DE AGUA', 308),
(40101, 'HEREDIA', 401),
(40102, 'MERCEDES', 401),
(40103, 'SAN FRANCISCO ', 401),
(40104, 'ULLOA ', 401),
(40105, 'VARABLANCA', 401),
(40201, 'BARVA', 402),
(40202, 'SAN PEDRO', 402),
(40203, 'SAN PABLO', 402),
(40204, 'SAN ROQUE', 402),
(40205, 'SANTA LUCÍA', 402),
(40206, 'SAN JOSÉ DE LA MONTAÑA', 402),
(40301, 'SANTO DOMINGO', 403),
(40302, 'SAN VICENTE', 403),
(40303, 'SAN MIGUEL', 403),
(40304, 'PARACITO', 403),
(40305, 'SANTO TOMÁS', 403),
(40306, 'SANTA ROSA', 403),
(40307, 'TURES', 403),
(40308, 'PARÁ', 403),
(40401, 'SANTA BÁRBARA', 404),
(40402, 'SAN PEDRO', 404),
(40403, 'SAN JUAN', 404),
(40404, 'JESÚS', 404),
(40405, 'SANTO DOMINGO', 404),
(40406, 'PURABÁ', 404),
(40501, 'SAN RAFAEL', 405),
(40502, 'SAN JOSECITO', 405),
(40503, 'SANTIAGO', 405),
(40504, 'ÁNGELES', 405),
(40505, 'CONCEPCIÓN', 405),
(40601, 'SAN ISIDRO', 406),
(40602, 'SAN JOSÉ', 406),
(40603, 'CONCEPCIÓN', 406),
(40604, 'SAN FRANCISCO ', 406),
(40701, 'SAN ANTONIO', 407),
(40702, 'LA RIBERA', 407),
(40703, 'LA ASUNCIÓN', 407),
(40801, 'SAN JOAQUÍN', 408),
(40802, 'BARRANTES', 408),
(40803, 'LLORENTE', 408),
(40901, 'SAN PABLO', 409),
(40902, 'RINCÓN DE SABANILLA', 409),
(41001, 'PUERTO VIEJO ', 410),
(41002, 'LA VIRGEN', 410),
(41003, 'LAS HORQUETAS', 410),
(41004, 'LLANURAS DEL GASPAR', 410),
(41005, 'CUREÑA', 410),
(50101, 'LIBERIA', 501),
(50102, 'CAÑAS DULCES', 501),
(50103, 'MAYORGA', 501),
(50104, 'NACASCOLO', 501),
(50105, 'CURUBANDÉ', 501),
(50201, 'NICOYA', 502),
(50202, 'MANSIÓN', 502),
(50203, 'SAN ANTONIO', 502),
(50204, 'QUEBRADA HONDA', 502),
(50205, 'SÁMARA', 502),
(50206, 'NOSARA', 502),
(50207, 'BELÉN DE NOSARITA', 502),
(50301, 'SANTA CRUZ', 503),
(50302, 'BOLSÓN', 503),
(50303, 'VEINTISIETE DE ABRIL', 503),
(50304, 'TEMPATE', 503),
(50305, 'CARTAGENA', 503),
(50306, 'CUAJINIQUIL', 503),
(50307, 'DIRIÁ', 503),
(50308, 'CABO VELAS', 503),
(50309, 'TAMARINDO', 503),
(50401, 'BAGACES', 504),
(50402, 'LA FORTUNA', 504),
(50403, 'MOGOTE', 504),
(50404, 'RÍO NARANJO', 504),
(50501, 'FILADELFIA', 505),
(50502, 'PALMIRA', 505),
(50503, 'SARDINAL', 505),
(50504, 'BELÉN', 505),
(50601, 'CAÑAS', 506),
(50602, 'PALMIRA', 506),
(50603, 'SAN MIGUEL', 506),
(50604, 'BEBEDERO', 506),
(50605, 'POROZAL', 506),
(50701, 'LAS JUNTAS', 507),
(50702, 'SIERRA', 507),
(50703, 'SAN JUAN ', 507),
(50704, 'COLORADO', 507),
(50801, 'TILARÁN', 508),
(50802, 'QUEBRADA GRANDE', 508),
(50803, 'TRONADORA', 508),
(50804, 'SANTA ROSA', 508),
(50805, 'LÍBANO', 508),
(50806, 'TIERRAS MORENAS', 508),
(50807, 'ARENAL', 508),
(50901, 'CARMONA', 509),
(50902, 'SANTA RITA', 509),
(50903, 'ZAPOTAL', 509),
(50904, 'SAN PABLO', 509),
(50905, 'PORVENIR', 509),
(50906, 'BEJUCO', 509),
(51001, 'LA CRUZ', 510),
(51002, 'SANTA CECILIA', 510),
(51003, 'LA GARITA', 510),
(51004, 'SANTA ELENA', 510),
(51101, 'HOJANCHA', 511),
(51102, 'MONTE ROMO', 511),
(51103, 'PUERTO CARRILLO', 511),
(51104, 'HUACAS', 511),
(60101, 'PUNTARENAS', 601),
(60102, 'PITAHAYA', 601),
(60103, 'CHOMES', 601),
(60104, 'LEPANTO', 601),
(60105, 'PAQUERA', 601),
(60106, 'MANZANILLO', 601),
(60107, 'GUACIMAL', 601),
(60108, 'BARRANCA', 601),
(60109, 'MONTE VERDE', 601),
(60110, 'ISLA DEL COCO', 601),
(60111, 'CÓBANO', 601),
(60112, 'CHACARITA', 601),
(60113, 'CHIRA', 601),
(60114, 'ACAPULCO', 601),
(60115, 'EL ROBLE', 601),
(60116, 'ARANCIBIA', 601),
(60201, 'ESPÍRITU SANTO ', 602),
(60202, 'SAN JUAN GRANDE', 602),
(60203, 'MACACONA', 602),
(60204, 'SAN RAFAEL', 602),
(60205, 'SAN JERÓNIMO', 602),
(60206, 'CALDERA', 602),
(60301, 'BUENOS AIRES', 603),
(60302, 'VOLCÁN', 603),
(60303, 'POTRERO GRANDE', 603),
(60304, 'BORUCA', 603),
(60305, 'PILAS', 603),
(60306, 'COLINAS', 603),
(60307, 'CHÁNGUENA', 603),
(60308, 'BIOLLEY', 603),
(60309, 'BRUNKA', 603),
(60401, 'MIRAMAR', 604),
(60402, 'LA UNIÓN', 604),
(60403, 'SAN ISIDRO', 604),
(60501, 'PUERTO CORTÉS', 605),
(60502, 'PALMAR', 605),
(60503, 'SIERPE', 605),
(60504, 'BAHÍA BALLENA', 605),
(60505, 'PIEDRAS BLANCAS', 605),
(60506, 'BAHÍA DRAKE', 605),
(60601, 'QUEPOS', 606),
(60602, 'SAVEGRE', 606),
(60603, 'NARANJITO', 606),
(60701, 'GOLFITO', 607),
(60702, 'PUERTO JIMÉNEZ', 607),
(60703, 'GUAYCARÁ', 607),
(60704, 'PAVÓN', 607),
(60801, 'SAN VITO', 608),
(60802, 'SABALITO', 608),
(60803, 'AGUA BUENA', 608),
(60804, 'LIMONCITO', 608),
(60805, 'PITTIER', 608),
(60901, 'PARRITA', 609),
(61001, 'CORREDOR', 610),
(61002, 'LA CUESTA', 610),
(61003, 'CANOAS', 610),
(61004, 'LAUREL', 610),
(61101, 'JACÓ', 611),
(61102, 'TÁRCOLES', 611),
(70101, 'LIMÓN', 701),
(70102, 'VALLE LA ESTRELLA', 701),
(70103, 'RÍO BLANCO ', 701),
(70104, 'MATAMA', 701),
(70201, 'GUÁPILES', 702),
(70202, 'JIMÉNEZ', 702),
(70203, 'RITA', 702),
(70204, 'ROXANA', 702),
(70205, 'CARIARI', 702),
(70206, 'COLORADO ', 702),
(70207, 'LA COLONIA', 702),
(70301, 'SIQUIRRES', 703),
(70302, 'PACUARITO', 703),
(70303, 'FLORIDA', 703),
(70304, 'GERMANIA', 703),
(70305, 'EL CAIRO', 703),
(70306, 'ALEGRÍA', 703),
(70401, 'BRATSI', 704),
(70402, 'SIXAOLA', 704),
(70403, 'CAHUITA', 704),
(70404, 'TELIRE', 704),
(70501, 'MATINA', 705),
(70502, 'BATÁN', 705),
(70503, 'CARRANDI', 705),
(70601, 'GUÁCIMO', 706),
(70602, 'MERCEDES ', 706),
(70603, 'POCORA', 706),
(70604, 'RÍO JIMÉNEZ', 706),
(70605, 'DUACARÍ', 706);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `factura`
--

CREATE TABLE `factura` (
  `id` int(11) NOT NULL,
  `fecha` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `nfactura` varchar(50) NOT NULL,
  `tipo_factura` int(11) NOT NULL,
  `tipo_pago` varchar(3) NOT NULL,
  `idCliente` int(11) NOT NULL,
  `m_subtotal` decimal(10,2) NOT NULL,
  `m_iva` decimal(10,2) NOT NULL,
  `m_total` decimal(10,2) NOT NULL,
  `estado` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

--
-- RELACIONES PARA LA TABLA `factura`:
--   `idCliente`
--       `cliente` -> `Id`
--   `tipo_factura`
--       `tipo_documento` -> `id`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `factura_detalle`
--

CREATE TABLE `factura_detalle` (
  `id` int(11) NOT NULL,
  `idFactura` int(11) NOT NULL,
  `idProducto` int(11) NOT NULL,
  `cantidad` decimal(10,3) NOT NULL,
  `preUnitario` decimal(10,2) NOT NULL,
  `subtotal` decimal(10,2) NOT NULL,
  `iva` decimal(10,2) NOT NULL,
  `total` decimal(10,2) NOT NULL,
  `estado` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

--
-- RELACIONES PARA LA TABLA `factura_detalle`:
--   `idFactura`
--       `factura` -> `id`
--   `idProducto`
--       `producto` -> `id`
--

--
-- Disparadores `factura_detalle`
--
DELIMITER $$
CREATE TRIGGER `update_inventario` BEFORE INSERT ON `factura_detalle` FOR EACH ROW BEGIN
	UPDATE inventario SET cantidad = cantidad - new.cantidad WHERE idProducto = new.idProducto;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `inventario`
--

CREATE TABLE `inventario` (
  `idProducto` int(11) NOT NULL,
  `cantidad` decimal(10,3) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

--
-- RELACIONES PARA LA TABLA `inventario`:
--   `idProducto`
--       `producto` -> `id`
--

--
-- Volcado de datos para la tabla `inventario`
--

INSERT INTO `inventario` (`idProducto`, `cantidad`) VALUES
(1, '55.000'),
(2, '40.000'),
(3, '32.000'),
(4, '33.000'),
(5, '40.000'),
(6, '50.000'),
(7, '48.000'),
(8, '15.000'),
(9, '29.000'),
(10, '20.000'),
(11, '50.000'),
(12, '60.000'),
(13, '125.000'),
(14, '60.000'),
(15, '5.000'),
(16, '25.000');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `producto`
--

CREATE TABLE `producto` (
  `id` int(11) NOT NULL,
  `codigo` varchar(30) DEFAULT NULL,
  `name` varchar(50) NOT NULL,
  `price` decimal(10,0) NOT NULL,
  `description` varchar(100) NOT NULL,
  `measure` varchar(15) NOT NULL,
  `minimo` tinyint(4) NOT NULL DEFAULT 10,
  `state` tinyint(1) NOT NULL,
  `img` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

--
-- RELACIONES PARA LA TABLA `producto`:
--

--
-- Volcado de datos para la tabla `producto`
--

INSERT INTO `producto` (`id`, `codigo`, `name`, `price`, `description`, `measure`, `minimo`, `state`, `img`) VALUES
(1, '123456789', 'Coca cola Retornable 2.5L', '1300', 'Coca cola Retornable 2.5L', 'UND', 10, 1, 'coca cola 2.5 L.jpg'),
(2, '123456700', 'Fanta Naranja Retornable 2 L', '1250', 'Fanta Naranja Retornable 2 L', 'UND', 10, 1, 'fanta naranja 2L.jpg'),
(3, '123456701', 'Fanta Naranja 600 ml', '875', 'Fanta Naranja 600 ml', 'UND', 10, 1, 'fanta naranja 600 ml.jpg'),
(4, '35', 'Yuca', '1265', 'Yuca', 'K', 10, 1, 'yuca-portada.jpg'),
(5, '325', 'Culantro', '325', 'Culantro', 'UND', 6, 1, 'culantro.jpeg'),
(6, '785', 'Zanahoria', '785', 'Zanahoria', 'K', 8, 1, 'zanahoria.jpeg'),
(7, '123000000', 'Coca Cola 600 ml', '650', 'Coca Cola 600 ml', 'UND', 10, 1, 'coca cola 600ml.jpeg'),
(8, '120000000', 'Big Cola 3 L', '1100', 'Big Cola 3 L', 'UND', 10, 1, 'big cola 3 l.jpeg'),
(9, '100000000', 'Tomate', '1975', 'Tomate', 'K', 10, 1, 'tomate.jpeg'),
(10, '7441163414564', 'Chiky Minichips', '250', 'Chiky Minichips', 'UND', 5, 1, 'chiky.jpeg'),
(11, '1785', 'Papa Blanca', '1785', 'Papa Blanca', 'K', 10, 1, 'papa.jpeg'),
(12, '7441134014045', 'Chocoleta Paquita Sabor Mani', '350', 'Chocoleta Paquita Sabor Mani - Marca Sensacion', 'UND', 10, 1, 'sinfoto.png'),
(13, '7503034941200', 'Corona Extra 355 ml', '1250', 'Corona Extra 355 ml', 'UND', 20, 1, 'sinfoto.png'),
(14, '72569874423', 'Royal Flan Vitamina C', '450', 'Royal Flan Vitamina C', 'UND', 5, 1, 'flan vitamina c.jpeg'),
(15, '025215723841', 'Bateria Alkaline AAA Maxell x4', '2100', 'Bateria Alkaline AAA Maxell x4', 'UND', 5, 1, 'sinfoto.png'),
(16, '8728915781082', 'Disco de corte 9\"x5/64\"x7/8\" Hilco', '2450', 'Disco de corte 9\"x5/64\"x7/8\" Hilco', 'UND', 10, 1, 'sinfoto.png');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `provincia`
--

CREATE TABLE `provincia` (
  `Id` int(11) NOT NULL,
  `NombreProvincia` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

--
-- RELACIONES PARA LA TABLA `provincia`:
--

--
-- Volcado de datos para la tabla `provincia`
--

INSERT INTO `provincia` (`Id`, `NombreProvincia`) VALUES
(1, 'SAN JOSE'),
(2, 'ALAJUELA'),
(3, 'CARTAGO'),
(4, 'HEREDIA'),
(5, 'GUANACASTE'),
(6, 'PUNTARENAS'),
(7, 'LIMON');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `regimen`
--

CREATE TABLE `regimen` (
  `id` tinyint(4) NOT NULL,
  `codigo` varchar(5) NOT NULL,
  `regimen` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

--
-- RELACIONES PARA LA TABLA `regimen`:
--

--
-- Volcado de datos para la tabla `regimen`
--

INSERT INTO `regimen` (`id`, `codigo`, `regimen`) VALUES
(1, 'RTT', 'Factura Electrónica'),
(2, 'RTS', 'Simplificado'),
(3, 'RTO', 'Otro');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `rol`
--

CREATE TABLE `rol` (
  `Id` int(11) NOT NULL,
  `nombreRol` varchar(30) NOT NULL,
  `descripcion` varchar(50) NOT NULL,
  `status` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

--
-- RELACIONES PARA LA TABLA `rol`:
--

--
-- Volcado de datos para la tabla `rol`
--

INSERT INTO `rol` (`Id`, `nombreRol`, `descripcion`, `status`) VALUES
(1, 'Administrador', 'Encargado general del sistema', 1),
(2, 'Cajero', 'Encargado de ventas e inventarios', 1),
(3, 'Proveedor', 'Encargado de proveer productos', 1),
(4, 'Asistente Administrativo', 'Controla registro y documentación general de la em', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipo_documento`
--

CREATE TABLE `tipo_documento` (
  `id` int(11) NOT NULL,
  `codigo` varchar(2) NOT NULL,
  `nombre` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

--
-- RELACIONES PARA LA TABLA `tipo_documento`:
--

--
-- Volcado de datos para la tabla `tipo_documento`
--

INSERT INTO `tipo_documento` (`id`, `codigo`, `nombre`) VALUES
(1, '01', 'Factura electrónica'),
(2, '02', 'Tiquete Electrónico'),
(3, '03', 'Voucher');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `unidad_medida`
--

CREATE TABLE `unidad_medida` (
  `id` tinyint(4) NOT NULL,
  `unidad` varchar(15) NOT NULL,
  `nomenclatura` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

--
-- RELACIONES PARA LA TABLA `unidad_medida`:
--

--
-- Volcado de datos para la tabla `unidad_medida`
--

INSERT INTO `unidad_medida` (`id`, `unidad`, `nomenclatura`) VALUES
(1, 'Kilogramo', 'K'),
(2, 'Gramos', 'G'),
(3, 'Litro', 'L'),
(4, 'Mililitro', 'ML'),
(5, 'Unidad', 'UND');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `email` varchar(30) NOT NULL,
  `username` varchar(30) NOT NULL,
  `password` varchar(30) NOT NULL,
  `dni` varchar(25) NOT NULL,
  `name` varchar(35) NOT NULL,
  `surnames` varchar(50) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `idRol` int(4) NOT NULL,
  `status` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

--
-- RELACIONES PARA LA TABLA `user`:
--   `idRol`
--       `rol` -> `Id`
--

--
-- Volcado de datos para la tabla `user`
--

INSERT INTO `user` (`id`, `email`, `username`, `password`, `dni`, `name`, `surnames`, `phone`, `idRol`, `status`) VALUES
(1, 'jrwc1989@gmail.com', 'jperez', 'Vsmora1989', '603830158', 'Jairo', 'Pérez Rodríguez', '83182537', 1, 1);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `canton`
--
ALTER TABLE `canton`
  ADD PRIMARY KEY (`Id`),
  ADD KEY `FK_IdProvincia` (`IdProvincia`);

--
-- Indices de la tabla `cliente`
--
ALTER TABLE `cliente`
  ADD PRIMARY KEY (`Id`),
  ADD KEY `idDistrito_Distrito` (`idDistrito`),
  ADD KEY `idRegimen_Regimen` (`Regimen`);

--
-- Indices de la tabla `distrito`
--
ALTER TABLE `distrito`
  ADD PRIMARY KEY (`Id`),
  ADD KEY `idDistrito` (`idCanton`);

--
-- Indices de la tabla `factura`
--
ALTER TABLE `factura`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idCliente_Cliente` (`idCliente`),
  ADD KEY `idTipoFactura_TipoFactura` (`tipo_factura`);

--
-- Indices de la tabla `factura_detalle`
--
ALTER TABLE `factura_detalle`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idFactura_Factura` (`idFactura`),
  ADD KEY `idProducto_Producto` (`idProducto`);

--
-- Indices de la tabla `inventario`
--
ALTER TABLE `inventario`
  ADD PRIMARY KEY (`idProducto`);

--
-- Indices de la tabla `producto`
--
ALTER TABLE `producto`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `provincia`
--
ALTER TABLE `provincia`
  ADD PRIMARY KEY (`Id`);

--
-- Indices de la tabla `regimen`
--
ALTER TABLE `regimen`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `rol`
--
ALTER TABLE `rol`
  ADD PRIMARY KEY (`Id`);

--
-- Indices de la tabla `tipo_documento`
--
ALTER TABLE `tipo_documento`
  ADD PRIMARY KEY (`id`) USING BTREE;

--
-- Indices de la tabla `unidad_medida`
--
ALTER TABLE `unidad_medida`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IdRol` (`idRol`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `canton`
--
ALTER TABLE `canton`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=707;

--
-- AUTO_INCREMENT de la tabla `cliente`
--
ALTER TABLE `cliente`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `factura`
--
ALTER TABLE `factura`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `factura_detalle`
--
ALTER TABLE `factura_detalle`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `producto`
--
ALTER TABLE `producto`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT de la tabla `provincia`
--
ALTER TABLE `provincia`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de la tabla `regimen`
--
ALTER TABLE `regimen`
  MODIFY `id` tinyint(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `rol`
--
ALTER TABLE `rol`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de la tabla `tipo_documento`
--
ALTER TABLE `tipo_documento`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `unidad_medida`
--
ALTER TABLE `unidad_medida`
  MODIFY `id` tinyint(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `canton`
--
ALTER TABLE `canton`
  ADD CONSTRAINT `FK_IdProvincia` FOREIGN KEY (`IdProvincia`) REFERENCES `provincia` (`Id`);

--
-- Filtros para la tabla `cliente`
--
ALTER TABLE `cliente`
  ADD CONSTRAINT `idDistrito_Distrito` FOREIGN KEY (`idDistrito`) REFERENCES `distrito` (`Id`),
  ADD CONSTRAINT `idRegimen_Regimen` FOREIGN KEY (`Regimen`) REFERENCES `regimen` (`id`);

--
-- Filtros para la tabla `distrito`
--
ALTER TABLE `distrito`
  ADD CONSTRAINT `idDistrito` FOREIGN KEY (`idCanton`) REFERENCES `canton` (`Id`);

--
-- Filtros para la tabla `factura`
--
ALTER TABLE `factura`
  ADD CONSTRAINT `idCliente_Cliente` FOREIGN KEY (`idCliente`) REFERENCES `cliente` (`Id`),
  ADD CONSTRAINT `idTipoFactura_TipoFactura` FOREIGN KEY (`tipo_factura`) REFERENCES `tipo_documento` (`id`);

--
-- Filtros para la tabla `factura_detalle`
--
ALTER TABLE `factura_detalle`
  ADD CONSTRAINT `idFactura_Factura` FOREIGN KEY (`idFactura`) REFERENCES `factura` (`id`),
  ADD CONSTRAINT `idProducto_Producto` FOREIGN KEY (`idProducto`) REFERENCES `producto` (`id`);

--
-- Filtros para la tabla `inventario`
--
ALTER TABLE `inventario`
  ADD CONSTRAINT `idProdcuto_Producto` FOREIGN KEY (`idProducto`) REFERENCES `producto` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `user`
--
ALTER TABLE `user`
  ADD CONSTRAINT `IdRol` FOREIGN KEY (`idRol`) REFERENCES `rol` (`Id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
