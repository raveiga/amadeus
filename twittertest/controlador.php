<?php
@session_start();

// Almacenamos en una variable de sesión la página para regresar desde el callback.php
$_SESSION['urldestino']= 'http://www.veiga.local'.$_SERVER['REQUEST_URI'];

// Cargamos la clase twitter.
require_once 'twitter.php';

// Si recibimos un parámetro get 
if (!empty($_GET)) {
    // Creamos un objeto de la clase twitter.
    $twitter = new twitter();

    if ($_GET['q'] == 'ultimos_status') {
        // Mostrar los últimos 10 mensajes de estado de Twitter.
        $mensajes=$twitter->obtener_ultimos_mensajes();
        colorear($mensajes);
    }
}



// Esta función muestra por pantalla de un modo legible tanto arrays como strings json
function colorear($datos) {
    header("Content-type: text/html; charset=UTF-8");

    if (is_array($datos))
        $format = 'array';
    else
        $format = 'json';
    // Formato reducido del if anterior:
    //      $format = (is_array($datos)) ? 'array' : 'json';

    // json_decode($datos,TRUE) -> true es para que devuelva un array asociativo, sino devolvería un objeto.
    highlight_string('<?php ' . print_r(($format === 'json' ? json_decode($datos, TRUE) : $datos), TRUE) . ' ?>');
    exit;
}

?>
