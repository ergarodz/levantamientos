
<style type="text/css">
	.dark{color:#5D5D5D;}
</style>

<div class="row" align="center" >
	<div class="col-md-4"></div>
	<div class="col-md-4">
		<label><b class="dark">Seleccione periodo</b></label>
		<select id="periodo_tabla" class="form-control" onchange="load_tabla_serverside();">
			<option selected hidden value="-1">Seleccione opción</option>
			<option value="0">Levantamientos cancelados por área geografía</option>
			<option value="3">2025-2026 (26/03/2025 - )</option>
			<option value="2">2024-2025 (19/03/2024 - 25/03/2025)</option>
			<option value="1">-2024 ( - 18/03/2024)</option>
		</select>
	</div>
	<div class="col-md-4"></div>
	
</div>
<br><br>

<div id="tabla_serverside_geo"></div>

<script>
	function load_tabla_serverside(){
		const periodo=$("#periodo_tabla").val();
		//alert(periodo);
		
		if(periodo==0){
			$("#tabla_serverside_geo").load('serverside/tbl_serverside_deleted.php');
		}else{
			$("#tabla_serverside_geo").load('serverside/tbl_serverside_all.php?periodo='+periodo);
		}
		
	}
</script>