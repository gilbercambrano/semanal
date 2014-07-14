<?php
	
	include_once("Database.php");

	class ActivoSectorCoordinador{

		private $id 			;
		private $activo_sector 	;
		private $coordinador 	;

		private $tabla 			;

		private $conexion ;

		function __construct(){
			$ob = new Database();
			$this->conexion = $ob->getConexion();
			$this->tabla = "activo_sector_coordinador"
		}

		function insert($activo_sector_coordinador){
			$sql = "insert into $this->tabla values(
				0,
				".$activo_sector_coordinador['id_activo_sector'].",
				".$activo_sector_coordinador['coordinador']."
				)";
			return mysql_query($sql, $this->conexion);
		}

		function update(){

		}

		function loadAll(){

		}

		function getId(){
			return $this->id ;
		}

		function getActivoSector(){
			return $this->activo_sector ;
		}

		function getCoordinador(){
			return $this->coordinador ;
		}

	}

?>