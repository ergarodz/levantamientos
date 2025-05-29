<?php 

session_start();

if (!isset($_SESSION["id_userAg"])) {
    header("Location: index.php");
   
}

$_SESSION["id_userAg"];
//echo json_encode($_SESSION);
?>


<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>Levantamiento Topografico</title>
  <link rel="stylesheet" href="plugins/bootstrap/bootstrap.min.css">
  <link rel="stylesheet" href="plugins/icofont/icofont.min.css">
  <link rel="stylesheet" href="css/style.css"> 
  <link rel="icon" type="image/png" sizes="16x16" href="images/favicon.ico"> 
  <script type="text/javascript" >

      window.location.hash="no-back-button";
      window.location.hash="Again-No-back-button" //chrome
      window.onhashchange=function(){window.location.hash=""; } 
  </script>

</head>
<body id="top">
 
  <?php 

    require_once 'admon_menu.php';
    ///llama al modal con id myModal
    require_once 'modals_cerrar.php';
  ?>

  <div class="modal fade" id="myModal2" role="dialog">
    <div class="modal-dialog">
      <!-- Modal content-->
    <div class="modal-content">
        <div class="modal-header">
        	 <h5 class="modal-title">ENVIADO A TOPOGRAFIA</h5>
        	 <br>
        	 <input type="text" name="fup2" id="fup2" style="display: none;">
        	 <input type="text" name="idRegistro" id="idRegistro" style="display: none;">
             <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        <div class="modal-body">
        	<div class="row">
        		<div class="col-md-5"><label>Orden de trabajo:</label></div>
            <input type="hidden" name="inicioFolio" id="inicioFolio" value="<?php echo  $_SESSION["abrev"]."-".$anio2;?>">
        		<div class="col-md-7"><label><?php echo  $_SESSION["abrev"]."-".$anio2;?></label><input type="text" name="ordentrabajo" id="ordentrabajo" style="border-left: none; border-right: none; border-top: none; margin-top: -30px; width: 100px;"><br><br></div>
        		<div class="col-md-5">
        			<label>Fecha de envío al área de topografía:</label></div>
            	<div class="col-md-7">
            		<input type="text" name="fechaEnvio2" id="fechaEnvio2" style="display: none; border-left: none; border-right: none; border-top: none;" readonly="">
            		 <select name="fechaDeEnvio" id="fechaDeEnvio" onchange="fechaEnviop();" style="width: 145px; display: block;">
         				<option value="0" selected="" disabled="">Seleccionar</option>
         				<option value="1">Ingresar fecha</option>
  						<option value="2">Proceso</option>
  						<option value="3">Cancelado</option>
					</select>
					<br><br>
					 <input type="date" name="fechaEnvio" id="fechaEnvio" style="display: none;">
					 <br><br>
            	</div>	
            	<div class="col-md-5" id="oc"><label>Área productora:</label></div>
  				<div class="col-md-7" id="oc2">
  					<select name="areaProduc" id="areaProduc" style="width: 145px;">
  						<option value="0" selected="" disabled="">Seleccionar</option>
  						<option value="Geografia">Dir. Geografia</option>
  						<option value="Brigada">Brigada delegación</option>
					</select><br>
				</div>
               
        	</div>
         <br>
		
		
        </div>
        <div class="modal-footer" id="butBien">
          <button type="button" class="btn btn-primary"  data-toggle="modal" data-target="#registroBien" id="actualizarDos" onclick="actualizarProceso();">Guardar</button>
          <button type="button" class="btn" id="terminoProcDos" style="background: #223a66; color: white;" onclick="terminarProcesoDos();">Terminar Proceso</button>
        </div>
        <div class="modal-footer" id="butMal" style="display: none;">
        	<button type="button" class="btn" style="background: #223a66; color: white;" onclick="ok();">Ok</button>
        </div>
      </div>
      
    </div>
  </div>

  <div class="modal fade" id="registroBien" role="dialog">
    <div class="modal-dialog">
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
        	 <h4 class="modal-title">Registro exitoso.</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        <div class="modal-body">
        	<center>
        		<img src="../images/about/ok.jpg" width="70" height="70">
        	</center> 
          <p>Los datos han sido registrados correctamente, vuelva pronto para terminar el proceso.</p>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn" data-dismiss="modal" onclick="ok();" style="background-color: #223a66; color: white;">Ok</button>
        </div>
      </div>
    </div>
  </div>

    <div class="modal fade" id="procesoTerminado" role="dialog">
    <div class="modal-dialog">
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
        	 <h4 class="modal-title">Registro exitoso.</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
         
        </div>
        <div class="modal-body">
        	<center>
        		<img src="../images/about/ok.jpg" width="70" height="70">
        	</center>
        	
          <p>Los datos han sido registrados correctamente y puede continuar con el siguiente proceso.</p>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn" data-dismiss="modal" onclick="ok();" style="background-color: #223a66; color: white;">Ok</button>
        </div>
      </div>
      
    </div>
  </div>
  <div class="modal fade" id="procesoTerminadoFin" role="dialog">
    <div class="modal-dialog">
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
           <h4 class="modal-title">Registro exitoso.</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
         
        </div>
        <div class="modal-body">
          <center>
            <img src="../images/about/ok.jpg" width="70" height="70">
          </center>
          
          <p>Los datos han sido registrados correctamente y ha concluido con todos los procesos</p>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn" data-dismiss="modal" onclick="ok();" style="background-color: #223a66; color: white;">Ok</button>
        </div>
      </div>
      
    </div>
  </div>
  <div class="modal fade" id="registrosFaltantes" role="dialog">
    <div class="modal-dialog">
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
        	 <h4 class="modal-title">Registros faltante.</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
         
        </div>
        <div class="modal-body">
        	<center>
        		<img src="../images/about/adver.png" width="70" height="70">
        	</center>
        	
          <p>Para terminar este proceso es necesario registrar toda la información solicitada.</p>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn" style="background-color: #223a66; color: white;" onclick="cerrarM();">Ok</button>
        </div>
      </div>
      
    </div>
  </div>
   <div class="modal fade" id="registrosFaltantesFecha" role="dialog">
    <div class="modal-dialog">
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
           <h4 class="modal-title">Registros faltante.</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
         
        </div>
        <div class="modal-body">
          <center>
            <img src="../images/about/adver.png" width="70" height="70">
          </center>
          
          <p>Para continuar con el proceso es necesario registrar la fecha solicitada.</p>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn" style="background-color: #223a66; color: white;" onclick="cerrarM();">Ok</button>
        </div>
      </div>
      
    </div>
  </div>

  <div class="modal fade" id="registroSinProesoAnterior" role="dialog">
    <div class="modal-dialog">
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
           <h4 class="modal-title">Registros faltante.</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
         
        </div>
        <div class="modal-body">
          <center>
            <img src="../images/about/adver.png" width="70" height="70">
          </center>
          
          <p>sonsulte con su administrador ya que tiene un registro faltante en la etapa anterior</p>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn" style="background-color: #223a66; color: white;" onclick="cerrarM();">Ok</button>
        </div>
      </div>
      
    </div>
  </div>

    <div class="modal fade" id="procesoTresInfo" role="dialog">
    <div class="modal-dialog">
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
        	 <h4 class="modal-title">NOTIFICADO.</h4>
        	 <input type="text" name="idRegistro3" id="idRegistro3" style="display: none;">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
         
        </div>
        <div class="modal-body">
        	<div class="row">
        		<div class="col-md-5">Anticipo</div>
        		<div class="col-md-7"><input type="text" name="anticip" id="anticip" style="border-left: none; border-right: none; border-top: none; margin-top: -30px;" readonly=""><br><br></div>
        		<div class="col-md-5"><label>Costo total:</label></div>
          		<div class="col-md-7"><input type="text" name="costoTT" id="costoTT" onkeyup="costoDifer();" style="border-left: none; border-right: none; border-top: none; margin-top: -30px;"><br><br>
          		</div>

          		<div class="col-md-5"><label>Fecha de notificaci&oacute;n al usuario para entrega:</label></div>
          		<div class="col-md-7">
          			<input type="text" name="fechanotientrega3" id="fechanotientrega3" style="border-left: none; border-right: none; border-top: none; display: none;" readonly="">
          			<input type="date" name="fechanotientrega" id="fechanotientrega" style="border-left: none; border-right: none; border-top: none; margin-top: -30px;"><br><br>
          		</div>

          		<div class="col-md-5"><label>Fecha de entrega al solicitante:</label></div>
          		<div class="col-md-7">
          			<input type="text" name="fechaentregasolicitante3" id="fechaentregasolicitante3" style="border-left: none; border-right: none; border-top: none; display: none;" readonly="">
          			<input type="date" name="fechaentregasolicitante" id="fechaentregasolicitante" style="border-left: none; border-right: none; border-top: none; margin-top: -30px;"><br><br>
          		</div>

          		<div class="col-md-5"><label>Diferencia (MN):</label></div>
          		<div class="col-md-7"><input type="text" name="diferencia" id="diferencia" style="border-left: none; border-right: none; border-top: none; margin-top: -30px;" readonly=""><br><br>
          		</div>

          		<div class="col-md-5"><label>FUP / Recibo:</label></div>
          		<div class="col-md-7"><input type="text" name="reciboFUP" id="reciboFUP" style="border-left: none; border-right: none; border-top: none; margin-top: -30px;"><br><br>
          		</div>

        	</div>

         
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-primary" onclick="actualizarProcesoTres();">Guardar</button>
          <button type="button" class="btn" style="background: #223a66; color: white;"  onclick="terminarProcesoTres();">Terminar proceso</button>
        </div>
      </div>
      
    </div>
  </div>

   <div class="modal fade" id="procesoTerminadoTres" role="dialog">
    <div class="modal-dialog">
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
        	 <h4 class="modal-title">Registro exitoso.</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
         
        </div>
        <div class="modal-body">
        	<center>
        		<img src="../images/about/ok.jpg" width="70" height="70">
        	</center>
        	
          <p>Los datos han sido registrados correctamente y puede continuar con el ultimo proceso ("CIERRE").</p>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn" data-dismiss="modal" onclick="ok();" style="background-color: #223a66; color: white;">Ok</button>
        </div>
      </div>
      
    </div>
  </div>
  <div class="modal fade" id="procesoCuatroInfo" role="dialog">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
        	 <h4 class="modal-title">LEVANTAMIENTO REALIZADO.</h4>
        	 <input type="text" name="idRegistro4" id="idRegistro4" style="display: none;">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        <div class="modal-body">
        	<div class="row">
        		
          		<div class="col-md-5"><label>Fecha de levantamiento:</label></div>
          		<div class="col-md-7">
          			<input type="text" name="fechaentregaGeo2" id="fechaentregaGeo2" style="border-left: none; border-right: none; border-top: none; display: none;" readonly="">
          			<input type="date" name="fechaentregaGeo" id="fechaentregaGeo" style="border-left: none; border-right: none; border-top: none; margin-top: -30px;"><br><br>
          		</div>
              <div class="col-md-5"><label>Folio GEO :</label></div>
              <div class="col-md-7"><input type="text" name="identificadorGeo" id="identificadorGeo" style="border-left: none; border-right: none; border-top: none; margin-top: -30px; width: 40px;" value="GEO"><label>/</label><input type="text" name="folGeo" id="folGeo" style="border-left: none; border-right: none; border-top: none; margin-top: -30px; width: 40px;"><label>/</label><input type="text" name="anioGeo" id="anioGeo" style="border-left: none; border-right: none; border-top: none; margin-top: -30px; width: 40px;" value="<?php echo $anio = date('Y');?>"><br><br>
              </div>
        	</div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-primary" onclick="actualizarProcesoCuatro();">Guardar</button>
          <button type="button" class="btn" style="background: #223a66; color: white;"  onclick="terminarProcesoCuatro();">Terminar proceso</button>
        </div>
      </div>
    </div>
  </div>

  <div class="modal fade" id="procesoSeisInfo" role="dialog">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
           <h4 class="modal-title">ENTREGA A LA DELEGACION.</h4>
           <input type="text" name="idRegistro6" id="idRegistro6" style="display: none;">
           <input type="text" name="folioUnoId" id="folioUnoId" style="display: none;">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        <div class="modal-body">
          <div class="row">
            
              <div class="col-md-5"><label>Fecha de entrega a la delegación:</label></div>
              <div class="col-md-7">
                <input type="text" name="fechaentregaDelegacion2" id="fechaentregaDelegacion2" style="border-left: none; border-right: none; border-top: none; display: none;" readonly=""> 
                <input type="date" name="fechaentregaDelegacion" id="fechaentregaDelegacion" style="border-left: none; border-right: none; border-top: none; margin-top: -30px;"><br><br>
              </div>
              <div class="col-md-5"><label>Superficie final(M2):</label></div>
              <div class="col-md-7"><input type="text" onchange="CalcularCostoTotal()" name="superficieResultante" id="superficieResultante" style="border-left: none; border-right: none; border-top: none; margin-top: -30px; width: 140px;"><br><br>
              </div>
              <div class="col-md-5"><label>Costo total:</label></div>
              <div class="col-md-7"><input type="text" name="costoTotal" id="costoTotal" style="border-left: none; border-right: none; border-top: none; margin-top: -30px; width: 140px;" readonly=""><br><br>
              </div>
              <div class="col-md-5"><label>Diferencia (+/-):</label></div>
              <div class="col-md-7"><input type="text" name="diferencias" id="diferencias" style="border-left: none; border-right: none; border-top: none; margin-top: -30px; width: 140px;" readonly=""><br><br>
              </div>
               <div class="col-md-5"><label>Oficio:</label></div>
              <div class="col-md-7">
                          <form action="#">
                          <select name="diDeRe" id="diDeRe" style="width: 140px;">  
                            <option value="0" selected="" disabled="">Seleccionar</option>
                            <option value="1">Diferencia</option>
                            <option value="2">Devolucion</option>
                            <option value="3">Renuncia</option>
                          </select>
                          </form>

                <br><br>
              </div>
              <div class="col-md-5"><label>Fup del oficio:</label></div>
              <div class="col-md-7"><input type="text" name="foliodiDeRe" id="foliodiDeRe" style="border-left: none; border-right: none; border-top: none; margin-top: -30px; width: 140px;"><br><br>
              </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-primary" onclick="actualizarProcesoSiete();">Guardar</button>
          <button type="button" class="btn" style="background: #223a66; color: white;"  onclick="terminarProcesoSiete();">Terminar proceso</button>
        </div>
      </div>
    </div>
  </div>
  
  <div class="modal fade" id="procesoSieteInfo" role="dialog">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
           <h4 class="modal-title">ENTREGA AL SOLICITANTE.</h4>
           <input type="text" name="idRegistro7" id="idRegistro7" style="display: none;">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        <div class="modal-body">
          <div class="row">
            
              <div class="col-md-5"><label>Fecha de notificación del servicio concluido:</label></div>
              <div class="col-md-7">
                <input type="text" name="fechaNotiConcluido2" id="fechaNotiConcluido2" style="border-left: none; border-right: none; border-top: none; display: none;" readonly="">
                <input type="date" name="fechaNotiConcluido" id="fechaNotiConcluido" style="border-left: none; border-right: none; border-top: none; margin-top: -30px;"><br><br>
              </div>
              <div class="col-md-5"><label>Fecha de entrega del servicio al solicitante:</label></div>
              <div class="col-md-7">
                <input type="text" name="fechaEntregaSolicitante2" id="fechaEntregaSolicitante2" style="border-left: none; border-right: none; border-top: none; display: none;" readonly="">
                <input type="date" name="fechaEntregaSolicitante" id="fechaEntregaSolicitante" style="border-left: none; border-right: none; border-top: none; margin-top: -30px;"><br><br>
              </div>
              
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-primary" onclick="actualizarProcesoOcho();">Guardar</button>
          <button type="button" class="btn" style="background: #223a66; color: white;"  onclick="terminarProcesoOcho();">Terminar proceso</button>
        </div>
      </div>
    </div>
  </div>

  <div class="modal fade" id="procesoOchoInfo" role="dialog">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
           <h4 class="modal-title">CERRADO.</h4>
           <input type="text" name="idRegistro8" id="idRegistro8" style="display: none;">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        <div class="modal-body">
          <div class="row">
            
              <div class="col-md-5"><label>Fecha de resguardo del servicio concluido:</label></div>
              <div class="col-md-7">
                <input type="text" name="fechaResguardo2" id="fechaResguardo2" style="border-left: none; border-right: none; border-top: none; display: none;" readonly="">
                <input type="date" name="fechaResguardo" id="fechaResguardo" style="border-left: none; border-right: none; border-top: none; margin-top: -30px;"><br><br>
              </div>
              <div class="col-md-5"><label>No. de oficio del resguardo enviado a geograf&iacute;a:</label></div>
              <div class="col-md-7">
                <input type="text" name="oficioResguardoGeo" id="oficioResguardoGeo" style="border-left: none; border-right: none; border-top: none;"><br><br>
              </div>
              <div class="col-md-5"><label>Observaciones:</label></div>
              <div class="col-md-7">
                <textarea id="observacionesC" name="observacionesC"></textarea>
               <br><br>
              </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-primary" onclick="actualizarProCerrado();">Guardar</button>
          <button type="button" class="btn" style="background: #223a66; color: white;"  onclick="terminarProCerrado();">Terminar proceso</button>
        </div>
      </div>
    </div>
  </div>

<!--
  <div class="modal fade" id="procesoCuatroInfo" role="dialog">
    <div class="modal-dialog">
   
      <div class="modal-content">
        <div class="modal-header">
           <h4 class="modal-title">CIERRE.</h4>
           <input type="text" name="idRegistro4" id="idRegistro4" style="display: none;">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
         
        </div>
        <div class="modal-body">
          <div class="row">
            <div class="col-md-7"><label>N&uacute;mero de oficio de env&iacute;o de expediente concluido :</label></div>
              <div class="col-md-5"><input type="text" name="idConcluido" id="idConcluido" style="border-left: none; border-right: none; border-top: none; margin-top: -30px;"><br><br>
              </div>

              <div class="col-md-7"><label>Fecha de entrega a la Dir. de Geograf&iacute;a:</label></div>
              <div class="col-md-5">
                <input type="text" name="fechaentregaGeo2" id="fechaentregaGeo2" style="border-left: none; border-right: none; border-top: none; display: none;" readonly="">
                <input type="date" name="fechaentregaGeo" id="fechaentregaGeo" style="border-left: none; border-right: none; border-top: none; margin-top: -30px;"><br><br>
              </div>

          </div>

         
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-primary" onclick="actualizarProcesoCuatro();">Actualizar</button>
          <button type="button" class="btn" style="background: #223a66; color: white;"  onclick="terminarProcesoCuatro();">Terminar proceso</button>
        </div>
      </div>
      
    </div>
  </div>-->

     <div class="modal fade" id="procesoTerminadoCuatro" role="dialog">
    <div class="modal-dialog">
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
        	 <h4 class="modal-title">Registro exitoso.</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
         
        </div>
        <div class="modal-body">
        	<center>
        		<img src="../images/about/ok.jpg" width="70" height="70">
        	</center>
        	
          <p>Los datos han sido registrados correctamente, puede continuar con el siguiente proceso</p>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn" data-dismiss="modal" onclick="ok();" style="background-color: #223a66; color: white;">Ok</button>
        </div>
      </div>
      
    </div>
  </div>


   <div class="modal fade" id="procesoCanceladoUno" role="dialog">
    <div class="modal-dialog">
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
        	 <h4 class="modal-title">Registro exitoso.</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
         
        </div>
        <div class="modal-body">
        	<center>
        		<img src="../images/about/ok.jpg" width="70" height="70">
        	</center>
        	
          <p>Los datos han sido registrados correctamente y el proceso ha sido cancelado.</p>
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
        		<img src="../images/about/adver.png" width="70" height="70">
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
					<div class="divider mb-3"></div>
					<span class="text-uppercase text-sm letter-spacing ">Registros</span> 
					<h1 class="mb-3 mt-3">Levantamientos Topográficos</h1>
					
					<!--<p class="mb-4 pr-5">A repudiandae ipsam labore ipsa voluptatum quidem quae laudantium quisquam aperiam maiores sunt fugit, deserunt rem suscipit placeat.</p> -->
					
				</div>
			</div>
		</div>
	</div>
</section>
<section class="features">
	<div class="container">
		<div class="row">
			<div class="col-lg-12">
				<div class="feature-block d-lg-flex">
						
					<div class="feature-item mb-5 mb-lg-0">
						<div class="feature-icon mb-4">
							<i class="icofont-edit"></i>
						</div>
						<span></span>
						<h4 class="mb-3">Proceso de registros</h4>
						<p class="mb-4">Registros realizados mostrando el estatus en el que se encuentran.</p>
							<center>
								<a href="semaforizacion.php" class="btn btn-main btn-round-full" id="procesoRegistro">Mostrar</a>
							</center>
					</div>
					<div class="feature-item mb-5 mb-lg-0">
						<div class="feature-icon mb-4">
							<i class="icofont-ui-folder"></i>
						</div>
						<h4 class="mb-3">Listado de registros</h4>
						<p>Información de todos los registros realizados</p>
						<center>
						<a href="admin.php" class="btn btn-main btn-round-full" id="buscaRegistro">Mostrar Listado</a>
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

    <script src="plugins/jquery/jquery.js"></script>
    <script src="plugins/bootstrap/bootstrap.min.js"></script> 
    <script src="js/script.js"></script>

  </body>
  </html>
