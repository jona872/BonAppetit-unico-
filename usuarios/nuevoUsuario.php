<?php 
require 'aut_verifica.inc.php'; // incluir motor de autentificacion.
include_once '../ClasesBasicas/ConsultaBD.php';
if ( $_SESSION['usuario_nivel'] != "1") {
   echo "<div align=center class=error>Acceso Incorrecto</div>";
   exit;
}

// Se requieren los script para acceder a los datos de la DB
require_once '../ClasesBasicas/ActiveRecordAbstractFactory.php';

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
<body onload="document.getElementById('empleado').focus();">
<div class="contenedor"  id="contenedor">
<header> <?php include_once '../ClasesBasicas/Encabezado.php'; ?> </header>
<div id="cuerpo"> 
     <div id="body">
        <form id="two" name="formulario" autocomplete="off" method="POST" action="index.php" onSubmit="return guardarDatos()">        
        <fieldset>
                    
            <h1>Nuevo Usuario</h1>                                    
            <br/>
            <label for="empleado">Empleado:</label>
            <input type="text" id="empleado" class="textolargo" name="empleado" value="" onKeyUp="ajax_showOptionsEmpleado(this,'getEmpleadoByLetters',event)" onBlur="this.style.color='#333333'" />*
            <input type="hidden" id="empleado_hidden" name="empleado_ID" value=""/>
            <div id="falta_empleado" class="falta_dato" style="display:none;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</div>
            <br/>              
            <label>Identificacion:</label>        
                <input type="text" name="usuarionombre"  maxlength="30" onFocus="this.style.color='blue'" onBlur="this.style.color='#333333'" >*
                <div id="iden" class="falta_dato" style="display:none">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</div>
            <br/>           
            <label>Acceso:</label>                              
                <select id="nivel" name="nivel">
                   <option value="0">Seleccione un nivel de usuario</option>                                    
                   <option value="1">1 - Supervisor</option>
                   <option value="2">2 - Administrador</option>                                    
                   <option value="3">3 - Mozo</option>                                    
                   <option value="4">4 - Cocina</option>                                                       
                   <option value="5">5 - Delivery</option>
                </select>*
                <div id="divNiv" class="falta_dato" style="display:none">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</div>
            <br/>
            <label>Contraseña:</label>
                <input type="password" name="password1" maxlength="10" >*
                <div id="pass1" class="falta_dato" style="display:none">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</div>                             
            Contraseña (repetir):                              
                <input type="password" name="password2" maxlength="10" >*
                <div id="pass2" class="falta_dato" style="display:none">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</div>
            <br/>
                <div id="falta" style="text-align: center;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</div>
            <br/>
            <p>
                <input type="button" class="button" value="&nbsp;&nbsp;Registrar&nbsp;&nbsp;" onclick="nuevoUsuario()" />
                <input type="reset" class="button" value="&nbsp;&nbsp;Limpiar&nbsp;&nbsp;">            
            </p>
             <div id="resultado">            
        </div>          
        </fieldset>
                </form>  
    </div>
</div>
<footer><?php include_once '../ClasesBasicas/Pie.php'; ?></footer>
</div>
</body>
</html>
