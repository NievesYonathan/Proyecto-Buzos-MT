-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 06-10-2024 a las 02:22:25
-- Versión del servidor: 10.4.32-MariaDB
-- Versión de PHP: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `pro_buzos_mt1`
--

DELIMITER $$
--
-- Procedimientos
--
CREATE DEFINER=`root`@`localhost` PROCEDURE `asignar_tarea` (IN `p_id_tarea` INT, IN `p_id_empleado` INT)   BEGIN
    -- Asignar tarea a empleado
    INSERT INTO emp_tarea(id_empleado, id_tarea, fecha_asignacion)
    VALUES (p_id_empleado, p_id_tarea, NOW());
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `ConsultarEstadoProduccion` (IN `produccion_id` INT)   BEGIN
    SELECT p.pro_nombre, p.pro_fecha_inicio, p.pro_fecha_fin, e.eta_nombre AS estado_actual
    FROM produccion AS p
    JOIN etapas AS e ON p.pro_etapa = e.id_etapas
    WHERE p.id_produccion = produccion_id;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `ConsultarMateriasPrimasPorProduccion` (IN `produccion_id` INT)   BEGIN
    SELECT mp.mat_pri_nombre, SUM(mp.mat_pri_cantidad) AS total_usado
    FROM produccion AS p
    JOIN reg_pro_mat_prima AS pmp ON p.id_produccion = pmp.id_produccion
    JOIN materia_prima AS mp ON pmp.id_pro_materia_prima = mp.id_materia_prima
    WHERE p.id_produccion = pmp.id_produccion
    GROUP BY mp.mat_pri_nombre;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `ConsultarMateriasPrimasPorProveedor` (IN `proveedor_id` INT)   BEGIN
    SELECT u.usu_nombres, u.usu_email, 
           mp.mat_pri_nombre, mp.mat_pri_cantidad, mp.mat_pri_unidad_medida
    FROM materia_prima AS mp
    JOIN cargos_has_usuarios AS chu 
        ON mp.proveedores_id_proveedores = chu.usuarios_num_doc
    JOIN usuarios AS u 
        ON u.num_doc = chu.usuarios_num_doc
    JOIN cargos AS c 
        ON c.id_cargos = chu.cargos_id_cargos
    WHERE chu.cargos_id_cargos = 5;  -- Filtrar por el cargo con ID 5
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `ConsultarResumenProduccion` ()   BEGIN
    SELECT p.pro_nombre, p.pro_cantidad, p.pro_fecha_inicio, p.pro_fecha_fin, e.eta_nombre AS estado
    FROM produccion AS p
    JOIN etapas AS e ON p.pro_etapa = e.id_etapas;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `ConsultarTareasPorOperario` (IN `usuario_num_doc` INT)   BEGIN
    SELECT t.tar_nombre, et.emp_tar_fecha_asignacion, et.emp_tar_fecha_entrega
    FROM emp_tarea AS et
    JOIN tarea AS t ON et.tarea_id_tarea = t.id_tarea
    WHERE et.id_empleado_tarea = usuario_num_doc;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `ObtenerDatosSeguridad` (IN `numero_doc` INT, IN `tipo_doc` INT)   BEGIN
    -- Selecciona datos de la tabla 'seguridad' y descifra la columna 'seg_clave_hash'
    SELECT 
           u.num_doc, 
           u.t_doc, 
           u.usu_nombres,
           u.usu_apellidos,
           u.usu_estado, 
           u.usu_telefono,
           u.usu_email,
           s.seg_clave_hash,
           AES_DECRYPT(s.seg_clave_hash, 'BUZOSMT') AS clave_descifrada,
           c.cargos_id_cargos,
           car.car_nombre
    FROM usuarios AS u
    LEFT JOIN seguridad AS s ON u.num_doc = s.usu_num_doc
    LEFT JOIN cargos_has_usuarios AS c ON u.num_doc = c.usuarios_num_doc
    LEFT JOIN cargos AS car ON c.cargos_id_cargos = car.id_cargos  -- Corregido a car.id_cargos
    WHERE u.t_doc = tipo_doc  -- Aquí deberías sustituir 'tipo_doc' por el valor correspondiente o variable
      AND u.num_doc = numero_doc;  -- Aquí también sustituir 'numero_doc' por el valor correspondiente
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `registrar_produccion` (IN `p_id_produccion` INT, IN `p_id_materia_prima` INT)   BEGIN
    -- Restar cantidad de materia prima utilizada
    UPDATE reg_mat_prima
    SET cantidad_disponible = cantidad_disponible - p_cantidad_usada
    WHERE id_materia_prima = p_id_materia_prima;
    
    -- Registrar producción finalizada
    INSERT INTO produccion(id_produccion, fecha, cantidad_producida)
    VALUES (p_id_produccion, NOW(), p_cantidad_usada);
END$$

--
-- Funciones
--
CREATE DEFINER=`root`@`localhost` FUNCTION `calcular_dias` (`id` INT) RETURNS LONGTEXT CHARSET utf8mb4 COLLATE utf8mb4_general_ci  BEGIN
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

CREATE DEFINER=`root`@`localhost` FUNCTION `obtener_estado_produccion` (`p_id_produccion` INT) RETURNS VARCHAR(50) CHARSET utf8mb4 COLLATE utf8mb4_general_ci  BEGIN
    DECLARE v_estado VARCHAR(50);
    
    -- Obtener el estado actual de la producción
    SELECT produccion INTO v_estado
    FROM produccion
    WHERE id_produccion =id_produccion
    ORDER BY pro_etapa DESC
    LIMIT 1;
    
    RETURN v_estado;
END$$

DELIMITER ;

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
(1, 'Administrador Usuario'),
(2, 'Jefe Producción'),
(3, 'Operario'),
(4, 'Jefe Inventario'),
(5, 'Proveedor');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cargos_has_usuarios`
--

CREATE TABLE `cargos_has_usuarios` (
  `id_usuario_cargo` int(11) NOT NULL,
  `cargos_id_cargos` int(11) NOT NULL,
  `usuarios_num_doc` int(11) NOT NULL,
  `fecha_asignacion` datetime NOT NULL,
  `estado_asignacion` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Volcado de datos para la tabla `cargos_has_usuarios`
--

INSERT INTO `cargos_has_usuarios` (`id_usuario_cargo`, `cargos_id_cargos`, `usuarios_num_doc`, `fecha_asignacion`, `estado_asignacion`) VALUES
(7, 1, 6543254, '2024-09-15 19:55:51', 2),
(9, 4, 1022934571, '2024-09-16 16:11:01', 2),
(64, 5, 1022934571, '2024-09-19 07:15:36', 1),
(69, 3, 852258, '2024-09-20 14:12:46', 2),
(70, 1, 4869681, '2024-09-24 01:14:34', 1),
(71, 3, 6543254, '2024-09-23 18:55:34', 1),
(72, 3, 1022922370, '2024-09-30 06:53:07', 1),
(73, 2, 852258, '2024-09-30 06:55:15', 1),
(74, 2, 1140916757, '2024-09-30 06:59:27', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `emp_tarea`
--

CREATE TABLE `emp_tarea` (
  `id_empleado_tarea` int(11) NOT NULL COMMENT 'Identificador unico de la tabla puente Emp Tarea\n ',
  `empleados_num_doc` int(11) NOT NULL COMMENT 'Fk que esintermediario entre empleado y numero de documento',
  `tarea_id_tarea` int(11) NOT NULL COMMENT 'Fk que es intermediario entre tare y Id de la tarea',
  `emp_tar_fecha_asignacion` date NOT NULL COMMENT 'Atributo que identifica la fecha de asignacion ',
  `emp_tar_fecha_entrega` date NOT NULL COMMENT 'Atributo que identifica la fecha de entrega',
  `emp_tar_estado_tarea` int(11) NOT NULL COMMENT 'Atributo que identifica el estado de la tarea',
  `produccion_id_produccion` int(11) NOT NULL COMMENT 'fk que comunica com la tabla producción'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Volcado de datos para la tabla `emp_tarea`
--

INSERT INTO `emp_tarea` (`id_empleado_tarea`, `empleados_num_doc`, `tarea_id_tarea`, `emp_tar_fecha_asignacion`, `emp_tar_fecha_entrega`, `emp_tar_estado_tarea`, `produccion_id_produccion`) VALUES
(1, 852258, 5, '2024-09-23', '2024-09-30', 1, 1),
(2, 6543254, 6, '2024-10-01', '2024-10-08', 1, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `estados`
--

CREATE TABLE `estados` (
  `id_estados` int(11) NOT NULL,
  `nombre_estado` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Volcado de datos para la tabla `estados`
--

INSERT INTO `estados` (`id_estados`, `nombre_estado`) VALUES
(1, 'Activo'),
(2, 'Inactivo'),
(3, 'Iniciado'),
(4, 'En progreso'),
(5, 'Completado'),
(6, 'Pendiente'),
(7, 'Cancelado'),
(8, 'Revisado');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `etapas`
--

CREATE TABLE `etapas` (
  `id_etapas` int(11) NOT NULL COMMENT 'Identificador unico de la tabla etapas',
  `eta_nombre` varchar(45) NOT NULL COMMENT 'Atributo que identifca el nombre d el a etapa',
  `eta_descripcion` varchar(100) NOT NULL COMMENT 'Atributo que identifica la descripcion de la etapa'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Volcado de datos para la tabla `etapas`
--

INSERT INTO `etapas` (`id_etapas`, `eta_nombre`, `eta_descripcion`) VALUES
(1, 'Diseño', 'Etapa de diseño del producto'),
(2, 'Producción', 'Etapa de producción en fábrica'),
(3, 'Revisión', 'Etapa de revisión de calidad'),
(4, 'Empaque', 'Empaque de los productos terminados'),
(5, 'Envío', 'Productos enviados a los distribuidores'),
(6, 'Entrega', 'Entrega al cliente final');

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
  `mat_pri_estado` int(11) NOT NULL COMMENT 'Atributo que identifica el estado de la materia prima(Agotado, Existente,  Deshabilitado)',
  `fecha_compra_mp` date NOT NULL COMMENT 'Atributo que identifica la fecha de la compra de la materia prima\n',
  `proveedores_id_proveedores` int(11) NOT NULL COMMENT 'Fk que comunica con la tabla proveedores'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Volcado de datos para la tabla `materia_prima`
--

INSERT INTO `materia_prima` (`id_materia_prima`, `mat_pri_nombre`, `mat_pri_descripcion`, `mat_pri_unidad_medida`, `mat_pri_cantidad`, `mat_pri_estado`, `fecha_compra_mp`, `proveedores_id_proveedores`) VALUES
(1, 'Tela', 'Tela de algodón', 'metros', 100, 2, '2024-07-10', 1022934571),
(2, 'Hilo', 'Hilo de poliéster', 'rollos', 200, 2, '2024-07-12', 1022934571),
(3, 'Botones', 'Botones de plástico', 'cajas', 50, 2, '2024-07-15', 1022934571),
(4, 'Cremalleras', 'Cremalleras de metal', 'unidades', 150, 1, '2024-07-18', 1022934571),
(5, 'Cintas', 'Cintas elásticas', 'rollos', 300, 2, '2024-07-20', 1022934571),
(6, 'Corchetes', 'Corchetes de acero', 'cajas', 60, 3, '2024-07-22', 1022934571);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `motivos`
--

CREATE TABLE `motivos` (
  `id_motivo` int(11) NOT NULL,
  `categoria_motivo` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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

--
-- Volcado de datos para la tabla `produccion`
--

INSERT INTO `produccion` (`id_produccion`, `pro_nombre`, `pro_fecha_inicio`, `pro_fecha_fin`, `pro_cantidad`, `pro_etapa`) VALUES
(1, 'Buzos para Niños. Rojos', '2024-08-01 00:00:00', '2024-08-15 00:00:00', 500, 2),
(2, 'Buzos con Frases. Blancos', '2024-08-05 00:00:00', '2024-08-20 00:00:00', 300, 3),
(3, 'Buzos Negros sin Capota', '2024-08-07 00:00:00', '2024-08-25 00:00:00', 400, 4),
(4, 'Buzos B/N', '2024-08-10 00:00:00', '2024-08-30 00:00:00', 600, 5),
(5, 'Buzos de Algodòn', '2024-08-12 00:00:00', '2024-08-28 00:00:00', 250, 6),
(6, 'Buzos Azules', '2024-08-14 00:00:00', '2024-08-29 00:00:00', 150, 1);

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

--
-- Volcado de datos para la tabla `reg_pro_fabricados`
--

INSERT INTO `reg_pro_fabricados` (`id_reg_prod_fabricados`, `reg_pf_cantidad`, `reg_pf_fecha_registro`, `reg_pf_talla`, `reg_pf_color`, `reg_pf_material`, `reg_pf_tipo_prenda`, `produccion_id_produccion`) VALUES
(1, 200, '2024-09-01', 'M', 'Azul', 'Algodón', 'Camisa', 1),
(2, 150, '2024-09-02', 'L', 'Negro', 'Denim', 'Pantalón', 2),
(3, 100, '2024-09-03', 'S', 'Rojo', 'Cuero', 'Chaqueta', 3),
(4, 250, '2024-09-04', 'M', 'Blanco', 'Sintético', 'Zapatos', 4),
(5, 180, '2024-09-05', 'XL', 'Verde', 'Algodón', 'Sombrero', 5),
(6, 220, '2024-09-06', 'L', 'Gris', 'Lana', 'Bufanda', 6);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `reg_pro_mat_prima`
--

CREATE TABLE `reg_pro_mat_prima` (
  `id_registro` int(11) NOT NULL COMMENT 'Identificador unico de la tabla registro',
  `reg_pmp_cantidad_usada` int(11) NOT NULL COMMENT 'Atrubuto que identifica la cantidad de materia prima usada',
  `reg_pmp_fecha_registro` date NOT NULL COMMENT 'Atrubuto que identifica la la fecha de registro de la materia prima producida',
  `id_pro_materia_prima` int(11) NOT NULL,
  `id_produccion` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Volcado de datos para la tabla `reg_pro_mat_prima`
--

INSERT INTO `reg_pro_mat_prima` (`id_registro`, `reg_pmp_cantidad_usada`, `reg_pmp_fecha_registro`, `id_pro_materia_prima`, `id_produccion`) VALUES
(1, 50, '2024-09-01', 1, 1),
(2, 30, '2024-09-02', 2, 2),
(3, 40, '2024-09-03', 3, 3),
(4, 60, '2024-09-04', 4, 4),
(5, 35, '2024-09-05', 5, 5),
(6, 20, '2024-09-06', 6, 6);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `salida_productos`
--

CREATE TABLE `salida_productos` (
  `id_salida_productos` int(11) NOT NULL,
  `sal_pro_cantidad` int(11) NOT NULL,
  `sal_pro_motivo` varchar(400) NOT NULL,
  `sal_pro_fecha` datetime NOT NULL,
  `sal_pro_destino` varchar(45) NOT NULL,
  `id_reg_prod_fabricados` int(11) NOT NULL,
  `id_motivo` int(11) DEFAULT NULL,
  `id_usuario` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Volcado de datos para la tabla `salida_productos`
--

INSERT INTO `salida_productos` (`id_salida_productos`, `sal_pro_cantidad`, `sal_pro_motivo`, `sal_pro_fecha`, `sal_pro_destino`, `id_reg_prod_fabricados`, `id_motivo`, `id_usuario`) VALUES
(1, 150, 'Venta al por mayor', '2024-09-10 00:00:00', 'Distribuidor A', 1, NULL, NULL),
(2, 120, 'Venta directa', '2024-09-11 00:00:00', 'Tienda B', 2, NULL, NULL),
(3, 90, 'Envío a sucursal', '2024-09-12 00:00:00', 'Sucursal C', 3, NULL, NULL),
(4, 200, 'Donación', '2024-09-13 00:00:00', 'Organización D', 4, NULL, NULL),
(5, 180, 'Venta online', '2024-09-14 00:00:00', 'Cliente E', 5, NULL, NULL),
(6, 100, 'Transferencia interna', '2024-09-15 00:00:00', 'Almacén F', 6, NULL, NULL);

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
(9, 1022934571, 'l*¯l8³3æù»¢*o¶¥—!gs#«øx)øÔ±~÷Á›q¦F”I„Ê]“·!¾6±'),
(10, 6543254, '1èúÎ¾f™1<©ÚËe“¾[Y¡N,>õÅÖFƒ¿'),
(12, 852258, '1èúÎ¾f™1<©ÚËe“¾[Y¡N,>õÅÖFƒ¿'),
(13, 4869681, 'è¾Üá÷î/2ØêÄšÇÿ'),
(14, 1022922370, '“;ªN	¿:âC\0É\Z\Z™O0ézÞÃ	\\úrÍâf$'),
(15, 1140916757, 'XP^Y1lvb„õì‹'),
(16, 1022948788, 'è¾Üá÷î/2ØêÄšÇÿ');

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
  `tar_estado` int(11) NOT NULL COMMENT 'Atributo que identifica el estado de la tarea'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Volcado de datos para la tabla `tarea`
--

INSERT INTO `tarea` (`id_tarea`, `tar_nombre`, `tar_descripcion`, `tar_estado`) VALUES
(5, 'Cortar Moldes', 'El operario se encarga de cortar los moldes para la producción de los buzos.', 4),
(6, 'Armado Inicial', 'El operario se encarga de unir la parte posterior y anterior del buzo.', 4),
(7, 'Unión de mangas', 'El operario se encarga de coser las managas del buzo.', 4),
(8, 'Unir capota', 'El usuario se encarga de coser la capota al buzo.', 4);

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
(1, 'PPT'),
(2, 'Cedula de ciudadania'),
(3, 'Tarjeta de identidad');

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
  `usu_email` varchar(50) NOT NULL COMMENT 'Atributo que identifica el correo del Usuario',
  `usu_fecha_contratacion` date NOT NULL COMMENT 'Atributo que identifica el la fecha de contracion del Usuario',
  `usu_estado` int(11) NOT NULL COMMENT 'Atributo que identifica el estado del Usuario',
  `imag_perfil` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`num_doc`, `t_doc`, `usu_nombres`, `usu_apellidos`, `usu_fecha_nacimiento`, `usu_sexo`, `usu_direccion`, `usu_telefono`, `usu_email`, `usu_fecha_contratacion`, `usu_estado`, `imag_perfil`) VALUES
(852258, 2, 'Juana M', 'Maria', '2024-09-05', 'F', 'Bogotá', '12387932', 'tovar@gmail.com', '2024-09-03', 2, NULL),
(4869681, 1, 'Yonathan', 'Nieves', '2004-10-15', 'F', 'Bogotá', '12387932', 'yonathanieves17@gmail.com', '2024-09-03', 1, NULL),
(6543254, 1, 'Paula', 'Tovar', '2024-09-06', 'F', 'Bogotá', '12387932', 'ytrrgytrs17@gmail.com', '2024-09-03', 1, NULL),
(1022922370, 2, 'andres', 'ramirez', '2006-10-16', 'M', 'Bogotá', '213213123', 'ajskajs@qssaasa.com', '2024-10-03', 2, '123456789'),
(1022934571, 2, 'José', 'Guerrero', '2024-09-08', 'M', 'Bogotá', '324354281', 'multygems@gmail.com', '2024-09-03', 1, NULL),
(1022948788, 3, 'Harold Nicolas', 'Gomez Rojas', '2007-01-31', 'M', 'Bogotá', '3224481728', 'haroldgomez31del2007@hotmail.com', '2024-09-03', 1, NULL),
(1140916757, 2, 'Camilo', 'moreno', '2023-11-01', 'M', 'Bogotá', '3052446589', 'milo.moreno@gmail.com', '2024-09-03', 1, NULL);

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
  `usu_email` varchar(50) NOT NULL COMMENT 'Atributo que identifica el correo del Usuario',
  `usu_fecha_contratacion` date NOT NULL COMMENT 'Atributo que identifica el la fecha de contracion del Usuario',
  `usu_estado` int(11) NOT NULL COMMENT 'Atributo que identifica el estado del Usuario',
  `imag_perfil` varchar(45) NOT NULL,
  `operacion` varchar(15) DEFAULT NULL,
  `fecha_operacion` date DEFAULT NULL,
  `usuario_operacion` varchar(15) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Volcado de datos para la tabla `usuarios_espejo`
--

INSERT INTO `usuarios_espejo` (`num_doc`, `t_doc`, `usu_nombres`, `usu_apellidos`, `usu_fecha_nacimiento`, `usu_sexo`, `usu_direccion`, `usu_telefono`, `usu_email`, `usu_fecha_contratacion`, `usu_estado`, `imag_perfil`, `operacion`, `fecha_operacion`, `usuario_operacion`) VALUES
(321654, 1, 'mARIO', 'PLy', '2024-09-06', 'M', 'Muuu', '32164552', 'fgdfgfd@gmail.com', '2024-09-05', 1, '', 'delete', '2024-09-23', 'root@localhost'),
(852258, 1, 'Juana M', 'Maria', '2024-09-05', 'F', 'Bogotá', '12387932', 'tovar@gmail.com', '2024-09-03', 2, '', 'UPDATE', '2024-09-30', 'root@localhost'),
(4869681, 3, 'Yonathan', 'Nieves', '2004-10-15', 'F', 'Bogotá', '12387932', 'yonathanieves17@gmail.com', '2024-09-03', 1, '', 'insert', '2024-09-23', 'root@localhost'),
(6543254, 1, 'Paula', 'Tovar', '2024-09-06', 'F', 'Bogotá', '12387932', 'ytrrgytrs17@gmail.com', '2024-09-03', 1, '', 'insert', '2024-09-23', 'root@localhost'),
(1022922370, 2, 'andres', 'ramirez', '2006-10-16', 'M', 'Bogotá', '213213123', 'ajskajs@qssaasa.com', '2024-10-03', 2, '', 'UPDATE', '2024-10-05', 'root@localhost'),
(1022934571, 1, 'José', 'Guerrero', '2024-09-08', 'M', 'Bogotá', '324354281', 'multygems@gmail.com', '2024-09-03', 1, '', 'insert', '2024-09-23', 'root@localhost'),
(1022948788, 3, 'Harold Nicolas', 'Gomez Rojas', '2007-01-31', 'M', 'Bogotá', '3224481728', 'haroldgomez31del2007@hotmail.com', '2024-09-03', 1, '', 'insert', '2024-09-30', 'root@localhost'),
(1140916757, 2, 'Camilo', 'moreno', '2023-11-01', 'M', 'Bogotá', '3052446589', 'milo.moreno@gmail.com', '2024-09-03', 1, '', 'UPDATE', '2024-09-30', 'root@localhost');

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
  ADD KEY `fk_cargos_has_usuarios_cargos1_idx` (`cargos_id_cargos`),
  ADD KEY `fk_estado_idx` (`estado_asignacion`);

--
-- Indices de la tabla `emp_tarea`
--
ALTER TABLE `emp_tarea`
  ADD PRIMARY KEY (`id_empleado_tarea`),
  ADD KEY `fk_Empleados_has_Tarea_Tarea1_idx` (`tarea_id_tarea`),
  ADD KEY `fk_emp_tarea_produccion1_idx` (`produccion_id_produccion`),
  ADD KEY `fk_doc_empleado_idx` (`empleados_num_doc`),
  ADD KEY `emp_tar_estado_tarea` (`emp_tar_estado_tarea`);

--
-- Indices de la tabla `estados`
--
ALTER TABLE `estados`
  ADD PRIMARY KEY (`id_estados`);

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
  ADD KEY `fk_estado_idx` (`mat_pri_estado`);

--
-- Indices de la tabla `motivos`
--
ALTER TABLE `motivos`
  ADD PRIMARY KEY (`id_motivo`);

--
-- Indices de la tabla `produccion`
--
ALTER TABLE `produccion`
  ADD PRIMARY KEY (`id_produccion`),
  ADD KEY `fk_produccion_etapas1_idx` (`pro_etapa`);

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
  ADD KEY `fk_materiaPrima_idx` (`id_pro_materia_prima`),
  ADD KEY `fk_produccion_idx` (`id_produccion`);

--
-- Indices de la tabla `salida_productos`
--
ALTER TABLE `salida_productos`
  ADD PRIMARY KEY (`id_salida_productos`),
  ADD KEY `fk_salida_productos_reg_pro_fabricados1_idx` (`id_reg_prod_fabricados`),
  ADD KEY `fk_motivo` (`id_motivo`),
  ADD KEY `fk_usuario` (`id_usuario`);

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
  ADD PRIMARY KEY (`id_tarea`),
  ADD KEY `fk_estadoT` (`tar_estado`);

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
  ADD KEY `fk_TipoDoc_idx` (`t_doc`),
  ADD KEY `fk_estados_idx` (`usu_estado`);

--
-- Indices de la tabla `usuarios_espejo`
--
ALTER TABLE `usuarios_espejo`
  ADD PRIMARY KEY (`num_doc`),
  ADD KEY `fk_TipoDoc_idx` (`t_doc`),
  ADD KEY `fk_estados_idx` (`usu_estado`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `cargos`
--
ALTER TABLE `cargos`
  MODIFY `id_cargos` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Identificador unico de la tabla Rol', AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `cargos_has_usuarios`
--
ALTER TABLE `cargos_has_usuarios`
  MODIFY `id_usuario_cargo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=75;

--
-- AUTO_INCREMENT de la tabla `emp_tarea`
--
ALTER TABLE `emp_tarea`
  MODIFY `id_empleado_tarea` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Identificador unico de la tabla puente Emp Tarea\n ', AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `estados`
--
ALTER TABLE `estados`
  MODIFY `id_estados` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de la tabla `etapas`
--
ALTER TABLE `etapas`
  MODIFY `id_etapas` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Identificador unico de la tabla etapas', AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `materia_prima`
--
ALTER TABLE `materia_prima`
  MODIFY `id_materia_prima` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Identificador unico de la tabla materia prima', AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `motivos`
--
ALTER TABLE `motivos`
  MODIFY `id_motivo` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `produccion`
--
ALTER TABLE `produccion`
  MODIFY `id_produccion` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Identificador unico de la tabla produccion', AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `reg_pro_fabricados`
--
ALTER TABLE `reg_pro_fabricados`
  MODIFY `id_reg_prod_fabricados` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Identificador unico de la tabla registro de productos fabricados', AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `reg_pro_mat_prima`
--
ALTER TABLE `reg_pro_mat_prima`
  MODIFY `id_registro` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Identificador unico de la tabla registro', AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `seguridad`
--
ALTER TABLE `seguridad`
  MODIFY `id_seguridad` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Identificador unico de la tabla seguridad.', AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT de la tabla `tarea`
--
ALTER TABLE `tarea`
  MODIFY `id_tarea` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Identificador unico de la tabla Tarea', AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de la tabla `tipo_doc`
--
ALTER TABLE `tipo_doc`
  MODIFY `id_tipo_documento` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Identificador unico de la tabla tipo de documento', AUTO_INCREMENT=4;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `cargos_has_usuarios`
--
ALTER TABLE `cargos_has_usuarios`
  ADD CONSTRAINT `fk_cargos_has_usuarios_cargos1` FOREIGN KEY (`cargos_id_cargos`) REFERENCES `cargos` (`id_cargos`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_cargos_has_usuarios_usuarios1` FOREIGN KEY (`usuarios_num_doc`) REFERENCES `usuarios` (`num_doc`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_estadoCU` FOREIGN KEY (`estado_asignacion`) REFERENCES `estados` (`id_estados`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `emp_tarea`
--
ALTER TABLE `emp_tarea`
  ADD CONSTRAINT `fk_Empleados_has_Tarea_Tarea1` FOREIGN KEY (`tarea_id_tarea`) REFERENCES `tarea` (`id_tarea`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_doc_empleado` FOREIGN KEY (`empleados_num_doc`) REFERENCES `usuarios` (`num_doc`) ON DELETE NO ACTION ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_emp_tarea_produccion1` FOREIGN KEY (`produccion_id_produccion`) REFERENCES `produccion` (`id_produccion`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_estadoTarea` FOREIGN KEY (`emp_tar_estado_tarea`) REFERENCES `estados` (`id_estados`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `materia_prima`
--
ALTER TABLE `materia_prima`
  ADD CONSTRAINT `fk_estado` FOREIGN KEY (`mat_pri_estado`) REFERENCES `estados` (`id_estados`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_proveedor` FOREIGN KEY (`proveedores_id_proveedores`) REFERENCES `usuarios` (`num_doc`) ON DELETE NO ACTION ON UPDATE CASCADE;

--
-- Filtros para la tabla `produccion`
--
ALTER TABLE `produccion`
  ADD CONSTRAINT `fk_produccion_etapas1` FOREIGN KEY (`pro_etapa`) REFERENCES `etapas` (`id_etapas`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `reg_pro_fabricados`
--
ALTER TABLE `reg_pro_fabricados`
  ADD CONSTRAINT `fk_Registro_Productos_Fabricados_Producción1` FOREIGN KEY (`produccion_id_produccion`) REFERENCES `produccion` (`id_produccion`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `reg_pro_mat_prima`
--
ALTER TABLE `reg_pro_mat_prima`
  ADD CONSTRAINT `fk_materiaPrima` FOREIGN KEY (`id_pro_materia_prima`) REFERENCES `materia_prima` (`id_materia_prima`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_produccion` FOREIGN KEY (`id_produccion`) REFERENCES `produccion` (`id_produccion`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `salida_productos`
--
ALTER TABLE `salida_productos`
  ADD CONSTRAINT `fk_motivo` FOREIGN KEY (`id_motivo`) REFERENCES `motivos` (`id_motivo`),
  ADD CONSTRAINT `fk_salida_productos_reg_pro_fabricados1` FOREIGN KEY (`id_reg_prod_fabricados`) REFERENCES `reg_pro_fabricados` (`id_reg_prod_fabricados`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_usuario` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`num_doc`);

--
-- Filtros para la tabla `seguridad`
--
ALTER TABLE `seguridad`
  ADD CONSTRAINT `fk_seguridad_usuarios1` FOREIGN KEY (`usu_num_doc`) REFERENCES `usuarios` (`num_doc`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `tarea`
--
ALTER TABLE `tarea`
  ADD CONSTRAINT `fk_estadoT` FOREIGN KEY (`tar_estado`) REFERENCES `estados` (`id_estados`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD CONSTRAINT `fk_TipoDoc` FOREIGN KEY (`t_doc`) REFERENCES `tipo_doc` (`id_tipo_documento`) ON DELETE NO ACTION ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_estados` FOREIGN KEY (`usu_estado`) REFERENCES `estados` (`id_estados`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
