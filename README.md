GESTIÓN DE RESERVAS AÉREAS.


Requisitos previos

Se recomienda tener instaladas las siguientes aplicaciones:
- Netbeans 7.2.1
- Git
- Cuenta en GitHub

Enunciado

Se desea desarrollar una aplicación para gestionar las reservas de Vuelos al estilo Amadeus. (https://www.amadeus.net)

Los aviones pertenecen a una compañía aérea: nombre, url, url-logotipo y teléfono de contacto.

De cada avión nos interesa almacenar su modelo, matrícula, compañía a la que pertenece,  número de plazas turista, número plazas business y la ruta que realiza (origen, destino) y días de la semana que vuela.

Los usuarios de la aplicación se identificarán por un nick y una contraseña y se almacenarán los siguientes datos: nombre, apellidos, dni, e-mail, fotografía y teléfono de contacto.

Cada usuario de la aplicación podrá realizar lo siguiente:
	- Registrarse en el sistema (se enviará mail de confirmación para confirmar el registro).
	- Modificar sus datos personales (menos el nick), así como la fotografía.
	- Realizar reservas (como máximo 3 reservas activas).
	- Mostrar su listados de reservas.
	- Consultar una reserva.
	- Borrar reservas.

El usuario admin del sistema podrá realizar lo siguiente:
	- Añadir nuevos aviones a la flota.
	- Modificar la flota (añadir aviones, borrar aviones, modificar sus datos).
	- Si se borra un avión, sus reservas tendrán que pasar a otro avión que realice la misma ruta y el mismo día (se nos pedirá escoger alguno de los aviones disponibles mostrando el número de plazas disponibles en el listado). Se copiarán todas las reservas posibles hasta que el avión esté lleno (hay que respetar el tipo de reserva de cada pasajero). Al resto de usuarios que no se han podido registrar se les mandará un e-mail indicando que se pongan en contacto con la compañía aérea.
	- Podrá dar de baja un usuario registrado.

Extras:
	- Las contraseñas estarán encriptadas en el sistema.
	- Generación de billete de reserva en formato PDF.
	- Uso de URL amigables.
	- Validaciones.
	- Se registrará la última IP desde la que se conectó el usuario, y se mostrará esa IP en el mensaje de bienvenida así como la fecha y hora de la última conexión.
