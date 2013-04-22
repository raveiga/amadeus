<?php

// Para que funcione LDAP en XAMPP.
// Habilitar extension=php_ldap.dll
// Copiar xampp/php/libsasl.dll  al directorio xampp/apache/bin
// Activar también extension=php_openssl.dll en xamp/php/php.ini
// Intro a LDAP : http://ldapman.org/articles/sp_intro.html
// http://www.php.net/manual/es/book.ldap.php
/*
  GLOSARIO:
  DN -> Distinguised Name: Todas las entradas almacenadas en un directorio LDAP tienen un único "Distinguished Name," o DN
  El DN para cada entrada está compuesto de dos partes: el Nombre Relativo Distinguido (RDN por sus siglas en ingles, Relative Distinguished Name) y la localización dentro del directorio LDAP donde el registro reside. l RDN es la porción de tu DN que no está relacionada con la estructura del árbol de directorio.

  DC -> Domain Component.
  OU -> Organizational Unit
  CN -> Common Name: la mayoría de los objetos que almacenarás en LDAP utilizarán su valor cn como base para su RDN

  EJEMPLO:
  El DN base de un directorio es dc=foobar,dc=com
  Estoy almacenando todos los registros LDAP para mis recetas en ou=recipes
  El RDN de mi registro LDAP es cn=Oatmeal Deluxe

  Dado todo esto, ¿cuál es el DN completo del registro LDAP para esta receta de comida de avena ? Recuerda, se lee en órden inverso, hacia atrás - como los nombres de máquina en los DNS.

  cn=ComidaDeAvena Deluxe,ou=recipes,dc=foobar,dc=com

 */

class ldap {

    private $_servidorLDAP;
    private $_puerto;
    private $_conexion = false;
    private $_filtroBusqueda;
    private $_camposMostrarLDAP = array("name", "displayname", "cn", "homedirectory", "mail", "lastlogon", "memberof", "givenname");
    private $_ou = 'OU=SC-Usuarios,DC=sanclemente,DC=local';
    // Estas variables se utilizarán para acceder desde otros módulos de diferentes aplicaciones.
    public $cn = false;
    public $mail = false;
    public $givenname = false;
    public $displayname = false;
    public $dn = false;

    /**
     * Constructor.
     * 
     * @param type $servidor
     * @param type $puerto
     */
    public function __construct($servidor, $puerto = 389) {
        $this->_servidorLDAP = $servidor;
        $this->_puerto = $puerto;

        if (strstr($servidor, 'ladps://') === false)
            $this->_conexion = ldap_connect($this->_servidorLDAP, $this->_puerto) or die("Imposible conectar al servidor LDAP $this->_servidorLDAP");
        else
            $this->_conexion = ldap_connect($this->_servidorLDAP) or die("Imposible conectar al servidor LDAP $this->_servidorLDAP");
    }

    
    public function __destruct() {
        ldap_unbind($this->_conexion);
    }
    
    /**
     * Función validarUsuario
     * 
     * Valida un usuario contra el LDAP.
     * 
     * @param string $usuario
     * @param string $dominioldap
     * @param string $password
     * @return boolean
     */
    public function validarUsuario($usuario, $dominioldap, $password) {
        if ($this->_conexion) {
            $resultado = @ldap_bind($this->_conexion, "$usuario@$dominioldap", "$password");
            if ($resultado)
                return true;
            else
                return false;
        }
        else {
            die("No hay conexión con el servidor LDAP.");
        }
    }
// Fin validarUsuario

    
    
    /**
     * 
     * Método ojearUsuarios()
     *
     * Nos permite hacer búsquedas sobre el LDAP en base a un usuario contenido en el atributo name o displayname.
     * 
     * @param string $usuario
     * @param array $camposMostrar
     */
    public function ojearUsuarios($usuario, $camposMostrar = false) {
        // Información sobre los filtros de búsqueda.
        // http://www.centos.org/docs/5/html/CDS/ag/8.0/Finding_Directory_Entries-LDAP_Search_Filters.html
        // https://confluence.atlassian.com/display/DEV/How+to+write+LDAP+search+filters
        // http://grover.open2space.com/content/use-php-create-modify-active-directoryldap-entries

        $this->_filtroBusqueda = "(|(name=$usuario*)(displayname=*$usuario*))";

        if (!$camposMostrar)
            $campos = $this->_camposMostrarLDAP;
        else
            $campos = $camposMostrar;

        // Realizamos la búsqueda.
        $resultados = ldap_search($this->_conexion, $this->_ou, $this->_filtroBusqueda, $campos);

        // Ordenamos los resultados de la búsqueda.
        ldap_sort($this->_conexion, $resultados, 'name');

        // Recorrer los resultados de la búsqueda.
        for ($entrada = ldap_first_entry($this->_conexion, $resultados); $entrada != false; $entrada = ldap_next_entry($this->_conexion, $entrada)) {
            // Averiguamos los atributos que tiene una entrada en particular.
            $atributos = ldap_get_attributes($this->_conexion, $entrada);

            // Imprimimos el número de atributos que tiene la entrada
            echo "Atributos de esta entrada: " . $atributos['count'] . "<br/>";

            // Imprimimos el contenido de todos los atributos de cada entrada.
            for ($i = 0; $i < $atributos['count']; $i++) {
                // Para obtener el contenido de un atributo se hace con
                // ldap_get_values.
                $dato = ldap_get_values($this->_conexion, $entrada, $atributos[$i]);
                // Hacemos un bucle por si tenemos atributos duplicados.
                // Eso se sabe consultando $dato['count'] que sería distinto de 1.
                for ($j = 0; $j < $dato['count']; $j++)
                    echo $atributos[$i] . ":" . $dato[$j] . "<br/>";
            }

            echo "DN del usuario: " . ldap_get_dn($this->_conexion, $entrada);

            echo "<hr/>";
        } // bucle for.
    }
// Fin ojearUsuarios.

    
    
    /**
     * Método actualizarEmail
     * 
     * Permite actualizar en el LDAP el e-mail de cualquier usuario.
     * 
     * @param string $nuevomail
     * @param string $dn Ejemplo: 'CN=veiga,OU=Informatica,OU=Profes,OU=SC-Usuarios,DC=sanclemente,DC=local'
     * 
     */
    public function actualizarEmail($nuevomail, $dn) {
        // Creamos un array con el dato a actualizar.
        $nuevosdatos['mail'] = $nuevomail;

        // Modificamos ese atributo en el ldap para el DN recibido.
        ldap_modify($this->_conexion, $dn, $nuevosdatos);
    }

    
    
    
    public function infoUsuario($usuario, $camposMostrar = false) {
        $mensaje = '';
        $this->_filtroBusqueda = "(name=$usuario)";

        if (!$camposMostrar)
            $campos = $this->_camposMostrarLDAP;
        else
            $campos = $camposMostrar;

        // Realizamos la búsqueda.
        $resultados = ldap_search($this->_conexion, $this->_ou, $this->_filtroBusqueda, $campos);

        // Ordenamos los resultados de la búsqueda.
        ldap_sort($this->_conexion, $resultados, 'name');

        // Recorrer los resultados de la búsqueda.
        for ($entrada = ldap_first_entry($this->_conexion, $resultados); $entrada != false; $entrada = ldap_next_entry($this->_conexion, $entrada)) {
            // Averiguamos los atributos que tiene una entrada en particular.
            $atributos = ldap_get_attributes($this->_conexion, $entrada);

            // Imprimimos el número de atributos que tiene la entrada
            $mensaje = "Atributos de esta entrada: " . $atributos['count'] . "<br/>";

            // Imprimimos el contenido de todos los atributos de cada entrada.
            for ($i = 0; $i < $atributos['count']; $i++) {
                // Para obtener el contenido de un atributo se hace con
                // ldap_get_values.
                $dato = ldap_get_values($this->_conexion, $entrada, $atributos[$i]);
                // ldap_get_values devuelve un array con x atributos iguales, y en la posición count nos indica cuantos están repetidos
                // en ese array.
                // Hacemos un bucle por si tenemos atributos duplicados.
                // Eso se sabe consultando $dato['count'] que sería distinto de 1.
                for ($j = 0; $j < $dato['count']; $j++) {
                    $mensaje.=$atributos[$i] . ":" . $dato[$j] . "<br/>";

                    // Actualizamos las variables públicas del objeto.
                    switch ($atributos[$i]) {
                        case 'mail':
                            $this->mail = $dato[$j];
                            break;
                        case 'displayName':
                            $this->displayname = $dato[$j];
                            break;
                        case 'name':
                            $this->name = $dato[$j];
                            break;
                    }
                }
            }

            $mensaje.="DN del usuario: " . ldap_get_dn($this->_conexion, $entrada);


            $mensaje.="<hr/>";

            $this->dn = ldap_get_dn($this->_conexion, $entrada);


            return $mensaje;
        } // bucle for.
    }

// Fin ojearUsuarios.
}

// Fin clase

/* Ejemplo de campos LDAP que se pueden encontrar en el Active Directory.
  objectClass
  cn
  sn
  description
  userPassword
  givenName
  givenName
  distinguishedName
  instanceType
  whenCreated
  whenChanged
  displayName
  uSNCreated
  memberOf
  uSNChanged
  name
  objectGUID
  userAccountControl
  codePage
  countryCode
  homeDirectory
  homeDrive
  scriptPath
  pwdLastSet
  primaryGroupID
  objectSid
  accountExpires
  sAMAccountName
  sAMAccountType
  userPrincipalName
  objectCategory
  dSCorePropagationData
 */
?>
