<?php

	include_once("Database.php");

	class Beneficiario{

		private $id 		;
		private $nombre 	;
		private $apellido_paterno ;
		private $apellido_materno ;
		private $detalle_direccion ;
		private $empleado 	;

		private $conexion ;
		private $tabla ;

		function __construct(){
			$ob = new Database();
			$this->conexion = $ob->getConexion();
			$this->tabla = "beneficiarios";
		}

		function insert($empleado, $detalle_direccion){

		}

		function update(){

		}

		function loadAll(){

		}

		function getId(){
			return $this->id ;
		}

		function getNombre(){
			return $this->nombre ;
		}

		function getApellidoPaterno(){
			return $this->apellido_paterno ;
		}

		function getApellidoMaterno(){
			return $this->apellido_materno ;
		}

		function getDetalleDireccion(){
			return $this->detalle_direccion ;
		}

		function getEmpleado(){
			return $this->empleado ;
		}

	}

?>