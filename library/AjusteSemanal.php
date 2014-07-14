<?php

	include_once('Database.php');

	class AjusteSemanal{

		private $id ;
		private $descripcion ;
		private $usuario ;
		private $monto ;
		private $nomina_general_semanal ;
		private $empleado ;

		private $tabla ;
		private $conexion ;

		function __construct(){
			$database = new Database();
			$this->tabla = 'ajustes_semanales' ;
			$this->conexion = $database->getConexion(); 
		}

		function insert($ajuste_semanal){
			$sql = "insert into $this->tabla values(
				0, 
				'".$ajuste_semanal['descripcion']."',
				".$ajuste_semanal['id_usuario'].",
				".$ajuste_semanal['monto'].",
				".$ajuste_semanal['id_nomina_general_semanal'].",
				".$ajuste_semanal['id_empleado']."
				)";
	
			return mysql_query($sql, $this->conexion);
		}

		function update(){

		}

		function getId(){
			return $this->id ;
		}

		function getDescripcion(){
			return $this->descripcion ;
		}

		function getUsuario(){
			return $this->usuario ;
		}

		function getMonto(){
			return $this->monto ;
		}

		function getNominaGeneralSemanal(){
			return $this->nomina_general_semanal ;
		}

		function getEmpleado(){
			return $this->empleado ;
		}

	}

?>