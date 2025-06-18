<?php 
    require_once 'Ops2.php';
    $lst= new Ops2();

    $fup=$_REQUEST['fup'];

    $iscancelado= $lst->is_levantamiento_cancelado($fup);
    if($iscancelado){
        echo '<br><br><br><br><br><br><div style="margin-right:10%; margin-left:10%;" class="alert alert-danger" role="alert">El levantamiento ha sido cancelado.</div>';
        return; ///si el levantamiento está cancelado, no se muestra nada más
    }


    $esp_actual=$lst->get_especialista_with_fup($fup);

    $id_del=$_SESSION['delegacion'];    
    if($id_del==0){
        $id_del=1; ///como se trata de geografía, se ponen los especialistas de la delegación toluca
    }
    
    $lista_especialistas=$lst->get_especialistas($id_del);

    $lista_especialistas_cambiados = $lst->get_especialistas_cambiados($fup);
    //echo json_encode($lista_especialistas_cambiados);
    $especialista_actual='';

?>

<?php foreach($lista_especialistas_cambiados as $lec){ 
    $especialista_actual=$lec->nombre.' '.$lec->apep.' '.$lec->apem;
?>
    <div class="row" align="left">
        <div class="col-md-1"></div>
        <div class="col-md-3" style="border-bottom: 1px solid #99adbf;"><?php echo $lec->nombre.' '.$lec->apep.' '.$lec->apem ;?></div>
        <div class="col-md-2" style="border-bottom: 1px solid #99adbf;"><?php echo (new DateTime($lec->fecha_cambio))->format('d-m-Y');?></div>
        <div class="col-md-5" style="border-bottom: 1px solid #99adbf;"><?php echo $lec->motivo; ?></div>
        <div class="col-md-1"></div>
    </div>    
<?php } ?>

<br><br>
<div class="row" align="left">
    <div class="col-md-2"></div>
    <div class="col-md-8">
        
        <label><b>Especialista actual:</b></label>
        <input class="form-control" readonly value="<?php if($especialista_actual!=''){echo $especialista_actual;}else{ echo $esp_actual->nombre.' '.$esp_actual->apep.' '.$esp_actual->apem; }?>"/>
        <br>
        <label><b>Cambiar especialista:</b></label>
        <select id="especialista_cambio" class="form-control" >
            <option value=0 hidden></option>
            <?php foreach($lista_especialistas as $especialista){ ?>
                <option value="<?php echo $especialista->id; ?>"><?php echo $especialista->nombre.' '.$especialista->apep.' '.$especialista->apem; ?></option>
            <?php } ?>
        </select>
        <br>
        <label><b>Motivo de cambio:</b></label>
        <textarea id="motivo_cambio" class="form-control" rows="3" placeholder="Indique el motivo del cambio de especialista"></textarea>

        <br>
        <button class="form-control btn-info" type="button" onclick="cambio_especialista();">Cambiar especialista</button>

    </div>
    <div class="col-md-2"></div>
</div>
<br><br><br>

<script>
    function cambio_especialista(){
        ///se valida que se haya elegido un especialista(diferente de 0) y que se haya indicado el motivo del cambio
        var especialista = $("#especialista_cambio").val(); 
        var motivo = $("#motivo_cambio").val().trim();

        if (especialista == 0) {
            Swal.fire("", "Seleccione un especialista", "warning");
            return;
        }
        if (motivo.length === 0) {
            Swal.fire("", "Indique el motivo del cambio", "warning");
            return;
        }

        /// Aquí puedes continuar con el proceso de cambio, por ejemplo, enviar los datos por AJAX
        $.ajax({
            url:'Ops2.php',
            data:{action:'save_cambio_especialista', fup: '<?php echo $fup; ?>', especialista: especialista, motivo: motivo},
            type:'post',
            dataType:'json',
            success:function(v){
                //alert(v);
                if(v==true){
                    Swal.fire("", "Especialista cambiado", "success");
                    $("#info_op").load("geo_lt_campo_info.php?opcion=2&fup=" + "<?php echo $fup; ?>" );
                }else{
                    Swal.fire("", "Ocurrió un error", "warning");
                }
                
            }
        });

    }
</script>