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
        top: 130px;
        right: 5px;
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
</style>

<div class="wrapper">
    <div class="grids top">
        <div class="grid-3 grid">
            <h2>¿Dónde volamos?</h2>
            <div>
                <p class="bottom">
                    <input type="button" name="info" id="info" value="Mostrar Info. Ruta"/>
                    <input type="button" name="boton" id="boton" value="Cargar Aeropuertos"/>
                </p>
            </div>
            <div id="opciones"></div>
        </div>


        <div id="contenedorprincipal" class="grid-13 grid">
            <!--        API CONSOLE https://code.google.com/apis/console-->
            <h2>Mapas de Aeropuertos</h2>
            <div id="mimapa"></div>
            <div id="infomapa"></div>
        </div>
    </div><!--end of grids-->
</div>
