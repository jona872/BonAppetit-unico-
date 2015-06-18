<?php
/**
 * Limpia las variables de sesion, destruye la sesion y redirige al formulario de login *
 *
 * @version    1.0
 * @since      File available since Release 1.0
 *
*/

// Se inicia o reanuda una sesion
session_name('sistema');
session_start();

// Se destruyen las variables de sesion

unset($_SESSION['usuarioRegistrado']);
unset($_SESSION['usuario_id']);
unset($_SESSION['usuario_nivel']);
unset($_SESSION['usuario_login']);
unset($_SESSION['usuario_password']);
unset($_SESSION['error_login']);
unset($_SESSION['http-user-agent']);


session_destroy();

header("Location: ingreso.php");