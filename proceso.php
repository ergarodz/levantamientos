<?php

$proceso='proceso_erick';
if(isset( $_REQUEST['proceso'] )){	$proceso=$_REQUEST['proceso']; }

//echo $fup_proc.' - '.$proceso;

switch($proceso){
	case 11111: ?>
		<!-- PROCESO 0 -->
		<div class="proceso_n" id="procesoCero" style="display:block;"> 
			<label style="color: #9f747f; font-weight: bold;">PROCESO CANCELADO</label>
			<br><br>                   
		</div>
	<?php	
	break;
	case 1: ?>
		<!-- PROCESO 1 -->
		<div class="proceso_n" id="procesoUno" style="display:block;"> 
			<label style="color: #223a66; font-weight: bold;"><i class="icofont-check icofont-2x"></i>INGRESADO A DELEGACION</label>
			<br>
			<a data-toggle="modal" data-target="#myModal2"  style="color: #8a2034; cursor:pointer; font-weight:bold;" onclick="mostrarInfo();"><i class="icofont-sign-in icofont-2x"></i>ENVIADO A TOPOGRAFIA</a>
			<br><br>
			<a class="btn btn-main btn-round-full" onclick="modal_cancelar_lt('<?php echo $proceso;?>');" id="cancelarlevantamiento">Cancelar levantamiento</a>
		</div>
	<?php	
	break;
	case 2: ?>
		<!-- PROCESO 2 -->
		<div class="proceso_n" id="procesoDos" style="display:block;"> 
			<label style="color: #223a66; font-weight: bold;"><i class="icofont-check icofont-2x"></i>INGRESADO A DELEGACION</label>
			<br>
			<label style="color: #223a66; font-weight: bold;"><i class="icofont-check icofont-2x"></i>ENVIADO A TOPOGRAFIA</label>
			<br>
			<a style="color: #8a2034; cursor:pointer; font-weight:bold;" onclick="notificacionColindantes();"><i class="icofont-sign-in icofont-2x"></i>NOTIFICACION A COLINDANTES</a>
			<br><br>
			<div id="cancelarlevantamientoBTN">
				<a class="btn btn-main btn-round-full" onclick="modal_cancelar_lt('<?php echo $proceso;?>');">Cancelar levantamiento</a>
			</div>
		</div> 
	<?php	
	break;
	case 3: ?>
		<!-- PROCESO 3 -->
		<div class="proceso_n" id="procesoTres" style="display:block;"> 
			<a style="color: #223a66; cursor: pointer;" onclick="mostrarStatusAll('procesoTres2');">Ver todos los estatus<i class="icofont-collapse icofont-2x"></i></a>
			<div id="procesoTres2" style="display: none;">
				<label style="color: #223a66; font-weight: bold;"><i class="icofont-check icofont-2x"></i>INGRESADO A DELEGACION</label>
				<br>
				<label style="color: #223a66; font-weight: bold;"><i class="icofont-check icofont-2x"></i>ENVIADO A TOPOGRAFIA</label>
				
			</div>
			<br>
			<label style="color: #223a66; font-weight: bold;"><i class="icofont-check icofont-2x"></i>NOTIFICADO</label>
			<br><br>
			<a data-toggle="modal"  style="color: #8a2034; cursor:pointer; font-weight:bold;" onclick="mostrarInfoCierre();"><i class="icofont-sign-in icofont-2x"></i>LEVANTAMIENTO REALIZADO</a>
			<br><br>
			<div id="cancelarlevantamientoBTNtres">
				<a class="btn btn-main btn-round-full" onclick="modal_cancelar_lt('<?php echo $proceso;?>');">Cancelar levantamiento</a>
			</div>
		</div>
	<?php	
	break;
	case 4: ?>
		<!-- PROCESO 4 -->
		<div class="proceso_n" id="procesoCuatro" style="display:block;"> 
			<a style="color: #223a66; cursor: pointer;" onclick="mostrarStatusAll('procesoCuatro2');">Ver todos los estatus<i class="icofont-collapse icofont-2x"></i></a><br>
			<div id="procesoCuatro2" style="display: none;">
				<label style="color: #223a66; font-weight: bold;"><i class="icofont-check icofont-2x"></i>INGRESADO A DELEGACION</label>
				<br>
				<label style="color: #223a66; font-weight: bold;"><i class="icofont-check icofont-2x"></i>ENVIADO A TOPOGRAFIA</label>
				<br>
				<label style="color: #223a66; font-weight: bold;"><i class="icofont-check icofont-2x"></i>NOTIFICADO</label>
				<br>
			</div>
			<label style="color: #223a66; font-weight: bold;"><i class="icofont-check icofont-2x"></i>LEVANTAMIENTO REALIZADO</label>
			<br><br>
			<a style="color: #8a2034; cursor:pointer; font-weight:bold;" onclick="envioDirGeo();"><i class="icofont-sign-in icofont-2x"></i>ENVIADO A DIR. DE GEOGRAFIA</a> 
			<br><br>
			<div id="cancelarlevantamientoBTNcuatro">
				<a class="btn btn-main btn-round-full" onclick="modal_cancelar_lt('<?php echo $proceso;?>');">Cancelar levantamiento</a>
			</div>
		</div>
	<?php	
	break;
	case 5: ?>
		<!-- PROCESO 5 -->
		<div class="proceso_n" id="procesoCinco" style="display:block;"> 
			<a style="color: #223a66; cursor: pointer;" onclick="mostrarStatusAll('procesoCinco2');">Ver todos los estatus<i class="icofont-collapse icofont-2x"></i></a><br>
			<div id="procesoCinco2" style="display: none;">
				<label style="color: #223a66; font-weight: bold;"><i class="icofont-check icofont-2x"></i>INGRESADO A DELEGACION</label>
				<br>
				<label style="color: #223a66; font-weight: bold;"><i class="icofont-check icofont-2x"></i>ENVIADO A TOPOGRAFIA</label>
				<br>
				<label style="color: #223a66; font-weight: bold;"><i class="icofont-check icofont-2x"></i>NOTIFICADO</label>
				<br>
				<label style="color: #223a66; font-weight: bold;"><i class="icofont-check icofont-2x"></i>LEVANTAMIENTO REALIZADO</label>
				<br>
			</div>
			<label style="color: #223a66; font-weight: bold;"><i class="icofont-check icofont-2x"></i>ENVIADO A DIR. DE GEOGRAFIA</label>
			<br><br>
			<a style="color: #8a2034; cursor:pointer; font-weight:bold;" onclick="recepcionCCC();"><i class="icofont-sign-in icofont-2x"></i>RECEPCIONADO EN DSI (CCC)</a> 
			<br><br>
			<div id="cancelarlevantamientoBTNcinco">
				<a class="btn btn-main btn-round-full" onclick="modal_cancelar_lt('<?php echo $proceso;?>');">Cancelar levantamiento</a>
			</div>
		</div>
	<?php	
	break;
	case 6: ?>
		<!-- PROCESO 6 -->
		<div class="proceso_n" id="procesoSeis" style="display:block;"> 
			<a style="color: #223a66; cursor: pointer;" onclick="mostrarStatusAll('procesoSeis2');">Ver todos los estatus<i class="icofont-collapse icofont-2x"></i></a><br>
			<div id="procesoSeis2" style="display: none;">
				<label style="color: #223a66; font-weight: bold;"><i class="icofont-check icofont-2x"></i>INGRESADO A DELEGACION</label>
				<br>
				<label style="color: #223a66; font-weight: bold;"><i class="icofont-check icofont-2x"></i>ENVIADO A TOPOGRAFIA</label>
				<br>
				<label style="color: #223a66; font-weight: bold;"><i class="icofont-check icofont-2x"></i>NOTIFICADO</label>
				<br>
				<label style="color: #223a66; font-weight: bold;"><i class="icofont-check icofont-2x"></i>LEVANTAMIENTO REALIZADO</label>
				<br>
				<label style="color: #223a66; font-weight: bold;"><i class="icofont-check icofont-2x"></i>ENVIADO A DIR. DE GEOGRAFIA</label>
				<br>
			</div>
			<label style="color: #223a66; font-weight: bold;"><i class="icofont-check icofont-2x"></i>RECEPCIONADO EN DSI (CCC)</label>
			<br><br>
			<a  data-toggle="modal" data-target="#procesoSeisInfo" style="color: #8a2034; cursor:pointer; font-weight:bold;" onclick="entregaDelegacion();"><i class="icofont-sign-in icofont-2x"></i>ENTREGA A LA DELEGACIÓN</a> 
			<br>
		</div>
	<?php	
	break;
	case 7: ?>
		<!-- PROCESO 7 -->
		<div class="proceso_n" id="procesoSiete" style="display:block;"> 
			<a style="color: #223a66; cursor: pointer;" onclick="mostrarStatusAll('procesoSiete2');">Ver todos los estatus<i class="icofont-collapse icofont-2x"></i></a><br>
			<div id="procesoSiete2" style="display: none;">
				<label style="color: #223a66; font-weight: bold;"><i class="icofont-check icofont-2x"></i>INGRESADO A DELEGACION</label>
				<br>
				<label style="color: #223a66; font-weight: bold;"><i class="icofont-check icofont-2x"></i>ENVIADO A TOPOGRAFIA</label>
				<br>
				<label style="color: #223a66; font-weight: bold;"><i class="icofont-check icofont-2x"></i>NOTIFICADO</label>
				<br>
				<label style="color: #223a66; font-weight: bold;"><i class="icofont-check icofont-2x"></i>LEVANTAMIENTO REALIZADO</label>
				<br>
				<label style="color: #223a66; font-weight: bold;"><i class="icofont-check icofont-2x"></i>ENVIADO A DIR. DE GEOGRAFIA</label>
				<br>
				<label style="color: #223a66; font-weight: bold;"><i class="icofont-check icofont-2x"></i>RECEPCIONADO EN DSI (CCC)</label>
				<br>
			</div>
			<label style="color: #223a66; font-weight: bold;"><i class="icofont-check icofont-2x"></i>ENTREGA A LA DELEGACIÓN</label>
			<br><br>
			<a  data-toggle="modal" data-target="#procesoSieteInfo" style="color: #8a2034; cursor:pointer; font-weight:bold;" onclick="entregaSolicitante();"><i class="icofont-sign-in icofont-2x"></i>ENTREGA AL SOLICITANTE</a> 
			<br>
		</div>
	<?php	
	break;
	case 8: ?>
		<!-- PROCESO 8 -->
		<div class="proceso_n" id="procesoOcho" style="display:block;"> 
			<a style="color: #223a66; cursor: pointer;" onclick="mostrarStatusAll('procesoOcho2');">Ver todos los estatus<i class="icofont-collapse icofont-2x"></i></a><br>
			<div id="procesoOcho2" style="display: none;">
				<label style="color: #223a66; font-weight: bold;"><i class="icofont-check icofont-2x"></i>INGRESADO A DELEGACION</label>
				<br>
				<label style="color: #223a66; font-weight: bold;"><i class="icofont-check icofont-2x"></i>ENVIADO A TOPOGRAFIA</label>
				<br>
				<label style="color: #223a66; font-weight: bold;"><i class="icofont-check icofont-2x"></i>NOTIFICADO</label>
				<br>
				<label style="color: #223a66; font-weight: bold;"><i class="icofont-check icofont-2x"></i>LEVANTAMIENTO REALIZADO</label>
				<br>
				<label style="color: #223a66; font-weight: bold;"><i class="icofont-check icofont-2x"></i>ENVIADO A DIR. DE GEOGRAFIA</label>
				<br>
				<label style="color: #223a66; font-weight: bold;"><i class="icofont-check icofont-2x"></i>RECEPCIONADO EN DSI (CCC)</label>
				<br>
				<label style="color: #223a66; font-weight: bold;"><i class="icofont-check icofont-2x"></i>ENTREGA A LA DELEGACIÓN</label>
				<br>
			</div>
			<label style="color: #223a66; font-weight: bold;"><i class="icofont-check icofont-2x"></i>ENTREGA AL SOLICITANTE</label>
			<br><br>
			<a  data-toggle="modal" data-target="#procesoOchoInfo" style="color: #8a2034; cursor:pointer; font-weight:bold;" onclick="mostrarProcesoOcho();"><i class="icofont-sign-in icofont-2x"></i>CERRADO</a> 
			<br>
		</div>
	<?php	
	break;
	case 9: ?>
		<!-- PROCESO 9 -->
		<div class="proceso_n" id="procesoNueve" style="display:block;"> 
			<a style="color: #223a66; cursor: pointer;" onclick="mostrarStatusAll('procesoNueve2');">Ver todos los estatus<i class="icofont-collapse icofont-2x"></i></a>
			<br> 
			<div id="procesoNueve2" style="display: none;">
				<label style="color: #223a66; font-weight: bold;"><i class="icofont-check icofont-2x"></i>INGRESADO A DELEGACION</label>
				<br>
				<label style="color: #223a66; font-weight: bold;"><i class="icofont-check icofont-2x"></i>ENVIADO A TOPOGRAFIA</label>
				<br>
				<label style="color: #223a66; font-weight: bold;"><i class="icofont-check icofont-2x"></i>NOTIFICADO</label>
				<br>
				<label style="color: #223a66; font-weight: bold;"><i class="icofont-check icofont-2x"></i>LEVANTAMIENTO REALIZADO</label>
				<br>
				<label style="color: #223a66; font-weight: bold;"><i class="icofont-check icofont-2x"></i>ENVIADO A DIR. DE GEOGRAFIA</label>
				<br>
				<label style="color: #223a66; font-weight: bold;"><i class="icofont-check icofont-2x"></i>RECEPCIONADO EN DSI (CCC)</label>
				<br>
				<label style="color: #223a66; font-weight: bold;"><i class="icofont-check icofont-2x"></i>ENTREGA A LA DELEGACIÓN</label>
				<br>
				<label style="color: #223a66; font-weight: bold;"><i class="icofont-check icofont-2x"></i>ENTREGA AL SOLICITANTE</label>
				<br>
			</div>
			<label style="color: #223a66; font-weight: bold; font-weight:bold;"><i class="icofont-check icofont-2x"></i>CERRADO</label>
			<br>
			<label>Ha concluido con todos los registros del Levantamiento topográfico</label>
		</div>
	<?php	
	break;

} ?>