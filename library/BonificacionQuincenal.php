<?php

	include_once("Database.php") ;

	class BonificacionQuincenal{

		private $id 			;
		private $fecha			;
		private $estatus		;
		private $comentario		;
		private $monto			;
		private $nomina_frente_quincenal ;
		private $empleado		;

		private $tabla 			;
		private $conexion 		;

		function __construct(){
			$ob = new Database();
			$this->conexion = $ob->getConexion();
			$this->tabla = "bonificaciones_quincenales" ;
		}

		function insert($nomina_frente_quincenal, $empleado){

		}

		function update(){

		}

		function loadAll(){

		}

		function getId(){
			return $this->id ;
		}

		function getFecha(){
			return $this->fecha ;
		}

		function getEstatus(){
			return $this->estatus ;
		}

		function getComentario(){
			return $this->comentario ;
		}

		function getMonto() {
			return $this->monto ;
		}

		function getNominaFrenteQuincenal(){
			return $this->nomina_frente_quincenal ;
		}

		function getEmpleado(){
			return $this->empleado ;
		}

	}

?>