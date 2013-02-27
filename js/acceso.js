// Código de Javascript del fichero registro.php

// Cuando el DOM esté preparado programamos el código de jQuery
// Forma reducida: $(function()
$(document).ready(function()
{
    // Cuando se produzca el evento de submit.
    $("#formulario").submit(function(evento)
    {
        // Cancelamos la acción principal del evento con preventDefault().
        evento.preventDefault();
          
        // Método rápido de envío de todos los datos del formulario.
        datos=$("#formulario").serializeArray();
        
        // Si queremos mostrar en consola de Firebug los datos que enviamos escribiremos:
        // console.log(datos);
          
        // Se hace la petición a peticiones.php pasándole el código de peticion op, en este caso 3 quiere decir Chequear Inicio de Sesión.
        $.post("peticiones.php?op=3",datos,function(resultado)
        {
            if (resultado=="OK")
            {
                $("#formulario").fadeOut(function()
                {
                    $("#mensajes").fadeTo(0,0).css("background-color","green").html('Acceso concedido al sistema').fadeTo(500,1,function()
                    {
                        setTimeout('document.location="index.html"',1000);
                    });
                });
           
            }
            else
                $("#mensajes").fadeTo(0,0).css("background-color","red").html(resultado).fadeTo(400,1).delay(900).fadeTo(1000,0);
            
        });
    }); // Formulario submit


}); // Cierre de $(document).ready..
