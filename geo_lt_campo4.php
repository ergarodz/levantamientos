<?php
    $fup = $_REQUEST['fup'];

    ////saber si el levantamiento ya fue cancelado
    require_once 'Ops2.php';
    $lst = new Ops2();
    $iscancelado= $lst->is_levantamiento_cancelado($fup);
    
    if($iscancelado){
        echo '<br><br><br><br><br><br><div style="margin-right:10%; margin-left:10%;" class="alert alert-danger" role="alert">El levantamiento ha sido cancelado.</div>';
        return; ///si el levantamiento está cancelado, no se muestra nada más
    }

?>
<br><br><br><br><br><br><br><br><br>
<div class="row">
    <div class="col-md-2"></div>
    <div class="col-md-8">        

        <button class="form-control btn-info" type="button" onclick="cancelar_levantamiento_geo();"  >Cancelar levantamiento</button>

    </div>
    <div class="col-md-2"></div>

<script>
    function cancelar_levantamiento_geo(){
        Swal.fire({
            title: "¿Está seguro?",
            text: "Esta acción cancelará el levantamiento y no podrá deshacerse",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            cancelButtonText: "Cancelar",
            confirmButtonText: "Sí, cancelar levantamiento"
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: 'Ops2.php',
                    data: {action: 'cancelar_levantamiento_geo', fup: '<?php echo $fup; ?>'},
                    type: 'post',
                    dataType: 'json',
                    success: function(response) {
                        
                        if (response==true) {
                            Swal.fire("Cancelado", "El levantamiento ha sido cancelado exitosamente", "success");
                            $("#info_op").load("geo_lt_campo_info.php?opcion=4&fup=" + "<?php echo $fup; ?>" );
                        } else {
                            Swal.fire("Error", "No se pudo cancelar el levantamiento, intente nuevamente", "error");
                        }
                    }
                });
            }
        });
    }
</script>
</div>

