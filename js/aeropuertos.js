// ----------------------------------------------------------------------
/**
 * Se le pasan dos puntos del tipo LatLng(lat,lon)
 */
// ----------------------------------------------------------------------
function distancia2(punto1, punto2)
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


/**
 * Se le pasan dos puntos del tipo LatLng(lat,lon)
 */
// ----------------------------------------------------------------------
function distancia(punto1,punto2)
{
    // Para usar el cálculo de distancia de google maps.
    // Ese necesario cargar la librería geometry
    // http://maps.googleapis.com/maps/api/js?key=&sensor=false&libraries=geometry">
    
    return (google.maps.geometry.spherical.computeDistanceBetween(punto1,punto2)/1000).toFixed(2);
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
function crearMarcador(posicion,titulo,tipo)
{
    // tipo: origen, destino, defecto
    // Ruta de iconos de google maps.
    // https://sites.google.com/site/gmapicons/home
    switch(tipo)
    {
        case 'origen':
            icono='http://www.google.com/mapfiles/dd-start.png';
            break;
        case 'destino':
            icono='http://www.google.com/mapfiles/dd-end.png';
            break;
        default:
            icono='http://www.google.com/mapfiles/marker.png';
    }
    
    var marcador = new google.maps.Marker(
    {
        map: mapa,
        draggable: false,
        //animation: google.maps.Animation.DROP,
        position: posicion,
        title: titulo,
        icon: icono,
        shadow: icono
    });   

    crearInfo(titulo,marcador);

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



//----------------------------------------------------------------------
function infoVuelo(origen,destino)
{
    // origen y destino son marcadores -> objetos de tipo Marker.
    var velocidadAvion=850; // 850km/h de media de velocidad
    var maniobras=20; // 20 minutos para despegue y aterrizaje.
    
    // Calculamos el tiempo en minutos para recorrer los dos puntos.
    var tiempoMinutos= ( distancia(origen.getPosition(),destino.getPosition()) * 60 / velocidadAvion) + maniobras;
    
    horas = Math.floor(tiempoMinutos/60);
    minutos = Math.round(tiempoMinutos%60);
    
    mensaje= origen.getTitle()+" --> "+destino.getTitle()+": <b>"+distancia(origen.getPosition(),destino.getPosition())+"</b> km.<br/>Duración: <b>"+horas+"</b> horas y <b>"+minutos+"</b> minutos.";
    
    
    return mensaje;
}









////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////
$(document).ready(function()
{
    $("#infomapa").fadeTo(0,0);
    
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
        zoom: 3,
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
    
    
    
    // Creamos dos marcas.
    var mMadrid = crearMarcador(madrid,'Madrid','origen');
    var mNyork = crearMarcador(nyork,'Nueva York','destino');
    
    // Ejemplo de crearInfo:
    //crearInfo('Madrid capital de España',marcaMadrid);
    
    // Cambiamos el zoom del mapa.
    // mapa.setZoom(3);

    // Programamos que al hacer click en el marcador
    // del instituto haga una animación.
    // google.maps.event.addListener(marcaInstituto,'click',function(){
    //    toggleBounce(marcaInstituto);
    //    });
    
    // Dibujamos una linea entre Instituto y Madrid.
    var linea = dibujarRuta([madrid,nyork]);
    
    // Centramos el mapa en el punto medio entre el instituto y Madrid.
    mapa.setCenter(puntoMedio(madrid,nyork));
    
  
    // Programamos la acción de click sobre el botón #info.
    $("#info").click(function()
    {
        // Ponemos el contenido en infomapa.
        $("#infomapa").html(infoVuelo(mMadrid,mNyork));
       
        $("#infomapa").fadeTo(800,1,function()
        {
            $(this).delay(1800).fadeTo(600,0);
        });
    });
  
  
  
  
  
  
  
  
    
});  // document.ready.