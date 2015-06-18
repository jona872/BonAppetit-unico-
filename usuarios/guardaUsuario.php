<?php
include_once 'aut_verifica.inc.php';
include_once '../ClasesBasicas/ConsultaBD.php';
// Se requieren los script para acceder a los datos de la DB
require_once '../ClasesBasicas/ActiveRecordAbstractFactory.php';

$oMysql = ActiveRecordAbstractFactory::getActiveRecordFactory(ActiveRecordAbstractFactory::MYSQL);
$oMysql->conectar();  

$empleado_id = $_POST['empleado_id'];
$usuario = $_POST['identif'];
$pass1 = $_POST['passw1'];
$pass2 = $_POST['passw2'];
$nivel= $_POST['nivel'];

$usuAlta =  $_SESSION['usuario_id'];

if ($nivel=="") {
   $baja = date('Y-m-d');
} else {
   $baja = '0000-00-00 00:00:00';
}
echo "<br/>";
if (($pass1 == "") || ($pass2 == "") || ($usuario == "") || ($empleado_id == "")) {
 //  echo "<div class=falta_dato><b>Debe completar todos los campos para poder crear un usuario.</b></div>";    
} else {
   if ($pass1 != $pass2) {
      echo "<div class=falta_dato><b>Las Contraseñas No Coinciden</b></div>";
   } else {
      $con = new ConsultaBD();
      $con->Conectar();      
      $sql="SELECT id FROM usuarios WHERE identificacion='$usuario'";      
      $con->executeQuery($sql);
      $con->Close();
      $total_encontrados = 0;
      $total_encontrados = $con->getNumRows();      
      if ($total_encontrados !=  0) {
         echo "<b><br/>La identificaci&oacute;n del usuario ya est&aacute; registrada<br/></b>";
      } else {
         $usuario=stripslashes($usuario);
         $pass1 = md5($pass1);
         $con = new ConsultaBD();
         $con->Conectar();  
         $con->executeQuery("begin");        
         $sql1="SELECT nombre, apellido FROM empleados WHERE id='$empleado_id'";      
         $con->executeQuery($sql1);
         $row = $con->getFetchObject();
         $sql = "INSERT INTO usuarios (nombre, apellido, identificacion, clave, permiso, usuario_alta, fecha_baja, empleado_id) ";
         $sql .= "VALUES('".$row->nombre."','".$row->apellido."','$usuario','$pass1','$nivel',$usuAlta, '$baja', $empleado_id)";                              
         if ($con->executeQuery($sql)) {
             $con->executeQuery("commit");
            $con->Close();
            echo "<center><div class=exito><b>Datos Guardados</b></div></center>";
            echo '<meta http-equiv="refresh" content="1; url=nuevoUsuario.php">';
         } else  {
             $con->executeQuery("rollback");
            $con->Close();
            echo "<div class=error><b>Ha ocurrido un error intentando guardar los datos</b></div>";
            echo '<meta http-equiv="refresh" content="2; url=nuevoUsuario.php">';
         }
      }
   }
}
?>
