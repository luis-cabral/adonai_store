-- phpMyAdmin SQL Dump
-- version 4.9.1
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost
-- Tiempo de generación: 10-12-2024 a las 01:58:18
-- Versión del servidor: 8.0.17
-- Versión de PHP: 7.3.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `adonai_store_schema`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `clientes`
--

CREATE TABLE `clientes` (
  `id_cliente` int(11) NOT NULL,
  `direccion` text,
  `telefono` varchar(15) DEFAULT NULL,
  `estado` enum('ACTIVO','INACTIVO') DEFAULT 'ACTIVO',
  `fch_estado` datetime DEFAULT NULL,
  `creado_en` datetime DEFAULT NULL,
  `actualizado_en` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `compras`
--

CREATE TABLE `compras` (
  `id_compra` int(11) NOT NULL,
  `id_producto` int(11) NOT NULL,
  `precio_compra` int(11) NOT NULL,
  `cantidad` int(11) NOT NULL,
  `estado` enum('ACTIVO','INACTIVO') CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL DEFAULT 'ACTIVO',
  `fch_estado` datetime NOT NULL,
  `creado_en` datetime NOT NULL,
  `actualizado_en` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Disparadores `compras`
--
DELIMITER $$
CREATE TRIGGER `before_insert_compras` BEFORE INSERT ON `compras` FOR EACH ROW BEGIN
    -- Inicializa fch_estado en la fecha actual si no se proporciona un valor
    IF NEW.fch_estado IS NULL THEN
        SET NEW.fch_estado = NOW();
    END IF;
    SET NEW.creado_en = NOW();
    --
    IF NEW.cantidad > 0 THEN
    	UPDATE productos SET stock = stock + NEW.cantidad;
    end if;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `empleados`
--

CREATE TABLE `empleados` (
  `id_empleado` int(11) NOT NULL,
  `id_punto_venta` int(11) DEFAULT NULL,
  `id_usuario` int(11) DEFAULT NULL,
  `estado` enum('ACTIVO','INACTIVO') DEFAULT 'ACTIVO',
  `fch_estado` datetime DEFAULT NULL,
  `creado_en` datetime DEFAULT NULL,
  `actualizado_en` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `productos`
--

CREATE TABLE `productos` (
  `id_producto` int(11) NOT NULL,
  `descripcion` text,
  `stock` int(11) NOT NULL,
  `id_proveedor` int(11) DEFAULT NULL,
  `estado` enum('ACTIVO','INACTIVO') DEFAULT 'ACTIVO',
  `fch_estado` datetime DEFAULT NULL,
  `creado_en` datetime DEFAULT NULL,
  `actualizado_en` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `proveedores`
--

CREATE TABLE `proveedores` (
  `id_proveedor` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `contacto` varchar(100) NOT NULL,
  `direccion` text,
  `estado` enum('ACTIVO','INACTIVO') DEFAULT 'ACTIVO',
  `fch_estado` datetime DEFAULT NULL,
  `creado_en` datetime DEFAULT NULL,
  `actualizado_en` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `proveedores`
--

INSERT INTO `proveedores` (`id_proveedor`, `nombre`, `contacto`, `direccion`, `estado`, `fch_estado`, `creado_en`, `actualizado_en`) VALUES
(1, 'Juan Deposito', '123454964106541', 'Facundo Machain', 'ACTIVO', NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `puntos_venta`
--

CREATE TABLE `puntos_venta` (
  `id_punto_venta` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `direccion` text,
  `estado` enum('ACTIVO','INACTIVO') DEFAULT 'ACTIVO',
  `fch_estado` datetime DEFAULT NULL,
  `creado_en` datetime DEFAULT NULL,
  `actualizado_en` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `rol`
--

CREATE TABLE `rol` (
  `id_rol` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `descripcion` text,
  `estado` enum('ACTIVO','INACTIVO') DEFAULT 'ACTIVO',
  `fch_estado` datetime DEFAULT NULL,
  `creado_en` datetime DEFAULT NULL,
  `actualizado_en` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `rol`
--

INSERT INTO `rol` (`id_rol`, `nombre`, `descripcion`, `estado`, `fch_estado`, `creado_en`, `actualizado_en`) VALUES
(1, 'Administrador', 'Acceso total al sistema.', 'ACTIVO', '2024-12-07 14:55:52', '2024-12-07 14:55:52', NULL),
(2, 'Vendedor', 'Puede ver y modificar el inventario y realizar ventas, pero no puede gestionar usuarios ni roles.', 'ACTIVO', '2024-12-07 14:55:52', '2024-12-07 14:55:52', '2024-12-08 19:12:40'),
(3, 'Inventario', 'Acceso solo para visualizar y actualizar el inventario.', 'ACTIVO', '2024-12-07 14:55:52', '2024-12-07 14:55:52', '2024-12-08 19:14:50'),
(4, 'Contabilidad', 'Acceso solo a los reportes financieros y de ventas, sin acceso a productos ni usuarios.', 'ACTIVO', '2024-12-08 19:15:38', '2024-12-08 19:15:38', '2024-12-08 19:17:26');

--
-- Disparadores `rol`
--
DELIMITER $$
CREATE TRIGGER `before_insert_rol` BEFORE INSERT ON `rol` FOR EACH ROW BEGIN
    SET NEW.fch_estado = NOW();
    SET NEW.creado_en = NOW();
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `before_update_rol` BEFORE UPDATE ON `rol` FOR EACH ROW BEGIN
    SET NEW.actualizado_en = NOW();
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `rol_ventanas`
--

CREATE TABLE `rol_ventanas` (
  `id_ventana` varchar(150) NOT NULL,
  `id_rol` int(11) NOT NULL,
  `estado` enum('ACTIVO','INACTIVO') DEFAULT 'ACTIVO',
  `fch_estado` datetime DEFAULT NULL,
  `creado_en` datetime DEFAULT NULL,
  `actualizado_en` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `rol_ventanas`
--

INSERT INTO `rol_ventanas` (`id_ventana`, `id_rol`, `estado`, `fch_estado`, `creado_en`, `actualizado_en`) VALUES
('gestion_productos.php', 1, 'ACTIVO', '2024-12-09 22:51:17', '2024-12-09 22:51:17', NULL),
('gestion_proveedores.php', 1, 'ACTIVO', '2024-12-09 21:54:53', '2024-12-09 21:54:53', NULL),
('gestion_RolVentanas.php', 1, 'ACTIVO', '2024-12-09 22:50:59', '2024-12-09 22:50:59', NULL);

--
-- Disparadores `rol_ventanas`
--
DELIMITER $$
CREATE TRIGGER `before_insert_rol_ventanas` BEFORE INSERT ON `rol_ventanas` FOR EACH ROW BEGIN
    SET NEW.fch_estado = NOW();
    SET NEW.creado_en = NOW();
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `before_update_rol_ventanas` BEFORE UPDATE ON `rol_ventanas` FOR EACH ROW BEGIN
    SET NEW.actualizado_en = NOW();
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id_usuario` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `apellido` varchar(100) NOT NULL,
  `email` varchar(255) NOT NULL,
  `contraseña` varchar(255) NOT NULL,
  `id_rol` int(11) DEFAULT NULL,
  `estado` enum('ACTIVO','INACTIVO') DEFAULT 'ACTIVO',
  `fch_estado` datetime DEFAULT NULL,
  `creado_en` datetime DEFAULT NULL,
  `actualizado_en` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id_usuario`, `nombre`, `apellido`, `email`, `contraseña`, `id_rol`, `estado`, `fch_estado`, `creado_en`, `actualizado_en`) VALUES
(5, 'Luis', 'Cabral', 'luis.a.cabral1@gmail.com', '$2y$10$S0jgEOpJCTgO7/5oR9RchuB2HvQ9/LbwPJzzUhehszWZ795YsBIuq', 2, 'ACTIVO', NULL, NULL, NULL),
(6, 'Adonai', 'Store', 'adonaiStore@gmail.com', '$2y$10$liYmAjTuUymmKotMJqlaMezs1yQNR0fWjuMHYeTy2TaIss0IfsUN2', 1, 'ACTIVO', NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ventanas`
--

CREATE TABLE `ventanas` (
  `id_ventana` varchar(250) NOT NULL,
  `descripcion` varchar(500) NOT NULL,
  `grupo` varchar(45) NOT NULL DEFAULT 'Gestiones',
  `estado` enum('ACTIVO','INACTIVO') DEFAULT 'ACTIVO',
  `fch_estado` datetime DEFAULT NULL,
  `creado_en` datetime DEFAULT NULL,
  `actualizado_en` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `ventanas`
--

INSERT INTO `ventanas` (`id_ventana`, `descripcion`, `grupo`, `estado`, `fch_estado`, `creado_en`, `actualizado_en`) VALUES
('gestion_productos.php', 'Productos', 'Gestiones', 'ACTIVO', '2024-12-09 22:49:18', '2024-12-09 22:49:18', NULL),
('gestion_proveedores.php', 'Proveedores', 'Gestiones', 'ACTIVO', '2024-12-09 21:52:18', '2024-12-09 21:52:18', NULL),
('gestion_RolVentanas.php', 'Rol de Ventanas', 'Gestiones', 'ACTIVO', '2024-12-09 22:50:38', '2024-12-09 22:50:38', NULL);

--
-- Disparadores `ventanas`
--
DELIMITER $$
CREATE TRIGGER `before_insert_ventanas` BEFORE INSERT ON `ventanas` FOR EACH ROW BEGIN
    SET NEW.fch_estado = NOW();
    SET NEW.creado_en = NOW();
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `before_update_ventanas` BEFORE UPDATE ON `ventanas` FOR EACH ROW BEGIN
    SET NEW.actualizado_en = NOW();
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ventas`
--

CREATE TABLE `ventas` (
  `id_venta` int(11) NOT NULL,
  `fecha` datetime NOT NULL,
  `total` decimal(10,2) NOT NULL,
  `cantidad` int(11) NOT NULL,
  `id_cliente` int(11) DEFAULT NULL,
  `id_punto_venta` int(11) DEFAULT NULL,
  `estado` enum('ACTIVO','INACTIVO') DEFAULT 'ACTIVO',
  `fch_estado` datetime DEFAULT NULL,
  `creado_en` datetime DEFAULT NULL,
  `actualizado_en` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Disparadores `ventas`
--
DELIMITER $$
CREATE TRIGGER `before_insert_ventas` BEFORE INSERT ON `ventas` FOR EACH ROW BEGIN
    -- Inicializa fch_estado en la fecha actual si no se proporciona un valor
    IF NEW.fch_estado IS NULL THEN
        SET NEW.fch_estado = NOW();
    END IF;
    SET NEW.creado_en = NOW();
    --
    IF NEW.cantidad > 0 THEN
    	UPDATE productos SET stock = stock - NEW.cantidad;
    end if;
END
$$
DELIMITER ;

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `clientes`
--
ALTER TABLE `clientes`
  ADD PRIMARY KEY (`id_cliente`);

--
-- Indices de la tabla `compras`
--
ALTER TABLE `compras`
  ADD PRIMARY KEY (`id_compra`),
  ADD KEY `prod_comp_fk` (`id_producto`);

--
-- Indices de la tabla `empleados`
--
ALTER TABLE `empleados`
  ADD PRIMARY KEY (`id_empleado`),
  ADD KEY `punto_venta` (`id_punto_venta`),
  ADD KEY `id_usuario` (`id_usuario`);

--
-- Indices de la tabla `productos`
--
ALTER TABLE `productos`
  ADD PRIMARY KEY (`id_producto`),
  ADD KEY `id_proveedor` (`id_proveedor`);

--
-- Indices de la tabla `proveedores`
--
ALTER TABLE `proveedores`
  ADD PRIMARY KEY (`id_proveedor`);

--
-- Indices de la tabla `puntos_venta`
--
ALTER TABLE `puntos_venta`
  ADD PRIMARY KEY (`id_punto_venta`);

--
-- Indices de la tabla `rol`
--
ALTER TABLE `rol`
  ADD PRIMARY KEY (`id_rol`);

--
-- Indices de la tabla `rol_ventanas`
--
ALTER TABLE `rol_ventanas`
  ADD PRIMARY KEY (`id_ventana`,`id_rol`),
  ADD KEY `rol_ventana_fk_idx` (`id_rol`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id_usuario`),
  ADD UNIQUE KEY `email` (`email`),
  ADD KEY `rol` (`id_rol`);

--
-- Indices de la tabla `ventanas`
--
ALTER TABLE `ventanas`
  ADD PRIMARY KEY (`id_ventana`),
  ADD KEY `grupo_ventana_idx` (`grupo`);

--
-- Indices de la tabla `ventas`
--
ALTER TABLE `ventas`
  ADD PRIMARY KEY (`id_venta`),
  ADD KEY `id_cliente` (`id_cliente`),
  ADD KEY `id_punto_venta` (`id_punto_venta`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `clientes`
--
ALTER TABLE `clientes`
  MODIFY `id_cliente` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `compras`
--
ALTER TABLE `compras`
  MODIFY `id_compra` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `empleados`
--
ALTER TABLE `empleados`
  MODIFY `id_empleado` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `productos`
--
ALTER TABLE `productos`
  MODIFY `id_producto` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `proveedores`
--
ALTER TABLE `proveedores`
  MODIFY `id_proveedor` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de la tabla `puntos_venta`
--
ALTER TABLE `puntos_venta`
  MODIFY `id_punto_venta` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id_usuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `ventas`
--
ALTER TABLE `ventas`
  MODIFY `id_venta` int(11) NOT NULL AUTO_INCREMENT;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `compras`
--
ALTER TABLE `compras`
  ADD CONSTRAINT `prod_comp_fk` FOREIGN KEY (`id_producto`) REFERENCES `productos` (`id_producto`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Filtros para la tabla `empleados`
--
ALTER TABLE `empleados`
  ADD CONSTRAINT `puve_empl_fk` FOREIGN KEY (`id_punto_venta`) REFERENCES `puntos_venta` (`id_punto_venta`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `usua_empl` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id_usuario`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Filtros para la tabla `productos`
--
ALTER TABLE `productos`
  ADD CONSTRAINT `prov_prod_fk` FOREIGN KEY (`id_proveedor`) REFERENCES `proveedores` (`id_proveedor`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Filtros para la tabla `rol_ventanas`
--
ALTER TABLE `rol_ventanas`
  ADD CONSTRAINT `id_rol_fk` FOREIGN KEY (`id_rol`) REFERENCES `rol` (`id_rol`),
  ADD CONSTRAINT `id_ventana_fk` FOREIGN KEY (`id_ventana`) REFERENCES `ventanas` (`id_ventana`);

--
-- Filtros para la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD CONSTRAINT `role_usua_fk` FOREIGN KEY (`id_rol`) REFERENCES `rol` (`id_rol`) ON DELETE RESTRICT ON UPDATE RESTRICT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
