<?php 
	if (session_status() == PHP_SESSION_NONE) { session_start(); }

	if (!isset($_SESSION["id_userAg"])) {
	  header("Location: index.php");   
	}

	//$_SESSION["id_userAg"];
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

	  <script type="text/javascript" src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
      <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css">

	  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

	  <!-- <script src="js/script.js"></script> -->
	  <script src="js/geo.js"></script>

	  <script src="https://momentjs.com/downloads/moment-with-locales.min.js"></script>

	  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>

	  <link href="css/loader.css" rel="stylesheet" type="text/css" />

	  <script type="text/javascript" >
	      window.location.hash="no-back-button";
	      window.location.hash="Again-No-back-button" //chrome
	      window.onhashchange=function(){window.location.hash=""; } 
	  </script>

	</head>

	<!--loader-->
    <div id="loader" class="modal fade" style="margin: auto;"></div>
    <!-- <script type="text/javascript">
    	$("#loader").modal('show');
    </script> -->

	<body id="top">	

		<header>
			<div class="header-top-bar">
				<div class="">
					<div class="row align-items-center" >
						<div class="col-lg-1"></div>
						<div class="col-lg-2">
							<a class="navbar-brand" style="cursor:default;">
								<img src="images/igecem.png" alt="" class="img-fluid" width="50" height="50"> 
							</a>
						</div>
						
						<div class="col-lg-6">
							<p style="font-size: xx-large; text-align: center; cursor:default;"><b>LEVANTAMIENTOS TOPOGRÁFICOS</b></p>
							<input type="text" name="delegacion" id="delegacion" style="display: none;" value="<?php echo $_SESSION["abrev"]; ?>">
							<input type="text" name="iddelegacion" id="iddelegacion" style="display: none;" value="<?php echo $_SESSION["id_userAg"]; ?>">
							<?php 
								$anio = date('Y');
			  					$anio2 = substr($anio, -2);
							?>
							<input type="hidden" name="anioAct" id="anioAct" value="<?php echo $anio2; ?>">
						</div>
						<div class="col-lg-3">
							
						</div>
					</div>
				</div>
			</div>
			<div class="col-md-12" style="background-color: #8a2034; ">
		        <div class="row">
		            <div class="col-md-3"></div>
		            <div class="col-md-6" style="margin-top:15px;">
		            	<p style="text-align:center; color:white; font-size:x-large; cursor:default; font-weight:bold;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $_SESSION["username"]; ?></p>
		            </div>

					<div class="col-md-1" style="margin-top:15px;"></div>

		            <div class="col-md-1" style="margin-top:15px;">
		            	<!-- <a href="delegaciones.php" title="Inicio"><i class="icofont-home icofont-2x" style="color: white;"></a></i> -->
		            	<a href="semaforizacion.php" title="Avance de levantamientos" ><i class="icofont-search-stock icofont-2x" style="color: white;"></i></a>
		            </div>

		            <div class="col-md-1" style="margin-top:15px;">
		                <a class="" data-toggle="modal" data-target="#myModal" style="color: white; cursor: pointer;" title="Cerrar Sesión"><i class="icofont-sign-out icofont-2x"></i></a> 
		            </div>
		            
		        </div>
		    </div>
		</header>
		<section>
			<div align="center">
				<br><br>
				<div class="row" >
					<div class="col-md-2">
						
						<button class="btn btn-default menu-btn" type="button" onclick="div_carga(1);" style="font-weight:normal; font-size:12pt;">Registrar salida</button>
						<br><br>
						<button class="btn btn-default menu-btn" type="button" onclick="div_carga(5);" style="font-weight:normal; font-size:12pt;">En Campo</button>
						<br><br>
						<button class="btn btn-default menu-btn" type="button" onclick="div_carga(2);" style="font-weight:normal; font-size:12pt;">Registrar entrega</button>
						<br><br><br><br><br>
						<button class="btn btn-default menu-btn" type="button" onclick="div_carga(3);" style="font-weight:normal; font-size:12pt;">Levantamientos topográficos</button>
						<!-- <br><br>
						<button class="btn btn-default menu-btn" type="button" onclick="div_carga(4);" style="font-weight:normal; font-size:12pt;">Reportes?</button> -->

					</div>
					<script>
						$(document).ready(function() {
							$('.menu-btn').on('click', function() {
								$('.menu-btn').css({
									'color': '',
									'font-size': '11pt',
									'font-weight': 'normal'
								});
								$(this).css({
									'color': '#8a2034',
									'font-size': '14pt',
									'font-weight': 'bold'
								});
							});
						});
					</script>

					<div class="col-md-10" id="div_carga" ><!-- aqui se muestra la seleccion de operacion --></div>

				</div>						
			</div>
		</section>
		
		<?php require_once 'modals_cerrar.php';?>
		<?php require_once 'modals_ad_ok.php';?>

		<!-- <script type="text/javascript">
	    	$("#loader").modal('show');
	    </script> -->
	</body>
</html>

