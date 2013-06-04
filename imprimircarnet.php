<?php

@session_start();

// Cargamos la clase dompdf
require_once 'lib/pdf/dompdf_config.inc.php';
require_once 'lib/funciones.php';

if (isset($_SESSION['fototwitter']) && $_SESSION['fototwitter'] != '')
{
    $imagen = "<img src='{$_SESSION['fototwitter']}' width='100px'/>";
    $nombre = $_SESSION['nombre'] . ".";
    $apellidos = "Usuario Twitter.";
}
else if (isset($_SESSION['fotografia']) && $_SESSION['fotografia'] != '')
{
    $imagen = "<img src='img/usuarios/{$_SESSION['fotografia']}' width='100px'/>";
    $nombre = $_SESSION['nombre'];
    $apellidos = $_SESSION['apellidos'];
}
else
{
    $imagen = "<img src='img/comun.png' width='100px'/>";
    $nombre = $_SESSION['nombre'];
    $apellidos = $_SESSION['apellidos'];
}

// Código principal obtenido de Pablo Eloy de Miguel Melero.

$html = '<style type="text/css">
#carnet{
     border-radius:15px;
     -moz-border-radius:15px; /* Firefox */
     -webkit-border-radius:15px; /* Safari y Chrome */
     width:400px;
     height:230px;
     text-align: center;
     vertical-align: middle;
     font-size: 15px;
     color:black;
     background:#a5c100;
     border: solid 2px black;
}

#carnet table{
     margin:8px;
}
</style>';

$html.="<div id='carnet'>";
$html.='<table width="100%"><tr><td width="70%"><h2>Agencia Viajes Amadeus</h2></td>';
$html.='<td width="30%" rowspan="3">' . $imagen . '</td></tr>';
$html.='<tr><td colspan="2"><b>Nombre:</b> ' . ucwords($nombre) . '<br/><b>Apellidos:</b> ' . ucwords($apellidos) . '</td></tr>';
$html.='<tr><td colspan="2">Carnet de Socio. &copy;' . date("Y") . '</td></tr></table>';
$html.="</div>";

$mipdf = new DOMPDF();
$mipdf->set_paper("A4", "portrait");
$mipdf->load_html(utf8_decode($html));
$mipdf->render();

// Si recibimos un parámetro grabamos el fichero para adjuntarlo por e-mail.
if (isset($_GET['fichero']) && $_GET['fichero'] == '1')
{
    if ($_SESSION['email'] != "")
    {
        $fichero = 'img/usuarios/' . md5(time()) . '.pdf';
        file_put_contents($fichero, $mipdf->output());

        $contenido = "Estimado señor/a $nombre $apellidos.<br/><br/>En este e-mail se adjunta el pdf con el carnet de socio en Viajes Amadeus.";

        if (enviarCorreo($nombre . ' ' . $apellidos, $_SESSION['email'], 'Carnet de Socio Agencia Viajes Amadeus', $contenido, $fichero))
        {
            echo "<h2> El carnet ha sido enviado a su dirección de correo electrónico.</h2>";

            // Borramos el pdf generado anteriormente.
            unlink($fichero);
        }
        unlink($fichero);
    }
    else
        echo "No le hemos podido enviar por correo el carnet, ya que usted no dispone de e-mail en su perfil.";
}
else
{
    $mipdf->stream('Carnet_Amadeus.pdf');
    header("Location: subirfoto.html");
}
?>