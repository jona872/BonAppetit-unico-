<?php
/**
 * @version    1.0
 * @since      File available since Release 1.0
 * 
*/
// Se chequea si existe un login
require_once '../usuarios/aut_verifica.inc.php';
require_once '../ClasesBasicas/ConsultaBD.php';

header ("Expires: Fri, 14 Mar 1980 20:53:00 GMT"); //la pagina expira en fecha pasada
header ("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT"); //ultima actualizacion ahora cuando la cargamos
header ("Cache-Control: no-cache, must-revalidate"); //no guardar en CACHE
header ("Pragma: no-cache"); //PARANOIA, NO GUARDAR EN CACHE

$conexion = new ConsultaBD();
$conexion->Conectar();
$consulta = "select pedido_maestros.id, empleados.descripcion AS empleado, mesa_nro, cantidad_de_comensales, DATE_FORMAT(fecha_y_hora,'%d-%m-%Y %H:%i') AS fecha, ubicacion.descripcion as ubicacion, finalizado, SEC_TO_TIME(TIMESTAMPDIFF(SECOND, timestamp_ticket, NOW())) horasCobrar, SEC_TO_TIME(TIMESTAMPDIFF(SECOND, fecha_y_hora, NOW())) horas from pedido_maestros INNER JOIN empleados ON pedido_maestros.`empleado_id`=empleados.`id` inner join ubicacion on ubicacion.id=pedido_maestros.ubicacion_id where pedido_maestros.id=".$_POST['ide_ped'];                        
$conexion->executeQuery($consulta);
$conexion->Close();
$ver = $conexion->getFetchObject(); 
 
echo '<div id="mesas" style="position: static; left: 0%; margin-left: 0px; margin-top: 0px; margin-right: 0px; font-weight: bold;">';
  
$conexion->Conectar();

$sql = "SELECT id, mesa_nro, DATE_FORMAT(fecha_y_hora, '%T') AS hora, cantidad_de_comensales,DATE_FORMAT(timestamp_ticket, '%H:%m:%s') horasCobrar,
SEC_TO_TIME(TIMESTAMPDIFF(SECOND, fecha_y_hora, NOW())) horas, finalizado, total
FROM pedido_maestros WHERE pedido_maestros.id=".$_POST['ide_ped']."  ORDER BY mesa_nro";
$conexion->executeQuery($sql);
$conexion->Close();
if ($conexion->getNumRows()<>0) {
    while ($row = $conexion->getFetchObject()) {     
         ?><a href="../editarMesa/index.php?p=<?php echo $row->id?>&ent=2" style="color: white;"><?php
        switch ($row->finalizado) {
           
            case 9: // tomando pedido
                $conexion2 = new ConsultaBD();
                $conexion2->Conectar();
                $sql_det="SELECT COUNT(*) AS cantidad FROM pedido_detalles 
                INNER JOIN receta_maestros ON pedido_detalles.`receta_maestro_id`=receta_maestros.id
                WHERE pedido_detalles.`pedido_maestro_id`=".$row->id." AND receta_maestros.`tipo_receta_id`<>4 AND pedido_detalles.`estado_id`=3";
                $conexion2->executeQuery($sql_det);
                $row_id = $conexion2->getFetchRow();                
                $pm_id = trim($row_id[0]);
                //SEC_TO_TIME((TIME(timestamp_cocina)+TIME(STR_TO_DATE(tiempo_preparacion, '%i')))-TIME(NOW())) AS hora
                $sql_hora = "SELECT timestamp_cocina, SEC_TO_TIME(TIMESTAMPDIFF(SECOND,  timestamp_cocina, NOW())) horas, ADDTIME(STR_TO_DATE(tiempo_preparacion, '%i'), STR_TO_DATE(tiempo, '%i')) AS horafinal,                  
                SEC_TO_TIME(TIMESTAMPDIFF(SECOND, NOW(), DATE_ADD(timestamp_cocina,INTERVAL tiempo_preparacion MINUTE)))
                FROM pedido_detalles
                INNER JOIN receta_maestros ON receta_maestros.`id`=pedido_detalles.`receta_maestro_id`
                INNER JOIN tipo_recetas ON tipo_recetas.`id`=receta_maestros.`tipo_receta_id`
                WHERE pedido_maestro_id=".$row->id." AND pedido_detalles.`estado_id`=3 AND tiempo=0 ORDER BY horafinal DESC, timestamp_cocina DESC LIMIT 1";                
                
                $conexion2->executeQuery($sql_hora);
                if($conexion2->getNumRows()==0) {
//                    $sql_hora = "SELECT timestamp_cocina, SEC_TO_TIME(TIMESTAMPDIFF(SECOND, (SELECT timestamp_entrega FROM pedido_detalles WHERE pedido_maestro_id=".$row->id." 
//                    AND pedido_detalles.`estado_id`=2 AND tiempo=0 ORDER BY timestamp_entrega DESC LIMIT 1), NOW())) horas, 
//                    STR_TO_DATE(tiempo_preparacion, '%i') AS horafinal, 
//                    SEC_TO_TIME(TIMESTAMPDIFF(SECOND, NOW(), DATE_ADD((SELECT timestamp_entrega FROM pedido_detalles WHERE pedido_maestro_id=".$row->id." AND pedido_detalles.`estado_id`=2 
//                    AND tiempo=0 ORDER BY timestamp_entrega DESC LIMIT 1),INTERVAL tiempo_preparacion MINUTE))) FROM pedido_detalles INNER JOIN receta_maestros ON receta_maestros.`id`=pedido_detalles.`receta_maestro_id` 
//                    INNER JOIN tipo_recetas ON tipo_recetas.`id`=receta_maestros.`tipo_receta_id` WHERE pedido_maestro_id=".$row->id." AND pedido_detalles.`estado_id`=3 AND tiempo=15 ORDER BY timestamp_cocina DESC, horafinal DESC LIMIT 1";                                                                
                    $sql_hora = "SELECT timestamp_cocina, SEC_TO_TIME(TIMESTAMPDIFF(SECOND, (SELECT timestamp_entrega FROM pedido_detalles WHERE pedido_maestro_id=".$row->id." 
                    AND pedido_detalles.`estado_id`=2 AND tiempo=0 ORDER BY timestamp_entrega DESC LIMIT 1), NOW())) horas, 
                    STR_TO_DATE(tiempo_preparacion, '%i') AS horafinal, 
                    SEC_TO_TIME(TIMESTAMPDIFF(SECOND, NOW(), DATE_ADD(timestamp_cocina,INTERVAL tiempo_preparacion MINUTE))) FROM pedido_detalles INNER JOIN receta_maestros ON receta_maestros.`id`=pedido_detalles.`receta_maestro_id` 
                    INNER JOIN tipo_recetas ON tipo_recetas.`id`=receta_maestros.`tipo_receta_id` WHERE pedido_maestro_id=".$row->id." AND pedido_detalles.`estado_id`=3 AND tiempo=15 ORDER BY horafinal DESC, timestamp_cocina DESC LIMIT 1";                                                                
                    $conexion2->executeQuery($sql_hora);
                    if($conexion2->getNumRows()==0) {
                        $sql_hora = "SELECT timestamp_cocina, SEC_TO_TIME(TIMESTAMPDIFF(SECOND, (SELECT timestamp_entrega FROM pedido_detalles WHERE pedido_maestro_id=".$row->id." 
                        AND pedido_detalles.`estado_id`=2 AND tiempo=15 ORDER BY timestamp_entrega DESC LIMIT 1), NOW())) horas, 
                        STR_TO_DATE(tiempo_preparacion, '%i') AS horafinal, 
                        SEC_TO_TIME(TIMESTAMPDIFF(SECOND, NOW(), DATE_ADD(timestamp_cocina,INTERVAL tiempo_preparacion MINUTE))) FROM pedido_detalles INNER JOIN receta_maestros ON receta_maestros.`id`=pedido_detalles.`receta_maestro_id` 
                        INNER JOIN tipo_recetas ON tipo_recetas.`id`=receta_maestros.`tipo_receta_id` WHERE pedido_maestro_id=".$row->id." AND pedido_detalles.`estado_id`=3 AND tiempo=99 ORDER BY horafinal DESC, timestamp_cocina DESC LIMIT 1";                                                                
                        $conexion2->executeQuery($sql_hora);
                    }
                }
                
                $row_hora = $conexion2->getFetchRow();                
                $pm_hora = trim($row_hora[2]);

                if($pm_hora<>'') {
                    if($row_hora[3][0]=='-') {
                         // mesa ocupada con pedidos impresos en cocina, con alert xq ya paso el tiempo limite
                        // echo "<div class='mesaA' style='width:150px; height:70px;'>
                        // <div class='numero' style='font-size:28px'>".$row->mesa_nro."
                        // </div><div class='pedido'><img src='../img/pizzaB.png' />
                        // <span style='font-size: 16px; color: #FFF'>".$pm_id."</span></div>
                        // <div style='text-align:center'>Cocina</div>
                        // <div class='reloj'>00:00:00&nbsp;&nbsp;".$pm_hora."</div></div>";                                
                                                
                        ?>
                        <input type="hidden" id="verifica" value="0" />
                        <input type="hidden" id="time" value="<?php echo $row_hora[3][1]."".$row_hora[3][2]."".$row_hora[3][3]."".$row_hora[3][4]."".$row_hora[3][5]."".$row_hora[3][6]."".$row_hora[3][7]."".$row_hora[3][8]."".$row_hora[3][9];?>" />
                        <div class='mesaA' id='mesaA' style='width:150px; height:70px;'>
                            <div class='numero'style='font-size:28px'>
                                <?php echo $row->mesa_nro?>
                            </div>
                            <div class='pedido'><img src='../img/pizzaB.png' />
                                <span style='font-size: 16px; color: #FFF'><?php echo $pm_id;?>
                                </span>
                            </div>
                            <div style='text-align:center'>Cocina</div>
                            <div class='reloj'><div id="apDiv3" style="display: inline"></div>&nbsp;&nbsp;<?php echo $pm_hora;?></div>
                        </div>  
                         <?php
                    } else {                               
                        // mesa ocupada con pedidos impresos en cocina, sin alert xq no paso el tiempo limite
                        //echo "<div class='mesaO' style='width:150px; height:70px'><div class='numero'style='font-size:28px'>".$row->mesa_nro."</div><div class='pedido'><img src='../img/pizza.png' /><span style='font-size: 16px; color: #000'>".$pm_id."</span></div><div style='text-align:center'>Cocina</div><div class='reloj'>".$row_hora[1]." ".$pm_hora."</div></div>";                                                                    ?>
                    <input type="hidden" id="verifica" value="1" />
                    <input type="hidden" id="time" value="<?php echo $row_hora[3][0]."".$row_hora[3][1]."".$row_hora[3][2]."".$row_hora[3][3]."".$row_hora[3][4]."".$row_hora[3][5]."".$row_hora[3][6]."".$row_hora[3][7]."".$row_hora[3][8]."".$row_hora[3][9];?>" />
                    <div class='mesaO' id='mesaO' style='width:150px; height:70px; background-color: #DF2222'>
                        <div class='numero'style='font-size:28px'>
                            <?php echo $row->mesa_nro?>
                        </div>
                        <div class='pedido'><img src='../img/pizzaB.png' />
                            <span style='font-size: 16px; color: #FFF'><?php echo $pm_id;?>
                            </span>
                        </div>
                        <div style='text-align:center'>Cocina</div>
                        <div class='reloj'><div id="apDiv3" style="display: inline"></div>&nbsp;&nbsp;<?php echo $pm_hora;?></div>
                    </div>                
                <?php
                    }
                }  else {
                    $sql_hora = "SELECT DATE_FORMAT(timestamp_alta, '%H:%i:%s') horas
                    FROM pedido_detalles
                    WHERE pedido_maestro_id=".$row->id." AND pedido_detalles.`estado_id`=1 ORDER BY timestamp_alta DESC LIMIT 1";
                    $conexion2->executeQuery($sql_hora);
                    $row_hora = $conexion2->getFetchRow();                
                    $pm_alta = trim($row_hora[0]);
                    if($pm_alta<>'') {
                        // mesa ocupada sin pedidos impresos en cocina, pero con pedidos a la mesa
                        echo "<input type='hidden' id='verifica' value='' /><input type='hidden' id='time' value='' /><div class='mesaO' style='width:150px; height:70px; background-color:#FE5F04'><div class='numero' style='font-size:28px'>".$row->mesa_nro."</div><div style='text-align:center'>Último Pedido</div><div class='reloj'>".$pm_alta."</div></div>";
                    } else {
                        $sql_hora = "SELECT DATE_FORMAT(timestamp_entrega, '%H:%i:%s') horas
                        FROM pedido_detalles
                        WHERE pedido_maestro_id=".$row->id." AND pedido_detalles.`estado_id`=2 ORDER BY timestamp_entrega DESC LIMIT 1";
                        $conexion2->executeQuery($sql_hora);
                        $row_hora = $conexion2->getFetchRow();                
                        $pm_ent = trim($row_hora[0]);
                        // mesa ocupada sin pedidos impresos en cocina y todos los pedidos entregados
                        echo "<input type='hidden' id='verifica' value='' /><input type='hidden' id='time' value='' /><div class='mesaO' style='width:150px; height:70px; background-color: #B00B67'><div class='numero' style='font-size:28px'>".$row->mesa_nro."</div><div style='text-align:center'>Entregado</div><div class='reloj'>".$pm_ent."</div></div>";
                    }
                }
                $conexion2->Close();
                break;
            case 2: // cobrando                
                echo "<input type='hidden' id='verifica' value='' /><input type='hidden' id='time' value='' /><div class='mesaC' style='width:150px; height:70px'><div class='numero' style='font-size:28px'>".$row->mesa_nro."</div><div style='text-align:center'>Cobrando</div><div class='reloj'>".$row->horasCobrar."</div></div>";
                break;
            case 0: // creada            
                echo "<input type='hidden' id='verifica' value='' /><input type='hidden' id='time' value='' /><div class='mesa' style='width:150px; height:70px'><div class='numero'  style='font-size:28px'>".$row->mesa_nro."</div><div style='text-align:center'>Creada</div><div class='reloj'>".$row->hora."</div></div>";                
                break;
            case 1: // cerrada            
                echo "<input type='hidden' id='verifica' value='' /><input type='hidden' id='time' value='' /><div class='mesa' style='width:150px; height:70px; background-color:grey'><div class='numero'  style='font-size:28px'>".$row->mesa_nro."</div><div style='text-align:center'>Cerrada</div><div class='reloj'>".$row->hora."</div></div>";                
                $cerrada = 1;
                break;


    //    echo "<p style=\"background-color:#FF7400\">".$row->horas." ".$row->mesa_nro." ".$row->hora."</p>";           
        }
        ?></a><?php
    }                        
}
echo '</div>';
echo '<div style="text-align: left;float:left; margin-left:2%">';
echo "<p style=''>Ubicaci&oacute;n: ".utf8_encode($ver->ubicacion)."<br/>";
echo "Cantidad de comensales: ".$ver->cantidad_de_comensales."<br/>";             
echo "Mozo: ".utf8_encode($ver->empleado)."<br/>";             
echo "Fecha y Hora: ".$ver->fecha."</p></div>";
$conexion = new ConsultaBD();
$conexion->Conectar();
$sql="select pedido_detalles.id, estados.id as estado_id, tipo_recetas.id as tipo_receta_id, pedido_detalles.tiempo,pedido_detalles.descuento, receta_maestros.descripcion, pedido_detalles.cantidad, pedido_detalles.precio_unitario, pedido_detalles.observaciones, pedido_detalles.observaciontiempo, estados.descripcion as estado, tipo_recetas.pasa_cocina,
    DATE_FORMAT(pedido_detalles.timestamp_alta, '%H:%i') as hora_alta, DATE_FORMAT(pedido_detalles.timestamp_cocina, '%H:%i') as hora_cocina, DATE_FORMAT(pedido_detalles.timestamp_entrega, '%H:%i') as hora_entregado,STR_TO_DATE(tiempo_preparacion, '%i') AS horafinal
from pedido_detalles 
inner join receta_maestros on receta_maestros.id=pedido_detalles.receta_maestro_id 
inner join tipo_recetas on receta_maestros.tipo_receta_id=tipo_recetas.id
inner join estados on pedido_detalles.estado_id=estados.id
where pedido_maestro_id=".$_POST['ide_ped']." order by estados.orden, tiempo,tiempo_preparacion, tipo_recetas.descripcion, receta_maestros.descripcion";
$conexion->executeQuery($sql);
$conexion->Close();
if ($conexion->getNumRows()<>0) {
?>
<div style="width: 1000px; text-align: right">

<?php if(!isset($cerrada)) {?>    
        <div style="float: right;">
            <form action="imprime_en_mostrador.php" method="post" name="imprime" target="_blank">
                <input type="hidden" id="ide_ped" name="ide_ped" value="<?php echo $_POST['ide_ped'];?>" />
                <input type="submit" name="submit" class="" value="&nbsp;&nbsp;&nbsp;Imprimir en Mostrador&nbsp;&nbsp;&nbsp;" tabindex="2"/>
            </form>
        </div>
    
        <form action="imprime_en_cocina.php" method="post" name="imprime_cocina" id="imprime_cocina" target="_blank">
        <div style="margin-left: 0px;">            
                <input type="hidden" id="ide_ped" name="ide_ped" value="<?php echo $_POST['ide_ped'];?>" />
                <input type="submit" name="submit" class="" value="&nbsp;&nbsp;&nbsp;Imprimir en Cocina&nbsp;&nbsp;&nbsp;" tabindex="1"/>            
        </div>               
<?php } ?>    
<!--<center> -->

<table id="estados" class="header" style="width: 100%;">
        <tr style="text-align: left">       
            <td>Descripci&oacute;n</td>
            <td>Cantidad</td>
            <td>Precio<br/>Unitario</td>
            <td>% Dcto.&nbsp;&nbsp;<img src="../img/edit.gif" /></td> 
            <td>SubTotal</td> 
            <td>Observaciones&nbsp;&nbsp;<img src="../img/edit.gif" /></td>              
            <td>Obs. Entrega&nbsp;&nbsp;<img src="../img/edit.gif" /></td>              
            <td>Tiempo</td> 
            <td>Plato&nbsp;&nbsp;<img src="../img/edit.gif" /></td> 
            <td>Estado</td>
            <?php if(!isset($cerrada)) { ?>
            <td></td>
            <?php } ?>
            <td style="text-align:center"><input type="checkbox" onclick="marcar(this);" /></td>
        </tr>    
    <?php
        $tiempos = array(
			"0"=>"1er Plato",
			"15"=>"2do Plato",
                        "99"=>"3er Plato"
			
        );
        $total = 0;
        
        while ($row = $conexion->getFetchObject()) {        
            if($row->estado_id==1){ // TOMANDO PEDIDO
                ?>
                <tr class="pedido">
                    <td style="text-align: left; ">
                        <a href="javascript: fn_mostrar_frm_modificar(<?=$row->id?>);"><img class="editarComanda"  src="../img/reload.gif" /></a><?=utf8_encode($row->descripcion)." "?></td>
                    <td><?php if($row->cantidad>1) echo "<a href='javascript: fn_restar(".$row->id.");'><img class='agregaCantidad' src='../img/menos1.gif' /></a> "?><?=$row->cantidad." "?><a href="javascript: fn_sumar(<?=$row->id?>);"><img class="agregaCantidad" src="../img/mas1.gif" /></a>
                    </td>
                    <td><?="$ ".$row->precio_unitario?></td>
                    <td><div class="text" style="display: inline" id="descuento-<?php echo $row->id ?>"><?php echo $row->descuento; ?></div>&nbsp;%</td>     
                    <td><?="$ ".  number_format(($row->cantidad*($row->precio_unitario-($row->descuento*$row->precio_unitario/100))),2);?></td>          
                    <td><div class="textarea" id="observaciones-<?php echo $row->id ?>"><?php echo $row->observaciones?></div></td>                 
                    <td><div class="textarea" id="observaciontiempo-<?php echo $row->id ?>"><?php echo $row->observaciontiempo ?></div></td>                 
                    <td><?php echo $row->horafinal; ?></td>
                    <td>
                    <?php if($row->tipo_receta_id!=4){?>
                        <div class="select" id="tiempo-<?php echo $row->id ?>"><?php echo $tiempos[$row->tiempo]?><img style="margin-left:4px;" src="../img/reloj.gif" /></div>            
                    <?php } ?>
                    </td>
                    <td style="text-align: center"><?php if($row->pasa_cocina==0){?> <a href="javascript: fn_entregar(<?=$row->id?>);"><img src="../img/tomandoPedido.gif" /></a>
                    <?php } else echo "<img src='../img/tomandoPedido.gif' />";
                    echo " ".$row->hora_alta;
                    ?></td>            
                    <td style="text-align: center"><a href="javascript: fn_eliminar(<?=$row->id?>);"><img src="../img/borrar.gif" width="20px" height="20px"/></a></td>                        
                    <td style="text-align: center">
                        <?php if($row->pasa_cocina==1){?>
                            <input type="checkbox" name="reimpresion[]" value="<?=$row->id?>" checked="yes"  />
                        <?php } ?>
                    </td>
                </tr>
        <?php }       if($row->estado_id==3){   /// impreso en cocina ?>
                <tr class="cocina" >
                    <td style="text-align: left;"><?=utf8_encode($row->descripcion)." "?></td>
                    <td><?=$row->cantidad." "?><a href="javascript: fn_sumarEntregado(<?=$row->id?>);"><img class="agregaCantidad" src="../img/mas1.gif" /></a>
                    </td>
                    <td><?="$ ".$row->precio_unitario?></td>
                    <td><div class="text" style="display: inline" id="descuento-<?php echo $row->id ?>"><?php echo $row->descuento; ?></div>&nbsp;%</td>     
                    <td><?="$ ".number_format(($row->cantidad*($row->precio_unitario-($row->descuento*$row->precio_unitario/100))),2)?></td>          
                    <td><div class="textarea" id="observaciones-<?php echo $row->id ?>"><?php echo $row->observaciones?></div></td>    
                    <td><div class="textarea" id="observaciontiempo-<?php echo $row->id ?>"><?php echo $row->observaciontiempo ?></div></td>    
                    <td><?php echo $row->horafinal; ?></td>
                    <td><?php echo $tiempos[$row->tiempo]?><img style="margin-left:4px;" src="../img/reloj.gif" /></td>            
                    <td style="text-align: center"><a href="javascript: fn_entregar(<?=$row->id?>);"><?php echo "<img src='../img/enPreparacion.gif' />" ?></a><?php echo " ".$row->hora_cocina;?></td>          
                    <td style="text-align: center"><a href="javascript: fn_eliminar(<?=$row->id?>);"><img src="../img/borrar.gif" /></a></td>
                    <td style="text-align: center">                        
                        <input type="checkbox" name="reimpresion[]" value="<?=$row->id?>"   />                        
                    </td>
                </tr>
        <?php }        
            
            $total = $total + ($row->cantidad*($row->precio_unitario-($row->descuento*$row->precio_unitario/100)));
            }   
            
            $conexion->Conectar();
            $consulta = "SELECT pd.id, rm.tipo_receta_id, empleados.`apellido` AS empleado, pm.`cliente_id`, pm.mesa_nro, pm.empleado_id, rm.descripcion, pd.cantidad, pd.precio_unitario, pd.`descuento`, pd.observaciones, pd.observaciontiempo,
            DATE_FORMAT(pm.`fecha_y_hora`,'%d-%m-%Y %h:%m') AS fecha, pm.`total`, STR_TO_DATE(tiempo_preparacion, '%i') AS horafinal,
            DATE_FORMAT(pd.timestamp_entrega, '%H:%i') as hora_entregado, pd.tiempo
            FROM receta_maestros AS rm
            INNER JOIN pedido_detalles AS pd ON pd.receta_maestro_id = rm.id
            INNER JOIN pedido_maestros AS pm ON pd.pedido_maestro_id = pm.id
            INNER JOIN empleados ON pm.`empleado_id`=empleados.`id`
            INNER JOIN tipo_recetas on tipo_recetas.id=rm.tipo_receta_id
            WHERE pm.id = ".$_POST['ide_ped']." AND estado_id=2 AND pasa_cocina=1
            ORDER BY tipo_receta_id, descuento, precio_unitario, observaciones, observaciontiempo, tiempo";            
            $conexion->executeQuery($consulta);
            $conexion->Close();
            
            // comidas entregadas
            while ($row = $conexion->getFetchObject()) {  
            ?>
                <tr class="terminado" >
                    <td style="text-align: left;"><?=utf8_encode($row->descripcion)." "?></td>
                    <td><?php echo $row->cantidad." ";
                            if(!isset($cerrada)) {
                            ?><a href="javascript: fn_sumarEntregado(<?=$row->id?>);"><img class="agregaCantidad" src="../img/mas1.gif" /></a>         
                            <?php } ?>
                    </td>
                    <td><?php echo "$ ".$row->precio_unitario?></td>
                    <td>
                        <?php if(!isset($cerrada)) {?>   
                        <div class="text" style="display: inline" id="descuento-<?php echo $row->id ?>"><?php echo $row->descuento; ?></div>&nbsp;%
                        <?php } else echo $row->descuento."&nbsp;%"; ?>   
                    </td>     
                    <td><?php echo "$ ".number_format(($row->cantidad*($row->precio_unitario-($row->descuento*$row->precio_unitario/100))),2)?></td>          
                    <td><?php echo $row->observaciones?></td>                 
                    <td><?php echo $row->observaciontiempo?></td>  
                    <td><?php echo $row->horafinal; ?></td>
                    <td><?php echo $tiempos[$row->tiempo]?><img style="margin-left:4px;" src="../img/reloj.gif" /></td>            
                    <?php /* echo $row->estado */ ?> 
                    <td style="text-align: center">
                        <?php if(!isset($cerrada)) {?> 
                            <a href="javascript: fn_cocinar(<?=$row->id?>);"><?php echo "<img src='../img/entregado.gif' />"?></a>
                        <?php } else { echo "<img src='../img/entregado.gif' />"; } echo " ".$row->hora_entregado; ?>
                    </td>
                    <?php if(!isset($cerrada)) {?> 
                    <td style="text-align: center">                        
                        <a href="javascript: fn_eliminar(<?=$row->id?>);"><img src="../img/borrar.gif" /></a>                        
                    </td>
                    <?php }?> 
                    <td style="text-align: center">                                                
                    </td>
                </tr>
        <?php }
            $conexion->Conectar();
            $consulta = "SELECT pd.id, rm.tipo_receta_id, empleados.`apellido` AS empleado, pm.`cliente_id`, pm.mesa_nro, pm.empleado_id, rm.descripcion, SUM(pd.cantidad) AS cantidad, pd.precio_unitario, pd.`descuento`, pd.observaciones, pd.observaciontiempo,
            DATE_FORMAT(pm.`fecha_y_hora`,'%d-%m-%Y %h:%m') AS fecha, pm.`total`, STR_TO_DATE(tiempo_preparacion, '%i') AS horafinal,
            DATE_FORMAT(MAX(pd.timestamp_entrega), '%H:%i') as hora_entregado, pd.tiempo
            FROM receta_maestros AS rm
            INNER JOIN pedido_detalles AS pd ON pd.receta_maestro_id = rm.id
            INNER JOIN pedido_maestros AS pm ON pd.pedido_maestro_id = pm.id
            INNER JOIN empleados ON pm.`empleado_id`=empleados.`id`
            INNER JOIN tipo_recetas on tipo_recetas.id=rm.tipo_receta_id
            WHERE pm.id = ".$_POST['ide_ped']." AND estado_id=2 AND pasa_cocina=0               
            GROUP BY tipo_receta_id, descuento, precio_unitario, rm.descripcion, observaciones, observaciontiempo, tiempo ";            
            $conexion->executeQuery($consulta);
            $conexion->Close();
            
            // bebidas entregadas y agrupadas
            while ($row = $conexion->getFetchObject()) {  
            ?>
                <tr class="terminado" >
                    <td style="text-align: left;"><?=utf8_encode($row->descripcion)." "?></td>
                    <td><?=$row->cantidad." "?>
                        <?php if(!isset($cerrada)) {?> 
                            <a href="javascript: fn_sumarEntregado(<?=$row->id?>);"><img class="agregaCantidad" src="../img/mas1.gif" />
                        <?php }?> 
                        </a>                    
                    </td>
                    <td><?="$ ".$row->precio_unitario?></td>
                    <td><div class="text" style="display: inline" id="descuento-<?php echo $row->id ?>"><?php echo $row->descuento; ?></div>&nbsp;%</td>     
                    <td><?="$ ".number_format(($row->cantidad*($row->precio_unitario-($row->descuento*$row->precio_unitario/100))),2)?></td>          
                    <td><?php echo $row->observaciones?></td>    
                    <td><?php echo $row->observaciontiempo?></td>    
                    <td><?php echo $row->horafinal; ?></td>
                    <td>
                    <?php if($row->tipo_receta_id!=4){
                     echo $tiempos[$row->tiempo]?><img style="margin-left:4px;" src="../img/reloj.gif" />
                    <?php } /* echo $row->estado */ ?> 
                    </td>
                    <td style="text-align: center">
                    <?php if(!isset($cerrada)) {?> 
                        <a href="javascript: fn_tomarpedido(<?=$row->id?>);"><?php echo "<img src='../img/entregado.gif' />"?></a><?php echo " ".$row->hora_entregado; ?>
                        <?php } else { echo "<img src='../img/entregado.gif' />"; echo " ".$row->hora_entregado; } ?>
                    </td>
                    <?php if(!isset($cerrada)) {?> 
                    <td style="text-align: center"><a href="javascript: fn_eliminar(<?=$row->id?>);"><img src="../img/borrar.gif" /></a></td>
                    <?php }?> 
                    <td style="text-align: center">                                                
                    </td>
                </tr>
        <?php }
            ?>
</table>
     </form>
</div>
<?php 
if(!isset($cerrada)) { 
if(($_SESSION['usuario_nivel']=='1')||($_SESSION['usuario_nivel']=='2')) { ?>
<form action="cobrarMesa.php" method="post" name="pagar" id="two" >
    <input type="hidden" id="total" name="total" value="<?php echo $total;?>" />        
    <input type="hidden" id="ide_ped" name="ide_ped" value="<?php echo $_POST['ide_ped'];?>" />    
    <!--Descuento: <input type="text" id="descuento" name="descuento" value="0" size="2" onChange="calculaTotal(this, total.value);"/>%    -->
    
    <div class="estiloTotal"><h3>Total $ <div id="divTotal"  style="display:inline"><?php echo number_format($total,2); ?></div></h3></div>
    Paga con: $<input type="text" id="pagacon" name="pagacon" value="<?php echo $total ?>" size="8" onChange="calculaVuelto(this, total.value);"/>    
    Vuelto: $ <div id="divVuelto" style="display:inline">0.00</div>   
    <input type="submit" name="submit" class="boton_pagar" value="&nbsp;&nbsp;&nbsp;Cobrar&nbsp;&nbsp;&nbsp;">
</form> 
<?php } } else { ?>
    <div class="estiloTotal"><h3>Total $ <div id="divTotal"  style="display:inline"><?php echo number_format($total,2); ?></div></h3></div>
<?php }  ?>    
<!--</center>-->
<script language="javascript" type="text/javascript">
    $(document).ready(function(){       
        
        $('.text').editable('ajax_observacion.php', { 
            type     : 'text'           
        });
        

        $('.select').editable('ajax_observacion.php', { 
            data   : " {'0':'1er Plato','15':'2do Plato','99':'3er Plato'}",
            type   : 'select'
            
        });
        
        $('.select2').editable('ajax_observacion.php', { 
            data   : " {'1':'TOMANDO PEDIDO','2':'ENTREGADO'}",
            type   : 'select'
        });
        
        $('.select3').editable('ajax_observacion.php', { 
            data   : " {'3':'EN PREPARACION','2':'ENTREGADO'}",
            type   : 'select'
        });
         // servira para editar el textarea.
        $('.textarea').editable('ajax_observacion.php', { 
             type     : 'textarea'
             
        });        
        
    });    
    
		
</script>
<?php
} else {
    echo "<center><br/>Aún no se han cargado ítems a la mesa</center>";
}
?>