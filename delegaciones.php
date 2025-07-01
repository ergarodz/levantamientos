<?php 

  if (session_status() == PHP_SESSION_NONE) { session_start(); }

  if (!isset($_SESSION["id_userAg"])) {
      header("Location: index.php");  
  }
  //echo json_encode($_SESSION);
  $_SESSION["id_userAg"];

  require_once 'Ops2.php';
  $erick=new Ops2();

  //echo json_encode($_SESSION);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>Levantamiento Topografico</title>
  <link rel="stylesheet" href="plugins/bootstrap/bootstrap.min.css">
  <link rel="stylesheet" href="plugins/icofont/icofont.min.css">
  
  <link rel="icon" type="image/png" sizes="16x16" href="images/favicon.ico"> 

  <script src="plugins/jquery/jquery.js"></script>
  <script src="plugins/bootstrap/bootstrap.min.js"></script> 
  <script src="js/script.js"></script>

  <script src="js/lt.js"></script>
  <link href="css/loader.css" rel="stylesheet" type="text/css" />

  <script src="https://momentjs.com/downloads/moment-with-locales.min.js"></script>

  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>

  <link rel="stylesheet" href="css/style.css"> 

  <script type="text/javascript" >

      window.location.hash="no-back-button";
      window.location.hash="Again-No-back-button" //chrome
      window.onhashchange=function(){window.location.hash=""; 
  } 
  </script>

</head>
<body id="top">

  <!-- Loader Overlay -->
	<div id="loader">
		<div id="loader-spinner"></div>
	</div>

<?php require_once 'menu.php';?>
<!-- <header>
	<div class="header-top-bar">
		<div class="" align="center">
			<div class="row align-items-center">
				<div class="col-lg-3">
				<a class="navbar-brand" >
				<img src="images/igecem.png" alt="" class="img-fluid" width="50" height="50"> 
				</a>
				</div>
				<div class="col-lg-6">
					<p style="font-size: xx-large; text-align: center;"><b>LEVANTAMIENTOS TOPOGRÁFICOS</b></p>
					<input type="text" name="delegacion" id="delegacion" style="display: none;" value="<?php echo $_SESSION["abrev"]; ?>">
					<input type="text" name="iddelegacion" id="iddelegacion" style="display: none;" value="<?php echo $_SESSION["id_userAg"]; ?>">
					<?php 
					$anio = date('Y');
  					$anio2 = substr($anio, -2);
					?>
					<input type="hidden" name="anioAct" id="anioAct" value="<?php echo $anio2; ?>">

          <input type="text" hidden="" id="tipo_usr" value="<?php echo $_SESSION['tipo_usr'];?>">

				</div>
				<div class="col-lg-3"></div>
			</div>
		</div>

    <div class="row" style="background-color: #8a2034;">
        <div class="col-md-3">
          <p style="text-align:left; color:white; font-size:x-large; margin-top:10px; font-weight:bold;">&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;DELEGACIÓN <?php echo $_SESSION["username"]; ?></p>
        </div>
        <div class="col-md-6"></div>
        <div class="col-md-1" style="margin-top:10px;"></div>
        <div class="col-md-1" style="margin-top:10px;">
            <a href="delegaciones.php" title="Inicio"><i class="icofont-home icofont-3x" style="color:white;"></a></i>
        </div>
        <div class="col-md-1" style="margin-top:10px;">
            <a class="" data-toggle="modal" data-target="#myModal" style="color:white; cursor:pointer;" title="Cerrar Sesión"><i class="icofont-sign-out icofont-3x"></i></a> 
        </div>        
    </div>
	</div>      
</header> -->

<?php require_once 'modals.php';?>
<?php require_once 'modals_ad_ok.php';?>
<?php require_once 'modals_cerrar.php';?>
  

   <div class="modal fade" id="procesoCanceladoUno" role="dialog">
    <div class="modal-dialog">
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
        	 <h4 class="modal-title">Registro exitoso</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
         
        </div>
        <div class="modal-body">
        	<center>
        		<img src="images/about/ok.jpg" width="70" height="70">
        	</center>
        	
          <p>Los datos han sido registrados correctamente y el proceso ha sido cancelado</p>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn" data-dismiss="modal" onclick="ok();" style="background-color: #223a66; color: white;">Ok</button>
        </div>
      </div>
      
    </div>
  </div>


   <div class="modal fade" id="procesoCanceladoError" role="dialog">
    <div class="modal-dialog">
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
        	 <h4 class="modal-title">Registro exitoso.</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
         
        </div>
        <div class="modal-body">
        	<center>
        		<img src="images/about/adver.png" width="70" height="70">
        	</center>
        	
          <p>Ha ocurrido un error, vuelva a intentar.</p>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn" data-dismiss="modal" onclick="ok();" style="background-color: #223a66; color: white;">Ok</button>
        </div>
      </div>
      
    </div>
  </div>

<section class="banner">
	<div class="container">
		<div class="row">
			<div class="col-lg-6 col-md-12 col-xl-7">
				<div class="block">
					<!-- <div class="divider mb-3"></div> -->
					<span class="text-uppercase text-sm letter-spacing ">Registros</span> 
					<h1 class="mb-3 mt-3">Levantamientos Topográficos</h1>
					
					<!--<p class="mb-4 pr-5">A repudiandae ipsam labore ipsa voluptatum quidem quae laudantium quisquam aperiam maiores sunt fugit, deserunt rem suscipit placeat.</p> -->
					
				</div>
			</div>
		</div>
	</div>
</section>

<section class="features">
	<div class="" style="margin-left: 14%; margin-right: 14%;">
		<div class="row">
			<div class="col-lg-12">
				<div class="feature-block d-lg-flex">
						<div class="feature-item mb-5 mb-lg-0">
						<div class="feature-icon mb-4">
							<i class="icofont-page"></i>
						</div>
					
						<h4 class="mb-3">Nuevo Registro</h4>
						<p class="mb-4">Capturar información para la primera etapa del proceso</p>

						<center>
							<a class="btn btn-main btn-round-full" onclick="newRegistro();" id="newRegistro">Capturar información</a>
						</center>
              <div id="agregarInformacion" style="display: none;">
                <center><label style="text-align: center; color: #223a66;">Datos del solicitante</label><br> </center>
                <form id="validationForm" name="validationForm" method="post">
                  <div>
                    Nombre:<input type="text" name="nombreSo" id="nombreSo" style="border-color: #223a66; border-top: none; border-left: none; border-right: none; width: 192px;"
                          onkeypress="ocultar_mensajes_error();" required="">
                    <br><br>
                    Apellido Paterno:<input type="text" name="aPaterno" id="aPaterno" style="border-color: #223a66; border-top: none; border-left: none; border-right: none; width: 170px; width: 133px;"
                          onkeypress="ocultar_mensajes_error();" required="">
                    <br><br>
                    Apellido Materno:<input type="text" name="aMaterno" id="aMaterno" style="border-color: #223a66; border-top: none; border-left: none; border-right: none; width: 170px; width: 132px;"
                          onkeypress="ocultar_mensajes_error();" required="">
                    <br>
                  </div>                    
                
                  <div class="errormsg" id="message" name="message" style="color: #c22708; display:none;" >Ingresar datos del solicitante</div>
                  <br>
                  <div>
                    <center>
                      ¿Cuenta con clave catastral?
                      <div action="#">
                        <input style="width:20px; height:20px;" type="radio" id="claveSi" name="ValorClaveSN" value="1" onclick="clic_radio_si();">
                        <label for="si">Si</label><br>
                        <input style="width:20px; height:20px;" type="radio" id="claveNo" name="ValorClaveSN" value="2" onclick="clic_radio_no();">
                        <label for="no">No</label><br>
                      </div>
                      <input type="hidden" name="valorDeRadion" id="valorDeRadion" value="0">
                    </center>  

                    <div class="errormsg" id="error_radio" style="display: none;">
                      <label style="border: none; color: #e12454; text-align: center;">Seleccione valor para clave catastral</label>
                    </div>                 
                  </div>
                  <div id="RegistroMunicipio" style="display: none;">
                     Municipio : <select name="munn" id="munn" style="width: 170px;">
                          <?php $municipios=$erick->listadoMunicipios_er(); 
                            foreach ($municipios as $mun) {
                            
                          ?>
                          <option value="<?php echo $mun->num; ?>"><?php echo $mun->municipio; ?></option>
                          <?php } ?>
                            
                         </select>
                     <br>
                  </div>
                  <div id="registroClave" style="display: none;">
                    Clave catastral:<input type="text" name="cclave" id="cclave" style="border-color: #223a66; height: 50px; border-top: none; border-left: none; border-right: none; display: none;">
                    <div class="row">
                      <div class="col-md-2">
                        <div class="form-group">
                          <input type="text" onkeypress="ocultar_mensajes_error();" onkeyup="this.value=entero(this.value); municip();" onchange="()" 
                            id="c_muni" name="c_muni" class="form-control" placeholder="MUN" title="Escriba clave de municipio" maxlength="3" style="text-align: left; width:55px; font-size:8pt;">
                        </div>
                      </div>
                                        
                      <div class="col-md-2">
                        <div class="form-group">
                          <input type="text" onkeypress="ocultar_mensajes_error();" onkeyup="this.value=entero(this.value);" onchange="contarLim(1);" 
                            id="c_zona" name="c_zona" class="form-control" placeholder="ZN" title="Escriba clave de Zona" maxlength="2" style="text-align: left; width:55px; font-size:8pt;">
                        </div>
                      </div>

                      <div class="col-md-2">
                        <div class="form-group">
                            <input type="text" onkeypress="ocultar_mensajes_error();" onkeyup="this.value=entero(this.value);"  onchange="contarLim(2);" 
                              class="form-control" id="c_manz" name="c_manz" placeholder="MZN" title="Escriba clave de Manzana" maxlength="3" style="text-align: left; width:55px; font-size:8pt;">
                        </div>
                      </div>
                      <div class="col-md-2">
                        <div class="form-group">
                          <input type="text" onkeypress="ocultar_mensajes_error();" onkeyup="this.value=entero(this.value);" onchange="contarLim(3);" 
                            class="form-control" id="c_lote" name="c_lote" placeholder="LT" title="Escriba clave de Lote" maxlength="2" style="text-align: left; width:55px; font-size:8pt;">
                        </div>
                      </div>
                      <div class="col-md-2">
                        <div class="form-group">
                          <input type="text" onkeypress="ocultar_mensajes_error();" onkeyup="this.value=entero_letras(this.value);" onchange="contarLim(4);" 
                            class="form-control" id="c_edif" name="c_edif" placeholder="ED" title="Escriba clave de Edificio" maxlength="2" style="text-align: left; width:55px; font-size:8pt;">
                        </div>
                      </div>
                                      
                      <div class="col-md-2">
                        <div class="form-group">
                          <input type="text" onkeypress="ocultar_mensajes_error();" onkeyup="this.value=entero_letras(this.value);" onchange="contarLim(5);" 
                            class="form-control"  id="c_dept" name="c_dept" placeholder="DPTO" title="Escriba clave de Depto" maxlength="4" style="text-align: left; width:55px; font-size:8pt;">
                        </div>
                      </div>

                    </div> 

                    <div class="errormsg" id="errormuni2" style="display: none;">
                      <label style="border: none; color: #e12454; text-align: center;">Ingresar correctamente el Código Zona (2 Digitos)</label>
                    </div>
                    <div class="errormsg" id="errormuni3" style="display: none;">
                      <label style="border: none; color: #e12454; text-align: center;">Ingresar correctamente el Código Manzana Catastral (3 Digitos)</label>
                    </div>
                    <div class="errormsg" id="errormuni4" style="display: none;">
                      <label style="border: none; color: #e12454; text-align: center;">Ingresar correctamente el Código Lote Catastral (2 Digitos)</label>
                    </div>
                    <div class="errormsg" id="errormuni5" style="display: none;">
                      <label style="border: none; color: #e12454; text-align: center;">Ingresar correctamente el Código edificio Catastral (2 Caracteres)</label>
                    </div>
                    <div class="errormsg" id="errormuni6" style="display: none;">
                      <label style="border: none; color: #e12454; text-align: center;">Ingresar correctamente el Código departamento Catastral (4 Caracteres)</label>
                    </div>
                    <div class="errormsg" id="errorccat" style="display: none;">
                      <label style="border: none; color: #e12454; text-align: center;">Ingresar correctamente la clave catastral</label>
                    </div>
                    
                    Municipio : <input type="text" name="c_muni2" id="c_muni2" style="border-top: none; border-left: none; border-right: none; width: 170px;" readonly="">
                               
                    <label class="errormsg" id="errormuni" style="border: none; color: #e12454; display: none; text-align: center;">Ingresar correctamente el dato de municipio en la clave catastral</label>

                    <br>
                  </div>          
                  <br>
                  Recepción : 
                  <input type="date" name="fecha" id="fecha" style="border-color: #223a66; width: 165px;" min="2024-03-19" max="2026-03-15"  onchange="ocultar_mensajes_error();anioSelect();limpiar_anticipo();" required="">
                  <div class="errormsg" id="mensaje_error_fecha_recepcion" style="display: none;">
                    <label style="color: #e12454; text-align: center;"><i class="icofont-exclamation-tringle"></i>Ingresar fecha de recepción</label>
                  </div>

                  <br><br>

                  <center><label style="text-align: center; color: #223a66;">Datos del propietario</label><br></center>
                   
                  <!--<input type="text" name="solicitante" id="solicitante" style="border-color: #223a66; border-top: none; border-left: none; border-right: none; width: 170px;"> -->
                  <div id="validationForm2" name="validationForm2" >
                    Nombre:<input type="text" name="nombreP" id="nombreP" style="border-color: #223a66; border-top: none; border-left: none; border-right: none; width: 192px;" required="">
                    <br><br>
                    Apellido Paterno:<input type="text" name="aPaternoP" id="aPaternoP" style="border-color: #223a66; border-top: none; border-left: none; border-right: none; width: 170px; width: 133px;" required="">
                    <br><br>
                    Apellido Materno:<input type="text" name="aMaternoP" id="aMaternoP" style="border-color: #223a66; border-top: none; border-left: none; border-right: none; width: 170px; width: 132px;" required="">
                    <br>
                    <div class="errormsg" id="message2" name="message2" style="color: #c22708; display:none;" >Ingresar datos del propietario</div>
                  </div>
                  <br><br>
                  <!-- onkeypress="return validaNumericos(event)" onchange="municip()" -->
                  <div id="superficieSP" name="superficieSP" >
                  	Superficie Inicial (M2):
                    <input type="text" name="supInicial" id="supInicial" 
                          onkeypress="ocultar_mensajes_error();" onkeyup="this.value=validarSuperficie_er(this.value); CalcularAnticipo();" 
                          style="border-color: #223a66; border-top: none; border-left: none; border-right: none; width: 93px;"
                          required="">
                  	<br>
                    <div class="errormsg" id="mensajeErrorSuperficie" style="display: none;">
                      <label style="color: #e12454; text-align: center;"><i class="icofont-exclamation-tringle"></i>Ingresar valor correcto en superficie</label>
                    </div>
                  </div>
                  Anticipo : 
                  <input type="text"  name="anticipo" id="anticipo" onkeypress="//return solonumeros(event)"
                          style="border-color: #223a66; border-top: none; border-left: none; border-right: none; width: 185px;" readonly="" required="" >
                  <br><br><br>

                  <center><label style="text-align: center; color: #223a66;">FUP (Número de control)</label><br>
                  	<span><label><?php echo  $_SESSION["abrev"]."-";?></label><input type="text" id="ani" name="ani" style="width: 30px; border: none; font-size: medium;"></span> 
                  	<input 
                      onkeypress="ocultar_mensajes_error();"
                      type="text" name="fupAs" id="fupAs" style="border-color: #223a66; border-top: none; border-left: none; border-right: none; width: 300px; width: 132px;" maxlength="4" required="">  
                  	<br><br>
                  </center>
                  <div class="errormsg" id="mensajeErrorNul" style="display: none;">
                  	<label style="color: #e12454; text-align: center;"><i class="icofont-exclamation-tringle"></i>Ingresar toda la información solicitada</label>
                  </div>
                  <div class="errormsg" id="mensajeErrorFupExistente" style="display: none;">
                  	<label style="color: #e12454; text-align: center;"><i class="icofont-exclamation-tringle"></i>El FUP ingresado ya esta registrado, verificar</label>
                  </div>
                  <center>
                    <a class="btn btn-main btn-round-full" onclick="prueba_guardar();//guardarRegistro();" id="guardarRegistro">Guardar</a>	
                  </center>
                </form>
              </div>
              <!-- Aqui termina la informacion a llenar en el ´primer paso, en la pestaña de la izquierda -->

							<div id="confirmacionGuardar" style="display: none;">
								<center><br>
										<label style="color: #28a745;"><i class="icofont-check icofont-2x"></i>Información guardada correctamente</label><br><br> 
								<label>El FUP registrado es:</label>
								<br>
								<input type="text" name="fupAsignado" id="fupAsignado"  style="border-color: #223a66; border-top: none; border-left: none; border-right: none;" readonly="">
								<br><br>
								<a class="btn btn-main btn-round-full" onclick="ok();" id="ok">OK</a>
								</center>
							</div>

              <div class="errormsg" id="mensajeErrorGuardar" style="display: none;">
                <label style="color: #e12454; text-align: center;"><i class="icofont-exclamation-tringle"></i>ERROR al guardar levantamiento</label>
              </div>
					</div>




					<div class="feature-item mb-5 mb-lg-0">
						<div class="feature-icon mb-4">
							<i class="icofont-edit"></i>
						</div>
						<span></span>
						<h4 class="mb-3">Proceso de registros</h4>
						<p class="mb-4">Continuar el registro de información ingresando número de FUP asignado</p>
						<div class="errormsg" id="fupNoRegistrado" style="display: none;"> 
							<label style="color: #e12454; text-align: center;"><i class="icofont-exclamation-tringle"></i>El FUP no cuenta con registro</label>
						</div> 
            <div align="center">
						  <a class="btn btn-main btn-round-full" onclick="ingresarFup();" id="btn-ingresaFup">Ingresar FUP</a>
            </div>
						<div id="ingresaFup" style="display: none;">
							<center>
								FUP: <input type="text" name="fup" id="fup" style="border-color: #223a66; border-top: none; border-left: none; border-right: none;" onkeyup=" buscaRegistro_enter();">
                    <i class="icofont-search-2 icofont-2x" id="seguirBusqueda" style="cursor: pointer; display: none;" onclick="buscaRegistro();" title="Buscar"></i>
								<br>
								 <input type="text" name="idRegistroE" id="idRegistroE" style="display: none;">
								<br>
								<div class="proceso_n" id="registroEncontrado" style="display: none;">
									Clave catastral:<input type="text" name="clavec" id="clavec" style="border-color: transparent; width: 150px;" readonly="">
									<br> 
								</div>

                  <?php //require_once 'modals.php'; ?>



                  <!-- SE UTILIZARÁ SOLO ESTE CODIGO PARA MANEJAR LOS PROCESOS DE LEVANTAMIENTOS -->
                  <div class="" id="control_proceso" style="display:block;"></div>                


                  	

								<a class="btn btn-main btn-round-full" onclick="buscaRegistro();" id="buscaRegistro">Buscar Registro</a>
							</center>							
						</div>
					</div>				
				
				
					<div class="feature-item mb-5 mb-lg-0">
						<div class="feature-icon mb-4">
							<i class="icofont-ui-folder"></i>
						</div>
						<h4 class="mb-3">Listado de registros</h4>
						<p>Información de todos los registros realizados</p>	
            <center>					
						  <a href="tablap.php" class="btn btn-main btn-round-full" id="buscaRegistro">Mostrar Listado</a>
            </center>
					</div>
				</div>
			</div>
		</div>
	</div>
</section> 

<footer class="footer section gray-bg">
	<div class="container">
	

		<div class="footer-btm py-4 mt-5">
			<div class="row align-items-center justify-content-between">
				<div class="col-lg-6">
					<div class="copyright">
					</div>
				</div>
				
			</div>

			<div class="row">
				<div class="col-lg-4">
					<a class="backtop scroll-top-to" href="#top">
						<i class="icofont-long-arrow-up"></i>
					</a>
				</div>
			</div>
		</div>
	</div>
</footer>    

</body>
</html>