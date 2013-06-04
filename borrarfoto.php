<?php

// Activamos las variables de sesión.
@session_start();

if (isset($_SESSION['fotografia']) && $_SESSION['fotografia'] != '')
{
    // Directorio de envío de imágenes.
    $directorioImagenes = substr(__FILE__, 0, strlen(__FILE__) - strlen(basename(__FILE__))) . 'img/usuarios/';
    $rutaFicheroAvatar = $directorioImagenes . $_SESSION['fotografia'];

    // Borramos el fichero físicamente.
    if (unlink($rutaFicheroAvatar))
    {
        // Actualizamos el campo fotografia de la base de datos.
        require_once 'lib/basedatos.php';
        $mibase = Basedatos::getInstancia();

        // Actualizamos el campo fotografia en la tabla.
        if ($mibase->borrarFoto())
        {
            $_SESSION['fotografia'] = '';
        }
    }
}

// AL terminar de borrar la foto redireccionamos a la página inicial.
header('location: subirfoto.html');
?>
