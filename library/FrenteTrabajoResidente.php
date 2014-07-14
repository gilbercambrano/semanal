<?php

	include_once("Database.php") ;

	class FrenteTrabajoResidente{

		private $id 			;
		private $frente_trabajo	;
		private $residente 		;

		private $conexion ;
		private $tabla ;

		function __construct(){
			$ob = new Database();
			$this->conexion = $ob->getConexion();
			$this->tabla = "frentes_trabajo_residentes";
		}

		function insert($frente_trabajo, $residente){

		}

		function update(){

		}

		function loadAll(){

		}

		function getId(){
			return $this->id ;
		}

		function getFrenteTrabajo(){
			return $this->frente_trabajo ;
		}

		function getResidente(){
			return $this->residente ;
		}

	}
	
?>