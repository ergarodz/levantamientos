<?php
    if (session_status() == PHP_SESSION_NONE) {session_start();}
    date_default_timezone_set('America/Mexico_City');
    setlocale(LC_TIME, 'spanish');
    
    $op=new Ops2();
    
    if(isset($_REQUEST['action'])){
        
        switch ($_REQUEST['action']) { 
        
            case 'delete_reg':
                $id=$_REQUEST['id'];
                echo json_encode($op->delete_reg($id) );                    
            break;

            case 'guardar_equipo_salida':                
                echo json_encode($op->guardar_equipo_salida() );
            break;                 

            case 'guardar_equipo_entrega':
                echo json_encode( $op->guardar_equipo_entrega() );
                //echo json_encode('Entra');
            break;

            case 'guardar_archivo_crudo':
                echo json_encode( $op->guardar_archivo_crudo() );
            break;


            case 'guardar_datos_correo':
                require_once 'Model/CorreoModel.php';
                $correo=new CorreoModel();
                echo json_encode( $correo->guardar_datos_correo() );
                //echo json_encode('Hola');
            break;

            case 'enviar_correo':
                require_once 'controller/emailController.php';
                $email=new EmailController();
                echo json_encode( $email->guardarDatos() );
                //echo json_encode(true);
            break;


            case 'get_equipo':
                echo json_encode($op->get_equipo($_REQUEST['inventario']) );
            break;


            case 'guardar_dia_lt':
                echo json_encode($op->guardar_dia_lt( $_REQUEST['fup'], $_REQUEST['fecha'] ) );
            break;

            case 'save_cambio_especialista':
                echo json_encode( $op->save_cambio_especialista( $_REQUEST['fup'], $_REQUEST['especialista'], $_REQUEST['motivo'] ) );
            break;

            case 'save_cambio_fecha_levantamiento':
                echo json_encode( $op->save_cambio_fecha_levantamiento( $_REQUEST['fup'], $_REQUEST['fecha'], $_REQUEST['motivo'], $_REQUEST['fecha_original'] ) );
            break;

            case 'cancelar_levantamiento_geo':
                echo json_encode( $op->cancelar_levantamiento_geo( $_REQUEST['fup'] ) );
            break;

        }
    }

    class Ops2{
        
        private $db;
        
        public function __construct() {
            require_once 'bd/db.php';
            $this->db= Conectar::conexion();
        }

        public function cancelar_levantamiento_geo($fup){
            $sql1='INSERT INTO cancelados_geo(fup, fecha_cancelado) VALUES (?, ?);';
            $query1=$this->db->prepare($sql1);
            $fecha_cancelado = date("Y-m-d H:i:s");
            if( $query1->execute([$fup, $fecha_cancelado]) ){

                //// hace el update en la tabla registro, va cancelado etapa 2
                $sql2='UPDATE registros SET cancelado=2, fechacancelacion=? WHERE fup=? and activo is true;';
                $query2=$this->db->prepare($sql2);
                if( $query2->execute([$fecha_cancelado, $fup]) ){
                    return true;
                }else{
                    return false;
                }
            }
        }

        public function is_levantamiento_cancelado($fup){
            $sql='select count(id) as tot from cancelados_geo where fup=?;';
            $query=$this->db->prepare($sql);
            $query->execute([$fup]);
            $total=$query->fetch(PDO::FETCH_OBJ)->tot;

            if($total>0){
                return true;///el levantamiento ya fue cancelado
            }else{
                return false;///el levantamiento no ha sido cancelado
            }
        }

        public function get_lt_cancelados_geo(){
            $sql='select * from cancelados_geo order by fecha_cancelado desc;';
            $query=$this->db->prepare($sql);
            $query->execute();
            return $query->fetchAll(PDO::FETCH_OBJ);
        }


        public function guardar_dia_lt($fup, $fecha){
            $sql1='select count(id) as tot from dias_agregados where fup=? ;';
            $query1=$this->db->prepare($sql1);
            $query1->execute([$fup]);
            $total=$query1->fetch(PDO::FETCH_OBJ)->tot;


            $fecha = date("Y-m-d H:i:s", strtotime($fecha));
            $sql='INSERT INTO dias_agregados(fup, num_dia, fecha_agregada) VALUES (?, ?, ?);';
            $query=$this->db->prepare($sql);
            if( $query->execute([ $fup, $total+1, $fecha ]) ){
                return true;
            }else{
                return false;
            }
        }

        public function get_dias_agregados($fup){
            $sql='select * from dias_agregados where fup=? order by num_dia asc;';
            $query=$this->db->prepare($sql);
            $query->execute([$fup]);
            return $query->fetchAll(PDO::FETCH_OBJ);
        }

        public function get_all_regs(){
            $sql='select a.* , b.usuario as nom_delegacion from registros as a 
                  join usuarios as b on a.iddelegacion=b.id
                  where a.activo is true and a.cancelado=0
                  order by a.iddelegacion, a.fup asc ;';
            $query=$this->db->prepare($sql);
            $query->execute();
            return $query->fetchAll(PDO::FETCH_OBJ);
        }

        public function get_all_regs_periodo($fecha_min, $fecha_max){
            $sql='select a.* , b.usuario as nom_delegacion from registros as a 
                  join usuarios as b on a.iddelegacion=b.id
                  where a.activo is true and a.cancelado=0
                  and a.fecha_recepcion >= ? and a.fecha_recepcion <= ? 
                  order by a.iddelegacion, a.fup desc ;';
            $query=$this->db->prepare($sql);
            $query->execute([ $fecha_min, $fecha_max ]);
            return $query->fetchAll(PDO::FETCH_OBJ);
        }

        public function get_regs_procesodos($id){
            $sql='select * from procesodos where folio=? ;';
            $query=$this->db->prepare($sql);
            $query->execute([$id]);
            return $query->fetch(PDO::FETCH_OBJ);
        }

        public function get_regs_procesodos_with_fup($fup){
            $sql='select * from procesodos where folio=(select id from registros where fup=? and activo is true and cancelado=0);';
            $query=$this->db->prepare($sql);
            $query->execute([$fup]);
            return $query->fetch(PDO::FETCH_OBJ);
        }

        public function get_regs_procesotres($id){
            $sql='select * from procesotres where fol=? ;';
            $query=$this->db->prepare($sql);
            $query->execute([$id]);
            return $query->fetch(PDO::FETCH_OBJ);
        }

        public function get_regs_procesocuatro($id){
            $sql='select * from procesocuatro where fol=? ;';
            $query=$this->db->prepare($sql);
            $query->execute([$id]);
            return $query->fetch(PDO::FETCH_OBJ);
        }

        public function get_all_regs_csv(){
            $sql='select a.*, b.usuario as nom_delegacion, c.*, d.*, e.* 
                  from registros as a 
                  join usuarios as b on a.iddelegacion=b.id
                  join procesodos as c on a.id=c.folio
                  join procesotres as d on d.fol=a.id
                  join procesocuatro as e on e.fol=a.id
                  where a.activo is true and a.cancelado=0 
                  order by a.iddelegacion, a.fup asc ;';
            $query=$this->db->prepare($sql);
            $query->execute();
            return $query->fetchAll(PDO::FETCH_OBJ);
        }

        public function delete_reg($id){

            ////en lugar de borrar el registro de la tabla, cambiamos el estatus del campo activo(true) a false
            $sqlup='UPDATE registros SET activo=false WHERE id=? ;';
            $queryup=$this->db->prepare($sqlup);
            if($queryup->execute([$id]) ){
                return true;
            }else{
                return false;
            }
        }

        public function get_regs_proceso_salida(){///regresa los registros en proceso 3, son los que aparecen para geografía
            // $sql='select a.*, b.* from registros as a
            //     join procesodos as b on a.id=b.folio
            //     where a.proceso=3 and a.activo is true';
            $deleg=$_SESSION['delegacion'];
            //if($_SESSION['brigada']){ $brigada='Brigada'; }else{ $brigada='Geografia'; }


            $sql="select a.*,b.areaproduc, b.fechaenvio from registros as a join procesodos as b on a.id=b.folio where a.proceso=2 and a.activo is true and cancelado=0 and salida_equipo is false 
                order by fechaenvio desc; ";
            
            if($deleg!=0){
                $sql='select a.*,b.areaproduc, b.fechaenvio from registros as a  join procesodos as b on a.id=b.folio 
                where a.proceso=2 and a.activo is true and cancelado=0 and salida_equipo is false and iddelegacion='.$deleg.' order by fechaenvio desc; ';   
            }

            $query=$this->db->prepare($sql); 
            $query->execute();
            return $query->fetchAll(PDO::FETCH_OBJ);
            //return $sql;
        }

        public function get_regs_proceso_regreso(){
            // $sql='select a.* from registros as a
            //     where a.proceso=2 and a.activo is true and salida_equipo is true and entrega_equipo is false order by fecha_recepcion desc;';
            $sql='select a.*,b.areaproduc from registros as a join procesodos as b on a.id=b.folio 
                where a.proceso=3 and cancelado=0 and a.activo is true and salida_equipo is true and entrega_equipo is false order by fecha_recepcion desc;';

            $deleg=$_SESSION['delegacion'];
            if($deleg!=0){
                $sql='select a.*,b.areaproduc from registros as a join procesodos as b on a.id=b.folio 
                where a.proceso=3 and cancelado=0 and a.activo is true and salida_equipo is true and entrega_equipo is false and iddelegacion='.$deleg.' order by fecha_recepcion desc;'; 
            }

            $query=$this->db->prepare($sql); 
            $query->execute();
            return $query->fetchAll(PDO::FETCH_OBJ);
        }


        public function get_reg_proceso3($id){
            $sql='select a.*, b.* from registros as a
                join procesodos as b on a.id=b.folio
                where a.proceso=3 and a.activo is true and a.id=? ';
            $query=$this->db->prepare($sql);
            $query->execute([$id]);
            return $query->fetch(PDO::FETCH_OBJ);
        }

        public function get_registro($fup){
            $sql='select a.*, b.* from registros as a 
                join procesodos as b on a.id=b.folio
                where a.fup=? and a.activo is true and a.cancelado=0 ;';
            $query=$this->db->prepare($sql);
            $query->execute([$fup]);
            return $query->fetch(PDO::FETCH_OBJ);
        }

        public function get_especialistas($id_del){
            $sql='select * from especialistas where id_del=? and activo is true';
            $query=$this->db->prepare($sql);
            $query->execute([ $id_del ]);
            return $query->fetchAll(PDO::FETCH_OBJ);
        }

        public function get_especialista_with_fup($fup){
            $sql='select a.especialista, b.nombre, b.apep, b.apem
                from geo_lt as a
                join especialistas as b on CAST(a.especialista as integer) =b.id
                where a.fup=? ;';
            $query=$this->db->prepare($sql);
            $query->execute([$fup]);
            return $query->fetch(PDO::FETCH_OBJ);
        }

        public function save_cambio_especialista($fup, $id_especialista, $motivo){
            $sql1='select count(id) as tot from cambio_especialista where fup=? ;';
            $query1=$this->db->prepare($sql1);
            $query1->execute([$fup]);
            $total=$query1->fetch(PDO::FETCH_OBJ)->tot;

            $sql='INSERT INTO cambio_especialista(fup, especialista_nuevo, num_especialista, motivo, fecha_cambio) VALUES (?, ?, ?, ?, ?) ;';
            $query=$this->db->prepare($sql);
            if( $query->execute([ $fup, $id_especialista, $total+1, $motivo, date('Y-m-d H:i:s') ]) ){
                return true;
            }else{
                return false;
            }
        }

        public function save_cambio_fecha_levantamiento($fup, $fecha, $motivo, $fecha_original){
            $sql1='select count(id) as tot from cambio_fecha_levantamiento where fup=? ;';
            $query1=$this->db->prepare($sql1);
            $query1->execute([$fup]);
            $total=$query1->fetch(PDO::FETCH_OBJ)->tot;
            if($total==0){///si es la primera vez que se cambia la fecha de levantamiento, se guarda la primera fecha 
                $sql="INSERT INTO cambio_fecha_levantamiento(fup, fecha_nueva, num_fecha, motivo, fecha_cambio) VALUES (?, ?, ?, ?, ?) ;";
                $query=$this->db->prepare($sql);
                $query->execute([ $fup, $fecha_original, $total, '', date('Y-m-d H:i:s') ]);
            }
            

            $sql='INSERT INTO cambio_fecha_levantamiento(fup, fecha_nueva, num_fecha, motivo, fecha_cambio) VALUES (?, ?, ?, ?, ?) ;';
            $query=$this->db->prepare($sql);
            if( $query->execute([ $fup, $fecha, $total+1, $motivo, date('Y-m-d H:i:s') ]) ){

                ////se actualiza la tabla procesodos cada que se cambie el día, para que los reportes coincidan
                $sql2='UPDATE procesodos  SET fechalevantamiento=? WHERE folio in ( SELECT id from registros where activo is true and cancelado=0 and fup=? );';
                $query2=$this->db->prepare($sql2);
                if( $query2->execute([ $fecha, $fup ]) ){
                    return true;
                }else{
                    return false;
                }
            }else{
                return false;
            }
        }

        public function get_regs_cambio_fecha_levantamiento($fup){
            $sql='select * from cambio_fecha_levantamiento where fup=? order by num_fecha asc;';
            $query=$this->db->prepare($sql);
            $query->execute([$fup]);
            return $query->fetchAll(PDO::FETCH_OBJ);
        }

        public function get_especialistas_cambiados($fup){
            $sql='select * from cambio_especialista as a join especialistas as b on a.especialista_nuevo=b.id where a.fup=? order by a.num_especialista asc;';
            $query=$this->db->prepare($sql);
            $query->execute([$fup]);
            return $query->fetchAll(PDO::FETCH_OBJ);
        }

        public function get_equipos($id_del){
            //$sql='select * from estaciones where id_del=? and activo is true order by id asc;';
            $sql='select * from estaciones where id_del=? order by id asc;';
            $query=$this->db->prepare($sql);
            $query->execute([ $id_del ]);
            return $query->fetchAll(PDO::FETCH_OBJ);
        }

        public function get_equipo($inventario){
            $sql='select * from estaciones where inventario=? ;';
            $query=$this->db->prepare($sql);
            $query->execute([$inventario]);
            return $query->fetch(PDO::FETCH_OBJ);
        }

        public function guardar_equipo_salida(){
            $fup=$_REQUEST['fup'];
            $fecha_lt=$_REQUEST['fecha_lt'];//////////////////este se va a la tabla procesodos
            //$hora_fecha_lt= date_7format( date_create($fecha_lt), 'H:i' );
            $hora_fecha_lt='00:00';

            //$fecha_notificacion=$_REQUEST['fecha_notificacion'];//////////////////este se va a la tabla procesodos

            $especialista=$_REQUEST['especialista'];
            $equipo=$_REQUEST['equipo'];
            $inventario=$_REQUEST['no_inventario'];

            $fecha_equipo_salida=$_REQUEST['fecha_equipo_salida'];
            $hora_equipo_salida=date_format( date_create($fecha_equipo_salida), 'H:i' );


            ///////guardamos los datos en la tabla geo_lt
            $sql='INSERT INTO geo_lt(fup, hora_prog_lt, especialista, equipo, inventario, hora_equipo_salida, fecha_equipo_salida ) VALUES (?, ?, ?, ?, ?, ?, ?);';
            $query=$this->db->prepare($sql);
            if( $query->execute([ $fup, $hora_fecha_lt, $especialista, $equipo, $inventario, $hora_equipo_salida, $fecha_equipo_salida ]) ){
                /////actualizamos los datos que correspondan en la tabla registros o procesodos
                $sql2='UPDATE procesodos SET fechalevantamiento=?  WHERE folio in(select id from registros where fup=? and activo is true and cancelado=0 );';
                //$sql2='UPDATE procesodos SET fechalevantamiento=?, fechanotificacion=?  WHERE folio in(select id from registros where fup=? and activo is true and cancelado=0 );';
                $query2=$this->db->prepare($sql2);
                if( $query2->execute( [$fecha_lt, $fup] ) ){
                //if( $query2->execute( [$fecha_lt, $fecha_notificacion, $fup] ) ){
                    ////actualizamos a true el campo boolean en registros
                    $sql3='UPDATE registros SET salida_equipo=true WHERE fup=? and activo is true and cancelado=0 ;';
                    $query3=$this->db->prepare($sql3);
                    if( $query3->execute([$fup]) ){

                        ///cambiamos el estado del equipo a false, porque ya se está ocupando
                        $sql4='update estaciones set activo=false where inventario=? ;';
                        $query4=$this->db->prepare($sql4);
                        if($query4->execute([$inventario]) ){
                            return true;
                        }else{
                            return false;
                        }
                    }else{
                        return false;
                    }
                }else{
                    return false;
                }

            }else{
                return false;
            }             
        }

        public function guardar_equipo_entrega(){
            $fup=$_REQUEST['fup'];
            $fecha_equipo_entrega=$_REQUEST['fecha_equipo_entrega'];
            $hora_equipo_entrega= date_format( date_create($fecha_equipo_entrega), 'H:i' );

            $obs_equipo_entrega=@$_REQUEST['obs_equipo_entrega'];
            //$folio_geo=$_REQUEST['folio_geo'];
            $folio_geo='GEO/'.$_REQUEST['folio_geo2'].'/'.$_REQUEST['folio_geo3'];
            $superficie_resultante=$_REQUEST['superficie_resultante'];
            
            $iscrudo=$_REQUEST['iscrudo'];
            
            $sql2='UPDATE geo_lt
                   SET hora_equipo_entrega=?, observaciones_equipo=?, folio_geo=?, archivo_crudo=?, superficie_resultante=?, fecha_equipo_entrega=?
                   WHERE fup=? ;';
            $query2=$this->db->prepare($sql2);
            if( $query2->execute([ $hora_equipo_entrega, $obs_equipo_entrega, $folio_geo, $iscrudo, $superficie_resultante, $fecha_equipo_entrega,  $fup ]) ){

                ////actualizamos el campo foliogeo de la tabla procesodos
                $sql3='UPDATE procesodos
                       SET foliogeo=?
                       WHERE folio=(select id from registros where fup=? and activo is true and cancelado=0 );';
                $query3=$this->db->prepare($sql3);
                if( $query3->execute([ $folio_geo, $fup ]) ){

                    ////insertamos en tabla procesotres el valor de la superficieresultante
                    $sql = "INSERT INTO procesotres(id, fol, superficieresultante)
                        VALUES ( (select id from registros where fup=? ), (select id from registros where fup=? ), ? );"; 
                    $query=$this->db->prepare($sql);
                    if( $query->execute([ $fup, $fup, $superficie_resultante ]) ){
                        
                        ///////actualizampos el campo regreso_equipo de la tabla registros
                        //////////  tambien se actualiza el campor proceso en registros, pero a cual????
                        $sql4='UPDATE registros SET  entrega_equipo=true WHERE fup=? and cancelado=0 and activo is true; ';
                        $query4=$this->db->prepare($sql4);
                        if( $query4->execute([ $fup ]) ){
                            return true;
                        }else{
                            return false;
                        }

                    }else{
                        return false;
                    }   

                }else{
                    return false;
                }
            }else{
                return false;
            }        

        }

        public function guardar_archivo_crudo(){
            $fup=$_REQUEST['fup'];
            $nombre_archivo=$_FILES['archivo_crudo']['name'];///nombre de archivo con extension
            
            $file = pathinfo($nombre_archivo);
            $filename=$file['filename'];//nombre sin extensión

            $dir=self::checkDir_archivo_crudo($fup);
            $temp=$_FILES['archivo_crudo']['tmp_name'];
            //$url=$dir.'/'.$nombre_archivo;

            //quita los acentos del nombre de las imagenes
            $filename = str_replace(array('Á','É','Í','Ó','Ú','Ñ'),array('','','','','',''), $filename);
            $filename = str_replace(array('á','é','í','ó','ú','ñ'),array('','','','','',''), $filename);
            $url=$dir.'/'.$filename.'.'.$file['extension'];
            //

            //*******validar si ya existe, renombrar el archivo*****//
            if(file_exists($url)){
                //renombrar
                $caracteres = '0123456789';
                for ($i=0; $i<4; $i++) {
                    $filename .= $caracteres[rand(0, strlen($caracteres) - 1)];
                }
                $url=$dir.'/'.$filename.'.'.$file['extension'];
            }

            if(move_uploaded_file($temp, $url)){
                /////aqui se guarda en la base de datos, en caso de que la imagen se guarde correctamente
                $sql_files='INSERT INTO geo_lt_acrudos(fup, url_archivo, fecha) VALUES (?, ?, ?);';
                $query_files=$this->db->prepare($sql_files);
                if( $query_files->execute([ $fup, $url, date('d/m/Y h:i:sA') ])  ){
                    return true;
                }else{
                    return false;                    
                }
                //return $filename.'.'.$file['extension'];

            }else{
                return false;
                //return 'Error';
            }
        }



        public function listadoMunicipios_er(){
            $sql='select num, municipio from municipios where delegacion=? order by municipio asc;';
            $query=$this->db->prepare($sql);
            $query->execute([$_SESSION['usuario'] ] );
            return $query->fetchAll(PDO::FETCH_OBJ);
        }

        // public function checkDir_archivo_crudo($fup){/////////////////LOCAL
        //     $xyz=true;//para saber si el directorio es correcto
        //     if(!file_exists('C:/xampp/htdocs/levantamientoTopografico/lt2/files')){//verifica la carpeta raíz    
        //         //echo 'La carpeta no existe y se procederá a crearla';
        //         if(!mkdir('C:/xampp/htdocs/levantamientoTopografico/lt2/files')){//echo '<br>El directorio ha sido creado';
        //             $xyz=false;
        //         }
        //     }
        //     $anio= date('Y');
        //     if(!file_exists('C:/xampp/htdocs/levantamientoTopografico/lt2/files/'.$anio)){//verifica la carpeta del usuario
        //         if(!mkdir('C:/xampp/htdocs/levantamientoTopografico/lt2/files/'.$anio)){
        //             $xyz=false;
        //         }
        //     }
        //     if(!file_exists('C:/xampp/htdocs/levantamientoTopografico/lt2/files/'.$anio.'/'.$fup)){//verifica la carpeta del mes
            
        //         if(!mkdir('C:/xampp/htdocs/levantamientoTopografico/lt2/files/'.$anio.'/'.$fup ) ){
        //             $xyz=false;
        //         }
        //     }
        //     if($xyz){
        //         return 'C:/xampp/htdocs/levantamientoTopografico/lt2/files/'.$anio.'/'.$fup;
        //     }else{
        //         return 'Error';
        //     }
        // }

        public function checkDir_archivo_crudo($fup){ ///////////////PARA SERVIDOR
            $xyz=true;//para saber si el directorio es correcto
            if(!file_exists('C:/xampp/htdocs/levantamientoTopografico/theme/lt/files')){//verifica la carpeta raíz    
                //echo 'La carpeta no existe y se procederá a crearla';
                if(!mkdir('C:/xampp/htdocs/levantamientoTopografico/theme/lt/files')){//echo '<br>El directorio ha sido creado';
                    $xyz=false;
                }
            }
            $anio= date('Y'); 
            if(!file_exists('C:/xampp/htdocs/levantamientoTopografico/theme/lt/files/'.$anio)){//verifica la carpeta del usuario
                if(!mkdir('C:/xampp/htdocs/levantamientoTopografico/theme/lt/files/'.$anio)){
                    $xyz=false;
                }
            }
            if(!file_exists('C:/xampp/htdocs/levantamientoTopografico/theme/lt/files/'.$anio.'/'.$fup)){//verifica la carpeta del mes
            
                if(!mkdir('C:/xampp/htdocs/levantamientoTopografico/theme/lt/files/'.$anio.'/'.$fup ) ){
                    $xyz=false;
                }
            }
            if($xyz){
                return 'C:/xampp/htdocs/levantamientoTopografico/theme/lt/files/'.$anio.'/'.$fup;
            }else{
                return 'Error';
            }
        }


        public function get_geo_lt(){
                
            $sql='select a.* , b.*, c.*, d.*,e.nombre, e.apep, e.apem
                from registros as a 
                join geo_lt as b on a.fup=b.fup
                join procesodos as c on a.id=c.folio
                join estaciones as d on d.inventario=b.inventario
                join especialistas as e on e.id= CAST(b.especialista as INTEGER)
                where a.iddelegacion=1 
                and (a.salida_equipo  is true or a.entrega_equipo is true) 
                and a.activo is true and a.cancelado=0 order by fecha_recepcion desc';

            $deleg=$_SESSION['delegacion'];
            if($deleg!=0){
                $sql='select a.* , b.*, c.*, d.*,e.nombre, e.apep, e.apem
                    from registros as a 
                    join geo_lt as b on a.fup=b.fup
                    join procesodos as c on a.id=c.folio
                    join estaciones as d on d.inventario=b.inventario
                    join especialistas as e on e.id= CAST(b.especialista as INTEGER)
                    where a.iddelegacion='.$deleg.'  
                    and (a.salida_equipo  is true or a.entrega_equipo is true) 
                    and a.activo is true and a.cancelado=0 order by fecha_recepcion desc';
            }
            $query=$this->db->prepare($sql);
            $query->execute();
            return $query->fetchAll(PDO::FETCH_OBJ);
        }

        public function get_periodos(){
            $sql='select * from periodos order by num_periodo desc; ';
            $query=$this->db->prepare($sql);
            if( $query->execute() ){
                return $query->fetchAll(PDO::FETCH_OBJ);
            }else{
                return false;
            }
        }

        public function get_fechas_periodo($periodo){
            $sql='select fecha_min, fecha_max from periodos where num_periodo=? ;';
            $query=$this->db->prepare($sql);
            $query->execute([ $periodo ]);
            return $query->fetch(PDO::FETCH_OBJ);            
        }

        public function get_geo_lt_periodo($periodo){
            $fechas=self::get_fechas_periodo( $periodo );
            $fecha_min=$fechas->fecha_min; $fecha_max=$fechas->fecha_max;
            
            // switch($periodo){
            //     case '1':
            //         //$fecha_min='-';
            //         $fecha_min='2022-01-01';
            //         $fecha_max='2024-03-18';
            //         break;
            //     case '2':
            //         $fecha_min='2024-03-19';
            //         $fecha_max='2025-03-25';
            //         break;
            //     case '3':
            //         $fecha_min='2025-03-26';
            //         //$fecha_max='-';
            //         $fecha_max='2027-01-01';
            //         break;
            // }

            $sql="select a.* , b.*, c.*, d.*,e.nombre, e.apep, e.apem
                from registros as a 
                join geo_lt as b on a.fup=b.fup
                join procesodos as c on a.id=c.folio
                join estaciones as d on d.inventario=b.inventario
                join especialistas as e on e.id= CAST(b.especialista as INTEGER)
                where a.iddelegacion=1 
                and fecha_recepcion>='".$fecha_min."' and fecha_recepcion<='".$fecha_max."' 
                and (a.salida_equipo  is true or a.entrega_equipo is true) 
                and a.activo is true and a.cancelado=0 order by fecha_recepcion desc";

            $deleg=$_SESSION['delegacion'];
            if($deleg!=0){
                $sql="select a.* , b.*, c.*, d.*,e.nombre, e.apep, e.apem
                    from registros as a 
                    join geo_lt as b on a.fup=b.fup
                    join procesodos as c on a.id=c.folio
                    join estaciones as d on d.inventario=b.inventario
                    join especialistas as e on e.id= CAST(b.especialista as INTEGER)
                    where a.iddelegacion=".$deleg." 
                    and fecha_recepcion>='".$fecha_min."' and fecha_recepcion<='".$fecha_max."'  
                    and (a.salida_equipo  is true or a.entrega_equipo is true) 
                    and a.activo is true and a.cancelado=0 order by fecha_recepcion desc";
            }

            $query=$this->db->prepare($sql);
            $query->execute();
            return $query->fetchAll(PDO::FETCH_OBJ);
        }

        public function get_archivos_crudos($fup){
            $sql='select b.* 
                from geo_lt as a
                join geo_lt_acrudos as b on a.fup=b.fup
                where a.archivo_crudo is true and a.fup=? ;';
            $query=$this->db->prepare($sql);
            $query->execute([$fup]);
            return $query->fetchAll(PDO::FETCH_OBJ);
        }

 
    }
