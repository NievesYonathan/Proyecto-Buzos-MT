<?php
include_once "../Modelo/EmpTarea.php";

class ControladorEmpTarea 
{
    public function tareasProduccion($id_produccion)
    {
        $objEmpTarea = new EmpTarea();
        $result = $objEmpTarea->tareasProduccion($id_produccion);
        return $result;
    }
}