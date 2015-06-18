<?php
/**
 * @version    1.0
 * @since      File available since Release 1.0
 * 
*/
// Se chequea si existe un login
require_once '../usuarios/aut_verifica.inc.php';
require_once '../ClasesBasicas/ConsultaBD.php';
require_once "../ClasesBasicas/PHPPaging.lib.php";
require_once "../ClasesBasicas/basico.php";

header ("Expires: Fri, 14 Mar 1980 20:53:00 GMT"); //la pagina expira en fecha pasada
header ("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT"); //ultima actualizacion ahora cuando la cargamos
header ("Cache-Control: no-cache, must-revalidate"); //no guardar en CACHE
header ("Pragma: no-cache"); //PARANOIA, NO GUARDAR EN CACHE

$conexion = new ConsultaBD();
$conexion->Conectar();
$paging = new PHPPaging;
$sql = "select empleados.*,tipo_empleados.descripcion as tipo_empleados from empleados";
$sql.=" INNER JOIN tipo_empleados on empleados.tipo_empleado_id=tipo_empleados.id ";
$sql.=" WHERE fecha_baja is null ";
if (isset($_GET['criterio_buscar']))
        $sql .= " AND empleados.descripcion like '%".fn_filtro(substr($_GET['criterio_buscar'], 0, 16))."%'";
if (isset($_GET['criterio_ordenar_por']))
        $sql .= sprintf(" order by %s %s", fn_filtro($_GET['criterio_ordenar_por']), fn_filtro($_GET['criterio_orden']));
else
        $sql .= " order by id desc";
$paging->agregarConsulta($sql); 
$paging->div('div_listar');
$paging->modo('desarrollo'); 
if (isset($_GET['criterio_mostrar']))
        $paging->porPagina(fn_filtro((int)$_GET['criterio_mostrar']));
$paging->verPost(true);
$paging->mantenerVar("criterio_usu_per", "criterio_ordenar_por", "criterio_orden", "criterio_mostrar");
$paging->ejecutar();
?>
<div style="width: 1000px; ">
<table id="estados" class="header" style="width: 100%;">
  <tr style="text-align: left">       
            <td>Código</td>            
            <td>DNI</td>
            <td>Apellido y Nombre</td>                        
            <td>Tipo Empleado</td>
            <td colspan="2" style="text-align: center"><a href="javascript: fn_mostrar_frm_agregar();"><img src="../img/add.png"></a></td>
        </tr>
    
    <?php
        while ($rs_per = $paging->fetchResultado()){
    ?>
        <tr style="text-align: left" id="tr_<?php echo $rs_per['id']?>">
            <td><?php echo $rs_per['id']?></td>
            <td><?php echo $rs_per['dni']?></td>
            <td><?php echo utf8_encode($rs_per['apellido'].", ".$rs_per['nombre'])?></td>            
            <td><?php echo utf8_encode($rs_per['tipo_empleados'])?></td>
            <td width="16px" ><a href="javascript: fn_mostrar_frm_modificar(<?php echo $rs_per['id']?>);"><img src="../img/reload.gif" /></a></td>
            <td width="16px" ><a href="javascript: fn_eliminar(<?php echo $rs_per['id']?>);"><img src="../img/borrar.gif" /></a></td>
        </tr>
    <?php } ?>
    <tfoot style="text-align: center">
        <tr>
            <td colspan="6">
				<?php echo $paging->fetchNavegacion()."<br/>"; ?>
</td>
        </tr>
    </tfoot>
</table><?php                

//-- Aqui MOSTRAMOS MAS DETALLADAMENTE EL PAGINADO
echo "<br/>Página: ".$paging->numEstaPagina()." de ".$paging->numTotalPaginas()."<br />
Mostrando: ".$paging->numRegistrosMostrados()." registros, del ".$paging->numPrimerRegistro()." al ".$paging->numUltimoRegistro()."<br />
De un total de: ".$paging->numTotalRegistros()?><br />
            
</div>
<!--</center>-->
