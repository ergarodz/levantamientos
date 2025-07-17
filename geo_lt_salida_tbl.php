<?php
	$fup='ERICK';
	if(isset($_REQUEST['fup']) ){
		$fup=$_REQUEST['fup'];
	}	

	if(!isset($erick)){
		require_once 'Ops2.php';
		$erick=new Ops2();
	}	
	//echo json_encode($_SESSION);

	$reg=$erick->get_registro($fup);
	//echo json_encode($reg);
	$fecha_min_lt = date('Y-m-d', strtotime($reg->fecha_recepcion )); // Fecha mínima para el levantamiento
	$especialistas=$erick->get_especialistas($_SESSION['delegacion']);
	///obtener lista de especialistas por delegación
	//$especialistas=$erick->get_especialistas($reg->iddelegacion);

	//echo json_encode($especialistas);

	////obtener lista de equipos/estaciones por delegación
	$id_del_mod=$reg->iddelegacion;
	//echo json_encode($id_del_mod);
	if($id_del_mod==1 || $id_del_mod==8 || $id_del_mod==6){$id_del_mod=0;} ////es para las delegaciones que utilizan el equipo de direccion de geografia (en la tabla e1staciones)
	//echo json_encode($id_del_mod);
	$equipos=$erick->get_equipos($id_del_mod);
	//echo json_encode($equipos);

?>
<script>
	$("#loader").show();
</script>
<div id="div_css"></div>
<br>
<form id="form_geo_salida">
	<div class="row">
		<div class="col-md-1"></div>

		<div class="col-md-3" align="left">
			<label><b>Fecha de ingreso</b></label>
			<p><?php echo date_format( date_create($reg->fecha_recepcion) ,'d-m-Y');?></p>
			<br>

			<label><b>Propietario</b></label>
			<p><?php echo $reg->solicitante.' '.$reg->apaterno.' '.$reg->amaterno; ?></p>
			<br>

			<label><b>Clave catastral</b></label>
			<p><?php echo $reg->clavec; ?></p>
			<br>

			<label><b>Municipio</b></label>
			<p><?php echo $reg->municipio; ?></p>
			<br>

			<label><b>Superficie (m2)</b></label>
			<p><?php echo $reg->superficieinicial; ?></p>
			<br>
			<!-- <label><b>Fecha de notificación</b></label>
			<p><?php echo date_format( date_create($reg->fechanotificacion) ,'d-m-Y');?></p>
			<br> -->
		</div>

		<div class="col-md-7" align="left">
			<div class="row">
				<div class="col-md-4">
					<label><b>Fecha del levantamiento topográfico</b></label>
				</div>
				<div class="col-md-8" align="left">
					<input id="fecha_lt" name="fecha_lt" type="date" class="form-control" style="width:60%;" required="" min="<?php echo $fecha_min_lt;?>"/>
				</div>			
			</div>
			<!-- <br>
			<div class="row">
				<div class="col-md-4">
					<label><b>Fecha de notificación</b></label>
				</div>
				<div class="col-md-8">
					<input id="fecha_notificacion" name="fecha_notificacion" type="date" class="form-control" style="width:60%;" required="" />
				</div>			
			</div> -->
			<br>
			<div class="row">
				<div class="col-md-4">
					<label><b>Especialista asignado</b></label>
				</div>
				<div class="col-md-8">
					<!-- <input id="especialista" name="especialista" type="text" class="form-control" placeholder="Ingrese especialista" required="" /> -->
					<select id="especialista" name="especialista" class="form-control" onchange="quitar_contorno('especialista');" >
						<option selected="" hidden="" value="0">Seleccione especialista</option>
						<?php foreach ($especialistas as $esp) { ?>
						<option value="<?php echo $esp->id; ?>"><?php echo $esp->nombre.' '.$esp->apep.' '.$esp->apem ; ?></option>
						<?php } ?>	
					</select>
				</div>	
			</div>
			<br>
			<div class="row">
				<div class="col-md-4">
					<label><b>Equipo asignado</b></label>
				</div>
				<div class="col-md-8">
					<!-- <select id="equipo" name="equipo" class="form-control" required="">
						<option hidden="" value="0">Seleccione equipo</option>
						<option value="1">Estación Leica</option>
						<option value="2">Estación Focus</option>
					</select> -->
					<select id="equipo" name="equipo" class="form-control" onchange="put_inventario(this.value); quitar_contorno('equipo');" >
						<option selected="" hidden="" value="0">Seleccione equipo</option>
						<?php foreach ($equipos as $equipo) { ?>
						<option value="<?php echo $equipo->inventario;?>"><?php if($equipo->tipo==1){echo 'Estación Leica ('.$equipo->inventario.')';}elseif($equipo->tipo==2){echo 'Estación Focus ('.$equipo->inventario.')';} ?></option>
						<?php } ?>						
					</select>
				</div>	
			</div>
			<br>
			<div class="row" id="info_equipo" style="display:none;">
				<div class="col-md-4" style="display:none;">
					<label><b>No. de inventario</b></label>
				</div>
				<div class="col-md-8" style="display:none;">
					<input id="no_inventario" name="no_inventario" type="text" class="form-control" placeholder="Ingrese no. de inventario" required="" />
				</div>
				<div class="col-md-11">
					<table class="table ">
						<tr>
							<td style="color:#6f8ba4; width:45%;"><b>&nbsp&nbsp Marca</b></td>
							<td id="info_equipo_marca"><?php //echo $equipo->marca;?></td>
						</tr>
						<tr>
							<td style="color:#6f8ba4; width:45%;"><b>&nbsp&nbsp Modelo</b></td>
							<td id="info_equipo_modelo"><?php //echo $equipo->modelo;?></td>
						</tr>
						<tr>
							<td style="color:#6f8ba4; width:45%;"><b>&nbsp&nbsp Número de serie</b></td>
							<td id="info_equipo_serie"><?php //echo $equipo->num_serie;?></td>
						</tr>
						<tr>
							<td style="color:#6f8ba4; width:45%;"><b>&nbsp&nbsp Número de inventario</b></td>
							<td id="info_equipo_inventario"><?php //echo $equipo->inventario;?></td>
						</tr>
					</table>
				</div>
						
			</div>
			<br>
			<div class="row">
				<div class="col-md-4">
					<label><b>Fecha y hora de salida del equipo</b></label>
				</div>
				<div class="col-md-8" align="left">
					<input id="fecha_equipo_salida" name="fecha_equipo_salida" type="datetime-local" class="form-control" style="width:60%;" required="" min="<?php echo $fecha_min_lt; ?>T00:00" />
				</div>	
			</div>
			<!-- <br>
			<div class="row">
				<div class="col-md-4">
					<label><b>Hora de salida del equipo</b></label>
				</div>
				<div class="col-md-8">
					<input id="hora_equipo_salida" type="text" class="form-control" placeholder="Ingrese hora de salida" />
				</div>			
			</div> -->
			<br>
			<div class="row">
				<div class="col-md-12" align="center">
					<button id="btn_guardar" class="btn btn-info" type="button" onclick="guardar_equipo_salida( '<?php echo $_SESSION["usuario"];?>' );">Guardar</button>	
				</div>			
			</div>		
		</div>

		<div class="col-md-1"></div>
	</div>
</form>

<script type="text/javascript">
	function put_inventario(inventario){
		///se muestra el bloque de informacion de equipo
		$("#info_equipo").show();
		$("#no_inventario").val(inventario);
		$('#no_inventario').prop('readonly', true);

		//////asignamos los valores a la tabla con los distintos valores del equipo, de acuerdo al inventario seleccionado
		$.ajax({
			url:'Ops2.php',
			data:{action:'get_equipo',inventario:inventario},
			dataType:'json',
			type:'post',
			success:function(v){
				//alert(v);
				$("#info_equipo_marca").html(v.marca);
				$("#info_equipo_modelo").html(v.modelo);
				$("#info_equipo_serie").html(v.num_serie);
				$("#info_equipo_inventario").html(v.inventario);
			}
		});
	}

	function quitar_contorno(elemento){
	    $("#"+elemento).removeAttr("style");
	}
</script>

<script>
    setTimeout(function () { $("#loader").hide(); }, 300); 
</script>