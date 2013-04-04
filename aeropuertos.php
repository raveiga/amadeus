<script type="text/javascript" src="http://maps.googleapis.com/maps/api/js?key=&sensor=false&libraries=geometry"></script>
<script type="text/javascript" src="js/aeropuertos.js"></script>

<style type="text/css">
    #mimapa{
        width:870px;
        height:500px;
    }

    #contenedorprincipal{
        position: relative;
    }

    #infomapa{
        width:250px;
        height:40px;
        position: absolute;
        top: 495px;
        padding: 5px;
        background-color: white;
        border: 1px solid #A6A6A6;
        box-shadow: 0 0 2px rgba(0, 0, 0, 0.2);
        padding: 10px;
        vertical-align: middle;
        white-space: nowrap;
        font-size: smaller;
        z-index:99;
    }

    #zonasugerencias{
        position: absolute;
        z-index: 30;
    }

    .enlace_sugerencia_over {
        background-color: #3366CC;
    }

    div.zonaconborde {
        top: 360px;
        width:400px;
        margin-left: 180px;
        background-color: #FFFFFF; 
        text-align: left; 
        border: 1px solid #000000;
        font-size: 12px;
    }

    li{
        list-style: none;
    }

    #infovuelos{
        width:600px;
        height:300px;
        position: absolute;
        top: 150px;
        left:150px;
        padding: 5px;
        background-color: white;
        border: 1px solid #A6A6A6;
        box-shadow: 0 0 2px rgba(0, 0, 0, 0.2);
        padding: 10px;
        vertical-align: middle;
        white-space: nowrap;
        font-size: smaller;
        z-index:99;
    }

    #infovuelos h3{
        width: 300px;
        float:left;
    }
    #cruz{
        float: right; 
    }
</style> 

<div class="wrapper">
    <div class="grids top">
        <div class="grid-3 grid">
            <h2>¿Dónde volamos?</h2>
            <div>
                <p class="bottom">
                    Origen: <input type="text" name="origen" id="origen"/>
                    Destino: <input type="text" name="destino" id="destino"/>
                    <input type="button" name="info" id="info" value="Mostrar Info. Ruta"/><br/><br/>

                    <input type="button" name="aeropuertos" id="aeropuertos" value="Cargar Aeropuertos"/><br/><br/>

                    Origen: <input type="radio" name="desde" id="dorigen" value="origen" checked />Destino: <input type="radio" name="desde" id="ddestino" value="destino" />
                    Salidas: <input type="radio" name="tipo" id="tiposalidas" value="salidas" checked />Llegadas: <input type="radio" name="tipo" id="tipollegadas" value="llegadas"/>
                    <input type="button" name="vuelos" id="vuelos" value="Vuelos en Tiempo Real"/><br/><br/>

                    <input type="button" name="geolocalizar" id="geolocalizar" value="Geolocalizame !"/>
                </p>
            </div>
            <div id="zonasugerencias"></div>
            <div id="opciones"></div>
        </div>

        <div id="contenedorprincipal" class="grid-13 grid">
            <!-- API CONSOLE https://code.google.com/apis/console -->
            <h2>Mapas de Aeropuertos</h2>
            <div id="mimapa"></div>
            <div id="infomapa"></div>
            <div id="infovuelos"></div>
        </div>
    </div><!--end of grids-->
</div>
