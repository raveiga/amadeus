<?php
// Para bloquear la cache en navegadores para las peticiones AJAX.
header('Cache-Control: no-cache, must-revalidate');
header('Expires: Mon, 25 Jul 1990 00:00:00 GMT');

// Cargamos la clase basedatos.
require_once("lib/basedatos.php");

// Creamos el objeto con el patrón diseño Singleton.
// No podemos usar $mibase= new Basedatos(), por que
// el constructor es privado en la clase Basedatos.
$mibase = Basedatos::getInstancia();

switch ($_GET['op']){
    case 1:  // Chequear nick
    
        
        break;
    
    case 2: // Alta de usuarios
        echo $mibase->insertarUsuario($_POST['nick'],$_POST['password'],$_POST['nombre'],$_POST['apellidos'],$_POST['dni'],$_POST['email'],$_POST['telefono']);
        
        break;
    
    case 3: // Listado de Usuarios
        
        break;
 }

?>