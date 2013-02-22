// Código de Javascript del fichero registro.php

// Cuando el DOM esté preparado programamos el código de jQuery
// Forma reducida: $(function()
$(document).ready(function()
{
    // Ejemplos de uso de jQuery.
    // alert("Documento preparado! ") ;
    // $("#telefono").val("981-");
    // alert($("#telefono").val());

    // Al hacer click en el campo email escribimos una @.
    /*
    $("#email").click(function(){
        // $("#email").val("@");
        // Otra forma de hacerlo:
        $(this).val("@");
    });
    */

    $("#nick").blur(function()
    {
        // Operacion op=1 -> chequear nick.
        $.post("peticiones.php?op=1", { nick: $("#nick").val() }, function(respuesta)
        {
            if (respuesta == "Nick en uso" ||  $("#nick").val()=="")
            {
                // Cuando se oculta el objeto con fadeIn o fadeOut o hide deja de ocupar espacio en el documento
                // y en este caso provoca que haya un desplazamiento vertical del formulario al usar esos efectos.
                //
                // Usaremos fadeTo, que juega con la opacidad del objeto (de transparente a opaco), pero siempre ocupará el espacio original.
                // Usaremos fadeTo, que ajusta la opacidad sin ocultar el objeto.
                // http://api.jquery.com/fadeTo/
                // fadeTo(duración,opacidad,[funcion])

                // Hack para que funcione el .focus()en cualquier navegador. Consiste en hacer un setTimeout con tiempo de espera 0 segundos y que
                // llame al método .focus() sobre el objeto $("#nombre")
                // Información sobre burbujeo de eventos:
                // http://www.slideshare.net/demimismo/javascript-en-proyectos-reales-jquery-presentation (paginas 32 a 38)
                // http://www.quirksmode.org/js/events_order.html

                setTimeout('$("#nick").focus()',0);

                // Utilizamos clearQueue para conseguir, que si hacemos varios clicks seguidos, se cancelen los efectos de fade pendientes de clicks anteriores.
                // Probad el funcionamiento con y sin clearQueue() haciendo varios clicks seguidos.
                $("#mensajes").clearQueue().fadeTo(0,0).html("El campo nombre es obligatorio").fadeTo(500,1).css("background-color","red").delay(400).fadeTo(2000,0);
            }
        });
    });


    // Programamos la consulta AJAX para chequear el nick.
    $("#nick").keyup(function()
    {
        $.post("peticiones.php?op=1", { nick: $("#nick").val() }, function(respuesta)
        {

            if (respuesta == "Nick en uso")
            {
                $("#nick").css("background-color","red");
                $("#mensajes").clearQueue().fadeTo(0,0).html(respuesta).css("background-color","red").fadeTo(500,1).fadeTo(500,0);
            }
            else
            {
                $("#nick").css("background-color","green");
            }
        }) ;
    });


    // Cuando se produzca el evento de submit.
    $("#formulario").submit(function(evento)
    {
        // Cancelamos la acción principal del evento con preventDefault().
        evento.preventDefault();
          
        // Método clásico de petición ajax POST poniendo todos los campos y valores entre llaves: ,{ campo1:valor, campo2:valor, ...},function..
        // $.post("pagina.php",{nick:$("#nick").val(), nombre:$("#nombre").val(),.... },function(resultado)....)
          
        // Método rápido de envío de todos los datos del formulario.
        datos=$("#formulario").serializeArray();
        
        // Si queremos mostrar en consola de Firebug los datos que enviamos escribiremos:
        // console.log(datos);
          
        // Se hace la petición a peticiones.php pasándole el código de peticion op, en este caso 2 quiere decir Alta de Usuarios.
        $.post("peticiones.php?op=2",datos,function(resultado){
                $("#formulario").fadeOut(function(){
                    $("#mensajes").fadeTo(0,0).css("background-color","green").html(resultado).fadeTo(1,1);
                });
        });
    }); 




}); // Cierre de $(document).ready..