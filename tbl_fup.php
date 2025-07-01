<?php 
    if (session_status() == PHP_SESSION_NONE) { session_start(); }
    $id = $_SESSION["id_userAg"]; 


    
    $periodo=$_REQUEST['periodo'];
    require_once 'Ops2.php';////para obtener las fechas de los periodos
    $ops2 =  new Ops2();
    $fechas =  $ops2->get_fechas_periodo($periodo);
    $fecha_min= $fechas->fecha_min;
    $fecha_max= $fechas->fecha_max;


    require_once 'Ops.php'; 
    $op= new Op();  

    $what_lista=$_REQUEST['lista'];
    if($what_lista==1){
        $fups = $op->lista($id, $fecha_min, $fecha_max);
    }else{
        $fups = $op->lista2($fecha_min, $fecha_max);
    }
     

    
?>

<script>
    $("#loader").show();
</script>

<script type="text/javascript">
    $(document).ready(function() {
        $('#example2').DataTable({ 
            "order": [],
            //"ordering": false,
            "language": { "url": "//cdn.datatables.net/plug-ins/1.10.15/i18n/Spanish.json"     }
        } );
    } );
</script>

<div style="margin-right:2%; margin-left:2%;">
    <input type="text" name="id_us" id="id_us" value="<?php echo $_SESSION["id_userAg"];?>" style="display: none;">   
    <br>
    <p style="text-align:left; font-size: small;">Da clic en el FUP para desplegar la informacion referente a las etapas con información ya capturada</p>
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

        <?php  foreach ($fups as $c) {  ?>

        <tr>
            <td style="font-weight: bold;" width="130">
                <input type="button" name="etapa1" id="etapa1" class="btn" style="background-color: #5656bb; color: white; display: none;" value="<?php echo $c->fup;?>" onclick="verLaEtapa(<?php echo $c->id;?>);">
                <label onclick="verLaEtapa(<?php echo $c->id;?>);" style="color: #223a66; font-weight: bold; cursor:pointer;"><?php echo $c->fup;?></label> 
                <input type="text" name="canceladoPro<?php echo $c->id;?>" id="canceladoPro<?php echo $c->id;?>" value="<?php echo $c->cancelado;?>" style="width: 50px; display: none;">
            </td>
            <td width="250"><!--<input type="button" name="etapa1" id="etapa1" class="btn" style="background-color: #bb2d3a; color: white;" value="Etapa 1">-->
                <div id="verLEtapa<?php echo $c->id;?>" style="display: none;"> 
                <p style="color: #223a66; font-weight: bold; font-size: small;">Clave Catastral:</p><input type="text" name="" value="<?php echo $c->clavec;?>" style="border-left: none; border-right: none; border-top: none; text-align: center;" readonly="">

                <p style="color: #223a66; font-weight: bold; font-size: small;">Fecha de ingreso de solicitud a la delegación:</p>
                <input type="text" name="" value="<?php echo date_format( date_create($c->fecha_recepcion) ,'d-m-Y');?>" 
                style="border-left: none; border-right: none; border-top: none; text-align: center;" readonly="">

                <p style="color: #223a66; font-weight: bold; font-size: small;">Solicitante:</p>
                <p style="font-size:small;background-color:white; color:black; "><?php echo $c->solicitante." ".$c->apaterno." ".$c->amaterno ;?></p>
                <!-- <input type="text" name="" value="<?php echo $c->solicitante." ".$c->apaterno." ".$c->amaterno ;?>" style="border-left: none; border-right: none; border-top: none; text-align: center;" readonly=""> -->
                <br>

                <p style="color: #223a66; font-weight: bold; font-size: small;">Propietario:</p>
                <p style="font-size:small;background-color:white; color:black; "><?php echo $c->propietario." ".$c->apaternoprop." ".$c->amaternoprop;?></p>
                <!-- <input type="text" name="" value="<?php echo $c->propietario." ".$c->apaternoprop." ".$c->amaternoprop;?>" style="border-left: none; border-right: none; border-top: none; text-align: center;" readonly=""> -->

                <p style="color: #223a66; font-weight: bold; font-size: small;">Superficie inicial(M2):</p><input type="text" name="" value="<?php echo $c->superficieinicial." M2";?>" style="border-left: none; border-right: none; border-top: none; text-align: center;" readonly="">

                <p style="color: #223a66; font-weight: bold; font-size: small;">Monto inicial:</p><input type="text" name="" value="<?php echo "$ ".$c->anticipo;?>" style="border-left: none; border-right: none; border-top: none; text-align: center;" readonly="">
                <div id="CanceladoLevantamientoTop<?php echo $c->id;?>">
                    <p style="color: #223a66; font-weight: bold; font-size: small;">Fecha de Levantamiento cancelado:</p><input type="text" name="" value="<?php echo $c->fechacancelacion;?>" style="border-left: none; border-right: none; border-top: none; text-align: center; border-color: #c50b0b;" readonly="">
                </div>
                

                </div>

            </td>
            
            <td>
                <div id="verLEtapa2<?php echo $c->id;?>" style="display: none;">
                <p style="color: #223a66; font-weight: bold; font-size: small;">Orden de trabajo:</p><input type="text" name="ordenTrabjo<?php echo $c->id;?>" id="ordenTrabjo<?php echo $c->id;?>" style="border-left: none; border-right: none; border-top: none; text-align: center;" readonly="">

                <p style="color: #223a66; font-weight: bold; font-size: small;">Fecha de envío al área de topografía:</p>
                <input type="text" name="fechaEnviaAreaTop<?php echo $c->id;?>" id="fechaEnviaAreaTop<?php echo $c->id;?>" 
                style="border-left: none; border-right: none; border-top: none; text-align: center;" readonly="">

                <p style="color: #223a66; font-weight: bold; font-size: small;">Área de topografía:</p><input type="text" name="areaTopogra<?php echo $c->id;?>" id="areaTopogra<?php echo $c->id;?>" style="border-left: none; border-right: none; border-top: none; text-align: center;" readonly="">
                    <div id="CanceladoLevantamientoTop2<?php echo $c->id;?>">
                <p style="color: #223a66; font-weight: bold; font-size: small;">Fecha de Levantamiento cancelado:</p><input type="text" name="fechaCancelacion2" id="fechaCancelacion2" style="border-left: none; border-right: none; border-top: none; text-align: center; border-color: #c50b0b;" readonly="" value="<?php echo $c->fechacancelacion;?>">
                </div>
                </div>

            </td>
            <td>
                <div id="verLEtapa3<?php echo $c->id;?>" style="display: none;">
                <p style="color: #223a66; font-weight: bold; font-size: small;">Fecha de notificación a colindantes:</p><input type="text" name="fechaNotiColindante<?php echo $c->id;?>" id="fechaNotiColindante<?php echo $c->id;?>" style="border-left: none; border-right: none; border-top: none; text-align: center;" readonly="">
                <div id="CanceladoLevantamientoTop3<?php echo $c->id;?>">
                <p style="color: #223a66; font-weight: bold; font-size: small;">Fecha de Levantamiento cancelado:</p><input type="text" name="fechaCancelacion3" id="fechaCancelacion3" style="border-left: none; border-right: none; border-top: none; text-align: center; border-color: #c50b0b;" readonly="" value="<?php echo $c->fechacancelacion;?>">
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
                <p style="color: #223a66; font-weight: bold; font-size: small; text-align: left;">Fecha de env&iacute;o a la direcci&oacute;n de geograf&iacute;a:</p><input type="text" name="fechaEnvioDirGeo<?php echo $c->id;?>" id="fechaEnvioDirGeo<?php echo $c->id;?>" style="border-left: none; border-right: none; border-top: none; text-align: center;" readonly="">
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
                <p style="color: #223a66; font-weight: bold; font-size: small;">Fecha de entrega a la delegaci&oacute;n:</p>
                <input type="text" name="fechaEntregaDelegacion<?php echo $c->id;?>" id="fechaEntregaDelegacion<?php echo $c->id;?>" style="border-left: none; border-right: none; border-top: none; text-align: center;" readonly="">

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
                <p style="color: #223a66; font-weight: bold; font-size: small;">Fecha de notificaci&oacute;n del servicio concluido al solicitante:</p><input type="text" name="fechaNotiConSolicitante<?php echo $c->id;?>" id="fechaNotiConSolicitante<?php echo $c->id;?>" style="border-left: none; border-right: none; border-top: none; text-align: center;" readonly="">

                <p style="color: #223a66; font-weight: bold; font-size: small;">Fecha de entrega del servicio al solicitante:</p><input type="text" name="fechaEntregaServicioSol<?php echo $c->id;?>" id="fechaEntregaServicioSol<?php echo $c->id;?>" style="border-left: none; border-right: none; border-top: none; text-align: center;" readonly="">

                <p style="color: #223a66; font-weight: bold; font-size: small;">Observaciones</p>
                <textarea name="obs_entrega<?php echo $c->id;?>" id="obs_entrega<?php echo $c->id;?>" style="border-left: none; border-right: none; border-top: none; text-align: center; height: 140px;"></textarea>

                </div>
            </td>

            <td>
                <div id="verLEtapa9<?php echo $c->id;?>" style="display: none;">
                <p style="color: #223a66; font-weight: bold; font-size: small;">Fecha de resguardo del servicio concluido:</p><input type="text" name="fechaResguardo<?php echo $c->id;?>" id="fechaResguardo<?php echo $c->id;?>" style="border-left: none; border-right: none; border-top: none; text-align: center;" readonly="">

                <p style="color: #223a66; font-weight: bold; font-size: small;">No. de oficio del resguardo enviado a geograf&iacute;a:</p><input type="text" name="noOficioResguardo<?php echo $c->id;?>" id="noOficioResguardo<?php echo $c->id;?>" style="border-left: none; border-right: none; border-top: none; text-align: center;" readonly="">

                <p style="color: #223a66; font-weight: bold; font-size: small;">Observaciones:</p>
                <textarea name="observacioness<?php echo $c->id;?>" id="observacioness<?php echo $c->id;?>" style="border-left: none; border-right: none; border-top: none; text-align: center; height: 300px;"></textarea>
                </div>
            </td>
            <td style="display: none;"><input type="text" name="procesoActual<?php echo $c->id;?>" id="procesoActual<?php echo $c->id;?>" value="<?php echo $c->proceso;?>"></td>
            
        </tr>


        <?php  } ?>
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

<script>
    setTimeout(function () { $("#loader").hide(); }, 300); 
</script>