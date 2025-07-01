
function numerico(cadena){
  for(var i=1; i<=cadena.length ;i++){
    cadena=cadena.replace(/[a-zA-ZáéíóúàèìòùÀÈÌÒÙÁÉÍÓÚñÑüÜ]/i, "");
    cadena=cadena.replace(/[áéíóúàèìòùÀÈÌÒÙÁÉÍÓÚñÑüÜ]/i, "");
    cadena=cadena.replace(/[,;:_¿¡'?=)´(/&%$#"!|°¬)+*~^{`¨}]/i, "");
    cadena=cadena.replace("-","");
    cadena=cadena.replace("}","");
    cadena=cadena.replace("]","");
    cadena=cadena.replace("[",""); 

    cadena=cadena.replace(" ",""); 
  }      
  return cadena;
}

function entero(cadena){
  for(var i=1; i<=cadena.length ;i++){
    cadena=cadena.replace(/[a-zA-ZáéíóúàèìòùÀÈÌÒÙÁÉÍÓÚñÑüÜ]/i, "");
    cadena=cadena.replace(/[áéíóúàèìòùÀÈÌÒÙÁÉÍÓÚñÑüÜ]/i, "");
    cadena=cadena.replace(/[.,;:_¿¡'?=)´(/&%$#"!|°¬)+*~^{`¨}]/i, "");
    cadena=cadena.replace("-","");
    cadena=cadena.replace("}","");
    cadena=cadena.replace("]","");
    cadena=cadena.replace("[",""); 
    cadena=cadena.replace(" ","");
  }
      
  return cadena;
}

function entero_letras(cadena){
  for(var i=1; i<=cadena.length ;i++){
    cadena=cadena.replace(/[áéíóúàèìòùÀÈÌÒÙÁÉÍÓÚñÑüÜ]/i, "");
    cadena=cadena.replace(/[áéíóúàèìòùÀÈÌÒÙÁÉÍÓÚñÑüÜ]/i, "");
    cadena=cadena.replace(/[.,;:_¿¡'?=)´(/&%$#"!|°¬)+*~^{`¨}]/i, "");
    cadena=cadena.replace("-","");
    cadena=cadena.replace("}","");
    cadena=cadena.replace("]","");
    cadena=cadena.replace("[",""); 
    cadena=cadena.replace(" ","");
  }
      
  return cadena;
}


function clic_radio_si(){
  ocultar_mensajes_error();

  $("#RegistroMunicipio").hide();
  $("#registroClave").show();
  $("#valorDeRadion").val('1');
}

function clic_radio_no(){
  ocultar_mensajes_error();

  $("#valorDeRadion").val('2');
  $("#registroClave").hide();
  $("#RegistroMunicipio").show();
}

function ocultar_mensajes_error(){///se ocultan todos los elementos con clase errormsg, en lugar de elemento por elemento
  $(".errormsg").hide();
}

function limpiar_anticipo(){////se limpia el valor del anticipo para el caso de que hayan seleccionado una fecha, calculado y luego cambien de fecha 
  $("#supInicial").val('');
  $("#anticipo").val('');
}

function validarSuperficie_er(cadena){
  //se eliminan letras
  cadena=numerico(cadena);
  cadena=recortaDecimales(cadena);
  return cadena
}

function recortaDecimales(cadena){
    var cad=cadena;
    var pos=cadena.indexOf('.');
    if(pos!=-1){
        if(cadena=='.'){
            return '0.';
        }else{
            return cad.substring(0,pos)+cad.substring(pos,pos+4);    
        }
    }else {
        return cadena;
    }
}


function prueba_guardar(){  
  $("#loader").show();

  ////quitamos todos los mensajes de error al inicio
  $("#mensajeErrorNul").hide();
  $("#message").hide();
  $("#errorccat").hide();
  $("#mensajeErrorNul").hide(); 
  $("#mensaje_error_fecha_recepcion").hide();
  $("#message2").hide();
  $("#mensajeErrorSuperficie").hide();
  $("#mensajeErrorFupExistente").hide();  
  $("#mensajeErrorGuardar").hide();

  ///se procede normalmente a validar el guardado

  isok=validar_radio_clave_catastral();
  nombreSo=$("#nombreSo").val(); apaterno=$("#aPaterno").val(); amaterno=$("#aMaterno").val();
  fechaRecepcion=$("#fecha").val();
  nombreP=$("#nombreP").val(); aPaternoP=$("#aPaternoP").val(); aMaternoP=$("#aMaternoP").val();
  superficieIn=$("#supInicial").val();

  form=document.getElementById('validationForm');
  if(form.checkValidity()==false ){
    $("#mensajeErrorNul").show();
    ////aqui se valida qué campos tienen error
    //alert('revisar campos required');
    ///solicitante    
    if(nombreSo=="" || apaterno=="" || amaterno==""){
      $("#message").show();
    }
    ///con/sin clave catastral    
    if(!isok){
      $("#errorccat").show();
      $("#mensajeErrorNul").show(); 
    }

    ///fecha de recepcion    
    if(fechaRecepcion==""){
      $("#mensaje_error_fecha_recepcion").show();
    }

    ///propietario    
    if(nombreP==""||aPaternoP==""||aMaternoP==""){
      $("#message2").show();
    }

    ///superficie inicial    
    if(superficieIn==""){
      $("#mensajeErrorSuperficie").show();
    }


  }else{
    ///aunque el form esté correcto, se valida el apartado de la clave catastral
    if(isok){
      //se valida que la clave catastral sea única y no exista en la base de datos
      //###################################################################################################################################################
      //alert('guarda');
      var abrev = $("#delegacion").val();
      var anio = $("#ani").val();
      var fup = $("#fupAs").val();
      var fup_buscar= abrev+"-"+anio+fup; 
      var iddelegacion = $("#iddelegacion").val();
      //alert(fup_buscar);
      $.ajax({
        url:'acceso/route.php',
        data:{acceess:96,fup_buscar:fup_buscar, iddelegacion:iddelegacion},
        dataType:'json',
        type:'post',
        success:function(v){
          //alert(v);
          if(v==100){///el fup no existe, por lo tanto se guarda
            c_muni=$("#c_muni").val(); c_zona=$("#c_zona").val(); c_manz=$("#c_manz").val(); c_lote=$("#c_lote").val(); c_edif=$("#c_edif").val(); c_dept=$("#c_dept").val();
            solicitante = nombreSo;
            municipio = $("#c_muni2").val();
            if( municipio=="" ){
              municipio=$("#munn").find('option:selected').text();
            }

            anticipo=$("#anticipo").val();
            anticipo = anticipo.replace('$', '');
            anticipo = anticipo.replace(',', '');

            fupAs=fup_buscar;
            propietario=nombreP;
            aPaternoPropietario=aPaternoP;
            aMaternoPropietario=aMaternoP;            

            //alert(solicitante+apaterno+amaterno);
            $.ajax({
              url:'acceso/route.php',
              data:{acceess:97, c_muni:c_muni,c_zona:c_zona,c_manz:c_manz,c_lote:c_lote, c_edif:c_edif,c_dept:c_dept,solicitante:solicitante,apaterno:apaterno,amaterno:amaterno,municipio:municipio,fechaRecepcion:fechaRecepcion, superficieIn:superficieIn,anticipo:anticipo,abrev:abrev,iddelegacion:iddelegacion,fupAs:fupAs,propietario:propietario,aPaternoPropietario:aPaternoPropietario, aMaternoPropietario:aMaternoPropietario },
              //data:{acceess:97},
              dataType:'json',
              type:'post',
              //beforeSend:function(){alert('Llega aqui');},
              success:function(w){
                ///dependiendo del retorno se muestra mensaje de guardado y el fup, o mensaje de error
                if(w=='100'){///error
                  $("#mensajeErrorGuardar").show();
                }else{
                  $("#guardarRegistro").hide();
                  $("#agregarInformacion").hide();
                  $("#confirmacionGuardar").show();
                  $("#fupAsignado").val(w);  
                }
              }
            });

          }else{
            ////el fup ya existe
            $("#mensajeErrorFupExistente").show();            
          }
        }
      });

    }else{
      $("#errorccat").show();
      $("#mensajeErrorNul").show(); 
    }
  } 

  setTimeout(function () { $("#loader").hide(); }, 200); 

}

function validar_radio_clave_catastral(){
 ////se obtiene el valor del radio de la clave catastral
  isok=true;
  isthere_clavec=$("#valorDeRadion").val();

  //dependiendo la opcíon del radio, se verifica que los campos que se desprenden de este tengan valores
  if(isthere_clavec=='0'){
    isok=false;
    $("#error_radio").show();
    $("#mensajeErrorNul").show();    
  }else if(isthere_clavec=='1'){    
    mun=$("#c_muni").val();
    zona=$("#c_zona").val();
    manzana=$("#c_manz").val();
    lote=$("#c_lote").val();
    edificio=$("#c_edif").val();
    departamento=$("#c_dept").val();
    mun_txt=$("#c_muni2").val();
    //se verifica que todos tengan valores
    if(mun==""||zona==""||manzana==""||lote==""||edificio==""||departamento==""||mun_txt=="" ){
      isok=false;
    }

  }else if(isthere_clavec=='2'){
    munn=$("#munn").val();
    //debe haber valor en el select de los municipios    
    if(munn==""){
      isok=false;
    }
  }

  return isok;
}
