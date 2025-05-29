

function listado(){

var id_us = $("#id_us").val();
var tablaCompleta = "";
 
  $.post("../theme/acceso/route.php",{ acceess:83,id_us:id_us},function(zm){
    console.log(zm);

   if (zm == "100" || zm == 100) {
      //Sin registros
   }else{
      //Con registros
     /* tablaCompleta = '<thead>'
                       +' <tr>'
                            +'<th>FUP</th>'
                            +'<th>Clave catastral</th>'
                            +'<th>Municipio</th>'
                            +'<th>Solicitante</th>'
                            +'<th>Fecha Recepcion</th>'
                            +'<th>Superficie</th>'
                            +'<th>Anticipo</th>'
                            +'<th colspan="4">Procesos concluidos</th>'
                        +'</tr>'
                    +'</thead>'
                    +'<tbody>';*/

      $(zm).each(function(key,valuee){

        tablaCompleta += '<tr>'
                +'<td>'+valuee.fup+'</td>'
                +'<td>'+valuee.clavec+'</td>'
                +'<td>'+valuee.municipio+'</td>'
                +'<td>'+valuee.solicitante+'</td>'
                +'<td>'+valuee.fecha_recepcion+'</td>'
                +'<td>'+valuee.superficieinicial+'</td>'
                +'<td>'+valuee.anticipo+'</td>'
                +'<td>'+valuee.proceso+'</td>'
                +'<td>'+valuee.proceso+'</td>'
                +'<td>'+valuee.proceso+'</td>'
                +'<td>'+valuee.proceso+'</td>'
            +'</tr>'; 
      });

    /*  tablaCompleta += '</tbody>'
                        +'<tfoot>'
                           +'<tr>'
                            +'<th>FUP</th>'
                            +'<th>Clave catastral</th>'
                            +'<th>Municipio</th>'
                            +'<th>Solicitante</th>'
                            +'<th>Fecha Recepcion</th>'
                            +'<th>Superficie</th>'
                            +'<th>Anticipo</th>'
                            +'<th colspan="4">Procesos concluidos</th>'
                          +'</tr>'
                        +' </tfoot>'; */

   }
        console.log(tablaCompleta); 
       $("#info_del").append(tablaCompleta); 

    });


}