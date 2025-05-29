<?php
 
if (session_status() == PHP_SESSION_NONE) {
session_start();
}
    date_default_timezone_set('America/Mexico_City');
    setlocale(LC_TIME, 'spanish');
/*
// JOIN UNION PARA TODO EL SISTEMA
FOLIO, ID CONTRIBUYENTE, ID_DICTAMINADOR
select d.id_dictaminador as dictaminador,p.id_dictaminador as contribuyente,d.folio from contribuyentedatos_v2 as d
join
aviso_dictamen_v2 as p
on
d.folio = p.id_aviso

*/

class Controllermaster {

public function login($c,$user,$pass){
  
    $query = "select * from usuarios where usuario = '".htmlentities($user)."' AND passw = '".htmlentities($pass)."';";

    $result = pg_query($query) or die('La consulta fallo: ' . pg_last_error());
    // Imprimiendo los resultados aarray
    $rs = pg_query( $c, $query );
    $validate_exixts = pg_num_rows($rs);
    if( $validate_exixts == "1" ){
    	while( $obj = pg_fetch_object($rs) ){
        $data[] = $obj;
      }


        $_SESSION["usuario"] = $user;
          $_SESSION['id_userAg']=$data[0]->id;
          $_SESSION['abrev']=$data[0]->abrev;
     
      if ($data[0]->tipoUsuario == 2) {
           //echo $link = "https://levantamientostopograficos.edomex.gob.mx/delegaciones.php" ;
           echo "delegaciones.php";
      }else{
         //echo $link = "https://levantamientostopograficos.edomex.gob.mx/admonIni.php" ;
         echo "admonIni.php";
      }
    
    }else{
    	//echo $link = "https://levantamientostopograficos.edomex.gob.mx/index.php" ; 
      echo "index.php";
    }
  
}

public function cerrar_sesion($c){

	session_destroy();
	//Redireccionamos a Inicio (al inicio de sesión)
	//echo "https://levantamientostopograficos.edomex.gob.mx/index.php";
  echo "index.php";

}

public function nombre_municipio($c,$id){ 
	 $query = "select municipio from municipios where num='$id';";

    $result = pg_query($query) or die('La consulta fallo: ' . pg_last_error());
    // Imprimiendo los resultados aarray
    $rs = pg_query( $c, $query );
    $validate_exixts = pg_num_rows($rs);
    if( $validate_exixts == "1" ){
    	while( $obj = pg_fetch_object($rs) ){
        $data[] = $obj;
        echo $data[0]->municipio;
      }
  }else{
  		echo "N/A"; 
      }

}

public function guardarInfoUno($c,$c_muni,$c_zona,$c_manz,$c_lote,$c_edif,$c_dept,$solicitante,$apaterno,$amaterno,$municipio,$fechaRecepcion,$superficieIn,$anticipo,$abrev,$iddelegacion,$fupAs,$propietario,$aPaternoPropietario,$aMaternoPropietario){
	//unir la clave catastral
	$c_muni2 = str_pad($c_muni, 3, "0", STR_PAD_LEFT);
	$c_zona2 = str_pad($c_zona, 2, "0", STR_PAD_LEFT);
	$c_manz2 = str_pad($c_manz, 3, "0", STR_PAD_LEFT);
	$c_lote2 = str_pad($c_lote, 2, "0", STR_PAD_LEFT);
	$c_edif2 = str_pad($c_edif, 2, "0", STR_PAD_LEFT);
	$c_dept2 = str_pad($c_dept, 4, "0", STR_PAD_LEFT);

	$clavec = $c_muni2.$c_zona2.$c_manz2.$c_lote2.$c_edif2.$c_dept2;

	//obtener ultimo numero serial de la base de datos POR DELEGACION PARA FORMAR EL fup

	/*$query = "Select max(fup) as fup from registros WHERE iddelegacion=$iddelegacion;";

    $result = pg_query($query) or die('La consulta fallo: ' . pg_last_error());
    // Imprimiendo los resultados aarray
    $rs = pg_query( $c, $query );
    $validate_exixts = pg_num_rows($rs);
    if( $validate_exixts == "1" ){
    	while( $obj = pg_fetch_object($rs) ){
        $data[] = $obj;
        $ulrimoFup= $data[0]->fup;
      }
  }else{
  		 $ulrimoFup='nn-220000'; 
      }


     $ulrimoFup2 = substr($ulrimoFup, 5);  // devuelve "0000"  
    
     $ulrimoFup3  = $ulrimoFup2 + 1; 

      $ulrimoFup3 = str_pad($ulrimoFup3, 4, "0", STR_PAD_LEFT);

  $anio = date('Y');
  $anio2 = substr($anio, -2);
  $FUP = $abrev.'-'.$anio2.$ulrimoFup3;*/

//////////////////////////Obtener el ultimo id general////////////////////////////////////

    $queryL = "Select max(id) as id from registros;";

    $resultL = pg_query($queryL) or die('La consulta fallo: ' . pg_last_error());
    // Imprimiendo los resultados aarray
    $rsL = pg_query( $c, $queryL );
    $validate_exixtsL = pg_num_rows($rsL);
    if( $validate_exixtsL == "1" ){
      while( $objL = pg_fetch_object($rsL) ){
        $dataL[] = $objL;
        $ulrimoFupL= $dataL[0]->id;
      }
  }else{
       $ulrimoFupL=0; 
      }

        $ulrimoFup2L  = $ulrimoFupL + 1;


	//guardar en base de datos
        //$propietario,$aPaternoPropietario,$aMaternoPropietario
	
	 $sql = "INSERT INTO registros(id, clavec, municipio, solicitante, superficieInicial, anticipo, fup,fecha_recepcion, proceso, iddelegacion, apaterno, amaterno, propietario, apaternoprop, amaternoprop, fechacancelacion, cancelado) VALUES ($ulrimoFup2L, '$clavec', '$municipio', '$solicitante', '$superficieIn', '$anticipo', '$fupAs', '$fechaRecepcion', 1, $iddelegacion, '$apaterno', '$amaterno', '$propietario', '$aPaternoPropietario', '$aMaternoPropietario', null, 0);";
		pg_query($c, $sql);

   $fecha_actual = date("Y-m-d H:i:s");

  $sql2 = "INSERT INTO historico(id, clavec, municipio, solicitante, superficieinicial, anticipo, 
            fup, fecha_recepcion, proceso, iddelegacion, apaterno, amaterno, 
            ordentrabajo, estatusfecha, fechaenvio, areaproduc, fechanotificacion, 
            fechalevantamiento, foliogeo, estatusfechater, fechatermino, 
            superficie, costototal, fechanotientrega, fechaentregasol, diferencia, 
            recibofup, id_envioexpediente, fechaentregageografia, fecha_actualizacion, propietario, apaternoprop, amaternoprop, fechacancelacion, cancelado)
    VALUES ($ulrimoFup2L, '$clavec', '$municipio', '$solicitante', '$superficieIn', '$anticipo', '$fupAs', '$fechaRecepcion', 1, $iddelegacion, '$apaterno', '$amaterno', null, null, null, null, null,null,null,null,null,null,null,null,null,null,null,null,null,'$fecha_actual', '$propietario', '$aPaternoPropietario', '$aMaternoPropietario', null, 0);";
    pg_query($c, $sql2);

		echo $fupAs;


}

public function buscarFup($c,$fup_buscar,$iddelegacion){

	 $query = "select * from registros where activo is true and fup='$fup_buscar' and iddelegacion=$iddelegacion;";  

    $result = pg_query($query) or die('La consulta fallo: ' . pg_last_error());
    // Imprimiendo los resultados aarray
    $rs = pg_query( $c, $query );
    $validate_exixts = pg_num_rows($rs);
    if( $validate_exixts == "1" ){
    	while( $obj = pg_fetch_object($rs) ){
        $data[] = $obj;
        
      }

      pg_free_result($result);
  // Cerrando la conexiÃ³n
  pg_close($c);
  header('Content-type: application/json');
  print_r(json_encode($data));
 //echo json_encode($data);

  }else{
  		echo "100"; 
      }

}

public function buscaRegistroProceDos($c,$folioRegistro){

    $query = "select * from procesodos where folio=$folioRegistro;";

    $result = pg_query($query) or die('La consulta fallo: ' . pg_last_error());
   
    $rs = pg_query($c, $query);
    $validate_exixts = pg_num_rows($rs);
    if( $validate_exixts == "1" ){
      while( $obj = pg_fetch_object($rs) ){
        $data[] = $obj;
        
      }

       pg_free_result($result);
  // Cerrando la conexiÃ³n
  pg_close($c);
  header('Content-type: application/json');
  print_r(json_encode($data));


    }else{
      echo "100"; 
      }

 

}

public function actualizarProcesoDos($c,$idRegistro,$ordenTrabajo,$estatusfechaEnvio,$fechaEnvio,$areaProductora){
                //$fechaNotificacion,$fechaLevantamiento,$folioGeo,$estatusFechaTermino,$fechaTermino,$superficie

  if ($fechaEnvio == 0) {
    $fechaEnvio = "1999-01-01";
  }

  if ($fechaNotificacion == 0) {
    $fechaNotificacion = "1999-01-01";
  }

  if ($fechaLevantamiento == 0) {
    $fechaLevantamiento = "1999-01-01";
  }

  if ($fechaTermino == 0) {
    $fechaTermino = "1999-01-01";
  }


     $sql = "INSERT INTO procesodos(id, folio, ordentrabajo, estatusfecha, fechaenvio, areaproduc, 
            fechanotificacion, fechalevantamiento, foliogeo, estatusfechater, 
            fechatermino, fecharecepcionccc) VALUES ($idRegistro, $idRegistro, '$ordenTrabajo', '$estatusfechaEnvio', '$fechaEnvio', '$areaProductora', null, null, null, null, null, null);";  
    
	
		pg_query($c, $sql);

    //////update en historico
    $fecha_actual = date("Y-m-d H:i:s");

    $sql2 = "UPDATE historico SET ordentrabajo='$ordenTrabajo', estatusfecha='$estatusfechaEnvio', fechaenvio='$fechaEnvio', 
       areaproduc='$areaProductora', fecha_actualizacion = '$fecha_actual'
        WHERE id = $idRegistro;"; 

    pg_query($c, $sql2);

		echo "1";



}


public function procesoDosActualizar($c,$idRegistro,$ordenTrabajo,$estatusfechaEnvio,$fechaEnvio,$areaProductora){
//$fechaNotificacion,$fechaLevantamiento,$folioGeo,$estatusFechaTermino,$fechaTermino,$superficie


  if ($fechaEnvio == 0) {
    $fechaEnvio = "1999-01-01";
  }

  if ($fechaNotificacion == 0) {
    $fechaNotificacion = "1999-01-01";
  }

  if ($fechaLevantamiento == 0) {
    $fechaLevantamiento = "1999-01-01";
  }

  if ($fechaTermino == 0) {
    $fechaTermino = "1999-01-01";
  }



    $sql = "UPDATE procesodos SET ordentrabajo='$ordenTrabajo', estatusfecha='$estatusfechaEnvio', fechaenvio='$fechaEnvio', 
       areaproduc='$areaProductora' WHERE id = $idRegistro and folio=$idRegistro;"; 
    

    pg_query($c, $sql);

    $fecha_actual = date("Y-m-d H:i:s");

    $sql2 = "UPDATE historico SET ordentrabajo='$ordenTrabajo', estatusfecha='$estatusfechaEnvio', fechaenvio='$fechaEnvio', 
       areaproduc='$areaProductora', fecha_actualizacion = '$fecha_actual' 
        WHERE id = $idRegistro;"; 
    

    pg_query($c, $sql2);

    echo "1";



}


public function terminarProcesoDos($c,$idRegistro,$ordenTrabajo,$estatusfechaEnvio,$fechaEnvio,$areaProductora,$sn){

  if ($fechaEnvio == 0) {
    $fechaEnvio = "1999-01-01";
  }
/*
  if ($fechaNotificacion == 0) {
    $fechaNotificacion = "1999-01-01";
  }

  if ($fechaLevantamiento == 0) {
    $fechaLevantamiento = "1999-01-01";
  }

  if ($fechaTermino == 0) {
    $fechaTermino = "1999-01-01";
  }*/


      if ($sn == 10 || $sn == "10") {

         $sql = "INSERT INTO procesodos(id, folio, ordentrabajo, estatusfecha, fechaenvio, areaproduc, 
            fechanotificacion, fechalevantamiento, foliogeo, estatusfechater, 
            fechatermino, fecharecepcionccc) VALUES ($idRegistro, $idRegistro, '$ordenTrabajo', '$estatusfechaEnvio', '$fechaEnvio', '$areaProductora', null, null, null, null, null, null);";  

      //$idRegistro,$ordenTrabajo,$estatusfechaEnvio,$fechaEnvio,$areaProductora,$sn
  
      pg_query($c, $sql);


       $sqll = "UPDATE registros SET proceso=2 WHERE id = $idRegistro;"; 
        pg_query($c, $sqll); 

        echo "1";

        
      }else{

         $sql = "UPDATE procesodos SET ordentrabajo='$ordenTrabajo', estatusfecha='$estatusfechaEnvio', fechaenvio='$fechaEnvio', 
       areaproduc='$areaProductora' WHERE id = $idRegistro and folio=$idRegistro;";  
        pg_query($c, $sql);

        $sqll = "UPDATE registros SET proceso=2 WHERE id = $idRegistro;"; 
        pg_query($c, $sqll); 


    echo "1";


      }

       $fecha_actual = date("Y-m-d H:i:s"); //fecha_actualizacion

      $sql2 = "UPDATE historico SET proceso=2, ordentrabajo='$ordenTrabajo', estatusfecha='$estatusfechaEnvio', fechaenvio='$fechaEnvio', 
       areaproduc='$areaProductora', fecha_actualizacion='$fecha_actual' 
        WHERE id = $idRegistro;"; 
    

    pg_query($c, $sql2);

}

public function buscaRegistroProceTres($c,$folioRegistro){

    $query = "select * from procesotres where fol=$folioRegistro;"; 

    $result = pg_query($query) or die('La consulta fallo: ' . pg_last_error());
   
    $rs = pg_query($c, $query);
    $validate_exixts = pg_num_rows($rs);
    if( $validate_exixts == "1" ){
      while( $obj = pg_fetch_object($rs) ){
        $data[] = $obj;
        
      }

       pg_free_result($result);
  // Cerrando la conexiÃ³n
  pg_close($c);
  header('Content-type: application/json');
  print_r(json_encode($data));


    }else{
      echo "100"; 
      }

 

}

public function actualizarProcesoTres($c,$folioRegistro,$costoTT,$fechanotientrega,$fechaentregasolicitante,$diferencia,$reciboFUP){



  if ($fechanotientrega == 0) {
    $fechanotientrega = "1999-01-01";
  }

  if ($fechaentregasolicitante == 0) {
    $fechaentregasolicitante = "1999-01-01";
  }


     $sql = "INSERT INTO procesotres(id, fol, costototal, fechanotientrega, fechaentregasol, diferencia, recibofup)
            VALUES ($folioRegistro, $folioRegistro, '$costoTT', '$fechanotientrega', '$fechaentregasolicitante', '$diferencia', '$reciboFUP');";  
      
    pg_query($c, $sql);

     $fecha_actual = date("Y-m-d H:i:s"); 

    $sql2 = "UPDATE historico SET costototal='$costoTT', fechanotientrega='$fechanotientrega', fechaentregasol='$fechaentregasolicitante', diferencia='$diferencia', recibofup='$reciboFUP', fecha_actualizacion='$fecha_actual' WHERE id=$folioRegistro;";  
      
    pg_query($c, $sql2);

    echo "1";

} 

public function actualizarProcesoTres_up($c,$folioRegistro,$costoTT,$fechanotientrega,$fechaentregasolicitante,$diferencia,$reciboFUP){



  if ($fechanotientrega == 0) {
    $fechanotientrega = "1999-01-01";
  }

  if ($fechaentregasolicitante == 0) {
    $fechaentregasolicitante = "1999-01-01";
  }


     $sql = "UPDATE procesotres SET costototal='$costoTT', fechanotientrega='$fechanotientrega', fechaentregasol='$fechaentregasolicitante', diferencia='$diferencia', recibofup='$reciboFUP' WHERE id=$folioRegistro and fol=$folioRegistro";  
      
    pg_query($c, $sql);


     $fecha_actual = date("Y-m-d H:i:s"); 

    $sql2 = "UPDATE historico SET costototal='$costoTT', fechanotientrega='$fechanotientrega', fechaentregasol='$fechaentregasolicitante', diferencia='$diferencia', recibofup='$reciboFUP', fecha_actualizacion='$fecha_actual' WHERE id=$folioRegistro;";  
      
    pg_query($c, $sql2);

    echo "1";

} 

public function terminarProcesoTres($c,$idRegistro,$costoTT,$fechanotientrega,$fechaentregasolicitante,$diferencia,$reciboFUP){


  if ($fechanotientrega == 0) {
    $fechanotientrega = "1999-01-01";
  }

  if ($fechaentregasolicitante == 0) {
    $fechaentregasolicitante = "1999-01-01";
  }


        $sql = "UPDATE procesotres SET costototal='$costoTT', fechanotientrega='$fechanotientrega', fechaentregasol='$fechaentregasolicitante', diferencia='$diferencia', recibofup='$reciboFUP' WHERE id=$idRegistro and fol=$idRegistro;"; 
        pg_query($c, $sql);

        $sqll = "UPDATE registros SET proceso=3 WHERE id = $idRegistro;"; 
        pg_query($c, $sqll); 

         $fecha_actual = date("Y-m-d H:i:s");  

        $sql2 = "UPDATE historico SET proceso=3, costototal='$costoTT', fechanotientrega='$fechanotientrega', fechaentregasol='$fechaentregasolicitante', diferencia='$diferencia', recibofup='$reciboFUP', fecha_actualizacion='$fecha_actual' WHERE id=$idRegistro;";  
      
        pg_query($c, $sql2); 


    echo "1";



}

public function buscaRegistroProcesoCuatro($c,$folioRegistro){

    $query = "select * from procesodos where folio=$folioRegistro;"; 

    $result = pg_query($query) or die('La consulta fallo: ' . pg_last_error());
   
    $rs = pg_query($c, $query);
    $validate_exixts = pg_num_rows($rs);
    if( $validate_exixts == "1" ){
      while( $obj = pg_fetch_object($rs) ){
        $data[] = $obj;
        
      }

       pg_free_result($result);
  // Cerrando la conexiÃ³n
  pg_close($c);
  header('Content-type: application/json');
  print_r(json_encode($data));


    }else{
      echo "100"; 
      }

 

}

public function actualizarProcesoCuatro($c,$folioRegistro,$idConcluido,$fechaentregaGeo){



  if ($fechaentregaGeo == 0) {
    $fechaentregaGeo = "1999-01-01";
  }


     $sql = "INSERT INTO procesocuatro(id, fol, id_envioexpediente, fechaentregageografia)
            VALUES ($folioRegistro, $folioRegistro, '$idConcluido', '$fechaentregaGeo');";  
      
    pg_query($c, $sql);


    $sqll = "UPDATE registros SET proceso = 4 where id=$folioRegistro;";  
      
    pg_query($c, $sqll);


     $fecha_actual = date("Y-m-d H:i:s"); //fecha_actualizacion

    $sql2 = "UPDATE historico SET id_envioexpediente='$idConcluido', fechaentregageografia='$fechaentregaGeo', fecha_actualizacion ='$fecha_actual' WHERE id=$folioRegistro;";  
      
    pg_query($c, $sql2);

    
    echo "1";


}

public function actualizarProcesoCuatro_up($c,$folioRegistro,$idConcluido,$fechaentregaGeo){

  if ($fechaentregaGeo == 0) {
    $fechaentregaGeo = "1999-01-01";
  }
    $sql = "UPDATE procesodos SET fechalevantamiento='$fechaentregaGeo', foliogeo='$idConcluido' WHERE folio=$folioRegistro;";
    pg_query($c, $sql);
    // $sql = "UPDATE procesocuatro SET id_envioexpediente='$idConcluido', fechaentregageografia='$fechaentregaGeo' WHERE id=$folioRegistro and fol=$folioRegistro";  
      
    //pg_query($c, $sql);

     $fecha_actual = date("Y-m-d H:i:s"); //fecha_actualizacion
     $sql2 = "UPDATE historico SET fechalevantamiento='$fechaentregaGeo', foliogeo='$idConcluido', fecha_actualizacion = '$fecha_actual' WHERE id=$folioRegistro;";  
      
     pg_query($c, $sql2);

     // $sql2 = "UPDATE historico SET id_envioexpediente='$idConcluido', fechaentregageografia='$fechaentregaGeo', fecha_actualizacion = '$fecha_actual' WHERE id=$folioRegistro;";  
      
    //pg_query($c, $sql2);

    echo "1";


}

public function terminarProcesoCuatro($c,$folioRegistro,$idConcluido,$fechaentregaGeo){


  if ($fechaentregaGeo == 0) { 
    $fechaentregaGeo = "1999-01-01";
  }

        $sql = "UPDATE procesodos SET fechalevantamiento='$fechaentregaGeo', foliogeo='$idConcluido' WHERE folio=$folioRegistro;"; 
        pg_query($c, $sql);

        $sqll = "UPDATE registros SET proceso=4 WHERE id = $folioRegistro;"; 
        pg_query($c, $sqll); 

          $fecha_actual = date("Y-m-d H:i:s"); //fecha_actualizacion

        $sql2 = "UPDATE historico SET proceso=4, fechalevantamiento='$fechaentregaGeo', foliogeo='$idConcluido', fecha_actualizacion = '$fecha_actual' WHERE id=$folioRegistro;";   
      
        pg_query($c, $sql2);

        /*
        $sql = "UPDATE procesocuatro SET id_envioexpediente='$idConcluido', fechaentregageografia='$fechaentregaGeo' WHERE id=$folioRegistro and fol=$folioRegistro;"; 
        pg_query($c, $sql);

        $sqll = "UPDATE registros SET proceso=4 WHERE id = $folioRegistro;"; 
        pg_query($c, $sqll); 

          $fecha_actual = date("Y-m-d H:i:s"); //fecha_actualizacion

        $sql2 = "UPDATE historico SET proceso=4, id_envioexpediente='$idConcluido', fechaentregageografia='$fechaentregaGeo', fecha_actualizacion = '$fecha_actual' WHERE id=$folioRegistro;";   
      
        pg_query($c, $sql2);
        */


    echo "1";

}

public function cancelar_areaProductora($c,$folioRegistro,$ordenTrabajo,$sn){

  $fecha_actual = date("Y-m-d H:i:s");

  if ($sn == 103 || $sn == "103") { //sin registro - insert

      $sql = "INSERT INTO procesodos(id, folio, ordentrabajo, estatusfecha, fechaenvio, areaproduc, 
            fechanotificacion, fechalevantamiento, foliogeo, estatusfechater, 
            fechatermino, fecharecepcionccc) VALUES ($folioRegistro, $folioRegistro, '$ordenTrabajo', '3', null, null, null, null, null, '3', null, null);";  
      
      pg_query($c, $sql);
      $sqll = "UPDATE registros SET proceso=0 WHERE id = $folioRegistro;"; 
      pg_query($c, $sqll);

      $sql2 = "UPDATE historico SET proceso=0, ordentrabajo='$ordenTrabajo', estatusfecha='3', fechaenvio=null, 
       areaproduc=null, fechanotificacion=null, fechalevantamiento=null, foliogeo=null, 
       estatusfechater=3, fechatermino=null, superficie=null, fecha_actualizacion = '$fecha_actual'
        WHERE id = $folioRegistro;"; 
        pg_query($c, $sql2);

        
      echo "1";

  }else if($sn == 30 || $sn == "30"){ // con registro - update

      $sql = "UPDATE procesodos SET ordentrabajo='$ordenTrabajo', estatusfecha='3', fechaenvio=null, 
       areaproduc=null, fechanotificacion=null, fechalevantamiento=null, foliogeo=null, 
       estatusfechater=3, fechatermino=null, superficie=null
        WHERE id = $folioRegistro and folio=$folioRegistro;"; 
        pg_query($c, $sql);

      $sqll = "UPDATE registros SET proceso=0 WHERE id = $folioRegistro;"; 
      pg_query($c, $sqll); 

      $sql2 = "UPDATE historico SET proceso=0, ordentrabajo='$ordenTrabajo', estatusfecha='3', fechaenvio=null, 
       areaproduc=null, fechanotificacion=null, fechalevantamiento=null, foliogeo=null, 
       estatusfechater=3, fechatermino=null, superficie=null, fecha_actualizacion = '$fecha_actual' 
        WHERE id = $folioRegistro;"; 
        pg_query($c, $sql2);

        
      echo "1";

  }else if ($sn == 102 || $sn == "102") { //sin registro - insert

      $sql = "INSERT INTO procesodos(id, folio, ordentrabajo, estatusfecha, fechaenvio, areaproduc, 
            fechanotificacion, fechalevantamiento, foliogeo, estatusfechater, 
            fechatermino, fecharecepcionccc) VALUES ($folioRegistro, $folioRegistro, '$ordenTrabajo', '2', null, null, null, null, null, '2', null, null);";  
      
      pg_query($c, $sql);
      $sqll = "UPDATE registros SET proceso=1 WHERE id = $folioRegistro;"; 
      pg_query($c, $sqll); 

      $sql2 = "UPDATE historico SET proceso=1, ordentrabajo='$ordenTrabajo', estatusfecha='2', fechaenvio=null, 
       areaproduc=null, fechanotificacion=null, fechalevantamiento=null, foliogeo=null, 
       estatusfechater=2, fechatermino=null, superficie=null, fecha_actualizacion = '$fecha_actual' 
        WHERE id = $folioRegistro;"; 
        pg_query($c, $sql2);
        
      echo "1";

  }else if($sn == 20 || $sn == "20"){ // con registro - update

      $sql = "UPDATE procesodos SET ordentrabajo='$ordenTrabajo', estatusfecha='3', fechaenvio=null, 
       areaproduc=null, fechanotificacion=null, fechalevantamiento=null, foliogeo=null, 
       estatusfechater=2, fechatermino=null, superficie=null
        WHERE id = $folioRegistro and folio=$folioRegistro;"; 
        pg_query($c, $sql);

      $sqll = "UPDATE registros SET proceso=1 WHERE id = $folioRegistro;"; 
      pg_query($c, $sqll); 

       $sql2 = "UPDATE historico SET proceso=1, ordentrabajo='$ordenTrabajo', estatusfecha='3', fechaenvio=null, 
       areaproduc=null, fechanotificacion=null, fechalevantamiento=null, foliogeo=null, 
       estatusfechater=2, fechatermino=null, superficie=null, fecha_actualizacion = '$fecha_actual' 
        WHERE id = $folioRegistro;"; 
        pg_query($c, $sql2);
        
      echo "1";

  }

}


public function terminarProcesoDosSerTer($c,$idRegistro,$ordenTrabajo,$estatusfechaEnvio,$fechaEnvio,$areaProductora,$fechaNotificacion,$fechaLevantamiento,$folioGeo,$estatusFechaTermino,$fechaTermino,$superficie,$sn){



  if ($fechaEnvio == 0) {
    $fechaEnvio = "1999-01-01";
  }

  if ($fechaNotificacion == 0) {
    $fechaNotificacion = "1999-01-01";
  }

  if ($fechaLevantamiento == 0) {
    $fechaLevantamiento = "1999-01-01";
  }

  if ($fechaTermino == 0) {
    $fechaTermino = "1999-01-01";
  }

          $fecha_actual = date("Y-m-d H:i:s");

      if ($sn == 100 || $sn == "100") {

         $sql = "INSERT INTO procesodos(id, folio, ordentrabajo, estatusfecha, fechaenvio, areaproduc, 
            fechanotificacion, fechalevantamiento, foliogeo, estatusfechater, 
            fechatermino, fecharecepcionccc) VALUES ($folioRegistro, $folioRegistro, '$ordenTrabajo', '$estatusfechaEnvio', '$fechaEnvio', '$areaProductora', '$fechaNotificacion', '$fechaLevantamiento', '$folioGeo', 3, null, null);";  
    
  
      pg_query($c, $sql);


       $sqll = "UPDATE registros SET proceso=0 WHERE id = $idRegistro;"; 
        pg_query($c, $sqll); 

         $sql2 = "UPDATE historico SET proceso=1, ordentrabajo='$ordenTrabajo', estatusfecha='$estatusfechaEnvio', fechaenvio='$fechaEnvio', 
       areaproduc='$areaProductora', fechanotificacion='$fechaNotificacion', fechalevantamiento='$fechaLevantamiento', foliogeo='$folioGeo', 
       estatusfechater='3', fechatermino=null, superficie=null, fecha_actualizacion = '$fecha_actual' 
        WHERE id = $idRegistro;"; 
        pg_query($c, $sql2);

        echo "1";

        
      }else{

         $sql = "UPDATE procesodos SET ordentrabajo='$ordenTrabajo', estatusfecha='$estatusfechaEnvio', fechaenvio='$fechaEnvio', 
       areaproduc='$areaProductora', fechanotificacion='$fechaNotificacion', fechalevantamiento='$fechaLevantamiento', foliogeo='$folioGeo', 
       estatusfechater='$estatusFechaTermino', fechatermino=null, superficie=null
        WHERE id = $idRegistro and folio=$idRegistro;"; 
        pg_query($c, $sql);

        $sqll = "UPDATE registros SET proceso=0 WHERE id = $idRegistro;"; 
        pg_query($c, $sqll); 


         $sql2 = "UPDATE historico SET proceso=1, ordentrabajo='$ordenTrabajo', estatusfecha='$estatusfechaEnvio', fechaenvio='$fechaEnvio', 
       areaproduc='$areaProductora', fechanotificacion='$fechaNotificacion', fechalevantamiento='$fechaLevantamiento', foliogeo='$folioGeo', 
       estatusfechater='$estatusFechaTermino', fechatermino=null, superficie=null, fecha_actualizacion = '$fecha_actual' 
        WHERE id = $idRegistro and folio=$idRegistro;"; 
        pg_query($c, $sql2);


    echo "1";


      }
}

public function detalleDeEtapas($c,$proceso,$fup,$id){

  if ($proceso == 1) {

    $query = "select * from registros where fup='$fup' and id=$id;"; 

    $result = pg_query($query) or die('La consulta fallo: ' . pg_last_error());
   
    $rs = pg_query($c, $query);
    $validate_exixts = pg_num_rows($rs);
    if( $validate_exixts == "1" ){
      while( $obj = pg_fetch_object($rs) ){
        $data[] = $obj;
        
      }

       pg_free_result($result);
  // Cerrando la conexiÃ³n
  pg_close($c);
  header('Content-type: application/json');
  print_r(json_encode($data));


    }else{
      echo "100"; 
      }

    
  }else if ($proceso == 2) {

    $query = "select * from procesodos where folio=$id;"; 

    $result = pg_query($query) or die('La consulta fallo: ' . pg_last_error());
   
    $rs = pg_query($c, $query);
    $validate_exixts = pg_num_rows($rs);
    if( $validate_exixts == "1" ){
      while( $obj = pg_fetch_object($rs) ){
        $data[] = $obj;
        
      }

       pg_free_result($result);
  // Cerrando la conexiÃ³n
  pg_close($c);
  header('Content-type: application/json');
  print_r(json_encode($data));


    }else{
      echo "100"; 
      }
    
  }else if ($proceso == 3) {

     $query = "select * from procesotres where fol=$id;"; 

    $result = pg_query($query) or die('La consulta fallo: ' . pg_last_error());
   
    $rs = pg_query($c, $query);
    $validate_exixts = pg_num_rows($rs);
    if( $validate_exixts == "1" ){
      while( $obj = pg_fetch_object($rs) ){
        $data[] = $obj;
        
      }

       pg_free_result($result);
  // Cerrando la conexiÃ³n
  pg_close($c);
  header('Content-type: application/json');
  print_r(json_encode($data));


    }else{
      echo "100"; 
      }

    
  }else if ($proceso == 4) {

    $query = "select * from procesocuatro where fol=$id;"; 

    $result = pg_query($query) or die('La consulta fallo: ' . pg_last_error());
   
    $rs = pg_query($c, $query);
    $validate_exixts = pg_num_rows($rs);
    if( $validate_exixts == "1" ){
      while( $obj = pg_fetch_object($rs) ){
        $data[] = $obj;
        
      }

       pg_free_result($result);
  // Cerrando la conexiÃ³n
  pg_close($c);
  header('Content-type: application/json');
  print_r(json_encode($data));


    }else{
      echo "100"; 
      }
    
  }else if ($proceso == 0) {

    $query = "select * from registros as r 
              join procesodos as d 
              on r.id = d.folio 
              where fup='$fup' and r.id=$id;"; 

    $result = pg_query($query) or die('La consulta fallo: ' . pg_last_error());
   
    $rs = pg_query($c, $query);
    $validate_exixts = pg_num_rows($rs);
    if( $validate_exixts == "1" ){
      while( $obj = pg_fetch_object($rs) ){
        $data[] = $obj;
        
      }

       pg_free_result($result);
  // Cerrando la conexiÃ³n
  pg_close($c);
  header('Content-type: application/json');
  print_r(json_encode($data));


    }else{
      echo "100"; 
      }

    
  }

}
public function listadoMunicipios($c){

    $query = "select num, municipio from municipios order by municipio asc;;"; 
    $result = pg_query($query) or die('La consulta fallo: ' . pg_last_error());
   
    $rs = pg_query($c, $query);
    $validate_exixts = pg_num_rows($rs);
    if( $validate_exixts >"1" ){
      while( $obj = pg_fetch_object($rs) ){
        $data[] = $obj;
        
      }
       pg_free_result($result);
  pg_close($c);
  header('Content-type: application/json');
  print_r(json_encode($data));


    }else{
      echo "100"; 
      }

}

public function calcularAnticipo($c,$supInicial){ 

  if ($supInicial >= 1 && $supInicial <= 2500) {
      $rango = 1;
  }


  if ($supInicial >= 2501 && $supInicial <= 5000) {
      $rango = 2;
  }

  if ($supInicial >= 5001 && $supInicial <= 20000) {
      $rango = 3;
  }

  if ($supInicial >= 20001 && $supInicial <= 100000) {
      $rango = 4;
  }

  if ($supInicial >= 100001) {
      $rango = 5;
  }


   $query = "select * from factoresaplicables where rango=$rango;";

   $result = pg_query($query) or die('La consulta fallo: ' . pg_last_error());

   
    $rs = pg_query($c, $query);
    $validate_exixts = pg_num_rows($rs);
    if( $validate_exixts == "1" ){
      while( $obj = pg_fetch_object($rs) ){
        $data[] = $obj;
        
      }

       pg_free_result($result);
  // Cerrando la conexiÃ³n
  pg_close($c);
  header('Content-type: application/json');
  print_r(json_encode($data));
    }else{
      echo "100"; 
      }
}
public function cancelarlevantamientoFecha($c,$fechaCancelacion,$proces,$fup){ 

    $sql = "UPDATE registros SET fechacancelacion='$fechaCancelacion', cancelado=$proces WHERE proceso =$proces and fup='$fup';"; 
    pg_query($c, $sql);
    $sql2 = "UPDATE historico SET fechacancelacion='$fechaCancelacion', cancelado=$proces WHERE proceso =$proces and fup='$fup';"; 
    pg_query($c, $sql2);

    echo $proces; 
    
}

public function fechaNotificacionColindantes($c,$fechaNotificacion,$idRegistroDos,$fup){

    $sql = "UPDATE procesodos SET fechanotificacion='$fechaNotificacion' WHERE folio =$idRegistroDos;"; 
    pg_query($c, $sql);

    $sqll = "UPDATE registros SET proceso=3 WHERE fup ='$fup';"; 
    pg_query($c, $sqll);

    echo "1";


}

public function fechaEnvioDirGeografia($c,$fechaEnvioDirGeogra,$idRegistroDos,$fup){

    $sql = "UPDATE procesodos SET fechatermino='$fechaEnvioDirGeogra' WHERE folio =$idRegistroDos;"; 
    pg_query($c, $sql);

    $sqll = "UPDATE registros SET proceso=5 WHERE fup ='$fup';"; 
    pg_query($c, $sqll);

    echo "1";


}

public function fechaRecepcionCCC($c,$fechaRecepcionDSIccc,$idRegistroDos,$fup){

    $sql = "UPDATE procesodos SET fecharecepcionccc='$fechaRecepcionDSIccc' WHERE folio =$idRegistroDos;"; 
    pg_query($c, $sql);
 
    $sqll = "UPDATE registros SET proceso=6 WHERE fup ='$fup';"; 
    pg_query($c, $sqll);

    echo "1";


}

public function calcularDiferencia($c,$folioGnral){

    $query = "select * from registros where fup='$folioGnral';";  
    $result = pg_query($query) or die('La consulta fallo: ' . pg_last_error());
    // Imprimiendo los resultados aarray
    $rs = pg_query( $c, $query );
    $validate_exixts = pg_num_rows($rs);
    if( $validate_exixts == "1" ){
      while( $obj = pg_fetch_object($rs) ){
        $data[] = $obj;
        
      }

  pg_free_result($result);
  pg_close($c);
  header('Content-type: application/json');
  print_r(json_encode($data)); 
 //echo json_encode($data);
  }else{
      echo "100"; 
      }
}
public function actualizarProcesoSiete($c,$fechaEntregaDelegacion3,$superficieResultante,$costoTotal,$diferencias,$diDeRe,$foliodiDeRe,$idFolioSiete,$obs_proceso6){
  //saber si ya esta registrado para poder actualizar y si no solo hacer el insert 
  $query = "select * from procesotres where fol=$idFolioSiete;";  
    $result = pg_query($query) or die('La consulta fallo: ' . pg_last_error());
    
    $rs = pg_query( $c, $query );
    $validate_exixts = pg_num_rows($rs);
    if( $validate_exixts == "1" ){
         //registro ya existente

      $sql = "UPDATE procesotres SET costototal = '$costoTotal', fechanotientrega = '$fechaEntregaDelegacion3', 
      diferencia = '$diferencias', recibofup = '$foliodiDeRe', superficieresultante = '$superficieResultante',
      tipooficio = $diDeRe , obs_proceso6= '$obs_proceso6' WHERE fol =$idFolioSiete;"; 
      pg_query($c, $sql);

      echo "100";


      }else{
         //sin registro
        $sql = "INSERT INTO procesotres(id, fol, costototal, fechanotientrega, fechaentregasol, diferencia, recibofup, superficieresultante, tipooficio, obs_proceso6)
          VALUES ($idFolioSiete, $idFolioSiete, '$costoTotal', '$fechaEntregaDelegacion3', null, '$diferencias', '$foliodiDeRe', '$superficieResultante', $diDeRe, '$obs_proceso6' );";  

      pg_query($c, $sql);
       echo "100";

      }

} 

public function infoProcesoTres($c,$idFolioSiete){

    $query = "select * from procesotres where fol=$idFolioSiete;";  
    $result = pg_query($query) or die('La consulta fallo: ' . pg_last_error());
    // Imprimiendo los resultados aarray
    $rs = pg_query( $c, $query );
    $validate_exixts = pg_num_rows($rs);
    if( $validate_exixts == "1" ){
      while( $obj = pg_fetch_object($rs) ){
        $data[] = $obj;
        
      }

  pg_free_result($result);
  pg_close($c);
  header('Content-type: application/json');
  print_r(json_encode($data)); 
 //echo json_encode($data);
  }else{
      echo "100"; 
      }
}

public function terminarProcesoSiete($c,$fechaEntregaDelegacion3,$superficieResultante,$costoTotal,$diferencias,$diDeRe,$foliodiDeRe,$idFolioSiete, $obs_proceso6){
  //saber si ya esta registrado para poder actualizar y si no solo hacer el insert 
  $query = "select * from procesotres where fol=$idFolioSiete;";  
    $result = pg_query($query) or die('La consulta fallo: ' . pg_last_error());
    
    $rs = pg_query( $c, $query );
    $validate_exixts = pg_num_rows($rs);
    if( $validate_exixts == "1" ){
         //registro ya existente

      $sql = "UPDATE procesotres SET costototal = '$costoTotal', fechanotientrega = '$fechaEntregaDelegacion3', 
      diferencia = '$diferencias', recibofup = '$foliodiDeRe', superficieresultante = '$superficieResultante',
      tipooficio = $diDeRe, obs_proceso6='$obs_proceso6'  WHERE fol =$idFolioSiete;"; 
      pg_query($c, $sql);

      $sql2 = "UPDATE registros SET proceso = 7  WHERE id =$idFolioSiete;"; 
      pg_query($c, $sql2);

      echo "100";




      }else{
         //sin registro
        $sql = "INSERT INTO procesotres(id, fol, costototal, fechanotientrega, fechaentregasol, diferencia, recibofup, superficieresultante, tipooficio, fechanotificacionconcluido, obs_proceso6)
          VALUES ($idFolioSiete, $idFolioSiete, '$costoTotal', '$fechaEntregaDelegacion3', null, '$diferencias', '$foliodiDeRe', '$superficieResultante', $diDeRe, null, '$obs_proceso6');";  

      pg_query($c, $sql);

      $sql2 = "UPDATE registros SET proceso = 7  WHERE id =$idFolioSiete;"; 
      pg_query($c, $sql2);


       echo "100";

      }

      $sql3 = "UPDATE historico SET proceso = 7, costototal = '$costoTotal', fechanotientrega = '$fechaEntregaDelegacion3', 
      diferencia = '$diferencias', recibofup = '$foliodiDeRe' WHERE id =$idFolioSiete;"; 
      pg_query($c, $sql3);



} 

public function actualizarProcesoOcho($c,$fechaNotiConcluido3,$fechaEntregaSolicitante3,$idRegistroUnico, $observaciones_entrega){
  //saber si ya esta registrado para poder actualizar y si no solo hacer el insert 
  $query = "select * from procesotres where fol=$idRegistroUnico;";  
    $result = pg_query($query) or die('La consulta fallo: ' . pg_last_error());
    
    $rs = pg_query( $c, $query );
    $validate_exixts = pg_num_rows($rs);
    if( $validate_exixts == "1" ){ 
         //registro ya existente

      $sql = "UPDATE procesotres SET fechanotificacionconcluido = '$fechaNotiConcluido3', fechaentregasol = '$fechaEntregaSolicitante3', observaciones_entrega_cliente='$observaciones_entrega'  WHERE fol =$idRegistroUnico;"; 
      pg_query($c, $sql);
      echo "100";

      }else{
         //sin registro, no paso un proceso anterior
       echo "10";

      }

} 

public function terminarProcesoOcho($c,$fechaNotiConcluido3,$fechaEntregaSolicitante3,$idRegistroUnico, $observaciones_entrega){
  //saber si ya esta registrado para poder actualizar y si no solo hacer el insert 
    $query = "select * from procesotres where fol=$idRegistroUnico;";  
    $result = pg_query($query) or die('La consulta fallo: ' . pg_last_error());
    
    $rs = pg_query( $c, $query );
    $validate_exixts = pg_num_rows($rs);
    if( $validate_exixts == "1" ){ 
      //registro ya existente
      $sql = "UPDATE procesotres SET fechanotificacionconcluido = '$fechaNotiConcluido3', fechaentregasol = '$fechaEntregaSolicitante3', observaciones_entrega_cliente='$observaciones_entrega'  WHERE fol =$idRegistroUnico;"; 
      pg_query($c, $sql);

      $sql2 = "UPDATE registros SET proceso = 8 WHERE id =$idRegistroUnico;"; 
      pg_query($c, $sql2);

      $sql3 = "UPDATE historico SET proceso = 8, fechaentregasol = '$fechaEntregaSolicitante3' WHERE id =$idRegistroUnico;"; 
      pg_query($c, $sql3);
      echo "100";

      }else{
      //sin registro, no paso un proceso anterior
      echo "10";
      }

}
public function actualizarProcesoCerrado($c,$fechaResguardo3,$oficioResguardoGeo,$observacionesC,$idRegistroUnico){
  //saber si ya esta registrado para poder actualizar y si no solo hacer el insert 
  $query = "select * from procesocuatro where fol=$idRegistroUnico;";  
    $result = pg_query($query) or die('La consulta fallo: ' . pg_last_error());
    
    $rs = pg_query( $c, $query );
    $validate_exixts = pg_num_rows($rs);
    if( $validate_exixts == "1" ){ 
         //registro ya existente

      $sql = "UPDATE procesocuatro SET folioderesguardo = '$oficioResguardoGeo', fechaderesguardo = '$fechaResguardo3', observaciones ='$observacionesC'  WHERE fol =$idRegistroUnico;"; 
      pg_query($c, $sql);
      echo "100";

      }else{
         //sin registro
        $sql = "INSERT INTO procesocuatro(id, fol, folioderesguardo, fechaderesguardo, observaciones) 
          VALUES ($idRegistroUnico, $idRegistroUnico, '$oficioResguardoGeo', '$fechaResguardo3', '$observacionesC');";  

      pg_query($c, $sql);

       echo "100";

      }

} 
public function mostrarProcesoCerrado($c,$idFolioOcho){

    $query = "select * from procesocuatro where fol=$idFolioOcho;";  
    $result = pg_query($query) or die('La consulta fallo: ' . pg_last_error());
    // Imprimiendo los resultados aarray
    $rs = pg_query( $c, $query );
    $validate_exixts = pg_num_rows($rs);
    if( $validate_exixts == "1" ){
      while( $obj = pg_fetch_object($rs) ){
        $data[] = $obj;
        
      }

  pg_free_result($result);
  pg_close($c);
  header('Content-type: application/json');
  print_r(json_encode($data)); 
 //echo json_encode($data);
  }else{
      echo "100"; 
      }
}
public function terminarProcesoCerrado($c,$fechaResguardo3,$oficioResguardoGeo,$observacionesC,$idRegistroUnico){
  //saber si ya esta registrado para poder actualizar y si no solo hacer el insert 
    $query = "select * from procesocuatro where fol=$idRegistroUnico;";  
    $result = pg_query($query) or die('La consulta fallo: ' . pg_last_error());
    
    $rs = pg_query( $c, $query );
    $validate_exixts = pg_num_rows($rs);
    if( $validate_exixts == "1" ){ 
      //registro ya existente
      $sql = "UPDATE procesocuatro SET folioderesguardo = '$oficioResguardoGeo', fechaderesguardo = '$fechaResguardo3', observaciones ='$observacionesC' WHERE fol =$idRegistroUnico;"; 
      pg_query($c, $sql);

      $sql2 = "UPDATE registros SET proceso = 9 WHERE id =$idRegistroUnico;"; 
      pg_query($c, $sql2);

      $sql3 = "UPDATE historico SET proceso = 9 WHERE id =$idRegistroUnico;";  
      pg_query($c, $sql3);
      echo "100";

      }else{
      //sin registro, 
         $sql = "INSERT INTO procesocuatro(id, fol, folioderesguardo, fechaderesguardo, observaciones) 
          VALUES ($idRegistroUnico, $idRegistroUnico, '$oficioResguardoGeo', '$fechaResguardo3', '$observacionesC');";  

      pg_query($c, $sql);

        $sql2 = "UPDATE registros SET proceso = 9 WHERE id =$idRegistroUnico;"; 
      pg_query($c, $sql2);

        $sql3 = "UPDATE historico SET proceso = 9 WHERE id =$idRegistroUnico;";  
      pg_query($c, $sql3); 

      echo "100";
      }

}

}
