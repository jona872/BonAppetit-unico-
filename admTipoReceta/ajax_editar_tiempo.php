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
$sql="UPDATE `tipo_recetas` SET `".$campo."`='".$p."'";
$sql.=" WHERE id='".$id."'";
$conexion->executeQuery($sql);
$conexion->Close();

?><script language="javascript" type="text/javascript">
    $(document).ready(function(){
            fn_buscar();
    });
</script>