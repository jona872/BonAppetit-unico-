




<?php
require_once '../ClasesBasicas/ConsultaBD.php';

$codigo_receta = utf8_decode($_GET['codigo_receta']);


if(empty($codigo_receta)) echo "true";
else
{
	$sql = "select * from receta_maestros where codigo='$codigo_receta'";
	 $conexion = new ConsultaBD();
	$conexion->Conectar();
	$conexion->executeQuery($sql);
	
	if($conexion->getNumRows() == 0)
		echo "true";
	else 
		echo "false";
}
	
?>