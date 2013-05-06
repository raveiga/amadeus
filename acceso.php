<?php
    require_once 'lib/config.php';
?>
<script type="text/javascript" src="js/acceso.js"></script>

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
            <h4>Acceso para usuarios registrados</h4>
            <div>
                <p class="bottom">
                   Si usted tiene cuenta de usuario local o a través de LDAP, utilice el formulario de la derecha, seleccionando el modo de Autenticación deseado.<br/><br/>Si desea acceder con su cuenta de Twitter utilice el botón inferior.
                </p>
                <a href='logintwitter.php'><img src='img/twitter2.png'/></a>
            </div>
        </div>

        <div class="grid-10 grid">

            <h2>Acceso local y LDAP.</h2>
            <div id="mensajes"></div>
            <form action="#" name="formulario" id="formulario" method="post">
                <table class="form">
                    <tr>
                        <th>
                            <label for="nick">Nick</label>
                        </th>
                        <td>
                            <input type="text" id="nick" name="nick" required="required" autofocus />
                        </td>
                    </tr>
                    <tr>
                        <th>
                            <label for="password">Contraseña</label>
                        </th>
                        <td>
                            <input type="password" id="password" name="password" required="required" />
                        </td>
                    </tr>
                    <tr>
                        <th>
                            <label for="autenticacion">Modo Autenticación</label>
                        </th>
                        <td>
                            <select id="autenticacion" name="autenticacion">
                                <option value="local" selected>Base Datos Local</option>
                                <option value="ldap">LDAP: <?php echo Config::$ldapDominio; ?></option>
                            </select>
                        </td>
                    </tr>

                </table>

                <p>
                    <input type="reset" value="Limpiar" class="float_right">
                    <input type="submit" value="Acceder" class="float_right" />
                </p>
            </form>


        </div><!--end of grid-10-->
    </div><!--end of grids-->

</div>