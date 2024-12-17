-- phpMyAdmin SQL Dump
-- version 4.9.1
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost
-- Tiempo de generación: 16-12-2024 a las 15:18:03
-- Versión del servidor: 8.0.17
-- Versión de PHP: 7.3.10

SET FOREIGN_KEY_CHECKS=0;
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
CREATE DATABASE IF NOT EXISTS `adonai_store_schema` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci;
USE `adonai_store_schema`;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `clientes`
--

DROP TABLE IF EXISTS `clientes`;
CREATE TABLE IF NOT EXISTS `clientes` (
  `id_cliente` int(11) NOT NULL AUTO_INCREMENT,
  `cedula` varchar(50) NOT NULL,
  `ruc` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  `nombre` varchar(100) NOT NULL,
  `apellido` varchar(100) NOT NULL,
  `direccion` text,
  `telefono` varchar(15) DEFAULT NULL,
  `estado` enum('ACTIVO','INACTIVO') DEFAULT 'ACTIVO',
  `fch_estado` datetime DEFAULT NULL,
  `creado_en` datetime DEFAULT NULL,
  `actualizado_en` datetime DEFAULT NULL,
  PRIMARY KEY (`id_cliente`)
) ENGINE=InnoDB AUTO_INCREMENT=55 DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `clientes`
--

INSERT INTO `clientes` (`id_cliente`, `cedula`, `ruc`, `nombre`, `apellido`, `direccion`, `telefono`, `estado`, `fch_estado`, `creado_en`, `actualizado_en`) VALUES
(1, '5959208', '5959208-5', 'Luis Alberto', 'Cabral Samudio', 'Guido Spano 3050', '0971667440', 'INACTIVO', '2024-12-15 15:45:43', '2024-12-13 10:52:37', '2024-12-15 15:45:43'),
(2, '1234567', '1234567-2', 'Juan', 'Pérez', 'Calle Falsa 123, Asunción', '0981123456', 'ACTIVO', '2024-12-13 11:00:23', '2024-12-13 11:00:23', NULL),
(3, '2345678', '2345678-5', 'María', 'Gómez', 'Avenida Central 456, Luque', '0982123456', 'ACTIVO', '2024-12-13 11:00:23', '2024-12-13 11:00:23', NULL),
(4, '3456789', '3456789-3', 'Carlos', 'Fernández', 'Ruta 2 km 10, San Lorenzo', '0983123456', 'ACTIVO', '2024-12-13 11:00:23', '2024-12-13 11:00:23', NULL),
(5, '4567890', '4567890-7', 'Ana', 'Ramírez', 'Barrio Obrero 789, Capiatá', '0984123456', 'ACTIVO', '2024-12-13 11:00:23', '2024-12-13 11:00:23', NULL),
(6, '5678901', '5678901-1', 'Pedro', 'Torres', 'Calle Palma 101, Encarnación', '0985123456', 'ACTIVO', '2024-12-13 11:00:23', '2024-12-13 11:00:23', NULL),
(7, '6789012', '6789012-4', 'Luisa', 'Martínez', 'Avenida del Sol 202, Ciudad del Este', '0986123456', 'ACTIVO', '2024-12-13 11:00:23', '2024-12-13 11:00:23', NULL),
(8, '7890123', '7890123-6', 'Miguel', 'Benítez', 'Calle Italia 303, Villarrica', '0987123456', 'ACTIVO', '2024-12-13 11:00:23', '2024-12-13 11:00:23', NULL),
(9, '8901234', '8901234-8', 'Sofía', 'López', 'Calle España 404, Caaguazú', '0988123456', 'ACTIVO', '2024-12-13 11:00:23', '2024-12-13 11:00:23', NULL),
(10, '9012345', '9012345-2', 'Fernando', 'Acosta', 'Calle Artigas 505, Lambaré', '0989123456', 'ACTIVO', '2024-12-13 11:00:23', '2024-12-13 11:00:23', NULL),
(11, '1012346', '1012346-5', 'Laura', 'Vera', 'Barrio San José 606, Ñemby', '0991123456', 'ACTIVO', '2024-12-13 11:00:23', '2024-12-13 11:00:23', NULL),
(12, '1113457', '1113457-3', 'Jorge', 'Morales', 'Calle Herrera 707, Hernandarias', '0992123456', 'ACTIVO', '2024-12-13 11:00:23', '2024-12-13 11:00:23', NULL),
(13, '1214568', '1214568-7', 'Gloria', 'Franco', 'Calle Ayolas 808, Coronel Oviedo', '0993123456', 'ACTIVO', '2024-12-13 11:00:23', '2024-12-13 11:00:23', NULL),
(14, '1315679', '1315679-1', 'José', 'Rojas', 'Calle Presidente Franco 909, Itauguá', '0994123456', 'ACTIVO', '2024-12-13 11:00:23', '2024-12-13 11:00:23', NULL),
(15, '1416780', '1416780-4', 'Elena', 'Cabral', 'Calle Mariscal López 1010, San Pedro', '0995123456', 'ACTIVO', '2024-12-13 11:00:23', '2024-12-13 11:00:23', NULL),
(16, '1517891', '1517891-6', 'Raúl', 'Castro', 'Calle Cerro Corá 1111, Pedro Juan Caballero', '0996123456', 'ACTIVO', '2024-12-13 11:00:23', '2024-12-13 11:00:23', NULL),
(17, '1618902', '1618902-8', 'Patricia', 'Ayala', 'Calle Palma 1212, Pilar', '0997123456', 'ACTIVO', '2024-12-13 11:00:23', '2024-12-13 11:00:23', NULL),
(18, '1719013', '1719013-2', 'Roberto', 'Villalba', 'Calle República 1313, Concepción', '0998123456', 'ACTIVO', '2024-12-13 11:00:23', '2024-12-13 11:00:23', NULL),
(19, '1810124', '1810124-5', 'Silvia', 'Espínola', 'Avenida General Díaz 1414, Mariano Roque Alonso', '0999123456', 'ACTIVO', '2024-12-13 11:00:23', '2024-12-13 11:00:23', NULL),
(20, '1911235', '1911235-3', 'Luis', 'Segovia', 'Calle Charles de Gaulle 1515, Filadelfia', '0981134567', 'ACTIVO', '2024-12-13 11:00:23', '2024-12-13 11:00:23', NULL),
(21, '2012346', '2012346-7', 'Gabriela', 'Montiel', 'Avenida Brasil 1616, Fernando de la Mora', '0982134567', 'ACTIVO', '2024-12-13 11:00:23', '2024-12-13 11:00:23', NULL),
(22, '2113457', '2113457-1', 'Ricardo', 'Ovelar', 'Calle San Martín 1717, Areguá', '0983134567', 'ACTIVO', '2024-12-13 11:00:23', '2024-12-13 11:00:23', NULL),
(23, '2214568', '2214568-4', 'Carmen', 'Zarza', 'Calle Capitán Miranda 1818, Eusebio Ayala', '0984134567', 'ACTIVO', '2024-12-13 11:00:23', '2024-12-13 11:00:23', NULL),
(24, '2315679', '2315679-6', 'Esteban', 'Peralta', 'Calle Yegros 1919, Paraguarí', '0985134567', 'ACTIVO', '2024-12-13 11:00:23', '2024-12-13 11:00:23', NULL),
(25, '2416780', '2416780-8', 'Fátima', 'Aguilera', 'Calle Sargento Gauto 2020, Caacupé', '0986134567', 'ACTIVO', '2024-12-13 11:00:23', '2024-12-13 11:00:23', NULL),
(26, '2517891', '2517891-2', 'Ángel', 'Lezcano', 'Avenida Caballero 2121, Villa Hayes', '0987134567', 'ACTIVO', '2024-12-13 11:00:23', '2024-12-13 11:00:23', NULL),
(27, '2618902', '2618902-5', 'Lucía', 'González', 'Calle Independencia 2222, Itapúa', '0988134567', 'ACTIVO', '2024-12-13 11:00:23', '2024-12-13 11:00:23', NULL),
(28, '2719013', '2719013-3', 'Hugo', 'Quiñónez', 'Calle Curupayty 2323, Alto Paraná', '0989134567', 'ACTIVO', '2024-12-13 11:00:23', '2024-12-13 11:00:23', NULL),
(29, '2810124', '2810124-7', 'Verónica', 'Riveros', 'Calle San Lorenzo 2424, Misiones', '0990134567', 'ACTIVO', '2024-12-13 11:00:23', '2024-12-13 11:00:23', NULL),
(30, '2911235', '2911235-1', 'Juan', 'Ortiz', 'Calle San Blas 2525, Amambay', '0991134567', 'ACTIVO', '2024-12-13 11:00:23', '2024-12-13 11:00:23', NULL),
(31, '3012346', '3012346-4', 'Clara', 'Insfrán', 'Avenida Paraguay 2626, Ñeembucú', '0992134567', 'ACTIVO', '2024-12-13 11:00:23', '2024-12-13 11:00:23', NULL),
(32, '3113457', '3113457-6', 'Daniel', 'Mendoza', 'Calle Cerro León 2727, Alto Paraguay', '0993134567', 'ACTIVO', '2024-12-13 11:00:23', '2024-12-13 11:00:23', NULL),
(33, '3214568', '3214568-8', 'Julia', 'Cabañas', 'Calle Alberdi 2828, Canindeyú', '0994134567', 'ACTIVO', '2024-12-13 11:00:23', '2024-12-13 11:00:23', NULL),
(34, '3315679', '3315679-2', 'Adriana', 'Salinas', 'Calle Azara 2929, Chaco', '0995134567', 'ACTIVO', '2024-12-13 11:00:23', '2024-12-13 11:00:23', NULL),
(35, '3416780', '3416780-5', 'Diego', 'Morán', 'Avenida España 3030, Central', '0996134567', 'ACTIVO', '2024-12-13 11:00:23', '2024-12-13 11:00:23', NULL),
(36, '3517891', '3517891-7', 'Nancy', 'Ortiz', 'Calle Palma 3131, Presidente Hayes', '0997134567', 'ACTIVO', '2024-12-13 11:00:23', '2024-12-13 11:00:23', NULL),
(37, '3618902', '3618902-1', 'Ramón', 'Ruiz', 'Calle Independencia 3232, Boquerón', '0998134567', 'ACTIVO', '2024-12-13 11:00:23', '2024-12-13 11:00:23', NULL),
(38, '3719013', '3719013-4', 'Mónica', 'Vargas', 'Avenida Caballero 3333, Cordillera', '0999134567', 'ACTIVO', '2024-12-13 11:00:23', '2024-12-13 11:00:23', NULL),
(39, '3810124', '3810124-6', 'Gustavo', 'Segovia', 'Calle Cerro Corá 3434, San Pedro', '0981145678', 'ACTIVO', '2024-12-13 11:00:23', '2024-12-13 11:00:23', NULL),
(40, '3911235', '3911235-8', 'Sandra', 'Medina', 'Avenida del Sol 3535, Guairá', '0982145678', 'ACTIVO', '2024-12-13 11:00:23', '2024-12-13 11:00:23', NULL),
(41, '4012346', '4012346-2', 'Luis', 'Domínguez', 'Calle Ayala 3636, Paraguarí', '0983145678', 'ACTIVO', '2024-12-13 11:00:23', '2024-12-13 11:00:23', NULL),
(42, '4113457', '4113457-5', 'Victoria', 'Acosta', 'Calle Herrera 3737, Cordillera', '0984145678', 'ACTIVO', '2024-12-13 11:00:23', '2024-12-13 11:00:23', NULL),
(43, '4214568', '4214568-3', 'Felipe', 'Caballero', 'Avenida República 3838, Ñeembucú', '0985145678', 'ACTIVO', '2024-12-13 11:00:23', '2024-12-13 11:00:23', NULL),
(44, '4315679', '4315679-7', 'Blanca', 'Vera', 'Calle Artigas 3939, Central', '0986145678', 'ACTIVO', '2024-12-13 11:00:23', '2024-12-13 11:00:23', NULL),
(45, '4416780', '4416780-1', 'Eduardo', 'Navarro', 'Avenida General Díaz 4040, Alto Paraná', '0987145678', 'ACTIVO', '2024-12-13 11:00:23', '2024-12-13 11:00:23', NULL),
(46, '4517891', '4517891-4', 'Valeria', 'Figueroa', 'Calle San Martín 4141, Itapúa', '0988145678', 'ACTIVO', '2024-12-13 11:00:23', '2024-12-13 11:00:23', NULL),
(47, '4618902', '4618902-6', 'Héctor', 'Salazar', 'Calle Palma 4242, Boquerón', '0989145678', 'ACTIVO', '2024-12-13 11:00:23', '2024-12-13 11:00:23', NULL),
(48, '4719013', '4719013-8', 'Claudia', 'Quintana', 'Avenida Brasil 4343, Canindeyú', '0990145678', 'ACTIVO', '2024-12-13 11:00:23', '2024-12-13 11:00:23', NULL),
(49, '4810124', '4810124-2', 'Arturo', 'Leiva', 'Calle Cerro León 4444, Amambay', '0991145678', 'ACTIVO', '2024-12-13 11:00:23', '2024-12-13 11:00:23', NULL),
(50, '4911235', '4911235-5', 'Paola', 'Ramón', 'Calle España 4545, Misiones', '0992145678', 'ACTIVO', '2024-12-13 11:00:23', '2024-12-13 11:00:23', NULL),
(51, '5012346', '5012346-3', 'Marcelo', 'Giménez', 'Calle Azara 4646, Presidente Hayes', '0993145678', 'ACTIVO', '2024-12-13 11:00:23', '2024-12-13 11:00:23', NULL),
(52, '5081811', '', 'Ricardo', 'Garuja', 'RI 4 Curupayty 264, Asunción', '0971234567', 'ACTIVO', '2024-12-15 15:36:06', '2024-12-15 15:36:06', NULL),
(53, '5976841', '', 'LUCIA MAGDALENA', 'LUGO GRANCE', 'RI 4 Curupayty 264, Asunción', '0975976841', 'ACTIVO', '2024-12-16 10:54:52', '2024-12-16 10:54:52', NULL),
(54, '3161046', '', 'MARIA ELSA', 'GALEANO FARIÑA', 'departamento central ciudad de limpio barrio salado villa ko´eju una cuadra antes de llegar a la escuela union europea', '0983161046', 'ACTIVO', '2024-12-16 11:02:49', '2024-12-16 11:02:49', NULL);

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
  `fecha` date NOT NULL,
  `id_empleado` int(11) NOT NULL,
  `estado` enum('ACTIVO','ANULADO') CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL DEFAULT 'ACTIVO',
  `fch_estado` datetime NOT NULL,
  `creado_en` datetime NOT NULL,
  `actualizado_en` datetime DEFAULT NULL,
  PRIMARY KEY (`id_compra`),
  KEY `prod_comp_fk` (`id_producto`),
  KEY `empl_comp_fk` (`id_empleado`)
) ENGINE=InnoDB AUTO_INCREMENT=33 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `compras`
--

INSERT INTO `compras` (`id_compra`, `id_producto`, `precio_compra_x_unidad`, `cantidad`, `precio_compra_total`, `fecha`, `id_empleado`, `estado`, `fch_estado`, `creado_en`, `actualizado_en`) VALUES
(1, 1, 80000, 10, 800000, '2024-12-12', 1, 'ACTIVO', '2024-12-12 11:31:55', '2024-12-12 11:31:55', '2024-12-14 18:18:03'),
(2, 2, 120000, 15, 1800000, '2024-12-12', 1, 'ACTIVO', '2024-12-12 11:31:55', '2024-12-12 11:31:55', '2024-12-14 18:18:03'),
(3, 3, 250000, 5, 1250000, '2024-12-12', 1, 'ACTIVO', '2024-12-12 11:31:55', '2024-12-12 11:31:55', '2024-12-14 18:18:03'),
(4, 4, 150000, 8, 1200000, '2024-12-12', 1, 'ACTIVO', '2024-12-12 11:31:55', '2024-12-12 11:31:55', '2024-12-14 18:18:03'),
(5, 5, 90000, 12, 1080000, '2024-12-12', 1, 'ACTIVO', '2024-12-12 11:31:55', '2024-12-12 11:31:55', '2024-12-14 18:18:03'),
(6, 6, 85000, 10, 850000, '2024-12-12', 1, 'ACTIVO', '2024-12-12 11:31:55', '2024-12-12 11:31:55', '2024-12-14 18:18:03'),
(7, 7, 300000, 3, 900000, '2024-12-12', 1, 'ACTIVO', '2024-12-12 11:31:55', '2024-12-12 11:31:55', '2024-12-14 18:18:03'),
(8, 8, 70000, 25, 1750000, '2024-12-12', 1, 'ACTIVO', '2024-12-12 11:31:55', '2024-12-12 11:31:55', '2024-12-14 18:18:03'),
(9, 9, 110000, 10, 1100000, '2024-12-12', 1, 'ACTIVO', '2024-12-12 11:31:55', '2024-12-12 11:31:55', '2024-12-14 18:18:03'),
(10, 10, 130000, 15, 1950000, '2024-12-12', 1, 'ACTIVO', '2024-12-12 11:31:55', '2024-12-12 11:31:55', '2024-12-14 18:18:03'),
(11, 11, 150000, 12, 1800000, '2024-12-12', 1, 'ACTIVO', '2024-12-12 11:31:55', '2024-12-12 11:31:55', '2024-12-14 18:18:03'),
(12, 12, 75000, 20, 1500000, '2024-12-12', 1, 'ACTIVO', '2024-12-12 11:31:55', '2024-12-12 11:31:55', '2024-12-14 18:18:03'),
(13, 13, 90000, 8, 720000, '2024-12-12', 1, 'ACTIVO', '2024-12-12 11:31:55', '2024-12-12 11:31:55', '2024-12-14 18:18:03'),
(14, 14, 100000, 10, 1000000, '2024-12-12', 1, 'ACTIVO', '2024-12-12 11:31:55', '2024-12-12 11:31:55', '2024-12-14 18:18:03'),
(15, 15, 300000, 5, 1500000, '2024-12-12', 1, 'ACTIVO', '2024-12-12 11:31:55', '2024-12-12 11:31:55', '2024-12-14 18:18:03'),
(16, 16, 120000, 7, 840000, '2024-12-12', 1, 'ACTIVO', '2024-12-12 11:31:55', '2024-12-12 11:31:55', '2024-12-14 18:18:03'),
(17, 17, 250000, 4, 1000000, '2024-12-12', 1, 'ACTIVO', '2024-12-12 11:31:55', '2024-12-12 11:31:55', '2024-12-14 18:18:03'),
(18, 18, 65000, 25, 1625000, '2024-12-12', 1, 'ACTIVO', '2024-12-12 11:31:55', '2024-12-12 11:31:55', '2024-12-14 18:18:03'),
(19, 19, 350000, 3, 1050000, '2024-12-12', 1, 'ACTIVO', '2024-12-12 11:31:55', '2024-12-12 11:31:55', '2024-12-14 18:18:03'),
(20, 20, 40000, 20, 800000, '2024-12-12', 1, 'ACTIVO', '2024-12-12 11:31:55', '2024-12-12 11:31:55', '2024-12-14 18:18:03'),
(21, 21, 30000, 25, 750000, '2024-12-12', 1, 'ACTIVO', '2024-12-12 11:31:55', '2024-12-12 11:31:55', '2024-12-14 18:18:03'),
(22, 22, 450000, 2, 900000, '2024-12-12', 1, 'ACTIVO', '2024-12-12 11:31:55', '2024-12-12 11:31:55', '2024-12-14 18:18:03'),
(23, 23, 150000, 6, 900000, '2024-12-12', 1, 'ACTIVO', '2024-12-12 11:31:55', '2024-12-12 11:31:55', '2024-12-14 18:18:03'),
(24, 24, 50000, 15, 750000, '2024-12-12', 1, 'ACTIVO', '2024-12-12 11:31:55', '2024-12-12 11:31:55', '2024-12-14 18:18:03'),
(25, 25, 60000, 20, 1200000, '2024-12-12', 1, 'ACTIVO', '2024-12-12 11:31:55', '2024-12-12 11:31:55', '2024-12-14 18:18:03'),
(26, 26, 30000, 25, 750000, '2024-12-12', 1, 'ACTIVO', '2024-12-12 11:31:55', '2024-12-12 11:31:55', '2024-12-14 18:18:03'),
(27, 27, 35000, 30, 1050000, '2024-12-12', 1, 'ACTIVO', '2024-12-12 11:31:55', '2024-12-12 11:31:55', '2024-12-14 18:18:03'),
(28, 28, 200000, 8, 1600000, '2024-12-12', 1, 'ACTIVO', '2024-12-12 11:31:55', '2024-12-12 11:31:55', '2024-12-14 18:18:03'),
(29, 29, 150000, 5, 750000, '2024-12-12', 1, 'ACTIVO', '2024-12-12 11:31:55', '2024-12-12 11:31:55', '2024-12-14 18:18:03'),
(30, 30, 10000, 50, 500000, '2024-12-12', 1, 'ACTIVO', '2024-12-12 11:31:55', '2024-12-12 11:31:55', '2024-12-14 18:18:03'),
(31, 22, 200000, 5, 1000000, '2024-12-13', 1, 'ACTIVO', '2024-12-13 09:55:08', '2024-12-13 09:55:08', '2024-12-14 18:18:03'),
(32, 34, 250000, 5, 1250000, '2024-12-15', 1, 'ACTIVO', '2024-12-15 15:43:26', '2024-12-15 15:43:26', NULL);

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
    SET NEW.fecha = NOW();
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
    --
    IF NEW.cantidad <> OLD.cantidad and NEW.estado = 'ACTIVO' THEN
    	UPDATE productos SET stock = stock + (OLD.cantidad - NEW.cantidad) where id_producto = NEW.id_producto;
    END IF;
    --
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
  `id_empleado` int(11) NOT NULL,
  `id_punto_venta` int(11) DEFAULT NULL,
  `cedula` varchar(20) NOT NULL,
  `nombre` varchar(200) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `apellido` varchar(200) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `email` varchar(100) NOT NULL,
  `contraseña` varchar(200) NOT NULL,
  `id_rol` int(11) NOT NULL,
  `estado` enum('ACTIVO','INACTIVO') CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT 'ACTIVO',
  `fch_estado` datetime NOT NULL,
  `creado_en` datetime NOT NULL,
  `actualizado_en` datetime DEFAULT NULL,
  PRIMARY KEY (`id_empleado`),
  UNIQUE KEY `email_un` (`email`),
  UNIQUE KEY `cedula_un` (`cedula`),
  KEY `punto_venta` (`id_punto_venta`),
  KEY `role_empl_fk` (`id_rol`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `empleados`
--

INSERT INTO `empleados` (`id_empleado`, `id_punto_venta`, `cedula`, `nombre`, `apellido`, `email`, `contraseña`, `id_rol`, `estado`, `fch_estado`, `creado_en`, `actualizado_en`) VALUES
(1, 1, '9999999', 'Adonai', 'Store', 'adonaiStore@gmail.com', '$2y$10$aTgTLrLc7pGrSu3ZBRoSIep/JYeHawGwdyG./hxw5HWsK9OxFqZJa', 1, 'ACTIVO', '2024-12-13 15:38:50', '2024-12-13 14:13:09', '2024-12-13 15:38:58'),
(2, 1, '5081811', 'CARLOS CELSO ROBERTO', 'RADICE MORALES', 'cradice@gmial.com', '$2y$10$4g0plQiRJiR/wD3Pv/47Ye99u8z/7pqvKHMayPhXuCoHU.Id6kCAa', 2, 'ACTIVO', '2024-12-13 15:43:34', '2024-12-13 15:43:11', '2024-12-13 15:43:34');

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
) ENGINE=InnoDB AUTO_INCREMENT=35 DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `productos`
--

INSERT INTO `productos` (`id_producto`, `descripcion`, `stock`, `id_proveedor`, `estado`, `fch_estado`, `creado_en`, `actualizado_en`) VALUES
(1, 'Camisas básicas', 7, 1, 'ACTIVO', '2024-12-14 17:52:08', NULL, '2024-12-16 10:48:13'),
(2, 'Pantalones de mezclilla', 12, 1, 'ACTIVO', NULL, NULL, '2024-12-14 18:08:19'),
(3, 'Chaquetas ligeras', 5, 1, 'ACTIVO', NULL, NULL, NULL),
(4, 'Vestidos de verano', 1, 2, 'ACTIVO', NULL, NULL, '2024-12-16 11:02:49'),
(5, 'Blusas estampadas', 12, 2, 'ACTIVO', NULL, NULL, NULL),
(6, 'Faldas cortas', 10, 2, 'ACTIVO', NULL, NULL, NULL),
(7, 'Trajes formales', 3, 3, 'ACTIVO', NULL, NULL, NULL),
(8, 'Corbatas de seda', 25, 3, 'ACTIVO', NULL, NULL, NULL),
(9, 'Camisas de vestir', 10, 3, 'ACTIVO', NULL, NULL, '2024-12-13 14:16:50'),
(10, 'Ropa deportiva', 15, 4, 'ACTIVO', NULL, NULL, NULL),
(11, 'Sudaderas', 12, 4, 'ACTIVO', NULL, NULL, NULL),
(12, 'Shorts deportivos', 20, 4, 'ACTIVO', NULL, NULL, NULL),
(13, 'Sombreros de paja', 8, 5, 'ACTIVO', NULL, NULL, NULL),
(14, 'Camisas guayaberas', 10, 5, 'ACTIVO', NULL, NULL, NULL),
(15, 'Zapatos de cuero', 2, 5, 'ACTIVO', NULL, NULL, '2024-12-14 18:25:35'),
(16, 'Pantalones de lino', 7, 6, 'ACTIVO', NULL, NULL, NULL),
(17, 'Blazers casuales', 4, 6, 'ACTIVO', NULL, NULL, NULL),
(18, 'Camisetas estampadas', 25, 6, 'ACTIVO', NULL, NULL, NULL),
(19, 'Abrigos de lana', 3, 7, 'ACTIVO', NULL, NULL, '2024-12-13 10:07:34'),
(20, 'Bufandas tejidas', 20, 7, 'ACTIVO', NULL, NULL, NULL),
(21, 'Guantes de invierno', 25, 7, 'ACTIVO', NULL, NULL, NULL),
(22, 'Vestidos de gala', 7, 8, 'ACTIVO', NULL, NULL, '2024-12-13 09:55:08'),
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
(33, 'Carteras de mano', 0, 11, 'ACTIVO', NULL, NULL, NULL),
(34, 'Camisas básicas color Champan', 5, 8, 'ACTIVO', '2024-12-15 15:36:58', '2024-12-15 15:36:58', '2024-12-15 15:43:26');

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
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `proveedores`
--

INSERT INTO `proveedores` (`id_proveedor`, `nombre`, `contacto`, `direccion`, `estado`, `fch_estado`, `creado_en`, `actualizado_en`) VALUES
(1, 'Juan Deposito', 'Denis Roa', 'Facundo Machainn', 'INACTIVO', '2024-12-15 15:45:17', NULL, '2024-12-15 15:45:17'),
(2, 'Moda Guaraní S.A.', 'Carlos Benítez', 'Calle Palma 123, Asunción, Paraguay', 'ACTIVO', NULL, NULL, NULL),
(3, 'Estilo Paraguayo', 'Ana Gómez', 'Avenida Mariscal López 456, Asunción, Paraguay', 'ACTIVO', NULL, NULL, NULL),
(4, 'Textiles Ñandutí', 'Jorge Martínez', 'Calle Cerro Corá 789, Luque, Paraguay', 'ACTIVO', NULL, NULL, NULL),
(5, 'Ropa del Chaco', 'Lorena González', 'Ruta Transchaco Km 12, Mariano Roque Alonso, Paraguay', 'ACTIVO', NULL, NULL, NULL),
(6, 'Diseños Mbarete', 'Sofía López', 'Avenida Eusebio Ayala 2345, San Lorenzo, Paraguay', 'ACTIVO', NULL, NULL, NULL),
(7, 'Elegancia Paraguaya', 'Ricardo Fernández', 'Calle Defensores del Chaco 678, Ciudad del Este, Paraguay', 'ACTIVO', NULL, NULL, NULL),
(8, 'Alta Moda Guaraní', 'Gabriela Torres', 'Calle Capitán Miranda 345, Encarnación, Paraguay', 'ACTIVO', NULL, NULL, NULL),
(9, 'Textiles del Este', 'Mateo Delgado', 'Avenida República del Paraguay 101, Hernandarias, Paraguay', 'ACTIVO', NULL, NULL, NULL),
(10, 'Fibras del Sur', 'María Ramírez', 'Calle 14 de Mayo 567, Villarrica, Paraguay', 'ACTIVO', NULL, NULL, NULL),
(11, 'Estilo Paraguayo Chic', 'Luis Gómez', 'Calle Artigas 890, Fernando de la Mora, Paraguay', 'ACTIVO', NULL, NULL, NULL),
(12, 'David Store', 'David Rojas', 'Fernando de la Mora Mombyry', 'INACTIVO', '2024-12-15 15:45:10', '2024-12-15 15:45:02', '2024-12-15 15:45:10');

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
(2, 'Adonai Store 2', 'Guido Spano 3050', 'INACTIVO', '2024-12-13 11:04:30', '2024-12-12 15:09:12', '2024-12-13 11:04:30');

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
-- Estructura de tabla para la tabla `roles`
--

DROP TABLE IF EXISTS `roles`;
CREATE TABLE IF NOT EXISTS `roles` (
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
-- Volcado de datos para la tabla `roles`
--

INSERT INTO `roles` (`id_rol`, `nombre`, `descripcion`, `estado`, `fch_estado`, `creado_en`, `actualizado_en`) VALUES
(1, 'Administrador', 'Acceso total al sistema.', 'ACTIVO', '2024-12-07 14:55:52', '2024-12-07 14:55:52', NULL),
(2, 'Vendedor', 'Puede ver y modificar el inventario y realizar ventas, pero no puede gestionar usuarios ni roles.', 'ACTIVO', '2024-12-07 14:55:52', '2024-12-07 14:55:52', '2024-12-08 19:12:40'),
(3, 'Inventario', 'Acceso solo para visualizar y actualizar el inventario.', 'ACTIVO', '2024-12-07 14:55:52', '2024-12-07 14:55:52', '2024-12-08 19:14:50');

--
-- Disparadores `roles`
--
DROP TRIGGER IF EXISTS `before_deleting_rol`;
DELIMITER $$
CREATE TRIGGER `before_deleting_rol` BEFORE DELETE ON `roles` FOR EACH ROW BEGIN 
    -- 
    signal sqlstate '45000' set message_text = 'No se pueden eliminar registros - before_deleting_rol';
    -- 
END
$$
DELIMITER ;
DROP TRIGGER IF EXISTS `before_inserting_rol`;
DELIMITER $$
CREATE TRIGGER `before_inserting_rol` BEFORE INSERT ON `roles` FOR EACH ROW BEGIN 
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
CREATE TRIGGER `before_updating_rol` BEFORE UPDATE ON `roles` FOR EACH ROW BEGIN 
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
('gestion_clientes.php', 2, 'INACTIVO', '2024-12-16 11:04:04', '2024-12-13 11:06:18', '2024-12-16 11:04:04'),
('gestion_clientes.php', 3, 'ACTIVO', '2024-12-16 11:04:48', '2024-12-16 11:04:48', NULL),
('gestion_empleados.php', 1, 'ACTIVO', '2024-12-12 15:52:19', '2024-12-12 15:52:19', NULL),
('gestion_productos.php', 1, 'ACTIVO', '2024-12-09 22:51:17', '2024-12-09 22:51:17', NULL),
('gestion_productos.php', 2, 'ACTIVO', '2024-12-13 11:06:23', '2024-12-13 11:06:23', NULL),
('gestion_productos.php', 3, 'ACTIVO', '2024-12-12 13:26:35', '2024-12-12 13:26:35', NULL),
('gestion_proveedores.php', 1, 'ACTIVO', '2024-12-09 21:54:53', '2024-12-09 21:54:53', NULL),
('gestion_proveedores.php', 3, 'ACTIVO', '2024-12-12 13:26:40', '2024-12-12 13:26:40', NULL),
('gestion_puntos_venta.php', 1, 'ACTIVO', '2024-12-12 15:05:01', '2024-12-12 15:05:01', NULL),
('gestion_RolVentanas.php', 1, 'ACTIVO', '2024-12-09 22:50:59', '2024-12-09 22:50:59', NULL),
('reporte_stock_productos.php', 1, 'ACTIVO', '2024-12-15 16:30:37', '2024-12-15 16:30:37', NULL),
('reporte_stock_productos.php', 2, 'INACTIVO', '2024-12-16 09:18:43', '2024-12-16 09:09:06', '2024-12-16 09:18:43'),
('reporte_stock_productos.php', 3, 'ACTIVO', '2024-12-16 09:18:50', '2024-12-16 09:18:50', NULL),
('reporte_ventas_x_empleado.php', 1, 'ACTIVO', '2024-12-16 11:40:05', '2024-12-16 11:40:05', NULL),
('reporte_ventas_x_empleado.php', 2, 'ACTIVO', '2024-12-16 11:40:10', '2024-12-16 11:40:10', NULL),
('reporte_ventas_x_productos_fecha.php', 1, 'ACTIVO', '2024-12-16 08:51:28', '2024-12-16 08:51:28', NULL),
('reporte_ventas_x_productos_fecha.php', 2, 'ACTIVO', '2024-12-16 09:09:15', '2024-12-16 09:09:15', NULL);

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
('reporte_stock_productos.php', 'Stock de Productos', 'Reportes', 'ACTIVO', '2024-12-15 15:52:47', '2024-12-15 15:52:47', NULL),
('reporte_ventas_x_empleado.php', 'Ventas', 'Reportes', 'ACTIVO', '2024-12-16 11:39:48', '2024-12-16 11:39:48', NULL),
('reporte_ventas_x_productos_fecha.php', 'Ventas de Productos x Fecha', 'Reportes', 'ACTIVO', '2024-12-16 08:51:11', '2024-12-16 08:51:11', NULL);

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
  `fecha` date NOT NULL,
  `precio_venta_x_unidad` decimal(10,2) NOT NULL,
  `cantidad` int(11) NOT NULL,
  `precio_venta_total` int(11) NOT NULL,
  `id_cliente` int(11) DEFAULT NULL,
  `id_empleado` int(11) NOT NULL,
  `id_punto_venta` int(11) DEFAULT NULL,
  `estado` enum('ACTIVO','ANULADO') CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT 'ACTIVO',
  `fch_estado` datetime DEFAULT NULL,
  `creado_en` datetime DEFAULT NULL,
  `actualizado_en` datetime DEFAULT NULL,
  PRIMARY KEY (`id_venta`),
  KEY `id_cliente` (`id_cliente`),
  KEY `id_punto_venta` (`id_punto_venta`),
  KEY `prod_vent_fk` (`id_producto`),
  KEY `empl_vent_fk` (`id_empleado`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `ventas`
--

INSERT INTO `ventas` (`id_venta`, `id_producto`, `fecha`, `precio_venta_x_unidad`, `cantidad`, `precio_venta_total`, `id_cliente`, `id_empleado`, `id_punto_venta`, `estado`, `fch_estado`, `creado_en`, `actualizado_en`) VALUES
(1, 1, '2024-12-14', '70000.00', 1, 70000, 1, 1, 1, 'ACTIVO', '2024-12-14 18:07:28', '2024-12-14 18:07:28', NULL),
(2, 2, '2024-12-14', '150000.00', 2, 300000, 4, 1, 1, 'ACTIVO', '2024-12-14 18:08:05', '2024-12-14 18:08:05', NULL),
(3, 2, '2024-12-14', '150000.00', 1, 150000, 6, 1, 1, 'ACTIVO', '2024-12-14 18:08:19', '2024-12-14 18:08:19', NULL),
(4, 4, '2024-12-14', '90000.00', 2, 180000, 13, 1, 1, 'ACTIVO', '2024-12-14 18:08:39', '2024-12-14 18:08:39', NULL),
(5, 15, '2024-12-13', '200000.00', 2, 400000, 14, 1, 1, 'ACTIVO', '2024-12-14 18:25:16', '2024-12-14 18:25:16', '2024-12-14 18:26:02'),
(6, 15, '2024-12-14', '250000.00', 1, 250000, 12, 1, 1, 'ACTIVO', '2024-12-14 18:25:35', '2024-12-14 18:25:35', NULL),
(7, 1, '2024-12-16', '150000.00', 1, 150000, 14, 2, 1, 'ACTIVO', '2024-12-16 10:44:39', '2024-12-16 10:44:39', NULL),
(8, 1, '2024-12-16', '150000.00', 1, 150000, 2, 2, 1, 'ACTIVO', '2024-12-16 10:48:13', '2024-12-16 10:48:13', NULL),
(9, 4, '2024-12-16', '150000.00', 2, 300000, 53, 2, 1, 'ACTIVO', '2024-12-16 10:54:52', '2024-12-16 10:54:52', NULL),
(10, 4, '2024-12-16', '150000.00', 1, 150000, 15, 2, 1, 'ACTIVO', '2024-12-16 10:56:10', '2024-12-16 10:56:10', NULL),
(11, 4, '2024-12-16', '150000.00', 1, 150000, 13, 2, 1, 'ACTIVO', '2024-12-16 11:01:46', '2024-12-16 11:01:46', NULL),
(12, 4, '2024-12-16', '160000.00', 1, 160000, 54, 2, 1, 'ACTIVO', '2024-12-16 11:02:49', '2024-12-16 11:02:49', NULL);

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
    SET NEW.fecha = NOW();
    --
    SET NEW.precio_venta_total = NEW.precio_venta_x_unidad * NEW.cantidad;
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
    --
    IF NEW.precio_venta_x_unidad <> OLD.precio_venta_x_unidad or NEW.cantidad <> OLD.cantidad THEN
    	SET NEW.precio_venta_total = NEW.precio_venta_x_unidad * NEW.cantidad;
    END IF;
    --
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
  ADD CONSTRAINT `empl_comp_fk` FOREIGN KEY (`id_empleado`) REFERENCES `empleados` (`id_empleado`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `prod_comp_fk` FOREIGN KEY (`id_producto`) REFERENCES `productos` (`id_producto`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Filtros para la tabla `empleados`
--
ALTER TABLE `empleados`
  ADD CONSTRAINT `puve_empl_fk` FOREIGN KEY (`id_punto_venta`) REFERENCES `puntos_venta` (`id_punto_venta`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `role_empl_fk` FOREIGN KEY (`id_rol`) REFERENCES `roles` (`id_rol`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Filtros para la tabla `productos`
--
ALTER TABLE `productos`
  ADD CONSTRAINT `prov_prod_fk` FOREIGN KEY (`id_proveedor`) REFERENCES `proveedores` (`id_proveedor`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Filtros para la tabla `rol_ventanas`
--
ALTER TABLE `rol_ventanas`
  ADD CONSTRAINT `id_rol_fk` FOREIGN KEY (`id_rol`) REFERENCES `roles` (`id_rol`),
  ADD CONSTRAINT `id_ventana_fk` FOREIGN KEY (`id_ventana`) REFERENCES `ventanas` (`id_ventana`);

--
-- Filtros para la tabla `ventas`
--
ALTER TABLE `ventas`
  ADD CONSTRAINT `clie_vent_fk` FOREIGN KEY (`id_cliente`) REFERENCES `clientes` (`id_cliente`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `empl_vent_fk` FOREIGN KEY (`id_empleado`) REFERENCES `empleados` (`id_empleado`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `prod_vent_fk` FOREIGN KEY (`id_producto`) REFERENCES `productos` (`id_producto`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `puve_vent_fk` FOREIGN KEY (`id_punto_venta`) REFERENCES `puntos_venta` (`id_punto_venta`) ON DELETE RESTRICT ON UPDATE RESTRICT;
SET FOREIGN_KEY_CHECKS=1;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
