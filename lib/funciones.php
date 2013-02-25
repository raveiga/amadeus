<?php

// Librería de funciones.
////////////////////////////////////////////////////////////////////////////////////////////////////////
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


//////////////////////////////////////////////////////////////////////////////////////////////////////// 
/**
 * Función cambiaf_normal
 * Convierte una fecha de mysql a formato normal.
 * 
 * @param string $fecha Una fecha en formato mysql.
 * @return string Fecha en formato nommal dd-mm-aaaa
 */
function cambiaf_normal($fecha) {
    $mifecha = array();
    $lafecha = array();

    preg_match("#([0-9]{2,4})-([0-9]{1,2})-([0-9]{1,2})#", $fecha, $mifecha);
    $lafecha = $mifecha[3] . "/" . $mifecha[2] . "/" . $mifecha[1];
    return $lafecha;
}

//////////////////////////////////////////////////////////////////////////////////////////////////////// 
/**
 * Función cambiaf_mysql
 * Convierte una fecha de formato normal a mysql.
 * 
 * @param string $fecha Una fecha en formato normal dd/mm/aaaa
 * @return string La fecha en formato mysql: aaaa-mm-dd
 */
function cambiaf_mysql($fecha) {
    $mifecha = array();
    $lafecha = array();

    preg_match("#([0-9]{1,2})/([0-9]{1,2})/([0-9]{2,4})#", $fecha, $mifecha);
    $lafecha = $mifecha[3] . "-" . $mifecha[2] . "-" . $mifecha[1];
    return $lafecha;
}


//////////////////////////////////////////////////////////////////////////////////////////////////////// 
/**
 * Función cambiafh_normal
 * Convierte una fecha y hora de mysql a formato normal.
 * 
 * @param string $fecha Una fecha y hora en formato normal dd-mm-aaaa
 * @return string La fecha y hora en formato mysql aaaa/mm/dd hh:mm:ss
 */
function cambiafh_normal($fecha) {
    $mifecha = array();
    $lafecha = array();
    preg_match("#([0-9]{2,4})-([0-9]{1,2})-([0-9]{1,2}) ([0-9]{1,2}):([0-9]{1,2}):([0-9]{1,2})#", $fecha, $mifecha);
    $lafecha = $mifecha[3] . "/" . $mifecha[2] . "/" . $mifecha[1] . " " . $mifecha[4] . ":" . $mifecha[5] . ":" . $mifecha[6];
    return $lafecha;
}





//////////////////////////////////////////////////////////////////////////////////////////////////////// 
/**
 * Función nombreDia
 * 
 * @param int $numdia El número de día de la semana.
 * @return string El nombre del día de la semana.
 */
function nombreDia($numdia) {
    $dias = array("Lunes", "Martes", "Miércoles", "Jueves", "Viernes", "Sábado", "Domingo");
    return $dias[$numdia];
}
////////////////////////////////////////////////////////////////////////////////////////////////////////
/**
 * Función nombreMes
 * Devuelve el nombre del mes en español.
 * 
 * @param int $nummes El número de mes
 * @return string El nombre de mes correspondiente en español
 */
function nombreMes($nummes) {
    $meses = array("Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre");
    return $meses[$nummes];
}



////////////////////////////////////////////////////////////////////////////////////////////////////////
/**
 * Función chequearSpam.
 * Chequea caracteres de SPAM en el correo.
 * 
 * @param string $campo El campo a chequear.
 * @return boolean true si ha pasado correctamente el chequeo de spam o sale de la aplicación si se encontró spam imprimiendo un mensaje.
 */
function chequearSpam($campo) {
//Array con las posibles cabeceras a utilizar por un spammer
    $spam = array("Content-Type:",
        "MIME-Version:",
        "Content-Transfer-Encoding:",
        "Return-path:",
        "Subject:",
        "From:",
        "Envelope-to:",
        "To:",
        "bcc:",
        "cc:",
        "link=",
        "url=");

    //Comprobamos que entre los datos no se encuentre alguna de
    //las cadenas del array. Si se encuentra alguna cadena de SPAM muestra mensaje y sale de la aplicación.
    foreach ($spam as $patron) 
    {
        // strpos(pajar,aguja) devuelve FALSE si no encuentra la cadena.
        if (strpos(strtolower($campo), strtolower($patron)) !== false) {
            echo "<br/><br/><h3><CENTER>!! Error: Caracteres SPAM detectados en el correo !! </h3>";
            echo "<h4><CENTER>!! Spammers no permitidos. Solicitud cancelada. !! </h4>.<br/></CENTER>";
            exit; // Sale de la aplicación.
        }
    }

    return true;
}


////////////////////////////////////////////////////////////////////////////////////////////////////////
/**
 * Función chequearEmail
 * Comprueba que el e-mail tenga un formato válido.
 * 
 * @param type $campo
 * @return boolean true si ha pasado el chequeo de e-mail  o sale de la aplicación si se encontró un e-mail incorrecto.
 */
function chequearEmail($campo) {
    if (!filter_var($campo, FILTER_VALIDATE_EMAIL)) {
        echo "<br/><br/><h3><CENTER>!! Error: Formato de e-mail incorrecto </font>!! </h3>";
        echo "<h4><CENTER>!! Solicitud cancelada !! </h4>.<br/></CENTER>";
        exit; // Sale de la aplicación.
    }
    return true;
}



////////////////////////////////////////////////////////////////////////////////////////////////////////
/**
 * Función obtenerIP
 * Devuelve la dirección IP del cliente.
 * 
 * @return string La dirección IP del cliente.
 */
function obtenerIP() {
    return $_SERVER['REMOTE_ADDR'];
}



////////////////////////////////////////////////////////////////////////////////////////////////////////
/**
 * Función de envío de correo
 * Envía un correo electrónico y devuelve true si se ha enviado correctamente o false si ha habido error.
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
 * @return boolean Verdadero o falso según se haya podido enviar o no el correo.
 */
function enviarCorreo($nombreDestinatario, $emailDestinatario, $asunto, $contenido, $fichero='', $nombreRemitente = '', $emailRemitente = '', $servidorCorreo = '', $usuarioCorreo = '', $passwordCorreo = '', $puerto = '') {
    if (isset($emailDestinatario) && $emailDestinatario != '') {
        // Comenzamos con la configuración del correo.
        // Cargamos las librerías de phpmailer
        require_once dirname(__FILE__) . '/phpmailer/class.phpmailer.php';
        require_once dirname(__FILE__) . '/phpmailer/class.smtp.php';
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
        if ($servidorCorreo != '' && $usuarioCorreo != '' && $passwordCorreo != '') {
            // Pendiente validación de SPAM en el correo.
            if (chequearSpam($nombreDestinatario) && chequearSpam($emailDestinatario) && chequearSpam($asunto) && chequearSpam($contenido) && chequearEmail($emailDestinatario) ) 
            {
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
                
                // Si se pasa un fichero, lo adjuntamos al correo.
                if ($fichero!='')
                    $correo->AddAttachment($fichero);

                // Y enviamos el correo.
                if ($correo->Send())
                    return true;
                else
                    // Más información del error en: $correo->ErrorInfo;
                    return false;
            }
        }
    }
}

?>
