<?php

// Activamos las variables de sesión.
@session_start();

// Para bloquear la cache en navegadores para las peticiones AJAX.
header('Cache-Control: no-cache, must-revalidate');
header('Expires: Mon, 01 Jan 1973 00:00:00 GMT');

// Cargamos la clase basedatos.
require_once("lib/basedatos.php");
require_once("lib/rss.php");

// Creamos el objeto con el patrón diseño Singleton.
// No podemos usar $mibase= new Basedatos(), por que
// el constructor es privado en la clase Basedatos.
$mibase = Basedatos::getInstancia();

switch ($_GET['op'])
{
    case 1:  // Chequear nick
        echo $mibase->chequearNick($_POST['nick']);
        break;

    case 2: // Alta de usuarios
        require_once 'lib/inputfilter/class.inputfilter.php';
        
        // Evitamos ataques XSS.
        $filtro = new InputFilter();
        $_POST = $filtro->process($_POST);
        
        echo $mibase->insertarUsuario($_POST['nick'], $_POST['password'], $_POST['nombre'], $_POST['apellidos'], $_POST['dni'], $_POST['email'], $_POST['telefono']);
        // Enviamos a continuación el correo de registro.
        break;

    case 3: // Chequear Inicio sesión
        echo $mibase->chequearAcceso($_POST['nick'], $_POST['password'], $_POST['autenticacion']);
        break;

    case 4: // Obtener los datos del usuario
        echo $mibase->obtenerInfoUsuario();
        break;

    case 5: // Actualizamos datos usuario logueado.
        echo $mibase->actualizarUsuario($_POST['password'], $_POST['nombre'], $_POST['apellidos'], $_POST['dni'], $_POST['email'], $_POST['telefono']);
        break;

    case 6: // Borrado de usuario y fotografías en el servidor.
        echo $mibase->borrarUsuario();
        break;

    case 7: // Petición ajax de carga de aeropuertos.
        echo $mibase->obtenerAeropuertos($_POST['latNE'], $_POST['lonNE'], $_POST['latSW'], $_POST['lonSW']);
        break;

    case 8: // Petición ajax de sugerencias de aeropuertos.
        echo $mibase->sugerirAeropuertos($_POST['aeropuerto']);
        break;

    case 9: // Petición JSON a flightRadar24.
        echo file_get_contents("http://www.flightradar24.com/AirportInfoService.php?airport={$_POST['iata']}&type={$_POST['tipo']}");
        break;

    case 10: // Consultas RSS
        $mirss = new rss($_POST['titulo'], $_POST['url']);
        echo $mirss->contenidoRSS();
        break;

    case 11: // Tiempo JSON wunderground.com
        echo file_get_contents("http://api.wunderground.com/api/" . Config::$keywunderground . "/conditions/forecast/lang:SP/q/" . str_replace(' ', '_', $_POST['pais']) . "/" . str_replace(' ', '_', $_POST['localidad']) . ".json");
        break;

    case 12: //Mis datos de twitter
        // Cargamos la librería twitterOAuth
        require_once 'lib/twitter/twitteroauth.php';

        $twitter = new TwitterOauth(Config::$consumerKey, Config::$consumerSecret, $_SESSION['access_token'], $_SESSION['access_token_secret']);
        switch ($_POST['boton'])
        {
            case 'misdatos':
                $misdatos = $twitter->get('account/verify_credentials');

                $nombre = $misdatos->name;
                $cuenta = $misdatos->screen_name;
                $fotografia = $misdatos->profile_image_url;
                $descripcion = $misdatos->description;
                $seguidores = $misdatos->followers_count;
                $siguiendo = $misdatos->friends_count;
                $num_tweets = $misdatos->statuses_count;

                $contenido = "<table padding='0'>";
                $contenido.="<tr><td><b>Nombre:</b> </td><td>" . $nombre . "</td></tr>";
                $contenido.="<tr><td><b>Username: </b></td><td>" . $cuenta . "</td></tr>";
                $contenido.="<tr><td><b>Foto Perfil: </b></td><td><img src='" . $fotografia . "'/></td></tr>";
                $contenido.="<tr><td><b>Descripción: </b></td><td>" . $descripcion . "</td></tr>";
                $contenido.="<tr><td><b>Tweets: </b></td><td>" . $num_tweets . "</td></tr>";
                $contenido.="<tr><td><b>Seguidores: </b></td><td>" . $seguidores . "</td></tr>";
                $contenido.="<tr><td><b>Siguiendo: </b></td><td>" . $siguiendo . "</td></tr>";
                $contenido.="</table>";

                echo $contenido;
                break;

            case 'status':
                $status = $twitter->get('statuses/home_timeline');
                $contenido = '';
                for ($i = 0; $i < count($status); $i++)
                {
                    $usuario = "<h5>" . $status[$i]->user->screen_name . "</h5>";
                    $fecha = "<font color='#21610B'>" . $status[$i]->created_at . "</font>";
                    $tweet = "<p>" . $status[$i]->text . "</p>";
                    $imagen = "<img src='" . $status[$i]->user->profile_image_url . "' />";
                    $contenido.="<div class='tweetstatus'>";
                    $contenido.="<div class='imgstatus'>" . $imagen;
                    $contenido.="</div>";
                    $contenido.="<div class='cuerpotweet'>";
                    $contenido.=$usuario;
                    $contenido.=$fecha;
                    $contenido.=$tweet;
                    $contenido.="</div></div>";
                }
                echo $contenido;
                break;

            case 'timeline':
                $timeline = $twitter->get('statuses/user_timeline', array('screen_name' => $_POST['informacion']));
                $contenido = '';
                if (isset($timeline->error) && $timeline->error == "Not authorized")
                {
                    $contenido.="Usuario protegido.";
                }
                else if (isset($timeline->errors[0]->code) && $timeline->errors[0]->code == "34")
                {
                    $contenido.="El usuario que ha introducido no existe.";
                }
                else if (isset($timeline[0]->user->screen_name))
                {

                    for ($i = 0; $i < count($timeline); $i++)
                    {
                        if (!empty($timeline[$i]->user->screen_name))
                        {
                            $usuario = "<h5>" . $timeline[$i]->user->screen_name . "</h5>";
                            $fecha = "<font color='#21610B'>" . $timeline[$i]->created_at . "</font>";
                            $tweet = "<p>" . $timeline[$i]->text . "</p>";
                            $imagen = "<img src='" . $timeline[$i]->user->profile_image_url . "'/>";
                            $contenido.="<div class='tweetstatus'>";
                            $contenido.="<div class='imgstatus'>" . $imagen . "</div>";
                            $contenido.="<div class='cuerpotweet'>";
                            $contenido.=$usuario;
                            $contenido.=$fecha . "<br/>";
                            $contenido.=$tweet;
                            $contenido.="</div></div>";
                        }
                    }
                }
                else
                {
                    $contenido.="Este usuario no ha twitteado nada todavía.<br/>";
                }
                echo $contenido;
                break;

            case 'publicar':
                $publicacion = $twitter->post('statuses/update', array('status' => $_POST['informacion']));
                echo "Su tweet fue publicado correctamente.";
                break;
        }
        break;

    case 13: // Envío de carnet.
        // Se genera el archivo y se envía por correo.
        echo file_get_contents('imprimircarnet.php?fichero=1');
        break;

    case 14:
        require_once 'lib/inputfilter/class.inputfilter.php';
        
        // Evitamos ataques XSS.
        $filtro = new InputFilter();
        $_POST = $filtro->process($_POST);

        $nombre = $_POST['name'];
        $email = $_POST['email'];
        $tel = $_POST['tel'];
        $url = $_POST['url'];
        $asunto = $_POST['subject'];
        $prioridad = $_POST['subject'];
        $mensaje = $_POST['description'];
        if (!isset($_POST['cc']) || $_POST['cc'] === '')
            $copia = 'No';
        else if ($_POST['cc'] === '1')
            $copia = 'Si';

        $contenido = "$nombre ha contactado a través del formulario de contacto<br/>";
        $contenido .= "Los datos enviados son: <br/>";
        $contenido .= "e-mail: $email <br/>";
        $contenido .= "Tel: $tel <br/>";
        $contenido .= "Referente a: $asunto <br/>";
        $contenido .= "URL: $url <br/>";
        $contenido .= "Asunto del mensaje: $prioridad <br/>";
        $contenido .= "Mensaje: $mensaje <br/>";
        $contenido .= "Correo de cortesía: $copia <br/>";

        if ($copia === 'Si')
        {
            if (enviarCorreo($nombre, $email, 'Copia de cortesía', $contenido))
                $contenido .= 'Envío de cortesía correcto';
            else
                $contenido .= 'Envío de cortesía error';
        }

        if (enviarCorreo(Config::$mailNombreRemitente, Config::$webmasterAddress, 'Envío desde formulario de contacto', $contenido))
            echo "<h2>Envío del mensaje realizado correctamente.</h2>";
        else
            echo "!! ATENCIÓN !!<br/><br/>Se ha producido un error al enviar el formulario de contacto.<br/>Contacte con " . Config::$mailEmailRemitente . " para informar del problema.";

        break;

        
}
?>