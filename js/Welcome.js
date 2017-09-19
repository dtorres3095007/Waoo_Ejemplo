
$(document).ready(function() {

    obtener_datos();
    $( "#lista").keyup(function() {
dato = $("#lista").val().trim();
if (dato.trim().length!=0) {Validar_existe(dato)};

});
   
});

    
function obtener_datos() {
   
    $.ajax({
        url: "http://localhost/Waoo/index.php/Welcome_control/Listar",
        dataType: "json",
 
        type: "post",
    }).done(function(datos) {
      
      
     for (var i = 0; i <= datos.length - 1; i++) {
       
                $("#lista_tareas").append("<option  value='"+datos[i].nombre+"'>");

            }

             Validar_existe();
    });
}

function Validar_existe(dato){

    existe=0;
var numero = document.getElementById("lista_tareas").options.length
 for (var i = 0; i <= numero - 1; i++) {
    str  = document.getElementById("lista_tareas").options[i].value;
    str = str.toLowerCase();
     var n = str.indexOf(dato.toLowerCase());
   
if (n>-1) {
 $("#error").hide("slow")
existe=1;

return false;
}
}

   if (existe==0) {
   $("#error").show("slow")

   }
   return false;
   
}

