-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 04-11-2025 a las 18:38:43
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
-- Base de datos: `bd_proyectofinal`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `boleto`
--

CREATE TABLE `boleto` (
  `ID_Boleto` int(11) NOT NULL,
  `ID_Persona` int(11) NOT NULL,
  `ID_Pago` int(11) NOT NULL,
  `ID_Omnibus` int(11) NOT NULL,
  `Asiento` int(11) NOT NULL,
  `Coche` int(11) NOT NULL,
  `HoraSalida` datetime(6) NOT NULL,
  `HoraLlegada` datetime(6) NOT NULL,
  `CiudadSalida` text NOT NULL,
  `CiudadLlegada` text NOT NULL,
  `TipoOmnibus` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `chofer`
--

CREATE TABLE `chofer` (
  `ID_Chofer` int(11) NOT NULL,
  `ID_Omnibus` int(11) NOT NULL,
  `Nombre` text NOT NULL,
  `Telefono` int(11) NOT NULL,
  `Horas_Trabajadas` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `encomiendas`
--

CREATE TABLE `encomiendas` (
  `ID_Encomienda` int(11) NOT NULL,
  `ID_Omnibus` int(11) NOT NULL,
  `Tipo` int(11) NOT NULL,
  `Telefono` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `omnibus`
--

CREATE TABLE `omnibus` (
  `ID_Omnibus` int(11) NOT NULL,
  `ID_Chofer` int(11) NOT NULL,
  `ProximaParada` text NOT NULL,
  `UltimaParada` text NOT NULL,
  `Coordenadas` point NOT NULL,
  `TipoOmnibus` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pago`
--

CREATE TABLE `pago` (
  `ID_Pago` int(11) NOT NULL,
  `Fecha` int(11) NOT NULL,
  `Monto` int(11) NOT NULL,
  `ID_Persona` int(11) NOT NULL,
  `MetodoPago` int(11) NOT NULL,
  `Estado` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `persona`
--

CREATE TABLE `persona` (
  `ID_Usuario` int(11) NOT NULL,
  `Cedula` int(11) NOT NULL,
  `NombreCompleto` text NOT NULL,
  `Telefono` int(11) NOT NULL,
  `Correo` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ruta`
--

CREATE TABLE `ruta` (
  `ID_Ruta` int(11) NOT NULL,
  `Origen` text NOT NULL,
  `Destino` text NOT NULL,
  `Tipo` text NOT NULL,
  `Precio` int(11) NOT NULL,
  `Duracion` int(11) NOT NULL,
  `Faltas` text NOT NULL DEFAULT '[]',
  `Horas` text NOT NULL DEFAULT '[]',
  `Trazo_actual` text NOT NULL DEFAULT '[]',
  `Trazo_planeado` text NOT NULL DEFAULT '[]'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `servicios`
--

CREATE TABLE `servicios` (
  `ID_Servicios` int(11) NOT NULL,
  `ID_Usuario` int(11) NOT NULL,
  `ID_Pago` int(11) NOT NULL,
  `Giros` varchar(500) NOT NULL,
  `Tramites` varchar(300) NOT NULL,
  `LineaPasajes` varchar(300) NOT NULL,
  `LineaAbono` varchar(300) NOT NULL,
  `Partidas` varchar(300) NOT NULL,
  `FechaPago` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario`
--

CREATE TABLE `usuario` (
  `ID_Usuario` int(11) NOT NULL,
  `Contrasena` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `boleto`
--
ALTER TABLE `boleto`
  ADD PRIMARY KEY (`ID_Boleto`),
  ADD KEY `boletoomnibus` (`ID_Omnibus`),
  ADD KEY `pagoboleto` (`ID_Pago`),
  ADD KEY `personaboleto` (`ID_Persona`);

--
-- Indices de la tabla `chofer`
--
ALTER TABLE `chofer`
  ADD PRIMARY KEY (`ID_Chofer`),
  ADD KEY `omnibuschofer` (`ID_Omnibus`);

--
-- Indices de la tabla `encomiendas`
--
ALTER TABLE `encomiendas`
  ADD PRIMARY KEY (`ID_Encomienda`),
  ADD KEY `omnibusemcomienda` (`ID_Omnibus`);

--
-- Indices de la tabla `omnibus`
--
ALTER TABLE `omnibus`
  ADD PRIMARY KEY (`ID_Omnibus`),
  ADD KEY `choferomnibus` (`ID_Chofer`);

--
-- Indices de la tabla `pago`
--
ALTER TABLE `pago`
  ADD PRIMARY KEY (`ID_Pago`),
  ADD KEY `personapago` (`ID_Persona`);

--
-- Indices de la tabla `persona`
--
ALTER TABLE `persona`
  ADD PRIMARY KEY (`ID_Usuario`);

--
-- Indices de la tabla `ruta`
--
ALTER TABLE `ruta`
  ADD PRIMARY KEY (`ID_Ruta`);

--
-- Indices de la tabla `servicios`
--
ALTER TABLE `servicios`
  ADD PRIMARY KEY (`ID_Servicios`),
  ADD KEY `serviciospago` (`ID_Pago`),
  ADD KEY `serviciosusuario` (`ID_Usuario`);

--
-- Indices de la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD KEY `usuariopersona` (`ID_Usuario`);

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
-- AUTO_INCREMENT de la tabla `encomiendas`
--
ALTER TABLE `encomiendas`
  MODIFY `ID_Encomienda` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `omnibus`
--
ALTER TABLE `omnibus`
  MODIFY `ID_Omnibus` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `pago`
--
ALTER TABLE `pago`
  MODIFY `ID_Pago` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `persona`
--
ALTER TABLE `persona`
  MODIFY `ID_Usuario` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `ruta`
--
ALTER TABLE `ruta`
  MODIFY `ID_Ruta` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `servicios`
--
ALTER TABLE `servicios`
  MODIFY `ID_Servicios` int(11) NOT NULL AUTO_INCREMENT;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `boleto`
--
ALTER TABLE `boleto`
  ADD CONSTRAINT `boletoomnibus` FOREIGN KEY (`ID_Omnibus`) REFERENCES `omnibus` (`ID_Omnibus`),
  ADD CONSTRAINT `pagoboleto` FOREIGN KEY (`ID_Pago`) REFERENCES `pago` (`ID_Pago`),
  ADD CONSTRAINT `personaboleto` FOREIGN KEY (`ID_Persona`) REFERENCES `persona` (`ID_Usuario`);

--
-- Filtros para la tabla `chofer`
--
ALTER TABLE `chofer`
  ADD CONSTRAINT `omnibuschofer` FOREIGN KEY (`ID_Omnibus`) REFERENCES `omnibus` (`ID_Omnibus`);

--
-- Filtros para la tabla `encomiendas`
--
ALTER TABLE `encomiendas`
  ADD CONSTRAINT `omnibusemcomienda` FOREIGN KEY (`ID_Omnibus`) REFERENCES `omnibus` (`ID_Omnibus`);

--
-- Filtros para la tabla `omnibus`
--
ALTER TABLE `omnibus`
  ADD CONSTRAINT `choferomnibus` FOREIGN KEY (`ID_Chofer`) REFERENCES `chofer` (`ID_Chofer`);

--
-- Filtros para la tabla `pago`
--
ALTER TABLE `pago`
  ADD CONSTRAINT `personapago` FOREIGN KEY (`ID_Persona`) REFERENCES `persona` (`ID_Usuario`);

--
-- Filtros para la tabla `servicios`
--
ALTER TABLE `servicios`
  ADD CONSTRAINT `serviciospago` FOREIGN KEY (`ID_Pago`) REFERENCES `pago` (`ID_Pago`),
  ADD CONSTRAINT `serviciosusuario` FOREIGN KEY (`ID_Usuario`) REFERENCES `persona` (`ID_Usuario`);

--
-- Filtros para la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD CONSTRAINT `usuariopersona` FOREIGN KEY (`ID_Usuario`) REFERENCES `persona` (`ID_Usuario`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
