<?php
	
	include_once("Database.php");

	class Prestamo{

		private $id 		;
		private $monto 		;
		private $fecha_inicio ;
		private $fecha_fin	;
		private $periodo_pago ;
		private $monto_pago ;
		private $estatus	;
		private $empleado	;

		private $conexion ;
		private $tabla ;

		function __construct(){
			$ob = new Database();
			$this->conexion = $ob->getConexion();
			$this->tabla = "prestamos";
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

		function getFechaInicio(){
			return $this->fecha_inicio ;
		}

		function getFechaFin(){
			return $this->fecha_fin ;
		}

		function getPeriodoPago(){
			return $this->periodo_pago ;
		}

		function getMontoPago(){
			return $this->monto_pago ;
		}

		function getEstatus(){
			return $this->estatus ;
		}

		function getEmpleado(){
			return $this->empleado ;
		}

	}

?>