<?php 

session_start();

if (!isset($_SESSION["id_userAg"])) {
    header("Location: index.php");
   
}

$id = $_SESSION["id_userAg"];


    require_once 'Ops.php'; 
    $op= new Op();  

    $users = $op->lista2($id); 

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

    <script src="https://momentjs.com/downloads/moment-with-locales.min.js"></script>


    <script type="text/javascript">
      $(document).ready(function() {
      $('#example').DataTable({ 
           "language": {
           "url": "//cdn.datatables.net/plug-ins/1.10.15/i18n/Spanish.json"
         }
        }
        );
      } );
    </script>

    <script type="text/javascript">
      $(document).ready(function() {
      $('#example2').DataTable({ 
           "language": {
           "url": "//cdn.datatables.net/plug-ins/1.10.15/i18n/Spanish.json"
         }
        }
        );
      } );
    </script>
</head>
    <body>

    <header>
      <!--  <center>
            <img src="images/banner2.png" style=" position: relative; text-align: center; width: 100%; height: 8%"> 
        </center> -->
    <div class="header-top-bar">
        <div class="container">

            <div class="row align-items-center">
                    <div class="col-md-2">
                        <a class="navbar-brand" href="index.html">
                <img src="images/igecem.png" alt="" class="img-fluid" width="50" height="50">
                        </a>
                        <br><br> <br><br><br> 
                    </div>
                    <div class="col-md-8" style="font-size: xx-large; text-align: center;">LEVANTAMIENTOS TOPOGRAFICOS</div>
                    <div class="col-md-1"></div>
                    <div class="col-md-1"></div>
                    <input type="text" name="delegacion" id="delegacion" style="display: none;" value="<?php echo $_SESSION["abrev"]; ?>">
                    <input type="text" name="iddelegacion" id="iddelegacion" style="display: none;" value="<?php echo $_SESSION["id_userAg"]; ?>">

                    <!-- 
                        <input type="button" class="btn btn-info btn-lg" data-toggle="modal" data-target="#myModal" value="Cerrar sesión" style="">  -->
            </div>
        </div>
    </div>
    <div class="col-md-12" style="background-color: #9f747f;">
        <div class="row">
            <div class="col-md-3"></div>
            <div class="col-md-6">
                <p style="text-align: center; color: white; font-size: x-large;">ADMINISTRADOR <?php //echo $_SESSION["usuario"]; ?></p>
            </div>
            <div class="col-md-1">
                <a href="admonIni.php" title="Inicio"><i class="icofont-home icofont-2x" style="color: white;"></a></i>
            </div>
            <div class="col-md-1">
                <a class="" data-toggle="modal" data-target="#myModal" style="color: white; cursor: pointer;" title="Cerrar Sesión"><i class="icofont-sign-out icofont-2x"></i></a> 
            </div>
            <div class="col-md-1">
            </div>
        </div>
    </div>
</header>

<div class="container">

     
  <div class="modal fade" id="procesosTr" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
             <h4 class="modal-title" style="color: black; font-weight: bold;">PROCESOS</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        <div class="modal-body">
          <input type="text" name="idFup" id="idFup" style="display: none;">
          <div class="row">
              <div class="col-md-8">
                  <input type="text" name="" value="Ingreso recepcion de solicitud" style="width: 250px; border: none; font-size: medium; color: #223a66; font-weight: bold;">
                  <br>
                   <input type="text" name="" value="Trabajo en campo y gabinete" style="width: 250px; border: none; font-size: medium; color: #223a66; font-weight: bold;">
                  <br>
                   <input type="text" name="" value="Entrega a usuarios" style="width: 250px; border: none; font-size: medium; color: #223a66; font-weight: bold;">
                  <br>
                   <input type="text" name="" value="Cierre" style="width: 250px; border: none; font-size: medium; color: #223a66; font-weight: bold;">
                  <br>
              </div>
              <div class="col-md-4">

                <div id="etapaUno" style="display: none;">
                    <span class="input-group-text" id="basic-addon2" style="width: 40px;"><i class="icofont-ui-check icofont-2x" style="color: #24503a;" title="Proceso concluido"></i></span>
                    <br>
                    <span class="input-group-text" id="basic-addon2" style="width: 40px;"><i class="icofont-ui-close icofont-2x" style="color: #9f747f;" title="Proceso inconcluso"></i></span>
                    <br>
                    <span class="input-group-text" id="basic-addon2" style="width: 40px;"><i class="icofont-ui-close icofont-2x" style="color: #9f747f;" title="Proceso inconcluso"></i></span>
                    <br>
                    <span class="input-group-text" id="basic-addon2" style="width: 40px;"><i class="icofont-ui-close icofont-2x" style="color: #9f747f;" title="Proceso inconcluso"></i></span>
                    <br>
                </div>

                <div id="etapaDos" style="display: none;">
                    <span class="input-group-text" id="basic-addon2" style="width: 40px;"><i class="icofont-ui-check icofont-2x" style="color: #24503a;" title="Proceso concluido"></i></span>
                    <br>
                    <span class="input-group-text" id="basic-addon2" style="width: 40px;"><i class="icofont-ui-check icofont-2x" style="color: #24503a;" title="Proceso concluido"></i></span>
                    <br>
                    <span class="input-group-text" id="basic-addon2" style="width: 40px;"><i class="icofont-ui-close icofont-2x" style="color: #9f747f;" title="Proceso inconcluso"></i></span>
                    <br>
                    <span class="input-group-text" id="basic-addon2" style="width: 40px;"><i class="icofont-ui-close icofont-2x" style="color: #9f747f;" title="Proceso inconcluso"></i></span>
                    <br>
                </div>

                <div id="etapaTres" style="display: none;">
                    <span class="input-group-text" id="basic-addon2" style="width: 40px;"><i class="icofont-ui-check icofont-2x" style="color: #24503a;" title="Proceso concluido"></i></span>
                    <br>
                    <span class="input-group-text" id="basic-addon2" style="width: 40px;"><i class="icofont-ui-check icofont-2x" style="color: #24503a;" title="Proceso concluido"></i></span>
                    <br>
                    <span class="input-group-text" id="basic-addon2" style="width: 40px;"><i class="icofont-ui-check icofont-2x" style="color: #24503a;" title="Proceso concluido"></i></span>
                    <br>
                    <span class="input-group-text" id="basic-addon2" style="width: 40px;"><i class="icofont-ui-close icofont-2x" style="color: #9f747f;" title="Proceso inconcluso"></i></span>
                    <br>
                </div>

                <div id="etapaCuatro" style="display: none;">
                    <span class="input-group-text" id="basic-addon2" style="width: 40px;"><i class="icofont-ui-check icofont-2x" style="color: #24503a;" title="Proceso concluido"></i></span>
                    <br>
                    <span class="input-group-text" id="basic-addon2" style="width: 40px;"><i class="icofont-ui-check icofont-2x" style="color: #24503a;" title="Proceso concluido"></i></span>
                    <br>
                    <span class="input-group-text" id="basic-addon2" style="width: 40px;"><i class="icofont-ui-check icofont-2x" style="color: #24503a;" title="Proceso concluido"></i></span>
                    <br>
                    <span class="input-group-text" id="basic-addon2" style="width: 40px;"><i class="icofont-ui-check icofont-2x" style="color: #24503a;" title="Proceso concluido"></i></span>
                    <br>
                </div>
              </div>

              <div class="col-md-12" id="canceladoProcesoCero">
                <center>
                    <br>
                    <label style="color: #9f747f; font-weight: bold; font-size: medium;">El proceso ha sido cancelado</label>
                </center>
                </div>

          </div>


        </div>
        <div class="modal-footer">
          <button type="button" class="btn" data-dismiss="modal" style="background-color: #223a66; color: white;">Cerrar</button>
        </div>
      </div>
      
    </div>
  </div>
  
</div>
    <br>
    <br><br>

    <div class="row">
        <div class="col-md-1"><br><br></div>
        <div class="col-md-2"><br><br></div>
        <div class="col-md-6"><p style="text-align: center; font-size: x-large;  font-weight: bold;">CONTROL DE RECEPCIÓN, PROCESO Y ENTREGA DE LEVANTAMIENTOS TOPOGRÁFICOS CATASTRALES 2023
        </p>
      </div>
        <div class="col-md-2"></div>
        <div class="col-md-1"><br><br></div>


        <div class="col-md-1"></div>
        <div class="col-md-10">
            <input type="text" name="id_us" id="id_us" value="<?php echo $_SESSION["id_userAg"];?>" style="display: none;">   
            <br><br><br> 
        <p style="text-align: center; font-size: small;">Dar clic en el FUP para desplegar la informacion referente a las etapas con información ya capturada</p>
     <table id="example2" class="display" style="width:100%">
         <thead>
            <tr>
                <th  style="text-align: center; font-size: small;  font-weight: bold; color: #223a66;">FUP</th>
                <th  style="text-align: center; font-size: small;  font-weight: bold; color: #223a66;">Ingreso a Delegacion</th>
                <th  style="text-align: center; font-size: small;  font-weight: bold; color: #223a66;">Enviado a topografía</th>
                <th  style="text-align: center; font-size: small;  font-weight: bold; color: #223a66;">Notificado</th>
                <th  style="text-align: center; font-size: small;  font-weight: bold; color: #223a66;">Levantamiento realizado</th>
                <th  style="text-align: center; font-size: small;  font-weight: bold; color: #223a66;">Enviado a Dir. de Geografía / Recepcionado en DSI (CCC)</th>
                <!--<th  style="text-align: center; font-size: small;  font-weight: bold; color: #223a66;">Recepcionado en DSI (CCC)</th> -->
                <th  style="text-align: center; font-size: small;  font-weight: bold; color: #223a66;">Entregado a la delegación</th>
                <th  style="text-align: center; font-size: small;  font-weight: bold; color: #223a66;">Entregado al solicitante</th>
                <th  style="text-align: center; font-size: small;  font-weight: bold; color: #223a66;">Cerrado</th>
                <th  style="text-align: center; font-size: small;  font-weight: bold; color: #223a66; display: none;">Etapas</th>
            </tr>
        </thead>
        <tbody>

            <?php      foreach ($users as $c) {   ?>

            <tr>
                <td style="font-weight: bold;" width="130"><input type="button" name="etapa1" id="etapa1" class="btn" style="background-color: #5656bb; color: white; display: none;" value="<?php echo $c->fup;?>" onclick="verLaEtapa(<?php echo $c->id;?>);">
                  <input type="text" name="canceladoPro<?php echo $c->id;?>" id="canceladoPro<?php echo $c->id;?>" value="<?php echo $c->cancelado;?>" style="width: 50px; display: none;">
                   <label onclick="verLaEtapa(<?php echo $c->id;?>);" style="color: #223a66; font-weight: bold;"><?php echo $c->fup;?></label> 
                </td>
                <td width="250"><!--<input type="button" name="etapa1" id="etapa1" class="btn" style="background-color: #bb2d3a; color: white;" value="Etapa 1">-->
                  <div id="verLEtapa<?php echo $c->id;?>" style="display: none;"> 
                    <p style="color: #223a66; font-weight: bold; font-size: small;">Clave Catastral:</p><input type="text" name="" value="<?php echo $c->clavec;?>" style="border-left: none; border-right: none; border-top: none; text-align: center;" readonly="">

                    <p style="color: #223a66; font-weight: bold; font-size: small;">Fecha de ingreso de solicitud a la delegación:</p><input type="text" name="" 
                    value="<?php echo date_format( date_create($c->fecha_recepcion) ,'d-m-Y');?>"  
                    style="border-left: none; border-right: none; border-top: none; text-align: center;" readonly="">

                    <p style="color: #223a66; font-weight: bold; font-size: small;">Solicitante:</p>
                    <p style="font-size:small;background-color:white;"><?php echo $c->solicitante." ".$c->apaterno." ".$c->amaterno ;?></p>
                    <!-- <input type="text" name="" value="<?php echo $c->solicitante." ".$c->apaterno." ".$c->amaterno ;?>" style="border-left: none; border-right: none; border-top: none; text-align: center;" readonly=""> -->

                    <br>

                    <p style="color: #223a66; font-weight: bold; font-size: small;">Propietario:</p>
                    <p style="font-size:small;background-color:white;"><?php echo $c->propietario." ".$c->apaternoprop." ".$c->amaternoprop;?></p>
                    <!-- <input type="text" name="" value="<?php echo $c->propietario." ".$c->apaternoprop." ".$c->amaternoprop;?>" style="border-left: none; border-right: none; border-top: none; text-align: center;" readonly=""> -->

                    <p style="color: #223a66; font-weight: bold; font-size: small;">Superficie inicial(M2):</p><input type="text" name="" value="<?php echo $c->superficieinicial." M2";?>" style="border-left: none; border-right: none; border-top: none; text-align: center;" readonly="">

                    <p style="color: #223a66; font-weight: bold; font-size: small;">Monto inicial:</p><input type="text" name="" value="<?php echo "$ ".$c->anticipo;?>" style="border-left: none; border-right: none; border-top: none; text-align: center;" readonly="">
                    <div id="CanceladoLevantamientoTop<?php echo $c->id;?>">
                      <p style="color: #223a66; font-weight: bold; font-size: small;">Fecha de Levantamiento cancelado:</p>
                      <input type="text" name="" value="<?php echo $c->fechacancelacion;?>" 
                      style="border-left: none; border-right: none; border-top: none; text-align: center; border-color: #c50b0b;" readonly="">
                    </div>
                    

                  </div>

                </td>
                
                <td>
                  <div id="verLEtapa2<?php echo $c->id;?>" style="display: none;">
                     <p style="color: #223a66; font-weight: bold; font-size: small;">Orden de trabajo:</p><input type="text" name="ordenTrabjo<?php echo $c->id;?>" id="ordenTrabjo<?php echo $c->id;?>" style="border-left: none; border-right: none; border-top: none; text-align: center;" readonly="">

                     <p style="color: #223a66; font-weight: bold; font-size: small;">Fecha de envío al área de topografía:</p><input type="text" name="fechaEnviaAreaTop<?php echo $c->id;?>" id="fechaEnviaAreaTop<?php echo $c->id;?>" style="border-left: none; border-right: none; border-top: none; text-align: center;" readonly="">

                     <p style="color: #223a66; font-weight: bold; font-size: small;">Área de topografía:</p><input type="text" name="areaTopogra<?php echo $c->id;?>" id="areaTopogra<?php echo $c->id;?>" style="border-left: none; border-right: none; border-top: none; text-align: center;" readonly="">
                      <div id="CanceladoLevantamientoTop2<?php echo $c->id;?>">
                     <p style="color: #223a66; font-weight: bold; font-size: small;">Fecha de Levantamiento cancelado:</p>
                     <input type="text" name="fechaCancelacion2" id="fechaCancelacion2" 
                     style="border-left: none; border-right: none; border-top: none; text-align: center; border-color: #c50b0b;" readonly="" value="<?php echo $c->fechacancelacion;?>">
                   </div>
                  </div>

                </td>
                <td>
                  <div id="verLEtapa3<?php echo $c->id;?>" style="display: none;">
                     <p style="color: #223a66; font-weight: bold; font-size: small;">Fecha de notificación a colindantes:</p><input type="text" name="fechaNotiColindante<?php echo $c->id;?>" id="fechaNotiColindante<?php echo $c->id;?>" style="border-left: none; border-right: none; border-top: none; text-align: center;" readonly="">
                     <div id="CanceladoLevantamientoTop3<?php echo $c->id;?>">
                     <p style="color: #223a66; font-weight: bold; font-size: small;">Fecha de Levantamiento cancelado:</p>
                     <input type="text" name="fechaCancelacion3" id="fechaCancelacion3" style="border-left: none; border-right: none; border-top: none; text-align: center; border-color: #c50b0b;" readonly="" 
                     value="<?php echo date_format( date_create($c->fechacancelacion) ,'d-m-Y');?>" >
                    </div>
                  </div>
                </td>
                <td>
                  <div id="verLEtapa4<?php echo $c->id;?>" style="display: none;">
                     <p style="color: #223a66; font-weight: bold; font-size: small; text-align: left;">Fecha de levantamiento realizado:</p><input type="text" name="fechaLevanRealizado<?php echo $c->id;?>" id="fechaLevanRealizado<?php echo $c->id;?>" style="border-left: none; border-right: none; border-top: none; text-align: center;" readonly="">

                     <p style="color: #223a66; font-weight: bold; font-size: small; text-align: left;">Folio GEO:</p><input type="text" name="folioGeoo<?php echo $c->id;?>" id="folioGeoo<?php echo $c->id;?>" style="border-left: none; border-right: none; border-top: none; text-align: center;" readonly="">
                     <div id="CanceladoLevantamientoTop4<?php echo $c->id;?>">
                     <p style="color: #223a66; font-weight: bold; font-size: small; text-align: left;">Fecha de Levantamiento cancelado:</p><input type="text" name="fechaCancelacion4" id="fechaCancelacion4" style="border-left: none; border-right: none; border-top: none; text-align: center; border-color: #c50b0b;" readonly="" value="<?php echo $c->fechacancelacion;?>">
                   </div>
                  </div>
                </td>
                <td>
                  <div id="verLEtapa5<?php echo $c->id;?>" style="display: none;">
                     <p style="color: #223a66; font-weight: bold; font-size: small; text-align: left;">Fecha de envío a la dirección de geografía:</p><input type="text" name="fechaEnvioDirGeo<?php echo $c->id;?>" id="fechaEnvioDirGeo<?php echo $c->id;?>" style="border-left: none; border-right: none; border-top: none; text-align: center;" readonly="">
                  </div>
                  <br><br><br>
                  <div id="verLEtapa6<?php echo $c->id;?>" style="display: none;">
                     <p style="color: #223a66; font-weight: bold; font-size: small; text-align: left;">Fecha de recepcion en CCC (Servicio terminado):</p><input type="text" name="fechaRecepcionCCC<?php echo $c->id;?>" id="fechaRecepcionCCC<?php echo $c->id;?>" style="border-left: none; border-right: none; border-top: none; text-align: center;" readonly="">
                  </div>
                </td>
                <!--<td style="text-align: center;">
                  <div id="verLEtapa6<?php echo $c->id;?>" style="display: none;">
                     <p style="color: #223a66; font-weight: bold; font-size: small;">Fecha de recepcion en CCC (Servicio terminado):</p><input type="text" name="fechaRecepcionCCC<?php echo $c->id;?>" id="fechaRecepcionCCC<?php echo $c->id;?>" style="border-left: none; border-right: none; border-top: none; text-align: center;" readonly="">
                  </div>
                </td>  -->

                <td>
                  <div id="verLEtapa7<?php echo $c->id;?>" style="display: none;">
                    <p style="color: #223a66; font-weight: bold; font-size: small;">Fecha de entrega a la delegación:</p><input type="text" name="fechaEntregaDelegacion<?php echo $c->id;?>" id="fechaEntregaDelegacion<?php echo $c->id;?>" style="border-left: none; border-right: none; border-top: none; text-align: center;" readonly="">

                    <p style="color: #223a66; font-weight: bold; font-size: small;">Superficie resultante:</p><input type="text" name="superficieResult<?php echo $c->id;?>" id="superficieResult<?php echo $c->id;?>" style="border-left: none; border-right: none; border-top: none; text-align: center;" readonly="">

                    <p style="color: #223a66; font-weight: bold; font-size: small;">Costo total:</p><input type="text" name="costoTTotal<?php echo $c->id;?>" id="costoTTotal<?php echo $c->id;?>" style="border-left: none; border-right: none; border-top: none; text-align: center;" readonly="">

                    <p style="color: #223a66; font-weight: bold; font-size: small;">Diferencia (+/-):</p><input type="text" name="diferenciaa<?php echo $c->id;?>" id="diferenciaa<?php echo $c->id;?>" style="border-left: none; border-right: none; border-top: none; text-align: center;" readonly="">

                    <p style="color: #223a66; font-weight: bold; font-size: small;">Tipo de Oficio:</p><input type="text" name="tipoOficio<?php echo $c->id;?>" id="tipoOficio<?php echo $c->id;?>" style="border-left: none; border-right: none; border-top: none; text-align: center;" readonly="">

                    <p style="color: #223a66; font-weight: bold; font-size: small;">Folio del Oficio:</p><input type="text" name="follOficio<?php echo $c->id;?>" id="follOficio<?php echo $c->id;?>" style="border-left: none; border-right: none; border-top: none; text-align: center;" readonly="">

                    <p style="color: #223a66; font-weight: bold; font-size: small;">Observaciones:</p>
                    <textarea name="obs_proceso6_<?php echo $c->id;?>" id="obs_proceso6_<?php echo $c->id;?>" style="border-left: none; border-right: none; border-top: none; text-align: center; height: 140px;"></textarea>

                  </div>
                </td>

                <td>
                   <div id="verLEtapa8<?php echo $c->id;?>" style="display: none;">
                    <p style="color: #223a66; font-weight: bold; font-size: small;">Fecha de notificación del servicio concluido al solicitante:</p><input type="text" name="fechaNotiConSolicitante<?php echo $c->id;?>" id="fechaNotiConSolicitante<?php echo $c->id;?>" style="border-left: none; border-right: none; border-top: none; text-align: center;" readonly="">

                    <p style="color: #223a66; font-weight: bold; font-size: small;">Fecha de entrega del servicio al solicitante:</p><input type="text" name="fechaEntregaServicioSol<?php echo $c->id;?>" id="fechaEntregaServicioSol<?php echo $c->id;?>" style="border-left: none; border-right: none; border-top: none; text-align: center;" readonly="">

                    <p style="color: #223a66; font-weight: bold; font-size: small;">Observaciones</p>
                    <textarea name="obs_entrega<?php echo $c->id;?>" id="obs_entrega<?php echo $c->id;?>" style="border-left: none; border-right: none; border-top: none; text-align: center; height: 140px;"></textarea>

                  </div>
                </td>

                <td>
                  <div id="verLEtapa9<?php echo $c->id;?>" style="display: none;">
                    <p style="color: #223a66; font-weight: bold; font-size: small;">Fecha de resguardo del servicio concluido:</p><input type="text" name="fechaResguardo<?php echo $c->id;?>" id="fechaResguardo<?php echo $c->id;?>" style="border-left: none; border-right: none; border-top: none; text-align: center;" readonly="">

                    <p style="color: #223a66; font-weight: bold; font-size: small;">No. de oficio del resguardo enviado a geografía:</p><input type="text" name="noOficioResguardo<?php echo $c->id;?>" id="noOficioResguardo<?php echo $c->id;?>" style="border-left: none; border-right: none; border-top: none; text-align: center;" readonly="">

                    <p style="color: #223a66; font-weight: bold; font-size: small;">Observaciones:</p>
                    <textarea name="observacioness<?php echo $c->id;?>" id="observacioness<?php echo $c->id;?>" style="border-left: none; border-right: none; border-top: none; text-align: center; height: 300px;"></textarea>
                  </div>
                </td>
                <td style="display: none;"><input type="text" name="procesoActual<?php echo $c->id;?>" id="procesoActual<?php echo $c->id;?>" value="<?php echo $c->proceso;?>"></td>
                
            </tr>


            <?php      } ?>
        </tbody>
        <tfoot>
            <tr>
                <th style="text-align: center; font-size: small;  font-weight: bold; color: #223a66;">FUP</th>
                <th  style="text-align: center; font-size: small;  font-weight: bold; color: #223a66;">Ingreso a Delegacion</th>
                <th  style="text-align: center; font-size: small;  font-weight: bold; color: #223a66;">Enviado a topografía</th>
                <th  style="text-align: center; font-size: small;  font-weight: bold; color: #223a66;">Notificado</th>
                <th  style="text-align: center; font-size: small;  font-weight: bold; color: #223a66;">Levantamiento realizado</th>
                <th  style="text-align: center; font-size: small;  font-weight: bold; color: #223a66;">Enviado a Dir. de Geografía / Recepcionado en DSI (CCC)</th>
                <!--<th  style="text-align: center; font-size: small;  font-weight: bold; color: #223a66;">Recepcionado en DSI (CCC)</th> -->
                <th  style="text-align: center; font-size: small;  font-weight: bold; color: #223a66;">Entregado a la delegación</th>
                <th  style="text-align: center; font-size: small;  font-weight: bold; color: #223a66;">Entregado al solicitante</th>
                <th  style="text-align: center; font-size: small;  font-weight: bold; color: #223a66;">Cerrado</th>
                <th  style="text-align: center; font-size: small;  font-weight: bold; color: #223a66; display: none;">Etapas</th>
            </tr>
        </tfoot>
    </table> 

        <br><br><br> <br><br><br>     
 


        </div>
        <div class="col-md-1"></div>
    </div>

    <?php require_once 'modals_cerrar.php';?>

</body>
</html>

