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

    public function crearUsuario($numDoc = null, $tDoc = null, $usuNombres = null, $usuApellidos = null, $usuFechaNacimiento = null, $usuSexo = null, $usuTelefono = null, $usuFechaContratacion = null, $usuEmail = null, $clave = null)
    {
        $conexion = new Conexion();
        $conectar = $conexion->conectarse();

        $usuEstado = "Activo";
        $usuDireccion = "Bogotá";
        // $usuFechaContratacion = "2024-09-03";

        $sql = "INSERT INTO usuarios (num_doc,t_doc,usu_nombres,usu_apellidos,usu_fecha_nacimiento,usu_sexo,usu_direccion,usu_telefono,usu_email,usu_fecha_contratacion,usu_estado)
                VALUE (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

        $stmt = $conectar->prepare($sql);
        $stmt->bind_param("iisssssssss", $numDoc, $tDoc, $usuNombres, $usuApellidos, $usuFechaNacimiento, $usuSexo, $usuDireccion, $usuTelefono, $usuEmail, $usuFechaContratacion, $usuEstado);
        $stmt->execute();
        $stmt->close();
        $conectar->close();

        $seguridad = new Seguridad();
        $seguridad->addClaveUsuario($numDoc, $clave);
    }


    public function iniciarSesion($numDoc = null, $tDoc = null, $clave = null)
    {
        $conexion = new Conexion();
        $conectar = $conexion->conectarse();

        $stmt = $conectar->prepare("CALL ObtenerDatosSeguridad(?, ?)");
        $stmt->bind_param("is", $numDoc, $tDoc);
        $stmt->execute();
        $res = $stmt->get_result();
        $stmt->close();
        $conectar->close();

        $fila = $res->fetch_assoc();

        $descifrada = $fila['clave_descifrada'];

        $numDoc = $fila['num_doc'];
        $cargo = $fila['car_nombre'];
        $nombre = $fila['usu_nombres'];

        $_SESSION['user_id'] = $numDoc; // Almacenar ID de usuario en la sesión
        $_SESSION['user_cargo'] = $cargo;
        $_SESSION['user_nombre'] = $nombre;


        if ($descifrada == $clave) {
            return $res;
        }
    }

    public function mostrarUsuarios()
    {
        $conexion = new Conexion();
        $conectar = $conexion->conectarse();

        // $sql = "SELECT u.num_doc, u.t_doc, u.usu_nombres, u.usu_apellidos, u.usu_fecha_nacimiento, u.usu_sexo, u.usu_direccion, u.usu_telefono, u.usu_email, u.usu_fecha_contratacion, u.usu_estado ,t.tip_doc_descripcion
        //         FROM usuarios AS u
        //         INNER JOIN tipo_doc AS t ON u.t_doc = t.id_tipo_documento";

        $sql = "SELECT td.tip_doc_descripcion, u.num_doc, u.usu_nombres, u.usu_apellidos, cu.cargos_id_cargos, GROUP_CONCAT(c.car_nombre SEPARATOR ', ') AS Cargos
                FROM usuarios as u
                INNER JOIN tipo_doc AS td ON u.t_doc = td.id_tipo_documento
                LEFT JOIN cargos_has_usuarios AS cu ON u.num_doc = cu.usuarios_num_doc
                LEFT JOIN cargos AS c ON cu.cargos_id_cargos = c.id_cargos
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

public function eliminarUsuario($num_doc) {
    $conexion = new Conexion();
    $conectar = $conexion->conectarse();
    
    // Consulta para eliminar o actualizar el estado del usuario
    $sql = "UPDATE usuarios SET usu_estado = 'Inactivo' WHERE num_doc = ?";
    
    $stmt = $conectar->prepare($sql);
    $stmt->bind_param("i", $num_doc);
    $resultado = $stmt->execute();
    
    $stmt->close();
    $conectar->close();
    
    return $resultado;
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

