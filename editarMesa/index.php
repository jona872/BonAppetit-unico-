<?php
/**
 * @version    1.0
 * @since      File available since Release 1.0
 * 
*/
// Se chequea si existe un login
require_once '../usuarios/aut_verifica.inc.php';
require_once '../ClasesBasicas/ConsultaBD.php';

if((empty($_POST)) && (empty($_GET)))  { 
    header("Location: ../abrirMesa/index.php");
}
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
    <?php if ((empty($_POST))&& isset($_GET['p'])) { 
                
        // entrada al formulario desde pedidos
        if(isset($_GET['ent'])) {
            $entrada=2;
        } else $entrada=1;
        
        $conexion = new ConsultaBD();
        $conexion->Conectar();
        
        $sql = "SELECT pedido_maestros.*, concat(clientes.id,' - ',clientes.descripcion) as descripcion, concat(empleados.id,' - ',empleados.descripcion) as empleados  FROM pedido_maestros ";
        $sql.= " INNER JOIN clientes on pedido_maestros.cliente_id = clientes.id ";
        $sql.= " INNER JOIN empleados on pedido_maestros.empleado_id = empleados.id ";
        $sql.= " WHERE pedido_maestros.id=".$_GET['p']; 
        $conexion->executeQuery($sql);
        
        if($conexion->getNumRows()!=1) {
            header("Location: ../abrirMesa/index.php");
        }
        $row = $conexion->getFetchObject();
        $conexion->Close();
        ?>
        <form id="two" name="formulario" autocomplete="off" method="POST" action="index.php" onSubmit="return guardarDatos()">
        <input type="hidden" name="id" id="id" value="<?php echo $_GET['p']?>"/>
        <input type="hidden" name="ent" id="ent" value="<?php echo $entrada?>"/>
        <fieldset>
        <div id="resultado">                
            <h1>Editar Mesa</h1>                        
            <label>Ubicaci&oacute;n:</label>    
            <select name="ubicacion" id="ubicacion" >
                <?php 
                require_once '../ClasesBasicas/ConsultaBD.php';
                $con = new ConsultaBD();
                $con->Conectar();        
                $sql = "select * from ubicacion ";
                $con->executeQuery($sql);
                while($inf = $con->getFetchObject()){                    
                    $nombre = htmlentities($inf->descripcion);
                    if($inf->id==$row->ubicacion_id)
                        echo "<option value='".$inf->id."' selected>".$nombre."</option>";
                    else
                        echo "<option value='".$inf->id."'>".$nombre."</option>";
                }
                $con->Close();	
                ?>          
            </select>*
            <br/>
            <label for="empleado">N&uacute;mero:</label>
                <input type="text" class="numero" id="mesa" name="mesa" value="<?php echo $row->mesa_nro?>" size="10" onKeyPress="return esInteger(event);"/>*                
                <div id="falta_mesa" class="falta_dato" style="display:none;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</div>
            <br/>            
            <label for="empleado">Comensales:</label>
                <input type="text" id="comensales" name="comensales" value="<?php echo $row->cantidad_de_comensales?>" size="10" onKeyPress="return esInteger(event)" />*                
                <div id="falta_comensales" class="falta_dato" style="display:none;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</div>
            <br/>                        
            <?php if($_SESSION['usuario_nivel']=='1') { ?>
                <label for="empleado">Mozo:</label>
                <input type="text" id="empleado" class="textolargo" name="empleado" value="<?php echo $row->empleados?>" onKeyUp="ajax_showOptionsEmpleado(this,'getEmpleadoByLetters',event)" onBlur="this.style.color='#333333'" />*
                <input type="hidden" id="empleado_hidden" name="empleado_ID" value="<?php echo $row->empleado_id?>"/>
                <div id="falta_empleado" class="falta_dato" style="display:none;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</div>
            <?php } else {
                echo "<label for='empleado'>Mozo:</label>";
                echo "<label for='mozo' style='margin-left:0%'>".$_SESSION['nombre_empleado']."</label>";
                echo "<input type='hidden' id='empleado_hidden' name='empleado_ID' value='".$_SESSION['empleado_id']."'/>";                
                echo "<input type='hidden' id='empleado' name='empleado' value='' size='80'  />";
                echo "<div id='falta_empleado' class='falta_dato' style='display:none;'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</div>";
            }?>
            <br/>
            <label for="empleado">Cliente:</label>
                <input type="text" id="cliente" class="textolargo" name="cliente" value="<?php echo $row->descripcion?>" onKeyUp="ajax_showOptionsCliente(this,'getClienteByLetters',event)" onBlur="this.style.color='#333333'" placeholder="5 - Consumidor Final"/>*
                <input type="hidden" id="cliente_hidden" name="cliente_ID" value="<?php echo $row->cliente_id?>"/>                
            <br/>
            <br/>
            <p>
                <input type="submit" value="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Guardar&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;" class="button" onclick="guardarDatos()" name="guardar"/>                                     
                <input type="reset" value="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Limpiar&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;" class="button"  />                    
            </p> 
            <div id="mensaje" style="color:brown; "></div>
        
        </div>
        </fieldset>
    </form>   
        
    <?php } else {     
        ?><div  style="margin: 0 auto; text-align: center; margin-top: 50px; font-size: 14px; color: #F00;"><?php
        /// guarda los datos
        $conexion = new ConsultaBD();
        $conexion->Conectar();
        $sql = "SELECT id FROM pedido_maestros WHERE mesa_nro = ".$_POST['mesa']." AND finalizado<>1 AND id <> ".$_POST['id'].";";
        $conexion->executeQuery($sql);
        if($conexion->getNumRows()>0) {
            echo "El número de mesa ingresado ya existe<br/><a href='index.php?p=".$_POST['id']."' style='color: #0087c7'>&laquo;&nbsp;Volver</a>";
        } else {
            $sql = "UPDATE pedido_maestros SET `empleado_id` = '".$_POST['empleado_ID']."', `cliente_id` = '".$_POST['cliente_ID']."',";
            $sql.= " `mesa_nro` = '".$_POST['mesa']."',  `cantidad_de_comensales` = '".$_POST['comensales']."',  `ubicacion_id` = '".$_POST['ubicacion']."' WHERE `id` = '".$_POST['id']."'";
            $conexion->executeQuery($sql);
            echo "Datos Guardados";
            if($_POST['ent']==1)
                echo '<meta http-equiv="refresh" content="0; url=../listadoMesas/index.php">';
            else
                echo '<meta http-equiv="refresh" content="0; url=../admMesas/pedidos.php?p='.$_POST['id'].'">';
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