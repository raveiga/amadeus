<?php

//require_once('lib/basedatos.php');
//$mibase = Basedatos::getInstancia();
//echo $mibase->obtenerUsuarios();































/*
  require_once 'lib/ldap.php';

  $ldap = new ldap("10.0.4.1");

  if($ldap->validarusuario("ldap2","sanclemente.local","abc123.."))
  {
  echo "OK usuario validado en Active Directory.<br/><br/>";
  //$ldap->ojearUsuarios("veiga");
  $ldap->infoUsuario("veiga");

  }
  else
  echo "ERROR datos incorrectos de acceso";

  $client = new Zend_Rest_Client('http://framework.zend.com/rest');
  echo $client->sayHello('Davey', 'Day')->get(); // "Hello Davey, Good Day"

  # Cargamos la librería dompdf.
  require_once 'lib/pdf/dompdf_config.inc.php';

  # Contenido HTML del documento que queremos generar en PDF.
  $html='
  <html>
  <head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
  <title>Ejemplo de Documento en PDF.</title>
  </head>
  <body>

  <h2>Ingredientes para la realización de Postres.</h2>
  <p>Ingredientes:</p>
  <dl>
  <dt>Chocolate</dt>
  <dd>Cacao</dd>
  <dd>Azucar</dd>
  <dd>Leche</dd>
  <dt>Caramelo</dt>
  <dd>Azucar</dd>
  <dd>Colorantes</dd>
  </dl>

  </body>
  </html>';
  /*
  # Instanciamos un objeto de la clase DOMPDF.
  $mipdf = new DOMPDF();

  # Definimos el tamaño y orientación del papel que queremos.
  # O por defecto cogerá el que está en el fichero de configuración.
  $mipdf ->set_paper("A4", "portrait");

  # Cargamos el contenido HTML.
  $mipdf ->load_html(utf8_decode($html));

  # Renderizamos el documento PDF.
  $mipdf ->render();

  # Enviamos el fichero PDF al navegador.
  $mipdf ->stream('FicheroEjemplo.pdf');
  ?>

 */

/*
// Ancho y alto de la imagen en pixels.
$ancho = 100;
$alto = 30;
$imagen = imagecreate($ancho, $alto);

// Definimos el color amarillo.
$amarillo = imagecolorallocate($imagen, 255, 255, 0);

// Rellenamos la imagen de color amarillo.
ImageFill($imagen, 0, 0, $amarillo);
$colorTexto = imagecolorallocate($imagen, 28, 63, 108);
$colorLineas = imagecolorallocate($imagen, 255, 0, 0);
$valoraleatorio = rand(100000, 999999);

// Escribimos el valor aleatorio en la imagen.
ImageString($imagen, 5, 25, 5, $valoraleatorio, $colorTexto);
for ($c = 0; $c <= 5; $c++)
{
    $x1 = rand(0, $ancho);
    $y1 = rand(0, $alto);
    $x2 = rand(0, $ancho);
    $y2 = rand(0, $alto);
    ImageLine($imagen, $x1, $y1, $x2, $y2, $colorLineas);
}

// Enviamos la cabecera de imagen JPEG.
// Importantísimo no tener ningún espacio en blanco al principio del fichero PHP 
// ni hacer ningún echo o similar, por que entonces el envío de la cabecera fallaría.
header("Content-type: image/jpeg");

// Enviamos el contenido de la imagen.
imagejpeg($imagen);

// Destruimos la memoria ocupada por la imagen en el servidor.
imagedestroy($imagen);
*/






# Texto a superponer en la imagen.
$texto = "Amadeus Copyright ".date("Y").".";

# Cargamos la imagen de fondo.
$imagen = imagecreatefromjpeg("img/email.jpg");

$watermark=imagecreatefrompng("img/watermark.png");

// Obtengo los tamaños de las imagenes 
$anchoimagen = imagesx($imagen); 
$altoimagen = imagesy($imagen); 
$anchowatermark = imagesx($watermark); 
$altowatermark = imagesy($watermark); 

#Color del texto
$color = imagecolorallocate($imagen, 135, 159, 0);

#Calculamos la distancia para colocar el texto
$px = (imagesx($imagen) - strlen($texto)*7.5) ;

//We will use alpha blending function to set blending option for both images to true:
imagealphablending($imagen, true);
imagealphablending($watermark, true);

// imagecopy ( resource $dst_im , resource $src_im , int $dst_x , int $dst_y , int $src_x , int $src_y , int $src_w , int $src_h )
// Copiamos el watermark a la imagen
imagecopy($imagen,$watermark,$anchoimagen-$anchowatermark-5,$altoimagen - $altowatermark-5,0,0,$anchowatermark,$altowatermark); 



// Situamos el texto en la imagen.
imagestring($imagen, 3, $anchoimagen- (7*strlen($texto)+30), $altoimagen-18, $texto, $color);



imagesavealpha($imagen,true);

// Enviamos la cabecera de imagen PNG.
// Importantísimo no tener ningún espacio en blanco al principio del fichero PHP 
// ni hacer ningún echo o similar, por que entonces el envío de la cabecera fallaría.
Header ("Content-type: image/png");

// Enviamos el contenido de la imagen.
imagepng($imagen);

// Destruimos la imagen en el servidor.
imagedestroy($imagen);



 ?>
