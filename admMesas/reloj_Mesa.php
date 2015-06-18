<?php
/// busca las mesas para mostrarlas
require_once '../ClasesBasicas/ConsultaBD.php';
$conexion = new ConsultaBD();
$conexion->Conectar();
// busqueda del usuario por nombre y password
$sql = "SELECT id, mesa_nro, DATE_FORMAT(fecha_y_hora, '%T') AS hora, cantidad_de_comensales,SEC_TO_TIME(TIMESTAMPDIFF(SECOND, timestamp_ticket, NOW())) horasCobrar,
SEC_TO_TIME(TIMESTAMPDIFF(SECOND, fecha_y_hora, NOW())) horas, finalizado, total
FROM pedido_maestros WHERE pedido_maestros.id=".$_GET['id']." and finalizado<>1 ORDER BY mesa_nro";
$conexion->executeQuery($sql);
$conexion->Close();
if ($conexion->getNumRows()<>0) {
    while ($row = $conexion->getFetchObject()) {        
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
                $sql_hora = "SELECT timestamp_cocina, SEC_TO_TIME(TIMESTAMPDIFF(SECOND,  timestamp_cocina, NOW())) horas, ADDTIME(STR_TO_DATE(tiempo_preparacion, '%i'), STR_TO_DATE(tiempo, '%i')) AS horafinal
                FROM pedido_detalles
                INNER JOIN receta_maestros ON receta_maestros.`id`=pedido_detalles.`receta_maestro_id`
                INNER JOIN tipo_recetas ON tipo_recetas.`id`=receta_maestros.`tipo_receta_id`
                WHERE pedido_maestro_id=".$row->id." AND pedido_detalles.`estado_id`=3 ORDER BY timestamp_cocina DESC, horafinal DESC LIMIT 1";
                $conexion2->executeQuery($sql_hora);
                $row_hora = $conexion2->getFetchRow();                
                $pm_hora = trim($row_hora[2]);
                if($pm_hora<>'') {
                    if($row_hora[1]>$pm_hora)
                         // mesa ocupada con pedidos impresos en cocina, con alert xq ya paso el tiempo limite
                        echo "<div class='mesaA' style='width:150px; height:70px'><div class='numero' style='font-size:28px'>".$row->mesa_nro."</div><div class='pedido'><img src='../img/pizza.png' /><span style='font-size: 16px; color: #000'>".$pm_id."</span></div><div style='text-align:center'>Cocina</div><div class='reloj'>".$row_hora[1]." ".$pm_hora."</div></div>";
                    else
                        // mesa ocupada con pedidos impresos en cocina, sin alert xq no paso el tiempo limite
                        echo "<div class='mesaO' style='width:150px; height:70px'><div class='numero'style='font-size:28px'>".$row->mesa_nro."</div><div class='pedido'><img src='../img/pizza.png' /><span style='font-size: 16px; color: #000'>".$pm_id."</span></div><div style='text-align:center'>Cocina</div><div class='reloj'>".$row_hora[1]." ".$pm_hora."</div></div>";
                }  else {
                    $sql_hora = "SELECT SEC_TO_TIME(TIMESTAMPDIFF(SECOND,  timestamp_alta, NOW())) horas
                    FROM pedido_detalles
                    WHERE pedido_maestro_id=".$row->id." AND pedido_detalles.`estado_id`=1 ORDER BY timestamp_alta DESC LIMIT 1";
                    $conexion2->executeQuery($sql_hora);
                    $row_hora = $conexion2->getFetchRow();                
                    $pm_alta = trim($row_hora[0]);
                    if($pm_alta<>'') {
                        // mesa ocupada sin pedidos impresos en cocina, pero con pedidos a la mesa
                        echo "<div class='mesaO' style='width:150px; height:70px'><div class='numero' style='font-size:28px'>".$row->mesa_nro."</div><div style='text-align:center'>Último Pedido</div><div class='reloj'>".$pm_alta."</div></div>";
                    } else {
                        $sql_hora = "SELECT SEC_TO_TIME(TIMESTAMPDIFF(SECOND,  timestamp_entrega, NOW())) horas
                        FROM pedido_detalles
                        WHERE pedido_maestro_id=".$row->id." AND pedido_detalles.`estado_id`=2 ORDER BY timestamp_entrega DESC LIMIT 1";
                        $conexion2->executeQuery($sql_hora);
                        $row_hora = $conexion2->getFetchRow();                
                        $pm_ent = trim($row_hora[0]);
                        // mesa ocupada sin pedidos impresos en cocina y todos los pedidos entregados
                        echo "<div class='mesaO' style='width:150px; height:70px'><div class='numero' style='font-size:28px'>".$row->mesa_nro."</div><div style='text-align:center'>Entregado</div><div class='reloj'>".$pm_ent."</div></div>";
                    }
                }
                $conexion2->Close();
                break;
            case 2: // cobrando                
                echo "<div class='mesaC' style='width:150px; height:70px'><div class='numero' style='font-size:28px'>".$row->mesa_nro."</div><div style='text-align:center'>Cobrando</div><div class='reloj'>".$row->horasCobrar."</div></div>";
                break;
            case 0: // creada            
                echo "<div class='mesa' style='width:150px; height:70px'><div class='numero'  style='font-size:28px'>".$row->mesa_nro."</div><div style='text-align:center'>Creada</div><div class='reloj'>".$row->horas."</div></div>";                
                break;                                          
    //    echo "<p style=\"background-color:#FF7400\">".$row->horas." ".$row->mesa_nro." ".$row->hora."</p>";           
        }
    }                        
}
?>
