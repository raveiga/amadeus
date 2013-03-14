$(document).ready(function()
{
    // Latitud NORTE(valores -) |ecuador| SUR(valores -)
    // Longitud OESTE(valores -) |Meridiano Greenwich| ESTE (valores +) 
    // Creamos dos puntos geográficos (latitud,longitud).
    var madrid = new google.maps.LatLng(40.4167754,-3.7037902);
    var instituto = new google.maps.LatLng(42.878676, -8.547272);
    
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
    var marcaInstituto = new google.maps.Marker(
    {
        map: mapa,
        draggable: false,
        animation: google.maps.Animation.DROP,
        position: instituto,
        title: 'IES San Clemente' 
    });


    // Programamos que al hacer click en el marcador
    // del instituto haga una animación.
    google.maps.event.addListener(marcaInstituto,'click',function(){
        if (marcaInstituto.getAnimation() != null)
            marcaInstituto.setAnimation(null);
        else
            marcaInstituto.setAnimation(google.maps.Animation.BOUNCE);
        
    });
    
   

    
    
    
});  // document.ready.