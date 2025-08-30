-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 17-07-2025 a las 22:55:02
-- Versión del servidor: 10.4.32-MariaDB
-- Versión de PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `bdproyectofinal`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `boleto`
--

CREATE TABLE `boleto` (
  `ID_Boleto` int(11) NOT NULL,
  `ID_Usuario` int(11) NOT NULL,
  `ID_Omnibus` int(11) NOT NULL,
  `asiento` int(11) NOT NULL,
  `horaSalida` datetime NOT NULL,
  `horaLlegada` datetime NOT NULL,
  `ciudadSalida` varchar(50) NOT NULL,
  `ciudadLlegada` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `chofer`
--

CREATE TABLE `chofer` (
  `ID_Chofer` int(11) NOT NULL,
  `nombre` int(11) NOT NULL,
  `telefono` int(11) NOT NULL,
  `horasTrabajadas` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `encomienda`
--

CREATE TABLE `encomienda` (
  `ID_Encomienda` int(11) NOT NULL,
  `tipo` varchar(50) NOT NULL,
  `telefono` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `omnibus`
--

CREATE TABLE `omnibus` (
  `ID_Omnibus` int(11) NOT NULL,
  `ID_Chofer` int(11) NOT NULL,
  `ID_Boleto` int(11) NOT NULL,
  `ID_Encomienda` int(11) NOT NULL,
  `ID_Ruta` int(11) NOT NULL,
  `proximaParada` varchar(100) NOT NULL,
  `ultimaParada` varchar(100) NOT NULL,
  `coordenadas` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ruta`
--

CREATE TABLE `ruta` (
  `ID_Ruta` int(11) NOT NULL,
  `ID_Omnibus` int(11) NOT NULL,
  `origen` int(11) NOT NULL,
  `destino` int(11) NOT NULL,
  `paradas` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario`
--

CREATE TABLE `usuario` (
  `ID_Usuario` int(11) NOT NULL,
  `nombre` varchar(50) NOT NULL,
  `contraseña` varchar(50) NOT NULL,
  `correo` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `boleto`
--
ALTER TABLE `boleto`
  ADD PRIMARY KEY (`ID_Boleto`),
  ADD KEY `ID_Usuario` (`ID_Usuario`),
  ADD KEY `ID_Omnibus` (`ID_Omnibus`);

--
-- Indices de la tabla `chofer`
--
ALTER TABLE `chofer`
  ADD PRIMARY KEY (`ID_Chofer`);

--
-- Indices de la tabla `encomienda`
--
ALTER TABLE `encomienda`
  ADD PRIMARY KEY (`ID_Encomienda`);

--
-- Indices de la tabla `omnibus`
--
ALTER TABLE `omnibus`
  ADD PRIMARY KEY (`ID_Omnibus`),
  ADD KEY `ID_Chofer` (`ID_Chofer`),
  ADD KEY `ID_Boleto` (`ID_Boleto`),
  ADD KEY `ID_Encomienda` (`ID_Encomienda`),
  ADD KEY `ID_Ruta` (`ID_Ruta`);

--
-- Indices de la tabla `ruta`
--
ALTER TABLE `ruta`
  ADD PRIMARY KEY (`ID_Ruta`);

--
-- Indices de la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`ID_Usuario`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `boleto`
--
ALTER TABLE `boleto`
  MODIFY `ID_Boleto` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `chofer`
--
ALTER TABLE `chofer`
  MODIFY `ID_Chofer` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `encomienda`
--
ALTER TABLE `encomienda`
  MODIFY `ID_Encomienda` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `omnibus`
--
ALTER TABLE `omnibus`
  MODIFY `ID_Omnibus` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `ruta`
--
ALTER TABLE `ruta`
  MODIFY `ID_Ruta` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `usuario`
--
ALTER TABLE `usuario`
  MODIFY `ID_Usuario` int(11) NOT NULL AUTO_INCREMENT;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `boleto`
--
ALTER TABLE `boleto`
  ADD CONSTRAINT `ID_Omnibus` FOREIGN KEY (`ID_Omnibus`) REFERENCES `omnibus` (`ID_Omnibus`),
  ADD CONSTRAINT `ID_Usuario` FOREIGN KEY (`ID_Usuario`) REFERENCES `usuario` (`ID_Usuario`);

--
-- Filtros para la tabla `omnibus`
--
ALTER TABLE `omnibus`
  ADD CONSTRAINT `ID_Boleto` FOREIGN KEY (`ID_Boleto`) REFERENCES `boleto` (`ID_Boleto`),
  ADD CONSTRAINT `ID_Chofer` FOREIGN KEY (`ID_Chofer`) REFERENCES `chofer` (`ID_Chofer`),
  ADD CONSTRAINT `ID_Encomienda` FOREIGN KEY (`ID_Encomienda`) REFERENCES `encomienda` (`ID_Encomienda`),
  ADD CONSTRAINT `ID_Ruta` FOREIGN KEY (`ID_Ruta`) REFERENCES `ruta` (`ID_Ruta`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
