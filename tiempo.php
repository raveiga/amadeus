<script type="text/javascript" src="js/tiempo.js"></script>
<style type="text/css">
    #zonasugerencias{
        position: absolute;
        z-index: 30;
        top:290px;
        margin-left: -70px;
    }

    .enlace_sugerencia_over {
        background-color: #3366CC;
    }

    div.zonaconborde {
        width:400px;
        background-color: #FFFFFF; 
        text-align: left; 
        border: 1px solid #000000;
        font-size: 12px;
    }

    li{
        list-style: none;
    }
</style> 

<div class="wrapper">
    <div class="grids top">
        <div class="grid-6 grid">
            <h4>Consulta Méteo en Tiempo Real</h4>
            <div>
                <p><b>Meteorología en aeropuertos de todo el mundo..</b><br/>
                <p>Seleccione localidad: <input type="text" name="origen" id="origen" /></p>

                <br/><b>Servicio Web</b> facilitado por <a href='http://www.wunderground.com/' target='_blank'>Wunderground</a>, utilizando <a href='http://www.wunderground.com/weather/api/' target='_blank'>Weather API REST</a>.
            </div>
        </div>

        <div class="grid-10 grid">
            <div id="zonasugerencias"></div>
            <div id="tiempo"></div>
        </div><!--end of grid-10-->
    </div><!--end of grids-->
</div>