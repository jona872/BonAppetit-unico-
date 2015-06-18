<?php
/**
 * @version    1.0
 * @since      File available since Release 1.0
 * 
*/
// Se chequea si existe un login
require_once '../usuarios/aut_verifica.inc.php';
require_once '../ClasesBasicas/ConsultaBD.php';

$data  = explode("-",$_POST['id']);

$campo = $data[0];
$id    = $data[1]; // id del registro
$p = $_POST['value']; // valor por el cual reemplazar

$conexion = new ConsultaBD();
$conexion->Conectar();

mysql_query('BEGIN');
if($p==9) {
    $sql_m = "SELECT factura_maestro_id FROM pedido_maestros WHERE id=$id";    
    $conexion->executeQuery($sql_m);
    $row_id = $conexion->getFetchRow();    
    
    $sql_elim1 = "DELETE FROM factura_detalles where factura_maestro_id=".$row_id[0];
    $conexion->executeQuery($sql_elim1);
    
    $sql_elim2 = "DELETE FROM factura_maestros where id=".$row_id[0];
    $conexion->executeQuery($sql_elim2);
        
    $sql_det = "SELECT * FROM pedido_detalles WHERE pedido_maestro_id=$id";
    $conexion->executeQuery($sql_det);
    if($conexion->getNumRows()==0) {
        $sql="UPDATE `pedido_maestros` SET `".$campo."`='0', factura_maestro_id=null, timestamp_finalizado=NULL";
        $sql.=" WHERE id='".$id."'";
        $conexion->executeQuery($sql);
    } else {
        $sql="UPDATE `pedido_maestros` SET `".$campo."`='9', factura_maestro_id=null, timestamp_finalizado=NULL";
        $sql.=" WHERE id='".$id."'";
        $conexion->executeQuery($sql);
    }
} else {
    $sql="UPDATE `pedido_maestros` SET `".$campo."`='".$p."'";
    $sql.=" WHERE id='".$id."'";
    $conexion->executeQuery($sql);
    
}
if($conexion->getResults()<>false) {
    mysql_query('COMMIT');
} else {
    mysql_query('ROLLBACK');
}
$conexion->Close();
?><script language="javascript" type="text/javascript">
	$(document).ready(function(){
		fn_buscar();
	});
</script>