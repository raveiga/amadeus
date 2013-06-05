<?php

require_once 'lib/config.php';
# Texto a superponer en la imagen.

$texto = Config::$webmasterAddress;
# Cargamos la imagen de fondo.

$imagen = imagecreatefrompng("img/email.png");
#Color del texto
$color = imagecolorallocate($imagen, 110, 110, 110);

#Calculamos la distancia para centrar el texto.
$px = (imagesx($imagen) - 9 * strlen($texto)) / 2;
$py = imagesy($imagen) - 30;
// Situamos el texto en la imagen.
imagestring($imagen, 4, $px, $py, $texto, $color);

// Enviamos la cabecera de imagen PNG.
// Importantísimo no tener ningún espacio en blanco al principio del fichero PHP
// ni hacer ningún echo o similar, por que entonces el envío de la cabecera fallará.
header("Content-type: image/png");
// Enviamos el contenido de la imagen.
imagepng($imagen);
// Destruimos la imagen en el servidor.
imagedestroy($imagen);
?>