<?php 

    class Conectar extends PDO{
        
        public static function conexion(){
           $conexion= new PDO('mysql:host=localhost;dbname=buzon;charset=UTF8', 'root', '');
           //$conexion= new PDO('mysql:host=10.10.68.31;dbname=buzon;charset=UTF8', 'root', 'yzR3qruwNnDFglDX');
           return $conexion;
       }
    }