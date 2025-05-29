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
    $anios=$op->get_anios_recepcion();
    $delegaciones=$op->get_delegaciones(); //echo json_encode($delegaciones);
?>

<html>
    <head>
        <link rel="stylesheet" href="css/style.css"> 
        <link rel="stylesheet" href="plugins/bootstrap/bootstrap.min.css">
        <link rel="stylesheet" href="plugins/icofont/icofont.min.css">
        <script src="js/script.js"></script> 
        <script type="text/javascript" src="https://code.jquery.com/jquery-3.3.1.js"></script>
        <script type="text/javascript" src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
        <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css">
        <link rel="icon" type="image/png" sizes="16x16" href="images/favicon.ico"> 
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>

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
        <!--loader-->
        <div id="loader" class="modal fade" style="margin: auto;"></div>
        <script type="text/javascript">
            $("#loader").modal('show');
        </script>

        <header><!--                         MENU                           -->        
            <div class="header-top-bar">
                <div class="container">

                    <div class="row align-items-center">
                            <div class="col-md-2">
                                <a class="navbar-brand" href="index.html">
                        <img src="images/igecem.png" alt="" class="img-fluid" width="50" height="50">
                                </a>
                                <br><br> <br><br> 
                            </div>
                            <div class="col-md-8">
                                <br><br>
                                <p style="font-size: xx-large; text-align: center;">LEVANTAMIENTOS TOPOGRÁFICOS</p><br>
                                </div>
                            <div class="col-md-1"></div>
                            <div class="col-md-1"></div>
                            <input type="text" name="delegacion" id="delegacion" style="display: none;" value="<?php echo $_SESSION["abrev"]; ?>">
                            <input type="text" name="iddelegacion" id="iddelegacion" style="display: none;" value="<?php echo $_SESSION["id_userAg"]; ?>">
                    </div>
                </div>
            </div>
            <div class="col-md-12" style="background-color: #9f747f;">
                <div class="row">
                    <div class="col-md-3"></div>
                    <div class="col-md-6">
                        <p style="text-align: center; color: white; font-size: x-large;"><?php echo $_SESSION["username"];?></p>                       
                    </div>
                     <div class="col-md-1">
                        <?php if($_SESSION['username']=='ADMINISTRADOR'){?>
                            <a href="admonIni.php" title="Inicio"><i class="icofont-home icofont-2x" style="color: white;"></a></i>
                        <?php } ?>
                        <?php if($_SESSION['username']=='GEOGRAFÍA'){?>
                            <a href="geo.php" title="Inicio"><i class="icofont-home icofont-2x" style="color: white;"></a></i>
                        <?php } ?>
                        
                    </div>
                    <div class="col-md-1">
                        <a class="" data-toggle="modal" data-target="#myModal" style="color: white; cursor: pointer;" title="Cerrar Sesión"><i class="icofont-sign-out icofont-2x"></i></a> 
                    </div>
                    <div class="col-md-1"></div>
                </div>
            </div>
        </header>

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
                <label>Seleccione año (fecha de recepción)</label>
                <select id="anio" class="form-control">
                    <?php foreach($anios as $anio){ ?>
                        <option><?php echo $anio->anio; ?></option>
                    <?php } ?>
                </select>
            </div>
            <div class="col-md-2">
                <label>Seleccione delegación</label>
                <select id="delegacionn" class="form-control">
                    <?php foreach($delegaciones as $deleg){ ?>
                        <option value="<?php echo $deleg->id;?>"><?php echo $deleg->nom_del; ?></option>
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
            $("#loader").modal('hide');
        </script>

        <script type="text/javascript">
            function cargar_tabla_admin(){
                $("#loader").modal('show');

                delegacion=$("#delegacionn").val();
                anio=$("#anio").val();
                $("#load_table_admin").load('table_admin.php?anio='+anio+'&delegacion='+delegacion);

                //$("#loader").modal('hide');
            }
        </script>

        <?php require_once 'modals_cerrar.php';?>    

    </body>
</html>