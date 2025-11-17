-- phpMyAdmin SQL Dump
-- version 5.2.3
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost
-- Tiempo de generación: 17-11-2025 a las 03:16:32
-- Versión del servidor: 12.0.2-MariaDB
-- Versión de PHP: 8.4.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `bd`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario`
--

CREATE TABLE `usuario` (
  `ID_Usuario` int(11) NOT NULL,
  `nombre_completo` text NOT NULL,
  `documento` text NOT NULL,
  `correo` text NOT NULL,
  `telefono` text NOT NULL,
  `contrasenia` text NOT NULL,
  `token_sesion` varchar(64) DEFAULT NULL,
  `rol` varchar(16) NOT NULL DEFAULT 'client'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuario`
--

INSERT INTO `usuario` (`ID_Usuario`, `nombre_completo`, `documento`, `correo`, `telefono`, `contrasenia`, `token_sesion`, `rol`) VALUES
(22, 'Federico Artencio', '56942082', 'fede.2007.artencio.u@gmail.com', '', '$2y$12$.dMPf3mDRJb.qb1YVWDoQupxOM25T/4sSYl2ntF6wXT2pIf5fVUOu', 'ffee8988361948569eb946163968cdeb21f6f9750e687581b5d56438aa5d9857', 'client'),
(23, 'Federico Artencio', '56942082', '10@10.com', '', '$2y$12$FPv8flU4BecIxv8/YvFfUusQ3C82UW7v/pUfUlvZQU34odv20uV7u', NULL, 'client');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`ID_Usuario`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `usuario`
--
ALTER TABLE `usuario`
  MODIFY `ID_Usuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
