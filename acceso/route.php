<?php

$Schlussel = isset($_POST['acceess']) ? $_POST['acceess']:"";

if(empty($Schlussel)){
     header('Location: ../index.php');
}else{
     include '../bd/conex.php';  
     include '../controller/ControllerPath.php';
     $erick= new Controllermaster();

     switch ($Schlussel) {
          case 108:
               echo json_encode($erick->get_info_procesotres($_REQUEST['fup']) );
          break;
          case 107:
               echo json_encode($erick->get_info_procesodos($_REQUEST['fup']) );
          break;
          case 106:
               echo json_encode($erick->get_registros($_REQUEST['fup']) );
               //echo json_encode('ERICK, aqui llega');
          break;
          case 105:
               echo json_encode($erick->get_info_enviadoDirGeo($_REQUEST['fup']) );
          break;

          case 104:
               echo json_encode($erick->get_registros_equipo2($_REQUEST['fup']) );
          break;

          case 103:
               echo json_encode($erick->get_registros_equipo($_REQUEST['fup']) );
          break;
     	
     	case 100:               
               echo json_encode($erick->login( $_POST['usa'], $_POST['pwd'] ) );
          break;

          case 99:          
               echo $erick->cerrar_sesion($coxx);
          break;

          case 98:
               $mun = isset($_POST['municip']) ? $_POST['municip']:"";
               echo $erick->nombre_municipio($mun);
          break;

          case 97:
               $c_muni = isset($_POST['c_muni']) ? $_POST['c_muni']:"";
               $c_zona = isset($_POST['c_zona']) ? $_POST['c_zona']:"";
               $c_manz = isset($_POST['c_manz']) ? $_POST['c_manz']:"";
               $c_lote = isset($_POST['c_lote']) ? $_POST['c_lote']:"";
               $c_edif = isset($_POST['c_edif']) ? $_POST['c_edif']:"";
               $c_dept = isset($_POST['c_dept']) ? $_POST['c_dept']:"";
               $solicitante = isset($_POST['solicitante']) ? $_POST['solicitante']:"";
               $municipio = isset($_POST['municipio']) ? $_POST['municipio']:"";
               $fechaRecepcion = isset($_POST['fechaRecepcion']) ? $_POST['fechaRecepcion']:"";
               $superficieIn = isset($_POST['superficieIn']) ? $_POST['superficieIn']:"";
               $anticipo = isset($_POST['anticipo']) ? $_POST['anticipo']:"";
               $abrev  = isset($_POST['abrev']) ? $_POST['abrev']:"";
               $iddelegacion = isset($_POST['iddelegacion']) ? $_POST['iddelegacion']:"";
               $apaterno = isset($_POST['apaterno']) ? $_POST['apaterno']:"";
               $amaterno = isset($_POST['amaterno']) ? $_POST['amaterno']:"";
               $fupAs = isset($_POST['fupAs']) ? $_POST['fupAs']:"";
               $propietario = isset($_POST['propietario']) ? $_POST['propietario']:"";
               $aPaternoPropietario = isset($_POST['aPaternoPropietario']) ? $_POST['aPaternoPropietario']:"";
               $aMaternoPropietario = isset($_POST['aMaternoPropietario']) ? $_POST['aMaternoPropietario']:"";
               
               echo json_encode( $erick->guardarInfoUno($c_muni,$c_zona,$c_manz,$c_lote,$c_edif,$c_dept,$solicitante,$apaterno,$amaterno,$municipio,$fechaRecepcion,$superficieIn,$anticipo,$abrev,$iddelegacion,$fupAs,$propietario,$aPaternoPropietario,$aMaternoPropietario) );
               //echo json_encode("100");
          break;

           case 96:  
               $fup_buscar = isset($_POST['fup_buscar']) ? $_POST['fup_buscar']:"";
               $iddelegacion = isset($_POST['iddelegacion']) ? $_POST['iddelegacion']:"";               
              
               echo json_encode( $erick->buscarFup($fup_buscar,$iddelegacion) );
               //+echo json_encode($fup_buscar);
          break;

          case 95:
                              
               $idRegistro = isset($_POST['folioRegistro']) ? $_POST['folioRegistro']:"";
               $ordenTrabajo = isset($_POST['ordenTrabajo']) ? $_POST['ordenTrabajo']:"";
               $estatusfechaEnvio = isset($_POST['estatusfechaEnvio']) ? $_POST['estatusfechaEnvio']:"";
               $fechaEnvio = isset($_POST['fechaEnvio']) ? $_POST['fechaEnvio']:"";
               $areaProductora = isset($_POST['areaProductora']) ? $_POST['areaProductora']:"";
              
               echo $erick->actualizarProcesoDos($coxx,$idRegistro,$ordenTrabajo,$estatusfechaEnvio,$fechaEnvio,$areaProductora);
          break;

          case 94:              
               $folioRegistro = isset($_POST['folioRegistro']) ? $_POST['folioRegistro']:"";
               echo $erick->buscaRegistroProceDos($coxx,$folioRegistro);
               //echo $folioRegistro;
          break;

          case 102:              
               $fup = isset($_POST['fup']) ? $_POST['fup']:"";

               echo $erick->buscaRegistroProceDos_fup($coxx,$fup);
          break;

           case 93:            
               $idRegistro = isset($_POST['folioRegistro']) ? $_POST['folioRegistro']:"";
               $ordenTrabajo = isset($_POST['ordenTrabajo']) ? $_POST['ordenTrabajo']:"";
               $estatusfechaEnvio = isset($_POST['estatusfechaEnvio']) ? $_POST['estatusfechaEnvio']:"";
               $fechaEnvio = isset($_POST['fechaEnvio']) ? $_POST['fechaEnvio']:"";
               $areaProductora = isset($_POST['areaProductora']) ? $_POST['areaProductora']:"";
              
               echo $erick->procesoDosActualizar($coxx,$idRegistro,$ordenTrabajo,$estatusfechaEnvio,$fechaEnvio,$areaProductora);
          break; 

          case 92:           
               $idRegistro = isset($_POST['folioRegistro']) ? $_POST['folioRegistro']:"";
               $ordenTrabajo = isset($_POST['ordenTrabajo']) ? $_POST['ordenTrabajo']:"";
               $estatusfechaEnvio = isset($_POST['estatusfechaEnvio']) ? $_POST['estatusfechaEnvio']:"";
               $fechaEnvio = isset($_POST['fechaEnvio']) ? $_POST['fechaEnvio']:"";
               $areaProductora = isset($_POST['areaProductora']) ? $_POST['areaProductora']:"";
               $fechaNotificacion = isset($_POST['fechaNotificacion']) ? $_POST['fechaNotificacion']:"";
               $fechaLevantamiento = isset($_POST['fechaLevantamiento']) ? $_POST['fechaLevantamiento']:"";
               $folioGeo = isset($_POST['folioGeo']) ? $_POST['folioGeo']:"";
               $estatusFechaTermino = isset($_POST['estatusFechaTermino']) ? $_POST['estatusFechaTermino']:"";
               $fechaTermino = isset($_POST['fechaTermino']) ? $_POST['fechaTermino']:"";
               $superficie = isset($_POST['superficie']) ? $_POST['superficie']:"";
               $sn = isset($_POST['sn']) ? $_POST['sn']:"";

               echo $erick->terminarProcesoDos($coxx,$idRegistro,$ordenTrabajo,$estatusfechaEnvio,$fechaEnvio,$areaProductora,$sn);

          break;
          case 91:              
               $folioRegistro = isset($_POST['folioRegistro3']) ? $_POST['folioRegistro3']:"";

               echo $erick->buscaRegistroProceTres($coxx,$folioRegistro);
          break;
          case 90:              
               $folioRegistro = isset($_POST['folioRegistro3']) ? $_POST['folioRegistro3']:"";
               $costoTT = isset($_POST['costoTT']) ? $_POST['costoTT']:"";
               $fechanotientrega = isset($_POST['fechanotientrega']) ? $_POST['fechanotientrega']:"";
               $fechaentregasolicitante = isset($_POST['fechaentregasolicitante']) ? $_POST['fechaentregasolicitante']:"";
               $diferencia = isset($_POST['diferencia']) ? $_POST['diferencia']:"";
               $reciboFUP = isset($_POST['reciboFUP']) ? $_POST['reciboFUP']:""; 

               echo $erick->actualizarProcesoTres($coxx,$folioRegistro,$costoTT,$fechanotientrega,$fechaentregasolicitante,$diferencia,$reciboFUP);
          break;
           case 89:               
               $folioRegistro = isset($_POST['folioRegistro3']) ? $_POST['folioRegistro3']:"";
               $costoTT = isset($_POST['costoTT']) ? $_POST['costoTT']:"";
               $fechanotientrega = isset($_POST['fechanotientrega']) ? $_POST['fechanotientrega']:"";
               $fechaentregasolicitante = isset($_POST['fechaentregasolicitante']) ? $_POST['fechaentregasolicitante']:"";
               $diferencia = isset($_POST['diferencia']) ? $_POST['diferencia']:"";
               $reciboFUP = isset($_POST['reciboFUP']) ? $_POST['reciboFUP']:""; 
                echo $erick->actualizarProcesoTres_up($coxx,$folioRegistro,$costoTT,$fechanotientrega,$fechaentregasolicitante,$diferencia,$reciboFUP);
          break;
          case 88:                         
               /*folioRegistro3:folioRegistro3,costoTT:costoTT,fechanotientrega:fechanotientrega,
                    fechaentregasolicitante:fechaentregasolicitante,diferencia:diferencia,reciboFUP:reciboFUP*/
               $idRegistro = isset($_POST['folioRegistro3']) ? $_POST['folioRegistro3']:"";
               $costoTT = isset($_POST['costoTT']) ? $_POST['costoTT']:"";
               $fechanotientrega = isset($_POST['fechanotientrega']) ? $_POST['fechanotientrega']:"";
               $fechaentregasolicitante = isset($_POST['fechaentregasolicitante']) ? $_POST['fechaentregasolicitante']:"";
               $diferencia = isset($_POST['diferencia']) ? $_POST['diferencia']:"";
               $reciboFUP = isset($_POST['reciboFUP']) ? $_POST['reciboFUP']:"";

               echo $erick->terminarProcesoTres($coxx,$idRegistro,$costoTT,$fechanotientrega,$fechaentregasolicitante,$diferencia,$reciboFUP);

          break;
          // case 87:              /////es lo mismo que el 94
          //      $folioRegistro = isset($_POST['folioRegistro4']) ? $_POST['folioRegistro4']:"";
               
          //      echo $erick->buscaRegistroProcesoCuatro($coxx,$folioRegistro);
          
          case 86:             
               $folioRegistro = isset($_POST['folioRegistro4']) ? $_POST['folioRegistro4']:"";
               $idConcluido = isset($_POST['idConcluido']) ? $_POST['idConcluido']:"";
               $fechaentregaGeo = isset($_POST['fechaentregaGeo']) ? $_POST['fechaentregaGeo']:"";
      
               echo $erick->actualizarProcesoCuatro($coxx,$folioRegistro,$idConcluido,$fechaentregaGeo);
          break;
          case 85:              
               $folioRegistro = isset($_POST['folioRegistro4']) ? $_POST['folioRegistro4']:"";
               $idConcluido = isset($_POST['idConcluido']) ? $_POST['idConcluido']:"";
               $fechaentregaGeo = isset($_POST['fechaentregaGeo']) ? $_POST['fechaentregaGeo']:"";

               echo $erick->actualizarProcesoCuatro_up($coxx,$folioRegistro,$idConcluido,$fechaentregaGeo);
          break;
          case 84:             
               $folioRegistro = isset($_POST['folioRegistro4']) ? $_POST['folioRegistro4']:"";
               $idConcluido = isset($_POST['idConcluido']) ? $_POST['idConcluido']:"";
               $fechaentregaGeo = isset($_POST['fechaentregaGeo']) ? $_POST['fechaentregaGeo']:"";

               echo $erick->terminarProcesoCuatro($coxx,$folioRegistro,$idConcluido,$fechaentregaGeo);
          break;
          case 83:              
               $id_us = isset($_POST['id_us']) ? $_POST['id_us']:"";

               echo $erick->listadoDelegacion($coxx,$id_us);
          break;
          case 82: 
               $folioRegistro = isset($_POST['folioRegistro']) ? $_POST['folioRegistro']:"";
               $ordenTrabajo  = isset($_POST['ordenTrabajo']) ? $_POST['ordenTrabajo']:"";
               $sn = isset($_POST['sn']) ? $_POST['sn']:"";

               echo $erick->cancelar_areaProductora($coxx,$folioRegistro,$ordenTrabajo,$sn);
          break;
          case 81:              
               $idRegistro = isset($_POST['folioRegistro']) ? $_POST['folioRegistro']:"";
               $ordenTrabajo = isset($_POST['ordenTrabajo']) ? $_POST['ordenTrabajo']:"";
               $estatusfechaEnvio = isset($_POST['estatusfechaEnvio']) ? $_POST['estatusfechaEnvio']:"";
               $fechaEnvio = isset($_POST['fechaEnvio']) ? $_POST['fechaEnvio']:"";
               $areaProductora = isset($_POST['areaProductora']) ? $_POST['areaProductora']:"";
               $fechaNotificacion = isset($_POST['fechaNotificacion']) ? $_POST['fechaNotificacion']:"";
               $fechaLevantamiento = isset($_POST['fechaLevantamiento']) ? $_POST['fechaLevantamiento']:"";
               $folioGeo = isset($_POST['folioGeo']) ? $_POST['folioGeo']:"";
               $estatusFechaTermino = isset($_POST['estatusFechaTermino']) ? $_POST['estatusFechaTermino']:"";
               $fechaTermino = isset($_POST['fechaTermino']) ? $_POST['fechaTermino']:"";
               $superficie = isset($_POST['superficie']) ? $_POST['superficie']:"";
               $sn = isset($_POST['sn']) ? $_POST['sn']:"";

               echo $erick->terminarProcesoDosSerTer($coxx,$idRegistro,$ordenTrabajo,$estatusfechaEnvio,$fechaEnvio,$areaProductora,$fechaNotificacion,$fechaLevantamiento,$folioGeo,$estatusFechaTermino,$fechaTermino,$superficie,$sn);

          break;
          case 80:           
               $proceso = isset($_POST['proceso']) ? $_POST['proceso']:"";
               $fup = isset($_POST['fup']) ? $_POST['fup']:"";
               $id = isset($_POST['id']) ? $_POST['id']:"";

               echo $erick->detalleDeEtapas($coxx,$proceso,$fup,$id);

          break;
          case 79: 
               echo $erick->listadoMunicipios();

          break;
          case 78:
               $supInicial = isset($_POST['supInicial']) ? $_POST['supInicial']:"";
               echo $erick->calcularAnticipo($coxx,$supInicial);               

          break;
          case 77:             
               //fechaCancelacion,proces
               $fechaCancelacion = isset($_POST['fechaCancelacion']) ? $_POST['fechaCancelacion']:"";
               $proces = isset($_POST['proces']) ? $_POST['proces']:"";
               $fup = isset($_POST['fup']) ? $_POST['fup']:"";               
             
               echo $erick->cancelarlevantamientoFecha($coxx,$fechaCancelacion,$proces,$fup);

          break;
          case 76:             
               //fechaCancelacion,proces
               $fechaNotificacion = isset($_POST['fechaNotificacion']) ? $_POST['fechaNotificacion']:"";
               $idRegistroDos = isset($_POST['idRegistroDos']) ? $_POST['idRegistroDos']:"";
               $fup = isset($_POST['fup']) ? $_POST['fup']:"";
               
               echo $erick->fechaNotificacionColindantes($coxx,$fechaNotificacion,$idRegistroDos,$fup);

          break;
          case 101:           
               $fechaNotificacion = isset($_POST['fechaNotificacion']) ? $_POST['fechaNotificacion']:"";
               $idRegistroDos = isset($_POST['idRegistroDos']) ? $_POST['idRegistroDos']:"";
               $fup = isset($_POST['fup']) ? $_POST['fup']:"";
               
               echo $erick->fechaNotificacionColindantes_2($coxx,$fechaNotificacion,$idRegistroDos,$fup);

          break;
          case 75:
               $fechaEnvioDirGeogra = isset($_POST['fechaEnvioDirGeogra']) ? $_POST['fechaEnvioDirGeogra']:"";
               $idRegistroDos = isset($_POST['idRegistroDos']) ? $_POST['idRegistroDos']:"";
               $fup = isset($_POST['fup']) ? $_POST['fup']:"";
               
               echo $erick->fechaEnvioDirGeografia($coxx,$fechaEnvioDirGeogra,$idRegistroDos,$fup);

          break;
          case 74:
               $fechaRecepcionDSIccc = isset($_POST['fechaRecepcionDSIccc']) ? $_POST['fechaRecepcionDSIccc']:"";
               $idRegistroDos = isset($_POST['idRegistroDos']) ? $_POST['idRegistroDos']:"";
               $fup = isset($_POST['fup']) ? $_POST['fup']:"";
               
               echo $erick->fechaRecepcionCCC($coxx,$fechaRecepcionDSIccc,$idRegistroDos,$fup);

          break;
          case 73:             
               $folioGnral = isset($_POST['folioGnral']) ? $_POST['folioGnral']:"";
               
               echo $erick->calcularDiferencia($coxx,$folioGnral);

          break;
          case 72:           
               $fechaEntregaDelegacion = isset($_POST['fechaEntregaDelegacion']) ? $_POST['fechaEntregaDelegacion']:"";
               $superficieResultante = isset($_POST['superficieResultante']) ? $_POST['superficieResultante']:"";
               $costoTotal = isset($_POST['costoTotal']) ? $_POST['costoTotal']:"";
               $diferencias = isset($_POST['diferencias']) ? $_POST['diferencias']:"";
               $diDeRe = isset($_POST['diDeRe']) ? $_POST['diDeRe']:"";
               $foliodiDeRe = isset($_POST['foliodiDeRe']) ? $_POST['foliodiDeRe']:"";
               $idFolioSiete = isset($_POST['idFolioSiete']) ? $_POST['idFolioSiete']:"";

               $obs_proceso6= isset($_POST['obs_proceso6']) ? $_POST['obs_proceso6']:"";

               echo $erick->actualizarProcesoSiete($coxx,$fechaEntregaDelegacion,$superficieResultante,$costoTotal,$diferencias,$diDeRe,$foliodiDeRe,$idFolioSiete, $obs_proceso6);

          break;
          case 71:              
               $idFolioSiete = isset($_POST['idFolioSiete']) ? $_POST['idFolioSiete']:"";
               
               echo $erick->infoProcesoTres($coxx,$idFolioSiete);

          break;
          case 70:            
               $fechaEntregaDelegacion = isset($_POST['fechaEntregaDelegacion']) ? $_POST['fechaEntregaDelegacion']:"";
               $superficieResultante = isset($_POST['superficieResultante']) ? $_POST['superficieResultante']:"";
               $costoTotal = isset($_POST['costoTotal']) ? $_POST['costoTotal']:"";
               $diferencias = isset($_POST['diferencias']) ? $_POST['diferencias']:"";
               $diDeRe = isset($_POST['diDeRe']) ? $_POST['diDeRe']:"";
               $foliodiDeRe = isset($_POST['foliodiDeRe']) ? $_POST['foliodiDeRe']:"";
               $idFolioSiete = isset($_POST['idFolioSiete']) ? $_POST['idFolioSiete']:"";

               $obs_proceso6= isset($_POST['obs_proceso6']) ? $_POST['obs_proceso6']:"";

               echo $erick->terminarProcesoSiete($coxx,$fechaEntregaDelegacion,$superficieResultante,$costoTotal,$diferencias,$diDeRe,$foliodiDeRe,$idFolioSiete, $obs_proceso6);

          break;
          case 69:             
               $fechaNotiConcluido = isset($_POST['fechaNotiConcluido']) ? $_POST['fechaNotiConcluido']:"";
               $fechaEntregaSolicitante = isset($_POST['fechaEntregaSolicitante']) ? $_POST['fechaEntregaSolicitante']:"";
               $idRegistroUnico = isset($_POST['idRegistroUnico']) ? $_POST['idRegistroUnico']:"";
               $observaciones_entrega=isset($_POST['observaciones_entrega']) ? $_POST['observaciones_entrega']:"";

               echo $erick->actualizarProcesoOcho($coxx,$fechaNotiConcluido,$fechaEntregaSolicitante,$idRegistroUnico, $observaciones_entrega);

          break;
          case 68:            
               $fechaNotiConcluido = isset($_POST['fechaNotiConcluido']) ? $_POST['fechaNotiConcluido']:"";
               $fechaEntregaSolicitante = isset($_POST['fechaEntregaSolicitante']) ? $_POST['fechaEntregaSolicitante']:"";
               $idRegistroUnico = isset($_POST['idRegistroUnico']) ? $_POST['idRegistroUnico']:"";
               $observaciones_entrega=isset($_POST['observaciones_entrega']) ? $_POST['observaciones_entrega']:"";

               echo $erick->terminarProcesoOcho($coxx,$fechaNotiConcluido,$fechaEntregaSolicitante,$idRegistroUnico, $observaciones_entrega);

          break;
          case 67:            
               $fechaResguardo3 = isset($_POST['fechaResguardo3']) ? $_POST['fechaResguardo3']:"";
               $oficioResguardoGeo = isset($_POST['oficioResguardoGeo']) ? $_POST['oficioResguardoGeo']:"";
               $observacionesC = isset($_POST['observacionesC']) ? $_POST['observacionesC']:"";
               $idRegistroUnico = isset($_POST['idRegistroUnico']) ? $_POST['idRegistroUnico']:""; 
               
               echo $erick->actualizarProcesoCerrado($coxx,$fechaResguardo3,$oficioResguardoGeo,$observacionesC,$idRegistroUnico);

          break;
          case 66:            
               $idFolioSiete = isset($_POST['idFolioSiete']) ? $_POST['idFolioSiete']:"";
               
               echo $erick->mostrarProcesoCerrado($coxx,$idFolioSiete);

          break;
          case 65:         
               $fechaResguardo = isset($_POST['fechaResguardo']) ? $_POST['fechaResguardo']:"";
               $oficioResguardoGeo = isset($_POST['oficioResguardoGeo']) ? $_POST['oficioResguardoGeo']:"";
               $observacionesC = isset($_POST['observacionesC']) ? $_POST['observacionesC']:"";
               $idRegistroUnico = isset($_POST['idRegistroUnico']) ? $_POST['idRegistroUnico']:"";
               
               echo $erick->terminarProcesoCerrado($coxx,$fechaResguardo,$oficioResguardoGeo,$observacionesC,$idRegistroUnico);

          break;
          case 64:          
               $idRegistro = isset($_POST['idRegistro']) ? $_POST['idRegistro']:"";
               
               echo $erick->mostrarDatosEtapaDos($coxx,$idRegistro);

          break; 
     }
}

?>