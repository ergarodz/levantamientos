<?php

if (session_status() == PHP_SESSION_NONE) { session_start(); }

if (isset($_SESSION['id_userAg'])) { ///////validar que vista se debe ver si la variable isset
	switch ($_SESSION['tipo_usr']) {
		case '1':///admin
			header("Location: admonIni.php");
			break;
		case '2':////delegacion
			header("Location: delegaciones.php");
			break;
		case '3':////geografía
			header("Location: geo.php");
			break;
	}	
}

?>


<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>Levantamiento Topografico</title>
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="description" content="Health Care Medical Html5 Template">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=5.0">
  <meta name="author" content="Themefisher">
  <meta name="generator" content="Themefisher Novena HTML Template v1.0">
  <link rel="icon" type="image/png" sizes="16x16" href="images/favicon.ico">
  <link rel="stylesheet" href="plugins/bootstrap/bootstrap.min.css">
  <link rel="stylesheet" href="plugins/icofont/icofont.min.css">
  <link rel="stylesheet" href="plugins/slick-carousel/slick/slick.css">
  <link rel="stylesheet" href="plugins/slick-carousel/slick/slick-theme.css">
  <link rel="stylesheet" href="css/style.css">

  <link rel="stylesheet" href="css/headerAndFooter.css">
  <link href="css/loader.css" rel="stylesheet" type="text/css" />

  <!-- 
    Essential Scripts
    =====================================-->
    <script src="plugins/jquery/jquery.js"></script>
    <script src="plugins/bootstrap/bootstrap.min.js"></script>
    <script src="plugins/slick-carousel/slick/slick.min.js"></script>
    <script src="plugins/shuffle/shuffle.min.js"></script>

    <!-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script> -->

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>
    
    <script src="js/login.js"></script>

</head>
<body>
	<!-- Loader Overlay -->
	<div id="loader">
		<div id="loader-spinner"></div>
	</div>

	<?php require_once 'header.php';?>
	<section class="section about">
		<div class="container">
			<div class="row">
				<div  class="col-lg-7 col-sm-7">
					<br><br>
				<p style="text-align: center; font-size: xx-large; font-weight: bold; color: #8a2034;">LEVANTAMIENTOS TOPOGRÁFICOS</p>
				<br><br><br>
				 <div class="row">
					<div class="col-lg-2"><br></div>
					<div class="col-lg-7">
						<center>
							<div class="input-group mb-3">
								<div class="input-group-append">
							    	<span class="input-group-text" id="basic-addon2"><i class="icofont-user-alt-5 icofont-2x"></i></span>
							  	</div>
								<input type="text" placeholder="  Ingresar usuario" aria-label="Recipient's username" aria-describedby="basic-addon2" style="width: 300px; border-top: none; border-right: none; border-left: none; " id="username">
							  
							</div>

							<div class="input-group mb-3">
								<div class="input-group-append">
									<span class="input-group-text" id="basic-addon2"><i class="icofont-ui-password icofont-2x"></i></span>
								</div>
							  <input type="password" placeholder="  Ingresar contraseña" aria-label="Recipient's username" aria-describedby="basic-addon2" style="width: 300px; border-top: none; border-right: none; border-left: none;" id="passw">
							 
							</div>
					
						</center>
					</div>
					<div class="col-lg-2"><br></div>
				</div>
				<center>
					<br><br>
					<a class="btn btn-main btn-round-full" onclick="login();" id="login">Iniciar Sesión</a>
				</center>
		
				</div>
				<div  class="col-lg-5 col-sm-5">
					<div class="about-img">
						<img src="images/about/IMG-7901.jpg" width="500" height="500">
						
					</div>
				</div>
				
			
				<div class="col-lg-4">
					
				</div>
			</div>
		</div>
		<br><br><br><br>
	</section>

	<footer class="footer section gray-bg">
		<div class="container">
			<div class="row">
				<div class="col-lg-1 mr-auto col-sm-">
					<div class="widget mb-5 mb-lg-0">
						<div class="logo mb-3">
					
							<img src="images/igecem.png" width="60" height="70">
	       
						</div>
					</div>
				</div>

					<div class="col-lg-4 mr-auto col-sm-4">
							<div class="footer-contact-block mb-4">
							<div class="icon d-flex align-items-center">
								<br><br><br>
								<span class="h6 mb-0" style="font-size: small;">Avenida Alfredo del Mazo No. 1135-B.
																		       Colonia La Magdalena.
																		       Toluca, Estado de Méxco C.P:50010</span>
							</div>
							<h4 class="mt-2">
								
							</h4>
						</div>
							
					</div>

				<div class="col-lg-3 col-md-4 col-sm-3">
					<div class="widget widget-contact mb-5 mb-lg-0">
						<h4 class="text-capitalize mb-3"></h4>

						<div class="footer-contact-block mb-4">
							<div class="icon d-flex align-items-center">
								<i class="icofont-email mr-3"></i>
								<span class="h6 mb-0" style="font-size: small;">igecem@igecem.gob.mx</span>
								<!-- <a href="mailto:support@email.com"> igecem@igecem.gob.mx</a>   -->
							</div>
							<h4 class="mt-2">
								
							</h4>
						</div>

						<div class="footer-contact-block">
							<div class="icon d-flex align-items-center">
								<i class="icofont-support mr-3"></i>
								<span class="h6 mb-0" style="font-size: small;">01 (722) 215 9481 y 214 9357
									<!-- <a href="tel:+23-345-67890">01 (722) 215 9481 y 214 9357</a>  -->
								</span>
							</div>
						</div>
					</div>
				</div>
				<div class="col-lg-3 col-md-4 col-sm-3">
					<div class="widget mb-5 mb-lg-0">
						<h4 class="text-capitalize mb-3"></h4>
						<center>
							<ul class="list-inline footer-socials mt-4">
							<li class="list-inline-item">
								<a target="_blank" href="https://www.facebook.com/IGECEM/"><i class="icofont-facebook"></i></a>
							</li>
							<li class="list-inline-item">
								<a target="_blank" href="https://twitter.com/IGECEM"><i class="icofont-twitter"></i></a>
							</li>
							<li class="list-inline-item">
								<a target="_blank" href="https://igecem.edomex.gob.mx/"><i class="icofont-web"></i></a>
							</li>
						</ul>
						</center>
					</div>
				</div>
			</div>
			<div class="footer-btm py-4 mt-5">
				<div class="row align-items-center justify-content-between">
					<div class="col-lg-6">
						<div class="copyright">
						 <p style="font-size: small;">Copyright &copy;, IGECEM. Versión 2.2</p>
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
    
  </body>
  </html>