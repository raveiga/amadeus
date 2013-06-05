$(document).ready(function() {
    $("form").submit(function(evento)
    {
        // Cancelamos la acciÃ³n principal del evento con preventDefault().
        evento.preventDefault();

        // MÃ©todo rÃ¡pido de envÃ­o de todos los datos del formulario.
        datos = $("form").serializeArray();

        // Si queremos mostrar en consola de Firebug los datos que enviamos escribiremos:
        console.log(datos);

        // Se hace la peticiÃ³n a contacto.php
        $.post("peticiones.php?op=14", datos, function(resultado) {
            $("form").fadeOut(function() {
                $("div.grid-10.grid").clearQueue().fadeTo(0, 0).html(resultado).fadeTo(500, 1).css("background-color", "green").delay(3000).fadeTo(500, 0); // Muestra mensaje
            });
        });
    });
});
