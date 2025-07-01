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
					<p style="font-size: xx-large; text-align: center;"><b>LEVANTAMIENTOS TOPOGRÁFICOS</b></p>
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
        <div class="row" style="background-color: #8a2034;">
            <div class="col-md-3">
            	<p style="text-align:left; color:white; font-size:x-large; margin-top:10px; font-weight:bold;">&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;DELEGACIÓN <?php echo $_SESSION["username"]; ?></p>
            </div>
            <div class="col-md-6"></div>
            <div class="col-md-1" style="margin-top:10px;"></div>
            <div class="col-md-1" style="margin-top:10px;">
                <a href="delegaciones.php" title="Inicio"><i class="icofont-home icofont-3x" style="color:white;"></a></i>
            </div>
            <div class="col-md-1" style="margin-top:10px;">
                <a class="" data-toggle="modal" data-target="#myModal" style="color:white; cursor:pointer;" title="Cerrar Sesión"><i class="icofont-sign-out icofont-3x"></i></a> 
            </div>        
        </div>
	</div>      
</header>