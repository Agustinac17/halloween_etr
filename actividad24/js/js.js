function votar(id)
{
    //pnom = $('#nom').val(); // algun valor del formulario
    //ppass = $('#pass').val(); // otro valor del formulario
    id = id_disfraz; //id del disfraz
    // Función que envía y recibe respuesta con AJAX
    $.ajax({
        type: 'POST',  
        url: 'modulos/guardar_voto.php',  
        data: { id: id_voto } 
    }).done(function( msg ) {  // Función que se ejecuta si todo ha ido bien
        // Escribimos en el div consola el mensaje devuelto
        alert(msg);
        $("#votarBoton"+id).hide();
    }).fail(function (jqXHR, textStatus, errorThrown){ // Función que se ejecuta si algo ha ido mal
        // Mostramos en consola el mensaje con el error que se ha producido
        $("#consola").html("Error: "+ textStatus +" "+ errorThrown); 
    });
}