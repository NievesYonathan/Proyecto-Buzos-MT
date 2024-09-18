<?php
include_once "../Modelo/CargosUsuarios.php";

class ControladorCarUsu
{

    // public function asociarCarUsu()
    // {
    //     //ID's de cargos ya asociados al usuario
    //     $idCarUsuarioExis = $_POST['idCarUsuario'];
    //     //ID's seleccionados
    //     $idCargoSelec = $_POST['idCargo'];

    //     $idUsuario = $_POST['numDoc'];

    //     date_default_timezone_set('America/Bogota');
    //     $fechaAsignacion = date('Y-m-d H:i:s');

    //     $estado = "Activo";

    //     $objCarUsu = new CargosUsuarios();
    //     //Usar 'array_diff' para obtener array resultante con los nuevo ID's
    //     $new_cargo = array_diff($idCargoSelec, $idCarUsuarioExis);
    //     foreach ($new_cargo as $idCargo) {
    //         $objCarUsu->addRelaUsuarioCargo($idCargo, $idUsuario, $fechaAsignacion, $estado);
    //     }

    //     header("Location: ../Perfil-Admin-Usuarios/user-list-cargo.php");
    //     exit();
    // }

    // public function desactivarCargo()
    // {
    //     $idUsuario = $_POST['numDoc'];

    //     $objCarUsu = new CargosUsuarios();
    //     $res = $objCarUsu->selectCarUsuarioDoc($idUsuario);
    //     //ID's de la BD
    //     $idCarUsuBD = [];
    //     while ($filaC = $res->fetch_assoc()){
    //         $idCarUsuBD[] = $filaC;
    //     }

    //     //ID's seleccionados
    //     $idCarSeleccionado = $_POST['idCarUsuRel'];


    //     if (count($idCarUsuBD) != $idCarSeleccionado){
    //         $cargosDesac = array_diff($idCarUsuBD, $idCarSeleccionado);
    //         $objCarUsu = new CargosUsuarios();
    //         $objCarUsu->desactivarCargo($cargosDesac);    
    //     }
    // }

    public function consultarCarUsuarios()
    {
        $objCarUsu = new CargosUsuarios();
        $res = $objCarUsu->selectCarUsuario();
        return $res;
    }

    public function gestionarCargosUsuario()
    {
        // ID's de cargos ya asociados al usuario (del formulario)
        $idCarUsuarioExis = isset($_POST['idCarUsuario']) ? $_POST['idCarUsuario'] : [];
        // ID's seleccionados (del formulario)
        $idCargoSelec = isset($_POST['idCargo']) ? $_POST['idCargo'] : [];
        $idUsuario = $_POST['numDoc'];

        $objCarUsu = new CargosUsuarios();

        // Obtener los cargos actualmente asociados al usuario desde la base de datos
        $objCarUsu = new CargosUsuarios();
        $res = $objCarUsu->selectCarUsuarioDoc($idUsuario);
        //ID's de la BD
        $cargosActualesBD = [];
        while ($filaC = $res->fetch_assoc()){
            $cargosActualesBD[] = $filaC;
        }

        // Determinar los nuevos cargos (marcados en el formulario pero que no estaban previamente asociados)
        $nuevosCargos = array_diff($idCargoSelec, $idCarUsuarioExis);

        // Determinar los cargos desmarcados (que estaban asociados y ahora no están seleccionados)
        $cargosDesactivar = array_diff($cargosActualesBD, $idCargoSelec);

        // **Asociar nuevos cargos**
        if (!empty($nuevosCargos)) {
            date_default_timezone_set('America/Bogota');
            $fechaAsignacion = date('Y-m-d H:i:s');
            $estado = "Activo";

            foreach ($nuevosCargos as $idCargo) {
                // Evitar duplicados asegurándote de que solo agregas cargos nuevos
                if (!in_array($idCargo, $cargosActualesBD)) {
                    $objCarUsu->addRelaUsuarioCargo($idCargo, $idUsuario, $fechaAsignacion, $estado);
                }
            }
        }

        // **Desactivar cargos desmarcados**
        if (!empty($cargosDesactivar)) {
            foreach ($cargosDesactivar as $idCargoDesactivar) {
                $objCarUsu->desactivarCargo($idCargoDesactivar, $idUsuario);
            }
        }

        // Redirigir al final del proceso
        header("Location: ../Perfil-Admin-Usuarios/user-list-cargo.php");
        exit();
    }

}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $controlador = new ControladorCarUsu();
    $controlador->gestionarCargosUsuario();
}
