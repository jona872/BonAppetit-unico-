<?php
// verificador de sesion
require_once '../usuarios/aut_verifica.inc.php';
require_once '../ClasesBasicas/ConsultaBD.php';

if(isset($_GET['getEmpleadoByLetters']) && isset($_GET['letters'])){
	$letters = $_GET['letters'];
        $con = new ConsultaBD();
        $con->Conectar();        
	$letters = preg_replace("/[^a-z0-9 ]/si","",$letters);
	$sql = "select * from empleados ";
        $sql .=" where tipo_empleado_id = 1 and  (descripcion like '%".$letters."%' or id like '%".$letters."%') AND fecha_baja is null  order by descripcion";
        $con->executeQuery($sql);
	while($inf = $con->getFetchArray()){
		$cod=$inf["id"] ;
		$nombre =htmlentities($inf["descripcion"]);
		echo $cod."###".$cod." - ".$nombre."|";
	}
        $con->Close();
}

?>
