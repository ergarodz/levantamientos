<?php
   /*class Conectar extends PDO{
        
        public static function conexion(){
           $conexion= new PDO("pgsql:host='localhost' dbname=levantamientoTop port=5432 user=postgres password=Igecem2018 ");
           return $conexion;
       }
       
    }*/

	


     class Conectar extends PDO{
        
        public static function conexion(){
           //$conexion= new PDO("pgsql:host='10.10.68.31' dbname=levantamientoTop port=5432 user=postgres password=j7cr3a ");
           $conexion= new PDO("pgsql:host='localhost' dbname=lt port=5432 user=postgres password=erick options='--client_encoding=UTF8' ");
           return $conexion;
       }
       
    }
	



?>

