$(document).ready(function(){

$("#botonesrss input[type=button]").click(function()
{
    $.post("peticiones.php?op=10",{titulo:$(this).attr("name"), url:$(this).attr("id")}, function(resultado)
    {
       $("#noticias").html(resultado);
    
    });
});
   
});