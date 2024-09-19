-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost
-- Tiempo de generación: 19-09-2024 a las 03:32:23
-- Versión del servidor: 10.4.28-MariaDB
-- Versión de PHP: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `pro_buzos_mt`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cargos`
--

CREATE TABLE `cargos` (
  `id_cargos` int(11) NOT NULL COMMENT 'Identificador unico de la tabla Rol',
  `car_nombre` varchar(40) NOT NULL COMMENT 'Atributo que identifica la el tipo de rol'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Volcado de datos para la tabla `cargos`
--

INSERT INTO `cargos` (`id_cargos`, `car_nombre`) VALUES
(2, 'Administrador Usuario'),
(3, 'Jefe Producción'),
(4, 'Operario'),
(5, 'Jefe Inventario'),
(6, 'Proveedor');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cargos_has_usuarios`
--

CREATE TABLE `cargos_has_usuarios` (
  `id_usuario_cargo` int(11) NOT NULL,
  `cargos_id_cargos` int(11) NOT NULL,
  `usuarios_num_doc` int(11) NOT NULL,
  `fecha_asignacion` datetime NOT NULL,
  `estado_asignacion` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Volcado de datos para la tabla `cargos_has_usuarios`
--

INSERT INTO `cargos_has_usuarios` (`id_usuario_cargo`, `cargos_id_cargos`, `usuarios_num_doc`, `fecha_asignacion`, `estado_asignacion`) VALUES
(2, 3, 1022934571, '2024-09-15 12:08:06', 'Activo'),
(6, 2, 4869681, '2024-09-15 19:51:40', 'Activo'),
(7, 4, 6543254, '2024-09-15 19:55:51', 'Activo');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `emp_tarea`
--

CREATE TABLE `emp_tarea` (
  `id_empleado_tarea` int(11) NOT NULL COMMENT 'Identificador unico de la tabla puente Emp Tarea\n ',
  `empleados_tipo_documento_id_tipo_documento` int(11) NOT NULL COMMENT 'Fk que  es intermediario entre el empleado y el tipo de documento',
  `empleados_num_doc` int(11) NOT NULL COMMENT 'Fk que esintermediario entre empleado y numero de documento',
  `tarea_id_tarea` int(11) NOT NULL COMMENT 'Fk que es intermediario entre tare y Id de la tarea',
  `emp_tar_fecha_asignacion` date NOT NULL COMMENT 'Atributo que identifica la fecha de asignacion ',
  `emp_tar_fecha_entrega` date NOT NULL COMMENT 'Atributo que identifica la fecha de entrega',
  `emp_tar_estado_tarea` varchar(20) NOT NULL COMMENT 'astributo que identifica el estado de la tarea',
  `produccion_id_produccion` int(11) NOT NULL COMMENT 'fk que comunica com la tabla producción'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `estados`
--

CREATE TABLE `estados` (
  `idEstado` int(11) NOT NULL,
  `nombreEstado` varchar(25) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `estados`
--

INSERT INTO `estados` (`idEstado`, `nombreEstado`) VALUES
(1, 'Agotado'),
(2, 'Habilitado');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `etapas`
--

CREATE TABLE `etapas` (
  `id_etapas` int(11) NOT NULL COMMENT 'Identificador unico de la tabla etapas',
  `eta_nombre` varchar(45) NOT NULL COMMENT 'Atributo que identifca el nombre d el a etapa',
  `eta_descripcion` varchar(100) NOT NULL COMMENT 'Atributo que identifica la descripcion de la etapa'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `materia_prima`
--

CREATE TABLE `materia_prima` (
  `id_materia_prima` int(11) NOT NULL COMMENT 'Identificador unico de la tabla materia prima',
  `mat_pri_nombre` varchar(45) NOT NULL COMMENT 'Atrubuto que identifica lel nombre de la materia prima',
  `mat_pri_descripcion` varchar(45) NOT NULL COMMENT 'Atrubuto que identifica la descripcion del amateria prima',
  `mat_pri_unidad_medida` varchar(10) NOT NULL COMMENT 'Atrubuto que identifica la unidad de medida que se utiliza en la amteria prima',
  `mat_pri_cantidad` int(11) NOT NULL COMMENT 'Atrubuto que identifica la la cantidad de la materia prima',
  `estado_id_estado` int(11) NOT NULL COMMENT 'Atributo que identifica el estado de la materia prima(Agotado, Existente,  Deshabilitado)',
  `fecha_compra_mp` date NOT NULL COMMENT 'Atributo que identifica la fecha de la compra de la materia prima\n',
  `proveedores_id_proveedores` int(11) NOT NULL COMMENT 'Fk que comunica con la tabla proveedores'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Volcado de datos para la tabla `materia_prima`
--

INSERT INTO `materia_prima` (`id_materia_prima`, `mat_pri_nombre`, `mat_pri_descripcion`, `mat_pri_unidad_medida`, `mat_pri_cantidad`, `estado_id_estado`, `fecha_compra_mp`, `proveedores_id_proveedores`) VALUES
(18, 'algodon', 'hodaaa', 'Metros', 80, 1, '2024-09-19', 3);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `modulos`
--

CREATE TABLE `modulos` (
  `id_modulos(11)` int(11) NOT NULL,
  `mod_nombre` varchar(30) NOT NULL,
  `mod_descripcion` varchar(60) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `operaciones`
--

CREATE TABLE `operaciones` (
  `id_operaciones` int(11) NOT NULL,
  `ope_nombre` varchar(45) NOT NULL,
  `modulos_id_modulos(11)` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `operaciones_has_cargos`
--

CREATE TABLE `operaciones_has_cargos` (
  `idOperaCargos` int(11) NOT NULL,
  `operaciones_id` int(11) NOT NULL,
  `cargos_id` int(11) NOT NULL,
  `ope_car_fecha_creacion` datetime NOT NULL,
  `ope_car_fecha_modificacion` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `produccion`
--

CREATE TABLE `produccion` (
  `id_produccion` int(11) NOT NULL COMMENT 'Identificador unico de la tabla produccion',
  `pro_nombre` varchar(50) NOT NULL COMMENT 'Atrubuto que identifica el nombre del producto en produccion',
  `pro_fecha_inicio` datetime NOT NULL COMMENT 'Atrubuto que identifica la fecha de inicio de la producion',
  `pro_fecha_fin` datetime NOT NULL COMMENT 'Atrubuto que identifica la fecha de fin de la producion',
  `pro_cantidad` int(10) NOT NULL COMMENT 'Atrubuto que identifica la cantidad de la producion',
  `pro_etapa` int(11) NOT NULL COMMENT 'fk que comunica con la tabla etapas '
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `produccion_reg_mat_prima`
--

CREATE TABLE `produccion_reg_mat_prima` (
  `produccion_id_produccion` int(11) NOT NULL,
  `reg_pro_mat_prima_id_registro` int(11) NOT NULL,
  `pro_mat_pri_fecha` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `reg_mat_prima`
--

CREATE TABLE `reg_mat_prima` (
  `id_reg_materia_prima` int(11) NOT NULL COMMENT 'Identificador unico de la tabla materia prima',
  `rmp_nombre` varchar(45) NOT NULL COMMENT 'Atributo que identifica el nombre de la materia prima',
  `rmp_unidad_medida` varchar(10) NOT NULL COMMENT 'Atributo que identifica la unidad de medida ',
  `rmp_cantidad` int(15) NOT NULL COMMENT 'Atrubuto que identifica la cantidad disponible de la materia prima',
  `rmp_tipo_movimiento` varchar(20) NOT NULL COMMENT 'Atrubuto que identifica la cantidad de salida de la materia prima',
  `rmp_fecha_actualizacion` date NOT NULL COMMENT 'Atrubuto que identifica la fecha de actualizacion de la materia prima',
  `materia_prima_id_materia_prima` int(11) NOT NULL COMMENT 'Fk que comunica con la tabla materia prima'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Disparadores `reg_mat_prima`
--
DELIMITER $$
CREATE TRIGGER `actualizar_stock_materia_prima` AFTER INSERT ON `reg_mat_prima` FOR EACH ROW BEGIN
    -- Actualizar el stock de materia prima
    UPDATE materia_prima
    SET cantidad_disponible = cantidad_disponible - NEW.rmp_cantidad
    WHERE rmp_cantidad = NEW.rmp_cantidad;
    
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `reg_pro_fabricados`
--

CREATE TABLE `reg_pro_fabricados` (
  `id_reg_prod_fabricados` int(11) NOT NULL COMMENT 'Identificador unico de la tabla registro de productos fabricados',
  `reg_pf_cantidad` int(15) NOT NULL COMMENT 'Atrubuto que identifica la cantidad disponible en los registros de productos fabricados',
  `reg_pf_fecha_registro` date NOT NULL COMMENT 'Atrubuto que identifica la fecha de actualizacion',
  `reg_pf_talla` varchar(4) NOT NULL COMMENT 'Atrinuto que identifica  la talla ',
  `reg_pf_color` varchar(25) NOT NULL COMMENT 'Atrinuto que identifica el color',
  `reg_pf_material` varchar(45) NOT NULL COMMENT 'Atrinuto que identifica el material',
  `reg_pf_tipo_prenda` varchar(45) NOT NULL COMMENT 'Atrinuto que identifica el tipo de prenda',
  `produccion_id_produccion` int(11) NOT NULL COMMENT 'Fk que comunica con la tabla produccion'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `reg_pro_mat_prima`
--

CREATE TABLE `reg_pro_mat_prima` (
  `id_registro` int(11) NOT NULL COMMENT 'Identificador unico de la tabla registro',
  `reg_pmp_unidad_medida` varchar(10) NOT NULL COMMENT 'Atrubuto que identifica la unidad de medida del resgistro producido de materia prima',
  `reg_pmp_cantidad_usada` int(11) NOT NULL COMMENT 'Atrubuto que identifica la cantidad de materia prima usada',
  `reg_pmp_fecha_registro` date NOT NULL COMMENT 'Atrubuto que identifica la la fecha de registro de la materia prima producida',
  `reg_pro_materia_prima` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `salida_productos`
--

CREATE TABLE `salida_productos` (
  `id_salida_productos` int(11) NOT NULL,
  `sal_pro_cantidad` int(11) NOT NULL,
  `sal_pro_motivo` varchar(60) NOT NULL,
  `sal_pro_fecha` datetime NOT NULL,
  `sal_pro_destino` varchar(45) NOT NULL,
  `id_reg_prod_fabricados` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `seguridad`
--

CREATE TABLE `seguridad` (
  `id_seguridad` int(11) NOT NULL COMMENT 'Identificador unico de la tabla seguridad.',
  `usu_num_doc` int(11) NOT NULL COMMENT 'Atributo que identifica el nombre del perfil',
  `seg_clave_hash` varchar(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL COMMENT 'Atributo que identifica el el ultimo inicio de sesion'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Volcado de datos para la tabla `seguridad`
--

INSERT INTO `seguridad` (`id_seguridad`, `usu_num_doc`, `seg_clave_hash`) VALUES
(6, 1022934571, 'p±ÓÐP>”TÚÑÖ±··tYƒäð¶ßœóüÙ±ânòç¦›0 ‰Œº'),
(9, 6543254, 'è¾Üá÷î/2ØêÄšÇÿ'),
(10, 4869681, 'è¾Üá÷î/2ØêÄšÇÿ');

--
-- Disparadores `seguridad`
--
DELIMITER $$
CREATE TRIGGER `encriptar_contraseña` BEFORE INSERT ON `seguridad` FOR EACH ROW BEGIN
    SET NEW.seg_clave_hash = AES_ENCRYPT(NEW.seg_clave_hash, 'BUZOSMT');
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `encriptar_update` BEFORE UPDATE ON `seguridad` FOR EACH ROW BEGIN
    SET NEW.seg_clave_hash = AES_ENCRYPT(NEW.seg_clave_hash, 'BUZOSMT');
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tarea`
--

CREATE TABLE `tarea` (
  `id_tarea` int(11) NOT NULL COMMENT 'Identificador unico de la tabla Tarea',
  `tar_nombre` varchar(50) NOT NULL COMMENT 'Atributo que identifica el nombre de la tarea',
  `tar_descripcion` varchar(200) NOT NULL COMMENT 'Atributo que identifica la descripcion de la tarea',
  `tar_estado` varchar(20) NOT NULL COMMENT 'Atributo que identifica el estaado de la tarea'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipo_doc`
--

CREATE TABLE `tipo_doc` (
  `id_tipo_documento` int(11) NOT NULL COMMENT 'Identificador unico de la tabla tipo de documento',
  `tip_doc_descripcion` varchar(20) NOT NULL COMMENT 'Atributo que identifica la descripcion del tipo del documento'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Volcado de datos para la tabla `tipo_doc`
--

INSERT INTO `tipo_doc` (`id_tipo_documento`, `tip_doc_descripcion`) VALUES
(1, 'Cedula de ciudadania'),
(2, 'Tarjeta de identidad'),
(3, 'PPT');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `num_doc` int(11) NOT NULL COMMENT 'Identificador unico de la tabla Usuario',
  `t_doc` int(11) NOT NULL COMMENT 'Fk que comunica con el tipo de documento',
  `usu_nombres` varchar(60) NOT NULL COMMENT 'Atributo que identifica el primer nombre del Usuario',
  `usu_apellidos` varchar(45) NOT NULL COMMENT 'Atributo que identifica el apellido del usuario',
  `usu_fecha_nacimiento` date NOT NULL COMMENT 'Atributo que identifica la fecha de nacimiento del Usuario',
  `usu_sexo` char(1) NOT NULL COMMENT 'Atributo que identifica el tipo de sexo del Usuario',
  `usu_direccion` varchar(50) NOT NULL COMMENT 'Atributo que identifica el la direccion de residencia del Usuario',
  `usu_telefono` varchar(10) NOT NULL COMMENT 'Atributo que identifica el el numero de contacto del Usuario',
  `usu_email` varchar(100) NOT NULL COMMENT 'Atributo que identifica el correo del Usuario',
  `usu_fecha_contratacion` date NOT NULL COMMENT 'Atributo que identifica el la fecha de contracion del Usuario',
  `usu_estado` varchar(45) NOT NULL COMMENT 'Atributo que identifica el estado del Usuario'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`num_doc`, `t_doc`, `usu_nombres`, `usu_apellidos`, `usu_fecha_nacimiento`, `usu_sexo`, `usu_direccion`, `usu_telefono`, `usu_email`, `usu_fecha_contratacion`, `usu_estado`) VALUES
(4869681, 3, 'Yonathan', 'Nieves', '2024-09-06', 'M', 'Bogotá', '12387932', 'yonathanieves17@gmail.com', '2024-09-03', 'Activo'),
(6543254, 1, 'Paula', 'Tovar', '2024-09-06', 'F', 'Bogotá', '12387932', 'ytrrgytrs17@gmail.com', '2024-09-03', 'Activo'),
(1022934571, 1, 'José', 'Guerrero', '2024-09-08', 'M', 'Bogotá', '324354281', 'multygems@gmail.com', '2024-09-03', 'Activo');

--
-- Disparadores `usuarios`
--
DELIMITER $$
CREATE TRIGGER `actualizar usuario` AFTER UPDATE ON `usuarios` FOR EACH ROW BEGIN
    INSERT INTO usuarios_espejo (
        t_doc, 
        num_doc, 
        usu_nombres, 
        usu_apellidos, 
        usu_fecha_nacimiento, 
        usu_sexo, 
        usu_direccion, 
        usu_telefono, 
        usu_email, 
        usu_fecha_contratacion, 
        usu_estado, 
        fecha_operacion, 
        usuario_operacion,
        operacion
    )
    VALUES (
        NEW.t_doc, 
        NEW.num_doc, 
        NEW.usu_nombres, 
        NEW.usu_apellidos, 
        NEW.usu_fecha_nacimiento, 
        NEW.usu_sexo, 
        NEW.usu_direccion, 
        NEW.usu_telefono, 
        NEW.usu_email, 
        NEW.usu_fecha_contratacion, 
        NEW.usu_estado, 
        NOW(), 
        CURRENT_USER(),
        'UPDATE'
    )
    ON DUPLICATE KEY UPDATE
        usu_nombres = VALUES(usu_nombres),
        usu_apellidos = VALUES(usu_apellidos),
        usu_fecha_nacimiento = VALUES(usu_fecha_nacimiento),
        usu_sexo = VALUES(usu_sexo),
        usu_direccion = VALUES(usu_direccion),
        usu_telefono = VALUES(usu_telefono),
        usu_email = VALUES(usu_email),
        usu_fecha_contratacion = VALUES(usu_fecha_contratacion),
        usu_estado = VALUES(usu_estado),
        fecha_operacion = VALUES(fecha_operacion),
        usuario_operacion = VALUES(usuario_operacion),
        operacion = VALUES(operacion);
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `eliminar_usuario` AFTER DELETE ON `usuarios` FOR EACH ROW BEGIN
    INSERT INTO usuarios_espejo (
        t_doc, 
        num_doc, 
        usu_nombres, 
        usu_apellidos, 
        usu_fecha_nacimiento, 
        usu_sexo, 
        usu_direccion, 
        usu_telefono, 
        usu_email, 
        usu_fecha_contratacion, 
        usu_estado, 
        operacion, 
        fecha_operacion, 
        usuario_operacion
    )
    VALUES (
        OLD.t_doc, 
        OLD.num_doc, 
        OLD.usu_nombres, 
        OLD.usu_apellidos, 
        OLD.usu_fecha_nacimiento, 
        OLD.usu_sexo, 
        OLD.usu_direccion, 
        OLD.usu_telefono, 
        OLD.usu_email, 
        OLD.usu_fecha_contratacion, 
        OLD.usu_estado, 
        'delete', 
        NOW(), 
        CURRENT_USER()
    )
    ON DUPLICATE KEY UPDATE
        usu_nombres = VALUES(usu_nombres),
        usu_apellidos = VALUES(usu_apellidos),
        usu_fecha_nacimiento = VALUES(usu_fecha_nacimiento),
        usu_sexo = VALUES(usu_sexo),
        usu_direccion = VALUES(usu_direccion),
        usu_telefono = VALUES(usu_telefono),
        usu_email = VALUES(usu_email),
        usu_fecha_contratacion = VALUES(usu_fecha_contratacion),
        usu_estado = VALUES(usu_estado),
        operacion = VALUES(operacion),
        fecha_operacion = VALUES(fecha_operacion),
        usuario_operacion = VALUES(usuario_operacion);
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `insertar_usuario` AFTER INSERT ON `usuarios` FOR EACH ROW BEGIN
    INSERT INTO usuarios_espejo (
        t_doc, 
        num_doc, 
        usu_nombres, 
        usu_apellidos, 
        usu_fecha_nacimiento, 
        usu_sexo, 
        usu_direccion, 
        usu_telefono, 
        usu_email, 
        usu_fecha_contratacion, 
        usu_estado, 
        fecha_operacion, 
        usuario_operacion,
        operacion
    )
    VALUES (
        NEW.t_doc, 
        NEW.num_doc, 
        NEW.usu_nombres, 
        NEW.usu_apellidos, 
        NEW.usu_fecha_nacimiento, 
        NEW.usu_sexo, 
        NEW.usu_direccion, 
        NEW.usu_telefono, 
        NEW.usu_email, 
        NEW.usu_fecha_contratacion, 
        NEW.usu_estado, 
        NOW(), 
        CURRENT_USER(),
        'insert'
    )
    ON DUPLICATE KEY UPDATE
        usu_nombres = VALUES(usu_nombres),
        usu_apellidos = VALUES(usu_apellidos),
        usu_fecha_nacimiento = VALUES(usu_fecha_nacimiento),
        usu_sexo = VALUES(usu_sexo),
        usu_direccion = VALUES(usu_direccion),
        usu_telefono = VALUES(usu_telefono),
        usu_email = VALUES(usu_email),
        usu_fecha_contratacion = VALUES(usu_fecha_contratacion),
        usu_estado = VALUES(usu_estado),
        fecha_operacion = VALUES(fecha_operacion),
        usuario_operacion = VALUES(usuario_operacion),
        operacion = VALUES(operacion);
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios_espejo`
--

CREATE TABLE `usuarios_espejo` (
  `num_doc` int(11) NOT NULL COMMENT 'Identificador unico de la tabla Usuario',
  `t_doc` int(11) NOT NULL COMMENT 'Fk que comunica con el tipo de documento',
  `usu_nombres` varchar(60) NOT NULL COMMENT 'Atributo que identifica el primer nombre del Usuario',
  `usu_apellidos` varchar(45) NOT NULL COMMENT 'Atributo que identifica el apellido del usuario',
  `usu_fecha_nacimiento` date NOT NULL COMMENT 'Atributo que identifica la fecha de nacimiento del Usuario',
  `usu_sexo` char(1) NOT NULL COMMENT 'Atributo que identifica el tipo de sexo del Usuario',
  `usu_direccion` varchar(50) NOT NULL COMMENT 'Atributo que identifica el la direccion de residencia del Usuario',
  `usu_telefono` varchar(10) NOT NULL COMMENT 'Atributo que identifica el el numero de contacto del Usuario',
  `usu_email` varchar(100) NOT NULL COMMENT 'Atributo que identifica el correo del Usuario',
  `usu_fecha_contratacion` date NOT NULL COMMENT 'Atributo que identifica el la fecha de contracion del Usuario',
  `usu_estado` varchar(45) NOT NULL COMMENT 'Atributo que identifica el estado del Usuario',
  `operacion` varchar(15) NOT NULL,
  `fecha_operacion` date NOT NULL,
  `usuario_operacion` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Volcado de datos para la tabla `usuarios_espejo`
--

INSERT INTO `usuarios_espejo` (`num_doc`, `t_doc`, `usu_nombres`, `usu_apellidos`, `usu_fecha_nacimiento`, `usu_sexo`, `usu_direccion`, `usu_telefono`, `usu_email`, `usu_fecha_contratacion`, `usu_estado`, `operacion`, `fecha_operacion`, `usuario_operacion`) VALUES
(4869681, 1, 'Yonathan', 'Nieves', '2024-09-06', 'M', 'Bogotá', '12387932', 'yonathanieves17@gmail.com', '2024-09-03', 'Activo', 'insert', '2024-09-15', 'root@localhost'),
(6543254, 1, 'Paula', 'Tovar', '2024-09-06', 'F', 'Bogotá', '12387932', 'ytrrgytrs17@gmail.com', '2024-09-03', 'Activo', 'insert', '2024-09-15', 'root@localhost'),
(123456780, 1, 'Yonathan', 'Nieves', '1985-11-30', 'M', 'ciudad bolivar', '3006290689', 'yonathannieves@gmail.com', '2024-01-08', 'Activo', 'delete', '2024-09-15', 'root@localhost'),
(1022934571, 1, 'José', 'Guerrero', '2024-09-08', 'M', 'Bogotá', '324354281', 'multygems@gmail.com', '2024-09-03', 'Activo', 'UPDATE', '2024-09-15', 'root@localhost');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `cargos`
--
ALTER TABLE `cargos`
  ADD PRIMARY KEY (`id_cargos`);

--
-- Indices de la tabla `cargos_has_usuarios`
--
ALTER TABLE `cargos_has_usuarios`
  ADD PRIMARY KEY (`id_usuario_cargo`),
  ADD KEY `fk_cargos_has_usuarios_usuarios1_idx` (`usuarios_num_doc`),
  ADD KEY `fk_cargos_has_usuarios_cargos1_idx` (`cargos_id_cargos`);

--
-- Indices de la tabla `emp_tarea`
--
ALTER TABLE `emp_tarea`
  ADD PRIMARY KEY (`id_empleado_tarea`),
  ADD KEY `fk_Empleados_has_Tarea_Tarea1_idx` (`tarea_id_tarea`),
  ADD KEY `fk_emp_tarea_produccion1_idx` (`produccion_id_produccion`),
  ADD KEY `fk_doc_empleado` (`empleados_tipo_documento_id_tipo_documento`,`empleados_num_doc`);

--
-- Indices de la tabla `estados`
--
ALTER TABLE `estados`
  ADD PRIMARY KEY (`idEstado`);

--
-- Indices de la tabla `etapas`
--
ALTER TABLE `etapas`
  ADD PRIMARY KEY (`id_etapas`);

--
-- Indices de la tabla `materia_prima`
--
ALTER TABLE `materia_prima`
  ADD PRIMARY KEY (`id_materia_prima`),
  ADD KEY `fk_proveedor_idx` (`proveedores_id_proveedores`),
  ADD KEY `fk_estado` (`estado_id_estado`);

--
-- Indices de la tabla `modulos`
--
ALTER TABLE `modulos`
  ADD PRIMARY KEY (`id_modulos(11)`);

--
-- Indices de la tabla `operaciones`
--
ALTER TABLE `operaciones`
  ADD PRIMARY KEY (`id_operaciones`),
  ADD KEY `fk_operaciones_modulos1_idx` (`modulos_id_modulos(11)`);

--
-- Indices de la tabla `operaciones_has_cargos`
--
ALTER TABLE `operaciones_has_cargos`
  ADD PRIMARY KEY (`idOperaCargos`),
  ADD KEY `fk_operaciones_has_cargos_cargos1_idx` (`cargos_id`),
  ADD KEY `fk_operaciones_has_cargos_operaciones1_idx` (`operaciones_id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `estados`
--
ALTER TABLE `estados`
  MODIFY `idEstado` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `materia_prima`
--
ALTER TABLE `materia_prima`
  MODIFY `id_materia_prima` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Identificador unico de la tabla materia prima', AUTO_INCREMENT=19;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `materia_prima`
--
ALTER TABLE `materia_prima`
  ADD CONSTRAINT `fk_estado` FOREIGN KEY (`estado_id_estado`) REFERENCES `estados` (`idEstado`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
