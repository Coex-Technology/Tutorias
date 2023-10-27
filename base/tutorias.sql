-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 26-10-2023 a las 05:37:29
-- Versión del servidor: 10.4.24-MariaDB
-- Versión de PHP: 8.1.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `tutorias`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `asignaturas`
--

CREATE TABLE `asignaturas` (
  `id` int(11) NOT NULL,
  `nombre` varchar(50) COLLATE utf8mb4_spanish2_ci NOT NULL,
  `examenes_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish2_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `asistencias`
--

CREATE TABLE `asistencias` (
  `usuarios_ci` int(11) NOT NULL,
  `tutorias_id` bigint(20) NOT NULL,
  `asistencias` int(11) DEFAULT NULL,
  `inasistencias_justificadas` int(11) DEFAULT NULL,
  `inasistencias_injustificadas` int(11) DEFAULT NULL,
  `fecha` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish2_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `contactos`
--

CREATE TABLE `contactos` (
  `ci` int(11) NOT NULL,
  `telefono` int(11) NOT NULL,
  `email` varchar(100) COLLATE utf8mb4_spanish2_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish2_ci;

--
-- Volcado de datos para la tabla `contactos`
--

INSERT INTO `contactos` (`ci`, `telefono`, `email`) VALUES
(11111111, 95123456, 'santiagobrignoni@gmail.com'),
(12345674, 91011021, 'sasaaas@gmail.com'),
(12345677, 93123721, 'sasaaas@gmail.com'),
(12345678, 95123456, 'santiagobrignoni@gmail.com'),
(12345678, 97123456, 'sass@gmail.com'),
(22222222, 95123456, 'santiagobrignoni@gmail.com'),
(56274580, 98123456, 'sass@gmail.com'),
(111111111, 98123456, 'sass@gmail.com'),
(111111112, 97123456, 'sass@gmail.com'),
(111111112, 98123456, 'santiagobrignoni@gmail.com'),
(111111112, 98123457, 'sasss@gmail.com'),
(111111122, 92029023, 'fa@gmail.com'),
(111111122, 92202902, 'fa@gmail.com');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `examenes`
--

CREATE TABLE `examenes` (
  `id` int(11) NOT NULL,
  `descripcion` text COLLATE utf8mb4_spanish2_ci DEFAULT NULL,
  `fecha` date NOT NULL,
  `hora` time NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish2_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `repositorios`
--

CREATE TABLE `repositorios` (
  `id_archivo` bigint(20) NOT NULL,
  `usuarios_ci` int(11) NOT NULL,
  `tutorias_id` bigint(20) NOT NULL,
  `nombre` varchar(50) COLLATE utf8mb4_spanish2_ci NOT NULL,
  `comentarios` text COLLATE utf8mb4_spanish2_ci NOT NULL,
  `tipo_archivo` varchar(100) COLLATE utf8mb4_spanish2_ci NOT NULL,
  `fecha_visualizacion` date NOT NULL,
  `hora_visualizacion` time DEFAULT NULL,
  `fecha_eliminacion` date NOT NULL,
  `hora_eliminacion` time DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish2_ci;

--
-- Volcado de datos para la tabla `repositorios`
--

INSERT INTO `repositorios` (`id_archivo`, `usuarios_ci`, `tutorias_id`, `nombre`, `comentarios`, `tipo_archivo`, `fecha_visualizacion`, `hora_visualizacion`, `fecha_eliminacion`, `hora_eliminacion`) VALUES
(2147483647, 11111111, 11111111030625, 'sas', 'p>br>/p>p>br>/p>p>br>/p>p>br>/p>p>br>/p>p>br>/p>', 'Imágenes', '2023-10-04', '01:17:00', '2023-10-26', '21:22:00'),
(202310052214, 11111111, 11111111030625, 'SAS', 'p>SAntiago/p>p>br>/p>p>br>/p>p>br>/p>p>br>/p>p>br>/p>', 'Imágenes', '2023-10-05', '22:14:00', '2023-10-12', '02:14:00');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tutorias`
--

CREATE TABLE `tutorias` (
  `id` bigint(20) NOT NULL,
  `docente_ci` int(11) NOT NULL,
  `administrador_ci` int(11) NOT NULL,
  `grupo` varchar(50) COLLATE utf8mb4_spanish2_ci NOT NULL,
  `descripcion` text COLLATE utf8mb4_spanish2_ci DEFAULT NULL,
  `dias` varchar(20) COLLATE utf8mb4_spanish2_ci NOT NULL,
  `fecha_inicial` date DEFAULT NULL,
  `fecha_final` date DEFAULT NULL,
  `hora_inicial` time NOT NULL,
  `hora_final` time DEFAULT NULL,
  `activa` varchar(25) COLLATE utf8mb4_spanish2_ci NOT NULL,
  `asignaturas_id` int(11) DEFAULT NULL,
  `tutorias_tipos_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish2_ci;

--
-- Volcado de datos para la tabla `tutorias`
--

INSERT INTO `tutorias` (`id`, `docente_ci`, `administrador_ci`, `grupo`, `descripcion`, `dias`, `fecha_inicial`, `fecha_final`, `hora_inicial`, `hora_final`, `activa`, `asignaturas_id`, `tutorias_tipos_id`) VALUES
(11111111030625, 11111111, 56274580, 'Mundo', '', 'Martes', '2023-10-13', '2023-10-13', '06:25:00', '06:22:00', '', NULL, 3),
(12345673050627, 12345673, 12345678, 'Adios', '', 'Jueves', '2023-10-06', '2023-10-11', '06:27:00', '08:23:00', '', NULL, 2),
(12345673060555, 12345673, 56274580, 'Hola', '', 'Viernes', '2023-10-13', '2023-10-13', '05:55:00', '05:55:00', '', NULL, 3);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tutorias_estudiantes`
--

CREATE TABLE `tutorias_estudiantes` (
  `tutorias_id` bigint(20) NOT NULL,
  `descripcion` text COLLATE utf8mb4_spanish2_ci DEFAULT NULL,
  `estudiantes_ci` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish2_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tutorias_tipos`
--

CREATE TABLE `tutorias_tipos` (
  `id` int(11) NOT NULL,
  `nombre_tipo` varchar(100) COLLATE utf8mb4_spanish2_ci NOT NULL,
  `descripcion` text COLLATE utf8mb4_spanish2_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish2_ci;

--
-- Volcado de datos para la tabla `tutorias_tipos`
--

INSERT INTO `tutorias_tipos` (`id`, `nombre_tipo`, `descripcion`) VALUES
(1, 'Tutorías de acompañamiento', NULL),
(2, 'Tutorías de febrero', NULL),
(3, 'Tutorías de vacaciones marzo', NULL),
(4, 'Tutorías de vacaciones de julio', NULL),
(5, 'Tutorías de vacaciones de septiembre', NULL),
(6, 'Tutorías de diciembre', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `ci` int(11) NOT NULL,
  `clave` varchar(500) COLLATE utf8mb4_spanish2_ci NOT NULL,
  `nombre` varchar(50) COLLATE utf8mb4_spanish2_ci NOT NULL,
  `apellido` varchar(50) COLLATE utf8mb4_spanish2_ci NOT NULL,
  `direccion` varchar(100) COLLATE utf8mb4_spanish2_ci DEFAULT NULL,
  `registrado` varchar(25) COLLATE utf8mb4_spanish2_ci NOT NULL,
  `activo` varchar(25) COLLATE utf8mb4_spanish2_ci NOT NULL,
  `usuarios_tipos_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish2_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`ci`, `clave`, `nombre`, `apellido`, `direccion`, `registrado`, `activo`, `usuarios_tipos_id`) VALUES
(11111111, '$2y$10$8Xp3OXSMgaGTLFF7Y4Og2OR/E/Ki0ByWoypxm5ridRqcsCnKxmJ2u', 'Facundo', 'Muñoz', 'En internet', 'Registrado', 'Activo', 2),
(12345673, '$2y$10$EEZb7WR8zu/UW7XoRoIzveZ/Gb.ovAr1iaqes4lTTfgELcrF0NZcS', 'Nicolás', 'Rodríguez', 'en mi casa', 'Registrado', 'Activo', 2),
(12345674, '$2y$10$kz5zOKABrIrhLBHaSpqS4ewzjTHEd7o1hidLNlggPZ/d.wesC.dIC', 'Santiago', 'Brignoni', 'Florida Cowork', 'Registrado', 'No Activo', 2),
(12345677, '$2y$10$9sGDldX4S50BKqutRU4yPuggYONrZSdQZdahuMcvLH1.MNlBjQp8i', 'Docente', 'Brignoni', 'Florida Cowork', 'No Registrado', 'No Activo', 2),
(12345678, '$2y$10$pAHDAxlfm3Gq.XXo5MbMVesfQ3OT2EcWWWIThc9xHgcN3hpdfbDj6', 'Santiago', 'Brignoni', 'Florida Cowork', 'Registrado', 'No Activo', 1),
(22222222, '$2y$10$sApQDWDwtu.It/v9rVufLeOkDzI6BptzywFRqDqhLwIcdM00FPkMG', 'Estudiante', 'De Prueba', 'Florida', 'Registrado', 'Activo', 3),
(56274580, '$2y$10$poNInfvS9xfPFc6Alh7GAeHV3YHRnvQh8TcAo5.5fQF6069efl./K', 'Facundo', 'MUÑOZ', 'Florida Cowork', 'Registrado', 'Activo', 1),
(111111111, '$2y$10$CrkZ9zyy00UrOQbMEr0izOTc3XOYkyReGukXmhSEakDL8sHCEDUKm', 'Coex', 'Technology', 'Florida Cowork', 'Registrado', 'Activo', 3),
(111111112, '$2y$10$HAVt9LV7z6LvoUcw614aGuBeV6gLzmqOClSCUAvW31E4bNsSzMdu2', 'Coex', 'Technology', 'Florida Cowork', 'Registrado', 'Activo', 1),
(111111122, '$2y$10$JUasbbr6qLyvfsgtif1QD.5UJTOZPUvG103Iduzxmx9LFgIRZCdNW', 'San', 'LOs', 'kkjsbkkss', 'No Registrado', 'No Activo', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios_tipos`
--

CREATE TABLE `usuarios_tipos` (
  `id` int(11) NOT NULL,
  `categoria` varchar(50) COLLATE utf8mb4_spanish2_ci NOT NULL,
  `permisos` text COLLATE utf8mb4_spanish2_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish2_ci;

--
-- Volcado de datos para la tabla `usuarios_tipos`
--

INSERT INTO `usuarios_tipos` (`id`, `categoria`, `permisos`) VALUES
(0, '[Root]', '[root]'),
(1, 'Administrador', NULL),
(2, 'Docente', NULL),
(3, 'Estudiante', NULL);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `asignaturas`
--
ALTER TABLE `asignaturas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `examenes_id` (`examenes_id`);

--
-- Indices de la tabla `asistencias`
--
ALTER TABLE `asistencias`
  ADD PRIMARY KEY (`usuarios_ci`,`tutorias_id`),
  ADD KEY `usuarios_ci` (`usuarios_ci`),
  ADD KEY `tutorias_id` (`tutorias_id`);

--
-- Indices de la tabla `contactos`
--
ALTER TABLE `contactos`
  ADD PRIMARY KEY (`ci`,`telefono`);

--
-- Indices de la tabla `examenes`
--
ALTER TABLE `examenes`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `repositorios`
--
ALTER TABLE `repositorios`
  ADD PRIMARY KEY (`id_archivo`,`usuarios_ci`,`tutorias_id`),
  ADD KEY `ci` (`usuarios_ci`),
  ADD KEY `tutorias_id` (`tutorias_id`);

--
-- Indices de la tabla `tutorias`
--
ALTER TABLE `tutorias`
  ADD PRIMARY KEY (`id`),
  ADD KEY `asignaturas_id` (`asignaturas_id`),
  ADD KEY `tutorias_tipos_id` (`tutorias_tipos_id`),
  ADD KEY `docente_ci` (`docente_ci`),
  ADD KEY `administrador_ci` (`administrador_ci`);

--
-- Indices de la tabla `tutorias_estudiantes`
--
ALTER TABLE `tutorias_estudiantes`
  ADD PRIMARY KEY (`tutorias_id`),
  ADD KEY `usuarios_ci` (`estudiantes_ci`),
  ADD KEY `tutorias_id` (`tutorias_id`),
  ADD KEY `estudiantes_ci` (`estudiantes_ci`);

--
-- Indices de la tabla `tutorias_tipos`
--
ALTER TABLE `tutorias_tipos`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`ci`),
  ADD KEY `usuario_tipo_id` (`usuarios_tipos_id`);

--
-- Indices de la tabla `usuarios_tipos`
--
ALTER TABLE `usuarios_tipos`
  ADD PRIMARY KEY (`id`);

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `asignaturas`
--
ALTER TABLE `asignaturas`
  ADD CONSTRAINT `asignaturas_ibfk_1` FOREIGN KEY (`examenes_id`) REFERENCES `examenes` (`id`) ON UPDATE CASCADE;

--
-- Filtros para la tabla `asistencias`
--
ALTER TABLE `asistencias`
  ADD CONSTRAINT `asistencias_ibfk_1` FOREIGN KEY (`usuarios_ci`) REFERENCES `usuarios` (`ci`) ON UPDATE CASCADE,
  ADD CONSTRAINT `asistencias_ibfk_2` FOREIGN KEY (`tutorias_id`) REFERENCES `tutorias` (`id`) ON UPDATE CASCADE;

--
-- Filtros para la tabla `contactos`
--
ALTER TABLE `contactos`
  ADD CONSTRAINT `contactos_ibfk_1` FOREIGN KEY (`ci`) REFERENCES `usuarios` (`ci`) ON UPDATE CASCADE;

--
-- Filtros para la tabla `repositorios`
--
ALTER TABLE `repositorios`
  ADD CONSTRAINT `repositorios_ibfk_1` FOREIGN KEY (`tutorias_id`) REFERENCES `tutorias` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `repositorios_ibfk_2` FOREIGN KEY (`usuarios_ci`) REFERENCES `usuarios` (`ci`) ON UPDATE CASCADE;

--
-- Filtros para la tabla `tutorias`
--
ALTER TABLE `tutorias`
  ADD CONSTRAINT `tutorias_ibfk_3` FOREIGN KEY (`asignaturas_id`) REFERENCES `asignaturas` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `tutorias_ibfk_5` FOREIGN KEY (`tutorias_tipos_id`) REFERENCES `tutorias_tipos` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `tutorias_ibfk_7` FOREIGN KEY (`docente_ci`) REFERENCES `usuarios` (`ci`) ON UPDATE CASCADE,
  ADD CONSTRAINT `tutorias_ibfk_8` FOREIGN KEY (`administrador_ci`) REFERENCES `usuarios` (`ci`) ON UPDATE CASCADE;

--
-- Filtros para la tabla `tutorias_estudiantes`
--
ALTER TABLE `tutorias_estudiantes`
  ADD CONSTRAINT `tutorias_estudiantes_ibfk_2` FOREIGN KEY (`estudiantes_ci`) REFERENCES `usuarios` (`ci`) ON UPDATE CASCADE,
  ADD CONSTRAINT `tutorias_estudiantes_ibfk_3` FOREIGN KEY (`tutorias_id`) REFERENCES `tutorias` (`id`) ON UPDATE CASCADE;

--
-- Filtros para la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD CONSTRAINT `usuarios_ibfk_2` FOREIGN KEY (`usuarios_tipos_id`) REFERENCES `usuarios_tipos` (`id`) ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
