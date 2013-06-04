<?php
// Datos de configuración de la aplicación

class Config{
    // URL de la aplicación sin terminar en /. Por ejemplo: 'http://www.veiga.local/amadeus'
    public static $urlAplicacion = 'http://www.veiga.local/amadeus';

    // Configuración de la base de datos.
    public static $dbServidor = 'localhost';
    public static $dbDatabase = 'c2base1';
    public static $dbUsuario = 'c2base1';
    public static $dbPassword = 'abc123.';

    // API Key wunderground.com Méteo.
    public static $keywunderground = '61f45636d937aab9';

    // Datos de configuración para el correo.
    public static $mailNombreRemitente = 'Nombre y Apellidos';
    public static $mailEmailRemitente = 'info@veiga.local';
    public static $mailServidor = 'localhost';
    public static $mailPuerto = '25';
    public static $mailUsuario = 'info@veiga.local';
    public static $mailPassword = 'abc123.';

    // Datos configuración autenticación LDAP
    public static $ldapServidor='10.0.4.1';
    public static $ldapPuerto='389';
    public static $ldapDominio='sanclemente.local';


    // Datos autenticación OAuth en Twitter obtenidos de nuestra configuración en:
    // http://dev.twitter.com
    // Cada usuario deberá poner sus propios datos aquí.
    public static $consumerKey='GXRtix4VvRoik7mq3z0w';
    public static $consumerSecret='oac66gVZkA2vYM9m2dLeUinLQV5W4nxUUuXnpCOUbo';

    public static $requestTokenUrl='https://api.twitter.com/oauth/request_token';
    public static $authorizeUrl='https://api.twitter.com/oauth/authorize';
    public static $accessTokenUrl='https://api.twitter.com/oauth/access_token';
    public static $callbackUrl='http://www.veiga.local/amadeus/callback.php';


    // Datos de configuración del servidor de correo para cuenta de GMAIL.
    // IMPORTANTE si usáis XAMPP:
    //
    // Para que funcione en XAMPP el envío con SSL (puerto 465) en GMAIL, hay que activar en el fichero \xampp\php\php.ini, la siguiente extensión:
    // extension=php_openssl.dll
    // y reiniciar de nuevo XAMPP.

    // Para usarlo con GMAIL aquí van un ejemplo de configuración:
    /*
     * public static $mailNombreRemitente = 'Nombre y Apellidos';
     * public static $mailEmailRemitente = 'usuario@gmail.com';
     * public static $mailServidor = 'smtp.gmail.com';
     * public static $mailPuerto = '465';
     * public static $mailUsuario = 'usuario@gmail.com';
     * public static $mailPassword = 'xxxxxx';
     */

    
    public static $marcadeAgua='img/watermark.png';
}

?>