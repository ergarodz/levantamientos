<?php //echo 'se muestran los registros que han sido cancelados por Geografía<br><br>';

require_once '../Ops2.php';
$cancelados = new Ops2();
$cancelados=$cancelados->get_lt_cancelados_geo();

//echo json_encode($cancelados);

?>

<script type="text/javascript">
    $(document).ready(function() {
        $('#tbl_cancelados').DataTable({ 
            language: {
		        "url": "//cdn.datatables.net/plug-ins/1.10.15/i18n/Spanish.json"
		    },
            aLengthMenu: [
		        [5, 10, 30, -1],
		        [5, 10, 30, "Todos"]
		    ]
        });
    });
</script>

<div class="row">
    <div class="col-md-2"></div>
    <div class="col-md-8">
        <table id="tbl_cancelados">
            <thead>
                <th class="dark">FUP</th>
                <th class="dark">Fecha cancelación</th>
            </thead>
            <tbody>
                <?php foreach($cancelados as $cancel){ ?>
                    <td><b class="dark"><?php echo $cancel->fup;?></b></td>
                    <td><?php echo $cancel->fecha_cancelado;?></td>
                <?php } ?>
            </tbody>
        </table>
    </div>
    <div class="col-md-2"></div>
</div>
