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

--
-- Estructura de tabla para la tabla `linea_pedido`
--

CREATE TABLE `linea_pedido` (
  `idPedido` int(11) NOT NULL,
  `idProducto` int(11) NOT NULL
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
  `color` varchar(255) NOT NULL,
  `marca` varchar(255) NOT NULL,
  `precio` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `productos`
--

INSERT INTO `productos` (`id`, `stock`, `categoria`, `color`, `marca`, `precio`) VALUES
(1, 79, 'camiseta', 'negra', 'nike', 40),
(2, 62, 'camiseta', 'azul', 'adidas', 38),
(3, 53, 'camiseta', 'verde', 'zara', 20),
(4, 57, 'camiseta', 'gris', 'gucci', 100),
(5, 38, 'camiseta', 'negra', 'adidas', 42),
(6, 60, 'camiseta', 'azul', 'levis', 50),
(7, 30, 'sudadera', 'negra', 'nike', 70),
(8, 36, 'sudadera', 'gris', 'adidas', 56),
(9, 42, 'pantalon', 'vaquero', 'levis', 70),
(10, 25, 'pantalon', 'azul', 'zara', 30);

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
  ADD PRIMARY KEY (`idPedido`,`idProducto`);

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
-- Filtros para la tabla `linea_pedido`
--
ALTER TABLE `linea_pedido`
  ADD CONSTRAINT `borrado` FOREIGN KEY (`idPedido`) REFERENCES `pedidos` (`idPedido`) ON DELETE CASCADE ON UPDATE NO ACTION;
COMMIT;

-- Encriptar contraseñas utilizando SHA-256
UPDATE usuarios SET password = SHA2(password, 256);

--TRIGGER PARA ACTUALIZAR EL STOCK
DELIMITER $$
CREATE TRIGGER actualizar_stock
BEFORE INSERT ON linea_pedido
FOR EACH ROW
BEGIN
    DECLARE stock_actual INT;
    SET stock_actual = (
        SELECT stock
        FROM productos
        WHERE id = NEW.idProducto
    );
    IF stock_actual <= 0 THEN
        SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'No hay stock disponible para este producto.';
    ELSE
        UPDATE productos
        SET stock = stock - 1
        WHERE id = NEW.idProducto;
    END IF;
END;
$$


/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
