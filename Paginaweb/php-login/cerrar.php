<?php
// Inicia la sesión si aún no se ha iniciado
session_start();

// Destruye todas las variables de sesión
$_SESSION = array();

// Borra la cookie de sesión si está establecida
if (isset($_COOKIE[session_name()])) {
    setcookie(session_name(), '', time()-42000, '/');
}

// Destruye la sesión 
session_destroy();

// Redirige al usuario a la página de inicio de sesión
header("Location: http://localhost/Paginaweb");
exit;
?>
