<script type="text/javascript" src="js/noticias.js"></script>
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
            <h4>Noticias y Novedades RSS</h4>
            <div id="botonesrss">
                <p>Consulte las noticias más importantes<br/>a través del menú.</p>
                <ul>
                    <li><input type="button" id="http://news.google.es/news?pz=1&cf=all&ned=es&hl=es&topic=t&output=rss" name="Ciencia y Tecnología desde Google" value="Noticias Google"/></li>
                    <li><input type="button" id="http://feeds.feedburner.com/publico/portada?format=xml" name="Noticias Diario Publico" value="Noticias Publico"/></li>
                    <li><input type="button" id="http://ep00.epimg.net/rss/elpais/portada.xml" name="Noticias Diario El Pais" value="Noticias El Pais"/></li>
                    <li><input type="button" id="http://feeds.weblogssl.com/genbeta" name="Noticias Programación GenBeta" value="Noticias GenBeta"/></li>
                    <li><input type="button" id="http://www.howtoforge.com/feed.rss" name="Hardware y Sistemas en Howtoforge" value="News HowtoForge"/></li>
                </ul>
            </div>
        </div>

        <div class="grid-10 grid">
            <div id="noticias"></div>
        </div><!--end of grid-10-->
    </div><!--end of grids-->
</div>
