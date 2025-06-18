<?php
    require_once 'Ops2.php';
    $lst = new Ops2();
    $fup = $_REQUEST['fup'];

    $iscancelado= $lst->is_levantamiento_cancelado($fup);
    if($iscancelado){
        echo '<br><br><br><br><br><br><div style="margin-right:10%; margin-left:10%;" class="alert alert-danger" role="alert">El levantamiento ha sido cancelado.</div>';
        return; ///si el levantamiento está cancelado, no se muestra nada más
    }


    $reg=$lst->get_regs_procesodos_with_fup($fup);

    $fechalevantamiento=(new DateTime($reg->fechalevantamiento))->format('Y-m-d');

    $cambios_de_fecha = $lst->get_regs_cambio_fecha_levantamiento($fup);
      
?>

<?php foreach($cambios_de_fecha as $cambiofecha){ 
    if($cambios_de_fecha!=null){///si hay registros guardados, se toma el último para seleccionar fecha a partir de este en el input date y bloquear lo anterior
        $fechalevantamiento_mas_un_dia = (new DateTime($cambiofecha->fecha_nueva))->modify('+1 day')->format('Y-m-d');

        $fechalevantamiento = (new DateTime($cambiofecha->fecha_nueva))->format('Y-m-d');
    }      
?>

<div class="row">
    <div class="col-md-1"></div>
    <div class="col-md-3" style="border-bottom: 1px solid #99adbf;"><?php echo (new DateTime($cambiofecha->fecha_nueva))->format('d-m-Y'); ?></div>
    <div class="col-md-7" style="border-bottom: 1px solid #99adbf;"><?php echo $cambiofecha->motivo; ?></div>
    <div class="col-md-1"></div>
</div>

<?php } ?>

<br>
<div class="row">
    <div class="col-md-2"></div>
    <div class="col-md-8">
        <label><b>Fecha de levantamiento:</b></label>
        <input type="date" id="fecha_levantamiento" class="form-control" readonly value="<?php echo $fechalevantamiento; ?>" />
    </div>
    <div class="col-md-2"></div>
</div>
<br>
<div class="row">
    <div class="col-md-2"></div>
    <div class="col-md-8">
        <label><b>Cambiar fecha de levantamiento</b></label>
        <input type="date" id="nueva_fechalevantamiento" class="form-control" min="<?php echo $fechalevantamiento_mas_un_dia; ?>"/>
    </div>
    <div class="col-md-2"></div>
</div>
<br>
<div class="row">
    <div class="col-md-2"></div>
    <div class="col-md-8">
        <label><b>Motivo de cambio:</b></label>
        <textarea id="motivo_cambio" class="form-control" rows="3" placeholder="Indique el motivo del cambio de fecha"></textarea>
    </div>
    <div class="col-md-2"></div>
</div>
<br>
<div class="row">
    <div class="col-md-2"></div>
    <div class="col-md-8">
        <button class="form-control btn-info" type="button" onclick="cambio_fecha_levantamiento();">Cambiar fecha levantamiento</button>
    </div>
    <div class="col-md-2"></div>
</div>

<script>
    function cambio_fecha_levantamiento(){
        const fecha= $("#nueva_fechalevantamiento").val();
        if (!fecha) {
            Swal.fire("","Por favor, seleccione una fecha","warning");
            return;
        }
        const dia = new Date(fecha).getDay();
        if (dia===5 || dia === 6) {
            Swal.fire("","La fecha seleccionada no puede ser sábado ni domingo","warning");
            return;
        }

        const motivo = $("#motivo_cambio").val().trim();
        if (motivo.length === 0) {
            Swal.fire("", "Indique el motivo del cambio", "warning");
            return;
        }

        $.ajax({
            url:'Ops2.php',
            data:{action:'save_cambio_fecha_levantamiento',fup: '<?php echo $fup; ?>', fecha: fecha, motivo: motivo},
            dataType:'json',
            type:'post',
            success:function(response){
                if(response==true){
                    Swal.fire("","Fecha de levantamiento cambiada exitosamente","success");
                    $("#info_op").load("geo_lt_campo_info.php?opcion=3&fup=" + "<?php echo $fup; ?>" );
                }else{
                    Swal.fire("","Error al agregar fecha de levantamiento: "+response.error,"error");
                }
            },
        });

    }
</script>