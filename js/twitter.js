$(document).ready(function(){

    $("#botonesrss input[type=button]").click(function(){

        $("#responsetwitter").text("");

        var boton = $(this).attr("id");

        if (boton == "publicar"){

            $("#twitter").html('');
            var texto = prompt("Introduce Tweet:");

            if (texto==null || texto.length==0)
                $("#twitter").html('No se ha publicado nada en Twitter.');
            else
                {
                    // Activamos el spinner.
                    $("#twitter").html("<img src='img/spinner.gif'/>");

                    $.post("peticiones.php?op=12", { boton: boton, informacion: texto }, function(respuesta)
                    {
                        $("#twitter").html(respuesta);
                    });
                }
        }
        else if(boton == "timeline")
        {
            var user = prompt("Introduce usuario a mostrar:");
            if (user==null || user.length==0)
                $("#twitter").html('No se ha publica nada en Twitter.');
            else
                {
                    // Activamos el spinner.
                    $("#twitter").html("<img src='img/spinner.gif'/>");

                    $.post("peticiones.php?op=12", { boton: boton, informacion: user }, function(respuesta)
                    {
                        $("#twitter").html(respuesta);

                    });
                }
        }
        else
        {
            // Activamos el spinner.
            $("#twitter").html("<img src='img/spinner.gif'/>");

            $.post("peticiones.php?op=12", { boton: $(this).attr("id") }, function(respuesta)
            {
                $("#twitter").html(respuesta);
            });
        }
    });

});// final del $(document).ready
