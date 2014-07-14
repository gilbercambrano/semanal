<?php
	
	include_once ("Database.php");

	class NominaGeneralQuincenal{

		private $id 			;
		private $fecha_pago		;
		private $monto			;
		private $estatus		;
		private $fecha_inicio_periodo ;
		private $fecha_fin_periodo	;
		private $fecha_generacion ;
		private $usuario 		;
		private $observaciones	;

		private $conexion ;
		private $tabla ;

		function __construct(){
			$ob = new Database();
			$this->conexion = $ob->getConexion();
			$this->tabla = "nominas_generales_quincenales" ;
		}

		function insert($usuario){

		}

		function update(){

		}

		function loadAll(){

		}

		function getId(){
			return $this->id ;
		}

		function getFechaPago(){
			return $this->fecha_pago ;
		}

		function getMonto(){
			return $this->monto ;
		}

		function getEstatus () {
			return $this->estatus ;
		}

		function getFechaInicioPeriodo(){
			return $this->fecha_inicio_periodo ;
		}

		function getFechaFinPeriodo(){
			return $this->fecha_fin_periodo ;
		}

		function getFechaGeneracion(){
			return $this->fecha_generacion ;
		}

		function getUsuario(){
			return $this->usuario ;
		}

		function getObservaciones(){
			return $this->observaciones ;
		}

	}

?>