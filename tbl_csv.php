<?php
    if (session_status() == PHP_SESSION_NONE) { session_start(); }

    $periodo=$_REQUEST['periodo'];

    require_once 'Ops2.php';
	$erick=new Ops2();

    $fechas =  $erick->get_fechas_periodo($periodo);
    $fecha_min= $fechas->fecha_min;
    $fecha_max= $fechas->fecha_max;

    $registros=$erick->get_all_regs_periodo($fecha_min, $fecha_max);	
?>

<script type="text/javascript">
    $("#loader").show();

    $(document).ready(function() {
    $('#table_regs').DataTable({ 
        aLengthMenu: [
            [10, 100, 1000, -1],
            [10, 100, 1000, "Todos"]
            ],

        "language": { "url": "//cdn.datatables.net/plug-ins/1.10.15/i18n/Spanish.json" }


    } );
} );
</script>

<script language="javascript">
    $(document).ready(function() {
        $(".botonExcel").click(function(event) {
            $("#datos_a_enviar").val( $("<div>").append( $("#table_regs").eq(0).clone()).html());
            $("#FormularioExportacion").submit();
        });
    });
</script>

<div style="margin-right:2%; margin-left:2%;" class="">
    <img style="width:70px; position:relative; top:25px; cursor:pointer;" src="images/excel.png"   class="botonExcel" />		
    <br><br>
    <table id="table_regs" style="border-color:solid black 3px;" class="cell-border">
        <thead>
            <tr>
                <th>FUP</th>	
                <th>Ingreso a delegación</th>					
                <th>Enviado a topografía</th>
                <th>Notificado</th>
                <th>Levantamiento realizado</th>
                <th>Enviado a Dir. de Geografía/Recepcionado en DSI (CCC)</th>
                <th>Entregado a la delegación</th>
                <th>Entregado al solicitante</th>
                <th>Cerrado</th>
            </tr>
        </thead>
        <tbody>
        <?php foreach($registros as $reg){ 
            ///vemos si hay info en la tabla procesodos
            $reg2=$erick->get_regs_procesodos($reg->id);
            $reg3=$erick->get_regs_procesotres($reg->id);
            $reg4=$erick->get_regs_procesocuatro($reg->id);//echo json_encode($reg4);
        ?>
            <tr>
                <td><span style="font-size:small;background-color:white;"><?php echo $reg->fup;?></span></td>
                <td>							
                    <span style="color: #223a66; font-weight: bold; font-size: small;">Delegación:</span>
                    <span style="font-size:small;background-color:white;"><?php echo $reg->nom_delegacion;?></span>						
                    <br>						
                    <span style="color: #223a66; font-weight: bold; font-size: small;">Municipio:</span>
                    <span style="font-size:small;background-color:white;"><?php echo @$reg->municipio;?></span>
                    <br>
                    <span style="color: #223a66; font-weight: bold; font-size: small;">Clave Catastral:</span>
                    <span style="font-size:small;background-color:white;"><?php echo @$reg->clavec;?></span>
                    <br>
                    <span style="color: #223a66; font-weight: bold; font-size: small;">Ingreso de solicitud a la delegación:</span>
                    <span style="font-size:small;background-color:white;"><?php if(isset($reg->fecha_recepcion)){ echo date_format( date_create($reg->fecha_recepcion) , 'd-m-Y') ; } ?></span>
                    <br>
                    <span style="color: #223a66; font-weight: bold; font-size: small;">Solicitante:</span>
                    <span style="font-size:small;background-color:white;"><?php echo $reg->solicitante.' '.@$reg->apaterno.' '.@$reg->amaterno;?></span>
                    <br>
                    <span style="color: #223a66; font-weight: bold; font-size: small;">Propietario:</span>
                    <span style="font-size:small;background-color:white;"><?php echo $reg->propietario.' '.@$reg->apaternoprop.' '.@$reg->amaternoprop;?></span>
                    <br>
                    <span style="color: #223a66; font-weight: bold; font-size: small;">Superficie inicial:</span>
                    <span style="font-size:small;background-color:white;"><?php echo @$reg->superficieinicial;?></span>
                    <br>
                    <span style="color: #223a66; font-weight: bold; font-size: small;">Monto inicial:</span>
                    <span style="font-size:small;background-color:white;"><?php echo @$reg->anticipo;?></span>							
                </td>
                <td>
                    <span style="color: #223a66; font-weight: bold; font-size: small;">Orden de trabajo:</span>
                    <span style="font-size:small;background-color:white;"><?php echo @$reg2->ordentrabajo;?></span>	
                    <br>
                    <span style="color: #223a66; font-weight: bold; font-size: small;">Fecha de envío al área de topografía:</span>
                    <span style="font-size:small;background-color:white;"><?php if(isset($reg2->fechaenvio)){ echo date_format( date_create(@$reg2->fechaenvio) , 'd-m-Y'); }?></span>	
                    <br>
                    <span style="color: #223a66; font-weight: bold; font-size: small;">Área de topografía:</span>
                    <span style="font-size:small;background-color:white;"><?php echo @$reg2->areaproduc;?></span>		
                </td>
                <td>
                    <span style="color: #223a66; font-weight: bold; font-size: small;">Fecha de notificación a colindantes:</span>
                    <span style="font-size:small;background-color:white;"><?php if(isset($reg2->fechanotificacion)){ echo date_format( date_create(@$reg2->fechanotificacion) , 'd-m-Y'); } ?></span>
                </td>
                <td>
                    <span style="color: #223a66; font-weight: bold; font-size: small;">Fecha de levantamiento realizado:</span>
                    <span style="font-size:small;background-color:white;"><?php if(isset($reg2->fechalevantamiento) ){echo date_format( date_create(@$reg2->fechalevantamiento) , 'd-m-Y'); }?></span>
                    <br>
                    <span style="color: #223a66; font-weight: bold; font-size: small;">Folio GEO:</span>
                    <span style="font-size:small;background-color:white;"><?php echo @$reg2->foliogeo;?></span>
                </td>
                <td>
                    <span style="color: #223a66; font-weight: bold; font-size: small;">Fecha de envío a la dirección de geografía:</span>
                    <span style="font-size:small;background-color:white;"><?php if(isset($reg2->fechatermino)){ echo date_format( date_create(@$reg2->fechatermino) , 'd-m-Y'); } ?></span>
                    <br>
                    <span style="color: #223a66; font-weight: bold; font-size: small;">Fecha de recepcion en CCC (Servicio terminado):</span>
                    <span style="font-size:small;background-color:white;"><?php if(isset($reg2->fecharecepcionccc)){ echo date_format( date_create(@$reg2->fecharecepcionccc) , 'd-m-Y'); }?></span>
                </td>
                <td>
                    <span style="color: #223a66; font-weight: bold; font-size: small;">Fecha de entrega a la delegación:</span>
                    <span style="font-size:small;background-color:white;"><?php if(isset($reg3->fechanotientrega)){ echo date_format( date_create(@$reg3->fechanotientrega) , 'd-m-Y'); } ?></span>
                    <br>
                    <span style="color: #223a66; font-weight: bold; font-size: small;">Superficie resultante:</span>
                    <span style="font-size:small;background-color:white;"><?php echo @$reg3->superficieresultante;?></span>
                    <br>
                    <span style="color: #223a66; font-weight: bold; font-size: small;">Costo total:</span>
                    <span style="font-size:small;background-color:white;"><?php echo @$reg3->costototal;?></span>
                    <br>
                    <span style="color: #223a66; font-weight: bold; font-size: small;">Diferencia (+/-):</span>
                    <span style="font-size:small;background-color:white;"><?php echo @$reg3->diferencia;?></span>
                    <br>
                    <span style="color: #223a66; font-weight: bold; font-size: small;">Tipo de oficio:</span>
                    <span style="font-size:small;background-color:white;"><?php echo @$reg3->tipooficio;?></span>
                    <br>
                    <span style="color: #223a66; font-weight: bold; font-size: small;">Folio del oficio:</span>
                    <span style="font-size:small;background-color:white;"><?php echo @$reg3->recibofup;?></span>
                    <br>
                    <span style="color: #223a66; font-weight: bold; font-size: small;">Observaciones:</span>
                    <span style="font-size:small;background-color:white;"><?php echo @$reg3->obs_proceso6;?></span>
                </td>
                <td>
                    <span style="color: #223a66; font-weight: bold; font-size: small;">Fecha de notificación del servicio concluido al solicitante:</span>
                    <span style="font-size:small;background-color:white;"><?php if(isset($reg3->fechanotificacionconcluido)){ echo date_format( date_create(@$reg3->fechanotificacionconcluido) , 'd-m-Y'); } ?></span>
                    <br>
                    <span style="color: #223a66; font-weight: bold; font-size: small;">Fecha de entrega del servicio al solicitante:</span>
                    <span style="font-size:small;background-color:white;"><?php if(isset($reg3->fechaentregasol)){ echo date_format( date_create(@$reg3->fechaentregasol) , 'd-m-Y'); } ?></span>
                    <br>
                    <span style="color: #223a66; font-weight: bold; font-size: small;">Observaciones:</span>
                    <span style="font-size:small;background-color:white;"><?php echo @$reg3->observaciones_entrega_cliente;?></span>
                </td>
                <td>
                    <span style="color: #223a66; font-weight: bold; font-size: small;">Fecha de resguardo del servicio concluido:</span>
                    <span style="font-size:small;background-color:white;"><?php if(isset($reg4->fechaderesguardo)){ echo date_format( date_create(@$reg4->fechaderesguardo) , 'd-m-Y'); } ?></span>
                    <br>
                    <span style="color: #223a66; font-weight: bold; font-size: small;">No. de oficio del resguardo enviado a geografía:</span>
                    <span style="font-size:small;background-color:white;"><?php echo @$reg4->folioderesguardo;?></span>
                    <br>
                    <span style="color: #223a66; font-weight: bold; font-size: small;">Observaciones:</span>
                    <span style="font-size:small;background-color:white;"><?php echo @$reg4->observaciones;?></span>
                </td>
            </tr>
        <?php } ?>
        </tbody>
    </table>
</div>

<script>
    setTimeout(function () { $("#loader").hide(); }, 300); 
</script>