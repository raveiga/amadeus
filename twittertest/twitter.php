<?php

@session_start();
require_once '../lib/config.php';

class twitter {

    public $oauth_acceso_concedido = false;
    private $_oauth; // Objeto de la clase OAuth de PHP.

    // Constantes útiles para la clase twitter.

    const URL = 'http://twitter.com/';
    const API_URL = 'http://api.twitter.com/';
    const VERSION = '1';
    const FORMATO = '.json';

    public function __construct() {
        // Cuando creamos un objeto de la clase twitter
        // intentará autenticarse con OAuth en Twitter.
        $this->autenticar_usuario();
    }

    public function autenticar_usuario() {
        // Creamos un objeto de la clase OAuth de PHP.
        $this->_oauth = new OAuth(Config::$consumerKey, Config::$consumerSecret, OAUTH_SIG_METHOD_HMACSHA1, OAUTH_AUTH_TYPE_URI);

        // Para que se pueda autenticar el usuario con OAuth necesitamos un access_token y el access_token_secret correspondientes a ese usuario.
        // Para ello lo tendríamos que haber leído de la BD previamente, si es que se autenticó alguna vez en Twitter.
        // y almacenarlo en una variable de sesión....
        // Todo eso se haría en este mismo bloque que está comentado.

        if (!isset($_SESSION['twitter_access_token'])) {   // No tenemos ningún access_token..   // Tenemos que solicitar un access token
            $this->obtener_access_token();
        }

        // Si ya tenemos un twitter_access_token
        // Configuramos el objeto OAuth para que use ese access_token y el token_secret, para las comunicaciones con Twitter.
        $this->_oauth->setToken($_SESSION['twitter_access_token'], $_SESSION['twitter_access_token_secret']);
    }

    public function obtener_request_token() {
        // En XAMPP hay que deshabilitar el chequeo SSL.
        // Se haría descomentando la siguiente instrucción:
        // $this->_oauth->disableSSLChecks();
        // Primer paso pedir un Request Token.
        // Los datos de respuesta se devuelven en un array, que contiene:
        // [oauth_token] y [oauth_token_secret].
        // Ese array lo almacenamos en la variable $respuesta.
        // En la petición se para la URL para Request Token y la dirección de callback.
        // 1º Paso (diagrama) -> Solicitud de RToken y RTSecret.
        $respuesta = $this->_oauth->getRequestToken(Config::$requestTokenUrl, Config::$callbackUrl);

        // 2º Paso (diagrama) -> Recepción de RToken y RTSecret.
        $_SESSION['twitter_request_token'] = $respuesta['oauth_token'];
        $_SESSION['twitter_request_token_secret'] = $respuesta['oauth_token_secret'];
        // 3º Paso (diagrama) -> Obtener AUTORIZACIÓN
        $this->obtener_autorizacion();
    }

    public function obtener_autorizacion() {
        // 3º Paso del diagrama dónde se redirige el usuario a Twitter y se autoriza la aplicación Amadeus.
        header('Location: ' . Config::$authorizeUrl . '?oauth_token=' . $_SESSION['twitter_request_token']);

        // Cuando el usuario nos autorice devolverá la conexión a la url de callback que configuramos en el paso 1.
        // Si no se define esa dirección callback.php cogerá la definida en los ajustes de la APP en twitter.
    }

    public function obtener_access_token() {
        // Comprobamos si procedemos de la página callback.php  (dónde declaramos un objeto twitter, justo después de que el usuario se valide.
        // Para ello evaluamos un parámetro que aparecerá en la URL de callback.php?oauth_token=......    

        if (!isset($_GET['oauth_token'])) {  
            // Si no procedemos de la página de callback.php
            // Estamos al comienzo de todo el proceso.
            // Paso 1 -> (diagrama)
            $this->obtener_request_token(); 
        } else 
            {
            // Entrará aquí cuando proceda de la autorización de Twitter.
            // 
            // Paso 4: procedentes de la autorización de twitter en el callback.php
            // En la respuesta de autorización nos devuelve por GET un código de autorización $_GET['oauth_token'] y su verificación.
            // Vamos a solicitar el cambio de RequestToken por Access Token.
            // Para ello configuramos el objeto oauth conteniendo el Request Token y el Request Token Secret.
            // 
            // En XAMPP deshabilitar SSL con la siguiente línea.
            // $this->_oauth->disableSSLChecks();
            $this->_oauth->setToken($_SESSION['twitter_request_token'], $_SESSION['twitter_request_token_secret']);

            
            // Paso 5º (diagrama): Solicitamos el Access Token y el Access Token Secret pasando el código de autorización recibido. $_GET['oauth_token']
            $respuesta = $this->_oauth->getAccessToken(Config::$accessTokenUrl, $_GET['oauth_token']);

            // Paso 6º (diagrama):
            // Almacenamos en unas variables de sesión AccessToken y AccessTokenSecret
            $_SESSION['twitter_access_token'] = $respuesta['oauth_token'];
            $_SESSION['twitter_access_token_secret'] = $respuesta['oauth_token_secret'];

            // Informamos al objeto twitter de que ya tenemos AccessToken y AccessTokenSecret.
            $this->oauth_acceso_concedido = true;
        }
    }

    public function obtener_ultimos_mensajes() {
        return $this->fetch(self::API_URL . self::VERSION . '/statuses/user_timeline' . self::FORMATO . '?count=10');
    }

    public function fetch($url, $data = array(), $method = OAUTH_HTTP_METHOD_GET) {
        $this->_oauth->fetch($url, $data, $method);
        return $this->_oauth->getLastResponse();
    }

}

?>
