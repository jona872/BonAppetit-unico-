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
if(empty($_POST['descripcion']) || empty($_POST['precio']) || empty($_POST['tipo_receta'])){
        echo "Debe llenar todos los campos";
        exit;
}

if(isset($_POST['codigo_receta']))
{
$sql = "INSERT INTO `receta_maestros` (`codigo`,`descripcion`,`precio`,`tipo_receta_id`,`usuario_id`) VALUES (";
$sql.= "'".strtoupper(utf8_decode($_POST['codigo_receta']))."', '".strtoupper(utf8_decode($_POST['descripcion']))."', '".$_POST['precio']."', ".$_POST['tipo_receta'].", ".$_SESSION['usuario_id'].")";
}
else
{
$sql = "INSERT INTO `receta_maestros` (`descripcion`,`precio`,`tipo_receta_id`,`usuario_id`) VALUES (";
$sql.= "'".strtoupper(utf8_decode($_POST['descripcion']))."', '".$_POST['precio']."', ".$_POST['tipo_receta'].", ".$_SESSION['usuario_id'].")";
}

$conexion = new ConsultaBD();
$conexion->Conectar();
mysql_query('BEGIN');

if($conexion->executeQuery($sql)) {

    if(empty($_POST['codigo_receta']))
    {
    //NO ES NECESARIO, YA QUE EL CODIGO DEL PLATO (codigo_receta) LO TRAEMOS DEL FORMULARIO
    $id_ult = $conexion->ultimoId();
    $sql2 = "UPDATE `receta_maestros` SET `codigo`=".$id_ult." WHERE id = ".$id_ult;
    
    $conexion->executeQuery($sql2);
    
     mysql_query('COMMIT');    
    }else{
    
    mysql_query('COMMIT'); 

    }
    }
     else   
    { echo "Error al insertar el nuevo plato:\n$sql";
    
    mysql_query('ROLLBACK');
    }

$conexion->Close();
exit;
?>