<?php

// Librería de FUNCIONES.

/**
 * Función de encriptación en Blowfish
 *
 * @param string $password La contraseña a encriptar.
 * @param int $vueltas Número de vueltas entre 04 y 31, 7 por defecto
 * @return string Contraseña encriptada
 *
 * Ejemplo de uso:
 * $encriptado = encriptar('mipassword',10);
 * if (crypt('mipassword',$encriptado) == $encriptado) { OK }
 *
 */
function encriptar($password, $vueltas = 7) {
    $caracteres = './ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';

    // http://php.net/manual/es/function.crypt.php
    // Para BlowFish, la cabecera es: $2a$ + coste + 22 caracteres del alfabeto de caracteres.
    // %02d -> es para que ponga el número con dos dígitos.
    // $vueltas -> número entre 04 y 31, Se recomienda 7 por defecto por ejemplo

    $semilla = sprintf('$2a$%02d$', $vueltas);
    for ($i = 0; $i < 22; $i++)
        $semilla.=$caracteres[rand(0, 63)];


    return crypt($password, $semilla);
}

/**
 * Función de envío de correo
 * 
 * 
 * @param string $nombreDestinatario Nombre y apellidos del destinatario
 * @param string $emailDestinatario Dirección de correo del destinatario
 * @param string $asunto Asunto del mensaje
 * @param string $contenido Contenido del mensaje
 * @param string $nombreRemitente [opcional]: Nombre y apellidos del remitente del correo.
 * @param string $emailRemitente [opcional]: E-mail del remitente del correo.
 * @param string $servidorCorreo [opcional]: Host del servidor de correo.
 * @param string $usuarioCorreo [opcional]: Usuario del servidor de correo, gralmente. el e-mail
 * @param string $passwordCorreo [opcional]: Password del servidor de correo.
 * @param string $puerto [opcional]: Puerto del servidor de correo.
 * @return string Mensaje de confirmación del envío o fallo del correo.
 */
function enviarCorreo($nombreDestinatario, $emailDestinatario, $asunto, $contenido, $nombreRemitente = '', $emailRemitente = '', $servidorCorreo = '', $usuarioCorreo = '', $passwordCorreo = '', $puerto = '') {
    if (isset($emailDestinatario) && $emailDestinatario != '') {
        // Comenzamos con la configuración del correo.
        // Cargamos las librerías de phpmailer
        require_once dirname(__FILE__) . '/class.phpmailer.php';
        require_once dirname(__FILE__) . '/class.smtp.php';
        require_once dirname(__FILE__) . '/config.php';

        if ($nombreRemitente == '')
            $nombreRemitente = Config::$mailNombreRemitente;

        if ($emailRemitente == '')
            $emailRemitente = Config::$mailEmailRemitente;

        if ($servidorCorreo == '')
            $servidorCorreo = Config::$mailServidor;

        if ($usuarioCorreo == '')
            $usuarioCorreo = Config::$mailUsuario;

        if ($passwordCorreo == '')
            $passwordCorreo = Config::$mailPassword;

        if ($puerto == '')
            $puerto = Config::$mailPuerto;

        // Está configurado el servidor de correo?
        if ($servidorCorreo != '' && $usuarioCorreo != '' && $passwordCorreo != '') 
        {
            // Pendiente validación de SPAM en el correo.
            // Creamos el objeto de tipo phpmailer
            $correo = new PHPMailer();

            $correo->IsSMTP();  // Indicamos que vamos a usar SMTP.
            $correo->SMTPDebug = 1; // Habilitamos el debug al enviar correo.
            // Autenticación del correo a true.
            $correo->SMTPAuth = true;
            $correo->CharSet = 'UTF-8';

            // Configuramos el servidor.
            $correo->Host = $servidorCorreo;
            $correo->Port = $puerto;

            // Si estamos usando gmail por ejemplo...
            if ($puerto == 465 || $puerto == 587)
                $correo->SMTPSecure = 'ssl';
            // Atención para que funcione en xampp el envío con ssl, hay que activar en \xampp\php\php.ini, la siguiente extensión:
            // extension=php_openssl.dll

            // Datos del correo
            $correo->Username = $usuarioCorreo;
            $correo->Password = $passwordCorreo;
            $correo->SetFrom($emailRemitente, $nombreRemitente);
            $correo->AddReplyTo($emailRemitente, $nombreRemitente);
            $correo->AddAddress($emailDestinatario, $nombreDestinatario);
            $correo->Subject = $asunto;
            $correo->AltBody = 'Para ver este mensaje utilice un visor de correo compatible con HTML.';
            $correo->MsgHTML($contenido);
            $correo->IsHTML(true);
            /**
             * SI queremos enviar ficheros adjuntos usaremos este comando.
             * 
             * $correo->AddAttachment('rutafichero/billete.pdf');
             * 
             */

            // POR FIN !! enviamos el correo.
            if ($correo->Send())
                return "Se ha enviado el correo correctamente.";
            else
                return 'Se ha producido un error enviado el correo';
        }
    }
}

?>
