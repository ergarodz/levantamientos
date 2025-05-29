		<header>
			<div class="header-top-bar">
				<div class="container">
					<div class="row align-items-center">
						<div class="col-lg-3">
						<a class="navbar-brand" href="index.html">
						<img src="images/igecem.png" alt="" class="img-fluid" width="50" height="50"> 
						</a>
						</div>
						<div class="col-lg-7">
							<p style="font-size: xx-large; text-align: center;">LEVANTAMIENTOS TOPOGRAFICOS</p>
							<input type="text" name="delegacion" id="delegacion" style="display: none;" value="<?php echo $_SESSION["abrev"]; ?>">
							<input type="text" name="iddelegacion" id="iddelegacion" style="display: none;" value="<?php echo $_SESSION["id_userAg"]; ?>">
							<?php 
							$anio = date('Y');
		  					$anio2 = substr($anio, -2);
							?>
							<input type="hidden" name="anioAct" id="anioAct" value="<?php echo $anio2; ?>">

						</div>
						<div class="col-lg-2">
							
						</div>
					</div>
				</div>
			</div>
			<div class="col-md-12" style="background-color: #9f747f;">
		        <div class="row">
		            <div class="col-md-3"></div>
		            <div class="col-md-4">
		            	<p style="text-align: center; color: white; font-size: x-large;">&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; <?php echo $_SESSION["username"];?></p>
		            </div>
		            <div class="col-md-1">
		                <a href="admon_csv.php" title="Descargar Excel"><i class="icofont-spreadsheet icofont-2x" style="color: white;"></i></a>
		            </div>
		            <div class="col-md-1">
		                <a href="admon_delete.php" title="Eliminar"><i class="icofont-delete icofont-2x" style="color: white;"></i></a>
		            </div>
		            <div class="col-md-1">
		                <a href="admonIni.php" title="Inicio"><i class="icofont-home icofont-2x" style="color: white;"></i></a>
		            </div>
		            <div class="col-md-1">
		                <a class="" data-toggle="modal" data-target="#myModal" style="color: white; cursor: pointer;" title="Cerrar Sesión"><i class="icofont-sign-out icofont-2x"></i></a> 
		            </div>
		            <div class="col-md-1">
		            </div>
		        </div>
		    </div>
		</header>