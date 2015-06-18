<?php
/**
 * Archivo que verifica que exista login del usuario
 * caso contrario redirige al logout
 *
 * @version    1.0
 * @since      File available since Release 1.1
 *
*/

// Se inicia o reanuda una sesion
session_name('sistema');
session_start();

//basename(getcwd())
// Verificar que hay login
// Verificar que el usuario se encuentra registrado
if ($_SESSION['usuarioRegistrado']==false) {
	header("Location: ../usuarios/logout.php");
}
// Verificar si el usuario se encuentra habilitado
if ($_SESSION['fechaBaja']!='0000-00-00 00:00:00') {
	header("Location: ../usuarios/logout.php");
}

// Verificar que el usuario tenga un nro de id
if ($_SESSION['usuario_id']=='') {
	header("Location: ../usuarios/logout.php");
}

// Verificar si el usuario un nivel de usuario
if ($_SESSION['usuario_nivel']=='') {
	header("Location: ../usuarios/logout.php");
}

// Verificar si el usuario posee un username
if ($_SESSION['usuario_login']=='') {
	header("Location: ../usuarios/logout.php");
}
// Verificar si el usuario posee una password
if ($_SESSION['usuario_password']=='') {
	header("Location: ../usuarios/logout.php");
}
// Verificar que el user-agent + la palabra secreta sean iguales
if ($_SESSION['http-user-agent'] != md5($_SERVER['HTTP_USER_AGENT'].'palabraSecreta')) {
	header("Location: ../usuarios/logout.php");
}
?>