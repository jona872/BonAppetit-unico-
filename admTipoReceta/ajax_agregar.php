<?php
/**
 * @version    1.0
 * @since      File available since Release 1.0
 * 
*/
// Se chequea si existe un login
require_once '../usuarios/aut_verifica.inc.php';
require_once '../ClasesBasicas/ConsultaBD.php';
	
/*verificamos si las variables se envian*/
if(empty($_POST['descripcion']) || empty($_POST['tiempo']) ){
        echo "Debe llenar todos los campos";
        exit;
}

$sql = "INSERT INTO `tipo_recetas` (`descripcion`,`tiempo_preparacion`,`pasa_cocina`,`usuario_id`) VALUES (";
$sql.= "'".strtoupper(utf8_decode($_POST['descripcion']))."', '".$_POST['tiempo']."','".$_POST['cocina']."', ".$_SESSION['usuario_id'].")";

$conexion = new ConsultaBD();
$conexion->Conectar();
mysql_query('BEGIN');

if($conexion->executeQuery($sql)) {   
    mysql_query('COMMIT');
} else { echo "Error al insertar el nuevo plato:\n$sql";
        mysql_query('ROLLBACK');
}

$conexion->Close();
exit;
?>