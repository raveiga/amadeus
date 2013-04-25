<?php
@session_start();

// Aterrizamos en esta página cuando el usuario se ha autenticado en Twitter 
// Twitter nos devuelve adicionalmente dos parámetros GET en la respuesta de callback, que son:
// oauth_token y oauth_verifier.

if (!empty($_GET))      // Procedemos de Twitter....
{
    // Para continuar con el proceso de oauth, necesitaríamos seguir ejecutando
    // código de la clase twitter. Para ello creamos un objeto de esa clase
    // y que continúe el proceso dónde lo dejó. Recordar que tenemos variables de sesión que nos permiten
    // saber en que fase estamos de todo el proceso.
    require_once 'twitter.php';
    
    $twitter = new twitter();
    
    // Pendiente de completar...
    
    
    
    
}


?>
