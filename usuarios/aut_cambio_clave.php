<?php
include_once 'aut_verifica.inc.php';
include_once '../ClasesBasicas/ConsultaBD.php';
$id = $_POST['id'];
$passA = $_POST['passwordA'];
$pass1 = $_POST['password1'];
$pass2 = $_POST['password2'];
    
if (($pass1 == "") || ($pass2 == "") || ($passA == "")){
   ?>
   <div class=falta_dato>
      <b><br/>
         Debe completar todos los campos para poder crear un usuario.
      </b>
   </div>
   <?php
} else {
   if ($pass1 != $pass2) {
        echo "<div class=error><b><br/>Las claves no coinciden</b></div>";
   } else {
      if (md5($passA) <> $_SESSION['usuario_password']){         
         echo "<div class=exito><b><br/><br/>La clave actual es incorrecta</b></div>";
         //echo '<meta http-equiv="refresh" content="2; url=aut_form_clave.php">';
      } else {
         $con = new ConsultaBD();
         $con->Conectar();
         $sql = "select * from usuarios where id = $id";
         $con->executeQuery($sql);
         $con->Close();
         $total_encontrados = $con->getNumRows();
         if ($total_encontrados ==  0){
            echo "<div class=error>Ha ocurrido un error intentando actualizar los datos</div>";
            echo '<meta http-equiv="refresh" content="2; url=aut_form_clave.php">';
         } else {
            $pass1 = md5($pass1);
            $con = new ConsultaBD();
            $con->Conectar();
            $sql="update usuarios set clave = '$pass1' where id = '$id'";
            if ($con->executeQuery($sql)) {
               $con->Close();
               $_SESSION['usuario_password'] = $pass1;
               echo "<div class=exito><b><br/><br/>Los datos se actualizaron con exito<br/>Deberá volver a iniciar sesión</b></div>";
               echo '<meta http-equiv="refresh" content="2; url=logout.php">';
            } else {
               $con->Close();
               echo "<div class=error><b><br/><br/>Ha ocurrido un error intentando guardar los datos</b></div>";
               echo '<meta http-equiv="refresh" content="2; url=aut_form_clave.php">';
            }
         }
      }
   }
}
?>