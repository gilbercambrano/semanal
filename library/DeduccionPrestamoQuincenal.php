<?php

	include_once("Database.php");

	class DeduccionPrestamoQuincenal{

		private $id 			;
		private $monto			;
		private $fecha_pago		;
		private $estatus		;
		private $acumulado 		;
		private $restante 		;
		private $prestamo 		;
		private $nomina_quincenal_empleado ;

		private $conexion ;
		private $tabla ;

		function __construct(){
			$ob = new Database();
			$this->conexion = $ob->getConexion();
			$this->tabla = "deducciones_prestamos_quincenales";
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

		function getMonto(){
			return $this->monto ;
		}

		function getFechaPago(){
			return $this->fecha_pago ;
		}

		function getEstatus(){
			return $this->estatus ;
		}

		function getAcumulado(){
			return $this->acumulado ;
		}

		function getRestante(){
			return $this->restante ;
		}

		function getPrestamo(){
			return $this->prestamo ;
		}

		function getNominaQuincenalEmpleado(){
			return $this->nomina_quincenal_empleado ;
		}
	}

?>