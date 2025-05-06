<?php

include_once "Conexion.php";
include_once "Seguridad.php";

class Usuarios
{
    private $numDoc;
    private $tDoc;
    private $usuNombres;
    private $usuApellidos;
    private $usuFechaNacimiento;
    private $usuSexo;
    private $usuDireccion;
    private $usuTelefono;
    private $usuEmail;
    private $usuFechaContratacion;
    private $usuEstado;
    private $imagPerfil;

    
    public function Usuarios($numDoc = null, $tDoc = null, $usuNombres = null, $usuApellidos = null, $usuFechaNacimiento = null, $usuSexo = null, $usuDireccion = null, $usuTelefono = null, $usuEmail = null, $usuFechaContratacion = null, $usuEstado = null, $imagPerfil = null)
    {
        $this->numDoc = $numDoc;
        $this->tDoc = $tDoc;
        $this->usuNombres = $usuNombres;
        $this->usuApellidos = $usuApellidos;
        $this->usuFechaNacimiento = $usuFechaNacimiento;
        $this->usuSexo = $usuSexo;
        $this->usuDireccion = $usuDireccion;
        $this->usuTelefono = $usuTelefono;
        $this->usuEmail = $usuEmail;
        $this->usuFechaContratacion = $$usuFechaContratacion;
        $this->usuEstado = $usuEstado;
        $this->imagPerfil = $imagPerfil;
    }

    public function crearUsuario($numDoc = null, $tDoc = null, $usuNombres = null, $usuApellidos = null, $usuFechaNacimiento = null, $usuSexo = null, $usuTelefono = null, $usuFechaContratacion = null, $usuEmail = null, $clave = null, $img = null)
    {
        $conexion = new Conexion();
        $conectar = $conexion->conectarse();

        $usuEstado = 1;
        $usuDireccion = "Bogotá";
        // $usuFechaContratacion = "2024-09-03";

        $sql = "INSERT INTO usuarios (num_doc,t_doc,usu_nombres,usu_apellidos,usu_fecha_nacimiento,usu_sexo,usu_direccion,usu_telefono,usu_email,usu_fecha_contratacion,usu_estado, imag_perfil)
                VALUE (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

        $stmt = $conectar->prepare($sql);
        $stmt->bind_param("iissssssssis", $numDoc, $tDoc, $usuNombres, $usuApellidos, $usuFechaNacimiento, $usuSexo, $usuDireccion, $usuTelefono, $usuEmail, $usuFechaContratacion, $usuEstado, $img);
        $stmt->execute();
        $stmt->close();
        $conectar->close();

        $seguridad = new Seguridad();
        $seguridad->addClaveUsuario($numDoc, $clave);
    }

    public function crearUsuarioGmail($numDoc = null, $tDoc = null, $usuNombres = null, $usuApellidos = null, $usuFechaNacimiento = null, $usuSexo = null, $usuTelefono = null, $usuFechaContratacion = null, $usuEmail = null, $img = null)
    {
        $conexion = new Conexion();
        $conectar = $conexion->conectarse();

        $usuEstado = 1;
        $registroEmail = 1;
        $usuDireccion = "Bogotá";
        // $usuFechaContratacion = "2024-09-03";

        $sql = "INSERT INTO usuarios (num_doc,t_doc,usu_nombres,usu_apellidos,usu_fecha_nacimiento,usu_sexo,usu_direccion,usu_telefono,usu_email,usu_fecha_contratacion,usu_estado, imag_perfil, registro_gmail)
                VALUE (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

        $stmt = $conectar->prepare($sql);
        $stmt->bind_param("iissssssssisi", $numDoc, $tDoc, $usuNombres, $usuApellidos, $usuFechaNacimiento, $usuSexo, $usuDireccion, $usuTelefono, $usuEmail, $usuFechaContratacion, $usuEstado, $img, $registroEmail);
        $stmt->execute();
        $stmt->close();
        $conectar->close();

    }


    public function iniciarSesion($numDoc = null, $tDoc = null, $clave = null)
    {
        $conexion = new Conexion();
        $conectar = $conexion->conectarse();

        $stmt = $conectar->prepare("CALL ObtenerDatosSeguridad(?, ?)");
        $stmt->bind_param("ii", $numDoc, $tDoc);
        $stmt->execute();
        $res = $stmt->get_result();
        $stmt->close();
        $conectar->close();

        if ($res && $res->num_rows > 0) {
            $fila = $res->fetch_assoc();
            //var_dump($fila);

            $descifrada = $fila['clave_descifrada'];

            if ($descifrada === $clave) {
                $_SESSION['user_id'] = $fila['num_doc'];
                $_SESSION['user_cargo'] = $fila['car_nombre'];
                $_SESSION['user_nombre'] = $fila['usu_nombres'];

                return $res;
            } else {
                return false;
            }
        }
    }

    public function iniciarSesionGmail($gmail = null)
    {
        $conexion = new Conexion();
        $conectar = $conexion->conectarse();

        $stmt = $conectar->prepare("CALL ObtenerDatosSeguridadGmail(?)");
        $stmt->bind_param("s", $gmail);
        $stmt->execute();
        $res = $stmt->get_result();
        $stmt->close();
        $conectar->close();

        if ($res && $res->num_rows > 0) {
            $fila = $res->fetch_assoc();
            $_SESSION['user_id'] = $fila['num_doc'];
            $_SESSION['user_cargo'] = $fila['car_nombre'];
            $_SESSION['user_nombre'] = $fila['usu_nombres'];

            return $res;
        }
    }

    public function mostrarUsuarios()
    {
        $conexion = new Conexion();
        $conectar = $conexion->conectarse();

        // Agregamos la unión con la tabla estado para obtener el nombre del estado
        $sql = "SELECT td.tip_doc_descripcion, u.*, cu.id_usuario_cargo, 
                GROUP_CONCAT(cu.cargos_id_cargos SEPARATOR ', ') AS id_cargos, 
                GROUP_CONCAT(cu.estado_asignacion SEPARATOR ', ') AS estadoCargo, 
                GROUP_CONCAT(c.car_nombre SEPARATOR ', ') AS Cargos,
                e.nombre_estado AS estado_usuario
            FROM usuarios AS u
            INNER JOIN tipo_doc AS td ON u.t_doc = td.id_tipo_documento
            LEFT JOIN cargos_has_usuarios AS cu ON u.num_doc = cu.usuarios_num_doc AND cu.estado_asignacion = 1
            LEFT JOIN cargos AS c ON cu.cargos_id_cargos = c.id_cargos
            LEFT JOIN estados AS e ON u.usu_estado = e.id_estados   
            GROUP BY u.num_doc";

        $res = $conectar->query($sql);


        $conectar->close();
        return $res;
    }

    public function obtenerUsuarioPornumDoc($numDoc)
    {
        $conexion = new Conexion();
        $conectar = $conexion->conectarse();

        $sql = "SELECT * FROM usuarios WHERE num_doc = ?";
        $stmt = $this->$conectar->prepare($sql);
        $stmt->bind_param("i", $numDoc);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc();
    }

    public function obtenerUsuarioPorGmail($gmail)
    {
        $conexion = new Conexion();
        $conectar = $conexion->conectarse();

        $sql = "SELECT * FROM usuarios WHERE usu_email = ?";
        $stmt = $conectar->prepare($sql);
        $stmt->bind_param("s", $gmail);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result;
    }

    public function obtenerUsuarioOperario()
    {
        $conexion = new Conexion();
        $conectar = $conexion->conectarse();

        $sql = "SELECT * FROM usuarios AS u
                LEFT JOIN cargos_has_usuarios AS cu ON cu.usuarios_num_doc = u.num_doc 
                WHERE cargos_id_cargos = 3";
        $res = $conectar->query($sql);
        $conectar->close();
        return $res;
    }

    public function actualizarUsuario($tipo_documento, $numDoc, $nombre, $apellido, $fechaNacimiento, $sexo, $direccion, $telefono, $email, $fecha_contratacion, $estado, $clave)
    {
        $conexion = new Conexion();
        $conectar = $conexion->conectarse();

        $sql = "UPDATE usuarios SET t_doc=?, usu_nombres=?, usu_apellidos=?, usu_fecha_nacimiento=?, usu_sexo=?, usu_direccion=?, usu_telefono=?, usu_email=?, usu_fecha_contratacion=?, usu_estado=? WHERE num_doc=?";

        $stmt = $conectar->prepare($sql);

        if (!$stmt) {
            error_log("Error en la preparación de la consulta: " . $conectar->error);
            return false;
        }

        $stmt->bind_param("sssssssssss", $tipo_documento, $nombre, $apellido, $fechaNacimiento, $sexo, $direccion, $telefono, $email, $fecha_contratacion, $estado, $numDoc);

        $result = $stmt->execute();
        if (!$result) {
            error_log("Error al ejecutar la consulta: " . $stmt->error);
            $stmt->close();
            $conectar->close();
            return false;
        }

        $rowsAffected = $stmt->affected_rows;
        $stmt->close();

        if ($clave) {
            $seguridad = new Seguridad();
            $claveActualizada = $seguridad->addClaveUsuario($numDoc, $clave);
            if (!$claveActualizada) {
                error_log("Error al actualizar la clave del usuario");
            }
        }

        $conectar->close();

        return $rowsAffected > 0 || $claveActualizada;
    }

    public function eliminarUsuario($num_doc)
    {
        $conexion = new Conexion();
        $conectar = $conexion->conectarse();

        // Consulta para eliminar o actualizar el estado del usuario
        $sql = "UPDATE usuarios SET usu_estado = 2 WHERE num_doc = ?";

        $stmt = $conectar->prepare($sql);
        $stmt->bind_param("i", $num_doc);
        $resultado = $stmt->execute();

        $stmt->close();
        $conectar->close();

        return $resultado;
    }
    public function buscarUsuario($search) {
    $conexion = new Conexion(); // Asegúrate de que tu conexión esté establecida correctamente
    $conectar = $conexion->conectarse();
    $sql = "
        SELECT u.num_doc, u.t_doc, u.usu_nombres, u.usu_apellidos, u.usu_fecha_nacimiento, u.usu_sexo, u.usu_direccion, u.usu_telefono, u.usu_email, u.usu_fecha_contratacion, e.nombre_estado AS estado_nombre
FROM 
    usuarios u
JOIN 
    estados e ON u.usu_estado = e.id_estados
WHERE 
    u.usu_nombres LIKE '%$search%' 
    OR u.usu_apellidos LIKE '%$search%' 
    OR u.num_doc LIKE '%$search%'
    ";

    // Agrega esta línea para depurar
    echo $search; // Muestra la consulta que se está ejecutando

    $result = mysqli_query($conectar, $sql);
    $conectar->close();
    return $result;
}

    
    

    public function mostrarProveedor()
    {
        $conexion = new Conexion();
        $conectar = $conexion->conectarse();

        // Consulta SQL para obtener los usuarios cuyo cargo es proveedor
        $sql = "SELECT u.num_doc, u.t_doc, u.usu_nombres, u.usu_apellidos, u.usu_direccion, u.usu_telefono, u.usu_email, u.usu_fecha_contratacion, 
                       u.usu_estado,
                e.nombre_estado AS estado_usuario
                FROM usuarios AS u
                INNER JOIN tipo_doc AS t ON u.t_doc = t.id_tipo_documento
                INNER JOIN cargos_has_usuarios AS cu ON u.num_doc = cu.usuarios_num_doc
                INNER JOIN cargos AS c ON cu.cargos_id_cargos = c.id_cargos
                LEFT JOIN estados AS e ON u.usu_estado = e.id_estados
                WHERE c.car_nombre = 'proveedor'";

        $res = $conectar->query($sql);
        $conectar->close();

        return $res;
    }
}

class Proveedor
{
    public function mostrarProveedor()
    {
        $conexion = new Conexion();
        $conectar = $conexion->conectarse();

        // Consulta SQL para obtener los usuarios cuyo cargo es proveedor
        $sql = "SELECT u.num_doc, u.t_doc, u.usu_nombres, u.usu_apellidos, u.usu_direccion, u.usu_telefono, u.usu_email, u.usu_fecha_contratacion, 
                      u.usu_estado
                 FROM usuarios AS u
                 INNER JOIN tipo_doc AS t ON u.t_doc = t.id_tipo_documento
                 INNER JOIN cargos_has_usuarios AS cu ON u.num_doc = cu.usuarios_num_doc
                 INNER JOIN cargos AS c ON cu.cargos_id_cargos = c.id_cargos
                 WHERE c.car_nombre = 'proveedor'";
        $res = $conectar->query($sql);
        $conectar->close();
        return $res;
    }
}
