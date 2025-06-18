<?php
if(isset($_REQUEST['opcion']) ){
    $opcion=$_REQUEST['opcion'];
}

switch ($opcion) {
    case 1: //Agregar días al levantamiento
        require_once 'geo_lt_campo1.php';
        break;
    case 2: //Cambiar especialista
        require_once 'geo_lt_campo2.php';
        break;
    case 3: //Cambiar fecha de levantamiento
        require_once 'geo_lt_campo3.php';
        break;
    case 4: //Cancelar levantamiento
        require_once 'geo_lt_campo4.php';
        break;
    default:
        echo "Opción no válida";
}
?>
