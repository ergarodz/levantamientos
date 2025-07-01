

<?php
    if(!isset($erick)){
		require_once 'Ops2.php';
		$erick=new Ops2();
	}		
	$registros=$erick->get_regs_proceso_regreso();

	$brigada=$_SESSION['brigada'];

    //echo json_encode($registros);
?>

<div class="row">

    <div class="col-md-4" style="">
        <label style="font-size:16pt;"><b>Levantamientos en campo</b></label>
		<br><br>
		<div class="row">
			<div class="col-md-6">
				<label>Seleccione FUP:</label>
			</div>
			<div class="col-md-6">
				<select id="fup" style="width:100%;" class="form-control" onchange="carga_opciones();">
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
        <br><br> 
                          
        <div class="row opciones" style="display:none;">
            <div class="col-12 d-flex justify-content-end">
                <button type="button" style="background-color:#d8c4a5; color:#8a2034;" class="btn btn-warning btn-block mb-2" onclick="carga_info_op(1);">
                    Agregar día(s) al levantamiento
                </button>
            </div>
        </div>
        <br>
        <div class="row opciones" style="display:none;">
            <div class="col-12 d-flex justify-content-end">
                <button type="button" style="background-color:#d8c4a5; color:#8a2034;" class="btn btn-warning btn-block mb-2" onclick="carga_info_op(2);">
                    Cambiar especialista
                </button>
            </div>
        </div>
        <br>
        <div class="row opciones" style="display:none;">
            <div class="col-12 d-flex justify-content-end">
                <button type="button" style="background-color:#d8c4a5; color:#8a2034;" class="btn btn-warning btn-block mb-2" onclick="carga_info_op(3);">
                    Cambiar fecha de levantamiento
                </button>
            </div>
        </div>
        <br>
        <div class="row opciones" style="display:none;">
            <div class="col-12 d-flex justify-content-end">
                <button type="button" style="background-color:#d8c4a5; color:#8a2034;" class="btn btn-warning btn-block mb-2" onclick="carga_info_op(4);">
                    Cancelar levantamiento
                </button>
            </div>
        </div>
    </div>

    <div class="col-md-8" id="info_op"></div>
</div>

<script>
    function carga_opciones(){
        $(".opciones").show();
    }

    function carga_info_op(opcion){
        $("#loader").show();
		setTimeout(function () {
			$("#loader").hide();
            $("#info_op").load("geo_lt_campo_info.php?opcion=" + opcion + "&fup=" + $("#fup").val() );
        }, 400);
    }
</script>