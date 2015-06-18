<?php
/**
 * @version    1.0
 * @since      File available since Release 1.0
 * 
*/
// Se chequea si existe un login
require_once '../usuarios/aut_verifica.inc.php';
require_once '../ClasesBasicas/ConsultaBD.php';
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>        
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <title>Bon Appetit</title>
    <link rel="shortcut icon" href="../img/favicon.ico" />    
    <link rel="stylesheet" type="text/css" href="../css/menu.css" /> 
    <link rel="stylesheet" type="text/css" href="../css/estilos.css" /> 
    <script language="javascript" type="text/javascript" src="js/jquery-1.3.2.min.js"></script>
    <script language="javascript" type="text/javascript" src="js/jquery.blockUI.js"></script>        
    <script language="javascript" type="text/javascript" src="js/jquery.validate.1.5.2.js"></script>        
    <script language="javascript" type="text/javascript" src="index.js"></script>
    <script type="text/javascript" src="js/jquery.jeditable.js"></script>    
    <script type="text/javascript" src="js/valida.js"></script>    
</head>
<body>
<div class="contenedor">
<header> <?php include_once '../ClasesBasicas/Encabezado.php'; ?> </header>
<div id="cuerpo" style="padding-bottom: 50px;">    
    <div id="body">
    <center>
        <br/><br/>
        <h1><b>Listado General de Mesas</b></h1>
        <form action="javascript: fn_buscar();" id="frm_buscar" name="frm_buscar">
            <fieldset>
                <div id="resultado" style="text-align: right">             
                    <input type="text" name="criterio_buscar" id="criterio_buscar" placeholder="Nro. mesa" size="10" onKeyPress="return esInteger(event);"/>                
                    <select name="criterio_ordenar_por" id="criterio_ordenar_por">
                        <option value="fecha_y_hora">Fecha y Hora de apertura</option>
                        <option value="pedido_maestros.mesa_nro">Nro. Mesa</option>
                        <option value="empleados.descripcion">Mozo</option>
                        <option value="ubicacion.`descripcion`">Ubicación</option>
                        <option value="pedido_maestros.`cantidad_de_comensales`">Comensales</option>                    
                    </select>                           
                    <select name="criterio_orden" id="criterio_orden">
                            <option value="desc">Descendente</option>
                        <option value="asc">Ascendente</option>
                    </select>                                          
                    <input type="submit" value="Buscar" />   
                    </div>
                </fieldset>
            </form>
        <div id="div_listar" style="margin-top: 20px;">            
        </div>
    </center>
    <div id="div_oculto" style="display: none;"></div>
    </div>
    <?php
    
    if(isset($_POST['limpiar'])) {
        $limpiar = $_POST['limpiar'];
        
        $consulta="SELECT pm.id FROM pedido_maestros pm WHERE (";
        foreach ($limpiar as $value) {
            $consulta.=" pm.id=$value OR ";
        }
        $consulta.=" 1!=1)";
        $consulta.=" AND pm.factura_maestro_id IS NULL";
     
        
        $conexion = new ConsultaBD();
        $conexion->Conectar();
        $conexion->executeQuery($consulta);
        if($conexion->getNumRows()>0) {            
            while ($row_ = $conexion->getFetchObject()) {       
                $ids[]=$row_->id;
            
            }
        }      
        mysql_query('BEGIN');      
        for ($index = 0; $index < count($ids); $index++) {         
            
            //Guardo todo en factura maestro y factura detalle para dejar constancia de la venta
            $sql_fm = "INSERT INTO factura_maestros
            (`descripcion`,`fecha_y_hora`,`fecha_y_hora_fin`,`cliente_id`,`total`,`subtotal`,`empleado_id`, `tipo_iva_id`,`empresa_id`,`usuario_id`,`cantidad_comensales`,`mesa_nro`,`ubicacion_id`)
            SELECT CONCAT('VENTA DE COMIDA EN SALON - ',fecha_y_hora), fecha_y_hora, now(), cliente_id, total,'0.00', empleado_id ,'2','1',".$_SESSION['usuario_id'].", `cantidad_de_comensales`, `mesa_nro`,`ubicacion_id` FROM pedido_maestros WHERE id=".$ids[$index];

            $conexion->executeQuery($sql_fm);
            $conexion->executeQuery("SELECT @@identity AS id");
            $row_id = $conexion->getFetchRow();
            $pm_id = trim($row_id[0]);

            //Inserto los detalles en la factura_detalles.
            $sql_fd = "INSERT INTO `factura_detalles`(`descripcion`,`factura_maestro_id`,`cantidad`,`precio_unitario`,`observacion`,`observaciontiempo`,`empresa_id`,`usuario_id`,`fecha_alta`,`fecha_cocina`,`fecha_entrega`,`demora_preparacion`,`id_tipo_plato`)
            SELECT receta_maestros.`descripcion`, ".$pm_id.", pedido_detalles.`cantidad`, pedido_detalles.`precio_unitario`,pedido_detalles.`observaciones`,pedido_detalles.`observaciontiempo`, 1,".$_SESSION['usuario_id'].", timestamp_alta, timestamp_cocina,timestamp_entrega,demora_preparacion,tipo_receta_id FROM pedido_detalles 
            INNER JOIN receta_maestros ON pedido_detalles.`receta_maestro_id`=receta_maestros.id
            WHERE pedido_maestro_id =".$ids[$index];                 
            
            $conexion->executeQuery($sql_fd);
        }

        foreach ($limpiar as $value) {
            $sql = "DELETE FROM `pedido_detalles` WHERE `pedido_maestro_id` = '".$value."'";
            $conexion->executeQuery($sql);
            $sql = "DELETE FROM `pedido_maestros` WHERE `id` = '".$value."'";
            $conexion->executeQuery($sql);
        }
        if($conexion->getResults()<>false) {
            mysql_query('COMMIT');
        } else {
            mysql_query('ROLLBACK');
        }

        echo '<meta http-equiv="refresh" content="0; url=index.php">';


    }
    ?>
</div>
</div>
<footer><?php include_once '../ClasesBasicas/Pie.php'; ?></footer>
</body>
</html>
