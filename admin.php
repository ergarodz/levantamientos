<?php 
  if (session_status() == PHP_SESSION_NONE) {session_start();}

  if (!isset($_SESSION["id_userAg"])) {
      header("Location: index.php");    
  }

  // $id = $_SESSION["id_userAg"];

  // require_once 'Ops.php'; 
  // $op= new Op();  

  // $users = $op->lista2($id); 
?>

<html>
  <head>
    
    <link rel="stylesheet" href="plugins/bootstrap/bootstrap.min.css">
    <link rel="stylesheet" href="plugins/icofont/icofont.min.css">    

    <!-- <script type="text/javascript" src="https://code.jquery.com/jquery-3.3.1.js"></script> -->
    <script src="plugins/jquery/jquery.js"></script>
    <!-- <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script> -->
    <script src="plugins/bootstrap/bootstrap.min.js"></script>

    <script type="text/javascript" src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css">
    <link rel="icon" type="image/png" sizes="16x16" href="images/favicon.ico"> 

    <script src="https://momentjs.com/downloads/moment-with-locales.min.js"></script>

    <link rel="stylesheet" href="css/style.css"> 
    <script src="js/script.js"></script>
    <link href="css/loader.css" rel="stylesheet" type="text/css" />

    <script type="text/javascript">
      $(document).ready(function() {
        $('#example2').DataTable({ 
           "language": { "url": "//cdn.datatables.net/plug-ins/1.10.15/i18n/Spanish.json" }
        } );
      } );
    </script>
  </head>
  <body>
    <!-- Loader Overlay -->
    <div id="loader">
      <div id="loader-spinner"></div>
    </div>
    <script>
      $("#loader").show();
    </script>

    <?php require_once 'admon_menu.php';?>
    <?php require_once 'modals_cerrar.php';?>
    <br>
    <div class="row">
        <div class="col-md-3"></div>
        <div class="col-md-6">
          <p style="text-align: center; font-size: x-large;  font-weight: bold;">CONTROL DE RECEPCIÓN, PROCESO Y ENTREGA DE LEVANTAMIENTOS TOPOGRÁFICOS CATASTRALES <?php echo date('Y');?></p>
        </div>
        <div class="col-md-3"></div>
    </div>

    <?php
      require_once 'Ops2.php';
      $ops2=new Ops2();
      $periodos=$ops2->get_periodos();
      //echo json_encode($periodos);
    ?>

    <div class="row" align="center">
      <div class="col-md-2"></div>
      <div class="col-md-8">
        <div class="row">
          <div class="col-md-2"></div>
          <div class="col-md-3" style="text-align: right;">
            <label>Seleccione periodo</label>
          </div>
          <div class="col-md-4">
              <select id="periodo_select" class="form-control" style="" onchange="cargar_tbl_fup();">
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

    <div id="tbl_fups"></div>

    

    <script>
      function cargar_tbl_fup(){
        const periodo=$("#periodo_select").val();
        //alert(periodo);
        $("#tbl_fups").load('tbl_fup.php?periodo='+periodo+'&lista=2');
      }

      setTimeout(function () { $("#loader").hide(); }, 300); 
    </script>
  </body>
</html>

