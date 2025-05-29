<?php 

if (session_status() == PHP_SESSION_NONE) { session_start(); }

if (!isset($_SESSION["id_userAg"])) {
    header("Location: index.php");   
}

$_SESSION["id_userAg"];
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

	  	<script src="plugins/jquery/jquery.js"></script>
		<script src="plugins/bootstrap/bootstrap.min.js"></script> 

		<script src="js/script.js"></script>
		<script src="js/script3.js"></script>

		<script type="text/javascript" >
		  window.location.hash="no-back-button";
		  window.location.hash="Again-No-back-button" //chrome
		  window.onhashchange=function(){window.location.hash=""; } 
		</script>

		<script type="text/javascript" src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
    	<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css">

    	<script type="text/javascript">
	      $(document).ready(function() {
	      	$('#table_regs').DataTable({ 
	      		aLengthMenu: [
			        [10, 100, 1000, -1],
			        [10, 100, 1000, "Todos"]
			     ],

	            "language": { "url": "//cdn.datatables.net/plug-ins/1.10.15/i18n/Spanish.json" }


	        } );
	    } );
	    </script>

	    <script language="javascript">
			$(document).ready(function() {
				$(".botonExcel").click(function(event) {
					$("#datos_a_enviar").val( $("<div>").append( $("#table_regs").eq(0).clone()).html());
					$("#FormularioExportacion").submit();
				});
			});
		</script>

	</head>
	<body id="top">
		  	

	  	<form action="info_excel.php" method="post" target="_blank" id="FormularioExportacion">
			<input type="hidden" id="datos_a_enviar" name="datos_a_enviar" value="Exportar a Excel" />
		</form>


		<?php 
		require_once 'admon_menu.php';
		///llama al modal con id myModal
		require_once 'modals_cerrar.php';

		require_once 'Ops2.php';
		$erick=new Ops2();

		$registros=$erick->get_all_regs();
		//echo json_encode($registros);		
		?>

		<div style="margin-right:2%; margin-left:2%;" class="">
			<img style="width:70px; position:relative; top:25px; cursor:pointer;" src="images/excel.png"   class="botonExcel" />		
			<br><br>
			<table id="table_regs" style="border-color:solid black 3px;" class="cell-border">
				<thead>
					<tr>
						<th>FUP</th>	
						<th>Ingreso a delegación</th>					
						<th>Enviado a topografía</th>
						<th>Notificado</th>
						<th>Levantamiento realizado</th>
						<th>Enviado a Dir. de Geografía/Recepcionado en DSI (CCC)</th>
						<th>Entregado a la delegación</th>
						<th>Entregado al solicitante</th>
						<th>Cerrado</th>
					</tr>
				</thead>
				<tbody>
				<?php foreach($registros as $reg){ 
					///vemos si hay info en la tabla procesodos
					$reg2=$erick->get_regs_procesodos($reg->id);
					$reg3=$erick->get_regs_procesotres($reg->id);
					$reg4=$erick->get_regs_procesocuatro($reg->id);//echo json_encode($reg4);
				?>
					<tr>
						<td><span style="font-size:small;background-color:white;"><?php echo $reg->fup;?></span></td>
						<td>							
							<span style="color: #223a66; font-weight: bold; font-size: small;">Delegación:</span>
							<span style="font-size:small;background-color:white;"><?php echo $reg->nom_delegacion;?></span>						
							<br>						
							<span style="color: #223a66; font-weight: bold; font-size: small;">Municipio:</span>
							<span style="font-size:small;background-color:white;"><?php echo @$reg->municipio;?></span>
							<br>
							<span style="color: #223a66; font-weight: bold; font-size: small;">Clave Catastral:</span>
							<span style="font-size:small;background-color:white;"><?php echo @$reg->clavec;?></span>
							<br>
							<span style="color: #223a66; font-weight: bold; font-size: small;">Ingreso de solicitud a la delegación:</span>
							<span style="font-size:small;background-color:white;"><?php if(isset($reg->fecha_recepcion)){ echo date_format( date_create($reg->fecha_recepcion) , 'd-m-Y') ; } ?></span>
							<br>
							<span style="color: #223a66; font-weight: bold; font-size: small;">Solicitante:</span>
							<span style="font-size:small;background-color:white;"><?php echo $reg->solicitante.' '.@$reg->apaterno.' '.@$reg->amaterno;?></span>
							<br>
							<span style="color: #223a66; font-weight: bold; font-size: small;">Propietario:</span>
							<span style="font-size:small;background-color:white;"><?php echo $reg->propietario.' '.@$reg->apaternoprop.' '.@$reg->amaternoprop;?></span>
							<br>
							<span style="color: #223a66; font-weight: bold; font-size: small;">Superficie inicial:</span>
							<span style="font-size:small;background-color:white;"><?php echo @$reg->superficieinicial;?></span>
							<br>
							<span style="color: #223a66; font-weight: bold; font-size: small;">Monto inicial:</span>
							<span style="font-size:small;background-color:white;"><?php echo @$reg->anticipo;?></span>							
						</td>
						<td>
							<span style="color: #223a66; font-weight: bold; font-size: small;">Orden de trabajo:</span>
							<span style="font-size:small;background-color:white;"><?php echo @$reg2->ordentrabajo;?></span>	
							<br>
							<span style="color: #223a66; font-weight: bold; font-size: small;">Fecha de envío al área de topografía:</span>
							<span style="font-size:small;background-color:white;"><?php if(isset($reg2->fechaenvio)){ echo date_format( date_create(@$reg2->fechaenvio) , 'd-m-Y'); }?></span>	
							<br>
							<span style="color: #223a66; font-weight: bold; font-size: small;">Área de topografía:</span>
							<span style="font-size:small;background-color:white;"><?php echo @$reg2->areaproduc;?></span>		
						</td>
						<td>
							<span style="color: #223a66; font-weight: bold; font-size: small;">Fecha de notificación a colindantes:</span>
							<span style="font-size:small;background-color:white;"><?php if(isset($reg2->fechanotificacion)){ echo date_format( date_create(@$reg2->fechanotificacion) , 'd-m-Y'); } ?></span>
						</td>
						<td>
							<span style="color: #223a66; font-weight: bold; font-size: small;">Fecha de levantamiento realizado:</span>
							<span style="font-size:small;background-color:white;"><?php if(isset($reg2->fechalevantamiento) ){echo date_format( date_create(@$reg2->fechalevantamiento) , 'd-m-Y'); }?></span>
							<br>
							<span style="color: #223a66; font-weight: bold; font-size: small;">Folio GEO:</span>
							<span style="font-size:small;background-color:white;"><?php echo @$reg2->foliogeo;?></span>
						</td>
						<td>
							<span style="color: #223a66; font-weight: bold; font-size: small;">Fecha de envío a la dirección de geografía:</span>
							<span style="font-size:small;background-color:white;"><?php if(isset($reg2->fechatermino)){ echo date_format( date_create(@$reg2->fechatermino) , 'd-m-Y'); } ?></span>
							<br>
							<span style="color: #223a66; font-weight: bold; font-size: small;">Fecha de recepcion en CCC (Servicio terminado):</span>
							<span style="font-size:small;background-color:white;"><?php if(isset($reg2->fecharecepcionccc)){ echo date_format( date_create(@$reg2->fecharecepcionccc) , 'd-m-Y'); }?></span>
						</td>
						<td>
							<span style="color: #223a66; font-weight: bold; font-size: small;">Fecha de entrega a la delegación:</span>
							<span style="font-size:small;background-color:white;"><?php if(isset($reg3->fechanotientrega)){ echo date_format( date_create(@$reg3->fechanotientrega) , 'd-m-Y'); } ?></span>
							<br>
							<span style="color: #223a66; font-weight: bold; font-size: small;">Superficie resultante:</span>
							<span style="font-size:small;background-color:white;"><?php echo @$reg3->superficieresultante;?></span>
							<br>
							<span style="color: #223a66; font-weight: bold; font-size: small;">Costo total:</span>
							<span style="font-size:small;background-color:white;"><?php echo @$reg3->costototal;?></span>
							<br>
							<span style="color: #223a66; font-weight: bold; font-size: small;">Diferencia (+/-):</span>
							<span style="font-size:small;background-color:white;"><?php echo @$reg3->diferencia;?></span>
							<br>
							<span style="color: #223a66; font-weight: bold; font-size: small;">Tipo de oficio:</span>
							<span style="font-size:small;background-color:white;"><?php echo @$reg3->tipooficio;?></span>
							<br>
							<span style="color: #223a66; font-weight: bold; font-size: small;">Folio del oficio:</span>
							<span style="font-size:small;background-color:white;"><?php echo @$reg3->recibofup;?></span>
							<br>
							<span style="color: #223a66; font-weight: bold; font-size: small;">Observaciones:</span>
							<span style="font-size:small;background-color:white;"><?php echo @$reg3->obs_proceso6;?></span>
						</td>
						<td>
							<span style="color: #223a66; font-weight: bold; font-size: small;">Fecha de notificación del servicio concluido al solicitante:</span>
							<span style="font-size:small;background-color:white;"><?php if(isset($reg3->fechanotificacionconcluido)){ echo date_format( date_create(@$reg3->fechanotificacionconcluido) , 'd-m-Y'); } ?></span>
							<br>
							<span style="color: #223a66; font-weight: bold; font-size: small;">Fecha de entrega del servicio al solicitante:</span>
							<span style="font-size:small;background-color:white;"><?php if(isset($reg3->fechaentregasol)){ echo date_format( date_create(@$reg3->fechaentregasol) , 'd-m-Y'); } ?></span>
							<br>
							<span style="color: #223a66; font-weight: bold; font-size: small;">Observaciones:</span>
							<span style="font-size:small;background-color:white;"><?php echo @$reg3->observaciones_entrega_cliente;?></span>
						</td>
						<td>
							<span style="color: #223a66; font-weight: bold; font-size: small;">Fecha de resguardo del servicio concluido:</span>
							<span style="font-size:small;background-color:white;"><?php if(isset($reg4->fechaderesguardo)){ echo date_format( date_create(@$reg4->fechaderesguardo) , 'd-m-Y'); } ?></span>
							<br>
							<span style="color: #223a66; font-weight: bold; font-size: small;">No. de oficio del resguardo enviado a geografía:</span>
							<span style="font-size:small;background-color:white;"><?php echo @$reg4->folioderesguardo;?></span>
							<br>
							<span style="color: #223a66; font-weight: bold; font-size: small;">Observaciones:</span>
							<span style="font-size:small;background-color:white;"><?php echo @$reg4->observaciones;?></span>
						</td>
					</tr>
				<?php } ?>
				</tbody>
			</table>
		</div>

		<div class="modal fade" id="myModal_eliminar" role="dialog">
		    <div class="modal-dialog">
				<!-- Modal content-->
				<div class="modal-content">
					<div class="modal-header">
						<h4 class="modal-title">Eliminar registro</h4>
					  	<button type="button" class="close" data-dismiss="modal">&times;</button>			 
					</div>
					<div class="modal-body">
						<p>¿Desea eliminar este registro?</p>
					</div>
					<div class="modal-footer" id="actualizar_id_borrado">
					 	<!-- <button type="button" class="btn btn-primary" data-dismiss="modal" onclick=" delete_reg('<?php echo $reg->id;?>'); " >Ok</button> -->
					</div>
				</div>	      
		    </div>
		</div>
			

	</body>
		
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
</html>
