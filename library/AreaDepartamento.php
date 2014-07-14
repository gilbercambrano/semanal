<?php

	include_once("Database.php");

	class AreaDepartamento{

		private $id 		;
		private $nombre 	;
		private $descripcion ;

		private $conexion ;
		private $tabla ;

		function __construct(){
			$ob = new Database();
			$this->conexion = $ob->getConexion();
			$this->tabla = "areas_departamentos";
		}

		function insert(){

		}

		function update(){

		}

		function loadAll(){
			$sql = "select * from $this->tabla ";
			$resultado = mysql_query($sql, $this->conexion);
			$areas = array ();
			if(mysql_num_rows($resultado) > 0){
				while($row = mysql_fetch_assoc($resultado)){
					$areas[] = $row ;
				}
			}
			return $areas ;
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

	}

?>