<style type="text/css">
    #mensajes{
        border-radius:15px;
        -moz-border-radius:15px; /* Firefox */
        -webkit-border-radius:15px; /* Safari y Chrome */
        width:400px;
        text-align: center;
        vertical-align: middle;
        font-size: 15px;
        color:white;
    }
</style>

<div class="wrapper">
    <div class="grids top">
        <div class="grid-6 grid">
            <h4>Registros</h4>
            En la zona de la derecha podrá consultar su estado de registro.
        </div>

        <div class="grid-10 grid">

            <h2>Confirmación del registro</h2>
             <?php
             // Cargamos la clase basedatos.
             require_once 'lib/basedatos.php';
             
             // Creamos el objeto de basedatos
             $mibase = Basedatos::getInstancia();
             
             // Llamamos al método confirmarRegistro de la clase Basedatos.
             echo $mibase->confirmarRegistro($_GET['nick'],$_GET['token']);
             ?>
        </div><!--end of grid-10-->
    </div><!--end of grids-->

</div>