$(document).ready(function(){
    
   // Cubrimos los campos del formulario con los datos recibidos por AJAX.
   $.post("peticiones.php?op=4",function(respuesta){
       // gestionar los datos recibidos...
       // Creamos un objeto persona con el JSON que recibimos de la petición AJAX
       var persona=jQuery.parseJSON(respuesta);
       
       // Cubrimos los campos del formulario.
       $("#nick").val(persona.nick);
       $("#password").val(persona.password);
       $("#nombre").val(persona.nombre);
       $("#apellidos").val(persona.apellidos);
       $("#dni").val(persona.dni);
       $("#email").val(persona.email);
       $("#telefono").val(persona.telefono);
  });
   
   
   // CUando se produzca el submit...
   // hacemos la petición ajax enviando las actualizaciones al servidor.
   
   $("#formulario").submit(function(evento){
       
       // Cancelamos el evento por defecto de envío de datos.
       evento.preventDefault();
       
       // Metemos todos los datos del formulario en la variable datos.
       var datos=$("#formulario").serializeArray();
       
       // Hacemos la petición AJAX. op=5 Actualizar datos usuario logueado.
       $.post("peticiones.php?op=5",datos,function(resultado){
          $("#formulario").fadeOut(function(){
             $("#mensajes").fadeTo(0,0).css("background-color","green").html(resultado).fadeTo(500,1);
          });
       });
   });
   

   
    
}); // Fin document.ready()