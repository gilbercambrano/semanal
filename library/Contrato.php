<?php
	include_once("Database.php");

	class Contrato{

		private $id 				;
		private $numero_contrato	;
		private $descripcion		;
		private $fecha_inicio		;
		private $fecha_fin			;
		private $estatus 			;
		private $coordinador		;


		private $tabla ;
		private $conexion ;

		function __construct(){
			$ob = new Database();
			$this->conexion = $ob->getConexion();
			$this->tabla = "contratos";
		}

		function insert($coordinador){

		}

		function update(){

		}

		function loadAll(){

		}

		function getId(){
			return $this->id ;
		}

		function getNumeroContrato(){
			return $this->numero_contrato ;
		}

		function getDescripcion(){
			return $this->descripcion ;
		}

		function getFechaInicio(){
			return $this->fecha_inicio ;
		}


		function getFechaFin(){
			return $this->fecha_fin ;
		}

		function getEstatus(){
			return $this->estatus ;
		}

		function getCoordinador(){
			return $this->coordinador ;
		}

	}

?>