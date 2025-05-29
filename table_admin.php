<script type="text/javascript">
    $(document).ready(function() {
        $('#table_admin').DataTable({ 
            "language": { "url": "//cdn.datatables.net/plug-ins/1.10.15/i18n/Spanish.json" }
        });
    });
</script>

<?php	
	if (isset($_REQUEST['anio']) ) {
		$anio=$_REQUEST['anio'];
	}

	if (isset($_REQUEST['delegacion']) ) {
		$id_deleg=$_REQUEST['delegacion'];
	}

	require_once 'Ops.php'; 
    $op= new Op();  

    $registros=$op->get_registros_admin($anio, $id_deleg);
    //echo json_encode($registros);

    $fechasNoLab = array("2022-01-01","2022-01-02","2022-01-03","2022-01-04","2022-01-05","2022-01-08","2022-01-09","2022-01-15","2022-01-16","2022-01-22","2022-01-23","2022-01-29","2022-01-30","2022-02-05","2022-02-06","2022-02-07","2022-02-12","2022-02-13","2022-02-19","2022-02-20","2022-02-26","2022-02-27","2022-03-02","2022-03-05","2022-03-06","2022-03-12","2022-03-13","2022-03-19","2022-03-20","2022-03-21","2022-03-26","2022-03-27","2022-04-02","2022-04-03","2022-04-09","2022-04-10","2022-04-11","2022-04-12","2022-04-13","2022-04-14","2022-04-15","2022-04-16","2022-04-17","2022-04-23","2022-04-24","2022-04-30","2022-05-01","2022-05-05","2022-05-07","2022-05-08","2022-05-14","2022-05-15","2022-05-21","2022-05-22","2022-05-28","2022-05-29","2022-06-04","2022-06-05","2022-06-11","2022-06-12","2022-06-18","2022-06-19","2022-06-25","2022-06-26","2022-07-02","2022-07-03","2022-07-09","2022-07-10","2022-07-16","2022-07-17","2022-07-18","2022-07-19","2022-07-20","2022-07-21","2022-07-22","2022-07-23","2022-07-24","2022-07-30","2022-07-31","2022-08-06","2022-08-07","2022-08-13","2022-08-14","2022-08-20","2022-08-21","2022-08-27","2022-08-28","2022-09-03","2022-09-04","2022-09-10","2022-09-11","2022-09-16","2022-09-17","2022-09-18","2022-09-24","2022-09-25","2022-10-01","2022-10-02","2022-10-08","2022-10-09","2022-10-15","2022-10-16","2022-10-22","2022-10-23","2022-10-29","2022-10-30","2022-11-02","2022-11-05","2022-11-06","2022-11-12","2022-11-13","2022-11-19","2022-11-20","2022-11-21","2022-11-26","2022-11-27","2022-12-03","2022-12-04","2022-12-10","2022-12-11","2022-12-17","2022-12-18","2022-12-22","2022-12-23","2022-12-24","2022-12-25","2022-12-26","2022-12-27","2022-12-28","2022-12-29","2022-12-30","2022-12-31","2023-01-01","2023-01-02","2023-01-03","2023-01-04","2023-01-07","2023-01-08","2023-01-14","2023-01-15","2023-01-21","2023-01-22","2023-01-28","2023-01-29","2023-02-04","2023-02-05","2023-02-06","2023-02-11","2023-02-12","2023-02-18","2023-02-19","2023-02-25","2023-02-26","2023-03-02","2023-03-04","2023-03-05","2023-03-11","2023-03-12","2023-03-18","2023-03-19","2023-03-20","2023-03-25","2023-03-26","2023-04-01","2023-04-02","2023-04-03","2023-04-04","2023-04-05","2023-04-06","2023-04-07","2023-04-08","2023-04-09","2023-04-15","2023-04-16","2023-04-22","2023-04-23","2023-04-29","2023-04-30","2023-05-01","2023-05-05","2023-05-06","2023-05-07","2023-05-13","2023-05-14","2023-05-20","2023-05-21","2023-05-27","2023-05-28","2023-06-03","2023-06-04","2023-06-10","2023-06-11","2023-06-17","2023-06-18","2023-06-24","2023-06-25","2023-07-01","2023-07-02","2023-07-08","2023-07-09","2023-07-15","2023-07-16","2023-07-22","2023-07-23","2023-07-24","2023-07-25","2023-07-26","2023-07-27","2023-07-28","2023-07-29","2023-07-30","2023-08-05","2023-08-06","2023-08-12","2023-08-13","2023-08-19","2023-08-20","2023-08-26","2023-08-27","2023-09-02","2023-09-03","2023-09-09","2023-09-10","2023-09-16","2023-09-17","2023-09-23","2023-09-24","2023-09-30","2023-10-01","2023-10-07","2023-10-08","2023-10-14","2023-10-15","2023-10-21","2023-10-22","2023-10-28","2023-10-29","2023-11-02","2023-11-04","2023-11-05","2023-11-11","2023-11-12","2023-11-18","2023-11-19","2023-11-20","2023-11-25","2023-11-26","2023-12-02","2023-12-03","2023-12-09","2023-12-10","2023-12-16","2023-12-17","2023-12-20","2023-12-21","2023-12-22","2023-12-23","2023-12-24","2023-12-25","2023-12-26","2023-12-27","2023-12-28","2023-12-29","2023-12-30","2023-12-31","2024-01-01","2024-01-02","2024-01-03","2024-01-04","2024-01-06","2024-01-07","2024-01-13","2024-01-14","2024-01-20","2024-01-21","2024-01-27","2024-01-28","2024-02-03","2024-02-04","2024-02-05","2024-02-10","2024-02-11","2024-02-17","2024-02-18","2024-02-24","2024-02-25","2024-03-01","2024-03-02","2024-03-03","2024-03-09","2024-03-10","2024-03-16","2024-03-17","2024-03-18","2024-03-23","2024-03-24","2024-03-25","2024-03-26","2024-03-27","2024-03-28","2024-03-29","2024-03-30","2024-03-31", "2024-04-06","2024-04-07","2024-04-13", "2024-04-14", "2024-04-20", "2024-04-21","2024-04-27","2024-04-28","2024-05-01","2024-05-04","2024-05-05","2024-05-06","2024-05-11","2024-05-12","2024-05-18","2024-05-19","2024-05-25","2024-05-26","2024-06-01", "2024-06-02","2024-06-08","2024-06-09","2024-06-15","2024-06-16","2024-06-22","2024-06-23","2024-06-29","2024-06-30","2024-07-06","2024-07-07","2024-07-13","2024-07-14","2024-07-20","2024-07-21", "2024-07-22","2024-07-23","2024-07-24","2024-07-25","2024-07-26","2024-07-27","2024-07-28","2024-08-03","2024-08-04","2024-08-10","2024-08-11","2024-08-17","2024-08-18","2024-08-24","2024-08-25", "2024-08-31","2024-09-01","2024-09-07","2024-09-08","2024-09-14","2024-09-15","2024-09-16","2024-09-21","2024-09-22","2024-09-28","2024-09-29","2024-10-01","2024-10-05","2024-10-06","2024-10-12", "2024-10-13","2024-10-19","2024-10-20","2024-10-26","2024-10-27","2024-11-01","2024-11-02","2024-11-03","2024-11-09","2024-11-10","2024-11-16","2024-11-17","2024-11-18","2024-11-23", "2024-11-24","2024-11-30","2024-12-01","2024-12-07","2024-12-08","2024-12-14","2024-12-15","2024-12-20","2024-12-21","2024-12-22","2024-12-23","2024-12-24","2024-12-25","2024-12-26","2024-12-27","2024-12-28","2024-12-29","2024-12-30","2024-12-31" );
	$diasInabiles = count($fechasNoLab);
?>

<table id="table_admin" class="display" style="width:100%">
    <thead>
        <tr>
            <th  style="text-align: center; font-size: medium;  font-weight: bold; color: #223a66;">FUP</th>
            <th  style="text-align: center; font-size: medium;  font-weight: bold; color: #223a66;">ESTATUS</th>
            <th  style="text-align: center; font-size: medium;  font-weight: bold; color: #223a66;">PROCESO</th>
            <th  style="text-align: center; font-size: medium;  font-weight: bold; color: #223a66;">TIEMPO TRANSCURRIDO (DÍAS HÁBILES)</th>
        </tr>
    </thead>
    <tbody>
    <?php foreach($registros as $c){ 
    	
    	$fechaRegistro = $c->fecha_recepcion;
    	$fechaFinal = date('Y-m-d');

    	switch ($c->proceso) {
    		case '1':
    			$procesoE = "INGRESADO EN DELEGACIÓN";
    			//$color='#e50a23';
    			$color='#FFFFFF';

    			$TotalDeDias = $op->obtenerDiasDeProceso($fechaRegistro,$fechaFinal,$diasInabiles,$fechasNoLab);
    			break;
    		case '2':
    			$procesoE = "ENVIADO A TOPOGRAFÍA";
    			//$color='#d76471';
    			$color='#FDF5E6';

    			$TotalDeDias = $op->obtenerDiasDeProceso($fechaRegistro,$fechaFinal,$diasInabiles,$fechasNoLab);
    			break;
    		case '3':
    			$procesoE = "NOTIFICADO";
    			//$color='#e5a54d';
    			$color='#FFFFCC';

				$fechaFinal = $c->fechacancelacion;
				if($fechaFinal==null){
					$fechaFinal=date('Y-m-d');
				}
				$TotalDeDias = $op->obtenerDiasDeProceso($fechaRegistro,$fechaFinal,$diasInabiles,$fechasNoLab); 
    			break;
    		case '4':
    			$procesoE = "LEVANTAMIENTO REALIZADO";
    			//$color='#e5dd4d';
    			$color='#C9FFE5';

				$TotalDeDias = $op->obtenerDiasDeProceso($fechaRegistro,$fechaFinal,$diasInabiles,$fechasNoLab); 
    			break;
    		case '5':
    			$procesoE = "ENVIADO A DIR. DE GEOGRAFÍA";
    			//$color='#8bdbd2';
    			$color='#ADD8E6';

    			$TotalDeDias = $op->obtenerDiasDeProceso($fechaRegistro,$fechaFinal,$diasInabiles,$fechasNoLab); 
    			break;
    		case '6':
    			$procesoE = "RECEPCIONADO EN DSI (CCC)";
    			//$color='#397383';
    			$color='#E6E6FA';

    			$TotalDeDias = $op->obtenerDiasDeProceso($fechaRegistro,$fechaFinal,$diasInabiles,$fechasNoLab); 
    			break;
    		case '7':
    			$procesoE = "ENTREGADO A LA DELEGACIÓN";
    			//$color='#3bd3fb';
    			$color='#FFC0CB';

    			$TotalDeDias = $op->obtenerDiasDeProceso($fechaRegistro,$fechaFinal,$diasInabiles,$fechasNoLab);
    			break;
    		case '8':
    			$procesoE = "ENTREGADO AL SOLICITANTE";
    			//$color='#70c77f';
    			$color='#FFDAB9';

    			$fechaFinal=$op->obtenerDiaDeEntrega($c->id)->fechaentregasol; 
		                         
		        $TotalDeDias = $op->obtenerDiasDeProceso($fechaRegistro,$fechaFinal,$diasInabiles,$fechasNoLab); 
    			break;
    		case '9':
    			$procesoE = "CERRADO";
    			//$color='#a179e7';
    			$color='#FF6347';

                //fecha registrada en el proceso 8
                $fecha = $op->obtenerDiaDeEntrega($c->id); 
                $fechaFinal = @$fecha->fechaentregasol; 
                $TotalDeDias = $op->obtenerDiasDeProceso($fechaRegistro,$fechaFinal,$diasInabiles,$fechasNoLab); 
    			break;
    	}      	
    ?>
    	<tr>
    		<td style="text-align: center; font-weight: bold; font-size: large;"><?php echo $c->fup;?></td>
    		<td style="text-align: center; background-color:<?php echo $color;?>; font-weight: bold;"><?php echo $procesoE;?></td>
    		<td style="text-align: center; background-color:<?php echo $color;?>; font-weight: bold;"><?php echo $c->proceso;?> </td>
    		
    		<!-- Se calculan aquí los días transcurridos desde la fecha_recepcion -->
    		<?php if ($TotalDeDias >= 1 && $TotalDeDias <= 20) { ?>
    		<td style="text-align: center; background-color: #70c77f; color:black;"><b><?php echo $TotalDeDias; ?></b></td>
    		<?php }else if ($TotalDeDias >= 21 && $TotalDeDias <= 25) { ?>
    		<td style="text-align: center; background-color: #e5dd4d; color: black;"><b><?php echo $TotalDeDias; ?></b></td>
    		<?php } else if ($TotalDeDias >= 26) { //erick, aqui es donde se calcula la diferencia de días ?>
    		<td style="text-align: center; background-color: #d76471; color: black;"><b><?php echo $TotalDeDias; ?></b></td>
    		<?php }else {  ?>	
    		<td style="text-align: center; background-color: #70c77f; color:black;"><b><?php echo "0"; ?></b></td>
    		<?php } ?>

    	</tr>
    <?php } ?>	
    </tbody>
    <!-- <tfoot>
    	<tr>
            <th style="text-align: center; font-size: medium;  font-weight: bold; color: #223a66;">FUP</th>
            <th style="text-align: center; font-size: medium;  font-weight: bold; color: #223a66;">ESTATUS</th>
            <th style="text-align: center; font-size: medium;  font-weight: bold; color: #223a66;">PROCESO</th>
            <th  style="text-align: center; font-size: medium;  font-weight: bold; color: #223a66;">TIEMPO TRANSCURRIDO (DÍAS HÁBILES)</th>
        </tr>
    </tfoot> -->
</table>


<script type="text/javascript">
    $("#loader").modal('hide');
</script>