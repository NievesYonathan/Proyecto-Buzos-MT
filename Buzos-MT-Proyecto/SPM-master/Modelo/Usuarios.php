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
    
    public function crearUsuario ($numDoc = null,$tDoc = null,$usuNombres = null,$usuApellidos = null,$usuFechaNacimiento = null,$usuSexo = null,$usuTelefono = null,$usuFechaContratacion = null,$usuEmail = null,$clave = null)
    {
        $conexion = new Conexion();
        $conetar = $conexion->conectarse();

        $usuEstado = "Activo";
        $usuDireccion = "Bogotá";
        // $usuFechaContratacion = "2024-09-03";

        $sql = "INSERT INTO usuarios (num_doc,t_doc,usu_nombres,usu_apellidos,usu_fecha_nacimiento,usu_sexo,usu_direccion,usu_telefono,usu_email,usu_fecha_contratacion,usu_estado)
                VALUE (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
        ";

        $stmt = $conetar->prepare($sql);
        $stmt->bind_param("iisssssssss", $numDoc, $tDoc, $usuNombres, $usuApellidos, $usuFechaNacimiento, $usuSexo, $usuDireccion, $usuTelefono, $usuEmail, $usuFechaContratacion, $usuEstado);
        $stmt->execute();
        $stmt->close();
        $conetar->close();

        $seguridad = new Seguridad();
        $seguridad->addClaveUsuario($numDoc, $clave);
    }
}