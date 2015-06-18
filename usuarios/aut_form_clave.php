<?php 
require 'aut_verifica.inc.php'; // incluir motor de autentificacion.
include_once '../ClasesBasicas/ConsultaBD.php';

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
</head>
<body onload="document.getElementById('passwordA').focus();">
<div class="contenedor"  id="contenedor">
<header> <?php include_once '../ClasesBasicas/Encabezado.php'; ?> </header>
<div id="cuerpo"> 
     <div id="body">
            <form id="two" name="formulario" autocomplete="off" method="post">
               <input name="ident" id="ident" value="<?php echo $_SESSION['usuario_id'] ?>" type="hidden">
               <fieldset style="width: 40%;">
                <h1>Actualizar Clave</h1>                         
                <br/>
                <label>Clave Actual:</label>                          
                        <input type="password" name="passwordA" id="passwordA" class="imputbox" maxlength="10">
                        <div id="passA" class="falta_dato" style="display:none">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</div>                        
                        <br/>
                <label>Clave Nueva:</label>                          
                        <input type="password" name="password1" id="password1" class="imputbox" maxlength="10">
                        <div id="pass1" class="falta_dato" style="display:none">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</div>                        
                        <br/>
                <label>Clave Nueva: (repetir)</label>                                                                      
                        <input type="password" name="password2" id="password2" class="imputbox" maxlength="10">
                        <div id="pass2" class="falta_dato" style="display:none">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</div>                                                
                    <br/>
                <div id="falta" style="text-align: center;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</div>
                <br/>
                <p>
                    <input type="button" class="button" name="Submit" value="&nbsp;&nbsp;Guardar&nbsp;&nbsp;" onclick="modificacionClave()">
                    <input type="button"  class="button" value="&nbsp;&nbsp;Cancelar&nbsp;&nbsp;" onclick="javascript: window.location.href='aut_form_clave.php';" >
                </p>
                <div id="resultado" style="text-align: center;">            
                </div>      
            </fieldset>            
         </div>
         <footer><?php include_once '../ClasesBasicas/Pie.php'; ?></footer>
      </div>
   </body>
</html>