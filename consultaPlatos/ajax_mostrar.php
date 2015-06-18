<?php
// Se chequea si existe un login
require_once '../usuarios/aut_verifica.inc.php';

// Se requieren los script para acceder a los datos de la DB
require_once '../ClasesBasicas/ActiveRecordAbstractFactory.php';
require_once '../Clases/ActiveRecord/MysqlOrdenActiveRecord.php';
require_once '../Clases/ActiveRecord/MysqlProblemaActiveRecord.php';
include_once 'funciones.php';

$oMysql = ActiveRecordAbstractFactory::getActiveRecordFactory(ActiveRecordAbstractFactory::MYSQL);
$oMysql->conectar();

$oMysqlOrden = $oMysql->getOrdenActiveRecord();
$oOrden = new OrdenValueObject();

$oOrden->setNro($_GET['nro']);
$oOrden = $oMysqlOrden->find($oOrden);
if ($oOrden==false){
        echo "La orden de trabajo no existe";
        exit;
}

?>
<!DOCTYPE html>
<html>
<head>    
    <title>ODT</title>
    <link rel="shortcut icon" href="../images/ingreso.ico" />    
    <link rel="stylesheet" href="../css/estilos.css" type="text/css" />      	   
    <script language="javascript" type="text/javascript" src="js/jquery-1.4.3.min.js"></script>
    <script language="javascript" type="text/javascript" src="js/index.js"></script>      
</head>
<body>
<div class="contenedor">
<header> <?php include_once '../ClasesBasicas/Encabezado.php'; ?> </header>
<div id="cuerpo">
<h1>Informaci&oacute;n Adicional de la Orden de Trabajo</h1>
    <input type="hidden" id="cue" name="cue" value="<?=$oOrden->getNro()?>" />
    <table class="formulario">
        <tbody>
            <tr>
                <td>Nro OT:</td>
                <td><strong><?=$oOrden->getNro()?></strong></td>         
            </tr>
            <tr>
                  
                <td>Recepci&oacute;n del pedido:</td>
                <td><strong><?php
                    switch ($oOrden->getTipoRecepcion()) {
                        case 0:
                            echo "Telef&oacute;nicamente";
                            break;
                        case 1:
                            echo "Personalmente";
                            break;
                        default:
                            echo "Otra";
                            break;
                    }                                    
                    ?></strong>
                </td>
            </tr>
            <tr>
                <td>Descripci&oacute;n del Problema:</td>
                <td><strong><?=$oOrden->getDescripcion()?></strong></td>
            </tr>                     
            <?php
            $oMysqlProblema = $oMysql->getProblemaActiveRecord();
            $oProblema = new ProblemaValueObject();
            $oProblema->setId($oOrden->getIdProblema());
            $oProblema=$oMysqlProblema->find($oProblema);  
            ?>
            <tr>
                <td>Observaci&oacute;n del Problema:</td>
                <td><strong><?=$oProblema->getObservacion()?></strong></td>
            </tr> 
            <tr><td>
                 Forma de Finalizaci&oacute;n:</td>
                <td><strong>
                    <?php
                    if($oOrden->getFormaFinalizacion()==2) echo "Solucionado<br/>";
                    if($oOrden->getFormaFinalizacion()==3) echo "No Solucionado<br/>";
                    echo $oOrden->getObservacion();
                        ?>   
                </strong></td></tr>
            <tr>
                <td></td>
            </tr>
        </tbody>
        <tfoot>
            <tr>
                <td colspan="2">                    
                    <input name="regresar" type="button" id="Regresar" value="&nbsp;&nbsp;&nbsp;Regresar&nbsp;&nbsp;&nbsp;" onclick="location.href='index.php?nro=<?php echo $_GET['nro']?>'" class="button"/>
                </td>
            </tr>
        </tfoot>
    </table>
</div>
<footer><?php include_once '../ClasesBasicas/Pie.php'; ?></footer>
</div>
</body>
</html>