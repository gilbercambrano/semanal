<?php
	include_once("Database.php")
	class ContratoActivoSector{

		private $id			;
		private $contrato 	;
		private $activo_sector ;

		private $tabla ;
		private $conexion ;

		function __construct(){
			$ob = new Database();
			$this->conexion = $ob->getConexion();
			$this->tabla = "contratos_activos_sectores";
		}

		function insert($contrato, $activo_sector){

		}

		function update(){

		}

		function loadAll(){

		}

		function getId(){
			return $this->id ;
		}

		function getContrato(){
			return $this->contrato ;
		}

		function getActivoSSector(){
			return $this->activo_sector ;
		}

	}

?>