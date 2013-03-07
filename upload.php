<?php
@session_start();

// Directorio de envío de imágenes.
$directorioImagenes = substr(__FILE__, 0, strlen(__FILE__) - strlen(basename(__FILE__))) . 'img/usuarios/';

// Extensiones permitidas de archivos.
$formatosPermitidos = array('jpg', 'jpeg', 'gif', 'png');

if (isset($_SESSION['usuario'])) {

    // Si recibimos fichero...
    if ( $_FILES['ficherosubido']['size'] >0) {
        $partesFichero = pathinfo($_FILES['ficherosubido']['name']);

        // Comprobamos si es un extensión permitida.
        if (in_array(strtolower($partesFichero['extension']), $formatosPermitidos)) {
            // nombreficheroAvatar.
            $nombreFicheroAvatar = md5("semoladetrigo" . $_SESSION['usuario']) . "." . strtolower($partesFichero['extension']);

            $rutaFicheroAvatar = $directorioImagenes . $nombreFicheroAvatar;

            // Movemos el archivo del directorio temporal a la carpeta definitiva.
            if (!move_uploaded_file($_FILES['ficherosubido']['tmp_name'], $rutaFicheroAvatar))
                die("ERROR: no se puede escribir en la carpeta de destino.");

            // Actualizamos la base de datos.
            require_once("lib/basedatos.php");
            $mibase = Basedatos::getInstancia();

            // Si ese ususario tenía una fotografía antigua, la borramos del servidor.
            if (isset($_SESSION['fotografia']) && $_SESSION['fotografia']!='')
            {
                $ficheroBorrar=$directorioImagenes.$_SESSION['fotografia'];
                unlink($ficheroBorrar);
            }
            
            // Actualizamos la foto en la base de datos.
            if ($mibase->actualizarFoto($nombreFicheroAvatar)) {
                $_SESSION['fotografia'] = $nombreFicheroAvatar;
                // Nos redirecciona a la página de subirfoto.html.
                header("location: subirfoto.html");
            }
        }
        else
            echo "ERROR: El formato de archivo no está permitido.";
    } // EMPTY FILES.
    header("location: subirfoto.html");
} // 
else
    echo "ERROR: Acceso no permitido a la aplicación.";
?>
