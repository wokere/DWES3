-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost
-- Tiempo de generación: 10-02-2021 a las 14:11:58
-- Versión del servidor: 10.4.14-MariaDB
-- Versión de PHP: 7.4.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `videoclub`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `actores`
--

CREATE TABLE `actores` (
  `id` int(11) NOT NULL,
  `nombre` varchar(50) NOT NULL,
  `anyoNacimiento` int(4) NOT NULL,
  `Pais` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `actores`
--

INSERT INTO `actores` (`id`, `nombre`, `anyoNacimiento`, `Pais`) VALUES
(3, 'Robert Duvall', 1931, 'Estados Unidos'),
(4, 'James Cann', 1940, 'Estados Unidos'),
(5, 'Diane Keaton', 1946, 'Estados Unidos'),
(6, 'Robert de Niro', 1943, 'Estados Unidos'),
(7, 'Kirk Douglas', 1916, 'Estados Unidos'),
(8, 'Ralph Meeker', 1920, 'Estados Unidos'),
(9, 'Adolphe Menjou', 1890, 'Estados Unidos'),
(10, 'Jack Lemmon', 1925, 'Estados Unidos'),
(11, 'Walter Matthau', 1920, 'Estados Unidos'),
(12, 'Susan Sarandon', 1946, 'Estados Unidos'),
(13, 'Movil', 2016, ''),
(14, 'Movil', 2016, '');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `directores`
--

CREATE TABLE `directores` (
  `id` int(11) NOT NULL,
  `nombre` varchar(50) NOT NULL,
  `anyoNacimiento` int(4) NOT NULL,
  `Pais` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `directores`
--

INSERT INTO `directores` (`id`, `nombre`, `anyoNacimiento`, `Pais`) VALUES
(1, 'Paco Coppola', 1939, 'EEUU'),
(3, 'al nububi', 1999, 'Polonia'),
(5, 'Eduardo GatosTijeras', 1986, 'Burtonland'),
(6, 'Sofi Gata', 2006, 'gatiland');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `peliculas`
--

CREATE TABLE `peliculas` (
  `id` int(11) NOT NULL,
  `titulo` varchar(50) NOT NULL,
  `anyo` int(4) NOT NULL,
  `duracion` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `peliculas`
--

INSERT INTO `peliculas` (`id`, `titulo`, `anyo`, `duracion`) VALUES
(1, 'El gatino 4', 1999, 555),
(2, 'El gatino 3', 1999, 555),
(3, 'Senderos de gloria', 1957, 86),
(4, 'Primera plana', 1974, 105),
(5, 'Eduardo GatosTijeras', 1986, 2016);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `peliculas_actores`
--

CREATE TABLE `peliculas_actores` (
  `id_pelicula` int(11) NOT NULL,
  `id_actor` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `peliculas_actores`
--

INSERT INTO `peliculas_actores` (`id_pelicula`, `id_actor`) VALUES
(1, 3),
(1, 4),
(1, 5),
(2, 3),
(2, 5),
(2, 6),
(3, 7),
(3, 8),
(3, 9);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `peliculas_directores`
--

CREATE TABLE `peliculas_directores` (
  `id_pelicula` int(11) NOT NULL,
  `id_director` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `peliculas_directores`
--

INSERT INTO `peliculas_directores` (`id_pelicula`, `id_director`) VALUES
(1, 1),
(2, 1),
(4, 3);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL,
  `email` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL,
  `guardaCredenciales` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id`, `email`, `password`, `guardaCredenciales`) VALUES
(1, 'wokere@gmail.com', '12345', 0),
(2, 'ismael@a.com', '12345', 0);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `actores`
--
ALTER TABLE `actores`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `directores`
--
ALTER TABLE `directores`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `peliculas`
--
ALTER TABLE `peliculas`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `titulo` (`titulo`);

--
-- Indices de la tabla `peliculas_actores`
--
ALTER TABLE `peliculas_actores`
  ADD KEY `fk_pel_act_act` (`id_actor`),
  ADD KEY `fk_pel_act_pel` (`id_pelicula`);

--
-- Indices de la tabla `peliculas_directores`
--
ALTER TABLE `peliculas_directores`
  ADD KEY `k_pel_dir_pel` (`id_pelicula`),
  ADD KEY `fk_pel_dir_dir` (`id_director`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `actores`
--
ALTER TABLE `actores`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT de la tabla `directores`
--
ALTER TABLE `directores`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `peliculas`
--
ALTER TABLE `peliculas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `peliculas_actores`
--
ALTER TABLE `peliculas_actores`
  ADD CONSTRAINT `fk_pel_act_act` FOREIGN KEY (`id_actor`) REFERENCES `actores` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_pel_act_pel` FOREIGN KEY (`id_pelicula`) REFERENCES `peliculas` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `peliculas_directores`
--
ALTER TABLE `peliculas_directores`
  ADD CONSTRAINT `fk_pel_dir_dir` FOREIGN KEY (`id_director`) REFERENCES `directores` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `k_pel_dir_pel` FOREIGN KEY (`id_pelicula`) REFERENCES `peliculas` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
