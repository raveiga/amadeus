$(document).ready(function(){

$("#botonesrss input[type=button]").click(function()
{
    $.post("peticiones.php?op=10",{titulo:$(this).attr("name"), url:$(this).attr("id")}, function(resultado)
    {
        // Para realizar la animación del scroll, usamos animate de jQuery.
        // http://api.jquery.com/animate/
        
       $("#noticias").html(resultado).animate({scrollTop:0},'slow');
    
    });
});
   
});