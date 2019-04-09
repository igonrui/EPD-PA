-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 18-11-2018 a las 03:19:53
-- Versión del servidor: 10.1.36-MariaDB
-- Versión de PHP: 7.2.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `epd6-p1`
--
CREATE DATABASE IF NOT EXISTS `epd6-p1` DEFAULT CHARACTER SET utf8 COLLATE utf8_spanish_ci;
USE `epd6-p1`;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ciudades`
--

CREATE TABLE `ciudades` (
  `ciudad` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci NOT NULL COMMENT 'nombre de la ciudad'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci COMMENT='tabla de las ciudades del sistema';

--
-- Volcado de datos para la tabla `ciudades`
--

INSERT INTO `ciudades` (`ciudad`) VALUES
('Almeria'),
('Cadiz'),
('Cordoba'),
('Granada'),
('Huelva'),
('Jaen'),
('Malaga'),
('Sevilla');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `equipos`
--

CREATE TABLE `equipos` (
  `id` int(8) NOT NULL,
  `nombre` varchar(50) COLLATE utf8_spanish_ci NOT NULL,
  `ciudad` varchar(20) COLLATE utf8_spanish_ci NOT NULL,
  `PJ` int(8) NOT NULL DEFAULT '0' COMMENT 'partidos jugados',
  `PG` int(8) NOT NULL DEFAULT '0' COMMENT 'partidos ganados',
  `PP` int(8) NOT NULL DEFAULT '0' COMMENT 'partidos perdidos',
  `PF` int(8) NOT NULL DEFAULT '0' COMMENT 'puntos a favor',
  `PE` int(8) NOT NULL DEFAULT '0' COMMENT 'puntos en contra'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `equipos`
--

INSERT INTO `equipos` (`id`, `nombre`, `ciudad`, `PJ`, `PG`, `PP`, `PF`, `PE`) VALUES
(0, 'prueba', 'Sevilla', 4, 3, 1, 10, 7),
(1, 'Equipo 1', 'Granada', 2, 0, 2, 2, 5),
(2, 'Equipo 2', 'Malaga', 1, 1, 0, 3, 1),
(3, 'Equipo 3', 'Granada', 2, 0, 1, 4, 6),
(4, 'Equipo 4', 'Cordoba', 1, 0, 0, 2, 2);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `partidos`
--

CREATE TABLE `partidos` (
  `id_partido` int(11) NOT NULL,
  `id_local` int(11) NOT NULL,
  `id_visitante` int(11) NOT NULL,
  `puntuacion_local` int(11) NOT NULL,
  `puntuacion_visitante` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `partidos`
--

INSERT INTO `partidos` (`id_partido`, `id_local`, `id_visitante`, `puntuacion_local`, `puntuacion_visitante`) VALUES
(9, 0, 1, 3, 1),
(10, 2, 0, 3, 1),
(11, 3, 0, 2, 4),
(12, 4, 3, 2, 2);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `nombre` varchar(50) COLLATE utf8_spanish_ci NOT NULL COMMENT 'nombre del usuario',
  `usuario` varchar(50) COLLATE utf8_spanish_ci NOT NULL COMMENT 'usuario de acceso al sistema',
  `password` varchar(255) COLLATE utf8_spanish_ci NOT NULL COMMENT 'contraseña de acceso al sistema',
  `f_registro` date NOT NULL COMMENT 'fecha de alta en el sistema'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`nombre`, `usuario`, `password`, `f_registro`) VALUES
('admin', '&#39; OR 1=1 #', '1234', '2018-11-17'),
('admin', 'admin', '$2y$10$L5A0yvdR34KrY7STPDFH9uLdxz9z37CC8R3GezIfzuZtqTYx616o.', '2018-11-17'),
('asd', 'asd', 'asd', '2018-11-17'),
('betis', 'betis', '$2y$10$/83J6HE9Nh.o5qDsFgZY9uqyHiCV2VMKVmox56Yp7TwRVAU36O3/m', '2018-11-17'),
('Irene GonzÃ¡lez Ruiz', 'hola', 'hola', '2018-11-17'),
('irene', 'irene', '$2y$10$otUqQKVITG1/TQ1We9A30O0IBqOh/.fmMZf4rANw1fdVgqEZh/P/y', '2018-11-17'),
('jefe', 'jefe', 'jefe', '2018-11-18'),
('root', 'root', 'root', '2018-11-17');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `ciudades`
--
ALTER TABLE `ciudades`
  ADD PRIMARY KEY (`ciudad`);

--
-- Indices de la tabla `equipos`
--
ALTER TABLE `equipos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `ciudad` (`ciudad`);

--
-- Indices de la tabla `partidos`
--
ALTER TABLE `partidos`
  ADD PRIMARY KEY (`id_partido`),
  ADD KEY `id_local` (`id_local`),
  ADD KEY `id_visitante` (`id_visitante`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`usuario`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `partidos`
--
ALTER TABLE `partidos`
  MODIFY `id_partido` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `partidos`
--
ALTER TABLE `partidos`
  ADD CONSTRAINT `partidos_ibfk_1` FOREIGN KEY (`id_local`) REFERENCES `equipos` (`id`),
  ADD CONSTRAINT `partidos_ibfk_2` FOREIGN KEY (`id_visitante`) REFERENCES `equipos` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
