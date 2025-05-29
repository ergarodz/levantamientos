<?php 
//require_once 'conexion.php';
date_default_timezone_set('America/Mexico_City');

class CorreoModel {
	private $db;
        
    public function __construct() {
        require_once './bd/db.php';
        $this->db= Conectar::conexion();
    }
	

	//////se guarda la información del correo
	public function guardar_datos_correo(){
		//$fecha = date("Y-m-d H:i:s");
		$correo_destino=$_REQUEST['correo_destino'];
		$fecha_enviado=date("Y-m-d H:i:s");
		$usuario_envio=$_REQUEST['usuario_envio'];
		$asunto=$_REQUEST['asunto'];
		$fup=$_REQUEST['fup'];
		$tipo=$_REQUEST['tipo'];

		$sql='INSERT INTO correos(correo_destino, fecha_enviado, usuario_envio, asunto, fup, tipo) VALUES (?, ?, ?, ?, ?, ?);';
		$query=$this->db->prepare($sql);
		if( $query->execute([ $correo_destino, $fecha_enviado, $usuario_envio, $asunto, $fup, $tipo ])  ){
			return true;
		}else{
			return false;
		}
	}
	
}