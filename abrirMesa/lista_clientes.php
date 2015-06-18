<?php
// verificador de sesion
require_once '../usuarios/aut_verifica.inc.php';
require_once '../ClasesBasicas/ConsultaBD.php';

if(isset($_GET['getClienteByLetters']) && isset($_GET['letters'])){
	$letters = $_GET['letters'];
        $con = new ConsultaBD();
        $con->Conectar();        
	$letters = preg_replace("/[^a-z0-9 ]/si","",$letters);
	$sql = "select * from clientes ";
        $sql .=" where (descripcion like '%".$letters."%' or id like '%".$letters."%') AND ESTADO = 1 order by descripcion";
        $con->executeQuery($sql);
	while($inf = $con->getFetchArray()){
		$cod=$inf["id"] ;
		$nombre =htmlentities($inf["descripcion"]);
		echo $cod."###".$cod." - ".$nombre."|";
	}
        $con->Close();
}

?>
