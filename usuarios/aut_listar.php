<?php 
require 'aut_verifica.inc.php'; // incluir motor de autentificacion.
include_once '../ClasesBasicas/ConsultaBD.php';
if ( $_SESSION['usuario_nivel'] != "1") {
   echo "<div align=center class=error>Acceso Incorrecto</div>";
   exit;
}
?>
<!DOCTYPE html>
<html>
<head>
     <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
     <title>Bon Appetit</title>
     <link rel="shortcut icon" href="../img/favicon.ico" />    
     <link rel="stylesheet" type="text/css" href="../css/menu.css"> 
     <link rel="stylesheet" type="text/css" href="../css/estilos.css"> 
     <script type="text/javascript" src="js/validacion.js"></script>
     <script type="text/javascript" src="js/ajax-dynamic-list.js"></script>
     <script type="text/javascript" src="js/ajax.js"></script>   
     <script language="javascript" type="text/javascript" src="js/jquery-1.3.2.min.js"></script>
</head>
<body>
<div class="contenedor" id="contenedor">
<header> <?php include_once '../ClasesBasicas/Encabezado.php'; ?> </header>
<div id="cuerpo" style="padding-bottom: 50px;"> 
     <div id="body">
        <center>
        <br/><br/>
        <h1><b>Listado General de Usuarios</b></h1>            
        <div id="div_listar" style="margin-top: 20px;width: 1000px;">            
        <br/>
           <?php
           $usu = $_SESSION['usuario_id'];
           $con = new ConsultaBD();
           $con->Conectar();
           $sql = "SELECT id, nombre, apellido, identificacion, permiso, DATE_FORMAT(fecha_alta, '%d-%m-%Y') AS fechaAlta, fecha_baja FROM usuarios ";
           $sql.= " WHERE id!= '$usu' order by apellido, nombre";               
           $con->executeQuery($sql);
           $con->Close();
           ?>
          <table id="estados" class="header" style="width: 100%;">
              <tr>
              <td>Código</td>
              <td>Apellido y Nombre</td>
              <td>Identificador</td>
              <td>Permiso</td>
              <td>Fecha Alta</td>             
              <td width="16px"></td>
              <td  width="16px"></td>
                  </tr>
              <?php                  
              while($resultados = $con->getFetchArray()) {                     
              ?>
                  <tr  style="text-align: left">
                  <!-- cuerpo de la lista -->
                     <td><?php echo $resultados['id'] ?></td>
                     <td><?php echo $resultados['apellido'].", ".$resultados['nombre'] ?></td>
                     <td><?php echo $resultados['identificacion'] ?></td>
                     <td><?php 
                        switch ($resultados['permiso']) {
                            case 1:
                                echo "Supervisor";
                                break;
                            case 2:
                                echo "Administrador";
                                break;
                            case 3:
                                echo "Mozo";
                                break;
                            case 4:
                                echo "Cocina";
                                break;
                            case 5:
                                echo "Delivery";
                                break;
                            default:
                                break;
                        }
                     ?></td>
                     <td><?php echo $resultados['fechaAlta'] ?></td>                     
                     <td>
                        <img src="../img/reload.gif" onclick="editarUsuario('<?php echo $resultados['id']; ?>' )" style="cursor:pointer" title="Editar Usuario">
                    </td> <td>
                        <img src="../img/borrar.gif" onclick="borrarUsuario('<?php echo $resultados['id']; ?>')" title="Bloquear usuario" style="cursor:pointer">
                     </td>
                  </tr>
                  <?php
              }
              ?>
           </table>   
        </div>
        </center>
    </div>
</div> <div id="resultado"></div>
<footer><?php include_once '../ClasesBasicas/Pie.php'; ?></footer>
</div>
</body>
</html>