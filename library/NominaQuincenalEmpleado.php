<?php

	include_once("Database.php");

	class NominaQuincenalEmpleado{

		private $id 			;
		private $monto			;
		private $comentario 	;
		private $estatus		;
		private $empleado 		;
		private $nomina_frente_quincenal ;

		private $conexion ;
		private $tabla ;

		function __construct(){
			$ob = new Database();
			$this->conexion = $ob->getConexion();
			$this->tabla = "nominas_quincenales_empleados";
		}

		function insert($empleado, $nomina_frente_quincenal){

		}

		function update(){

		}

		function loadAll(){

		}

		function getId(){
			return $this->id ;
		}

		function getMonto(){
			return $this->monto ;
		}

		function getComentario(){
			return $this->comentario ;
		}

		function getEstatus(){
			return $this->estatus ;
		}

		function getEmpleado(){
			return $this->empleado ;
		}

		function getNominaFrenteQuincenal(){
			return $this->nomina_frente_quincenal ;
		}

	}

?>