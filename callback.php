<?php
@session_start();
require_once 'lib/config.php';
require_once 'lib/twitter/twitteroauth.php';

// Si regresamos de Twitter, tendremos unos parámetros específicos en la URL.
if (!empty($_GET['oauth_verifier']) && !empty($_SESSION['request_token']) && !empty($_SESSION['request_token_secret']) )
{
    // Podemos pedir entonces el ACCESS TOKEN y ACCESS TOKEN SECRET
    // Configuramos el objeto $twitter.
    $twitter= new TwitterOAuth(Config::$consumerKey,Config::$consumerSecret,$_SESSION['request_token'], $_SESSION['request_token_secret']);

    // Una vez configurado el objeto, pedimos el cambio por un access Token.
    // Nos devuelve un array con esos datos.
    $accesstoken=$twitter->getAccessToken($_GET['oauth_verifier']);

    //Almacenamos en 2 variables de sesión el AccessTOken y AccessTokenSecret
    $_SESSION['access_token']=$accesstoken['oauth_token'];
    $_SESSION['access_token_secret']=$accesstoken['oauth_token_secret'];

    // Eliminamos las variables de sesión request_TOKEN.
    unset($_SESSION['request_token']);
    unset($_SESSION['request_token_secret']);

    // Redireccionamos a logintwitter.php
    header('Location:logintwitter.php');
}

?>
