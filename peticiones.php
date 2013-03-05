<?php
// Activamos las variables de sesión.
@session_start();

// Para bloquear la cache en navegadores para las peticiones AJAX.
header('Cache-Control: no-cache, must-revalidate');
header('Expires: Mon, 01 Jan 1973 00:00:00 GMT');

// Cargamos la clase basedatos.
require_once("lib/basedatos.php");

// Creamos el objeto con el patrón diseño Singleton.
// No podemos usar $mibase= new Basedatos(), por que
// el constructor es privado en la clase Basedatos.
$mibase = Basedatos::getInstancia();

switch ($_GET['op']){
    case 1:  // Chequear nick
          echo $mibase->chequearNick($_POST['nick']);
        break;
    
    case 2: // Alta de usuarios
        echo $mibase->insertarUsuario($_POST['nick'],$_POST['password'],$_POST['nombre'],$_POST['apellidos'],$_POST['dni'],$_POST['email'],$_POST['telefono']);
        // Enviamos a continuación el correo de registro.
        break;
    
    case 3: // Chequear Inicio sesión
        echo $mibase->chequearAcceso($_POST['nick'],$_POST['password']);
        break;
    
    
    case 4: // Obtener los datos del usuario
        echo $mibase->obtenerInfoUsuario();
        break;
    
    case 5: // Actualizamos datos usuario logueado.
        echo $mibase->actualizarUsuario($_POST['password'],$_POST['nombre'],$_POST['apellidos'],$_POST['dni'],$_POST['email'],$_POST['telefono']);
        break;
    
 }

?>