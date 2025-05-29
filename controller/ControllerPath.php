<?php
 
if (session_status() == PHP_SESSION_NONE) {session_start();}

date_default_timezone_set('America/Mexico_City');
setlocale(LC_TIME, 'spanish');

class Controllermaster {

  private $db;
        
  public function __construct() {
      require_once '../bd/db.php';
      $this->db= Conectar::conexion();
  }

  public function login( $user,$pass){
    //return $user;
    $sql = "select * from usuarios where usuario = ? AND passw = ? ;";
    $query=$this->db->prepare($sql);
    $query->execute([$user, $pass]);
    $result=$query->fetch(PDO::FETCH_OBJ);

    if($result!=null){
      $_SESSION["usuario"] = $user;
      $_SESSION['id_userAg']=$result->id;
      $_SESSION['abrev']=$result->abrev;
      $_SESSION['tipo_usr']=$result->tipoUsuario;
      ///////////////////AGREGAR aquí los campos nuevos en la base de datos 
      $_SESSION['admin']=$result->admin;
      $_SESSION['brigada']=$result->brigada;
      $_SESSION['username']=$result->username;
      $_SESSION['delegacion']=$result->delegacion;

      if ($result->tipoUsuario == 2) {
       return "delegaciones.php" ;
      }elseif ($result->tipoUsuario == 3) {
        return "geo.php";
      }else{
        return "admonIni.php";
      }
    }else{
      return "Error";
    }   
  }

  public function cerrar_sesion($c){

  	session_destroy();
  	//Redireccionamos a Inicio (al inicio de sesión)
  	//echo "https://levantamientostopograficos.edomex.gob.mx/index.php";
    echo "index.php";

  }

  public function get_registros($fup){
    $sql='select * from registros where activo is true and fup=? ;';
    // dualidad $sql='select a.fecha_recepcion, b.*
    //       from registros as a 
    //       join procesotres as b on b.fol=a.id
    // dualidad      where a.activo is true and a.fup=? ;';
    $query=$this->db->prepare($sql);
    $query->execute([ $fup ]);
    return $query->fetch(PDO::FETCH_OBJ);
  }

  public function get_registros_equipo($fup){
    $sql='select entrega_equipo from registros where fup=? and activo is true; ';
    //$sql='select salida_equipo from registros where fup=? and activo is true; ';
    $query=$this->db->prepare($sql);
    $query->execute([ $fup ]);
    return $query->fetch(PDO::FETCH_OBJ);
  }

  public function get_registros_equipo2($fup){
    //$sql='select entrega_equipo from registros where fup=? and activo is true; ';
    $sql='select salida_equipo from registros where fup=? and activo is true; ';
    $query=$this->db->prepare($sql);
    $query->execute([ $fup ]);
    return $query->fetch(PDO::FETCH_OBJ);
  }

  public function nombre_municipio($id_mun){ 
    $sql='select municipio from municipios where num=? ;';
    $query=$this->db->prepare($sql);
    $query->execute([$id_mun]);
    $result=$query->fetch(PDO::FETCH_OBJ);
    if($result!=null){
      return $result->municipio;
    }else{
      return "N/A";
    }
  }

  public function get_info_enviadoDirGeo($fup){
    $sql='select b.*
      from registros as a
      join procesodos as b on a.id=b.folio 
      where a.fup=? and a.activo is true ;';

    // dualidad $sql='select b.areaproduc, c.fecha_equipo_entrega
    //   from registros as a
    //   join procesodos as b on a.id=b.folio 
    //   join geo_lt as c on a.fup=c.fup
    // dualidad  where a.fup=? ';
    $query=$this->db->prepare($sql);
    $query->execute([$fup]);
    return $query->fetch(PDO::FETCH_OBJ);
  }

  	// $query = "select municipio from municipios where num='$id';";

   //  $result = pg_query($query) or die('La consulta fallo: ' . pg_last_error());
   //  // Imprimiendo los resultados aarray
   //  $rs = pg_query( $c, $query );
   //  $validate_exixts = pg_num_rows($rs);
   //  if( $validate_exixts == "1" ){
   //  	while( $obj = pg_fetch_object($rs) ){
   //      $data[] = $obj;
   //      echo $data[0]->municipio;
   //    }
   //  }else{
   //  	echo "N/A"; 
   //  }

  public function get_info_procesodos($fup){
    $sql='select b.*
      from registros as a
      join procesodos as b on a.id=b.folio 
      where a.fup=? and a.activo is true ;';
    $query=$this->db->prepare($sql);
    $query->execute([$fup]);
    return $query->fetch(PDO::FETCH_OBJ);
  }

  public function get_info_procesotres($fup){
    $sql='select b.*
      from registros as a
      join procesotres as b on a.id=b.fol 
      where a.fup=? and a.activo is true ;';
    $query=$this->db->prepare($sql);
    $query->execute([$fup]);
    return $query->fetch(PDO::FETCH_OBJ);
  }
   


  public function guardarInfoUno($c_muni,$c_zona,$c_manz,$c_lote,$c_edif,$c_dept,$solicitante,$apaterno,$amaterno,$municipio,$fechaRecepcion,$superficieIn,$anticipo,$abrev,$iddelegacion,$fupAs,$propietario,$aPaternoPropietario,$aMaternoPropietario){
  	//unir la clave catastral
  	$c_muni2 = str_pad($c_muni, 3, "0", STR_PAD_LEFT);
  	$c_zona2 = str_pad($c_zona, 2, "0", STR_PAD_LEFT);
  	$c_manz2 = str_pad($c_manz, 3, "0", STR_PAD_LEFT);
  	$c_lote2 = str_pad($c_lote, 2, "0", STR_PAD_LEFT);
  	$c_edif2 = str_pad($c_edif, 2, "0", STR_PAD_LEFT);
  	$c_dept2 = str_pad($c_dept, 4, "0", STR_PAD_LEFT);

  	$clavec = $c_muni2.$c_zona2.$c_manz2.$c_lote2.$c_edif2.$c_dept2;

  	//obtener ultimo numero serial de la base de datos POR DELEGACION PARA FORMAR EL fup
    //////////////////////////Obtener el ultimo id general////////////////////////////////////
    $sqlL='Select max(id) as id from registros;';
    $queryl=$this->db->prepare($sqlL);
    $queryl->execute();
    $qres=$queryl->fetch(PDO::FETCH_OBJ);

    $ulrimoFupL=0;
    if($qres!=null){
      $ultimoFupL=$qres->id;
    }
    $ultimoFupL++;

    // $queryL = "Select max(id) as id from registros;";
    // $resultL = pg_query($queryL) or die('La consulta fallo: ' . pg_last_error());
    // // Imprimiendo los resultados aarray
    // $rsL = pg_query( $c, $queryL );
    // $validate_exixtsL = pg_num_rows($rsL);
    // if( $validate_exixtsL == "1" ){
    //   while( $objL = pg_fetch_object($rsL) ){
    //     $dataL[] = $objL;
    //     $ultimoFupL= $dataL[0]->id;
    //   }
    // }else{
    //      $ultimoFupL=0; 
    // }

    // $ulrimoFup2L  = $ultimoFupL + 1;

  	//guardar en base de datos
    //$propietario,$aPaternoPropietario,$aMaternoPropietario

  	$sql = "INSERT INTO registros(id, clavec, municipio, solicitante, superficieInicial, anticipo, fup,fecha_recepcion, proceso, iddelegacion, apaterno, amaterno, propietario, apaternoprop, amaternoprop, fechacancelacion, cancelado) VALUES ($ultimoFupL, '$clavec', '$municipio', '$solicitante', '$superficieIn', '$anticipo', '$fupAs', '$fechaRecepcion', 1, $iddelegacion, '$apaterno', '$amaterno', '$propietario', '$aPaternoPropietario', '$aMaternoPropietario', null, 0);";
    $query=$this->db->prepare($sql);
    if( $query->execute() ){
      return $fupAs;
    }else{
      return '100';
    }

  	//pg_query($c, $sql);

    // $fecha_actual = date("Y-m-d H:i:s");
    // $sql2 = "INSERT INTO historico(id, clavec, municipio, solicitante, superficieinicial, anticipo, 
    //           fup, fecha_recepcion, proceso, iddelegacion, apaterno, amaterno, 
    //           ordentrabajo, estatusfecha, fechaenvio, areaproduc, fechanotificacion, 
    //           fechalevantamiento, foliogeo, estatusfechater, fechatermino, 
    //           superficie, costototal, fechanotientrega, fechaentregasol, diferencia, 
    //           recibofup, id_envioexpediente, fechaentregageografia, fecha_actualizacion, propietario, apaternoprop, amaternoprop, fechacancelacion, cancelado)
    //   VALUES ($ulrimoFup2L, '$clavec', '$municipio', '$solicitante', '$superficieIn', '$anticipo', '$fupAs', '$fechaRecepcion', 1, $iddelegacion, '$apaterno', '$amaterno', null, null, null, null, null,null,null,null,null,null,null,null,null,null,null,null,null,'$fecha_actual', '$propietario', '$aPaternoPropietario', '$aMaternoPropietario', null, 0);";
    // pg_query($c, $sql2);

  	//echo $fupAs;

  }

  public function buscarFup($fup_buscar,$iddelegacion){
    $sql='select * from registros where activo is true and fup=? and iddelegacion=? ;';
    $query=$this->db->prepare($sql);
    $query->execute([$fup_buscar, $iddelegacion]);
    $result=$query->fetch(PDO::FETCH_OBJ);
    if($result!=null){
      return $result;
    }else{
      return '100';
    }
  	//  $query = "select * from registros where activo is true and fup='$fup_buscar' and iddelegacion=$iddelegacion;"; 
    //  $result = pg_query($query) or die('La consulta fallo: ' . pg_last_error());
    //  // Imprimiendo los resultados aarray
    //  $rs = pg_query( $c, $query );
    //  $validate_exixts = pg_num_rows($rs);
    //  if( $validate_exixts == "1" ){
    //  	while( $obj = pg_fetch_object($rs) ){
    //      $data[] = $obj;        
    //    }
    //    pg_free_result($result);
    //    // Cerrando la conexiÃ³n
    //    pg_close($c);
    //    header('Content-type: application/json');
    //    print_r(json_encode($data));
    //    //echo json_encode($data);
    //  }else{
    // 	echo "100"; 
    //  }
  }

  public function buscaRegistroProceDos($c,$folioRegistro){
      $query = "select * from procesodos where folio='$folioRegistro' ;" ;
      $result = pg_query($query) or die('La consulta fallo: ' . pg_last_error());
     
      $rs = pg_query($c, $query);
      $validate_exixts = pg_num_rows($rs);
      if( $validate_exixts == "1" ){
        while( $obj = pg_fetch_object($rs) ){
          $data[] = $obj;        
        }

        pg_free_result($result);
        // Cerrando la conexión
        pg_close($c);
        header('Content-type: application/json');
        print_r(json_encode($data));

      }else{
        echo "100"; 
      } 

  }

  public function buscaRegistroProceDos_fup($c,$fup){

      $query = "select * from procesodos where folio=(select id from registros where fup='$fup' and activo is true) ;";
      //$query="select a.* ,(select especialista from geo_lt where fup='$fup')
              // from procesodos as a 
              // where a.folio=(select id from registros where fup='$fup' and activo is true)";

      // dualidad $query="select a.* ,(select concat(b.nombre,' ',b.apep, ' ', b.apem) as especialista from geo_lt as a join especialistas as b on CAST(a.especialista as INT)=b.id where a.fup='$fup')
      //         from procesodos as a 
      //         where a.folio=(select id from registros where fup='$fup' and activo is true)";

      $result = pg_query($query) or die('La consulta fallo: ' . pg_last_error());
     
      $rs = pg_query($c, $query);
      $validate_exixts = pg_num_rows($rs);
      if( $validate_exixts == "1" ){
        while( $obj = pg_fetch_object($rs) ){
          $data[] = $obj;        
        }

        pg_free_result($result);
        // Cerrando la conexión
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


    if ($sn == 10 || $sn == "10") {

      $sql = "INSERT INTO procesodos(id, folio, ordentrabajo, estatusfecha, fechaenvio, areaproduc, 
          fechanotificacion, fechalevantamiento, foliogeo, estatusfechater, 
          fechatermino, fecharecepcionccc) VALUES ($idRegistro, $idRegistro, '$ordenTrabajo', '$estatusfechaEnvio', '$fechaEnvio', '$areaProductora', null, null, null, null, null, null);";  

      pg_query($c, $sql);


      $sqll = "UPDATE registros SET proceso=2 WHERE id = $idRegistro;"; 
      pg_query($c, $sqll); 

      echo "1";
      
    }else{

      $sql = "UPDATE procesodos SET ordentrabajo='$ordenTrabajo', estatusfecha='$estatusfechaEnvio', fechaenvio='$fechaEnvio', areaproduc='$areaProductora' WHERE id = $idRegistro and folio=$idRegistro;";  
      pg_query($c, $sql);

      $sqll = "UPDATE registros SET proceso=2 WHERE id = $idRegistro;"; 
      pg_query($c, $sqll); 

      echo "1";
    }

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

  // public function buscaRegistroProcesoCuatro($c,$folioRegistro){///////es lo mismo que buscaRegistroProceDos

  //   $query = "select * from procesodos where folio=$folioRegistro;"; 

  //   $result = pg_query($query) or die('La consulta fallo: ' . pg_last_error());
   
  //   $rs = pg_query($c, $query);
  //   $validate_exixts = pg_num_rows($rs);
  //   if( $validate_exixts == "1" ){
  //     while( $obj = pg_fetch_object($rs) ){
  //       $data[] = $obj;        
  //     }

  //     pg_free_result($result);
  //     // Cerrando la conexiÃ³n
  //     pg_close($c);
  //     header('Content-type: application/json');
  //     print_r(json_encode($data));

  //   }else{
  //     echo "100"; 
  //   }

  // }

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

  public function terminarProcesoCuatro($c,$folioRegistro,$folio_geo,$fechaentregaGeo){

    if ($fechaentregaGeo == 0) { ////esto se supone que no debería aplicar, y por qué el 1999? -preguntar a eli-
      $fechaentregaGeo = "1999-01-01";
    }

    $sql = "UPDATE procesodos SET fechalevantamiento='$fechaentregaGeo', foliogeo='$folio_geo' WHERE folio=$folioRegistro;"; 
    pg_query($c, $sql);

    $sqll = "UPDATE registros SET proceso=4 WHERE id = $folioRegistro;"; 
    pg_query($c, $sqll); 

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
        
      echo "1";

    }else if($sn == 30 || $sn == "30"){ // con registro - update

      $sql = "UPDATE procesodos SET ordentrabajo='$ordenTrabajo', estatusfecha='3', fechaenvio=null, 
        areaproduc=null, fechanotificacion=null, fechalevantamiento=null, foliogeo=null, 
        estatusfechater=3, fechatermino=null, superficie=null
        WHERE id = $folioRegistro and folio=$folioRegistro;"; 
      pg_query($c, $sql);

      $sqll = "UPDATE registros SET proceso=0 WHERE id = $folioRegistro;"; 
      pg_query($c, $sqll); 
        
      echo "1";

    }else if ($sn == 102 || $sn == "102") { //sin registro - insert

      $sql = "INSERT INTO procesodos(id, folio, ordentrabajo, estatusfecha, fechaenvio, areaproduc, 
            fechanotificacion, fechalevantamiento, foliogeo, estatusfechater, 
            fechatermino, fecharecepcionccc) VALUES ($folioRegistro, $folioRegistro, '$ordenTrabajo', '2', null, null, null, null, null, '2', null, null);";  
      
      pg_query($c, $sql);
      $sqll = "UPDATE registros SET proceso=1 WHERE id = $folioRegistro;"; 
      pg_query($c, $sqll); 
        
      echo "1";

    }else if($sn == 20 || $sn == "20"){ // con registro - update

      $sql = "UPDATE procesodos SET ordentrabajo='$ordenTrabajo', estatusfecha='3', fechaenvio=null, 
        areaproduc=null, fechanotificacion=null, fechalevantamiento=null, foliogeo=null, 
        estatusfechater=2, fechatermino=null, superficie=null
        WHERE id = $folioRegistro and folio=$folioRegistro;"; 
      pg_query($c, $sql);

      $sqll = "UPDATE registros SET proceso=1 WHERE id = $folioRegistro;"; 
      pg_query($c, $sqll); 

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

    $query = "select num, municipio from municipios order by municipio asc;"; 
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

    $anio_tarifa=$_REQUEST['anio_tarifa'];

    $query = "select * from factoresaplicables where rango=$rango and anio=$anio_tarifa ";

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

      //$sql = "UPDATE registros SET fechacancelacion='$fechaCancelacion', cancelado=$proces WHERE proceso =$proces and fup='$fup';"; 

      ///se puede dar de baja el fup al momento de cancelarlo
      $sql = "UPDATE registros SET fechacancelacion='$fechaCancelacion', cancelado=$proces , activo=false WHERE proceso =$proces and fup='$fup';"; 
      pg_query($c, $sql);
      //echo $proces;    
      echo "100"; 
  }

  public function fechaNotificacionColindantes($c,$fechaNotificacion,$idRegistroDos,$fup){

      $sql = "UPDATE procesodos SET fechanotificacion='$fechaNotificacion' WHERE folio =$idRegistroDos;"; 
      pg_query($c, $sql);

      $sqll = "UPDATE registros SET proceso=3 WHERE fup ='$fup';"; 
      pg_query($c, $sqll);

      echo "1";
  }

  public function fechaNotificacionColindantes_2($c,$fechaNotificacion,$idRegistroDos,$fup){///solo para guardar la fecha, sin avanzar de etapa

      $sql = "UPDATE procesodos SET fechanotificacion='$fechaNotificacion' WHERE folio =$idRegistroDos;"; 
      pg_query($c, $sql);
      // $sqll = "UPDATE registros SET proceso=3 WHERE fup ='$fup';"; esto es solo para cuando se termina el proceso dos
      // pg_query($c, $sqll);
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

  // public function calcularDiferencia($c,$folioGnral){

  //   $query = "select * from registros where fup='$folioGnral';";  
  //   $result = pg_query($query) or die('La consulta fallo: ' . pg_last_error());
  //   // Imprimiendo los resultados aarray
  //   $rs = pg_query( $c, $query );
  //   $validate_exixts = pg_num_rows($rs);
  //   if( $validate_exixts == "1" ){
  //     while( $obj = pg_fetch_object($rs) ){
  //       $data[] = $obj;        
  //     }

  //     pg_free_result($result);
  //     pg_close($c);
  //     header('Content-type: application/json');
  //     print_r(json_encode($data)); 
  //    //echo json_encode($data);
  //   }else{
  //     echo "100"; 
  //   }
  // }

  public function calcularDiferencia($c,$folioGnral){

    $query = "select * from registros where activo is true and id='$folioGnral';";  
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
    //$result = pg_query($query) or die('La consulta fallo: ' . pg_last_error());    
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

  public function infoProcesoTres($c,$idfolio){

    $query = "select * from procesotres where fol=$idfolio;";  
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
    //$result = pg_query($query) or die('La consulta fallo: ' . pg_last_error());
    
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
    // $sql3 = "UPDATE historico SET proceso = 7, costototal = '$costoTotal', fechanotientrega = '$fechaEntregaDelegacion3', 
    // diferencia = '$diferencias', recibofup = '$foliodiDeRe' WHERE id =$idFolioSiete;"; 
    // pg_query($c, $sql3);
  } 

  public function actualizarProcesoOcho($c,$fechaNotiConcluido3,$fechaEntregaSolicitante3,$idRegistroUnico, $observaciones_entrega){
    //saber si ya esta registrado para poder actualizar y si no solo hacer el insert 
    $query = "select * from procesotres where fol=$idRegistroUnico;";  
    //$result = pg_query($query) or die('La consulta fallo: ' . pg_last_error());    
    $rs = pg_query( $c, $query );
    $validate_exixts = pg_num_rows($rs);
    if( $validate_exixts == "1" ){ 
      //registro ya existente

      ///se verifica si las fechas son null para no agregarlas al update
      if($fechaNotiConcluido3==null && $fechaEntregaSolicitante3==null){
        $sql = "UPDATE procesotres SET observaciones_entrega_cliente='$observaciones_entrega'  WHERE fol =$idRegistroUnico;"; 

      }elseif($fechaNotiConcluido3==null && $fechaEntregaSolicitante3!=null){
        $sql = "UPDATE procesotres SET fechaentregasol = '$fechaEntregaSolicitante3', observaciones_entrega_cliente='$observaciones_entrega'  WHERE fol =$idRegistroUnico;"; 

      }elseif($fechaNotiConcluido3!=null && $fechaEntregaSolicitante3==null){
        $sql = "UPDATE procesotres SET fechanotificacionconcluido = '$fechaNotiConcluido3', observaciones_entrega_cliente='$observaciones_entrega'  WHERE fol =$idRegistroUnico;";  

      }else{
        $sql = "UPDATE procesotres SET fechanotificacionconcluido = '$fechaNotiConcluido3', fechaentregasol = '$fechaEntregaSolicitante3', observaciones_entrega_cliente='$observaciones_entrega'  WHERE fol =$idRegistroUnico;"; 
      }

      //$sql = "UPDATE procesotres SET fechanotificacionconcluido = '$fechaNotiConcluido3', fechaentregasol = '$fechaEntregaSolicitante3', observaciones_entrega_cliente='$observaciones_entrega'  WHERE fol =$idRegistroUnico;"; 
      pg_query($c, $sql);
      echo "100";
    }
    // else{
    //   //sin registro, no paso un proceso anterior
    //   echo "10";
    // }
  } 

  public function terminarProcesoOcho($c,$fechaNotiConcluido3,$fechaEntregaSolicitante3,$idRegistroUnico, $observaciones_entrega){
    //saber si ya esta registrado para poder actualizar y si no solo hacer el insert 
    $query = "select * from procesotres where fol=$idRegistroUnico;";  
    //$result = pg_query($query) or die('La consulta fallo: ' . pg_last_error());
    
    $rs = pg_query( $c, $query );
    $validate_exixts = pg_num_rows($rs);
    if( $validate_exixts == "1" ){ 
      //registro ya existente
      $sql = "UPDATE procesotres SET fechanotificacionconcluido = '$fechaNotiConcluido3', fechaentregasol = '$fechaEntregaSolicitante3', observaciones_entrega_cliente='$observaciones_entrega'  WHERE fol =$idRegistroUnico;"; 
      pg_query($c, $sql);

      $sql2 = "UPDATE registros SET proceso = 8 WHERE id =$idRegistroUnico;"; 
      pg_query($c, $sql2);

      // $sql3 = "UPDATE historico SET proceso = 8, fechaentregasol = '$fechaEntregaSolicitante3' WHERE id =$idRegistroUnico;"; 
      // pg_query($c, $sql3);
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
    //$result = pg_query($query) or die('La consulta fallo: ' . pg_last_error());    
    $rs = pg_query( $c, $query );
    $validate_exixts = pg_num_rows($rs);
    if( $validate_exixts == "1" ){ 
      //registro ya existente
      $sql = "UPDATE procesocuatro SET folioderesguardo = '$oficioResguardoGeo', fechaderesguardo = '$fechaResguardo3', observaciones ='$observacionesC' WHERE fol =$idRegistroUnico;"; 
      pg_query($c, $sql);

      $sql2 = "UPDATE registros SET proceso = 9 WHERE id =$idRegistroUnico;"; 
      pg_query($c, $sql2);

      echo "100";

    }else{
      //sin registro, 
      $sql = "INSERT INTO procesocuatro(id, fol, folioderesguardo, fechaderesguardo, observaciones) 
          VALUES ($idRegistroUnico, $idRegistroUnico, '$oficioResguardoGeo', '$fechaResguardo3', '$observacionesC');";  

      pg_query($c, $sql);

      $sql2 = "UPDATE registros SET proceso = 9 WHERE id =$idRegistroUnico;"; 
      pg_query($c, $sql2);

      echo "100";
    }
  }

}