function cerrarSession(){
      
    $.post("acceso/route.php",{acceess:99},function(yz){
    	//document.getElementById('id01').style.display='none';  
    	location.href=yz;
    });
}

function municip(){
	var municip =$("#c_muni").val();
	$.post("acceso/route.php",{acceess:98,municip:municip},function(yz){
		if (yz == "N/A" || yz == 'N/A') {
			///mostrar mensaje de error en municipio
			$("#errormuni").show();
			document.getElementById("c_muni").style.borderColor="#e12454";
		}else{
			$("#errormuni").hide();
			document.getElementById("c_muni").style.borderColor="#223a66";
		}
       $("#c_muni2").val(yz);   
    });
}

function contarLim(tip){
	//length 
	var dato = "";
	var totalDato = "";

	if (tip == 1) { //zona dos digitos
	 dato = $('#c_zona').val();
	 totalDato = dato.length;

	 if (totalDato != 2) {
	 	//Hace falta registrar bien 
	 	$("#errormuni2").show();
		document.getElementById("c_zona").style.borderColor="#e12454";
	 }else if (totalDato == 2) {
	 	$("#errormuni2").hide();
		document.getElementById("c_zona").style.borderColor="#223a66";
	 }

	}else if(tip == 2){ //manzana 3 digitos
		dato = $('#c_manz').val();
	 	totalDato = dato.length;
	 	if (totalDato != 3) {
	 		$("#errormuni3").show();
			document.getElementById("c_manz").style.borderColor="#e12454";

	 	}else if(totalDato == 3){
	 		$("#errormuni3").hide();
			document.getElementById("c_manz").style.borderColor="#223a66";
	 	}

	}else if(tip == 3){ // Lote 2 digitos
		dato = $('#c_lote').val();
	 	totalDato = dato.length;

	 	if (totalDato != 2) {
	 		$("#errormuni4").show();
			document.getElementById("c_lote").style.borderColor="#e12454";

	 	}else if(totalDato == 2){
	 		$("#errormuni4").hide();
			document.getElementById("c_lote").style.borderColor="#223a66";
	 	}

	}else if(tip == 4){ // Edificio 2 digitos
		dato = $('#c_edif').val();
	 	totalDato = dato.length;

	 	if (totalDato != 2) {
	 		$("#errormuni5").show();
			document.getElementById("c_edif").style.borderColor="#e12454";

	 	}else if(totalDato == 2){
	 		$("#errormuni5").hide();
			document.getElementById("c_edif").style.borderColor="#223a66";
	 	}

	}else if(tip == 5){ // Departamento 4 digitos
		dato = $('#c_dept').val();
	 	totalDato = dato.length;

	 	if (totalDato != 4) {
	 		$("#errormuni6").show();
			document.getElementById("c_dept").style.borderColor="#e12454";

	 	}else if(totalDato == 4){
	 		$("#errormuni6").hide();
			document.getElementById("c_dept").style.borderColor="#223a66";
	 	}
	}
}

function CalcularAnticipo(){/////se usa en la primera parte, cuando el usuario captura un registro
	var supInicial ="";
	var superficie =0;
	var factorAplicable=0;
	var factorAplicable2=0;
	var cuotaFija=0;
	var cuotaFija2=0;
	var totalDeAnticipo=0;
	var totalDeAnticipo2=0;

	///se obtiene la fecha de recepcion para saber que valores usar, si 2023 o 2024
	var anio_tarifa=0;
	var fecha_recepcion=$("#fecha").val();
	if(fecha_recepcion==""){
		alert('Elija fecha de recepción primero');
		///se elimina el valor ingresado
		$("#supInicial").val('');
	}else{
		//alert(fecha_recepcion);
		//////comparamos las fechas para saber la tarifa por año a seleccionar
		//var fecha_compara=new Date('2024-03-19');///hasta el 18 de marzo se va trabajar ocn la tarifa del 2023
		var fecha_compara=new Date('2025-03-26');///hasta el 25 de marzo se va trabajar ocn la tarifa del 2024
		var fecha_recepcion_date=new Date(fecha_recepcion);
		if(fecha_compara<=fecha_recepcion_date){
			//alert('Se trabaja con tarifa del 2024');
			anio_tarifa=2025;
		}else{
			//alert('se ocupan valores del 2023');
			anio_tarifa=2024;
		}


		supInicial =$("#supInicial").val();
		if(supInicial!="" && supInicial!='0'){
			$.post("acceso/route.php",{acceess:78,supInicial:supInicial,anio_tarifa:anio_tarifa},function(yz){

				$(yz).each(function(key,valuee){
		    		superficie=supInicial - valuee.limiteinferior;
		    		factorAplicable=superficie * valuee.factoraplicable;
		    		cuotaFija = parseFloat(valuee.cuotafija);
		    		factorAplicable2=parseFloat(factorAplicable);
		    		cuotaFija2 = factorAplicable2 + cuotaFija;

		    	});
				totalDeAnticipo=Math.round(cuotaFija2)
				totalDeAnticipo2= totalDeAnticipo.toLocaleString("en-US", {
			        style: "currency",
			        currency: "USD"
			    });
					$("#anticipo").val(totalDeAnticipo2);
				    
		    });
		}else{
			$("#anticipo").val("");
		}


	}
				
}

function ingresarFup(){
	$("#btn-ingresaFup").hide();
	$("#ingresaFup").show();
}

function newRegistro(){
	$("#newRegistro").hide();
	$("#agregarInformacion").show();
}

function guardarRegistro(){	
	var sn = $("#valorDeRadion").val();///cuenta con clave catastral
	var municipio = "";
	var c_muni = "";
  	var c_zona = "";
  	var c_manz = "";
  	var c_lote = "";
  	var c_edif = "";
  	var c_dept = "";
  	var ban2 = 0;

	if (sn == 1) { //registro con clave catastral
		//Clave catastral
		c_muni = $("#c_muni").val();
  		c_zona = $("#c_zona").val();
  		c_manz = $("#c_manz").val();
  		c_lote = $("#c_lote").val();
  		c_edif = $("#c_edif").val();
  		c_dept = $("#c_dept").val();

  		municipio = $("#c_muni2").val();

  		//validar que esten registrados todos los elementos de la clave catastral

  		if (c_muni ==null || c_muni == '') {
			$("#mensajeErrorNul").show(); 
			document.getElementById("c_muni").style.borderColor="#e12454";
			ban2 = 1;
		}else{
			document.getElementById("c_muni").style.borderColor="#223a66";
		}

	 	if (c_zona == null || c_zona =='') {
			$("#mensajeErrorNul").show();
			document.getElementById("c_zona").style.borderColor="#e12454";
			ban2 = 1;
		}else{
			document.getElementById("c_zona").style.borderColor="#223a66";
		}


	 	if (c_manz == null || c_manz =='') {
			$("#mensajeErrorNul").show();
			document.getElementById("c_manz").style.borderColor="#e12454";
			ban2 = 1;
		}else{
			document.getElementById("c_manz").style.borderColor="#223a66";
		}


	 	if (c_lote == null || c_lote =='') {
			$("#mensajeErrorNul").show();
			document.getElementById("c_lote").style.borderColor="#e12454";
			ban2 = 1;
		}else{

			document.getElementById("c_lote").style.borderColor="#223a66";
		}


	 	if (c_edif == null || c_edif =='') {
			$("#mensajeErrorNul").show();
			document.getElementById("c_edif").style.borderColor="#e12454";
			ban2 = 1;
		}else{

			document.getElementById("c_edif").style.borderColor="#223a66";
		}

	 	if (c_dept == null || c_dept =='') {
			$("#mensajeErrorNul").show();
			document.getElementById("c_dept").style.borderColor="#e12454";
			ban2 = 1;
		}else{

			document.getElementById("c_dept").style.borderColor="#223a66";
		}

		if (municipio == null || municipio =='' ||  municipio =='N/A') {
			$("#mensajeErrorNul").show();
			//document.getElementById("municipio").style.borderColor="#e12454";
			ban2 = 1;
		}


	}else if(sn == 2){ // solo registrar municipio , clave catastral no

		c_muni = "0";
  		c_zona = "0";
  		c_manz = "0";
  		c_lote = "0";
  		c_edif = "0";
  		c_dept = "0";

		//var numic =$("#munn").val();
		municipio=$("#munn").find('option:selected').text();

		if (municipio == null || municipio =='' ||  municipio =='N/A') {
			$("#mensajeErrorNul").show();
			//document.getElementById("municipio").style.borderColor="#e12454";
			ban2 = 1;
		}

	}else{//no selecciono el radio button		
		$("#mensajeErrorNul").show();
		ban2=1; 
	}

	///obtener datos capturados
	var solicitante = $("#nombreSo").val();
	var apaterno = $("#aPaterno").val();
	var amaterno = $("#aMaterno").val();

	// solicitante2 = validaLetras();
	// apaterno2 = validaLetras2();
	// amaterno2 = validaLetras3();
	solicitante2 =true;
	apaterno2 =true;
	amaterno2 =true;

	var fechaRecepcion = $("#fecha").val();
	var superficieIn = $("#supInicial").val();
	var superficieIn2 = validarSuperficie();

	var abrev = $("#delegacion").val();
	var iddelegacion = $("#iddelegacion").val();

	var propietario = $("#nombreP").val();
	var aPaternoPropietario = $("#aPaternoP").val();
	var aMaternoPropietario = $("#aMaternoP").val();

	// propietario2 = validaLetrasPr();
	// aPaternoPropietario2 = validaLetrasPr2();
	// aMaternoPropietario2 = validaLetrasPr3();
	propietario2 = true;
	aPaternoPropietario2 = true;
	aMaternoPropietario2 = true;

	var abrev = $("#delegacion").val();
	var anioAct = $("#anioAct").val();
	var anio = $("#ani").val();
	var fo = abrev+"-"+anio; 

	var fup = $("#fupAs").val();
	var fupAs = "";
	var ban = 0;
	var fup_buscar = fupAs = fo+fup; 

	//validar cada variable.
	var anticipo3 = $("#anticipo").val();
	var anticipo2= "";
	var anticipo = "";
	
	if (anticipo3 == "$NaN" || anticipo3 == null || anticipo3 == "") {
		$("#mensajeErrorNul").show();
		document.getElementById("anticipo").style.borderColor="#e12454";
		ban = 1;
		
	}else{
		anticipo2 = anticipo3.replace('$', '');
  		anticipo = anticipo2.replace(',', '');
  		//$("#mensajeErrorNul").hidden();
		document.getElementById("anticipo").style.borderColor="#223a66";
	}

	if (fup == null || fup == '') {
		$("#mensajeErrorNul").show(); 
		document.getElementById("fupAs").style.borderColor="#e12454";
		ban = 1;
	}else{
		//ver si ya existe un registro del fup
		document.getElementById("fupAs").style.borderColor="#223a66";
	}

	if (anio == null || anio == '') {
		ban = 1;
	}else{
	
	}

	if (fechaRecepcion == null || fechaRecepcion =='' || fechaRecepcion =="") {
		$("#mensajeErrorNul").show();
		//document.getElementById("fechaRecepcion").style.borderColor="#e12454";                
		ban = 1;
	}

	if (superficieIn == null || superficieIn =='' || !superficieIn2) {
		$("#mensajeErrorNul").show();
		document.getElementById("supInicial").style.borderColor="#e12454";
		ban = 1;
	}else{
		document.getElementById("supInicial").style.borderColor="#223a66";
	}

	if(solicitante == null || solicitante == '' || !solicitante2){
		$("#mensajeErrorNul").show();
		document.getElementById("nombreSo").style.borderColor="#e12454";
		ban = 1;		
	}else{
		document.getElementById("nombreSo").style.borderColor="#223a66";
	}

	if(apaterno == null || apaterno == '' || !apaterno2){
		$("#mensajeErrorNul").show();
		document.getElementById("aPaterno").style.borderColor="#e12454";
		ban = 1;
	}else{
		document.getElementById("aPaterno").style.borderColor="#223a66";
	}

	if(amaterno == null || amaterno == '' || !amaterno2){ 
		$("#mensajeErrorNul").show();
		document.getElementById("aMaterno").style.borderColor="#e12454";
		ban = 1;
	}else{
		document.getElementById("aMaterno").style.borderColor="#223a66";
	}


	if(propietario == null || propietario == '' || !propietario2){ 
		$("#mensajeErrorNul").show();
		document.getElementById("nombreP").style.borderColor="#e12454";
		ban = 1;
	}else{
		document.getElementById("nombreP").style.borderColor="#223a66";
	}

  	if(aPaternoPropietario == null || aPaternoPropietario == '' || !aPaternoPropietario2){ 
		$("#mensajeErrorNul").show();
		document.getElementById("aPaternoP").style.borderColor="#e12454";
		ban = 1;
	}else{
		document.getElementById("aPaternoP").style.borderColor="#223a66";
	}
   

    if(aMaternoPropietario == null || aMaternoPropietario == '' || !aMaternoPropietario2){ 
		$("#mensajeErrorNul").show();
		document.getElementById("aMaternoP").style.borderColor="#e12454";
		ban = 1;
	}else{
		document.getElementById("aMaternoP").style.borderColor="#223a66";
	}  


	if (ban == 1 || ban2 == 1) {//adquiere el valor 1 cuando hay error en los campos
		//faltan registros
	}else{
		$.post("acceso/route.php",{acceess:96,fup_buscar:fup_buscar,iddelegacion:iddelegacion},function(yz){
	    	console.log(yz); 
	    	if (yz == 100 || yz == "100") {
	    		//sin registro
    			document.getElementById("fupAs").style.borderColor="#223a66"; 
    			//guardar en base de datos  
				$.post("acceso/route.php",{acceess:97,c_muni:c_muni,c_zona:c_zona,c_manz:c_manz,c_lote:c_lote,
				 	c_edif:c_edif,c_dept:c_dept,solicitante:solicitante,apaterno:apaterno,amaterno:amaterno,municipio:municipio,fechaRecepcion:fechaRecepcion,
				 	superficieIn:superficieIn,anticipo:anticipo,abrev:abrev,iddelegacion:iddelegacion,fupAs:fupAs,propietario:propietario,aPaternoPropietario:aPaternoPropietario,
				 	aMaternoPropietario:aMaternoPropietario
				},function(yz){		    	
		      		 console.log(yz); 
		      		$("#guardarRegistro").hide();
					$("#agregarInformacion").hide();
					$("#confirmacionGuardar").show();
					//devolver FUP (ABREVIATURA - ANIO(ULTIMOS DOS DIGITOS) Y 4 DIGITOS)
		      		$("#fupAsignado").val(yz);      
		    	});

			}else{
	    		//con registro
	    		$("#mensajeErrorFupExistente").show();
	    		$("#mensajeErrorNul").hide();  
			    document.getElementById("fupAs").style.borderColor="#e12454";			    
	    	}	      
	    });		
	}
}

function validaNumericos(event) {
    if(event.charCode >= 48 && event.charCode <= 57){

      return true;
     }
     return false;
}

function validaNumLet(event) {
    if(event.charCode >= 48 && event.charCode <= 122){
      return true;
     }
     return false;
}

function solonumeros(event) {
 
    if(event.charCode >= 48 && event.charCode <= 57 || event.charCode == 46 || event.charCode == 8){ //46,8 punto , 118 coma 188

      return true;
     }
     return false;
}

function validarSuperficie2() {

 	 let isValid = false;
      const input = document.forms['superficieResult2']['superficieResultante'];
      const message = document.getElementById('mensajeErrorSuperficie2');
      input.willValidate = false;
      const pattern = new RegExp('^[1-9]+[0-9]+([.][0-9]+)?$');
      if(!input.value) {
        isValid = false;
      } else {
          if(!pattern.test(input.value)){ 
            isValid = false;
          } else {
            isValid = true;
          }
        }

         if(!isValid) {
        message.hidden = false;
        $("#mensajeErrorSuperficie2").show(); 

      } else {
        message.hidden = true;
         $("#mensajeErrorSuperficie2").hide();
         document.getElementById("superficieResultante").style.borderColor="#223a66";
      }
      return isValid;
}

function ok(){
	location.href='delegaciones.php';
}

function modal_cancelar_lt(proceso){
	$("#procc").val(proceso);
	$("#cancelar_lt").modal('show');
}

function cancelar_lt(){
	proceso=$("#procc").val();
	fecha=$("#fecha_cancel").val();
	fup=$("#fup").val();
	if(fecha==""){
		$("#titulo_modal_ad").html('Registro faltante');
		$("#mensaje_modal_ad").html('Para continuar es necesario seleccionar la fecha de cancelación');
		$("#modal_mensaje_ad").modal('show');
	}else{
		///guaarda la fecha de cancelación y el proceso en que se cancela
		//alert('aqui cancela');
		$.post("acceso/route.php",{acceess:77,fechaCancelacion:fecha,proces:proceso,fup:fup},function(yz){
			if (yz==100) {
				$("#cancelar_lt").modal('hide');//ocultamos el modal de cancelacion

				//$(".proceso_n").hide();///primero ocultamos todo
				//$("#procesoCero").show();///y mostramos el modal de cancelado
				$("#control_proceso").load('proceso.php?proceso=11111');

				////mostramos modal de cancelacion cerrecta
				$("#titulo_modal_ok").html('Cancelación correcta');
				$("#mensaje_modal_ok").html('Levantamiento cancelado exitosamente');
				$("#modal_mensaje_ok").modal('show');
			}
		});

	}
}

function buscaRegistro_enter(){
	$("#fup").keypress(function(e) {
	  if(e.which == 13) {
	    buscaRegistro();
	  }
	});
}

function buscaRegistro(){
	var fup_buscar = $("#fup").val(); 
	var iddelegacion = $("#iddelegacion").val();

	//alert(iddelegacion);
	$.ajax({
		url:'acceso/route.php',
		data:{acceess:96,fup_buscar:fup_buscar,iddelegacion:iddelegacion},///se obtiene la información del folio, se obtiene 100 si no existe
		dataType:'json',
		type:'post',
		success:function(yz){
			if ( yz == 100) {////no existe registro
				
				$("#fupNoRegistrado").show();////mensaje de fup sin informacion
				$(".proceso_n").hide();
				$("#registroEncontrado").hide();////mensaje de registro con informacion, solo tiene la clave catastral		

			}else{ ////hay registro

				$("#fupNoRegistrado").hide();////mensaje de fup sin informacion
				$("#buscaRegistro").hide();///boton de busqueda, que va hasta el final
				$("#proceso_n").hide();	     		
	      		$("#seguirBusqueda").show();///es la lupa     		
				/////en lugar de tantas variables se manejaran estas que se guardan en modals.php ERICK
				$("#fol").val(yz.id);

				///////////////////NUEVO//////////////////
				//validamos si está cancelado 
				if( yz.cancelado!=0  ){
					$("#registroEncontrado").hide();
					$("#control_proceso").load('proceso.php?proceso=11111');///cargamos proceso.php, y este decide que proceso mostrar de acuerdo al proceso
				}else{
					
					$("#registroEncontrado").show();///estos solo contiene la clave catastral	 
					$("#clavec").val(yz.clavec);///dentro de registro encontrado

					$("#control_proceso").load('proceso.php?proceso='+yz.proceso);///cargamos proceso.php, y este decide que proceso mostrar de acuerdo al proceso
				}				
			}
		}
	});	
}

function fechaEnviop(){////revisar, porque muchos campos no se usan
	var seleccion = document.getElementById("fechaDeEnvio").value;

	if (seleccion == 1 || seleccion == "1") {///ingresar fecha
		$("#fechaEnvio").show();
		$("#oc").show();
		$("#areaProduc").show();
		$("#fechaNotificacion").show();
		$("#fechaLevantamiento").show();
		$("#folioGEO").show();
		$("#fechaSerTerminado").show();
		$("#superficie").show();
		$("#fechaNotificacion2").hide();
		$("#fechaLevantamiento2").hide(); 
		$("#fechaSerTerminado2").hide();  
		$("#fechaSerTerminado3").hide();
		$("#actualizarDos").show();
		$("#terminoProcDos").show();

	}else if(seleccion == 2 || seleccion == "2"){///proceso
		$("#oc").hide();
		$("#areaProduc").hide();
		$("#fechaNotificacion").hide();
		$("#fechaNotificacion2").hide();
		$("#fechaLevantamiento").hide();
		$("#fechaLevantamiento2").hide();
		$("#folioGEO").hide();
		$("#fechaSerTerminado").hide();
		$("#fechaSerTerminado2").hide();  
		$("#fechaSerTerminado3").hide();
		$("#superficie").hide();
		$("#fechaEnvio").hide();
		$("#actualizarDos").show();
		$("#terminoProcDos").hide();

	}else if(seleccion == 3 || seleccion == "3"){//cancelado
		$("#oc").hide();
		$("#areaProduc").hide();
		$("#fechaNotificacion").hide();
		$("#fechaNotificacion2").hide();
		$("#fechaLevantamiento").hide();
		$("#fechaLevantamiento2").hide();
		$("#folioGEO").hide();
		$("#fechaSerTerminado").hide();
		$("#fechaSerTerminado2").hide();  
		$("#fechaSerTerminado3").hide();
		$("#superficie").hide(); 
		$("#fechaEnvio").hide();
		$("#actualizarDos").hide();
		$("#terminoProcDos").show();

	}//else{$("#fechaEnvio").hide();}
}

function fechaTermino(){
	var seleccionT = document.getElementById("fechaSerTerminado").value;

	if (seleccionT == 1 || seleccionT == "1") {
		$("#fechaSerTerminado2").show();
		$("#superficie").show();
		$("#actualizarDos").show();
		$("#terminoProcDos").show();

	}else if(seleccionT == 2 || seleccionT == "2"){
		$("#fechaSerTerminado2").hide();
		$("#superficie").hide();
		$("#actualizarDos").show();
		$("#terminoProcDos").hide();

	}else if(seleccionT == 3 || seleccionT == "3"){
		$("#superficie").hide();
		$("#fechaSerTerminado2").hide();
		$("#actualizarDos").hide();
		$("#terminoProcDos").show();
	}
}

function mostrarInfo(){
	var folioRegistro = $("#fol").val();

	$.post("acceso/route.php",{acceess:94,folioRegistro:folioRegistro},function(yz){

 		if (yz != 100 || yz != "100"  ) {
 			$(yz).each(function(key,valuee){

 				//alert(valuee.fechaenvio);

 				$("#ordentrabajo").val(valuee.ordentrabajo);		

 				if(valuee.estatusfecha==1 && valuee.fechaenvio!=""){///se verifica que sea la opcion de seleccionar fecha y que hya valor en el date
 					$("#fechaDeEnvio").val( valuee.estatusfecha );
 					$("#fechaEnvio").val( moment(valuee.fechaenvio).format('YYYY-MM-DD') );
 					$("#fechaEnvio").show();
 				}

 				if(valuee.areaproduc!=""){
 					$("#areaProduc").val(valuee.areaproduc);
 				}	 
			});
 		}
 	});
}

function actualizarProceso(){
	var folioRegistro = $("#idRegistro").val();
	var ordenTrabajo = $("#ordentrabajo").val(); //
	var ordenTrabajo2 = "";
	var estatusfechaEnvio = $("#fechaDeEnvio").val();//
	var fechaEnvio = $("#fechaEnvio").val();//
	var areaProductora = $("#areaProduc").val();//
	var inicioFolio = "";
	/*
	var fechaNotificacion = $("#fechaNotificacion").val();
	var fechaLevantamiento = $("#fechaLevantamiento").val();
	var folioGeo = $("#folioGEO").val();
	var estatusFechaTermino = $("#fechaSerTerminado").val();
	var fechaTermino = $("#fechaSerTerminado2").val(); 
	var superficie = $("#superficie").val(); */
	if (ordenTrabajo == null || ordenTrabajo == "") {
		ordenTrabajo = $("#ordentrabajo").val();

	}else{
		ordenTrabajo2 = $("#ordentrabajo").val();
		inicioFolio = $("#inicioFolio").val();
		ordenTrabajo = inicioFolio+ordenTrabajo2;
	}

	///////////////////////////////////////////////////////////////////////////////////////////////////

	if (estatusfechaEnvio == "2" ||  estatusfechaEnvio == 2 || estatusfechaEnvio == "" || estatusfechaEnvio == null){
		fechaEnvio=0;   

	}else if (estatusfechaEnvio == "3" || estatusfechaEnvio == 3) {
		//Bloquea todos los demas campos y termina el registro

	}else if(estatusfechaEnvio == "1" && fechaEnvio == "" || estatusfechaEnvio == 1 && fechaEnvio == null ){
		fechaEnvio=0;  
	}

	/*
	if (estatusFechaTermino == "2" || estatusFechaTermino == 2 || estatusFechaTermino == "" || estatusFechaTermino == null){
		fechaTermino=0;    
		
	}else if(estatusFechaTermino == "3" || estatusFechaTermino == 3){
		//Bloquea todos los demas campos y termina el registro

	}

	if (fechaNotificacion == "" || fechaNotificacion == null) {
		fechaNotificacion=0;  
	}

	if (fechaLevantamiento == "" || fechaLevantamiento == null) {
		fechaLevantamiento=0    ; 
	}*/		

	$.post("acceso/route.php",{acceess:94,folioRegistro:folioRegistro},function(yz){  
		console.log(yz); 
		if (yz == "100") {
			//sin registro
			$.post("acceso/route.php",{acceess:95,folioRegistro:folioRegistro,ordenTrabajo:ordenTrabajo,estatusfechaEnvio:estatusfechaEnvio,
		 	fechaEnvio:fechaEnvio,areaProductora:areaProductora},function(yz){
		 		//fechaNotificacion:fechaNotificacion,fechaLevantamiento:fechaLevantamiento,folioGeo:folioGeo,estatusFechaTermino:estatusFechaTermino,fechaTermino:fechaTermino,superficie:superficie
		 		console.log(yz);

		 		if (yz == "1" || yz == 1) {
		 			//cerrar modal de registro
		 			$("#myModal2").hide();
		 			//Abrir modal de registro guardado
		 			$("#registroBien").show();
		 		}else{
		 		//error
		 		}
		 	});
		}else{
			//con registro

			/*var fechaNotificacion2 = $("#fechaNotificacion2").val();
			var fechaLevantamiento2 = $("#fechaLevantamiento2").val();

			if (fechaNotificacion == null || fechaNotificacion == 0) {
				fechaNotificacion = fechaNotificacion2
			} 

			if (fechaLevantamiento == null || fechaLevantamiento == 0) {
				fechaLevantamiento = fechaLevantamiento2;
			}
				
			var fechaEnvio2 = $("#fechaEnvio2").val();

			if (estatusfechaEnvio == null && fechaEnvio2 != null) {

		 		if (fechaEnvio2 == 'Proceso') {
		 			estatusfechaEnvio = "2";
		 				fechaEnvio=0;


		 		}else if (fechaEnvio2 == 'Cancelado') {
		 			estatusfechaEnvio = "3";
		 			fechaEnvio=0;

		 		}else{

		 			estatusfechaEnvio = "1";
		 			fechaEnvio = fechaEnvio2;

		 		}
			}

			var fechaTermino2 = $("#fechaSerTerminado3").val(); 

			if (estatusFechaTermino == null && fechaTermino2 != null) {

			 	if (fechaTermino2 == 'Proceso') {
			 		estatusFechaTermino = "2";
			 		fechaTermino =0;

			 	}else if (fechaTermino2 == 'Cancelado') {
			 		estatusFechaTermino = "3";
			 		fechaTermino =0;


			 	}else{
			 		estatusFechaTermino = "1";
			 		fechaTermino =fechaTermino2;

			 	}
			}*/


			$.post("acceso/route.php",{acceess:93,folioRegistro:folioRegistro,ordenTrabajo:ordenTrabajo,estatusfechaEnvio:estatusfechaEnvio,
			fechaEnvio:fechaEnvio,areaProductora:areaProductora},function(yz){ 
		//fechaNotificacion:fechaNotificacion,fechaLevantamiento:fechaLevantamiento,folioGeo:folioGeo,estatusFechaTermino:estatusFechaTermino,fechaTermino:fechaTermino,superficie:superficie

		 		if (yz == "1" || yz == 1) {  

		 			//cerrar modal de registro
		 			$("#myModal2").hide();
		 			//Abrir modal de registro guardado
		 			$("#registroBien").show();
		 		}else{
		 			//error
		 		}
	 		});
		}
	});
}

function terminarProcesoDos(usuario_envio){
	//alert(usuario_envio);
	var fup=$("#fup").val();
	//alert(fup);

	var folioRegistro = $("#fol").val();
	var ordenTrabajo = $("#ordentrabajo").val();
	var estatusfechaEnvio = $("#fechaDeEnvio").val();////es el select
	var fechaEnvio = $("#fechaEnvio").val();////es el date
	var areaProductora = $("#areaProduc").val();
	var fechaEnvio2 = $("#fechaEnvio2").val();

	var proc = 0;///no se usa
	var sn = 0;

	if(ordenTrabajo==""){
		$("#titulo_modal_ad").html('Registro faltante');
		$("#mensaje_modal_ad").html('Para continuar con el proceso es necesario ingresar la orden de trabajo');
		$("#modal_mensaje_ad").modal('show');
	}else{
		if(estatusfechaEnvio==0){
			$("#titulo_modal_ad").html('Registro faltante');
			$("#mensaje_modal_ad").html('Para continuar con el proceso es necesario seleccionar fecha de envío al área de topografía');
			$("#modal_mensaje_ad").modal('show');
		}else{
			if(estatusfechaEnvio==1 && fechaEnvio==""){
				$("#titulo_modal_ad").html('Registro faltante');
				$("#mensaje_modal_ad").html('Para continuar con el proceso es necesario seleccionar fecha');
				$("#modal_mensaje_ad").modal('show');
			}else{
				if(areaProductora==0){
					$("#titulo_modal_ad").html('Registro faltante');
					$("#mensaje_modal_ad").html('Para continuar con el proceso es necesario seleccionar el área productora');
					$("#modal_mensaje_ad").modal('show');
				}else{		

					////aqui ya que se validaron los campos, se guarda de acuerdo al estatus	
					if(estatusfechaEnvio==3){////cancelado
						///no venia nada en el código original, no hace nada
					}
					else if(estatusfechaEnvio==2){////proceso
						$.post("acceso/route.php",{acceess:94,folioRegistro:folioRegistro},function(yz){

							if (yz == 100 || yz == "100") {
								//sin registro
								sn = 102 ;
								$.post("acceso/route.php",{acceess:82,folioRegistro:folioRegistro,ordenTrabajo:ordenTrabajo,sn:sn},function(yz){ 
							 		if (yz == "1" || yz == 1) {  
							 			$("#myModal2").modal('hide');
							 			$(".proceso_n").hide();	

							 			$("#titulo_modal_ok").html('Registro correcto');
										$("#mensaje_modal_ok").html('Información guardada correctamente');
										$("#modal_mensaje_ok").modal('show');								 			
							 		}
							 	});

							}else{
								//Con registro
								sn = 20;
								$.post("acceso/route.php",{acceess:82,folioRegistro:folioRegistro,ordenTrabajo:ordenTrabajo,sn:sn},function(yz){ 
							 		if (yz == "1" || yz == 1) {  
							 			$("#myModal2").modal('hide');	
							 			$(".proceso_n").hide();

							 			$("#titulo_modal_ok").html('Registro correcto');
										$("#mensaje_modal_ok").html('Información guardada correctamente');
										$("#modal_mensaje_ok").modal('show');									 			
							 		}
							 	});
							}
						});
					}else if(estatusfechaEnvio==1){////ingresar fecha
						//alert(estatusfechaEnvio);
						sn=0;
						$.post("acceso/route.php",{acceess:94,folioRegistro:folioRegistro},function(yz){
							if (yz == 100 || yz == "100") {
								/////////sin registro
								sn = 10 ;								
							}							

							$.post("acceso/route.php",{acceess:92,folioRegistro:folioRegistro,ordenTrabajo:ordenTrabajo,estatusfechaEnvio:estatusfechaEnvio,fechaEnvio:fechaEnvio,areaProductora:areaProductora,sn:sn},function(yz){ 
						 		if (yz == "1" || yz == 1) { 


									
						 			//////aqui se envía correo avisando que se envió a topografía
						 			///se realiza envío de correo
								    correo_destino='erick.garcia.rdz@hotmail.com'; //alert(correo_destino);
								    asunto='Aviso de envío a Topografía'; 
								    tipo='Enviado a Topografía';
								    $.ajax({
								    	url:'Ops2.php?action=guardar_datos_correo',
								    	data:{correo_destino:correo_destino, usuario_envio:usuario_envio, asunto:asunto, fup:fup, tipo:tipo },
								    	dataType:'json',
								    	type:'post',
								    	//beforeSend:function(){alert('here');},				    	
								    	success:function(v){
								    		if(v==true){
								    			////se manda el correo
								    			$.ajax({
								    				url:'Ops2.php?action=enviar_correo',
								    				data:{fup:fup, usuario:usuario_envio, tipo:tipo, correo_destino:correo_destino },
								    				dataType:'json',
								    				type:'post',
								    				success:function(w){
								    					//alert(w);
								    					if(w==true){
								    						//cerrar modal de registro
												 			$("#myModal2").modal('hide');
												 			$(".proceso_n").hide();	
												 			//Abrir modal de registro guardado								 			
												 			$("#titulo_modal_ok").html('Registro correcto');
															$("#mensaje_modal_ok").html('Información guardada correctamente');
															$("#modal_mensaje_ok").modal('show');

								    					}else{
								    						alert('Fallo en el envío del correo');
								    					}
								    				}
								    			});

								    		}else{
								    			alert('Error al guardar en la BD');
								    		}
								    	}
								    });




									//cerrar modal de registro
									$("#myModal2").modal('hide');
									$(".proceso_n").hide();	
									//Abrir modal de registro guardado								 			
									$("#titulo_modal_ok").html('Registro correcto');
									$("#mensaje_modal_ok").html('Información guardada correctamente');
									$("#modal_mensaje_ok").modal('show');		
						 		}
				 			});
						});
					}					
				}
			}
		}
	}	
}

function cerrarM(){/////pARECE QUE NO SE VA USAR
	$("#registrosFaltantes").modal('hide');		
	$("#registrosFaltantesFecha").modal('hide');	
	$("#registroSinProesoAnterior").modal('hide');	
}

function costoDifer(){
	var anticipo = $("#anticip").val();
	var costoTT = $("#costoTT").val();
	var diferencia = 0;

	diferencia = costoTT - anticipo;

	$("#diferencia").val(diferencia);
}

function mostrarInfoEntregaUser(){
	var folioRegistro3 = $("#idRegistro3").val();

	$.post("acceso/route.php",{acceess:91,folioRegistro3:folioRegistro3},function(yz){

	 	if (yz == "100" || yz == 100) {
	 		//sin registro 
	 	}else{
	 		//con registro
	 		$(yz).each(function(key,valuee){ 

				$("#costoTT").val(valuee.costototal);

				if (valuee.fechanotientrega=="1999-01-01 00:00:00+01") {

				}else{
					document.getElementById('fechanotientrega').style.display = "none";
					$("#fechanotientrega3").show();
					$("#fechanotientrega3").val(valuee.fechanotientrega);
				}
				
				if (valuee.fechaentregasol=="1999-01-01 00:00:00+01") {

				}else{
					document.getElementById('fechaentregasolicitante').style.display = "none";
					$("#fechaentregasolicitante3").show();
					$("#fechaentregasolicitante3").val(valuee.fechaentregasol);
				}
				$("#diferencia").val(valuee.diferencia);
				$("#reciboFUP").val(valuee.recibofup); 
		 	});
		}
	});
}

function actualizarProcesoTres(){

	var folioRegistro3 = $("#idRegistro3").val();
	var costoTT = $("#costoTT").val();
	var fechanotientrega = $("#fechanotientrega").val();
	var fechaentregasolicitante = $("#fechaentregasolicitante").val();
	var diferencia = $("#diferencia").val();
	var reciboFUP = $("#reciboFUP").val();

	if (fechanotientrega == null || fechanotientrega == "") {
		fechanotientrega = 0;
	}

	if (fechaentregasolicitante == null || fechaentregasolicitante == "") {
		fechaentregasolicitante = 0; 
	}

	$.post("acceso/route.php",{acceess:91,folioRegistro3:folioRegistro3},function(yz){ 

	 	if (yz == "100" || yz == 100) {
	 		//sin registro
	 		$.post("acceso/route.php",{acceess:90,folioRegistro3:folioRegistro3,costoTT:costoTT,fechanotientrega:fechanotientrega,fechaentregasolicitante:fechaentregasolicitante, diferencia:diferencia,reciboFUP:reciboFUP},function(yz){

		 	    //console.log(yz); 
		 		if (yz == "1" || yz == 1) {
		 			$("#procesoTresInfo").modal('hide');
		 			$("#registroBien").modal('show');
		 		}
	  		});
	 	}else{
	 		//con registro
	 		var fechanotientrega3 = $("#fechanotientrega3").val();
			var fechaentregasolicitante3 = $("#fechaentregasolicitante3").val();
			//verificar aqui este if... no  lo valida bien en fechanotientrega3 != null

			if (fechanotientrega == null && fechanotientrega3 != null || fechanotientrega == "" && fechanotientrega3 != "") { 
				fechanotientrega = fechanotientrega3;
			}

			if (fechaentregasolicitante == null && fechaentregasolicitante3 != null || fechaentregasolicitante == "" && fechaentregasolicitante3 != "") {
				fechaentregasolicitante = fechaentregasolicitante3;
			}

			$.post("acceso/route.php",{acceess:89,folioRegistro3:folioRegistro3,costoTT:costoTT,fechanotientrega:fechanotientrega,fechaentregasolicitante:fechaentregasolicitante, diferencia:diferencia,reciboFUP:reciboFUP},function(yz){
		 		//console.log(yz); 
		 		if (yz == "1" || yz == 1) {
	 				$("#procesoTresInfo").modal('hide');
	 				$("#registroBien").modal('show');
		 		}
	  		});
	 	}
	});
}

function terminarProcesoTres(){

	var folioRegistro3 = $("#idRegistro3").val();
	var costoTT = $("#costoTT").val();
	var fechanotientrega = $("#fechanotientrega").val();
	var fechaentregasolicitante = $("#fechaentregasolicitante").val();
	var diferencia = $("#diferencia").val();
	var reciboFUP = $("#reciboFUP").val();
	var fechanotientrega3 = $("#fechanotientrega3").val();
	var fechaentregasolicitante3 = $("#fechaentregasolicitante3").val();
	var proc = 0;

	////////////////////////////////////////////validar cuando un dato no este registrado/////////////////////////////////////////////////////////////////////////
	if (costoTT == null || costoTT == "" || diferencia == null || diferencia == "" || reciboFUP == null || reciboFUP == "") {
			proc = 1;
	}

		 if (fechanotientrega == null && fechanotientrega3 != null || fechanotientrega == "" && fechanotientrega3 != "") { 
				fechanotientrega = fechanotientrega3;

			}else if (fechanotientrega != null && fechanotientrega3 == null || fechanotientrega != "" && fechanotientrega3 == ""){
				//proc = 0;
			}else{
				proc = 1;
			}

			if (fechaentregasolicitante == null && fechaentregasolicitante3 != null || fechaentregasolicitante == "" && fechaentregasolicitante3 != "") {
				fechaentregasolicitante = fechaentregasolicitante3;
			}else if(fechaentregasolicitante != null && fechaentregasolicitante3 == null || fechaentregasolicitante != "" && fechaentregasolicitante3 == ""){
				//proc = 0;

			}else{
				proc = 1;
			}

		/////////////////////////////////Todos los registros con datos/////////////////////////////////////////////////////

			if (proc == 1) {
				//Faltan datos por registrar
				$("#procesoTresInfo").modal('hide');	
				$("#registrosFaltantes").modal('show');	


			}else{  

			$.post("acceso/route.php",{acceess:88,folioRegistro3:folioRegistro3,costoTT:costoTT,fechanotientrega:fechanotientrega,
		 	fechaentregasolicitante:fechaentregasolicitante,diferencia:diferencia,reciboFUP:reciboFUP},function(yz){ 

		 		if (yz == "1" || yz == 1) {  
		 			//$("#registrosFaltantes").modal('hide');	
		 			//cerrar modal de registro
		 			$("#myModal2").modal('hide');	
		 			//Abrir modal de registro guardado
		 			$("#procesoTerminadoTres").modal('show');	
		 		}

		 		  });
			}
}

function mostrarInfoCierre(){////aqui se carga información en el modal, si es que ya se había registrado información con anterioridad
	var fup=$("#fup").val();

	////verificamos si el usuario GEO ya terminó su registro, mostrado en los campos salida_equipo y regreso_equipo de la tabla registros
	$.ajax({
		url:'acceso/route.php',
		data:{acceess:103,fup:fup},
		type:'post',
		dataType:'json',
		success:function(z){
			if(z.entrega_equipo){
				
				///abrimos el modal
				$("#procesoCuatroInfo").modal('show');

				var folioRegistro4 = $("#fol").val();////numero de folio, para buscar en tabla procesodos
				var folioGeo = "";
				var folioGeo2 = "";
				var identificadorGeo="", folioGeo="", anioGeo="";
				$.post("acceso/route.php",{acceess:94,folioRegistro:folioRegistro4},function(yz){ //87////se cambia al 94 porque es exactamente lo mismo, obtiene info de la tabla procesodos

				 	if (yz == 100 || yz == "100") { 
				 		//sin registro
				 		////no puede estar sin registro, porque desde etapas anteriores ya se hizo el registro y solo se va actualizando la tabla
				 	}else{
				 		//con registro
				 		$(yz).each(function(key,valuee){
				 			//dividir el folio GEO ----- ya no se usa, porque ahora esto lo llena geografia y se muestra el folio como ellos lo pongan
					 		// 	folioGeo=valuee.foliogeo;
					 		// 	folioGeo2 = folioGeo.split('/');
								// identificadorGeo = folioGeo2[0];
					 		// 	folioGeo = folioGeo2[1];
					 		// 	anioGeo = folioGeo2[2];

					 		// 	$("#identificadorGeo").val(identificadorGeo);
					 		// 	$("#folGeo").val(folioGeo);
					 		// 	$("#anioGeo").val(anioGeo);

				 			if (valuee.fechalevantamiento != "") {
				 				$("#fechaentregaGeo").val( moment(valuee.fechalevantamiento).format('YYYY-MM-DD') );
				 			}
				 			$("#folio_geo").val(valuee.foliogeo);
				 		});
				 	}
				});

			}else{
				//alert('está aqui');

				$("#titulo_modal_ad").html('En espera');
				$("#mensaje_modal_ad").html('<div align="center">Para continuar es necesario que el respectivo usuario de tipo Geografía complete su registro</div>');
				$("#modal_mensaje_ad").modal('show');
			}
		}
	});	
}
// function mostrarInfoCierre(){////aqui se carga información en el modal, si es que ya se había registrado información con anterioridad
// 	var fup=$("#fup").val();

// 	///abrimos el modal
// 	$("#procesoCuatroInfo").modal('show');

// 	var folioRegistro4 = $("#fol").val();////numero de folio, para buscar en tabla procesodos
// 	var folioGeo = "";
// 	var folioGeo2 = "";
// 	var identificadorGeo="", folioGeo="", anioGeo="";
// 	$.post("acceso/route.php",{acceess:94,folioRegistro:folioRegistro4},function(yz){ //87////se cambia al 94 porque es exactamente lo mismo, obtiene info de la tabla procesodos

// 		 if (yz == 100 || yz == "100") { 
// 			 //sin registro
// 			 ////no puede estar sin registro, porque desde etapas anteriores ya se hizo el registro y solo se va actualizando la tabla
// 		 }else{
// 			 //con registro
// 			 $(yz).each(function(key,valuee){
// 				 //dividir el folio GEO ----- ya no se usa, porque ahora esto lo llena geografia y se muestra el folio como ellos lo pongan
// 				 	folioGeo=valuee.foliogeo;
// 				 	folioGeo2 = folioGeo.split('/');
// 					identificadorGeo = folioGeo2[0];
// 				 	folioGeo = folioGeo2[1];
// 				 	anioGeo = folioGeo2[2];

// 				 	$("#identificadorGeo").val(identificadorGeo);
// 				 	$("#folGeo").val(folioGeo);
// 				 	$("#anioGeo").val(anioGeo);

// 				 if (valuee.fechalevantamiento != "") {
// 					 $("#fechaentregaGeo").val( moment(valuee.fechalevantamiento).format('YYYY-MM-DD') );
// 				 }
// 				 $("#folio_geo").val(valuee.foliogeo);
// 			 });
// 		 }
// 	});
// }

function actualizarProcesoCuatro(){

	var folioRegistro4 = $("#idRegistro4").val(); //folio del procesoDos , un digito
	var identificadorGeo = $("#identificadorGeo").val(); //identificador para el folio GEO
	var folGeo = $("#folGeo").val(); // folio  geo correspondiente
	var anioGeo = $("#anioGeo").val();// año del folio geo
	var fechaentregaGeo = $("#fechaentregaGeo").val(); //fecha de levantamiento
	var fechaentregaGeo2 = $("#fechaentregaGeo2").val();
	var idConcluido = ""; 

	if (identificadorGeo == null || folGeo == null || anioGeo == null || identificadorGeo == "" || folGeo == "" || anioGeo == "") {
			//falte registar un campo para completar el FOLIO GEO	
			idConcluido="";
	}else{
		// completar el folio GEO
		idConcluido=identificadorGeo+"/"+folGeo+"/"+anioGeo;
	}
		// $.post("acceso/route.php",{acceess:87,folioRegistro4:folioRegistro4},function(yz){ 

		 	/*if (yz == 100 || yz == "100"){
		 		//sin registro
		 	$.post("acceso/route.php",{acceess:86,folioRegistro4:folioRegistro4,idConcluido:idConcluido,fechaentregaGeo:fechaentregaGeo},function(yz){ 
		 		
		 		if (yz == 1 || yz == "1") { 
		 			$("#procesoCuatroInfo").modal('hide');
	 				$("#registroBien").modal('show');
		 		}
		 	});
		 	}*///else{

		 		//if (fechaentregaGeo == null && fechaentregaGeo2 != null || fechaentregaGeo == "" && fechaentregaGeo2 != "") {
		 		//		fechaentregaGeo = fechaentregaGeo2; 
		 	//	} 
		 		//con registro
		 		$.post("acceso/route.php",{acceess:85,folioRegistro4:folioRegistro4,idConcluido:idConcluido,fechaentregaGeo:fechaentregaGeo},function(yz){
		 			if (yz == 1 || yz == "1") {
		 					$("#procesoCuatroInfo").modal('hide');
	 						$("#registroBien").modal('show');

		 			}else{

		 			}

		 		 });
		 	//}
		 // });
}

function terminarProcesoCuatro(){
	var folioRegistro4 = $("#fol").val(); // id de registro en procesoDos
	var fechaentregaGeo = $("#fechaentregaGeo").val(); //fecha de levantamiento
	

	// var identificadorGeo = $("#identificadorGeo").val(); //identificador para el folio GEO
	// var folGeo = $("#folGeo").val(); // folio  geo correspondiente
	// var anioGeo = $("#anioGeo").val();// año del folio geo
	// var idConcluido = "";// folio GEO completo
	// var folio_geo = identificadorGeo+"/"+folGeo+"/"+anioGeo;

	var folio_geo=$("#folio_geo").val();

	if(fechaentregaGeo==""){
		$("#titulo_modal_ad").html('Registro faltante');
		$("#mensaje_modal_ad").html('Para continuar con el proceso es necesario seleccionar la fecha de levantamiento');
		$("#modal_mensaje_ad").modal('show');
	}else{
		//if (identificadorGeo == "" || folGeo == "" || anioGeo == "") {
		if(folio_geo==""){
			//falte registar un campo para completar el FOLIO GEO	
			$("#titulo_modal_ad").html('Registro faltante');
			$("#mensaje_modal_ad").html('Para continuar con el proceso es necesario completar el folio GEO');
			$("#modal_mensaje_ad").modal('show');

		}else{
			// completar el folio GEO
			//idConcluido=identificadorGeo+"/"+folGeo+"/"+anioGeo;  
			//todos los datos han sigo  registrados
 			$.post("acceso/route.php",{acceess:84,folioRegistro4:folioRegistro4,idConcluido:folio_geo,fechaentregaGeo:fechaentregaGeo},function(yz){

	 		 	if (yz == 1 || yz =="1") {
	 		 		$("#procesoCuatroInfo").modal('hide');
	 		 		$(".proceso_n").hide();

	 				$("#titulo_modal_ok").html('Registro correcto');
					$("#mensaje_modal_ok").html('Información guardada correctamente');
					$("#modal_mensaje_ok").modal('show');

	 		 	}else{
	 		 	}
 		    });
		}
	}
}

function procesosTrm(id,delegacion){
	//console.log('gfgg');
		$("#procesosTr").modal('show');
		$("#idFup").val(id);

		var fup_buscar = id;
		var iddelegacion = delegacion;
		/*96
		   */
		 $.post("acceso/route.php",{acceess:96,fup_buscar:fup_buscar,iddelegacion:iddelegacion},
		 	function(yz){
		 		if (yz == "100" || yz == 100) {
		 			//Sin registro
		 		}else{
		 			//Con registro
		 				$(yz).each(function(key,valuee){
		 					if (valuee.proceso == 1) {
		 						$("#canceladoProcesoCero").hide();
		 						$("#etapaUno").show();
		 						$("#etapaDos").hide();
		 						$("#etapaTres").hide();
		 						$("#etapaCuatro").hide();
		 					}else if (valuee.proceso == 2){
		 						$("#canceladoProcesoCero").hide();
		 						$("#etapaUno").hide();
		 						$("#etapaDos").show();
		 						$("#etapaTres").hide();
		 						$("#etapaCuatro").hide();

		 					}else if (valuee.proceso == 3){
		 						$("#canceladoProcesoCero").hide();
		 						$("#etapaUno").hide();
		 						$("#etapaDos").hide();
		 						$("#etapaTres").show();
		 						$("#etapaCuatro").hide();

		 					}else if (valuee.proceso == 4){
		 						$("#canceladoProcesoCero").hide();
		 						$("#etapaUno").hide();
		 						$("#etapaDos").hide();
		 						$("#etapaTres").hide();
		 						$("#etapaCuatro").show();
		 					}else if (valuee.proceso == 0) {
		 						$("#canceladoProcesoCero").show();
		 						$("#etapaUno").show();
		 						$("#etapaDos").hide();
		 						$("#etapaTres").hide();
		 						$("#etapaCuatro").hide();

		 					}
		 				});
		 		}
		 	});
}


function detalleEtapas(proceso,fup,id){

	$.post("acceso/route.php",{acceess:80,proceso:proceso,fup:fup,id:id},
	 	function(yz){

	 		console.log(yz); 
 			if (proceso == 1) {
 				$("#tituloP").val('PROCESO: INGRESO RECEPCION SOLICITUD');
 				$("#uno").show();
 				$("#dos").hide();
 				$("#tres").hide();
 				$("#cuatro").hide();
 				$("#cero").hide();

 				$(yz).each(function(key,valuee){

 					var solicitante = valuee.solicitante+" "+valuee.apaterno+" "+valuee.amaterno;

 					$("#cclave").val(valuee.clavec);
 					$("#muni").val(valuee.municipio);
					$("#fechaRece").val(valuee.fecha_recepcion);
					$("#supInicial").val(valuee.superficieinicial);
					$("#anticipo").val(valuee.anticipo);
					$("#solicitant").val(solicitante);
					$("#fupAs").val(valuee.fup); 				
 				});

 			}else if (proceso == 2) {
 				$("#tituloP").val('PROCESO: TRABAJO EN CAMPO Y GABINETE');
 				$("#uno").hide();
 				$("#dos").show();
 				$("#tres").hide();
 				$("#cuatro").hide();
 				$("#cero").hide();

 				$(yz).each(function(key,valuee){

 					$("#ordentrabajo").val(valuee.ordentrabajo);
 					$("#fechaEnvio2").val(valuee.fechaenvio);
					$("#areaProduc").val(valuee.areaproduc);
					$("#fechaNotificacion2").val(valuee.fechanotificacion);
					$("#fechaLevantamiento2").val(valuee.fechalevantamiento);
					$("#folioGEO").val(valuee.foliogeo);
					$("#fechaSerTerminado3").val(valuee.fechatermino);
					$("#superficie").val(valuee.superficie);  				
 				});


 			}else if (proceso == 3) {
 				$("#tituloP").val('PROCESO: ENTREGA A USUARIO');
 				$("#uno").hide();
 				$("#dos").hide();
 				$("#tres").show();
 				$("#cuatro").hide();
 				$("#cero").hide();

 				$(yz).each(function(key,valuee){

 					$("#costoTT").val(valuee.costototal);
					$("#fechanotientrega3").val(valuee.fechanotientrega);
					$("#fechaentregasolicitante3").val(valuee.fechaentregasol);
					$("#diferencia").val(valuee.diferencia);
					$("#reciboFUP").val(valuee.recibofup); 				
 				});

 			}else if (proceso == 4) { 
 				$("#tituloP").val('PROCESO: CIERRE');
 				$("#uno").hide();
 				$("#dos").hide();
 				$("#tres").hide();
 				$("#cuatro").show();
 				$("#cero").hide();

 				$(yz).each(function(key,valuee){

 					$("#idConcluido").val(valuee.id_envioexpediente);
					$("#fechaentregaGeo2").val(valuee.fechaentregageografia); 				
 				});

 			}else if (proceso == 0) { 
 				$("#tituloP").val('PROCESO: CANCELADO');
 				$("#cero").show();
 				$("#uno").hide();
 				$("#dos").hide();
 				$("#tres").hide();
 				$("#cuatro").hide();

 				$(yz).each(function(key,valuee){

 					var solicitante = valuee.solicitante+" "+valuee.apaterno+" "+valuee.amaterno;

 					$("#cclave2").val(valuee.clavec);
 					$("#muni2").val(valuee.municipio);
					$("#fechaRece2").val(valuee.fecha_recepcion);
					$("#supInicial2").val(valuee.superficieinicial);
					$("#anticipo2").val(valuee.anticipo);
					$("#solicitant2").val(solicitante);
					$("#fupAs2").val(valuee.fup);
					$("#orden2").val(valuee.ordentrabajo);

					if (valuee.estatusfecha == "3") {
						$("#proCancelado").show();
						$("#proEnProceso").hide();
						$("#fechaEnvio2c").val('CANCELADO');

					}else if (valuee.estatusfecha == "2") {
						$("#proEnProceso").show();
						$("#proCancelado").hide();
						$("#fechaEnvio2c").val('PROCESO');

					}else if (valuee.estatusfecha == "1") {
						$("#proEnProceso").hide();
						$("#proCancelado").hide();

						$("#fechaEnvio2c").val(valuee.fechaenvio);
						$("#areaProduc2").val(valuee.areaproduc);
						$("#fechaNotificacion2c").val(valuee.fechanotificacion);
						$("#fechaLevantamiento2c").val(valuee.fechalevantamiento);
						$("#folioGEOc").val(valuee.foliogeo);

						if (valuee.estatusfechater == "3") {
							$("#proCancelado").show();
							$("#proEnProceso").hide();
						}
					}						
 				
 				});
 			}
	 	});
}

function notificacionColindantes(){///erickkk
	///llama primero a la info de procesodos y pone fecha si es que ya hay
	var fup= $("#fup").val();
	
	////aqui validamos que geografía haga su parte 
	$.ajax({
		url:'acceso/route.php',
		//data:{acceess:103,fup:fup},
		data:{acceess:104,fup:fup},
		type:'post',
		dataType:'json',
		success:function(z){
			//if(z.entrega_equipo){
			if(z.salida_equipo){	
				$.post("acceso/route.php",{acceess:102,fup:fup},function(w){
					if(w!=100){
						$(w).each(function(key,v){
							if(v.fechanotificacion!=""){
								$("#fechanotif").val( moment(v.fechanotificacion).format('YYYY-MM-DD') );

								////se agrega la fecha de levantamiento y especialista a este apartado
								$("#fecha_lev").val( moment(v.fechalevantamiento).format('YYYY-MM-DD') );
								$("#esp_lev").val( v.especialista );
							}
				    	});				
					}
				});
				$("#modal_notificacion").modal('show');	
			}else{
				$("#titulo_modal_ad").html('En espera');
				$("#mensaje_modal_ad").html('<div align="center">Para continuar es necesario que el respectivo usuario de tipo Geografía complete su registro</div>');
				$("#modal_mensaje_ad").modal('show');
			}
		}
	});
}
// function notificacionColindantes(){///erickkk
// 	///llama primero a la info de procesodos y pone fecha si es que ya hay
// 	var fup= $("#fup").val();	
// 	///obtenemos la fecha de notificación, en caso de que ya se haya guardado
// 	$.post("acceso/route.php",{acceess:102,fup:fup},function(w){
// 		if(w!=100){
// 			$(w).each(function(key,v){
// 				if(v.fechanotificacion!=""){
// 					$("#fechanotif").val( moment(v.fechanotificacion).format('YYYY-MM-DD') );
// 				}
// 			});				
// 		}
// 	});
// 	$("#modal_notificacion").modal('show');	


// }

function fechaNotificacionCo(){
	var fechaNotificacion= $("#fechanotif").val();
	//var idRegistroDos= $("#idRegistroE").val();
	var idRegistroDos= $("#fol").val();
	var fup= $("#fup").val();

	if (fechaNotificacion == null || fechaNotificacion == "") {
		$("#titulo_modal_ad").html('Registro faltante');
		$("#mensaje_modal_ad").html('Para continuar con el proceso es necesario registrar la fecha solicitada');
		$("#modal_mensaje_ad").modal('show');
	}else{

		$.post("acceso/route.php",{acceess:76,fechaNotificacion:fechaNotificacion,idRegistroDos:idRegistroDos,fup:fup},
		 	function(yz){ 
		 		if (yz == 1 || yz =="1") {
	 				$(".proceso_n").hide();
	 				
	 				$("#modal_notificacion").modal('hide');

	 				$("#titulo_modal_ok").html('Registro correcto');
					$("#mensaje_modal_ok").html('Información guardada correctamente');
					$("#modal_mensaje_ok").modal('show');
	 		 	}
		 	});
	}

}

function fechaNotificacionCo_2(){////aqui solo guarda la fecha sin pasar de proceso
	//alert('Entra');
	var fechaNotificacion= $("#fechanotif").val();
	var idRegistroDos= $("#fol").val();///este está en delegaciones.php como hidden
	var fup= $("#fup").val();///está en delegaciones.php

	if (fechaNotificacion == null || fechaNotificacion == "") {
		$("#titulo_modal_ad").html('Registro faltante');
		$("#mensaje_modal_ad").html('Para continuar con el proceso es necesario registrar la fecha solicitada');
		$("#modal_mensaje_ad").modal('show');

	}else{///fecha ingresada
		$.post("acceso/route.php",{acceess:101,fechaNotificacion:fechaNotificacion,idRegistroDos:idRegistroDos,fup:fup},
		 	function(yz){ 
		 		if (yz == 1 || yz =="1") {
	 		 		//$("#cancelarlevantamientoBTN").hide();
	 				$(".proceso_n").hide();
	 				$("#modal_notificacion").modal('hide');
	 				//$("#procesoTres").show();
	 				$("#titulo_modal_ok").html('Registro correcto');
					$("#mensaje_modal_ok").html('Información guardada correctamente');
					$("#modal_mensaje_ok").modal('show');
	 		 	}
		 	});
	}

}

function envioDirGeo(){
	var fup= $("#fup").val();///está en delegaciones.php
	///////////////si  lo hizo geografia, se pone por default la fecha de regreso del envio
	$.ajax({
		url:'acceso/route.php',
		data:{acceess:105,fup:fup},
		dataType:'json',
		type:'post',
		success:function(yz){
			//alert(yz);
	 		if(yz.areaproduc=='Geografia'){
	 			$("#fechaEnvioDirGeogra").val( moment( yz.fecha_equipo_entrega ).format('YYYY-MM-DD') );
				
				////fechatermino es la fecha de envío a la dirección de geografía
				$("#fechaEnvioDirGeogra").val( moment( yz.fechatermino ).format('YYYY-MM-DD') );
	 		}
		}
	});

	//$("#fechaEnvioDirGeo").show();
	$("#envio_dir_geo").modal('show');
}

function fechaEnvioDirGeografia(){
	var fechaEnvioDirGeogra= $("#fechaEnvioDirGeogra").val();
	var idRegistroDos= $("#fol").val();
	var fup= $("#fup").val();/////se encuentra en deleaciones.php

	if (fechaEnvioDirGeogra == null || fechaEnvioDirGeogra == "") {//mensaje
		//$("#registrosFaltantesFecha").modal('show');
		$("#titulo_modal_ad").html('Registro faltante');
		$("#mensaje_modal_ad").html('Para continuar con el proceso es necesario seleccionar la fecha de envío a la dirección de geografía');
		$("#modal_mensaje_ad").modal('show');
	}else{
		$.post("acceso/route.php",{acceess:75,fechaEnvioDirGeogra:fechaEnvioDirGeogra,idRegistroDos:idRegistroDos,fup:fup},
		 	function(yz){ 
		 		if (yz == 1 || yz =="1") {
	 				//$("#procesoCuatro").hide();
	 				$("#titulo_modal_ok").html('Registro correcto');
					$("#mensaje_modal_ok").html('Información guardada correctamente');
					$("#modal_mensaje_ok").modal('show');

	 				$(".proceso_n").hide();
	 				$("#envio_dir_geo").modal('hide');
	 		 	}
		 	});
	}	
}

function recepcionCCC(){////modal Recepcionado en DSI
	////buscamos el valor de la fecha de recepcion en DSI
	var fup= $("#fup").val();/////se encuentra en deleaciones.php
	$.ajax({
		url:'acceso/route.php',
		data:{acceess:107,fup:fup},
		dataType:'json',
		type:'post',
		success:function(yz){
			$("#fechaRecepcionDSIccc").val( moment( yz.fecharecepcionccc ).format('YYYY-MM-DD') );
		}
	});


	$("#recepcion_dsi").modal('show');

	$("#fechaRecepcionDSIccc").val('');
}

function fechaRecepcionDsicc(){////boton guardar del modal Recepcionado en DSI
	var fechaRecepcionDSIccc= $("#fechaRecepcionDSIccc").val();
	var idRegistroDos= $("#fol").val();///se encuentra como campo oculto en delegaciones.php
	var fup= $("#fup").val();/////se encuentra en deleaciones.php

	if (fechaRecepcionDSIccc == null || fechaRecepcionDSIccc == "") {
		//$("#registrosFaltantesFecha").modal('show');
		$("#titulo_modal_ad").html('Registro faltante');
		$("#mensaje_modal_ad").html('Para continuar con el proceso es necesario seleccionar la fecha de recepción en DSI (CCC)');
		$("#modal_mensaje_ad").modal('show');
	}else{
		$.post("acceso/route.php",{acceess:74,fechaRecepcionDSIccc:fechaRecepcionDSIccc,idRegistroDos:idRegistroDos,fup:fup},
		 	function(yz){  

		 		if (yz == 1 || yz =="1") {
	 				//$("#procesoCinco").hide(); 
	 				$("#titulo_modal_ok").html('Registro correcto');
					$("#mensaje_modal_ok").html('Información guardada correctamente');
					$("#modal_mensaje_ok").modal('show');

	 				$(".proceso_n").hide();
	 				$("#recepcion_dsi").modal('hide');
	 		 	}else{

	 		 	}
		 	});
	}
}

function manda_calcularCostoTotal(){
	var anio_tarifa = $("#anio_tarifa").val();
	//alert(anio_tarifa);
	CalcularCostoTotal(anio_tarifa);
}

function CalcularCostoTotal(anio_tarifa){
	var supInicial ="";
	var superficie =0;
	var factorAplicable=0;
	var factorAplicable2=0;
	var cuotaFija=0;
	var cuotaFija2=0;
	var totalDeAnticipo=0;
	var totalDeAnticipo2=0;
	var folioGnral = $("#fol").val();
	var anticipo="",costoTot2="",costoTot3="",anticipoF=0, costoTot="", diferenciaCT=0, costoTotF=0, diferenciaCT2=0, diferenciaCT3=0;
    var ban = 0;
	supInicial =$("#superficieResultante").val();
	//alert(supInicial);
	/////////////////////////////calcular el costo total dependiendo de la superficie/////////////////////////////////////////////////////
	$.post("acceso/route.php",{acceess:78,supInicial:supInicial, anio_tarifa:anio_tarifa},function(yz){

		$(yz).each(function(key,valuee){
    		superficie=supInicial - valuee.limiteinferior;
    		factorAplicable=superficie * valuee.factoraplicable;
    		cuotaFija = parseFloat(valuee.cuotafija);
    		factorAplicable2=parseFloat(factorAplicable);
    		cuotaFija2 = factorAplicable2 + cuotaFija;
    	});
		//console.log(cuotaFija2); 
		totalDeAnticipo=Math.round(cuotaFija2)
		totalDeAnticipo2= totalDeAnticipo.toLocaleString("en-US", {
	        style: "currency",
	        currency: "USD"
	    });
		//alert(totalDeAnticipo2);
		$("#costoTotal").val(totalDeAnticipo2);			    
    });

    ///////////////////////calcular la diferencia del anticipo con el costo total///////////////
    $.post("acceso/route.php",{acceess:73,folioGnral:folioGnral},function(yz){

		if (yz == 100 || yz == "100") {
    		//sin registro encontrado
    	}else{
    		//console.log(yz); 
    		$(yz).each(function(key,valuee){
	    		anticipo = valuee.anticipo;
	  			anticipoF = parseFloat(anticipo);

	    		costoTot = $("#costoTotal").val();
	  			costoTot2 = costoTot.replace('$', '');
	  			costoTot3 = costoTot2.replace(',', '');
	  			costoTotF = parseFloat(costoTot3);
	  			////ERICK
	    		//diferenciaCT = anticipoF - costoTotF;////esta es la línea original
	    		diferenciaCT = costoTotF - anticipoF  ;/////esta linea se agrego para ver si invirtiendo la resta se ponían correctamente los signos

	    		diferenciaCT2=Math.round(diferenciaCT)
			    diferenciaCT3= diferenciaCT2.toLocaleString("en-US", {
	        		style: "currency",
	                currency: "USD"
	    		});

	    		$("#diferencias").val(diferenciaCT3); 

	 			//////////////////calcular si la diferencia es negativa para validar el tipo de oficio DIFERENCIA / DEVOLUCIÓN / RENUNCIA
	    		if (anticipoF > costoTotF){ //Devolucion
	    		    //console.log('Devolucion'); 
	    		 	$("#diDeRe").val('2'); 
	    		 	document.getElementById("diferencias").style.borderColor="#e12454";
	    		 	$("#labelOficio").show();
	    		 	$("#foliodiDeRe").show();
	    		 	$("#labelFup").hide();

	    		}else if (anticipoF < costoTotF){ // Diferencia
	    		 	//console.log('diferencia'); 
	                $("#diDeRe").val('1'); 
	                document.getElementById("diferencias").style.borderColor="#359d31";
	                $("#labelFup").show();
	    		 	$("#foliodiDeRe").show();
	    		 	$("#labelOficio").hide();

	    		}else{////ERICK
	    		 	$("#diDeRe").val('4');///al no haber diferenia, se elige Sin diferencia en el select 
	    		 	document.getElementById("diferencias").style.borderColor="#359d31";
	                $("#labelFup").hide();
	    		 	$("#foliodiDeRe").hide();
	    		 	$("#labelOficio").hide();
	    		}
	    	});
    	}		    
    });
}

function entregaDelegacion(){
	var idFolioSiete = $("#fol").val();////desde que se busca el registro, se actualiza este dato
	var fup=$("#fup").val();
	//alert(fup);
	////primero obtenemos la fecha_recepcion de la tabla registros, para saber que tarifa usar
	var fecha_rec=''; 	var superficie_resultante='';	var anio_tarifa='0';

	$.ajax({
		url:'acceso/route.php',
		data:{acceess:106,fup:fup},/////se obtiene la fecha_recepcion y la superficieresultante
		dataType:'json',
		type:'post',
		success:function(v){
			fecha_rec=v.fecha_recepcion;
			//alert(fecha_rec);
			superficie_resultante=v.superficieresultante;

			fecha_compara=new Date('2025-03-26');///hasta el 25 de marzo se va trabajar ocn la tarifa del 2024
			fecha_recepcion_date=new Date(fecha_rec); 
			if(fecha_compara<=fecha_recepcion_date){
				anio_tarifa=2025;
			}else{
				anio_tarifa=2024;
			}

			if (v.fechanotientrega != "") {
				$("#fechaentregaDelegacion").val( moment(v.fechanotientrega).format('YYYY-MM-DD') );
			}



			$.post("acceso/route.php",{acceess:78,supInicial:superficie_resultante,anio_tarifa:anio_tarifa},function(yz){
				$(yz).each(function(key,valuee){
		    		superficie=superficie_resultante - valuee.limiteinferior;
		    		factorAplicable=superficie * valuee.factoraplicable;
		    		cuotaFija = parseFloat(valuee.cuotafija);
		    		factorAplicable2=parseFloat(factorAplicable);
		    		cuotaFija2 = factorAplicable2 + cuotaFija;
		    	});

				totalparcial=Math.round(cuotaFija2)
				totalfinal= totalparcial.toLocaleString("en-US", { style: "currency", currency: "USD" });				
				//alert(totalfinal);
				$("#costoTotal").val(totalfinal);
				    
		    });		
			//////estos valores se ponene para cuando se ha guardado, pero no terminado el proceso
			$("#superficieResultante").val(v.superficieresultante);
			//$("#costoTotal").val(v.costototal);
			$("#diferencias").val(v.diferencia);
			$("#diDeRe").val(v.tipooficio);
			$("#foliodiDeRe").val(v.recibofup);

			///erick, este es tu yo del futuro, aqui obtienes el valor de las observaciuones agregadas
			$("#obs_proceso6").val(v.obs_proceso6); 

			tipoNodeOficio();////ERICK, este es tu yo del pasado, aquí llamaste este método que ya estaba creado para que se eligieran solos los campos de acuerdo a la opción del select

			////se agrega para que al cargar la info se realice el proceso de calcular costo tototal
			CalcularCostoTotal(anio_tarifa);
		}
	});	

	// $.post("acceso/route.php",{acceess:71,idFolioSiete:idFolioSiete},function(yz){ ////de qui ahora solo obtenemos la superficie resultante

	// 	if ( yz != "100") {
	// 		$(yz).each(function(key,valuee){

	// 			if (valuee.fechanotientrega != "") {////
	// 				$("#fechaentregaDelegacion").val( moment(valuee.fechanotientrega).format('YYYY-MM-DD') );
	// 			}
				
	// 			$("#superficieResultante").val(valuee.superficieresultante);
	// 			$("#costoTotal").val(valuee.costototal);
	// 			$("#diferencias").val(valuee.diferencia);
	// 			$("#diDeRe").val(valuee.tipooficio);
	// 			$("#foliodiDeRe").val(valuee.recibofup);

	// 			///erick, este es tu yo del futuro, aqui obtienes el valor de las observaciuones agregadas
	// 			$("#obs_proceso6").val(valuee.obs_proceso6); 

	// 			tipoNodeOficio();////ERICK, este es tu yo del pasado, aquí llamaste este método que ya estaba creado para que se eligieran solos los campos de acuerdo a la opción del select

	// 			////se agrega para que al cargar la info se realice el proceso de calcular costo tototal
	// 			CalcularCostoTotal();
	// 		});
	// 	}
	// });
 }
// function entregaDelegacion(){
// 	var idFolioSiete = $("#fol").val();////desde que se busca el registro, se actualiza este dato
// 	var fup=$("#fup").val();
// 	////primero obtenemos la fecha_recepcion de la tabla registros, para saber que tarifa usar
// 	var fecha_rec=''; 	var superficie_resultante='';	var anio_tarifa='0';

// 	$.ajax({
// 		url:'acceso/route.php',
// 		data:{acceess:106,fup:fup},/////se obtiene la fecha_recepcion para saber con que año de la tarifa se trabaja
// 		dataType:'json',
// 		type:'post',
// 		success:function(v){
// 			fecha_rec=v.fecha_recepcion;

// 			fecha_compara=new Date('2025-03-26');///hasta el 25 de marzo se va trabajar ocn la tarifa del 2024 
// 			fecha_recepcion_date=new Date(fecha_rec); 
// 			if(fecha_compara<=fecha_recepcion_date){
// 				//alert('Se trabaja con tarifa del 2024');
// 				anio_tarifa=2025;
// 			}else{
// 				//alert('se ocupan valores del 2024');
// 				anio_tarifa=2024;
// 			}
// 			$("#anio_tarifa").val(anio_tarifa);			

// 			////get_info_procesotres ---- se busca si ya existe superficie resultante, para calcular el costo total
// 			$.ajax({
// 				url:'acceso/route.php',
// 				data:{acceess:108,fup:fup},/////se obtiene la fecha_recepcion y la superficieresultante
// 				dataType:'json',
// 				type:'post',
// 				success:function(w){
// 					//alert(w);
// 					if(w==false){
// 						//alert('No se ha guardado la superficie resultante');
// 						////se abre el modal, pero sin valores
// 					}else{
// 						//alert('Aquí se ejecuta el calculo del costo total');
// 						superficie_resultante=w.superficieresultante;

// 						////este ajax calcula el costo total, dependiendo de la superficie resultante
// 						$.post("acceso/route.php",{acceess:78,supInicial:superficie_resultante,anio_tarifa:anio_tarifa},function(yz){
// 							$(yz).each(function(key,valuee){
// 								superficie=superficie_resultante - valuee.limiteinferior;
// 								factorAplicable=superficie * valuee.factoraplicable;
// 								cuotaFija = parseFloat(valuee.cuotafija);
// 								factorAplicable2=parseFloat(factorAplicable);
// 								cuotaFija2 = factorAplicable2 + cuotaFija;
// 							});

// 							totalparcial=Math.round(cuotaFija2)
// 							totalfinal= totalparcial.toLocaleString("en-US", { style: "currency", currency: "USD" });				
// 							//alert(totalfinal);
// 							$("#costoTotal").val(totalfinal);

// 							$("#fechaentregaDelegacion").val( moment(w.fechanotientrega).format('YYYY-MM-DD') );
// 							//////estos valores se ponene para cuando se ha guardado, pero no terminado el proceso
// 							$("#superficieResultante").val(superficie_resultante);
// 							$("#diferencias").val(w.diferencia);
// 							$("#diDeRe").val(w.tipooficio);
// 							$("#foliodiDeRe").val(w.recibofup);
// 							///erick, este es tu yo del futuro, aqui obtienes el valor de las observaciuones agregadas
// 							$("#obs_proceso6").val(w.obs_proceso6); 

// 							tipoNodeOficio();////ERICK, este es tu yo del pasado, aquí llamaste este método que ya estaba creado para que se eligieran solos los campos de acuerdo a la opción del select

// 							////se agrega para que al cargar la info se realice el proceso de calcular costo tototal
// 							CalcularCostoTotal(anio_tarifa);
								
// 						});	
// 					}
// 				}
// 			});	
// 		}
// 	});	


// 	// $.post("acceso/route.php",{acceess:71,idFolioSiete:idFolioSiete},function(yz){ ////de qui ahora solo obtenemos la superficie resultante

// 	// 	if ( yz != "100") {
// 	// 		$(yz).each(function(key,valuee){

// 	// 			if (valuee.fechanotientrega != "") {////
// 	// 				$("#fechaentregaDelegacion").val( moment(valuee.fechanotientrega).format('YYYY-MM-DD') );
// 	// 			}
				
// 	// 			$("#superficieResultante").val(valuee.superficieresultante);
// 	// 			$("#costoTotal").val(valuee.costototal);
// 	// 			$("#diferencias").val(valuee.diferencia);
// 	// 			$("#diDeRe").val(valuee.tipooficio);
// 	// 			$("#foliodiDeRe").val(valuee.recibofup);

// 	// 			///erick, este es tu yo del futuro, aqui obtienes el valor de las observaciuones agregadas
// 	// 			$("#obs_proceso6").val(valuee.obs_proceso6); 

// 	// 			tipoNodeOficio();////ERICK, este es tu yo del pasado, aquí llamaste este método que ya estaba creado para que se eligieran solos los campos de acuerdo a la opción del select

// 	// 			////se agrega para que al cargar la info se realice el proceso de calcular costo tototal
// 	// 			CalcularCostoTotal();
// 	// 		});
// 	// 	}
// 	// });
// }

function actualizarProcesoSiete(){

	var fechaEntregaDelegacion = $("#fechaentregaDelegacion").val(); 
	var superficieResultante = $("#superficieResultante").val();
	var diDeRe = $("#diDeRe").val();
	var foliodiDeRe = $("#foliodiDeRe").val();
	var idFolioSiete = $("#fol").val();

	var obs_proceso6=$("#obs_proceso6").val();

	var costoTotal = $("#costoTotal").val();
	if (costoTotal!="") {
		costoTotal = costoTotal.replace('$', '');
		costoTotal = costoTotal.replace(',', '');
	}
    /////////////////////////////diferencia que quede sin signo de pesos y sin la coma///////////////////////////////////////
	var diferencias = $("#diferencias").val();
	if (diferencias!="") {
		diferencias = diferencias.replace('$', '');
		diferencias = diferencias.replace(',', '');
	}

	if (diDeRe == null || diDeRe == "") {
		diDeRe=0;
	}

	if(fechaEntregaDelegacion==""){
		$("#titulo_modal_ad").html('Registro faltante');
		$("#mensaje_modal_ad").html('Para continuar con el proceso es necesario seleccionar la fecha de entrega a la delegación');
		$("#modal_mensaje_ad").modal('show');
	}else{
		if(superficieResultante=="" || superficieResultante=='0'){
			$("#titulo_modal_ad").html('Registro faltante');
			$("#mensaje_modal_ad").html('Para continuar con el proceso es necesario ingresar la superficie final');
			$("#modal_mensaje_ad").modal('show');
		}else{
			if(costoTotal=='$NaN' || costoTotal=='NaN' || costoTotal==null){
				$("#titulo_modal_ad").html('Registro faltante');
				$("#mensaje_modal_ad").html('Para continuar con el proceso ingrese una superficie final correcta');
				$("#modal_mensaje_ad").modal('show');
			}else{
				//alert('aqui');
				$.post("acceso/route.php",{acceess:72,fechaEntregaDelegacion:fechaEntregaDelegacion,superficieResultante:superficieResultante,costoTotal:costoTotal,diferencias:diferencias,diDeRe:diDeRe,foliodiDeRe:foliodiDeRe,idFolioSiete:idFolioSiete, obs_proceso6:obs_proceso6},function(yz){
			 		if (yz == 100 || yz == "100") {
			 			//registro correcto
			 			$(".proceso_n").hide();
		 				$("#procesoSeisInfo").modal('hide');

			 			$("#titulo_modal_ok").html('Registro correcto');
						$("#mensaje_modal_ok").html('Información guardada correctamente');
						$("#modal_mensaje_ok").modal('show');
			 		}
			 	});
			}	
		}
	}
} 

function terminarProcesoSiete(){ 
	var fechaEntregaDelegacion = $("#fechaentregaDelegacion").val(); //*
	var superficieResultante = $("#superficieResultante").val();//*
	var diDeRe = $("#diDeRe").val();//*
	var foliodiDeRe = $("#foliodiDeRe").val();
	var idFolioSiete = $("#fol").val();

	var obs_proceso6 = $("#obs_proceso6").val();

	var costoTotal = $("#costoTotal").val();
	if (costoTotal!="") {
		costoTotal = costoTotal.replace('$', '');
		costoTotal = costoTotal.replace(',', '');
	}	
	/////////////////////////////diferencia que quede sin signo de pesos y sin la coma///////////////////////////////////////
	var diferencias = $("#diferencias").val();
	if (diferencias!="") {
		diferencias = diferencias.replace('$', '');
		diferencias = diferencias.replace(',', '');
	}
	
	if(fechaEntregaDelegacion==""){
		$("#titulo_modal_ad").html('Registro faltante');
		$("#mensaje_modal_ad").html('Para continuar con el proceso es necesario seleccionar la fecha de entrega a la delegación');
		$("#modal_mensaje_ad").modal('show');
	}else{
		if(superficieResultante=="" || superficieResultante=='0'){
			$("#titulo_modal_ad").html('Registro faltante');
			$("#mensaje_modal_ad").html('Para continuar con el proceso es necesario ingresar la superficie final');
			$("#modal_mensaje_ad").modal('show');
		}else{
			if(costoTotal=='$NaN' || costoTotal=='NaN' || costoTotal==null){
				$("#titulo_modal_ad").html('Registro faltante');
				$("#mensaje_modal_ad").html('Para continuar con el proceso ingrese una superficie final correcta');
				$("#modal_mensaje_ad").modal('show');
			}else{
				$.post("acceso/route.php",{acceess:70,fechaEntregaDelegacion:fechaEntregaDelegacion,superficieResultante:superficieResultante,costoTotal:costoTotal,diferencias:diferencias,diDeRe:diDeRe,foliodiDeRe:foliodiDeRe,idFolioSiete:idFolioSiete, obs_proceso6:obs_proceso6 },function(yz){

			 		if (yz == 100 || yz == "100") {
			 			$(".proceso_n").hide();
		 				$("#procesoSeisInfo").modal('hide');

			 			$("#titulo_modal_ok").html('Registro correcto');
						$("#mensaje_modal_ok").html('Información guardada correctamente');
						$("#modal_mensaje_ok").modal('show');
			 		}
				});
			}	
		}
	}
}

function actualizarProcesoOcho(){

	var fechaNotiConcluido = $("#fechaNotiConcluido").val();
	var fechaEntregaSolicitante = $("#fechaEntregaSolicitante").val(); 
	var idRegistroUnico = $("#fol").val();
	var observaciones_entrega=$("#observaciones_entrega_cliente").val();

	if(fechaNotiConcluido==""){fechaNotiConcluido=null;}
	if(fechaEntregaSolicitante==""){fechaEntregaSolicitante=null;}
	//alert(idRegistroUnico);

	/////las fechas pueden ir vacias igual que las observaciones, ya que no va terminar el proceso
	////////////////////////////////////////////////////////////////////////////////////////////////
	$.post("acceso/route.php",{acceess:69,fechaNotiConcluido:fechaNotiConcluido,fechaEntregaSolicitante:fechaEntregaSolicitante,idRegistroUnico:idRegistroUnico, observaciones_entrega:observaciones_entrega},function(yz){
 		if (yz == 100 || yz == "100") {
 			//alert(yz);
 			//registro correcto
 			$("#procesoSieteInfo").modal('hide'); 

 			$(".proceso_n").hide();

 			$("#titulo_modal_ok").html('Registro correcto');
			$("#mensaje_modal_ok").html('Información guardada correctamente');
			$("#modal_mensaje_ok").modal('show');
 		}
	});
} 

function entregaSolicitante(){		
	//var idFolioSiete = $("#idRegistro7").val();
	var idFolioSiete = $("#fol").val();

	$.post("acceso/route.php",{acceess:71,idFolioSiete:idFolioSiete},function(yz){ 

		if ( yz != "100") {
			$(yz).each(function(key,valuee){
				if(valuee.fechanotificacionconcluido!="" || valuee.fechanotificacionconcluido!=null){
					$("#fechaNotiConcluido").val( moment(valuee.fechanotificacionconcluido).format('YYYY-MM-DD') );
				}

				if(valuee.fechaentregasol!="" || valuee.fechaentregasol!=null){
					$("#fechaEntregaSolicitante").val( moment(valuee.fechaentregasol).format('YYYY-MM-DD') );
				}

				$("#observaciones_entrega_cliente").val(valuee.observaciones_entrega_cliente);
			});
		}
	});
}

function terminarProcesoOcho(){

	var fechaNotiConcluido = $("#fechaNotiConcluido").val(); 
	var fechaEntregaSolicitante = $("#fechaEntregaSolicitante").val(); 
	var idRegistroUnico = $("#fol").val();
	var observaciones_entrega=$("#observaciones_entrega_cliente").val();

	if(fechaNotiConcluido==""){///mensaje de advertencia
		$("#titulo_modal_ad").html('Registro faltante');
		$("#mensaje_modal_ad").html('Para continuar con el proceso es necesario seleccionar la fecha de notificación de servicio concluido');
		$("#modal_mensaje_ad").modal('show');
	}else{
		if(fechaEntregaSolicitante==""){
			$("#titulo_modal_ad").html('Registro faltante');
			$("#mensaje_modal_ad").html('Para continuar con el proceso es necesario seleccionar la fecha de entrega de servicio al solicitante');
			$("#modal_mensaje_ad").modal('show');
		}else{
			$.post("acceso/route.php",{acceess:68,fechaNotiConcluido:fechaNotiConcluido,fechaEntregaSolicitante:fechaEntregaSolicitante,idRegistroUnico:idRegistroUnico,observaciones_entrega:observaciones_entrega},function(yz){

		 		if (yz == 100 || yz == "100") {
		 			//registro correcto
		 			$("#procesoSieteInfo").modal('hide'); 

	 		 		$(".proceso_n").hide();

	 				$("#titulo_modal_ok").html('Registro correcto');
					$("#mensaje_modal_ok").html('Información guardada correctamente');
					$("#modal_mensaje_ok").modal('show');
		 		}
		 	});
		}
	}
} 

function actualizarProCerrado(){

	var fechaResguardo = $("#fechaResguardo").val(); 
	var fechaResguardo2 = $("#fechaResguardo2").val(); 
	var fechaResguardo3 = "";
	var oficioResguardoGeo = $("#oficioResguardoGeo").val(); 
	var observacionesC = $("#observacionesC").val(); 
	var idRegistroUnico = $("#idRegistro8").val();

	if(fechaResguardo == null && fechaResguardo2 != null || fechaResguardo == "" && fechaResguardo2 != ""){
		fechaResguardo3 = fechaResguardo2;

	}else if(fechaResguardo != null && fechaResguardo2 == null || fechaResguardo != "" && fechaResguardo2 == ""){
		fechaResguardo3 = fechaResguardo;
	}else{
		fechaResguardo3 = '1999-01-01 00:00:00-06';
	}
	////////////////////////////////////////////////////////////////////////////////////////////////

	 $.post("acceso/route.php",{acceess:67,fechaResguardo3:fechaResguardo3,
	 	oficioResguardoGeo:oficioResguardoGeo,observacionesC:observacionesC,idRegistroUnico:idRegistroUnico},function(yz){

	 		if (yz == 100 || yz == "100") {
	 			//registro correcto
	 			$("#procesoOchoInfo").modal('hide'); 
	 			$("#registroBien").modal('show');  
	 		}else if(yz == 10 || yz == "10"){
	 			//el folio no esta registrado.
	 			$("#registroSinProesoAnterior").modal('show'); 

	 		}else{
	 			//existio algun error
	 		}
	 });
} 

function mostrarProcesoOcho(){///al abrir el modal, carga información si existe		
	var idFolioSiete = $("#fol").val();///viene del propio modal
	//alert(idFolioSiete);
	$.post("acceso/route.php",{acceess:66,idFolioSiete:idFolioSiete},function(yz){ 
		//alert(yz);
		if (yz!= "100") {
			$(yz).each(function(key,valuee){

				if(valuee.fechaderesguardo!=""){
					$("#fechaResguardo").val( moment(valuee.fechaderesguardo).format('YYYY-MM-DD') );
				}
				$("#oficioResguardoGeo").val(valuee.folioderesguardo);
				$("#observacionesC").val(valuee.observaciones);
			});
		}
	});
} 

function terminarProCerrado(){

	var fechaResguardo = $("#fechaResguardo").val(); 
	var oficioResguardoGeo = $("#oficioResguardoGeo").val(); 
	var observacionesC = $("#observacionesC").val(); 
	var idRegistroUnico = $("#fol").val();

	if(fechaResguardo==""){
		$("#titulo_modal_ad").html('Registro faltante');
		$("#mensaje_modal_ad").html('Para continuar con el proceso es necesario seleccionar la fecha de resguardo del servicio concluido');
		$("#modal_mensaje_ad").modal('show');
	}else{
		if(oficioResguardoGeo==""){
			$("#titulo_modal_ad").html('Registro faltante');
			$("#mensaje_modal_ad").html('Para continuar con el proceso es necesario ingresar no. de oficio del resguardo');
			$("#modal_mensaje_ad").modal('show');
		}else{
			///se guarda
			$.post("acceso/route.php",{acceess:65,fechaResguardo:fechaResguardo,oficioResguardoGeo:oficioResguardoGeo,observacionesC:observacionesC,idRegistroUnico:idRegistroUnico},function(yz){

		 		if (yz == 100 || yz == "100") {
		 			//registro correcto
		 			$("#procesoOchoInfo").modal('hide'); 
		 			//$("#procesoTerminadoFin").modal('show');  
		 			$(".proceso_n").hide();

		 			$("#titulo_modal_ok").html('Registro correcto');
					$("#mensaje_modal_ok").html('Levantamiento topográfico terminado');
					$("#modal_mensaje_ok").modal('show');
		 		}
		 	});
		}
	}
} 

function mostrarStatusAll(id){
	var x = document.getElementById(id);
	if (x.style.display === "none") {
		x.style.display = "block";
	} else {
		x.style.display = "none";
	}
}

function anioSelect(){	
	var fechaa = $("#fecha").val();
	var anio = fechaa.split("-", 1);
	$("#ani").val( anio.toString().substring(2) );
	console.log(anio); 
}

function tipoNodeOficio(){
	var tip = $("#diDeRe").val();

	if (tip == 1) {
		$("#labelFup").show();
		$("#foliodiDeRe").show();
		$("#labelOficio").hide();

	}else if (tip == 2) {
		$("#labelFup").hide();
		$("#labelOficio").show();
		$("#foliodiDeRe").show();

	}else if (tip == 3) {
		$("#labelFup").hide();
		$("#labelOficio").show();
		$("#foliodiDeRe").show();
	}
	else if (tip == 4) {
		$("#labelFup").hide();
		$("#labelOficio").hide();
		$("#foliodiDeRe").hide();
	}
}

function verLaEtapa(fol){
	
	var folioRegistro=fol;
	var etapa = $("#procesoActual"+folioRegistro+"").val();
	var canceladoPro = $("#canceladoPro"+folioRegistro+"").val();
	var idDeInfo = "verLEtapa"+fol;
	var idDeInfo2 = "verLEtapa2"+fol;
	var idDeInfo3 = "verLEtapa3"+fol;
	var idDeInfo4 = "verLEtapa4"+fol;
	var idDeInfo5 = "verLEtapa5"+fol;
	var idDeInfo6 = "verLEtapa6"+fol;
	var idDeInfo7 = "verLEtapa7"+fol;
	var idDeInfo8 = "verLEtapa8"+fol;
	var idDeInfo9 = "verLEtapa9"+fol;
	var x = document.getElementById(idDeInfo);
	var dos = document.getElementById(idDeInfo2);
	var tres = document.getElementById(idDeInfo3);
	var cuatro = document.getElementById(idDeInfo4);
	var cinco = document.getElementById(idDeInfo5);
	var seis = document.getElementById(idDeInfo6);
	var siete = document.getElementById(idDeInfo7);
	var ocho = document.getElementById(idDeInfo8);
	var nueve = document.getElementById(idDeInfo9);

	//alert(canceladoPro);

	if (etapa == 1) {

		if(x.style.display === "none") {
    	x.style.display = "block";
    	//abrir todos 
  		}else{
  		//cerrar todos
    	x.style.display = "none";
  		}

	}else if (etapa == 2) {
		///////////////////////////////////////////ETAPA 2//////////////////////////////////////////////////////////////
		$.post("acceso/route.php",{acceess:94,folioRegistro:folioRegistro},function(yz){ 

  			$(yz).each(function(key,valuee){ 
  				$("#ordenTrabjo"+folioRegistro+"").val(valuee.ordentrabajo); //agregar el folioRegistro
  				//$("#numm"+con+"").val();
  				//$("#fechaEnviaAreaTop"+folioRegistro+"").val(valuee.fechaenvio);
  				$("#fechaEnviaAreaTop"+folioRegistro+"").val( moment(valuee.fechaenvio).format('DD-MM-YYYY') );

  				$("#areaTopogra"+folioRegistro+"").val(valuee.areaproduc); 
  				//$("#fechaCancelacion2").val();

  			});

	 	}); 

	 	if (canceladoPro == 2 || canceladoPro == 0) {
	 		$("#CanceladoLevantamientoTop"+folioRegistro+"").hide();
	 		$("#CanceladoLevantamientoTop2"+folioRegistro+"").hide();
	 		
	 	}


		if(x.style.display === "none") {
    	x.style.display = "block";
    	dos.style.display = "block";
    	//abrir todos 
  		}else{
  		//cerrar todos
    	x.style.display = "none";
    	dos.style.display = "none";
  		}



	}else if (etapa == 3) {


		///////////////////////////////////////////ETAPA 2 y 3//////////////////////////////////////////////////////////////
		$.post("acceso/route.php",{acceess:94,folioRegistro:folioRegistro},function(yz){ 

  			$(yz).each(function(key,valuee){ 
  				$("#ordenTrabjo"+folioRegistro+"").val(valuee.ordentrabajo); //agregar el folioRegistro
  				//$("#numm"+con+"").val();
  				//$("#fechaEnviaAreaTop"+folioRegistro+"").val(valuee.fechaenvio);
  				$("#fechaEnviaAreaTop"+folioRegistro+"").val( moment(valuee.fechaenvio).format('DD-MM-YYYY') );

  				$("#areaTopogra"+folioRegistro+"").val(valuee.areaproduc); 
  				//$("#fechaCancelacion2").val();

  				//$("#fechaNotiColindante"+folioRegistro+"").val(valuee.fechanotificacion);///linea original 
  				$("#fechaNotiColindante"+folioRegistro+"").val(moment(valuee.fechanotificacion).format('DD-MM-YYYY') );

  			});

	 	}); 

		if (canceladoPro == 3 || canceladoPro == 0) {
	 		$("#CanceladoLevantamientoTop"+folioRegistro+"").hide();
	 		$("#CanceladoLevantamientoTop2"+folioRegistro+"").hide();
	 		$("#CanceladoLevantamientoTop3"+folioRegistro+"").hide();
	 	}

		if(x.style.display === "none") {
    	x.style.display = "block";
    	dos.style.display = "block";
    	tres.style.display = "block";
    	//abrir todos 
  		}else{
  		//cerrar todos
    	x.style.display = "none";
    	dos.style.display = "none";
    	tres.style.display = "none";
  		}

	}else if (etapa == 4) {


		///////////////////////////////////////////ETAPA 2, 3 y 4//////////////////////////////////////////////////////////////
		$.post("acceso/route.php",{acceess:94,folioRegistro:folioRegistro},function(yz){ 

  			$(yz).each(function(key,valuee){ 
  				$("#ordenTrabjo"+folioRegistro+"").val(valuee.ordentrabajo); //agregar el folioRegistro
  				//$("#numm"+con+"").val();
  				//$("#fechaEnviaAreaTop"+folioRegistro+"").val(valuee.fechaenvio);
  				$("#fechaEnviaAreaTop"+folioRegistro+"").val( moment(valuee.fechaenvio).format('DD-MM-YYYY') );

  				$("#areaTopogra"+folioRegistro+"").val(valuee.areaproduc); 
  				//$("#fechaCancelacion2").val();

  				//$("#fechaNotiColindante"+folioRegistro+"").val(valuee.fechanotificacion); 
  				$("#fechaNotiColindante"+folioRegistro+"").val(moment(valuee.fechanotificacion).format('DD-MM-YYYY') );

  				//$("#fechaLevanRealizado"+folioRegistro+"").val(valuee.fechalevantamiento);
  				$("#fechaLevanRealizado"+folioRegistro+"").val(moment(valuee.fechalevantamiento).format('DD-MM-YYYY') ); 
  				$("#folioGeoo"+folioRegistro+"").val(valuee.foliogeo); 

  			});

	 	}); 

       ////////////////////////////////////////////////ETAPA /////////////////////////////////////////////////////
	 	/*$.post("acceso/route.php",{acceess:91,folioRegistro:folioRegistro},function(yz){ 

  			$(yz).each(function(key,valuee){ 
  				$("#fechaNotiColindante"+folioRegistro+"").val(valuee.fechanotientrega);

  				$("#fechaLevanRealizado"+folioRegistro+"").val(valuee.fechanotientrega);
  				$("#folioGeoo"+folioRegistro+"").val(valuee.fechanotientrega);
  				//$("#numm"+con+"").val();

  			});

	 	});*/

	 	if (canceladoPro == 4 || canceladoPro == 0) {
	 		$("#CanceladoLevantamientoTop"+folioRegistro+"").hide();
	 		$("#CanceladoLevantamientoTop2"+folioRegistro+"").hide();
	 		$("#CanceladoLevantamientoTop3"+folioRegistro+"").hide();
	 		$("#CanceladoLevantamientoTop4"+folioRegistro+"").hide();
	 	}

		if(x.style.display === "none") {
    	x.style.display = "block";
    	dos.style.display = "block";
    	tres.style.display = "block";
    	cuatro.style.display = "block";
    	//abrir todos 
  		}else{
  		//cerrar todos
    	x.style.display = "none";
    	dos.style.display = "none";
    	tres.style.display = "none";
    	cuatro.style.display = "none";
  		}

	}else if (etapa == 5) {

		///////////////////////////////////////////ETAPA 2, 3 , 4 y 5//////////////////////////////////////////////////////////////
		$.post("acceso/route.php",{acceess:94,folioRegistro:folioRegistro},function(yz){ 

  			$(yz).each(function(key,valuee){ 
  				$("#ordenTrabjo"+folioRegistro+"").val(valuee.ordentrabajo); //agregar el folioRegistro
  				//$("#numm"+con+"").val();
  				//$("#fechaEnviaAreaTop"+folioRegistro+"").val(valuee.fechaenvio);
  				$("#fechaEnviaAreaTop"+folioRegistro+"").val( moment(valuee.fechaenvio).format('DD-MM-YYYY') );

  				$("#areaTopogra"+folioRegistro+"").val(valuee.areaproduc); 
  				//$("#fechaCancelacion2").val();

  				//$("#fechaNotiColindante"+folioRegistro+"").val(valuee.fechanotificacion); 
  				$("#fechaNotiColindante"+folioRegistro+"").val(moment(valuee.fechanotificacion).format('DD-MM-YYYY') );

  				//$("#fechaLevanRealizado"+folioRegistro+"").val(valuee.fechalevantamiento); 
  				$("#fechaLevanRealizado"+folioRegistro+"").val(moment(valuee.fechalevantamiento).format('DD-MM-YYYY') ); 

  				$("#folioGeoo"+folioRegistro+"").val(valuee.foliogeo); 

  				//$("#fechaEnvioDirGeo"+folioRegistro+"").val(valuee.fechatermino);
  				$("#fechaEnvioDirGeo"+folioRegistro+"").val(moment(valuee.fechatermino).format('DD-MM-YYYY') ); 

  			});

	 	}); 

	 	if (canceladoPro == 0) {
	 		$("#CanceladoLevantamientoTop"+folioRegistro+"").hide();
	 		$("#CanceladoLevantamientoTop2"+folioRegistro+"").hide();
	 		$("#CanceladoLevantamientoTop3"+folioRegistro+"").hide();
	 		$("#CanceladoLevantamientoTop4"+folioRegistro+"").hide();
	 	}	

		if(x.style.display === "none") {
    	x.style.display = "block";
    	dos.style.display = "block";
    	tres.style.display = "block";
    	cuatro.style.display = "block";
    	cinco.style.display = "block";
    	//abrir todos 
  		}else{
  		//cerrar todos
    	x.style.display = "none";
    	dos.style.display = "none";
    	tres.style.display = "none";
    	cuatro.style.display = "none";
    	cinco.style.display = "none";
  		}

	}else if (etapa == 6) {


		///////////////////////////////////////////ETAPA 2, 3 , 4 , 5 y 6//////////////////////////////////////////////////////////////
		$.post("acceso/route.php",{acceess:94,folioRegistro:folioRegistro},function(yz){ 

  			$(yz).each(function(key,valuee){ 
  				$("#ordenTrabjo"+folioRegistro+"").val(valuee.ordentrabajo); //agregar el folioRegistro
  				//$("#numm"+con+"").val();
  				//$("#fechaEnviaAreaTop"+folioRegistro+"").val(valuee.fechaenvio);
  				$("#fechaEnviaAreaTop"+folioRegistro+"").val( moment(valuee.fechaenvio).format('DD-MM-YYYY') );

  				$("#areaTopogra"+folioRegistro+"").val(valuee.areaproduc); 
  				//$("#fechaCancelacion2").val();

  				//$("#fechaNotiColindante"+folioRegistro+"").val(valuee.fechanotificacion); 
  				$("#fechaNotiColindante"+folioRegistro+"").val(moment(valuee.fechanotificacion).format('DD-MM-YYYY') );

  				//$("#fechaLevanRealizado"+folioRegistro+"").val(valuee.fechalevantamiento); 
  				$("#fechaLevanRealizado"+folioRegistro+"").val(moment(valuee.fechalevantamiento).format('DD-MM-YYYY') ); 

  				$("#folioGeoo"+folioRegistro+"").val(valuee.foliogeo); 

  				//$("#fechaEnvioDirGeo"+folioRegistro+"").val(valuee.fechatermino); 
  				$("#fechaEnvioDirGeo"+folioRegistro+"").val(moment(valuee.fechatermino).format('DD-MM-YYYY') ); 

  				//$("#fechaRecepcionCCC"+folioRegistro+"").val(valuee.fecharecepcionccc); 
  				$("#fechaRecepcionCCC"+folioRegistro+"").val(moment(valuee.fecharecepcionccc).format('DD-MM-YYYY') );

  			});
  		});

		if (canceladoPro == 0) {
	 		$("#CanceladoLevantamientoTop"+folioRegistro+"").hide();
	 		$("#CanceladoLevantamientoTop2"+folioRegistro+"").hide();
	 		$("#CanceladoLevantamientoTop3"+folioRegistro+"").hide();
	 		$("#CanceladoLevantamientoTop4"+folioRegistro+"").hide();
	 	}

		if(x.style.display === "none") {
    	x.style.display = "block";
    	dos.style.display = "block";
    	tres.style.display = "block";
    	cuatro.style.display = "block";
    	cinco.style.display = "block";
    	seis.style.display = "block";
    	//abrir todos 
  		}else{
  		//cerrar todos
    	x.style.display = "none";
    	dos.style.display = "none";
    	tres.style.display = "none";
    	cuatro.style.display = "none";
    	cinco.style.display = "none";
    	seis.style.display = "none";
  		}

	}else if (etapa == 7) {

		///////////////////////////////////////////ETAPA 2, 3 , 4 , 5 y 6//////////////////////////////////////////////////////////////
		$.post("acceso/route.php",{acceess:94,folioRegistro:folioRegistro},function(yz){ 

  			$(yz).each(function(key,valuee){ 
  				$("#ordenTrabjo"+folioRegistro+"").val(valuee.ordentrabajo); //agregar el folioRegistro
  				//$("#numm"+con+"").val();
  				//$("#fechaEnviaAreaTop"+folioRegistro+"").val(valuee.fechaenvio);
  				$("#fechaEnviaAreaTop"+folioRegistro+"").val( moment(valuee.fechaenvio).format('DD-MM-YYYY') );

  				$("#areaTopogra"+folioRegistro+"").val(valuee.areaproduc); 
  				//$("#fechaCancelacion2").val();

  				//$("#fechaNotiColindante"+folioRegistro+"").val(valuee.fechanotificacion); 
  				$("#fechaNotiColindante"+folioRegistro+"").val(moment(valuee.fechanotificacion).format('DD-MM-YYYY') );

  				//$("#fechaLevanRealizado"+folioRegistro+"").val(valuee.fechalevantamiento); 
  				$("#fechaLevanRealizado"+folioRegistro+"").val(moment(valuee.fechalevantamiento).format('DD-MM-YYYY') ); 

  				$("#folioGeoo"+folioRegistro+"").val(valuee.foliogeo); 

  				//$("#fechaEnvioDirGeo"+folioRegistro+"").val(valuee.fechatermino); 
  				$("#fechaEnvioDirGeo"+folioRegistro+"").val(moment(valuee.fechatermino).format('DD-MM-YYYY') ); 

  				//$("#fechaRecepcionCCC"+folioRegistro+"").val(valuee.fecharecepcionccc); 
  				$("#fechaRecepcionCCC"+folioRegistro+"").val(moment(valuee.fecharecepcionccc).format('DD-MM-YYYY') );

  			});

  		}); 

  		////////////////////////////////////////////Etapa 7//////////////////////////////////////////////////////////////
  		var folioRegistro3 = folioRegistro;  
  		$.post("acceso/route.php",{acceess:91,folioRegistro3:folioRegistro3},function(yz){ 

  			$(yz).each(function(key,valuee){ 
  				$("#follOficio"+folioRegistro+"").val(valuee.recibofup); 
  			//	$("#tipoOficio"+folioRegistro+"").val(valuee.tipooficio);
  				$("#diferenciaa"+folioRegistro+"").val("$ "+valuee.diferencia); 
  				$("#costoTTotal"+folioRegistro+"").val("$ "+valuee.costototal); 
  				$("#superficieResult"+folioRegistro+"").val(valuee.superficieresultante+" M2"); 
  				//$("#fechaEntregaDelegacion"+folioRegistro+"").val(valuee.fechanotientrega); 
  				$("#fechaEntregaDelegacion"+folioRegistro+"").val( moment(valuee.fechanotientrega).format('DD-MM-YYYY') ); 


  				//$("#obs_entrega"+folioRegistro).val(valuee.observaciones_entrega_cliente);///agregado
  				$("#obs_proceso6_"+folioRegistro).val(valuee.obs_proceso6);
  				//$("#obs_proceso6_"+folioRegistro).val('ERICK');

  				if (valuee.tipooficio == 1) {
  					$("#tipoOficio"+folioRegistro+"").val('Diferencia');
  				}else if (valuee.tipooficio == 2) {
  					$("#tipoOficio"+folioRegistro+"").val('Devolución');
  				}else if (valuee.tipooficio == 3) { 
  					$("#tipoOficio"+folioRegistro+"").val('Renuncia');
  				}  

  			});

  		});

  		if (canceladoPro == 0) {
	 		$("#CanceladoLevantamientoTop"+folioRegistro+"").hide();
	 		$("#CanceladoLevantamientoTop2"+folioRegistro+"").hide();
	 		$("#CanceladoLevantamientoTop3"+folioRegistro+"").hide();
	 		$("#CanceladoLevantamientoTop4"+folioRegistro+"").hide();
	 	}

		if(x.style.display === "none") {
    	x.style.display = "block";
    	dos.style.display = "block";
    	tres.style.display = "block";
    	cuatro.style.display = "block";
    	cinco.style.display = "block";
    	seis.style.display = "block";
    	siete.style.display = "block";
    	//abrir todos 
  		}else{
  		//cerrar todos
    	x.style.display = "none";
    	dos.style.display = "none";
    	tres.style.display = "none";
    	cuatro.style.display = "none";
    	cinco.style.display = "none";
    	seis.style.display = "none";
    	siete.style.display = "none";
  		}

	}else if (etapa == 8) {

		///////////////////////////////////////////ETAPA 2, 3 , 4 , 5 y 6//////////////////////////////////////////////////////////////
		$.post("acceso/route.php",{acceess:94,folioRegistro:folioRegistro},function(yz){ 

  			$(yz).each(function(key,valuee){ 
  				$("#ordenTrabjo"+folioRegistro+"").val(valuee.ordentrabajo); //agregar el folioRegistro
  				//$("#numm"+con+"").val();
  				//$("#fechaEnviaAreaTop"+folioRegistro+"").val(valuee.fechaenvio);
  				$("#fechaEnviaAreaTop"+folioRegistro+"").val( moment(valuee.fechaenvio).format('DD-MM-YYYY') );

  				$("#areaTopogra"+folioRegistro+"").val(valuee.areaproduc); 
  				//$("#fechaCancelacion2").val();

  				//$("#fechaNotiColindante"+folioRegistro+"").val(valuee.fechanotificacion); 
  				$("#fechaNotiColindante"+folioRegistro+"").val(moment(valuee.fechanotificacion).format('DD-MM-YYYY') );

  				//$("#fechaLevanRealizado"+folioRegistro+"").val(valuee.fechalevantamiento); 
  				$("#fechaLevanRealizado"+folioRegistro+"").val(moment(valuee.fechalevantamiento).format('DD-MM-YYYY') ); 

  				$("#folioGeoo"+folioRegistro+"").val(valuee.foliogeo); 

  				//$("#fechaEnvioDirGeo"+folioRegistro+"").val(valuee.fechatermino); 
  				$("#fechaEnvioDirGeo"+folioRegistro+"").val(moment(valuee.fechatermino).format('DD-MM-YYYY') ); 

  				//$("#fechaRecepcionCCC"+folioRegistro+"").val(valuee.fecharecepcionccc); 
  				$("#fechaRecepcionCCC"+folioRegistro+"").val(moment(valuee.fecharecepcionccc).format('DD-MM-YYYY') );

  			});

  		});

  		////////////////////////////////////////////Etapa 7 y 8//////////////////////////////////////////////////////////////
  		var folioRegistro3 = folioRegistro;  
  		$.post("acceso/route.php",{acceess:91,folioRegistro3:folioRegistro3},function(yz){ 

  			$(yz).each(function(key,valuee){ 
  				$("#follOficio"+folioRegistro+"").val(valuee.recibofup); 
  				//$("#tipoOficio"+folioRegistro+"").val(valuee.tipooficio);
  				$("#diferenciaa"+folioRegistro+"").val("$ "+valuee.diferencia); 
  				$("#costoTTotal"+folioRegistro+"").val("$ "+valuee.costototal); 
  				$("#superficieResult"+folioRegistro+"").val(valuee.superficieresultante+" M2"); 
  				//$("#fechaEntregaDelegacion"+folioRegistro+"").val(valuee.fechanotientrega);
  				$("#fechaEntregaDelegacion"+folioRegistro+"").val(moment(valuee.fechanotientrega).format('DD-MM-YYYY') );

  				//$("#fechaNotiConSolicitante"+folioRegistro+"").val(valuee.fechanotificacionconcluido);
  				$("#fechaNotiConSolicitante"+folioRegistro+"").val(moment(valuee.fechanotificacionconcluido).format('DD-MM-YYYY') ); 

  				//$("#fechaEntregaServicioSol"+folioRegistro+"").val(valuee.fechaentregasol);
  				$("#fechaEntregaServicioSol"+folioRegistro+"").val(moment(valuee.fechaentregasol).format('DD-MM-YYYY') );   

  				if (valuee.tipooficio == 1) {
  					$("#tipoOficio"+folioRegistro+"").val('Diferencia');
  				}else if (valuee.tipooficio == 2) {
  					$("#tipoOficio"+folioRegistro+"").val('Devolución');
  				}else if (valuee.tipooficio == 3) { 
  					$("#tipoOficio"+folioRegistro+"").val('Renuncia');
  				} 


  				$("#obs_proceso6_"+folioRegistro).val(valuee.obs_proceso6);

  				$("#obs_entrega"+folioRegistro).val(valuee.observaciones_entrega_cliente); 



  			});

  		});

  		if (canceladoPro == 0) {
	 		$("#CanceladoLevantamientoTop"+folioRegistro+"").hide();
	 		$("#CanceladoLevantamientoTop2"+folioRegistro+"").hide();
	 		$("#CanceladoLevantamientoTop3"+folioRegistro+"").hide();
	 		$("#CanceladoLevantamientoTop4"+folioRegistro+"").hide();
	 	}

		if(x.style.display === "none") {
    	x.style.display = "block";
    	dos.style.display = "block";
    	tres.style.display = "block";
    	cuatro.style.display = "block";
    	cinco.style.display = "block";
    	seis.style.display = "block";
    	siete.style.display = "block";
    	ocho.style.display = "block";
    	//abrir todos 
  		}else{
  		//cerrar todos
    	x.style.display = "none";
    	dos.style.display = "none";
    	tres.style.display = "none";
    	cuatro.style.display = "none";
    	cinco.style.display = "none";
    	seis.style.display = "none";
    	siete.style.display = "none";
    	ocho.style.display = "none";
  		}

	}else if (etapa == 9) {

		///////////////////////////////////////////ETAPA 2, 3 , 4 , 5 y 6//////////////////////////////////////////////////////////////
		$.post("acceso/route.php",{acceess:94,folioRegistro:folioRegistro},function(yz){ 

  			$(yz).each(function(key,valuee){ 
  				$("#ordenTrabjo"+folioRegistro+"").val(valuee.ordentrabajo); //agregar el folioRegistro
  				//$("#numm"+con+"").val();
  				//$("#fechaEnviaAreaTop"+folioRegistro+"").val(valuee.fechaenvio);
  				$("#fechaEnviaAreaTop"+folioRegistro+"").val( moment(valuee.fechaenvio).format('DD-MM-YYYY') );

  				$("#areaTopogra"+folioRegistro+"").val(valuee.areaproduc); 
  				//$("#fechaCancelacion2").val();

  				//$("#fechaNotiColindante"+folioRegistro+"").val(valuee.fechanotificacion); 
  				$("#fechaNotiColindante"+folioRegistro+"").val(moment(valuee.fechanotificacion).format('DD-MM-YYYY') );

  				//$("#fechaLevanRealizado"+folioRegistro+"").val(valuee.fechalevantamiento); 
  				$("#fechaLevanRealizado"+folioRegistro+"").val(moment(valuee.fechalevantamiento).format('DD-MM-YYYY') ); 

  				$("#folioGeoo"+folioRegistro+"").val(valuee.foliogeo); 

  				//$("#fechaEnvioDirGeo"+folioRegistro+"").val(valuee.fechatermino); 
  				$("#fechaEnvioDirGeo"+folioRegistro+"").val(moment(valuee.fechatermino).format('DD-MM-YYYY') ); 

  				//$("#fechaRecepcionCCC"+folioRegistro+"").val(valuee.fecharecepcionccc); 
  				$("#fechaRecepcionCCC"+folioRegistro+"").val(moment(valuee.fecharecepcionccc).format('DD-MM-YYYY') );

  			});

  		});

  		////////////////////////////////////////////Etapa 7 y 8//////////////////////////////////////////////////////////////
  		var folioRegistro3 = folioRegistro;

  		$.post("acceso/route.php",{acceess:91,folioRegistro3:folioRegistro3},function(yz){ 

  			$(yz).each(function(key,valuee){ 
  				$("#follOficio"+folioRegistro+"").val(valuee.recibofup); 
  				
  				$("#diferenciaa"+folioRegistro+"").val("$ "+valuee.diferencia); 
  				$("#costoTTotal"+folioRegistro+"").val("$ "+valuee.costototal); 
  				$("#superficieResult"+folioRegistro+"").val(valuee.superficieresultante+" M2"); 
  				//$("#fechaEntregaDelegacion"+folioRegistro+"").val(valuee.fechanotientrega);
  				$("#fechaEntregaDelegacion"+folioRegistro+"").val(moment(valuee.fechanotientrega).format('DD-MM-YYYY') );

  				//$("#fechaNotiConSolicitante"+folioRegistro+"").val(valuee.fechanotificacionconcluido); 
  				$("#fechaNotiConSolicitante"+folioRegistro+"").val(moment(valuee.fechanotificacionconcluido).format('DD-MM-YYYY') ); 

  				//$("#fechaEntregaServicioSol"+folioRegistro+"").val(valuee.fechaentregasol);  
  				$("#fechaEntregaServicioSol"+folioRegistro+"").val(moment(valuee.fechaentregasol).format('DD-MM-YYYY') );   


  				$("#obs_proceso6_"+folioRegistro).val(valuee.obs_proceso6);

  				$("#obs_entrega"+folioRegistro).val(valuee.observaciones_entrega_cliente); 


  				

  				if (valuee.tipooficio == 1) {
  					$("#tipoOficio"+folioRegistro+"").val("Diferencia");

  				}else if (valuee.tipooficio == 2) {
  					$("#tipoOficio"+folioRegistro+"").val("Devolucion");

  				}else if (valuee.tipooficio == 3) {
  					$("#tipoOficio"+folioRegistro+"").val("Renuncia");

  				}
  			});

  		});

  		///////////////////////////////////////////Etapa 9///////////////////////////////////////////////////////////////////////////

  		var idFolioSiete = folioRegistro;
  		$.post("acceso/route.php",{acceess:66,idFolioSiete:idFolioSiete},function(yz){ 

  			$(yz).each(function(key,valuee){ 
  				//$("#fechaResguardo"+folioRegistro+"").val(valuee.fechaderesguardo);
  				$("#fechaResguardo"+folioRegistro+"").val(moment(valuee.fechaderesguardo).format('DD-MM-YYYY') );

  				$("#noOficioResguardo"+folioRegistro+"").val(valuee.folioderesguardo);
  				$("#observacioness"+folioRegistro+"").val(valuee.observaciones);   
  				
  			});

  		});

  		if (canceladoPro == 0) {
	 		$("#CanceladoLevantamientoTop"+folioRegistro+"").hide();
	 		$("#CanceladoLevantamientoTop2"+folioRegistro+"").hide();
	 		$("#CanceladoLevantamientoTop3"+folioRegistro+"").hide();
	 		$("#CanceladoLevantamientoTop4"+folioRegistro+"").hide();
	 	}

		if(x.style.display === "none") {
    	x.style.display = "block";
    	dos.style.display = "block";
    	tres.style.display = "block";
    	cuatro.style.display = "block";
    	cinco.style.display = "block";
    	seis.style.display = "block";
    	siete.style.display = "block";
    	ocho.style.display = "block";
    	nueve.style.display = "block";
    	//abrir todos 
  		}else{
  		//cerrar todos
    	x.style.display = "none";
    	dos.style.display = "none";
    	tres.style.display = "none";
    	cuatro.style.display = "none";
    	cinco.style.display = "none";
    	seis.style.display = "none";
    	siete.style.display = "none";
    	ocho.style.display = "none";
    	nueve.style.display = "none";
  		}

	}

} 
/*function verLaEtapa2(fol){
	var idDeInfo = "verLEtapa2"+fol;
	var x = document.getElementById(idDeInfo);
  if (x.style.display === "none") {
    x.style.display = "block";
  } else {
    x.style.display = "none";
  }
}*/
 ///////////////////////////////////////////////////////////////////////////////////////////////////////
 /**********************************************/
 ////////////////////////////////////////////////////////

(function ($) {
		'use strict';

	// navbarDropdown
	if ($(window).width() < 992) {
		$('.navigation .dropdown-toggle').on('click', function () {
			$(this).siblings('.dropdown-menu').animate({
				height: 'toggle'
			}, 300);
		});
  }

	// scroll to top button
	$(window).on('scroll', function () {
		if ($(window).scrollTop() > 70) {
			$('.backtop').addClass('reveal');
		} else {
			$('.backtop').removeClass('reveal');
		}
	});
	// scroll-to-top
  $('.scroll-top-to').on('click', function () {
    $('body,html').animate({
      scrollTop: 0
    }, 500);
    return false;
  });

	$('.portfolio-single-slider').slick({
		infinite: true,
		arrows: false,
		autoplay: true,
		autoplaySpeed: 2000
	});

	$('.clients-logo').slick({
		infinite: true,
		arrows: false,
		autoplay: true,
		slidesToShow: 6,
		slidesToScroll: 6,
		autoplaySpeed: 6000,
		responsive: [{
				breakpoint: 1024,
				settings: {
					slidesToShow: 6,
					slidesToScroll: 6,
					infinite: true,
					dots: true
				}
			},
			{
				breakpoint: 900,
				settings: {
					slidesToShow: 4,
					slidesToScroll: 4
				}
			}, {
				breakpoint: 600,
				settings: {
					slidesToShow: 4,
					slidesToScroll: 4
				}
			},
			{
				breakpoint: 480,
				settings: {
					slidesToShow: 2,
					slidesToScroll: 2
				}
			}

		]
	});

	$('.testimonial-wrap').slick({
		slidesToShow: 1,
		slidesToScroll: 1,
		infinite: true,
		dots: true,
		arrows: false,
		autoplay: true,
		vertical: true,
		verticalSwiping: true,
		autoplaySpeed: 6000,
		responsive: [{
				breakpoint: 1024,
				settings: {
					slidesToShow: 1,
					slidesToScroll: 1,
					infinite: true,
					dots: true
				}
			},
			{
				breakpoint: 900,
				settings: {
					slidesToShow: 1,
					slidesToScroll: 1
				}
			}, {
				breakpoint: 600,
				settings: {
					slidesToShow: 1,
					slidesToScroll: 1
				}
			},
			{
				breakpoint: 480,
				settings: {
					slidesToShow: 1,
					slidesToScroll: 1
				}
			}

		]
	});

	$('.testimonial-wrap-2').slick({
		slidesToShow: 2,
		slidesToScroll: 2,
		infinite: true,
		dots: true,
		arrows: false,
		autoplay: true,
		autoplaySpeed: 6000,
		responsive: [{
				breakpoint: 1024,
				settings: {
					slidesToShow: 2,
					slidesToScroll: 2,
					infinite: true,
					dots: true
				}
			},
			{
				breakpoint: 900,
				settings: {
					slidesToShow: 1,
					slidesToScroll: 1
				}
			}, {
				breakpoint: 600,
				settings: {
					slidesToShow: 1,
					slidesToScroll: 1
				}
			},
			{
				breakpoint: 480,
				settings: {
					slidesToShow: 1,
					slidesToScroll: 1
				}
			}

		]
	});


	// counter
	function counter() {
		var oTop;
		if ($('.counter').length !== 0) {
			oTop = $('.counter').offset().top - window.innerHeight;
		}
		if ($(window).scrollTop() > oTop) {
			$('.counter').each(function () {
				var $this = $(this),
					countTo = $this.attr('data-count');
				$({
					countNum: $this.text()
				}).animate({
					countNum: countTo
				}, {
					duration: 500,
					easing: 'swing',
					step: function () {
						$this.text(Math.floor(this.countNum));
					},
					complete: function () {
						$this.text(this.countNum);
					}
				});
			});
		}
  }
  $(window).on('scroll', function () {
		counter();
	});


	// Shuffle js filter and masonry
	if ($('.shuffle-wrapper').length !== 0) {
		var Shuffle = window.Shuffle;
		var jQuery = window.jQuery;

		var myShuffle = new Shuffle(document.querySelector('.shuffle-wrapper'), {
			itemSelector: '.shuffle-item',
			buffer: 1
		});
		jQuery('input[name="shuffle-filter"]').on('change', function (evt) {
			var input = evt.currentTarget;
			if (input.checked) {
				myShuffle.filter(input.value);
			}
		});
	}

})(jQuery);
