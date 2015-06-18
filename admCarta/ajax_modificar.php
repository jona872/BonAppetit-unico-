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
if(empty($_POST['id']) ||empty($_POST['codigo_receta']) || empty($_POST['descripcion']) || empty($_POST['precio']) || empty($_POST['tipo_receta'])){
        echo "Usted no a llenado todos los campos";
        exit;
}

$codigo_receta=$_POST['codigo_receta'];
$codigo_hidden=$_POST['codigo_hidden'];


if($codigo_receta!=$codigo_hidden ) 
{

$sql = "select * from receta_maestros where codigo='$codigo_receta'";
	 $conexion = new ConsultaBD();
	$conexion->Conectar();
	$conexion->executeQuery($sql);
	
	if($conexion->getNumRows() != 0)
	{	echo "El codigo ya esta registrado";
		exit;
	}

	else 
	{

	$sql2 ="UPDATE receta_maestros SET codigo='".strtoupper(utf8_decode($_POST['codigo_receta']))."', descripcion='".strtoupper(utf8_decode($_POST['descripcion']))."', precio='".$_POST['precio']."', tipo_receta_id='".$_POST['tipo_receta']."' where id=".$_POST['id'];



	if(!$conexion->executeQuery($sql2))
        echo "Error al insertar el plato:\n$sql";
	$conexion->Close();  

	exit;  
	}

}

else
{

/*modificar el registro*/
$sql3 ="UPDATE receta_maestros SET codigo='".strtoupper(utf8_decode($_POST['codigo_receta']))."', descripcion='".strtoupper(utf8_decode($_POST['descripcion']))."', precio='".$_POST['precio']."', tipo_receta_id='".$_POST['tipo_receta']."' where id=".$_POST['id'];

$conexion = new ConsultaBD();
$conexion->Conectar();

if(!$conexion->executeQuery($sql3))
        echo "Error al insertar el plato:\n$sql";
$conexion->Close();    

exit;
}
?>