<?php
// Comprobamos si el parámetro inc existe y es distinto del vacio.
if (isset($_GET['inc']) && $_GET['inc']!="")

    // Si no existe el fichero indicado en inc
    if (! file_exists("{$_GET['inc']}.php"))
    { // Sacamos página de error personalizada
        header("HTTP/1.0 404 Not Found");
        require 'error/404.html';
    }
    else  // el fichero existe y cargamos su versión .php
    {
        require_once 'header.html';
        require_once 'menu.php';
        require_once "{$_GET['inc']}.php";
        require_once 'footer.html';
    }
?>