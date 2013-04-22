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

?>