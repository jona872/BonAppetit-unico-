<?php
/// busca las mesas para mostrarlas
require_once '../ClasesBasicas/ConsultaBD.php';
$tipo = $_GET['tipo'];
$conexion = new ConsultaBD();
$conexion->Conectar();
$sql = "SELECT id, mesa_nro, DATE_FORMAT(fecha_y_hora, '%T') AS hora, cantidad_de_comensales,SEC_TO_TIME(TIMESTAMPDIFF(SECOND, timestamp_ticket, NOW())) horasCobrar,
SEC_TO_TIME(TIMESTAMPDIFF(SECOND, fecha_y_hora, NOW())) horas, finalizado, total
FROM pedido_maestros WHERE finalizado<>1";
if($tipo<>0) $sql.=" and ubicacion_id=$tipo ";
$sql.=" ORDER BY mesa_nro";
$conexion->executeQuery($sql);
$conexion->Close();
if ($conexion->getNumRows()<>0) {
    while ($row = $conexion->getFetchObject()) {            
        if(($row->mesa_nro>10)){
            if($ent<>1) {
                $ent=1;
                echo "<div style='display:block; width:62%; height: 60px;'></div>";
            }        
        }        
        if(($row->mesa_nro>19)){
            if($ent2<>1) {
                $ent2=1;
                echo "<div style='display:block; width:62%; height: 60px;'></div>";
            }        
        }
        if(($row->mesa_nro>29)){
            if($ent3<>1) {
                $ent3=1;
                echo "<div style='display:block; width:62%; height: 60px;'></div>";
            }        
        }
        if(($row->mesa_nro>39)){
            if($ent4<>1) {
                $ent4=1;
                echo "<div style='display:block; width:62%; height: 60px;'></div>";
            }        
        }
        if(($row->mesa_nro>49)){
            if($ent5<>1) {
                $ent5=1;
                echo "<div style='display:block; width:62%; height: 60px;'></div>";
            }        
        }
        if(($row->mesa_nro>59)){
            if($ent6<>1) {
                $ent6=1;
                echo "<div style='display:block; width:62%; height: 60px;'></div>";
            }        
        }
        if(($row->mesa_nro>69)){
            if($ent7<>1) {
                $ent7=1;
                echo "<div style='display:block; width:62%; height: 60px;'></div>";
            }        
        }
        if(($row->mesa_nro>79)){
            if($ent8<>1) {
                $ent8=1;
                echo "<div style='display:block; width:62%; height: 60px;'></div>";
            }        
        }
        if(($row->mesa_nro>89)){
            if($ent9<>1) {
                $ent9=1;
                echo "<div style='display:block; width:62%; height: 60px;'></div>";
            }        
        }
        if(($row->mesa_nro>99)){
            if($ent10<>1) {
                $ent10=1;
                echo "<div style='display:block; width:62%; height: 60px;'></div>";
            }        
        }
        if(($row->mesa_nro>109)){
            if($ent11<>1) {
                $ent11=1;
                echo "<div style='display:block; width:62%; height: 60px;'></div>";
            }        
        }
        if(($row->mesa_nro>119)){
            if($ent12<>1) {
                $ent12=1;
                echo "<div style='display:block; width:62%; height: 60px;'></div>";
            }        
        }
        if(($row->mesa_nro>129)){
            if($ent13<>1) {
                $ent13=1;
                echo "<div style='display:block; width:62%; height: 60px;'></div>";
            }        
        }
        if(($row->mesa_nro>139)){
            if($ent14<>1) {
                $ent14=1;
                echo "<div style='display:block; width:62%; height: 60px;'></div>";
            }        
        }
        if(($row->mesa_nro>149)){
            if($ent15<>1) {
                $ent15=1;
                echo "<div style='display:block; width:62%; height: 60px;'></div>";
            }        
        }
        if(($row->mesa_nro>159)){
            if($ent16<>1) {
                $ent16=1;
                echo "<div style='display:block; width:62%; height: 60px;'></div>";
            }        
        }
        switch ($row->finalizado) {
            case 9: // tomando pedido
                $conexion2 = new ConsultaBD();
                $conexion2->Conectar();
                // impreso en cocina
                $sql_det="SELECT COUNT(*) AS cantidad FROM pedido_detalles 
                INNER JOIN receta_maestros ON pedido_detalles.`receta_maestro_id`=receta_maestros.id
                WHERE pedido_detalles.`pedido_maestro_id`=".$row->id." AND receta_maestros.`tipo_receta_id`<>4 AND pedido_detalles.`estado_id`=3";
                $conexion2->executeQuery($sql_det);
                $row_id = $conexion2->getFetchRow();                
                $pm_id = trim($row_id[0]);
                
                // pedido sin imprimir en cocina
//                $sql_det1="SELECT COUNT(*) AS cantidad FROM pedido_detalles 
//                INNER JOIN receta_maestros ON pedido_detalles.`receta_maestro_id`=receta_maestros.id
//                WHERE pedido_detalles.`pedido_maestro_id`=".$row->id." AND receta_maestros.`tipo_receta_id`<>4 AND pedido_detalles.`estado_id`=1";  
                $sql_det1="SELECT COUNT(*) AS cantidad FROM pedido_detalles "
                        . "INNER JOIN receta_maestros ON pedido_detalles.`receta_maestro_id`=receta_maestros.id "
                        . "INNER JOIN tipo_recetas ON receta_maestros.`tipo_receta_id`=tipo_recetas.`id` "
                        . "WHERE pedido_detalles.`pedido_maestro_id`=".$row->id."  "
                        . "AND tipo_recetas.`pasa_cocina`<>0 AND pedido_detalles.`estado_id`=1";
         
                $conexion2->executeQuery($sql_det1);
                $row_id1 = $conexion2->getFetchRow();                
                $sin_imprimir = trim($row_id1[0]);
                
                $sql_hora = "SELECT timestamp_cocina, SEC_TO_TIME(TIMESTAMPDIFF(SECOND,  timestamp_cocina, NOW())) horas, ADDTIME(STR_TO_DATE(tiempo_preparacion, '%i'), STR_TO_DATE(tiempo, '%i')) AS horafinal
                FROM pedido_detalles
                INNER JOIN receta_maestros ON receta_maestros.`id`=pedido_detalles.`receta_maestro_id`
                INNER JOIN tipo_recetas ON tipo_recetas.`id`=receta_maestros.`tipo_receta_id`
                WHERE pedido_maestro_id=".$row->id." AND pedido_detalles.`estado_id`=3 ORDER BY timestamp_cocina DESC, horafinal DESC LIMIT 1";
                $conexion2->executeQuery($sql_hora);
                $row_hora = $conexion2->getFetchRow();                
                $pm_hora = trim($row_hora[2]);
                if($pm_hora<>'') {
                if($row_hora[1]>$pm_hora) {
                    // mesa ocupada con pedidos impresos en cocina, con alert xq ya paso el tiempo limite
                    echo "<a href='pedidos.php?p=".$row->id."'><div class='mesaA'><div class='numero'>".$row->mesa_nro."</div><div class='personas'><img src='../img/personasB.png' />".$row->cantidad_de_comensales."</div><div class='pedido'><img src='../img/pizzaB.png' /><span>".$pm_id."</span></div>";
                    if($sin_imprimir<>0) {
                        echo "<div class='reloj' style='background-color:#FE5F04; '>".$row->horas."</div></div></a>";
                    } else echo "<div class='reloj' >".$row->horas."</div></div></a>";
                } else {
                    // mesa ocupada con pedidos impresos en cocina, sin alert xq no paso el tiempo limite
                    echo "<a href='pedidos.php?p=".$row->id."'><div class='mesaO' style='background-color: #DF2222'><div class='numero'>".$row->mesa_nro."</div><div class='personas'><img src='../img/personas.png' />".$row->cantidad_de_comensales."</div><div class='pedido'><img src='../img/pizza.png' /><span>".$pm_id."</span></div>";                    
                    
                    if($sin_imprimir<>0) {
                        echo "<div class='reloj' style='background-color:#FE5F04;'>".$row->horas."</div></div></a>";
                    } else echo "<div class='reloj'>".$row->horas."</div></div></a>";
                }
                }  else {
                    $sql_hora = "SELECT SEC_TO_TIME(TIMESTAMPDIFF(SECOND,  timestamp_alta, NOW())) horas
                    FROM pedido_detalles
                    WHERE pedido_maestro_id=".$row->id." AND pedido_detalles.`estado_id`=1 ORDER BY timestamp_alta DESC LIMIT 1";
                    $conexion2->executeQuery($sql_hora);
                    $row_hora = $conexion2->getFetchRow();                
                    $pm_alta = trim($row_hora[0]);
                    if($pm_alta<>'') {
                        // mesa ocupada sin pedidos impresos en cocina, pero con pedidos a la mesa
                        echo "<a href='pedidos.php?p=".$row->id."'><div class='mesaO' style='background-color: #FE5F04'><div class='numero'>".$row->mesa_nro."</div><div class='personas'><img src='../img/personas.png' />".$row->cantidad_de_comensales."</div><div class='pedido'><img src='../img/pizza.png' /><span>".$pm_id."</span></div>";
                        if($sin_imprimir<>0) {
                            echo "<div class='reloj' style='background-color:#FE5F04;'>".$row->horas."</div></div></a>";
                        } else echo "<div class='reloj'>".$row->horas."</div></div></a>";
                    } else {
                        $sql_hora = "SELECT SEC_TO_TIME(TIMESTAMPDIFF(SECOND,  timestamp_entrega, NOW())) horas
                        FROM pedido_detalles
                        WHERE pedido_maestro_id=".$row->id." AND pedido_detalles.`estado_id`=2 ORDER BY timestamp_entrega DESC LIMIT 1";
                        $conexion2->executeQuery($sql_hora);
                        $row_hora = $conexion2->getFetchRow();                
                        $pm_ent = trim($row_hora[0]);
                        // mesa ocupada sin pedidos impresos en cocina y todos los pedidos entregados
                        echo "<a href='pedidos.php?p=".$row->id."'><div class='mesaO' style='background-color: #B00B67'><div class='numero'>".$row->mesa_nro."</div><div class='personas'><img src='../img/personas.png' />".$row->cantidad_de_comensales."</div><div class='pedido'><img src='../img/pizza.png' /><span>".$pm_id."</span></div>";
                        if($sin_imprimir<>0) {
                            echo "<div class='reloj' style='background-color:#FE5F04;'>".$row->horas."</div></div></a>";
                        } else echo "<div class='reloj'>".$row->horas."</div></div></a>";
                    }
                }
                $conexion2->Close();
                break;
            case 2: // cobrando
                echo "<a href='pedidos.php?p=".$row->id."'><div class='mesaC'><div class='numero'>".$row->mesa_nro."</div><div class='personas'><img src='../img/personas.png' />".$row->cantidad_de_comensales."</div><div class='reloj'>".$row->horas."</div></div></a>";
                break;
            case 0: // creada            
                echo "<a href='pedidos.php?p=".$row->id."'><div class='mesa'><div class='numero'>".$row->mesa_nro."</div><div class='personas'><img src='../img/personas.png' />".$row->cantidad_de_comensales."</div><div class='reloj'>".$row->horas."</div></div></a>";                
                break;
        }
            
        
            
            
    //    echo "<p style=\"background-color:#FF7400\">".$row->horas." ".$row->mesa_nro." ".$row->hora."</p>";           
     
    }                        
}
?>