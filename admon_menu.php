<header>
	<div class="header-top-bar">
		<div class="" align="center">
			<div class="row align-items-center">
				<div class="col-lg-3">
					<a class="navbar-brand" >
						<img src="images/igecem.png" alt="" class="img-fluid" width="50" height="50"> 
					</a>
				</div>
				<div class="col-lg-6">
					<p style="font-size: xx-large; text-align: center;"><b>LEVANTAMIENTOS TOPOGRAFICOS</b></p>
					<input type="text" name="delegacion" id="delegacion" style="display: none;" value="<?php echo $_SESSION["abrev"]; ?>">
					<input type="text" name="iddelegacion" id="iddelegacion" style="display: none;" value="<?php echo $_SESSION["id_userAg"]; ?>">
					<?php 
					$anio = date('Y');
					$anio2 = substr($anio, -2);
					?>
					<input type="hidden" name="anioAct" id="anioAct" value="<?php echo $anio2; ?>">

					<input type="text" hidden="" id="tipo_usr" value="<?php echo $_SESSION['tipo_usr'];?>">
				</div>
				<div class="col-lg-3"></div>
			</div>
		</div>
	</div>
	<div class="row" style="background-color: #8a2034;">		
		
		<div class="col-md-3">
			<p style="text-align:left; color:white; font-size:x-large; margin-top:10px;">&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; <?php echo $_SESSION["username"];?></p>
		</div>
		<div class="col-md-4"></div>
		
		<div class="col-md-1" style="margin-top:10px;">
			<?php if($_SESSION['username']=='ADMINISTRADOR'){ ?>
			<a href="admon_csv.php" title="Descargar Excel"><i class="icofont-spreadsheet icofont-2x" style="color: white;"></i></a>
			<?php } ?>
		</div>
		
		<div class="col-md-1" style="margin-top:10px;">
			<?php if($_SESSION['username']=='ADMINISTRADOR'){ ?>
			<a href="admon_delete.php" title="Eliminar"><i class="icofont-delete icofont-2x" style="color: white;"></i></a>
			<?php } ?>
		</div>
		
		<div class="col-md-1" style="margin-top:10px;">
			<?php if($_SESSION['username']=='GEOGRAFÍA'){ ?>
			<a href="semaforizacion.php" title="Avance de levantamientos" ><i class="icofont-search-stock icofont-2x" style="color: white;"></i></a>
			<?php } ?>
		</div>

		<div class="col-md-1" style="margin-top:10px;">
			<?php if($_SESSION['username']=='ADMINISTRADOR'){?>
				<a href="admonIni.php" title="Inicio"><i class="icofont-home icofont-2x" style="color: white;"></a></i>
			<?php } ?>
			<?php if($_SESSION['username']=='GEOGRAFÍA'){?>
				<a href="geo.php" title="Inicio"><i class="icofont-home icofont-2x" style="color: white;"></a></i>
			<?php } ?>
		</div>
		
		<div class="col-md-1" style="margin-top:10px;">
			<a class="" data-toggle="modal" data-target="#myModal" style="color: white; cursor: pointer;" title="Cerrar Sesión"><i class="icofont-sign-out icofont-2x"></i></a> 
		</div>
	</div>
</header>