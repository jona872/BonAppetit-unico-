<?php
require_once '../ClasesBasicas/ConsultaBD.php';
$descripcion = $_GET['descripcion'];
$sql = "select * from receta_maestros where descripcion='$descripcion'";
 $conexion = new ConsultaBD();
$conexion->Conectar();
$conexion->executeQuery($sql);
if($conexion->getNumRows() == 0)
        echo "true";
else
        echo "false";
?>