-- phpMyAdmin SQL Dump
-- version 4.7.0
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 06-05-2019 a las 12:37:32
-- Versión del servidor: 10.1.25-MariaDB
-- Versión de PHP: 5.6.31

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `padel2u_db`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `imagenes`
--

CREATE TABLE `imagenes` (
  `id` int(11) NOT NULL,
  `idTorneo` int(11) DEFAULT NULL,
  `idPartidoAmistoso` int(11) DEFAULT NULL,
  `localizacionCargador` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `notificaciones`
--

CREATE TABLE `notificaciones` (
  `Id` int(11) NOT NULL,
  `Tipo` int(1) NOT NULL,
  `UsuarioReceptor` int(11) NOT NULL,
  `idUsuarioEnlazado` int(11) DEFAULT NULL,
  `idPartidoAmistosoEnlazado` int(11) DEFAULT NULL,
  `idTorneoEnlazado` int(11) DEFAULT NULL,
  `idPartidoTorneoEnlazado` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `notificaciones`
--

INSERT INTO `notificaciones` (`Id`, `Tipo`, `UsuarioReceptor`, `idUsuarioEnlazado`, `idPartidoAmistosoEnlazado`, `idTorneoEnlazado`, `idPartidoTorneoEnlazado`) VALUES
(210, 3, 2, 3, NULL, 1, NULL),
(213, 3, 10, 11, NULL, 1, NULL),
(214, 3, 12, 13, NULL, 1, NULL),
(215, 5, 5, 4, NULL, 1, 36),
(216, 5, 4, 5, NULL, 1, 36),
(217, 5, 3, 2, NULL, 1, 36),
(218, 5, 2, 3, NULL, 1, 36),
(219, 5, 13, 12, NULL, 1, 37),
(220, 5, 12, 13, NULL, 1, 37),
(221, 5, 7, 6, NULL, 1, 37),
(222, 5, 6, 7, NULL, 1, 37),
(223, 5, 11, 10, NULL, 1, 38),
(224, 5, 10, 11, NULL, 1, 38);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `parejas`
--

CREATE TABLE `parejas` (
  `id` int(11) NOT NULL,
  `integrante1` int(11) NOT NULL,
  `integrante2` int(11) NOT NULL,
  `torneoAsociado` int(11) NOT NULL,
  `efectividad` int(10) NOT NULL,
  `enVigor` varchar(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `parejas`
--

INSERT INTO `parejas` (`id`, `integrante1`, `integrante2`, `torneoAsociado`, `efectividad`, `enVigor`) VALUES
(8, 3, 2, 1, 10, '1'),
(9, 5, 4, 1, 3, '1'),
(10, 7, 6, 1, 10, '1'),
(11, 11, 10, 1, 2, '1'),
(12, 13, 12, 1, 4, '1');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `partidos_amistosos`
--

CREATE TABLE `partidos_amistosos` (
  `id` int(11) NOT NULL,
  `nombre` varchar(40) NOT NULL,
  `creador` int(11) DEFAULT NULL,
  `jugador3` int(11) DEFAULT NULL,
  `jugador2` int(11) DEFAULT NULL,
  `jugador1` int(11) DEFAULT NULL,
  `fechaInicio` varchar(25) NOT NULL,
  `fechaInscripcion` varchar(25) NOT NULL,
  `resultados` varchar(40) DEFAULT NULL,
  `enDisputa` tinyint(1) NOT NULL,
  `resultadosCerrados` tinyint(1) NOT NULL,
  `lleno` tinyint(1) NOT NULL,
  `ciudad` varchar(40) NOT NULL,
  `direccion` varchar(40) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `partidos_torneos`
--

CREATE TABLE `partidos_torneos` (
  `id` int(11) NOT NULL,
  `nombre` varchar(40) NOT NULL,
  `pareja1` int(11) DEFAULT NULL,
  `pareja2` int(11) DEFAULT NULL,
  `torneoAsociado` int(11) NOT NULL,
  `parejaGanadora` int(11) DEFAULT NULL,
  `resultados` varchar(40) DEFAULT NULL,
  `fechaInicio` varchar(25) NOT NULL,
  `ronda` int(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `partidos_torneos`
--

INSERT INTO `partidos_torneos` (`id`, `nombre`, `pareja1`, `pareja2`, `torneoAsociado`, `parejaGanadora`, `resultados`, `fechaInicio`, `ronda`) VALUES
(36, 'Partido: 1. ', 9, 8, 1, NULL, NULL, '06-05-2019 01:32', 1),
(37, 'Partido: 2. ', 12, 10, 1, NULL, NULL, '10-05-2019 20:32', 1),
(38, 'Partido: 3. ', 11, NULL, 1, NULL, NULL, '07-05-2019 15:32', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `torneos`
--

CREATE TABLE `torneos` (
  `id` int(11) NOT NULL,
  `nombre` varchar(40) NOT NULL,
  `numParejas` int(2) NOT NULL,
  `efectividadRequerida` int(10) DEFAULT NULL,
  `premio` varchar(40) DEFAULT NULL,
  `provincia` varchar(30) NOT NULL,
  `direccion` varchar(40) NOT NULL,
  `ciudad` varchar(40) NOT NULL,
  `fechaInicio` varchar(25) NOT NULL,
  `fechaFin` varchar(25) NOT NULL,
  `fechaInscripcion` varchar(25) DEFAULT NULL,
  `maxParejas` int(3) NOT NULL,
  `cerrado` tinyint(1) NOT NULL,
  `maxRondas` int(2) NOT NULL,
  `rondaActual` int(2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `torneos`
--

INSERT INTO `torneos` (`id`, `nombre`, `numParejas`, `efectividadRequerida`, `premio`, `provincia`, `direccion`, `ciudad`, `fechaInicio`, `fechaFin`, `fechaInscripcion`, `maxParejas`, `cerrado`, `maxRondas`, `rondaActual`) VALUES
(1, 'torneo 6 parejas', 12, 1, 'ddd', '41', 'edf', '41001', '2019-04-28', '2019-04-27', '2019-05-03', 23, 1, 4, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL,
  `email` varchar(30) NOT NULL,
  `nombre` varchar(20) NOT NULL,
  `apellido1` varchar(25) NOT NULL,
  `apellido2` varchar(25) NOT NULL,
  `efectividad` int(8) NOT NULL,
  `password` varchar(256) NOT NULL,
  `provincia` varchar(30) NOT NULL,
  `localidad` varchar(30) NOT NULL,
  `sexo` varchar(10) NOT NULL,
  `arbitro` tinyint(1) NOT NULL,
  `perfil` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id`, `email`, `nombre`, `apellido1`, `apellido2`, `efectividad`, `password`, `provincia`, `localidad`, `sexo`, `arbitro`, `perfil`) VALUES
(1, 'a@gmail.com', 'a', 'a', 'a', 0, '$2y$10$jst/OkF2NtMte8cKJ3aeVOvcMpxn9BpQRD1gVVMt36tAHN0PEbHoS', 'comunidad_b', 'ciudad_a', 'hombre', 1, NULL),
(2, 'adios@gmail.com', 'adios', 'adios', 'adios', 10, '$2y$10$3wgbtklo8dNz.ERs6puyqOvqni3lV16quFfVSycHj8KiYckxYMhU6', '50', '50001', 'hombre', 0, NULL),
(3, 'daniel.lopez@gmail.com', 'daniel', 'daniel', 'daniel', 10, '$2y$10$zO3XwiFewjjJvoTc2jUdcekbTJPqLeJu0PxRyOddZ/f5cHSNtBgoC', '39', '39001', 'hombre', 0, NULL),
(4, 'usuario1@gmail.com', 'usuario1', 'usuario1', 'usuario1', 3, '$2y$10$9medDlA8uUG3u4MgdX3y1./tL/17HNgyWJQJCdrXZimxT4pj.q3G2', '38', '38001', 'hombre', 0, NULL),
(5, 'usuario2@gmail.com', 'usuario2', 'usuario2', 'usuario2', 3, '$2y$10$/VVFqisHaeeopbOm/vtWHO5i7hUAgS34U35Y9rcJIHR/UaBzo0NTu', '35', '35001', 'hombre', 0, NULL),
(6, 'usuario3@gmail.com', 'usuario3', 'usuario3', 'usuario3', 10, '$2y$10$vOGLdbdrqW6mlg5fitt.0.EYzZ/h390T9C.YiMJlz4CqZ9in9/l8W', '39', '39001', 'hombre', 0, NULL),
(7, 'usuario4@gmail.com', 'usuario4', 'usuario4', 'usuario4', 10, '$2y$10$4RXxdfT96PpRDRKYHhloOu/V0IpdBZjGPb8.eyHFshKOzY8byYhWO', '09', '09001', 'hombre', 0, NULL),
(8, 'usuario5@gmail.com', 'usuario5', 'usuario5', 'usuario5', 0, '$2y$10$ccQ8rnvTHYsV.q2IP4aQ1OXM5pIJGHRsGLUugT7Y1y5qSFbbpEfom', '05', '05001', 'hombre', 0, NULL),
(9, 'usuario6@gmail.com', 'usuario6', 'usuario6', 'usuario6', 0, '$2y$10$KOysd5QLDFvEv0KkFBfWOuYg7S9JZC6jheE8RL6PMlVrXONd6gNX.', '39', '39001', 'hombre', 0, NULL),
(10, 'usuario7@gmail.com', 'usuario7', 'usuario7', 'usuario7', 2, '$2y$10$rS6I6jksF/72msJjJvTLY.J3bS2nMbrP/BKSu1KxK1.uX.TXw6wI6', '23', '23001', 'hombre', 0, NULL),
(11, 'usuario8@gmail.com', 'usuario8', 'usuario8', 'usuario8', 2, '$2y$10$cvOYLnW0HeEebY5czIbmyukEV5YjSPSZm9gy45XCrRFFu.0rvpuhW', '11', '11001', 'hombre', 0, NULL),
(12, 'usuario9@gmail.com', 'usuario9', 'usuario9', 'usuario9', 4, '$2y$10$SzUuFqHlPJmEodLimP6vVucihVLp286XhGAUbPt1SChZ3BExgUxJO', '35', '35001', 'hombre', 0, NULL),
(13, 'usuario10@gmail.com', 'usuario10', 'usuario10', 'usuario10', 4, '$2y$10$YA1b8Iil2Tpy7lU2y49wFuBwN.oNFRwW8aCF1hfIQFK8Yy/WM79qO', '05', '05001', 'hombre', 0, NULL),
(14, 'usuario11@gmail.com', 'usuario11', 'usuario1', 'usuario11', 0, '$2y$10$A1q7J9fncPTY8af8VwwYIO/pL9PrF5hrZ2dYbaIvWiwIJuSBy8nxu', '38', '38001', 'hombre', 0, NULL),
(15, 'usuario12@gmail.com', 'usuario12', 'usuario12', 'usuario12', 0, '$2y$10$jZ//SZrRfNk0wyUDDjHTZe81DhJdxUnYlH0bsxA/QovxCtFn6WDNW', '39', '39001', 'hombre', 0, NULL),
(19, 'b@gmail.com', 'b', 'nuevo', 'b', 1, '$2y$10$7TPbfpQRJ2tIbEGk8OxifeU1jUM2Q03ABDjFPTxf9UT8A8BdvW.tG', 'Madrid', 'Boadilla del Monte', 'hombre', 0, 'uploads/usuario/19/perfil.jpg'),
(20, 'nuevisimo@gmail.com', 'n', 'n', 'n', 1, '$2y$10$8vn3JasYc9M9litwfEE2uuDSVRXCQQ.y919GwJDuzqyOtWokfrK.W', '35', '35001', 'hombre', 0, 'uploads/usuario/20/perfil.jpg');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `imagenes`
--
ALTER TABLE `imagenes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `imagenTorneoFk` (`idTorneo`),
  ADD KEY `imagenPartidoFk` (`idPartidoAmistoso`);

--
-- Indices de la tabla `notificaciones`
--
ALTER TABLE `notificaciones`
  ADD PRIMARY KEY (`Id`),
  ADD KEY `usuarioReceptorNotificacionFk` (`UsuarioReceptor`),
  ADD KEY `usuarioNotificacionEnlazadoFk` (`idUsuarioEnlazado`),
  ADD KEY `partidoAmistosoNotificacionEnlazadoFk` (`idPartidoAmistosoEnlazado`),
  ADD KEY `torneoNotificacionFk` (`idTorneoEnlazado`),
  ADD KEY `partido_torneo_fk` (`idPartidoTorneoEnlazado`);

--
-- Indices de la tabla `parejas`
--
ALTER TABLE `parejas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `integrante1_pareja_fk` (`integrante1`),
  ADD KEY `integrante2_pareja_fk` (`integrante2`),
  ADD KEY `torneoAsociadoParejaFk` (`torneoAsociado`);

--
-- Indices de la tabla `partidos_amistosos`
--
ALTER TABLE `partidos_amistosos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jugador1_partido_fk` (`jugador1`),
  ADD KEY `jugador2_partido_fk` (`jugador2`),
  ADD KEY `jugador3_partido_fk` (`jugador3`),
  ADD KEY `creador_partido_fk` (`creador`);

--
-- Indices de la tabla `partidos_torneos`
--
ALTER TABLE `partidos_torneos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `pareja1PartidoTorneoFk` (`pareja1`),
  ADD KEY `pareja2PartidoTorneoFk` (`pareja2`),
  ADD KEY `parejaGanadoraTorneoFk` (`parejaGanadora`),
  ADD KEY `torneoAsociadoPartido_fk` (`torneoAsociado`);

--
-- Indices de la tabla `torneos`
--
ALTER TABLE `torneos`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nombre_uk` (`nombre`);

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
-- AUTO_INCREMENT de la tabla `imagenes`
--
ALTER TABLE `imagenes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `notificaciones`
--
ALTER TABLE `notificaciones`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=225;
--
-- AUTO_INCREMENT de la tabla `parejas`
--
ALTER TABLE `parejas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;
--
-- AUTO_INCREMENT de la tabla `partidos_torneos`
--
ALTER TABLE `partidos_torneos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;
--
-- AUTO_INCREMENT de la tabla `torneos`
--
ALTER TABLE `torneos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;
--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `imagenes`
--
ALTER TABLE `imagenes`
  ADD CONSTRAINT `imagenPartidoFk` FOREIGN KEY (`idPartidoAmistoso`) REFERENCES `partidos_amistosos` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `imagenTorneoFk` FOREIGN KEY (`idTorneo`) REFERENCES `torneos` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `notificaciones`
--
ALTER TABLE `notificaciones`
  ADD CONSTRAINT `partidoAmistosoNotificacionEnlazadoFk` FOREIGN KEY (`idPartidoAmistosoEnlazado`) REFERENCES `partidos_amistosos` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `partido_torneo_fk` FOREIGN KEY (`idPartidoTorneoEnlazado`) REFERENCES `partidos_torneos` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `torneoNotificacionFk` FOREIGN KEY (`idTorneoEnlazado`) REFERENCES `torneos` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `usuarioNotificacionEnlazadoFk` FOREIGN KEY (`idUsuarioEnlazado`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `usuarioReceptorNotificacionFk` FOREIGN KEY (`UsuarioReceptor`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `parejas`
--
ALTER TABLE `parejas`
  ADD CONSTRAINT `integrante1_pareja_fk` FOREIGN KEY (`integrante1`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `integrante2_pareja_fk` FOREIGN KEY (`integrante2`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `torneoAsociadoParejaFk` FOREIGN KEY (`torneoAsociado`) REFERENCES `torneos` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `partidos_amistosos`
--
ALTER TABLE `partidos_amistosos`
  ADD CONSTRAINT `creador_partido_fk` FOREIGN KEY (`creador`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `jugador1_partido_fk` FOREIGN KEY (`jugador1`) REFERENCES `usuarios` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `jugador2_partido_fk` FOREIGN KEY (`jugador2`) REFERENCES `usuarios` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `jugador3_partido_fk` FOREIGN KEY (`jugador3`) REFERENCES `usuarios` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Filtros para la tabla `partidos_torneos`
--
ALTER TABLE `partidos_torneos`
  ADD CONSTRAINT `pareja1PartidoTorneoFk` FOREIGN KEY (`pareja1`) REFERENCES `parejas` (`id`) ON DELETE SET NULL ON UPDATE SET NULL,
  ADD CONSTRAINT `pareja2PartidoTorneoFk` FOREIGN KEY (`pareja2`) REFERENCES `parejas` (`id`) ON DELETE SET NULL ON UPDATE SET NULL,
  ADD CONSTRAINT `parejaGanadoraTorneoFk` FOREIGN KEY (`parejaGanadora`) REFERENCES `parejas` (`id`) ON DELETE SET NULL ON UPDATE SET NULL,
  ADD CONSTRAINT `torneoAsociadoPartido_fk` FOREIGN KEY (`torneoAsociado`) REFERENCES `torneos` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
