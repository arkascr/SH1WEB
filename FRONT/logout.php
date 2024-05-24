<?php
session_start(); // Iniciar la sesión si aún no está iniciada

// Destruir todas las variables de sesión
$_SESSION = array();

// Borrar la cookie de sesión
if (isset($_COOKIE[session_name()])) {
    setcookie(session_name(), '', time() - 42000, '/');
}

// Destruir la sesión
session_destroy();

// Redirigir a la página de inicio de sesión u otra página deseada
header("Location: index.php"); // Reemplaza 'login.php' con la ruta de tu página de inicio de sesión
exit;
?>
