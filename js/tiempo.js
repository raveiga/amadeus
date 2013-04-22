$(document).ready(function()
{
        
    $("#origen").click(function()
    {
        $(this).val("");
    });
        
        
        
    $("#origen").keyup(function()
    {
        // Averiguamos el nombre del objeto dónde estamos escribiendo.
        casillaclick=$(this).attr('id');
        
        $.post("peticiones.php?op=8",{
            aeropuerto:$(this).val()
        },function(datos){
            // Convierte a objeto de Javascript el JSON recibido desde PHP.
            aeropuertos = jQuery.parseJSON(datos);
            listado='';
        
            // Recorremos el array.
            $.each(aeropuertos,function(index,valor)
            {
                // En index tenemos del 0 al 10 como máximo.
                // En valor tendremos el objeto con todas sus prop.
                listado+="<li>"+valor.aeropuerto+", "+valor.ciudad+" - "+valor.pais+" ("+valor.iata+")</li>";
            });
            
            if (aeropuertos.length !=0)
                $("#zonasugerencias").addClass("zonaconborde");
            else
                $("#zonasugerencias").removeClass("zonaconborde");
        
            // Metemos en el contenedor el listado generado con <li>...
            $("#zonasugerencias").html(listado);
            
            $("#zonasugerencias li").each(function()
            {
                $(this).mouseover(function()
                {
                    $(this).addClass("enlace_sugerencia_over");
                });
            
                $(this).mouseout(function()
                {
                    $(this).removeClass("enlace_sugerencia_over");
                });
            
                $(this).click(function()
                {
                    // http://preloaders.net para generar un indicador Ajax.
                    // Activamos el spinner Ajax.
                    $("#tiempo").html("<img src='img/spinner.gif'/>");
                        
                    $("#"+casillaclick).val($(this).text());
                
                    // Necesitamos averiguar la posición dónde hemos hecho click, 
                    // para poder ir al array aeropuertos y coger los datos de latitud y longitud de ese aeropuerto.
                    // $(this).parent().children().index($(this));
                    posiciondeclick=$(this).parent().children().index($(this));
                  
                    // Ocultamos el div de sugerencias
                    $("#zonasugerencias").removeClass("zonaconborde").html("");
                        
                        
                    // Hacemos la petición al servicio web de Wunderground.
                        
            
                    // aeropuertos[posiciondeclick].ciudad
                    // aeropuertos[posiciondeclick].ciudad
            
                    $.post("peticiones.php?op=11",{  pais: aeropuertos[posiciondeclick].pais, localidad: aeropuertos[posiciondeclick].ciudad },function(resultados)

                    {
                        prediccion=jQuery.parseJSON(resultados);
                                
                        if (!("current_observation" in prediccion) && !("error" in prediccion.response))
                        {
                            $("#tiempo").html("<h3>No hay predicción meteorológica para:</h3><br/><h4>"+prediccion.response.results[0].name+", "+prediccion.response.results[0].country_name+".</h4>")
                        }
                        else   if ("error" in prediccion.response)
                        {
                            $("#tiempo").html("<h3>Atención no se ha encontrado la localidad:</h3><br/><h4> "+$("#origen").val()+".</h4>")
                        }
                        else
                        {
                            cadena="<h3 style='display:inline'>Predicción: "+prediccion.current_observation.display_location.full+".</h3>";
                            cadena+="<h4>Tiempo Actual: "+prediccion.current_observation.weather;
                            cadena+="<img src='"+prediccion.current_observation.icon_url+"'/></h4>";
                            cadena+="<h4>Temperatura: "+prediccion.current_observation.temp_c+" grados centígrados.</h4>";
                            cadena+="<h5>Mañana: "+prediccion.forecast.txt_forecast.forecastday[2].fcttext_metric;
                            cadena+="<img src='"+prediccion.forecast.txt_forecast.forecastday[2].icon_url+"'/></h5>";
                            cadena+="Méteo facilitada por: <img align='middle' src='"+prediccion.current_observation.image.url+"'/>";
                        
                            $("#tiempo").html(cadena);
                        }
                
    
                    }) ;
                        
                        
                        
                        
                        
                        
                });
            });

        });
    });
 
 
});  // document.ready