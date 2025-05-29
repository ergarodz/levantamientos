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

        }
    }

    class Ops2{
        
        private $db;
        
        public function __construct() {
            require_once 'bd/db.php';
            $this->db= Conectar::conexion();
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

        public function get_regs_procesodos($id){
            $sql='select * from procesodos where folio=? ;';
            $query=$this->db->prepare($sql);
            $query->execute([$id]);
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
                where a.proceso=3 and a.activo is true and salida_equipo is true and entrega_equipo is false order by fecha_recepcion desc;';

            $deleg=$_SESSION['delegacion'];
            if($deleg!=0){
                $sql='select a.*,b.areaproduc from registros as a join procesodos as b on a.id=b.folio 
                where a.proceso=3 and a.activo is true and salida_equipo is true and entrega_equipo is false and iddelegacion='.$deleg.' order by fecha_recepcion desc;'; 
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

        public function get_equipos($id_del){
            $sql='select * from estaciones where id_del=? and activo is true order by id asc;';
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

        public function checkDir_archivo_crudo($fup){/////////////////LOCAL
            $xyz=true;//para saber si el directorio es correcto
            if(!file_exists('C:/xampp/htdocs/levantamientoTopografico/theme2/files')){//verifica la carpeta raíz    
                //echo 'La carpeta no existe y se procederá a crearla';
                if(!mkdir('C:/xampp/htdocs/levantamientoTopografico/theme2/files')){//echo '<br>El directorio ha sido creado';
                    $xyz=false;
                }
            }
            $anio= date('Y');
            if(!file_exists('C:/xampp/htdocs/levantamientoTopografico/theme2/files/'.$anio)){//verifica la carpeta del usuario
                if(!mkdir('C:/xampp/htdocs/levantamientoTopografico/theme2/files/'.$anio)){
                    $xyz=false;
                }
            }
            if(!file_exists('C:/xampp/htdocs/levantamientoTopografico/theme2/files/'.$anio.'/'.$fup)){//verifica la carpeta del mes
            
                if(!mkdir('C:/xampp/htdocs/levantamientoTopografico/theme2/files/'.$anio.'/'.$fup ) ){
                    $xyz=false;
                }
            }
            if($xyz){
                return 'C:/xampp/htdocs/levantamientoTopografico/theme2/files/'.$anio.'/'.$fup;
            }else{
                return 'Error';
            }
        }

        // public function checkDir_archivo_crudo($fup){ ///////////////PARA SERVIDOR
        //     $xyz=true;//para saber si el directorio es correcto
        //     if(!file_exists('C:/xampp/htdocs/levantamientoTopografico/theme/lt/files')){//verifica la carpeta raíz    
        //         //echo 'La carpeta no existe y se procederá a crearla';
        //         if(!mkdir('C:/xampp/htdocs/levantamientoTopografico/theme/lt/files')){//echo '<br>El directorio ha sido creado';
        //             $xyz=false;
        //         }
        //     }
        //     $anio= date('Y'); 
        //     if(!file_exists('C:/xampp/htdocs/levantamientoTopografico/theme/lt/files/'.$anio)){//verifica la carpeta del usuario
        //         if(!mkdir('C:/xampp/htdocs/levantamientoTopografico/theme/lt/files/'.$anio)){
        //             $xyz=false;
        //         }
        //     }
        //     if(!file_exists('C:/xampp/htdocs/levantamientoTopografico/theme/lt/files/'.$anio.'/'.$fup)){//verifica la carpeta del mes
            
        //         if(!mkdir('C:/xampp/htdocs/levantamientoTopografico/theme/lt/files/'.$anio.'/'.$fup ) ){
        //             $xyz=false;
        //         }
        //     }
        //     if($xyz){
        //         return 'C:/xampp/htdocs/levantamientoTopografico/theme/lt/files/'.$anio.'/'.$fup;
        //     }else{
        //         return 'Error';
        //     }
        // }


        public function get_geo_lt(){
            // $sql='select a.* , b.*, c.*
            //     from registros as a 
            //     join geo_lt as b on a.fup=b.fup
            //     join procesodos as c on a.id=c.folio
            //     where (a.salida_equipo  is true or a.entrega_equipo is true) and a.activo is true and a.cancelado=0 order by fecha_recepcion desc ;' ;
            // $sql=' select a.* , b.*, c.*, d.*
            //     from registros as a 
            //     join geo_lt as b on a.fup=b.fup
            //     join procesodos as c on a.id=c.folio
            //     join estaciones as d on b.inventario=d.inventario
            //     where (a.salida_equipo  is true or a.entrega_equipo is true) and a.activo is true and a.cancelado=0 order by fecha_recepcion desc';
                
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
                // $sql='select a.* , b.*, c.*
                //     from registros as a 
                //     join geo_lt as b on a.fup=b.fup
                //     join procesodos as c on a.id=c.folio
                //     where a.iddelegacion='.$deleg.' and (a.salida_equipo  is true or a.entrega_equipo is true) and a.activo is true and a.cancelado=0 order by fecha_recepcion desc ;';
                $sql='select a.* , b.*, c.*, d.*
                    from registros as a 
                    join geo_lt as b on a.fup=b.fup
                    join procesodos as c on a.id=c.folio
                    join estaciones as d on d.inventario=b.inventario
                    where a.iddelegacion=1 and (a.salida_equipo  is true or a.entrega_equipo is true) and a.activo is true and a.cancelado=0 order by fecha_recepcion desc';
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
