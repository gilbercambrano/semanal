<?php
	include_once("Database.php");

	class SolicitudMedica{
		private $id ;
		private $empleado ;
		private $consecutivo ;

		private $conexion ;
		private $tabla ;

		function __construct(){
			$ob = new Database();
			$this->conexion = $ob->getConexion();
			$this->tabla = "solicitudes_medicas";
		}

		function insert($solicitud){
			$sql = "insert into $this->tabla values(
				0, 
				".$solicitud['id_empleado'].",
				".$solicitud['consecutivo']."
				)";
			
			mysql_query($sql, $this->conexion) ;
		
		}

		function getNextConsecutivo(){
			$sql = "select max(consecutivo) from $this->tabla" ;
			$resultado = mysql_query($sql, $this->conexion) ;
			if(mysql_num_rows($resultado)>0){
				$res = mysql_fetch_array($resultado) ;
				return $res[0] + 1 ;
			}
			else{
				return 0 ;
			}
		}


	}
?>