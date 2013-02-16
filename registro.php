<script type="text/javascript">
     // Cuando el DOM esté preparado programamos el código de jQuery
     // Forma reducida: $(function()
     $(document).ready(function()
     {
	  // Ejemplos de uso de jQuery.
	  // alert("Documento preparado! ") ;
	  // $("#telefono").val("981-");
	  // alert($("#telefono").val());

	  // Al hacer click en el campo email escribimos una @.
	  $("#email").click(function(){
	       // $("#email").val("@");
	       // Otra forma de hacerlo:
	       $(this).val("@");
	  });


	  $("#nick").blur(function(){

	       $.post("chequearnick.php", {nick: $("#nick").val()}, function(respuesta){

		    if (respuesta == "Nick en uso" ||  $("#nick").val()=="")
		    {
			 // Cuando se oculta el objeto con fadeIn o fadeOut o hide deja de ocupar espacio en el documento
			 // y en este caso provoca que haya un desplazamiento vertical del formulario al usar esos efectos.
			 //
			 // Usaremos fadeTo, que juega con la opacidad del objeto (de transparente a opaco), pero siempre ocupará el espacio original.
			 // Usaremos fadeTo, que ajusta la opacidad sin ocultar el objeto.
			 // http://api.jquery.com/fadeTo/
			 // fadeTo(duración,opacidad,[funcion])

			 // Hack para que funcione el .focus()en cualquier navegador. Consiste en hacer un setTimeout con tiempo de espera 0 segundos y que
			 // llame al método .focus() sobre el objeto $("#nombre")
			 // Información sobre burbujeo de eventos:
			 // http://www.slideshare.net/demimismo/javascript-en-proyectos-reales-jquery-presentation (paginas 32 a 38)
			 // http://www.quirksmode.org/js/events_order.html

			 setTimeout('$("#nick").focus()',0);

			 // Utilizamos clearQueue para conseguir, que si hacemos varios clicks seguidos, se cancelen los efectos de fade pendientes de clicks anteriores.
			 // Probad el funcionamiento con y sin clearQueue() haciendo varios clicks seguidos.
			 $("#mensajes").clearQueue().fadeTo(0,0).html("El campo nombre es obligatorio").fadeTo(500,1).css("background-color","red").delay(400).fadeTo(2000,0);
		    }
	       });
	  });


	  // Programamos la consulta AJAX de nick en uso.
	  $("#nick").keyup(function(){
	       $.post("chequearnick.php", {nick: $("#nick").val()}, function(respuesta){

		    if (respuesta == "Nick en uso")
		    {
			 $("#nick").css("background-color","red");
			 $("#mensajes").clearQueue().fadeTo(0,0).html(respuesta).css("background-color","red").fadeTo(500,1).fadeTo(500,0);
		    }
		    else
		    {
			 $("#nick").css("background-color","green");
		    }
	       }) ;
	  });



     }); // Cierre de la función principal de document.ready
</script>

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
				   <input type="e-mail" id="email" name="e-mail" required="required" />
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