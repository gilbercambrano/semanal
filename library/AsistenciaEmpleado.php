<?php

	include_once("Database") ;

	class AsistenciaEmpleado{

		private $id 			;
		private $fecha			;
		private $asistencia 	;
		private $observacion 	;
		private $estatus		;
		private $hora_entrada	;
		private $nomina_quincenal_empleado ;
		private $empleado 		;

		private $tabla 			;

		private $conexion 		;

		function __construct(){
			$ob = new Database();
			$this->conexion = $ob->getConexion();
			$this->tabla = "asistencias_empleados";
		}

		function insert($nomina_quincenal_empleado, $empleado){

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

		function getAsistencia(){
			return $this->asistencia;
		}

		function getObservacion(){
			return $this->observacion ;
		}

		function getEstatus(){
			return $this->estatus ;
		}

		function getHoraEntrada(){
			return $this->hora_entrada ;
		}

		function getNominaQuincenalEmpleado(){
			return $this->nomina_quincenal_empleado ;
		}

		function getEmpleado(){
			return $this->empleado;
		}

	}

?>