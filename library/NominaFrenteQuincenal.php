<?php
		
	include_once ("Database.php");

	class NominaFrenteQuincenal{

		private $id 			;
		private $monto			;
		private $observaciones	;
		private $frente_trabajo	;
		private $estatus		;
		private $nomina_general_quincenal ;

		private $conexion ;
		private $tabla ;

		function __construct(){
			$ob = new Database();
			$this->conexion = $ob->getConexion();
			$this->tabla = "nominas_frentes_quincenales";
		}

		function insert($frente_trabajo, $nomina_general_quincenal){

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

		function getObservaciones(){
			return $this->observaciones ;
		}

		function getFrenteTrabajo(){
			return $this->frente_trabajo ;
		}

		function getEstatus(){
			return $this->estatus ;
		}

		function getNominaGeneralQuincenal(){
			return $this->nomina_general_quincenal ;
		}


	}


?>