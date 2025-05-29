<?php
	if(!isset($erick)){
		require_once 'Ops2.php';
		$erick=new Ops2();
	}		
	$registros=$erick->get_regs_proceso_regreso();

	$brigada=$_SESSION['brigada'];
?>

<div class="row">
	<div class="col-md-12"><h5>REGISTRAR ENTREGA</h5></div>

	<div class="col-md-3" style="">
		<label><b>Concluir levantamiento</b></label>
		<br><br>
		<div class="row">
			<div class="col-md-6">
				<label>Seleccione FUP:</label>
			</div>
			<div class="col-md-6">
				<select id="fup" style="width:100%;" class="form-control" onchange="carga_info_entrega();">
					<option hidden="" selected="">Seleccionar</option>
					<?php
					foreach ($registros as $reg) {
						if(  ($reg->areaproduc=='Brigada' && $brigada==true) || ($reg->areaproduc=='Geografia' && $brigada==false)  ){
					?>
					<option value="<?php echo $reg->fup; ?>"><?php echo $reg->fup; ?> </option>

				<?php } } ?>
				</select>
			</div>
		</div>
	</div>

	<div class="col-md-9" id="info_entrega"></div>
			
</div>