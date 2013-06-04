<?php

@session_start();

// Directorio de envío de imágenes.
$directorioImagenes = substr(__FILE__, 0, strlen(__FILE__) - strlen(basename(__FILE__))) . 'img' . DIRECTORY_SEPARATOR . 'usuarios' . DIRECTORY_SEPARATOR;

// Código obtenido de Salvador Tabarés Navarrete.
$formatosPermitidos = array('jpg', 'jpeg', 'png');
if (isset($_SESSION['usuario']))
{
    // Si recibimos fichero.
    if ($_FILES['ficherosubido']['size'] > 0)
    {
        $partesFichero = pathinfo($_FILES['ficherosubido']['name']);
        // Comprobamos si es una extensión permitida.
        if (in_array(strtolower($partesFichero['extension']), $formatosPermitidos))
        {
            // Almacenamos el NOMBRE del fichero
            $nombreFicheroAvatar = md5("semoladetrigo" . $_SESSION['usuario']);
            // Almacenamos la EXTENSIÓN del fichero
            $extension = strtolower($partesFichero['extension']);
            // Almacenamos la RUTA COMPLETA del fichero
            $rutaFicheroAvatar = $directorioImagenes . $nombreFicheroAvatar . '.' . $extension;
            // Movemos el archivo del directorio temporal a la carpeta definitiva.
            if (!move_uploaded_file($_FILES['ficherosubido']['tmp_name'], $rutaFicheroAvatar))
                die("ERROR: no se puede escribir en la carpeta de destino.");
            /*
             * Cuando el fichero ha sido almacenado en el lugar adecuado,
             * con el nombre adecuado y SU propia extensión, lo trasformamos con la
             * función diseñada, a la que le pasamos el NOMBRE y SU EXTENSIÓN y el
             * resultado será una imagen con el mismo NOMBRE pero con extensión .png
             */
            personalizaAvatar($directorioImagenes, $nombreFicheroAvatar, $extension);
            $nombreFicheroAvatar .= '.png';
            // Actualizamos la base de datos.
            require_once("lib/basedatos.php");
            $mibase = Basedatos::getInstancia();
            // Si pudo actualizar la foto en la base de datos....
            if ($mibase->actualizarFoto($nombreFicheroAvatar))
            {
                $_SESSION['fotografia'] = $nombreFicheroAvatar;
                // Nos redirecciona a la página de subirfoto.html.
                //echo 'Foto subida correctamente.';
                header("location: subirfoto.html");
            } // Actualizar base de datos
        } // Formatos permitidos
        else
            echo "ERROR: El formato de archivo no está permitido.";
    } // EMPTY FILES.
    header("location: subirfoto.html");
} //
else
    echo "ERROR: Acceso no permitido a la aplicación.";

//header("location: subirfoto.html");
/*
 * Personalización del avatar enviado: el avatar que acaba de subir el usuario
 * lo transforma según las directrices -> redimensión, agregar marca de agua y
 * leyenda inferior de copyright.
 * Recibe 3 Strings que contienen el DIRECTORIO de almacenamiento, el NOMBRE del
 * fichero y SU EXTENSIÓN
 * No devuelve nada, pero al transformar la foto siempre resultará de tipo .png
 * por lo que hay que eliminar la foto original (podría ser .jpg o .jpeg y
 * tendríamos 2 fotos del mismo usuario: la original en .jpg o .jpeg y la final
 * en .png)
 */

function personalizaAvatar($directorioImagenes, $nombreFicheroAvatar, $extension)
{
    /*
     * Necesitamos acceder a config para obtener el nombre del fichero usado como
     * marca de agua. Sería una "marca de la casa", por lo que pertenece a las
     * configuraciones
     */
    require_once 'lib/config.php';
    // PASO 1: cargamos las 2 imágenes y obtenemos sus dimensiones
    $imagenBase = $directorioImagenes . $nombreFicheroAvatar . '.' . $extension;
    $marcadeAgua = Config::$marcadeAgua;
    $base = file_get_contents($imagenBase);
    $water = file_get_contents($marcadeAgua);
    $imagen = imagecreatefromstring($base);
    $alto = imagesy($imagen);
    $ancho = imagesx($imagen);
    $agua = imagecreatefromstring($water);
    $aguax = imagesx($agua);
    $aguay = imagesy($agua);
    // FIN PASO 1
    // PASO 2: restricción planteada-> anchura máxima y ratio de conversión para
    // la redimensión horizontal y vertical manteniendo el "aspect ratio"
    $max_ancho = 250;
    $xratio = $max_ancho / $ancho;
    $ancho_final = $max_ancho;
    if ($ancho <= $max_ancho)
        $ancho_final = $max_ancho;
    $alto_final = ceil($alto * $xratio);
    $tmp = imagecreatetruecolor($ancho_final, $alto_final); // Creamos una imagen temporal
    // con las nuevas medidas
    $fondo = imagecolorallocatealpha($tmp, 0, 0, 0, 127); // Asignamos los parámetros de una
    // capa transparente
    imagefill($tmp, 0, 0, $fondo); // Hacemos una capa transparente que pueda interpretar
    // correctamente las posibles áreas transparentes de la
    // imagen subida
    imagesavealpha($tmp, true); // Preservamos el canal alpha
    imagecopyresampled($tmp, $imagen, 0, 0, 0, 0, $ancho_final, $alto_final, $ancho, $alto);
    // Remuestreamos (redimensionamos) la imagen original. A partir de este
    // punto seguimos trabajando sobre una nueva imagen temporal ($tmp)
    // FIN PASO 2
    imagedestroy($imagen); // Eliminamos de la memoria la imagen original
    unlink($imagenBase); // Eliminamos del disco el fichero original de la imagen
    // PASO 3: restricción planteada -> sobreimpresión de leyenda inferior
    $colorLetras = imagecolorallocate($tmp, 135, 159, 0); // Verde Amadeus
    $texto = 'Amadeus Copyright ' . date('Y'); // Leyenda
    $px = ($ancho_final - 30 - (7 * strlen($texto))); // Distancia para situar leyenda
    // Situamos el texto en la imagen.
    imagestring($tmp, 3, $px, ($alto_final - 18), $texto, $colorLetras);
    // FIN PASO 3
    // PASO 4: restricción planteada -> sobreimpresión marca de agua
    imagecopy($tmp, $agua, ($ancho_final - $aguax - 5), ($alto_final - $aguay - 5), 0, 0, $aguax, $aguay);
    // FIN PASO 4
    // PASO 5: guardando el resultado
    $calidad = 0; // Parámetro de compresión .png
    // Enviamos la cabecera de imagen PNG.
    // Importantísimo no tener ningún espacio en blanco al principio del fichero
    // PHP ni hacer ningún echo o similar, porque entonces el envío de la cabecera
    // fallaría.
    Header("Content-type: image/png");
    // Escribimos en disco el fichero resultante
    imagepng($tmp, $directorioImagenes . $nombreFicheroAvatar . '.png', $calidad);
    imagedestroy($tmp); // Eliminamos de la memoria la imagen resultante
    // FIN PASO 5. 
}

?>