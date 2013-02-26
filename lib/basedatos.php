<?php

// Gestión de la base de datos MySQL.
// Ejemplo de dirname:
// La constante predefinida __FILE__ de php contiene la ruta fisica real del fichero, por ejemplo para este fichero podría ser: /var/www/amadeus/basedatos.php
// dirname ("/var/www/amadeus/basedatos.php") --> devuelve /var/www/amadeus

require_once dirname(__FILE__) . '/config.php';
require_once dirname(__FILE__) . '/funciones.php';

class Basedatos {

    /**
     * @var Basedatos Contiene la instancia de Basedatos. 
     */
    private static $_instancia;

    /**
     *
     * @var boolean|mysqli Contiene el objeto mysqli después de que se haya 
     * establecido la conexión.
     */
    private static $_mysqli = false;

    
    
    
    //----------------------------------------------------------------------------------------------------
    /**
     * Crea la conexión al servidor o devuelve error parando la ejecución.
     * 
     * @return Basedatos Devuelve la referencia al objeto Basedatos.
     */
    public static function getInstancia() {
        if (!self::$_instancia instanceof self) {
            // Creamos una nueva instancia de basedatos.
            self::$_instancia = new self;

            // Creamos el objeto mysqli y lo asignamos a $_mysqli
            self::$_mysqli = @new mysqli(Config::$dbServidor, Config::$dbUsuario, Config::$dbPassword, Config::$dbDatabase);
            if (self::$_mysqli->connect_error) {
                echo "Error conectando Base Datos" . self::$_mysqli->connect_error;
                self::$_mysqli = false;
                die();
            }
        }

        // Si la instancia ya estaba creada, la devolvemos.
        return self::$_instancia;
    }

    
    
    
    //----------------------------------------------------------------------------------------------------
    /**
     * Función close()
     * Cierra una conexión activa con el servidor
     * 
     * @access public
     * @return boolean Siempre devolverá true.
     */
    public function close() {
        if (self::$_mysqli) {
            self::$_mysqli->close();
            self::$_mysqli = false;
        }
        return true;
    }

    
    
    
    //----------------------------------------------------------------------------------------------------
    /**
     * Función insertarUsuario()
     * Inserta los datos recibidos como parámetros en la tabla de usuarios.
     * 
     * @param string $nick
     * @param string $password
     * @param string $nombre
     * @param string $apellidos
     * @param string $dni
     * @param string $email
     * @param string $telefono
     * @return string "OK" indicando que se ha realizado con éxito la insercción de datos.
     */
    public function insertarUsuario($nick, $password, $nombre, $apellidos, $dni, $email, $telefono) {
        // Preparamos la instrucción SQL.
        $stmt = self::$_mysqli->prepare("insert into amadeus_usuarios(nick,password,nombre,apellidos,dni,email,telefono,token) values(?,?,?,?,?,?,?,?)") or die(self::$_mysqli->error);

        // Enlazamos los parámetros.
        $nick=strtolower($nick);
        $encriptada = encriptar($password, 10);
        $token=md5($encriptada);
        $stmt->bind_param('ssssssss', $nick, $encriptada, $nombre, $apellidos, $dni, $email, $telefono,$token);

        // Ejecutamos la instrucción
        $stmt->execute() or die(self::$_mysqli->error);

        $contenido="Estimado señor/a $nombre $apellidos.<br/><br/>Hemos recibido una petición de registros en nuestra web de viajes Amadeus.";
        $contenido.="Si usted no ha realizado dicha petición, simplemente borre este correo y en breve el registro será borrado de nuestra base de datos.<br/><br/>";
        $contenido.="En otro caso, confirme su registro antes de 24 H en la siguiente dirección de Amadeus:<br/>";
        $contenido.="<a href='".Config::$urlAplicacion."/confirmar.html?nick=$nick&token=$token'>Confirmación registro en web viajes Amadeus</a><br/><br/>";
        $contenido.="IP registrada: ".obtenerIP()."<br/><br/>";
        $contenido.="Reciba un cordial saludo.<br/><br/>Agencia de viajes Amadeus &copy; 2013.";
        
        if (enviarCorreo($nombre.' '.$apellidos,$email,'Confirmación registro en Viajes Amadeus',$contenido))
                return "Registro realizado correctamente.<br/><br/>Le hemos enviado una confirmación a su correo electrónico:<br/>$email";
        else
                return "!! ATENCION !!<br/><br/>Se ha producido un fallo al enviar el correo a $email.<br/>Contacte con ".Config::$mailEmailRemitente." para informar del problema.";
  }

  
  
    //----------------------------------------------------------------------------------------------------
    /**
     * Función chequearNick()
     * Comprueba si existe el nick en la base de datos.
     * 
     * @param string $nick Nick del usuario.
     * @return string Mensaje de en uso o disponible.
     */  
    public function chequearNick($nick) {
        // Preparamos la consulta.
        $stmt = self::$_mysqli->prepare("SELECT * from amadeus_usuarios where nick=?") or (self::$_mysqli->error);

        // Enlazamos los parámetros (s string)
        // http://es2.php.net/manual/es/mysqli-stmt.bind-param.php

        $stmt->bind_param("s", $nick);

        // Ejecutamos la consulta preparada.
        $stmt->execute();

        // Si es una consulta de select almacenamos el resultado.
        $stmt->store_result();

        // Número de filas obtenidas.
        $numfilas = $stmt->num_rows;

        // Liberamos el espacio que ocupa ese resultado en memoria.
        $stmt->free_result();

        if ($numfilas == 1)
            return "Nick en uso";
        else
            return "Nick disponible";
    }

    
    
    
    //----------------------------------------------------------------------------------------------------
    /**
     * Función confirmarRegistro()
     * Actualiza el token del usuario enviado por e-mail
     * 
     * @param string $nick Nick del usuario.
     * @param string $token Token recibido por e-mail.
     * @return string Mensaje de confirmación de actualización.
     */
    public function confirmarRegistro($nick,$token)
    {
        $nick=strtolower($nick);
        
        $stmt= self::$_mysqli->prepare("select * from amadeus_usuarios where nick=? and token=?") or die(self::$_mysqli->error);
        
        // Enlazamos los parámetros con bind_param.
        $stmt->bind_param("ss",$nick,$token);
        
        // Ejecutamos la consulta
        $stmt->execute();
        
        // Almacenamos el resultado.
        $stmt->store_result();
        
        // Número de filas obtenidas en la consulta.
        $numfilas = $stmt->num_rows;
        
        if ($numfilas ==1)
        {
            // Los datos son correctos.
            // Actualizamos el token a OK.
            
            // Preparamos la consulta de actualizacion
            $stmt=self::$_mysqli->prepare("update amadeus_usuarios set token='OK' where nick=?") or die(self::$_mysqli->error);
            
            // Enlazamos el parámetro
            $stmt->bind_param('s',$nick);
            
            // Ejecutamos la instrucción
            $stmt->execute() or die(self::$_mysqli->error);
            
            // Devolvemos el mensaje
            return "<h3>Su registro ha sido confirmado satisfactoriamente</h3>";
        }
        else
            return "Error: los datos de validación son incorrectos";
    }
    
    
    
    
    }
?>
