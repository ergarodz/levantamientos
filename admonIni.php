<?php 
  if (session_status() == PHP_SESSION_NONE) {session_start();}

  if (!isset($_SESSION["id_userAg"])) {
      header("Location: index.php");   
  }

  $_SESSION["id_userAg"];
  //echo json_encode($_SESSION);
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>Levantamiento Topografico</title>
    <link rel="stylesheet" href="plugins/bootstrap/bootstrap.min.css">
    <link rel="stylesheet" href="plugins/icofont/icofont.min.css">
    <script src="plugins/jquery/jquery.js"></script>
    <script src="plugins/bootstrap/bootstrap.min.js"></script> 
    <link rel="stylesheet" href="css/style.css"> 
    <link rel="icon" type="image/png" sizes="16x16" href="images/favicon.ico"> 
    <script type="text/javascript" >
        window.location.hash="no-back-button";
        window.location.hash="Again-No-back-button" //chrome
        window.onhashchange=function(){window.location.hash=""; } 
    </script>

    <script src="js/script.js"></script>
    <link href="css/loader.css" rel="stylesheet" type="text/css" />

  </head>
  <body id="top">
  
    <?php 
      require_once 'admon_menu.php';
      ///llama al modal con id myModal
      require_once 'modals_cerrar.php';
    ?>

    <!-- Loader Overlay -->
    <div id="loader">
      <div id="loader-spinner"></div>
    </div>
    <script>
      $("#loader").show();
    </script>

    <section class="banner">
      <div class="container">
        <div class="row">
          <div class="col-lg-6 col-md-12 col-xl-7">
            <div class="block">
              <div class="divider mb-3"></div>
              <span class="text-uppercase text-sm letter-spacing ">Registros</span> 
              <h1 class="mb-3 mt-3">Levantamientos Topográficos</h1>
              
              <!--<p class="mb-4 pr-5">A repudiandae ipsam labore ipsa voluptatum quidem quae laudantium quisquam aperiam maiores sunt fugit, deserunt rem suscipit placeat.</p> -->
              
            </div>
          </div>
        </div>
      </div>
    </section>
    <section class="features">
      <div class="container">
        <div class="row">
          <div class="col-lg-12">
            <div class="feature-block d-lg-flex">
                
              <div class="feature-item mb-5 mb-lg-0">
                <div class="feature-icon mb-4">
                  <i class="icofont-edit"></i>
                </div>
                <span></span>
                <h4 class="mb-3">Proceso de registros</h4>
                <p class="mb-4">Registros realizados mostrando el estatus en el que se encuentran.</p>
                  <center>
                    <a href="semaforizacion.php" class="btn btn-main btn-round-full" id="procesoRegistro">Mostrar</a>
                  </center>
              </div>
              <div class="feature-item mb-5 mb-lg-0">
                <div class="feature-icon mb-4">
                  <i class="icofont-ui-folder"></i>
                </div>
                <h4 class="mb-3">Listado de registros</h4>
                <p>Información de todos los registros realizados</p>
                <center>
                <a href="admin.php" class="btn btn-main btn-round-full" id="buscaRegistro">Mostrar Listado</a>
                </center>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section> 
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
    setTimeout(function () { $("#loader").hide(); }, 300); 
  </script>

</html>
