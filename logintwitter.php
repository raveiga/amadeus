<?php

@session_start();
require_once 'lib/config.php';
require_once 'lib/basedatos.php';
require_once 'lib/twitter/twitteroauth.php';

// Creamos una instancia de twitteroauth.
$twitter = new TwitterOAuth(Config::$consumerKey, Config::$consumerSecret);

// Comprobamos si tenemos access Token.
if (empty($_SESSION['access_token']) || empty($_SESSION['access_token_secret']))
{
    // Solicitamos un request token.
    $tokens=$twitter->getRequestToken(Config::$callbackUrl);

    // Almacenamos los Request Token recibidos.
    $_SESSION['request_token']=$tokens['oauth_token'];
    $_SESSION['request_token_secret']=$tokens['oauth_token_secret'];

    // Redireccionamos a la página de autenticación de Twitter.
    if ($twitter->http_code == 200)
    {
        $url=$twitter->getAuthorizeURL($_SESSION['request_token']);
        header('Location: '.$url);
    }
    else
            die("Problemas accediendo al servicio de Twitter.");
}
else    // Tenemos un access token disponible.
{
    // Aquí dentro, podemos hacer consultas a twitter,
    // ya que tenemos el access token disponible.
    // Configuramos el objeto twitter para las consultas.
    $twitter = new TwitterOAuth(Config::$consumerKey, Config::$consumerSecret,$_SESSION['access_token'],$_SESSION['access_token_secret']);

    


}







?>
