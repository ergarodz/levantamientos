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

		<link href="css/loader.css" rel="stylesheet" type="text/css" />

		<script type="text/javascript" >
		  window.location.hash="no-back-button";
		  window.location.hash="Again-No-back-button" //chrome
		  window.onhashchange=function(){window.location.hash=""; } 
		</script>

		<script type="text/javascript" src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
    	<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css">
	</head>
	<body id="top">
		
		<!-- Loader Overlay -->
		<div id="loader">
			<div id="loader-spinner"></div>
		</div>
		<script>
			$("#loader").show();
		</script>

	  	<form action="info_excel.php" method="post" target="_blank" id="FormularioExportacion">
			<input type="hidden" id="datos_a_enviar" name="datos_a_enviar" value="Exportar a Excel" />
		</form>

		<?php 
		require_once 'admon_menu.php';
		///llama al modal con id myModal
		require_once 'modals_cerrar.php';

		require_once 'Ops2.php';
		$erick=new Ops2();

		$periodos=$erick->get_periodos();		
		?>

		<br>
		<div class="row" align="center">
			<div class="col-md-2"></div>
			<div class="col-md-8">
				<div class="row">
				<div class="col-md-2"><label><b>DESCARGAR EXCEL</b></label></div>
				<div class="col-md-3" style="text-align: right;">
					<label>Seleccione periodo</label>
				</div>
				<div class="col-md-4">
					<select id="periodo_select" class="form-control" style="" onchange="cargar_tbl_csv();">
						<option value=0 hidden >Seleccione periodo</option>
						<?php foreach($periodos as $periodo){ ?>
						<option value='<?php echo $periodo->num_periodo;?>' ><?php echo $periodo->txt; ?></option>
						<?php } ?>
					</select>
				</div>
				<div class="col-md-3"></div>
				</div>
				
				
			</div>
			<div class="col-md-2"></div>
		</div>


		<div id="tbl_csv"></div>
		

		<!-- <div class="modal fade" id="myModal_eliminar" role="dialog">
		    <div class="modal-dialog">.
				<div class="modal-content">
					<div class="modal-header">
						<h4 class="modal-title">Eliminar registro</h4>
					  	<button type="button" class="close" data-dismiss="modal">&times;</button>			 
					</div>
					<div class="modal-body">
						<p>¿Desea eliminar este registro?</p>
					</div>
					<div class="modal-footer" id="actualizar_id_borrado">
					</div>
				</div>	      
		    </div>
		</div> -->			

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

	<script>

		function cargar_tbl_csv(){
			$("#loader").show();
			const periodo=$("#periodo_select").val();
			$("#tbl_csv").load('tbl_csv.php?periodo='+periodo);
		}
		setTimeout(function () { $("#loader").hide(); }, 300); 
	</script>
</html>
