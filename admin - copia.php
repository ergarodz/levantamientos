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
                        <br><br> <br><br> 
                    </div>
                    <div class="col-md-8">
                        <br><br>
                        <p style="font-size: xx-large; text-align: center;">LEVANTAMIENTOS TOPOGRAFICOS</p><br>
                        </div>
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
            <div class="col-md-9">
            </div>
            <div class="col-md-1">
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
 
  <div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog">
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
             <h4 class="modal-title">Cerrar sesión</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
         
        </div>
        <div class="modal-body">
          <p>Confirmar que requiere cerrar Sesión</p>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-primary" data-dismiss="modal" onclick="cerrarSession();">Ok</button>
        </div>
      </div>
      
    </div>
  </div>

   <div class="modal fade" id="detalles" role="dialog">
    <div class="modal-dialog">
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
             <input type="text" name="tituloP" id="tituloP" style="border: none; width: 400px; font-weight: bold; font-size: medium; color: #223a66;">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
         
        </div>
        <div class="modal-body">

            <div id="uno" style="display: none;">
                        <div class="row">
                            <div class="col-md-5"><label style="font-size: medium; margin-top: 20px;">Clave catastral:</label></div>
                            <div class="col-md-7"><input type="text" name="cclave" id="cclave" style="border-color: #223a66; border-top: none; border-left: none; border-right: none;" readonly="">
                            </div>

                            <div class="col-md-5"><label style="font-size: medium; margin-top: 20px;">Municipio:</label></div>
                            <div class="col-md-7"><input type="text" name="muni" id="muni" style="border-color: #223a66; border-top: none; border-left: none; border-right: none; width: 170px;" readonly=""></div>


                            <div class="col-md-5"><label style="font-size: medium; margin-top: 20px;">Recepcion:</label></div>
                            <div class="col-md-7"><input type="text" name="fechaRece" id="fechaRece" style="border-color: #223a66; border-top: none; border-left: none; border-right: none; width: 170px;" readonly=""></div>


                            <div class="col-md-5"><label style="font-size: medium; margin-top: 20px;">Superficie Inicial (M2):</label></div>
                            <div class="col-md-7"><input type="text" name="supInicial" id="supInicial" style="border-color: #223a66; border-top: none; border-left: none; border-right: none; width: 170px;" readonly=""></div>

                                
                            <div class="col-md-5"><label style="font-size: medium; margin-top: 20px;">Anticipo:</label></div>
                            <div class="col-md-7"><input type="text" name="anticipo" id="anticipo" style="border-color: #223a66; border-top: none; border-left: none; border-right: none;" readonly=""></div>


                            <div class="col-md-5"><label style="font-size: medium; margin-top: 20px;">Solicitante:</label></div>
                            <div class="col-md-7"><input type="text" name="solicitant" id="solicitant" style="border-color: #223a66; border-top: none; border-left: none; border-right: none;" readonly=""></div>


                            <div class="col-md-5"><label style="font-size: medium; margin-top: 20px;">FUP (Número de control):</label></div>
                            <div class="col-md-7"><input type="text" name="fupAs" id="fupAs" style="border-color: #223a66; border-top: none; border-left: none; border-right: none;" readonly=""></div>
                        </div>
            </div>


            <div id="dos" style="display: none;">
                <div class="row">

                <div class="col-md-5"><label style="font-size: medium; margin-top: 20px;">Orden de trabajo:</label></div>
                <div class="col-md-7">
                    <input type="text" name="ordentrabajo" id="ordentrabajo" style="border-left: none; border-right: none; border-top: none; border-color: #223a66;" readonly="">
                </div>

                <div class="col-md-5"><label style="font-size: medium; margin-top: 8px;">Fecha de env&iacute;o al &aacute;rea productora:</label></div>
                <div class="col-md-7">
                    <input type="text" name="fechaEnvio2" id="fechaEnvio2" style="border-left: none; border-right: none; border-top: none; border-color: #223a66;" readonly="">
                </div> 

                <div class="col-md-5"><label style="font-size: medium; margin-top: 20px;">&Aacute;rea productora:</label></div>
                <div class="col-md-7">
                    <input type="text" name="areaProduc" id="areaProduc" style="border-left: none; border-right: none; border-top: none; border-color: #223a66;" readonly="">
                </div>

                <div class="col-md-5">
                    <label style="font-size: medium; margin-top: 8px;">Fecha de notificaci&oacute;n a colindantes:</label>
                </div>
                <div class="col-md-7">
                     <input type="text" name="fechaNotificacion2" id="fechaNotificacion2" style="border-left: none; border-right: none; border-top: none; border-color: #223a66;" readonly="">
                </div>
                <div class="col-md-5"><label style="font-size: medium; margin-top: 8px;">Fecha de Realizacion de levantamiento:</label></div>
                <div class="col-md-7">
                    <input type="text" name="fechaLevantamiento2" id="fechaLevantamiento2" style="border-left: none; border-right: none; border-top: none; border-color: #223a66;" readonly="">
                </div>

                <div class="col-md-5">
                    <label style="font-size: medium; margin-top: 20px;">Folio GEO:</label> 
                </div>
                <div class="col-md-7">
                    <input type="text" name="folioGEO" id="folioGEO" style="border-left: none; border-right: none; border-top: none; border-color: #223a66;" readonly=""><br><br>
                </div>

                <div class="col-md-5">
                    <label style="font-size: medium; margin-top: 8px;">Fecha de recepcion del servicio terminado:</label>
                </div>
                <div class="col-md-7">
                    <input type="text" name="fechaSerTerminado3" id="fechaSerTerminado3" style="border-left: none; border-right: none; border-top: none; border-color: #223a66;" readonly="">
                </div>

                    <div class="col-md-5">
                    <label style="font-size: medium; margin-top: 10px;">Superficie resultante (M2):</label>
                </div>
                <div class="col-md-7">
                    <input type="text" name="superficie" id="superficie" style="border-left: none; border-right: none; border-top: none; border-color: #223a66;" readonly=""><br>
                </div>       
                </div>
            </div>


            <div id="tres" style="display: none;">
                <div class="row">
               
                <div class="col-md-5"><label style="font-size: medium; margin-top: 20px;">Costo total:</label></div>
                <div class="col-md-7"><input type="text" name="costoTT" id="costoTT" style="border-left: none; border-right: none; border-top: none; border-color: #223a66;" readonly=""><br><br>
                </div>


                <div class="col-md-5"><label style="font-size: medium; margin-top: -5px;">Fecha de notificaci&oacute;n al usuario para entrega:</label></div>
                <div class="col-md-7">
                    <input type="text" name="fechanotientrega3" id="fechanotientrega3" style="border-left: none; border-right: none; border-top: none; border-color: #223a66;" readonly="">
                </div>


                <div class="col-md-5"><label style="font-size: medium; margin-top: 8px;">Fecha de entrega al solicitante:</label></div>
                <div class="col-md-7">
                    <input type="text" name="fechaentregasolicitante3" id="fechaentregasolicitante3" style="border-left: none; border-right: none; border-top: none; border-color: #223a66;" readonly="">
                </div>


                <div class="col-md-5"><label style="font-size: medium; margin-top: 20px;">Diferencia (MN):</label></div>
                <div class="col-md-7"><input type="text" name="diferencia" id="diferencia" style="border-left: none; border-right: none; border-top: none; border-color: #223a66;" readonly=""><br><br>
                </div>

                <div class="col-md-5"><label style="font-size: medium; margin-top: 20px;">FUP / Recibo:</label></div>
                <div class="col-md-7"><input type="text" name="reciboFUP" id="reciboFUP" style="border-left: none; border-right: none; border-top: none; border-color: #223a66;" readonly=""><br><br>
                </div>
                          
                </div>
            </div>




             <div id="cuatro" style="display: none;">
                <div class="row">
                <div class="col-md-5"><label style="font-size: medium; margin-top: 20px;">N&uacute;mero de oficio de env&iacute;o de expediente concluido :</label></div>
                <div class="col-md-7"><br><br><input type="text" name="idConcluido" id="idConcluido" style="border-left: none; border-right: none; border-top: none; border-color: #223a66;" readonly=""><br><br>
                </div>

                <div class="col-md-5"><label style="font-size: medium; margin-top: 20px;">Fecha de entrega a la Dir. de Geograf&iacute;a:</label></div>
                <div class="col-md-7"><br>
                    <input type="text" name="fechaentregaGeo2" id="fechaentregaGeo2" style="border-left: none; border-right: none; border-top: none; border-color: #223a66;" readonly="">
                </div>
                </div>

        </div>

        <div id="cero" style="display: none;">
                <div class="row">
                            <div class="col-md-5"><label style="font-size: medium; margin-top: 20px;">Clave catastral:</label></div>
                            <div class="col-md-7"><input type="text" name="cclave2" id="cclave2" style="border-color: #223a66; border-top: none; border-left: none; border-right: none;" readonly="">
                            </div>

                            <div class="col-md-5"><label style="font-size: medium; margin-top: 20px;">Municipio:</label></div>
                            <div class="col-md-7"><input type="text" name="muni2" id="muni2" style="border-color: #223a66; border-top: none; border-left: none; border-right: none; width: 170px;" readonly=""></div>


                            <div class="col-md-5"><label style="font-size: medium; margin-top: 20px;">Recepcion:</label></div>
                            <div class="col-md-7"><input type="text" name="fechaRece2" id="fechaRece2" style="border-color: #223a66; border-top: none; border-left: none; border-right: none; width: 170px;" readonly=""></div>


                            <div class="col-md-5"><label style="font-size: medium; margin-top: 20px;">Superficie Inicial (M2):</label></div>
                            <div class="col-md-7"><input type="text" name="supInicial2" id="supInicial2" style="border-color: #223a66; border-top: none; border-left: none; border-right: none; width: 170px;" readonly=""></div>

                                
                            <div class="col-md-5"><label style="font-size: medium; margin-top: 20px;">Anticipo:</label></div>
                            <div class="col-md-7"><input type="text" name="anticipo2" id="anticipo2" style="border-color: #223a66; border-top: none; border-left: none; border-right: none;" readonly=""></div>


                            <div class="col-md-5"><label style="font-size: medium; margin-top: 20px;">Solicitante:</label></div>
                            <div class="col-md-7"><input type="text" name="solicitant2" id="solicitant2" style="border-color: #223a66; border-top: none; border-left: none; border-right: none;" readonly=""></div>


                            <div class="col-md-5"><label style="font-size: medium; margin-top: 20px;">FUP (Número de control):</label></div>
                            <div class="col-md-7"><input type="text" name="fupAs2" id="fupAs2" style="border-color: #223a66; border-top: none; border-left: none; border-right: none;" readonly=""></div>

                            <div class="col-md-5"><label style="font-size: medium; margin-top: 20px;">Orden de trabajo:</label></div>
                            <div class="col-md-7"><input type="text" name="orden2" id="orden2" style="border-color: #223a66; border-top: none; border-left: none; border-right: none;" readonly=""></div>


                            <div class="col-md-5"><label style="font-size: medium; margin-top: 8px;">Fecha de env&iacute;o al &aacute;rea productora:</label></div>
                            <div class="col-md-7">
                                 <input type="text" name="fechaEnvio2c" id="fechaEnvio2c" style="border-left: none; border-right: none; border-top: none; border-color: #223a66;" readonly="">
                            </div> 

                            <div class="col-md-5"><label style="font-size: medium; margin-top: 20px;">&Aacute;rea productora:</label></div>
                            <div class="col-md-7">
                                <input type="text" name="areaProduc2" id="areaProduc2" style="border-left: none; border-right: none; border-top: none; border-color: #223a66;" readonly="">
                            </div>



                             <div class="col-md-5">
                            <label style="font-size: medium; margin-top: 8px;">Fecha de notificaci&oacute;n a colindantes:</label>
                            </div>
                            <div class="col-md-7">
                                <input type="text" name="fechaNotificacion2c" id="fechaNotificacion2c" style="border-left: none; border-right: none; border-top: none; border-color: #223a66;" readonly="">
                            </div>
                            <div class="col-md-5"><label style="font-size: medium; margin-top: 8px;">Fecha de Realizacion de levantamiento:</label></div>
                            <div class="col-md-7">
                                <input type="text" name="fechaLevantamiento2c" id="fechaLevantamiento2c" style="border-left: none; border-right: none; border-top: none; border-color: #223a66;" readonly="">
                            </div>

                            <div class="col-md-5">
                                <label style="font-size: medium; margin-top: 20px;">Folio GEO:</label> 
                            </div>
                            <div class="col-md-7">
                                <input type="text" name="folioGEOc" id="folioGEOc" style="border-left: none; border-right: none; border-top: none; border-color: #223a66;" readonly=""><br><br>
                            </div>





                            <div class="col-md-12" id="proCancelado" style="display: none;">
                                <center>
                                    <label style="color: #9f747f; font-weight: bold;">El proceso ha sido cancelado</label>
                                </center>
                            </div>

                            <div class="col-md-12" id="proEnProceso" style="display: none;">
                                <center>
                                    <label style="color: #9f747f; font-weight: bold;">Registro en proceso</label>
                                </center>
                            </div>

                        </div>

        </div>



        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-primary" data-dismiss="modal" onclick="">Ok</button>
        </div>
      </div>
      
    </div>
  </div>
  
</div>
    <br>
    <br><br>

    <div class="row">
        <div class="col-md-1"><br><br></div>
        <div class="col-md-1"><br><br></div>
        <div class="col-md-8">
            <p style="font-size: xx-large; text-align: center; font-weight: bold;">ADMINISTRADOR</p>
            <br>
            <p style="text-align: center; font-size: x-large;  font-weight: bold;">REGISTROS REALIZADOS</p></div>
        <div class="col-md-1"></div>
        <div class="col-md-1"><br><br></div>


        <div class="col-md-1"></div>
        <div class="col-md-10">
            <input type="text" name="id_us" id="id_us" value="<?php echo $_SESSION["id_userAg"];?>" style="display: none;">   
            <br><br><br> 

        

    <table id="example" class="display" style="width:100%">
         <thead>
            <tr>
                <th  style="text-align: center; font-size: medium;  font-weight: bold; color: #223a66;">FUP</th>
                <th  style="text-align: center; font-size: medium;  font-weight: bold; color: #223a66;">ETAPA</th>
                <th  style="text-align: center; font-size: medium;  font-weight: bold; color: #223a66;">DETALLE</th>
            </tr>
        </thead>
        <tbody>

            <?php      foreach ($users as $c) {   ?>
            <tr>
                <td style="text-align: center; font-weight: bold; font-size: large;"><?php echo $c->fup;?></td>

                <?php  
                 $procesoE = "";
                    if ($c->proceso == 1) {
                         $procesoE = "INGRESO RECEPCION SOLICITUD";
                ?>
                <td style="text-align: center; background-color: #708ec7;"><?php echo $procesoE;?></td>

                 <?php  
                    }else if ($c->proceso == 2) {
                         $procesoE = "TRABAJO EN  CAMPO Y GABINETE";
                ?>
                <td style="text-align: center; background-color: #c79870;"><?php echo $procesoE;?></td>
                <?php
                    }else if ($c->proceso == 3) {
                         $procesoE = "ENTREGA A USUARIO";
                ?>
                <td style="text-align: center; background-color: #70c77f;"><?php echo $procesoE;?></td>
                <?php 
                    }else if ($c->proceso == 4) {
                         $procesoE = "CIERRE";
                ?>
                <td style="text-align: center; background-color: #7170c7;"><?php echo $procesoE;?></td>
                 <?php   }else if ($c->proceso == 0) {
                      $procesoE = "CANCELADO";

                      ?>
                 <td style="text-align: center; background-color: #e77b87;"><?php echo $procesoE;?></td>
                 <?php }

                  ?>
                
                <td style="text-align: center;"><input type="button" data-toggle="modal" data-target="#detalles" class="btn" name="etapaDetalle" id="etapaDetalle" style="background-color: #223a66; color: white;" value="<?php echo $c->proceso; ?>" onclick="detalleEtapas(<?php echo $c->proceso;?>,'<?php echo $c->fup;?>',<?php echo $c->id;?>);"></td>
            </tr>


            <?php      } ?>
        </tbody>
        <tfoot>
            <tr>
                <th style="text-align: center; font-size: medium;  font-weight: bold; color: #223a66;">FUP</th>
                <th style="text-align: center; font-size: medium;  font-weight: bold; color: #223a66;">ETAPA</th>
                <th style="text-align: center; font-size: medium;  font-weight: bold; color: #223a66;">DETALLE</th>
            </tr>
        </tfoot>
    </table>     
 
            <br><br><br><br><br>    
 


        </div>
        <div class="col-md-1"></div>
    </div>

</body>
</html>

