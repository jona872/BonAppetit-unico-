<?php
/**
 * Archivo de ingreso del usuario y la contraseña
 *
 * @version    1.0
 * @since      File available since Release 1.0
 *
*/
// No almacenar en el cache del navegador esta pagina.
header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");             		// Expira en fecha pasada
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");		// Siempre pagina modificada
header("Cache-Control: no-cache, must-revalidate");           		// HTTP/1.1
header("Pragma: no-cache");                                   		// HTTP/1.0

// Se inicia o reanuda una sesion
$nombre = explode("/", $_SERVER['PHP_SELF']);
session_name('sistema');

session_start();
// Se genera el token para evitar ataques
$token = md5(uniqid(rand(), true));

// Se guarda el token en la sesion
$_SESSION['token'] = $token;

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="es" xml:lang="es">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Bon Appetit</title>
    <link rel="shortcut icon" href="../img/favicon.ico" />
    <style type="text/css">
            html,
            body {
               margin:0;
               padding:0;
               height:100%;
               font-family: "Century Gothic";
               color: #222222;
               font-size: 12px;
               background-color: #F2F2F2;
            }
            .body{
                position: absolute;
                top: 20px;
                left: 0px;
                right: 0px;
                bottom: 0px;
                width: auto;
                height: auto;
                background-image: url(../images/Restaurant.jpg);
                background-size: cover;
                -webkit-filter: blur(4px);
                z-index: 0;
            }
            #wrapper {
               min-height:100%;
               position:relative;
            }
            #header {
               background-color:#333333;
               padding:10px;
               color:#fff;
            }
            #body {
               padding:10px;
               padding-bottom:150px;	/* Altura del footer */
            }
            #footer {
               position:absolute;
               bottom:0;
               width:100%;
               height:30px;   			/* Altura del footer */
               background-color:#333333;
            }

            #login{
                background-color:#333333;
                width: 700px;                
                position: absolute;
                top: 50%; /* Buscamos el centro horizontal (relativo) del navegador */
                left: 50%; /* Buscamos el centro vertical (relativo) del navegador */
                width: 700 px; /* Definimos el ancho del objeto a centrar */
                height: 280px; /* Definimos el alto del objeto a centrar */
                margin-top: -132px; /* Restamos la mitad de la altura del objeto con un margin-top */
                margin-left: -350px; /* Restamos la mitad de la anchura del objeto con un margin-left */

            }

            #login #titulo{
                background-color: #222222;
                height: 95px;
                vertical-align: middle;
                font-size: 15px;
                color: #F86C52;

            }


            #fecha{
                color:#F86C52;
                font-size: 0.8em; 
            }

            #fecha span{
                color:#F2F2F2;
            }


            /* input*/

            input[type=text], input[type=submit], input[type=password] {
                padding: 6px;
                background-color: #222222;
                color:#F2F2F2;
                font-family: "Century Gothic";
                font-size: 1 em;
                border: none;
              
              
                border:solid 1px #222222;
                padding:5px;

            }
            
            input[type=submit] {    
                cursor: pointer;
            }
            h1 {
                font-size: 1em;
            }

        </style>
</head>
<body onload="formu.user.focus()">
<div id="wrapper">
    
    <div id="header">
    </div><div class="body"></div>
    <div id="body">
        <div id="login">
            <div id="titulo"> 
                <div style="float: left; margin:10px 80px 10px 20px;"><img src="..\img\titulo.png" /></div><div style="padding-top: 25px; ">Inicio de Sesión<br><div id="fecha">Fecha&nbsp;&nbsp;<span><?php echo date('d-m-Y'); ?></span></div></div>                        
                <br/><br/>
                <form  action="aut_verifica_ingreso.php" method="post" class="formLogin" name="formu" autocomplete="off">
                <input type='hidden' name='token' value="<?php  echo $token ?>" />
                <div style="width: 100%; height: 100%; text-align:left; color: #F2F2F2;">
                    <div style="padding: 15px 0px 10px 80px;"><div style="width: 170px; float: left;">Nombre de Usuario</div><div> <input type="text" name="user" size="30" id="username"/></div></div>
                    <div style="padding: 5px 0px 10px 80px;"><div style="width: 170px; float: left">Clave</div> <div><input type="password" name="pass" size="30" id="password" /></div></div>                            
                    <div style="text-align: center;"><input name="Entrar" type="submit"  value="&nbsp;Ingresar&nbsp;"  /></div>
                    <div style="text-align: center; padding-top: 10px; color: #F86C52;"><?php if(isset ($_SESSION['error_login']) ) echo $_SESSION['error_login']; ?></div>
                </div>
                <br/>
                
                </form>    

            </div>
        </div>
    </div>
    <div id="footer">
        <div style="text-align: center; padding-top: 5px;"><img src="..\img\loguito.png" /></div>
    </div>
</div>   
</body>
</html>