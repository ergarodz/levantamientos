

$(document).ready(function() {

    $("#claveSi").click(function() {
      $("#RegistroMunicipio").hide();
      $("#registroClave").show();
      $("#valorDeRadion").val('1');
    });

    $("#claveNo").click(function() {
       $("#valorDeRadion").val('2');
      $("#registroClave").hide();
      $.post("../../acceso/route.php",{acceess:79},function(yz){
    	//console.log(yz);
    	$(yz).each(function(key,valuee){
    		$("#munn").append('<option value='+valuee.num+'>'+valuee.municipio+'</option>');
    	});
    	
       $("#RegistroMunicipio").show();
    });
    });

  });


function login(){
  
  var usa = $('#username').val();
  var pwd = $('#passw').val();

  if( usa == " " || usa == "" || pwd == " " || pwd == ""  ){
    alert("completa campos");
  }else{ 
    
    $.post("../../acceso/route.php",{acceess:100,usa:usa,pwd:pwd},function(yz){
    	//document.getElementById('id01').style.display='none';  
       location.href=yz;
       
      
    });

  } 
}

function cerrarSession(){
      
    $.post("../../acceso/route.php",{acceess:99},function(yz){
    	//document.getElementById('id01').style.display='none';  
    	location.href=yz;
    });
    //session_destroy();
    //location.href='../index.php';
}



function municip(){
	var municip =$("#c_muni").val();
	$.post("../../acceso/route.php",{acceess:98,municip:municip},function(yz){
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

function CalcularAnticipo(){
	var supInicial ="";
	var superficie =0;
	var factorAplicable=0;
	var factorAplicable2=0;
	var cuotaFija=0;
	var cuotaFija2=0;
	var totalDeAnticipo=0;
	var totalDeAnticipo2=0;

	//if (ban == 1) {
		supInicial =$("#supInicial").val();
	//}else if (ban ==2) {
	//	supInicial =$("#superficieResultante").val();
	//}

	$.post("../../acceso/route.php",{acceess:78,supInicial:supInicial},function(yz){

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
		//if (ban == 1) {
			$("#anticipo").val(totalDeAnticipo2);
		//}else if (ban ==2) {
		//	$("#costoTotal").val(totalDeAnticipo2);
		//}
		    
    });
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
	
	var sn = $("#valorDeRadion").val();
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

		//municipio = $("#munn").val(); //nombre del municipio seleccionado
		//buscra nombre del municipio ---- aun no queda esta parte , verificar
		var numic =$("#munn").val();

if(numic=="001"){municipio="Cuautitlán";}
if(numic=="002"){municipio="Coyotepec";}
if(numic=="003"){municipio="Huehuetoca";}
if(numic=="004"){municipio="Melchor Ocampo";}
if(numic=="005"){municipio="Teoloyucan";}
if(numic=="006"){municipio="Tepotzotlán";}
if(numic=="007"){municipio="Tultepec";}
if(numic=="008"){municipio="Tultitlán";}
if(numic=="009"){municipio="Chalco";}
if(numic=="010"){municipio="Amecameca";}
if(numic=="011"){municipio="Atlautla";}
if(numic=="012"){municipio="Ayapango";}
if(numic=="013"){municipio="Cocotitlán";}
if(numic=="014"){municipio="Ecatzingo";}
if(numic=="015"){municipio="Ixtapaluca";}
if(numic=="016"){municipio="Juchitepec";}
if(numic=="017"){municipio="Ozumba";}
if(numic=="018"){municipio="Temamatla";}
if(numic=="019"){municipio="Tenango del aire";}
if(numic=="020"){municipio="Tepetlixpa";}
if(numic=="021"){municipio="Tlalmanalco";}
if(numic=="022"){municipio="El oro";}
if(numic=="023"){municipio="Acambay de Ruíz Castañeda";}
if(numic=="024"){municipio="Atlacomulco";}
if(numic=="025"){municipio="Temascalcingo";}
if(numic=="026"){municipio="Ixtlahuaca";}
if(numic=="027"){municipio="Jiquipilco";}
if(numic=="028"){municipio="Jocotitlán";}
if(numic=="029"){municipio="Morelos";}
if(numic=="030"){municipio="San Felipe del Progreso";}
if(numic=="031"){municipio="Jilotepec";}
if(numic=="032"){municipio="Aculco";}
if(numic=="033"){municipio="Chapa de Mota";}
if(numic=="034"){municipio="Polotitlán";}
if(numic=="035"){municipio="Soyaniquilpan de Juárez";}
if(numic=="036"){municipio="Timilpan";}
if(numic=="037"){municipio="Villa del Carbón";}
if(numic=="038"){municipio="Lerma";}
if(numic=="039"){municipio="Ocoyoacac";}
if(numic=="040"){municipio="Otzolotepec";}
if(numic=="041"){municipio="San Mateo Atenco";}
if(numic=="042"){municipio="Xonacatlán";}
if(numic=="043"){municipio="Otumba";}
if(numic=="044"){municipio="Axapusco";}
if(numic=="045"){municipio="Nopaltepec";}
if(numic=="046"){municipio="San Martín de las Pirámid";}
if(numic=="047"){municipio="Tecámac";}
if(numic=="048"){municipio="Temascalapa";}
if(numic=="049"){municipio="Sultepec";}
if(numic=="050"){municipio="Almoloya de Alquisiras";}
if(numic=="051"){municipio="Amatepec";}
if(numic=="052"){municipio="Texcaltitlán";}
if(numic=="053"){municipio="Tlatlaya";}
if(numic=="054"){municipio="Zacualpan";}
if(numic=="055"){municipio="Temascaltepec";}
if(numic=="056"){municipio="San Simón de Guerrero";}
if(numic=="057"){municipio="Tejupilco";}
if(numic=="058"){municipio="Tenancingo";}
if(numic=="059"){municipio="Coatepec Harinas";}
if(numic=="060"){municipio="Ixtapan de la Sal";}
if(numic=="061"){municipio="Malinalco";}
if(numic=="062"){municipio="Ocuilan";}
if(numic=="063"){municipio="Tonatico";}
if(numic=="064"){municipio="Villa Guerrero";}
if(numic=="065"){municipio="Zumpahuacán";}
if(numic=="066"){municipio="Tenango del Valle";}
if(numic=="067"){municipio="Almoloya del Río";}
if(numic=="068"){municipio="Atizapán";}
if(numic=="069"){municipio="Calimaya";}
if(numic=="070"){municipio="Capulhuac";}
if(numic=="071"){municipio="Chapultepec";}
if(numic=="072"){municipio="Xalatlaco";}
if(numic=="073"){municipio="Joquicingo";}
if(numic=="074"){municipio="Mexicaltzingo";}
if(numic=="075"){municipio="Rayón";}
if(numic=="076"){municipio="San Antonio la Isla";}
if(numic=="077"){municipio="Texcalyacac";}
if(numic=="078"){municipio="Tianguistenco";}
if(numic=="079"){municipio="Texcoco";}
if(numic=="080"){municipio="Acolman";}
if(numic=="081"){municipio="Atenco";}
if(numic=="082"){municipio="Chiautla";}
if(numic=="083"){municipio="Chicoloapan";}
if(numic=="084"){municipio="Chiconcuac";}
if(numic=="085"){municipio="Chimalhuacán";}
if(numic=="086"){municipio="La Paz";}
if(numic=="087"){municipio="Nezahualcóyotl";}
if(numic=="088"){municipio="Papalotla";}
if(numic=="089"){municipio="Teotihuacán";}
if(numic=="090"){municipio="Tepetlaoxtoc";}
if(numic=="091"){municipio="Tezoyuca";}
if(numic=="092"){municipio="Tlalnepantla de Baz";}
if(numic=="093"){municipio="Coacalco de Berriozábal";}
if(numic=="094"){municipio="Ecatepec de Morelos";}
if(numic=="095"){municipio="Huixquilucan";}
if(numic=="096"){municipio="Isidro Fabela";}
if(numic=="097"){municipio="Jilotzingo";}
if(numic=="098"){municipio="Naucalpan de Juárez";}
if(numic=="099"){municipio="Nicolás Romero";}
if(numic=="100"){municipio="Atizapán de Zaragoza";}
if(numic=="101"){municipio="Toluca";}
if(numic=="102"){municipio="Almoloya de Juárez";}
if(numic=="103"){municipio="Metepec";}
if(numic=="104"){municipio="Temoaya";}
if(numic=="105"){municipio="Villa Victoria";}
if(numic=="106"){municipio="Zinacantepec";}
if(numic=="107"){municipio="Valle de Bravo";}
if(numic=="108"){municipio="Amanalco";}
if(numic=="109"){municipio="Donato Guerra";}
if(numic=="110"){municipio="Ixtapan del Oro";}
if(numic=="111"){municipio="Otzoloapan";}
if(numic=="112"){municipio="Santo Tomás";}
if(numic=="113"){municipio="Villa de Allende";}
if(numic=="114"){municipio="Zacazonapan";}
if(numic=="115"){municipio="Zumpango";}
if(numic=="116"){municipio="Apaxco";}
if(numic=="117"){municipio="Hueypoxtla";}
if(numic=="118"){municipio="Jaltenco";}
if(numic=="119"){municipio="Nextlalpan";}
if(numic=="120"){municipio="Tequixquiac";}
if(numic=="121"){municipio="Cuautitlán Izcalli";}
if(numic=="122"){municipio="Valle de Chalco Solidarid";}
if(numic=="123"){municipio="Luvianos";}
if(numic=="124"){municipio="San José del Rincón";}
if(numic=="125"){municipio="Tonanitla";}
if(numic==""){municipio="";}


		if (municipio == null || municipio =='' ||  municipio =='N/A') {
			$("#mensajeErrorNul").show();
			//document.getElementById("municipio").style.borderColor="#e12454";
			ban2 = 1;
		}

	}else{
		//no selecciono el radio button
		$("#mensajeErrorNul").show();
		ban2=1; 
	}

	///obtener datos capturados
  var solicitante = $("#nombreSo").val();
  var apaterno = $("#aPaterno").val();
  var amaterno = $("#aMaterno").val();

   solicitante2 = validaLetras();
   apaterno2 = validaLetras2();
   amaterno2 = validaLetras3();

  var fechaRecepcion = $("#fecha").val();
  var superficieIn = $("#supInicial").val();
  var superficieIn2 = validarSuperficie();

  var abrev = $("#delegacion").val();
  var iddelegacion = $("#iddelegacion").val();

  var propietario = $("#nombreP").val();
  var aPaternoPropietario = $("#aPaternoP").val();
  var aMaternoPropietario = $("#aMaternoP").val();

  propietario2 = validaLetrasPr();
  aPaternoPropietario2 = validaLetrasPr2();
  aMaternoPropietario2 = validaLetrasPr3();

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

	/* if (solicitante == null || solicitante =='') {
		$("#mensajeErrorNul").show();
		document.getElementById("solicitante").style.borderColor="#e12454";              
		ban = 1;
	}else{
		document.getElementById("solicitante").style.borderColor="#223a66";
	}*/


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


	 /*if (anticipo == null || anticipo =='') {
		$("#mensajeErrorNul").show();
		document.getElementById("anticipo").style.borderColor="#e12454";
		ban = 1;
	}else{

	document.getElementById("anticipo").style.borderColor="#223a66";
	}*/

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
   


	if (ban == 1 || ban2 == 1) {
//faltan registros

	}else{

	$.post("../../acceso/route.php",{acceess:96,fup_buscar:fup_buscar,iddelegacion:iddelegacion},function(yz){

    	console.log(yz); 

    	if (yz == 100 || yz == "100") {
    		//sin registro
    			document.getElementById("fupAs").style.borderColor="#223a66"; 
    			//guardar en base de datos  

		$.post("../../acceso/route.php",{acceess:97,c_muni:c_muni,c_zona:c_zona,c_manz:c_manz,c_lote:c_lote,
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

  function validarSuperficie() {

 	 let isValid = false;
      const input = document.forms['superficieSP']['supInicial'];
      const message = document.getElementById('mensajeErrorSuperficie');
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
        $("#mensajeErrorSuperficie").show(); 

      } else {
        message.hidden = true;
         $("#mensajeErrorSuperficie").hide();
      }
      return isValid;
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
function validaLetras() {
      let isValid = false;
      const input = document.forms['validationForm']['nombreSo'];
      const message = document.getElementById('message');
      input.willValidate = false;
      const pattern = new RegExp('^[A-Z ÁÉÍÓÚÑ]+$', 'i');
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


      } else {
        message.hidden = true;
      }
      return isValid;

}

function validaLetras2() {
      let isValid = false;
      const input = document.forms['validationForm']['aPaterno'];
      const message = document.getElementById('message');
      input.willValidate = false;
      const pattern = new RegExp('^[A-Z ÁÉÍÓÚÑ]+$', 'i');
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


      } else {
        message.hidden = true;
      }
      return isValid;

}

function validaLetras3() {
      let isValid = false;
      const input = document.forms['validationForm']['aMaterno'];
      const message = document.getElementById('message');
      input.willValidate = false;
      const pattern = new RegExp('^[A-Z ÁÉÍÓÚÑ]+$', 'i');
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


      } else {
        message.hidden = true;
      }
      return isValid;

}

function validaLetrasPr() {
      let isValid = false;
      const input = document.forms['validationForm2']['nombreP'];
      const message = document.getElementById('message2');
      input.willValidate = false;
      const pattern = new RegExp('^[A-Z ÁÉÍÓÚÑ]+$', 'i');
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


      } else {
        message.hidden = true;
      }
      return isValid;

}
function validaLetrasPr2() {
      let isValid = false;
      const input = document.forms['validationForm2']['aPaternoP'];
      const message = document.getElementById('message2');
      input.willValidate = false;
      const pattern = new RegExp('^[A-Z ÁÉÍÓÚÑ]+$', 'i');
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


      } else {
        message.hidden = true;
      }
      return isValid;

}

function validaLetrasPr3() {
      let isValid = false;
      const input = document.forms['validationForm2']['aMaternoP'];
      const message = document.getElementById('message2');
      input.willValidate = false;
      const pattern = new RegExp('^[A-Z ÁÉÍÓÚÑ]+$', 'i');
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


      } else {
        message.hidden = true;
      }
      return isValid;

}

function ok(){
	location.href='../delegaciones.php';
}

function cancelarlevantamiento(proceso){

	if (proceso == 1) {
		$("#cancelarlevantamiento").hide();
		$("#procesoUno").hide();
		$("#cancelacionLevanUno").show();
		$("#cancelarlevantamiento2").show();
	}else if (proceso == 2) {
		$("#cancelacionLevanDos").show();
		$("#cancelacionLevanUno").hide();
		$("#cancelarlevantamientoBTN").hide();
		
	}else if (proceso == 3) {
		$("#cancelacionLevanTres").show();
		$("#cancelarlevantamientoBTNtres").hide();

	}else if (proceso == 4) {
		$("#cancelacionLevanCuatro").show();
		$("#cancelarlevantamientoBTNcuatro").hide();
	}else if (proceso == 5) {
		$("#cancelacionLevanCinco").show();
		$("#cancelarlevantamientoBTNcinco").hide();
	}
	
}

function cancelarlevantamientoFecha(proceso){
	var proces = proceso;
	var fup = $("#fup").val();
	var fechaCancelacion = "";

if (proceso == 1) {
	 fechaCancelacion = $("#fechaCancelarUno").val(); 
	 if (fechaCancelacion == null || fechaCancelacion == "") { 
		$("#registrosFaltantesFecha").modal('show');
	}else{

	}

}else if(proceso == 2){
	
	fechaCancelacion = $("#fechaCancelarDos").val(); 
	if (fechaCancelacion == null || fechaCancelacion == "") { 
		$("#registrosFaltantesFecha").modal('show');
	}else{

	}

}else if (proceso == 3) {
	fechaCancelacion = $("#fechaCancelarTres").val(); 
	if (fechaCancelacion == null || fechaCancelacion == "") {
		$("#registrosFaltantesFecha").modal('show');
	}else{

	}
}else if (proceso == 4) {
	fechaCancelacion = $("#fechaCancelarCuatro").val(); 
	if (fechaCancelacion == null || fechaCancelacion == "") { 
		$("#registrosFaltantesFecha").modal('show');
	}else{

	}
}else if (proceso == 5) {
	fechaCancelacion = $("#fechaCancelarCinco").val(); 
	if (fechaCancelacion == null || fechaCancelacion == "") { 
		$("#registrosFaltantesFecha").modal('show');
	}else{

	}
}


	$.post("../../acceso/route.php",{acceess:77,fechaCancelacion:fechaCancelacion,proces:proces,fup:fup},function(yz){
		if (yz=="1" || yz==1) {
			//Registro correcto
			$("#cancelacionLevanUno").hide();
			$("#cancelarlevantamiento2").hide();
			$("#procesoCero").show();
		}else if(yz=="2" || yz==2){
			//$("#cancelacionLevanDos").hide();
			//$("#cancelarlevantamientoBTN").hide();
			$("#procesoDos").hide();
			$("#procesoCero").show();
		}else if (yz=="3" || yz==3) {
			$("#procesoTres").hide();
			$("#procesoCero").show();

		}else if (yz=="4" || yz==4) {
			$("#procesoCuatro").hide();
			$("#procesoCero").show();

		}else if (yz=="4" || yz==5) {
			$("#procesoCinco").hide();
			$("#procesoCero").show();

		}

	});

}

function buscaRegistro(){
	var fup_buscar = $("#fup").val(); 
	var iddelegacion = $("#iddelegacion").val();

	$.post("../../acceso/route.php",{acceess:96,fup_buscar:fup_buscar,iddelegacion:iddelegacion},function(yz){
		 console.log(yz); 
    	
		if (yz == 100 || yz == "100" || yz == null || yz == "") {
			//sin registro de fup

			$("#fupNoRegistrado").show();
			$("#procesoUno").hide();
			$("#procesoDos").hide();
			$("#procesoTres").hide();
			$("#procesoCuatro").hide();
			$("#registroEncontrado").hide();
			$("#procesoCero").hide();

    	}else{
    		//console.log(yz); 
    		$("#fupNoRegistrado").hide();
      		$("#registroEncontrado").show();
      		$("#buscaRegistro").hide();
      		$("#seguirBusqueda").show();0
      		$("#procesoCero").hide();

      		$(yz).each(function(key,valuee){
		
				$("#clavec").val(valuee.clavec);
				$("#fup2").val(valuee.fup);
				$("#ordentrabajo").val(valuee.ordentrabajo);
				$("#idRegistroE").val(valuee.id);
				$("#idRegistro").val(valuee.id);
				$("#idRegistro3").val(valuee.id);
				$("#idRegistro4").val(valuee.id);
				$("#folioUnoId").val(valuee.id);
				$("#idRegistro7").val(valuee.id);
				$("#idRegistro8").val(valuee.id);
				$("#anticip").val(valuee.anticipo);

			

				if (valuee.proceso == 1 && valuee.cancelado == 0 || valuee.proceso == 1 && valuee.cancelado == null) {
					
					$("#cancelarlevantamiento").show();
					$("#cancelacionLevanUno").hide();
					$("#procesoUno").show();
					$("#procesoDos").hide();
					$("#procesoTres").hide();
					$("#procesoCuatro").hide();
					$("#procesoCinco").hide();
					$("#procesoSeis").hide();
					$("#procesoSiete").hide();
					$("#procesoOcho").hide();
					$("#procesoNueve").hide();
					$("#procesoCero").hide();

				}else if (valuee.proceso == 1 && valuee.cancelado == 1) {
					
					$("#cancelacionLevanUno").hide();
					$("#procesoUno").hide();
					$("#procesoDos").hide();
					$("#procesoTres").hide();
					$("#procesoCuatro").hide();
					$("#procesoCinco").hide();
					$("#procesoSeis").hide();
					$("#procesoSiete").hide();
					$("#procesoOcho").hide();
					$("#procesoNueve").hide();
					$("#procesoCero").show(); 

				}else if (valuee.proceso == 2 && valuee.cancelado == 0 || valuee.proceso == 2 && valuee.cancelado == null) { // 
					
					$("#cancelarlevantamientoBTN").show();  
					$("#cancelacionLevanDos").hide();  
					$("#procesoUno").hide();
					$("#procesoDos").show();  
					$("#procesoTres").hide();
					$("#procesoCuatro").hide();
					$("#procesoCinco").hide();
					$("#procesoSeis").hide();
					$("#procesoSiete").hide();
					$("#procesoOcho").hide();
					$("#procesoNueve").hide();
					$("#procesoCero").hide();

				}else if (valuee.proceso == 2 && valuee.cancelado == 2) { 
					 
					$("#procesoUno").hide();
					$("#procesoDos").hide(); 
					$("#procesoTres").hide();
					$("#procesoCuatro").hide();
					$("#procesoCinco").hide();
					$("#procesoSeis").hide();
					$("#procesoSiete").hide();
					$("#procesoOcho").hide();
					$("#procesoNueve").hide();
					$("#procesoCero").show();

				}else if(valuee.proceso == 3 && valuee.cancelado == 0 || valuee.proceso == 3 && valuee.cancelado == null){
					
					$("#procesoUno").hide();
					$("#procesoDos").hide();
					$("#procesoTres").show();
					$("#procesoCuatro").hide();
					$("#procesoCinco").hide();
					$("#procesoSeis").hide();
					$("#procesoSiete").hide();
					$("#procesoOcho").hide();
					$("#procesoNueve").hide();
					$("#procesoCero").hide();

					//$("#procesoTres2").hide();
					$("#procesoCuatro2").hide();
					$("#procesoCinco2").hide();
					$("#procesoSeis2").hide();
					$("#procesoSiete2").hide();
					$("#procesoOcho2").hide();
					$("#procesoNueve2").hide();

				}else if(valuee.proceso == 3 && valuee.cancelado == 3){
					
					$("#procesoUno").hide();
					$("#procesoDos").hide();
					$("#procesoTres").hide();
					$("#procesoCuatro").hide();
					$("#procesoCinco").hide();
					$("#procesoSeis").hide();
					$("#procesoSiete").hide();
					$("#procesoOcho").hide();
					$("#procesoNueve").hide();
					$("#procesoCero").show();
					//$("#procesoTres2").hide();
					$("#procesoCuatro2").hide();
					$("#procesoCinco2").hide();
					$("#procesoSeis2").hide();
					$("#procesoSiete2").hide();
					$("#procesoOcho2").hide();
					$("#procesoNueve2").hide();

				}else if (valuee.proceso == 4 && valuee.cancelado == 0 || valuee.proceso == 4 && valuee.cancelado == null) {
					
					$("#procesoUno").hide();
					$("#procesoDos").hide();
					$("#procesoTres").hide();
					$("#procesoCuatro").show();
					$("#procesoCinco").hide();
					$("#procesoSeis").hide();
					$("#procesoSiete").hide();
					$("#procesoOcho").hide();
					$("#procesoNueve").hide();
					$("#procesoCero").hide();

					//$("#procesoCuatro2").hide();
					$("#procesoTres2").hide();
					$("#procesoCinco2").hide();
					$("#procesoSeis2").hide();
					$("#procesoSiete2").hide();
					$("#procesoOcho2").hide();
					$("#procesoNueve2").hide();
					
				}else if (valuee.proceso == 4 && valuee.cancelado == 4) {
					
					$("#procesoUno").hide();
					$("#procesoDos").hide();
					$("#procesoTres").hide();
					$("#procesoCuatro").hide();
					$("#procesoCinco").hide();
					$("#procesoSeis").hide();
					$("#procesoSiete").hide();
					$("#procesoOcho").hide();
					$("#procesoNueve").hide();
					//$("#procesoCuatro2").hide();
					$("#procesoTres2").hide();
					$("#procesoCinco2").hide();
					$("#procesoSeis2").hide();
					$("#procesoSiete2").hide();
					$("#procesoOcho2").hide();
					$("#procesoNueve2").hide();

					$("#procesoCero").show();
					
				}else if (valuee.proceso == 5 && valuee.cancelado == 0 || valuee.proceso == 5 && valuee.cancelado == null) {
					
					$("#procesoUno").hide();
					$("#procesoDos").hide();
					$("#procesoTres").hide();
					$("#procesoCuatro").hide();
					$("#procesoCinco").show();
					$("#procesoSeis").hide();
					$("#procesoSiete").hide();
					$("#procesoOcho").hide();
					$("#procesoNueve").hide();
					$("#procesoCero").hide();
					$("#cancelarlevantamientoBTNcinco").show();  
					$("#cancelacionLevanCinco").hide(); 
					//$("#procesoCinco2").hide();
					$("#procesoCuatro2").hide();
					$("#procesoTres2").hide();
					$("#procesoSeis2").hide();
					$("#procesoSiete2").hide();
					$("#procesoOcho2").hide();
					$("#procesoNueve2").hide();

					
				}else if (valuee.proceso == 5 && valuee.cancelado == 5) {
					
					$("#procesoUno").hide();
					$("#procesoDos").hide();
					$("#procesoTres").hide();
					$("#procesoCuatro").hide();
					$("#procesoCinco").hide();
					$("#procesoSeis").hide();
					$("#procesoSiete").hide();
					$("#procesoOcho").hide();
					$("#procesoNueve").hide();
					//$("#procesoCinco2").hide();
					$("#procesoCuatro2").hide();
					$("#procesoTres2").hide();
					$("#procesoSeis2").hide();
					$("#procesoSiete2").hide();
					$("#procesoOcho2").hide();
					$("#procesoNueve2").hide();
					$("#procesoCero").show();
					
				}else if (valuee.proceso == 6 && valuee.cancelado == 0 || valuee.proceso == 6 && valuee.cancelado == null) {
					
					$("#procesoUno").hide();
					$("#procesoDos").hide();
					$("#procesoTres").hide();
					$("#procesoCuatro").hide();
					$("#procesoCinco").hide();
					$("#procesoSeis").show();
					$("#procesoSiete").hide();
					$("#procesoOcho").hide();
					$("#procesoNueve").hide();
					$("#procesoCero").hide();
					$("#cancelarlevantamientoBTNcinco").hide();  
					$("#cancelacionLevanCinco").hide(); 
					//$("#procesoSeis2").hide();
					$("#procesoCinco2").hide();
					$("#procesoCuatro2").hide();
					$("#procesoTres2").hide();
					$("#procesoSiete2").hide();
					$("#procesoOcho2").hide();
					$("#procesoNueve2").hide();
					
					
				}else if (valuee.proceso == 6 && valuee.cancelado == 6) {
					
					$("#procesoUno").hide();
					$("#procesoDos").hide();
					$("#procesoTres").hide();
					$("#procesoCuatro").hide();
					$("#procesoCinco").hide();
					$("#procesoSeis").hide();
					$("#procesoSiete").hide();
					$("#procesoOcho").hide();
					$("#procesoNueve").hide();
					$("#procesoCero").show();
					//$("#procesoSeis2").hide();
					$("#procesoCinco2").hide();
					$("#procesoCuatro2").hide();
					$("#procesoTres2").hide();
					$("#procesoSiete2").hide();
					$("#procesoOcho2").hide();
					$("#procesoNueve2").hide();
					//$("#procesoSeis").show();
				}else if (valuee.proceso == 7 && valuee.cancelado == 0 || valuee.proceso == 7 && valuee.cancelado == null) {
				
					$("#procesoUno").hide();
					$("#procesoDos").hide();
					$("#procesoTres").hide();
					$("#procesoCuatro").hide();
					$("#procesoCinco").hide();
					$("#procesoSeis").hide();
					$("#procesoSiete").show();
					$("#procesoOcho").hide();
					$("#procesoNueve").hide();
					$("#procesoCero").hide();
					$("#cancelarlevantamientoBTNcinco").hide();  
					$("#cancelacionLevanCinco").hide(); 
					//$("#procesoSiete2").hide();
					$("#procesoSeis2").hide();
					$("#procesoCinco2").hide();
					$("#procesoCuatro2").hide();
					$("#procesoTres2").hide();
					$("#procesoOcho2").hide();
					$("#procesoNueve2").hide();
					
					
				}else if (valuee.proceso == 7 && valuee.cancelado == 7) {
					
					$("#procesoUno").hide();
					$("#procesoDos").hide();
					$("#procesoTres").hide();
					$("#procesoCuatro").hide();
					$("#procesoCinco").hide();
					$("#procesoSeis").hide();
					$("#procesoSiete").hide();
					$("#procesoOcho").hide();
					$("#procesoNueve").hide();
					$("#procesoCero").show();
					//$("#procesoSiete2").hide();
					$("#procesoSeis2").hide();
					$("#procesoCinco2").hide();
					$("#procesoCuatro2").hide();
					$("#procesoTres2").hide();
					$("#procesoOcho2").hide();
					$("#procesoNueve2").hide();
					//$("#procesoSeis").show();
				}else if (valuee.proceso == 8 && valuee.cancelado == 0 || valuee.proceso == 8 && valuee.cancelado == null) {
				
					$("#procesoUno").hide();
					$("#procesoDos").hide();
					$("#procesoTres").hide();
					$("#procesoCuatro").hide();
					$("#procesoCinco").hide();
					$("#procesoSeis").hide();
					$("#procesoSiete").hide();
					$("#procesoOcho").show();
					$("#procesoNueve").hide();
					$("#procesoCero").hide();
					$("#cancelarlevantamientoBTNcinco").hide();  
					$("#cancelacionLevanCinco").hide(); 

					//$("#procesoOcho2").hide();
					$("#procesoSiete2").hide();
					$("#procesoSeis2").hide();
					$("#procesoCinco2").hide();
					$("#procesoCuatro2").hide();
					$("#procesoTres2").hide();
					$("#procesoNueve2").hide();
					
					
				}else if (valuee.proceso == 8 && valuee.cancelado == 8) {
					
					$("#procesoUno").hide();
					$("#procesoDos").hide();
					$("#procesoTres").hide();
					$("#procesoCuatro").hide();
					$("#procesoCinco").hide();
					$("#procesoSeis").hide();
					$("#procesoSiete").hide();
					$("#procesoOcho").hide();
					$("#procesoNueve").hide();
					$("#procesoCero").show();
					//$("#procesoOcho2").hide();
					$("#procesoSiete2").hide();
					$("#procesoSeis2").hide();
					$("#procesoCinco2").hide();
					$("#procesoCuatro2").hide();
					$("#procesoTres2").hide();
					$("#procesoNueve2").hide();
					//$("#procesoSeis").show();
				}else if (valuee.proceso == 9 && valuee.cancelado == 0 || valuee.proceso == 9 && valuee.cancelado == null) {
				
					$("#procesoUno").hide();
					$("#procesoDos").hide();
					$("#procesoTres").hide();
					$("#procesoCuatro").hide();
					$("#procesoCinco").hide();
					$("#procesoSeis").hide();
					$("#procesoSiete").hide();
					$("#procesoOcho").hide();
					$("#procesoNueve").show();
					$("#procesoCero").hide();
					$("#cancelarlevantamientoBTNcinco").hide();  
					$("#cancelacionLevanCinco").hide(); 
					//$("#procesoNueve2").hide();
					$("#procesoOcho2").hide();
					$("#procesoSiete2").hide();
					$("#procesoSeis2").hide();
					$("#procesoCinco2").hide();
					$("#procesoCuatro2").hide();
					$("#procesoTres2").hide();
					
					
				}else if (valuee.proceso == 9 && valuee.cancelado == 9) {
					
					$("#procesoUno").hide();
					$("#procesoDos").hide();
					$("#procesoTres").hide();
					$("#procesoCuatro").hide();
					$("#procesoCinco").hide();
					$("#procesoSeis").hide();
					$("#procesoSiete").hide();
					$("#procesoOcho").hide();
					$("#procesoNueve").hide();
					$("#procesoCero").show();
					//$("#procesoNueve2").hide();
					$("#procesoOcho2").hide();
					$("#procesoSiete2").hide();
					$("#procesoSeis2").hide();
					$("#procesoCinco2").hide();
					$("#procesoCuatro2").hide();
					$("#procesoTres2").hide();
					//$("#procesoSeis").show();
				}else if(valuee.proceso == 0){
					$("#procesoCero").show();
					
					$("#procesoUno").hide();
					$("#procesoDos").hide();
					$("#procesoTres").hide();
					$("#procesoCuatro").hide();
					$("#procesoCinco").hide();
					$("#procesoSeis").hide();
					$("#procesoSiete").hide();
					$("#procesoOcho").hide();
					$("#procesoNueve").hide();

				}
			});

    	}  
    });
}

function fechaEnviop(){
	var seleccion = document.getElementById("fechaDeEnvio").value;

	if (seleccion == 1 || seleccion == "1") {
		$("#fechaEnvio").show();

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

	}else if(seleccion == 2 || seleccion == "2"){
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

	}else if(seleccion == 3 || seleccion == "3"){
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

	var folioRegistro = $("#idRegistro").val();
	var odn = "";
	var odn2 = "";

	$.post("../../acceso/route.php",{acceess:94,folioRegistro:folioRegistro},function(yz){
		//console.log(yz); 
 		if (yz == 100 || yz == "100" || yz == null ) {
 			//sin registros
 		}else{

 			$(yz).each(function(key,valuee){

 				$("#fechaDeEnvioTip").val(valuee.estatusfecha);

 				if (valuee.ordentrabajo == null || valuee.ordentrabajo == "") {
 					$("#ordentrabajo").val(valuee.ordentrabajo);

 				}else{
 					//fechaentregaGeo2.slice(0, -12);
 					odn = valuee.ordentrabajo;
 					//odn2 = odn.slice(-5,0);
 					odn2=odn.substr(5,4);
 					$("#ordentrabajo").val(odn2);

 				}

	 			

	 			if (valuee.estatusfecha == '1' && valuee.fechaenvio != "1999-01-01 00:00:00+01") {
	 				$("#fechaEnvio2").show();
	 				//$("#fechaEnvio2").val(valuee.fechaenvio);///linea original
	 				$("#fechaEnvio2").val( moment(valuee.fechaenvio).format('DD-MM-YYYY') );
	 				document.getElementById('fechaDeEnvio').style.display = "none";
	 				//visibility:hidden
	 			}else if(valuee.estatusfecha == '1' && valuee.fechaenvio == "1999-01-01 00:00:00+01"){

	 				document.getElementById('fechaDeEnvio').style.display = "block";
	 				$("#fechaEnvio").show();
	 				$("#fechaDeEnvio").val('1');

	 			}else if(valuee.estatusfecha == '2'){
	 				$("#fechaDeEnvio2").hide();
	 				$("#fechaDeEnvio").val('2');
	 				document.getElementById('fechaDeEnvio').style.display = "block"; 
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

	 			}else if (valuee.estatusfecha == '3') {
	 				$("#fechaEnvio2").show();
	 				$("#fechaEnvio2").val('Cancelado');
	 				document.getElementById('fechaDeEnvio').style.display = "none";
	 				//mostrar mensaje de que el proceso ha sido cancelado
	 				document.getElementById('areaCancelada').style.display = "block";

	 				$("#oc").hide();
	 				$("#oc1").hide();
	 				$("#oc2").hide();
	 				$("#oc3").hide();
	 				$("#oc4").hide();
	 				$("#oc5").hide();
	 				$("#oc6").hide();
	 				$("#oc7").hide();
	 				$("#oc8").hide();
	 				$("#oc9").hide();
	 				$("#oc10").hide();
	 				$("#oc11").hide();
	 				$("#oc12").hide();
	 				$("#butBien").hide();
	 				$("#butMal").show();

	 				

	 			}

	 			$("#areaProduc").val(valuee.areaproduc);

				if (valuee.fechanotificacion == "1999-01-01 00:00:00+01") {
					//1999-01-01 00:00:00+01 sin registro de fecha

					
				}else{
					$("#fechaNotificacion").hide();
					$("#fechaNotificacion2").show();
					$("#fechaNotificacion2").val(valuee.fechanotificacion);
				}
						

				if (valuee.fechalevantamiento == "1999-01-01 00:00:00+01") {
					//sin registro de fecha
					
				}else{

					$("#fechaLevantamiento").hide();
					$("#fechaLevantamiento2").show();
					$("#fechaLevantamiento2").val(valuee.fechalevantamiento);
				}
				
				$("#folioGEO").val(valuee.foliogeo);


				if (valuee.estatusfechater == '1' && valuee.fechatermino != "1999-01-01 00:00:00+01") {

					document.getElementById('fechaSerTerminado').style.display = "none";
					$("#fechaSerTerminado3").show();
					$("#fechaSerTerminado3").val(valuee.fechatermino);
					$("#terminoProcDos").show();
					$("#actualizarDos").show();

				}else if(valuee.estatusfechater == '1' && valuee.fechatermino == "1999-01-01 00:00:00+01"){
					document.getElementById('fechaSerTerminado').style.display = "block";
					$("#fechaSerTerminado").val('1');
					$("#fechaSerTerminado2").show();
					$("#terminoProcDos").show();
					$("#actualizarDos").show();

				}else if (valuee.estatusfechater == '2') {
					document.getElementById('fechaSerTerminado').style.display = "block";
					$("#fechaSerTerminado3").hide();
					$("#superficie").hide();
					$("#fechaSerTerminado").val('2');
					$("#terminoProcDos").hide();
					$("#actualizarDos").show();

					
				}else if (valuee.estatusfechater == '3') {
					document.getElementById('fechaSerTerminado').style.display = "none";
					$("#fechaSerTerminado3").show();
					$("#fechaSerTerminado3").val('Cancelado');
					//$("#fechaSerTerminado").val('3');
					$("#terminoProcDos").show();
					$("#actualizarDos").hide();
					$("#superficie").hide();
					document.getElementById('areaCancelada').style.display = "block";
					$("#butBien").hide();
	 				$("#butMal").show();

				}

				$("#superficie").val(valuee.superficie);
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
		

	$.post("../../acceso/route.php",{acceess:94,folioRegistro:folioRegistro},function(yz){  
		console.log(yz); 
		if (yz == "100") {
			//sin registro

			$.post("../../acceso/route.php",{acceess:95,folioRegistro:folioRegistro,ordenTrabajo:ordenTrabajo,estatusfechaEnvio:estatusfechaEnvio,
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

		 		//////////////////////////////////////////
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


			$.post("../../acceso/route.php",{acceess:93,folioRegistro:folioRegistro,ordenTrabajo:ordenTrabajo,estatusfechaEnvio:estatusfechaEnvio,
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


function terminarProcesoDos(){

	var folioRegistro = $("#idRegistro").val();
	var ordenTrabajo = $("#ordentrabajo").val();
	var estatusfechaEnvio = $("#fechaDeEnvio").val();
	var fechaEnvio = $("#fechaEnvio").val();
	var areaProductora = $("#areaProduc").val();
	var fechaEnvio2 = $("#fechaEnvio2").val();

	//var estatusfechaEnvio = $("#fechaDeEnvioTip").val();

	/*if (ordenTrabajo != null || ordenTrabajo != "") {
		var abrev = $("#delegacion").val();
  		var anioAct = $("#anioAct").val(); 
  		ordenTrabajo = abrev+"-"+anioAct+ordenTrabajo;
	}*/

	/*
	var fechaNotificacion = $("#fechaNotificacion").val();
	var fechaLevantamiento = $("#fechaLevantamiento").val();
	
	var folioGeo = $("#folioGEO").val(); 
	
	var estatusFechaTermino = $("#fechaSerTerminado").val();
	var fechaTermino = $("#fechaSerTerminado2").val(); 
	
	var superficie = $("#superficie").val(); 

	//////// variables agregadas a una actualizacion
	var fechaTermino2 = $("#fechaSerTerminado3").val(); 
	
	var fechaNotificacion2 = $("#fechaNotificacion2").val();
	var fechaLevantamiento2 = $("#fechaLevantamiento2").val();*/

	var proc = 0;
	var sn = 0;

	/////falta validad los demas estatus de fecha para cancelados y procesos/////
 

	//////////////////////////////////////////////////tramite cancelado en "Fecha de envío al área productora"///////////////////////////////////////////////////////////////////////
	if (estatusfechaEnvio == 3 || estatusfechaEnvio == "3") { 

	$.post("../../acceso/route.php",{acceess:94,folioRegistro:folioRegistro},function(yz){

		if (yz == 100 || yz == "100") {
			//sin registro
			sn = 103 ;
		$.post("../../acceso/route.php",{acceess:82,folioRegistro:folioRegistro,ordenTrabajo:ordenTrabajo,sn:sn},function(yz){ 

	 		if (yz == "1" || yz == 1) {  
	 			//-bn  procesoCanceladoUno
	 			$("#procesoCanceladoUno").modal('show');	
	 			$("#procesoCanceladoError").modal('hide');	
	 			
	 		}else{
	 			//error procesoCanceladoError
	 			$("#procesoCanceladoError").modal('show');	
	 			$("#procesoCanceladoUno").modal('hide');

	 		}

	 	});

		}else{
			//Con registro
			sn = 30;

			$.post("../../acceso/route.php",{acceess:82,folioRegistro:folioRegistro,ordenTrabajo:ordenTrabajo,sn:sn},function(yz){ 

	 		if (yz == "1" || yz == 1) {  
	 			//-bn  procesoCanceladoUno
	 			$("#procesoCanceladoUno").modal('show');	
	 			$("#procesoCanceladoError").modal('hide');	
	 			
	 		}else{
	 			//error procesoCanceladoError
	 			$("#procesoCanceladoUno").modal('hide');	
	 			$("#procesoCanceladoError").modal('show');	
	 		}

	 	});

		}


	});


	///////////////////////////////////Tramite en proceso////////////////////////////////////////////////
	}else if(estatusfechaEnvio == 2 || estatusfechaEnvio == "2"){


			//94   100 sin registro
	$.post("../../acceso/route.php",{acceess:94,folioRegistro:folioRegistro},function(yz){

		if (yz == 100 || yz == "100") {
			//sin registro
			sn = 102 ;
		$.post("../../acceso/route.php",{acceess:82,folioRegistro:folioRegistro,ordenTrabajo:ordenTrabajo,sn:sn},function(yz){ 

	 		if (yz == "1" || yz == 1) {  
	 			//-bn  procesoCanceladoUno
	 			$("#procesoCanceladoUno").modal('show');	
	 			$("#procesoCanceladoError").modal('hide');	
	 			
	 		}else{
	 			//error procesoCanceladoError
	 			$("#procesoCanceladoError").modal('show');	
	 			$("#procesoCanceladoUno").modal('hide');

	 		}

	 	});

		}else{
			//Con registro
			sn = 20;

			$.post("../../acceso/route.php",{acceess:82,folioRegistro:folioRegistro,ordenTrabajo:ordenTrabajo,sn:sn},function(yz){ 

	 		if (yz == "1" || yz == 1) {  
	 			//-bn  procesoCanceladoUno
	 			$("#procesoCanceladoUno").modal('show');	
	 			$("#procesoCanceladoError").modal('hide');	
	 			
	 		}else{
	 			//error procesoCanceladoError
	 			$("#procesoCanceladoUno").modal('hide');	
	 			$("#procesoCanceladoError").modal('show');	
	 		}

	 	});

		}


	});



	}else{
	///////////////////////////////////////////////continuidad del tramite/////////////////////////////////////////////////////////////////////////

	if (ordenTrabajo == null || areaProductora == null || ordenTrabajo == "" || areaProductora == "") {
		proc = 1;
	}




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

	}else if(estatusfechaEnvio != null && fechaEnvio2 == null || estatusfechaEnvio != null && fechaEnvio2 == ""){
		//con fecha

	}else if(estatusfechaEnvio != null && fechaEnvio2 != null || estatusfechaEnvio != null && fechaEnvio2 != ""){
		//con fecha

	}else{
		proc = 1;
	}



	/*if (estatusFechaTermino == null && fechaTermino2 != null) {

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

	}else if(estatusFechaTermino != null && fechaTermino2 == null || estatusFechaTermino != null && fechaTermino2 == ""){
		

	}else{
		proc = 1;
	}*/



	/*if (fechaNotificacion == "" && fechaNotificacion2 != null) {

		fechaNotificacion = fechaNotificacion2;

	}else if(fechaNotificacion != "" && fechaNotificacion2 == null || fechaNotificacion != null && fechaNotificacion2 == ""){
		//con fecha  
	}else{
		proc = 1;
	}*/



	/*if (fechaLevantamiento == "" && fechaLevantamiento2 != null) {

		fechaLevantamiento = fechaLevantamiento2;

	}else if(fechaLevantamiento != "" && fechaLevantamiento2 == null || fechaLevantamiento != null && fechaLevantamiento2 == ""){
		//con fecha
	}else{
		proc = 1;
	}*/



	/*if(estatusFechaTermino == 3 || estatusFechaTermino == "3"){
		proc = 0;


	 }*/
	if (proc == 1) {
		//falta registrar alguna informacion 
		$("#registrosFaltantes").modal('show');

	}else{



		/*if(estatusFechaTermino == 3 || estatusFechaTermino == "3"){ //proceso cancelado en Fecha de recepcion del servicio terminado:

			$.post("../../acceso/route.php",{acceess:94,folioRegistro:folioRegistro},function(yz){

			if (yz == 100 || yz == "100") {
					/////////sin registro
					sn = 10 ;
						$.post("../../acceso/route.php",{acceess:81,folioRegistro:folioRegistro,ordenTrabajo:ordenTrabajo,estatusfechaEnvio:estatusfechaEnvio,
	 	fechaEnvio:fechaEnvio,areaProductora:areaProductora,fechaNotificacion:fechaNotificacion,fechaLevantamiento:fechaLevantamiento,
	 	folioGeo:folioGeo,estatusFechaTermino:estatusFechaTermino,fechaTermino:fechaTermino,superficie:superficie,sn:sn},function(yz){ 

	 		if (yz == "1" || yz == 1) {  
	 			//$("#registrosFaltantes").modal('hide');	
	 			//cerrar modal de registro
	 			$("#myModal2").modal('hide');	
	 			//Abrir modal de registro guardado
	 			$("#procesoCanceladoUno").modal('show');	
	 		}else{
	 			//error
	 		}
	 	});
			}else{
				///con registro
				sn = 0;

				$.post("../../acceso/route.php",{acceess:81,folioRegistro:folioRegistro,ordenTrabajo:ordenTrabajo,estatusfechaEnvio:estatusfechaEnvio,
	 	fechaEnvio:fechaEnvio,areaProductora:areaProductora,fechaNotificacion:fechaNotificacion,fechaLevantamiento:fechaLevantamiento,
	 	folioGeo:folioGeo,estatusFechaTermino:estatusFechaTermino,fechaTermino:fechaTermino,superficie:superficie,sn:sn},function(yz){ 

	 		if (yz == "1" || yz == 1) {  
	 			//$("#registrosFaltantes").modal('hide');	
	 			//cerrar modal de registro
	 			$("#myModal2").modal('hide');	
	 			//Abrir modal de registro guardado
	 			$("#procesoCanceladoUno").modal('show');	
	 		}else{
	 			//error
	 		}
	 	});
			}
		 });

			
		}else{ *///continuidad del proceso

					$.post("../../acceso/route.php",{acceess:94,folioRegistro:folioRegistro},function(yz){

			if (yz == 100 || yz == "100") {
					/////////sin registro
					sn = 10 ;
						$.post("../../acceso/route.php",{acceess:92,folioRegistro:folioRegistro,ordenTrabajo:ordenTrabajo,estatusfechaEnvio:estatusfechaEnvio,
	 	fechaEnvio:fechaEnvio,areaProductora:areaProductora,sn:sn},function(yz){ 

	 		if (yz == "1" || yz == 1) {  
	 			//$("#registrosFaltantes").modal('hide');	
	 			//cerrar modal de registro
	 			$("#myModal2").modal('hide');	
	 			//Abrir modal de registro guardado
	 			$("#procesoTerminado").modal('show');	
	 		}else{
	 			//error
	 		}
	 	});
			}else{
				///con registro
				sn = 0;

				$.post("../../acceso/route.php",{acceess:92,folioRegistro:folioRegistro,ordenTrabajo:ordenTrabajo,estatusfechaEnvio:estatusfechaEnvio,
	 	fechaEnvio:fechaEnvio,areaProductora:areaProductora,sn:sn},function(yz){ 

	 		if (yz == "1" || yz == 1) {  
	 			//$("#registrosFaltantes").modal('hide');	
	 			//cerrar modal de registro
	 			$("#myModal2").modal('hide');	
	 			//Abrir modal de registro guardado
	 			$("#procesoTerminado").modal('show');	
	 		}else{
	 			//error
	 		}
	 	});
			}
		 });



		//}
	}
	}
}

function cerrarM(){

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

	$.post("../../acceso/route.php",{acceess:91,folioRegistro3:folioRegistro3},function(yz){

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

	$.post("../../acceso/route.php",{acceess:91,folioRegistro3:folioRegistro3},function(yz){ 

	 	if (yz == "100" || yz == 100) {
	 		//sin registro
	 		$.post("../../acceso/route.php",{acceess:90,folioRegistro3:folioRegistro3,costoTT:costoTT,fechanotientrega:fechanotientrega,fechaentregasolicitante:fechaentregasolicitante, diferencia:diferencia,reciboFUP:reciboFUP},function(yz){  

		 	    //console.log(yz); 
		 		if (yz == "1" || yz == 1) {
		 			$("#procesoTresInfo").modal('hide');
		 			$("#registroBien").modal('show');
		 		}else{
		 			//Error
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

			$.post("../../acceso/route.php",{acceess:89,folioRegistro3:folioRegistro3,costoTT:costoTT,fechanotientrega:fechanotientrega,fechaentregasolicitante:fechaentregasolicitante, diferencia:diferencia,reciboFUP:reciboFUP},function(yz){
		 		//console.log(yz); 
		 		if (yz == "1" || yz == 1) {
	 				$("#procesoTresInfo").modal('hide');
	 				$("#registroBien").modal('show');
		 		}else{
		 			//Error
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

			$.post("../../acceso/route.php",{acceess:88,folioRegistro3:folioRegistro3,costoTT:costoTT,fechanotientrega:fechanotientrega,
		 	fechaentregasolicitante:fechaentregasolicitante,diferencia:diferencia,reciboFUP:reciboFUP},function(yz){ 


		 		if (yz == "1" || yz == 1) {  
		 			//$("#registrosFaltantes").modal('hide');	
		 			//cerrar modal de registro
		 			$("#myModal2").modal('hide');	
		 			//Abrir modal de registro guardado
		 			$("#procesoTerminadoTres").modal('show');	
		 		}else{
		 			//error
		 		}

		 		  });

			}

}

function mostrarInfoCierre(){

	var folioRegistro4 = $("#idRegistro4").val();
	var folioGeo = "";
	var folioGeo2 = "";
	var identificadorGeo="", folioGeo="", anioGeo="";
		 $.post("../../acceso/route.php",{acceess:87,folioRegistro4:folioRegistro4},function(yz){ //91

		 	if (yz == 100 || yz == "100") { 
		 		//sin registro

		 	}else{
		 		//con registro
		 		$(yz).each(function(key,valuee){

		 			//dividir el folio GEO
		 			folioGeo=valuee.foliogeo;
		 			folioGeo2 = folioGeo.split('/');
					identificadorGeo = folioGeo2[0];
		 			folioGeo = folioGeo2[1];
		 			anioGeo = folioGeo2[2];

		 			$("#identificadorGeo").val(identificadorGeo);
		 			$("#folGeo").val(folioGeo);
		 			$("#anioGeo").val(anioGeo);


		 			if (valuee.fechalevantamiento == "1999-01-01 00:00:00+01" || valuee.fechalevantamiento == "1999-01-01 00:00:00-06") {
		 				
		 			}else{

		 				document.getElementById('fechaentregaGeo').style.display = "none";
						$("#fechaentregaGeo2").show();
		 				//$("#fechaentregaGeo2").val(valuee.fechalevantamiento);////linea original
		 				$("#fechaentregaGeo2").val( moment(valuee.fechalevantamiento).format('DD-MM-YYYY') );

		 			}


		 			

		 		});

		 	}



		  });



}

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

		// $.post("../../acceso/route.php",{acceess:87,folioRegistro4:folioRegistro4},function(yz){ 

		 	/*if (yz == 100 || yz == "100"){
		 		//sin registro
		 	$.post("../../acceso/route.php",{acceess:86,folioRegistro4:folioRegistro4,idConcluido:idConcluido,fechaentregaGeo:fechaentregaGeo},function(yz){ 
		 		
		 		if (yz == 1 || yz == "1") { 
		 			$("#procesoCuatroInfo").modal('hide');
	 				$("#registroBien").modal('show');

		 		}else{

		 		}

		 	});
		 	}*///else{

		 		//if (fechaentregaGeo == null && fechaentregaGeo2 != null || fechaentregaGeo == "" && fechaentregaGeo2 != "") {
		 		//		fechaentregaGeo = fechaentregaGeo2; 
		 	//	} 

		 		//con registro
		 		$.post("../../acceso/route.php",{acceess:85,folioRegistro4:folioRegistro4,idConcluido:idConcluido,fechaentregaGeo:fechaentregaGeo},function(yz){
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
	var folioRegistro4 = $("#idRegistro4").val(); // id de registro en procesoDos
	var fechaentregaGeo = $("#fechaentregaGeo").val(); //fecha de levantamiento
	var fechaentregaGeo2 = $("#fechaentregaGeo2").val();
	var proc =0, proc2 =0;

	var identificadorGeo = $("#identificadorGeo").val(); //identificador para el folio GEO
	var folGeo = $("#folGeo").val(); // folio  geo correspondiente
	var anioGeo = $("#anioGeo").val();// año del folio geo
	var idConcluido = "";// folio GEO completo


	if (identificadorGeo == null || folGeo == null || anioGeo == null || identificadorGeo == "" || folGeo == "" || anioGeo == "") {
			//falte registar un campo para completar el FOLIO GEO	
			idConcluido="";
			proc2 =1;

	}else{
		// completar el folio GEO
		idConcluido=identificadorGeo+"/"+folGeo+"/"+anioGeo;  
		proc2 =0;
	}

///////////////////////////////////////////////////////

	/*if (idConcluido == null || idConcluido == "") {
		proc =1;

	}*/


	if (fechaentregaGeo == null && fechaentregaGeo2 != null || fechaentregaGeo == "" && fechaentregaGeo2 != "") {
		proc = 0;
		//fechaentregaGeo2 //dejar año-mes-dia   2023-01-09 00:00:00-06
		var fechaentregaGeo22 = fechaentregaGeo2.slice(0, -12); 
		fechaentregaGeo = fechaentregaGeo2; 

	}else if(fechaentregaGeo != null && fechaentregaGeo2 == null || fechaentregaGeo != "" && fechaentregaGeo2 == ""){
			proc = 0;
	}else{
		proc = 1;
	} 

	// $.post("../../acceso/route.php",{acceess:87,folioRegistro4:folioRegistro4},function(yz){ 

	 	/*if (yz == 100 || yz == "100") {
	 		//sin registro
	 			if (proc == 1) {
	 				//falta registrar datos
	 				$("#procesoCuatroInfo").modal('hide');
	 				$("#registrosFaltantes").modal('show');
	 				

	 			}else{
	 				//continuar con el insert, ya que todos los campos estan registrados
	 					$.post("../../acceso/route.php",{acceess:86,folioRegistro4:folioRegistro4,idConcluido:idConcluido,fechaentregaGeo:fechaentregaGeo},function(yz){ 
		 		
		 		if (yz == 1 || yz == "1") {
		 			$("#procesoCuatroInfo").modal('hide');
	 				$("#procesoTerminadoCuatro").modal('show');

		 		}else{

		 		}

		 	});

	 			}

	 	}else{*/
	 		//con registro

	 		if (proc == 1 || proc2 == 1) { 
	 			//falta registrar algun dato
	 			$("#procesoCuatroInfo").modal('hide');
	 			$("#registrosFaltantes").modal('show');

	 		}else{
	 			//todos los datos han sigo  registrados
	 			 $.post("../../acceso/route.php",{acceess:84,folioRegistro4:folioRegistro4,idConcluido:idConcluido,fechaentregaGeo:fechaentregaGeo},function(yz){

	 		 	if (yz == 1 || yz =="1") {
	 		 		$("#procesoCuatroInfo").modal('hide');
	 				$("#procesoTerminadoCuatro").modal('show');

	 		 	}else{

	 		 	}


	 		  });

	 		}


	 	//}


	// });


}

function procesosTrm(id,delegacion){
	//console.log('gfgg');
		$("#procesosTr").modal('show');
		$("#idFup").val(id);

		var fup_buscar = id;
		var iddelegacion = delegacion;

		/*96
		   */
		 $.post("../../acceso/route.php",{acceess:96,fup_buscar:fup_buscar,iddelegacion:iddelegacion},
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

	$.post("../../acceso/route.php",{acceess:80,proceso:proceso,fup:fup,id:id},
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

function notificacionColindantes(){
	$("#fechaNotificacionn").show();
}

function fechaNotificacionCo(){
	var fechaNotificacion= $("#fechanotif").val();
	var idRegistroDos= $("#idRegistroE").val();
	var fup= $("#fup").val();

	if (fechaNotificacion == null || fechaNotificacion == "") {
		$("#registrosFaltantesFecha").modal('show');

	}else{

		$.post("../../acceso/route.php",{acceess:76,fechaNotificacion:fechaNotificacion,idRegistroDos:idRegistroDos,fup:fup},
		 	function(yz){ 
		 		if (yz == 1 || yz =="1") {
	 		 		//$("#cancelarlevantamientoBTN").hide();
	 				$("#procesoDos").hide();
	 				//$("#procesoTres").show();

	 		 	}else{

	 		 	}

		 	});

	}

}

function envioDirGeo(){
	$("#fechaEnvioDirGeo").show();

}

function fechaEnvioDirGeografia(){
	var fechaEnvioDirGeogra= $("#fechaEnvioDirGeogra").val();
	var idRegistroDos= $("#idRegistroE").val();
	var fup= $("#fup").val();

	if (fechaEnvioDirGeogra == null || fechaEnvioDirGeogra == "") {//mensaje
			$("#registrosFaltantesFecha").modal('show');
	}

	$.post("../../acceso/route.php",{acceess:75,fechaEnvioDirGeogra:fechaEnvioDirGeogra,idRegistroDos:idRegistroDos,fup:fup},
		 	function(yz){ 

		 		if (yz == 1 || yz =="1") {
	 		 		//$("#cancelarlevantamientoBTNcuatro").hide();
	 				$("#procesoCuatro").hide();
	 				//$("#procesoCinco").show();

	 		 	}else{

	 		 	}
		 	});

}

function recepcionCCC(){
	$("#fechaRecepcionCCC").show();

}

function fechaRecepcionDsicc(){
	var fechaRecepcionDSIccc= $("#fechaRecepcionDSIccc").val();
	var idRegistroDos= $("#idRegistroE").val();
	var fup= $("#fup").val();

	if (fechaRecepcionDSIccc == null || fechaRecepcionDSIccc == "") {
		$("#registrosFaltantesFecha").modal('show');
	}

	$.post("../../acceso/route.php",{acceess:74,fechaRecepcionDSIccc:fechaRecepcionDSIccc,idRegistroDos:idRegistroDos,fup:fup},
		 	function(yz){  

		 		if (yz == 1 || yz =="1") {
	 		 	//	$("#cancelarlevantamientoBTNcinco").hide();
	 				$("#procesoCinco").hide(); 
	 			//	$("#procesoSeis").show();

	 		 	}else{

	 		 	}
		 	});

}


function CalcularCostoTotal(){
	var supInicial ="";
	var superficie =0;
	var factorAplicable=0;
	var factorAplicable2=0;
	var cuotaFija=0;
	var cuotaFija2=0;
	var totalDeAnticipo=0;
	var totalDeAnticipo2=0;
	var folioGnral = $("#idRegistro6").val();
	var anticipo="",costoTot2="",costoTot3="",anticipoF=0, costoTot="", diferenciaCT=0, costoTotF=0, diferenciaCT2=0, diferenciaCT3=0;
    var ban = 0;
	//if (ban == 1) {
	//	supInicial =$("#supInicial").val();
	//}else if (ban ==2) {
		supInicial =$("#superficieResultante").val();
	//}
	/////////////////////////////calcular el costo total dependiendo de la superficie/////////////////////////////////////////////////////
	$.post("../../acceso/route.php",{acceess:78,supInicial:supInicial},function(yz){

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
		//if (ban == 1) {
		//	$("#anticipo").val(totalDeAnticipo2);
		//}else if (ban ==2) {
			$("#costoTotal").val(totalDeAnticipo2);
		//}
		    
    });

    ///////////////////////calcular la diferencia del anticipo con el costo total///////////////
    $.post("../../acceso/route.php",{acceess:73,folioGnral:folioGnral},function(yz){

		/*$(yz).each(function(key,valuee){
    		superficie=supInicial - valuee.limiteinferior;
    		factorAplicable=superficie * valuee.factoraplicable;
    		cuotaFija = parseFloat(valuee.cuotafija);
    		factorAplicable2=parseFloat(factorAplicable);
    		cuotaFija2 = factorAplicable2 + cuotaFija;

    	});*/
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

		//if (ban == 1) {
		//	$("#anticipo").val(totalDeAnticipo2);
		//}else if (ban ==2) {
			//$("#costoTotal").val(totalDeAnticipo2);
		//}
		    
    });

}

function entregaDelegacion(){
		var folioGeneral=$("#fup").val();
		$("#idRegistro6").val(folioGeneral);

		var idFolioSiete = $("#folioUnoId").val();

		$.post("../../acceso/route.php",{acceess:71,idFolioSiete:idFolioSiete},function(yz){ 

			if (yz == 100 || yz == "100") {
				//sin registro
			}else{
				//con registros
				$(yz).each(function(key,valuee){

					if (valuee.fechanotientrega == '1999-01-01 00:00:00-06') {
						$("#fechaentregaDelegacion").show();
						$("#fechaentregaDelegacion2").hide();
						//$("#fechaentregaDelegacion").val();

					}else{
						$("#fechaentregaDelegacion").hide();
						$("#fechaentregaDelegacion2").show();
						//$("#fechaentregaDelegacion2").val(valuee.fechanotientrega);////linea original
						$("#fechaentregaDelegacion2").val(moment(valuee.fechanotientrega).format('DD-MM-YYYY') );
					}

					
					
					$("#superficieResultante").val(valuee.superficieresultante);
					$("#costoTotal").val(valuee.costototal);
					$("#diferencias").val(valuee.diferencia);
					$("#diDeRe").val(valuee.tipooficio);
					$("#foliodiDeRe").val(valuee.recibofup);

					///erick, este es tu yo del futuro, aqui obtienes el valor de las observaciuones agregadas
					$("#obs_proceso6").val(valuee.obs_proceso6); 

					tipoNodeOficio();////ERICK, este es tu yo del pasado, aquí llamaste este método que ya estaba creado para que se eligieran solos los cmapos de acuerdo a la opción del select

				 });

			}



		});




}

function actualizarProcesoSiete(){

	var fechaEntregaDelegacion = $("#fechaentregaDelegacion").val(); 
	var fechaEntregaDelegacion2 = $("#fechaentregaDelegacion2").val(); 
	var fechaEntregaDelegacion3 = "";
	var superficieResultante = $("#superficieResultante").val();
	var superficieResultante2 = validarSuperficie2();
	var costoTotal = "";
	var diferencias = "";
	var diDeRe = $("#diDeRe").val();
	var foliodiDeRe = $("#foliodiDeRe").val();
	var idFolioSiete = $("#folioUnoId").val();
	var ban=0;

	var obs_proceso6=$("#obs_proceso6").val();
	//alert(obs_proceso6);

	if (!superficieResultante2) {//false
		ban=1;

	}

	if (fechaEntregaDelegacion == null && fechaEntregaDelegacion2 != null || fechaEntregaDelegacion == "" && fechaEntregaDelegacion2 != ""){
		fechaEntregaDelegacion3 = fechaEntregaDelegacion2;

	}else if (fechaEntregaDelegacion != null && fechaEntregaDelegacion2 == null || fechaEntregaDelegacion != "" && fechaEntregaDelegacion2 == ""){
		fechaEntregaDelegacion3 = fechaEntregaDelegacion;
	}else{
		fechaEntregaDelegacion3 = '1999-01-01 00:00:00-06';
	}

	////costo que quede sin signo de pesos y sin la coma

		var costoTotal1 = $("#costoTotal").val();
		if (costoTotal1 == null || costoTotal1 == "") {
			costoTotal = "";

		}else{
			var costoTotal2 = costoTotal1.replace('$', '');
  			var costoTotal3 = costoTotal2.replace(',', '');
  			costoTotal = costoTotal3; 
		}
        /////////////////////////////diferencia que quede sin signo de pesos y sin la coma///////////////////////////////////////
		var diferencias1 = $("#diferencias").val();
		if (diferencias1 == null || diferencias1 == "") {
			diferencias = "";

		}else{
			var diferencias2 = diferencias1.replace('$', '');
  			var diferencias3 = diferencias2.replace(',', '');
  			diferencias = diferencias3; 
		}



		if (diDeRe == null || diDeRe == "") {
			diDeRe=0;
		}

  		////////////////////////////////////////////////////////////////////////////////////////////////

  		if (ban == 1) { //mal
  			document.getElementById("superficieResultante").style.borderColor="#e12454";
  		}else{

  			document.getElementById("superficieResultante").style.borderColor="#223a66";
  			$.post("../../acceso/route.php",{acceess:72,fechaEntregaDelegacion3:fechaEntregaDelegacion3,superficieResultante:superficieResultante,
	 	costoTotal:costoTotal,diferencias:diferencias,diDeRe:diDeRe,foliodiDeRe:foliodiDeRe,idFolioSiete:idFolioSiete, obs_proceso6:obs_proceso6},function(yz){

	 		if (yz == 100 || yz == "100") {
	 			//registro correcto
	 			$("#procesoSeisInfo").modal('hide'); 
	 			$("#registroBien").modal('show'); 
	 		}else{
	 			//existio algun error
	 		}

	 });

  		}

	 


} 

function terminarProcesoSiete(){ 

	var fechaEntregaDelegacion = $("#fechaentregaDelegacion").val(); //*
	var fechaEntregaDelegacion2 = $("#fechaentregaDelegacion2").val(); //*
	var fechaEntregaDelegacion3 = "";//*
	var superficieResultante = $("#superficieResultante").val();//*
	var superficieResultante2 = validarSuperficie2();
	var costoTotal = "";//*
	var diferencias = "";//*
	var diDeRe = $("#diDeRe").val();//*
	var foliodiDeRe = $("#foliodiDeRe").val();
	var idFolioSiete = $("#folioUnoId").val();

	var obs_proceso6 = $("#obs_proceso6").val();

	var ban=0;

	if (fechaEntregaDelegacion == null && fechaEntregaDelegacion2 != null || fechaEntregaDelegacion == "" && fechaEntregaDelegacion2 != ""){
		fechaEntregaDelegacion3 = fechaEntregaDelegacion2;

	}else if (fechaEntregaDelegacion != null && fechaEntregaDelegacion2 == null || fechaEntregaDelegacion != "" && fechaEntregaDelegacion2 == ""){
		fechaEntregaDelegacion3 = fechaEntregaDelegacion;
	}else{
		fechaEntregaDelegacion3 = '1999-01-01 00:00:00-06';
		ban=1;
	}

	////costo que quede sin signo de pesos y sin la coma

		var costoTotal1 = $("#costoTotal").val();
		if (costoTotal1 == null || costoTotal1 == "" || costoTotal1 == "$NaN" || costoTotal1 == "NaN") {
			costoTotal = "";
			ban=1;

		}else{ 
			var costoTotal2 = costoTotal1.replace('$', '');
  			var costoTotal3 = costoTotal2.replace(',', '');
  			costoTotal = costoTotal3; 
		}
/////////////////////////////diferencia que quede sin signo de pesos y sin la coma///////////////////////////////////////
		var diferencias1 = $("#diferencias").val();
		if (diferencias1 == null || diferencias1 == "" || diferencias1 == "$NaN" || diferencias1 == "NaN") {
			diferencias = "";
			ban=1;

		}else{
			var diferencias2 = diferencias1.replace('$', '');
  			var diferencias3 = diferencias2.replace(',', '');
  			diferencias = diferencias3; 
		}

  		///////////////////validar las otras variables/////////////////////////////////////////////////////////////////////////////
  		////ERICK
  		////Aquí, si la diferencia es cero, eliminar las variables que no aparecen debido a esta opción ERICK tienes que hacer esto, para que guarde
  		if(diferencias!=0){
  			if (superficieResultante == null || superficieResultante == "" || diDeRe == 0 || foliodiDeRe == null || foliodiDeRe == "" || !superficieResultante2) {
	  			ban=1;
	  		}
  		}else{
  			if (superficieResultante == null || superficieResultante == "" || !superficieResultante2) {
	  			ban=1;
	  		}
  		}
   		// 	if (superficieResultante == null || superficieResultante == "" || diDeRe == 0 || foliodiDeRe == null || foliodiDeRe == "" || !superficieResultante2) {
  		// 	ban=1;
  		// }



  		if (ban == 1) {
  			//falta registrar informacion
  			$("#registrosFaltantes").modal('show');
  			$("#procesoSeisInfo").modal('hide'); 

  		}else{
  			//terminar proceso

  			 $.post("../../acceso/route.php",{acceess:70,fechaEntregaDelegacion3:fechaEntregaDelegacion3,superficieResultante:superficieResultante,
	 	costoTotal:costoTotal,diferencias:diferencias,diDeRe:diDeRe,foliodiDeRe:foliodiDeRe,idFolioSiete:idFolioSiete, obs_proceso6:obs_proceso6 },function(yz){

	 		if (yz == 100 || yz == "100") {
	 			//registro correcto
	 			$("#procesoSeisInfo").modal('hide'); 
	 			$("#procesoTerminado").modal('show'); 
	 		}else{
	 			//existio algun error
	 		}

	 });

  		}
}

function actualizarProcesoOcho(){

	var fechaNotiConcluido = $("#fechaNotiConcluido").val(); 
	var fechaNotiConcluido2 = $("#fechaNotiConcluido2").val(); 
	var fechaNotiConcluido3 = "";

	var fechaEntregaSolicitante = $("#fechaEntregaSolicitante").val(); 
	var fechaEntregaSolicitante2 = $("#fechaEntregaSolicitante2").val(); 
	var fechaEntregaSolicitante3 = "";

	var idRegistroUnico = $("#idRegistro7").val();

	var observaciones_entrega=$("#observaciones_entrega_cliente").val();


	if(fechaNotiConcluido == null && fechaNotiConcluido2 != null || fechaNotiConcluido == "" && fechaNotiConcluido2 != ""){
		fechaNotiConcluido3 = fechaNotiConcluido2;

	}else if(fechaNotiConcluido != null && fechaNotiConcluido2 == null || fechaNotiConcluido != "" && fechaNotiConcluido2 == ""){
		fechaNotiConcluido3 = fechaNotiConcluido;
	}else{
		fechaNotiConcluido3 = '1999-01-01';
	}

	////////////////////////////////////////////////////////////////////////

	if(fechaEntregaSolicitante == null && fechaEntregaSolicitante2 != null || fechaEntregaSolicitante == "" && fechaEntregaSolicitante2 != ""){
		fechaEntregaSolicitante3 = fechaEntregaSolicitante2;

	}else if(fechaEntregaSolicitante != null && fechaEntregaSolicitante2 == null || fechaEntregaSolicitante != "" && fechaEntregaSolicitante2 == ""){
		fechaEntregaSolicitante3 = fechaEntregaSolicitante;
	}else{  
		fechaEntregaSolicitante3 = '1999-01-01';
	}

	////////////////////////////////////////////////////////////////////////////////////////////////

	 $.post("../../acceso/route.php",{acceess:69,fechaNotiConcluido3:fechaNotiConcluido3,
	 	fechaEntregaSolicitante3:fechaEntregaSolicitante3,idRegistroUnico:idRegistroUnico, observaciones_entrega:observaciones_entrega},function(yz){

	 		if (yz == 100 || yz == "100") {
	 			//registro correcto
	 			$("#procesoSieteInfo").modal('hide'); 
	 			$("#registroBien").modal('show'); 
	 		}else if(yz == 10 || yz == "10"){
	 			//el folio no esta registrado.
	 			$("#registroSinProesoAnterior").modal('show'); 

	 		}else{
	 			//existio algun error
	 		}

	 });


} 

function entregaSolicitante(){
		
		var idFolioSiete = $("#idRegistro7").val();

		$.post("../../acceso/route.php",{acceess:71,idFolioSiete:idFolioSiete},function(yz){ 

			if (yz == 100 || yz == "100") {
				//sin registro
			}else{
				//con registros
				$(yz).each(function(key,valuee){

					//if (valuee.fechanotificacionconcluido=='1999-01-01 00:00:00-06' || valuee.fechanotificacionconcluido==null || valuee.fechanotificacionconcluido=='1999-01-01 07:00:00+01'){///linea original
					if (valuee.fechanotificacionconcluido=='01-01-1999' || valuee.fechanotificacionconcluido==null){///linea original
						$("#fechaNotiConcluido").show();
						$("#fechaNotiConcluido2").hide();
						//$("#fechaentregaDelegacion").val();

					}else{
						$("#fechaNotiConcluido").hide();
						$("#fechaNotiConcluido2").show();
						//$("#fechaNotiConcluido2").val(valuee.fechanotificacionconcluido);///linea original
						$("#fechaNotiConcluido2").val( moment(valuee.fechanotificacionconcluido).format('DD-MM-YYYY') );
					}

					/////////////////////////////////////


					//if (valuee.fechaentregasol == '1999-01-01 00:00:00-06' || valuee.fechaentregasol == null ||  valuee.fechaentregasol == '1999-01-01 07:00:00+01') {///linea original
					if ( moment(valuee.fechaentregasol).format('DD-MM-YYYY') == '01-01-1999' || valuee.fechaentregasol == null ) {	
						$("#fechaEntregaSolicitante").show();
						$("#fechaEntregaSolicitante2").hide();
						//$("#fechaentregaDelegacion").val();

					}else{
						$("#fechaEntregaSolicitante").hide();
						$("#fechaEntregaSolicitante2").show();
						//$("#fechaEntregaSolicitante2").val(valuee.fechaentregasol);///linea original
						$("#fechaEntregaSolicitante2").val( moment(valuee.fechaentregasol).format('DD-MM-YYYY') );
					}

					$("#observaciones_entrega_cliente").val(valuee.observaciones_entrega_cliente);

				 });
			}

		});

}

function terminarProcesoOcho(){

	var fechaNotiConcluido = $("#fechaNotiConcluido").val(); 
	var fechaNotiConcluido2 = $("#fechaNotiConcluido2").val(); 
	var fechaNotiConcluido3 = "";

	var fechaEntregaSolicitante = $("#fechaEntregaSolicitante").val(); 
	var fechaEntregaSolicitante2 = $("#fechaEntregaSolicitante2").val(); 
	var fechaEntregaSolicitante3 = "";

	var idRegistroUnico = $("#idRegistro7").val();

	var observaciones_entrega=$("#observaciones_entrega_cliente").val();
	var ban = 0;


	if(fechaNotiConcluido == null && fechaNotiConcluido2 != null || fechaNotiConcluido == "" && fechaNotiConcluido2 != ""){
		fechaNotiConcluido3 = fechaNotiConcluido2;

	}else if(fechaNotiConcluido != null && fechaNotiConcluido2 == null || fechaNotiConcluido != "" && fechaNotiConcluido2 == ""){
		fechaNotiConcluido3 = fechaNotiConcluido;
	}else{
		fechaNotiConcluido3 = '1999-01-01 00:00:00-06';
		ban=1;
	}

	////////////////////////////////////////////////////////////////////////

	if(fechaEntregaSolicitante == null && fechaEntregaSolicitante2 != null || fechaEntregaSolicitante == "" && fechaEntregaSolicitante2 != ""){
		fechaEntregaSolicitante3 = fechaEntregaSolicitante2;

	}else if(fechaEntregaSolicitante != null && fechaEntregaSolicitante2 == null || fechaEntregaSolicitante != "" && fechaEntregaSolicitante2 == ""){
		fechaEntregaSolicitante3 = fechaEntregaSolicitante;
	}else{  
		fechaEntregaSolicitante3 = '1999-01-01 00:00:00-06';
		ban=1;
	}

	////////////////////////////////////////////////////////////////////////////////////////////////


	if(ban==1) {
			//hace falta capturar un registro
	}else{
		//con registroos , continuar
		 $.post("../../acceso/route.php",{acceess:68,fechaNotiConcluido3:fechaNotiConcluido3,
		 	fechaEntregaSolicitante3:fechaEntregaSolicitante3,idRegistroUnico:idRegistroUnico,observaciones_entrega:observaciones_entrega},function(yz){

	 		if (yz == 100 || yz == "100") {
	 			//registro correcto
	 			$("#procesoSieteInfo").modal('hide'); 
	 			$("#procesoTerminado").modal('show'); 
	 		}else if(yz == 10 || yz == "10"){
	 			//el folio no esta registrado.
	 			$("#registroSinProesoAnterior").modal('show'); 

	 		}else{
	 			//existio algun error
	 		}

	 });

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

	 $.post("../../acceso/route.php",{acceess:67,fechaResguardo3:fechaResguardo3,
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

function mostrarProcesoOcho(){
		
		var idFolioSiete = $("#idRegistro8").val();

		$.post("../../acceso/route.php",{acceess:66,idFolioSiete:idFolioSiete},function(yz){ 

			if (yz == 100 || yz == "100") {
				//sin registro
			}else{
				//con registros
				$(yz).each(function(key,valuee){

					if (valuee.fechaderesguardo == '1999-01-01 00:00:00-06') {
						$("#fechaResguardo").show();
						$("#fechaResguardo2").hide();

					}else{
						$("#fechaResguardo").hide();
						$("#fechaResguardo2").show();
						//$("#fechaResguardo2").val(valuee.fechaderesguardo);///linea original
						$("#fechaResguardo2").val( moment(valuee.fechaderesguardo).format('DD-MM-YYYY') );
					}

					/////////////////////////////////////
					$("#oficioResguardoGeo").val(valuee.folioderesguardo);
					$("#observacionesC").val(valuee.observaciones);

				 });
			}

		});

} 
function terminarProCerrado(){

	var fechaResguardo = $("#fechaResguardo").val(); 
	var fechaResguardo2 = $("#fechaResguardo2").val(); 
	var fechaResguardo3 = "";
	var oficioResguardoGeo = $("#oficioResguardoGeo").val(); 
	var observacionesC = $("#observacionesC").val(); 
	var idRegistroUnico = $("#idRegistro8").val();
	var ban=0;


	if(fechaResguardo == null && fechaResguardo2 != null || fechaResguardo == "" && fechaResguardo2 != ""){
		fechaResguardo3 = fechaResguardo2;

	}else if(fechaResguardo != null && fechaResguardo2 == null || fechaResguardo != "" && fechaResguardo2 == ""){
		fechaResguardo3 = fechaResguardo;
	}else{
		fechaResguardo3 = '1999-01-01 00:00:00-06';
		ban=1;
	}

	////////////////////////////////////validar las variables restantes////////////////////////////////////////////////////////////

	if (oficioResguardoGeo == null || oficioResguardoGeo == "") {
		ban=1;
	}




	if (ban==1) {
		//faltan registrar datos

	}else{ 
		//cuenta con toda la informacion, continuar
		$.post("../../acceso/route.php",{acceess:65,fechaResguardo3:fechaResguardo3,
	 	oficioResguardoGeo:oficioResguardoGeo,observacionesC:observacionesC,idRegistroUnico:idRegistroUnico},function(yz){

	 		if (yz == 100 || yz == "100") {
	 			//registro correcto
	 			$("#procesoOchoInfo").modal('hide'); 
	 			$("#procesoTerminadoFin").modal('show');  
	 		}else if(yz == 10 || yz == "10"){
	 			//el folio no esta registrado.
	 			$("#registroSinProesoAnterior").modal('show'); 

	 		}else{
	 			//existio algun error
	 		}

	 });
	}

} 

function mostarStatusAll9(){
	var x = document.getElementById("procesoNueve2");
  if (x.style.display === "none") {
    x.style.display = "block";
  } else {
    x.style.display = "none";
  }
}
function mostarStatusAll3(){
	var x = document.getElementById("procesoTres2");
  if (x.style.display === "none") {
    x.style.display = "block";
  } else {
    x.style.display = "none";
  }
}

function mostarStatusAll4(){
	var x = document.getElementById("procesoCuatro2");
  if (x.style.display === "none") {
    x.style.display = "block";
  } else {
    x.style.display = "none";
  }
} 

function mostarStatusAll5(){
	var x = document.getElementById("procesoCinco2");
  if (x.style.display === "none") {
    x.style.display = "block";
  } else {
    x.style.display = "none";
  }
}

function mostarStatusAll6(){
	var x = document.getElementById("procesoSeis2");
  if (x.style.display === "none") {
    x.style.display = "block";
  } else {
    x.style.display = "none";
  }
}

function mostarStatusAll7(){
	var x = document.getElementById("procesoSiete2");
  if (x.style.display === "none") {
    x.style.display = "block";
  } else {
    x.style.display = "none";
  }
}

function mostarStatusAll8(){
	var x = document.getElementById("procesoOcho2");
  if (x.style.display === "none") {
    x.style.display = "block";
  } else {
    x.style.display = "none";
  }
}

function anioSelect(){
	
	var fechaa = $("#fecha").val();
	var anio = fechaa.split("-", 1);
	var aa = "";
	if (anio == '2022' || anio == "2022") {
		aa = "22";
	}else if (anio == '2023' || anio == "2023") {
		aa = "23";
	}
	$("#ani").val(aa);
	console.log(aa); 
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
		$.post("../../acceso/route.php",{acceess:94,folioRegistro:folioRegistro},function(yz){ 

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
		$.post("../../acceso/route.php",{acceess:94,folioRegistro:folioRegistro},function(yz){ 

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
		$.post("../../acceso/route.php",{acceess:94,folioRegistro:folioRegistro},function(yz){ 

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
	 	/*$.post("../../acceso/route.php",{acceess:91,folioRegistro:folioRegistro},function(yz){ 

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
		$.post("../../acceso/route.php",{acceess:94,folioRegistro:folioRegistro},function(yz){ 

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
		$.post("../../acceso/route.php",{acceess:94,folioRegistro:folioRegistro},function(yz){ 

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
		$.post("../../acceso/route.php",{acceess:94,folioRegistro:folioRegistro},function(yz){ 

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
  		$.post("../../acceso/route.php",{acceess:91,folioRegistro3:folioRegistro3},function(yz){ 

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
		$.post("../../acceso/route.php",{acceess:94,folioRegistro:folioRegistro},function(yz){ 

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
  		$.post("../../acceso/route.php",{acceess:91,folioRegistro3:folioRegistro3},function(yz){ 

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
		$.post("../../acceso/route.php",{acceess:94,folioRegistro:folioRegistro},function(yz){ 

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

  		$.post("../../acceso/route.php",{acceess:91,folioRegistro3:folioRegistro3},function(yz){ 

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
  		$.post("../../acceso/route.php",{acceess:66,idFolioSiete:idFolioSiete},function(yz){ 

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
