<meta http-equiv="content-type" content="application/xhtml+xml; charset=UTF-8" />


<?php

header("Content-type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet;  name='excel'");
 
header("Content-Disposition: attachment; filename=levantamientos_topograficos.xls");
header("Pragma: no-cache");
header("Expires: 0");

//application/vnd.ms-excel;
echo $_POST['datos_a_enviar'];
?>