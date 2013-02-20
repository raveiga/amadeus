<?php
// Datos de configuración de la aplicación

class Config{
    // Configuración de la base de datos.
    public static $dbServidor = 'localhost';
    public static $dbUsuario = 'c2base1';
    public static $dbPassword = 'abc123.';
    public static $dbDatabase = 'c2base1';

    // Datos de configuración para el correo.
    public static $mailNombreRemitente = 'Rafa Veiga';
    public static $mailEmailRemitente = 'info@veiga.local';
    
    // Datos de configuración del servidor de correo.
    // Para usarlo con GMAIL sustituir por los siguientes datos:
    /*
     * public static $mailServidor = 'smtp.gmail.com';
     * public static $mailPuerto = '465';
     * 
     */
    public static $mailServidor = 'localhost';
    public static $mailUsuario = 'info@veiga.local';
    public static $mailPassword = 'abc123.';
    public static $mailPuerto = '25';
    
        
}

?>
