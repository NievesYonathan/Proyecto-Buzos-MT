<?php

include_once "Conexion.php";
include_once "Seguridad.php";

class Usuarios {
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

    public function Usuarios ($numDoc = null,$tDoc = null,$usuNombres = null,$usuApellidos = null,$usuFechaNacimiento = null,$usuSexo = null,$usuDireccion = null,$usuTelefono = null,$usuEmail = null,$usuFechaContratacion = null,$usuEstado = null, $imagPerfil = null)
    {
        $this->numDoc = $numDoc;
        $this->tDoc =$tDoc;
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
    
    public function crearUsuario($numDoc = null,$tDoc = null,$usuNombres = null,$usuApellidos = null,$usuFechaNacimiento = null,$usuSexo = null,$usuTelefono = null,$usuFechaContratacion = null,$usuEmail = null,$clave = null)
    {
        $conexion = new Conexion();
        $conectar = $conexion->conectarse();

        $usuEstado = "Activo";
        $usuDireccion = "Bogotá";
        // $usuFechaContratacion = "2024-09-03";

        $sql = "INSERT INTO usuarios (num_doc,t_doc,usu_nombres,usu_apellidos,usu_fecha_nacimiento,usu_sexo,usu_direccion,usu_telefono,usu_email,usu_fecha_contratacion,usu_estado)
                VALUE (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
        ";

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

        $sql = "SELECT u.num_doc, u.t_doc, u.usu_estado, s.seg_clave_hash
                FROM usuarios AS u
                LEFT JOIN seguridad AS s ON u.num_doc = s.usu_num_doc
                WHERE u.t_doc = ? AND u.num_doc = ?
        ";

        $stmt = $conectar->prepare($sql);
        $stmt->bind_param("ii", $tDoc, $numDoc);
        $stmt->execute();
        $res = $stmt->get_result();
        $stmt->close();
        $conectar->close();

        $fila = $res->fetch_assoc();

        $hasClaveBD = $fila['seg_clave_hash'];

        $verificado = password_verify($clave, $hasClaveBD);

        if($verificado)
        {
            return $res;
        }
    }

    public function mostrarUsuarios()
    {
        $conexion = new Conexion();
        $conectar = $conexion->conectarse();

        $sql = "SELECT u.num_doc, u.t_doc, u.usu_nombres, u.usu_apellidos, u.usu_telefono, u.usu_email, u.usu_estado ,t.tip_doc_descripcion
                FROM usuarios AS u
                INNER JOIN tipo_doc AS t ON u.t_doc = t.id_tipo_documento";        
        $res = $conectar->query($sql);
        $conectar->close();
        return $res;
    }
}