<?php 

    session_start();
    if (!isset($_SESSION["id_userAg"])) {
        header("Location: index.php");   
    }

	$id = $_SESSION["id_userAg"];
	//echo $id;
    require_once 'Ops.php'; 
    $op= new Op();  
    //$users = $op->lista2($id); 
    ////$anios=$op->get_anios_recepcion();////se usan los periodos en lugar de esto
    $delegaciones=$op->get_delegaciones(); //echo json_encode($delegaciones);


    require_once 'Ops2.php';
    $ops2=new Ops2();
    $periodos=$ops2->get_periodos();
    //echo json_encode($periodos);
?>

<html>
    <head>
        <link rel="stylesheet" href="css/style.css"> 
        <link rel="stylesheet" href="plugins/bootstrap/bootstrap.min.css">
        <link rel="stylesheet" href="plugins/icofont/icofont.min.css">
        <script src="js/script.js"></script> 
        <!-- <script type="text/javascript" src="https://code.jquery.com/jquery-3.3.1.js"></script> -->
        <script src="plugins/jquery/jquery.js"></script>
        <script type="text/javascript" src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
        <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css">
        <link rel="icon" type="image/png" sizes="16x16" href="images/favicon.ico"> 
        <!-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css"> -->
        <!-- <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script> -->
         <script src="plugins/bootstrap/bootstrap.min.js"></script>

        <link href="css/loader.css" rel="stylesheet" type="text/css" />

        <!-- <script type="text/javascript">
            $(document).ready(function() {
                $('#examplee').DataTable({ 
                    "language": { "url": "//cdn.datatables.net/plug-ins/1.10.15/i18n/Spanish.json" }
                });
            });
        </script> -->
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
            <div class="col-md-2"></div>
            <div class="col-md-8">
                <!-- <p style="font-size: xx-large; text-align: center; font-weight: bold;"><?php echo $_SESSION["username"]; ?></p> -->
                <br>
                <p style="text-align: center; font-size: x-large;  font-weight: bold;">REGISTROS REALIZADOS</p></div>
            <div class="col-md-2"></div>        
        </div>

        <br>
        <div class="row">
            <div class="col-md-3"></div>
            <div class="col-md-2">
                <label>Seleccione perdiodo</label>
                <select id="periodo" class="form-control">
                    <?php foreach($periodos as $per){ ?>
                        <option value="<?php echo $per->num_periodo;?>"><?php echo $per->txt; ?></option>
                    <?php } ?>
                </select>
            </div>
            <div class="col-md-2">
                <label>Seleccione delegación</label>
                <select id="delegacionn" class="form-control">
                    <?php foreach($delegaciones as $deleg){ ?>
                        <option value="<?php echo $deleg->id_del;?>"><?php echo $deleg->nom_del; ?></option>
                    <?php } ?>
                    <option value="0">TODOS</option>
                </select>
            </div>
            <div class="col-md-2">
                <br>
                <button class="btn btn-info" type="button" style="width:50%;" onclick="cargar_tabla_admin();">Ver</button>
            </div>
            <div class="col-md-3"></div>
        </div>

        <div class="row">
            <div class="col-md-1"></div>
            <div class="col-md-10">
                <input type="text" name="id_us" id="id_us" value="<?php echo $_SESSION["id_userAg"];?>" style="display: none;"> 
                
                <br><br>
                <div id="load_table_admin"></div>  

            </div>
            <div class="col-md-1"></div>
        </div>

        <script type="text/javascript">
            setTimeout(function () { $("#loader").hide(); }, 300); 
        </script>

        <script type="text/javascript">            
            
            function cargar_tabla_admin(){
                $("#loader").show();

                delegacion=$("#delegacionn").val();
                periodo=$("#periodo").val();
                $("#load_table_admin").load('table_admin.php?periodo='+periodo+'&delegacion='+delegacion);

                //setTimeout(function () { $("#loader").hide(); }, 300); 
            }
        </script>

        <?php //require_once 'modals_cerrar.php';?>    

    </body>
    <br><br><br>
</html>