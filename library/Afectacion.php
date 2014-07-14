<?php

	include_once("Database.php");

	class Afectacion{

		private $id ;
		private $descripcion ;
		private $nomina_general_semanal ;
		private $monto ;
		private $nombre_afectado ;
		private $apellido_paterno_afectado ;
		private $apellido_materno_afectado ;
		private $estatus ;

		private $tabla ;
		private $conexion ;

		function __construct(){
			$database = new Database();
			$this->tabla = "afectaciones" ;
			$this->conexion = $database->getConexion();
		}

		function insert($afectacion){
			$sql = "insert into $this->tabla values(
				0,
				'".$afectacion['descripcion']."',
				".$afectacion['id_nomina_general_semanal'].",
				".$afectacion['monto'].",
				'".$afectacion['nombre_afectado']."',
				'".$afectacion['apellido_paterno_afectado']."',
				'".$afectacion['apellido_materno_afectado']."',
				'".$afectacion['estatus']."'
				)";
	
			return mysql_query($sql, $this->conexion);
		}

		function update(){

		}

		function getId(){
			return $this->id ;
		}

		function getDescripcion(){
			return $this->descripcion ;
		}

		function getNominaGeneralSemanal(){
			return $this->nomina_general_semanal ;
		}

		function getMonto(){
			return $this->monto ;
		}

		function getNombreAfectado(){
			return $this->nombre_afectado;
		}

		function getApellidoPaternoAfectado(){
			return $this->apellido_paterno_afectado ;
		}

		function getApellidoMaternoAfectado(){
			return $this->apellido_materno_afectado ;
		}

		function getEstatus(){
			return $this->estatus ;
		}

	}

?>