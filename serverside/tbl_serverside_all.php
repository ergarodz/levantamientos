<?php
	require_once '../Ops2.php';
	$erick=new Ops2();

    $periodo=$_REQUEST['periodo'];

	//$levs=$erick->get_geo_lt();
    $levs=$erick->get_geo_lt_periodo( $periodo );
	//echo json_encode($levs);	
?>

<script type="text/javascript">
    $(document).ready(function() {
        $('#tbl_lt').DataTable({ 
            language: {
		        "url": "//cdn.datatables.net/plug-ins/1.10.15/i18n/Spanish.json"
		    },
            aLengthMenu: [
		        [3, 10, 30, -1],
		        [3, 10, 30, "Todos"]
		    ]
        });
    });
</script>

<script>
	$("#loader").show();
</script>

<div class="row cointainer" >
    <div class="col-md-1"></div>
	<div class="col-md-10" >

		<table id="tbl_lt" class="table table-striped">
			<thead>
				<tr>
					<th style="text-align:center;" colspan="3"><h6>LEVANTAMIENTOS TOPOGRÁFICOS</h6></th>
				</tr>
				<tr>
					<th style="text-align:left">Levantamiento</th>
					<th style="text-align:left;">Salida de equipo</th>
					<th style="text-align:left;">Entrega de equipo</th>
				</tr>
			</thead>
			<tbody>
				<?php foreach($levs as $lt){ ?>
				<tr>
					<td style="width:31%;">
						<b class="dark">FUP:</b> <b class="dark"><?php echo $lt->fup;?></b>	
						<br><br>
						<b class="dark">Fecha de ingreso:</b> <?php echo $lt->fecha_recepcion;?>
						<br>
						<b class="dark">Propietario:</b> <?php echo $lt->propietario.' '.$lt->apaternoprop.' '.$lt->amaternoprop;?>
						<br>
						<b class="dark">Clave catastral:</b> <?php echo $lt->clavec;?>
						<br>
						<b class="dark">Municipio:</b> <?php echo $lt->municipio;?>
						<br>
						<b class="dark">Superficie:</b> <?php echo $lt->superficieinicial;?>
						
					</td>
					<td style="width:31%;">
						<b class="dark">Fecha del levantamiento:</b> <?php echo $lt->fechalevantamiento;?>
						<br>
						<b class="dark">Hora programada del levantamiento:</b> <?php echo $lt->hora_prog_lt?>
						<br>
						<b class="dark">Fecha de notificación:</b> <?php echo $lt->fechanotificacion;?>
						<br>
						<!-- <b class="dark">Especialista:</b> <?php echo $lt->especialista;?> -->
						<b class="dark">Especialista:</b> <?php echo $lt->nombre.' '.$lt->apep.' '.$lt->apem;?> 


						<!-- <br>
						<b class="dark">Equipo:</b> <?php if($lt->equipo=='1'){ echo 'LEICA';}else{ echo 'FOCUS';}?>
						<br>
						<b class="dark">No. de inventario:</b>  <?php echo $lt->inventario;?> -->

						<br>
						<div class="row">
							<div class="col-md-12"><b class="dark">Equipo:</b></div>							
						</div>
						<div class="row">
							<div class="col-md-1"></div>
							<div class="col-md-5"><b class="dark">Inventario</b></div>		
							<div class="col-md-6"><?php echo $lt->inventario;?></div>					
						</div>
						<div class="row">
							<div class="col-md-1"></div>
							<div class="col-md-5"><b class="dark">Número de serie</b></div>		
							<div class="col-md-6"><?php echo $lt->num_serie;?></div>					
						</div>
						<div class="row">
							<div class="col-md-1"></div>
							<div class="col-md-5"><b class="dark">Modelo</b></div>		
							<div class="col-md-6"><?php echo $lt->modelo;?></div>					
						</div>						
						<div class="row">
							<div class="col-md-1"></div>
							<div class="col-md-5"><b class="dark">Marca</b></div>		
							<div class="col-md-6"><?php echo $lt->marca;?></div>					
						</div>

					</td>
					
					
					<td style="width:31%;">
						<?php if($lt->entrega_equipo==true){ 
							///se obtienen los archivos crudos
							$archivos_crudos=$erick->get_archivos_crudos( $lt->fup );
						?>
						<b class="dark">Fecha de entrega del equipo:</b> <?php echo $lt->fecha_equipo_entrega; ?>
						<br>
						<b class="dark">Hora de entrega del equipo:</b> <?php echo $lt->hora_equipo_entrega; ?>
						<br>
						<b class="dark">Observaciones del equipo:</b> <?php echo $lt->observaciones_equipo; ?>
						<br>
						<b class="dark">Número de GEO:</b> <?php echo $lt->foliogeo; ?>
						<br>
						<b class="dark">Superficie resultante (m2):</b> <?php echo $lt->superficie_resultante; ?>
						

						<?php if($archivos_crudos!=null){ 
							echo '<br><br><b class="dark">Archivos crudos:</b>';
							foreach($archivos_crudos as $acr){
								$crud=explode('/', $acr->url_archivo);

								//$ruta=str_replace('C:/xampp/htdocs/levantamientoTopografico/theme2/', '', $acr->url_archivo);/////local
								$ruta=str_replace('C:/xampp/htdocs/levantamientoTopografico/theme/lt/', '', $acr->url_archivo);/////servidor
						?>
							<br>
							<a style="color:blue;" href="<?php echo $ruta;?>" download="<?php echo $crud[ count($crud)-1 ];?>"><i><?php echo $crud[ count($crud)-1 ];?></i></a>
						<?php } } ?>

						
						<?php } ?>
					</td>			

				</tr>
				<?php } ?>
			</tbody>
		</table>
	</div>
</div>

<script>
    setTimeout(function () { $("#loader").hide(); }, 300); 
</script>