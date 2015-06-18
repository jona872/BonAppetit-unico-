<?php
/**
**
 */

require_once ('../usuarios/aut_verifica.inc.php');
?>
<div id="header" style="z-index: 10000">        
    <div id="encabezado">
        <div style="float: left; margin:10px 0px 0px 0px;"><a href="../admMesas/index.php" ><img src="..\img\titulo.png" /></a></div>
        <div id="salir">
            <a href="../usuarios/logout.php" ><img src="../img/salir.png" /></a>
        </div>
        <div style="padding-top: 25px; "><div id="usuario">Bienvenido/a&nbsp;&nbsp;<span><?php  echo $_SESSION['usuario_nombre']; ?></span></div>
        <br/>
        <div id="fecha">Fecha&nbsp;&nbsp;<span><?php echo date('d-m-Y'); ?></span></div></div>
    </div>   
    <?php
//hola
    include_once ('../ClasesBasicas/menu_horizontal.php');
    ?>
</div>
