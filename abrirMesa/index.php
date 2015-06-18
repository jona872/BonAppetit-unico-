<?php
/**
 * @version    1.0
 * @since      File available since Release 1.0
 * 
*/
// Se chequea si existe un login
require_once '../usuarios/aut_verifica.inc.php';

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
    <!-- lista dinamica -->
    <script type="text/javascript" src="js/ajax-dynamic-list.js"></script>
    <script type="text/javascript" src="js/ajax.js"></script>   
    <script type="text/javascript" src="js/valida.js"></script>    
    <script language="javascript" type="text/javascript" src="js/jquery-1.3.2.min.js"></script>
    <script language="javascript" type="text/javascript">
        $('#two input').keydown(function(e) {
            if (e.keyCode == 13) {
                $('#two').submit();
            }
        });
        function guardarDatos(){            
            document.getElementById('falta_empleado').style.display='none';
            document.getElementById('falta_mesa').style.display='none';
            document.getElementById('falta_comensales').style.display='none';
            document.getElementById('empleado').style.borderColor='';
            document.getElementById('mesa').style.borderColor='';
            document.getElementById('comensales').style.borderColor='';
            var error=0;
            if(document.getElementById('empleado_hidden').value=='') {
                document.getElementById('empleado').style.borderColor='red';
                document.getElementById('falta_empleado').style.display='inline';
                document.getElementById('empleado').focus();
                error=1;
            }
            if(document.getElementById('comensales').value=='') {
                document.getElementById('comensales').style.borderColor='red';
                document.getElementById('falta_comensales').style.display='inline';
                document.getElementById('comensales').focus();
                error=1;
            }           
            if(document.getElementById('mesa').value=='') {
                document.getElementById('mesa').style.borderColor='red';
                document.getElementById('falta_mesa').style.display='inline';
                document.getElementById('mesa').focus()
                error=1;
            }           
            
            if(error==1)
                return false;
            else 
                formulario.submit();
        }
    </script> 
</head>
<body onload="document.getElementById('mesa').focus();">
<div class="contenedor">
<header> <?php include_once '../ClasesBasicas/Encabezado.php'; ?> </header>
<div id="cuerpo">    
    <div id="body">
    <?php if (empty($_POST)) { ?>
    <form id="two" name="formulario" autocomplete="off" method="POST" action="index.php" onSubmit="return guardarDatos()">
        <fieldset>
        <div id="resultado">                
            <h1>Abrir Mesa</h1>                                   
            <label for="empleado">N&uacute;mero:</label>
                <input type="text" class="numero" id="mesa" name="mesa" value="" size="10" onKeyPress="return esInteger(event);"/>*                
                <div id="falta_mesa" class="falta_dato" style="display:none;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</div>
            <br/>            
            <label for="empleado">Comensales:</label>
                <input type="text" id="comensales" name="comensales" value="" size="10" onKeyPress="return esInteger(event)" />*                
                <div id="falta_comensales" class="falta_dato" style="display:none;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</div>
            <br/>                        
            <?php if(($_SESSION['usuario_nivel']=='1')||($_SESSION['usuario_nivel']=='2')) { ?>
                <label for="empleado">Mozo:</label>
                <input type="text" id="empleado" class="textolargo" name="empleado" value="" onKeyUp="ajax_showOptionsEmpleado(this,'getEmpleadoByLetters',event)" onBlur="this.style.color='#333333'" />*
                <input type="hidden" id="empleado_hidden" name="empleado_ID" value=""/>
                <div id="falta_empleado" class="falta_dato" style="display:none;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</div>
            <?php } else {
                echo "<label for='empleado'>Mozo:</label>";
                echo "<label for='mozo' style='margin-left:0%'>".$_SESSION['nombre_empleado']."</label>";
                echo "<input type='hidden' id='empleado_hidden' name='empleado_ID' value='".$_SESSION['empleado_id']."'/>";                
                echo "<input type='hidden' id='empleado' name='empleado' value='".$_SESSION['nombre_empleado']."' size='80'  />";
                echo "<div id='falta_empleado' class='falta_dato' style='display:none;'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</div>";
            }?>
            <br/>
            <label>Ubicaci&oacute;n:</label>    
            <select name="ubicacion" id="ubicacion" style='max-width:100px' >
                <?php 
                require_once '../ClasesBasicas/ConsultaBD.php';
                $con = new ConsultaBD();
                $con->Conectar();        
                $sql = "select * from ubicacion ";
                $con->executeQuery($sql);
                while($inf = $con->getFetchObject()){                    
                    $nombre = htmlentities($inf->descripcion);
                    echo "<option value='".$inf->id."'>".$nombre."</option>";
                }
                $con->Close();	
                ?>          
            </select>*
            <br/>
            <label for="cliente">Cliente:</label>
                <input type="text" id="cliente" class="textolargo" name="cliente" value="" onKeyUp="ajax_showOptionsCliente(this,'getClienteByLetters',event)" onBlur="this.style.color='#333333'" placeholder="5 - Consumidor Final"/>*
                <input type="hidden" id="cliente_hidden" name="cliente_ID" value="5"/>                
            <br/>
            <br/>
            <p>
                <input type="submit" value="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Guardar&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;" class="button" onclick="guardarDatos()" name="guardar"/>                                     
                <input type="button" value="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Limpiar&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;" class="button" onclick="javascript:window.location='index.php'" />                    
            </p> 
            <div id="mensaje" style="color:brown; "></div>
        
        </div>
        </fieldset>
    </form>   
        
    <?php } else {     
        ?><div  style="margin: 0 auto; text-align: center; margin-top: 50px; font-size: 14px; color: #F00;"><?php
        /// guarda los datos
        $oMysql = ActiveRecordAbstractFactory::getActiveRecordFactory(ActiveRecordAbstractFactory::MYSQL);
        $oMysql->conectar();
        
        $oPedido = new PedidoMaestroValueObject('',$_POST['empleado_ID'], $_POST['cliente_ID'], $_POST['mesa'], $_POST['comensales'], '', '0', '0', 1, $_SESSION['usuario_id'], $_POST['ubicacion']);
        $oPedidoMysql = $oMysql->getPedidoMaestroActiveRecord();
        
        if($oPedidoMysql->exists($oPedido)) {
            echo "El número de mesa ingresado ya existe<br/><a href='index.php' style='color: #0087c7'>&laquo;&nbsp;Volver</a>";
        } else {
            if($oPedidoMysql->insert($oPedido)) {               
                echo "Datos Guardados";
                echo '<meta http-equiv="refresh" content="0; url=../admMesas/pedidos.php?p='.$oPedido->getId().'">';
            } else {
                echo "Ha ocurrido un error intentando guardar los datos<br/><a href='index.php'>Volver</a>";
            }
        }
        ?></div><?php
    }
    ?>
        
    </div>
</div>
<footer><?php include_once '../ClasesBasicas/Pie.php'; ?></footer>
</div>
</body>
</html>
