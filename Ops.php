<?php
if (session_status() == PHP_SESSION_NONE) {
session_start();
}
    date_default_timezone_set('America/Mexico_City');
    setlocale(LC_TIME, 'spanish');
    
    $op=new Op();
    
    if(isset($_REQUEST['action'])){
        
        switch ($_REQUEST['action']) { 
        
            case 'lista':
                $id=$_REQUEST['id'];

                $res=$op->listaUser();  
                echo json_encode($id);                     
            break; 

            case 'lista2':
                $id=$_REQUEST['id'];

                $res=$op->lista2($id);  
                echo json_encode();                     
            break; 
            case 'obtenerDiaDeEntrega':
                $id=$_REQUEST['id'];
                $res=$op->obtenerDiaDeEntrega($id);  
                echo $res;                     
            break; 
            case 'obtenerDiasDeProceso':
                $fechaRegistro=$_REQUEST['fechaRegistro'];
                $fechaFinal=$_REQUEST['fechaFinal'];
                $diasInabiles=$_REQUEST['diasInabiles'];
                $fechasNoLab=$_REQUEST['fechasNoLab'];
                $res=$op->obtenerDiasDeProceso($fechaRegistro,$fechaFinal,$diasInabiles,$fechasNoLab);  
                echo $res;                     
            break; 
        }

    }
    class Op{
        
        private $db;
        
        public function __construct() {
            require_once 'bd/db.php';
            $this->db= Conectar::conexion();
            //$this->db=  new PDO("pgsql:host='localhost' dbname=agenda port=5432 user=postgres password=erick");
            //$this->db=  new PDO("pgsql:host='localhost' dbname=agenda port=5432 user=postgres password=ig3c3m");
        }

        public function lista($id){  

            $sql='SELECT * FROM registros where iddelegacion=? and activo is true and cancelado=0 order by fecha_recepcion desc;;';
            $query=$this->db->prepare($sql); 
            $query->execute([$id]);
            //  $res=$query->fetch(PDO::FETCH_OBJ);
            $res=$query->fetchAll(PDO::FETCH_OBJ);
            return $res;
        }

        public function lista2($id){  
            $sql='SELECT * FROM registros where activo is true and cancelado=0 ';
            $query=$this->db->prepare($sql); 
            $query->execute();
          //  $res=$query->fetch(PDO::FETCH_OBJ);
            $res=$query->fetchAll(PDO::FETCH_OBJ);
            return $res;
        }  

        public function get_registros_admin($anio, $id_deleg){
            switch ($id_deleg) {
                case '0':
                    $sql='select * from registros 
                            where activo is true  
                            and extract(year from fecha_recepcion)=? 
                            order by fecha_recepcion desc';
                    $query=$this->db->prepare($sql);
                    $query->execute([ $anio ]);
                    break;
                
                default:
                    $sql='select * from registros 
                            where activo is true and iddelegacion=? 
                            and extract(year from fecha_recepcion)=? 
                            order by fecha_recepcion desc';
                    $query=$this->db->prepare($sql);
                    $query->execute([ $id_deleg, $anio ]);
                    break;
            }
                    
                    
            return $query->fetchAll(PDO::FETCH_OBJ);
        }

        public function get_anios_recepcion(){
            $sql='select distinct extract(year from fecha_recepcion) as anio from registros
                where activo is true
                order by anio desc';
            $query=$this->db->prepare($sql);
            $query->execute();
            return $query->fetchAll(PDO::FETCH_OBJ);
        }

        public function get_delegaciones(){
            $sql='select * from delegaciones order by nom_del asc';
            $query=$this->db->prepare($sql);
            $query->execute();
            return $query->fetchAll(PDO::FETCH_OBJ);
        }

        public function obtenerDiaDeEntrega($id){  

            $sql='SELECT fechaentregasol FROM procesotres where fol=?;';
            $query=$this->db->prepare($sql); 
            $query->execute([$id]);
            $res=$query->fetch(PDO::FETCH_OBJ);   
            return $res;
        } 
        
        public function obtenerDiasDeProceso($fechaRegistro,$fechaFinal,$diasInabiles,$fechasNoLab){
            date_default_timezone_set('America/Mexico_City');   
            ////return date("Y-m-d", strtotime($fechasNoLab[0]) );
            //////aqui modificaste erick---------------------------------------------------------------------------------------
            $fecha_inicio=strtotime($fechaRegistro);
            $fecha_final=strtotime($fechaFinal);
            $fecha_resultado=$fecha_final - $fecha_inicio;
            $fecha_resultado=$fecha_resultado/86400;

            //return $fecha_final;
            //return date("Y-m-d", $fecha_resultado);
            //return date($fecha_resultado,86400);
            //return $fecha_resultado/86400;

            $contador=0;////contador tiene los días inhabiles encontrados entre la fecha de inicio y la fecha de entrega y se van a restar
            for($i=$fecha_inicio; $i<=$fecha_final; $i+=86400 ){ ////86400 es un día en segundos, es decir se recorre un día completo
                ////en este for se avanza los días de uno en uno a partir de la fecha de inicio
                //echo date("d-m-Y",$i);

                for($j=0; $j<$diasInabiles; $j++ ){
                    ////en este for se recorre el vector de dias inhabiles
                    //echo $i.'-'.strtotime($fechasNoLab[$j]).'<br>';

                    if($i== strtotime($fechasNoLab[$j]) ){
                        //echo 'IGUAL<br><br>';
                        $contador++;
                    }
                }
            }

            return floor($fecha_resultado-$contador+1);

            
            //$fechaRegistro = date('Y-m-d', strtotime($fechaRegistro."+ 1 days")) ; 
        }

        // public function obtenerDiasDeProceso($fechaRegistro,$fechaFinal,$diasInabiles,$fechasNoLab){
        //     date_default_timezone_set('America/Mexico_City');       

        //     $segundosFechaActual = strtotime($fechaRegistro);
        //     $segundosFechaRegistro = strtotime($fechaFinal);
        //     $segundosTranscurridos = $segundosFechaRegistro - $segundosFechaActual;
        //     //$segundosTranscurridos;

        //     $diasExistentes = $segundosTranscurridos / 86400;///86400 segundos son 1 dia
          
        //     $diasExistentes2 = floor($diasExistentes);  

        //     $fechaRegistro = date('Y-m-d', strtotime($fechaRegistro));

        //     $contador = 0;
        //     $dias = 1; 

        //     for ($i=0; $i <= $diasExistentes; $i++) { 
        //         //  echo "Fecha inicial: ".$fechaRegistro."<br>"; 

        //         for ($f=0; $f < $diasInabiles; $f++) {    
        //             if($fechaRegistro == $fechasNoLab[$f]){

        //             $contador= 1 + $contador;

        //             }else{
        //                // echo "fecha no esta dentro del arrreglo <br>";
        //             } 

        //         }
        //         $fechaRegistro = date('Y-m-d', strtotime($fechaRegistro."+ ".$dias." days")) ; 

        //     }
        //     $TotalDeDias = $diasExistentes2 - $contador;

        //     return $TotalDeDias;
        // }
 
    }
?>    