<script type="text/javascript" src="js/registro.js"></script>

<style type="text/css">
    #mensajes{
        border-radius:15px;
        -moz-border-radius:15px; /* Firefox */
        -webkit-border-radius:15px; /* Safari y Chrome */
        width:400px;
        height:25px;
        text-align: center;
        vertical-align: middle;
        font-size: 15px;
        color:white;
    }
</style>

<div class="wrapper">
    <div class="grids top">
        <div class="grid-6 grid">
            <h4>Ventajas como usuario registrado</h4>
            <div>
                <p class="bottom">
                <ul>
                    <li>Billetes + baratos</li>
                    <li>Low cost airlines</li>
                    <li>Todas las compañías aéreas</li>
                    <li>Volamos a todo el mundo</li>
                    <li>Número ilimitado de reservas</li>
                    <li>Notificaciones automáticas de su reserva</li>
                    <li>Información de cambios</li>
                    <li>Mapas de aeropuertos</li>
                    <li>Información meteorológica en destino</li>
                    <li>Etc...</li>
                </ul>
                </p>
            </div>
        </div>

        <div class="grid-10 grid">

            <h2>Formulario de Registro</h2>
            <div id="mensajes"></div>
            <form action="#" name="formulario" id="formulario" method="post">
                <table class="form">
                    <tr>
                        <th>
                            <label for="nick">Nick</label>
                        </th>
                        <td>
                            <input type="text" id="nick" name="nick" required="required" />
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
                            <label for="nombre">Nombre</label>
                        </th>
                        <td>
                            <input type="text" id="nombre" name="nombre" required="required" />
                        </td>
                    </tr>
                    <tr>
                        <th>
                            <label for="apellidos">Apellidos</label>
                        </th>
                        <td>
                            <input type="text" id="apellidos" name="apellidos" required="required" />
                        </td>
                    </tr>
                    <tr>
                        <th>
                            <label for="dni">DNI</label>
                        </th>
                        <td>
                            <input type="text" id="dni" name="dni" required="required" />
                        </td>
                    </tr>
                    <tr>
                        <th>
                            <label for="email">E-mail</label>
                        </th>
                        <td>
                            <input type="e-mail" id="email" name="email" required="required" />
                        </td>
                    </tr>

                    <tr>

                        <th>
                            <label for="telefono">Teléfono</label>
                        </th>
                        <td>
                            <input type="tel" id="telefono" name="telefono" required="required" />
                        </td>
                    </tr>

                </table>

                <p>
                    <input type="reset" value="Limpiar" class="float_right">
                    <input type="submit" value="Registrar" class="float_right" />
                </p>
            </form>


        </div><!--end of grid-10-->
    </div><!--end of grids-->

</div>