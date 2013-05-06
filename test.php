<?php
require_once 'lib/ldap.php';

$ldap = new ldap("10.0.4.1");

if($ldap->validarusuario("ldap2","sanclemente.local","abc123.."))
{
        echo "OK usuario validado en Active Directory.<br/><br/>";
        //$ldap->ojearUsuarios("veiga");
        $ldap->infoUsuario("veiga");

}
   else
        echo "ERROR datos incorrectos de acceso";

$client = new Zend_Rest_Client('http://framework.zend.com/rest');
echo $client->sayHello('Davey', 'Day')->get(); // "Hello Davey, Good Day"
?>