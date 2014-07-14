<?php

	include_once("Database.php") ;

	class AreaDepartamentoEmpleado{

		private $id 		;
		private $area_departamento ;
		private $jefe 		;
		private $estatus 	;

		private $conexion ;
		private $tabla ;

		function __construct(){
			$ob = new Database();
			$this->conexion = $ob->getConexion();
			$this->tabla = "areas_departamentos_empleados";
		}

		function insert($area_departamento, $jefe){

		}

		function update(){

		}

		function loadAll(){

		}

		function getId(){
			return $this->id ;
		}

		function getAreaDepartamento(){
			return $this->area_departamento ;
		}

		function getJefe(){
			return $this->jefe ;
		}

		function getEstatus(){
			return $this->estatus ;
		}

	}

?>