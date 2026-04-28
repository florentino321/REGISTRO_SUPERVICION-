-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 28-04-2026 a las 02:00:23
-- Versión del servidor: 10.4.32-MariaDB
-- Versión de PHP: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `db_darwin`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `accion`
--

CREATE TABLE `accion` (
  `ID_ACCION` int(11) NOT NULL,
  `NOMBRE_ABREVIADO` varchar(50) DEFAULT NULL,
  `NOMBRE_ACCION` varchar(50) DEFAULT NULL,
  `CODIGO_A_E` varchar(50) DEFAULT NULL,
  `CODIGO_P_ACCION` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `accion`
--

INSERT INTO `accion` (`ID_ACCION`, `NOMBRE_ABREVIADO`, `NOMBRE_ACCION`, `CODIGO_A_E`, `CODIGO_P_ACCION`) VALUES
(1, '31.1 Preoperativa y denuncias', 'Fiscalización Preoperativa y Denuncias', 'K31.1', NULL),
(2, '31.2 Comercialización', 'Fiscalización de comercialización de Hidrocarburos', 'K31.2', NULL),
(3, '31.3 Instalaciones y MT', 'Fiscalización de Instalaciones y medios de transpo', 'K31.3', NULL),
(4, '31.4 Calidad y cantidad', 'Fiscalización de la calidad y cantidad de los comb', 'K31.4', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `accion_especifica`
--

CREATE TABLE `accion_especifica` (
  `ID_AE` int(11) NOT NULL,
  `ID_ACCION` int(11) DEFAULT NULL,
  `NOMBRE_ABREVIADO` varchar(50) NOT NULL DEFAULT '0',
  `ACCION_ESPECIFICA` varchar(50) NOT NULL DEFAULT '0',
  `CODIGO_A_E` varchar(50) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `accion_especifica`
--

INSERT INTO `accion_especifica` (`ID_AE`, `ID_ACCION`, `NOMBRE_ABREVIADO`, `ACCION_ESPECIFICA`, `CODIGO_A_E`) VALUES
(1, 1, '1.1 RHO en toda la cadena', '31.1.1 Administración y otorgamiento del Registro ', 'K31.1.1'),
(2, 1, '1.2 ITF', '31.1.2 Atención de solicitudes de informe técnico ', 'K31.1.2'),
(3, 1, '1.3 Certificado para GNV, GNC, GNL', '31.1.3 Atención solicitudes de certificado de fisc', 'K31.1.3'),
(4, 1, '1.4 Actas pruebas y conformidad', '31.1.4 Actas de verificación de pruebas y de confo', 'K31.1.4'),
(5, 1, '1.5 Denuncias', '31.1.5 Fiscalización de denuncias', 'K31.1.5'),
(6, 2, '2.1 PRICE', '31.2.1 Fiscalización PRICE', 'K31.2.1'),
(7, 2, '2.2 RIC', '31.2.2 Fiscalización RIC (GNV, GNC, GNL)', 'K31.2.2'),
(8, 2, '2.3 Control Volumétrico', '31.2.3 Fiscalización de Control Volumétrico', 'K31.2.3'),
(9, 2, '2.4 GPS', '31.2.4 Fiscalización GPS', 'K31.2.4'),
(10, 2, '2.5 SCOP', '31.2.5 Fiscalización SCOP', 'K31.2.5');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `actividad`
--

CREATE TABLE `actividad` (
  `ID_ACTIVIDAD` int(11) NOT NULL,
  `NOMBRE_ACTIVIDAD` varchar(50) NOT NULL DEFAULT '0',
  `CODIGO_ACTIVIDAD` varchar(50) NOT NULL DEFAULT '0',
  `ID_TA` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `actividad`
--

INSERT INTO `actividad` (`ID_ACTIVIDAD`, `NOMBRE_ACTIVIDAD`, `CODIGO_ACTIVIDAD`, `ID_TA`) VALUES
(1, 'Revisión de cableado', 'ACT-RED-01', 1),
(2, 'Escaneo de vulnerabilidades', 'ACT-SOFT-01', 2);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detalle_registro`
--

CREATE TABLE `detalle_registro` (
  `ID_REGISTRO` int(11) NOT NULL,
  `ID_ACCION` int(11) DEFAULT 0,
  `ID_AE` int(11) DEFAULT 0,
  `ID_SA` int(11) DEFAULT 0,
  `ID_TA` int(11) DEFAULT 0,
  `id_tt` int(11) DEFAULT 0,
  `id_zd` int(11) DEFAULT 0,
  `id_zp` int(11) DEFAULT 0,
  `ID_ACTIVIDAD` int(11) DEFAULT NULL,
  `NUM_SUPERVISORES` varchar(50) DEFAULT NULL,
  `EMPRESA_SUPERVISORA` varchar(50) DEFAULT NULL,
  `CALIDAD_ENTREGABLE` varchar(50) DEFAULT NULL,
  `NRO_EXPEDIENTE` varchar(50) DEFAULT NULL,
  `CARTA_LINEA` varchar(50) DEFAULT NULL,
  `OBSERVACIONES` varchar(50) DEFAULT NULL,
  `CONTRATO` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `detalle_registro`
--

INSERT INTO `detalle_registro` (`ID_REGISTRO`, `ID_ACCION`, `ID_AE`, `ID_SA`, `ID_TA`, `id_tt`, `id_zd`, `id_zp`, `ID_ACTIVIDAD`, `NUM_SUPERVISORES`, `EMPRESA_SUPERVISORA`, `CALIDAD_ENTREGABLE`, `NRO_EXPEDIENTE`, `CARTA_LINEA`, `OBSERVACIONES`, `CONTRATO`) VALUES
(1, 1, 1, 0, 3, 2, 3, 1, 1, NULL, NULL, NULL, 'EXP_122', NULL, 'SU EQUIPO SE DAÑO ', '12133644'),
(2, 1, 5, 0, 2, 1, 2, 1, 1, NULL, NULL, NULL, 'EXP_122', NULL, '22001', '12133644'),
(3, 1, 2, 0, 1, 1, 1, 1, 2, NULL, NULL, NULL, 'EXP_1233', NULL, 'uyebubfugbeunbjsvjf ', '546101+');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `subaccion`
--

CREATE TABLE `subaccion` (
  `ID_SA` int(11) NOT NULL,
  `NOMBRE_ABREVIADO` varchar(50) NOT NULL DEFAULT '0',
  `SUB_ACCION_ESP` varchar(50) NOT NULL DEFAULT '0',
  `CONCAT` varchar(50) NOT NULL DEFAULT '0',
  `CODIGO_S_A_E` varchar(50) NOT NULL DEFAULT '0',
  `ID_AE` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipo_agente`
--

CREATE TABLE `tipo_agente` (
  `ID_TA` int(11) NOT NULL DEFAULT 0,
  `NOMBRE_TA` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `tipo_agente`
--

INSERT INTO `tipo_agente` (`ID_TA`, `NOMBRE_TA`) VALUES
(1, 'Técnico de Campo'),
(2, 'Ingeniero de Soporte'),
(3, 'Supervisor de Proyecto');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipo_transporte`
--

CREATE TABLE `tipo_transporte` (
  `id_tt` int(11) NOT NULL,
  `NOMBRE_TRANSPORTE` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `tipo_transporte`
--

INSERT INTO `tipo_transporte` (`id_tt`, `NOMBRE_TRANSPORTE`) VALUES
(1, 1),
(2, 2),
(3, 3);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `zona_distrito`
--

CREATE TABLE `zona_distrito` (
  `id_zd` int(11) NOT NULL,
  `NOMBRE_DISTRITO` varchar(50) DEFAULT NULL,
  `id_zp` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `zona_distrito`
--

INSERT INTO `zona_distrito` (`id_zd`, `NOMBRE_DISTRITO`, `id_zp`) VALUES
(1, 'Huánuco', 1),
(2, 'Amarilis', 1),
(3, 'Pillco Marca', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `zona_provincia`
--

CREATE TABLE `zona_provincia` (
  `id_zp` int(11) NOT NULL,
  `NOMBRE_PROVINCIA` varchar(50) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `zona_provincia`
--

INSERT INTO `zona_provincia` (`id_zp`, `NOMBRE_PROVINCIA`) VALUES
(1, 'Huánuco'),
(2, 'Leoncio Prado'),
(3, 'Pachitea');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `accion`
--
ALTER TABLE `accion`
  ADD PRIMARY KEY (`ID_ACCION`);

--
-- Indices de la tabla `accion_especifica`
--
ALTER TABLE `accion_especifica`
  ADD PRIMARY KEY (`ID_AE`);

--
-- Indices de la tabla `actividad`
--
ALTER TABLE `actividad`
  ADD PRIMARY KEY (`ID_ACTIVIDAD`);

--
-- Indices de la tabla `detalle_registro`
--
ALTER TABLE `detalle_registro`
  ADD PRIMARY KEY (`ID_REGISTRO`);

--
-- Indices de la tabla `subaccion`
--
ALTER TABLE `subaccion`
  ADD PRIMARY KEY (`ID_SA`);

--
-- Indices de la tabla `tipo_agente`
--
ALTER TABLE `tipo_agente`
  ADD PRIMARY KEY (`ID_TA`);

--
-- Indices de la tabla `tipo_transporte`
--
ALTER TABLE `tipo_transporte`
  ADD PRIMARY KEY (`id_tt`);

--
-- Indices de la tabla `zona_distrito`
--
ALTER TABLE `zona_distrito`
  ADD PRIMARY KEY (`id_zd`);

--
-- Indices de la tabla `zona_provincia`
--
ALTER TABLE `zona_provincia`
  ADD PRIMARY KEY (`id_zp`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `accion`
--
ALTER TABLE `accion`
  MODIFY `ID_ACCION` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `accion_especifica`
--
ALTER TABLE `accion_especifica`
  MODIFY `ID_AE` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de la tabla `actividad`
--
ALTER TABLE `actividad`
  MODIFY `ID_ACTIVIDAD` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `detalle_registro`
--
ALTER TABLE `detalle_registro`
  MODIFY `ID_REGISTRO` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `subaccion`
--
ALTER TABLE `subaccion`
  MODIFY `ID_SA` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `tipo_transporte`
--
ALTER TABLE `tipo_transporte`
  MODIFY `id_tt` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `zona_distrito`
--
ALTER TABLE `zona_distrito`
  MODIFY `id_zd` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `zona_provincia`
--
ALTER TABLE `zona_provincia`
  MODIFY `id_zp` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
