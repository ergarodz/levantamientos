<?php if (session_status() == PHP_SESSION_NONE) {session_start();} ?>


<!-- VARIABLES CON VALORES DE BUSQUEDA -->
<input type="text" name="fol" id="fol" style="display: none;"/>


<!-- ENVIADO A TOPOGRAFIA -->
<?php $brigada=$_SESSION['brigada']; 
	$usuario_envio=$_SESSION['usuario'];
?>
<div class="modal fade" id="myModal2" role="dialog">
    <div class="modal-dialog">
	    <div class="modal-content">
	        <div class="modal-header">
	        	 <h5 class="modal-title">ENVIADO A TOPOGRAFÍA</h5>
	        	 <br>	        	 
	        	 <!-- <input type="text" name="idRegistro" id="idRegistro" style="display: none;"> -->
	             <button type="button" class="close" data-dismiss="modal">&times;</button>
	        </div>
	        <div class="modal-body">
	        	<div class="row">
	        		<div class="col-md-5"><label>Orden de trabajo:</label></div>
	            	<!-- <input hidden="" name="inicioFolio" id="inicioFolio" value="<?php echo  $_SESSION["abrev"]."-".$anio2;?>"> -->
	        		<div class="col-md-7">
	        			<input type="text" name="ordentrabajo" id="ordentrabajo" style="border-left: none; border-right: none; border-top: none; margin-top: -30px; width: 80%;" maxlength="6">
	        		</div>
	        	</div>
	        	<br><br>
	        	<div class="row">
	        		<div class="col-md-5">
	        			<label>Fecha de envío al área de topografía:</label>
	        		</div>
	            	<div class="col-md-7">
	            		<!-- <input type="text" name="fechaEnvio2" id="fechaEnvio2" style="display: none; border-left: none; border-right: none; border-top: none;" readonly=""> -->
	            		<select name="fechaDeEnvio" id="fechaDeEnvio" onchange="fechaEnviop();" style="width:80%; display: block;">
	         				<option value="0" selected="" hidden="">Seleccionar</option>
	         				<option value="1">Ingresar fecha</option>
	  						<option value="2">Proceso</option>
	  						<option value="3">Cancelado</option>
						</select>
						<br><br>
	          			<!-- <input type="hidden" name="fechaDeEnvioTip" id="fechaDeEnvioTip"> -->
						<input type="date" name="fechaEnvio" id="fechaEnvio" style="display: none;" min="2024-03-19" max="2026-03-15">
	            	</div>	
	        	</div>
	        	<br>
	        	<div class="row">
	        		<div class="col-md-5" id="oc"><label>Área productora:</label></div>
	  				<div class="col-md-7" id="oc2">
	  					<select name="areaProduc" id="areaProduc" style="width:80%;">
	  						<option value="0" selected="" hidden="">Seleccionar</option>
	  						<option value="Geografia">Dir. Geografia</option>
	  						<?php if($brigada){ ?>
	  						<option value="Brigada">Brigada delegación</option>
	  						<?php } ?>
						</select><br>
					</div>
	        	</div>
	         	<br>
	        </div>
	        <div class="modal-footer" id="butBien" style="margin-right:20px;">
	         	<button type="button" class="btn btn-main btn-round-full" style="width:150px;" id="terminoProcDos" onclick="terminarProcesoDos(' <?php echo $usuario_envio;?>' );">Guardar</button> 
	        </div>
	    </div>      
    </div>
</div>


<!-- NOTIFIACIÓN A COLINDANTES -->
<div class="modal fade" id="modal_notificacion" role="dialog">
    <div class="modal-dialog">
	    <div class="modal-content">
	    	<div class="modal-header">
	        	 <h5 class="modal-title">NOTIFICACIÓN A COLINDANTES</h5>
	        	 <br>
	             <button type="button" class="close" data-dismiss="modal">&times;</button>
	        </div>
	        <div class="modal-body">	        	
	        	<div id="fechaNotificacionn" style="display: block;">
	        		<br>
	        		<div class="row">
	        			<div class="col-md-6">
	        				<label>Fecha programada del levantamiento</label>
	        			</div>
	        			<div class="col-md-6">
	        				<input type="date" name="fecha_lev" id="fecha_lev" readonly="" >
	        			</div>

	        			<div class="col-md-6">
	        				<label>Especialista asignada(o)</label>
	        			</div>
	        			<div class="col-md-6">
	        				<input class="form-control" type="text" name="esp_lev" id="esp_lev" readonly="" >
	        			</div>
	        		</div>
	        		<br>
	        		<div class="row">
	        			<div class="col-md-6">
	        				<label>Ingresar fecha de notificación</label>
	        			</div>
	        			<div class="col-md-6">
	        				<input type="date" name="fechanotif" id="fechanotif" min="2024-03-19" max="2026-03-15" >
	        			</div>
	        		</div>	
	        		<br>
	        		<div class="row" align="right">
	        			<div class="col-md-6">
	        				<a class="btn btn-main btn-round-full" onclick="fechaNotificacionCo_2();" data-toggle="modal" data-target="#registroBien">Guardar</a>
	        			</div>
	        			<div class="col-md-6">
	        				<a class="btn btn-main btn-round-full" onclick="fechaNotificacionCo();" data-toggle="modal" data-target="#procesoTerminado">Terminar proceso</a>
	        			</div>
	        		</div>
	        		<br>
				</div>
	        </div>		    	
	    </div>      
    </div>
</div> 


<!-- LEVANTAMIENTO REALIZADO -->
<div class="modal fade" id="procesoCuatroInfo" role="dialog">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				 <h4 class="modal-title">LEVANTAMIENTO REALIZADO</h4>
				 <input type="text" name="idRegistro4" id="idRegistro4" style="display: none;"> <!-- Aqui está el folio, para buscar en tabla procesodos -->
			 	<button type="button" class="close" data-dismiss="modal">&times;</button>
			</div>
			<div class="modal-body">
				<br>
				<div class="row">					
			  		<div class="col-md-5"><label>Fecha de levantamiento:</label></div>
			  		<div class="col-md-7">
			  			<input type="date" name="fechaentregaGeo" id="fechaentregaGeo" style="border-left: none; border-right: none; border-top: none; margin-top: -30px;" min="2024-03-19" max="2026-03-15" ><br><br>
			  		</div>
			      	<div class="col-md-5"><label>Folio GEO :</label></div>
				    <div class="col-md-5">
				    	<input type="text" name="identificadorGeo" id="identificadorGeo" style="border-left: none; border-right: none; border-top: none; margin-top: -30px; width: 40px;" value="GEO" maxlength="4"><label>/</label>
				    	<input type="text" name="folGeo" id="folGeo" style="border-left: none; border-right: none; border-top: none; margin-top: -30px; width: 40px;" maxlength="4"><label>/</label>
				    	<input type="text" name="anioGeo" id="anioGeo" style="border-left: none; border-right: none; border-top: none; margin-top: -30px; width: 40px;" value="<?php echo $anio = date('Y');?>" maxlength="4"><br><br> 

				    	<!-- <input type="text" name="folio_geo" id="folio_geo" class="form-control" readonly=""> -->
				    </div>
				</div>
			</div>
		<div class="modal-footer">
		  <button type="button" class="btn btn-primary" onclick="terminarProcesoCuatro();">Continuar</button>
		  <button type="button" class="btn btn-main btn-round-full" style="width:200px;" onclick="terminarProcesoCuatro();">Guardar</button>
		</div>
		</div>
	</div>
</div>

<!-- ENVIADO A DIR DE GEOGRAFIA -->
<div class="modal fade" id="envio_dir_geo" role="dialog">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				 <h4 class="modal-title">ENVIADO A DIRECCIÓN DE GEOGRAFÍA</h4>
			 	<button type="button" class="close" data-dismiss="modal">&times;</button>
			</div>
			<div class="modal-body">
				<br>
				<div id="fechaEnvioDirGeo">
					<div class="row">
						<div class="col-md-6">
							<label>Ingresar fecha de envío a la dirección de geografía:</label>		
						</div>
						<div class="col-md-6">
							<input type="date" name="fechaEnvioDirGeogra" id="fechaEnvioDirGeogra" min="2024-03-19" max="2026-03-15"><br><br>
						</div>
					</div>
                </div>
			</div>
			<div class="modal-footer">
			  <button type="button" class="btn btn-main btn-round-full" style="width:200px;" onclick="fechaEnvioDirGeografia();">Guardar</button>
			</div>
		</div>
	</div>
</div>

<!-- RECEPCIONADO EN DSI (CCC) -->
<div class="modal fade" id="recepcion_dsi" role="dialog">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				 <h4 class="modal-title">RECEPCIONADO EN DSI (CCC)</h4>
			 	<button type="button" class="close" data-dismiss="modal">&times;</button>
			</div>
			<div class="modal-body">
				<div id="fechaRecepcionCCC" class="row">
					<div class="col-md-6">
						<label>Ingresar fecha de recepción en DSI (CCC)</label>
					</div>
					<div class="col-md-6">
						<input type="date" name="fechaRecepcionDSIccc" id="fechaRecepcionDSIccc" min="2024-03-19" max="2026-03-15">	
					</div>
				</div>
				<br>
				<!-- <div id="fechaRecepcionCCC">
                    <a class="btn btn-main btn-round-full" id="fechaRecepcionDccc" onclick="fechaRecepcionDsicc();" data-toggle="modal" data-target="#procesoTerminado">Guardar</a> 
                </div> -->
			</div>
			<div class="modal-footer">
			  <!-- <button type="button" class="btn btn-primary" onclick="fechaEnvioDirGeografia();">Guardar</button> -->
			  <button type="button" class="btn btn-main btn-round-full" style="width:200px;" onclick="fechaRecepcionDsicc();">Guardar</button>
			</div>
		</div>
	</div>
</div>

<!-- ENTREGA A LA DELEGACIÓN -->
<div class="modal fade" id="procesoSeisInfo" role="dialog">
	<div class="modal-dialog">
		<div class="modal-content">
		<div class="modal-header">
			<h4 class="modal-title">ENTREGA A LA DELEGACIÓN</h4>
			<!-- <input type="text" name="idRegistro6" id="idRegistro6" style="display: none;"> -->
			<!-- <input type="text" name="folioUnoId" id="folioUnoId" style="display: none;"> -->
			 <input id="anio_tarifa" style="display:none;"/>
			<button type="button" class="close" data-dismiss="modal">&times;</button>
		</div>
		<div class="modal-body">
			<div class="row">           
				<div class="col-md-5"><label>Fecha de entrega a la delegación:</label></div>
				<div class="col-md-7">
					<!-- <input  name="fechaentregaDelegacion2" id="fechaentregaDelegacion2" style="border-left: none; border-right: none; border-top: none; display: none;" readonly="">  -->
					<input type="date" name="fechaentregaDelegacion" id="fechaentregaDelegacion" style="border-left: none; border-right: none; border-top: none; margin-top: -30px;" min="2024-03-19" max="2026-03-15"><br><br>
				</div>

				<div class="col-md-5"><label>Superficie final (M2):</label></div>
				<div class="col-md-7">
					<div id="superficieResult2" name="superficieResult2" >
						<input type="text" onkeyup="this.value=validarSuperficie_er(this.value); CalcularCostoTotal();" onload="CalcularCostoTotal();" 
							name="superficieResultante" id="superficieResultante" 
							style="border-left: none; border-right: none; border-top: none; margin-top: -30px; width: 140px;" readonly=""><br><br>
						<input type="text" onkeyup="this.value=validarSuperficie_er(this.value); manda_calcularCostoTotal();" onload="//CalcularCostoTotal();" 
							name="superficieResultante" id="superficieResultante" 
							style="border-left: none; border-right: none; border-top: none; margin-top: -30px; width: 140px;" ><br><br>
					</div>
				</div>
				<div class="col-md-12" id="mensajeErrorSuperficie2" style="display: none;">
					<label style="color: #e12454; text-align: center;"><i class="icofont-exclamation-tringle"></i>Ingresar el valor correcto en superficie</label>
				</div>

				<div class="col-md-5"><label>Costo total:</label></div>
				<div class="col-md-7">
					<input type="text" name="costoTotal" id="costoTotal" style="border-left: none; border-right: none; border-top: none; margin-top: -30px; width: 140px;" readonly=""><br><br>
				</div>
				<div class="col-md-5"><label>Diferencia (+/-):</label></div>
				<div class="col-md-7"><input type="text" name="diferencias" id="diferencias" style="border-left: none; border-right: none; border-top: none; margin-top: -30px; width: 140px;" readonly=""><br><br>
				</div>
				<div class="col-md-5"><label>Oficio:</label></div>
				<div class="col-md-7">
					<select name="diDeRe" id="diDeRe" style="width: 140px;"  onchange="tipoNodeOficio();" >  
					<option value="0" selected="" hidden="">Seleccionar</option>
					<option value="1">Diferencia</option>
					<option value="2">Devolucion</option>
					<option value="3">Renuncia</option>
					<option value="4">Sin diferencia</option>
					</select>					
				</div>
				<div class="col-md-5" id="labelFup" style="display: none;"><label>FUP:</label></div>
				<div class="col-md-5" id="labelOficio" style="display: none;"><label>No. Oficio:</label></div>
				<div class="col-md-7">
					<input type="text" name="foliodiDeRe" id="foliodiDeRe" style="border-left: none; border-right: none; border-top: none; margin-top: -30px; width: 140px; display: none;" maxlength="25">
				</div>
			</div>
			<br>
			<div class="row">
				<br>
				<div class="col-md-5">
				    <label> Observaciones:</label>
				</div>
				<div class="col-md-7"><textarea id="obs_proceso6"></textarea></div>
			</div>
		</div>
		<div class="modal-footer">
			<button type="button" class="btn btn-main btn-round-full" style="width:200px;" onclick="actualizarProcesoSiete();">Guardar</button>
		    <button type="button" class="btn btn-main btn-round-full" style="width:200px;" onclick="terminarProcesoSiete();">Terminar proceso</button>
		</div>
		</div>
	</div>
</div>

<!-- ENTREGA AL SOLICITANTE -->
<div class="modal fade" id="procesoSieteInfo" role="dialog">
    <div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
			    <h4 class="modal-title">ENTREGA AL SOLICITANTE</h4>
			    <!-- <input type="text" name="idRegistro7" id="idRegistro7" style="display: none;"> -->
				<button type="button" class="close" data-dismiss="modal">&times;</button>
			</div>
			<div class="modal-body">
				<div class="row">
					<div class="col-md-5"><label>Fecha de notificación del servicio concluido:</label></div>
					<div class="col-md-7">
						<!-- <input type="text" name="fechaNotiConcluido2" id="fechaNotiConcluido2" style="border-left: none; border-right: none; border-top: none; display: none;" readonly=""> -->
						<input type="date" name="fechaNotiConcluido" id="fechaNotiConcluido" style="border-left: none; border-right: none; border-top: none; margin-top: -30px;" min="2024-03-19" max="2026-03-15"><br><br>
					</div>			  
				</div>
				<br>
				<div class="row">
					<div class="col-md-5"><label>Fecha de entrega del servicio al solicitante:</label></div>
					<div class="col-md-7">
						<!-- <input type="text" name="fechaEntregaSolicitante2" id="fechaEntregaSolicitante2" style="border-left: none; border-right: none; border-top: none; display: none;" readonly=""> -->
						<input type="date" name="fechaEntregaSolicitante" id="fechaEntregaSolicitante" style="border-left: none; border-right: none; border-top: none; margin-top: -30px;" min="2024-03-19" max="2026-03-15"><br><br>
					</div>
				</div><br>
				<div class="row">
					<div class="col-md-5"><label>Observaciones:</label></div>
					<div class="col-md-7">
						<textarea id="observaciones_entrega_cliente" name="observaciones_entrega_cliente"></textarea>
					</div>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-main btn-round-full" style="width:200px;" onclick="actualizarProcesoOcho();">Guardar</button>
				<button type="button" class="btn btn-main btn-round-full" style="width:200px;" onclick="terminarProcesoOcho();">Terminar proceso</button>
			</div>
		</div>
    </div>
</div>

<!-- CERRADO -->
<div class="modal fade" id="procesoOchoInfo" role="dialog">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
           <h4 class="modal-title">CERRADO</h4>
           <!-- <input type="text" name="idRegistro8" id="idRegistro8" style="display: none;"> -->
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        <div class="modal-body">
          <div class="row">            
              <div class="col-md-5"><label>Fecha de resguardo del servicio concluido:</label></div>
              <div class="col-md-7">
                <!-- <input type="text" name="fechaResguardo2" id="fechaResguardo2" style="border-left: none; border-right: none; border-top: none; display: none;" readonly=""> -->
                <input type="date" name="fechaResguardo" id="fechaResguardo" style="border-left: none; border-right: none; border-top: none; margin-top: -30px;" min="2024-03-19" max="2026-03-15"><br><br>
              </div>
          </div>
          <br>
          <div class="row">
          	<div class="col-md-5"><label>No. de oficio del resguardo enviado a geografía:</label></div>
	        <div class="col-md-7">
	            <input type="text" name="oficioResguardoGeo" id="oficioResguardoGeo" style="border-left: none; border-right: none; border-top: none;" maxlength="25"><br><br>
	        </div>
          </div>
          <br>
          <div class="row">
          	<div class="col-md-5"><label>Observaciones:</label></div>
              <div class="col-md-7">
                <textarea id="observacionesC" name="observacionesC"></textarea>               
              </div>
          </div>
          <br>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-main btn-round-full" style="width:200px;" onclick="terminarProCerrado();">Guardar</button>
        </div>
      </div>
    </div>
</div>



<!-- CANCELAR PROCESO -->
<div class="modal fade" id="cancelar_lt" role="dialog">
	<div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
           <h4 class="modal-title">CANCELAR LEVANTAMIENTO</h4>
           <input type="text" id="procc" hidden="" />
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        <div class="modal-body">
          <div class="row">            
              <div class="col-md-5"><label>Fecha de cancelación:</label></div>
              <div class="col-md-7">
                <input type="date" name="fecha_cancel" id="fecha_cancel" style="border-left: none; border-right: none; border-top: none; margin-top: -30px;" min="2024-03-19" max="2026-03-15"><br><br>
              </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-main btn-round-full" style="width:200px;" onclick="cancelar_lt();">Cancelar</button>
        </div>
      </div>
    </div>
</div>
