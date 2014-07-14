<?php

	include_once("Database.php") ;

	class Prestacion{

		private $id 			;
		private $descripcion	;
		private $monto 			;
		private $fecha_pago		;
		private $comentario		;
		private $estatus		;
		private $empleado 		;

		private $conexion ;
		private $tabla ;

		function __construct(){
			$ob = new Database();
			$this->conexion = $ob->getConexion();
			$this->tabla = "prestaciones";
		}

		function insert(){

		}

		function update(){

		}

		function loadAll(){

		}

		function getId($empleado){
			return $this->id ;
		}

		function getDescripcion(){
			return $this->descripcion ;
		}

		function getMonto (){
			return $this->monto ;
		}

		function getFechaPago(){
			return $this->fecha_pago ;
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

	}

?>