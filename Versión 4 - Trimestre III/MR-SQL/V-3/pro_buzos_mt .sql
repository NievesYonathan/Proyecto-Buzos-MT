-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 25, 2024 at 12:37 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `pro_buzos_mt`
--

DELIMITER $$
--
-- Procedures
--
CREATE DEFINER=`root`@`localhost` PROCEDURE `lista_proveedores` ()   BEGIN
    SELECT *
    FROM usuarios
    WHERE rol_id_rol = 8;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `tareas_completadas` ()   BEGIN
    SELECT *
    FROM tarea
    WHERE tar_estado = "completado";
END$$

--
-- Functions
--
CREATE DEFINER=`root`@`localhost` FUNCTION `calcular_dias_pasad` (`id` INT) RETURNS LONGTEXT CHARSET utf8mb4 COLLATE utf8mb4_bin DETERMINISTIC BEGIN
    DECLARE fecha_asignacion DATE;
    DECLARE fecha_entrega DATE;
    DECLARE dias_pasad INT;

    -- Obtener la fecha de asignación y la fecha de entrega
    SELECT emp_tar_fecha_asignacion, emp_tar_fecha_entrega 
    INTO fecha_asignacion, fecha_entrega
    FROM emp_tarea
    WHERE id_empleado_tarea = id;

    -- Calcular los días que han pasado entre la fecha de asignación y la fecha de entrega
    SET dias_pasad = DATEDIFF(fecha_entrega, fecha_asignacion);

    -- Retornar un JSON con los datos
    RETURN JSON_OBJECT(
        'dias_pasad', dias_pasad,
        'fecha_asignacion', fecha_asignacion,
        'fecha_entrega', fecha_entrega
    );
END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `cargos`
--

CREATE TABLE `cargos` (
  `id_cargos` int(11) NOT NULL COMMENT 'Identificador unico de la tabla Rol',
  `car_nombre` varchar(40) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `cargos`
--

INSERT INTO `cargos` (`id_cargos`, `car_nombre`) VALUES
(1, 'Jefe de Producción'),
(2, 'Jefe de Inventario'),
(3, 'Jefe de Logística'),
(4, 'Operario de cortadora'),
(5, 'Operario de ensamble'),
(6, 'Administrador'),
(7, 'Empleado'),
(8, 'Proveedor'),
(9, 'Cliente'),
(10, 'Gerente');

-- --------------------------------------------------------

--
-- Table structure for table `cargos_has_usuarios`
--

CREATE TABLE `cargos_has_usuarios` (
  `cargos_id_cargos` int(11) DEFAULT NULL,
  `usuarios_t_doc` int(11) DEFAULT NULL,
  `usuarios_num_doc` int(11) DEFAULT NULL,
  `car_usu_fecha_asignacion` datetime DEFAULT NULL,
  `car_usu_estado_rol` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `emp_tarea`
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

--
-- Dumping data for table `emp_tarea`
--

INSERT INTO `emp_tarea` (`id_empleado_tarea`, `empleados_tipo_documento_id_tipo_documento`, `empleados_num_doc`, `tarea_id_tarea`, `emp_tar_fecha_asignacion`, `emp_tar_fecha_entrega`, `emp_tar_estado_tarea`, `produccion_id_produccion`) VALUES
(1, 1, 10105885, 1, '2024-03-01', '2024-03-10', 'Completada', 1),
(2, 2, 10274586, 2, '2024-03-05', '2024-03-15', 'Pendiente', 2),
(3, 3, 10378547, 3, '2024-03-10', '2024-03-20', 'En Proceso', 3),
(4, 4, 10452456, 4, '2024-03-15', '2024-03-25', 'Completada', 4),
(5, 1, 10105885, 5, '2024-03-20', '2024-03-30', 'Pendiente', 5),
(6, 2, 10274586, 6, '2024-03-25', '2024-04-05', 'En Proceso', 6),
(7, 3, 10378547, 7, '2024-04-01', '2024-04-10', 'Completada', 7),
(8, 4, 10452456, 8, '2024-04-05', '2024-04-15', 'Pendiente', 8),
(9, 1, 10105885, 9, '2024-04-10', '2024-04-20', 'En Proceso', 9),
(10, 2, 10274586, 10, '2024-04-15', '2024-04-25', 'Completada', 10);

-- --------------------------------------------------------

--
-- Table structure for table `etapas`
--

CREATE TABLE `etapas` (
  `id_etapas` int(11) NOT NULL COMMENT 'Identificador unico de la tabla etapas',
  `eta_nombre` varchar(45) NOT NULL COMMENT 'Atributo que identifca el nombre d el a etapa',
  `eta_descripcion` varchar(100) NOT NULL COMMENT 'Atributo que identifica la descripcion de la etapa'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `etapas`
--

INSERT INTO `etapas` (`id_etapas`, `eta_nombre`, `eta_descripcion`) VALUES
(1, 'Corte', 'Corte de la tela según los patrones'),
(2, 'Costura', 'Costura de las piezas cortadas'),
(3, 'Acabado', 'Revisión y acabado de las prendas'),
(4, 'Control de calidad', 'Inspección final de calidad'),
(5, 'Empaque', 'Empaque de las prendas listas para envío'),
(6, 'Almacenamiento', 'Almacenamiento de las prendas terminadas'),
(7, 'Distribución', 'Distribución de las prendas a los puntos de venta'),
(8, 'Diseño', 'Diseño y creación de los patrones'),
(9, 'Compra de material', 'Adquisición de materias primas'),
(10, 'Planificación', 'Planificación de la producción');

-- --------------------------------------------------------

--
-- Table structure for table `materia_prima`
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

--
-- Dumping data for table `materia_prima`
--

INSERT INTO `materia_prima` (`id_materia_prima`, `mat_pri_nombre`, `mat_pri_descripcion`, `mat_pri_unidad_medida`, `mat_pri_cantidad`, `mat_pri_estado`, `fecha_compra_mp`, `proveedores_id_proveedores`) VALUES
(11, 'Tela Algodón', 'Tela de algodón para buzos', 'metros', 500, 'Existente', '2024-01-01', 10105885),
(12, 'Hilo de Poliester', 'Hilo resistente para costura', 'rollos', 200, 'Existente', '2024-01-05', 10274586),
(13, 'Cremalleras', 'Cremalleras de 30 cm', 'unidades', 1000, 'Existente', '2024-01-10', 10378547),
(14, 'Botones', 'Botones de plástico', 'unidades', 5000, 'Existente', '2024-01-15', 10452456),
(15, 'Elástico', 'Elástico de 2 cm', 'metros', 300, 'Agotado', '2024-01-20', 10547856),
(16, 'Tela Lana', 'Tela de lana para buzos', 'metros', 150, 'Existente', '2024-01-25', 10652867),
(17, 'Hilo de Algodón', 'Hilo suave para costura', 'rollos', 250, 'Existente', '2024-02-01', 10769878),
(18, 'Cierres', 'Cierres de 50 cm', 'unidades', 800, 'Deshabilitado', '2024-02-05', 14578608),
(19, 'Broches', 'Broches metálicos', 'unidades', 1500, 'Existente', '2024-02-10', 10652867),
(20, 'Tela Sintética', 'Tela sintética para buzos', 'metros', 400, 'Existente', '2024-02-15', 10652867);

-- --------------------------------------------------------

--
-- Table structure for table `modulos`
--

CREATE TABLE `modulos` (
  `id_modulos` int(11) NOT NULL,
  `mod_nombre` varchar(30) DEFAULT NULL,
  `mod_descripcion` varchar(60) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `operaciones`
--

CREATE TABLE `operaciones` (
  `id_operaciones` int(11) NOT NULL,
  `ope_nombre` varchar(45) DEFAULT NULL,
  `ope_id_modulo` varchar(45) DEFAULT NULL,
  `modulos_id_modulos` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `operaciones_has_cargos`
--

CREATE TABLE `operaciones_has_cargos` (
  `operaciones_id` int(11) DEFAULT NULL,
  `cargos_id_cargos` int(11) DEFAULT NULL,
  `ope_car_fecha_creacion` datetime DEFAULT NULL,
  `ope_car_fecha_modificacion` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `produccion`
--

CREATE TABLE `produccion` (
  `id_produccion` int(11) NOT NULL COMMENT 'Identificador unico de la tabla produccion',
  `pro_nombre` varchar(50) NOT NULL COMMENT 'Atrubuto que identifica el nombre del producto en produccion',
  `pro_fecha_inicio` datetime NOT NULL COMMENT 'Atrubuto que identifica la fecha de inicio de la producion',
  `pro_fecha_fin` datetime NOT NULL COMMENT 'Atrubuto que identifica la fecha de fin de la producion',
  `pro_cantidad` int(10) NOT NULL COMMENT 'Atrubuto que identifica la cantidad de la producion',
  `pro_etapa` int(11) NOT NULL COMMENT 'fk que comunica con la tabla etapas '
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `produccion`
--

INSERT INTO `produccion` (`id_produccion`, `pro_nombre`, `pro_fecha_inicio`, `pro_fecha_fin`, `pro_cantidad`, `pro_etapa`) VALUES
(1, 'Buzo Azul', '2024-01-01 08:00:00', '2024-01-10 17:00:00', 100, 1),
(2, 'Buzo Rojo', '2024-01-11 08:00:00', '2024-01-20 17:00:00', 150, 2),
(3, 'Buzo Verde', '2024-01-21 08:00:00', '2024-01-30 17:00:00', 200, 3),
(4, 'Buzo Amarillo', '2024-02-01 08:00:00', '2024-02-10 17:00:00', 100, 4),
(5, 'Buzo Negro', '2024-02-11 08:00:00', '2024-02-20 17:00:00', 150, 5),
(6, 'Buzo Blanco', '2024-02-21 08:00:00', '2024-03-01 17:00:00', 200, 6),
(7, 'Buzo Gris', '2024-03-02 08:00:00', '2024-03-10 17:00:00', 100, 7),
(8, 'Buzo Naranja', '2024-03-11 08:00:00', '2024-03-20 17:00:00', 150, 8),
(9, 'Buzo Rosa', '2024-03-21 08:00:00', '2024-03-30 17:00:00', 200, 9),
(10, 'Buzo Morado', '2024-04-01 08:00:00', '2024-04-10 17:00:00', 100, 10);

-- --------------------------------------------------------

--
-- Table structure for table `reg_mat_prima`
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
-- Dumping data for table `reg_mat_prima`
--

INSERT INTO `reg_mat_prima` (`id_reg_materia_prima`, `rmp_nombre`, `rmp_unidad_medida`, `rmp_cantidad`, `rmp_tipo_movimiento`, `rmp_fecha_actualizacion`, `materia_prima_id_materia_prima`) VALUES
(11, 'Tela Algodón', 'metros', 500, 'Ingreso', '2024-03-01', 12),
(12, 'Hilo de Poliester', 'rollos', 200, 'Egreso', '2024-03-05', 12),
(13, 'Cremalleras', 'unidades', 1000, 'Ingreso', '2024-03-10', 13),
(14, 'Botones', 'unidades', 5000, 'Egreso', '2024-03-15', 14),
(15, 'Elástico', 'metros', 300, 'Ingreso', '2024-03-20', 15),
(16, 'Tela Lana', 'metros', 150, 'Egreso', '2024-03-25', 16),
(17, 'Hilo de Algodón', 'rollos', 250, 'Ingreso', '2024-04-01', 17),
(18, 'Cierres', 'unidades', 800, 'Egreso', '2024-04-05', 18),
(19, 'Broches', 'unidades', 1500, 'Ingreso', '2024-04-10', 19),
(20, 'Tela Sintética', 'metros', 400, 'Egreso', '2024-04-15', 20);

-- --------------------------------------------------------

--
-- Table structure for table `reg_pro_fabricados`
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

--
-- Dumping data for table `reg_pro_fabricados`
--

INSERT INTO `reg_pro_fabricados` (`id_reg_prod_fabricados`, `reg_pf_cantidad`, `reg_pf_fecha_registro`, `reg_pf_talla`, `reg_pf_color`, `reg_pf_material`, `reg_pf_tipo_prenda`, `produccion_id_produccion`) VALUES
(1, 100, '2024-03-01', 'M', 'Rojo', 'Algodón', 'Buzo', 1),
(2, 200, '2024-03-05', 'L', 'Azul', 'Poliester', 'Buzo', 2),
(3, 150, '2024-03-10', 'S', 'Verde', 'Algodón', 'Buzo', 3),
(4, 250, '2024-03-15', 'M', 'Negro', 'Lana', 'Buzo', 4),
(5, 300, '2024-03-20', 'XL', 'Gris', 'Sintético', 'Buzo', 5),
(6, 400, '2024-03-25', 'L', 'Blanco', 'Algodón', 'Buzo', 6),
(7, 350, '2024-04-01', 'M', 'Azul', 'Poliester', 'Buzo', 7),
(8, 500, '2024-04-05', 'S', 'Rojo', 'Lana', 'Buzo', 8),
(9, 450, '2024-04-10', 'XL', 'Negro', 'Sintético', 'Buzo', 9),
(10, 550, '2024-04-15', 'L', 'Verde', 'Algodón', 'Buzo', 10);

-- --------------------------------------------------------

--
-- Table structure for table `reg_pro_mat_prima`
--

CREATE TABLE `reg_pro_mat_prima` (
  `id_registro` int(11) NOT NULL COMMENT 'Identificador unico de la tabla registro',
  `reg_pmp_unidad_medida` varchar(10) NOT NULL COMMENT 'Atrubuto que identifica la unidad de medida del resgistro producido de materia prima',
  `reg_pmp_cantidad_usada` int(11) NOT NULL COMMENT 'Atrubuto que identifica la cantidad de materia prima usada',
  `reg_pmp_fecha_registro` date NOT NULL COMMENT 'Atrubuto que identifica la la fecha de registro de la materia prima producida',
  `produccion_id_produccion` int(11) NOT NULL COMMENT 'Fk que comunica con la tabla Produccion',
  `reg_pro_materia_prima` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `reg_pro_mat_prima`
--

INSERT INTO `reg_pro_mat_prima` (`id_registro`, `reg_pmp_unidad_medida`, `reg_pmp_cantidad_usada`, `reg_pmp_fecha_registro`, `produccion_id_produccion`, `reg_pro_materia_prima`) VALUES
(11, 'metros', 100, '2024-03-01', 1, 11),
(12, 'rollos', 50, '2024-03-05', 2, 12),
(13, 'unidades', 300, '2024-03-10', 3, 13),
(14, 'unidades', 200, '2024-03-15', 4, 14),
(15, 'metros', 80, '2024-03-20', 5, 15),
(16, 'metros', 60, '2024-03-25', 6, 16),
(17, 'rollos', 70, '2024-04-01', 7, 17),
(18, 'unidades', 250, '2024-04-05', 8, 18),
(19, 'unidades', 150, '2024-04-10', 9, 19),
(20, 'metros', 120, '2024-04-15', 10, 20);

-- --------------------------------------------------------

--
-- Table structure for table `salida_productos`
--

CREATE TABLE `salida_productos` (
  `id_salida_productos` int(11) NOT NULL,
  `sal_pro_cantidad` int(11) DEFAULT NULL,
  `sal_pro_motivo` varchar(60) DEFAULT NULL,
  `sal_pro_fecha` datetime DEFAULT NULL,
  `sal_pro_destino` varchar(45) DEFAULT NULL,
  `id_reg_prod_fabricados` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `seguridad`
--

CREATE TABLE `seguridad` (
  `id_seguridad` int(11) NOT NULL COMMENT 'Identificador unico de la tabla Perfil',
  `usu_num_doc` int(11) NOT NULL COMMENT 'Atributo que identifica el nombre del perfil',
  `seg_clave_hash` varchar(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL COMMENT 'Atributo que identifica la clave del perfil',
  `usu_tipo_doc` int(11) NOT NULL COMMENT 'Atributo que identifica el el ultimo inicio de sesion'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `seguridad`
--

INSERT INTO `seguridad` (`id_seguridad`, `usu_num_doc`, `seg_clave_hash`, `usu_tipo_doc`) VALUES
(1, 1234567890, 'ÈÖê³´2¹¨‰Ðf¡ñ', 1),
(2, 987654321, 'îZupañ’Lâ', 3),
(3, 2147483647, 'bMDYåv@ŒâX ZZÂ', 6),
(4, 2147483647, '™Ü¡Hã°\nqn\naïÅ', 2),
(5, 2147483647, 'ãÖë¼‡5×\\¬Î|<Ðp', 7),
(6, 2147483647, 'VÊð…‰º#ûròµF“Ù', 9),
(7, 2147483647, 'SÍtŸq5¥Rí%œ	þ˜B', 1),
(8, 2147483647, 'ˆqM\r\ZkÙ$þ‡†Á', 5),
(9, 2147483647, '\\\rKº}#,æ60Ëˆ^É', 8),
(10, 2147483647, 'Ùüg¬“Ý·jåH‡é', 2);

--
-- Triggers `seguridad`
--
DELIMITER $$
CREATE TRIGGER `encriptar_contraseña` BEFORE INSERT ON `seguridad` FOR EACH ROW BEGIN
    SET NEW.seg_clave_hash = AES_ENCRYPT(NEW.seg_clave_hash, 'BUZOSMT');
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `encriptar_update_tabla` BEFORE UPDATE ON `seguridad` FOR EACH ROW BEGIN
UPDATE seguridad
    SET NEW.seg_clave_hash = AES_ENCRYPT(NEW.seg_clave_hash, 'BUZOSMT');
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `tarea`
--

CREATE TABLE `tarea` (
  `id_tarea` int(11) NOT NULL COMMENT 'Identificador unico de la tabla Tarea',
  `tar_nombre` varchar(50) NOT NULL COMMENT 'Atributo que identifica el nombre de la tarea',
  `tar_descripcion` varchar(200) NOT NULL COMMENT 'Atributo que identifica la descripcion de la tarea',
  `tar_estado` varchar(20) NOT NULL COMMENT 'Atributo que identifica el estaado de la tarea'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `tarea`
--

INSERT INTO `tarea` (`id_tarea`, `tar_nombre`, `tar_descripcion`, `tar_estado`) VALUES
(1, 'Corte de Tela', 'Corte de tela para buzo azul', 'Completado'),
(2, 'Costura de Mangas', 'Costura de mangas para buzo azul', 'Completado'),
(3, 'Costura de Cuerpo', 'Costura del cuerpo para buzo azul', 'Completado'),
(4, 'Ensambaje', 'Ensambaje final para buzo azul', 'Completado'),
(5, 'Corte de Tela', 'Corte de tela para buzo rojo', 'Completado'),
(6, 'Costura de Mangas', 'Costura de mangas para buzo rojo', 'Completado'),
(7, 'Costura de Cuerpo', 'Costura del cuerpo para buzo rojo', 'Completado'),
(8, 'Ensambaje', 'Ensambaje final para buzo rojo', 'Completado'),
(9, 'Corte de Tela', 'Corte de tela para buzo verde', 'Completado'),
(10, 'Costura de Mangas', 'Costura de mangas para buzo verde', 'Completado');

-- --------------------------------------------------------

--
-- Table structure for table `tipo_doc`
--

CREATE TABLE `tipo_doc` (
  `id_tipo_documento` int(11) NOT NULL COMMENT 'Identificador unico de la tabla tipo de documento',
  `tip_doc_descripcion` varchar(8) NOT NULL COMMENT 'Atributo que identifica la descripcion del tipo del documento'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `tipo_doc`
--

INSERT INTO `tipo_doc` (`id_tipo_documento`, `tip_doc_descripcion`) VALUES
(1, 'CC'),
(2, 'TI'),
(3, 'CE'),
(4, 'PAS'),
(5, 'DNI'),
(6, 'NIT'),
(7, 'ID'),
(8, 'RUT'),
(9, 'RC'),
(10, 'PPT');

-- --------------------------------------------------------

--
-- Table structure for table `usuarios`
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
  `usu_estado` varchar(45) NOT NULL COMMENT 'Atributo que identifica el estado del Usuario',
  `rol_id_rol` int(11) NOT NULL COMMENT 'Fk que comunica con la tabla rol',
  `perfil_id_perfil` int(11) NOT NULL COMMENT 'Fk que comunica con la tabla Perfil'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `usuarios`
--

INSERT INTO `usuarios` (`num_doc`, `t_doc`, `usu_nombres`, `usu_apellidos`, `usu_fecha_nacimiento`, `usu_sexo`, `usu_direccion`, `usu_telefono`, `usu_email`, `usu_fecha_contratacion`, `usu_estado`, `rol_id_rol`, `perfil_id_perfil`) VALUES
(10105885, 1, 'Juan', 'Perez', '1990-01-01', 'M', 'Calle 123', '3001234567', 'juan.perez@example.com', '2024-01-01', 'Activo', 1, 1),
(10274586, 2, 'Ana', 'Gomez', '1985-02-02', 'F', 'Calle 456', '3002345678', 'ana.gomez@example.com', '2024-02-01', 'Activo', 2, 2),
(10378547, 3, 'Carlos', 'Lopez', '1975-03-03', 'M', 'Calle 789', '3003456789', 'carlos.lopez@example.com', '2024-03-01', 'Activo', 3, 3),
(10452456, 4, 'Maria', 'Rodriguez', '1995-04-04', 'F', 'Calle 012', '3004567890', 'maria.rodriguez@example.com', '2024-04-01', 'Activo', 4, 4),
(10547856, 5, 'Pedro', 'Martinez', '1980-05-05', 'M', 'Calle 345', '3005678901', 'pedro.martinez@example.com', '2024-05-01', 'Activo', 5, 5),
(10652867, 6, 'Luisa', 'Garcia', '1993-06-06', 'F', 'Calle 678', '3006789012', 'luisa.garcia@example.com', '2024-06-01', 'Activo', 6, 6),
(10769878, 7, 'Jorge', 'Hernandez', '1988-07-07', 'M', 'Calle 901', '3007890123', 'jorge.hernandez@example.com', '2024-07-01', 'Activo', 7, 7),
(10785259, 9, 'Rosa', 'Diaz', '1992-09-09', 'F', 'Calle 567', '3009012345', 'rosa.diaz@example.com', '2024-09-01', 'Activo', 9, 9),
(14578608, 8, 'Laura', 'Ramirez', '1977-08-08', 'F', 'Calle 234', '3008901234', 'laura.ramirez@example.com', '2024-08-01', 'Activo', 8, 8),
(17865700, 10, 'Luis', 'Torres', '1983-10-10', 'M', 'Calle 890', '3000123456', 'luis.torres@example.com', '2024-10-01', 'Activo', 10, 10);

--
-- Triggers `usuarios`
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
            rol_id_rol, 
            perfil_id_perfil, 
            operacion, 
            fecha_operacion, 
            usuario_operacion
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
            NEW.rol_id_rol, 
            NEW.perfil_id_perfil, 
            'UPDATE', 
            NOW(), 
            CURRENT_USER()
        );
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
        rol_id_rol, 
        perfil_id_perfil, 
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
        OLD.rol_id_rol, 
        OLD.perfil_id_perfil, 
        'delete', 
        NOW(), 
        CURRENT_USER()
    );
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
        rol_id_rol, 
        perfil_id_perfil, 
        operacion, 
        fecha_operacion, 
        usuario_operacion
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
        NEW.rol_id_rol, 
        NEW.perfil_id_perfil, 
        'insert', 
        NOW(), 
        CURRENT_USER()
    );
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `usuarios_espejo`
--

CREATE TABLE `usuarios_espejo` (
  `num_doc` int(11) NOT NULL,
  `t_doc` int(11) DEFAULT NULL,
  `usu_nombres` varchar(50) DEFAULT NULL,
  `usu_apellidos` varchar(50) DEFAULT NULL,
  `usu_fecha_nacimiento` date DEFAULT NULL,
  `usu_sexo` char(1) DEFAULT NULL,
  `usu_direccion` varchar(50) DEFAULT NULL,
  `usu_telefono` varchar(10) DEFAULT NULL,
  `usu_email` varchar(100) DEFAULT NULL,
  `usu_fecha_contratacion` date DEFAULT NULL,
  `usu_estado` varchar(10) DEFAULT NULL,
  `rol_id_rol` int(11) DEFAULT NULL,
  `perfil_id_perfil` int(11) DEFAULT NULL,
  `operacion` varchar(50) DEFAULT NULL,
  `fecha_operacion` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `usuario_operacion` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `usuarios_espejo`
--

INSERT INTO `usuarios_espejo` (`num_doc`, `t_doc`, `usu_nombres`, `usu_apellidos`, `usu_fecha_nacimiento`, `usu_sexo`, `usu_direccion`, `usu_telefono`, `usu_email`, `usu_fecha_contratacion`, `usu_estado`, `rol_id_rol`, `perfil_id_perfil`, `operacion`, `fecha_operacion`, `usuario_operacion`) VALUES
(17865700, 10, 'Luis', 'Torres', '1983-10-10', 'M', 'Calle 890', '3000123456', 'luis.torres@example.com', '2024-10-01', 'Activo', 10, 10, 'UPDATE', '2024-08-24 14:17:17', 'root@localhost'),
(17865710, 10, 'Luis', 'Torres', '1983-10-10', 'M', 'Calle 890', '3000123456', 'luis.torres@example.com', '2024-10-01', 'Activo', 10, 10, 'delete', '2024-08-24 14:08:25', 'root@localhost'),
(17865711, 10, 'Luis', 'Torres', '1983-10-10', 'M', 'Calle 890', '3000123456', 'luis.torres@example.com', '2024-10-01', 'Activo', 10, 10, 'insert', '2024-08-24 14:16:24', 'root@localhost');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cargos`
--
ALTER TABLE `cargos`
  ADD PRIMARY KEY (`id_cargos`);

--
-- Indexes for table `cargos_has_usuarios`
--
ALTER TABLE `cargos_has_usuarios`
  ADD KEY `cargos_id_cargos` (`cargos_id_cargos`);

--
-- Indexes for table `emp_tarea`
--
ALTER TABLE `emp_tarea`
  ADD PRIMARY KEY (`id_empleado_tarea`),
  ADD KEY `fk_Empleados_has_Tarea_Tarea1_idx` (`tarea_id_tarea`),
  ADD KEY `fk_emp_tarea_produccion1_idx` (`produccion_id_produccion`),
  ADD KEY `fk_doc_empleado` (`empleados_tipo_documento_id_tipo_documento`,`empleados_num_doc`);

--
-- Indexes for table `etapas`
--
ALTER TABLE `etapas`
  ADD PRIMARY KEY (`id_etapas`);

--
-- Indexes for table `materia_prima`
--
ALTER TABLE `materia_prima`
  ADD PRIMARY KEY (`id_materia_prima`),
  ADD KEY `fk_proveedor_idx` (`proveedores_id_proveedores`);

--
-- Indexes for table `modulos`
--
ALTER TABLE `modulos`
  ADD PRIMARY KEY (`id_modulos`);

--
-- Indexes for table `operaciones`
--
ALTER TABLE `operaciones`
  ADD PRIMARY KEY (`id_operaciones`),
  ADD KEY `modulos_id_modulos` (`modulos_id_modulos`);

--
-- Indexes for table `operaciones_has_cargos`
--
ALTER TABLE `operaciones_has_cargos`
  ADD KEY `operaciones_id` (`operaciones_id`),
  ADD KEY `cargos_id_cargos` (`cargos_id_cargos`);

--
-- Indexes for table `produccion`
--
ALTER TABLE `produccion`
  ADD PRIMARY KEY (`id_produccion`),
  ADD KEY `fk_produccion_etapas1_idx` (`pro_etapa`);

--
-- Indexes for table `reg_mat_prima`
--
ALTER TABLE `reg_mat_prima`
  ADD PRIMARY KEY (`id_reg_materia_prima`,`materia_prima_id_materia_prima`),
  ADD KEY `fk_Registro_Materia_Prima_Materia_Prima1_idx` (`materia_prima_id_materia_prima`);

--
-- Indexes for table `reg_pro_fabricados`
--
ALTER TABLE `reg_pro_fabricados`
  ADD PRIMARY KEY (`id_reg_prod_fabricados`),
  ADD KEY `fk_Registro_Productos_Fabricados_Producción1_idx` (`produccion_id_produccion`);

--
-- Indexes for table `reg_pro_mat_prima`
--
ALTER TABLE `reg_pro_mat_prima`
  ADD PRIMARY KEY (`id_registro`),
  ADD KEY `fk_Registro_Prod_Mat_Prima_Producción1_idx` (`produccion_id_produccion`),
  ADD KEY `fk_reg_pro_mat_prima_reg_mat_prima1_idx` (`reg_pro_materia_prima`);

--
-- Indexes for table `salida_productos`
--
ALTER TABLE `salida_productos`
  ADD PRIMARY KEY (`id_salida_productos`),
  ADD KEY `id_reg_prod_fabricados` (`id_reg_prod_fabricados`);

--
-- Indexes for table `seguridad`
--
ALTER TABLE `seguridad`
  ADD PRIMARY KEY (`id_seguridad`);

--
-- Indexes for table `tarea`
--
ALTER TABLE `tarea`
  ADD PRIMARY KEY (`id_tarea`);

--
-- Indexes for table `tipo_doc`
--
ALTER TABLE `tipo_doc`
  ADD PRIMARY KEY (`id_tipo_documento`);

--
-- Indexes for table `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`num_doc`),
  ADD KEY `fk_Empleados_Rol_idx` (`rol_id_rol`),
  ADD KEY `fk_Empleados_Perfil1_idx` (`perfil_id_perfil`),
  ADD KEY `fk_TipoDoc_idx` (`t_doc`);

--
-- Indexes for table `usuarios_espejo`
--
ALTER TABLE `usuarios_espejo`
  ADD PRIMARY KEY (`num_doc`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `cargos`
--
ALTER TABLE `cargos`
  MODIFY `id_cargos` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Identificador unico de la tabla Rol', AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `emp_tarea`
--
ALTER TABLE `emp_tarea`
  MODIFY `id_empleado_tarea` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Identificador unico de la tabla puente Emp Tarea\n ', AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `etapas`
--
ALTER TABLE `etapas`
  MODIFY `id_etapas` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Identificador unico de la tabla etapas', AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `materia_prima`
--
ALTER TABLE `materia_prima`
  MODIFY `id_materia_prima` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Identificador unico de la tabla materia prima', AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `modulos`
--
ALTER TABLE `modulos`
  MODIFY `id_modulos` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `operaciones`
--
ALTER TABLE `operaciones`
  MODIFY `id_operaciones` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `produccion`
--
ALTER TABLE `produccion`
  MODIFY `id_produccion` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Identificador unico de la tabla produccion', AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `reg_mat_prima`
--
ALTER TABLE `reg_mat_prima`
  MODIFY `id_reg_materia_prima` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Identificador unico de la tabla materia prima', AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `reg_pro_fabricados`
--
ALTER TABLE `reg_pro_fabricados`
  MODIFY `id_reg_prod_fabricados` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Identificador unico de la tabla registro de productos fabricados', AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `reg_pro_mat_prima`
--
ALTER TABLE `reg_pro_mat_prima`
  MODIFY `id_registro` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Identificador unico de la tabla registro', AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `salida_productos`
--
ALTER TABLE `salida_productos`
  MODIFY `id_salida_productos` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `seguridad`
--
ALTER TABLE `seguridad`
  MODIFY `id_seguridad` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Identificador unico de la tabla Perfil', AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `tarea`
--
ALTER TABLE `tarea`
  MODIFY `id_tarea` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Identificador unico de la tabla Tarea', AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `tipo_doc`
--
ALTER TABLE `tipo_doc`
  MODIFY `id_tipo_documento` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Identificador unico de la tabla tipo de documento', AUTO_INCREMENT=11;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `cargos_has_usuarios`
--
ALTER TABLE `cargos_has_usuarios`
  ADD CONSTRAINT `cargos_has_usuarios_ibfk_1` FOREIGN KEY (`cargos_id_cargos`) REFERENCES `cargos` (`id_cargos`);

--
-- Constraints for table `emp_tarea`
--
ALTER TABLE `emp_tarea`
  ADD CONSTRAINT `fk_Empleados_has_Tarea_Tarea1` FOREIGN KEY (`tarea_id_tarea`) REFERENCES `tarea` (`id_tarea`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_doc_empleado` FOREIGN KEY (`empleados_tipo_documento_id_tipo_documento`,`empleados_num_doc`) REFERENCES `usuarios` (`t_doc`, `num_doc`) ON DELETE NO ACTION ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_emp_tarea_produccion1` FOREIGN KEY (`produccion_id_produccion`) REFERENCES `produccion` (`id_produccion`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `materia_prima`
--
ALTER TABLE `materia_prima`
  ADD CONSTRAINT `fk_proveedor` FOREIGN KEY (`proveedores_id_proveedores`) REFERENCES `usuarios` (`num_doc`) ON DELETE NO ACTION ON UPDATE CASCADE;

--
-- Constraints for table `operaciones`
--
ALTER TABLE `operaciones`
  ADD CONSTRAINT `operaciones_ibfk_1` FOREIGN KEY (`modulos_id_modulos`) REFERENCES `modulos` (`id_modulos`);

--
-- Constraints for table `operaciones_has_cargos`
--
ALTER TABLE `operaciones_has_cargos`
  ADD CONSTRAINT `operaciones_has_cargos_ibfk_1` FOREIGN KEY (`operaciones_id`) REFERENCES `operaciones` (`id_operaciones`),
  ADD CONSTRAINT `operaciones_has_cargos_ibfk_2` FOREIGN KEY (`cargos_id_cargos`) REFERENCES `cargos` (`id_cargos`);

--
-- Constraints for table `produccion`
--
ALTER TABLE `produccion`
  ADD CONSTRAINT `fk_produccion_etapas1` FOREIGN KEY (`pro_etapa`) REFERENCES `etapas` (`id_etapas`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `reg_mat_prima`
--
ALTER TABLE `reg_mat_prima`
  ADD CONSTRAINT `fk_Registro_Materia_Prima_Materia_Prima1` FOREIGN KEY (`materia_prima_id_materia_prima`) REFERENCES `materia_prima` (`id_materia_prima`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `reg_pro_fabricados`
--
ALTER TABLE `reg_pro_fabricados`
  ADD CONSTRAINT `fk_Registro_Productos_Fabricados_Producción1` FOREIGN KEY (`produccion_id_produccion`) REFERENCES `produccion` (`id_produccion`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `reg_pro_mat_prima`
--
ALTER TABLE `reg_pro_mat_prima`
  ADD CONSTRAINT `fk_Registro_Prod_Mat_Prima_Producción1` FOREIGN KEY (`produccion_id_produccion`) REFERENCES `produccion` (`id_produccion`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_reg_pro_mat_prima_reg_mat_prima1` FOREIGN KEY (`reg_pro_materia_prima`) REFERENCES `reg_mat_prima` (`id_reg_materia_prima`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `salida_productos`
--
ALTER TABLE `salida_productos`
  ADD CONSTRAINT `salida_productos_ibfk_1` FOREIGN KEY (`id_reg_prod_fabricados`) REFERENCES `reg_pro_fabricados` (`id_reg_prod_fabricados`);

--
-- Constraints for table `usuarios`
--
ALTER TABLE `usuarios`
  ADD CONSTRAINT `fk_Empleados_Perfil1` FOREIGN KEY (`perfil_id_perfil`) REFERENCES `seguridad` (`id_seguridad`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_Empleados_Rol` FOREIGN KEY (`rol_id_rol`) REFERENCES `cargos` (`id_cargos`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_TipoDoc` FOREIGN KEY (`t_doc`) REFERENCES `tipo_doc` (`id_tipo_documento`) ON DELETE NO ACTION ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
