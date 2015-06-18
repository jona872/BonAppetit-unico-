<?php
/**
 * @version    1.0
 * @since      File available since Release 1.0
 * 
*/
// Se chequea si existe un login
require_once '../usuarios/aut_verifica.inc.php';

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>        
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <title>Bon Appetit</title>
    <link rel="shortcut icon" href="../img/favicon.ico" />    
    <link rel="stylesheet" type="text/css" href="../css/menu.css"/> 
    <link rel="stylesheet" type="text/css" href="../css/estilos.css"/> 
    <link rel="stylesheet" type="text/css" href="../css/PHPPaging.lib.css"/> 
    <script language="javascript" type="text/javascript" src="js/jquery-1.3.2.min.js"></script>
    <script language="javascript" type="text/javascript" src="js/jquery.blockUI.js"></script>
    <script language="javascript" type="text/javascript" src="js/jquery.validate.1.5.2.js"></script>        
    <script language="javascript" type="text/javascript" src="index.js"></script>
</head>
<body onload="document.getElementById('criterio_buscar').focus();">
<div class="contenedor">
<header> <?php include_once '../ClasesBasicas/Encabezado.php'; ?> </header>
<div id="cuerpo" style="padding-bottom: 50px;"> 
    <div id="body">            
        <form action="javascript: fn_buscar();" id="frm_buscar" name="frm_buscar">
            <fieldset>
                <div id="resultado" style="text-align: right">    
                <h1>Administración de Clientes</h1>                                
                <input type="text" id="criterio_buscar" name="criterio_buscar" id="criterio_buscar" placeholder="Cliente a buscar" size="40"/>                
                    <select name="criterio_ordenar_por" id="criterio_ordenar_por">
                        <option value="id">Código</option>
                        <option value="descripcion">Apellido y Nombre</option>
                        <option value="dni">DNI</option>                        
                        <option value="razon_social">Razon Social</option>
                    </select>                           
                    <select name="criterio_orden" id="criterio_orden">
                            <option value="desc">Descendente</option>
                        <option value="asc">Ascendente</option>
                    </select>
                    <select name="criterio_mostrar" id="criterio_mostrar">
                            <option value="1">1</option>
                            <option value="2">2</option>
                            <option value="5">5</option>
                            <option value="10">10</option>
                            <option value="20" selected="selected">20</option>
                            <option value="40">40</option>
                    </select>                            
                    <input type="submit" value="Buscar" />   
                </div>
                </fieldset>
        
            </form>
            <center>
                <div id="div_listar" style="margin-top: 10px;"></div>
            </center>
            <div id="div_oculto" style="display: none;"></div>            
    </div>
</div>
<footer><?php include_once '../ClasesBasicas/Pie.php'; ?></footer>
</div>
</body>
</html>