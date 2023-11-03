-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 04-11-2023 a las 00:48:30
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
-- Estructura de tabla para la tabla `asistencias`
--

CREATE TABLE `asistencias` (
  `tutorias_id` bigint(20) NOT NULL,
  `estudiantes_ci` int(11) NOT NULL,
  `fecha` date NOT NULL,
  `docente_ci` int(11) NOT NULL,
  `fecha_ingreso` date NOT NULL,
  `inasistencias_justificadas` int(11) DEFAULT NULL,
  `inasistencias_injustificadas` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish2_ci;

--
-- Volcado de datos para la tabla `asistencias`
--

INSERT INTO `asistencias` (`tutorias_id`, `estudiantes_ci`, `fecha`, `docente_ci`, `fecha_ingreso`, `inasistencias_justificadas`, `inasistencias_injustificadas`) VALUES
(11111111030625, 22222222, '2023-06-14', 11111111, '2023-11-02', 1, 3),
(11111111030625, 22222222, '2023-07-13', 11111111, '2023-11-02', 12, 10),
(11111111030625, 22222222, '2023-11-01', 11111111, '2023-11-01', 0, 0),
(11111111030625, 22222222, '2023-11-04', 11111111, '2023-10-31', 1, NULL),
(11111111030625, 22222222, '2023-11-05', 11111111, '2023-11-02', 20, 0),
(11111111030625, 22222222, '2023-11-11', 11111111, '2023-11-02', 0, 4),
(11111111030625, 22222222, '2023-11-17', 11111111, '2023-11-02', 0, 0),
(11111111030625, 22222222, '2023-11-26', 11111111, '2023-11-01', 1, 2),
(11111111030625, 54893231, '2023-07-13', 11111111, '2023-11-02', 2, 23),
(11111111030625, 54893231, '2023-11-01', 11111111, '2023-11-01', 0, 0),
(11111111030625, 54893231, '2023-11-05', 11111111, '2023-11-02', 20, 0),
(11111111030625, 54893231, '2023-11-17', 11111111, '2023-11-02', 0, 0),
(11111111030625, 54893231, '2023-11-26', 11111111, '2023-11-01', 0, 0),
(11111111030625, 54893232, '2023-11-01', 11111111, '2023-11-01', 0, 0),
(11111111030625, 54893232, '2023-11-04', 11111111, '2023-10-31', 1, NULL),
(11111111030625, 54893232, '2023-11-05', 11111111, '2023-11-02', 20, 1),
(11111111030625, 54894723, '2023-10-05', 11111111, '2023-10-31', 1, 7),
(11111111030625, 54894723, '2023-11-04', 11111111, '2023-10-31', 1, NULL),
(12345674061048, 22222222, '2023-11-12', 11111111, '2023-11-02', 1, 3),
(12345674061048, 54894723, '2023-11-12', 11111111, '2023-11-02', 4, 1);

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
(43030123, 97323212, 'santino@gmail.com'),
(54893231, 93232142, 'santiagobrignoni6@outlook.com'),
(54893232, 93254143, 'camila36@outlook.com'),
(54894723, 93254143, 'micaela@gmail.com'),
(56274580, 98123456, 'sass@gmail.com'),
(92748293, 95111543, 'juan@gmail.com'),
(111111110, 1922029022, 'sa@gmail.com'),
(111111111, 98123456, 'sass@gmail.com'),
(111111112, 97123456, 'sass@gmail.com'),
(111111112, 98123456, 'santiagobrignoni@gmail.com'),
(111111112, 98123457, 'sasss@gmail.com');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `repositorios`
--

CREATE TABLE `repositorios` (
  `id_archivo` bigint(20) NOT NULL,
  `usuarios_ci` int(11) NOT NULL,
  `tutorias_id` bigint(20) NOT NULL,
  `tema` varchar(100) COLLATE utf8mb4_spanish2_ci NOT NULL,
  `nombre` varchar(100) COLLATE utf8mb4_spanish2_ci NOT NULL,
  `comentarios` text COLLATE utf8mb4_spanish2_ci NOT NULL,
  `tipo_archivo` varchar(100) COLLATE utf8mb4_spanish2_ci NOT NULL,
  `fecha_visualizacion` date NOT NULL,
  `hora_visualizacion` time DEFAULT NULL,
  `fecha_eliminacion` date NOT NULL,
  `hora_eliminacion` time DEFAULT NULL,
  `activo` varchar(45) COLLATE utf8mb4_spanish2_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish2_ci;

--
-- Volcado de datos para la tabla `repositorios`
--

INSERT INTO `repositorios` (`id_archivo`, `usuarios_ci`, `tutorias_id`, `tema`, `nombre`, `comentarios`, `tipo_archivo`, `fecha_visualizacion`, `hora_visualizacion`, `fecha_eliminacion`, `hora_eliminacion`, `activo`) VALUES
(202310030449, 12345678, 12345674040800, 'Word Numero 2', 'Calendario_202310100459_12345678_12345674040800.png', 'p>br>/p>p>br>/p>p>br>/p>p>br>/p>p>br>/p>p>br>/p>p>br>/p>p>br>/p>', 'Textos', '2023-10-03', '04:49:00', '2023-11-03', '23:49:00', 'Activo'),
(202310091055, 11111111, 11111111030625, 'Funciones', 'Funciones_202310091055_11111111_11111111030625.png', 'p>br>/p>p>br>/p>p>br>/p>p>br>/p>p>br>/p>p>br>/p>p>br>/p>p>br>/p>', 'Imágenes', '2023-10-09', '10:55:00', '2023-11-05', '10:55:00', 'Activo'),
(202310100459, 12345678, 12345674040800, 'Funciones', 'Calendario_202310100459_12345678_12345674040800.png', 'p>br>/p>p>br>/p>p>br>/p>p>br>/p>p>br>/p>p>br>/p>p>br>/p>p>br>/p>', 'Imágenes', '2023-10-10', '04:59:00', '2023-11-05', '23:04:00', 'Activo'),
(202310120022, 12345678, 12345674040800, 'Hola', 'Hola_202310120022_12345678_12345674040800.png', 'p>br>/p>p>br>/p>p>br>/p>p>br>/p>p>br>/p>p>br>/p>p>br>/p>p>br>/p>', 'Imágenes', '2023-10-12', '00:22:00', '2023-11-03', '00:22:00', 'Activo'),
(202310120502, 12345678, 12345674061048, 'Archivo', 'Archivo_202310120502_12345678_12345674061048.png', 'p>br>/p>p>br>/p>p>br>/p>p>br>/p>p>br>/p>p>br>/p>p>br>/p>p>br>/p>', 'Imágenes', '2023-10-12', '05:02:00', '2023-11-05', '23:08:00', 'No Activo');

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
  `fecha_inicial` date NOT NULL,
  `fecha_final` date NOT NULL,
  `hora_inicial` time NOT NULL,
  `hora_final` time NOT NULL,
  `activa` varchar(25) COLLATE utf8mb4_spanish2_ci NOT NULL,
  `asignaturas_id` int(11) DEFAULT NULL,
  `tutorias_tipos_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish2_ci;

--
-- Volcado de datos para la tabla `tutorias`
--

INSERT INTO `tutorias` (`id`, `docente_ci`, `administrador_ci`, `grupo`, `descripcion`, `dias`, `fecha_inicial`, `fecha_final`, `hora_inicial`, `hora_final`, `activa`, `asignaturas_id`, `tutorias_tipos_id`) VALUES
(11111111030625, 11111111, 12345678, '2°Bachillerato - Matemática', '[No se ha ingresado]', 'Viernes', '2023-03-03', '2023-05-12', '15:00:00', '16:30:00', 'Activa', NULL, 3),
(12345673020530, 12345673, 56274580, '1°Bachillerato -  Ingles', '[No se ha ingresado]', 'Lunes', '2023-10-09', '2023-10-23', '05:30:00', '07:00:00', 'Activa', NULL, 4),
(12345673060555, 12345673, 56274580, '1°Ciclo Básico - Ciencias Físicas', '[No se ha ingresado]', 'Lunes', '2023-05-08', '2023-06-12', '14:10:00', '14:55:00', 'Activa', NULL, 3),
(12345674040800, 12345674, 12345678, '3°Ciclo Básico - Idioma Español', '[No se ha ingresado]', 'Miércoles', '2023-10-04', '2023-10-18', '08:00:00', '09:15:00', 'Activa', NULL, 5),
(12345674061048, 11111111, 12345678, '2°Ciclo Básico - Historia', '[No se ha ingresado]', 'Viernes', '2023-10-06', '2023-10-16', '14:10:00', '14:55:00', 'Activa', NULL, 6),
(12345674071437, 12345674, 12345678, '3°Bachillerato - Sociología', '[No se ha ingresado]', 'Sábado', '2023-10-28', '2023-10-28', '19:45:00', '20:30:00', 'Activa', NULL, 5);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tutorias_estudiantes`
--

CREATE TABLE `tutorias_estudiantes` (
  `tutorias_id` bigint(20) NOT NULL,
  `estudiantes_ci` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish2_ci;

--
-- Volcado de datos para la tabla `tutorias_estudiantes`
--

INSERT INTO `tutorias_estudiantes` (`tutorias_id`, `estudiantes_ci`) VALUES
(11111111030625, 22222222),
(11111111030625, 54893231),
(11111111030625, 54894723),
(11111111030625, 111111111),
(12345674040800, 22222222),
(12345674040800, 54893231),
(12345674061048, 22222222),
(12345674061048, 54894723);

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
(1, 'Tutoría de acompañamiento', NULL),
(2, 'Tutoría para examen en febrero', NULL),
(3, 'Tutoría para examen en marzo', NULL),
(4, 'Tutoría para examen en abril', NULL),
(5, 'Tutoría para examen en julio', NULL),
(6, 'Tutoría para examen en septiembre', NULL),
(7, 'Tutoría para examen en diciembre', NULL);

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
(11111111, '$2y$10$8Xp3OXSMgaGTLFF7Y4Og2OR/E/Ki0ByWoypxm5ridRqcsCnKxmJ2u', 'Lucía', 'Perez', 'Florida Cowork', 'Registrado', 'No Activo', 2),
(12345673, '$2y$10$EEZb7WR8zu/UW7XoRoIzveZ/Gb.ovAr1iaqes4lTTfgELcrF0NZcS', 'Nicolás', 'Rodríguez', 'en mi casa', 'Registrado', 'No Activo', 2),
(12345674, '$2y$10$kz5zOKABrIrhLBHaSpqS4ewzjTHEd7o1hidLNlggPZ/d.wesC.dIC', 'Facundo', 'Martínez', 'Florida Cowork', 'Registrado', 'No Activo', 2),
(12345677, '$2y$10$9sGDldX4S50BKqutRU4yPuggYONrZSdQZdahuMcvLH1.MNlBjQp8i', 'Juan', 'Torres', 'Florida Cowork', 'No Registrado', 'No Activo', 2),
(12345678, '$2y$10$pAHDAxlfm3Gq.XXo5MbMVesfQ3OT2EcWWWIThc9xHgcN3hpdfbDj6', 'Santiago', 'Brignoni', 'Florida Cowork', 'Registrado', 'Activo', 1),
(22222222, '$2y$10$sApQDWDwtu.It/v9rVufLeOkDzI6BptzywFRqDqhLwIcdM00FPkMG', 'Camila', 'Muñoz', 'Florida', 'Registrado', 'Activo', 3),
(43030123, '$2y$10$WfCfhGYkBcCGkNeyoxHTm.43h9KCNuYzHcATdxEDstln70BZewd9W', 'Santino', 'Muñoz', 'Sarandi Grande', 'Registrado', 'Activo', 1),
(54893231, '$2y$10$tw8sq7xMphDVet9pVsEWrO7H5GHrHPLEC0I5O1YvpEGCRTzNwnATG', 'Matias', 'Olivera', '25 de Mayo', 'Registrado', 'Activo', 3),
(54893232, '$2y$10$smqXLS7xwuSX7yCsen0xhuIrhg45n74EWiWw154B/AmTkWHQ1MyWG', 'Camila', 'Perez', 'Cardal', 'Registrado', 'Activo', 3),
(54894723, '$2y$10$Iz5e1Tmj9beEByLgMwf1XOOjw8vg.QY4y6h0VM5PqAH6rPz5ByAXa', 'Micaela', 'Vega', 'Sarandi Grande', 'Registrado', 'Activo', 3),
(56274580, '$2y$10$poNInfvS9xfPFc6Alh7GAeHV3YHRnvQh8TcAo5.5fQF6069efl./K', 'Facundo', 'Vega', 'Florida Cowork', 'Registrado', 'Activo', 1),
(92748293, '$2y$10$Q7gj4YBMg/R3seNL2nHasORENRNXpjE6MepKiJNyi4wYzJsTc0UQq', 'Juan', 'Fernadez', 'Florida', 'Registrado', 'Activo', 3),
(111111110, '$2y$10$rSmo7cNz3JFjqEXh6PCL4eps3ntQIanmEo/ctmNZwIMT1QqlpTYve', 'akds', 'jwebda', 'Florida', 'Registrado', 'Activo', 2),
(111111111, '$2y$10$CrkZ9zyy00UrOQbMEr0izOTc3XOYkyReGukXmhSEakDL8sHCEDUKm', 'Josefina', 'Casas', 'Florida Cowork', 'Registrado', 'Activo', 3),
(111111112, '$2y$10$HAVt9LV7z6LvoUcw614aGuBeV6gLzmqOClSCUAvW31E4bNsSzMdu2', 'Coex', 'Technology', 'Florida Cowork', 'Registrado', 'Activo', 1);

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
-- Indices de la tabla `asistencias`
--
ALTER TABLE `asistencias`
  ADD PRIMARY KEY (`tutorias_id`,`estudiantes_ci`,`fecha`),
  ADD KEY `tutorias_id` (`tutorias_id`),
  ADD KEY `docente_ci` (`docente_ci`),
  ADD KEY `estudiantes_ci2` (`estudiantes_ci`),
  ADD KEY `estudiantes_ci` (`estudiantes_ci`);

--
-- Indices de la tabla `contactos`
--
ALTER TABLE `contactos`
  ADD PRIMARY KEY (`ci`,`telefono`);

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
  ADD PRIMARY KEY (`tutorias_id`,`estudiantes_ci`),
  ADD KEY `tutorias_id` (`tutorias_id`),
  ADD KEY `estudiantes_ci_2` (`estudiantes_ci`);

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
-- Filtros para la tabla `asistencias`
--
ALTER TABLE `asistencias`
  ADD CONSTRAINT `asistencias_ibfk_2` FOREIGN KEY (`tutorias_id`) REFERENCES `tutorias` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `asistencias_ibfk_3` FOREIGN KEY (`docente_ci`) REFERENCES `usuarios` (`ci`) ON UPDATE CASCADE;

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
  ADD CONSTRAINT `tutorias_ibfk_5` FOREIGN KEY (`tutorias_tipos_id`) REFERENCES `tutorias_tipos` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `tutorias_ibfk_7` FOREIGN KEY (`docente_ci`) REFERENCES `usuarios` (`ci`) ON UPDATE CASCADE,
  ADD CONSTRAINT `tutorias_ibfk_8` FOREIGN KEY (`administrador_ci`) REFERENCES `usuarios` (`ci`) ON UPDATE CASCADE;

--
-- Filtros para la tabla `tutorias_estudiantes`
--
ALTER TABLE `tutorias_estudiantes`
  ADD CONSTRAINT `tutorias_estudiantes_ibfk_3` FOREIGN KEY (`tutorias_id`) REFERENCES `tutorias` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `tutorias_estudiantes_ibfk_4` FOREIGN KEY (`estudiantes_ci`) REFERENCES `usuarios` (`ci`) ON UPDATE CASCADE;

--
-- Filtros para la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD CONSTRAINT `usuarios_ibfk_2` FOREIGN KEY (`usuarios_tipos_id`) REFERENCES `usuarios_tipos` (`id`) ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
