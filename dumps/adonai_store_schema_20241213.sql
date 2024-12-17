-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 12-12-2024 a las 21:56:52
-- Versión del servidor: 8.0.17
-- Versión de PHP: 7.4.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `adonai_store_schema`
--
CREATE DATABASE IF NOT EXISTS `adonai_store_schema` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci;
USE `adonai_store_schema`;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `clientes`
--

DROP TABLE IF EXISTS `clientes`;
CREATE TABLE IF NOT EXISTS `clientes` (
  `id_cliente` int(11) NOT NULL AUTO_INCREMENT,
  `direccion` text,
  `telefono` varchar(15) DEFAULT NULL,
  `estado` enum('ACTIVO','INACTIVO') DEFAULT 'ACTIVO',
  `fch_estado` datetime DEFAULT NULL,
  `creado_en` datetime DEFAULT NULL,
  `actualizado_en` datetime DEFAULT NULL,
  PRIMARY KEY (`id_cliente`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Disparadores `clientes`
--
DROP TRIGGER IF EXISTS `before_deleting_clientes`;
DELIMITER $$
CREATE TRIGGER `before_deleting_clientes` BEFORE DELETE ON `clientes` FOR EACH ROW BEGIN 
    -- 
    signal sqlstate '45000' set message_text = 'No se pueden eliminar registros - before_deleting_clientes';
    -- 
END
$$
DELIMITER ;
DROP TRIGGER IF EXISTS `before_inserting_clientes`;
DELIMITER $$
CREATE TRIGGER `before_inserting_clientes` BEFORE INSERT ON `clientes` FOR EACH ROW BEGIN 
    -- Inicializa fch_estado en la fecha actual si no se proporciona un valor
    IF NEW.fch_estado IS NULL THEN
        SET NEW.fch_estado = NOW();
    END IF;
    SET NEW.creado_en = NOW();
    --
END
$$
DELIMITER ;
DROP TRIGGER IF EXISTS `before_updating_clientes`;
DELIMITER $$
CREATE TRIGGER `before_updating_clientes` BEFORE UPDATE ON `clientes` FOR EACH ROW BEGIN 
    -- Si el estado cambia, actualiza la fecha de estado
    IF NEW.estado <> OLD.estado THEN
        SET NEW.fch_estado = NOW();
    END IF;
    SET NEW.actualizado_en = NOW();
    --
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `compras`
--

DROP TABLE IF EXISTS `compras`;
CREATE TABLE IF NOT EXISTS `compras` (
  `id_compra` int(11) NOT NULL AUTO_INCREMENT,
  `id_producto` int(11) NOT NULL,
  `precio_compra_x_unidad` int(11) NOT NULL,
  `cantidad` int(11) NOT NULL,
  `precio_compra_total` int(11) NOT NULL DEFAULT '0',
  `estado` enum('ACTIVO','ANULADO') CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL DEFAULT 'ACTIVO',
  `fch_estado` datetime NOT NULL,
  `creado_en` datetime NOT NULL,
  `actualizado_en` datetime DEFAULT NULL,
  PRIMARY KEY (`id_compra`),
  KEY `prod_comp_fk` (`id_producto`)
) ENGINE=InnoDB AUTO_INCREMENT=31 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `compras`
--

INSERT INTO `compras` (`id_compra`, `id_producto`, `precio_compra_x_unidad`, `cantidad`, `precio_compra_total`, `estado`, `fch_estado`, `creado_en`, `actualizado_en`) VALUES
(1, 1, 80000, 10, 800000, 'ACTIVO', '2024-12-12 11:31:55', '2024-12-12 11:31:55', NULL),
(2, 2, 120000, 15, 1800000, 'ACTIVO', '2024-12-12 11:31:55', '2024-12-12 11:31:55', NULL),
(3, 3, 250000, 5, 1250000, 'ACTIVO', '2024-12-12 11:31:55', '2024-12-12 11:31:55', NULL),
(4, 4, 150000, 8, 1200000, 'ACTIVO', '2024-12-12 11:31:55', '2024-12-12 11:31:55', NULL),
(5, 5, 90000, 12, 1080000, 'ACTIVO', '2024-12-12 11:31:55', '2024-12-12 11:31:55', NULL),
(6, 6, 85000, 10, 850000, 'ACTIVO', '2024-12-12 11:31:55', '2024-12-12 11:31:55', NULL),
(7, 7, 300000, 3, 900000, 'ACTIVO', '2024-12-12 11:31:55', '2024-12-12 11:31:55', NULL),
(8, 8, 70000, 25, 1750000, 'ACTIVO', '2024-12-12 11:31:55', '2024-12-12 11:31:55', NULL),
(9, 9, 110000, 10, 1100000, 'ACTIVO', '2024-12-12 11:31:55', '2024-12-12 11:31:55', NULL),
(10, 10, 130000, 15, 1950000, 'ACTIVO', '2024-12-12 11:31:55', '2024-12-12 11:31:55', NULL),
(11, 11, 150000, 12, 1800000, 'ACTIVO', '2024-12-12 11:31:55', '2024-12-12 11:31:55', NULL),
(12, 12, 75000, 20, 1500000, 'ACTIVO', '2024-12-12 11:31:55', '2024-12-12 11:31:55', NULL),
(13, 13, 90000, 8, 720000, 'ACTIVO', '2024-12-12 11:31:55', '2024-12-12 11:31:55', NULL),
(14, 14, 100000, 10, 1000000, 'ACTIVO', '2024-12-12 11:31:55', '2024-12-12 11:31:55', NULL),
(15, 15, 300000, 5, 1500000, 'ACTIVO', '2024-12-12 11:31:55', '2024-12-12 11:31:55', NULL),
(16, 16, 120000, 7, 840000, 'ACTIVO', '2024-12-12 11:31:55', '2024-12-12 11:31:55', NULL),
(17, 17, 250000, 4, 1000000, 'ACTIVO', '2024-12-12 11:31:55', '2024-12-12 11:31:55', NULL),
(18, 18, 65000, 25, 1625000, 'ACTIVO', '2024-12-12 11:31:55', '2024-12-12 11:31:55', NULL),
(19, 19, 350000, 3, 1050000, 'ACTIVO', '2024-12-12 11:31:55', '2024-12-12 11:31:55', NULL),
(20, 20, 40000, 20, 800000, 'ACTIVO', '2024-12-12 11:31:55', '2024-12-12 11:31:55', NULL),
(21, 21, 30000, 25, 750000, 'ACTIVO', '2024-12-12 11:31:55', '2024-12-12 11:31:55', NULL),
(22, 22, 450000, 2, 900000, 'ACTIVO', '2024-12-12 11:31:55', '2024-12-12 11:31:55', NULL),
(23, 23, 150000, 6, 900000, 'ACTIVO', '2024-12-12 11:31:55', '2024-12-12 11:31:55', NULL),
(24, 24, 50000, 15, 750000, 'ACTIVO', '2024-12-12 11:31:55', '2024-12-12 11:31:55', NULL),
(25, 25, 60000, 20, 1200000, 'ACTIVO', '2024-12-12 11:31:55', '2024-12-12 11:31:55', NULL),
(26, 26, 30000, 25, 750000, 'ACTIVO', '2024-12-12 11:31:55', '2024-12-12 11:31:55', NULL),
(27, 27, 35000, 30, 1050000, 'ACTIVO', '2024-12-12 11:31:55', '2024-12-12 11:31:55', NULL),
(28, 28, 200000, 8, 1600000, 'ACTIVO', '2024-12-12 11:31:55', '2024-12-12 11:31:55', NULL),
(29, 29, 150000, 5, 750000, 'ACTIVO', '2024-12-12 11:31:55', '2024-12-12 11:31:55', NULL),
(30, 30, 10000, 50, 500000, 'ACTIVO', '2024-12-12 11:31:55', '2024-12-12 11:31:55', NULL);

--
-- Disparadores `compras`
--
DROP TRIGGER IF EXISTS `before_deleting_compras`;
DELIMITER $$
CREATE TRIGGER `before_deleting_compras` BEFORE DELETE ON `compras` FOR EACH ROW BEGIN 
    -- 
    signal sqlstate '45000' set message_text = 'No se pueden eliminar registros - before_deleting_compras';
    -- 
END
$$
DELIMITER ;
DROP TRIGGER IF EXISTS `before_insert_compras`;
DELIMITER $$
CREATE TRIGGER `before_insert_compras` BEFORE INSERT ON `compras` FOR EACH ROW BEGIN
    -- Inicializa fch_estado en la fecha actual si no se proporciona un valor
    IF NEW.fch_estado IS NULL THEN
        SET NEW.fch_estado = NOW();
    END IF;
    SET NEW.creado_en = NOW();
    --
    SET NEW.precio_compra_total = NEW.precio_compra_x_unidad * NEW.cantidad;
    --
    IF NEW.cantidad > 0 THEN
    	UPDATE productos SET stock = stock + NEW.cantidad where id_producto = NEW.id_producto;
    end if;
END
$$
DELIMITER ;
DROP TRIGGER IF EXISTS `before_update_compras`;
DELIMITER $$
CREATE TRIGGER `before_update_compras` BEFORE UPDATE ON `compras` FOR EACH ROW BEGIN
    -- Si el estado cambia, actualiza la fecha de estado
    IF NEW.estado <> OLD.estado THEN
        SET NEW.fch_estado = NOW();
        -- 
        IF NEW.estado = 'ANULADO' THEN
        	UPDATE productos SET stock = stock - NEW.cantidad where id_producto = NEW.id_producto;
        END IF;
        -- 
        IF NEW.estado = 'ACTIVO' THEN
        	UPDATE productos SET stock = stock + NEW.cantidad where id_producto = NEW.id_producto;
        END IF;
    END IF;
    SET NEW.actualizado_en = NOW();
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `empleados`
--

DROP TABLE IF EXISTS `empleados`;
CREATE TABLE IF NOT EXISTS `empleados` (
  `id_empleado` int(11) NOT NULL AUTO_INCREMENT,
  `id_punto_venta` int(11) DEFAULT NULL,
  `id_usuario` int(11) DEFAULT NULL,
  `estado` enum('ACTIVO','INACTIVO') DEFAULT 'ACTIVO',
  `fch_estado` datetime DEFAULT NULL,
  `creado_en` datetime DEFAULT NULL,
  `actualizado_en` datetime DEFAULT NULL,
  PRIMARY KEY (`id_empleado`),
  UNIQUE KEY `id_usuario_un` (`id_usuario`),
  KEY `punto_venta` (`id_punto_venta`),
  KEY `id_usuario` (`id_usuario`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `empleados`
--

INSERT INTO `empleados` (`id_empleado`, `id_punto_venta`, `id_usuario`, `estado`, `fch_estado`, `creado_en`, `actualizado_en`) VALUES
(1, 2, 5, 'ACTIVO', '2024-12-12 16:29:45', '2024-12-12 16:29:45', '2024-12-12 17:53:56');

--
-- Disparadores `empleados`
--
DROP TRIGGER IF EXISTS `before_deleting_empleados`;
DELIMITER $$
CREATE TRIGGER `before_deleting_empleados` BEFORE DELETE ON `empleados` FOR EACH ROW BEGIN 
    -- 
    signal sqlstate '45000' set message_text = 'No se pueden eliminar registros - before_deleting_empleados';
    -- 
END
$$
DELIMITER ;
DROP TRIGGER IF EXISTS `before_inserting_empleados`;
DELIMITER $$
CREATE TRIGGER `before_inserting_empleados` BEFORE INSERT ON `empleados` FOR EACH ROW BEGIN 
    -- Inicializa fch_estado en la fecha actual si no se proporciona un valor
    IF NEW.fch_estado IS NULL THEN
        SET NEW.fch_estado = NOW();
    END IF;
    SET NEW.creado_en = NOW();
    --
END
$$
DELIMITER ;
DROP TRIGGER IF EXISTS `before_updating_empleados`;
DELIMITER $$
CREATE TRIGGER `before_updating_empleados` BEFORE UPDATE ON `empleados` FOR EACH ROW BEGIN 
    -- Si el estado cambia, actualiza la fecha de estado
    IF NEW.estado <> OLD.estado THEN
        SET NEW.fch_estado = NOW();
    END IF;
    SET NEW.actualizado_en = NOW();
    --
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `productos`
--

DROP TABLE IF EXISTS `productos`;
CREATE TABLE IF NOT EXISTS `productos` (
  `id_producto` int(11) NOT NULL AUTO_INCREMENT,
  `descripcion` text,
  `stock` int(11) NOT NULL,
  `id_proveedor` int(11) DEFAULT NULL,
  `estado` enum('ACTIVO','INACTIVO') DEFAULT 'ACTIVO',
  `fch_estado` datetime DEFAULT NULL,
  `creado_en` datetime DEFAULT NULL,
  `actualizado_en` datetime DEFAULT NULL,
  PRIMARY KEY (`id_producto`),
  KEY `id_proveedor` (`id_proveedor`)
) ENGINE=InnoDB AUTO_INCREMENT=34 DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `productos`
--

INSERT INTO `productos` (`id_producto`, `descripcion`, `stock`, `id_proveedor`, `estado`, `fch_estado`, `creado_en`, `actualizado_en`) VALUES
(1, 'Camisas básicas', 10, 1, 'ACTIVO', NULL, NULL, NULL),
(2, 'Pantalones de mezclilla', 15, 1, 'ACTIVO', NULL, NULL, NULL),
(3, 'Chaquetas ligeras', 5, 1, 'ACTIVO', NULL, NULL, NULL),
(4, 'Vestidos de verano', 8, 2, 'ACTIVO', NULL, NULL, NULL),
(5, 'Blusas estampadas', 12, 2, 'ACTIVO', NULL, NULL, NULL),
(6, 'Faldas cortas', 10, 2, 'ACTIVO', NULL, NULL, NULL),
(7, 'Trajes formales', 3, 3, 'ACTIVO', NULL, NULL, NULL),
(8, 'Corbatas de seda', 25, 3, 'ACTIVO', NULL, NULL, NULL),
(9, 'Camisas de vestir', 10, 3, 'ACTIVO', NULL, NULL, NULL),
(10, 'Ropa deportiva', 15, 4, 'ACTIVO', NULL, NULL, NULL),
(11, 'Sudaderas', 12, 4, 'ACTIVO', NULL, NULL, NULL),
(12, 'Shorts deportivos', 20, 4, 'ACTIVO', NULL, NULL, NULL),
(13, 'Sombreros de paja', 8, 5, 'ACTIVO', NULL, NULL, NULL),
(14, 'Camisas guayaberas', 10, 5, 'ACTIVO', NULL, NULL, NULL),
(15, 'Zapatos de cuero', 5, 5, 'ACTIVO', NULL, NULL, NULL),
(16, 'Pantalones de lino', 7, 6, 'ACTIVO', NULL, NULL, NULL),
(17, 'Blazers casuales', 4, 6, 'ACTIVO', NULL, NULL, NULL),
(18, 'Camisetas estampadas', 25, 6, 'ACTIVO', NULL, NULL, NULL),
(19, 'Abrigos de lana', 3, 7, 'ACTIVO', NULL, NULL, NULL),
(20, 'Bufandas tejidas', 20, 7, 'ACTIVO', NULL, NULL, NULL),
(21, 'Guantes de invierno', 25, 7, 'ACTIVO', NULL, NULL, NULL),
(22, 'Vestidos de gala', 2, 8, 'ACTIVO', NULL, NULL, NULL),
(23, 'Zapatos de tacón', 6, 8, 'ACTIVO', NULL, NULL, NULL),
(24, 'Accesorios de moda', 15, 8, 'ACTIVO', NULL, NULL, NULL),
(25, 'Pijamas de algodón', 20, 9, 'ACTIVO', NULL, NULL, NULL),
(26, 'Ropa interior masculina', 25, 9, 'ACTIVO', NULL, NULL, NULL),
(27, 'Ropa interior femenina', 30, 9, 'ACTIVO', NULL, NULL, NULL),
(28, 'Chalecos acolchados', 8, 10, 'ACTIVO', NULL, NULL, NULL),
(29, 'Ropa impermeable', 5, 10, 'ACTIVO', NULL, NULL, NULL),
(30, 'Calcetines térmicos', 50, 10, 'ACTIVO', NULL, NULL, NULL),
(31, 'Sandalias de verano', 0, 11, 'ACTIVO', NULL, NULL, NULL),
(32, 'Bolsos de cuero', 0, 11, 'ACTIVO', NULL, NULL, NULL),
(33, 'Carteras de mano', 0, 11, 'ACTIVO', NULL, NULL, NULL);

--
-- Disparadores `productos`
--
DROP TRIGGER IF EXISTS `before_deleting_productos`;
DELIMITER $$
CREATE TRIGGER `before_deleting_productos` BEFORE DELETE ON `productos` FOR EACH ROW BEGIN 
    -- 
    signal sqlstate '45000' set message_text = 'No se pueden eliminar registros - before_deleting_productos';
    -- 
END
$$
DELIMITER ;
DROP TRIGGER IF EXISTS `before_inserting_productos`;
DELIMITER $$
CREATE TRIGGER `before_inserting_productos` BEFORE INSERT ON `productos` FOR EACH ROW BEGIN 
    -- Inicializa fch_estado en la fecha actual si no se proporciona un valor
    IF NEW.fch_estado IS NULL THEN
        SET NEW.fch_estado = NOW();
    END IF;
    SET NEW.creado_en = NOW();
    --
END
$$
DELIMITER ;
DROP TRIGGER IF EXISTS `before_updating_productos`;
DELIMITER $$
CREATE TRIGGER `before_updating_productos` BEFORE UPDATE ON `productos` FOR EACH ROW BEGIN 
    -- Si el estado cambia, actualiza la fecha de estado
    IF NEW.estado <> OLD.estado THEN
        SET NEW.fch_estado = NOW();
    END IF;
    SET NEW.actualizado_en = NOW();
    --
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `proveedores`
--

DROP TABLE IF EXISTS `proveedores`;
CREATE TABLE IF NOT EXISTS `proveedores` (
  `id_proveedor` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(100) NOT NULL,
  `contacto` varchar(100) NOT NULL,
  `direccion` text,
  `estado` enum('ACTIVO','INACTIVO') DEFAULT 'ACTIVO',
  `fch_estado` datetime DEFAULT NULL,
  `creado_en` datetime DEFAULT NULL,
  `actualizado_en` datetime DEFAULT NULL,
  PRIMARY KEY (`id_proveedor`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `proveedores`
--

INSERT INTO `proveedores` (`id_proveedor`, `nombre`, `contacto`, `direccion`, `estado`, `fch_estado`, `creado_en`, `actualizado_en`) VALUES
(1, 'Juan Deposito', 'Denis Roa', 'Facundo Machain', 'INACTIVO', '2024-12-12 14:10:49', NULL, '2024-12-12 14:10:49'),
(2, 'Moda Guaraní S.A.', 'Carlos Benítez', 'Calle Palma 123, Asunción, Paraguay', 'ACTIVO', NULL, NULL, NULL),
(3, 'Estilo Paraguayo', 'Ana Gómez', 'Avenida Mariscal López 456, Asunción, Paraguay', 'ACTIVO', NULL, NULL, NULL),
(4, 'Textiles Ñandutí', 'Jorge Martínez', 'Calle Cerro Corá 789, Luque, Paraguay', 'ACTIVO', NULL, NULL, NULL),
(5, 'Ropa del Chaco', 'Lorena González', 'Ruta Transchaco Km 12, Mariano Roque Alonso, Paraguay', 'ACTIVO', NULL, NULL, NULL),
(6, 'Diseños Mbarete', 'Sofía López', 'Avenida Eusebio Ayala 2345, San Lorenzo, Paraguay', 'ACTIVO', NULL, NULL, NULL),
(7, 'Elegancia Paraguaya', 'Ricardo Fernández', 'Calle Defensores del Chaco 678, Ciudad del Este, Paraguay', 'ACTIVO', NULL, NULL, NULL),
(8, 'Alta Moda Guaraní', 'Gabriela Torres', 'Calle Capitán Miranda 345, Encarnación, Paraguay', 'ACTIVO', NULL, NULL, NULL),
(9, 'Textiles del Este', 'Mateo Delgado', 'Avenida República del Paraguay 101, Hernandarias, Paraguay', 'ACTIVO', NULL, NULL, NULL),
(10, 'Fibras del Sur', 'María Ramírez', 'Calle 14 de Mayo 567, Villarrica, Paraguay', 'ACTIVO', NULL, NULL, NULL),
(11, 'Estilo Paraguayo Chic', 'Luis Gómez', 'Calle Artigas 890, Fernando de la Mora, Paraguay', 'ACTIVO', NULL, NULL, NULL);

--
-- Disparadores `proveedores`
--
DROP TRIGGER IF EXISTS `before_deleting_proveedores`;
DELIMITER $$
CREATE TRIGGER `before_deleting_proveedores` BEFORE DELETE ON `proveedores` FOR EACH ROW BEGIN 
    -- 
    signal sqlstate '45000' set message_text = 'No se pueden eliminar registros - before_deleting_proveedores';
    -- 
END
$$
DELIMITER ;
DROP TRIGGER IF EXISTS `before_inserting_proveedores`;
DELIMITER $$
CREATE TRIGGER `before_inserting_proveedores` BEFORE INSERT ON `proveedores` FOR EACH ROW BEGIN 
    -- Inicializa fch_estado en la fecha actual si no se proporciona un valor
    IF NEW.fch_estado IS NULL THEN
        SET NEW.fch_estado = NOW();
    END IF;
    SET NEW.creado_en = NOW();
    --
END
$$
DELIMITER ;
DROP TRIGGER IF EXISTS `before_updating_proveedores`;
DELIMITER $$
CREATE TRIGGER `before_updating_proveedores` BEFORE UPDATE ON `proveedores` FOR EACH ROW BEGIN 
    -- Si el estado cambia, actualiza la fecha de estado
    IF NEW.estado <> OLD.estado THEN
        SET NEW.fch_estado = NOW();
    END IF;
    SET NEW.actualizado_en = NOW();
    --
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `puntos_venta`
--

DROP TABLE IF EXISTS `puntos_venta`;
CREATE TABLE IF NOT EXISTS `puntos_venta` (
  `id_punto_venta` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(100) NOT NULL,
  `direccion` text,
  `estado` enum('ACTIVO','INACTIVO') DEFAULT 'ACTIVO',
  `fch_estado` datetime DEFAULT NULL,
  `creado_en` datetime DEFAULT NULL,
  `actualizado_en` datetime DEFAULT NULL,
  PRIMARY KEY (`id_punto_venta`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `puntos_venta`
--

INSERT INTO `puntos_venta` (`id_punto_venta`, `nombre`, `direccion`, `estado`, `fch_estado`, `creado_en`, `actualizado_en`) VALUES
(1, 'Adonai Store 1', 'Limpio Salado', 'ACTIVO', '2024-12-12 15:08:45', '2024-12-12 15:08:45', NULL),
(2, 'Adonai Store 2', 'Guido Spano 3050', 'ACTIVO', '2024-12-12 15:09:12', '2024-12-12 15:09:12', NULL);

--
-- Disparadores `puntos_venta`
--
DROP TRIGGER IF EXISTS `before_deleting_puntos_venta`;
DELIMITER $$
CREATE TRIGGER `before_deleting_puntos_venta` BEFORE DELETE ON `puntos_venta` FOR EACH ROW BEGIN 
    -- 
    signal sqlstate '45000' set message_text = 'No se pueden eliminar registros - before_deleting_puntos_venta';
    -- 
END
$$
DELIMITER ;
DROP TRIGGER IF EXISTS `before_inserting_puntos_venta`;
DELIMITER $$
CREATE TRIGGER `before_inserting_puntos_venta` BEFORE INSERT ON `puntos_venta` FOR EACH ROW BEGIN 
    -- Inicializa fch_estado en la fecha actual si no se proporciona un valor
    IF NEW.fch_estado IS NULL THEN
        SET NEW.fch_estado = NOW();
    END IF;
    SET NEW.creado_en = NOW();
    --
END
$$
DELIMITER ;
DROP TRIGGER IF EXISTS `before_updating_puntos_venta`;
DELIMITER $$
CREATE TRIGGER `before_updating_puntos_venta` BEFORE UPDATE ON `puntos_venta` FOR EACH ROW BEGIN 
    -- Si el estado cambia, actualiza la fecha de estado
    IF NEW.estado <> OLD.estado THEN
        SET NEW.fch_estado = NOW();
    END IF;
    SET NEW.actualizado_en = NOW();
    --
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `rol`
--

DROP TABLE IF EXISTS `rol`;
CREATE TABLE IF NOT EXISTS `rol` (
  `id_rol` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `descripcion` text,
  `estado` enum('ACTIVO','INACTIVO') DEFAULT 'ACTIVO',
  `fch_estado` datetime DEFAULT NULL,
  `creado_en` datetime DEFAULT NULL,
  `actualizado_en` datetime DEFAULT NULL,
  PRIMARY KEY (`id_rol`)
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
DROP TRIGGER IF EXISTS `before_deleting_rol`;
DELIMITER $$
CREATE TRIGGER `before_deleting_rol` BEFORE DELETE ON `rol` FOR EACH ROW BEGIN 
    -- 
    signal sqlstate '45000' set message_text = 'No se pueden eliminar registros - before_deleting_rol';
    -- 
END
$$
DELIMITER ;
DROP TRIGGER IF EXISTS `before_inserting_rol`;
DELIMITER $$
CREATE TRIGGER `before_inserting_rol` BEFORE INSERT ON `rol` FOR EACH ROW BEGIN 
    -- Inicializa fch_estado en la fecha actual si no se proporciona un valor
    IF NEW.fch_estado IS NULL THEN
        SET NEW.fch_estado = NOW();
    END IF;
    SET NEW.creado_en = NOW();
    --
END
$$
DELIMITER ;
DROP TRIGGER IF EXISTS `before_updating_rol`;
DELIMITER $$
CREATE TRIGGER `before_updating_rol` BEFORE UPDATE ON `rol` FOR EACH ROW BEGIN 
    -- Si el estado cambia, actualiza la fecha de estado
    IF NEW.estado <> OLD.estado THEN
        SET NEW.fch_estado = NOW();
    END IF;
    SET NEW.actualizado_en = NOW();
    --
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `rol_ventanas`
--

DROP TABLE IF EXISTS `rol_ventanas`;
CREATE TABLE IF NOT EXISTS `rol_ventanas` (
  `id_ventana` varchar(150) NOT NULL,
  `id_rol` int(11) NOT NULL,
  `estado` enum('ACTIVO','INACTIVO') DEFAULT 'ACTIVO',
  `fch_estado` datetime DEFAULT NULL,
  `creado_en` datetime DEFAULT NULL,
  `actualizado_en` datetime DEFAULT NULL,
  PRIMARY KEY (`id_ventana`,`id_rol`),
  KEY `rol_ventana_fk_idx` (`id_rol`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `rol_ventanas`
--

INSERT INTO `rol_ventanas` (`id_ventana`, `id_rol`, `estado`, `fch_estado`, `creado_en`, `actualizado_en`) VALUES
('gestion_clientes.php', 1, 'ACTIVO', '2024-12-12 14:19:01', '2024-12-12 14:19:01', NULL),
('gestion_empleados.php', 1, 'ACTIVO', '2024-12-12 15:52:19', '2024-12-12 15:52:19', NULL),
('gestion_productos.php', 1, 'ACTIVO', '2024-12-09 22:51:17', '2024-12-09 22:51:17', NULL),
('gestion_productos.php', 3, 'ACTIVO', '2024-12-12 13:26:35', '2024-12-12 13:26:35', NULL),
('gestion_proveedores.php', 1, 'ACTIVO', '2024-12-09 21:54:53', '2024-12-09 21:54:53', NULL),
('gestion_proveedores.php', 3, 'ACTIVO', '2024-12-12 13:26:40', '2024-12-12 13:26:40', NULL),
('gestion_puntos_venta.php', 1, 'ACTIVO', '2024-12-12 15:05:01', '2024-12-12 15:05:01', NULL),
('gestion_RolVentanas.php', 1, 'ACTIVO', '2024-12-09 22:50:59', '2024-12-09 22:50:59', NULL),
('gestion_usuarios.php', 1, 'ACTIVO', '2024-12-11 16:45:45', '2024-12-11 16:45:45', NULL);

--
-- Disparadores `rol_ventanas`
--
DROP TRIGGER IF EXISTS `before_deleting_rol_ventanas`;
DELIMITER $$
CREATE TRIGGER `before_deleting_rol_ventanas` BEFORE DELETE ON `rol_ventanas` FOR EACH ROW BEGIN 
    -- 
    signal sqlstate '45000' set message_text = 'No se pueden eliminar registros - before_deleting_rol_ventanas';
    -- 
END
$$
DELIMITER ;
DROP TRIGGER IF EXISTS `before_inserting_rol_ventanas`;
DELIMITER $$
CREATE TRIGGER `before_inserting_rol_ventanas` BEFORE INSERT ON `rol_ventanas` FOR EACH ROW BEGIN 
    -- Inicializa fch_estado en la fecha actual si no se proporciona un valor
    IF NEW.fch_estado IS NULL THEN
        SET NEW.fch_estado = NOW();
    END IF;
    SET NEW.creado_en = NOW();
    --
END
$$
DELIMITER ;
DROP TRIGGER IF EXISTS `before_updating_rol_ventanas`;
DELIMITER $$
CREATE TRIGGER `before_updating_rol_ventanas` BEFORE UPDATE ON `rol_ventanas` FOR EACH ROW BEGIN 
    -- Si el estado cambia, actualiza la fecha de estado
    IF NEW.estado <> OLD.estado THEN
        SET NEW.fch_estado = NOW();
    END IF;
    SET NEW.actualizado_en = NOW();
    --
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

DROP TABLE IF EXISTS `usuarios`;
CREATE TABLE IF NOT EXISTS `usuarios` (
  `id_usuario` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(100) NOT NULL,
  `apellido` varchar(100) NOT NULL,
  `email` varchar(255) NOT NULL,
  `contraseña` varchar(255) NOT NULL,
  `id_rol` int(11) DEFAULT NULL,
  `estado` enum('ACTIVO','INACTIVO') DEFAULT 'ACTIVO',
  `fch_estado` datetime DEFAULT NULL,
  `creado_en` datetime DEFAULT NULL,
  `actualizado_en` datetime DEFAULT NULL,
  PRIMARY KEY (`id_usuario`),
  UNIQUE KEY `email` (`email`),
  KEY `rol` (`id_rol`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id_usuario`, `nombre`, `apellido`, `email`, `contraseña`, `id_rol`, `estado`, `fch_estado`, `creado_en`, `actualizado_en`) VALUES
(5, 'Luis', 'Cabral', 'luis.a.cabral1@gmail.com', '$2y$10$VXjtmk2NRo8Sr4m8J3.7vuKzzqsz.hTMqXOmjrvJM738WENDzJxjy', 2, 'ACTIVO', NULL, NULL, '2024-12-12 17:53:56'),
(6, 'Adonai', 'Store', 'adonaiStore@gmail.com', '$2y$10$liYmAjTuUymmKotMJqlaMezs1yQNR0fWjuMHYeTy2TaIss0IfsUN2', 1, 'ACTIVO', NULL, NULL, NULL);

--
-- Disparadores `usuarios`
--
DROP TRIGGER IF EXISTS `before_deleting_usuarios`;
DELIMITER $$
CREATE TRIGGER `before_deleting_usuarios` BEFORE DELETE ON `usuarios` FOR EACH ROW BEGIN 
    -- 
    signal sqlstate '45000' set message_text = 'No se pueden eliminar registros - before_deleting_usuarios';
    -- 
END
$$
DELIMITER ;
DROP TRIGGER IF EXISTS `before_inserting_usuarios`;
DELIMITER $$
CREATE TRIGGER `before_inserting_usuarios` BEFORE INSERT ON `usuarios` FOR EACH ROW BEGIN 
    -- Inicializa fch_estado en la fecha actual si no se proporciona un valor
    IF NEW.fch_estado IS NULL THEN
        SET NEW.fch_estado = NOW();
    END IF;
    SET NEW.creado_en = NOW();
    --
END
$$
DELIMITER ;
DROP TRIGGER IF EXISTS `before_updating_usuarios`;
DELIMITER $$
CREATE TRIGGER `before_updating_usuarios` BEFORE UPDATE ON `usuarios` FOR EACH ROW BEGIN 
    -- Si el estado cambia, actualiza la fecha de estado
    IF NEW.estado <> OLD.estado THEN
        SET NEW.fch_estado = NOW();
    END IF;
    SET NEW.actualizado_en = NOW();
    --
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ventanas`
--

DROP TABLE IF EXISTS `ventanas`;
CREATE TABLE IF NOT EXISTS `ventanas` (
  `id_ventana` varchar(250) NOT NULL,
  `descripcion` varchar(500) NOT NULL,
  `grupo` varchar(45) NOT NULL DEFAULT 'Gestiones',
  `estado` enum('ACTIVO','INACTIVO') DEFAULT 'ACTIVO',
  `fch_estado` datetime DEFAULT NULL,
  `creado_en` datetime DEFAULT NULL,
  `actualizado_en` datetime DEFAULT NULL,
  PRIMARY KEY (`id_ventana`),
  KEY `grupo_ventana_idx` (`grupo`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `ventanas`
--

INSERT INTO `ventanas` (`id_ventana`, `descripcion`, `grupo`, `estado`, `fch_estado`, `creado_en`, `actualizado_en`) VALUES
('gestion_clientes.php', 'Clientes', 'Gestiones', 'ACTIVO', '2024-12-12 14:18:51', '2024-12-12 14:18:51', NULL),
('gestion_empleados.php', 'Empleados', 'Gestiones', 'ACTIVO', '2024-12-12 14:26:35', '2024-12-12 14:26:35', NULL),
('gestion_productos.php', 'Productos', 'Gestiones', 'ACTIVO', '2024-12-09 22:49:18', '2024-12-09 22:49:18', NULL),
('gestion_proveedores.php', 'Proveedores', 'Gestiones', 'ACTIVO', '2024-12-09 21:52:18', '2024-12-09 21:52:18', NULL),
('gestion_puntos_venta.php', 'Puntos de Venta', 'Gestiones', 'ACTIVO', '2024-12-12 15:02:56', '2024-12-12 15:02:56', NULL),
('gestion_RolVentanas.php', 'Rol de Ventanas', 'Gestiones', 'ACTIVO', '2024-12-09 22:50:38', '2024-12-09 22:50:38', NULL),
('gestion_usuarios.php', 'Usuarios', 'Gestiones', 'ACTIVO', '2024-12-11 16:45:31', '2024-12-11 16:45:31', NULL);

--
-- Disparadores `ventanas`
--
DROP TRIGGER IF EXISTS `before_deleting_ventanas`;
DELIMITER $$
CREATE TRIGGER `before_deleting_ventanas` BEFORE DELETE ON `ventanas` FOR EACH ROW BEGIN 
    -- 
    signal sqlstate '45000' set message_text = 'No se pueden eliminar registros - before_deleting_ventanas';
    -- 
END
$$
DELIMITER ;
DROP TRIGGER IF EXISTS `before_inserting_ventanas`;
DELIMITER $$
CREATE TRIGGER `before_inserting_ventanas` BEFORE INSERT ON `ventanas` FOR EACH ROW BEGIN 
    -- Inicializa fch_estado en la fecha actual si no se proporciona un valor
    IF NEW.fch_estado IS NULL THEN
        SET NEW.fch_estado = NOW();
    END IF;
    SET NEW.creado_en = NOW();
    --
END
$$
DELIMITER ;
DROP TRIGGER IF EXISTS `before_updating_ventanas`;
DELIMITER $$
CREATE TRIGGER `before_updating_ventanas` BEFORE UPDATE ON `ventanas` FOR EACH ROW BEGIN 
    -- Si el estado cambia, actualiza la fecha de estado
    IF NEW.estado <> OLD.estado THEN
        SET NEW.fch_estado = NOW();
    END IF;
    SET NEW.actualizado_en = NOW();
    --
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ventas`
--

DROP TABLE IF EXISTS `ventas`;
CREATE TABLE IF NOT EXISTS `ventas` (
  `id_venta` int(11) NOT NULL AUTO_INCREMENT,
  `id_producto` int(11) NOT NULL,
  `fecha` datetime NOT NULL,
  `total` decimal(10,2) NOT NULL,
  `cantidad` int(11) NOT NULL,
  `id_cliente` int(11) DEFAULT NULL,
  `id_punto_venta` int(11) DEFAULT NULL,
  `estado` enum('ACTIVO','ANULADO') CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT 'ACTIVO',
  `fch_estado` datetime DEFAULT NULL,
  `creado_en` datetime DEFAULT NULL,
  `actualizado_en` datetime DEFAULT NULL,
  PRIMARY KEY (`id_venta`),
  KEY `id_cliente` (`id_cliente`),
  KEY `id_punto_venta` (`id_punto_venta`),
  KEY `prod_vent_fk` (`id_producto`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Disparadores `ventas`
--
DROP TRIGGER IF EXISTS `before_deleting_ventas`;
DELIMITER $$
CREATE TRIGGER `before_deleting_ventas` BEFORE DELETE ON `ventas` FOR EACH ROW BEGIN 
    -- 
    signal sqlstate '45000' set message_text = 'No se pueden eliminar registros - before_deleting_ventas';
    -- 
END
$$
DELIMITER ;
DROP TRIGGER IF EXISTS `before_inserting_ventas`;
DELIMITER $$
CREATE TRIGGER `before_inserting_ventas` BEFORE INSERT ON `ventas` FOR EACH ROW BEGIN 
    -- Inicializa fch_estado en la fecha actual si no se proporciona un valor
    IF NEW.fch_estado IS NULL THEN
        SET NEW.fch_estado = NOW();
    END IF;
    SET NEW.creado_en = NOW();
    --
    IF NEW.cantidad > 0 THEN
    	UPDATE productos SET stock = stock - NEW.cantidad where id_producto = NEW.id_producto;
    end if;
END
$$
DELIMITER ;
DROP TRIGGER IF EXISTS `before_updating_ventas`;
DELIMITER $$
CREATE TRIGGER `before_updating_ventas` BEFORE UPDATE ON `ventas` FOR EACH ROW BEGIN 
    -- Si el estado cambia, actualiza la fecha de estado
    IF NEW.estado <> OLD.estado THEN
        SET NEW.fch_estado = NOW();
        -- 
        IF NEW.estado = 'ANULADO' THEN
        	UPDATE productos SET stock = stock + NEW.cantidad where id_producto = NEW.id_producto;
        END IF;
        -- 
        IF NEW.estado = 'ACTIVO' THEN
        	UPDATE productos SET stock = stock - NEW.cantidad where id_producto = NEW.id_producto;
        END IF;
    END IF;
    SET NEW.actualizado_en = NOW();
    --
END
$$
DELIMITER ;

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

--
-- Filtros para la tabla `ventas`
--
ALTER TABLE `ventas`
  ADD CONSTRAINT `clie_vent_fk` FOREIGN KEY (`id_cliente`) REFERENCES `clientes` (`id_cliente`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `prod_vent_fk` FOREIGN KEY (`id_producto`) REFERENCES `productos` (`id_producto`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `puve_vent_fk` FOREIGN KEY (`id_punto_venta`) REFERENCES `puntos_venta` (`id_punto_venta`) ON DELETE RESTRICT ON UPDATE RESTRICT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
