<?php 
    require_once 'Ops2.php';
    $lst= new Ops2();

    $fup=$_REQUEST['fup'];

    $iscancelado= $lst->is_levantamiento_cancelado($fup);
    if($iscancelado){
        echo '<br><br><br><br><br><br><div style="margin-right:10%; margin-left:10%;" class="alert alert-danger" role="alert">El levantamiento ha sido cancelado.</div>';
        return; ///si el levantamiento está cancelado, no se muestra nada más
    }

    $id_reg=$lst->get_registro($fup)->id;///se obtiene el registro, para obtener el id
    $reg=$lst->get_regs_procesodos($id_reg);///aqui viene fechalevantamiento, que es la que se utiliza 

    $fechalevantamiento = (new DateTime($reg->fechalevantamiento))->format('Y-m-d');

    $fechalevantamiento_mas_un_dia = (new DateTime($reg->fechalevantamiento))->modify('+1 day')->format('Y-m-d');


    $dias_agregados = $lst->get_dias_agregados($fup);
    //echo json_encode($dias_agregados);
    
    $last_fecha=null;////para bloquear el calendario a partir de esta fecha
?>
<br>
<div class="row" align="left">
    <div class="col-md-1"></div>
    <div class="col-md-11">
        <label><b>Fecha del levantamiento inicial:</b></label>
        <input class="form-control" type="date" style="width:15%; text-align:center;" value="<?php echo $fechalevantamiento; ?>" readonly/>
        <br>
        
        <!-- Estos son los días agregados al levatamiento, en caso de que haya -->
        <div class="row">
            <?php foreach($dias_agregados as $lt){ 
                $last_fecha=$lt->fecha_agregada;
            ?>
                <div class="col-md-12">
                    <?php echo '<b>Día '.($lt->num_dia+1).':</b> '.(new DateTime($lt->fecha_agregada))->format('d/m/Y'); ?>
                </div>
            <?php } ?>
        </div> 
                
        <?php //echo $last_fecha;
            if($last_fecha!=null){///si hay registros guardados, se toma el último para seleccionar fecha a partir de este en el input date y bloquear lo anterior
                $fechalevantamiento_mas_un_dia = (new DateTime($last_fecha))->modify('+1 day')->format('Y-m-d');
            }
        ?>

        <br>
        <div class="row">
            <div class="col-md-4" onclick="muestra_fechas();">
                <label style="font-size:14pt; font-weight:bold;">Agregar día &nbsp&nbsp&nbsp</label>        
                <i class="fa-solid fa-plus fa-2x" style="color:#8a2034; cursor:pointer;" ></i>
            </div>
            <div class="col-md-4">
                <input class="form-control fecha_agregada" id="fecha_agregar" type="date" style="width:60%; display:none;" min="<?php echo $fechalevantamiento_mas_un_dia; ?>"/>
            </div>

            <div class="col-md-4">
                <button class="form-control btn-info fecha_agregada" type="button" style="width:50%; display:none;" onclick="guardar_dia_fecha();">Agregar</button>
            </div>
        </div>
    </div>
</div>

<script>
    function muestra_fechas(){
        $(".fecha_agregada").show();
    }

    function guardar_dia_fecha(){
        const fecha= $("#fecha_agregar").val();
        if (!fecha) {
            Swal.fire("","Por favor, seleccione una fecha","warning");
            return;
        }
        const dia = new Date(fecha).getDay();
        if (dia===5 || dia === 6) {
            Swal.fire("","La fecha seleccionada no puede ser sábado ni domingo","warning");
            return;
        }
        
        //alert(fecha);
        ////se guarda la fecha en la base de datos
        $.ajax({
            url:'Ops2.php',
            data:{action:'guardar_dia_lt', fup: '<?php echo $fup; ?>', fecha: fecha},
            type:'post',
            dataType:'json',
            success:function(v){
                //alert(v);
                if(v==true){
                    ////se recarga la página para mostrar los cambios
                    Swal.fire("","Día agegado al levantamiento exitosamente","success");
                    $("#info_op").load("geo_lt_campo_info.php?opcion=1&fup=" + "<?php echo $fup; ?>" );
                    
                }else{
                    Swal.fire("","No se pudo guardar la fecha, intente nuevamente","warning");
                }
                
            }
        });
    }
</script>