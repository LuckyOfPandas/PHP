-- phpMyAdmin SQL Dump
-- version 5.2.0
-- Servidor: 127.0.0.1
-- Versión del servidor: 10.4.27-MariaDB
-- Versión de PHP: 8.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `SystemCare_inv`
--

-- --------------------------------------------------------
CREATE DATABASE IF NOT EXISTS SystemCare_inv;
USE SystemCare_inv;
--
-- Estructura de tabla para la tabla `linea_pedido`
--

CREATE TABLE `linea_pedido` (
  `idPedido` int(11) NOT NULL,
  `idProducto` int(11) NOT NULL,
  `unidades` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pedidos`
--

CREATE TABLE `pedidos` (
  `idPedido` int(11) NOT NULL,
  `usuario` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `productos`
--

CREATE TABLE `productos` (
  `id` int(11) NOT NULL,
  `stock` int(11) NOT NULL,
  `categoria` varchar(255) NOT NULL,
  `caracteristicas` varchar(255) NOT NULL,
  `Distribuidor` varchar(255) NOT NULL,
  `precio` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `productos`
--

INSERT INTO `productos` (`id`, `stock`, `categoria`, `caracteristicas`, `distribuidor`, `precio`) VALUES
(2, 62, 'Adaptador', 'VGA-HDMI', 'SystemCare', 7.21),
(3, 53, 'Adaptador', 'VGA-DP', 'SystemCare', 8.99),
(4, 57, 'Adaptador', 'DVI-DP', 'SystemCare', 10.56),
(5, 38, 'Adaptador', 'USB-RJ45', 'SystemCare', 12.09),
(6, 60, 'Adaptador', 'USB C-RJ45', 'SystemCare', 14.12),
(7, 30, 'Cable', 'VGA 1.8m', 'SystemCare', 18.99),
(8, 36, 'Cable', 'DP 1.8m', 'SystemCare', 16.03),
(11, 36, 'Cable', 'DVI 1.8m', 'SystemCare', 11.02),
(12, 36, 'Cable', 'RJ-45 30m Cat6', 'SystemCare', 31.39),
(13, 36, 'Cable', 'RJ-45 15m Cat6', 'SystemCare', 21.02),
(14, 36, 'Cable', 'RJ-45 1.8m Cat6', 'SystemCare', 14.21),
(9, 42, 'Otro', 'Pila placa base', 'SystemCare', 2.21),
(10, 25, 'Otro', 'EjemploX', 'SystemCare', 12.12),
(15, 36, 'Portatil', 'Dell Latitude 5570', 'Dell', 2500.56),
(16, 36, 'Portatil', 'Hp Probook 430 G8', 'Hp', 650.32),
(17, 36, 'Ordenador sobremesa', 'Hp Z4 G4', 'Hp', 1700.12),
(18, 36, 'Ordenador sobremesa', 'Hp Z2 Mini', 'Hp', 509.99);



-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `usuario` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `identidad` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`usuario`, `password`, `identidad`) VALUES
('dgarcia', 'abc123.', 'Daniel Garcia Figueroa'),
('jferreiro', 'abc123.', 'Joam Ferreiro Garrote '),
('afernandez', 'abc123.', 'Ana Fernandez Feal'),
('xgarcia', 'abc123.', 'Xalo Garcia Teijido'),
('psanchez', 'abc123.', 'Pablo Sanchez Lopez'),
('mlopez', 'abc123.', 'Manuel Lopez Figueroa'),
('ateijido', 'abc123.', 'Alejandro Teijido Fernandez'),
('pvazquez', 'abc123.', 'Pablo Vazquez García'),
('dpena', 'abc123.', 'David Pena Sanchez'),
('jgarrote', 'abc123.', 'Joel Garrote Feal'),
('bfeal', 'abc123.', 'Beatriz Feal García'),
('egarcia', 'abc123.', 'Enrique Garcia Couce');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `linea_pedido`
--
ALTER TABLE `linea_pedido`
  ADD PRIMARY KEY (`idPedido`,`idProducto`,`unidades`);

--
-- Indices de la tabla `pedidos`
--
ALTER TABLE `pedidos`
  ADD PRIMARY KEY (`idPedido`);

--
-- Indices de la tabla `productos`
--
ALTER TABLE `productos`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`usuario`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `pedidos`
--
ALTER TABLE `pedidos`
  MODIFY `idPedido` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT de la tabla `productos`
--
ALTER TABLE `productos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- Restricciones para tablas volcadas
--

--
-- Agregamos las nuevas restricciones
--
ALTER TABLE `pedidos`
	ADD CONSTRAINT `fk_pedidos_usuarios1` FOREIGN KEY (`usuario`) REFERENCES `SystemCare_inv`.`usuarios` (`usuario`)ON DELETE CASCADE ON UPDATE NO ACTION;
ALTER TABLE `linea_pedido`
    ADD CONSTRAINT `fk_linea_pedido_pedidos` FOREIGN KEY (`idPedido`) REFERENCES `pedidos` (`idPedido`) ON DELETE CASCADE ON UPDATE NO ACTION,
    ADD CONSTRAINT `fk_linea_pedido_productos` FOREIGN KEY (`idProducto`) REFERENCES `productos` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;

-- Encriptar contraseñas utilizando SHA-256
UPDATE usuarios SET password = SHA2(password, 256);

--TRIGGER PARA ACTUALIZAR EL STOCK
DELIMITER $$
CREATE TRIGGER actualizar_stock
AFTER INSERT ON linea_pedido
FOR EACH ROW
BEGIN
    IF EXISTS (
        SELECT 1
        FROM productos
        WHERE id = NEW.idProducto AND stock < NEW.unidades
    ) THEN
        SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'No hay suficiente stock disponible para este producto.';
    ELSE
        UPDATE productos
        SET stock = stock - NEW.unidades
        WHERE id = NEW.idProducto;
    END IF;
END;
$$
DELIMITER ;

