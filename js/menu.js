$(document).ready(function()
    {
        // Almacenamos la URL que aparece en el navegador.
        var url=window.location.href;
   
        // Si tenemos url's absolutas en el menú...
        //$("#nav a[href='"+url+"']").addClass("active");
    
        // Para el caso de URL's relativas o absolutas en el menú, usaremos ésta forma:
        $('ul#nav a').filter(function()
        {
            return this.href== url; 
        }).addClass("active");
    
        // Para las url adicionales que no estén en el menú principal.
        if (url.indexOf("subirfoto.html") != -1)
            $("ul#nav a[href='editarusuario.html']").addClass('active');

    });  // document.ready