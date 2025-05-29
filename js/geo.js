function validarSuperficie_er1(cadena){
  //se eliminan letras
  cadena=numerico1(cadena);
  cadena=recortaDecimales1(cadena);
  return cadena
}

function numerico1(cadena){
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

function recortaDecimales1(cadena){
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


function div_carga(op){
	if(op==1){
		$("#div_carga").load('geo_lt_salida.php');
	}else if(op==2){
		$("#div_carga").load('geo_lt_entrega.php');
	}else if(op==3){
		$("#div_carga").load('lt_concluidos.php');
	}else if(op==4){
		$("#div_carga").load('lt_reportes.php');
	}		
}

function carga_info_salida(){
	var fup=$("#fup").val();
	$("#info_salida").load('geo_lt_salida_tbl.php?fup='+fup);
}

function guardar_equipo_salida(usuario_envio){
	var fup=$("#fup").val();

	var equipo=$("#equipo").val();
	var especialista=$("#especialista").val();
	//alert( $("#no_inventario").val() );
	var form=document.getElementById('form_geo_salida');
	if(form.checkValidity()==false || equipo=='0' || especialista=='0'){///hay errores
		///se validan los select de equipo y especialista
		if(equipo=='0'){
			$("#equipo").css( {"border": "1px solid red "} );
		}
		if(especialista=='0'){
			$("#especialista").css( {"border": "1px solid red "} );
		}

		///se muestra el modal al final
		$("#div_css").html('<style type="text/css"> input:invalid {   border: 2px solid red;  }</style>');////se agrega el css para marcar invalidos los campos

		$("#titulo_modal_ad").html('Registros faltantes');
		$("#mensaje_modal_ad").html('Para continuar es necesario llenar todos los campos');
		$("#modal_mensaje_ad").modal('show');
	}else{
		///se deshabilita el bot´n de guardar para evitar guardados extraños o dobles clics
		$("#btn_guardar").attr("disabled",true);
		
		$("#div_css").html('');
		$.ajax({
            url:'Ops2.php?action=guardar_equipo_salida&fup='+fup,
            type:'post',
            data:$("#form_geo_salida").serialize(),
            dataType:'json',
            // beforeSend:function(){$("#loader").modal('show');},
            // complete:function(){$("#loader").modal('hide');},
            success:function(a){
            	if(a){



            		///se realiza envío de correo
				    correo_destino='erick.garcia.rdz@hotmail.com'; //alert(correo_destino);
				    asunto='Aviso de salida de equipo'; 
				    tipo='Salida';
				    $.ajax({
				    	url:'Ops2.php?action=guardar_datos_correo',
				    	data:{correo_destino:correo_destino, usuario_envio:usuario_envio, asunto:asunto, fup:fup, tipo:tipo },
				    	dataType:'json',
				    	type:'post',				    	
				    	success:function(v){
				    		//alert(v);
				    		if(v==true){
				    			////se manda el correo
				    			$.ajax({
				    				url:'Ops2.php?action=enviar_correo',
				    				data:{fup:fup, usuario:usuario_envio, tipo:'Salida', correo_destino:correo_destino },
				    				dataType:'json',
				    				type:'post',
				    				success:function(w){
				    					//alert(w);
				    					if(w==true){
				    						//alert('Correo enviado a'+correo_destino);
				    						$("#titulo_modal_ok").html('Registro correcto');
											$("#mensaje_modal_ok").html('Información guardada correctamente');
											$("#modal_mensaje_ok").modal('show');

											////recargamos el select de los folios
						            		$("#div_carga").load('geo_lt_salida.php');
				    					}else{
				    						alert('Fallo en el envío del correo');
				    					}
				    				}
				    			});

				    		}else{
				    			alert('Error al guardar información del correo en la BD');
				    		}
				    	}
				    });




     				//$("#titulo_modal_ok").html('Registro correcto');
					// $("#mensaje_modal_ok").html('Información guardada correctamente');
					// $("#modal_mensaje_ok").modal('show');

					// ////recargamos el select de los folios
     				//$("#div_carga").load('geo_lt_salida.php');

            	}else{
            		$("#titulo_modal_ad").html('ERROR');
					$("#mensaje_modal_ad").html('Error en guardado');
					$("#modal_mensaje_ad").modal('show');
            	}
            }
  		});	

	}
}



function carga_info_entrega(){
	var fup=$("#fup").val();
	$("#info_entrega").load('geo_lt_entrega_tbl.php?fup='+fup);
}

function guardar_equipo_entrega(){	
	var fup=$("#fup").val();
	var form=document.getElementById('form_geo_entrega');
	if(form.checkValidity()==false ){///hay errores

		$("#titulo_modal_ad").html('Registros faltantes');
		$("#mensaje_modal_ad").html('Para continuar es necesario llenar todos los campos');
		$("#modal_mensaje_ad").modal('show');

		//alert('Faltan campos');
		$("#div_css").html('<style type="text/css"> input:invalid {   border: 2px solid red;  }</style>');
	}else{////GUARDADO
		$("#div_css").html('');
		///aqui validamos los campos
		iscrudo=document.getElementById('iscrudo').checked;///valores de true and false
		if(iscrudo){////hayarchivos

			$.ajax({
	            url:'Ops2.php?action=guardar_equipo_entrega&fup='+fup+'&iscrudo='+iscrudo,
	            type:'post',
	            data:$("#form_geo_entrega").serialize(),
	            dataType:'json',
	            success:function(a){
	            	////si es correcto, se procede a guardar las imágenes
	            	inputFile = document.getElementById("archivo_crudo");
		    		totalFiles=inputFile.files.length;

		    		for(var i=0;i<totalFiles;i++){
				    	////se repite el proceso de guardado de acuerdo al numero de archivos seleccionados
				    	file= inputFile.files[i];
					    data = new FormData();
					    data.append('archivo_crudo', file);

					    $.ajax({
					    	url:'Ops2.php?action=guardar_archivo_crudo&fup='+fup,
					    	data:data,
					    	type:'post',
					    	dataType:'json',
				            contentType:false,
				            processData:false,
				            cache:false,
					    	success:function(c){
					    		//alert(c);
					    		if(c==true){
					    			$("#titulo_modal_ok").html('Registro correcto');
									$("#mensaje_modal_ok").html('Levantamiento concluido correctamente');
									$("#modal_mensaje_ok").modal('show');

									div_carga(2);////recarga la seccion de eleccion de fup 1-SALIDA //// 2-ENTREGA
					    		}						    		
					    	}
					    });
				    }
	            }
	        });				    
			    

		}else{//alert('no hay archivos');
			
			$.ajax({
	            url:'Ops2.php?action=guardar_equipo_entrega&fup='+fup+'&iscrudo='+iscrudo,
	            type:'post',
	            data:$("#form_geo_entrega").serialize(),
	            dataType:'json',
	            success:function(a){
	            	//alert(a);
	            	if(a==true){
	            		$("#titulo_modal_ok").html('Registro correcto');
						$("#mensaje_modal_ok").html('Levantamiento concluido correctamente');
						$("#modal_mensaje_ok").modal('show');

						div_carga(2);////recarga la seccion de eleccion de fup 1-SALIDA //// 2-ENTREGA
	            	}
	            	else{

	            	}
	            }
	        });
		}			
	}
}

function verificar_crudo(){
	///primero limpiamos el input, por si ya se había seleccionado algo
	$("#archivo_crudo").val('');

	var iscrudo=document.getElementById('iscrudo').checked;///valores de true and false
	if(iscrudo){///se abre el apartado para subir archivos
		$("#archivo_crudo").show();
		$("#archivo_crudo").attr("required", true);
	}else{
		$("#archivo_crudo").hide();
		$("#archivo_crudo").attr("required", false);
	}
}