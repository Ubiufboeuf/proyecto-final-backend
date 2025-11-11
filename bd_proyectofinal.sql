-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 11-11-2025 a las 18:38:14
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
  `Hora-Salida` datetime(6) NOT NULL,
  `Hora-Llegada` datetime(6) NOT NULL,
  `Ciudad-Salida` text NOT NULL,
  `Ciudad-Llegada` text NOT NULL,
  `Tipo-Omnibus` varchar(30) NOT NULL
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
  `Proxima-Parada` text NOT NULL,
  `Ultima-Parada` text NOT NULL,
  `Coordenadas` point NOT NULL,
  `Tipo-Omnibus` text NOT NULL
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
  `Metodo-Pago` int(11) NOT NULL,
  `Estado` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ruta`
--

CREATE TABLE `ruta` (
  `ID_Rutas` int(11) NOT NULL,
  `Origen` point NOT NULL,
  `Destino` point NOT NULL,
  `Paradas` point NOT NULL,
  `ID_Omnibus` int(11) NOT NULL
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
  `Linea-Pasajes` varchar(300) NOT NULL,
  `Linea-Abono` varchar(300) NOT NULL,
  `Partidas` varchar(300) NOT NULL,
  `Fecha-Pago` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario`
--

CREATE TABLE `usuario` (
  `ID_Usuario` int(11) NOT NULL,
  `correo` varchar(50) NOT NULL,
  `telefono` int(11) NOT NULL,
  `contrasenia` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuario`
--

INSERT INTO `usuario` (`ID_Usuario`, `correo`, `telefono`, `contrasenia`) VALUES
(1, 'juan.perez@ejemplo.com', 2147483647, 'hash_jp1'),
(2, 'ana.gomez@mail.org', 2147483647, 'hash_ag2'),
(3, 'luis.rojas@prueba.net', 2147483647, 'hash_lr3'),
(4, 'maria.soto@dominio.com', 2147483647, 'hash_ms4'),
(5, 'carlos.diaz@test.com', 2147483647, 'hash_cd5'),
(6, 'elena.vargas@ejemplo.es', 2147483647, 'hash_ev6'),
(7, 'pedro.alvarez@mail.com', 2147483647, 'hash_pa7'),
(8, 'sofia.morales@prueba.net', 2147483647, 'hash_sm8'),
(9, 'javier.castro@dominio.org', 2147483647, 'hash_jc9'),
(10, 'laura.nuñez@test.org', 2147483647, 'hash_ln10');

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
-- Indices de la tabla `ruta`
--
ALTER TABLE `ruta`
  ADD PRIMARY KEY (`ID_Rutas`),
  ADD KEY `omnibusruta` (`ID_Omnibus`);

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
-- AUTO_INCREMENT de la tabla `ruta`
--
ALTER TABLE `ruta`
  MODIFY `ID_Rutas` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `servicios`
--
ALTER TABLE `servicios`
  MODIFY `ID_Servicios` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `usuario`
--
ALTER TABLE `usuario`
  MODIFY `ID_Usuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

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
-- Filtros para la tabla `ruta`
--
ALTER TABLE `ruta`
  ADD CONSTRAINT `omnibusruta` FOREIGN KEY (`ID_Omnibus`) REFERENCES `omnibus` (`ID_Omnibus`);

--
-- Filtros para la tabla `servicios`
--
ALTER TABLE `servicios`
  ADD CONSTRAINT `serviciospago` FOREIGN KEY (`ID_Pago`) REFERENCES `pago` (`ID_Pago`),
  ADD CONSTRAINT `serviciosusuario` FOREIGN KEY (`ID_Usuario`) REFERENCES `persona` (`ID_Usuario`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
