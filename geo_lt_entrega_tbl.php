<?php
	$fup='ERICK';
	if(isset($_REQUEST['fup']) ){
		$fup=$_REQUEST['fup'];
	}	

	if(!isset($erick)){
		require_once 'Ops2.php';
		$erick=new Ops2();
	}	
?>
<div id="div_css"></div>
<br>
<form id="form_geo_entrega" enctype="multipart/form-data">
	<div class="row">
		<div class="col-md-1"></div>

		<div class="col-md-8" align="left">
			<div class="row">
				<div class="col-md-4">
					<label><b>Fecha y hora de entrega del equipo</b></label>
				</div>
				<div class="col-md-8">
					<input id="fecha_equipo_entrega" name="fecha_equipo_entrega" class="form-control" style="width:55%;" type="datetime-local" required="">
				</div>
			</div>
			<br>
			<div class="row">
				<div class="col-md-4">
					<label><b>Observaciones del equipo</b></label>
				</div>
				<div class="col-md-8">
					<textarea id="obs_equipo_entrega" name="obs_equipo_entrega" class="form-control"></textarea>
				</div>
			</div>
			<br>
			<div class="row">
				<div class="col-md-4">
					<label><b>Número de GEO</b></label>
				</div>
				<div class="col-md-8">					
					<!-- <input type="text" id="folio_geo" name="folio_geo" class="form-control" required=""> -->
					 GEO / 
					<input style="width:13%; text-align:center; border:none;" maxlength="4" type="text" id="folio_geo2" name="folio_geo2"  required="" placeholder="0000"> / 
					<input style="width:13%; text-align:center; border:none;" maxlength="4" type="text" id="folio_geo3" name="folio_geo3"  required="" placeholder="año">
						
				</div>
			</div>
			<br>
			<div class="row">
				<div class="col-md-4">
					<label><b>Archivo crudo</b></label>
				</div>
				<div class="col-md-8">
					<div class="row">
						<div class="col-md-2">
							<input type="checkbox" id="iscrudo" name="iscrudo" style="width:32px; height:32px;" onclick="verificar_crudo();" >
						</div>
						<div class="col-md-10">
							<input type="file" id="archivo_crudo" name="archivo_crudo" multiple="" style="display:none; width:100%;" accept=".txt">
						</div>
					</div>					
				</div>
			</div>
			<br>
			<div class="row">
				<div class="col-md-4">
					<label><b>Superficie resultante del levantamiento (M2)</b></label>
				</div>
				<div class="col-md-8">
					<input type="text" id="superficie_resultante" name="superficie_resultante" class="form-control" required="" onkeyup="this.value=validarSuperficie_er1(this.value);">
				</div>
			</div>
			<br>
			<div class="row">
				<div class="col-md-12" align="center">
					<button class="btn btn-info" type="button" onclick="guardar_equipo_entrega();">Guardar</button>	
				</div>			
			</div>
		</div>

		<div class="col-md-3"></div>
	</div>
</form>

<script>
	document.getElementById('archivo_crudo').addEventListener('change', function() {
	    var input = this;
	    // Verificar si se seleccionaron más de 3 archivos
	    if (input.files.length > 3) {
	        //alert('Solo puedes seleccionar hasta 3 archivos.');      
	        $("#titulo_modal_ad").html('Archivos excedentes');
			$("#mensaje_modal_ad").html('Solo se puede seleccionar hasta 3 archivos');
			$("#modal_mensaje_ad").modal('show');

			// Limpiar la selección de archivos
	        input.value = '';
	    }
	});
</script>