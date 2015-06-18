<?php
include_once 'aut_verifica.inc.php';
include_once '../ClasesBasicas/ConsultaBD.php';
$empleado_id = $_POST['empleado_id'];
$usuario = $_POST['identif'];
$pass1 = $_POST['passw1'];
$pass2 = $_POST['passw2'];
$nivel = $_POST['nivel'];
$id = $_POST['id'];

if (($pass1 == "") || ($pass2 == "") || ($usuario == "") || ($empleado_id == "")) {
  // echo "<div class=falta_dato><b>Debe completar todos los campos para poder crear un usuario.</b></div>";    
} else {
   if ($pass1 != $pass2) {
      echo "<div class=falta_dato><b>Las Contraseñas No Coinciden</b></div>";
   } else {
      $con = new ConsultaBD();

      $usuario=stripslashes($usuario);
      $pass1 = md5($pass1);
      $con = new ConsultaBD();
      $con->Conectar();       
      $sql1="SELECT nombre, apellido FROM empleados WHERE id='$empleado_id'";      
      $con->executeQuery($sql1);
      $row = $con->getFetchObject();
      
      $sql = "UPDATE usuarios SET nombre = '".$row->nombre."', apellido = '".$row->apellido."', identificacion = '$usuario',
      clave = '$pass1', permiso = '$nivel', empleado_id = '$empleado_id' WHERE id = $id;";          
      if ($con->executeQuery($sql)) {
         $con->Close();
         echo "<center><div class=exito><b><br/>Los datos se actualizaron con exito</b></div></center>";
         echo '<meta http-equiv="refresh" content="2; url=aut_listar.php">';
      } else  {
         $con->Close();
         echo "<div class=error><b><br/>Ha ocurrido un error intentando guardar los datos</b></div>";
         echo '<meta http-equiv="refresh" content="0; url=aut_listar.php">';
      }
   }
}
?>
