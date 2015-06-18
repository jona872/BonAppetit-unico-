<?php
/**
 * Archivo verificador del login
 *
 * Archivo verificador del login que verifica el ingreso del usuarios y
 * guarda los valores en variables de sesion
 *
 * @version    1.0
 * @since      File available since Release 1.0
 *
*/

// Se inicia o reanuda una sesion
session_name('sistema');

session_start();

// si se enviaron datos a traves del formulario de login
if (isset($_POST['Entrar'])  && isset($_POST['token']) && $_POST['token'] == $_SESSION['token']) {
   // Se verifican los datos de login
   if (isset($_POST['user'])) {
      $auxiliar = htmlentities(trim($_POST['user']));
      $usuario = $auxiliar;
   }
   if (isset($_POST['pass'])) {
      $auxiliar = htmlentities(trim($_POST['pass']));
      $password = $auxiliar;
   }

   require_once '../ClasesBasicas/ConsultaBD.php';
   $conexion = new ConsultaBD();
   $conexion->Conectar();
   // busqueda del usuario por nombre y password
   $sql = "SELECT usuarios.id, usuarios.identificacion, usuarios.clave, usuarios.permiso,usuarios.empleado_id, usuarios.fecha_baja, usuarios.nombre, usuarios.apellido FROM usuarios";
   $sql.="  WHERE identificacion='$usuario' and clave=md5('$password')";   
   $conexion->executeQuery($sql);
   $conexion->Close();
   
   if ($conexion->getNumRows()==1) {
  
      $datos_usuario = $conexion->getFetchArray();
      if ($datos_usuario['fecha_baja']=='0000-00-00 00:00:00') {
         // Registra variables de session
         $_SESSION['usuarioRegistrado'] = true;
         // definimos usuarios_id como IDentificador del usuario en nuestra BD de usuarios
         $_SESSION['usuario_id'] = $datos_usuario['id'];
         $_SESSION['usuario_nombre'] = $datos_usuario['nombre'];         
         // definimos usuario_nivel con el Nivel de acceso del usuario de nuestra BD de usuarios
         $_SESSION['usuario_nivel'] = $datos_usuario['permiso'];
         //definimos usuario_nivel con el Nivel de acceso del usuario de nuestra BD de usuarios
         $_SESSION['usuario_login'] = $datos_usuario['identificacion'];
         //definimos usuario_password con el password del usuario de la sesion actual (formato md5 encriptado)
         $_SESSION['usuario_password'] = $datos_usuario['clave'];
         //definimos la fecha de baja del usuario
         $_SESSION['fechaBaja'] = $datos_usuario['fecha_baja'];         
         $_SESSION['empleado_id'] = $datos_usuario['empleado_id'];
         $_SESSION['nombre_empleado'] = $datos_usuario['nombre']." ".$datos_usuario['apellido'];
         $_SESSION['http-user-agent'] = md5($_SERVER['HTTP_USER_AGENT'].'palabraSecreta');
         
         // regenera el identificador de sesion
         session_regenerate_id();
         // Paranoia: decimos al navegador que no "cachee" esta p�gina.
         session_cache_limiter('nocache,private');
         // direcciona a la pagina de aplicaciones      
        
         header("Location: ../admMesas/index.php");
        
      } else { $redir = 1;  }
   } else {  $redir = 1; }
} else {   $redir = 1; }
if ($redir==1) {
   // hace una redireccion por un mal login
   $_SESSION['error_login']="Acceso Incorrecto";
   header("Location: ingreso.php");
}
?>