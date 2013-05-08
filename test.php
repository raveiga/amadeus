<?php
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
*/
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




?>