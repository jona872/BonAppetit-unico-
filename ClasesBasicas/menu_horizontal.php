<?php
 /**
 * Menu principal de la aplicacion
 * @version    1.0
 * @since      File available since Release 1.0
 *
*/

// Se chequea si existe un login
require_once ('../usuarios/aut_verifica.inc.php');
?>
<div id='menuWrapper'>
            <div id="contieneMenu">    
            <ul class='menu'>            
                <li class='top'><a class='top_link' href='../abrirMesa/index.php' accesskey="a"><span><u>A</u>brir Mesa</span></a></li>
            

            <li class='top'><a class='top_link' href='#'><span class='down'>ADM Mesas &darr;</span></a>
            <ul class='sub'>
            <li><a href='../admMesas/index.php' accesskey="m"><u>M</u>esas Abiertas</a></li>
            <li><a href='../listadoMesas' accesskey="g">Listado <u>G</u>eneral</a></li>
            </ul>
            </li>

            
            <?php if (( $_SESSION['usuario_nivel'] == "1")||( $_SESSION['usuario_nivel'] == "2")) { ?>
            <li class='top'><a class='top_link' href='#'><span class='down'>ADM Básica &darr;</span></a>
            <ul class='sub'>
                <li><a href='../admCarta' accesskey="c">ADM <u>C</u>arta</a></li>
                <li><a href='../admTipoReceta' accesskey="t">ADM <u>T</u>ipo de Plato</a></li>
                <li><a href='../admEmpleados' accesskey="e">ADM <u>E</u>mpleados</a></li>
                 <li><a href='../admClientes/' accesskey="l">ADM C<u>l</u>ientes</a></li>
            </ul>
            </li>
                
                
            <?php } ?>
            <?php if (( $_SESSION['usuario_nivel'] == "1")||( $_SESSION['usuario_nivel'] == "2")) { ?>
            <li class='top'><a class='top_link' href='#'><span class='down'>Informes &darr;</span></a>
            <ul class='sub'>
                <li><a href='../consultaPlatos' accesskey="p">Consulta General de <u>P</u>latos</a></li>
                <li><a href='../consultaIngresos' accesskey="i">Consulta <u>I</u>ngresos</a></li>
            </ul>
            </li>
                
                
            <?php } ?>
            <?php if (( $_SESSION['usuario_nivel'] == "1")||( $_SESSION['usuario_nivel'] == "2")) { ?>
<!--            <li class='top'><a class='top_link' href='#'><span class='down'>Empleados &darr;</span></a>
            <ul class='sub'>
            
           <li><a class='fly' href='#'>Pesta&ntilde;a 4.2</a>
            <ul>
            <li><a href='URL del enlace'>Pesta&ntilde;a 4.2.1</a></li>
            <li><a href='URL del enlace'>Pesta&ntilde;a 4.2.2</a></li>
            <li><a href='URL del enlace'>Pesta&ntilde;a 4.2.3</a></li>
            <li><a href='URL del enlace'>Pesta&ntilde;a 4.2.4</a></li>
            <li><a href='URL del enlace'>Pesta&ntilde;a 4.2.5</a></li>
            <li><a href='URL del enlace'>Pesta&ntilde;a 4.2.6</a></li>
            </ul>
            </li>
            <li><a href='URL del enlace'>Pesta&ntilde;a 4.3</a></li>
            <li><a href='URL del enlace'>Pesta&ntilde;a 4.4</a></li>
            <li><a href='URL del enlace'>Pesta&ntilde;a 4.5</a></li>
            <li><a href='URL del enlace'>Pesta&ntilde;a 4.6</a></li>
            </ul>
            </li>-->
            <?php } ?>
            
            <li class='top'><a class='top_link' href='#'><span class='down'>ADM Usuarios &darr;</span></a>
                <ul class="sub">
                <?php if ( $_SESSION['usuario_nivel'] == "1") { ?>
                <li><a href="../usuarios/nuevoUsuario.php" accesskey="n">Ingresar <u>N</u>uevo</a></li>
                <li><a href="../usuarios/aut_listar.php" accesskey="r">Listado Gene<u>r</u>al</a></li>
                <?php } ?>
                <li><a href="../usuarios/aut_form_clave.php" accesskey="v">Actualizar Cla<u>v</u>e Actual</a></li>
                </ul>
             </li>         
                    
            </ul>
    </div>
</div>
