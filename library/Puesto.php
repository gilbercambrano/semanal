<?php

	include_once("Database.php") ;

	class Puesto{

		private $id 		;
		private $nombre		;
		private $descripcion ;
		private $salario 	;
		private $area_departamento ;

		private $conexion ;
		private $tabla ;

		function __construct(){
			$ob = new Database();
			$this->conexion = $ob->getConexion();
			$this->tabla = "puestos";
		}

		function insert($area_departamento){

		}

		function update(){

		}

		function loadById($puesto){
			$sql = "select * from $this->tabla where id_puesto=$puesto" ;
			$resultado = mysql_query($sql, $this->conexion) ;
			if(mysql_num_rows($resultado) > 0){
				$row = mysql_fetch_assoc($resultado) ;
				$this->id = $row['id_puesto'] ;
				$this->nombre= $row['nombre'] ;
				$this->descripcion = $row['descripcion'] ;
				$this->salario = $row['salario'] ;
			}
		}

		function loadAll(){
			$sql = "select * from $this->tabla ";
			$resultado = mysql_query($sql, $this->conexion);
			$puestos = array ();
			if(mysql_num_rows($resultado) > 0){
				while($row = mysql_fetch_assoc($resultado)){
					$puestos[] = $row ;
				}
			}
			return $puestos ;
		}

		function getId(){
			return $this->id ;
		}

		function getNombre(){
			return $this->nombre ;
		}

		function getDescripcion(){
			return $this->descripcion ;
		}

		function getSalario(){
			return $this->salario ;
		}

		function getAreaDepartamento(){
			return $this->area_departamento ;
		}

	}

?>