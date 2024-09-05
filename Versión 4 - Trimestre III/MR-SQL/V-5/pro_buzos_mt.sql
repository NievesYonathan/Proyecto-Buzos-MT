-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 05-09-2024 a las 14:21:01
-- Versión del servidor: 10.4.32-MariaDB
-- Versión de PHP: 8.2.12

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
  `mat_pri_cantidad` int(15) NOT NULL COMMENT 'Atrubuto que identifica la la cantidad de la materia prima',
  `mat_pri_estado` varchar(45) NOT NULL COMMENT 'Atributo que identifica el estado de la materia prima(Agotado, Existente,  Deshabilitado)',
  `fecha_compra_mp` date NOT NULL COMMENT 'Atributo que identifica la fecha de la compra de la materia prima\n',
  `proveedores_id_proveedores` int(11) NOT NULL COMMENT 'Fk que comunica con la tabla proveedores'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

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
  `seg_clave_hash` varchar(50) NOT NULL COMMENT 'Atributo que identifica el el ultimo inicio de sesion'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

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
  `tip_doc_descripcion` varchar(8) NOT NULL COMMENT 'Atributo que identifica la descripcion del tipo del documento'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

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
-- Indices de la tabla `etapas`
--
ALTER TABLE `etapas`
  ADD PRIMARY KEY (`id_etapas`);

--
-- Indices de la tabla `materia_prima`
--
ALTER TABLE `materia_prima`
  ADD PRIMARY KEY (`id_materia_prima`),
  ADD KEY `fk_proveedor_idx` (`proveedores_id_proveedores`);

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
-- Indices de la tabla `produccion`
--
ALTER TABLE `produccion`
  ADD PRIMARY KEY (`id_produccion`),
  ADD KEY `fk_produccion_etapas1_idx` (`pro_etapa`);

--
-- Indices de la tabla `produccion_reg_mat_prima`
--
ALTER TABLE `produccion_reg_mat_prima`
  ADD PRIMARY KEY (`produccion_id_produccion`,`reg_pro_mat_prima_id_registro`),
  ADD KEY `fk_produccion_has_reg_pro_mat_prima_reg_pro_mat_prima1_idx` (`reg_pro_mat_prima_id_registro`),
  ADD KEY `fk_produccion_has_reg_pro_mat_prima_produccion1_idx` (`produccion_id_produccion`);

--
-- Indices de la tabla `reg_mat_prima`
--
ALTER TABLE `reg_mat_prima`
  ADD PRIMARY KEY (`id_reg_materia_prima`,`materia_prima_id_materia_prima`),
  ADD KEY `fk_Registro_Materia_Prima_Materia_Prima1_idx` (`materia_prima_id_materia_prima`);

--
-- Indices de la tabla `reg_pro_fabricados`
--
ALTER TABLE `reg_pro_fabricados`
  ADD PRIMARY KEY (`id_reg_prod_fabricados`),
  ADD KEY `fk_Registro_Productos_Fabricados_Producción1_idx` (`produccion_id_produccion`);

--
-- Indices de la tabla `reg_pro_mat_prima`
--
ALTER TABLE `reg_pro_mat_prima`
  ADD PRIMARY KEY (`id_registro`),
  ADD KEY `fk_reg_pro_mat_prima_reg_mat_prima1_idx` (`reg_pro_materia_prima`);

--
-- Indices de la tabla `salida_productos`
--
ALTER TABLE `salida_productos`
  ADD PRIMARY KEY (`id_salida_productos`),
  ADD KEY `fk_salida_productos_reg_pro_fabricados1_idx` (`id_reg_prod_fabricados`);

--
-- Indices de la tabla `seguridad`
--
ALTER TABLE `seguridad`
  ADD PRIMARY KEY (`id_seguridad`),
  ADD KEY `fk_seguridad_usuarios1_idx` (`usu_num_doc`);

--
-- Indices de la tabla `tarea`
--
ALTER TABLE `tarea`
  ADD PRIMARY KEY (`id_tarea`);

--
-- Indices de la tabla `tipo_doc`
--
ALTER TABLE `tipo_doc`
  ADD PRIMARY KEY (`id_tipo_documento`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`num_doc`),
  ADD KEY `fk_TipoDoc_idx` (`t_doc`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `cargos`
--
ALTER TABLE `cargos`
  MODIFY `id_cargos` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Identificador unico de la tabla Rol';

--
-- AUTO_INCREMENT de la tabla `emp_tarea`
--
ALTER TABLE `emp_tarea`
  MODIFY `id_empleado_tarea` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Identificador unico de la tabla puente Emp Tarea\n ';

--
-- AUTO_INCREMENT de la tabla `etapas`
--
ALTER TABLE `etapas`
  MODIFY `id_etapas` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Identificador unico de la tabla etapas';

--
-- AUTO_INCREMENT de la tabla `materia_prima`
--
ALTER TABLE `materia_prima`
  MODIFY `id_materia_prima` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Identificador unico de la tabla materia prima';

--
-- AUTO_INCREMENT de la tabla `modulos`
--
ALTER TABLE `modulos`
  MODIFY `id_modulos(11)` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `produccion`
--
ALTER TABLE `produccion`
  MODIFY `id_produccion` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Identificador unico de la tabla produccion';

--
-- AUTO_INCREMENT de la tabla `reg_mat_prima`
--
ALTER TABLE `reg_mat_prima`
  MODIFY `id_reg_materia_prima` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Identificador unico de la tabla materia prima';

--
-- AUTO_INCREMENT de la tabla `reg_pro_fabricados`
--
ALTER TABLE `reg_pro_fabricados`
  MODIFY `id_reg_prod_fabricados` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Identificador unico de la tabla registro de productos fabricados';

--
-- AUTO_INCREMENT de la tabla `reg_pro_mat_prima`
--
ALTER TABLE `reg_pro_mat_prima`
  MODIFY `id_registro` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Identificador unico de la tabla registro';

--
-- AUTO_INCREMENT de la tabla `seguridad`
--
ALTER TABLE `seguridad`
  MODIFY `id_seguridad` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Identificador unico de la tabla seguridad.';

--
-- AUTO_INCREMENT de la tabla `tarea`
--
ALTER TABLE `tarea`
  MODIFY `id_tarea` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Identificador unico de la tabla Tarea';

--
-- AUTO_INCREMENT de la tabla `tipo_doc`
--
ALTER TABLE `tipo_doc`
  MODIFY `id_tipo_documento` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Identificador unico de la tabla tipo de documento';

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `cargos_has_usuarios`
--
ALTER TABLE `cargos_has_usuarios`
  ADD CONSTRAINT `fk_cargos_has_usuarios_cargos1` FOREIGN KEY (`cargos_id_cargos`) REFERENCES `cargos` (`id_cargos`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_cargos_has_usuarios_usuarios1` FOREIGN KEY (`usuarios_num_doc`) REFERENCES `usuarios` (`num_doc`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `emp_tarea`
--
ALTER TABLE `emp_tarea`
  ADD CONSTRAINT `fk_Empleados_has_Tarea_Tarea1` FOREIGN KEY (`tarea_id_tarea`) REFERENCES `tarea` (`id_tarea`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_doc_empleado` FOREIGN KEY (`empleados_tipo_documento_id_tipo_documento`,`empleados_num_doc`) REFERENCES `usuarios` (`t_doc`, `num_doc`) ON DELETE NO ACTION ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_emp_tarea_produccion1` FOREIGN KEY (`produccion_id_produccion`) REFERENCES `produccion` (`id_produccion`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `materia_prima`
--
ALTER TABLE `materia_prima`
  ADD CONSTRAINT `fk_proveedor` FOREIGN KEY (`proveedores_id_proveedores`) REFERENCES `usuarios` (`num_doc`) ON DELETE NO ACTION ON UPDATE CASCADE;

--
-- Filtros para la tabla `operaciones`
--
ALTER TABLE `operaciones`
  ADD CONSTRAINT `fk_operaciones_modulos1` FOREIGN KEY (`modulos_id_modulos(11)`) REFERENCES `modulos` (`id_modulos(11)`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `operaciones_has_cargos`
--
ALTER TABLE `operaciones_has_cargos`
  ADD CONSTRAINT `fk_operaciones_has_cargos_cargos1` FOREIGN KEY (`cargos_id`) REFERENCES `cargos` (`id_cargos`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_operaciones_has_cargos_operaciones1` FOREIGN KEY (`operaciones_id`) REFERENCES `operaciones` (`id_operaciones`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `produccion`
--
ALTER TABLE `produccion`
  ADD CONSTRAINT `fk_produccion_etapas1` FOREIGN KEY (`pro_etapa`) REFERENCES `etapas` (`id_etapas`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `produccion_reg_mat_prima`
--
ALTER TABLE `produccion_reg_mat_prima`
  ADD CONSTRAINT `fk_produccion_has_reg_pro_mat_prima_produccion1` FOREIGN KEY (`produccion_id_produccion`) REFERENCES `produccion` (`id_produccion`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_produccion_has_reg_pro_mat_prima_reg_pro_mat_prima1` FOREIGN KEY (`reg_pro_mat_prima_id_registro`) REFERENCES `reg_pro_mat_prima` (`id_registro`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `reg_mat_prima`
--
ALTER TABLE `reg_mat_prima`
  ADD CONSTRAINT `fk_Registro_Materia_Prima_Materia_Prima1` FOREIGN KEY (`materia_prima_id_materia_prima`) REFERENCES `materia_prima` (`id_materia_prima`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `reg_pro_fabricados`
--
ALTER TABLE `reg_pro_fabricados`
  ADD CONSTRAINT `fk_Registro_Productos_Fabricados_Producción1` FOREIGN KEY (`produccion_id_produccion`) REFERENCES `produccion` (`id_produccion`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `reg_pro_mat_prima`
--
ALTER TABLE `reg_pro_mat_prima`
  ADD CONSTRAINT `fk_reg_pro_mat_prima_reg_mat_prima1` FOREIGN KEY (`reg_pro_materia_prima`) REFERENCES `reg_mat_prima` (`id_reg_materia_prima`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `salida_productos`
--
ALTER TABLE `salida_productos`
  ADD CONSTRAINT `fk_salida_productos_reg_pro_fabricados1` FOREIGN KEY (`id_reg_prod_fabricados`) REFERENCES `reg_pro_fabricados` (`id_reg_prod_fabricados`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `seguridad`
--
ALTER TABLE `seguridad`
  ADD CONSTRAINT `fk_seguridad_usuarios1` FOREIGN KEY (`usu_num_doc`) REFERENCES `usuarios` (`num_doc`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD CONSTRAINT `fk_TipoDoc` FOREIGN KEY (`t_doc`) REFERENCES `tipo_doc` (`id_tipo_documento`) ON DELETE NO ACTION ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
