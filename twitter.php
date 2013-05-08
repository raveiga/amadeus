<script type="text/javascript" src="js/twitter.js"></script>
<style type="text/css">
    #noticias{
        overflow-y: auto;
        overflow-x: hidden;
        height: 400px;
    }

    ul li{
        list-style-type: none;
        margin-bottom: 5px;
    }

</style>

<div class="wrapper">
    <div class="grids top">
        <div class="grid-6 grid">
            <h4>Operaciones sobre Twitter</h4>
            <div id="botonesrss">
                <p>Operaciones que puede realizar sobre<br/>su cuenta de Twitter.</p>
                <ul>
                    <li><input type="button" id="misdatos" name="misdatos" value="Mis Datos en Twitter"/></li>
                    <li><input type="button" id="status" name="status" value="Mostrar mi Timeline"/></li>
                    <li><input type="button" id="timeline" name="timeline" value="Timeline de otros usuario (@elpais)"/></li>
                    <li><input type="button" id="publicar" name="publicar" value="Publicar Mensaje en Twitter"/></li>
                </ul>
            </div>
        </div>

        <div class="grid-10 grid">
            <h4>Información sobre Twitter</h4>
            <div id="twitter"></div>
        </div><!--end of grid-10-->
    </div><!--end of grids-->
</div>
