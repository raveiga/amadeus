// ----------------------------------------------------------------------
/**
 * Se le pasan dos puntos (lat,lon)
 */
function distancia(punto1, punto2)
{
    lon1= punto1.lng().toString();
    lat1= punto1.lat().toString();
    lon2= punto2.lng().toString();
    lat2= punto2.lat().toString();
     
    rad = function(x) {
        return x*Math.PI/180;
    }

    var R     = 6378.137;                          //Radio de la tierra en km
    var dLat  = rad( lat2 - lat1 );
    var dLong = rad( lon2 - lon1 );

    var a = Math.sin(dLat/2) * Math.sin(dLat/2) + Math.cos(rad(lat1)) * Math.cos(rad(lat2)) * Math.sin(dLong/2) * Math.sin(dLong/2);
    var c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1-a));
    var d = R * c;

    return d.toFixed(3);                      //Retorna tres decimales
}

// ----------------------------------------------------------------------
function toggleBounce(nombreMarcador)
{
    if (nombreMarcador.getAnimation() != null)
        nombreMarcador.setAnimation(null);
    else
        nombreMarcador.setAnimation(google.maps.Animation.BOUNCE);
}

//------------------------------------------------------------------------
function crearMarcador(posicion, titulo)
{
    var marcador = new google.maps.Marker(
    {
        map: mapa,
        draggable: false,
        //animation: google.maps.Animation.DROP,
        position: posicion,
        title: titulo 
    });   

    return marcador;
}

//------------------------------------------------------------------------
function dibujarRuta(rutadepuntos)
{
    return  new google.maps.Polyline(
    {
        map: mapa,
        path: rutadepuntos,
        geodesic: true,
        strokeColor: "FF0000",
        strokeOpacity: 1.0,
        strokeWeight: 2      
    });   

}
//------------------------------------------------------------------------
function crearInfo(contenido,marcador)
{
    var informacion= new google.maps.InfoWindow(
    {
        maxWidth: 120,
        content: contenido
    });
    
    google.maps.event.addListener(marcador,'mouseover',function(){
        informacion.open(mapa,marcador);
    });
   
    google.maps.event.addListener(marcador,'mouseout',function(){
        informacion.close();
    });
    
    
}

//----------------------------------------------------------------------
function puntoMedio(punto1,punto2)
{
    lon1=parseFloat(punto1.lng().toString());
    lat1=parseFloat(punto1.lat().toString());
    lon2=parseFloat(punto2.lng().toString());
    lat2=parseFloat(punto2.lat().toString());
    
    latMedio=(lat1 + lat2)/2;
    lonMedio=(lon1 + lon2)/2;
    
    return new google.maps.LatLng(latMedio,lonMedio);
}

// ----------------------------------------------------------------------
$(document).ready(function()
{
    // Latitud NORTE(valores +) |ecuador| SUR(valores -)
    // Longitud OESTE(valores -) |Meridiano Greenwich| ESTE (valores +) 
    // Creamos dos puntos geográficos (latitud,longitud).
    var madrid = new google.maps.LatLng(40.4167754,-3.7037902);
    var instituto = new google.maps.LatLng(42.878676, -8.547272);
    var nyork = new google.maps.LatLng(40.7143528,-74.0059731);
    var miami = new google.maps.LatLng(25.7889689,-80.2264393);
    
    // Definimos las opciones de mapa en un objeto de tipo MapOptions
    // https://developers.google.com/maps/documentation/javascript/reference#MapOptions
    var opcionesMapa ={
        center: instituto,
        zoom: 17,
        mapTypeId: google.maps.MapTypeId.ROADMAP    
    };
    
    // document.getElementById('objeto'); //returns a HTML DOM Object
    // var contents = $('#objeto');  //returns a jQuery Object
    // Calling $('#id') will return a jQuery object that wraps the DOM object and provides jQuery methods.
    // 
    // Si queremos obtener el objeto DOM lo haríamos con:
    // var contents = $('#objeto')[0];
    // 
    // En nuestro caso:
    // document.getElementById("mimapa");
    // o tambien: $("#mimapa")[0];
    mapa = new google.maps.Map($("#mimapa")[0],opcionesMapa);
    
    
    // Creamos un objeto de tipo Market en el instituto.
    var marcaInstituto = crearMarcador(instituto,'IES San Clemente');
    var marcaMadrid = crearMarcador(madrid,'Madrid');
    
    crearInfo('Madrid capital de España',marcaMadrid);


    // Cambiamos el zoom del mapa.
    mapa.setZoom(6);


    // Programamos que al hacer click en el marcador
    // del instituto haga una animación.
    google.maps.event.addListener(marcaInstituto,'click',function(){
        toggleBounce(marcaInstituto);
    });
    
   

    // Dibujamos una linea entre Instituto y Madrid.
    var linea = dibujarRuta([instituto, madrid]);
    
    // Centramos el mapa en el punto medio entre el instituto y Madrid.
    mapa.setCenter(puntoMedio(instituto,madrid));
    
  
    mensaje="<p>La distancia entre el Instituto y Madrid es de "+distancia(instituto,madrid)+" Km.</p>";
    
    $("#opciones").html(mensaje);
    
});  // document.ready.