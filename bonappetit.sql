-- phpMyAdmin SQL Dump
-- version 4.3.11
-- http://www.phpmyadmin.net
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 18-06-2015 a las 01:49:07
-- Versión del servidor: 5.6.24
-- Versión de PHP: 5.6.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de datos: `bonappetit`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `caja_apertura_cierres`
--

CREATE TABLE IF NOT EXISTS `caja_apertura_cierres` (
  `id` int(11) NOT NULL,
  `descripcion` varchar(200) DEFAULT NULL,
  `hora_apertura` datetime DEFAULT NULL,
  `hora_cierre` datetime DEFAULT NULL,
  `saldo_apertura` decimal(20,5) DEFAULT NULL,
  `saldo_cierre` decimal(10,5) DEFAULT NULL,
  `cantidad_horas` varchar(20) DEFAULT NULL,
  `total_ingreso` decimal(10,2) DEFAULT NULL,
  `total_egreso` decimal(10,2) DEFAULT NULL,
  `estado` int(11) DEFAULT NULL,
  `empresa_id` int(11) DEFAULT NULL,
  `usuario_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `caja_estados`
--

CREATE TABLE IF NOT EXISTS `caja_estados` (
  `id` int(11) NOT NULL,
  `descripcion` varchar(200) DEFAULT NULL,
  `empresa_id` int(11) DEFAULT NULL,
  `usuario_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `clientes`
--

CREATE TABLE IF NOT EXISTS `clientes` (
  `id` int(11) NOT NULL,
  `descripcion` varchar(45) DEFAULT NULL,
  `nombre` varchar(45) DEFAULT NULL,
  `apellido` varchar(45) DEFAULT NULL,
  `direccion` varchar(45) DEFAULT NULL,
  `telefono` varchar(45) DEFAULT NULL,
  `email` varchar(45) DEFAULT NULL,
  `dni` varchar(45) DEFAULT NULL,
  `razon_social` varchar(45) DEFAULT NULL,
  `condicion_iva_id` int(11) DEFAULT NULL,
  `mapa` varchar(45) DEFAULT NULL,
  `empresa_id` int(11) DEFAULT NULL,
  `usuario_id` int(11) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `clientes`
--

INSERT INTO `clientes` (`id`, `descripcion`, `nombre`, `apellido`, `direccion`, `telefono`, `email`, `dni`, `razon_social`, `condicion_iva_id`, `mapa`, `empresa_id`, `usuario_id`) VALUES
(1, 'loquito', 'loquitro', 'loquito', 'loquit1', 'loquisad1', 'njasd@ffddsafa.com', '1231234', NULL, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `condicion_ivas`
--

CREATE TABLE IF NOT EXISTS `condicion_ivas` (
  `id` int(11) NOT NULL,
  `descripcion` varchar(45) DEFAULT NULL,
  `empresa_id` int(11) DEFAULT NULL,
  `usuario_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `empleados`
--

CREATE TABLE IF NOT EXISTS `empleados` (
  `id` int(11) NOT NULL,
  `descripcion` varchar(45) DEFAULT NULL,
  `nombre` varchar(45) DEFAULT NULL,
  `apellido` varchar(45) DEFAULT NULL,
  `dni` varchar(45) DEFAULT NULL,
  `ventas_x_dia` varchar(45) DEFAULT NULL,
  `venta_x_mesa` varchar(45) DEFAULT NULL,
  `tipo_empleado_id` int(11) DEFAULT NULL,
  `empresa_id` int(11) DEFAULT NULL,
  `usuario_id` int(11) DEFAULT NULL,
  `fecha_alta` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `fecha_baja` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=70 DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `empleados`
--

INSERT INTO `empleados` (`id`, `descripcion`, `nombre`, `apellido`, `dni`, `ventas_x_dia`, `venta_x_mesa`, `tipo_empleado_id`, `empresa_id`, `usuario_id`, `fecha_alta`, `fecha_baja`) VALUES
(68, 'JAUME, NAHUEL - 34312', 'NAHUEL', 'JAUME', '34312', NULL, NULL, 1, NULL, NULL, '2015-05-13 18:07:23', NULL),
(69, 'DEGANO, ANDRES - 12323123', 'ANDRES', 'DEGANO', '12323123', NULL, NULL, 1, NULL, NULL, '2015-05-13 18:14:50', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `estados`
--

CREATE TABLE IF NOT EXISTS `estados` (
  `id` int(11) NOT NULL,
  `descripcion` varchar(45) DEFAULT NULL,
  `orden` int(11) DEFAULT NULL,
  `empresa_id` int(11) DEFAULT NULL,
  `usuario_id` int(11) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `estados`
--

INSERT INTO `estados` (`id`, `descripcion`, `orden`, `empresa_id`, `usuario_id`) VALUES
(1, 'tomar pedido', NULL, NULL, NULL),
(2, 'entregado', NULL, NULL, NULL),
(3, 'cocinando', NULL, NULL, NULL),
(4, 'cobrando', NULL, NULL, NULL),
(5, 'cerrado', NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `factura_detalles`
--

CREATE TABLE IF NOT EXISTS `factura_detalles` (
  `id` int(11) NOT NULL,
  `descripcion` varchar(45) DEFAULT NULL,
  `factura_maestro_id` int(11) DEFAULT NULL,
  `cantidad` decimal(10,2) DEFAULT NULL,
  `precio_unitario` decimal(10,2) DEFAULT NULL,
  `observacion` text,
  `observaciontiempo` text,
  `empresa_id` int(11) DEFAULT NULL,
  `usuario_id` int(11) DEFAULT NULL,
  `fecha_alta` datetime DEFAULT NULL,
  `fecha_cocina` datetime DEFAULT NULL,
  `demora_preparacion` int(10) DEFAULT NULL,
  `fecha_entrega` datetime DEFAULT NULL,
  `id_tipo_plato` int(11) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=117882 DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `factura_detalles`
--

INSERT INTO `factura_detalles` (`id`, `descripcion`, `factura_maestro_id`, `cantidad`, `precio_unitario`, `observacion`, `observaciontiempo`, `empresa_id`, `usuario_id`, `fecha_alta`, `fecha_cocina`, `demora_preparacion`, `fecha_entrega`, `id_tipo_plato`) VALUES
(117875, 'COCA COLA', 22849, '2.00', '5.00', '', NULL, 1, 7, '2015-06-10 20:45:08', NULL, NULL, '2015-06-10 20:46:31', 33),
(117876, 'PAPAS FRITAS', 22849, '2.00', '70.00', '', NULL, 1, 7, '2015-06-10 20:45:15', '2015-06-10 20:45:46', 1, '2015-06-10 20:46:20', 32),
(117877, 'PIZZAS', 22849, '1.00', '40.00', '', NULL, 1, 7, '2015-06-10 20:45:21', '2015-06-10 20:45:46', 1, '2015-06-10 20:47:22', 32),
(117878, 'COCA COLA', 22850, '1.00', '5.00', '', NULL, 1, 7, '2015-06-10 20:55:46', NULL, NULL, '2015-06-10 20:57:56', 33),
(117879, 'PAPAS FRITAS', 22850, '3.00', '70.00', '', NULL, 1, 7, '2015-06-10 20:55:54', '2015-06-10 20:57:08', 1, '2015-06-10 20:59:31', 32),
(117880, 'PIZZAS', 22850, '1.00', '40.00', '', NULL, 1, 7, '2015-06-10 20:56:05', '2015-06-10 20:57:08', 1, '2015-06-10 20:59:31', 32),
(117881, 'EMPANADAS', 22850, '3.00', '25.00', '', NULL, 1, 7, '2015-06-10 20:56:23', '2015-06-10 20:57:08', 1, '2015-06-10 20:57:32', 32);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `factura_maestros`
--

CREATE TABLE IF NOT EXISTS `factura_maestros` (
  `id` int(11) NOT NULL,
  `descripcion` varchar(50) DEFAULT NULL,
  `fecha_y_hora` datetime DEFAULT NULL,
  `fecha_y_hora_fin` datetime DEFAULT NULL,
  `cliente_id` int(11) DEFAULT NULL,
  `total` decimal(10,2) DEFAULT NULL,
  `subtotal` decimal(10,2) DEFAULT NULL,
  `empleado_id` int(11) DEFAULT NULL,
  `tipo_iva_id` int(11) DEFAULT NULL,
  `empresa_id` int(11) DEFAULT NULL,
  `usuario_id` int(11) DEFAULT NULL,
  `cantidad_comensales` varchar(200) DEFAULT NULL,
  `mesa_nro` int(11) DEFAULT NULL,
  `ubicacion_id` int(11) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=22851 DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `factura_maestros`
--

INSERT INTO `factura_maestros` (`id`, `descripcion`, `fecha_y_hora`, `fecha_y_hora_fin`, `cliente_id`, `total`, `subtotal`, `empleado_id`, `tipo_iva_id`, `empresa_id`, `usuario_id`, `cantidad_comensales`, `mesa_nro`, `ubicacion_id`) VALUES
(22849, 'VENTA DE COMIDA EN SALON - 2015-06-10 20:45:02', '2015-06-10 20:45:02', '2015-06-10 20:47:39', 1, '190.00', '0.00', 68, 2, 1, 7, '3', 3, 2),
(22850, 'VENTA DE COMIDA EN SALON - 2015-06-10 20:53:29', '2015-06-10 20:53:29', '2015-06-10 20:59:30', 1, '330.00', '0.00', 69, 2, 1, 7, '3', 5, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pedido_detalles`
--

CREATE TABLE IF NOT EXISTS `pedido_detalles` (
  `id` int(11) NOT NULL,
  `descripcion` varchar(45) DEFAULT NULL,
  `receta_maestro_id` int(11) DEFAULT NULL,
  `pedido_maestro_id` int(11) DEFAULT NULL,
  `cantidad` decimal(10,2) DEFAULT NULL,
  `observaciones` text COMMENT 'Escriba aqui todo lo relacionado a adicionales al pedido',
  `precio_unitario` decimal(10,2) DEFAULT NULL,
  `descuento` int(10) DEFAULT '0',
  `estado_id` int(11) DEFAULT NULL,
  `tiempo` int(1) NOT NULL,
  `observaciontiempo` text,
  `timestamp_alta` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `timestamp_cocina` datetime DEFAULT NULL,
  `timestamp_entrega` datetime DEFAULT NULL,
  `demora_preparacion` int(10) DEFAULT NULL,
  `empresa_id` int(11) DEFAULT NULL,
  `usuario_id` int(11) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=51756 DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `pedido_detalles`
--

INSERT INTO `pedido_detalles` (`id`, `descripcion`, `receta_maestro_id`, `pedido_maestro_id`, `cantidad`, `observaciones`, `precio_unitario`, `descuento`, `estado_id`, `tiempo`, `observaciontiempo`, `timestamp_alta`, `timestamp_cocina`, `timestamp_entrega`, `demora_preparacion`, `empresa_id`, `usuario_id`) VALUES
(51749, '', 424, 10493, '2.00', '', '5.00', 0, 2, 0, NULL, '2015-06-10 23:45:08', NULL, '2015-06-10 20:46:31', NULL, 1, 7),
(51750, '', 403, 10493, '2.00', '', '70.00', 0, 2, 0, NULL, '2015-06-10 23:45:15', '2015-06-10 20:45:46', '2015-06-10 20:46:20', 1, 1, 7),
(51751, '', 411, 10493, '1.00', '', '40.00', 0, 2, 0, NULL, '2015-06-10 23:45:21', '2015-06-10 20:45:46', '2015-06-10 20:47:22', 1, 1, 7),
(51752, '', 424, 10494, '1.00', '', '5.00', 0, 2, 0, NULL, '2015-06-10 23:55:46', NULL, '2015-06-10 20:57:56', NULL, 1, 7),
(51753, '', 403, 10494, '3.00', '', '70.00', 0, 2, 0, NULL, '2015-06-10 23:55:54', '2015-06-10 20:57:08', '2015-06-10 20:59:31', 1, 1, 7),
(51754, '', 411, 10494, '1.00', '', '40.00', 0, 2, 0, NULL, '2015-06-10 23:56:05', '2015-06-10 20:57:08', '2015-06-10 20:59:31', 1, 1, 7),
(51755, '', 407, 10494, '3.00', '', '25.00', 0, 2, 0, NULL, '2015-06-10 23:56:23', '2015-06-10 20:57:08', '2015-06-10 20:57:32', 1, 1, 7);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pedido_maestros`
--

CREATE TABLE IF NOT EXISTS `pedido_maestros` (
  `id` int(11) NOT NULL,
  `descripcion` varchar(255) DEFAULT NULL,
  `empleado_id` int(11) DEFAULT NULL,
  `cliente_id` int(11) DEFAULT NULL,
  `mesa_nro` int(11) DEFAULT NULL,
  `cantidad_de_comensales` varchar(200) DEFAULT NULL,
  `ubicacion_id` int(11) DEFAULT NULL,
  `fecha_y_hora` datetime DEFAULT NULL,
  `timestamp_ticket` datetime DEFAULT NULL,
  `timestamp_finalizado` datetime DEFAULT NULL,
  `total` decimal(10,2) DEFAULT NULL,
  `finalizado` varchar(45) DEFAULT '0',
  `factura_maestro_id` int(11) DEFAULT NULL,
  `empresa_id` int(11) DEFAULT NULL,
  `usuario_id` int(11) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=10495 DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `pedido_maestros`
--

INSERT INTO `pedido_maestros` (`id`, `descripcion`, `empleado_id`, `cliente_id`, `mesa_nro`, `cantidad_de_comensales`, `ubicacion_id`, `fecha_y_hora`, `timestamp_ticket`, `timestamp_finalizado`, `total`, `finalizado`, `factura_maestro_id`, `empresa_id`, `usuario_id`) VALUES
(10493, '', 68, 1, 3, '3', 2, '2015-06-10 20:45:02', '2015-06-10 20:47:28', '2015-06-10 20:47:39', '190.00', '1', 22849, 1, 7),
(10494, '', 69, 1, 5, '3', 1, '2015-06-10 20:53:29', NULL, '2015-06-10 20:59:31', '330.00', '1', 22850, 1, 7);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `receta_maestros`
--

CREATE TABLE IF NOT EXISTS `receta_maestros` (
  `id` int(11) NOT NULL,
  `codigo` varchar(11) DEFAULT NULL,
  `descripcion` varchar(45) DEFAULT NULL,
  `descripcion_larga` text,
  `precio` decimal(10,2) DEFAULT NULL,
  `tipo_receta_id` int(11) DEFAULT NULL,
  `empresa_id` int(11) DEFAULT NULL,
  `usuario_id` int(11) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=426 DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `receta_maestros`
--

INSERT INTO `receta_maestros` (`id`, `codigo`, `descripcion`, `descripcion_larga`, `precio`, `tipo_receta_id`, `empresa_id`, `usuario_id`) VALUES
(403, '403', 'PAPAS FRITAS', NULL, '70.00', 32, NULL, 7),
(407, '25', 'EMPANADAS', NULL, '25.00', 32, NULL, 7),
(410, '5', 'RABAS', NULL, '60.00', 32, NULL, 7),
(411, '15', 'PIZZAS', NULL, '40.00', 32, NULL, 7),
(422, '420', 'TACOS', NULL, '35.00', 32, NULL, 7),
(423, '423', 'BERENJENAS', NULL, '40.00', 32, NULL, 7),
(424, '12', 'COCA COLA', NULL, '5.00', 33, NULL, 7),
(425, '425', 'MILANESA FRITA', NULL, '45.00', 32, NULL, 7);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipo_empleados`
--

CREATE TABLE IF NOT EXISTS `tipo_empleados` (
  `id` int(11) NOT NULL,
  `descripcion` varchar(45) DEFAULT NULL,
  `costo_x_hora` decimal(10,2) DEFAULT NULL,
  `empresa_id` int(11) DEFAULT NULL,
  `usuario_id` int(11) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `tipo_empleados`
--

INSERT INTO `tipo_empleados` (`id`, `descripcion`, `costo_x_hora`, `empresa_id`, `usuario_id`) VALUES
(1, 'Admin', '100.00', 1, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipo_ivas`
--

CREATE TABLE IF NOT EXISTS `tipo_ivas` (
  `id` int(11) NOT NULL,
  `descripcion` varchar(45) DEFAULT NULL,
  `empresa_id` int(11) DEFAULT NULL,
  `usuario_id` int(11) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `tipo_ivas`
--

INSERT INTO `tipo_ivas` (`id`, `descripcion`, `empresa_id`, `usuario_id`) VALUES
(2, 'tipoiva2', NULL, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipo_recetas`
--

CREATE TABLE IF NOT EXISTS `tipo_recetas` (
  `id` int(11) NOT NULL,
  `descripcion` varchar(45) DEFAULT NULL,
  `tiempo_preparacion` int(10) DEFAULT NULL,
  `pasa_cocina` int(1) DEFAULT NULL,
  `empresa_id` int(11) DEFAULT NULL,
  `usuario_id` int(11) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=34 DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `tipo_recetas`
--

INSERT INTO `tipo_recetas` (`id`, `descripcion`, `tiempo_preparacion`, `pasa_cocina`, `empresa_id`, `usuario_id`) VALUES
(32, 'FRITOS', 1, 1, NULL, 7),
(33, 'INMEDIATO', 3, 0, NULL, 7);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ubicacion`
--

CREATE TABLE IF NOT EXISTS `ubicacion` (
  `id` int(11) NOT NULL,
  `descripcion` varchar(45) DEFAULT NULL,
  `empresa_id` int(11) DEFAULT NULL,
  `usuario_id` int(11) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `ubicacion`
--

INSERT INTO `ubicacion` (`id`, `descripcion`, `empresa_id`, `usuario_id`) VALUES
(1, 'afuera', 1, 1),
(2, 'adentro', 1, 68);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE IF NOT EXISTS `usuarios` (
  `id` int(11) NOT NULL,
  `nombre` varchar(150) DEFAULT NULL,
  `apellido` varchar(150) DEFAULT NULL,
  `identificacion` varchar(50) DEFAULT NULL,
  `clave` text,
  `permiso` varchar(45) DEFAULT NULL,
  `usuario_alta` int(11) DEFAULT NULL,
  `fecha_alta` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `usuario_baja` int(11) DEFAULT NULL,
  `fecha_baja` timestamp NULL DEFAULT '0000-00-00 00:00:00',
  `empleado_id` int(11) DEFAULT NULL,
  `empresa_id` int(11) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id`, `nombre`, `apellido`, `identificacion`, `clave`, `permiso`, `usuario_alta`, `fecha_alta`, `usuario_baja`, `fecha_baja`, `empleado_id`, `empresa_id`) VALUES
(1, 'Nahuel', 'Jaume', 'njaume', '123123', '1', 1, '2015-05-13 17:46:35', NULL, '0000-00-00 00:00:00', 1, NULL),
(7, 'NAHUEL', 'JAUME', 'admin', '4297f44b13955235245b2497399d7a93', '1', 1, '2015-05-13 18:07:54', NULL, '0000-00-00 00:00:00', 68, NULL),
(8, 'ANDRES', 'DEGANO', 'adegano', '4297f44b13955235245b2497399d7a93', '2', 7, '2015-05-13 18:15:19', NULL, '0000-00-00 00:00:00', 69, NULL);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `caja_apertura_cierres`
--
ALTER TABLE `caja_apertura_cierres`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `caja_estados`
--
ALTER TABLE `caja_estados`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `clientes`
--
ALTER TABLE `clientes`
  ADD PRIMARY KEY (`id`), ADD KEY `fk_clientes_1_idx` (`condicion_iva_id`);

--
-- Indices de la tabla `condicion_ivas`
--
ALTER TABLE `condicion_ivas`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `empleados`
--
ALTER TABLE `empleados`
  ADD PRIMARY KEY (`id`), ADD KEY `fk_empleados_1_idx` (`tipo_empleado_id`);

--
-- Indices de la tabla `estados`
--
ALTER TABLE `estados`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `factura_detalles`
--
ALTER TABLE `factura_detalles`
  ADD PRIMARY KEY (`id`), ADD KEY `fk_factura_detalles_1_idx` (`factura_maestro_id`);

--
-- Indices de la tabla `factura_maestros`
--
ALTER TABLE `factura_maestros`
  ADD PRIMARY KEY (`id`), ADD KEY `fk_factura_maestros_1_idx` (`tipo_iva_id`), ADD KEY `fk_factura_maestros_2_idx` (`cliente_id`);

--
-- Indices de la tabla `pedido_detalles`
--
ALTER TABLE `pedido_detalles`
  ADD PRIMARY KEY (`id`), ADD KEY `fk_pedido_detalles_1_idx` (`receta_maestro_id`), ADD KEY `fk_pedido_detalles_2_idx` (`pedido_maestro_id`), ADD KEY `fk_pedido_detalles_4_idx` (`estado_id`);

--
-- Indices de la tabla `pedido_maestros`
--
ALTER TABLE `pedido_maestros`
  ADD PRIMARY KEY (`id`), ADD KEY `fk_pedido_maestros_1_idx` (`cliente_id`), ADD KEY `fk_pedido_maestros_3_idx` (`empleado_id`);

--
-- Indices de la tabla `receta_maestros`
--
ALTER TABLE `receta_maestros`
  ADD PRIMARY KEY (`id`), ADD KEY `fk_receta_maestros_1_idx` (`tipo_receta_id`);

--
-- Indices de la tabla `tipo_empleados`
--
ALTER TABLE `tipo_empleados`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `tipo_ivas`
--
ALTER TABLE `tipo_ivas`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `tipo_recetas`
--
ALTER TABLE `tipo_recetas`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `ubicacion`
--
ALTER TABLE `ubicacion`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `caja_apertura_cierres`
--
ALTER TABLE `caja_apertura_cierres`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `caja_estados`
--
ALTER TABLE `caja_estados`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `clientes`
--
ALTER TABLE `clientes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT de la tabla `condicion_ivas`
--
ALTER TABLE `condicion_ivas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `empleados`
--
ALTER TABLE `empleados`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=70;
--
-- AUTO_INCREMENT de la tabla `estados`
--
ALTER TABLE `estados`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT de la tabla `factura_detalles`
--
ALTER TABLE `factura_detalles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=117882;
--
-- AUTO_INCREMENT de la tabla `factura_maestros`
--
ALTER TABLE `factura_maestros`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=22851;
--
-- AUTO_INCREMENT de la tabla `pedido_detalles`
--
ALTER TABLE `pedido_detalles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=51756;
--
-- AUTO_INCREMENT de la tabla `pedido_maestros`
--
ALTER TABLE `pedido_maestros`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=10495;
--
-- AUTO_INCREMENT de la tabla `receta_maestros`
--
ALTER TABLE `receta_maestros`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=426;
--
-- AUTO_INCREMENT de la tabla `tipo_empleados`
--
ALTER TABLE `tipo_empleados`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT de la tabla `tipo_ivas`
--
ALTER TABLE `tipo_ivas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT de la tabla `tipo_recetas`
--
ALTER TABLE `tipo_recetas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=34;
--
-- AUTO_INCREMENT de la tabla `ubicacion`
--
ALTER TABLE `ubicacion`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=9;
--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `clientes`
--
ALTER TABLE `clientes`
ADD CONSTRAINT `fk_clientes_1` FOREIGN KEY (`condicion_iva_id`) REFERENCES `condicion_ivas` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `empleados`
--
ALTER TABLE `empleados`
ADD CONSTRAINT `fk_empleados_1` FOREIGN KEY (`tipo_empleado_id`) REFERENCES `tipo_empleados` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `factura_detalles`
--
ALTER TABLE `factura_detalles`
ADD CONSTRAINT `fk_factura_detalles_1` FOREIGN KEY (`factura_maestro_id`) REFERENCES `factura_maestros` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `factura_maestros`
--
ALTER TABLE `factura_maestros`
ADD CONSTRAINT `fk_factura_maestros_1` FOREIGN KEY (`tipo_iva_id`) REFERENCES `tipo_ivas` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
ADD CONSTRAINT `fk_factura_maestros_2` FOREIGN KEY (`cliente_id`) REFERENCES `clientes` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `pedido_detalles`
--
ALTER TABLE `pedido_detalles`
ADD CONSTRAINT `fk_pedido_detalles_1` FOREIGN KEY (`receta_maestro_id`) REFERENCES `receta_maestros` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
ADD CONSTRAINT `fk_pedido_detalles_2` FOREIGN KEY (`pedido_maestro_id`) REFERENCES `pedido_maestros` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
ADD CONSTRAINT `fk_pedido_detalles_4` FOREIGN KEY (`estado_id`) REFERENCES `estados` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `pedido_maestros`
--
ALTER TABLE `pedido_maestros`
ADD CONSTRAINT `fk_pedido_maestros_1` FOREIGN KEY (`cliente_id`) REFERENCES `clientes` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
ADD CONSTRAINT `fk_pedido_maestros_3` FOREIGN KEY (`empleado_id`) REFERENCES `empleados` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `receta_maestros`
--
ALTER TABLE `receta_maestros`s
ADD CONSTRAINT `fk_receta_maestros_1` FOREIGN KEY (`tipo_receta_id`) REFERENCES `tipo_recetas` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

alter table clientes add column estado int default null;
alter table clientes add column fecha_baja datetime default null;