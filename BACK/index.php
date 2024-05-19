<?php
// index.php

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    header('Access-Control-Allow-Origin: *'); // Permitir solicitudes desde cualquier origen
	//header('Access-Control-Allow-Origin: https://api.tagtico.com, https://gotime.tagtico.com');
    header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');
    header('Access-Control-Allow-Headers: Content-Type');
    exit;
}
// Autoload de clases
spl_autoload_register(function ($class) {
    $dirs = ['models', 'controllers', 'services']; // Directorios donde buscar las clases

    foreach ($dirs as $dir) {
        $file = __DIR__ . '/' . $dir . '/' . $class . '.php';
        if (file_exists($file)) {
            include $file;
            return;
        }
    }
});

// Obtener la URL
$url = isset($_GET['url']) ? $_GET['url'] : '/';
$url = rtrim($url, '/');
$url = explode('/', $url);

// Enrutamiento
$controller = new ApiController();

switch ($_SERVER['REQUEST_METHOD']) {
    case 'GET':
        switch ($url[0]) {
            case 'obtenerEventos':
                $controller->getAllEvents();
                break;
            case 'obtenerEventoId':
                $controller->getEventById($url[1]);
                break;
            default:
                mostrarError('Ruta no válida.');
                break;
        }
        break;
    case 'POST':
    // Obtener los datos enviados en la solicitud POST
    $postData = file_get_contents("php://input");
    $data = json_decode($postData, true); // Decodificar los datos JSON en un array asociativo

    // Verificar si se recibieron datos
    if (!empty($data)) {
        // Acceder a los parámetros según su nombre
        $uuid = $data['uuid'];
        // Llamar al método correspondiente en base a los parámetros recibidos
        switch ($url[0]) {
            case 'obtenerTodos':
                $controller->getAllResultados();
                break;
            case 'getEvent':
                $controller->getEventById($uuid);
                break;
            default:
                mostrarError('Ruta no válida.');
                break;
        }
    } else {
        mostrarError('No se recibieron datos en la solicitud POST.');
    }
    break;

    case 'PUT':
        // Manejar petición PUT para actualizar un recurso existente
        break;
    case 'DELETE':
        // Manejar petición DELETE para eliminar un recurso existente
        break;
    default:
        mostrarError('Método no permitido.');
        break;
}


// Función para mostrar un error
function mostrarError($mensaje) {
    header("HTTP/1.0 404 Not Found");
    echo $mensaje;
    // Puedes personalizar el formato del error o enviarlo como JSON según tus necesidades
}
