<?php
@session_start();

// Cargamos la clase twitter.
require_once 'twitter.php';

// si recibimos un parámetro get 
if (!empty($_GET)) {
    // Creamos un objeto de la clase twitter.
    $twitter = new twitter();

    if ($_GET['q'] == 'ultimos_status') {
        // Mostrar los últimos 10 mensajes de estado de Twitter.
        $twitter->obtener_ultimos_mensajes();
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
    //      $format = (is_array($data)) ? 'array' : 'json';

    highlight_string('<?php ' . print_r(($format === 'json' ? json_decode($datos, TRUE) : $datos), TRUE) . ' ?>');
    exit;
}

?>
