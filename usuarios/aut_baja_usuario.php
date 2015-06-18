<?php
include_once 'aut_verifica.inc.php';
include_once '../ClasesBasicas/ConsultaBD.php';
$id = $_POST['ident'];

$con = new ConsultaBD();
$con->Conectar();
$sql = "DELETE FROM usuarios where id = '$id'";

if ($con->executeQuery($sql)) {
   $con->Close();
   echo '<meta http-equiv="refresh" content="0; url=aut_listar.php">';
} else {
   $con->Close();   
   echo '<meta http-equiv="refresh" content="0; url=aut_listar.php">';
}
?>