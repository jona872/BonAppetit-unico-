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
<html>
<head>        
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <title>Bon Appetit</title>
    <link rel="shortcut icon" href="../img/favicon.ico" />    
    <link rel="stylesheet" type="text/css" href="../css/menu.css"/> 
    <link rel="stylesheet" type="text/css" href="../css/estilos.css"/> 
    <link rel="stylesheet" type="text/css" href="../css/PHPPaging.lib.css"/>     
    <script language="javascript" type="text/javascript" src="js/jquery-1.4.3.min.js"></script>
    <script language="javascript" type="text/javascript" src="js/jquery.blockUI.js"></script>
    <script language="javascript" type="text/javascript" src="js/index.js"></script>   
    <script type="text/javascript" src="js/validar_fecha.js"></script>
    <script type="text/javascript" src="js/ajax-dynamic-list.js"></script>
    <script type="text/javascript" src="js/ajax.js"></script>       
    <script language="javascript" type="text/javascript" src="js/jquery-1.3.2.min.js"></script>
</head>
<body onload="document.getElementById('fechaDesde').focus();">
<div class="contenedor">
<header> <?php include_once '../ClasesBasicas/Encabezado.php'; ?> </header>
<div id="cuerpo" style="padding-bottom: 50px;"> 
    <div id="body">            
        <form action="javascript: fn_buscar();" id="frm_buscar" name="frm_buscar">
            <fieldset>       
                <div id="resultado" style="text-align: right">    
                <h1>Consulta General de Platos</h1>                                
                <cite>Fecha Desde</cite>            
                <input id="fechaDesde" name="fechaDesde" type="text"  size="14" placeholder="dd/mm/aaaa" onblur="validar_fecha(this);"  />                                
                <input id="horaDesde" name="horaDesde" type="text"  size="14" placeholder="HH:MM" onblur="validar_hora(this);" />                
                <cite>Fecha Hasta:</cite>            
                <input id="fechaHasta" name="fechaHasta" type="text"  size="14" placeholder="dd/mm/aaaa" onblur="validar_fecha(this);" />                                
                <input id="horaHasta" name="horaHasta" type="text"  size="14" placeholder="HH:MM" onblur="validar_hora(this);"/>                
                <cite>Horas:</cite>  
                <select name="intervalo" ide="intervalo" class="required">                    
                    <option value="1">Intervalo Diario</option>                    
                    <option value="0" >Completas</option>
                </select>
                  noche:  <input type=checkbox name="nocturno" id="nocturno" ><br>
                <cite>Mozo:</cite> 
                <input type="text" id="empleado" class="textolargo" name="empleado" value="" onKeyUp="ajax_showOptionsEmpleado(this,'getEmpleadoByLetters',event)" onBlur="this.style.color='#333333'" size="30"/>
                <input type="hidden" id="empleado_hidden" name="empleado_ID" value=""/>
                <br/>
                <cite>Tipo plato:</cite> 
                <select name="tipo_receta" ide="tipo_receta" class="required">     
                    <option value="">Todos</option>                        
                    <?php
                        $conexion = new ConsultaBD();
                        $conexion->Conectar();
                        $sql = "select * from tipo_recetas order by descripcion";
                        $conexion->executeQuery($sql);
                        while($rs_receta = $conexion->getFetchObject()){
                    ?>
                        <option value="<?php echo $rs_receta->id; ?>"><?php echo $rs_receta->descripcion; ?></option>
                    <?php } ?>
                </select>
                <cite>Plato:</cite>                 
                <input type="text" name="criterio_buscar" id="criterio_buscar" placeholder="Descripción a buscar" size="40"/>       
                <cite>Estado:</cite>  
                <select name="tipo_estado" ide="tipo_estado" class="required">
                    <option value="">Todos</option>
                    <option value=">">Excedido</option>
                    <option value="<">No excedido</option>                        
                </select>  
                <br/>
                <cite>Ordenar por:</cite>  
                <select name="criterio_ordenar_por" id="criterio_ordenar_por">
                    <option value="fecha_alta">Fecha y Hora</option>
                    <option value="descripcion">Plato</option>                        
                    <option value="empleado">Mozo</option>   
                    <option value="mesa_nro">Mesa</option>   
                    <option value="cantidad_comensales">Comensales</option>   
                    <option value="tipo_plato">Tipo Plato</option>    
                    <option value="cantidad">Cantidad</option>
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
        <div align="center" id="mensaje" style="color:brown; "></div>
    </form>
    <center>
    <div id="div_listar" style="margin-top: 10px;"></div>
    </center>
    <div id="div_oculto" style="display: none;"></div>        
</div>
<footer><?php include_once '../ClasesBasicas/Pie.php'; ?></footer>
</div>
</body>
</html>
