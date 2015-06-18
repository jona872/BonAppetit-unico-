<?php
/**
 * Archivo de mensajes
 *
 *
 * @copyright  Copyright (c) 2010 INFORMATICA MINISTERIO DE SALUD
 * @version    1.0
 * @since      File available since Release 1.0
 *
*/
require_once '../aut_verifica.inc.php';
if(isset($_GET['pag'])) 
$pag = "../".$_GET['pag'];
$mensaje = $_GET['msj'];
$id = $_GET['id'];
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<link href="../../css/estilos.css" rel="stylesheet" type="text/css" />
</head>
<body>
<center>
<br/><br/>
    <?php
    switch ($mensaje) {
        case 1:     
            echo "<div class=exito>Los datos se actualizaron con exito</div>";
            ?> <meta http-equiv="refresh" content="2; url='<?php echo $pag ?>'" />
            <?php 
            break;
        case 2:
            echo "<div class=error>Ha ocurrido un error intentando guardar los datos</div>";
            ?> <meta http-equiv="refresh" content="2; url='<?php echo $pag ?>'" />
            <?php
            break;
        case 3:
            echo "<div class=error>Ha ocurrido un error intentando actualizar los datos</div>";
            ?> <meta http-equiv="refresh" content="2; url='<?php echo $pag ?>'" />
            <?php
            break;
        case 4:
            ?>  <div class="confirma">&iquest;Desea activar el usuario&#63;
                <br/><br/>
                <a href=<?php echo "../aut_modifica_usuario.php?accion=activar&id=".$id ?> class="button">Aceptar</a>&nbsp;
                <a href="../aut_lista_usuarios.php?go=1" class="button">Cancelar</a>
                </div>
            <?php
            break;
        case 5:
            ?>  <div class="confirma">&iquest;Desea desactivar el usuario&#63;
                <br/><br/>
                <a href="<?php echo "../aut_modifica_usuario.php?accion=desactivar&id=".$id ?>" class="button">Aceptar</a>&nbsp;
                <a href="../aut_lista_usuarios.php?go=1" class="button">Cancelar</a>
                </div>
            <?php
            break;
    } ?>
</center>
</body>
</html>
